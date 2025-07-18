<?php 

/**
* Controlador principal para el dashboard
*/
class dashboardController extends Controller
{
	
	function __construct()
	{
		parent::__construct();
	}


	/**
	* Principal función para el dashboard, muestra estadísticas generales
	*/
	public function index()
	{
		register_styles([URL.PLUGINS.'bootstrap-datepicker/css/bootstrap-datepicker3.css']);
		register_scripts([URL.PLUGINS.'bootstrap-datepicker/js/bootstrap-datepicker.min.js', URL.PLUGINS.'bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js']);

		register_styles([URL.PLUGINS.'owl.carousel/css/owl.carousel.css'], 'Owl carousel styles');
		register_scripts([URL.PLUGINS.'owl.carousel/js/owl.carousel.min.js', URL.PLUGINS.'countup/countUp.min.js']);

		/** Chart JS 
		$sql = 'SELECT t.tipo AS labels ,COUNT(e.id) AS total FROM equipos e LEFT JOIN tipos t ON t.id = e.id_tipo GROUP BY t.tipo ORDER BY total ASC';
		if($equipos = equiposModel::query($sql)){
			foreach ($equipos as $e) {
				$labels[] = $e['labels'];
				$data[] = $e['total'];
			}

			$chart = new ChartJSHandler('hero-donuts','doughnut',$labels,$data);
			$chart->set_border_w(1);
			$chart->shuffle_bg_colors();
			GraphHandler::register($chart->create());
		}*/

		//$sql = 'SELECT COUNT(e.status) AS xdata, e.status AS label FROM envios e WHERE e.id_usuario = :id GROUP BY e.status ORDER BY xdata DESC';
		$sql      = 'SELECT COUNT(e.status) AS total FROM envios e WHERE e.id_usuario = :id AND e.status = "OutForDelivery"';
		$e_camino = envioModel::query($sql,['id' => get_user_id()])[0]['total'];

		$sql      = 'SELECT COUNT(e.id) AS total FROM envios e WHERE e.id_usuario = :id_usuario';
		$e_t      = envioModel::query($sql,['id_usuario' => get_user_id()])[0];

		$sql      = 'SELECT COUNT(c.id) AS total FROM ventas c WHERE c.id_usuario = :id_usuario';
		$c_t      = ventaModel::query($sql,['id_usuario' => get_user_id()])[0];

		## Prueba de carousel
		$productos = productoModel::all(true);
		$owl       = null;
		if($productos) {
			$data =
			[
				'element'       => 'Productos',
				'bg_image'      => IMG.'owl-tarifas.jpg',
				'content_title' => 'Tarifas del día de hoy',
				'content_empty' => 'Las tarifas no están definidas aún',
				'footer_text'   => 'Agregar envío',
				'footer_link'   => URL.'envios/nuevo',
				'keys'          => ['titulo','descripcion','sku','precio','creado'],
				'show'          => ['title','description','number_element','main_element'],
			];
			foreach ($productos as $p) {
				$content[] = 
				[
					'titulo'      => sprintf('%s %s %skg (%s)', $p['name'], $p['tipo_servicio'], $p['capacidad'], $p['tiempo_entrega']),
					'descripcion' => $p['descripcion'],
					'sku'         => $p['sku'],
					'precio'      => '<h2>'.money($p['precio']).'</h2>',
					'creado'      => fecha($p['creado'])
				];
			}
			$data['content'] = $content;
			$owl = create_event_carousel($data);
		}

		$this->data =
		[
			'title'       => 'Dashboard',
			'e_t'         => $e_t,
			'e_ec'        => $e_camino,
			'c_t'         => $c_t,
			'owl_tarifas' => $owl
		];

		View::render("dashboard" , $this->data , true);
	}
}