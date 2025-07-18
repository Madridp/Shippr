<?php 
/**
* Modelo de tabla tokens
*/
class tokenModel extends Model
{
  public static function add_new($reference = NULL , $lifetime = NULL)
  {
    $token = new TokenHandler();
    $new_token = $token->getToken();

    $tkn = 
    [
      'id_ref'     => ($reference !== NULL ? $reference : NULL),
      'token'      => $new_token,
      'lifetime'   => ($lifetime !== NULL ? $lifetime : NULL),
      'valid'      => 1,
      'created_at' => ahora()
    ];

    if(!$id = self::add('tokens',$tkn)) {
      return false;
    }

    $tkn['id'] = $id;
    return $tkn;
  }

  public static function delete_expired()
  {
    $sql = 'DELETE t FROM tokens t WHERE t.valid = 0 OR t.lifetime < :lifetime';
    return (self::query($sql,['lifetime' => time()],null)) ? true : false;
  }
  
  public static function validate($token)
  {
    $conditions =
    [
      'token' => $token['token']
    ];
    $sql = 'SELECT t.* FROM tokens t WHERE token = :token AND valid = 1';

    if(isset($token['id_ref'])) {
      $sql .= ' AND id_ref = :id_ref';
      $conditions['id_ref'] = $token['id_ref'];
    } 
    if (isset($token['lifetime'])) {
      $sql .= ' AND lifetime > :now';
      $conditions['now'] = $token['lifetime'];
    }

    $rows = parent::query($sql,$conditions);
    return ($rows) ? $rows[0] : false;
  }
}