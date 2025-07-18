<?php

class JS_Options extends Model
{
  
  /**
   * Properties
   * 
   * @var int $opcion
   * 
   */
  private $ID;
  private $opcion;
  private $valor;
  private $fecha;

  public function __construct($_opcion = null)
  {

    if($_opcion !== null){
      $this->opcion = trim($_opcion);
      if (!$row = parent::list('opciones', ['opcion' => $this->opcion])[0]) {
        return false;
      }
      $this->opcion = $row['opcion'];
      $this->valor = $row['valor'];
      $this->fecha = $row['created_at'];
      return true;
    }
    
  }

  /**
   * Get option name and return it
   */
  public static function get_option($_opcion,$col = null)
  {
    $opt = new self($_opcion);
    if(!$row = parent::list('opciones',['opcion' => $opt->opcion])[0]){
      return false;
    }

    // Get the column value selected
    if($col !== null){
      if(array_key_exists($col,$row)){
        return $row[$col];
      }
      return false;
    }

    // Return just the value of the opcion selected
    return $row['valor'];
  }

  /**
   * Updates an option if exists
   *
   * @param string $opcion
   * @param mixed $value
   * @return void
   */
  public static function update_option($opcion , $value)
  {
    if(!is_string($opcion) && empty($value)){
      throw new LumusException('Invalid parameters provided.', 1);      
    }

    if(!self::update('opciones' , ['opcion' => $opcion] , ['valor' => $value])){
      return false;
    }

    return true;
  }

  /**
   * Add a new option if it does not exist, else updates it
   *
   * @param string $opcion
   * @param mixed $value
   * @return void
   */
  public static function add_option($opcion , $value)
  {
    if(!is_string($opcion) && empty($value)){
      throw new LumusException('Invalid parameters provided.', 1);      
    }

    if(self::list('opciones' , ['opcion' => $opcion] , 1)){
      return (self::update_option($opcion , $value) ? true : false);
    }

    if(!$id = self::add('opciones',['opcion' => $opcion , 'valor' => $value , 'created_at' => ahora()])){
      return false;
    }

    return $id;
  }

  /**
   * Get all options on database
   *
   * @return void
   */
  public static function all()
  {
    return ($options = parent::list('opciones')) ? $options : false;
  }

}
