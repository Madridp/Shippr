<?php 

class ipnController extends Controller
{

  public function __construct()
  {
  }

  public function index()
  {
    logger('IPN Started');
    if(!isset($_GET['topic'],$_GET['id'])){
      http_response_code(200);
      die;
    }

    $topic = $_GET['topic'];
    $id    = $_GET['id'];

    try {
      
      $ipn = new PaymentHandler();
      $payment = $ipn->search_ipn($topic,$id);      
      
    } catch (Exception $e){
      die($e->getMessage());
    }

    ## Que hacer después de obtener la información de pago
    if(!$payment){
      return false;
    }

    ## Actualizar registro
    $mo = $ipn->get_merchant_order();

    ## Validar que exista la referencia externa
    if(!$venta = ventaModel::list('ventas',['folio' => $mo->external_reference])){
      die(sprintf('Sale not found with number %s',$mo->external_reference));
    }

    ## Crear array para actualizar registros en DB
    $payment = $mo->payments[0];

    $updated_data = 
    [
      'pago_status'       => format_mp_status($payment->status),
      'collection_id'     => $payment->id,
      'preference_id'     => $mo->preference_id,
      'merchant_order_id' => $mo->id
    ];

    ## Actualizar el registro de la venta
    if(!ventaModel::update('ventas',['folio' => $mo->external_reference],$updated_data)){
      logger(sprintf('Sale number %s not updated.',$mo->external_reference));
    }
    
    logger('IPN Ended');
    logger(sprintf('Sale number %s updated.',$mo->external_reference));
  }

  public function api()
  {
    //logger('Probando integración de IPN de API');
    //logger('POST: '.print_r($_POST,TRUE));
    //logger('GET '.print_r($_GET,TRUE));

    $topic = $_GET['type'];
    $id    = $_GET['data_id'];

    try {
      
      $ipn = new PaymentHandler();
      $payment = $ipn->search_ipn($topic,$id);      
      
    } catch (Exception $e){
      logger($e->getMessage());
    }
    ## Actualizar registro
    $payment = $ipn->get_payment();
    $merchant_order = $ipn->get_merchant_order();
    //logger('Payment: '.print_r($payment,TRUE));
    //logger('Merchant Order '.print_r($merchant_order,TRUE));
  }
  
}
