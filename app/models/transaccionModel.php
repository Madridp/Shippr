<?php 

class transaccionModel extends Model
{
  public $t1 = 'shippr_transacciones';
  public $id;
  public $numero;
  public $tipo;
  public $detalle;
  public $referencia;
  public $id_usuario    = 0;
  public $tipo_ref      = null;
  public $id_ref        = 0;
  public $status        = 'pendiente';
  public $status_detalle;
  public $metodo_pago;
  public $mensualidades = 1;
  public $descripcion;
  public $subtotal      = 0;
  public $impuestos     = 0;
  public $total         = 0;
  public $debido        = 0;
  public $hash;
  public $creado;
  public $actualizado;

  private $transaccion;

  public static function all_by_user($id_usuario)
  {
    $sql = "SELECT t.*,
    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,
    u.empresa AS u_empresa,
    u.razon_social AS u_razon_social,
    u.telefono AS u_telefono,

    v.id AS v_id,
    v.folio AS v_folio,
    v.status AS v_status,
    v.metodo_pago AS v_metodo_pago,
    v.pago_status AS v_pago_status,

    e.id AS e_id

    FROM shippr_transacciones t
    LEFT JOIN usuarios u ON u.id_usuario = t.id_usuario
    LEFT JOIN ventas v ON t.id_ref = v.id
    LEFT JOIN envios e ON t.tipo_ref = 'envio' AND t.id_ref = e.id 
    WHERE t.id_usuario = :id_usuario
    ORDER BY t.creado DESC";

    return ($rows = parent::query($sql, ['id_usuario' => $id_usuario])) ? $rows : false;
  }

  public static function all_recargas()
  {
    $sql = "SELECT t.*,
    t2.status AS pago_status,
    t2.numero AS pago_numero,
    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,
    u.empresa AS u_empresa,
    u.razon_social AS u_razon_social,
    u.telefono AS u_telefono
    FROM shippr_transacciones t
    LEFT JOIN usuarios u ON u.id_usuario = t.id_usuario
    LEFT JOIN shippr_transacciones t2 ON t2.referencia = t.numero AND t2.tipo_ref = 'abono_saldo'
    WHERE t.tipo = 'recarga_saldo'
    ORDER BY t.creado DESC";

    return ($rows = parent::query($sql)) ? $rows : false;
  }

  public static function all_cargos()
  {
    $sql = "SELECT t.*,
    e.id AS e_id,
    e.status AS e_status,
    e.num_guia AS e_num_guia,
    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,
    u.empresa AS u_empresa,
    u.razon_social AS u_razon_social,
    u.telefono AS u_telefono
    FROM shippr_transacciones t
    LEFT JOIN usuarios u ON u.id_usuario = t.id_usuario
    LEFT JOIN envios e ON t.id_ref = e.id
    WHERE t.tipo = 'cargo_sobrepeso_saldo' AND t.tipo_ref = 'envio'
    ORDER BY t.creado DESC";

    return ($rows = parent::query($sql)) ? $rows : false;
  }

  public static function by_id($id)
  {
    $sql = 'SELECT * FROM shippr_transacciones WHERE id = :id LIMIT 1';
    return ($row = parent::query($sql, ['id' => $id])) ? $row[0] : false;
  }

  public function agregar()
  {
    $data = 
    [
      'numero'          => randomPassword(10, 'numeric'),
      'tipo'            => clean($this->tipo),
      'detalle'         => clean($this->detalle),
      'referencia'      => clean($this->referencia),
      'id_usuario'      => (int) clean($this->id_usuario),
      'tipo_ref'        => clean($this->tipo_ref),
      'id_ref'          => (int) clean($this->id_ref),
      'status'          => clean($this->status),
      'status_detalle'  => clean($this->status_detalle),
      'metodo_pago'     => clean($this->metodo_pago),
      'mensualidades'   => (int) clean($this->mensualidades),
      'descripcion'     => clean($this->descripcion),
      'subtotal'        => (float) $this->subtotal,
      'impuestos'       => (float) $this->impuestos,
      'total'           => (float) $this->total,
      'hash'            => $this->new_hash(),
      'creado'          => ahora()
    ];

    if(!$this->id = self::add($this->t1, $data)) {
      return false;
    }

    return $this->id;
  }

  static function get_by_sub($id_sub)
  {
    $stmt = 
		'SELECT 
		t.*
		FROM va_transacciones t
		JOIN va_sub_transactions subt ON subt.id_transaction = t.id
		JOIN va_subscriptions sub ON sub.id = subt.id_sub
		WHERE
    sub.id = :id
    ORDER BY
    t.created_at
    DESC';
		return ($row = parent::query($stmt,["id" => $id_sub])) ? $row : false;
  }

  static function get_by_payment_number($pn)
  {
    $stmt = 
		'SELECT 
		t.*,
    st.type,
    st.title,
    st.regular_price,
    sub.status AS sub_status,
    sub.start,
    sub.end
		FROM va_transacciones t
		JOIN va_sub_transactions subt ON subt.id_transaction = t.id
		JOIN va_subscriptions sub ON sub.id = subt.id_sub
    JOIN va_sub_types st ON st.id = sub.id_sub_type
		WHERE
    t.payment_number = :pn
    LIMIT 1';
		return ($row = parent::query($stmt,["pn" => $pn],true)) ? $row[0] : false;
  }

  private function new_hash()
  {
    $hash = new TokenHandler();
    $hash = $hash->getToken();
    return $hash;
  }
}
