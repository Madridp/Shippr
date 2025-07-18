<?php 

class Auth extends Controller {

	private $hash = "SHA256";
	private $token;
	private $id;

	private $cookie_token_name = AUTH_TKN_NAME;
	private $cookie_id_name    = AUTH_ID_NAME;
	private $cookie_lifetime   = 31536000;

	private $user = null;

	function __construct()
	{
	}

	public function get_cookie_name($cookie)
	{
		switch ($cookie) {
			case 'token':
				return $this->cookie_token_name;
				break;
			case 'id':
				return $this->cookie_id_name;
				break;
			default:
				return false;
		}
	}

	/**
	* Valida si existe una sesión almacenada en cookies / y si es valida
	* @access public
	* @var $_COOKIE ID_USR $_COOKIE TKN
	* @return array | false
	**/
	public static function auth()
	{
		/** We make an instance to use class properties */
		$auth = new self();

		## If the cookies exists
		if (!self::existe_el_cookie($auth->get_cookie_name('id')) || !self::existe_el_cookie($auth->get_cookie_name('token'))) {

			self::destruir_cookie([
				$auth->get_cookie_name('id') => NULL, 
				$auth->get_cookie_name('token') => NULL
			]);

			return false;
		}

		## Obtenemos la información del usuario
		$usuario = new usuariosModel();
		//$res = $usuario->validar_usuario_y_token(self::get_cookie($auth->get_cookie_name('id')) , hash($auth->hash, self::get_cookie($auth->get_cookie_name('token'))));
		$res = usuariosModel::validate_user_session(self::get_cookie($auth->get_cookie_name('id')) , hash($auth->hash, self::get_cookie($auth->get_cookie_name('token'))));

		## Verificamos si coincide
		if (!$res) {
			## Si no coinciden, destruimos cookies
			self::destruir_cookie([
				$auth->get_cookie_name('id') => NULL, 
				$auth->get_cookie_name('token') => NULL
			]);

			## Regresamos false para redirección
			return false;
		}

		if (!$user = $usuario->cargar_informacion_usuario(self::get_cookie($auth->get_cookie_name('id')) , hash($auth->hash, self::get_cookie($auth->get_cookie_name('token'))))) {
			return false;
		}

		return true; // return $user si se presentan errores
	}

	public static function authbu()
	{
		/** We make an instance to use class properties */
		$auth = new self();

		## If the cookies exists
		if (self::existe_el_cookie($auth->get_cookie_name('id')) && self::existe_el_cookie($auth->get_cookie_name('token'))) {

			## Obtenemos la información del usuario
			$usuario = new usuariosModel();
			$token = $usuario->validar_usuario_y_token($_COOKIE[$auth->get_cookie_name('id')] , hash($auth->hash, $_COOKIE[$auth->get_cookie_name('token')]));

			## Verificamos si coincide
			if (!$token) {
				## Si no coinciden, destruimos cookies
				self::destruir_cookie([$auth->get_cookie_name('id') => $_COOKIE[$auth->get_cookie_name('id')]]);
				self::destruir_cookie([$auth->get_cookie_name('token') => $_COOKIE[$auth->get_cookie_name('token')]]);

				## Regresamos false para redirección
				return false;
			}

			if (!$usuario = $usuario->cargar_informacion_usuario($_COOKIE[$auth->get_cookie_name('id')] , hash($auth->hash, $_COOKIE[$auth->get_cookie_name('token')]))) {
				return false;
			}

			return true; // return $usuario si se presentan errores

		} else {

			## En caso de que no exista alguno de los 2, destruimos ambos
			if (self::existe_el_cookie($auth->get_cookie_name('id')) || self::existe_el_cookie($auth->get_cookie_name('token'))) {
				self::destruir_cookie([
					$auth->get_cookie_name('id') => $_COOKIE[$auth->get_cookie_name('id')], 
					$auth->get_cookie_name('token') => $_COOKIE[$auth->get_cookie_name('token')]
				]);
			}

			## Regresamos false para redirección
			return false;
		}

	}

