<?php
function format_trans_tipo($trans_tipo) {
  $res = null;
  switch ($trans_tipo) {
    case 'recarga_saldo':
    $res = 'Ticket de recarga de saldo';
    break;

    case 'abono_saldo':
    $res = 'Abono de saldo a cuenta';
    break;

    case 'retiro_saldo':
    $res = 'Retiro de compra';
    break;

    case 'cargo_sobrepeso_saldo':
    $res = 'Cargo por sobrepeso';
    break;

    case 'cargo_recoleccion_saldo':
    $res = 'Cargo por recolección';
    break;

    case 'cargo_especial_saldo':
    $res = 'Cargo especial';
    break;

    case 'devolucion_saldo':
    $res = 'Devolución de saldo';
    break;

    case 'compensacion_saldo':
    $res = 'Compensación de saldo';
    break;

    default:
    $res = 'Desconocido';
  }

  return $res;
}

function format_trans_tipo_monto($trans_tipo, $monto) {
  $badge = null;
  $icon  = null;
  $str   = null;
  switch ($trans_tipo) {
    case 'recarga_saldo':
    $badge = 'badge-primary';
    $icon  = 'fas fa-envelope';
    break;

    case 'abono_saldo':
    $badge = 'badge-success';
    $icon  = 'fas fa-plus';
    break;

    case 'retiro_saldo':
    $badge = 'badge-danger';
    $icon  = 'fas fa-minus';
    break;

    case 'cargo_sobrepeso_saldo':
    $badge = 'badge-danger';
    $icon  = 'fas fa-weight';
    break;

    case 'cargo_recoleccion_saldo':
    $badge = 'badge-danger';
    $icon  = 'fas fa-shipping-fast';
    break;

    case 'cargo_especial_saldo':
    $badge = 'badge-danger';
    $icon  = 'fas fa-money-check-alt';
    break;

    case 'devolucion_saldo':
    $badge = 'badge-info';
    $icon  = 'fas fa-undo-alt';
    break;

    case 'compensacion_saldo':
    $badge = 'badge-success';
    $icon  = 'fas fa-medal';
    break;

    default:
    $badge = 'badge-light';
    $icon  = 'fas fa-question';
  }

  return sprintf('<span class="badge f-s-14 %s"><i class="%s"></i> %s</span>', $badge, $icon, money($monto, '$'));
}

function get_metodos_de_pago() {
  $metodos = 
  [
    ['efectivo'     ,'Efectivo'],
    ['transferencia','Transferencia bancaria'],
    ['credit_card'  ,'Tarjeta de crédito'],
    ['debit_card'   ,'Tarjeta de débito'],
    ['prepaid_card' ,'Tarjeta prepagada'],
    ['mercadopago'  ,'MercadoPago'],
    ['account_money','Dinero en cuenta MercadoPago'],
    ['user_wallet'  , 'Crédito en cuenta'],
    ['qr-code'      ,'Código QR Mercado Pago'],
    ['desconocido'  ,'Desconocido']
  ];

  return $metodos;
}

function get_estados_de_venta() {
  $status = 
  [
    ['pendiente' ,'Pendiente de entrega'],
    ['en-proceso','En proceso'],
    ['completada','Completada'],
    ['cancelada' ,'Cancelada']
  ];
  return $status;
}

function get_estados_de_pago() {
  $payment_status = 
  [
    ['pendiente'  , 'Pendiente'],
    ['en-progreso', 'En revisión'],
    ['pagado'     , 'Pagado'],
    ['aprobado'   , 'Aprobado'],
    ['rechazado'  , 'Rechazado'],
    ['cancelado'  , 'Cancelado'],
    ['devuelto'   , 'Devuelto'],
    ['void'       , 'Anulado']
  ];
  return $payment_status;
}

function get_va_overweight_price() {
  $res = JS_Options::get_option('va_mp_overweight_price');

  if(!$res || $res === null) {
    return 25;
  }

  return $res;
}

function get_va_mp_comission_rate() {
  $res = JS_Options::get_option('va_mp_comission_rate');

  if(!$res || $res === null) {
    return 0;
  }

  return $res;
}

function get_mp_public_key() {
  $res = JS_Options::get_option('va_mp_public_key');

  if(!$res || $res === null) {
    return ''; // Llave del cliente
  }

  return $res;
}

function get_mp_access_token() {
  $res = JS_Options::get_option('va_mp_access_token');

  if(!$res || $res === null) {
    return '';
  }

  return $res;
}

