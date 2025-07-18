<?php 

/**
* Controlador principal para manejo de inicios de sesión
*/
class loginController extends Controller
{
	
	function __construct()
	{
		/** If there's already a session we take them to dashboard */
		if (Auth::auth()) {
			Taker::to('dashboard');
		}
	}


	/**
	* Metodo por defector para mostrar el formulario de inicio de sesión
	* @access public
	*/
	public function index()
	{
		$this->data['title'] = "Iniciar sesión";
		View::render('login' , $this->data);
	}

	public function recuperar_contrasena()
	{
		$this->data =
		[
			'title' => 'Recuperar contraseña'
		];

		View::render('recuperar',$this->data,true);
	}

	public function recuperar_contrasena_submit()
	{
		if(!isset($_POST)){
			Flasher::access();
			Taker::back();
		}

		if(empty($_POST['usuario'])){
			Flasher::save('Completa todos los campos.','danger');
			Taker::back();
		}

		/** If not found, throw error  */
		if(!$user = usuariosModel::list('usuarios',['usuario' => $_POST['usuario']],1)[0]){
			Flasher::save('Usuario no existente.','danger');
			Taker::back();
		}

		/** Generate new token */
		if(!$token = tokenModel::add_new($user['id_usuario'],strtotime('24 hours'))) {
			Flasher::save('Algo salió mal, intenta de nuevo.','danger');
			Taker::back();
		}
		
		/** add token to user array */
		$user['password_token'] = $token['token'];
		
		/** Send email */
		$email = new usuarioMailer($user);
		if(!$email->recuperacion_password()){
			Flasher::save('Algo salió mal, intenta de nuevo.', 'danger');
			Taker::back();
		}

		Flasher::save('Hemos enviado un email de recuperación a tu correo electrónico.');
		Taker::to('login');
	}

	public function actualizar_contrasena()
	{
		if(!isset($_GET['token'])){
			Flasher::access();
			Taker::back();
		}

		/** Verificar que el token sea válido aún */
		if(!$token = tokenModel::validate(['token' => $_GET['token'] , 'lifetime' => time()])) {
			Flasher::save('Este link ha caducado o no es válido, genera uno nuevo.','danger');
			Taker::back();
		}		

		/** cargar información del usuario basado en el token generado */
		$usuario = usuariosModel::list('usuarios',['id_usuario' => $token['id_ref']])[0];

		$this->data =
		[
			'title' => 'Actualizar contraseña',
			'usuario' => $usuario
		];

		/** Mostrar formulario para actualizar la contraseña */
		View::render('actualizar',$this->data , true);
	}

		public function actualizar_contrasena_submit()
	{
		if(!isset($_POST)){
			Flasher::access();
			Taker::back();
		}

		/** Si por alguna razón no se encuentra el id del usuario */
		if(empty($_POST['id_usuario'])){
			Flasher::save('Algo salió mal, intenta de nuevo.', 'danger');
			Taker::back();
		}

		/** Verificar que el token sea válido aún */
		if(!$token = tokenModel::validate(['token' => $_POST['token'] , 'lifetime' => time()])) {
			Flasher::save('Este link ha caducado o no es válido, genera uno nuevo.','danger');
			Taker::back();
		}

		/** Si es muy corta */
		if(strlen($_POST['password']) < 5){
			Flasher::save('Tu contraseña es muy corta o debil, ingresa 5 o más caracteres.', 'danger');
			Taker::back();
		}

		/** Si no coinciden las contraseñas */
		if($_POST['password'] !== $_POST['conf-password']){
			Flasher::save('Las contraseñas no coinciden.','danger');
			Taker::back();
		}

		$new_password = password_hash($_POST['password'].SITESALT,PASSWORD_BCRYPT);

		if(!usuariosModel::update('usuarios',['id_usuario' => $_POST['id_usuario']],['password' => $new_password])){
			Flasher::save('Algo salió mal, intenta de nuevo.', 'danger');
			Taker::back();
		}

		/** Deshabilitar el uso del token */
		if(!tokenModel::update('tokens',['token' => $_POST['token']],['valid' => 0])){
			Flasher::save('Algo salió mal, intenta de nuevo.', 'danger');
			Taker::back();
		}

		Flasher::save('Tu contraseña ha sido actualizada con éxito.');
		Taker::to('login');
	}
}