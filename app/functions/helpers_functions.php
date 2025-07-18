<?php

function generate_filename($size = 12,$span = 3) {
	if(!is_integer($size)){
		$size = 6;
	}
	
	$name = '';
	for ($i=0; $i < $span; $i++) { 
		$name .= randomPassword($size).'-';
	}

	$name = rtrim($name , '-');
	return strtolower($name);
}

function elapsed_time($timestamp, $precision = 2 , $lng = 'es') {
	switch ($lng) {
		case 'eng':
			$a = array('decade' => 315576000, 'year' => 31557600, 'month' => 2629800, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'min' => 60, 'sec' => 1);
			$plurals = ['decades','years','months','weeks','days','hours','minutes','seconds'];
			break;
		
		default:
			$a = array('decada' => 315576000, 'año' => 31557600, 'mes' => 2629800, 'semana' => 604800, 'día' => 86400, 'hora' => 3600, 'minuto' => 60, 'segundo' => 1);
			$plurals = ['decadas','años','meses','semanas','días','horas','minutos','segundos'];
			break;
	}

	if(!is_numeric($timestamp)){
		$timestamp = strtotime($timestamp);
	}

	$now = time();

	## If it's in the future
	$future = false;
	if($timestamp > $now){
		$future = true;
		$time = $timestamp - $now;
	} else {
		$time = $now - $timestamp;
	}

	$i = 0;
	$result = '';
	
  foreach($a as $k => $v) {
		$output = floor($time/$v);
		if($output > 0){
			$time = $i >= $precision ? 0 : $time - $output * $v;
			$is_plural = $output > 1 ? $plurals[$i] : $k;
			$output = $output ? $output.' '.$is_plural.' ' : '';
			$result .= $output;
			if($i == 2 && $output >= 6){
				return fecha(date('Y-m-d H:i:s',$timestamp));
			}
		}
		$i++;
	}

	switch ($lng) {
		case 'eng':
			return $result ? $result.'ago' : sprintf('%s %s to go','1',($result > 1 ? 'seconds' : 'second'));
			break;
		
		default:
			return $result ? sprintf('%s %s',($future ? 'Dentro de' : 'Hace'),$result) : sprintf('Dentro de %s %s','1', ($result > 1 ? 'segundos':'segundo'));
			break;
	}
}

function build_address($row) {
	if(!is_object($row)){
		$row = json_decode($row);
	}

	$output = '';

	if(isset($row->calle)){
		$output .= $row->calle.', ';
	}

	if(isset($row->num_ext) && !empty($row->num_ext)){
		$output .= $row->num_ext.', ';
	}

	if(isset($row->num_int)){
		$output .= 'Int. '.(empty($row->num_int) || $row->num_int === 0 ? 'S/N' : $row->num_int).', ';
	}

	$output .= $row->colonia.', ';
	$output .= $row->ciudad.', ';
	$output .= $row->estado.', ';
	$output .= $row->cp;

	return $output;
}

/**
 * Valida el nombre de una persona humana
 *
 * @param string $name
 * @return void
 */
function validate_name($name) {
	$pattern = '/^[A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+([\ A-Za-z\x{00C0}-\x{00FF}][A-Za-z\x{00C0}-\x{00FF}\'\-]+)*/u';
	if(preg_match($pattern , $name)){
		return true;
	}

	return false;
}

function bg_image($image , $w = 900 , $h = 400) {
	if(!is_file($image)){
		return "style=\"background-image: url('https://via.placeholder.com/".$w."x".$h."');\"";
	}

	return "style=\"background-image: url('".$image."');\"";
}

/**
 * Function to log processes to a file
 *
 * @param string $message
 * @param string $type
 * @return bool
 */
