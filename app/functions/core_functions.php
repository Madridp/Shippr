<?php
/**
 * Checks wheter serp is on local environment or not
 *
 * @return boolean
 */
function is_local() {
	$on_localhost = array('127.0.0.1','::1');
	return (in_array($_SERVER['REMOTE_ADDR'] , $on_localhost) ? true : false);
}

/**
 * Gets company login background image
 *
 * @return void
 */
function get_site_login_bg() {
	$bg = get_option('site_login_bg');
	
	/** Check if exists */
	if(!is_file(UPLOADS.$bg)){
		return (is_file(IMG.'jserp-login-bg.png') ? URL.IMG.'jserp-login-bg.png' : 'https://via.placeholder.com/2000x1300?text=SERP');
	}

	return URL.UPLOADS.$bg;
}

/**
 * Gets the email address for the specified purpose
 * anticipos, reportes, contacto, contabilidad, and more coming
 *
 * @param string $area
 * @return void
 */
function get_email_address_for($area) {

	$options = ['reportes' , 'anticipos' , 'contabilidad' , 'contacto'];

	if(!in_array($area , $options)){
		$email = get_option('site_smtp_email');

		return $email;
	}

	$email = get_option('email_address_for_'.$area);

	if(!$email){
		$email = get_option('site_smtp_email');
	}

	if(is_local()){
		$email = 'jslocal@localhost.com';
	}

	return $email;
}

/**
 * Gets the server name to connect for
 * SMTP email
 *
 * @return void
 */
function get_smtp_host() {
	$host = get_option('site_smtp_host');
	return $host;
}

/**
 * Gets SMTP server port number
 * to stablish connection
 *
 * @return void
 */
function get_smtp_port() {
	$port = get_option('site_smtp_port');

	return $port;
}

/**
 * Get noreplay email address to send emails from
 *
 * @return void
 */
function get_noreply_email() {
	$email = get_option('site_smtp_email');

	if(!$email || is_local()){
		return 'jslocal@localhost.com';
	}

	return $email;

	$domain = explode('@', $email);

	$email = 'noreply@'.(isset($domain[1]) ? $domain[1] : 'localhost.com');

	return $email;
}

/**
 * Gets SMTP default email address for web application
 * will be use to send compound emails with no error
 *
 * @return void
 */
function get_smtp_email() {
	$email = get_option('site_smtp_email');

	if(is_local()){
		$email = 'jslocal@localhost.com';
	}

	return $email; //regresar el email en este caso
}

/**
 * Gets email address smtp password to login
 *
 * @return void
 */
function get_smtp_password() {
	$pw = get_option('site_smtp_password');
	return $pw;
}

/**
 * Gets the alignment option for email templates
 *
 * @return void
 */
function get_email_alignment() {
	$alignment = get_option('email_alignment');

	$options = ['left','center','right'];

	if(!in_array($alignment , $options)){
		$alignment = 'left';
	}

	return $alignment;
}


/**
 * Gets the alignment options for pdf documents
 *
 * @return void
 */
function get_pdf_alignment() {
	$alignment = get_option('pdf_alignment');

	$options = ['left','center','right'];

	if(!in_array($alignment , $options)){
		$alignment = 'center';
	}

	return $alignment;
}


function get_sitetheme() {
	$theme = get_option('sitetheme');
	$themes = get_theme_colors();

	if(!in_array($theme, $themes)){
		$theme = 'orange';
	}

	return $theme;
}

function load_sitetheme($theme) {
	if(!is_file(CSS.'theme-'.$theme.'.css')){
		return '<link href="'.URL.CSS.'theme-blue.css" rel="stylesheet" id="sitetheme" />';
	}

	return '<link href="'.URL.CSS.'theme-'.$theme.'.css" rel="stylesheet" id="sitetheme" />';
}

/**
 * Get current domain registered together with the sitekey
 * if it's not valid, web application wont work
 *
 * @return void
 */
