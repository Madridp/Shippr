<?php 
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;
use MercadoPago\SDK AS SDK;

/**
* Controlador principal para peticiones ajax
*/
class ajaxController extends Controller
{
	/* Códigos de respuesta
	status = 200 // True
	status = 201 // Agregado
	status = 400 // False
	status = 600 // Sin privilegios
	status = 700 // Permisos denegados
	*/
	protected $modelo;
	
	function __construct()
	{
	}

	/**
	* Bloquea el acceso al script desde afuera
	* @access private
	**/
	public function index()
	{
		http_response_code(403);
		exit();
	}

	public function do_get_sidebar_bg()
	{
		if(!check_get_data([], $_GET)) {
			json_output(json_build(403));
		}

		json_output(json_build(200, fix_url(get_sidebar_bg())));
	}
	
	/**
	 * Tests SMTP connection to server or host
	 *
	 * @return void
	 */
	public function smtp_test()
	{
		if($_POST['hook'] !== 'js_hook' && $_POST['action'] !== 'smtp-test'){
			json_output(json_build(400,null,'Access not allowed'));
			die;
		}

		try {

			Mailer::test_connection( $_POST['host'] , $_POST['port'] , $_POST['email'] , $_POST['password'] );
			json_output(json_build(200 , null , 'Conexión satisfactoria.'));
			die;

		} catch (LumusException $e) {
			json_output(json_build(400 , null , $e->getMessage()));
			die;
		}

		die;
	}

	/**
	* Ajax para iniciar sesión de forma segura
	* @access private
	* Todos los usuarios deberán ser validados
	**/
	public function login()
	{
		if(!isset($_POST['accion']) && $_POST['accion'] !== 'login') {
			http_response_code(403);
			json_output(json_build(403));
		}

		try {
			$action  = $_POST['accion'];
			$usuario = new usuariosModel();
			$res     = null;
			$status  = null;
	
			// Validar password y usuario
			if (!$usuario = $usuario->validar_usuario_y_password($_POST['usuario'] , $_POST['password'])) {
				json_output(json_build(400,null,'El password o el usuario no coinciden'));
			}
	
			$status = (int) $usuario['status'];
	
			if($status === 1){
				json_output(json_build(400, null, sprintf('Lo sentimos %s, has sido suspendido del sistema, ponte en contacto con un administrador de %s', $usuario['nombre'], get_sitename())));
			}
	
			// Usuario sin confirmar para demostración
			if($status === 2){
				json_output(json_build(400, null, sprintf('Lo sentimos %s, debes confirmar tu registro para poder ingresar, revisa tu bandeja de spam en %s', $usuario['nombre'], $usuario['email'])));
			}
	
			// Demostración de usuario terminada
			if($status === 3){
				json_output(json_build(400, null, sprintf('Lo sentimos %s, tu periodo de demostración ha terminado, gracias por probar %s, escríbenos para contratar', $usuario['nombre'], get_system_name())));
			}
	
			// Inicia la sesión creación de $_COOKIES
			if(!Auth::iniciar_sesion($usuario['id_usuario'])) {
				json_output(json_build(400,null,'Hubo un problema, intenta de nuevo'));
			}
	
			// Verificar el rol del usuario
			$usuario = usuariosModel::by_id($usuario['id_usuario']);
	
			if($usuario['role'] === 'admin') {
				$res['redirect_to'] = URL.'direccion';
			} elseif($usuario['role'] === 'worker') {
				$res['redirect_to'] = URL.'admin';
			} elseif($usuario['role'] === 'root') {
				$res['redirect_to'] = URL.'root';
			} else {
				$res['redirect_to'] = URL.'dashboard';
			}
	
			json_output(json_build(200, $res, 'Bienvenido de nuevo '.$usuario['nombre']));
			//code...
		} catch (PDOException $e) {
			json_output(json_build(400, null, $e->getMessage()));
		}
	}