function logger($message , $type = 'debug' , $output = false) {
  $types = ['debug','import','info','success','warning','error'];

  if(!in_array($type , $types)){
    $type = 'debug';
  }

  $now_time = date("d-m-Y H:i:s");

  $message = "[".strtoupper($type)."] $now_time - $message";

  if(!$fh = fopen(LOGS."jserp_log.log", 'a')) { 
    error_log("Can not open this file on ".LOGS."store_server.log");
    return false;
  }

  fwrite($fh, "$message\n");
	fclose($fh);
	if($output){
		print "$message\n";
	}

  return true;
}

/**
 * Creates a google static map url
 *
 * @param string $location
 * @param integer $zoom
 * @param integer $size_x
 * @param integer $size_y
 * @param string $type
 * @return void
 */
function static_map($location , $zoom = 15 , $size_x = 800 , $size_y = 400 , $type = 'roadmap') {
	$output = '';
	if(!defined('STATIC_GMAPS')){
		return false;
	}

	$output = 'https://maps.googleapis.com/maps/api/staticmap?center='.urlencode($location). '&markers=size:small|color:red|label:S|'.urlencode($location).'&zoom='.$zoom.'&size='.$size_x.'x'.$size_y.'&scale=2&maptype='.$type.'&key='.STATIC_GMAPS;

	return $output;
}

/**
 * Convert number of bytes largest unit bytes will fit into.
 *
 * It is easier to read 1 KB than 1024 bytes and 1 MB than 1048576 bytes. Converts
 * number of bytes to human readable number by taking the number of that unit
 * that the bytes will go into it. Supports TB value.
 *
 * Please note that integers in PHP are limited to 32 bits, unless they are on
 * 64 bit architecture, then they have 64 bit size. If you need to place the
 * larger size then what PHP integer type will hold, then use a string. It will
 * be converted to a double, which should always have 64 bit length.
 *
 * Technically the correct unit names for powers of 1024 are KiB, MiB etc.
 *
 * @since 2.3.0
 *
 * @param int|string $bytes    Number of bytes. Note max integer size for integers.
 * @param int        $decimals Optional. Precision of number of decimal places. Default 0.
 * @return string|false False on failure. Number string on success.
 */
function filesize_formatter($size , $precision = 1) {
	$units = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
	$step = 1024;
	$i = 0;
	while (($size / $step) > 0.9) {
		$size = $size / $step;
		$i++;
	}
	return round($size, $precision) . $units[$i];
}

/**
 * Generar un tooltip para insertar en cualquier elemento
 * 
 * @var title
 */
function tooltip($title = null){
	if($title == null){
		throw new Exception("Valor ".$title.' no válido.', 1);
	}

	return 'data-toggle="tooltip" title="'.$title.'"';
}


/**
 * Generar un link para insertar con variables
 * 
 */
function buildURL($url , $params = [] , $redirection = true) {
	
	// Check if theres a ?
	$query     = parse_url($url, PHP_URL_QUERY);
	$_params[] = '_t='.CSRF_TOKEN;
	$_params[] = 'hook='.strtolower(get_system_name());
	$_params[] = 'action=doing-trask';
	
	// Si requiere redirección
	if($redirection){
		$_params[] = 'redirect_to='.urlencode(CUR_PAGE);
	}

	// Si no es un array regresa la url original
	if (!is_array($params)) {
		return $url;
	}

	// Listando parametros
	foreach ($params as $key => $value) {
		$_params[] = sprintf('%s=%s', urlencode($key), urlencode($value));
	}
	
	$url .= strpos($url, '?') ? '&' : '?';
	$url .= implode('&', $_params);
	return $url;
}

