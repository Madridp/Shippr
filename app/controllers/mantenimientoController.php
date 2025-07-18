<?php 

class mantenimientoController extends Controller
{
  public function __construct()
  {
    if((int) get_option('maintenance_mode') === 0){
			//Taker::back();
		}
  }

  public function index()
  {
    $this->data =
    [
      'title' => sprintf('%s en mantenimiento', get_system_name()),
      'msg'   => sprintf('El sistema %s está bajo mantenimiento, volverá en línea en unos minutos', get_system_name())
    ];

    View::render('maintenance', $this->data);
  }
}