	/**
	* Starts the session of the user
	* @access public
	* @var array
	* @return bool
	**/
	public static function iniciar_sesion($id) 
	{
		## Nueva instancia para usar las propiedades de la clase
		$auth = new self();

		## Creates a new token
		$token = self::generar_token();
		$usuario = new usuariosModel();

		## Verificamos si existen los cookies
		if (self::existe_el_cookie($auth->get_cookie_name('id')) && self::existe_el_cookie($auth->get_cookie_name('token'))) {

			## Si existen los borramos y creamos nuevos y agregamos a DB
			self::destruir_cookie([
				$auth->get_cookie_name('id') => NULL, 
				$auth->get_cookie_name('token') => NULL
			]);
			
			self::crear_cookie([
				$auth->get_cookie_name('id') => $id , 
				$auth->get_cookie_name('token') => $token
			]);

			## Update table with new token
			//$usuario->actualizar_token($id , hash($auth->hash, $token));
			$id = usuariosModel::add_user_session($id , hash($auth->hash, $token));

		} else {

			## Create cookies if they dont exist
			self::crear_cookie([
				$auth->get_cookie_name('id') => $id , 
				$auth->get_cookie_name('token') => $token
			]);

			## Update table with new token
			//$usuario->actualizar_token($id , hash($auth->hash, $token));
			$id = usuariosModel::add_user_session($id , hash($auth->hash, $token));

		}

		## All good, return true
		return ($id) ? true : false;
	}

	## Crear un token de acceso | string
	private static function generar_token($length = 64)
	{
		$token = bin2hex(openssl_random_pseudo_bytes($length));
		return $token;
	}

	## Verificar si existen los cookies | true | false
	private static function existe_el_cookie($cookie)
	{

		if (isset($_COOKIE[$cookie])) {
			return true;
		} else {
			return false;
		}

	}

	## Crear cookies | true
	private static function crear_cookie($cookies)
	{
		$auth = new self();
		foreach ($cookies as $key => $value) {
			setcookie($key , $value , time() + $auth->cookie_lifetime , "/");
		}
		return true;
	}

	## Borrar cookies | true
	private static function destruir_cookie($cookies)
	{
		foreach ($cookies as $key => $value) {
			if (isset($_COOKIE[$key])) {
				setcookie($key , $value , time() - 1000 , "/");
				return true;
			}
		}
		return false;
	}

	## Logs user out
	public static function cerrar_sesion()
	{
		/** We make an instance to use class properties */
		$auth = new self();
		unset($_SESSION);
		## Remove db token
		if(!usuariosModel::destroy_user_session(self::get_cookie($auth->get_cookie_name('id')) , hash($auth->hash,self::get_cookie($auth->get_cookie_name('token'))))){
			logger('Token no borrado: '.self::get_cookie($auth->get_cookie_name('token')));
		}

		self::destruir_cookie([
			$auth->get_cookie_name('id') => NULL, 
			$auth->get_cookie_name('token') => NULL
		]);

		## End all session variables remaining
		session_destroy();
		return true;
	}

	/**
	 * Get current user's id
	 *
	 * @return void
	 */
	public static function get_user_id()
	{
		if(!$user = self::get_user()){
			return false;
		}

		return $user->id_usuario;
	}

	public static function get_user()
	{
		/** We make an instance to use class properties */
		$auth = new self();
		
		/** Loads user inf */
		$usuario = new usuariosModel();
		if(!$user = $usuario->cargar_informacion_usuario(self::get_cookie($auth->get_cookie_name('id')) , hash($auth->hash, self::get_cookie($auth->get_cookie_name('token'))))) {
			return false;
		}

		return json_decode(json_encode($user));
	}

	/**
	 * Get user's role to use
	 *
	 * @return void
	 */
	public static function get_user_role()
	{
		if(!$user = self::get_user()){
			return false; // The session is not valid
		}

		$user = toObj($user);
		$role = $user->role;

		return $role; // We return a valid role of the current user
	}

	public static function get_cookie($cookie_name)
	{
		if(!isset($_COOKIE[$cookie_name])) {
			return false;
		}
		
		return $_COOKIE[$cookie_name];
	}
}