function buildURL2($url , $params = [] , $redirection = true) {
  // Check if theres a ?
	$query = parse_url($url, PHP_URL_QUERY);
	$_params[] = '_t='.CSRF_TOKEN;
	$_params[] = 'hook='.strtolower(get_system_name());
	$_params[] = 'action=doing-trask';

	// Si lo hay, query string
	if ($query) {
		if (!is_array($params)) {
			throw new Exception("Ingresa un array asociativo key=value", 1);			
		}

		$url .= (strpos($url, '?') ? '&' : '?');

		if($redirection){
			$_params[] = 'redirect_to='.urlencode(CUR_PAGE);
		}

		foreach ($params as $key => $value) {
			$_params[] = urlencode($key) . '=' . urlencode($value);
		}

		$url .= implode('&', $_params);

	} else {

		if (!is_array($params)) {
			throw new Exception("Ingresa un array asociativo key=value", 1);
		}

		$url .= (strpos($url,'?') ? '&' : '?') ;
		
		if($redirection){
			$_params[] = 'redirect_to='.urlencode(CUR_PAGE);
		}

		foreach ($params as $key => $value) {
			$_params[] = urlencode($key) . '=' . urlencode($value);
		}

		$url .= implode('&', $_params);

	}

	return $url;
}

/**
 * Verificar CSRF Token
 * 
 * @var $_POST['csrf]
 * @var $_SESSION['token]
 */
function validate_csrf($csrf_token, $strict_mode = false, $redirection = false) {
	if(CSRF::validate($csrf_token, $strict_mode)) {
		return true; // token válido
	}

	// Loggear intento loggear el intento de uso del token
	logger('CSRF no válido detectado: "'.$csrf_token.'" el '.fecha(ahora()));
	logger('Dirección IP registrada: '.$_SERVER['REMOTE_ADDR']);
	CSRF::regenerate();

	if($redirection) {
		Flasher::access();
		Taker::back();
	}
	
	return false;
}

function insert_inputs() {
	$output = '';

	if(isset($_POST['redirect_to'])){
		$location = $_POST['redirect_to'];
	} else if(isset($_GET['redirect_to'])){
		$location = $_GET['redirect_to'];
	} else {
		$location = CUR_PAGE;
	}

	$output .= '<input type="hidden" name="redirect_to" value="' . $location . '">';
	$output .= '<input type="hidden" name="timecheck" value="' . time() . '">';
	$output .= '<input type="hidden" name="csrf" value="'.CSRF_TOKEN.'">';
	$output .= '<input type="hidden" name="action" value="post">';
	$output .= '<input type="hidden" name="hook" value="shippr">';
	return $output;
}

/**
 * Convertir a objeto cualquier array
 * @param array
 * @param var
 */
function toObj($array = []) {
	if (empty($array)) {
		throw new Exception("El array no tiene elementos para convertir a objetos " . $array, 1);
	}
	return json_decode(json_encode($array), false);
}

/**
 * Re-acomodar multiple file upload
 */
function multiUpload($files) {
	if(empty($files)) {
		return false;
	}
	
	foreach ($files['error'] as $err) {
		if(intval($err) === 4){
			return false;
		}
	}
	
	$file_ary   = array();
	$file_count = (is_array($files)) ? count($files['name']) : 1;
	$file_keys  = array_keys($files);
	
	for ($i = 0; $i < $file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $files[$key][$i];
		}
	}

	return $file_ary;
}

/**
 * Función para mostrar las redes sociales de cada usuario
 */
function redesSociales($redes) {
	if (empty($redes)) {
		return '';
	}

	$redes = json_decode($redes);
	$output = '';

	foreach ($redes as $key => $val) {

		if (!empty($val)) {
			switch ($key) {
				case 'facebook':
					$output .= '<a href="' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-facebook"></i></a>';
					break;
				case 'twitter':
					$output .= '<a href="' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-twitter"></i></a>';
					break;
				case 'google':
					$output .= '<a href="' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-google-plus"></i></a>';
					break;
				case 'instagram':
					$output .= '<a href="' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-instagram"></i></a>';
					break;
				case 'whatsapp':
					$output .= '<a href="tel:' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-whatsapp"></i></a>';
					break;
				case 'email':
					$output .= '<a href="mailto:' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-envelope"></i></a>';
					break;
				case 'snapchat':
					$output .= '<a href="' . $val . '" data-toggle="tooltip" title="' . ucfirst($key) . '"><i class="fa fa-snapchat"></i></a>';
					break;
				default:
			}
		}


	}

	return $output;

}

