<?php 

class comprasController extends Controller
{

  public function index()
  {
    $this->data =
    [
      'title' => 'Todas mis compras',
      'v'     => $ventas = ventaModel::by_user(get_user_id())
    ];

    View::render('index',$this->data,true);
  }

  public function ver($folio)
  {
    if(!$venta = ventaModel::by_user_and_folio(get_user_id() , $folio)){
      Flasher::access();
      Taker::back();
    }
    
    $this->data =
    [
      'title' => 'Compra #'.$venta['folio'],
      'v'     => $venta
    ];

    View::render('single',$this->data,true);
  }
  
  public function pagar($id)
  {
    if(!check_get_data(['_t','nonce'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    if(!$venta = ventaModel::by_id($id)) {
      Flasher::not_found('compra', false);
      Taker::back();
    }

    // Validación de usuario y hash
    if($venta['nonce'] !== $_GET['nonce'] || (int) $venta['id_usuario'] !== get_user_id()) {
      Flasher::access();
      Taker::back();
    }

    // Validando el status de la venta
    if($venta['pago_status'] === 'pagado') {
      Flasher::save('El pago de esta compra ya está realizado', 'info');
      Taker::back();
    }

    if($venta['pago_status'] === 'en-progreso') {
      Flasher::save('El pago de esta compra ya está en revisión', 'info');
      Taker::back();
    }

    if($venta['status'] === 'completada') {
      Flasher::save('Esta compra ya ha sido completada, no puedes realizar el pago', 'danger');
      Taker::back();
    }

    if($venta['status'] === 'cancelada') {
      Flasher::save('Esta compra ya ha sido cancelada, no puedes realizar el pago', 'danger');
      Taker::back();
    }

    $this->data =
    [
      'title' => sprintf('Pagando compra #%s', $venta['folio']),
      'v'     => $venta
    ];
    
    View::render('pagar', $this->data);
  }
}
