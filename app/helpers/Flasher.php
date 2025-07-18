<?php 

  class Flasher
  {
    
    private $valid_types = ["success", "danger", "warning", "info", "default", "tip",'primary'];
    private $type;
    private $msj;
    private $icon;

    public function __construct($_msj,$_type)
    {

      $this->msj = trim($_msj);
      if(!in_array($_type,$this->valid_types)){
        $this->type = 'info';
      } else {
        $this->type = $_type;
      }

    }

    /**
     * Method used to create a new notification based on $msj and $type
     * 
     * You can create a single notification only using this method
     * 
     * @param $type
     * 
     * @param $msj
    */
    public function create()
    {
      // Validate the message actually exists
      // if it doesn't you throw a new exception to the system
      if(!$this->msj){
        throw new Exception("Error: Propiedad msj no definida.", 1);
        
      }

      // Just set the value of the notification and thats it
      $_SESSION[$this->type][] = trim($this->msj);
      return true;
    }

    /**
     * Calls a static method to create
     * a new notification 
     * It will be displayed when the function flasher() is used.
     * 
     * You can mass multiple error or success messages at once using an array of strings
     */
    public static function save($msgs , $type = "success")
    {
      $types = ["success","danger","warning","info","default","tip"];

      if (!in_array($type, $types)) {
        $type = "info";
      }
      if (is_array($msgs)) {
        foreach ($msgs as $msg) {
          $_SESSION[$type][] = $msg;
        }
        return true;
      }
      $_SESSION[$type][] = $msgs;
      return true;
    }

    /**
     * Creates a new "Acceso no autorizado." message to the user.
     * @param string
     */
    public static function access($_type = 'denied')
    {

      // $_type will only accept "granted" or "denied"
      // It will create a new notificación for the system
      // Based on the type

      if(!in_array($_type, ['granted', 'denied'])){
        throw new Exception("Error: El parametro ".$_type." no es válido.", 1);
      }
      
      
      if($_type === 'granted'){
        $msj = 'Acceso autorizado con éxito.';
        $type = 'success';
      }
      
      if($_type === 'denied'){
        $msj = 'Acceso no autorizado.';
        $type = 'danger';
      }
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;      

    }

    /**
     * Creates a new "action" message to the user.
     * @param string
     */
    public static function action($_type = 'denied')
    {

        // $_type will only accept "granted" or "denied"
        // It will create a new notificación for the system
        // Based on the type

      if (!in_array($_type, ['granted', 'denied'])) {
        throw new Exception("Error: El parametro " . $_type . " no es válido.", 1);
      }


      if ($_type === 'granted') {
        $msj = 'Acción realizada con éxito.';
        $type = 'success';
      }

      if ($_type === 'denied') {
        $msj = 'Acción no autorizada por el sistema.';
        $type = 'danger';
      }

      $flash = new self($msj, $type);
      if (!$flash->create()) {
        return false;
      }

      return true;

    }

    public static function added($object , $done = true)
    {
      if($done){
        $msj = sprintf( '%s agregado con éxito.' , ucfirst($object) );
        $type = 'success';
      } else {
        $msj = sprintf('%s no agregado, hubo un error o no es válido, intenta de nuevo.', ucfirst($object));
        $type = 'danger';
      }
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;  
    }

    public static function updated($object , $done = true)
    {
      if($done){
        $msj = sprintf('%s actualizado con éxito.',ucfirst($object));
        $type = 'success';
      } else {
        $msj = sprintf('%s no actualizado, hubo un error o no es válido, intenta de nuevo.',ucfirst($object));
        $type = 'danger';
      }
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;  
    }

    public static function deleted($object , $done = true)
    {
      if($done){
        $msj = sprintf('%s borrado con éxito.',ucfirst($object));
        $type = 'success';
      }else{
        $msj = sprintf('%s no borrado, hubo un error o no es válido, intenta de nuevo.',ucfirst($object));
        $type = 'danger';
      }
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;  
    }

    public static function error()
    {
      $msj = 'Algo salió mal, intenta de nuevo.';
      $type = 'danger';
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;     
    }

    public static function email_to($to = 'system' , $done = true)
    {
      switch ($to) {
        case 'usuario':
          $msj = sprintf(($done ? 'Notificación a %s enviada con éxito.' : 'Notificación a %s no enviada, hubo un error.' ) , $to);
          $type = ($done ? 'info' : 'danger');
          break;
        
        case 'cliente':
          $msj = sprintf(($done ? 'Notificación a %s enviada con éxito.' : 'Notificación a %s no enviada, hubo un error.' ) , $to);
          $type = ($done ? 'info' : 'danger');
          break;
        
        case 'system':
          $msj = sprintf(($done ? 'Notificación a %s enviada con éxito.' : 'Notificación a %s no enviada, hubo un error.' ) , get_sitename());
          $type = ($done ? 'info' : 'danger');
          break;
        
        default:
          $msj = sprintf(($done ? 'Notificación a %s enviada con éxito.' : 'Notificación a %s no enviada, hubo un error.' ) , $to);
          $type = ($done ? 'info' : 'danger');
          break;
      }
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;   
    }

    public static function not_found($object = 'registro')
    {
      $msj = sprintf('El %s que buscas no existe, intenta de nuevo.', $object);
      $type = 'danger';
      
      $flash = new self($msj,$type);
      if(!$flash->create()){
        return false;
      }

      return true;
    }



  }
  
