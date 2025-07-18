<?php 

class informacionController extends Controller
{

  public function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $this->contacto();
  }

  public function precios()
  {
    $this->data =
    [
      'title' => 'Todos los precios',
      'productos' => productoModel::all()
    ];
    View::render('precios',$this->data);
  }

  public function terminos_y_condiciones()
  {
    $this->data =
    [
      'title' => 'Términos y condiciones'
    ];
    View::render('terminos',$this->data,true);
  }

  public function aviso_de_privacidad()
  {
    $this->data =
    [
      'title' => 'Aviso de privacidad'
    ];
    View::render('aviso',$this->data,true);
  }

  public function articulos_prohibidos()
  {
    $this->data =
    [
      'title' => 'Artículos prohibidos'
    ];
    View::render('articulos',$this->data,true);
  }

  public function recoleccion_de_paquetes()
  {

  }

  public function preguntas_frecuentes()
  {
    $this->data =
    [
      'title' => 'Preguntas frecuentes'
    ];
    View::render('FAQ',$this->data);
  }

  public function contacto()
  {
    $this->data =
    [
      'title' => 'Contáctanos'
    ];
    View::render('contacto',$this->data,true);
  }

  public function contacto_submit()
  {
    if(!isset($_POST)){
      Flasher::access();
      Taker::back();
    }

    if(empty($_POST['nombre']) || empty($_POST['mensaje'])){
      Flasher::save('Completa todos los campos.', 'danger');
      Taker::back();
    }

    if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
      Flasher::save('Dirección de correo no válida.', 'danger');
      Taker::back();
    }

    $nombre     = clean($_POST['nombre']);
    $email_addr = clean($_POST['email']);
    $telefono   = clean($_POST['telefono']);
    $mensaje    = clean($_POST['mensaje']);

    ## Envío de mensaje de contacto
    $_body = '
    Haz recibido un mensaje:<br>
    <b>Nombre:</b> '.$nombre.'<br>
    <b>Email:</b> '.$email_addr.'<br>
    <b>Teléfono:</b> '.$telefono.'<br>
    <b>Mensaje:</b><br>'.$mensaje.'
    ';
    $data = 
    [
      'title'   => sprintf('Nuevo mensaje desde %s', get_system_name()),
      'subject' => sprintf('%s Nuevo mensaje desde web', get_email_sitename()),
      'body'    => $_body,
      'alt'     => sprintf('Nuevo mensaje desde %s', get_system_name())
    ];
    
    $email = new Mailer();
		$email->setFrom(get_noreply_email(), get_system_name());
		$email->addAddress(get_smtp_email());
    $email->setSubject($data['subject']);
    
		$body = new MailerBody(get_email_template(), $data);
		$body = $body->parseBody()->getOutput();
		$email->setBody($body);

		if(!$email->send()){
      Flasher::email_to(get_sitename(), false);
    } else {
      Flasher::email_to(get_sitename());
    }
    
    Taker::back();
  }

  public function calcular_peso_volumetrico()
  {
    $this->data =
    [
      'title' => 'Cotizar envío'
    ];
    
    View::render('calculo', $this->data);
  }
}
