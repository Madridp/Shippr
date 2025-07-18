<?php
// Faker
use Faker\Factory;
use Faker\Provider\Base;
use Faker\ORM\Propel\Populator;
use Faker\Provider\Internet;
use Faker\Provider\UserAgent;
use Faker\Provider\Payment;
use Faker\Provider\Color;
use Faker\Provider\File;
use Faker\Provider\Image;
use Faker\Provider\Miscellaneous;
use Faker\Provider\HtmlLorem;
use Faker\Provider\DateTime;
use Faker\Provider\en_US\Company;
use Faker\Provider\en_US\PhoneNumber;

function get_dashboard_shortcuts() {
  $output = '';
  $elements =
  [
    ['clientes/agregar','Agregar nuevo cliente', ['gerente-servicio','asistente','gerente-ventas']],
    ['servicios/agregar','Agregar servicio', ['gerente-servicio','asistente']],
    ['reportes/agregar','Agregar reporte', ['gerente-servicio','ingeniero','asistente']],
    ['contratos/agregar','Agregar contrato', ['admin']],
    ['cotizaciones/agregar','Nueva cotizacion', ['gerente-servicio','asistente','gerente-ventas']],
    ['formatos/cotizacion-interna','Nueva cotización interna', ['gerente-ventas','asistente']],
    ['servicios/orden-de-servicio','Nueva orden de servicio', ['ingeniero','asistente']],
    ['anticipos/solicitar','Solicitar anticipo', ['ingeniero']],
    ['reembolsos/agregar','Solicitar reembolso', ['ingeniero']],
    ['servicios/asignados','Mis servicios', ['ingeniero']],
    ['direccion/configuraciones','Configuraciones', ['admin']],
  ];
  $output .= '<div class="list-group">';
  $i = 0;
  foreach ($elements as $e) {
    if(is_user(get_user_role(), $e[2])) {
      $output .= '<a href="'.$e[0].'" class="list-group-item list-group-item-action '.($i === 0 ? 'active' : '').'">'.$e[1].'</a>';
      $i++;
    }
  }
  $output .= '</div>';
  return $output;
}

function get_newversion_excluded_dirs() {
  $excluded =
  [
    'app/handlers',
    'app/helpers',
    'app/migrations',
    'vue',
    'vendor',
    'app/config',
    '.git',
    'app/logs',
    'app/db_backups',
    'app/interfaces',
    'backups',
    'updates',
    'uploads',
    'uploads/anticipos',
    'uploads/qr',
    'pruebas',
    'README.html',
    'README.md',
    'composer.json',
    'composer.lock',
    '.sass',
    '.scss',
    'plugins',
    'plugins',
    'files',
    '_es6',
    '.htaccess',
    'prepros-6.config',
    'versions'
  ];
  return $excluded;
}

function get_cotizacion_types() {
  $types = 
	[
		'Cotización de Equipo Médico',
		'Cotización de Productos Artesanales',
		'Cotización de Servicios de Ingeniería',//3
		'Cotización de Refacciones',//4
    'Recibo de pago mensual',
    'Cotización de Servicios',
    'Cotización de Productos',
    'Cotización'
  ];
  return $types;
}

function not_empty($value = '' , $return_value = '—') {
  if(empty($value) || $value === '' || $value == NULL) {
    return $return_value;
  }

  return $value;
}

function get_tipos_de_empleado() {
  $types = 
  [
    'Tiempo completo',
    'Medio tiempo',
    'Bajo contrato',
    'Temporal',
    'Aprendiz',
    'Practicante',
    'Becario'
  ];
  return $types;
}

function get_estados_de_empleado() {
  $types =
  [
    'Activo',
    'Terminado',
    'Difunto',
    'Renunció'
  ];
  return $types;
}

function check_posted_data($required_params = [] , $posted_data = []) {
  if(empty($posted_data)) {
    return false;
  }

  // Keys necesarios en toda petición
  $defaults = ['hook','action'];
  $required_params = array_merge($required_params,$defaults);
  $required = count($required_params);
  $found = 0;

  foreach ($posted_data as $k => $v) {
    if(in_array($k , $required_params)) {
      $found++;
    }
  }

  if($found !== $required) {
    return false;
  }

  return true;
}

function check_get_data($required_params = [] , $get_data = []) {
  if(empty($get_data)) {
    return false;
  }

  // Keys necesarios en toda petición
  $defaults = ['hook','action'];
  $required_params = array_merge($required_params, $defaults);
  $required = count($required_params);
  $found = 0;

  foreach ($get_data as $k => $v) {
    if(in_array($k , $required_params)) {
      $found++;
    }
  }

  if($found !== $required) {
    return false;
  }

  return true;
}

