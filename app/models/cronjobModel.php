<?php

class cronjobModel extends Model
{
  public static function add_new($titulo , $descripcion = '')
  {
    $cronjob =
    [
      'tipo'       => 'cronjob',
      'titulo'     => $titulo,
      'contenido'  => (empty($descripcion) ? 'Cronjob ejecutado con éxito, ' : $descripcion.', ').fecha(ahora()),
      'created_at' => ahora()
    ];

    if(!$id = parent::add('posts',$cronjob)) {
      return false;
    }

    $cronjob['id'] = $id;
    return $cronjob;
  }

  public static function once_a_day($titulo)
  {
    $sql = "SELECT c.id FROM posts c WHERE c.tipo = 'cronjob' AND c.titulo = :titulo AND DATE(created_at) = CURRENT_DATE LIMIT 1";
    $res = parent::query($sql , ['titulo' => $titulo]);
    if(!$res) {
      return false;
    }

    return true;
  }

  public static function twice_a_day($titulo)
  {
    $sql = "SELECT COUNT(c.id) AS total FROM posts c WHERE c.tipo = 'cronjob' AND c.titulo = :titulo AND DATE(created_at) = CURRENT_DATE";
    $res = parent::query($sql , ['titulo' => $titulo]);

    if(!$res || empty($res)) {
      return false;
    }

    return ($res[0]['total'] == 2) ? true : false;
  }

  public static function delete_expired($days = 15)
  {
    if(!is_integer($days)) {
      $days = 15;
    }
    
    $sql = 'DELETE c.* FROM posts c WHERE tipo = "cronjob" AND DATE(created_at) < DATE(NOW() - INTERVAL '.$days.' DAY)';
    return ($res = parent::query($sql)) ? true : false;
  }



}
