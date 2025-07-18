<?php 

class zonaModel extends Model
{
	private $t1 = "shippr_zonas";
	
	function __construct()
	{
	}

	public static function by_cp($codigo_postal)
	{
    $sql  = 'SELECT 
    z.*,

    c.slug,
    c.name AS titulo,
    c.thumb AS imagenes,
    c.phone,
    c.other_name,

    p.sku,
    p.capacidad,
    p.tipo_servicio AS p_tipo_servicio,
    p.tiempo_entrega,
    (IF(z.zona_extendida = 1, COALESCE(p.precio + z.cargo, 0), p.precio)) AS precio,
    p.precio_descuento,
    p.publicado

    FROM shippr_zonas z 
    JOIN productos p ON p.id_courier = z.id_courier
    JOIN va_couriers c ON z.id_courier = c.id
    WHERE z.cp = :cp 
    ORDER BY z.id DESC';
		return ($rows = parent::query($sql, ['cp' => $codigo_postal])) ? $rows : false;
  }

  public static function search($remitente, $destinatario, $capacidad, $id_courier = null)
	{
    $sql  = 'SELECT 
    z.*,
    z.id AS z_id,

    c.slug,
    c.name AS titulo,
    c.thumb AS imagenes,
    c.phone,
    c.other_name,

    p.id,
    p.sku,
    p.capacidad,
    p.tipo_servicio AS p_tipo_servicio,
    p.tiempo_entrega,
    (IF(z.zona_extendida = 1, COALESCE(p.precio + z.cargo, 0), p.precio)) AS precio,
    p.precio_descuento,
    p.publicado,

    r.cp AS rem_cp,
    r.recoleccion AS rem_recoleccion

    FROM shippr_zonas z 
    JOIN productos p ON p.id_courier = z.id_courier 
    JOIN va_couriers c ON z.id_courier = c.id
    LEFT JOIN shippr_zonas r ON r.cp = :remitente AND r.id_courier = z.id_courier
    WHERE z.cp = :destinatario AND p.capacidad BETWEEN :capacidad AND :max_capacidad '.($id_courier !== null ? 'AND z.id_courier = :id_courier' : null).'
    ORDER BY z.id DESC';

    $params = 
    [
      'destinatario'  => $destinatario, 
      'remitente'     => $remitente, 
      'capacidad'     => ceil($capacidad), 
      'max_capacidad' => ceil($capacidad * 3)
    ];

    if($id_courier !== null) {
      $params['id_courier'] = $id_courier;
    }

    return ($rows = parent::query($sql, $params)) ? $rows : false;
  }
  
  public static function by_id($id)
	{
    $sql = 'SELECT * FROM shippr_zonas z WHERE z.id = :id LIMIT 1';
		return ($rows = parent::query($sql, ['id' => $id])) ? $rows[0] : false;
  }
  
  public static function single_shipment()
  {
    # code...
  }
}