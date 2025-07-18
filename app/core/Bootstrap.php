<?php
/**
* Class tha makes all the website run
*/
class Bootstrap
{

	private $uri;

	private $default_controller       = 'dashboard';
	private $default_error_controller = 'error';
	private $default_method           = 'index';
	private $params;

	private $controller;
	private $current_controller;
	private $current_method;

	public function __construct()
	{
		$this->init_session();
		$this->init_jserp_config();
		$this->init_database_config();
		$this->init_autoloader();
		$this->init_composer_autoloader();
		$this->init_globals();
		$this->init_functions();
		$this->create_csrf_token();
		$this->init_timezone();
		$this->init_core_data();
		$this->load_smtp_constants();
		$this->dispatch();
	}
	
	public static function run()
	{
		$serp = new self();
		return;
	}

	/**
	 * Stablish database credentials conection for
	 * local and production mode
	 *
	 * @return void
	 */
	private function init_database_config()
	{
		if(!file_exists('app/config/database_config.php')){
			die(sprintf('%s file not found, please provide it in order to continue.', 'database_config.php'));
		}

		require_once 'app/config/database_config.php';
	}

	/**
	 * Sets paths constants for our entire application
	 *
	 * @return void
	 */
	private function init_jserp_config()
	{
		if(!file_exists('app/config/jserp_config.php')){
			die(sprintf('%s file not found, please provide it in order to continue.', 'jserp_config.php'));
		}

		require_once 'app/config/jserp_config.php';

		if(!file_exists('app/core/serp_config.php')){
			die(sprintf('%s file not found, please provide it in order to continue.', 'serp_config.php'));
		}

		require_once 'app/core/serp_config.php';
	}

	/**
	 * Starts autoloading classes
	 *
	 * @return void
	 */
	private function init_autoloader()
	{
		if(!file_exists(CORE.'Autoloader.php')){
			die(sprintf('%s file not found, please provide it in order to continue.','Autoloader.php'));
		}
		
		require_once CORE.'Autoloader.php';
		Autoloader::autoload();
	}
	
	/**
	 * Autoloads composer files and libraries
	 *
	 * @return void
	 */
	private function init_composer_autoloader()
	{
		if(!file_exists(VENDOR."autoload.php")){
			die(sprintf('%s file not found, please provide it in order to continue, and run "composer update".', VENDOR."autoload.php"));
		}

		require_once VENDOR."autoload.php";
	}

	/**
	 * Loads core functions of SERP
	 *
	 * @return void
	 */
	private function init_functions()
	{
		if(!file_exists('app/functions/core_functions.php')){
			die(sprintf('%s file not found, please provide it in order to continue.', 'core_functions.php'));
		}

		$functions = glob(FUNCTIONS.'*_functions.php');
		foreach ($functions as $f) {
			if(!file_exists($f)){
				die(sprintf('%s file not found, please provide it in order to continue.', basename($f)));
			}

			require_once $f;
		}
	}