function get_working_hours_message() {
  $output = 
  '<div class="alert alert-danger m-b-25" role="alert">
    <h4 class="alert-heading f-w-500 my-3">¡Recuerda!</h4>
    <p>Actualmente estamos <b>desconectados</b>, las guías pendientes serás procesadas automáticamente el siguiente día hábil.</p>
    %s de lunes a viernes,<br>
    %s sábados,<br>
    %s domingos
    <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
      <span class="text-white" aria-hidden="true">&times;</span>
    </button>
  </div>';
  $lv = get_option('site_lv_opening') == 0 && get_option('site_lv_closing') == 0 ? 'No laborable - ' : sprintf('%s - %s',
  get_hour(get_option('site_lv_opening')),
  get_hour(get_option('site_lv_closing')));

  $sat = get_option('site_sat_opening') == 0 && get_option('site_sat_closing') == 0 ? 'No laborable - ' : sprintf('%s - %s',
  get_hour(get_option('site_sat_opening')),
  get_hour(get_option('site_sat_closing')));

  $sun = get_option('site_sun_opening') == 0 && get_option('site_sun_closing') == 0 ? 'No laborable - ' : sprintf('%s - %s',
  get_hour(get_option('site_sun_opening')),
  get_hour(get_option('site_sun_closing')));
  return sprintf($output, $lv, $sat, $sun);
}

function get_hours_list() {
  return
  [
    [0, '12:00 AM'],
    [1, '1:00 AM'],
    [2, '2:00 AM'],
    [3, '3:00 AM'],
    [4, '4:00 AM'],
    [5, '5:00 AM'],
    [6, '6:00 AM'],
    [7, '7:00 AM'],
    [8, '8:00 AM'],
    [9, '9:00 AM'],
    [10, '10:00 AM'],
    [11, '11:00 AM'],
    [12, '12:00 PM'],
    [13, '1:00 PM'],
    [14, '2:00 PM'],
    [15, '3:00 PM'],
    [16, '4:00 PM'],
    [17, '5:00 PM'],
    [18, '6:00 PM'],
    [19, '7:00 PM'],
    [20, '8:00 PM'],
    [21, '9:00 PM'],
    [22, '10:00 PM'],
    [23, '11:00 PM']
  ];
}

function get_hour($hour = 0) {
  foreach (get_hours_list() as $h) {
    if($h[0] == $hour) {
      return $h[1];
    }
  }

  return 0;
}

function is_working_hours() {
  $open_hour    = get_open_hour();
  $close_hour   = get_close_hour();
  $current_hour = date('H');
  if($current_hour < $open_hour || $current_hour >= $close_hour) {
    return false;
  }

  return true;
}

function get_open_hour() {
  // Con base al día de la semana
  // se muestra la hora de servicio
  switch (date('N')) {
    case 6: // sábados
      return get_option('site_sat_opening');;
      break;
    case 7: // domingos
      return get_option('site_sun_opening');;
      break;
    default: // lunes a viernes
      return get_option('site_lv_opening');
      break;
  }
}

function get_close_hour() {
  switch (date('N')) {
    case 6: // sábados
      return get_option('site_sat_closing');;
      break;
    case 7: // domingos
      return get_option('site_sun_closing');;
      break;
    default: // lunes a viernes
      return get_option('site_lv_closing');
      break;
  }
}

function get_aftership_key() {
  $api_key = get_option('aftership_api_key'); // desde versión 2.0.0 para cada cliente
  return $api_key;
}

function get_producto_imagen($img) {
  if(!is_file(UPLOADS.$img)) {
    return URL.IMG.'broken.png';
  }

  return URL.UPLOADS.$img;
}

function get_producto_status($status) {
  if(!$status || intval($status) === 0) {
    return false;
  }

  return true;
}

function create_event_carousel($data = null) {
  if($data === NULL) {
    return false;
  }

  ## 5 elementos requeridos en cada cuadro
  ## ['titulo','descripcion','sku','precio','creado']
  ## Inicialización
  $d =
  [
    'id'            => (isset($data['id']) ? $data['id'] : NULL),
    'classes'       => (isset($data['classes']) && !empty($data['classes']) ? $data['classes'] : []),
    'element'       => (isset($data['element']) ? $data['element'] : NULL),
    'bg_image'      => (isset($data['bg_image']) ? $data['bg_image'] : NULL),
    'content_title' => (isset($data['content_title']) ? $data['content_title'] : NULL),
    'content_empty' => (isset($data['content_empty']) ? $data['content_empty'] : NULL),
    'footer_text'   => (isset($data['footer_text']) ? $data['footer_text'] : NULL),
    'footer_link'   => (isset($data['footer_link']) ? $data['footer_link'] : NULL),
    'keys'          => (isset($data['keys']) && !empty($data['keys']) ? $data['keys'] : []),
    'show'          => (isset($data['show']) && !empty($data['show']) ? $data['show'] : []),
    'content'       => (isset($data['content']) && !empty($data['content']) ? $data['content'] : [])
  ];

  $shown_areas = ['title','description','number_element','main_element','date','link_to'];

  ## To object
  $d = toObj($d);

  ## Imagen de fondo a utilizar
  $data['bg-image'] = (isset($data['bg-image']) ? $data['bg-image'] : '');

  ## Título del carouse
  $data['title'] = (isset($data['title']) ? $data['title'] : 'Sin titulo');

  ## Data
  $data['data'] = (isset($data['data']) ? $data['data'] : NULL);

  $output =
  '<div class="user-profile compact '.implode(' ',$d->classes).'" '.(empty($d->id) ? '' : 'id="'.$d->id.'"').'>
  <div class="up-head-w" '.bg_image($d->bg_image).'>
  <div class="up-main-info" style="padding-top: 10%;">
  <h2 class="up-header">
  <span class="m-r-10" data-count="true" data-number="'.(!empty($d->content) ? count($d->content) : 0).'" id="upcoming"></span>'.$d->content_title.'
  </h2>';

  if(isset($d->content) && !empty($d->content)) {
    $output .= '<div class="upcoming_event_carasol owl-carousel owl-theme">';
    foreach ($d->content as $c) {
        $i = 0;
        $output .= 
        '<div class="item">
        <h2 class="m-0">'.$c->{$d->keys[$i++]}.'</h2>
        <small>'.$c->{$d->keys[$i++]}.'</small>

        <h5 class="m-0">'.$c->{$d->keys[$i++]}.'</h5><br>

        <div class="w-200">
          '.$c->{$d->keys[$i++]}.'
        </div>';

        ## Show date
        if(in_array('date' , $d->show)) {
          $output .= '<small>Fecha</small><p>'.$c->{$d->keys[$i++]}.'</p>';
        }
        $output .= '</div>';
    }
    $output .= '</div>';
  } else {
    $output .= '<h2>'.$d->content_empty.'</h2>';
  }

  $output .= '<h2 class="up-header name">'.get_user_name().'</h2>';
  if(!empty($d->footer_text) && !empty($d->footer_link)) {
    $output .= 
    '<h6 class="up-sub-header name">
    <a href="'.$d->footer_link.'" class="text-white" target="_blank">'.$d->footer_text.'</a>
    </h6>';
  }
  $output .= '</div></div></div>';

  return $output;
}

