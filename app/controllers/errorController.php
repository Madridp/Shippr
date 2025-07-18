<?php 
/**
*  Controlador principal de errores
*/
class errorController extends Controller
{
	function __construct(){
		parent::__construct();
	}

	/**
	* Default method to be called
	* @access public
	* @param none
	* @return view and default data
	**/
	public function index()
	{
		http_response_code(404);

		$this->data =
		[
			'title' => 'Página no encontrada'
		];

		View::render("error", $this->data);
	}
}