function more_info($str , $color = 'text-info' , $icon = 'fas fa-exclamation-circle') {
  $str = clean($str);
  $output = '';
  $output .= '<span class="'.$color.'" '.tooltip($str).'><i class="'.$icon.'"></i></span>';
  return $output;
}

function get_cfdi_usos() {
  $cfdi = [
	"G01" => "Adquisición de mercancias",
	"G02" => "Devoluciones, descuentos o bonificaciones",
	"G03" => "Gastos en general",
	"I01" => "Construcciones",
	"I02" => "Mobiliario y equipo de oficina por inversiones",
	"I03" => "Equipo de transporte",
	"I04" => "Equipo de computo y transporte",
	"I05" => "Dados, troqueles, moldes, matrices y herramientas",
	"I08" => "Otra maquinaria y equipo",
	"D01" => "Honorarios médicos, dentales y gastos hospitalarios",
	"D04" => "Donativos",
	"D06" => "Aportaciones voluntarias al SAR",
	"P01" => "Por definir"
  ];
  return $cfdi;
}

function get_lorem() {
  $content = file_get_contents('http://loripsum.net/api');
  return $content;
}

function mailto($email, $subject = null, $body = null) {
  $string = 'mailto:'.$email;

  if($subject !== null) {
    $string .= strpos($string, '?') !== false ? '&subject='.$subject : '?subject='.$subject;
  }

  if($body !== null) {
    $string .= strpos($string, '?') !== false ? '&body='.$body : '?body='.$body;
  }
  
  return $string;
}

function get_php_info() {
  $entitiesToUtf8 = function($input) {
      // http://php.net/manual/en/function.html-entity-decode.php#104617
      return preg_replace_callback("/(&#[0-9]+;)/", function($m) { return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); }, $input);
  };

  $plainText = function($input) use ($entitiesToUtf8) {
      return trim(html_entity_decode($entitiesToUtf8(strip_tags($input))));
  };

  $titlePlainText = function($input) use ($plainText) {
      return '# '.$plainText($input);
  };
 
  ob_start();
  phpinfo(-1);
 
  $phpinfo = array('phpinfo' => array());

  // Strip everything after the <h1>Configuration</h1> tag (other h1's)
  if (!preg_match('#(.*<h1[^>]*>\s*Configuration.*)<h1#s', ob_get_clean(), $matches)) {
      return array();
  }
 
  $input = $matches[1];
  $matches = array();

  if(preg_match_all(
      '#(?:<h2.*?>(?:<a.*?>)?(.*?)(?:<\/a>)?<\/h2>)|'.
      '(?:<tr.*?><t[hd].*?>(.*?)\s*</t[hd]>(?:<t[hd].*?>(.*?)\s*</t[hd]>(?:<t[hd].*?>(.*?)\s*</t[hd]>)?)?</tr>)#s',
      $input,
      $matches,
      PREG_SET_ORDER
  )) {
      foreach ($matches as $match) {
          $fn = strpos($match[0], '<th') === false ? $plainText : $titlePlainText;
          if (strlen($match[1])) {
              $phpinfo[$match[1]] = array();
          } elseif (isset($match[3])) {
              $keys1 = array_keys($phpinfo);
              $phpinfo[end($keys1)][$fn($match[2])] = isset($match[4]) ? array($fn($match[3]), $fn($match[4])) : $fn($match[3]);
          } else {
              $keys1 = array_keys($phpinfo);
              $phpinfo[end($keys1)][] = $fn($match[2]);
          }

      }
  }
 
  return $phpinfo;
}

function get_sat_regimenes() {
	$file = SAT.'c_RegimenFiscal.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function sat_search_regimen_by_id($id) {
  $regimenes = get_sat_regimenes();

  foreach ($regimenes as $k => $v) {
    if($id == $v->id) {
      return $v;
    }
  }

  return toObj(['id'=> 'XOX0', 'descripcion' => 'Régimen desconocido']);
}

function get_sat_usos_cfdi() {
	$file = SAT.'c_UsoCFDI.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function get_sat_claves_productos() {
  return json_decode(file_get_contents(SAT.'c_ClaveProdServ.json'));
}

function sat_search_clave_producto($query) {
  $claves_productos = get_sat_claves_productos();
  $matches = []; // matches o claves de productos encontrados

  foreach ($claves_productos as $k => $v) {
    if(preg_match("/\b$query\b/i", $v->descripcion) || preg_match("/\b$query\b/i", $v->id)) {
      $matches[] = $v;
    }
  }

  return $matches;
}