/**
 * Regresa el script para seguimiento de hotjar
 * de Shippr v1
 *
 * @return void
 */
function get_hotjar_script() {
  $hotjar = get_option('site_hotjar');
  $hotjar = '';
  return $hotjar;
}

/**
 * Regresa el estado formateado como boton
 * de la venta
 *
 * @param string $status
 * @return void
 */
function get_venta_status_boton($status) {
  switch ($status) {
    case 'pendiente':
    return '<span class="badge badge-primary">Pendiente <i class="fa fa-clock-o"></i></span>';
    break;
    
    case 'en-proceso':
      return '<span class="badge badge-info">En proceso <i class="fa fa-forward"></i></span>';
      break;

    case 'cancelada':
      return '<span class="badge badge-danger">Cancelada <i class="fa fa-undo"></i></span>';
      break;

    case 'completada':
      return '<span class="badge badge-success">Completada <i class="fa fa-check"></i></span>';
      break;
    
    default:
      return '<span class="badge badge-danger">Desconocido <i class="fa fa-exclamation"></i></span>';
      break;
  }
}

/**
 * Determina si deberán tomarse las claves
 * sandbox de pruebas o de producción
 * de Shippr
 *
 * @return void
 */
function get_mp_sandbox() {
  $sandbox = (int) JS_Options::get_option('mp_sandbox');

  if(!$sandbox){
    return false;
  }

  return true;
}

/**
 * Carga de la db la client id de Mercado Pago
 * de Shippr
 *
 * @return void
 */
function get_mp_client_id() {
  $sandbox = (int) JS_Options::get_option('mp_sandbox');
  $key     = JS_Options::get_option('mp_client_id');

	return $key;
}

/**
 * Carga de la db el client secret de Mercado Pago
 * de Shippr
 *
 * @return void
 */
function get_mp_client_secret() {
  $sandbox = (int) JS_Options::get_option('mp_sandbox');
  $key     = JS_Options::get_option('mp_client_secret');

	return $key;
}

/**
 * Despedida de los correos electrónicos
 *
 * @return void
 */
function get_email_ty_message() {
  $output = 'Gracias por tu preferencia, cada día trabajamos para brindarte un mejor servicio, más fácil y rápido.<br><br>';
  $output .= get_sitename().'<br><br>';
  return $output;
}

function check_if_defined($value , $muted = false , $block = false) {
  if(empty($value) || $value === '' || $value == '') {
    return ($muted) ? '<span class="text-muted '.($block ? 'd-block' : '').'">No definido</span>' : 'No definido';
  }

  return $value;
}

function get_youtube_video() {
  $video = 'https://www.youtube.com/embed/FJ7efO0AWyk';
  return $video;
}

function embed_video($url , $container = true) {
  $output = '';
  if($container) {
    $output .= '<div class="responsive-embed-container">';
  }

  $output .= '<iframe class="mt-2 responsive-embed-item" src="'.$url.'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

  if($container) {
    $output .= '</div>';
  }

  return $output;
}

