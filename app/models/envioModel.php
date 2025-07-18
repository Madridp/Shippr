<?php 

class envioModel extends Model
{
  public static function all()
  {
    # Seleccionar envíos, conectar con productos y conectar con ventas
    $sql = 'SELECT 
    e.*,
    u.id_usuario AS u_id,
    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,
    c.thumb AS imagenes,
    c.slug,
    p.sku,
    p.capacidad,
    p.tipo_servicio,
    p.tiempo_entrega,
    v.id AS venta_id,
    v.folio AS venta_folio,
    v.metodo_pago AS venta_metodo_pago,
    v.collection_id AS venta_collection_id,
    v.status AS venta_status,
    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso,
    t.id AS t_id,
    t.numero AS t_numero,
    t.tipo AS t_tipo,
    t.status AS t_status,
    t.total AS t_total,
    t.hash AS t_hash
    FROM envios e
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN usuarios u ON e.id_usuario = u.id_usuario
    LEFT JOIN va_couriers c ON e.id_courier = c.id
    LEFT JOIN shippr_transacciones t ON t.tipo IN ("cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t.id_ref = e.id
    ORDER BY
    e.id
    DESC
    ';

    $rows = parent::query($sql);
    return ($rows ? $rows : false);
  }

  public static function by_user_and_id($user , $id)
  {
    # Seleccionar envíos, conectar con productos y conectar con ventas
    $sql = 'SELECT 
    e.*, 
    p.sku,
    p.capacidad,
    p.tipo_servicio,
    p.tiempo_entrega,
    v.id AS venta_id,
    v.folio AS venta_folio,
    v.metodo_pago AS venta_metodo_pago,
    v.collection_id AS venta_collection_id,
    v.status AS venta_status,
    u.id_usuario AS u_id,
    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,
    c.thumb AS imagenes,
    c.slug,
    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso,
    t.id AS t_id,
    t.numero AS t_numero,
    t.tipo AS t_tipo,
    t.status AS t_status,
    t.total AS t_total,
    t.hash AS t_hash
    FROM envios e
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN usuarios u ON e.id_usuario = u.id_usuario
    LEFT JOIN va_couriers c ON e.id_courier = c.id
    LEFT JOIN shippr_transacciones t ON t.tipo IN ("cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t.id_ref = e.id
    WHERE
    e.id_usuario = :id AND e.id = :id_envio
    ORDER BY
    e.id
    DESC
    ';

    $row = parent::query($sql,['id' => $user , 'id_envio' => $id]);
    return ($row ? $row[0] : false);
  }

  public static function by_user($user)
  {
    # Seleccionar envíos, conectar con productos y conectar con ventas
    $sql = 'SELECT 
    e.*, 

    p.sku,
    p.capacidad,
    p.tipo_servicio,
    p.tiempo_entrega,

    v.id AS venta_id,
    v.folio AS venta_folio,
    v.metodo_pago AS venta_metodo_pago,
    v.collection_id AS venta_collection_id,
    v.status AS venta_status,

    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso,
    c.thumb AS imagenes,
    c.slug,
    
    t.id AS t_id,
    t.numero AS t_numero,
    t.tipo AS t_tipo,
    t.status AS t_status,
    t.total AS t_total,
    t.hash AS t_hash
    FROM envios e
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN va_couriers c ON e.id_courier = c.id
    LEFT JOIN shippr_transacciones t ON t.tipo IN ("cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t.id_ref = e.id
    WHERE
    e.id_usuario = :id
    ORDER BY
    e.id
    DESC
    ';

    $rows = parent::query($sql,['id' => $user]);
    return ($rows ? $rows : false);
  }

  public static function by_id($id)
  {
    # Seleccionar envíos, conectar con productos y conectar con ventas
    $sql = 'SELECT 
    e.*,

    u.nombre AS u_nombre,
    u.usuario AS u_usuario,
    u.email AS u_email,

    c.thumb AS imagenes,
    c.slug,

    p.sku,
    p.capacidad,
    p.tipo_servicio,
    p.tiempo_entrega,

    v.id AS venta_id,
    v.folio AS venta_folio,
    v.metodo_pago AS venta_metodo_pago,
    v.collection_id AS venta_collection_id,
    v.status AS venta_status,
    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso,

    t.id AS t_id,
    t.numero AS t_numero,
    t.tipo AS t_tipo,
    t.status AS t_status,
    t.total AS t_total,
    t.hash AS t_hash
    
    FROM envios e
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN usuarios u ON e.id_usuario = u.id_usuario
    LEFT JOIN va_couriers c ON e.id_courier = c.id
    LEFT JOIN shippr_transacciones t ON t.tipo IN ("cargo_sobrepeso_saldo","cargo_recoleccion_saldo") AND t.id_ref = e.id
    WHERE
    e.id = :id
    ORDER BY
    e.id
    DESC
    ';

    $row = parent::query($sql, ['id' => $id]);
    return ($row ? $row[0] : false);
  }
}