function get_sat_formas_pago() {
	$file = SAT.'c_FormaPago.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function get_sat_metodos_pago() {
	$file = SAT.'c_MetodoPago.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function get_sat_unidades() {
	$file = SAT.'c_ClaveUnidad.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function sat_search_unidades($query) {
  $unidades = get_sat_unidades();
	$matches = []; // matches o claves de unidades encontradas
	
  foreach ($unidades as $k => $v) {
    if(preg_match("/\b$query\b/i", $v->nombre) || preg_match("/\b$query\b/i", $v->id)) {
      $matches[] = $v;
    }
  }

  return $matches;
}

function sat_get_unidad($id_unidad) {
  $unidades = get_sat_unidades();
	
  foreach ($unidades as $k => $v) {
    if($v->id == $id_unidad) {
      return $v;
    }
  }

  return false;
}

function get_sat_impuestos() {
	$file = SAT.'c_Impuesto.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function get_sat_tipo_comprobante() {
	$file = SAT.'c_TipoDeComprobante.json';
	if(!is_file($file)) {
		return [];
	}

	return json_decode(file_get_contents($file));
}

function construct_navbar($user_role) {
  if($user_role === null) {
    return 'Sin autorización';
  }

  // Construcción de sidebar
  ob_start();
  require_once INCLUDES.'sidebar_nav.php';
  $output = ob_get_clean();

  return $output;
}

function render_category_tree($tree, $level_mark = '', $sub_mark = '--') {
  if(empty($tree)) {
    return false;
  }

  $output = '';

  foreach ($tree as $cat) {
    $output .= '<span class="d-block"><i class="fas fa-trash text-danger f-s-12 mr-3 do_delete_categoria" data-id="'.$cat['id'].'"></i><i class="fas fa-edit text-primary f-s-12 mr-3 do_open_update_modal" data-id="'.$cat['id'].'"></i>'.$level_mark.$cat['categoria'].' ('.$cat['total'].')</span>';
    if(!empty($cat['subcategorias'])) {
      $output .= render_category_tree($cat['subcategorias'], $level_mark.$sub_mark, $sub_mark);
    }
  }

  return $output;
}

function render_category_tree_options($tree, $level_mark = '', $sub_mark = '-') {
  if(empty($tree)) {
    return false;
  }

  $output = '';

  foreach ($tree as $cat) {
    $output .= '<option value="'.$cat['id'].'" '.(isset($_POST['id_padre']) && $_POST['id_padre'] == $cat['id'] ? 'selected' : '').'>'.$level_mark.$cat['categoria'].'</option>';
    if(!empty($cat['subcategorias'])) {
      $output .= render_category_tree_options($cat['subcategorias'], $level_mark.$sub_mark, $sub_mark);
    }
  }

  return $output;
}

function debug($data) {
  echo '<pre>';
  if(is_array($data) || is_object($data)) {
    print_r($data);
  } else {
    echo $data;
  }
  echo '</pre>';
}

function add_ellipsis($string , $lng = 100) {
	if(!is_integer($lng)) {
		$lng = 100;
	}
	$output = strlen($string) > $lng ? substr($string, 0 , $lng).'...' : $string;
	return $output;
}

function fix_url($url) {
	return str_replace('\\', '/', $url);
}

/**
 * Reinicia todas las tablas del sistema
 *
 * @return void
 */
function truncate_all_tables() {
  $sql           = '';
  $errors        = 0;
  $success       = 0;
  $started_at    = time();
  $ellapsed_time = 0;

  logger('Iniciando truncado de tablas...');

  try {
    // Truncate direcciones
    $sql = 'TRUNCATE TABLE direcciones';
    Model::query($sql);
  
    // Truncate envios
    $envios = envioModel::all();
    $sql    = 'TRUNCATE TABLE envios';
    Model::query($sql);

    // TODO: Borrar todas las etiquetas generadas o archivos guardados en el sistema
    if(!empty($envios)) {
      foreach ($envios as $e) {
        if(is_file(UPLOADS.$e['adjunto'])) {
          unlink(UPLOADS.$e['adjunto']);
        }
      }
    }
    // Posts
    $sql = 'TRUNCATE TABLE posts';
    Model::query($sql);

    // Productos
    $sql = 'TRUNCATE TABLE productos';
    Model::query($sql);

    // sesion_tokens
    $sql = 'TRUNCATE TABLE sesion_tokens';
    Model::query($sql);
    
    // transacciones
    $sql = 'TRUNCATE TABLE shippr_transacciones';
    Model::query($sql);

    // $sql = 'TRUNCATE TABLE shippr_zonas';
    // Model::query($sql);

    $sql = 'TRUNCATE TABLE tokens';
    Model::query($sql);

    $sql = 'TRUNCATE TABLE va_sub_transactions';
    Model::query($sql);

    $sql = 'TRUNCATE TABLE va_sub_types';
    Model::query($sql);

    $sql = 'TRUNCATE TABLE va_subscriptions';
    Model::query($sql);

    $sql = 'TRUNCATE TABLE va_transacciones';
    Model::query($sql);

    $sql = 'TRUNCATE TABLE ventas';
    Model::query($sql);
    
    // Usuarios    
    $sql = 'DELETE FROM usuarios WHERE id_usuario NOT IN(:id_usuario)';
    Model::query($sql, ['id_usuario' => get_user_id()]);

    $ellapsed_time = time() - $started_at;
    logger(sprintf('Truncado de tablas finalizado en %s segundo(s)', $ellapsed_time));
    return true;

  } catch (PDOException $e) {
    throw new Exception($e->getMessage(), 1);
  } catch (Exception $e) {
    throw new Exception($e->getMessage(), 1);
  }
}

