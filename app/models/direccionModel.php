<?php 

class direccionModel extends Model
{

  public static function all()
  {

  }

  public static function by_id($id)
  {
    $sql = 'SELECT 
    d.* ,
    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,
    u.telefono AS u_telefono,
    u.empresa AS u_empresa
    FROM 
    direcciones d 
    JOIN usuarios u ON d.id_usuario = u.id_usuario
    WHERE 
    d.id = :id';
    $row = parent::query($sql,['id' => $id],true);
    return ($row ? $row[0] : false);
  }

  public static function by_user($id_usuario)
  {
    $sql = 'SELECT 
    d.*,
    (SELECT COUNT(d2.id) FROM direcciones d2 WHERE d2.id_usuario = d.id_usuario AND d2.tipo IN("remitente")) AS remitentes
    FROM 
    direcciones d 
    WHERE 
    d.id_usuario = :id_usuario
    ORDER BY d.id
    DESC';
    $rows = parent::query($sql,['id_usuario' => $id_usuario]);
    return ($rows ? $rows : false);
  }

  public static function by_user_and_id($id_usuario , $id)
  {
    $sql = 'SELECT 
    d.* 
    FROM 
    direcciones d 
    WHERE 
    d.id_usuario = :id_usuario AND d.id = :id';
    $row = parent::query($sql,['id_usuario' => $id_usuario , 'id' => $id]);
    return ($row ? $row[0] : false);
  }

  public static function get_user_main_address($id_usuario)
  {
    if(!self::check_user_main_addresses($id_usuario)) {
      return false;
    }

    $sql = 'SELECT d.* FROM direcciones d WHERE d.id_usuario = :id_usuario AND d.tipo IN("remitente") ORDER BY d.id LIMIT 1';
    $row = parent::query($sql,['id_usuario' => $id_usuario])[0];

    return ($row) ? $row : false;
  }

  public static function check_user_main_addresses($id_usuario)
  {
    $sql = 'SELECT 
    COUNT(d.id) AS total
    FROM 
    direcciones d 
    WHERE 
    d.id_usuario = :id_usuario AND d.tipo IN("remitente")';
    $rows = parent::query($sql,['id_usuario' => $id_usuario]);
    if(!$rows) {
      return false;
    }

    return ($rows[0]['total'] > 0) ? true : false;
  }

  public static function reset_main_addresses($id_usuario)
  {
    $sql = 'UPDATE direcciones d SET d.tipo = :tipo WHERE d.id_usuario = :id_usuario';
    $rows = parent::query($sql,['id_usuario' => $id_usuario,'tipo' => NULL]);

    return ($rows) ? true : false;
  }
  
}