function get_rating($rating = 5 , $color = 'warning') {
  $output = '';
  $min        = 1;
  $max        = 5;
  $empty_star = '<i class="far fa-star text-'.$color.'"></i>';
  $half_star  = '<i class="fas fa-star-half-alt text-'.$color.'"></i>';
  $full_star  = '<i class="fas fa-star text-'.$color.'"></i>';

  if(!is_numeric($rating)) {
    $rating = 5;
  }
  $rating = ceil($rating);

  for ($i=0; $i < $max; $i++) { 
    if($rating > $i) {
      $output .= $full_star;
    } else {
      $output .= $empty_star;
    }
  }

  return $output;
}

function missing_fields_on_user_profile() {
  $missing_fields = 0;
  $mgs = [];
  $user = get_user_data();

  if(!$user) {
    return false;
  }

  // Checar Empresa
  if($user->empresa == '' || empty($user->empresa)) {
    $missing_fields++;
    $mgs[] = 'Ingresa el nombre de tu empresa o negocio';
  }
  // Checar Razón social
  if($user->razon_social == '' || empty($user->razon_social)) {
    $missing_fields++;
    $mgs[] = 'Ingresa la Razón Social de tu empresa';
  }
  // Checar RFC
  if($user->rfc == '' || empty($user->rfc)) {
    $missing_fields++;
    $mgs[] = 'Ingresa el RFC personal o corporativo';
  }
  // Checar Teléfono
  if($user->telefono == '' || empty($user->telefono)) {
    $missing_fields++;
    $mgs[] = 'Ingresa el teléfono de contacto de tu empresa';
  }
  // Checar dirección
  if(empty($user->cp) || empty($user->calle) || empty($user->num_ext) || empty($user->colonia) || empty($user->ciudad)) {
    $missing_fields++;
    $mgs[] = 'Completa tu domicilio o el de tu empresa';
  }
  // Checar dirección
  if($user->bio == '' || empty($user->bio)) {
    $missing_fields++;
    $mgs[] = 'Cuéntanos un poco más sobre ti o tu empresa';
  }

  if($missing_fields === 0) {
    return false;
  }

  return $mgs;
}

function subscription_will_expire(){
  if(!is_subscribed()) {
    return false;
  }

  $time = 60 * 60 * 24 * 3; // 3 days prior
  $sub = get_user_sub();
  $time_remaining = $sub['end'] - time();
  if($time_remaining < $time) {
    //Flasher::save(sprintf('Tu suscripción está próxima a expirar, renuevala ahora <b><a class="text-white" href="%s">aquí</a></b>.',buildURL('suscribirse/pay',['subType' => $sub['id']],false)),'info');
  }
  return true;
}

function get_transactions_endpoint() {
  return URL.'transacciones/';
}

function get_subscription_message() {
  return $output = ''; // agregado en versión 2.0.0

  if(is_subscribed()) {
    $sub_status = get_user_sub_status();
    if($sub_status === 'authorized') {
      $output .= '<div class="alert alert-success mb-3">Eres <b>'.get_user_sub_title().'</b> y estás usando los beneficios de '.get_sitename().'.</div>';
    } elseif($sub_status === 'expired') {
      $output .= '<div class="alert alert-danger">Tu suscripción <b>'.get_user_sub_title().'</b> ha expirado, renueva ahora para seguir disfrutando de los beneficios de '.get_sitename().'.</div>
      <a class="btn btn-info mb-2" href="usuarios/renovar">Renovar ahora</a>';
    } elseif($sub_status === 'paused') {
      $output .= '<div class="alert alert-danger">Tu suscripción <b>'.get_user_sub_title().'</b> está pausada, reactívala ahora para seguir disfrutando de los beneficios de '.get_sitename().'.</div>
      <a class="btn btn-info mb-2" href="usuarios/suscripcion">Reactivar ahora</a>';
    } elseif($sub_status === 'cancelled') {
      $output .= '<div class="alert alert-danger">Tu suscripción <b>'.get_user_sub_title().'</b> ha sido cancelada, reactívala ahora para seguir disfrutando de los beneficios de '.get_sitename().'.</div>
      <a class="btn btn-info mb-2" href="usuarios/suscripcion">Reactivar ahora</a>';
    } elseif($sub_status === 'pending') {
      $output .= '<div class="alert alert-danger mb-3">Tu suscripción <b>'.get_user_sub_title().'</b> está pendiente, estamos verificando tu pago, será activada automáticamente para que sigas disfrutando de los beneficios de '.get_sitename().'.</div>';
    }
  }
  return $output;
}

function get_system_status() {
  $status = get_option('site_status');
  return ((int) $status === 1 ? true : false);
}

function get_plan($_plan) {
  $plans = [];
  $plans[] =
  [
    'title'         => 'lite',
    'billing'       => 'monthly',
    'price'         => 299,
    'workers_limit' => 0,
    'admins_limit'  => 1
  ];

  $plans[] =
  [
    'title'         => 'basic',
    'billing'       => 'monthly',
    'price'         => 499,
    'workers_limit' => 2,
    'admins_limit'  => 1
  ];

  $plans[] =
  [
    'title'         => 'unlimited',
    'billing'       => 'lifetime',
    'price'         => 35000,
    'workers_limit' => 5,
    'admins_limit'  => 1
  ];

  foreach($plans as $plan) {
    if($plan['title'] === $_plan) {
      return $plan;
    }
  }

  return $plans[0];
}

