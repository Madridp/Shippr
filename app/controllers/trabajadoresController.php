<?php 

class trabajadoresController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!is_admin(get_user_role())){
      Flasher::access();
      Taker::back();
    }
  }
  
  ## TRABAJADORES
  function index()
  {
    $this->data =
    [
      'title' => 'Todos los trabajadores',
      'table' => trabajadorModel::draw_table()
    ];

    View::render('index', $this->data);
  }

  function agregar()
  {
    $this->data =
    [
      'title' => 'Agregar trabajador'
    ];

    View::render('add', $this->data);
  }

  function store()
  {
    if(!check_posted_data(['email','usuario','nombre','password'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    if(reached_workers_limit()) {
      Flasher::save(sprintf('Haz alcanzado el límite de trabajadores soportados en tu plan (%s de %s)', trabajadorModel::sits_used(), get_workers_limit()), 'danger');
      Taker::to('trabajadores');
    }

    if(!isset($_POST['submit'])) {
      Flasher::access();
      Taker::back();
    }

    // Validar existencia de usuario o correo
    if(trabajadorModel::list('usuarios', ['usuario' => $_POST['usuario']])) {
      Flasher::save('El nombre de usuario ya existe en la base de datos', 'danger');
      Taker::back();
    }

    if(trabajadorModel::list('usuarios', ['email' => $_POST['email']])) {
      Flasher::save('La dirección de correo electrónico ya existe en la base de datos', 'danger');
      Taker::back();
    }

    // Validar email
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      Flasher::save('La dirección de correo electrónico no es válida', 'danger');
      Taker::back();
    }

    
    $worker =
    [
      'nombre'     => clean($_POST['nombre']),
      'usuario'    => clean($_POST['usuario']),
      'email'      => clean($_POST['email']),
      'password'   => clean($_POST['password']),
      'id_role'    => 6,
      'status'     => 0,
      'ip'         => ipCliente(),
      'created_at' => ahora()
    ];

    if ($_POST["auto_password"] === "si") {
      $_POST['password']  = randomPassword();
      $worker['password'] = password_hash($_POST['password'].SITESALT , PASSWORD_BCRYPT);
    } else {
      if ($_POST['password'] !== $_POST['conf_password']) {
        Flasher::save('El password no coincide.','danger');
        Taker::back();
      }
      $worker['password'] = password_hash($_POST['password'].SITESALT , PASSWORD_BCRYPT);
    }

    if(!$id = trabajadorModel::add('usuarios', $worker)) {
      Flasher::added('Trabajador', false);
      Taker::back();
    }

    $worker = trabajadorModel::list('usuarios' , ['id_usuario' => $id])[0];
		$worker['unhashed'] = $_POST['password'];
		
		// Enviar mensaje con los datos del usuario
		$email = new usuarioMailer($worker);
		$email->agregado();
    $email->agregado('usuario');

    Flasher::added('Trabajador');
    Taker::back();
  }

  public function recuperar_contrasena($id)
	{
		if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])){
			Flasher::access();
			Taker::back();
		}

		/** If not found, throw error  */
		if(!$user = usuariosModel::list('usuarios', ['id_usuario' => $id])[0]){
			Flasher::save('El trabajador no existente en la base de datos', 'danger');
			Taker::back();
		}

		/** Generate new token */
		if(!$token = tokenModel::add_new($user['id_usuario'], strtotime('24 hours'))) {
			Flasher::error();
			Taker::back();
		}

		/** add token to user array */
		$user['password_token'] = $token['token'];

		## Send email notification
		$email = new usuarioMailer($user);
		if(!$email->recuperacion_password()){
      Flasher::error();
			Taker::back();
		}

		Flasher::save('Hemos enviado un email de recuperación al correo electrónico del trabajador');
		Taker::back();
  }
  
  public function suspender($id)
	{
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])){
			Flasher::access();
			Taker::back();
    }
    
		if(!$user = usuariosModel::by_id($id)) {
			Flasher::acces();
			Taker::back();
		}

		## Validates if $id_usuario user is admin or root
		if(is_admin($user['role']) || is_root($user['role'])) {
			Flasher::save(sprintf('No puedes suspender un usuario %s o %s', 'Root developer', 'Administrador'));
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

		Flasher::save('El trabajador ha sido suspendido con éxito y le hemos informado');
		Taker::back();
  }
  
  public function retirar_suspension($id)
	{
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])){
			Flasher::access();
			Taker::back();
    }
    
		if(!$user = usuariosModel::by_id($id)) {
			Flasher::acces();
			Taker::back();
    }
    
    // Validar que este suspendido
    if((int) $user['status'] !== 1) {
      Flasher::save('El trabajador seleccionado no está suspendido, intenta de nuevo.', 'danger');
      Taker::back();
    }

		## Updates current user and bans it
		if(!usuariosModel::update('usuarios', ['id_usuario' => $id], ['status' => 0])) {
			Flasher::updated('usuario', false);
			Taker::back();
		}

		// Enviar notificación al usuario

		Flasher::save('Se ha retirado la suspensión al trabajador con éxito y le hemos informado');
		Taker::back();
	}
}
