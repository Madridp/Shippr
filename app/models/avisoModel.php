<?php

class avisoModel extends Model
{
  static function all()
  {
    $sql = 'SELECT p.*
    FROM posts p
    WHERE p.tipo IN ("aviso")
    ORDER BY p.id
    DESC';

    $rows = parent::query($sql);
    return ($rows) ? $rows : false;
  }
  
}
