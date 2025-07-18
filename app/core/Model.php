<?php 
/*
* Modelo principal
* @access public
*/
/**
* 
*/
class Model extends Conexion
{

	/**
	* Conexión a base de datos
	* @var obj
	*/
	private $link;

	/**
	* Tabla que se está utlizando para manipular la información
	* @var string
	*/
	private $tabla;

	/**
	* El nombre de la columna para ordenar los resultados
	* @var string
	*/
	private $order = 'id';

	/**
	* Dirección de ordenado de los resultados de la base de datos
	* @var string
	*/
	private $direction = 'ASC';

	/**
	* Query de busqueda para la base de datos
	* @var obj
	*/
	protected $query;

	/**
	* Límite para mostrar resultados de la base de datos
	* @var obj
	*/
	private $limit = '';

	/**
	* Elemento de busqueda para hacer el match en los resultados
	* @var obj
	*/
	private $needle = 'id';

	/**
	* Valores que se insertaran, actualizarán o buscarán
	* @var obj
	*/
	private $values;



	function __construct()
	{
		$this->link = parent::conector();
		return $this->link;
	}

	/**
	* Establece el valor de una propiedad de la clase
	* @var string or array
	* @return
	*/
	public function set($property , $value)
	{
		if (!property_exists($this, $property)) {
			throw new Exception("La propiedad no existe", 1);
			exit();
		}
		$this->{$property} = clean($value);
	}

	/**
	* Obtiene el valor de una propiedad de la clase
	* @var string or array
	* @return propiedad
	*/
	public function get($property)
	{
		if (!property_exists($this, $property)) {
			throw new Exception("La propiedad no existe", 1);
			exit();
		}
		return $this->{$property};
	}

	/**
	* Obtiene todos los resultados
	* @var 
	* @return propiedad
	*/
	public function finds($needle , $values)
	{

	}

	/**
	* Regresa todos los registros de la base de datos
	* @param $key es el nombre de la columna
	* @param $value es el valor del registro
	* @param $tabla es la tabla que se usará
	**/
	public function alls($columnas = "*" , $clausulas = "")
	{
		$this->query = "SELECT ";
		if ($columnas == "*") {
			$this->query .= "*";
		}

		$_columnas = '';
		if (is_array($columnas)) {
			foreach ($columnas as $columna) {
				$_columnas .= "$columna,";
			}
			$this->query .= rtrim($_columnas, ',');
		} else {
			$this->query .= trim($columnas);
		}

		$this->query .= " FROM";
		$this->query .= " $this->tabla";

		echo $this->query;
	}

	/**
	* Add a new record to DB
	* @access public
	* @var string | array
	* @return bool
	**/
	public static function add($table , $params)
	{	
		$cols = "";
		$placeholders = "";
		foreach ($params as $key => $value) {
			$cols .= "{$key} ,";
			$placeholders .= ":{$key} ,";
		}
		$cols = substr($cols, 0 , -1);
		$placeholders = substr($placeholders, 0 , -1);
		$stmt = 
		"INSERT INTO {$table}
		({$cols})
		VALUES
		({$placeholders})
		";
		
		// Manda el statement a query()
		if ($id = parent::query($stmt , $params , true)) {
			return $id;
		}
		else {
			return false;
		}
	}

	public static function batch2($table, $rows) {
		$cols            = "";
		$placeholders    = "";
		$total_to_insert = isset($rows[0]) ? count($rows) : 0;
		$batches         = [];
		$batch           = '';
		$insert_data     = [];

		$cols = implode(', ', array_keys($rows[0]));
		for ($i=0; $i < $total_to_insert; $i++) { 
			$batch .= '(';
			foreach ($rows[$i] as $k => $v) {
				$row[':'.$k.$i]         = $v;
				$placeholders .= sprintf(' :%s, ', $k.$i);
			}
			$insert_data[] = $row;
			$row = [];
			$batch .= substr($placeholders, 0 , -2);
			$batch .= ')';
			$batches[] = $batch;
			$batch = '';
			$placeholders = '';
		}

		echo '<pre>';
		print_r($insert_data);
		echo '</pre>';

		$stmt = 
		"INSERT INTO {$table}
		($cols)
		VALUES
		".implode(', ', $batches).";";

		echo $stmt;

		// Manda el statement a query()
		//return $stmt;
		if ($id = parent::query($stmt, $insert_data, true)) {
			return $id;
		}
		else {
			return false;
		}
	}

