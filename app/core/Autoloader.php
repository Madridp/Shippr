<?php 

/**
* Autoloader class to get and load all files need dynamically
*/
class Autoloader
{
	/**
	* Registers load function for autoloading files
	* @access private
	* @var none
	* @return none
	**/
	public static function autoload()
	{
		spl_autoload_register(array(__CLASS__ , "load"));
	}

	private static function load($filename)
	{	
		if (file_exists(CONTROLLERS . $filename . EXT)) {
			require_once CONTROLLERS . $filename . EXT;
		} elseif (file_exists(CONTROLLERS . $filename . "Controller" . EXT)) {
			require_once CONTROLLERS . $filename . "Controller" . EXT;
		} elseif (file_exists(MODELS . $filename . "Model" . EXT)) {
			require_once MODELS . $filename . "Model" . EXT;
		} elseif (file_exists(MODELS . $filename  . EXT)) {
			require_once MODELS . $filename  . EXT;
		} elseif (file_exists(CORE . $filename . EXT)) {
			require_once CORE . $filename . EXT;
		} elseif (file_exists(HELPERS . $filename . EXT)) {
			require_once HELPERS . $filename . EXT;
		} elseif (file_exists(INTERFACES . $filename . EXT)) {
			require_once INTERFACES . $filename . EXT;
		} elseif (file_exists(DB . $filename . EXT)) {
			require_once DB . $filename . EXT;
		} elseif (file_exists(HANDLERS . $filename . EXT)) {
			require_once HANDLERS . $filename . EXT;
		} elseif (file_exists(FUNCTIONS . $filename . EXT)) {
			require_once FUNCTIONS . $filename . EXT;
		}
	}
}