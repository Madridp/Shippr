<?php 

class suscribirseController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    Flasher::save('Área fuera de servicio', 'danger');
    Taker::to('dashboard');
  }

  public function index()
  {
    // if(!is_root(get_user_role())) {
    //   Flasher::save('Seguimos trabajando en esta sección, ¡te informaremos cuando esté lista!','info');
    //   Taker::back();
    // }
    $this->data =
    [
      'title' => 'Suscribirse a '.get_sitename()
    ];

    View::render('index', $this->data);
  }

  public function pay()
  {
    if(is_subscribed()) {
      Flasher::save('Ya tienes una suscripción.','info');
      Taker::to('usuarios/suscripcion');
    }
    
    if(!isset($_GET['subType']) || !in_array($_GET['subType'],[1,2])) {
      Flasher::save('Selecciona un plan válido para proceder.','danger');
      Taker::to('suscribirse');
    }

    $this->data =
    [
      'title'       => 'Pagar ahora',
      'id_sub_type' => $_GET['subType']
    ];
    
    View::render('pay', $this->data);
  }
  
}
