<?php 

class courierModel extends Model
{
  static function all()
  {
    $sql = 'SELECT c.*,
    (SELECT COUNT(z.id) FROM shippr_zonas z WHERE z.id_courier = c.id) AS cobertura
    FROM va_couriers c 
    ORDER BY c.id';
    $rows = parent::query($sql);
    return ($rows) ? $rows : false;
  }
}
