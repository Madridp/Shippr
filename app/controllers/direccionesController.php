<?php

class direccionesController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $d = direccionModel::by_user(get_user_id());

    $this->data =
    [
      'title' => 'Mis direcciones',
      'd' => $d
    ];

    View::render('index',$this->data);
  }

  public function agregar()
  {
    $this->data =
    [
      'title' => 'Agregar nueva dirección'
    ];

    View::render('agregar', $this->data);
  }

  public function post_agregar()
  {
    if(!check_posted_data(['csrf','cp','colonia','ciudad','estado','calle','referencias','num_int'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    try {
      if(empty($_POST['cp']) || strlen($_POST['cp']) < 3) {
        throw new PDOException('El código postal es demasiado corto o no es válido');
      }

      if(!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        throw new PDOException('La dirección de correo electrónica no es válida');
      }

      if(empty($_POST['colonia']) || empty($_POST['estado'])) {
        throw new PDOException('Debes completar toda la información de la dirección');
      }

      // Nueva dirección
      $data =
      [
        'id_usuario'  => get_user_id(),
        'tipo'        => (isset($_POST['default_address']) ? 'remitente' : null),
        'nombre'      => clean($_POST['nombre']),
        'email'       => clean($_POST['email']),
        'telefono'    => clean($_POST['telefono']),
        'empresa'     => clean($_POST['empresa']),
        'cp'          => clean($_POST['cp']),
        'calle'       => clean($_POST['calle']),
        'num_ext'     => clean($_POST['num_ext']),
        'num_int'     => clean($_POST['num_int']),
        'colonia'     => clean($_POST['colonia']),
        'ciudad'      => clean($_POST['ciudad']),
        'estado'      => clean($_POST['estado']),
        'pais'        => clean($_POST['pais']),
        'referencias' => clean($_POST['referencias']),
        'coordenadas' => null,
        'creado'      => ahora()
      ];

      // Convertir en principal si es requerido
      if(isset($_POST['default_address']) && $_POST['default_address'] == 'on') {
        direccionModel::reset_main_addresses(get_user_id());
      }

      // Agregar la nueva dirección
      if(!$id = direccionModel::add('direcciones', $data)) {
        throw new PDOException('Hubo un problema al agregar tu nueva dirección');
      }

      Flasher::save('Hemos agregado con éxito una nueva dirección');
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  public function remitente_principal()
  {
    if(!isset($_GET['id'],$_GET['action'])) {
      Flasher::access();
      Taker::back();
    }

    ## Validate if current user already has a main address
    if(!isset($_GET['overwrite'])) {
      if(direccionModel::check_user_main_addresses(get_user_id())) {
        Flasher::save(sprintf('Ya tienes un remitente principal, ¿te gustaría sustituirlo?, <a href="%s" class="d-block text-white">Sí, actualizar el remitente principal</a>',buildURL('direcciones/remitente-principal',['id' => $_GET['id'],'action' => 'update','overwrite' => true])),'info');
        Taker::back();
      }
    }

    ## Update current address
    if(!direccionModel::update('direcciones',['id' => $_GET['id']],['tipo' => 'remitente'])) {
      Flasher::updated('dirección',false);
    } else {
      Flasher::updated('dirección');
    }

    Taker::back();
  }
}