function get_siteplan() {
  $plan = get_option('siteplan');
  $default = 'lite';

  if(!$plan) {
    return $default;
  }

  return $plan;
}

function reached_workers_limit() {
  $plan          = get_plan(get_siteplan());
  $workers_limit = $plan['workers_limit'];
  $used          = trabajadorModel::sits_used();
  if($used >= $workers_limit) {
    return true;
  }

  return false;
}

function get_workers_limit() {
  $plan = get_plan(get_siteplan());
  return $plan['workers_limit'];
}

//---------------------------------------------------------------------
//---------------------------------------------------------------------
//---------------------------------------------------------------------
// A PARTIR DE LA VERSIÓN 2.0.0
//---------------------------------------------------------------------
//---------------------------------------------------------------------
//---------------------------------------------------------------------
function get_site_faq() {
  $faq = get_option('faq');

  if(empty($faq)) {
    return sprintf('No hay preguntas frecuentes definidas por %s.', get_sitename());
  }

  return $faq;
}

function get_faq_date() {
  $date = get_option('faq_updated');

  if($date === null || empty($date)) {
    return 'Desconocida';
  }

  return fecha(date('Y-m-d', $date));
}

/**
 * Opciones disponibles para recargas de saldo en cuentas
 *
 * @return array
 */
function get_saldo_montos() {
  return [300,500,750,1000,1500,2000,2500,5000];
}

/**
 * Cargar saldo del usuario
 * pendiente | abonado | retirado | saldo | all
 *
 * @param string $type
 * @return void
 */
function get_user_saldo($type = null) {
  $user = get_user_data();

  $data =
  [
    'saldo_abonado'   => isset($user->saldos->saldo_abonado) ? $user->saldos->saldo_abonado : 0,
    'saldo_pendiente' => isset($user->saldos->saldo_pendiente) ? $user->saldos->saldo_pendiente : 0,
    'saldo_retirado'  => isset($user->saldos->saldo_retirado) ? $user->saldos->saldo_retirado : 0,
    'saldo'           => isset($user->saldos->saldo) ? $user->saldos->saldo : 0
  ];

  if($type === 'all') {
    return $data;
  }

  switch ($type) {
    case 'pendiente':
    return $data['saldo_pendiente'];
    break;

    case 'abonado':
    return $data['saldo_abonado'];
    break;

    case 'retirado':
    return $data['saldo_retirado'];
    break;

    case 'saldo':
    default:
    return $data['saldo'];
    break;
  }
}

function get_producto_tiempos_entrega() {
  return
  [
    ['día siguiente'],
    ['1 a 2 días hábiles'],
    ['2 a 5 días hábiles'],
    ['3 a 5 días hábiles'],
    ['3 a 7 días hábiles'],
    ['3 a 10 días'],
    ['10 a 15 días'],
    ['15 a 20 días'],
    ['1 mes'],
    ['60 días']
  ];
}

function get_producto_tipos_servicio() {
  return
  [
    ['regular', 'Regular / Económico'],
    ['express', 'Express']
  ];
}

function get_envio_sobrepeso_opciones() {
  return 
  [
    [1, 'Sobrepeso registrado'],
    [0, 'Sin sobrepeso']
  ];
}

/**
 * Formato textual del estado del pago de una transacción o venta
 *
 * @param string $pago_status
 * @return string
 */
function get_payment_status($pago_status) {
  switch ($pago_status) {
    case 'pendiente':
      return 'Pago pendiente';
      break;

    case 'aprobado':
    case 'pagado':
      return 'Pago aprobado';
      break;
    
    case 'cancelado':
      return 'Pago cancelado';
      break;

    case 'devuelto':
      return 'Cobro devuelto';
      break;
    
    case 'en-progreso':
    case 'en_progreso':
    case 'en-progreso':
    case 'en_revision':
      return 'Pago en revisión';
      break;

    case 'solicitado':
      return 'Recarga solicitada';
      break;

    case 'abonado':
      return 'Saldo abonado';
      break;

    case 'rechazado':
      return 'Pago rechazado';
      break;

    case 'void':
      return 'Pago anulado';
      break;
    
    default:
      return 'Desconocido';
      break;
  }
}

/**
 * Muestra el estado de pago como pill o botón pequeño
 *
 * @param string $pago_status
 * @return void
 */
