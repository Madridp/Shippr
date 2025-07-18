<?php 

/**
* Clase para todos los usuarios registrados dentro de la plataforma
*/
class usuariosController extends Controller
{
	protected $modelo;
	
	function __construct()
	{
		parent::__construct();
		$this->modelo = new usuariosModel;
	}

	public function index()
	{
		$this->perfil();
	}

	/**
	* Agregar un usuario a la DB.
	* @access private
	* Solo acceso a administración para generar nuevos registros.
	*/
	public function agregar()
	{
		if (!is_user(get_user_role(), ['admin'])) {
			Flasher::save('Acceso no autorizado.', 'danger');
			Taker::to('dashboard');
		}

		$roles = new rolesModel();
		$this->data =
		[
			'title' => 'Agregar usuario',
			'roles' => $roles->all()
		];
		
		View::render('add' , $this->data);
	}

	/**
	 * Método para procesar la información del formulario
	 * @access public
	 * @param array
	 * @return bool
	 */
	public function store()
	{
		if(!isset($_POST)){
			Flasher::save('Acceso no autorizado.','danger');
			Taker::to('usuarios/agregar');
		}

		$usuario = new usuariosModel();

		if (validateName($_POST['nombre'])) {
			Flasher::save('Nombre no valido.','danger');
			Taker::to('usuarios/agregar');
		}

		if (onlyLetters($_POST['usuario'])) {
			Flasher::save('Usuario no valido.','danger');
			Taker::to('usuarios/agregar');
		}

		if ($usuario->usuario_existente($_POST['usuario'])) {
			Flasher::save('Usuario ya existente.','danger');
			Taker::to('usuarios/agregar');
		}

		if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
			Flasher::save('Email no valido.','danger');
			Taker::to('usuarios/agregar');
		}

		if ($usuario->email_existente($_POST['email'])) {
			Flasher::save('Email ya existente.','danger');
			Taker::to('usuarios/agregar');
		}

		$data =
		[
			'usuario' => trim($_POST['usuario']),
			'nombre'  => trim($_POST['nombre']),
			'email'   => trim($_POST['email']),
			'id_role' => trim($_POST['role']),
			'ip'      => ipCliente(),
			'status'  => 0,
			'token'   => 0,
			'borrado' => 0
		];

		if ($_POST["auto_password"] == "si") {
			$_POST['password'] = randomPassword();
			$data['password'] = password_hash($_POST['password'].SITESALT , PASSWORD_BCRYPT);
		} else {
			if ($_POST['password'] !== $_POST['conf_password']) {
				Flasher::save('El password no coincide.','danger');
				Taker::back();
			}
			$data['password'] = password_hash($_POST['password'].SITESALT , PASSWORD_BCRYPT);
		}

		if (!$id = usuariosModel::add('usuarios' , $data)) {
			Flasher::save('Hubo un problema.','danger');
			Taker::to('usuarios/agregar');
		}

		$usuario = usuariosModel::list('usuarios' , ['id_usuario' => $id])[0];
		$usuario['unhashed'] = $_POST['password'];
		
		// Enviar mensaje con los datos del usuario
		$email = new usuarioMailer($usuario);
		if(!$email->agregado()){
      Flasher::email_to('system' , false);
    }else{
      Flasher::email_to('system');
    }

    if(!$email->agregado('usuario')){
      Flasher::email_to('usuario' , false);
    }else{
      Flasher::email_to('usuario');
    }