function get_sitedomain() {
	$domain = get_option('domain');

	if(!$domain || empty($domain)){
		$domain = 'www.notregistered.com';
	}

	/** We can add an API call and validate this key right inside here */
	return $domain;
}

/** Gets the web application key
 * every Joystick client must have one
 * If it does not, shut down the system.
 */
function get_sitekey() {
	$sitekey = get_option('sitekey');

	if(!$sitekey || empty($sitekey)){
		die('You are not allowed to use this application, site key required.');
	}

	return $sitekey;
}

/** Get all timezones to use */
function get_timezones() {
	$timezones = file_get_contents(JS . 'timezones.json');
	$timezones = json_decode($timezones);
	foreach ($timezones as $t) {
		if($t->group == 'America'){
			return $t->zones;
		}
	}
	return $timezones;
}

/**
 * Gets current timezone set on configurations
 *
 * @return string
 */
function get_timezone() {
	$timezone = get_option('time_zone');

	if(!in_array($timezone , timezone_identifiers_list())){
		return 'America/Mexico_City';
	}

	return $timezone;
}

/** Get the web application name or company name */
function get_sitename() {
	return ($sitename = get_option('sitename')) ? $sitename : get_system_name();
}

/**
 * Gets the default system name: Shippr
 *
 * @return string
 */
function get_system_name() {
	return 'Shippr';
}

function get_email_system_name() {
	return sprintf('[%s]', get_system_name());
}

/**
 * Gets shipper url
 *
 * @return void
 */
function get_system_url() {
	return 'http://www.shippr.com.mx';
}

/** Get the company slogan or catch phrase */
function get_siteslogan() {
	return (JS_Options::get_option('siteslogan') ? JS_Options::get_option('siteslogan') : '');
}

/** Get the company description, what they do */
function get_sitedesc() {
	$default = get_system_name().', el mejor ERP de administración corporativa en México, administra todo en tu empresa o negocio, ten el control total.';
	return (JS_Options::get_option('sitedesc') ? JS_Options::get_option('sitedesc') : $default);
}

/** Gets company keywords for search engines */
function get_sitekeywords() {
	$keywords = ['jserp','ERP','Administración','plataforma de administración','empresas de servicios méxico','plataforma web','ERP de Sercicio Médico','diseño a la medida','diseño web'];

	if($res = JS_Options::get_option('sitekeywords')) {
		$keywords = (array) json_decode($res);
	}

	return implode(',' , $keywords);
}

/**
 * Gets meta robots of the website to tell search engines to crawl and index or not
 * the application
 *
 * @return void
 */
function get_site_public() {
	$res = get_option('site_public');
	return ((int) $res === 1 ? true : false);
}

function get_site_google_analytics($hide_on_local = true) {
	$output = '';
	if($res = JS_Options::get_option('site_google_analytics')) {
		$output = $res;
	}

	return (!is_local() ? $output : ($hide_on_local ? false : $output));
}

/**
 * Gets hotjar extension snipped
 *
 * @param boolean $hide_on_local
 * @return void
 */
function get_site_hotjar($hide_on_local = true) {
	$output = '';
	if($res = JS_Options::get_option('site_hotjar')) {
		$output = $res;
	}

	return (!is_local() ? $output : ($hide_on_local ? false : $output));
}

/**
 * Gets all header scripts to be used as google analytics
 * hotjar
 * realtime chat
 * etc
 *
 * @return void
 */
function get_header_scripts() {
	$output = '';
	if($res = get_option('header_scripts')) {
		$output = $res;
	}

	return $output;
}

/** Gets the company favicon for the web application */
function get_header_sitefavicon() {
	$favicon = get_option('sitefavicon');

	if(!is_file(UPLOADS.$favicon)) {
		$favicon = URL.FAVICON.'shippr.ico';
		$output  = '<link rel="shortcut icon" href="'.$favicon.'?v='.get_siteversion().'" type="image/x-icon">'."\n";
		$output .= '<link rel="icon" href="'.$favicon.'?v='.get_siteversion().'" type="image/x-icon">';
		return $output;
	}

	$favicon = URL.UPLOADS.$favicon;
	$output  = '<link rel="shortcut icon" href="'.$favicon.'?v='.get_siteversion().'" type="image/x-icon">'."\n";
	$output .= '<link rel="icon" href="'.$favicon.'?v='.get_siteversion().'" type="image/x-icon">';
	return $output;
}