function format_payment_status_pill($pago_status) {
  $str     = null;
  $classes = null;
  $icon    = null;

  switch ($pago_status) {
    case 'pendiente':
      $classes = 'badge-warning';
      $icon    = 'fas fa-clock';
      break;

    case 'aprobado':
    case 'pagado':
      $classes = 'badge-success';
      $icon    = 'fas fa-check';
      break;
    
    case 'cancelado':
      $classes = 'badge-danger';
      $icon    = 'fas fa-ban';
      break;

    case 'devuelto':
      $classes = 'badge-danger';
      $icon    = 'fas fa-undo';
      break;
    
    case 'en_progreso':
    case 'en-progreso':
    case 'en_revision':
      $classes = 'badge-info';
      $icon    = 'fas fa-search-dollar';
      break;

    case 'solicitado':
      $classes = 'badge-warning';
      $icon    = 'fas fa-clock';
      break;

    case 'abonado':
      $classes = 'badge-primary';
      $icon    = 'fas fa-plus';
      break;

    case 'rechazado':
      $classes = 'badge-danger';
      $icon    = 'fas fa-times';
      break;

    case 'void':
      $classes = 'badge-muted';
      $icon    = 'fas fa-strikethrough';
      break;
    
    default:
      $classes = 'badge-muted';
      $icon    = 'fas fa-exclamation';
      break;
  }

  return sprintf('<span class="badge %s"><i class="%s"></i> %s</span>', $classes, $icon, get_payment_status($pago_status));
}

function get_ticket_payment_info() {
  $bank_info = get_bank_info();
  $output    = null;

  if($bank_info->name !== null) {
    $output .= sprintf('<p>Banco <b>%s</b></p>', $bank_info->name);
  }

  if($bank_info->number !== null) {
    $output .= sprintf('<p>Sucursal <b>%s</b></p>', $bank_info->number);
  }

  if($bank_info->account_name !== null) {
    $output .= sprintf('<p>Titular <b>%s</b></p>', $bank_info->account_name);
  }

  if($bank_info->account_number !== null) {
    $output .= sprintf('<p>Número de cuenta <b>%s</b></p>', $bank_info->account_number);
  }

  if($bank_info->clabe !== null) {
    $output .= sprintf('<p>CLABE <b>%s</b></p>', $bank_info->clabe);
  }
  
  if($bank_info->card_number !== null) {
    $output .= sprintf('<p>Pago en OXXO o 7Eleven <b>%s</b></p>', $bank_info->card_number);
  }

  return $output;
}

function get_cart_items() {
  $cart             = new CartHandler;
  $amounts          = $cart->get_amounts();
  $basket           = $cart->get_items();
  $cart_nonce       = $cart->get_nonce();

  if(empty($basket)) {
    return 0;
  }
  
  return count($basket);
}

function get_cart_count($color = 'light') {
  $items  = get_cart_items();

  return sprintf('<span class="badge badge-%s">%s</span>', $color, $items);
}

function format_cart_icon($icon = null) {
  $icon   = $icon === null ? 'fas fa-shopping-cart' : $icon;
  $items  = get_cart_items();

  return sprintf('<span><i class="%s"></i> <span class="badge badge-primary text-white">%s</span></span> ', $icon, $items);
}

function get_custom_zones() {
  $custom_zones = get_option('site_custom_zones');

  if(empty($custom_zones) || $custom_zones === null) {
    return false;
  }

  return (int) $custom_zones === 1;
}

function download_label($file , $new_name = null) {
  header("Content-type:application/pdf");

  // It will be called downloaded.pdf
  header("Content-Disposition:attachment;filename=".($new_name == NULL ? pathinfo($file,PATHINFO_BASENAME) : $new_name));

  // The PDF source is in original.pdf
  readfile($file);
}

function get_tracking_link($slug, $trancking_number) {
  $carriers[] = ['carrier' => 'dhl'      , 'tracking' => 'https://track.aftership.com/%s/%s'];
  $carriers[] = ['carrier' => 'fedex'    , 'tracking' => 'https://www.fedex.com/apps/fedextrack/?action=track&trackingnumber=%s&cntry_code=mx&locale=es_MX'];
  $carriers[] = ['carrier' => 'estafeta' , 'tracking' => 'https://www.estafeta.com/Herramientas/Rastreo'];
  $carriers[] = ['carrier' => 'redpack'  , 'tracking' => 'http://www.redpack.com.mx/rastreo-de-envios/'];
  $carriers[] = ['carrier' => 'ups'      , 'tracking' => 'https://www.ups.com/track?loc=es_MX&requester=ST/'];

  $couriers      = ['dhl','fedex','estafeta','mexico-redpack','ups'];
  $tracking_link = 'https://track.aftership.com/%s/%s';

  if(empty($trancking_number) || $trancking_number === null) {
    return false;
  }
  
  return sprintf($tracking_link , urlencode($slug) , urlencode($trancking_number));
}

/**
 * Regresa el status del envío actual
 *
 * @param array $status
 * @return void
 */
function get_tracking_status($status) {
  switch ($status) {
    case 'Pending':
      return 'Envío pendiente';
      break;
    case 'InfoReceived':
      return 'Información recibida';
      break;
    case 'InTransit':
      return 'Paquete en camino';
      break;
    case 'Exception':
      return 'Excepción de entrega';
      break;
    case 'OutForDelivery':
      return 'En ruta de entrega';
      break;
    case 'FailedAttempt':
      return 'Intento fallido';
      break;
    case 'Delivered':
      return 'Entregado';
      break;
    case 'Expired':
      return 'Expirado';
      break;
    default:
      return 'Envío pendiente';
  }
}