		// Redireccionar a usuarios
		Flasher::added('usuario');
		Taker::to('usuarios');
	}

	/**
	*
	* Muestra información de un solo usuario
	* @access public
	*
	**/
	public function ver($id)
	{
		$this->perfil();
	}

	/**
	 * Current user's profile
	 *
	 * @return void
	 */
	public function perfil()
	{
		$usuario = new usuariosModel;
		$this->data =
		[
			'title'   => 'Mi perfil',
			'usuario' => $usuario->find(get_user_id())
		];

		View::render('perfil', $this->data);
	}

	/**
	*
	* Muestra el formulario e información del registro de la base de datos para editar
	* @access public
	* @param $_POST
	*
	*/
	public function editar_mi_perfil()
	{
		$usuario = new usuariosModel();

		if (!$user = $usuario->find(get_user_id())) {
			Flasher::save('Usuario no encontrado.', 'danger');
			Taker::back();
		}

		$this->data =
		[
			'title' => 'Editar mi perfil',
			'u'     => $user
		];

		View::render('edit',$this->data);
	}

	/**
	 * Método para procesar la información del formulario de editar
	 * @access public
	 * @param array
	 * @return bool	
	 */
	public function mi_perfil_update()
	{
		if(!check_posted_data(['csrf','id_usuario'], $_POST) || !validate_csrf($_POST['csrf'])) {
			Flasher::access();
			Taker::back();
		}

		// Instancia del modelo
		$usuario = new usuariosModel;

		// Información a insertar
		$data =
		[
			'nombre'                 => clean($_POST['nombre']),
			'bio'                    => clean($_POST['bio']),
			'redesSociales'          => json_encode($_POST['redes']),
			'empresa'                => clean($_POST['empresa']),
			'razon_social'           => clean($_POST['razon_social']),
			'rfc'                    => clean($_POST['rfc']),
			'telefono'               => clean($_POST['telefono']),
			'cp'                     => clean($_POST['cp']),
			'calle'                  => clean($_POST['calle']),
			'num_ext'                => clean($_POST['num_ext']),
			'num_int'                => clean($_POST['num_int']),
			'colonia'                => clean($_POST['colonia']),
			'ciudad'                 => clean($_POST['ciudad']),
			'estado'                 => clean($_POST['estado'])
		];

		// Imagen de perfil
		try {
			$img_perfil = multiUpload($_FILES['img_perfil'])[0];
			if($img_perfil) {
				$current_avatar = UPLOADS.get_user_data()->perfil;
				$filename       = generate_filename();
				$upload         = new Uploader($img_perfil, $filename);
				$data['perfil'] = $upload->scale(320);
				$upload->clean();

				## Borrar si existe una imagen actual
				if(is_file($current_avatar)){
					unlink($current_avatar);
				}
			}
		}catch(LumusException $e){
			Flasher::save($e->getMessage(),'danger');
			Taker::back();
		}

		// Imagen de fondo o background
		try {
			$img_bg = multiUpload($_FILES['img_background'])[0];
			if ($img_bg) {
				
				$current_bg         = UPLOADS.get_user_data()->background;
				$filename           = generate_filename();
				$upload             = new Uploader($img_bg, $filename);
				$data['background'] = $upload->scale(852);
				$upload->clean();

				// Borrar background pasado
				if(is_file($current_bg) && file_exists($current_bg)) {
					unlink($current_bg);
				}
			}

		} catch (LumusException $e){
			Flasher::save($e->getMessage(),'danger');
			Taker::back();
		}


		// Actualización de la información de la base de datos
		try {
			if(!usuariosModel::update('usuarios', ['id_usuario' => $_POST['id_usuario']], $data)){
				Flasher::updated('perfil', false);
				Taker::back();
			}
	
			// Notificación de actualizado de perfil
			Flasher::updated('perfil');
			Taker::back();

		} catch (PDOException $e) {
			Flasher::save($e->getMessage(), 'danger');
			Taker::back();
		}
	}

	/**
	*
	* Cierra y destruye la sessión del usuario actual
	* @access public
	*
	**/
	public function logout()
	{
		if (Auth::cerrar_sesion()) {
			Taker::to('login');
		}
	}

	public function recuperar_contrasena($id)
	{
		if(!is_admin(get_user_role())){
			Flasher::access();
			Taker::back();
		}

		/** If not found, throw error  */
		if(!$user = usuariosModel::list('usuarios',['id_usuario' => $id],1)[0]){
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

		## Send email notification
		$email = new usuarioMailer($user);
		if(!$email->recuperacion_password()){
			Flasher::save('Algo salió mal, intenta de nuevo.', 'danger');
			Taker::back();
		}

		Flasher::save('Hemos enviado un email de recuperación al correo electrónico del usuario.');
		Taker::back();
	}

	public function suscripcion2()
	{
		if(!is_subscribed()) {
			Flasher::save('No estás suscrito aún, mira nuestros planes disponibles.','info');
			Taker::to('suscribirse');
		}
		
		$sub = suscripcionModel::get_by_user(get_user_id());
		$transactions = transaccionModel::get_by_sub((isset($sub['id']) ? $sub['id'] : NULL));
		$this->data =
		[
			'title' => 'Mi suscripción',
			's' => $sub,
			't' => $transactions
		];
		View::render('suscripcion',$this->data);
	}

	public function renovar2()
	{
		//session_destroy();
		$sub = suscripcionModel::get_by_user(get_user_id());
		$this->data = 
		[
			'title' => 'Renovar suscripción',
			's' => $sub
		];
		View::render('renovar',$this->data);
	}

	public function recargar_saldo()
	{
		$this->data =
		[
			'title' => 'Recargar saldo',

		];

		View::render('recargar', $this->data);
	}

	public function post_recargar_saldo()
	{
		if(!check_posted_data(['amount', 'csrf'], $_POST) || !validate_csrf($_POST['csrf'])) {
			Flasher::access();
			Taker::back();
		}

		$amount  = (float) $_POST['amount'];
		$id      = null;
		$bank    = get_bank_info();
		$titular = $bank->account_name;
		$account = $bank->account_number;
		$clabe   = $bank->clabe;
		$card    = $bank->card_number;

		// Validar que este disponible la información bancaria
		if($titular === null || $account === null || $clabe === null || $card === null) {
			Flasher::save(sprintf('Lo sentimos, por el momento %s no está aceptando pagos.', get_sitename()), 'danger');
			Taker::back();
		}

		// Nueva transacción
		try {
			$trans                 = new transaccionModel;
			$trans->tipo           = 'recarga_saldo';
			$trans->detalle        = sprintf('%s solicitó recarga de saldo por %s pesos', get_user_name(), money($amount));
			$trans->referencia     = time();
			$trans->id_usuario     = get_user_id();
			$trans->tipo_ref       = 'recarga_saldo';
			$trans->status         = 'solicitado';
			$trans->status_detalle = get_payment_status($trans->status);
			$trans->metodo_pago    = 'efectivo';
			$trans->descripcion    = 'Nueva transacción';
			$trans->subtotal       = $amount / 1.16;
			$trans->impuestos      = ($amount / 1.16) * 0.16;
			$trans->total          = $amount;
	
			if(!$id = $trans->agregar()) {
				Flasher::save('Hubo un problema al solicitar tu ticket, intenta de nuevo', 'danger');
				Taker::back();
			}
	
			$trans = transaccionModel::by_id($id);
	
			$user = usuariosModel::by_id(get_user_id());
			$user['total']  = $trans['total'];
			$user['numero'] = $trans['numero'];
			$email = new usuarioMailer($user);
			$email->solicitud_saldo();
			$email->nueva_solicitud();
			Flasher::save(sprintf('El ticket <b>%s</b> ha sido enviado a tu correo electrónico, revisa tu bandeja de <b>spam</b> también', $trans['numero']));
			Taker::back();

		} catch (PDOException $e) {
			Flasher::save($e->getMessage(), 'danger');
			Taker::back();
		}
	}

	public function suspender($id)
	{
		// Validar si es un sitiodemo
		validate_demosite();

		// Validar el role del usuario
		if(!is_worker(get_user_role()) || !check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])) {
			Flasher::action();
			Taker::back();
		}

		if(!$user = usuariosModel::by_id($id)) {
			Flasher::access();
			Taker::back();
		}

		## Validates if $id_usuario user is admin or root
		if(is_admin($user['role']) || is_root($user['role'])) {
			Flasher::action();
			Taker::back();
		}

		// Validar si ya está suspendido
		if((int) $user['status'] === 1) {
			Flasher::save('El usuario ya está suspendido.', 'danger');
			Taker::back();
		}

		## Updates current user and bans it
		if(!usuariosModel::update('usuarios', ['id_usuario' => $id], ['status' => 1])) {
			Flasher::updated('usuario', false);
			Taker::back();
		}

		## Enviar notificación al usuario
		$email = new usuarioMailer($user);
		if($email->suspendido('usuario')) {
			Flasher::email_to('usuario');
		}

		if($email->suspendido()) {
			Flasher::email_to();
		}

		Flasher::save(sprintf('El usuario <b>%s</b> ha sido suspendido con éxito.', $user['nombre']));
		Taker::back();
	}

	public function revertir_suspension($id)
	{
		// Validar si es un sitiodemo
		validate_demosite();

		## Validates if its root or admin
		if(!is_worker(get_user_role()) || !check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])) {
			Flasher::access();
			Taker::back();
		}
		
		if(!$user = usuariosModel::by_id($id)) {
			Flasher::access();
			Taker::back();
		}

		if((int) $user['status'] !== 1) {
			Flasher::save('Este usuario no está suspendido','danger');
			Taker::back();
		}
		
		## Updates current user and unbans it
		if(!usuariosModel::update('usuarios', ['id_usuario' => $id], ['status' => 0])) {
			Flasher::updated('usuario',false);
			Taker::back();
		}

		Flasher::save('Usuario habilitado con éxito');
		Taker::back();
	}

	public function terminar_demostracion($id)
	{
		// Validar si es un sitiodemo
		validate_demosite();

		if (!check_get_data(['_t'], $_GET) || !is_root(get_user_role())) {
			Flasher::access();
			Taker::back();
		}

		// Cargar información del usuario actual
		$u = new usuariosModel();
		if(!$usuario = $u->find($id)){
			Flasher::not_found('usuario');
			Taker::back();
		}

		// Si no es un usuario demo
		if(!is_demouser($usuario['role'])) {
			Flasher::save(sprintf('%s no es un usuario para demostración', $usuario['nombre']), 'danger');
			Taker::back();
		}

		try {
			if(!usuariosModel::update('usuarios', ['id_usuario' => $id], ['status' => 3])) {
				Flasher::updated('usuario', false);
				Taker::back();
			}

			// Cerrar sesiones abiertas del usuario
			usuariosModel::close_all_sessions_by_user($id);

			// Notificación
			$email = new usuarioMailer($usuario);
			$email->demostracion_terminada();

			Flasher::save(sprintf('Se ha terminado la demostración para el usuario %s', $usuario['nombre']));
			Taker::back();

		} catch (PDOException $e) {
			Flasher::save($e->getMessage(), 'danger');
			Taker::back();
		}
	}

	/**
	*
	* Metodo para borrar el registro de la base de datos
	* @access public
	* @param $id del registro a borrar de la base de datos
	*
	*/
	public function borrar($id)
	{
		// Validar si es un sitiodemo
		validate_demosite();

		if(!is_admin(get_user_role()) || !check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])){
			Flasher::access();
			Taker::back();
		}

		if($id == get_user_id()){
			Flasher::save('Acción no autorizada, no puedes borrarte a ti mismo', 'danger');
			Taker::back();
		}

		if(!$usuario = usuariosModel::by_id($id)) {
			Flasher::not_found('usuario');
			Taker::back();
		}

		if(is_root($usuario['role'])){
			logger(sprintf('Intento de borrado de usuario desarrollador por %s', get_user_name()));
			Flasher::save('No está permitido borrar desarrolladores del sistema', 'danger');
			Flasher::save('Contáctanos a soporte@joystick.com.mx', 'info');
			Taker::back();
		}

		if (!usuariosModel::remove('usuarios', ['id_usuario' => $id], 1)) {
			Flasher::deleted('usuario', false);
			Taker::back();
		}

		Flasher::save('Usuario borrado con éxito');
		Taker::back();
	}
}