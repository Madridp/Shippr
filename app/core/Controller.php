<?php 

/**
* Main Controller
*/
class Controller
{
	protected $data;
	protected $modelo;

	public function __construct()
	{
		//if (CONTROLLER !== "login" && !Auth::auth()) {
		if (!Auth::auth()) {
			Taker::to('login');
		}

		$this->data =
		[
			'title' => 'Define el título dentro de esta sección',
			'data'  => NULL
		];
	}

	/**
	* Makes redirections of the site
	* @access public
	* @param string
	* @return none | redirect to set URL
	**/
	public static function to($location = null){
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case '404':
					header('HTTP/1.0 404 Not found');
					include 'includes/errors/404.php';
					break;
				}
			}
			if (!headers_sent()){    
				header('Location: '.$location);
				exit();
			} else {  
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.$location.'";';
				echo '</script>';
				echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
				echo '</noscript>'; 
				exit();
			}
		}	
	}


	/**
	* Makes redirections of the site
	* @access public
	* @param string
	* @return none | redirect to set URL
	**/
	public static function go($location = null){
		if ($location) {
			if (is_numeric($location)) {
				switch ($location) {
					case '404':
					header('HTTP/1.0 404 Not found');
					include 'views/error/errorView.php';
					break;
				}
			}
			if (!headers_sent()){
				if(strpos($location,'http') !== false) {
					header('Location: ' . $location);
					die();
				}
				elseif($location == 'back'){
					header('Location: ' . ((isset($_SESSION['PREV_PAGE']) && !empty($_SESSION['PREV_PAGE'])) ? $_SESSION['PREV_PAGE'] : URL . 'dashboard'));
					die();
				}
				else {
					header('Location: '.URL.$location);
					die;
				}
				exit();
			} else {  
				echo '<script type="text/javascript">';
				echo 'window.location.href="'.URL.$location.'";';
				echo '</script>';
				echo '<noscript>';
				echo '<meta http-equiv="refresh" content="0;url='.$location.'" />';
				echo '</noscript>'; 
				exit();
			}
		}	
	}
}