function get_tracking_image($status) {
  switch ($status) {
    ## AfterShip statuses
    case 'Pending':
      return URL.IMG.'va-shipment-pending.svg';
      break;
    case 'InfoReceived':
      return URL.IMG.'va-shipment-received.svg';
      break;
    case 'InTransit':
      return URL.IMG.'va-shipment-transit.svg';
      break;
    case 'OutForDelivery':
      return URL.IMG.'va-shipment-out.svg';
      break;
    case 'Exception':
      return URL.IMG.'va-shipment-exception.svg';
      break;
    case 'FailedAttempt':
      return URL.IMG.'va-shipment-failed.svg';
      break;
    case 'Delivered':
      return URL.IMG.'va-shipment-delivered.svg';
      break;
    case 'Expired':
      return URL.IMG.'va-shipment-expired.svg';
      break;
    default:
      return URL.IMG.'va-shipment-pending.svg';
  }
}

function get_envio_referencia($envio) {
  if(!is_array($envio)){
    $envio = (array) $envio;
  }
  
  if(!isset($envio['referencia']) || empty($envio['referencia'])){
    return false;
  }

  return trim(rtrim($envio['referencia']));
}

function get_cart_shipment_address($envio) {
  if(!is_array($envio)){
    $envio = (array) $envio;
  }

  $output = '';

  ## Remitente
  $output .= get_shipment_country_image($envio,15).' Desde '.$envio['remitente']->cp.' - '.$envio['remitente']->colonia.' - '.$envio['remitente']->ciudad.'<br>';

  ## Destinatario
  $output .= get_shipment_country_image($envio,15).' Hacia '.$envio['destinatario']->cp.' - '.$envio['destinatario']->colonia.' - '.$envio['destinatario']->ciudad;
  return $output;
}

function get_single_shipment_address($envio) {
  if(!is_array($envio)){
    $envio = (array) $envio;
  }
  
  $r = json_decode($envio['remitente']);
  $d = json_decode($envio['destinatario']);

  $output = '';

  ## Remitente
  $output .= get_shipment_country_image($envio,15).' Desde '.$r->cp.' - '.$r->colonia.' - '.$r->ciudad.'<br>';

  ## Destinatario
  $output .= get_shipment_country_image($envio,15).' Hacia '.$d->cp.' - '.$d->colonia.' - '.$d->ciudad;
  return $output;
}

function get_shipment_country_image($e , $w = 20) {
  $country = 'mexico';
  if(!is_integer($w)){
    $w = 20;
  }
  return '<img src="'.URL.IMG.'flags/mexico.png'.'" title="'.$country.'" alt="'.$country.'" style="width: '.$w.'px">';
}

function get_shipment_statuses() {
  $sts =
  [
    'Pending',
    'InfoReceived',
    'InTransit',
    'OutForDelivery',
    'Exception',
    'FailedAttempt',
    'Delivered',
    'Expired'
  ];

  return $sts;
}

function get_shipment_slug($titulo_producto) {
  $titulo_producto = strtolower($titulo_producto);

  $slugs = ['fedex','dhl','estafeta','ups','mexico-redpack'];

  switch ($titulo_producto) {
    case 'fedex':
      return 'fedex';
      break;
    case 'dhl':
      return 'dhl';
      break;
    case 'estafeta':
      return 'estafeta';
      break;
    case 'ups':
      return 'ups';
      break;
    case 'redpack':
      return 'mexico-redpack';
      break;
    default:
      return false;
      break;
  }
}

function update_all_shipment_status($envios) {
  ## Init vars
  $updated_records = 0;

  if(empty($envios) || $envios === null) {
    return false;
  }

  foreach ($envios as $e) {
    if(empty($e['tracking_id']) || $e['tracking_id'] == null) {
      logger(sprintf('Envío %s saltado para sincronización', $e['id']));
      continue;
    }

    ## Check if it exists
    $res = null;
    try {
      $as  = new AftershipHandler();
      $res = $as->get_by_id($e['tracking_id']);

      ## If it exists on Aftership
      if($res !== null) {
        $meta     = $res['meta'];
        $data     = $res['data'];
        $tracking = $data['tracking'];

        // Registro para actualizar la db
        $shipment = 
        [
          'status'           => $tracking['tag'],
          'firmado_por'      => $tracking['signed_by'],
          'peso_real'        => $tracking['shipment_weight'],
          'entregado'        => (!empty($tracking['shipment_delivery_date']) ? date('Y-m-d H:i:s', strtotime($tracking['shipment_delivery_date'])) : null),
          'entrega_estimada' => (!empty($tracking['expected_delivery']) ? date('Y-m-d H:i:s', strtotime($tracking['expected_delivery'])) : null)
        ];

        // Desde versión 2.0.0
        if($shipment['peso_real'] > $e['peso_neto']) {
          $shipment['con_sobrepeso'] = 1;
        }

        // Actualiza el registro
        if(!envioModel::update('envios', ['tracking_id' => $e['tracking_id']], $shipment)) {
          logger(sprintf('Hubo un error al actualizar el estado del envío %s con Aftership', $e['id']));
          continue;
        }
        
        // Enviar notificación de sobrepeso al usuario
        // worktodo
        $updated_records++;
      }

    } catch (Exception $e) {
      logger($e->getMessage());
      continue;
    }
  }

  return $updated_records;
}

