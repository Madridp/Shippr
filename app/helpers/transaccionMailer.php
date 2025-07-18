<?php 

class transaccionMailer extends MailerBody
{

  private $data;

  public function __construct($data)
  {
    if(empty($data)){
      return false;
    }

    if(is_array($data)){
      $this->data = json_decode(json_encode($data));
    }

    return $this;
  }
}