/** Gets the complete file path to company favicon */
function get_sitefavicon() {
	$favicon = get_option('sitefavicon');

	if(!is_file(UPLOADS.$favicon)) {
		return URL.FAVICON.'shippr.ico';
	}

	return URL.UPLOADS.$favicon;
}

/** Get the company emaiil */
function get_siteemail() {
	$email = get_option('siteemail');

	if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
		return get_smtp_email();
	}
	
	return $email;
}

/** Get the company telephone */
function get_siteph() {
	return get_option('siteph');
}

/** Get full address of company as an object or empty object with just the country set by default */
function get_siteaddress() {
	$data =
	[
		'cp'      => null,
		'calle'   => null,
		'num_ext' => null,
		'num_int' => null,
		'colonia' => null,
		'ciudad'  => null,
		'estado'  => null,
		'pais'    => 'México'		
	];

	$addr = get_option('siteaddress');

	if(empty($addr)){
		return json_decode(json_encode($data));
	}

	return json_decode($addr);
}

/** Get the company or person RFC number for taxes */
function get_siterfc() {
	return ($rfc = get_option('siterfc')) ? $rfc : '';
}

/** Gets company legal name for taxes */
function get_siterazonSocial() {
	return ($rz = get_option('siterazonSocial')) ? $rz : '';
}

/** Get the remote URL or production URL of the web application */
function get_siteurl() {
	return ($url = get_option('siteurl')) ? $url : URL;
}

/** Get the company name for email titles */
function get_email_sitename() {
	//return sprintf('[%s] -', get_system_name());
	$email_sitename = get_option('email_sitename');
	
	if(!$email_sitename) {
		$email_sitename = ($email = get_option('sitename')) ? $email : get_system_name();
		$email_sitename = str_replace(' ','',strtoupper(trim($email_sitename)));
		$email_sitename = (strlen($email_sitename) > 6) ? substr($email_sitename,0,10) : $email_sitename;
		return '['.$email_sitename.']';
	}

	return $email_sitename;
}

/** Get the web application logo */
function get_sitelogo($size = null) {
	
	/** Fix URL to display it properly */
	$logo = get_option('sitelogo');
	$path = str_replace('\\', '/', URL.IMG);

	// Si existe
	if(!is_file(IMG.$logo)){
		return get_system_logo($size == null ? 1000 : $size);
	}

	$basename  = pathinfo($logo , PATHINFO_FILENAME);
	$extension = pathinfo($logo , PATHINFO_EXTENSION);

	if($size === null){
		return URL.IMG.$logo;
	}
	
	return URL.IMG.$logo;
}

/**
 * Gets the system default logo complete path
 *
 * @param int $size
 * @return void
 */
function get_system_logo($size = 1000, $type = 'color') {
	$img = URL.IMG.'shippr_logo_%s%s.png';
	$type = ($type == 'color' ? '' : '_white');
	switch ($size) {
		case 1000:
			return sprintf($img, $size, $type);
			break;
		case 500:
			return sprintf($img, $size, $type);
			break;
		case 250:
			return sprintf($img, $size, $type);
			break;
		default:
			return sprintf($img, $size, $type);
	}
}

/**
 * Gets the company logo filename
 *
 * @return void
 */
function get_sitelogo_filename() {
	$logo = get_option('sitelogo');

	/** Check if exists */
	if(!is_file(IMG.$logo)){
		return 'serp-1000.png';
	}

	return $logo;
}