/**
 * Lista todos los archivos dentro de un folder y subfolders
 */
// Does not support flag GLOB_BRACE        
function glob_recursive($pattern, $flags = 0) {
	$files = glob($pattern, $flags);
	foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir) {
		$files = array_merge($files, glob_recursive($dir . '/' . basename($pattern), $flags));
	}
	return $files;
}

/**
 * Flashing notifications
 * success
 * error
 * info
 * tip
 * warning
 */
function flasher() {
	$theres_is = false;
	$types = ["success", "danger", "warning", "info", "tip"];

	$output = '<div class="row"><div class="col">';
	foreach ($types as $type) {

		if (isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
			foreach ($_SESSION[$type] as $msj) {
				$theres_is = true;
				$output .=
					'<div class="alert alert-' . $type . ' alert-dismissible fade show" role="alert">
  				' . $msj . '
  				<button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
    				<span aria-hidden="true">&times;</span>
  				</button>
				</div>';

			}
			unset($_SESSION[$type]);
		}
	}
	$output .= '</div></div>';
	$output .= '<div class="m-b-20"></div>';

	echo ($theres_is ? $output : '');
	return true;
}

/**
Formateo de la hora en tres variantes
d M, Y,
m Y,
d m Y,
mY,
d M, Y time
 **/
function fecha($fecha, $type = 'd M, Y') {
	setlocale(LC_ALL, "es_MX.UTF-8", "es_MX", "esp");
	$diasemana = strftime("%A", strtotime($fecha));
	$diames = strftime("%d", strtotime($fecha));
	$dia = strftime("%e", strtotime($fecha));
	$mes = strftime("%B", strtotime($fecha));
	$anio = strftime("%Y", strtotime($fecha));
	$hora = strftime("%H", strtotime($fecha));
	$minutos = strftime("%M", strtotime($fecha));
	$date = [
		'año' => $anio,
		'mes' => ucfirst($mes),
		'mes_corto' => substr($mes, 0, 3),
		'dia' => $dia,
		'dia_mes' => $diames,
		'dia_semana' => ucfirst($diasemana),
		'hora' => $hora,
		'minutos' => $minutos,
		'tiempo' => $hora . ':' . $minutos
	];
	switch ($type) {
		case 'd M, Y':
			return $date['dia'] . ' de ' . $date['mes'] . ', ' . $date['año'];
			break;
		case 'm Y':
			return $date['mes'] . ' ' . $date['año'];
			break;
		case 'd m Y':
			return $date['dia'] . ' ' . $date['mes_corto'] . ' ' . $date['año'];
			break;
		case 'mY':
			return ucfirst($date['mes_corto']).', '.$date['año'];
			break;
		case 'd M, Y time':
			return $date['dia'].' de '.$date['mes'].', '.$date['año'].' a las '.date('H:i A', strtotime($fecha));
			break;
		default:
			return $date['dia'] . ' de ' . $date['mes'] . ', ' . $date['año'];
			break;
	}
}

/**
 * Formateo de moneda 
 */
function money($number , $symbol = null) {
	return ($symbol !== NULL ? $symbol : '$').number_format($number, 2, ".", ",");
}

function unmoney($number) {
	return str_replace(',', '', $number);
}

/*
Agregar clase de menú activo según el controlador
 */
function current_link($controllers, $methods = []) {
	if(!is_array($controllers) || !is_array($methods)) {
		return false;
	}

	if(empty($methods)) {
		return in_array(CONTROLLER , $controllers) ? 'active' : false;	
	}
	
	return in_array(CONTROLLER , $controllers) && in_array(METHOD, $methods) ? 'active' : false;
}

/*
Muestra un saludo de bienvenida
 */
