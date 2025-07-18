<?php 

class productoModel extends Model
{
  public $t1 = 'productos';
  public $id;
  public $sku;
  public $titulo           = 'Guía de envío';
  public $id_courier       = 0;
  public $capacidad        = 1;
  public $tipo_servicio    = 'regular';
  public $tiempo_entrega;
  public $descripcion      = 'Guía electrónica de envío';
  public $precio           = 0;
  public $precio_descuento = 0;
  public $publicado        = 1;
  public $creado;
  public $actualizado;


  public static function all($only_active = false)
  {
    ## Filters
    $sql = null;
    if(!$only_active) {
      $sql = 
      'SELECT 
      p.*,
      c.slug,
      c.name,
      c.name AS titulo,
      c.phone,
      c.other_name,
      c.web_url,
      c.thumb AS imagenes,
      (SELECT COUNT(e.id) FROM envios e WHERE e.id_producto = p.id) AS ventas
      FROM 
      productos p
      JOIN va_couriers c ON p.id_courier = c.id
      ORDER BY 
      p.id 
      DESC';
    } else {
      $sql = 
      'SELECT 
      p.*,
      c.slug,
      c.name,
      c.phone,
      c.other_name,
      c.web_url,
      c.thumb AS imagenes,
      (SELECT COUNT(e.id) FROM envios e WHERE e.id_producto = p.id) AS ventas
      FROM 
      productos p
      JOIN va_couriers c ON p.id_courier = c.id
      WHERE p.publicado = 1
      ORDER BY 
      p.id 
      DESC';
    }


    $rows = parent::query($sql);
    return ($rows ? $rows : false);
  }

  public static function by_id($id, $cp = null)
  {
    $params = ['id_producto' => $id];
    $sql = 
    'SELECT 
    p.*,
    (IF(z.zona_extendida = 1, COALESCE(p.precio + z.cargo, 0), p.precio)) AS precio,
    c.slug,
    c.name,
    c.phone,
    c.other_name,
    c.web_url,
    c.thumb AS imagenes,
    null AS zona_extendida,
    (SELECT COUNT(e.id) FROM envios e WHERE e.id_producto = p.id) AS ventas
    FROM 
    productos p
    JOIN va_couriers c ON p.id_courier = c.id
    LEFT JOIN shippr_zonas z ON p.id_courier = z.id_courier
    WHERE
    p.id = :id_producto '.($cp === null ? '' : 'AND z.cp = :cp');

    if($cp !== null) {
      $params =
      [
        'id_producto' => $id,
        'cp'          => $cp
      ];
    }
    
    $row = parent::query($sql, $params)[0];
    return ($row ? $row : false);
  }

  public static function by_capacity($cap , $courier = null)
  {
    $sql = 'SELECT DISTINCT p.*,
    (IF(z.zona_extendida = 1, COALESCE(p.precio + z.cargo, 0), p.precio)) AS precio,
    c.slug,
    c.name,
    c.phone,
    c.other_name,
    c.web_url,
    c.thumb AS imagenes,
    null AS zona_extendida,
    1 AS rem_recoleccion,
    p.tipo_servicio AS p_tipo_servicio,
    (SELECT COUNT(e.id) FROM envios e WHERE e.id_producto = p.id) AS ventas
    FROM productos p
    JOIN va_couriers c ON p.id_courier = c.id
    LEFT JOIN shippr_zonas z ON p.id_courier = z.id_courier
    WHERE 
    p.capacidad >= :cap '.($courier !== null ? 'AND p.id_courier = :id_courier' : '').' AND p.publicado = 1
    ORDER BY 
    p.precio 
    DESC';

    $params['cap'] = $cap;
    if($courier !== null) {
      $params['id_courier'] = $courier;
    }
    
    $rows = parent::query($sql,$params);

    return ($rows) ? $rows : false;
  }

