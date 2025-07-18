<?php 
//////////////////////////////////////////////
// Clase para Conectar a MySQL
//////////////////////////////////////////////

class Conexion {

	private $engine = 'mysql';
	private $host;
	private $name;
	private $charset;
	private $user;
	private $pass;
	private $options;


	/** 
	* Creates a new connection to the database
	* @access public
	* @param array with DB settings and credentials
	* @return new connection
	**/
	public static function conector()
	{
		// new instance
		$self = new self();
		$self->host    = is_local() ? LDB_ENGINE : DB_ENGINE;
		$self->host    = is_local() ? LDB_HOST : DB_HOST;
		$self->name    = is_local() ? LDB_NAME : DB_NAME;
		$self->charset = is_local() ? LDB_CHARSET : DB_CHARSET;
		$self->user    = is_local() ? LDB_USER : DB_USER;
		$self->pass    = is_local() ? LDB_PASS : DB_PASS;
		$self->options = [
			PDO::ATTR_ERRMODE                  => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE       => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES         => false,
			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
		];

		try {
			$link = new PDO($self->engine.':host='.$self->host.';dbname='.$self->name.';charset='.$self->charset.'', $self->user, $self->pass, $self->options);
			return $link;
		} catch (PDOException $e) {
			//echo "No hay conexion con la base de datos: ". $e->getMessage();
			require_once DB.'db_error.php'; // No connection view
			die();
		};
	}

	/**
	* Makes a query to database
	* @access public
	* @param string with statement to query and array with data to pass
	* @return array with row(s) or true / false
	**/
	public static function query($stmt , $array = array() , $debug = false)
	{
		$link = self::conector();
		$link->beginTransaction();
		$query = $link->prepare($stmt);

		if ($ok = $query->execute($array)) {

			if (strpos($stmt, 'SELECT') !== false) {

				return ($query->rowCount() > 0) ? $query->fetchAll() : false; ## Not match or 0 results

			} elseif(strpos($stmt, 'INSERT') !== false) {

				$id = $link->lastInsertId();
				$link->commit();
				return $id; ## Insertado con éxito

			} elseif (strpos($stmt, 'DELETE') !== false) {
				
				if ($query->rowCount() > 0) {
					$link->commit();
					return true;
				}

				$link->rollBack();
				return false; ## Nada borrado

			} elseif (strpos($stmt, 'UPDATE') !== false) {

				if ($affected = $query->rowCount() >= 0) {
					$link->commit();
					return true;
				}
				
				$link->rollBack();
				return false; ## Nada actualizado

			} else {

				if ($ok) {
					$link->commit();
					return true;
				}

				$link->rollBack();
				return false; ## Nada actualizado

			}

		} else {
			if($debug){
				
				$error = $query->errorInfo();
				throw new Exception(sprintf('Hubo un error %s %s: %s',$error[0], $error[1], $error[2]));

			}

			$link->rollBack();
			return false; ## Error with Query
		}
	}
}