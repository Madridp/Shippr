<?php 

class carritoController extends Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $cart             = new CartHandler();
    $cart_output      = $cart->get_cart();
    $cart_amounts     = $cart->get_amounts();
    $cart_items       = $cart->get_items();
    $cart_total_items = $cart->get_total_items();

    $this->data =
    [
      'title'       => 'Tu carrito de compras',
      'cart'        => $cart_output,
      'items'       => $cart_items,
      'total_items' => $cart_total_items,
      'a'           => $cart_amounts,
    ];

    View::render('index',$this->data,true);
  }

  public function nuevo()
  {
    ## Si el usuario tiene dirección principal
    $main_address = direccionModel::get_user_main_address(get_user_id());

    ## Couriers disponibles
    $couriers = courierModel::all();

    if($main_address) {
      if(!get_session('remitente')) {
        set_session('remitente', $main_address);
      }
    }

    ## Direcciones guardadas del usuario
    $direcciones = direccionModel::by_user(get_user_id());

    $this->data =
    [
      'title'       => 'Nuevo envío',
      'direcciones' => $direcciones,
      'couriers'    => $couriers
    ];

    View::render('nuevo', $this->data);
  }

  /**
   * Se procesan ambas direcciónes y se
   * calculan las opciones disponibles de envío
   */
  public function store_step_two()
  {
    if(!check_posted_data(['csrf','remitente','destinatario','paq'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    if(!isset($_POST['remitente'])){
      Flasher::save('Debes ingresar un remitente', 'danger');
      Taker::back();
    }

    if(!isset($_POST['destinatario'])){
      Flasher::save('Debes ingresar un destinatario', 'danger');
      Taker::back();
    }

    if(!isset($_POST['paq'])){
      Flasher::save('Debes ingresar la información del paquete', 'danger');
      Taker::back();
    }

    $remitente    = null;
    $destinatario = null;
    $paquete      = null;

    $remitente    = $_POST['remitente'];
    $destinatario = $_POST['destinatario'];
    $paquete      = $_POST['paq'];
    $err          = 0;

    set_session('remitente', $remitente);
    set_session('destinatario', $destinatario);

    if (empty($remitente['cp']) || strlen($remitente['cp']) < 4) {
      Flasher::save('Debes ingresar un código postal válido para el remitente.', 'danger');
      $err++;
    }

    if (empty($remitente['colonia'])) {
      Flasher::save('Debes seleccionar una colonia válida para el remitente.', 'danger');
      $err++;
    }

    if (empty($remitente['ciudad'])) {
      Flasher::save('Ciudad no válida para el remitente.', 'danger');
      $err++;
    }

    if (empty($destinatario['cp']) || strlen($destinatario['cp']) < 4) {
      Flasher::save('Debes ingresar un código postal válido para el destinatario.', 'danger');
      $err++;
    }

    if (empty($destinatario['colonia'])) {
      Flasher::save('Debes seleccionar una colonia válida para el destinatario.', 'danger');
      $err++;
    }

    if (empty($destinatario['ciudad'])) {
      Flasher::save('Ciudad no válida para el destinatario.', 'danger');
      $err++;
    }

    if ($err > 0) {
      Taker::back();
    }
    
    // Verificar integridad del paquete
    $peso_vol  = null;
    $opciones  = null;
    $cap       = null;
    $opciones  = null;
    $paq_alto  = 0;
    $paq_ancho = 0;
    $paq_largo = 0;
    $id_courier= (isset($_POST['id_courier']) && !empty($_POST['id_courier']) ? $_POST['id_courier'] : null);
    
    $paq_largo = unmoney($_POST['paq']['largo']);
    $paq_alto  = unmoney($_POST['paq']['alto']);
    $paq_ancho = unmoney($_POST['paq']['ancho']);
    $peso_vol  = $_POST['paq']['peso_vol'] = (float) ($paq_alto * $paq_largo * $paq_ancho) / 5000;
    
    set_session('paq', $_POST['paq']);

    // Busqueda de productos permitidos para utilizar */
    $capacidad = ($peso_vol > $_POST['paq']['peso_neto'] ? $peso_vol : $_POST['paq']['peso_neto']);
    $opciones  = [];
    
    // Verificar si se deben utilizar coberturas personalizadas
    if(get_custom_zones()) {
      //$opciones2 = productoModel::search(ceil($capacidad), $destinatario['cp'], $id_courier);
      $opciones = zonaModel::search($remitente['cp'], $destinatario['cp'], $capacidad, $id_courier);
    } else {
      $opciones = productoModel::by_capacity($capacidad, $id_courier);
    }

    $label =
    [
      'r' => $_POST['remitente'],
      'd' => $_POST['destinatario'],
      'p' => $_POST['paq'],
      'o' => $opciones
    ];

    set_session('current_label', $label);

    Taker::to('carrito/confirmar-informacion');
  }

  public function confirmar_informacion()
  {
    if(!get_session('current_label')){
      Flasher::save('Debes comenzar un nuevo envío primero.','danger');
      Taker::to('carrito/nuevo');
    }
    
    $this->data =
    [
      'title' => 'Confirmar envío',
      'r'     => get_session('current_label')['r'],
      'd'     => get_session('current_label')['d'],
      'p'     => get_session('current_label')['p'],
      'o'     => get_session('current_label')['o'],
    ];

    View::render('pasoDos', $this->data,true);
  }

  public function agregar()
  {
    if(!check_posted_data(['id_producto', 'csrf'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    $id_producto = (int) $_POST['id_producto'];
    $producto    = productoModel::by_id($id_producto, get_custom_zones() ? get_session('destinatario.cp') : null);
    if(!$producto){
      Flasher::save('Selecciona una opción de envío válida.','danger');
      Taker::back();
    }

    $remitente    = get_session('remitente');
    $destinatario = get_session('destinatario');
    $paquete      = get_session('paq');
    $label        = get_session('current_label');

    $item = 
    [
      'id'           => randomPassword(10, 'numeric'),
      'id_producto'  => $producto['id'],
      'id_courier'   => $producto['id_courier'],
      'title'        => sprintf('%s %s %skg (%s)', $producto['name'], $producto['tipo_servicio'], $producto['capacidad'], $producto['tiempo_entrega']),
      'capacidad'    => $producto['capacidad'],
      'quantity'     => 1,
      'unit_price'   => $producto['precio'],
      'description'  => $producto['descripcion'],
      'picture_url'  => URL.'assets/uploads/'.$producto['imagenes'],
      'image'        => $producto['imagenes'],
      'remitente'    => $remitente,
      'destinatario' => $destinatario,
      'paq'          => $paquete
    ];

    $cart = new CartHandler();
    if(!$cart->add($item)){
      Flasher::save('Hubo un problema al agregar el envío al carrito, intenta de nuevo', 'danger');
      Taker::back();
    }
    
    unset($_SESSION['remitente']);
    unset($_SESSION['destinatario']);
    unset($_SESSION['paq']);
    unset($_SESSION['current_label']);
    Taker::to('carrito');
  }
  
  public function borrar()
  {
    if(!check_get_data(['id','cart_nonce'], $_GET)) {
      Flasher::access();
      Taker::back();
    }

    $cart = new CartHandler();
    if(!$cart->remove($_GET['id'])){
      Flasher::save('Producto no borrado, intenta de nuevo', 'danger');
      Taker::back();
    }

    Flasher::save('Producto borrado con éxito, carrito actualizado');
    Taker::back();
  }

  public function pagar_ahora()
  {
    $cart             = new CartHandler;
    $amounts          = $cart->get_amounts();
    $basket           = $cart->get_items();
    $cart_nonce       = $cart->get_nonce();
    $subtotal         = $amounts['subtotal'];
    $comission        = $amounts['comission'];
    $total            = $amounts['total'];
    $saldo_disponible = get_user_saldo('saldo');
    $sale_number      = randomPassword(10, 'numeric');
    $id_venta         = null;
    $id_envio         = null;
    $envios           = [];
    $env_insertados   = [];
    $id_transaccion   = null;

    if(empty($cart->get_cart()) || empty($basket)){
      Flasher::save('Tu carrito está vacío, primero debes agregar por lo menos un envío', 'danger');
      Taker::back();
    }
    
    if(!isset($_POST['pago_metodo'])) {
      Flasher::save('Selecciona un método de pago válido', 'danger');
      Taker::back();
    }
    
    if($_POST['pago_metodo'] !== $cart->get_payment_method()) {
      Flasher::save('Selecciona un método de pago válido', 'danger');
      Taker::back();
    }
    
    // En caso de que se duplique la transacción
    if(ventaModel::list('ventas' , ['nonce' => $cart_nonce])){
      logger('Intento de carrito duplicado detectado: '.$cart_nonce, 'error');
      Flasher::save('Este carrito ya ha sido procesado anteriormente', 'danger');
      $cart->destroy();
      logger('Carrito reiniciado con éxito');
      Taker::back();
    } 

    // Validar que el usuario tenga crédito disponible para la compra
    if($total > $saldo_disponible) {
      Flasher::save('No hay suficiente saldo en tu cuenta para completar la compra, realiza una recarga por favor', 'danger');
      Taker::back();
    }

    // Se inserta la venta en sistema como pendiente de pago
    try {
      $venta = 
      [
        'folio'             => $sale_number,
        'id_usuario'        => get_user_id(),
        'nonce'             => $cart_nonce,
        'metodo_pago'       => format_mp_payment_type($cart->get_payment_method()),
        'pago_status'       => 'pendiente', // Se inicializada como pendiente de pago
        'status'            => 'pendiente', // status de la venta como tal
        'collection_id'     => null,
        'preference_id'     => null,
        'merchant_order_id' => null,
        'subtotal'          => $subtotal,
        'comision'          => $comission,
        'total'             => $total,
        'creado'            => ahora()
      ];
  
      // Agregando la venta a la DB
      if(!$id_venta = ventaModel::add('ventas', $venta)){
        Flasher::save('Hubo un problema con la venta, intenta de nuevo','danger');
        Taker::back();
      }
      
    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }

    // Se insertan los envíos relacionados a la venta
    try {
      $producto = null;
      foreach ($basket as $i) {
        $producto = productoModel::by_id($i['id_producto']);
        $envios[] =
        [
          'id_venta'         => $id_venta,
          'id_usuario'       => get_user_id(),
          'id_producto'      => $i['id_producto'],
          'id_courier'       => $i['id_courier'],
          'tracking_id'      => null,
          'referencia'       => $i['paq']['referencia'],
          'titulo'           => $i['title'],
          'capacidad'        => $i['capacidad'],
          'precio'           => $i['unit_price'],
          'cantidad'         => $i['quantity'],
          'remitente'        => json_encode($i['remitente']),
          'destinatario'     => json_encode($i['destinatario']),
          'descripcion'      => $i['paq']['descripcion'],
          'paq_alto'         => $i['paq']['alto'],
          'paq_ancho'        => $i['paq']['ancho'],
          'paq_largo'        => $i['paq']['largo'],
          'peso_neto'        => $i['paq']['peso_neto'],
          'peso_vol'         => $i['paq']['peso_vol'],
          'num_guia'         => null,
          'status'           => 'Pending',
          'solicitado'       => 0,
          'descargado'       => 0,
          'con_sobrepeso'    => 0,
          'entrega_estimada' => null, // fecha estimada de la entrega Aftership
          'entregado'        => null, // fecha de la entrega Aftership
          'creado'           => ahora(),
          'actualizado'      => ahora()
        ];
      }
  
      ## Agregando cada envío
      foreach ($envios as $e) {
        if(!$id_envio = envioModel::add('envios', $e)){
          throw new PDOException('Hubo un error al agregar uno de tus envíos, tuvimos que cancelar la compra, intenta de nuevo');
        }
        
        $env_insertados[] = $id_envio;
      }
      
    } catch (PDOException $e) {
      // Si 1 o varios envíos no se insertan bien se cancela la venta, 
      // se borran los elementos insertados y se borra la venta
      Flasher::save($e->getMessage(), 'danger');
      
      logger('Error al insertar uno de los envíos a la base de datos');

      // Cancelando la venta
      logger(sprintf('Cancelando venta con id %s...', $id_venta));
      ventaModel::update('ventas', ['id' => $id_venta], ['status' => 'cancelada']);
      
      // Borrando la venta
      logger(sprintf('Borrando venta con id %s...', $id_venta));
      ventaModel::remove('ventas', ['id' => $id_venta], 1);

      // Borrando los envíos que se hayan insertado
      logger(sprintf('Borrando envíos insertados de la venta con id %s...', $id_venta));
      $sql = 'DELETE FROM envios WHERE id_venta = :id_venta';
      envioModel::query($sql, ['id_venta' => $id_venta]);

      logger('Listo');

      // Reinicio de carrito
      // todo, generar un nuevo hash para reintentar la compra
      // todo, almacenar la venta pero no borrarla
      Flasher::save('Hemos reiniciado tu carrito de compras');
      Flasher::save('No tienes de que preocuparte, no se te hizo ningún cobro. Lamentamos el inconveniente', 'info');
      $cart->destroy();
      Taker::back();
    }

    // Si se insertan bien todos los elementos anteriores se hace el cobro
    try {
      // Insertar transacción y deducción de saldo
      $venta                 = ventaModel::by_id($id_venta);
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
        logger(sprintf('Hubo un error en el pago para la venta %s, se debe solicitar el cobro manualmente', $venta['folio']));
        //throw new PDOException('Hubo un problema al realizar la transacción con tu crédito en cuenta, debes realizar tu pago manualmente desde <a href="compras">aquí</a>');
        Flasher::save('Hubo un problema al realizar la transacción con tu crédito en cuenta, debes realizar el pago manualmente desde <a href="'.buildURL('compras/pagar/'.$venta['id'], ['nonce' => $venta['nonce']]).'" class="text-white" target="_blank">aquí</a>', 'info');
      }

      $transaccion = transaccionModel::by_id($id_transaccion);
      Flasher::save(sprintf('Tu pago ha sido realizado con éxito, con folio <b>#%s</b>', $transaccion['numero']));

      // Notificación de nueva compra
      $venta = ventaModel::by_id($id_venta);
      $email = new compraMailer($venta);
      $email->nueva_compra('usuario');
      $email->nueva_compra();

      // Si el cobro se realiza con éxito se actualiza la venta a pagado
      $updated_order =
      [
        'pago_status'   => 'pagado',
        'status'        => 'en-proceso',
        'collection_id' => $transaccion['numero']
      ];
      ventaModel::update('ventas', ['id' => $id_venta], $updated_order); // Se actualiza la información de la venta

      // worktodo
      // Solicitar la creación de la guías
      

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      //Taker::back(); prevenir la redirección para que se siga a la página de pago
    }

    // Redirección para pasarelas de pago
    // Si el pago es offline entonces no requiere redirección especial
    switch ($cart->get_payment_method()) {
      case 'paying-qr-code':
        $params = 
        [
          'sale_id' => $id_venta,
          'sale_number' => $venta['folio'],
          'sale_payment_method' => $venta['metodo_pago'],
          'sale_status' => 'success'
        ];
        $cart->destroy();
        Taker::to(buildURL('pagos/qr-code', $params, false));
        break;

      case 'paying-cash':

        $params = 
        [
          'sale_id' => $id_venta,
          'sale_number' => $venta['folio'],
          'sale_payment_method' => $venta['metodo_pago']
        ];
        $cart->destroy();
        Taker::to(buildURL('pagos/cash', $params, false));
        break;
      
      case 'paying-bank-transfer':
        
        $params = 
        [
          'sale_id' => $id_venta,
          'sale_number' => $venta['folio'],
          'sale_payment_method' => $venta['metodo_pago']
        ];
        $cart->destroy();
        Taker::to(buildURL('pagos/bank-transfer', $params, false));
        break;

      case 'paying-mercadopago':
        try {

          $payer =
          [
            'name'    => get_user_name(),
            'email'   => get_user_email()
          ];

          $urls =
          [
            'success' => URL.'pagos/success',
            'pending' => URL.'pagos/pending',
            'failure' => URL.'pagos/failure'
          ];

          $ipn = URL.'ipn';

          $mp = new PaymentHandler;
          $mp->new_payer($payer);
          $mp->add_items($cart->get_items());
          $mp->add_comission($cart->get_amounts()['comission']);
          $mp->create_preference(['reference' => $sale_number , 'back_urls' => $urls , 'ipn' => $ipn]);
          $mp->save_preference();
          
          $cart->destroy();
          Taker::to($mp->get_payment_link());

        } catch (Exception $e){
          Flasher::save('Hubo un error: '.$e->getMessage(), 'danger');
          Taker::back();
        }
        break;
      
      case 'paying_user_wallet':
      default:
        $params = 
        [
          'sale_id'             => $venta['id'],
          'sale_number'         => $venta['folio'],
          'sale_payment_method' => $venta['metodo_pago']
        ];
        $cart->destroy();
        Taker::to(buildURL('pagos/user-wallet', $params, false));
        break;
    }
  }
}
