<?php 

class CSRF extends TokenHandler {
  
  private $token;
  private $token_expiration;
  private $expiration_time = 60 * 5; // 2 minutos
  
  // Crear nuestro token si no existe y es el primer ingreso al sitio
  public function __construct()
  {
    if(!isset($_SESSION['csrf_token'])) {
      $this->generate();
      $_SESSION['csrf_token'] =
      [
        'token'      => $this->token,
        'expiration' => $this->token_expiration
      ];
      return $this;
    }

    $this->token            = $_SESSION['csrf_token']['token'];
    $this->token_expiration = $_SESSION['csrf_token']['expiration'];

    return $this;
  }
  
  // Reiniciar el token
  private function generate()
  {
    $this->token   = new parent();
    $this->token   = $this->token->getToken();
    $this->token_expiration = time() + $this->expiration_time;
    return $this;
  }

  public function get_token()
  {
    return $this->token;
  }

  public function get_expiration()
  {
    return $this->token_expiration;
  }

  // Validar el token
  public static function validate($csrf_token, $validate_expiration = false)
  {
    $self = new self();
    // Validando el tiempo de expiración del token
    if($validate_expiration && $self->get_expiration() < time()) {
      return false;
    }

    if($csrf_token !== $self->get_token()) {
      return false;
    }

    return true;
  }

  // Regenerar
  public static function regenerate()
  {
    $self = new self();
    $self->generate();
    $_SESSION['csrf_token'] =
    [
      'token'      => $self->token,
      'expiration' => $self->token_expiration
    ];

    return true;
  }
}