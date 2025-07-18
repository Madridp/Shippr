<?php 

class PayerHandler
{

  private $id_user;
  private $payer;

  public function __construct($id = null)
  {
    if($id !== NULL){
      $this->create_payer($id);
      return $this->payer;
    }

    return $this;
  }

  public function create_payer($id)
  {
    
  }
  
}