	public static function batch($table, array $rows, array $columns = [])
	{
		// Is array empty? Nothing to insert!
		if (empty($rows)) {
			return true;
		}
		
		// Get the column count. Are we inserting all columns or just the specific columns?
		$columnCount = !empty($columns) ? count($columns) : count(reset($rows));
		
		// Build the column list
		$columnList = !empty($columns) ? '('.implode(', ', $columns).')' : '';
		
		// Build value placeholders for single row
		$rowPlaceholder = ' ('.implode(', ', array_fill(1, $columnCount, '?')).')';
		
		// Build the whole prepared query
		$query = sprintf(
			'INSERT INTO %s %s VALUES %s',
			$table,
			$columnList,
			implode(', ', array_fill(1, count($rows), $rowPlaceholder))
		);

		// Prepare PDO statement
		//return $query;

		// Flatten the value array (we are using ? placeholders)
		$data = array();
		foreach ($rows as $rowData) {
			foreach ($rowData as $rowField) {
					$data[] = $rowField;
			}
		}

		// Did the insert go successfully?
		// Manda el statement a query()
		return parent::query($query, $data, true);
	}

	/**
	* Add a new record to DB
	* @access public
	* @var string | array
	* @return bool
	**/
	public static function update($table , $haystack = [] , $params = [])
	{	
		$placeholders = "";
		$col = "";

		foreach ($params as $key => $value) {
			$placeholders .= " {$key} = :{$key} ,";
		}

		if(count($haystack) > 1){
			foreach ($haystack as $key => $value) {
				$col .= " $key = :$key AND";
			}
			$col = substr($col, 0, -3);
		} else {
			foreach ($haystack as $key => $value) {
				$col .= " $key = :$key";
			}
		}

		$placeholders = substr($placeholders, 0 , -1);
		$stmt = 
		"UPDATE $table
		SET
		$placeholders
		WHERE
		$col
		";

		// Manda el statement a query()
		if (parent::query($stmt , array_merge($params,$haystack))) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	* Gets all data from DB
	* @access public
	* @var string | array | string
	* @return array | bool
	**/
	public static function list($table, $params = [], $limit = null)
	{	
		// It creates the col names and values to bind
		$cols_values = "";
		$limits = "";
		if (!empty($params)) {
			$cols_values .= "WHERE";
			foreach ($params as $key => $value) {
				$cols_values .= " {$key} = :{$key} AND";
			}
			$cols_values = substr($cols_values, 0 , -3);
		}

		// If $limit is set, set a limit of data read
		if ($limit !== null) {
			$limits = " LIMIT {$limit}";
		}

		// Query creation
		$stmt =
		"SELECT * 
		FROM $table 
		{$cols_values}
		{$limits}";

		// Calling DB and querying
		if ($row = parent::query($stmt , $params)) {
			return $row;
		}
		else {
			return false;
		}
	}

	/**
	* Borra el registro de la base de datos
	* @param $key es el nombre de la columna
	* @param $value es el valor del registro
	* @param $tabla es la tabla que se usará
	**/
	public function delete($key , $value , $tabla)
	{
		$this->query = "DELETE FROM $tabla WHERE ";
		$this->query .= "$key = :$key ";
		$this->query .= "LIMIT 1";
		
		$array = ["$key" => $value];
		return (parent::query($this->query,$array)) ? true : false;
	}

	public static function remove($table, $params = [], $limit = 1)
	{	
		// It creates the col names and values to bind
		$cols_values = "";
		$limits = "";
		if (!empty($params)) {
			$cols_values .= "WHERE";
			foreach ($params as $key => $value) {
				$cols_values .= " {$key} = :{$key} AND";
			}
			$cols_values = substr($cols_values, 0 , -3);
		}

		// If $limit is set, set a limit of data read
		if ($limit !== null) {
			$limits = " LIMIT {$limit}";
		}

		// Query creation
		$stmt =
		"DELETE FROM $table 
		{$cols_values}
		{$limits}";

		// Calling DB and querying
		if ($row = parent::query($stmt , $params)) {
			return $row;
		}
		else {
			return false;
		}
	}

	/**
	 * Build conditional statement for sql query
	 *
	 * @param array $params
	 * @return string
	 */
	public static function conditions_builder($params)
	{
		if(!is_array($params)) {
			return '';
		}

		## AND | OR | BETWEEN | IN | LIKE | NOT IN | IS NULL
		
		$output     = 'WHERE';
		$conditions = '';
		
		## operation -> key -> symbol -> value
		foreach ($params as $i => $v) {
			$key             = (isset($v[0]) ? $v[0] : 'notkey');
			$placeholder     = (isset($v[1]) ? $v[1] : NULL);
			$symbol          = (isset($v[2]) ? $v[2] : '=');
			$operation       = (isset($v[3]) ? strtoupper($v[3]) : 'AND');

			switch (strtolower($operation)) {
				case 'or':
				case 'between':
				case 'in':
				case 'not in':
				case 'like':
					$conditions .= ' '.$key.$symbol.$placeholder.' '.$operation; // key=:key AND
					break;
				
				default:
					$conditions .= ' '.$key.$symbol.$placeholder.' '.$operation; // key=:key AND
					break;
			}
		}

		return $output;
	}



}