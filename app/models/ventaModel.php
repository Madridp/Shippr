<?php 

class ventaModel extends Model
{
  public static function all()
  {
    $sql = 'SELECT
    v.*,
    u.nombre,
    u.email,
    u.usuario,
    (SELECT COUNT(e.id) FROM envios e WHERE v.id = e.id_venta) AS envios
    FROM ventas v
    LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
    ORDER BY
    v.id
    DESC';

    $rows = parent::query($sql);

    return ($rows ? $rows : false);
  }

  public static function by_user($user)
  {
    $sql = 'SELECT
    v.*,
    u.nombre,
    u.email,
    u.usuario,
    (SELECT COUNT(e.id) FROM envios e WHERE v.id = e.id_venta) AS envios
    FROM ventas v
    LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
    WHERE
    v.id_usuario = :user ORDER BY v.id DESC';

    $rows = parent::query($sql,['user' => $user]);

    return ($rows ? $rows : false);
  }
  
  public static function by_id($id)
  {
    $sql = 'SELECT
    v.*,
    u.nombre,
    u.email,
    u.usuario,
    (SELECT COUNT(e.id) FROM envios e WHERE v.id = e.id_venta) AS envios
    FROM ventas v
    LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
    WHERE
    v.id = :id ORDER BY v.id DESC';

    $row = parent::query($sql, ['id' => $id])[0];

    if(!$row) return false;

    $sql = 'SELECT
    e.*,
    p.capacidad,
    p.sku,
    p.tipo_servicio,
    p.tiempo_entrega,
    v.id AS venta_id,
    v.folio AS venta_folio,
    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso,
    c.thumb AS imagenes
    FROM envios e
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN va_couriers c ON p.id_courier = c.id
    WHERE
    e.id_venta = :id_venta
    ORDER BY
    e.id
    DESC
    ';
    $items = parent::query($sql, ['id_venta' => $row['id']]);
    $row['items'] = $items;

    return ($row ? $row : false);
  }

  public static function by_user_and_folio($user, $folio)
  {
    $sql = 'SELECT
    v.*,
    u.nombre,
    u.email,
    u.usuario,
    t.id AS t_id,
    t.numero AS t_numero,
    t.status AS t_status,
    t.total AS t_total,
    (SELECT COUNT(e.id) FROM envios e WHERE v.id = e.id_venta) AS envios
    FROM ventas v
    LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
    LEFT JOIN shippr_transacciones t ON t.id_ref = v.id AND t.tipo = "retiro_saldo" AND t.tipo_ref = "compra"
    WHERE
    v.id_usuario = :user AND v.folio = :folio
    LIMIT 1';

    $row = parent::query($sql,['user' => $user,'folio' => $folio])[0];

    if(!$row) return false;

    // Editado en versión 2.0.0 removiendo titulo de producto
    $sql = 'SELECT
    e.*,
    p.capacidad,
    p.sku,
    p.tipo_servicio,
    p.tiempo_entrega,
    v.id AS venta_id,
    v.folio AS venta_folio,
    c.thumb AS imagenes,
    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso
    FROM envios e
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN va_couriers c ON p.id_courier = c.id
    WHERE
    e.id_venta = :id_venta AND e.id_usuario = :user
    ORDER BY
    e.id
    DESC
    ';
    $items = parent::query($sql,['id_venta' => $row['id'],'user' => $user]);
    $row['items'] = $items;

    // Pagos
    // serptodo

    return ($row ? $row : false);
  }

  public static function by_folio($folio)
  {
    $sql = 'SELECT
    v.*,
    u.nombre,
    u.email,
    u.usuario,
    u.telefono,
    (SELECT COUNT(e.id) FROM envios e WHERE v.id = e.id_venta) AS envios
    FROM ventas v
    LEFT JOIN usuarios u ON v.id_usuario = u.id_usuario
    WHERE
    v.folio = :folio
    LIMIT 1
    ';

    $row = parent::query($sql,['folio' => $folio])[0];

    if(!$row) return false;

    $sql = 'SELECT
    e.*,
    p.capacidad,
    p.sku,
    p.tipo_servicio,
    p.tiempo_entrega,
    v.id AS venta_id,
    v.folio AS venta_folio,
    c.thumb AS imagenes,
    CASE
      WHEN p.capacidad >= e.peso_real THEN 0
      WHEN p.capacidad < e.peso_real THEN 1
    END AS sobrepeso
    FROM envios e
    LEFT JOIN ventas v ON e.id_venta = v.id
    LEFT JOIN productos p ON e.id_producto = p.id
    LEFT JOIN va_couriers c ON p.id_courier = c.id
    WHERE
    e.id_venta = :id_venta AND e.id_usuario = :user
    ORDER BY
    e.id
    DESC
    ';
    $items = parent::query($sql,['id_venta' => $row['id'],'user' => $row['id_usuario']]);
    $row['items'] = $items;

    return ($row ? $row : false);
  }

  public static function stats_by_venta($id_venta)
  {
  }
}
