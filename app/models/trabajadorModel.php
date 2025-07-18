<?php 

class trabajadorModel extends Model
{

  private $t1 = 'usuarios';
  private $t2 = 'roles';
  private $t3 = '';
  
  public static function all()
  {
    $self = new self();
    $sql = "SELECT u.* FROM $self->t1 u
    JOIN $self->t2 r ON u.id_role = r.id
    WHERE r.role = 'worker'
    ORDER BY u.id_usuario
    DESC";

    return ($rows = parent::query($sql)) ? $rows : false;
  }

  public static function sits_used()
  {
    $self = new self();
    $sql = "SELECT COUNT(u.id_usuario) AS total
    FROM $self->t1 u
    INNER JOIN $self->t2 r ON u.id_role = r.id
    WHERE r.role = 'worker'";

    return ($rows = parent::query($sql)) ? $rows[0]['total'] : false;
  }

  public static function available($spots_available)
  {
    $used = self::sits_used();

    if(!$used) {
      return true;
    }

    if($spots_available == 0) {
      return false;
    }

    return $spots_available > $used ? true : false;
  }

  public static function draw_table()
  {
    $data['trabajadores'] = self::all();

    $table = get_module('trabajadores/table', $data, true);

    return $table;
  }
}