/** Gets all company bancary information for documents and pdfs */
function get_bank_info() {
	$bank_info = 
	[
		'name'           => (JS_Options::get_option('bank_name') ? JS_Options::get_option('bank_name') : null),
		'number'         => (JS_Options::get_option('bank_number') ? JS_Options::get_option('bank_number') : null),
		'account_name'   => (JS_Options::get_option('bank_account_name') ? JS_Options::get_option('bank_account_name') : null),
		'account_number' => (JS_Options::get_option('bank_account_number') ? JS_Options::get_option('bank_account_number') : null),
		'clabe'          => (JS_Options::get_option('bank_clabe') ? JS_Options::get_option('bank_clabe') : null),
		'card_number'    => (JS_Options::get_option('bank_card_number') ? JS_Options::get_option('bank_card_number') : null)
	];

	return json_decode(json_encode($bank_info));
}

/** Gets the repeat time for notifications
 * to be send to users
 * l to v
 * l,m,v
 * whole week
 */
function get_cron_repeat_time() {
	$options =
	[
		'l,m,v' => 'Lunes, Martes y Viernes',
		'l-v'   => 'Lunes a Viernes',
		'week'  => 'Todos los días'
	];

	$frecuency = (JS_Options::get_option('cron_repeat_time') ? JS_Options::get_option('cron_repeat_time') : 'l-v');

	return $frecuency;
}

/**
 * Gets the frecuency wich emails will be send to users
 *
 * @return void
 */
function get_frecuency() {
	$options =
		[
		'l,m,v' => 'Lunes, Miércoles y Viernes',
		'l-v'   => 'Lunes a Viernes',
		'week'  => 'Todos los días'
	];

	return json_decode(json_encode($options));
}

/** Gets web application current version */
function get_siteversion() {
	return SITEVERSION;
	$siteversion = get_option('siteversion');
	
	if(!$siteversion) {
		$siteversion = '1.0.0';
	}

	/**
	 * If user set it up as an array
	 * we need to parse it to a string
	 * imploding all values
	 */
	if (is_array($siteversion)) {
		return implode('.', $siteversion);
	}

	/**
	 * if user set it as string we just
	 * parse it and return it as
	 * it is.
	 */
	if (is_string($siteversion)) {
		return trim($siteversion);
	}

	return $siteversion;
}

/**
 * Gets the db version
 * deprecated
 *
 * @return void
 */
function get_db_version() {
	$db_version = get_option('db_version');

	if(!$db_version){
		return '1.0.0';
	}

	return $db_version;
}

/**
 * Gets all options saved on system db
 *
 * @return void
 */
function get_all_options() {
	$options = JS_Options::all();
	return ($options) ? $options : [];
}

/**
 * Gets the global array of options saved on the system
 *
 * @param string $option
 * @param boolean $return_row
 * @return mixed
 */
function get_option($option , $return_row = false) {
	global $JS_Settings;

	foreach ($JS_Settings as $i => $row) {
		if($option == $row['opcion']) {
			return ($return_row) ? $row : $row['valor'];
		}
	}

	return false;
}

/**
 * Gets the sidebar background image
 *
 * @return void
 */
function get_sidebar_bg() {
	global $JS_Settings;

	$bg = get_option('sidebar_bg');

	if(!is_file(UPLOADS.$bg)) {
		return URL.IMG.'bg-sidebar.jpg';
	}

	return str_replace('\\','/',URL.UPLOADS.$bg);
}

/**
 * Gets the public URL to be used
 *
 * @param string $controller_name
 * @return void
 */
function get_public_url($controller_name = 'p') {
  return URL.$controller_name.'/';
}

/**
 * Gets the company facebook page
 *
 * @return void
 */
function get_company_facebook_page() {
	$facebook = get_option('facebook_page');
	$default  = 'https://www.facebook.com/joystickdesign';

	if(!$facebook) {
		return $default;
	}

	return $facebook;
}

/**
 * Gets the company facebook og image
 *
 * @return void
 */
function get_company_facebook_image() {
	$image = get_option('facebook_image');
	$default = 'placeholder_facebook_card.png';

	if(!$image || !is_file(UPLOADS.$image)) {
		return URL.IMG.$default;
	}

	return URL.UPLOADS.$image;
}

/**
 * Gets the company twitter username
 *
 * @return void
 */
