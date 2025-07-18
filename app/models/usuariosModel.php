<?php 

/**
* Modelo para usuarios
*/
class usuariosModel extends Model
{
	/**
	* Nombre de la tabla que se afectará
	*/
	protected $tabla = "usuarios";

	/**
	* @var id int
	* @var usuario string
	* @var email string
	* @var password string
	* @var nombre string
	* @var role int
	* @var ip string
	* @var status int
	* @var token string
	*/
	protected $id;
	protected $usuario;
	protected $email;
	protected $password;
	protected $nombre;
	protected $id_role;
	protected $ip;
	protected $status;
	protected $token;
	protected $borrado;


	function __construct()
	{

	}

	public static function all()
	{
		$query = 
		"SELECT 
		u.*, 
		r.role,
		r.titulo,
		r.descripcion
		FROM usuarios u 
		LEFT JOIN roles r ON u.id_role = r.id 
		ORDER BY u.id_usuario
		DESC";
		$usuarios = parent::query($query);

		return ($usuarios) ? $usuarios : false;
	}

	public static function all_regular()
	{
		// Saldos
		$abonado   = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo IN("abono_saldo","devolucion_saldo") AND t2.status = "pagado"';
		$pendiente = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo = "abono_saldo" AND t2.status = "pendiente"';
		$recargado = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo = "abono_saldo" AND t2.status = "pagado"';
		$devuelto  = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo = "devolucion_saldo" AND t2.status = "pagado"';
		$retirado  = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo IN("retiro_saldo","cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t2.status = "pagado"';
		$query = 
		"SELECT 
		u.*, 
		r.role,
		r.titulo,
		r.descripcion,
		($abonado) AS saldo_abonado,
		($pendiente) AS saldo_pendiente,
		($recargado) AS saldo_recargado,
		($devuelto) AS saldo_devuelto,
		($retirado) AS saldo_utilizado,
		(($abonado) - ($retirado)) AS saldo
		FROM usuarios u 
		LEFT JOIN roles r ON u.id_role = r.id 
		WHERE r.role = 'regular'
		ORDER BY u.id_usuario
		DESC";

		return ($usuarios = parent::query($query)) ? $usuarios : false;
	}

	public static function admins()
	{
		$sql = 
		"SELECT 
		u.*, 
		r.role,
		r.titulo,
		r.descripcion
		FROM usuarios u 
		JOIN roles r ON u.id_role = r.id 
		WHERE r.role = 'admin'
		ORDER BY u.id_usuario
		DESC";

		return ($rows = parent::query($sql)) ? $rows : false;
	}

	public static function by_id($id)
	{
		// Saldos
		$abonado   = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo IN("abono_saldo","devolucion_saldo") AND t2.status = "pagado"';
		$pendiente = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo = "abono_saldo" AND t2.status = "pendiente"';
		$retirado  = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = u.id_usuario AND t2.tipo IN("retiro_saldo","cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t2.status = "pagado"';
		$query = "SELECT 
		u.*,
		r.id  AS id_role,
		r.role,
		r.titulo,
		r.descripcion,
		($abonado) AS saldo_abonado,
		($pendiente) AS saldo_pendiente,
		($retirado) AS saldo_utilizado,
		(($abonado) - ($retirado)) AS saldo
		FROM usuarios u 
		LEFT JOIN roles r ON u.id_role = r.id 
		WHERE u.id_usuario = :id 
		LIMIT 1";
		//$this->query = "SELECT u.*,r.role FROM $this->tabla u LEFT JOIN roles r ON u.id_role = r.id WHERE id_usuario = :id LIMIT 1";
		$usuario = parent::query($query, ["id" => $id])[0];

		if(!$usuario) return false;

		$usuario['saldos'] = self::user_wallet($id);
		return $usuario;
	}

	public static function user_wallet($id_usuario)
	{
		// Saldos
		$abonado   = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = t.id_usuario AND t2.tipo IN("abono_saldo","devolucion_saldo") AND t2.status = "pagado"';
		$pendiente = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = t.id_usuario AND t2.tipo = "abono_saldo" AND t2.status = "pendiente"';
		$retirado  = 'SELECT COALESCE(SUM(t2.total), 0) FROM shippr_transacciones t2 WHERE t2.id_usuario = t.id_usuario AND t2.tipo IN("retiro_saldo","cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t2.status = "pagado"';

		$sql = 'SELECT
		('.$abonado.') AS saldo_abonado,
		('.$pendiente.') AS saldo_pendiente,
		('.$retirado.') AS saldo_retirado,
		(('.$abonado.') - ('.$retirado.')) AS saldo
		FROM shippr_transacciones t 
		WHERE t.id_usuario = :id 
		GROUP BY t.id';

		return ($rows = parent::query($sql, ['id' => $id_usuario])) ? $rows[0] : false;
	}

	/**
	*
	* @access public
	* Carga todos los usuarios de la base de datos
	*
	**/

	public function cargar_todos_los_usuarios()
	{
		$this->query = 
		"SELECT 
		u.id_usuario, 
		u.usuario, 
		u.nombre, 
		u.email, 
		r.role,
		r.titulo,
		r.descripcion
		FROM $this->tabla u 
		LEFT JOIN roles r ON u.id_role = r.id 
		ORDER BY u.id_usuario
		DESC";
		$usuarios = parent::query($this->query);

		return ($usuarios) ? $usuarios : false;
	}

	/**
	*
	* Carga información de un solo usuario
	* @access public
	*
	**/
	public function find($id)
	{
		$this->query = "SELECT 
		u.*,
		r.id  AS id_role,
		r.role,
		r.titulo,
		r.descripcion
		FROM $this->tabla u 
		LEFT JOIN roles r ON u.id_role = r.id 
		WHERE u.id_usuario = :id 
		LIMIT 1";
		//$this->query = "SELECT u.*,r.role FROM $this->tabla u LEFT JOIN roles r ON u.id_role = r.id WHERE id_usuario = :id LIMIT 1";
		return ($usuario = parent::query($this->query, ["id" => $id])) ? $usuario[0] : false;
	}


	/**
	*
	* @access public
	* Agregar registro a la base de datos
	*
	**/
	public function agregar()
	{
		$data = [
			'usuario' => $this->usuario,
			'nombre' => $this->nombre,
			'email' => $this->email,
			'password' => $this->password,
			'id_role' => $this->id_role,
			'status' => $this->status,
			'ip' => $this->ip,
			'token' => $this->token,
			'borrado' => $this->borrado,
		];

		$this->query = "INSERT INTO $this->tabla (usuario, nombre, email, password, id_role, status, ip, token, borrado) 
		VALUES (:usuario, :nombre, :email, :password, :id_role, :status, :ip, :token, :borrado)";
		return (parent::query($this->query, $data)) ? true : false;
	}


	public function usuario_existente($usuario)
	{
		$this->query = "SELECT usuario FROM $this->tabla WHERE usuario = :usuario LIMIT 1";
		return (parent::query($this->query,["usuario" => $usuario])) ? true : false;
	}

	public function email_existente($email)
	{
		$this->query = "SELECT email FROM $this->tabla WHERE email = :email LIMIT 1";
		return (parent::query($this->query,["email" => $email])) ? true : false;
	}

	public function validar_usuario_y_password($usuario , $unhashed_password)
	{
		$this->usuario = clean($usuario);
		$this->password = $unhashed_password;

		$this->query = "SELECT u.* FROM $this->tabla u WHERE usuario = :usuario LIMIT 1";
		$usuario = parent::query($this->query , ["usuario" => $this->usuario])[0];

		if(!$usuario) {
			return false;
		}
		
		$db_password = $usuario['password'];

		if(!password_verify($this->password.SITESALT , $db_password)){
			return false;
		}

		return $usuario;
	}

	public function actualizar_token($id , $token)
	{
		$this->id = intval($id);
		$this->token = $token;

		$query = parent::query("UPDATE $this->tabla SET token = :token WHERE id_usuario = :id_usuario" , ["id_usuario" => $this->id , "token" => $this->token]);

		return ($query) ? true : false;
	}

	public function validar_usuario_y_token($id , $token)
	{
		$this->id = intval($id);
		$this->token = $token;

		$usuario = parent::query("SELECT * FROM $this->tabla WHERE id_usuario = :id_usuario AND token = :token LIMIT 1" , ["id_usuario" => $this->id , "token" => $this->token]);

		return ($usuario) ? $usuario : false;

	}

	public static function add_user_session($id_usuario , $hashed_token)
	{
		$new_token =
		[
			'id_usuario'        => $id_usuario,
			'token'             => $hashed_token,
			'navegador'         => get_user_browser(),
			'sistema_operativo' => get_user_os(),
			'ip'                => ipCliente(),
			'valid'             => 1,
			'lifetime'          => strtotime('1 year'),
			'created_at'        => ahora()
		];

		if(!$id = parent::add('sesion_tokens' , $new_token)) {
			return false;
		}

		return $id;
	}

	public static function validate_user_session($id_usuario , $hashed_token)
	{
		$sql = 'SELECT u.*,
		(SELECT COUNT(st.id) FROM sesion_tokens st WHERE st.id_usuario = u.id_usuario AND st.valid = 1) AS sesiones_activas
		FROM usuarios u
		JOIN sesion_tokens st ON st.id_usuario = u.id_usuario AND st.valid = 1 AND st.token = :token AND st.lifetime > :now
		WHERE u.id_usuario = :id_usuario
		LIMIT 1';

		$user = parent::query($sql,['id_usuario' => $id_usuario , 'token' => $hashed_token , 'now' => time()])[0];

		return ($user) ? true : false;
	}

	public static function destroy_user_session($id_usuario , $hashed_token)
	{
		$sql = 'DELETE st 
		FROM sesion_tokens st
		WHERE st.id_usuario = :id_usuario AND st.token = :token';

		$res = parent::query($sql,['id_usuario' => $id_usuario , 'token' => $hashed_token]);

		if(!$res) {
			return false;
		}

		return true;
	}

	/**
	* Cargar la información del usuario validado
	* @access public
	* @param $id
	* @return $array
	**/
	public function cargar_informacion_usuario($id , $hashed_token)
	{
		$this->query = "SELECT 
		u.*,
		r.role,
		r.titulo,
		r.descripcion
		FROM $this->tabla u 
		LEFT JOIN roles r ON u.id_role = r.id 
		JOIN sesion_tokens st ON st.id_usuario = u.id_usuario AND st.token = :token AND st.valid = 1 AND st.lifetime > :now
		WHERE u.id_usuario = :id 
		LIMIT 1";

		$usuario = parent::query($this->query, ["id" => intval($id) , "token" => $hashed_token , 'now' => time()],true);

		if(!$usuario) return false;

		$usuario = $usuario[0];
		$usuario['saldos'] = self::user_wallet($id);
		return $usuario;
	}

	public static function update_subscription($id_usuario , $id_sub_type) 
	{
		$new_subscription =
		[
			'id_sub_type' => $id_sub_type
		];

		// Actualizar el registro
		if(!parent::update('usuarios',['id_usuario' => (int) $id_usuario],$new_subscription)) {
			return false;
		}

		return true;
	}
}