function get_payment_image($pago_status) {
  switch ($pago_status) {
    case 'pendiente':
      return URL.IMG.'payment-pending.svg';
      break;
    
    case 'pagado':
      return URL.IMG.'payment-paid.svg';
      break;

    case 'cancelado':
      return URL.IMG.'payment-canceled.svg';
      break;

    case 'devuelto':
      return URL.IMG.'payment-refunded.svg';
      break;

    case 'en-progreso':
      return URL.IMG.'payment-progress.svg';
      break;
    
    default:
      return URL.IMG.'payment-pending.svg';
      break;
  }
}

/**
 * @deprecated 2.0.0
 *
 * @param string $status
 * @return void
 */
function get_sale_status($status) {
  switch ($status) {
    case 'pendiente':
      return 'Pendiente de entrega <i class="fa fa-spinner text-warning"></i>';
      break;
    
    case 'en-proceso':
      return 'En proceso <i class="fa fa-clock-o text-primary"></i>';
      break;

    case 'cancelada':
      return 'Cancelada <i class="fa fa-undo text-danger"></i>';
      break;

    case 'completada':
      return 'Completada <i class="fa fa-check text-success"></i>';
      break;
    
    default:
      return 'Pendiente <i class="fa fa-clock-o text-warning"></i>';
      break;
  }
}

/**
 * Requerido "metodo_pago"
 *
 * @param string $sale
 * @return void
 */
function get_payment_method_image($mp) {
  switch ($mp) {
    case 'credit_card':
    case 'debit_card':
      return URL.IMG.'mp-tarjeta.svg';
      break;

    case 'cash':
    case 'user_wallet':
    case 'efectivo':
      return URL.IMG.'mp-efectivo.svg';
      break;

    case 'transfer':
    case 'transferencia':
      return URL.IMG.'mp-transferencia.svg';
      break;
    
    default:
      return URL.IMG.'mp-desconocido.svg';
      break;
  }
}

/**
 * Se debe pasar "metodo_pago" de cada venta
 *
 * @param string $mp
 * @return void
 */
function get_payment_method_status($mp) {
  switch ($mp) {
    case 'account_money':
      return 'Dinero en cuenta MercadoPago';
      break;

    case 'bank_transfer':
    case 'transferencia':
      return 'Transferencia bancaria';
      break;
      
    case 'cash':
    case 'ticket':
    case 'efectivo':
    case 'atm':
      return 'Efectivo';
      break;

    case 'credit_card':
      return 'Tarjeta de crédito';
      break;

    case 'debit_card':
      return 'Tarjeta de débito';
      break;

    case 'prepaid_card':
      return 'Tarjeta prepagada';
      break;

    case 'mercadopago':
      return 'MercadoPago';
      break;

    case 'qr-code':
      return 'Código QR Mercado Pago';
      break;

    case 'user_wallet':
      return 'Crédito en cuenta';
      break;

    default:
      return 'Desconocido o pendiente de pago';
  }
}

/**
 * Collection_status de mercado pago
 * formateo para ingresar a la base de datos en columna
 * "pago_status"
 *
 * @param string $status
 * @return void
 */
function format_mp_status($status) {
  ## approved
  ## pending
  ## rejected
  switch ($status) {
    case 'approved':
      return 'pagado';
      break;
    case 'pending':
      return 'pendiente';
      break;
    case 'rejected':
      return 'pendiente';
      break;
    case 'canceled':
      return 'cancelado';
      break;
    case 'in_process':
      return 'en-progreso';
      break;
    case 'null':
      return 'cancelado';
      break;
    default:
      return 'pendiente';
  }
}

/**
 * Formatear el payment_type de mercado pago
 * utilizado por el comprador
 * paga guardar en la base de datos
 *
 * @param string $type
 * @return void
 */
function format_mp_payment_type($type) {
  switch ($type) {
    case 'account_money':
    case 'ticket':
    case 'paying-cash':
    case 'atm':
      return 'efectivo';
      break;
      
    case 'bank_transfer':
    case 'paying-bank-transfer':
      return 'transferencia';
      break;

    case 'paying-mercadopago':
      return 'mercadopago';
      break;

    case 'credit_card':
      return 'credit_card';
      break;

    case 'debit_card':
      return 'debit_card';
      break;

    case 'prepaid_card':
      return 'prepaid_card';
      break;

    case 'paying-qr-code':
      return 'qr-code';
      break;

    case 'paying_user_wallet':
      return 'user_wallet';

    default:
      return 'desconocido';
  }
}