function restart_options() {
  logger('Iniciando reinicio de opciones...');
  $old_logo    = get_option('sitelogo');
  $old_favicon = get_option('sitefavicon');
  
  // todo: borrar imágenes no utilizadas en reinicio
  
  try {
    $default_options =
    [
      'sitename'            => 'Shippr',
      'sitelogo'            => null,
      'sitefavicon'         => null,
      'siteslogan'          => 'Sistema de administración de envíos.',
      'sitedesc'            => 'Shippr el mejor ERP de administración de empresas de envíos y logística, desarrollado por Joystick, empresa 100% mexicana.',
      'siteurl'             => URL,
      'siteph'              => '5512346789',
      'siterazonSocial'     => 'Shippr SA de CV',
      'siterfc'             => 'XXJOHNDOEXX00',
      'time_zone'           => 'America/Mexico_City',
      'siteaddress'         => '{"cp":"78956","calle":"Un domicilio","num_ext":"3569","num_int":"H-255","colonia":"Roma","ciudad":"Cua\u00fahtemoc","estado":"CDMX","pais":"M\u00e9xico"}',

      'site_smtp_host'      => '',
      'site_smtp_port'      => '',
      'site_smtp_email'     => '',
      'site_smtp_password'  => '',

      'cron_repeat_time'    => 'week',
      'maintenance_mode'    => 0,
      'maintenance_time'    => 0,
      'sitetheme'           => 'orange',
      'email_alignment'     => 'right',
      'pdf_alignment'       => 'right',
      'updating_system'     => 0,
      'site_login_bg'       => null,
      'sidebar_bg'          => null,
      'sidebar_alignment'   => 'left',
      'sidebar_opacity'     => 1,
      'site_hotjar'         => null,
      'sitekeywords'        => json_encode(['envíos','guías prepagadas','dhl','fedex','ups','rastreo de envíos','rastrea tu envío','envía barato y rápido','guías baratas','redpack','Fedex','logística de envíos','erp de envíos','plataforma para vender envíos','plataforma para vender guías'], JSON_UNESCAPED_UNICODE),
      'email_sitename'      => '[Shippr] -',
      'email_template'      => 'jserp_template_02.php',
      'show_signs'          => 0,
      'site_regimen'        => 612,
      'site_suspended'      => 0,
      'siteemail'           => null,

      'bank_name'           => 'Shippr Banco Oficial',
      'bank_number'         => 'SUC-123',
      'bank_account_name'   => 'JOHN DOE TITULAR DE CUENTA',
      'bank_account_number' => '0011223456789',
      'bank_clabe'          => '6321480774589659481',

      'sitepublic'          => 0,
      'sitegmaps'           => '',

      // Shippr
      'aftership_api_key'   => null,
      'faq'                 => null,
      'faq_updated'         => null,
      'mp_client_id'        => null,
      'mp_client_secret'    => null,
      'mp_sandbox'          => 1,
      'siteplan'            => 'basic',
      'site_status'         => 0,
      'site_lv_opening'     => null,
      'site_lv_closing'     => null,
      'site_sat_opening'    => null,
      'site_sat_closing'    => null,
      'site_sun_opening'    => null,
      'site_sun_closing'    => null,
      'bank_card_number'    => null
    ];
  
    /** Loop each option and update it or add it */
    foreach ($default_options as $key => $value) {
      JS_Options::add_option($key , trim($value));
    }

    logger(sprintf('Reinicio de %s opciones completado con éxito', count($default_options)));
    return true;
  } catch (PDOException $e) {
    throw new Exception($e->getMessage(), 1);
  }
}

function seed_database($records = 20) {
  try {
  } catch (Exception $e) {
    throw new Exception($e->getMessage(), 1);
  }

  return true;
}

function disable_on_enter() {
  return '<!-- Prevent implicit submission of the form -->
  <button type="submit" style="display: none" aria-hidden="true" disabled></button>';
}