function get_company_twitter() {
	$twitter = get_option('twitter_username');
	$default = '@JoystickDG';

	if(!$twitter) {
		return $default;
	}

	return $twitter;
}

/**
 * Gets the company twitter's image
 *
 * @return void
 */
function get_company_twitter_image() {
	$image = get_option('twitter_image');
	$default = 'placeholder_twitter_card.png';

	if(!$image || !is_file(UPLOADS.$image)) {
		return URL.IMG.$default;
	}

	return URL.UPLOADS.$image;
}

/**
 * Gets the default company email template to be used for
 * emails
 *
 * @return void
 */
function get_email_template() {
	$template = get_option('email_template');
	$default = 'jserp_main.php';
	$default = 'jserp_template_02.php';
	return $default;

	if(!is_file(EMAIL_TEMPLATES.$template)) {
		return $default;
	}

	return $template;
}

/**
 * Checks whener the site is under demo mode
 *
 * @return boolean
 */
function is_demo() {
	$is_demo = get_option('demosite');
	return ((int) $is_demo === 1);
}

/**
 * Función para saber si ha experidado el sitio demo
 * 1.0.7.1
 *
 * @return boolean
 */
function is_demo_expired() {
	$now = time();
	return ($now > demo_expiration());
}

/**
 * Regresa el tiempo de expiración del sitio demo
 * 1.0.7.1
 *
 * @return mixed
 */
function demo_expiration() {
	$expiration_time = get_option('demosite_expiration');
	return $expiration_time;
}

/**
 * Validates if the site is currenctly a demosite
 *
 * @return void
 */
function validate_demosite() {
	if (!is_demo() || is_root(get_user_role())) {
		return true;
	}

	// Prevenir el ingreso o la acción del usuario en un sitio demo
	Flasher::save(sprintf('Acción no disponible en la versión demo del sistema, gracias <b>%s</b> por probar <b>%s</b>', get_user_name(), get_system_name()), 'danger');
	Flasher::save(sprintf('¿Te está gustando <b>%s</b>?, déjanos tus comentarios <a class="text-dark" href="%s">aquí</a>.', get_system_name(), 'mailto:hellow@joystick.com.mx'), 'primary');
	Taker::back();
}

/**
 * Gets powered by text
 *
 * @param boolean $return_html
 * @return void
 */
function get_powered_by($return_html = false) {
	return ($return_html) ? sprintf('Powered by <a href="%s" target="_blank">%s</a> de <a href="%s" target="_blank">%s</a>.', 'https://www.joystick.com.mx/js-erp', get_system_name(), 'https://www.joystick.com.mx', 'Joystick') : 'Powered by Joystick';
}

/**
 * Gets system copyrights for footer or anything else
 *
 * @param boolean $return_html
 * @return void
 */
function get_system_copyrights($return_html = false) {
	return $return_html ? sprintf('<a class="text-theme" href="%s" target="_blank">%s</a> © <span id="writeCopyrights">%s</span> Todos los derechos reservados.', 'https://www.joystick.com.mx', get_system_name(), date('Y')) : sprintf('%s © %s Todos los derechos reservados.', get_system_name(), date('Y'));
}

/**
 * Gets the serp API url to be used
 *
 * @param boolean $turn_on_production
 * @return void
 */
function get_api_url($turn_on_production = false) {
	$dev        = URL.'api/';
	$production = 'https://www.joystick.com.mx/';
	if($turn_on_production) {
		return $production;
	}

	return is_local() ? $dev : $production;
}

/**
 * Checks if signs should be shown
 *
 * @return void
 */
function get_show_signs() {
	$res = (int) get_option('show_signs');

	return $res === 1 ? true : false;
}

/**
 * Gets regimen fiscal id
 *
 * @return void
 */
function get_site_regimen_id() {
	$regimen_id = get_option('site_regimen_id');
	return $regimen_id;
}

/**
 * Gets company regimen
 *
 * @return void
 */
function get_site_regimen() {
	$regimen = get_option('site_regimen');
	return $regimen;
}

