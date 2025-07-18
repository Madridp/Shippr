<?php 

/**
 * version 1.0.3.5
 */
class DbUpgradeHandler extends Conexion
{
  private $siteversion;
  private $file;
  private $upgrades       = [];
  private $queue_upgrades = [];
  private $err_count      = 0;
  private $errors         = [];
  private $success_count  = 0;
  private $exceptions     = false;

  public function __construct($siteversion , $exceptions = false)
  {
    $this->siteversion = $siteversion;
    $this->exceptions  = $exceptions;

    // Set new changes behind the scenes
    $this->set_new_upgrades();

    // Check if there's new upgrades of database
    if(!$this->check_if_new_changes()) {
      if($this->exceptions) {
        throw new Exception('There are not database upgrades at this moment.', 1);
      }
      return false;
    }

    // Upgrade database
    $this->upgrade();
        
    // Validate all changes
    if($this->err_count >= 1) {
      if($this->exceptions) {
        throw new Exception(sprintf('There were %s errors during database upgrade.',$this->err_count), 1);
      }
      return false;
    }
    
    return true;
  }

  private function check_if_new_changes()
  {
    if(empty($this->upgrades)) {
      return false;
    }

    // Loop array to find current version and upgrades
    foreach ($this->upgrades as $version => $upgrades) {
      if($this->siteversion == $version) {
        $this->queue_upgrades = $upgrades;
        return true;
      }
    }
    return false;
  }

  private function set_new_upgrades()
  {
    $this->file = MIGRATIONS.$this->siteversion.'.php';
    if(!is_file($this->file)) {
      return false;
    }

    $this->upgrades = require $this->file;
    return true;
  }

  public function get_upgrades()
  {
    return $this->upgrades;
  }

  public function upgrade()
  {
    if(empty($this->queue_upgrades)) {
      return false;
    }

    foreach ($this->queue_upgrades as $query) {
      try {
        
        $current_upgrade = parent::query($query, [], true);
        $this->success_count++;
        
      } catch (Exception $e) {
        $msg = $e->getMessage();
        $this->err_count++;
        $this->errors[] = $msg;
      }
    }

    return true;
  }

  public function get_upgrades_count()
  {
    return count($this->queue_upgrades);
  }

  public function get_queue_upgrades()
  {
    return $this->queue_upgrades;
  }

  public function get_success_count()
  {
    return $this->success_count;
  }

  public function get_err_count()
  {
    return $this->err_count;
  }

  public function get_errors()
  {
    return $this->errors;
  }
}
