<?php 

class pagosController extends Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    Taker::back();
  }

  public function success()
  {
    ## Deben existir los parametros GET
    if(!isset($_GET['collection_id'] , 
    $_GET['collection_status'] , 
    $_GET['preference_id'] , 
    $_GET['external_reference'] , 
    $_GET['payment_type'] , 
    $_GET['merchant_order_id'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que sea un pago exitoso
    if(!$_GET['collection_status'] == 'approved'){
      Flasher::access();
      Taker::back();
    }

    ## Validar que exista la referencia externa
    $venta = null;
    if(!$venta = ventaModel::by_user_and_folio(get_user_id() , $_GET['external_reference'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que sea la primera vez que ingresan
    if(!empty($venta['collection_id']) || !empty($venta['preference_id']) || !empty($venta['merchant_order_id'])){
      //Taker::to('compras/ver/'.$venta['folio']);
    }

    ## Primer ingreso a la validación del pago
    $payment = 
    [
      'pago_status'       => format_mp_status($_GET['collection_status']),
      'collection_id'     => $_GET['collection_id'],
      'preference_id'     => $_GET['preference_id'],
      'metodo_pago'       => format_mp_payment_type($_GET['payment_type']),
      'merchant_order_id' => $_GET['merchant_order_id']
    ];

    ## Actualizar el registro de la venta
    if(!ventaModel::update('ventas',['folio' => $venta['folio']],$payment)){
      Flasher::save('La compra se realizó con éxito, pero no pudimos actualizar el registro.','danger');
      Taker::back();
    }

    ## Reseleccionar la venta con información actualizada
    $venta = ventaModel::by_user_and_folio(get_user_id() , $_GET['external_reference']);

    $this->data =
    [
      'title' => 'Pago éxitoso',
      'v'     => $venta
    ];

    View::render('success',$this->data,true);
  }

  public function pending()
  {
    ## Deben existir los parametros GET
    if(!isset($_GET['collection_id'] , 
    $_GET['collection_status'] , 
    $_GET['preference_id'] , 
    $_GET['external_reference'] , 
    $_GET['payment_type'] , 
    $_GET['merchant_order_id'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que sea un pago pendiente
    if(!in_array($_GET['collection_status'],['pending','in_process'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que exista la referencia externa
    $venta = null;
    if(!$venta = ventaModel::by_user_and_folio(get_user_id() , $_GET['external_reference'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que sea la primera vez que ingresan
    if(!empty($venta['collection_id']) || !empty($venta['preference_id']) || !empty($venta['merchant_order_id'])){
      Taker::to('compras/ver/'.$venta['folio']);
    }

    ## Primer ingreso a la validación del pago
    $payment = 
    [
      'pago_status'       => format_mp_status($_GET['collection_status']),
      'collection_id'     => $_GET['collection_id'],
      'preference_id'     => $_GET['preference_id'],
      'metodo_pago'       => format_mp_payment_type($_GET['payment_type']),
      'merchant_order_id' => $_GET['merchant_order_id']
    ];

    ## Actualizar el registro de la venta
    if(!ventaModel::update('ventas',['folio' => $venta['folio']],$payment)){
      Flasher::save('La compra se realizó con éxito con pago pendiente o en revisión, pero no pudimos actualizar el registro.','danger');
      Taker::back();
    }

    ## Reseleccionar la venta con información actualizada
    $venta = ventaModel::by_user_and_folio(get_user_id() , $_GET['external_reference']);

    $this->data =
    [
      'title' => 'Pago en revisión',
      'v'     => $venta
    ];

    View::render('pending',$this->data,true);
  }

  public function failure()
  {
    ## Deben existir los parametros GET
    if(!isset($_GET['collection_id'] , 
    $_GET['collection_status'] , 
    $_GET['preference_id'] , 
    $_GET['external_reference'] , 
    $_GET['payment_type'] , 
    $_GET['merchant_order_id'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que sea un pago pendiente
    if(!in_array($_GET['collection_status'],['rejected','null'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que exista la referencia externa
    $venta = null;
    if(!$venta = ventaModel::by_user_and_folio(get_user_id() , $_GET['external_reference'])){
      Flasher::access();
      Taker::back();
    }

    ## Validar que sea la primera vez que ingresan
    if(!empty($venta['collection_id']) || !empty($venta['preference_id']) || !empty($venta['merchant_order_id'])){
      #Taker::to('compras/ver/'.$venta['folio']);
    }

    ## Primer ingreso a la validación del pago
    $payment = 
    [
      'pago_status'       => format_mp_status($_GET['collection_status']),
      'collection_id'     => $_GET['collection_id'],
      'preference_id'     => $_GET['preference_id'],
      'metodo_pago'       => format_mp_payment_type($_GET['payment_type']),
      'merchant_order_id' => $_GET['merchant_order_id'],
      'status'            => 'cancelada'
    ];

    ## Actualizar el registro de la venta
    if(!ventaModel::update('ventas',['folio' => $venta['folio']],$payment)){
      Flasher::save('Hubo un error en la transacción, tu pago no se proceso de forma correcta.','danger');
      Flasher::save('Contáctanos para realizar tu pago nuevamente.','primary');
      Taker::back();
    }

    ## Reseleccionar la venta con información actualizada
    $venta = ventaModel::by_user_and_folio(get_user_id() , $_GET['external_reference']);

    $this->data =
    [
      'title' => 'Pago rechazado',
      'v'     => $venta
    ];

    View::render('failure',$this->data,true);
  }

  public function  cash()
  {
    ## Parámetros get deben existir
    if(!isset($_GET['sale_id'],$_GET['sale_number'],$_GET['sale_payment_method'])) {
      Flasher::access();
      Taker::back();
    }

    $id = (int) $_GET['sale_id'];
    $folio = $_GET['sale_number'];
    $payment = $_GET['sale_payment_method'];

    if(!$venta = ventaModel::by_user_and_folio( get_user_id() , $folio)) {
      Flasher::not_found();
      Taker::back();
    }

    if($venta['metodo_pago'] !== $payment) {
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Compra exitosa',
      'v'     => $venta
    ];

    View::render('cash',$this->data);
  }

  public function  bank_transfer()
  {
    ## Parámetros get deben existir
    if(!isset($_GET['sale_id'],$_GET['sale_number'],$_GET['sale_payment_method'])) {
      Flasher::access();
      Taker::back();
    }

    $id = (int) $_GET['sale_id'];
    $folio = $_GET['sale_number'];
    $payment = $_GET['sale_payment_method'];

    if(!$venta = ventaModel::by_user_and_folio( get_user_id() , $folio)) {
      Flasher::not_found();
      Taker::back();
    }

    if($venta['metodo_pago'] !== $payment) {
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Compra exitosa',
      'v'     => $venta
    ];

    View::render('banktransfer',$this->data);
  }

  public function  qr_code()
  {
    ## Parámetros get deben existir
    if(!isset($_GET['sale_id'],$_GET['sale_number'],$_GET['sale_payment_method'])) {
      Flasher::access();
      Taker::back();
    }

    $id = (int) $_GET['sale_id'];
    $folio = $_GET['sale_number'];
    $payment = $_GET['sale_payment_method'];

    if(!$venta = ventaModel::by_user_and_folio( get_user_id() , $folio)) {
      Flasher::not_found();
      Taker::back();
    }

    if($venta['metodo_pago'] !== $payment) {
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Compra exitosa',
      'v'     => $venta
    ];

    View::render('qrCode',$this->data);
  }

  public function user_wallet()
  {
    ## Parámetros get deben existir
    if(!check_get_data(['_t','sale_id','sale_number','sale_payment_method'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    $id      = (int) $_GET['sale_id'];
    $folio   = $_GET['sale_number'];
    $payment = $_GET['sale_payment_method'];

    if(!$venta = ventaModel::by_user_and_folio( get_user_id(), $folio)) {
      Flasher::not_found();
      Taker::back();
    }

    if($venta['metodo_pago'] !== $payment) {
      Flasher::access();
      Taker::back();
    }

    // 2.1.9
    // Si ya existe un pago por cualquier error o razón, actualizar la venta
    if ($venta['pago_status'] === 'pendiente' && $venta['t_status'] === 'pagado' && $venta['t_id'] !== null) {
      $updated_order =
      [
        'pago_status'   => 'pagado',
        'status'        => 'en-proceso',
        'collection_id' => $venta['t_numero']
      ];
      ventaModel::update('ventas', ['id' => $id], $updated_order); // Se actualiza la información de la venta
      $venta = ventaModel::by_user_and_folio( get_user_id(), $folio);
    }

    $this->data =
    [
      'title' => 'Compra exitosa',
      'v'     => $venta
    ];

    View::render('userWallet', $this->data);
  }
}
