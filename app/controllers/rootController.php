<?php
use GuzzleHttp\Client;

class rootController extends Controller
{
  
  public function __construct()
  {
    parent::__construct();
    
    if(!is_root(get_user_role())){
      Flasher::access();
      Taker::back();
    }
  }

  public function index()
  {
    $this->data = 
    [
      'title' => 'Configuración del sistema'
    ];

    View::render('index' , $this->data);
  }

  public function administradores()
  {
    $this->data =
    [
      'title'    => 'Administradores',
      'usuarios' => usuariosModel::admins()
    ];

    View::render('admins', $this->data);
  }

  public function agregar_admin()
  {
    $this->data =
    [
      'title' => 'Agregar un administrador',
    ];

    View::render('administradores/agregar', $this->data);
  }

  public function post_administradores()
  {
    if(!check_posted_data(['csrf','nombre','usuario','email'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    FormHandler::save('agregar_administrador', $_POST);

    try {
      // Validaciones de información
      $err = 0;
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        Flasher::save('Dirección de correo electrónico no válida.', 'danger');
        $err++;
      }
  
      if (usuariosModel::list('usuarios', ['usuario' => $_POST['usuario']])) {
        Flasher::save(sprintf('Ya existe el nombre de usuario <b>%s</b> en la base de datos', $_POST['usuario']), 'danger');
        $err++;
      }
  
      if (usuariosModel::list('usuarios', ['email' => $_POST['email']])) {
        Flasher::save(sprintf('Ya existe la dirección de correo <b>%s</b> en la base de datos', $_POST['email']), 'danger');
        $err++;
      }
  
      if ($err > 0) {
        Taker::back();
      }

      // Nuevo usuario a insertar
      $role = rolesModel::list('roles', ['role' => 'admin']);

      if(!$role) {
        Flasher::error();
        Taker::back();
      }

      $password = randomPassword();
      $hashed   = password_hash($password.SITESALT, PASSWORD_BCRYPT);
      $role     = $role[0]['id'];
      $token    = new TokenHandler();
      $token    = $token->getToken();

      $data =
      [
        'usuario'    => clean($_POST['usuario']),
        'nombre'     => clean($_POST['nombre']),
        'email'      => clean($_POST['email']),
        'password'   => $hashed,
        'id_role'    => $role,
        'bio'        => null,
        'perfil'     => null,
        'firma'      => null,
        'status'     => 0,
			  'token'      => $token,
        'borrado'    => 0,
        'created_at' => ahora()
      ];

      if(!$id = usuariosModel::add('usuarios', $data)) {
        throw new Exception('Hubo un error al insertar el registro, intenta de nuevo.');
      }

      // Enviar notificación con datos de usuario
      $usuario             = usuariosModel::by_id($id);
      $usuario['unhashed'] = $password;
      $email               = new usuarioMailer($usuario);
      $email->agregado();
      $email->agregado('usuario');

      FormHandler::destroy('agregar_administrador');
      Flasher::save(sprintf('Hemos agregado un nuevo administrador con éxito.'));
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }
}
