<?php 

class enviosController extends Controller 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $envios = envioModel::by_user(get_user_id());

    $this->data =
    [
      'title' => 'Todos mis envíos',
      'e'     => $envios
    ];

    View::render('index',$this->data,true);
  }

  public function ver($id)
  {
    if(!$envio = envioModel::by_user_and_id(get_user_id() , $id)){
      Flasher::not_found('envío');
      Taker::back();
    }

    // Validar que la venta no este cancelada, si está cancelada no se permite el acceso
    if($envio['venta_status'] === 'cancelada') {
      Flasher::save(sprintf('No puedes ver este envío ya, la compra <b>%s</b> se encuentra cancelada', $envio['venta_folio']), 'danger');
      Taker::back();
    }

    $this->data =
    [
      'title' => sprintf('Viendo envío #%s', $envio['id']),
      'e'     => $envio,
      'r'     => json_decode($envio['remitente']),
      'd'     => json_decode($envio['destinatario'])
    ];

    View::render('single',$this->data,true);
  }

  public function actualizar($id)
  {
    if(!$envio = envioModel::by_user_and_id(get_user_id() , $id)){
      Flasher::access();
      Taker::back();
    }

    // Validar que la venta no este cancelada, si está cancelada no se permite el acceso
    if($envio['venta_status'] === 'cancelada') {
      Flasher::save(sprintf('No puedes editar este envío ya, la compra <b>%s</b> se encuentra cancelada', $envio['venta_folio']), 'danger');
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Actualizando envío',
      'e'     => $envio,
      'r'     => json_decode($envio['remitente']),
      'd'     => json_decode($envio['destinatario'])
    ];

    View::render('actualizar',$this->data,true);
  }

  public function post_actualizar()
  {
    if(!check_posted_data(['csrf','id','referencia'], $_POST) || !validate_csrf($_POST['csrf'])){
      Flasher::access();
      Taker::back();
    }

    $id = $_POST['id'];
    if(!$envio = envioModel::by_user_and_id(get_user_id() , $id)){
      Flasher::access();
      Taker::back();
    }

    // Validar que la venta no este cancelada, si está cancelada no se permite el acceso
    if($envio['venta_status'] === 'cancelada') {
      Flasher::save(sprintf('No puedes actualizar este envío ya, la compra <b>%s</b> se encuentra cancelada', $envio['venta_folio']), 'danger');
      Taker::back();
    }

    $envio_actualizado =
    [
      'referencia' => clean($_POST['referencia'])
    ];

    if(!envioModel::update('envios', ['id' => $id], $envio_actualizado)){
      Flasher::updated('envío',false);
      Taker::back();
    }

    Flasher::updated('envío');
    Taker::to('envios/ver/'.$id);
  }
  
  public function cotizar()
  {
    $this->data =
    [
      'title' => 'Cotizar envío',
    ];
    
    View::render('cotizar', $this->data,true);
  }

  public function print_label($id)
  {
    if(!check_get_data(['label','nonce','_t'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    if(!$envio = envioModel::by_user_and_id(get_user_id() , $id)){
      Flasher::not_found('envío');
      Taker::back();
    }

    // Validar que la venta no este cancelada, si está cancelada no se permite el acceso
    if($envio['venta_status'] === 'cancelada') {
      Flasher::save(sprintf('No puedes descargar la etiqueta de este envío, la compra <b>%s</b> se encuentra cancelada', $envio['venta_folio']), 'danger');
      Taker::back();
    }

    if(strlen($_GET['nonce']) !== 20){
      Flasher::access();
      Taker::back();
    }

    $file = $_GET['label'];

    ## Actualiza registro y decir que ya fue descargado
    if(empty($envio['descargado']) || (int) $envio['descargado'] === 0){
      envioModel::update('envios', ['id'  => $id], ['descargado' => 1]);
    }

    ## Al ser descargado confirmamos que el envío es correcto
    ## Verificar si ya existe en Aftership
    ## Agregar a AfterShip
    $res = null;
    try {
      $shipment = 
			[
				'slug'            => $envio['slug'],
        'tracking_number' => $envio['num_guia'],
        'title'           => 'Envío #'.$envio['id'].' de la venta #'.$envio['venta_folio'],
        'customer_name'   => $envio['u_nombre'],
        'customer_email'  => $envio['u_email'],
        'order_id'        => $envio['venta_folio'],
        'order_id_path'   => URL.'compras/ver/'.$envio['venta_folio']
      ];

      $aftership = new AftershipHandler();
      $res       = $aftership->add_new($shipment);

      $tracking  = $res['data']['tracking'];
      $data      = 
      [
        'tracking_id'  => $tracking['id'],
        'status'       => $tracking['tag']
      ];

      ## Actualizar el envio con su nueva información
      envioModel::update('envios', ['id'  => $id], $data);

    } catch (Exception $e) {
      logger($e->getMessage());
      Flasher::save($e->getMessage(), 'danger');
      //Taker::back();
    }

    download_label(UPLOADS.$file);
  }

  public function pagar_sobrepeso($id)
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    if(!$envio = envioModel::by_user_and_id(get_user_id(), $id)) {
      Flasher::access();
      Taker::back();
    }

    if(!$transaccion = transaccionModel::by_id($envio['t_id'])) {
      Flasher::not_found('transacción');
      Taker::back();
    }

    if($transaccion['tipo'] !== 'cargo_sobrepeso_saldo') {
      Flasher::save('La transacción no es un cargo por sobrepeso o no es válida', 'danger');
      Taker::back();
    }

    // Validar que en efecto exista un sobrepeso
    $peso_max    = $envio['peso_neto'] >= $envio['peso_vol'] ? $envio['peso_neto'] : $envio['peso_vol'];
    $peso_real   = $envio['peso_real'];
    $status      = $transaccion['status'];

    // El peso neto registrado es menor a la capacidad significa que está dentro del margen y no hay sobrepeso real
    // Si el peso volumétrico calculado es menor a la capacidad no hay sobrepeso real
    // Ver peso neto / volumétrico y real VS capacidad del envío
    if($peso_max < $envio['capacidad'] && $peso_real < $envio['capacidad']) {
      Flasher::save('Este envío no ha generado un sobrepeso', 'danger');
      Taker::back();
    }

    // Ver estado de la transacción relacionada
    if($status === 'pagado') {
      Flasher::save(sprintf('Ya has realizado el pago por cargo de sobrepeso para el <b>envío #%s</b>', $id), 'danger');
      Taker::back();
    }

    if($status !== 'pendiente') {
      Flasher::save('El estado de la transacción no es válido', 'danger');
      Taker::back();
    }

    // Comenzando actualización de transacción
    try {
      // Validar saldo en cuenta
      $id_transaccion        = $transaccion['id'];
      $total                 = $transaccion['total'];
      $saldo_disponible      = get_user_saldo('saldo');
      
      // Actualizar transacción y deducción de saldo
      // Validar que el usuario tenga crédito disponible para la compra
      if($total > $saldo_disponible) {
        //Flasher::save('No hay suficiente saldo en tu cuenta para completar la compra, realiza una recarga por favor', 'danger');
        //Taker::back();
        // worktodo
        // Verificar según la práctica si es bueno cobrar aunque no tenga saldo disponible así al realizar una recarga siempre será cobrado el débito pendiente
      }
  
      // Si el cobro falla se forzará el cobro al usuario
      if(!transaccionModel::update('shippr_transacciones', ['id' => $id_transaccion], ['status' => 'pagado'])) {
        logger(sprintf('Hubo un error en el pago para el cobro de sobrepeso del envío %s, se debe solicitar el cobro manualmente', $id));
        throw new PDOException('Hubo un problema al actualizar la transacción, intenta de nuevo por favor');
      }

      // worktodo: Notificación de pago de sobrepeso realizado

      Flasher::save(sprintf('Transacción realizada con éxito, has pagado un monto de <b>%s</b> por sobrepeso en el <b>envío #%s</b>', money($total, '$'), $id));
      Flasher::save(sprintf('Gracias por tu pago %s', get_user_name()));
      Taker::to('transacciones');

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }
}
