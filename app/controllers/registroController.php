<?php 

class registroController extends Controller
{
  public function __construct()
  {
    // Si ya hay una sesión iniciada con éxito redirigir
		if (Auth::auth()) {
			Taker::to('dashboard');
		}
  }

  public function index()
  {
    $this->data =
    [
      'title' => 'Regístrate gratis'
    ];

    View::render('index',$this->data,true);
  }
  
  public function store()
  {
    if(!check_posted_data(['csrf','nombre','email','usuario','password'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    FormHandler::save('registro_usuario', $_POST);

    if(empty($_POST['usuario']) || empty($_POST['nombre']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['conf-password'])){
      Flasher::save('Completa todos los campos por favor','danger');
      Taker::back();
    }

    if(strpos($_POST['usuario'] , ' ') !== false || !validate_name($_POST['usuario'])){
      Flasher::save('Ingresa un usuario válido, no debe contener espacios ni caracteres especiales', 'danger');
      Taker::back();
    }

    if(!validate_name($_POST['nombre'])){
      Flasher::save('Ingresa un nombre válido', 'danger');
      Taker::back();
    }

    if(!filter_var($_POST['email'] , FILTER_VALIDATE_EMAIL)){
      Flasher::save('Ingresa una dirección de correo electrónico válida', 'danger');
      Taker::back();
    }

    if($_POST['password'] !== $_POST['conf-password'])
    {
      Flasher::save('Las contraseñas no coinciden, intenta de nuevo', 'danger');
      Taker::back();
    }

    /** Verificar que no exista ya el usuario */
    if(usuariosModel::list('usuarios' , ['email' => $_POST['email']]) || usuariosModel::list('usuarios' , ['usuario' => $_POST['usuario']])){
      Flasher::save('El usuario o la dirección de correo electrónico ya existen', 'danger');
      Taker::back();
    }

    /** Agregar el nuevo usuario al sistema */

    ## Api key del usuario
    $token = new TokenHandler();
    $token = $token->getToken();

    $api_key = new TokenHandler();
    $api_key = $api_key->getToken();
    $usuario = 
    [
      'usuario'    => clean($_POST['usuario']),
      'nombre'     => clean($_POST['nombre']),
      'email'      => clean($_POST['email']),
      'verificado' => 0,
      'password'   => password_hash($_POST['password'].SITESALT, PASSWORD_DEFAULT),
      'id_role'    => 3,
      'ip'         => ipCliente(),
      'status'     => 0,
      'token'      => $token,
      'api_key'    => $api_key,
      'created_at' => ahora()
    ];
    
    if(!$id = usuariosModel::add('usuarios' , $usuario)){
      Flasher::save('Hubo un error en tu registro, intenta de nuevo por favor', 'danger');
      Taker::back();
    }

    /** Envío de notificaciones */
    $usuario             = usuariosModel::list('usuarios',['id_usuario' => $id])[0];
    $usuario['unhashed'] = $_POST['password'];
    $email               = new usuarioMailer($usuario);
    if(!$email->registrado()){
      logger('Correo de nuevo usuario registrado no enviado');
    }

    if(!$email->registrado('usuario')){
      logger('Correo a usuario de registro no enviado');
    }

    FormHandler::destroy('registro_usuario');
    Flasher::save(sprintf('¡Excelente %s!, registro completado con éxito', $usuario['nombre']));
    Taker::to('login');
  }
}
