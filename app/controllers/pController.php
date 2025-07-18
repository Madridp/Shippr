<?php 

/**
 * Controlador principal para acceso a rutas publicas con protección parcial
 */
class pController extends Controller
{

  function __construct()
  {
  }

  /**
   * Método por defecto
   * @access public
   * @param none
   * @return bool
   */
  public function index()
  {
    $this->tarifas();
  }

  public function tarifas()
  {
    $this->data =
    [
      'title'   => 'Lista de precios',
      'precios' => productoModel::for_printing()
    ];

    View::render('tarifas', $this->data);
  }

  public function download_prices()
  {
    if(!check_get_data(['_t'], $_GET) || !validate_csrf($_GET['_t'])) {
      Flasher::access();
      Taker::to('p/tarifas');
    }

    // Procesar los registros
    if(!$precios = productoModel::for_printing()) {
      Flasher::save('No tenemos tarifas para mostrar en estos momentos', 'danger');
      Taker::to('p/tarifas');
    }
    
    // Inicio del csv
    $csv_name  = sprintf('Shippr_prices_%s.csv', time());
    $delimiter = ',';

    $f    = fopen('php://output', 'w');
    $data = 
    [
      ['Archivo CSV creado', fecha(ahora())],
      ['Detalles', 'Precio MXN']
    ];

    // Iterar y construir el array de precios
    $precios = toObj($precios);
    foreach ($precios as $p) {
      $new =
      [
        sprintf('%s %s %s kg (%s)', $p->titulo, $p->tipo_servicio, $p->capacidad, $p->tiempo_entrega), money($p->precio, '$')
      ];
      $data[] = $new;
    }

    // Derechos shippr
    $data[] =
    [
      'Shippr', 'Todos los derechos reservados'
    ];

    if(is_logged()) {
      $data[] =
      [
        'Envía ahora en: ', URL.'carrito/nuevo'
      ];
    } else {
      $data[] =
      [
        'Regístrate ahora en: ', URL.'registro'
      ];
    }

    // Disclaimer
    $data[] = [''];
    $data[] = ['*Las zonas extendidas pueden tener un cargo adicional al precio base.',''];
    $data[] = ['**Nuestras tarifas pueden cambiar sin previo aviso.'];

    foreach ($data as $line) {
      // generate csv lines from the inner arrays
      fputcsv($f, $line, $delimiter); 
    }

    // tell the browser it's going to be a csv file
    header('Content-Encoding: UTF-8');
    header('Content-type: text/csv; charset=UTF-8');

    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="'.$csv_name.'";');

    // make php send the generated csv lines to the browser
    fpassthru($f);

    exit();
  }
}