	public function update_payment_type()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['type'])) {
			json_output(json_build(403));
		}

		$valid_types = ['paying-cash','paying-bank-transfer','paying-mercadopago','paying-tokenize','paying-qr-code','paying_user_wallet'];
		$valid_types = ['paying_user_wallet'];

		if(!in_array($_POST['type'], $valid_types)) {
			json_output(json_build(400, null, 'Método de pago no soportado por '.get_sitename()));
		}

		// Actualizando la comisión y totales según el método de pago
		$cart = new CartHandler();

		// Check if cart is empty
		if(empty($cart->get_items())) {
			json_output(json_build(400, null, 'Tu carrito está vacío'));
		}
		
		$payment_method = $_POST['type'];
		switch ($payment_method) {
			case 'paying-tokenize' :
			case 'paying-mercadopago':
				$cart->set_payment_method($payment_method);
				$cart->set_comission_rate(get_user_sub_comission_rate());
				break;
			
			case 'paying-bank-transfer':
			case 'paying-cash':
			case 'paying-qr-code':
				$cart->set_payment_method($payment_method);
				$cart->set_comission_rate(0);
				break;

			case 'paying_user_wallet':
				$cart->set_payment_method($payment_method);
				$cart->set_comission_rate(0);
				break;
			
			default:
				$cart->set_payment_method(NULL);
				$cart->set_comission_rate(0);
				break;
		}

		json_output(json_build(200));
	}

	public function do_load_cart_checkout()
	{
		if(!isset($_POST['hook'],$_POST['action'])) {
			json_output(json_build(403));
		}

		## Get cart data
		$cart         = new CartHandler();
		$cart_amounts = $cart->get_amounts();
		$cart_amounts = toObj($cart_amounts);
		$cart_totals  = '';

		// Estado de la suscripción
		$cart_totals .= get_subscription_message();

		$cart_totals .= 
		'<table class="table table-striped">
			<tbody>
				<tr>
					<td class="text-left">Subtotal</td>
					<th class="text-right">'.money($cart_amounts->subtotal,'$').'</th>
				</tr>
				<tr>
					<td class="text-left">Comisiones <i class="fas fa-exclamation-circle text-info" '.tooltip('Por procesamiento de pago').'></i></td>
					<th class="text-right">'.(in_array($cart->get_payment_method(), ['paying-qr-code','paying-account-money']) ? '¡Sin comisiones!' : money($cart_amounts->comission,'$')).'</th>
				</tr>
				<tr>
					<td class="text-left align-middle">Método de pago</td>
					<th class="text-right align-middle">'.$cart->get_payment_method_formatted().'</th>
				</tr>
				<tr>
					<th class="text-left align-middle text-theme">Total a pagar</th>
					<th class="text-right align-middle text-theme"><h3 class="m-0 p-0"><b>MXN '.money($cart_amounts->total,'$').'</b></h3></th>
				</tr>
			</tbody>
		</table>
		<small class="text-muted">Recuerda que si alguno de tus paquetes supera la capacidad máxima permitida de peso neto o volumétrico, se aplicarán recargos.</small>';
		
		$data['cart_totals'] = $cart_totals;
		json_output(json_build(200,$data));
	}

	public function calcular_opciones_productos()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['peso_volumetrico'])) {
			json_output(json_build(403));
		}

		$destino  = clean($_POST['des_cp']);
		$peso_vol = ceil($_POST['peso_volumetrico']);

		if(empty($destino) || strlen($destino) < 5) {
			json_output(json_build(400, null, 'Ingresa un código postal válido para cotizar'));
		}

		## Busqueda de productos que esten dentro del criterio establecido
		$output = '';
    $sql = 'SELECT p.*, c.thumb AS imagenes, c.name FROM productos p JOIN va_couriers c ON c.id = p.id_courier WHERE capacidad >= :capacidad ORDER BY precio DESC';
		$opciones = productoModel::query($sql, ['capacidad' => $peso_vol]);
		$opciones = zonaModel::search(000, $destino, $peso_vol, null);
		
		## No hay resultados
		if(!$opciones) {
			$output = sprintf('<p>No tenemos opciones disponibles para tu envío al código postal <b>%s</b>, intenta de nuevo.</p>', $destino);
			json_output(json_build(200, $output));
		}

		$data =
		[
			'destino'  => $destino,
			'peso_vol' => clean($_POST['peso_volumetrico']),
			'opciones' => $opciones
		];

		$output = get_module('informacion/cotizador', $data, true);

		json_output(json_build(200, $output));
	}

	public function user_first_visit_modal()
	{
		if(!isset($_POST['hook'],$_POST['action'])) {
			json_output(json_build(400, null, 'Invalid access'));
		}

		if(!Auth::auth()) {
			//Auth::cerrar_sesion();
			logger(sprintf('Error en línea %s', __LINE__));
			json_output(json_build(403, null, 'Acceso no autorizado al sistema'));
		}

		$output = 
		'<div class="modal fade" id="user_first_visit_modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Bienvenido a '.get_sitename().'">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xl-12 text-center">
								<img src="'.URL.IMG.'va-welcome-message-modal.png" alt="Bienvenido" class="img-fluid" style="width: 200px;">
							</div>
						</div>
						<div class="row">
							<div class="col-xl-3"></div>
							<div class="col-xl-6 text-center">
								<p>Bienvenido a '.get_sitename().' <span class="text-theme">'.get_user_name().'</span> , a partir de ahora enviar será más fácil y rápido.</p>
								<p>¿Quieres ver cómo se hace?, mira este video y empieza a enviar ahora.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-2 col-12"></div>
							<div class="col-xl-8 col-12">
								<div class="responsive-embed-container">
									<iframe class="mt-2 responsive-embed-item" src="'.get_youtube_video().'" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 text-center">
								<a href="envios/nuevo" class="btn btn-primary btn-lg mt-3">Comenzar a enviar</a>
							</div>
						</div>
					</div>
					<div class="modal-footer text-center">
					</div>
				</div>
			</div>
		</div>';

		json_output(json_build(200,$output,'OK'));
	}

	public function envios_sync_to_aftership()
	{
		if(!is_worker(get_user_role())) {
			json_output(json_build(403));
		}

		if(!isset($_POST['hook'],$_POST['action']) || $_POST['action'] !== 'sync-shipments') {
			json_output(json_build(403));
		}

		// Get all shipments
		$envios = envioModel::all();

    if(!$envios) {
      json_output(json_build(200, null, 'No hay envíos en la base de datos.'));
		}
		
		$updated_shipments = update_all_shipment_status($envios);

		if($updated_shipments === 0 || $updated_shipments === false) {
			json_output(json_build(200, null, 'Ningún envío fue actualizado.'));
		}

		json_output(json_build(200, null, sprintf('%s %s con éxito.',$updated_shipments, ($updated_shipments > 1 ? 'envíos actualizados' : 'envío actualizado'))));
	}

	public function envios_track()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'track-shipment') {
			json_output(json_build(403));
		}

		if(!is_user(get_user_role(), 'regular')) {
			json_output(json_build(403));
		}

		## id del envío
		$id = (int) $_POST['id'];

		if(!$envio = envioModel::by_id($id)) {
			json_output(json_build(404));
		}
		
		## tracking_id del envío
		$tracking_id = $envio['tracking_id'];
		$res         = null;

		## Check if tracking_id exists on the shipment
		if(empty($tracking_id) || $tracking_id == null) {
			json_output(json_build(404, null, 'Este envío no está listo y no puede ser rastreado.'));
		}

		## Check if the shipment is actually registered on aftership
		try {
			$as  = new AftershipHandler();
			$res = $as->get_by_id($tracking_id);
		} catch (Exception $e) {
			json_output(json_build(404, null, 'Hubo un error, '.$e->getMessage()));
		}

		## Format output
		$content  = '';
		$meta     = $res['meta'];
		$tracking = $res['data']['tracking'];

		if(empty($tracking['checkpoints'])) {
			$content = '<p>No hay información de rastreo del paquete o no ha iniciado su viaje aún.</p>';
		} else {
			## slug
			## city
			## created_at
			## location
			## country_name
			## message
			## country_iso3
			## tag
			## subtag
			## subtag_message
			## checkpoint_time
			## coordinates[]
			## state
			## zip
			$content .= '
			<div class="row py-3 mb-2 bg-light" style="border-radius: 5px;">
				<div class="col-xl-12">
					<span class="badge badge-primary">'.$tracking['slug'].'</span> 
					'.(!empty($envio['titulo']) ? $envio['titulo'] : 'Desconocido').' - '.$envio['num_guia'].'
				</div>
			</div>';
			foreach ($tracking['checkpoints'] as $c) {
				$content .= '
				
				<div class="row py-2">
					<div class="col-xl-2 col-2 text-center align-baseline">
						<img class="img-fluid" src="'.get_tracking_image($c['tag']).'" style="width: 50px;">
					</div>
					<div class="col-xl-10 col-10 text-left">
						<p class="m-0"><b>'.get_tracking_status($c['tag']).'</b></p>
						'.(!empty($c['location']) && !empty($c['country_name']) ? '<span>'.strtoupper($c['location'].' - '.$c['country_name']).'</span>' : '').'
						'.(!empty($tracking['signed_by']) && $c['tag'] === 'Delivered' ? '<span class="text-primary d-block">Firmado por '.strtoupper($tracking['signed_by']).'</span>' : '').'
						 <small class="text-muted d-block m-0">'.fecha($c['checkpoint_time'],'d M, Y time').'</small>
					</div>
				</div>
				';
			}
		}

		$output = '<div class="modal fade" id="tracking-shipment-real-time" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Estado de envío #'.$envio['id'].'">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xl-12 text-center">
								<img src="'.URL.IMG.'va-tracking-shipment.svg" alt="Estado de envío #'.$envio['id'].'" class="img-fluid" style="width: 150px;">
							</div>
						</div>
						<br>

						<div class="row">
							<div class="col-xl-2"></div>
							<div class="col-xl-8 text-center">
							'.$content.'
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';

		json_output(json_build(200, $output));
	}

	public function do_open_edit_venta_modal()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['folio']) || $_POST['action'] !== 'open-modal') {
			json_output(json_build(403));
		}

		if(!is_worker(get_user_role())) {
			json_output(json_build(403));
		}

		## folio de la venta
		$folio = $_POST['folio'];

		if(!$v = ventaModel::by_folio($folio)) {
			json_output(json_build(404));
		}

		## Format output
		$output = 
		'<div class="modal fade" id="edit-venta-modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Actualizando venta #'.$v['folio'].'">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Actualizando venta #'.$v['folio'].'</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form id="do-save-changes-venta-form" method="POST">
						<input type="hidden" name="folio" value="'.$v['folio'].'" required>

            <h6>Información del cliente</h6>
            <div class="form-group">
              <small class="d-block">Usuario</small>
              '.$v['usuario'].'
            </div>
            <div class="form-group">
              <small class="d-block">Nombre completo</small>
              '.$v['nombre'].'
            </div>
            <div class="form-group">
              <small class="d-block">E-mail</small>
              '.$v['email'].'
            </div>
            <br>

						<h6>Información general</h6>
            <div class="form-group">
              <small class="d-block">Folio</small>
              '.$v['folio'].'
            </div>

            <div class="form-group">
              <small class="d-block">Estado de la venta</small>
							<select class="form-control form-control-sm" name="data[status]" required>';
							foreach (get_estados_de_venta() as $status) {
								if($status[0] == $v['status']) {
									$output .= '<option value="'.$status[0].'" selected>'.$status[1].'</option>';
								} else {
									$output .= '<option value="'.$status[0].'">'.$status[1].'</option>';
								}
							}
						
						$output .= '
              </select>
            </div>

            <div class="form-group">
              <small class="d-block">Estado del pago</small>
              <select class="form-control form-control-sm" name="data[pago_status]" required>';
							foreach (get_estados_de_pago() as $status) {
								if($status[0] == $v['pago_status']) {
									$output .= '<option value="'.$status[0].'" selected>'.$status[1].'</option>';
								} else {
									$output .= '<option value="'.$status[0].'">'.$status[1].'</option>';
								}
							}
							$output .= 
							'</select>
            </div>

            <div class="form-group">
              <small class="d-block">Método de pago</small>
              <select class="form-control form-control-sm" name="data[metodo_pago]" required>';
							foreach (get_metodos_de_pago() as $status) {
								if($status[0] == $v['metodo_pago']) {
									$output .= '<option value="'.$status[0].'" selected>'.$status[1].'</option>';
								} else {
									$output .= '<option value="'.$status[0].'">'.$status[1].'</option>';
								}
							}
              $output .= '</select>
            </div>

            <div class="form-group">
              <small class="d-block">Número de pago</small>
              <input type="text" class="form-control form-control-sm" name="data[collection_id]" value="'.$v['collection_id'].'">
            </div>
            <br>
            
						<button type="submit" class="btn btn-success " name="submit">Guardar cambios</button>
						<button type="reset" class="btn btn-default" name="cancel" data-dismiss="modal">Cancelar</button>
					</form>
					</div>
				</div>
			</div>
		</div>';
		json_output(json_build(200,$output));
	}

	public function do_save_changes_venta_modal()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['data']) || $_POST['action'] !== 'save-changes') {
			json_output(json_build(403));
		}

		if(!is_worker(get_user_role())) {
			json_output(json_build(403));
		}

		## folio de la venta
		parse_str($_POST['data'] , $parsed_array);
		$folio = $parsed_array['folio'];
		$data  = $parsed_array['data'];

		if(!$v = ventaModel::by_folio($folio)) {
			json_output(json_build(404));
		}

		if(!ventaModel::update('ventas',['id' => intval($v['id'])],$data)) {
      json_output(json_build(400,null,'Venta no actualizada, hubo un error'));
		}
		
		json_output(json_build(200,null,'Venta actualizada con éxito'));
	}

	## --------------------------------------------
	##
	## MODALS AND POP UPS
	##
	## --------------------------------------------
	public function do_load_new_payment_method_modal()
	{
		if(!Auth::auth()) {
			Auth::cerrar_sesion();
			json_output(json_build(403));
		}

		if(!isset($_POST['hook'],$_POST['action'])) {
			json_output(json_build(400, null, 'Invalid access'));
		}

		$output = 
		'<div class="modal fade" id="do_load_new_payment_method_modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Métodos de pago">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-xl-12 text-center">
								<img src="'.URL.IMG.'va-new-payment-method-modal.png" alt="QR Método de pago" class="img-fluid" style="width: 350px;">
							</div>
						</div>
						<br>
						<div class="row">
							<div class="col-xl-2"></div>
							<div class="col-xl-8 text-center">
								<h3>Código QR</h3>
								<p>En '.get_system_name().' seguimos trabajando para ofrecerte un mejor y más rápido servicio, es por eso que ahora tenemos un <b>nuevo método de pago</b>, rápido y sencillo de utilizar.</p>
								<p>Pruébalo ahora mismo y dinos que piensas</p>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 text-center">
								<a href="envios/nuevo" class="btn btn-primary btn-lg mt-3">Hacer un envío</a>
							</div>
						</div>
					</div>
					<div class="modal-footer text-center">
					</div>
				</div>
			</div>
		</div>';
		json_output(json_build(200,$output,'OK'));
	}

	function do_load_whats_new_modal()
	{
		if(!isset($_POST['hook'],$_POST['action']) || $_POST['action'] !== 'get') {
			json_output(json_build(403));
		}

		ob_start();
		require_once MODULES.'whatsnew/newDireccionesModal.php';
		$output = ob_get_clean();

		json_output(json_build(200, $output));
	}
	
	function do_get_user_address()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'get') {
			json_output(json_build(403));
		}

		## Id de la dirección
		$id = $_POST['id'];

		## Existe y pertenece al usuario actual
		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		json_output(json_build(200,$direccion));
	}

	function do_u_create_direccion_modal()
	{
		if(!isset($_POST['hook'],$_POST['action']) || $_POST['action'] !== 'create') {
			json_output(json_build(403));
		}

		ob_start();
		require_once MODULES.'direcciones/createModal.php';
		$output = ob_get_clean();

		json_output(json_build(200,$output));
	}

	function do_u_create_direccion()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['data']) || $_POST['action'] !== 'create') {
			json_output(json_build(403));
		}

		## Parsing data
		parse_str($_POST['data'],$data);

		if(empty($data['nombre']) || 
		empty($data['telefono']) ||
		empty($data['cp']) ||
		empty($data['calle']) ||
		empty($data['num_ext']) ||
		empty($data['colonia']) ||
		empty($data['ciudad']) ||
		empty($data['estado']) ||
		empty($data['referencias'])) {
			json_output(json_build(400,NULL,'Completa todos los campos'));
		}

		if(!empty($data['email'])) {
			if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)) {
				json_output(json_build(400,NULL,'Ingresa una dirección de correo válida'));
			}
		}

		## Nueva dirección
		$new_address =
		[
			'id_usuario'  => get_user_id(),
			'tipo'        => (isset($data['default_address']) ? 'remitente' : NULL),
			'nombre'      => clean($data['nombre']),
			'email'       => clean($data['email']),
			'telefono'    => clean($data['telefono']),
			'empresa'     => clean($data['empresa']),
			'cp'          => clean($data['cp']),
			'calle'       => clean($data['calle']),
			'num_ext'     => clean($data['num_ext']),
			'num_int'     => clean($data['num_int']),
			'colonia'     => clean($data['colonia']),
			'ciudad'      => clean($data['ciudad']),
			'estado'      => clean($data['estado']),
			'pais'        => clean($data['pais']),
			'referencias' => clean($data['referencias']),
			'coordenadas' => NULL,
			'creado'      => ahora()
		];

		## Convertir en principal si es requerido
		if(isset($data['default_address']) && $data['default_address'] == 'on') {
			direccionModel::reset_main_addresses(get_user_id());
		}

		## Agregar la nueva dirección
		if(!$id = direccionModel::add('direcciones',$new_address)) {
			json_output(json_build(400,NULL,'Hubo un error, intenta de nuevo'));
		}

		json_output(json_build(201));
	}

	function do_u_get_direccion_modal()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'get') {
			json_output(json_build(403));
		}

		## Id de la dirección a cargar
		$id = $_POST['id'];

		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		## Parse direccion a objeto
		$d = toObj($direccion);

		ob_start();
		require_once MODULES.'direcciones/getModal.php';
		$output = ob_get_clean();

		json_output(json_build(200,$output));
	}

	function do_u_update_direccion()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['data']) || $_POST['action'] !== 'update') {
			json_output(json_build(403));
		}

		## Parsing data
		parse_str($_POST['data'],$data);

		if(empty($data['nombre']) || 
		empty($data['telefono']) ||
		empty($data['cp']) ||
		empty($data['calle']) ||
		empty($data['num_ext']) ||
		empty($data['colonia']) ||
		empty($data['ciudad']) ||
		empty($data['estado']) ||
		empty($data['referencias'])) {
			json_output(json_build(400,NULL,'Completa todos los campos'));
		}

		if(!empty($data['email'])) {
			if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL)) {
				json_output(json_build(400,NULL,'Ingresa una dirección de correo válida'));
			}
		}

		## Dirección a actualizar
		$id = $data['id'];

		## Validar que sea del usuario actual
		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		## Dirección actualizada
		$updated_address =
		[
			'tipo'        => (isset($data['default_address']) ? 'remitente' : NULL),
			'nombre'      => clean($data['nombre']),
			'email'       => clean($data['email']),
			'telefono'    => clean($data['telefono']),
			'empresa'     => clean($data['empresa']),
			'cp'          => clean($data['cp']),
			'calle'       => clean($data['calle']),
			'num_ext'     => clean($data['num_ext']),
			'num_int'     => clean($data['num_int']),
			'colonia'     => clean($data['colonia']),
			'ciudad'      => clean($data['ciudad']),
			'estado'      => clean($data['estado']),
			'pais'        => clean($data['pais']),
			'referencias' => clean($data['referencias']),
			'coordenadas' => NULL
		];

		## Convertir en principal si es requerido
		if(isset($data['default_address']) && $data['default_address'] == 'on') {
			direccionModel::reset_main_addresses(get_user_id());
		}

		## Actualizar la dirección
		if(!direccionModel::update('direcciones',['id' => $id],$updated_address)) {
			json_output(json_build(400,NULL,'Hubo un error, intenta de nuevo'));
		}

		json_output(json_build(200));
	}

	function do_u_update_direccion_modal()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'update') {
			json_output(json_build(403));
		}

		## Id de la dirección a cargar
		$id = $_POST['id'];

		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		## Parse direccion a objeto
		$d = toObj($direccion);

		ob_start();
		require_once MODULES.'direcciones/updateModal.php';
		$output = ob_get_clean();

		json_output(json_build(200,$output));
	}

	function do_u_delete_remitente_defecto()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'update') {
			json_output(json_build(403));
		}

		## Id de la dirección
		$id = $_POST['id'];

		## Existe
		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		## Checar si realmente es principal
		if($direccion['tipo'] !== 'remitente') {
			json_output(json_build(400,null,'Esta dirección no es una dirección por defecto'));
		}

		## Actualizar el registro
		if(!direccionModel::update('direcciones',['id' => $id],['tipo' => NULL])) {
			json_output(json_build(400,null,'Hubo un error al actualizar la dirección'));
		}

		json_output(json_build(200));
	}

	function do_u_make_remitente_defecto()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'update') {
			json_output(json_build(403));
		}

		## Id de la dirección
		$id = $_POST['id'];

		## Existe
		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		## Checar si no es principal ya
		if($direccion['tipo'] == 'remitente') {
			json_output(json_build(400,null,'Esta dirección ya es tu remitente por defecto'));
		}

		## Checkar si ya tiene remitentes por defecto el usuario
		if(direccionModel::check_user_main_addresses(get_user_id())) {
			direccionModel::reset_main_addresses(get_user_id());
		}

		## Actualizar el registro
		if(!direccionModel::update('direcciones',['id' => $id],['tipo' => 'remitente'])) {
			json_output(json_build(400,null,'Hubo un error al actualizar la dirección'));
		}

		json_output(json_build(200));
	}

	function do_u_delete_direccion()
	{
		if(!isset($_POST['hook'],$_POST['action'],$_POST['id']) || $_POST['action'] !== 'delete') {
			json_output(json_build(403));
		}

		## Id de la dirección
		$id = $_POST['id'];

		## Existe y pertenece al usuario actual
		if(!$direccion = direccionModel::by_user_and_id(get_user_id(),$id)) {
			json_output(json_build(404));
		}

		## Borrar el registro
		if(!direccionModel::remove('direcciones',['id' => $id])) {
			json_output(json_build(400,null,'Hubo un error al borrar la dirección'));
		}

		json_output(json_build(200));
	}

	## --------------------------------------
	##
	## INFORMACION CONTROLLER
	##
	## --------------------------------------
	function do_send_consulting_form()
	{
		if(!check_posted_data(['inf_email','inf_asunto','inf_contenido','inf_pregunta'], $_POST)) {
			json_output(json_build(403));
		}

		if(empty($_POST['inf_email']) || empty($_POST['inf_contenido']) || empty($_POST['inf_pregunta'])) {
			json_output(json_build(400,null,'Completa todos los campos por favor'));
		}

		if(!filter_var($_POST['inf_email'], FILTER_VALIDATE_EMAIL)) {
			json_output(json_build(400,null,'Dirección de correo electrónico no válida'));
		}

		$email = new Mailer();
		$email->setFrom($_POST['inf_email']);
		$email->addAddress(get_smtp_email());
		$email->setSubject(get_email_sitename().' '.$_POST['inf_asunto']);
		$data =
		[
			'title'   => $_POST['inf_asunto'],
			'altbody' => 'Nuevo mensaje de usuario',
			'body'    => '<h5><strong>'.$_POST['inf_pregunta'].'</strong></h5><br>'.$_POST['inf_contenido']
		];
		
		$body = new MailerBody(get_email_template(), $data);
		$body = $body->parseBody()->getOutput();
		$email->setBody($body);

		if(!$email->send()){
			json_output(json_build(400,null, 'Mensaje no enviado, intenta de nuevo'));
		}

		json_output(json_build(200, null, 'Mensaje enviado con éxito, ¡Gracias!'));
	}

	## -----------------------------------
	##
	## 1.0.5.6 LOG del sistema
	##
	## -----------------------------------
	function do_get_log()
	{
		if(!check_posted_data([], $_POST)) {
			json_output(json_build(403));
		}

		$log_file = LOGS.'jserp_log.log';
		if(!is_file($log_file)) {
			json_output(json_build(404, null, sprintf('Archivo %s no encontrado', $log_file)));
		}
		
		ob_start();
		require_once $log_file;
		$output = ob_get_clean();
		
		json_output(json_build(200, $output, 'Log cargado con éxito'));
	}

	## -----------------------------------
	##
	## 1.0.5.6 Personalización
	##
	## -----------------------------------
	function do_delete_site_login_bg()
	{
		if(!check_posted_data([], $_POST)) {
			json_output(json_build(403));
		}

		$login_bg = get_option('site_login_bg');

		// No hay imagen guardada en el sistema
		if(!$login_bg || !is_file(UPLOADS.$login_bg)) {
			json_output(json_build(400, get_site_login_bg(), sprintf('No puedes borrar la imagen por defecto %s', get_user_name())));
		}

		// Si existe, se borra y se reinicia el valor
		if(!unlink(UPLOADS.$login_bg)) {
			json_output(json_build(400, get_site_login_bg(), sprintf('Hubo un problema al borrar la imagen %s', $login_bg)));
		}

		if(!JS_Options::add_option('site_login_bg', null)) {
			json_output(json_build(400, get_site_login_bg(), sprintf('Hubo un problema al actualizar los parametros')));
		}

		json_output(json_build(200, get_site_login_bg(), sprintf('Imagen %s borrada con éxito', $login_bg)));
	}

	function do_delete_sidebar_bg()
	{
		if(!check_posted_data([], $_POST)) {
			json_output(json_build(403));
		}

		$login_bg = get_option('sidebar_bg');

		// No hay imagen guardada en el sistema
		if(!$login_bg || !is_file(UPLOADS.$login_bg)) {
			json_output(json_build(400, get_sidebar_bg(), sprintf('No puedes borrar la imagen por defecto %s', get_user_name())));
		}

		// Si existe, se borra y se reinicia el valor
		if(!unlink(UPLOADS.$login_bg)) {
			json_output(json_build(400, get_sidebar_bg(), sprintf('Hubo un problema al borrar la imagen %s', $login_bg)));
		}

		if(!JS_Options::add_option('sidebar_bg', null)) {
			json_output(json_build(400, get_sidebar_bg(), sprintf('Hubo un problema al actualizar los parametros')));
		}

		json_output(json_build(200, get_sidebar_bg(), sprintf('Imagen %s borrada con éxito', $login_bg)));
	}

		## -----------------------------------
	##
	## USER HEARTBEAT
	##
	## -----------------------------------
	function do_heartbeat()
	{
		if(!isset($_POST['action'],$_POST['hook'])) {
			json_output(json_build(403));
		}

		// La sesión expiró o hubo algún problema
		if(!Auth::auth()) {
			json_output(json_build(403, null, 'Not logged in'));
		}
		
		// Tiempo actual en el servidor
		$current_time = time();
		
		// Actualizar registro en la db
		if(!usuariosModel::update('usuarios',['id_usuario' => get_user_id()],['time_active' => $current_time])) {
			json_output(json_build(400, null, 'Tiempo de actividad no actualizado, hubo un problema'));
		}
		
		// Revisar
		json_output(json_build(200, null, 'alive'));
	}

	/**
	 * Función para reiniciar a las opciones por defecto en la base de datos
	 *
	 * @return void
	 */
	function do_restart_opciones() 
	{
		if(!check_get_data(['csrf'], $_POST) || !validate_csrf($_POST['csrf']) || !is_root(get_user_role())) {
			json_output(json_build(403));
		}

		try {
			restart_options();
			json_output(json_build(200, null, 'Las opciones del sistema han sido reiniciadas con éxito'));
		} catch (Exception $e) {
			json_output(json_build(400, null, $e->getMessage()));
		}
	}

	/**
	 * Reiniciar base de datos y opciones a por defecto
	 *
	 * @return void
	 */
	function do_restart_system()
	{
		if(!check_get_data(['csrf'], $_POST) || !validate_csrf($_POST['csrf']) || !is_root(get_user_role())) {
			json_output(json_build(403));
		}

		try {
			truncate_all_tables();
			restart_options();
			json_output(json_build(200, null, 'El sistema ha sido reiniciado con éxito'));
		} catch (Exception $e) {
			json_output(json_build(400, null, $e->getMessage()));
		}
	}
}