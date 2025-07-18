<?php 
/**
* 
*/
class View
{

	/* Nombre de la vista */
	private static $view;
	
	function __construct()
	{
	}

	/**
	* Gets and renders the view if it exists if not, it loads default one, index
	* @access public
	* @param string
	* @return file of view loaded
	**/

	public static function render($_view , $data = array(), $parse = false)
	{
		// If we can parse our array to object we set $parse to true
		$dataObj = toObj($data);
		$d       = $dataObj;

		self::$view = trim(rtrim($_view));
		if (file_exists(VIEWS . CONTROLLER . DS . self::$view . "View" . EXT)) {
			require_once VIEWS . CONTROLLER . DS . self::$view . "View" . EXT;
		}
		if (self::$view == "error") {
			require_once VIEWS . "error" . DS . self::$view . "View" . EXT;
		}
		exit;
	}
}

