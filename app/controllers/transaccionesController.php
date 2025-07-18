<?php 

class transaccionesController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->data =
    [
      'title'         => 'Mis transacciones',
      'transacciones' => transaccionModel::all_by_user(get_user_id())
    ];

    View::render('index', $this->data);
  }

  public function approved($payment_number)
  {
    // Check $folio is set
    if($payment_number == '') {
      Flasher::save('Transacción no válida.','danger');
      Taker::back();
    }

    // Cargar la información del pago
    if(!$transaction = transaccionModel::get_by_payment_number($payment_number)) {
      Flasher::save('Transacción no válida.','danger');
      Taker::back();
    }

    // Proteger si no es el estado correcto
    if($transaction['status'] !== 'approved') {
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Transacción aprobada',
      't'     => $transaction
    ];
    View::render('approved',$this->data);
  }

  public function in_process($payment_number)
  {
    // Check $folio is set
    if($payment_number == '') {
      Flasher::save('Transacción no válida.','danger');
      Taker::back();
    }

    // Cargar la información del pago
    if(!$transaction = transaccionModel::get_by_payment_number($payment_number)) {
      Flasher::save('Transacción no válida.','danger');
      Taker::back();
    }

    // Proteger si no es el estado correcto
    if($transaction['status'] !== 'in_process') {
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Transacción en verificación',
      't'     => $transaction
    ];
    View::render('inProcess',$this->data);
  }

  public function rejected($payment_number)
  {
  }

  public function nueva()
  {
    if(!check_posted_data(['csrf','id_venta','id_usuario'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    // Comenzando la transacción
    try {
      // Insertar transacción y deducción de saldo
      $id_transaccion        = null;
      $venta                 = null;
      $id_venta              = (int) $_POST['id_venta'];
      $total                 = 0;
      $saldo_disponible      = get_user_saldo('saldo');

      // Validar que exista la venta en efecto
      if(!$venta = ventaModel::by_id($id_venta)) {
        Flasher::error();
        Taker::back();
      }

      if((int) $venta['id_usuario'] !== get_user_id()) {
        Flasher::access();
        Taker::back();
      }

      // Validar que el usuario tenga crédito disponible para la compra
      if($total > $saldo_disponible) {
        Flasher::save('No hay suficiente saldo en tu cuenta para completar la compra, realiza una recarga por favor', 'danger');
        Taker::back();
      }

      $total                 = $venta['total'];
      $trans                 = new transaccionModel;
			$trans->tipo           = 'retiro_saldo';
			$trans->detalle        = sprintf('Retiro por %s MXN en compra realizada %s', money($total), $venta['folio']);
			$trans->referencia     = time();
      $trans->id_usuario     = get_user_id();
      $trans->tipo_ref       = 'compra';
      $trans->id_ref         = $id_venta;
			$trans->status         = 'pagado';
			$trans->status_detalle = get_payment_status($trans->status);
			$trans->metodo_pago    = 'user_wallet';
			$trans->descripcion    = 'Nueva transacción';
			$trans->subtotal       = $total / 1.16;
			$trans->impuestos      = ($total / 1.16) * 0.16;
			$trans->total          = $total;
	
      // Si el cobro falla se solicitará el pago al usuario
			if(!$id_transaccion = $trans->agregar()) {
        logger(sprintf('Hubo un error en el pago para la venta %s, se debe solicitar el cobro manualmente', $id_venta));
        throw new PDOException('Hubo un problema al realizar la transacción, intenta de nuevo por favor');
      }

      // Si el cobro se realiza con éxito se actualiza la venta a pagado y en proceso
      ventaModel::update('ventas', ['id' => $id_venta], ['pago_status' => 'pagado', 'status' => 'en-proceso']);
      
      // Notificación de pago realizado
      $venta = ventaModel::by_id($id_venta);
      $email = new compraMailer($venta);
      $email->compra_pagada('usuario');
      $email->compra_pagada();

      Flasher::save(sprintf('Transacción realizada con éxito, has pagado un monto de <b>%s</b> por la compra <b>#%s</b>', money($total, '$'), $venta['folio']));
      Flasher::save(sprintf('Gracias por tu pago %s', get_user_name()));
      Taker::to('compras');

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }
}
