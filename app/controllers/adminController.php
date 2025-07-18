<?php 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class adminController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    if(!is_worker(get_user_role())){
      Flasher::access();
      Taker::back('dashboard');
    }
  }

  public function index()
  {
    // Gráfica de ventas anuales
    $chart = new ChartJSHandler('chartjs_ventas', 'bar');
    $chart->label = 'Ventas';
    $chart->set_border_w(1);
    $chart->set_border_color('black');
    $ventas_stats = statModel::by_month(12, 'ventas', 'creado');
    foreach ($ventas_stats as $venta) {
      $chart->add_set($venta['xkey'], $venta['ykeys']);
    }
    GraphHandler::register($chart->create());

    // Gráfica de envíos mensuales
    $chart = new ChartJSHandler('chartjs_envios', 'bar');
    $chart->label = 'Envíos';
    $chart->set_border_w(1);
    $chart->set_border_color('black');
    $ventas_stats = statModel::by_month(12, 'envios', 'creado');
    foreach ($ventas_stats as $envio) {
      $chart->add_set($envio['xkey'], $envio['ykeys']);
    }
    GraphHandler::register($chart->create());

    // Gráfica de USUARIOS registrados mensualmente
    $chart = new ChartJSHandler('chartjs_usuarios', 'bar');
    $chart->label = 'Usuarios registrados';
    $chart->set_border_w(1);
    $chart->set_border_color('black');
    $ventas_stats = statModel::by_month(12, 'usuarios', 'created_at');
    foreach ($ventas_stats as $u) {
      $chart->add_set($u['xkey'], $u['ykeys']);
    }
    GraphHandler::register($chart->create());

    // Ingresos mensuales
    $chart = new ChartJSHandler('chartjs_ingresos', 'bar');
    $chart->label = 'Ingresos mensuales';
    $chart->set_border_w(1);
    $chart->set_border_color('black');
    $ventas_stats = statModel::sum_by_month(12, 'ventas', 'creado', 'total');
    foreach ($ventas_stats as $u) {
      $chart->add_set($u['xkey'], $u['ykeys']);
    }
    GraphHandler::register($chart->create());

    $this->data =
    [
      'title' => 'Administración'
    ];

    View::render('index',$this->data,true);
  }

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Envíos
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  public function envios_index()
  {
    $this->data =
    [
      'title' => 'Todos los envíos',
      'e'     => envioModel::all()
    ];

    View::render('envios/index', $this->data);
  }

  /**
   * Ver un envío de forma individual
   *
   * @param integer $id
   * @return void
   */
  public function envios_ver($id)
  {
    if(!$envio = envioModel::by_id($id)){
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Viendo envío',
      'e'     => $envio,
      'r'     => json_decode($envio['remitente']),
      'd'     => json_decode($envio['destinatario'])
    ];

    View::render('envios/single', $this->data);
  }

  /**
   * Ver formulario de actualizar para envío
   *
   * @param integer $id
   * @return void
   */
  function envios_actualizar($id)
  {
    if(!$envio = envioModel::by_id($id)){
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Actualizando envío',
      'e'     => $envio,
      'r'     => json_decode($envio['remitente']),
      'd'     => json_decode($envio['destinatario'])
    ];

    View::render('envios/actualizar', $this->data);
  }

  /**
   * Procesar el formulario de actualizar envío
   *
   * @return void
   */
  function envios_update()
  {
    if(!check_posted_data(['csrf','id','status','descripcion','paq_alto','paq_ancho','paq_largo','peso_neto','peso_real'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    $id        = (int) $_POST['id'];
    if(!$envio = envioModel::by_id($id)){
      Flasher::not_found('envío');
      Taker::back();
    }
    
    $paq_alto   = unmoney($_POST['paq_alto']);
    $paq_ancho  = unmoney($_POST['paq_ancho']);
    $paq_largo  = unmoney($_POST['paq_largo']);
    $peso_vol   = (float) $paq_alto * $paq_ancho * $paq_largo / 5000;
    $peso_real  = unmoney($_POST['peso_real']);
    $peso_neto  = unmoney($_POST['peso_neto']);
    $overweight = $envio['capacidad'] < $peso_real || $envio['capacidad'] < $peso_vol ? true : false;

    try {
      // Iniciar actualización de envío
      $shipment = 
      [
        //'tracking_id'    => str_replace(' ','',clean($_POST['tracking_id'])),
        //'num_guia'       => str_replace(' ','',clean($_POST['num_guia'])),
        'status'         => $_POST['status'],
        'descripcion'    => clean($_POST['descripcion']),
        'paq_alto'       => $paq_alto,
        'paq_ancho'      => $paq_ancho,
        'paq_largo'      => $paq_largo,
        'peso_neto'      => $peso_neto,
        'peso_vol'       => $peso_vol,
        'peso_real'      => $peso_real,
        'con_sobrepeso'  => $overweight ? 1 : 0
      ];
  
      ## Update shipment
      if(!envioModel::update('envios', ['id' => $id], $shipment)) {
        Flasher::updated('envío', false);
        Taker::back();
      }

      if($overweight) {
        Flasher::save(sprintf('El paquete ha generado un sobrepeso al superar el peso amparado de <b>%s kg</b>', $envio['capacidad']), 'danger');
      }

      Flasher::updated('envío');
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  /**
   * Fomrulario para adjuntar guía de envío a pedido
   *
   * @param integer $id
   * @return void
   */
  function envios_adjuntar_guia($id)
  {
    if(!$envio = envioModel::by_id($id)){
      Flasher::not_found('envío');
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Viendo envío',
      'e'     => $envio,
      'r'     => json_decode($envio['remitente']),
      'd'     => json_decode($envio['destinatario'])
    ];

    View::render('envios/adjuntarGuia', $this->data);
  }

  /**
   * Proceso del formulario para adjuntar guía de envío
   *
   * @return void
   */
  function envios_adjuntar_guia_process()
  {
    if(!check_posted_data(['id','csrf','num_guia'], $_POST) || !validate_csrf($_POST['csrf'])){
      Flasher::access();
      Taker::back();
    }

    $file = multiUpload($_FILES['adjunto'])[0];
    if(!$file){
      Flasher::save('Hubo un error al subir el archivo seleccionado.', 'danger');
      Taker::back();
    }

    ## Checar que sea pdf
    if(!in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['pdf','PDF'])){
      Flasher::save('Selecciona un archivo <b>pdf</b> válido por favor.', 'danger');
      Taker::back();
    }

    // Guardar el archivo en el servidor
    try {
      $id       = (int) $_POST['id'];
      $num_guia = str_replace(' ','',clean($_POST['num_guia']));
      
      // Validar que exista el envío en la base de datos
      if(!$envio = envioModel::by_id($id)){
        Flasher::not_found('envío');
        Taker::back();
      }

      $uploader = new Uploader($file, get_system_name().'Label-'.generate_filename());
      $uploader->setUploadPath(UPLOADS);
      $pdf_name = $uploader->original();
      $uploader->clean();

      // Actualizar el registro
      if(!envioModel::update('envios', ['id' => $id], ['adjunto' => $pdf_name, 'num_guia' => $num_guia])){
        Flasher::updated('envío',false);
        Taker::back();
      }

      // Enviar notificación a usuario
      $envio = envioModel::by_id($id);
      $email = new envioMailer($envio);
      if($email->label_ready('usuario')){
        Flasher::email_to('usuario');
      }

      Flasher::updated('envío');
      Taker::back();

    } catch (LumusException $e){
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  /**
   * Actualizar el status de un envío
   *
   * @param integer $id
   * @return void
   */
  function envios_cambiar_status($id)
  {
    if(!$envio = envioModel::by_id($id) || !isset($_GET['status'])){
      Flasher::access();
      Taker::back();
    }

    $status_validos = get_shipment_statuses();
    $status         = $_GET['status'];

    if(!in_array($status , $status_validos)){
      Flasher::access();
      Taker::back();
    }

    if(!envioModel::update('envios',['id' => $id],['status' => $status])){
      Flasher::updated('envío',false);
      Taker::back();
    }

    Flasher::updated('envío');
    Taker::back();
  }

  /**
   * Descargar la guía de envío de un pedido
   *
   * @param integer $id
   * @return void
   */
  function envios_print_label($id)
  {
    if(!$envio = envioModel::by_id($id)){
      Flasher::access();
      Taker::back();
    }

    if(!isset($_GET['label'],$_GET['nonce'])){
      Flasher::access();
      Taker::back();
    }

    if(strlen($_GET['nonce']) !== 20){
      Flasher::access();
      Taker::back();
    }

    $file = $_GET['label'];

    if(!is_file(UPLOADS.$file)){
      Flasher::save(sprintf('La guía solicitada %s no existe o está dañada.',$file),'danger');
      Taker::back();
    }

    download_label(UPLOADS.$file);
  }

  /**
   * Reenviar notificación de pedido o envío
   *
   * @return void
   */
  function envios_enviar_notificacion()
  {
    if(!isset($_POST,$_POST['id'],$_POST['tipo_notificacion'])){
      Flasher::access();
      Taker::back();
    }

    $id = $_POST['id'];

    if(!$envio = envioModel::by_id($id)){
      Flasher::access();
      Taker::back();
    }

    ## Enviar notificación a usuario
    switch ($_POST['tipo_notificacion']) {
      case 'label-ready':
        $email = new envioMailer($envio);
        if(!$email->label_ready('usuario')){
          Flasher::email_to('usuario',false);
        } else {
          Flasher::email_to('usuario');
        }
        break;
      
      case 'new-order':
        $venta = ventaModel::by_id($envio['venta_id']);
        $email = new compraMailer($venta);
        if(!$email->nueva_compra('usuario')){
          Flasher::email_to('usuario',false);
        } else {
          Flasher::email_to('usuario');
        }
        break;

      case 'payment-pending':
        $venta = ventaModel::by_id($envio['venta_id']);
        $email = new compraMailer($venta);
        if(!$email->payment_pending('usuario')){
          Flasher::email_to('usuario',false);
        } else {
          Flasher::email_to('usuario');
        }
        break;
      
      case 'payment-approved':
        $venta = ventaModel::by_id($envio['venta_id']);
        $email = new compraMailer($venta);
        if(!$email->compra_pagada('usuario')){
          Flasher::email_to('usuario',false);
        } else {
          Flasher::email_to('usuario');
        }
        break;
      
      case 'payment-canceled':
        $venta = ventaModel::by_id($envio['venta_id']);
        $email = new compraMailer($venta);
        if(!$email->payment_canceled('usuario')){
          Flasher::email_to('usuario',false);
        } else {
          Flasher::email_to('usuario');
        }
        break;

      case 'payment-refunded':
        $venta = ventaModel::by_id($envio['venta_id']);
        $email = new compraMailer($venta);
        if(!$email->payment_refunded('usuario')){
          Flasher::email_to('usuario',false);
        } else {
          Flasher::email_to('usuario');
        }
        break;
      
      default:
        Flasher::save('Selecciona una opción válida.','danger');
        break;
    }

    Taker::back();
  }

  /**
   * Solicitar generación de guía de envío
   *
   * @param integer $id
   * @return void
   */
  function envios_solicitar_generacion($id)
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    if(!$envio = envioModel::by_id($id)) {
      Flasher::not_found('Envío', false);
      Taker::back();
    }

    ## Revisar si ya fue solicitado con anterioridad
    if((int) $envio['solicitado'] == 1) {
      Flasher::save('La solicitud ya ha sido enviada anteriormente.', 'warning');
    }

    // Notificación de creación de envío
    $to    = get_smtp_email();
    $email = new envioMailer($envio);

    if(!$email->solicitar_generacion()){
      Flasher::email_to($to, false);
    } else {
      Flasher::email_to($to);
      envioModel::update('envios', ['id' => $id], ['solicitado' => 1]);
    }

    Taker::back();
  }

  /**
   * Formulario de cargo por sobre peso
   *
   * @param integer $id
   * @return void
   */
  function envios_sobrepeso($id)
  {
    if(!$envio = envioModel::by_id($id)){
      Flasher::not_found('envío');
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Agregar cargo por sobrepeso',
      'e'     => $envio,
      'r'     => json_decode($envio['remitente']),
      'd'     => json_decode($envio['destinatario'])
    ];

    View::render('envios/cargoSobrepeso', $this->data);
  }

  /**
   * Procesar el formulario de sobre peso de envíos
   *
   * @return void
   */
  function post_sobrepeso()
  {
    if(!check_posted_data(['id','csrf','importe'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    // Validar la existencia del registro
    $id  = (int) $_POST['id'];
    
    if(!$envio = envioModel::by_id($id)){
      Flasher::not_found('envío');
      Taker::back();
    }

    // Validar que en efecto haya un sobrepeso generado
    if((int) $envio['con_sobrepeso'] !== 1) {
      Flasher::save(sprintf('El <b>envío #%s</b> no tiene un sobrepeso registrado, no podemos crear el cargo', $id), 'danger');
      Taker::back();
    }

    // Validar que no exista ya una transacción
    if($envio['t_id'] !== null || !empty($envio['t_id'])) {
      Flasher::save(sprintf('Ya existe un cargo creado para el <b>envío #%s</b>, no podemos volver a crearlo', $id), 'danger');
      Taker::back();
    }

    // Validar el estado de la transacción si ésta existe
    if($envio['t_status'] === 'pagada') {
      Flasher::save(sprintf('Ya existe un cargo <b>pagado</b> por sobrepeso de <b>%s</b> para el <b>envío #%s</b>', money($envio['t_total'], '$'), $id), 'danger');
      Taker::back();
    }

    // Validar que en efecto exista un sobrepeso
    $peso_max  = $envio['peso_neto'] >= $envio['peso_vol'] ? $envio['peso_neto'] : $envio['peso_vol'];
    $peso_real = $envio['peso_real'];

    // El peso neto registrado es menor a la capacidad significa que está dentro del margen y no hay sobrepeso real
    // Si el peso volumétrico calculado es menor a la capacidad no hay sobrepeso real
    // Ver peso neto / volumétrico y real VS capacidad del envío
    if($peso_max < $envio['capacidad'] && $peso_real < $envio['capacidad']) {
      Flasher::save('Este envío no ha generado un sobrepeso, no podemos crear la transacción', 'danger');
      Taker::back();
    }

    // Crear la transacción
    try {
      // Insertar transacción y deducción de saldo
      $id_transaccion        = null;
      $saldo_disponible      = get_user_saldo('saldo');
      $total                 = (float) unmoney($_POST['importe']);

      $trans                 = new transaccionModel;
			$trans->tipo           = 'cargo_sobrepeso_saldo';
			$trans->detalle        = sprintf('Cargo por sobrepeso para el envío %s de un monto %s', $id, money($total, '$'));
			$trans->referencia     = sprintf('Envío #%s', $id);
      $trans->id_usuario     = $envio['id_usuario'];
      $trans->tipo_ref       = 'envio';
      $trans->id_ref         = $id;
			$trans->status         = 'pendiente';
			$trans->status_detalle = get_payment_status($trans->status);
			$trans->metodo_pago    = 'user_wallet';
			$trans->descripcion    = 'Nueva transacción';
			$trans->subtotal       = $total / 1.16;
			$trans->impuestos      = ($total / 1.16) * 0.16;
			$trans->total          = $total;
	
      // Si el cobro falla se solicitará el pago al usuario
			if(!$id_transaccion = $trans->agregar()) {
        logger(sprintf('Hubo un error en el pago para el sobrecargo del envío %s', $id));
        throw new PDOException('Hubo un problema al realizar la transacción, intenta de nuevo por favor');
      }

      // Notificación al usuario de nuevo sobrepeso generado
      $envio = envioModel::by_id($id);
      $email = new envioMailer($envio);
		  if($email->cargo_sobrepeso()) {
        Flasher::save('Ya le informamos al usuario sobre el cargo a pagar, ¡sigue así!');
      }
  
      // Retorno
      Flasher::save(sprintf('Transacción creada con éxito, hemos creado un cargo a pagar por un monto de <b>%s</b> por sobrepeso en el <b>envío #%s</b>', money($total, '$'), $id));
      Taker::to(sprintf('admin/envios-ver/%s', $id));

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // cobertura de couriers
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  function cobertura()
  {
    if(!get_custom_zones()) {
      Flasher::save('El uso de coberturas personalizadas está desactivado', 'danger');
      Taker::back();
    }
    
    $this->data =
    [
      'title'    => 'Cobertura de couriers',
      'couriers' => courierModel::all()
    ];

    View::render('cobertura/agregar', $this->data);
  }

  /**
   * Procesar la subida de corberturas personalizadas
   *
   * @return void
   */
  function post_cobertura()
  {
    if(!check_posted_data(['id_courier','csrf'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    $id_courier = (int) clean($_POST['id_courier']);
    $file       = $_FILES['csv_coberturas'];

    if($id_courier === '' || $id_courier === null) {
      Flasher::save('Selecciona un courier válido por favor', 'danger');
      Taker::back();
    }

    if($file['error'] === 4) {
      Flasher::save('Por favor, selecciona un archivo CSV válido e intenta de nuevo', 'danger');
      Taker::back();
    }
      
    // Inicia proceso para soportar más de 50 mil registros
    ini_set('memory_limit', '256M');

    $csv_file    = $file['tmp_name'];

    /** Create a new Xls Reader  **/
    $reader      = new Csv();
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($csv_file);
    $csv_data    = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
    if(empty($csv_data)) {
      Flasher::save('El archivo CSV no tiene información válida, intenta de nuevo', 'danger');
      Taker::back();
    }
    
    // Quitar primer columna para reformateo
    unset($csv_data[1]);
    $rows     = count($csv_data);
		$start    = time();
    $data     = [];
    $cps      = [];
    $skipped  = 0;

    // Validar el courier actual
    if((int) $csv_data[2]['A'] !== $id_courier) {
      Flasher::save('El courier seleccionado y el del documento no son el mismo, intenta de nuevo', 'danger');
      Taker::back();
    }

    Flasher::save('Se ha eliminado la primer fila del documento con éxito, no es necesaria');
    Flasher::save(sprintf('El documento tiene <b>%s</b> registros para insertar en la base de datos', $rows));

    // Parseando la información
    // Estructura general del CSV
    // [A] => COURIER
    // [B] => CP
    // [C] => TIPO_SERVICIO
    // [D] => ZONA EXTENDIDA
    // [E] => RECOLECCION
    // [F] => CARGO
    // Validar que el courier seleccionado sea el mismo que el del documento

		foreach ($csv_data as $row) {
      // Parseando información para validación
      $cp              = clean($row['B']);
      $cp              = strlen($cp) == 4 ? '0'.$cp : $cp;

      $tipo_servicio   = clean($row['C']);
      $tipo_servicio   = is_numeric($tipo_servicio) ? (int) $tipo_servicio : strtolower($tipo_servicio);
      $tipos_regular   = ['económico','eco','regular','normal','economico'];
      $tipos_express   = ['express','exp','EXP','expres','xpress','xpres','expresss'];
      $servicio_valido = false;

      $zona_extendida  = (int) clean($row['D']);
      $zona_extendida  = !in_array($zona_extendida, [1, 0]) ? 0 : $zona_extendida;

      $recoleccion     = (int) clean($row['E']);
      $recoleccion     = !in_array($recoleccion, [1, 0]) ? 1 : $recoleccion;

      $cargo           = (float) clean($row['F']);
      $cargo           = (float) unmoney($cargo);

      // Validar longitud del cp, no más de 5 y si es de 4 números, se agrega el 0 al inicio para códigos postales con inicio 0
      if(strlen($cp) > 5) {
        $skipped++;
        continue;
      }

      // Validar que no exista el CP solicitado
      if(in_array($cp, $cps)) {
        $skipped++;
        continue;
      }
      
      // Validar el tipo de servicio regular
      if(in_array($tipo_servicio, $tipos_regular)) {
        $servicio_valido = true;
        $tipo_servicio   = 'eco';
      }
      
      if(in_array($tipo_servicio, $tipos_express)) {
        $servicio_valido = true;
        $tipo_servicio   = 'exp';
      }
      
      if(is_integer($tipo_servicio)) {
        $servicio_valido = in_array($tipo_servicio, [1, 0]);
        $tipo_servicio   = $tipo_servicio === 1 ? 'exp' : 'eco';
      }
      
      if($servicio_valido === false) {
        $skipped++;
        continue;
      }
      
      // Validar si es zona extendida no puede ser servicio express
      // Recordar que si tiene servicio express, entonces cuenta con servicio económico
      // Si es zona extendida no puede contar con servicio express
      if($zona_extendida === 1 && $tipo_servicio === 'exp') {
        $tipo_servicio = 'eco';
      }
      
      $data[] = 
      [
        'id_courier'     => $id_courier, 
        'cp'             => $cp,
        'tipo_servicio'  => $tipo_servicio,
        'zona_extendida' => $zona_extendida, 
        'recoleccion'    => $recoleccion, 
        'cargo'          => $cargo, 
        'creado'         => ahora()
      ];
      $cps[] = $cp;
    }

    try {
      // Borrado de coverturas anteriores
      $sql         = 'SELECT COUNT(id) AS total FROM shippr_zonas WHERE id_courier = :id_courier';
      $total_found = envioModel::query($sql, ['id_courier' => $id_courier])[0];
      $total_found = $total_found['total'];
      if($total_found > 0) {
        Flasher::save(sprintf('Encontramos <b>%s</b> registros anteriores, borrando...', $total_found));
        $sql = 'DELETE FROM shippr_zonas WHERE id_courier = :id_courier';
        if(envioModel::query($sql, ['id_courier' => $id_courier])) {
          Flasher::save('Registros anteriores borrados con éxito, insertando nuevos...');
        }
      }
      
      // Actualizado
      // break data into max size of 200
      $chunks = array_chunk($data, 1000);
  
      foreach ($chunks as $chunk) {
        $batch = envioModel::batch('shippr_zonas', $chunk, array_keys($data[0]));
      }
      //$batch = envioModel::batch('shippr_zonas', $data, ['cp','servicio','creado']);
  
      $end = time();
      if($skipped > 0) {
        Flasher::save(sprintf('%s registros omitidos y no insertados en la base de datos', $skipped), 'info');
      }
      Flasher::save(sprintf('Se han insertado <b>%s</b> registros en <b>%s</b> segundos', $rows - $skipped, $end - $start));
      Taker::back();
  
    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  /**
   * Descarga la template para cobertura personalizada
   *
   * @return void
   */
  public function template_cobertura()
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    Taker::to('shippr2.1.0.csv');
  }

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Ventas en general
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  function ventas_index()
  {
    $ventas = ventaModel::all();
    $this->data =
    [
      'title' => 'Todas las ventas',
      'v' => $ventas
    ];
    View::render('ventas/index',$this->data);
  }

  /**
   * Ver listado de ventas
   *
   * @param string $folio
   * @return void
   */
  function ventas_ver($folio)
  {
    if(!$venta = ventaModel::by_folio($folio)) {
      Flasher::access();
      Taker::back();
    }

    $this->data = 
    [
      'title' => 'Venta #'.$venta['folio'],
      'v' => $venta
    ];
    View::render('ventas/single',$this->data);
  }

  /**
   * Actualizar venta
   *
   * @param string $folio
   * @return void
   */
  function ventas_actualizar($folio)
  {
    if(!$venta = ventaModel::by_folio($folio)) {
      Flasher::access();
      Taker::back();
    }

    $this->data =
    [
      'title' => 'Actualizando venta #'.$venta['folio'],
      'v'     => $venta
    ];

    View::render('ventas/actualizar',$this->data);
  }

  /**
   * Proceso actualizar venta
   *
   * @return void
   */
  function ventas_update()
  {
    if(!isset($_POST)) {
      Flasher::access();
      Taker::back();
    }

    if(!ventaModel::update('ventas', ['id' => intval($_POST['id'])], $_POST['data'])) {
      Flasher::updated('venta',false);
      Taker::back();
    }

    Flasher::updated('venta');
    Taker::back();
  }

  /**
   * Buscar pago con mercado pago
   * @deprecated 2.0.0
   * @return void
   */
  function ventas_buscar_pago()
  {
    Taker::back();
    $filters = [];
    if(isset($_GET['id'])) {
      $filters['id'] = $_GET['id'];
    }

    if(isset($_GET['external_reference'])) {
      $filters['external_reference'] = $_GET['external_reference'];
    }

    if(isset($_GET['collection_id'])) {
      $filters['collection_id'] = $_GET['collection_id'];
    }

    if(isset($_GET['merchant_order_id'])) {
      $filters['merchant_order_id'] = $_GET['merchant_order_id'];
    }

    if(isset($_GET['preference_id'])) {
      $filters['preference_id'] = $_GET['preference_id'];
    }

    $payments = new PaymentHandler();
    $pagos = $payments->search($filters);
    print_r($pagos);
    die;

    $this->data =
    [
      'title' => 'Buscar pagos',
      'pagos' => $pagos
    ];
    View::render('ventas/pagos',$this->data);
  }

  function ventas_cambiar_status($id)
  {
    try {
      if(!$venta = ventaModel::by_id($id)){
        Flasher::access();
        Taker::back();
      }

      $status = clean($_GET['status']);
      $status_validos =
      [
        'pendiente',
        'en-proceso',
        'completada',
        'cancelada'
      ];
  
      if(!in_array($status , $status_validos)){
        Flasher::access();
        Taker::back();
      }

      // Si el estado es completado no debería poder cambiar ya
      if($venta['status'] === 'completada') {
        throw new PDOException('Esta venta ya ha sido completada, no podemos cambiar su estado');
      }
  
      if(!ventaModel::update('ventas', ['id' => $id], ['status' => $status])){
        Flasher::updated('venta',false);
        Taker::back();
      }

      // Si la venta cambia a cancelada
      if($status === 'cancelada') {
        // El pago deberá ser reembolsado
        $devolucion                 = new transaccionModel();
        $devolucion->tipo           = 'devolucion_saldo';
        $devolucion->detalle        = sprintf('Devolución por %s MXN en compra realizada %s', money($venta['total'], '$'), $venta['folio']);
        $devolucion->tipo_ref       = 'compra';
        $devolucion->id_ref         = $venta['id'];
        $devolucion->referencia     = $venta['folio'];
        $devolucion->id_usuario     = $venta['id_usuario'];
        $devolucion->status         = 'pagado';
        $devolucion->status_detalle = get_payment_status($devolucion->status);
        $devolucion->metodo_pago    = 'user_wallet';
        $devolucion->descripcion    = 'Nueva devolución';
        $devolucion->subtotal       = $venta['total'] / 1.16;
        $devolucion->impuestos      = ($venta['total'] / 1.16) * 0.16;
        $devolucion->total          = $venta['total'];

        // Si el cobro falla se solicitará el pago al usuario
        if(!$id_devolucion = $devolucion->agregar()) {
          logger(sprintf('Hubo un error en la devolución para la venta %s', $venta['id']));
          throw new PDOException('Hubo un problema al realizar la devolución');
        }

        Flasher::save(sprintf('Hemos devuelto un saldo de <b>%s</b> al usuario', money($devolucion->total, '$')));

        if(!ventaModel::update('ventas', ['id' => $venta['id']], ['pago_status' => 'devuelto'])){
          throw new PDOException(sprintf('Hubo un problema al cambiar el estado del pago de la venta <b>%s</b> a devuelto', $venta['folio']));
        }

        Flasher::save('Hemos actualizado el estado del pago de la venta a <b>Devuelto</b>');
      }
      
      Flasher::updated('venta');
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  function ventas_pago_status($id)
  {
    if(!$venta = ventaModel::by_id($id) || !isset($_GET['status'])){
      Flasher::access();
      Taker::back();
    }

    $status = $_GET['status'];

    $status_validos =
    [
      'pendiente',
      'en-progreso',
      'pagado',
      'cancelado',
      'devuelto'
    ];

    if(!in_array($status , $status_validos)){
      Flasher::access();
      Taker::back();
    }

    if(!ventaModel::update('ventas',['id' => $id],['pago_status' => $status])){
      Flasher::updated('estado del pago',false);
      Taker::back();
    }

    Flasher::updated('estado del pago');
    Taker::back();
  }

  function ventas_borrar($id)
  {
    if(!$venta = ventaModel::by_id($id)){
      Flasher::not_found('Venta');
      Taker::back();
    }

    $ventas = 0;
    $envios = 0;

    ## Borrar la venta
    if(!ventaModel::remove('ventas' , ['id' => $id])) {
      Flasher::deleted('venta',false);
      Taker::back();
    }

    $ventas++;
    Flasher::save(sprintf('%s venta borrada con éxito',$ventas));

    ## Borrar los envíos relacionados
    foreach ($venta['items'] as $v) {
      if(envioModel::remove('envios', ['id' => $v['id']])) {
        $envios++;
      } else {
        Flasher::save(sprintf('El envío con ID %s no pudo ser borrado',$v['id']),'danger');
      }
    }

    ## Regresar
    Flasher::save(sprintf('%s '.($envios > 1 ? 'envíos borrados': 'envío borrado' ).' con éxito', $envios));
    Taker::back();
  }

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Usuarios en general
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  function usuarios_index()
  {
    $this->data =
    [
      'title'    => 'Todos los usuarios',
      'usuarios' => usuariosModel::all_regular()
    ];
    View::render('usuarios/index',$this->data);
  }

  function usuarios_ver($id)
	{
		if (!$usuario = usuariosModel::by_id($id)) {
			Flasher::not_found('usuario');
			Taker::back();
		}

    $this->data =
    [
      'title'   => 'Usuario '.$usuario['nombre'],
      'usuario' => $usuario
    ];

		View::render('usuarios/single' , $this->data);
  }

  function usuarios_modificar($id)
	{
		if (!is_admin(get_user_role())) {
			Flasher::access();
			Taker::back();
		}

		if($id == get_user_id()){
			Taker::to('usuarios/perfil');
		}

		$user = new usuariosModel();
		if(!$u = $user->find($id)){
			Flasher::not_found('usuario');
			Taker::back();
		}

		$roles = new rolesModel();
		$roles = $roles->all();

		$this->data =
		[
			'title'   => 'Editando '.$u['nombre'],
			'usuario' => $u
		];

		View::render('usuarios/modificar', $this->data , true);
	}

	function usuarios_modificar_submit()
	{
		if(!is_admin(get_user_role()) || !isset($_POST)){
			Flasher::action();
			Taker::to('dashboard');
		}

		// Información a actualizar
		// Dependiendo si hay imágenes o no
		$id   = (int) $_POST['id_usuario'];
		$data =
		[
			'usuario' => clean($_POST['usuario']),
			'nombre'  => clean($_POST['nombre']),
			'email'   => clean($_POST['email'])
		];

		if ($_POST["auto_password"] === "si") {
			$new_password     = randomPassword();
			$data['password'] = password_hash($new_password.SITESALT , PASSWORD_BCRYPT);
		}

		/** Updating user information */
		if(!usuariosModel::update('usuarios', ['id_usuario' => $_POST['id_usuario']], $data)){
			Flasher::updated('usuario',false);
			Taker::back();
		}

		$usuario = usuariosModel::list('usuarios' , ['id_usuario' => $id])[0];
		$usuario['unhashed'] = (isset($new_password) ? $new_password : null);
		
		// Enviar mensaje con los datos del usuario
		$email = new usuarioMailer($usuario);
		if(!$email->modificado()){
			Flasher::email_to('system' , false);
    }else{
			Flasher::email_to('system');
		}

		if(!$email->modificado('usuario')){
			Flasher::email_to('usuario' , false);
    }else{
			Flasher::email_to('usuario');
		}
		
		Flasher::updated('usuario');
		Taker::back();
	}

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Productos Administración
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  function productos_index()
  {
    $productos = productoModel::all();
    $this->data =
    [
      'title' => 'Todos los productos',
      'p'     => $productos
    ];
    View::render('productos/index',$this->data);
  }

  function productos_ver($id)
  {
    if(!$producto = productoModel::by_id($id)) {
      Flasher::not_found('Producto', false);
      Taker::back();
    }

    $this->data =
    [
      'title'    => 'Viendo producto',
      'producto' => $producto
    ];

    View::render('productos/single', $this->data);
  }

  function productos_agregar()
  {
    $this->data =
    [
      'title'    => 'Agregar nuevo producto',
      'couriers' => courierModel::all()
    ];

    View::render('productos/agregar', $this->data);
  }

  function productos_store()
  {
    if(!check_posted_data(['sku','id_courier','capacidad','tipo_servicio','tiempo_entrega','precio','csrf'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    try {
      $producto                   = new productoModel;
      $producto->sku              = $_POST['sku'];
      $producto->id_courier       = $_POST['id_courier'];
      $producto->capacidad        = $_POST['capacidad'];
      $producto->tipo_servicio    = $_POST['tipo_servicio'];
      $producto->tiempo_entrega   = $_POST['tiempo_entrega'];
      $producto->precio           = unmoney($_POST['precio']);
      $producto->precio_descuento = $producto->precio;
      $producto->publicado        = 1;

      if(!$id = $producto->agregar()) {
        Flasher::added('Producto', false);
      } else {
        Flasher::added('Producto');
      }

      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  function productos_actualizar($id)
  {
    if(!$producto = productoModel::by_id($id)) {
      Flasher::not_found('Producto', false);
      Taker::back();
    }

    $this->data =
    [
      'title'    => 'Actualizando producto',
      'p'        => $producto,
      'couriers' => courierModel::all()
    ];

    View::render('productos/actualizar', $this->data);
  }

  function productos_update()
  {
    if(!check_posted_data(['id','sku','id_courier','capacidad','tipo_servicio','tiempo_entrega','precio','csrf'], $_POST) || !validate_csrf($_POST['csrf'])) {
      Flasher::access();
      Taker::back();
    }

    try {
      $producto                   = new productoModel;
      $producto->id               = $_POST['id'];
      $producto->sku              = $_POST['sku'];
      $producto->id_courier       = $_POST['id_courier'];
      $producto->capacidad        = $_POST['capacidad'];
      $producto->tipo_servicio    = $_POST['tipo_servicio'];
      $producto->tiempo_entrega   = $_POST['tiempo_entrega'];
      $producto->precio           = unmoney($_POST['precio']);
      $producto->precio_descuento = $producto->precio;

      if(!$producto->actualizar()) {
        Flasher::updated('Producto', false);
      } else {
        Flasher::updated('Producto');
      }

      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  function productos_cambiar_status()
  {
    if(!check_get_data(['_t', 'status', 'id'], $_GET)) {
      Flasher::access();
      Taker::back();
    }

    if(!validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    $id     = (int) $_GET['id'];
    $status = (int) $_GET['status'];

    try {
      if(!productoModel::update('productos', ['id' => $id], ['publicado' => $status])) {
        Flasher::save('El estado del producto no pudo ser actualizado, intenta de nuevo', 'danger');
      } else {
        Flasher::save('El estado del producto ha sido actualizado');
      }

      Taker::back();
    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }

  }

  function productos_borrar($id)
  {
    if(!check_get_data(['_t'], $_GET)) {
      Flasher::access();
      Taker::back();
    }

    if(!validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    try {
      if(!productoModel::remove('productos', ['id' => $id], 1)) {
        Flasher::deleted('Producto', false);
        Taker::back();
      }

      Flasher::deleted('Producto');
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Avisos
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  function avisos_index()
  {
    $avisos     = avisoModel::all();
    $this->data =
    [
      'title' => 'Todos los avisos',
      'avisos' => $avisos
    ];

    View::render('avisos/index',$this->data);
  }

  function avisos_agregar()
  {
    $this->data =
    [
      'title' => 'Agregar aviso'
    ];

    View::render('avisos/agregar',$this->data);
  }

  function crear_aviso_masivo()
  {
    register_styles(['https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.css'] , 'Summernote');
		register_scripts(['https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-lite.js' , 'Summernote']);
    
    $this->data =
    [
      'title' => 'Crear aviso masivo'
    ];

    View::render('avisos/masivo',$this->data);
  }

  function enviar_aviso_masivo()
  {
    ## Si se enviará a un usuario en específico o varios / empty es todos
    $files_to_send = null;
    $_addr         = usuariosModel::all_regular();

    if(empty($_addr)) {
      Flasher::save('No hay destinatarios para enviar el aviso');
      Taker::back();
    }

    ## Adjuntos
    if($files = multiUpload($_FILES['adjuntos'])){
      foreach ($files as $a) {
        try {
          $uploader = new Uploader($a);
          $uploader->original();
          $files_to_send[] = UPLOADS.$uploader->get_new_name();
          $uploader->clean();
        } catch (LumusException $e){
          Flasher::error();
          Flasher::save($e->getMessage(), 'danger');
          Taker::back();
        }
      }
    }

    ## Inicialización de contadores
    $users    = count($_addr);
    $sent     = 0;
    $not_sent = 0;    

    foreach ($_addr as $usuario) {
      if(!is_local() && $usuario['email'] == 'jslocal@localhost.com') {
        break;
      }
      
      $email = new Mailer();
      $email->setFrom(get_noreply_email(), get_sitename());
      $email->addAddress($usuario['email']);
      $email->setSubject(get_email_sitename().' '.(empty($_POST['subject']) ? 'Tienes un nuevo mensaje' : clean($_POST['subject'])));

      ## Sólo si hay adjuntos que enviar
      if(!empty($files_to_send)) {
        foreach ($files_to_send as $f) {
          $email->add_attachment($f);
        }
      }
  
      $data =
      [
        'title' => clean($_POST['subject']),
        'body'  => $_POST['body']
      ];
      
      $body = new MailerBody(get_email_template(), $data);
      $body = $body->parseBody()->getOutput();
      $email->setBody($body);

      if(!$email->send()){
        $not_sent++;
      } else {
        $sent++;
      }
      $email = null;
    }

    Flasher::save('Mensajes enviados con éxito: '.$sent.'/'.$users);
    if($not_sent > 0) {
      Flasher::save('Mensajes no enviados: '.$not_sent, 'danger');
    }

		Taker::back();
  }

  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  // Recargas de usuarios
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  //------------------------------------------------------------------------------------------------------------
  function recargas()
  {
    $this->data =
    [
      'title'    => 'Todas las recargas',
      'recargas' => transaccionModel::all_recargas()
    ];

    View::render('recargas/index', $this->data);
  }

  function recarga($id)
  {
    if(!$trans = transaccionModel::by_id($id)) {
      Flasher::not_found('Transacción', false);
      Taker::back();
    }

    $this->data =
    [
      'title'       => sprintf('Transacción %s', $trans['numero']),
      'transaccion' => $trans
    ];

    View::render('single', $this->data);
  }

  function recarga_aprobar($id) 
  {
    if(!check_get_data(['hash', '_t'], $_GET)) {
      Flasher::access();
      Taker::back();
    }

    if(!validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    if(!$recarga = transaccionModel::by_id($id)) {
      Flasher::save('La transacción que buscas no existe', 'danger');
      Taker::back();
    }

    // Validar el status del recargo
    // pagado | abonado | cancelado | devuelto
    if($recarga['status'] === 'pagado') {
      Flasher::save('Esta transacción ya ha sido aprobada', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'abonado') {
      Flasher::save('Esta transacción ya ha sido abonada', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'cancelado') {
      Flasher::save('No puedes aprobar una transacción que ha sido cancelada anteriormente', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'devuelto') {
      Flasher::access('Esta transacción ya ha sido devuelta, no puedes aprobarla', 'danger');
      Taker::back();
    }
    
		try {

      $id = null;
      
      // Nueva transacción
			$trans                 = new transaccionModel;
			$trans->tipo           = 'abono_saldo';
			$trans->detalle        = sprintf('Abono por %s MXN', money($recarga['total']));
			$trans->referencia     = $recarga['numero'];
      $trans->id_usuario     = $recarga['id_usuario'];
      $trans->tipo_ref       = 'abono_saldo';
			$trans->status         = 'pagado';
			$trans->status_detalle = get_payment_status($trans->status);
			$trans->metodo_pago    = 'efectivo';
			$trans->descripcion    = 'Nueva transacción';
			$trans->subtotal       = $recarga['subtotal'];
			$trans->impuestos      = $recarga['impuestos'];
			$trans->total          = $recarga['total'];
	
			if(!$id = $trans->agregar()) {
				Flasher::save('Hubo un problema al abonar el saldo, intenta de nuevo', 'danger');
				Taker::back();
			}
	
      // Actualización de recarga
      if(!transaccionModel::update('shippr_transacciones', ['id' => $recarga['id']], ['status' => 'abonado', 'status_detalle' => get_payment_status('abonado')])) {
        Flasher::updated('Transacción', false);
        Taker::back();
      }
  
      // Notificación a usuario de recarga
      $trans             = transaccionModel::by_id($id);
      $usuario           = usuariosModel::by_id($trans['id_usuario']);
      $usuario['total']  = $trans['total'];
      $usuario['numero'] = $recarga['numero'];
      
      $email = new usuarioMailer($usuario);
      if($email->abono_aprobado()) {
        Flasher::save(sprintf('Se ha informado a <b>%s</b> que haz abonado <b>%s MXN</b> a su crédito en cuenta', $usuario['nombre'], money($trans['total'])));
      }
  
      Flasher::updated('Transacción');
      Taker::back();

		} catch (PDOException $e) {
			Flasher::save($e->getMessage(), 'danger');
			Taker::back();
		}
  }

  function recarga_rechazar($id) 
  {
    if(!check_get_data(['hash', '_t'], $_GET)) {
      Flasher::access();
      Taker::back();
    }

    if(!validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::back();
    }

    if(!$recarga = transaccionModel::by_id($id)) {
      Flasher::save('La transacción que buscas no existe', 'danger');
      Taker::back();
    }

    // Validar el status del recargo
    // pagado | abonado | cancelado | devuelto | rechazado
    if($recarga['status'] === 'rechazado') {
      Flasher::save('Esta transacción ya ha sido rechazada', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'pagado') {
      Flasher::save('Esta transacción ya ha sido aprobada', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'abonado') {
      Flasher::save('Esta transacción ya ha sido abonada', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'cancelado') {
      Flasher::save('No puedes rechazar una transacción que ha sido cancelada anteriormente', 'danger');
      Taker::back();
    }

    if($recarga['status'] === 'devuelto') {
      Flasher::access('Esta transacción ya ha sido devuelta, no puedes rechazarla', 'danger');
      Taker::back();
    }
    
		try {
      // Actualización de recarga
      if(!transaccionModel::update('shippr_transacciones', ['id' => $recarga['id']], ['status' => 'rechazado', 'status_detalle' => get_payment_status('rechazado')])) {
        Flasher::updated('Transacción', false);
        Taker::back();
      }
  
      // Notificación a usuario de recarga
      $usuario           = usuariosModel::by_id($recarga['id_usuario']);
      $usuario['total']  = $recarga['total'];
      $usuario['numero'] = $recarga['numero'];
      
      $email = new usuarioMailer($usuario);
      if($email->abono_rechazado()) {
        Flasher::save(sprintf('Se ha informado a <b>%s</b> que se ha rechazado el ticket <b>%s</b> para abonar <b>%s MXN</b> a su crédito en cuenta', $usuario['nombre'], $recarga['numero'], money($recarga['total'])));
      }
  
      Flasher::updated('Transacción');
      Taker::back();

		} catch (PDOException $e) {
			Flasher::save($e->getMessage(), 'danger');
			Taker::back();
		}
  }

  function recarga_borrar($id)
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t']) || !is_admin(get_user_role())) {
      Flasher::access();
      Taker::back();
    }

    try {
      $trans = transaccionModel::by_id($id);
      if($trans['tipo'] !== 'recarga_saldo') {
        throw new PDOException('No es posible eliminar esta transacción');
      }

      if($trans['status'] === 'abonado') {
        throw new PDOException('No es posible borrar esta recarga, ya ha sido aprobada');
      }

      if(!transaccionModel::remove('shippr_transacciones', ['id' => $id], 1)) {
        Flasher::deleted('Transacción', false);
        Taker::back();
      }
  
      Flasher::deleted('Transacción');
      Taker::back();

    } catch (PDOException $e) {
      Flasher::save($e->getMessage(), 'danger');
      Taker::back();
    }
  }
}
