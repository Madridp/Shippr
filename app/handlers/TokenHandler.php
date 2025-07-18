<?php

class TokenHandler
{

  /**
   * Default token length to be used when creating a new one
   * 
   * You can pass a new value to the constructor everytime you create 
   * a new token, either way, we recommend not going below a value 24
   * @var integer $length
   */
  private $length = 32;

  /**
   * Hash salt to be used for authentification
   * 
   * @var string $hash_format
   * 
   * it can be either:
   * 
   * PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0). 
   * Note that this constant is designed to change over time as new and stronger algorithms are added to PHP. 
   * For that reason, the length of the result from using this identifier can change over time. 
   * Therefore, it is recommended to store the result in a database column that can expand 
   * beyond 60 characters (255 characters would be a good choice).
   * PASSWORD_BCRYPT - Use the CRYPT_BLOWFISH algorithm to create the hash. 
   * This will produce a standard crypt() compatible hash using the "$2y$" identifier. 
   * The result will always be a 60 character string, or FALSE on failure.
   * 
   * @var constant $valid_salts
   */
  private $hash_format = PASSWORD_DEFAULT;
  private $valid_salts = [PASSWORD_DEFAULT,PASSWORD_BCRYPT];


  /**
   * Token value withouth any hash
   * 
   * It's going to be a long integer
   * We recommend to use a varchar column just in case you are 
   * going to store the value on a database
   * 
   * You can get a DB error if it's too long
   * @var string $token
   * 
   */
  private $token;


  /**
   * This is going to be the token hashed using password_hash and a salt
   * It's one of the best way to crypt and produce a secure result.
   * 
   * @var string $hash_format
   */
  private $hashed_token;


  public function __construct($length = null)
  {

    if($length !== null){
      $this->length = intval($length);
    }

    $this->create();

    return $this;    
  }


  // Create token
  public function create()
  {

    // Length must be set and valid
    if(!$this->length){
      throw new InvalidArgumentException("Length of token is not a valid number.", 1);
    }

    // Sometimes the server doesnt have one of these functions
    // we will need at least one to work this out
    // to create a secure token
    if (function_exists('bin2hex')) {
      $this->token = bin2hex(random_bytes($this->length));
    } else {
      $this->token = bin2hex(openssl_random_pseudo_bytes($this->length));
    }

    return $this;
  }

  // Hash token
  public function hash()
  {

    if(!in_array($this->hash_format , $this->valid_salts)){
      throw new ErrorException("Not a valid hash_format provided.", 1);
    }

    // Hashing the token
    if($this->token == ''){
      throw new LumusException("The value of the token is empty, you must create it first.", 1);
    }

    // Now we hash our token
    $this->hashed_token = password_hash($this->token , $this->hash_format);


    return true;    

  }

  /**
   * Get the value of token
   */ 
  public function getToken()
  {
    return $this->token;
  }

  /**
   * Get $hash_format
   *
   * @return  string
   */ 
  public function getHashed_token()
  {
    return $this->hashed_token;
  }
}
