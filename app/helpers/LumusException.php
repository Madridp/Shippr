<?php 

class LumusException extends Exception
{

  // Redefine the exception so message isn't optional
  public function __construct($message, $code = 0, Exception $previous = null , $params = null)
  {
    // some code

    // make sure everything is assigned properly
    parent::__construct($message, $code, $previous);

  }

  // custom string representation of object
  public function __toString()
  {
    return __class__ . ": [{$this->code}]: {$this->message}\n";
  } 
}