  public static function search($cap, $dest_cp = null, $id_courier = null, $tipo_servicio = null, $zona_extendida = null)
  {
    $sql = 
    "SELECT
      c.name AS titulo,
      (IF(z.zona_extendida = 1, COALESCE(p.precio + z.cargo, 0), p.precio)) AS precio,
      p.capacidad,
      z.cp,
      p.tipo_servicio,
      p.tiempo_entrega,
      z.recoleccion,
      z.zona_extendida,
      c.thumb AS imagenes
    FROM
      productos p
    JOIN va_couriers c ON p.id_courier = c.id
    JOIN shippr_zonas z ON p.id_courier = z.id_courier
    WHERE p.capacidad BETWEEN :cap AND :max_cap AND z.cp = :cp AND p.tipo_servicio IN(
      (CASE WHEN z.zona_extendida = 1 THEN '\'regular\''
      ELSE
        CONCAT('\'regular\'',',','\'express\'')
      END)
    )";

    $sql = 
    "SELECT
      p.id,
      c.name AS titulo,
      (IF(z.zona_extendida = 1, COALESCE(p.precio + z.cargo, 0), p.precio)) AS precio,
      p.capacidad,
      z.cp,
      p.tipo_servicio,
      p.tiempo_entrega,
      z.recoleccion,
      z.zona_extendida,
      c.thumb AS imagenes
    FROM
      productos p
    JOIN va_couriers c ON p.id_courier = c.id
    JOIN shippr_zonas z ON p.id_courier = z.id_courier
    WHERE p.capacidad BETWEEN :cap AND :max_cap AND z.cp = :cp";

    $params =
    [
      'cap'     => $cap,
      'max_cap' => ceil($cap * 3),
      'cp'      => $dest_cp
    ];

    if($id_courier !== null) {
      $sql .= ' AND p.id_courier = :id_courier';
      $params['id_courier'] = $id_courier;
    }
    
    return ($rows = parent::query($sql, $params)) ? $rows : false;
  }

  public static function has_pickup($cp)
  {
    $sql = 'SELECT recoleccion FROM shippr_zonas WHERE cp = :cp LIMIT 1';
    $row = parent::query($sql, ['cp' => $cp])[0];

    if(!$row) return false;

    return ((int) $row['recoleccion'] === 1);
  }

  public function agregar()
  {
    $data =
    [
      'sku'              => clean($this->sku),
      'titulo'           => clean($this->titulo),
      'descripcion'      => clean($this->descripcion),
      'id_courier'       => (int) clean($this->id_courier),
      'capacidad'        => (int) clean($this->capacidad),
      'tipo_servicio'    => clean($this->tipo_servicio),
      'tiempo_entrega'   => clean($this->tiempo_entrega),
      'precio'           => (float) clean($this->precio),
      'precio_descuento' => (float) clean($this->precio_descuento),
      'publicado'        => (int) clean($this->publicado),
      'creado'           => ahora()
    ];

    if(!$this->id = self::add($this->t1, $data)) {
      return false;
    }

    return $this->id;
  }

  public function actualizar()
  {
    $data =
    [
      'sku'              => clean($this->sku),
      'id_courier'       => (int) clean($this->id_courier),
      'capacidad'        => (int) clean($this->capacidad),
      'tipo_servicio'    => clean($this->tipo_servicio),
      'tiempo_entrega'   => clean($this->tiempo_entrega),
      'precio'           => (float) clean($this->precio),
      'precio_descuento' => (float) clean($this->precio_descuento)
    ];

    if(!self::update($this->t1, ['id' => $this->id], $data)) {
      return false;
    }

    return true;
  }

  public static function for_printing()
  {
    $sql = 
    'SELECT 
    p.*,
    c.slug,
    c.name,
    c.name AS titulo,
    c.phone,
    c.other_name,
    c.web_url,
    c.thumb
    FROM 
    productos p
    JOIN va_couriers c ON p.id_courier = c.id
    WHERE p.publicado = 1
    ORDER BY c.name DESC,
    p.capacidad ASC,
    p.precio ASC';

    return ($rows = parent::query($sql)) ? $rows : false;
  }
}