	/**
	 * Starts current session
	 *
	 * @return void
	 */
	private function init_session()
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		} elseif(function_exists(session_id())){
			if(session_id() == '') {
				session_start();
			}
		}
	}

	/**
	 * Creates needed $_GLOBALS to use
	 * inside the web application
	 *
	 * @return void
	 */
	private function init_globals()
	{	
		/** header css files to be lazy loaded */
		$GLOBALS['JS_Styles']      = [];

		/** header js files to be lazy loaded */
		$GLOBALS['JS_HScripts']    = [];

		/** footer js files to be lazy loaded */
		$GLOBALS['JS_Scripts']     = [];

		/** Chart JS */
		$GLOBALS['JS_Chartjs']     = null;

		/** Current User */
		$GLOBALS['JS_CurrentUser'] = [];

		/** System settings */
		$GLOBALS['JS_Settings']    = [];

		// Define si un usuario está loggeado o no
		$GLOBALS['JS_Logged']      = false;
	}

	/**
	 * Created a CSRF token
	 */
	private function create_csrf_token()
	{
		$token = new CSRF();
		define('CSRF_TOKEN', $token->get_token());
	}

	/**
	* Creates website URL based on database information
	*@access private
	*@var none
	*@return none
	**/
	private function init_core_data()
	{
		global $JS_CurrentUser;
		global $JS_Settings;
		global $JS_Logged;

		// Check if user is logged or not
		$JS_Logged      = Auth::auth() ? true : false;

		// Loading user data on page load
		$JS_CurrentUser = Auth::get_user();

		// Loading all settings from database on page load
		$JS_Settings = get_all_options();
	}
	
	/** Sets the default timezone based on company location
	 * @return void
	 */
	private function init_timezone()
	{
		if(!function_exists('get_timezone')){
			throw new LumusException('get_timezone function does not exist, it is needed to start web application.', 1);
		}

		/** Setting time zone for local times and dates */
		date_default_timezone_set(get_timezone());
	}

	private function load_smtp_constants()
	{
		
	}

	/**
	* Dispatches our application and outputs it to viewport
	* @access private
	* @return new instance of the controller in use
	**/
	private function dispatch()
	{
		/** Here we are going to add a serial validation before everything loads up */
		// 1.0.5.3 SERP
		$this->uri = $this->filter_uri();

		// Controlador a cargar actualmente
		$this->controller           = isset($this->uri[0]) ? $this->uri[0] : $this->default_controller;
		$this->current_controller   = $this->controller.'Controller';
		$this->current_method       = str_replace('-','_', isset($this->uri[1]) ? $this->uri[1] : $this->default_method);
		$this->params               = isset($this->uri[2]) ? $this->uri[2] : null;

		// Si no existe el controlador pedido
		if (!class_exists($this->current_controller)) {
			$this->controller         = $this->default_error_controller;
			$this->current_controller = $this->default_error_controller.'Controller';
		}

		// Si el controlador existe
		//$controller = new $this->current_controller;
		if (!isset($this->uri[1]) || !method_exists(new $this->current_controller, $this->current_method)) {
			$this->current_method = $this->default_method;
		}

		//----------------------------------------------------
		//----------------------------------------------------
		// Middlewares
		//----------------------------------------------------
		//----------------------------------------------------
		$this->middlewares();

		//----------------------------------------------------
		
		// Defining URI constants
		define("CONTROLLER", $this->controller);
		define("METHOD"    , $this->current_method);
		define("PARAMS"    , $this->params);

		// Existe el método solicitado
		$this->current_controller = new $this->current_controller();
		$this->current_controller->{$this->current_method}($this->params);
		//die; // última línea de ejecución
	}

	private function filter_uri()
	{
		if(isset($_GET['uri'])) {
      $this->uri = $_GET['uri'];
      $this->uri = rtrim($this->uri, '/');
      $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
      $this->uri = explode('/', strtolower($this->uri));
      return $this->uri;
    }
	}

		/**
	 * Controlar el acceso al sistema con base a middlewares 
	 * @version 1.2.0.0
	 *
	 * @return void
	 */
	private function middlewares() 
	{
		// No requerido en caso de ser una petición AJAX o API
		if(in_array($this->controller, ['ajax', 'api'])) {
			return true;
		}

		// Si es un sitio de demostración
		// desde SERP pero no es funcional aún
		if(is_demo() && !is_demo_expired()) {
			$now      = time();
			$max      = get_session('demo_alert_timer') ? get_session('demo_alert_timer') : set_session('demo_alert_timer', strtotime('+2 min'));
			if($now > $max) {
				//set_session('demo_alert_timer', strtotime('+2 min'));
				//demo_alert();
			}
		}
		
		// Si está bajo mantenimiento
		if((int) get_option('maintenance_mode') === 1){
			$this->controller           = 'mantenimiento';
			$this->current_controller   = $this->controller.'Controller';
			$this->current_method       = 'index';
		} else

		// Si está suspendido el sistema
		if(is_logged() && is_site_suspended() && !is_root(get_user_role())) {
			$this->controller           = 'suspension';
			$this->current_controller   = $this->controller.'Controller';
			$this->current_method       = 'index';
		} else

		// Sitio demo expiró
		if(is_logged() && is_demo() && is_demo_expired() && !is_root(get_user_role())) {
			$this->controller           = 'demo';
			$this->current_controller   = $this->controller.'Controller';
			$this->current_method       = 'index';
		}
	}
}