/**
 * Checks if a user is logged in or not
 *
 * @return boolean
 */
function is_logged() {
	global $JS_Logged;

	return $JS_Logged;
}

/**
 * Checks if a module is active or not
 *
 * @param string $module_name
 * @return boolean
 */
function is_module_active($module_name = null) {
	return true;
}

/**
 * Gets the theme colors available for SERP
 *
 * @return array
 */
function get_theme_colors() {
	$themes = ['blue','green','orange','dark','purple','black','pink','brown','grey'];
	return $themes;
}

function get_sidebar_alignment() {
	$alignment = get_option('sidebar_alignment');
	$default = 'left';

	if(!$alignment) {
		return $default;
	}

	return $alignment;
}

function get_sidebar_opacity() {
	$opacity = get_option('sidebar_opacity');
	$default = 0;

	if(!$opacity) {
		return $default;
	}

	return $opacity;
}

function is_site_suspended() {
	$res = get_option('site_suspended');

	return ((int) $res ===1 );
}

function get_user_os() {
	if (isset( $_SERVER ) ) {
		$agent = $_SERVER['HTTP_USER_AGENT'];
	} else {
		global $HTTP_SERVER_VARS;
		if ( isset( $HTTP_SERVER_VARS ) ) {
			$agent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
		}
		else {
			global $HTTP_USER_AGENT;
			$agent = $HTTP_USER_AGENT;
		}
	}
	$ros[] = array('Windows XP', 'Windows XP');
	$ros[] = array('Windows NT 5.1|Windows NT5.1)', 'Windows XP');
	$ros[] = array('Windows 2000', 'Windows 2000');
	$ros[] = array('Windows NT 5.0', 'Windows 2000');
	$ros[] = array('Windows NT 4.0|WinNT4.0', 'Windows NT');
	$ros[] = array('Windows NT 5.2', 'Windows Server 2003');
	$ros[] = array('Windows NT 6.0', 'Windows Vista');
	$ros[] = array('Windows NT 7.0', 'Windows 7');
	$ros[] = array('Windows CE', 'Windows CE');
	$ros[] = array('(media center pc).([0-9]{1,2}\.[0-9]{1,2})', 'Windows Media Center');
	$ros[] = array('(win)([0-9]{1,2}\.[0-9x]{1,2})', 'Windows');
	$ros[] = array('(win)([0-9]{2})', 'Windows');
	$ros[] = array('(windows)([0-9x]{2})', 'Windows');
	$ros[] = array('Windows ME', 'Windows ME');
	$ros[] = array('Win 9x 4.90', 'Windows ME');
	$ros[] = array('Windows 98|Win98', 'Windows 98');
	$ros[] = array('Windows 95', 'Windows 95');
	$ros[] = array('(windows)([0-9]{1,2}\.[0-9]{1,2})', 'Windows');
	$ros[] = array('win32', 'Windows');
	$ros[] = array('(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})', 'Java');
	$ros[] = array('(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}', 'Solaris');
	$ros[] = array('dos x86', 'DOS');
	$ros[] = array('unix', 'Unix');
	$ros[] = array('Mac OS X', 'Mac OS X');
	$ros[] = array('Mac_PowerPC', 'Macintosh PowerPC');
	$ros[] = array('(mac|Macintosh)', 'Mac OS');
	$ros[] = array('(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'SunOS');
	$ros[] = array('(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}', 'BeOS');
	$ros[] = array('(risc os)([0-9]{1,2}\.[0-9]{1,2})', 'RISC OS');
	$ros[] = array('os/2', 'OS/2');
	$ros[] = array('freebsd', 'FreeBSD');
	$ros[] = array('openbsd', 'OpenBSD');
	$ros[] = array('netbsd', 'NetBSD');
	$ros[] = array('irix', 'IRIX');
	$ros[] = array('plan9', 'Plan9');
	$ros[] = array('osf', 'OSF');
	$ros[] = array('aix', 'AIX');
	$ros[] = array('GNU Hurd', 'GNU Hurd');
	$ros[] = array('(fedora)', 'Linux - Fedora');
	$ros[] = array('(kubuntu)', 'Linux - Kubuntu');
	$ros[] = array('(ubuntu)', 'Linux - Ubuntu');
	$ros[] = array('(debian)', 'Linux - Debian');
	$ros[] = array('(CentOS)', 'Linux - CentOS');
	$ros[] = array('(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - Mandriva');
	$ros[] = array('(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)', 'Linux - SUSE');
	$ros[] = array('(Dropline)', 'Linux - Slackware (Dropline GNOME)');
	$ros[] = array('(ASPLinux)', 'Linux - ASPLinux');
	$ros[] = array('(Red Hat)', 'Linux - Red Hat');
	$ros[] = array('(linux)', 'Linux');
	$ros[] = array('(amigaos)([0-9]{1,2}\.[0-9]{1,2})', 'AmigaOS');
	$ros[] = array('amiga-aweb', 'AmigaOS');
	$ros[] = array('amiga', 'Amiga');
	$ros[] = array('AvantGo', 'PalmOS');
	$ros[] = array('[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3})', 'Linux');
	$ros[] = array('(webtv)/([0-9]{1,2}\.[0-9]{1,2})', 'WebTV');
	$ros[] = array('Dreamcast', 'Dreamcast OS');
	$ros[] = array('GetRight', 'Windows');
	$ros[] = array('go!zilla', 'Windows');
	$ros[] = array('gozilla', 'Windows');
	$ros[] = array('gulliver', 'Windows');
	$ros[] = array('ia archiver', 'Windows');
	$ros[] = array('NetPositive', 'Windows');
	$ros[] = array('mass downloader', 'Windows');
	$ros[] = array('microsoft', 'Windows');
	$ros[] = array('offline explorer', 'Windows');
	$ros[] = array('teleport', 'Windows');
	$ros[] = array('web downloader', 'Windows');
	$ros[] = array('webcapture', 'Windows');
	$ros[] = array('webcollage', 'Windows');
	$ros[] = array('webcopier', 'Windows');
	$ros[] = array('webstripper', 'Windows');
	$ros[] = array('webzip', 'Windows');
	$ros[] = array('wget', 'Windows');
	$ros[] = array('Java', 'Unknown');
	$ros[] = array('flashget', 'Windows');
	$ros[] = array('(PHP)/([0-9]{1,2}.[0-9]{1,2})', 'PHP');
	$ros[] = array('MS FrontPage', 'Windows');
	$ros[] = array('(msproxy)/([0-9]{1,2}.[0-9]{1,2})', 'Windows');
	$ros[] = array('(msie)([0-9]{1,2}.[0-9]{1,2})', 'Windows');
	$ros[] = array('libwww-perl', 'Unix');
	$ros[] = array('UP.Browser', 'Windows CE');
	$ros[] = array('NetAnts', 'Windows');
	$file  = count ( $ros );
	$os    = '';
	for ( $n=0 ; $n < $file ; $n++ ){
		if ( @preg_match('/'.$ros[$n][0].'/i' , $agent, $name)){
			$os = @$ros[$n][1].' '.@$name[2];
			break;
		}
	}
	return trim( $os );
}

function get_user_browser()  {
	$user_agent = (isset($_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : null);
	$browser    = "Unknown Browser";

	$browser_array = array(
		'/msie/i'      => 'Internet Explorer',
		'/firefox/i'   => 'Firefox',
		'/safari/i'    => 'Safari',
		'/chrome/i'    => 'Chrome',
		'/edge/i'      => 'Edge',
		'/opera/i'     => 'Opera',
		'/netscape/i'  => 'Netscape',
		'/maxthon/i'   => 'Maxthon',
		'/konqueror/i' => 'Konqueror',
		'/mobile/i'    => 'Handheld Browser'
	);

	foreach ($browser_array as $regex => $value) {
		if (preg_match($regex, $user_agent)) {
			$browser = $value;
		}
	}

	return $browser;
}