function greeting() {
	if (date("H") > 6 && date("H") < 12) {
		return "Buenos días";
	} elseif (date("H") >= 12 && date("H") < 19) {
		return "Buenas tardes";
	} elseif (date("H") >= 19) {
		return "Buenas noches";
	} else {
		return "Hola";
	}
}

/*
Flash error o mensaje de usuario
 */
function flash($mensaje, $type = "error") {
	if ($type == "mensaje") {
		$_SESSION['mensaje'] = clean($mensaje);
		unset($_SESSION['mensaje']);
	} elseif ($type == "error") {
		$_SESSION['error'] = clean($mensaje);
		unset($_SESSION['error']);
	}
}

/*
Valida un string con solo letras
 */
function onlyLetters($string) {
	if (!preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ]{5,31}$/', $string)) {
		return true;
	} else {
		return false;
	}
}

function validateName($string) {
	if (!preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ\s]{5,31}$/', $string)) {
		return true;
	} else {
		return false;
	}
}

## Sanitizar los valores ingresados en input
function clean($str, $cleanhtml = false) {
	$str = @trim(@rtrim($str));

	if ($cleanhtml == true) {
		return htmlspecialchars($str);
	}
	
	return $str;
}

## Da la fecha y hora actual
function ahora() {
	$time = date("Y-m-d H:i:s");
	return $time;
}

// Generar random password
function randomPassword($tamaño = 8, $type = 'default') {
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	if ($type === 'numeric') {
		$alphabet = '1234567890';
	}
	$pass = array(); //remember to declare $pass as an array
	$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	for ($i = 0; $i < $tamaño; $i++) {
		$n = rand(0, $alphaLength);
		$pass[] = $alphabet[$n];
	}
	return str_shuffle(implode($pass)); //turn the array into a string
}

#-------------------------------------
## Obtener la Ip del cliente
#-------------------------------------
function ipCliente() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if (getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if (getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if (getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if (getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if (getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}

#-------------------------------------
##  Formato de Fechas Español
#-------------------------------------
function fechaEspanol($fecha) {
	setlocale(LC_ALL, "es_ES.utf-8", "es_ES", "esp");
	$diasemana = strftime("%A", strtotime($fecha));
	$diames    = strftime("%d", strtotime($fecha));
	$mes       = strftime("%B", strtotime($fecha));
	$anio      = strftime("%Y", strtotime($fecha));
	$hora      = strftime("%H", strtotime($fecha));
	$minutos   = strftime("%M", strtotime($fecha));
	$fecha2    = [
		'año'       => $anio,
		'mes'       => substr($mes, 0, 3),
		'dia'       => $diames,
		'diasemana' => $diasemana,
		'hora'      => $hora,
		'minutos'   => $minutos
	];
	return ($fecha2);
}

#-------------------------------------
##  Sluggify URL
#-------------------------------------
function sluggify($url) {
	# Prep string with some basic normalization
	return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($url, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}

function get_breadcrums($bcs = []) {
	$output = '<div class="row"><div class="col-xl-12"><nav aria-label="breadcrumb"><ol class="breadcrumb">';

	if (empty($bcs)){
		$output .= '<li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>';
	} else {
		/** Process all links */
		$last_bc = end($bcs);
		$output .= '<li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>';
		foreach ($bcs as $bc) {
			if($bc[0] !== $last_bc[0]){
				$output .= '<li class="breadcrumb-item"><a href="'.$bc[0].'">'.$bc[1].'</a></li>';
			} else {
				$output .= '<li class="breadcrumb-item active" aria-current="page">'.$bc[1].'</li>';
			}
		}
	}

	$output .= '</ol></nav></div></div>';

	return $output;
}

function get_module($view , $d = [] , $obj_parsed = false) {
	$file_to_include = MODULES.$view.'View.php';
	$output = '';
	
	// Data to be used inside the template
	$d = $obj_parsed ? toObj($d) : $d;
	
	if(!is_file($file_to_include)) {
		return false;
	}

	ob_start();
	require_once $file_to_include;
	$output = ob_get_clean();

	return $output;
}