<?php 

class suscripcionModel extends Model
{
  public static function get_type_by_id($id)
  {
    $stmt = 'SELECT st.* FROM va_sub_types st WHERE st.id = :id LIMIT 1';
    return ($row = parent::query($stmt,['id' => $id])) ? $row[0] : false;
  }

  public static function get_by_type($type)
  {
    $stmt = 'SELECT st.* FROM va_sub_types st WHERE st.type = :type LIMIT 1';
    return ($row = parent::query($stmt,['type' => $type])) ? $row[0] : false;
  }

  public static function update_sub($id)
  {
    
  }

  public static function get_by_user($id_usuario)
  {
    $stmt = 
		'SELECT 
		sub.*,
		st.type,
		st.title,
		st.regular_price,
		st.sale_price,
		st.comission_rate,
    u.id_usuario,
    u.nombre,
    u.usuario,
    u.email
		FROM va_subscriptions sub
		INNER JOIN usuarios u ON sub.id_usuario = u.id_usuario
		INNER JOIN va_sub_types st ON sub.id_sub_type = st.id
		WHERE
		sub.id_usuario = :id_usuario
		LIMIT 1';
		return ($row = parent::query($stmt,["id_usuario" => $id_usuario])) ? $row[0] : false;
  }
  
}
