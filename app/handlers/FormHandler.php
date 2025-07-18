<?php 

class FormHandler
{
  private $form_name;
  private $field;
  private $params = [];

  public function __construct($form_name)
  {
    $this->form_name                     = $form_name;

    if(!isset($_SESSION['forms'][$this->form_name])) {
      $_SESSION['forms'][$this->form_name] = [];
    } else {
      $_SESSION['forms'][$this->form_name] = self::get($this->form_name);
    }

    return $this;
  }

  public function get_field($field)
  {
    $this->field = $field;
    return self::field($this->form_name, $field);
  }

  /**
   * Crea un nuevo formulario para guardar la información
   *
   * @param string $form_name
   * @return void
   */
  public static function create($form_name)
  {
    $form = new self($form_name);
    return $form;
  }

  /**
   * Guarda todos los valores de un formulario
   *
   * @param string $form_name
   * @param array $form_fields
   * @return void
   */
  public static function save($form_name, $form_fields)
  {
    $_SESSION['forms'][$form_name] = $form_fields;
  }

  /**
   * Regresa todos los campos de un formulario existente
   *
   * @param string $form_name
   * @return void
   */
  public static function get($form_name)
  {
    if(!isset($_SESSION['forms'][$form_name])) {
      return false;
    }

    return $_SESSION['forms'][$form_name];
  }

  /**
   * Regresa el valor de un campo del formulario
   *
   * @param string $form_name
   * @param string $field
   * @return void
   */
  public static function field($form_name, $field)
  {
    if(!isset($_SESSION['forms'][$form_name])) {
      return false;
    }

    if(!isset($_SESSION['forms'][$form_name][$field])) {
      return null;
    }

    return $_SESSION['forms'][$form_name][$field];
  }

  /**
   * Destruye el formulario actual guardado en session
   *
   * @param string $form_name
   * @return void
   */
  public static function destroy($form_name)
  {
    if(isset($_SESSION['forms'][$form_name])) {
      unset($_SESSION['forms'][$form_name]);
    }

    return true;
  }
}
