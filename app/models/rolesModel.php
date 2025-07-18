<?php 

/**
* Modeo de la tabla roles
* @access public
*/
class rolesModel extends Model
{
	/**
	* Nombre de la tabla que se afectará
	*/
	protected $tabla = "roles";

	protected $id;
	protected $role;
	protected $created_at;
	protected $updated_at;
	
	function __construct()
	{
	}



	public function all()
	{
		$rows = parent::query("SELECT * FROM $this->tabla ORDER BY id");
		return ($rows) ? $rows : false;
	}

}