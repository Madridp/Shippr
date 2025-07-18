<?php 

class usuarioMailer extends MailerBody
{

  private $usuario;
  private $data;

  public function __construct($usuario)
  {
    if(empty($usuario)){
      return false;
    }

    if(is_array($usuario)){
      $this->data = $this->usuario = json_decode(json_encode($usuario));
    }

    return $this;
  }

  public function agregado($to = 'system')
  {
    if(!isset($this->usuario->unhashed)){
      $this->usuario->unhashed = 'Desconocido';
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        Hola '.$this->usuario->nombre.', aquí tenemos tus datos de ingreso a la plataforma de '.get_sitename().',<br><br>
        
        Usuario: <strong>'.$this->usuario->usuario.'</strong><br>
        Email: <strong>'.$this->usuario->email. '</strong><br>
        Contraseña: <strong>' . $this->usuario->unhashed . '</strong><br>
        No compartas con nadie esta información, solo tú la conoces.<br><br>
        Puedes comenzar a utilizar la plataforma de forma inmediata, bienvenido.<br>
        '.get_sitename().'<br><br>
        <a class="btn btn-primary" href="'.URL.'login">Iniciar sesión</a>
        ';
          
        $data['title']   = '¡Bienvenido a bordo!';
        $data['altbody'] = 'Tus datos de usuario';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'new_user.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Tus datos de usuario');
        $email->addAddress($this->usuario->email); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
        break;
      
      default:
        $body =
        '
        Nuevo usuario agregado, '.$this->usuario->nombre.',<br>

        Usuario: <strong>'.$this->usuario->usuario.'</strong><br>
        Email: <strong>'.$this->usuario->email. '</strong><br>
        Contraseña: <strong>*****</strong><br>
        Esta información es privada, no debe ser compartida con nadie.<br>
        ';
          
        $data['title']   = 'Nuevo usuario agregado';
        $data['altbody'] = 'Nuevo usuario agregado';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'new_user.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Nuevo usuario agregado');
        $email->addAddress(get_smtp_email()); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
        break;
    }
  }

  public function modificado($to = 'system')
  {
    if(!$this->usuario){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        Hola '.$this->usuario->nombre.',<br>
        Tu información de usuario ha sido actualizada, aquí tienes.<br><br>
        Usuario: <strong>'.$this->usuario->usuario.'</strong><br>
        Email: <strong>'.$this->usuario->email. '</strong><br>
        Contraseña: <strong>' . ($this->usuario->unhashed ? $this->usuario->unhashed : 'Permanece sin cambios') . '</strong><br>
        No compartas con nadie esta información, solo tú la conoces.<br><br>
        Puedes continuar utilizando la plataforma de forma inmediata.<br>
        '.get_sitename().'<br><br>
        <a class="btn btn-primary" href="'.URL.'login">Iniciar sesión</a>
        ';
          
        $data['title']   = 'Nuevos datos de usuario';
        $data['altbody'] = 'Nuevos datos de usuario';
        $data['body']    = $body;
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Nuevos datos de usuario');
        $email->addAddress($this->usuario->email); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
        break;
      
      default:
        $body =
        '
        Usuario actualizado, '.$this->usuario->nombre.',<br>

        Usuario: <strong>'.$this->usuario->usuario.'</strong><br>
        Email: <strong>'.$this->usuario->email. '</strong><br>
        Contraseña: <strong>*****</strong><br>
        Esta información es privada, no debe ser compartida con nadie.<br>
        ';
          
        $data['title']   = 'Usuario actualizado';
        $data['altbody'] = 'Usuario actualizado';
        $data['body']    = $body;
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Usuario actualizado');
        $email->addAddress(get_smtp_email()); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
        break;
    }
  }

  public function recuperacion_password()
  {
    if(!isset($this->usuario->password_token)){
      return false;
    }
    
    $data['subject'] = 'Recuperación de contraseña';
    $data['title']   = 'Recuperación de contraseña';
    $data['altbody'] = 'Recupera tu contraseña con este link.';
    $data['body'] =
    '<p>
    Para recuperar tu contraseña entra al siguiente enlace o da click <a href="'.buildURL(URL.'login/actualizar-contrasena',['token' => $this->usuario->password_token]).'">aquí</a>.<br>
    </p>
    <p class="small">Si no requieres actualizarla, solo ignora este mensaje.</p>
    <a class="btn btn-success" href="'.buildURL(URL.'login/actualizar-contrasena', ['token' => $this->usuario->password_token], false).'">Recuperar contraseña</a>
    ';

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' Recuperación de contraseña');
    $email->addAddress($this->usuario->email);

    /** Get body  */
    $body = new parent(get_email_template() ,$data);
    $body->parseBody();
    $email->setBody($body->getOutput());
    if(!$email->send()){
      return false;
    }
    $email = null;
    $body = null;
    return true;
  }

  public function tareas_pendientes($tareas)
  {
    switch ($tareas) {
      case null:
        $data['subject'] = 'No tienes tareas pendientes';
        $data['title'] = 'No tienes tareas pendientes';
        $data['altbody'] = 'No tienes tareas pendientes';
        $data['banner'] = URL.IMG.'sin-tareas.png';
        $data['body'] =
        '
        <p>Hola '.$this->usuario->nombre.', en hora buena, parece ser que no tienes tareas pendientes.<br>
        <br>
        <a href="'.URL.'dashboard" class="btn btn-primary">Agregar una tarea</a>
        ';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' No tienes tareas pendientes');
        $email->addAddress($this->usuario->email);
    
        /** Get body  */
        $body = new parent(get_email_template() ,$data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if(!$email->send()){
          return false;
        }
        $email = null;
        $body = null;
        return true;

        break;

      default:

        /** Armar string con tareas pendientes */
        $output = '';
        foreach ($tareas as $t) {
          $output .= '<li>';
          $output .= $t['titulo'] . ' - ' . $t['permalink'] . '<br>';
          $output .= (strtotime($t['deadline_at']) > 0) ? 'Para el ' . fecha($t['deadline_at']) : 'Entrega sin definir';
          $output .= '</li>';
        }

        $title = 'Tienes tareas pendientes';
        $data['subject'] = $title;
        $data['title'] = $title;
        $data['altbody'] = $title;
        $data['banner'] = URL.IMG.'tareas-pendientes.png';
        $data['body'] =
        'Hola '.$this->usuario->nombre.', tienes tareas pendientes por realizar.<br>
				<ul>
				' . $output . '
				</ul>
				<br>
				<a href="'.URL.'dashboard" class="btn btn-primary">Ver tareas</a>
				';

        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' '.$title);
        $email->addAddress($this->usuario->email);

        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
    }
  }

  public function registrado($to = 'va')
  {
    if(!isset($this->usuario->unhashed)){
      $this->usuario->unhashed = 'Desconocido';
    }

    switch ($to) {
      case 'usuario':
        $body = '
        Hola '.$this->usuario->nombre.', ¡enhorabuena!, bienvenido a '.get_sitename().', te vamos a ayudar a mantener tus envíos en orden y bajo control, todo en un mismo lugar, nosotros nos encargamos de eso.<br><br>
        Aquí estan tus datos de ingreso, toda tu información está segura y no es compartida con nadie, comienza ahora aquí.<br>

        Usuario: <strong>'.$this->usuario->usuario.'</strong><br>
        Email: <strong>'.$this->usuario->email. '</strong><br>
        Contraseña: <strong>' . $this->usuario->unhashed . '</strong><br>

        '.get_sitename().'<br><br>
        <a class="btn btn-primary" href="'.URL.'login">Iniciar sesión</a>
        ';
          
        $data['title']   = '¡Bienvenido a bordo!';
        $data['altbody'] = 'Tus datos de usuario';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-registered.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' ¡Bienvenido a bordo!');
        $email->addAddress($this->usuario->email); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        
        return true;
        break;
      
      default:
        $body =
        'Un nuevo usuario se ha registrado en '.get_system_name().',<br>
        Su nombre es '.$this->usuario->nombre.',<br><br>
        Usuario: <strong>'.$this->usuario->usuario.'</strong><br>
        Email: <strong>'.$this->usuario->email. '</strong><br>
        Contraseña: <strong>*******</strong><br>
        Esta información es privada, no debe ser compartida con nadie.<br>
        ';
          
        $data['title']   = ' ¡Yajuuuu!, nuevo usuario registrado';
        $data['altbody'] = ' ¡Yajuuuu!, nuevo usuario registrado';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-registered.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().'  ¡Yajuuuu!, nuevo usuario registrado');
        $email->addAddress(get_smtp_email()); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template() , $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }

        return true;
        break;
    }
  }

  public function solicitud_saldo()
  {
    $body = 'Hola <b>'.$this->data->nombre.'</b>, recibimos la solicitud para recargar el saldo de tu cuenta, sigue las instrucciones para realizar el pago:<br><br>
    1.- Utiliza los datos bancarios:<br>
    <div class="dropzone" style="text-align:center;">
      '.get_ticket_payment_info().'
    </div>
    2.- Realiza tu pago por un monto de:<br>
    <div class="dropzone">
      <h2 style="margin:0px;text-align:center;"><b>'.money($this->data->total).'</b> MXN</h2>
    </div>
    3.- Envía una imagen de tu comprobante de pago a <b>'.get_smtp_email().'</b> con el asunto:
    <div class="dropzone">
      <h3 style="margin:0px;text-align:center;"><b>Comprobante folio #'.$this->data->numero.'</b></h3>
    </div>
    4.- Una vez aprobada la transacción tu saldo será abonado en tu cuenta en menos de 2 horas.<br><br>
    
    No compartas con nadie esta información, sólo tú la conoces.<br><br>'.get_email_ty_message();
      
    $data['title']   = 'Ticket para recargar saldo';
    $data['altbody'] = 'Recarga el saldo de tu cuenta con este ticket';
    $data['body']    = $body;
    //$data['banner']  = URL.IMG.'new_user.png';

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' '.sprintf('Ticket de pago %s generado', $this->data->numero));
    $email->addAddress($this->usuario->email); // Actualizar esto de forma dinámica

    /** Get body  */
    $body = new parent(get_email_template() , $data);
    $body->parseBody();
    $email->setBody($body->getOutput());
    if (!$email->send()) {
      return false;
    }
    
    $email = null;
    return true;
  }

  public function nueva_solicitud()
  {
    $body = 'Hola, el usuario <b>%s</b> ha solicitado el ticket con folio <b>%s</b> para recargar saldo a su cuenta por un monto de:<br><br>
    <div class="dropzone">
      <h2 style="margin:0px;text-align:center;"><b>%s</b> MXN</h2>
    </div>
    Recuerda esperar a que el usuario realice el pago antes de abonar el saldo a su cuenta.<br><br>
    <a class="btn btn-primary" href="%s">Administrar recargas</a><br><br>'.get_email_ty_message();
      
    $data['title']   = 'Recarga solicitada';
    $data['altbody'] = 'Nueva recarga de saldo solicitada';
    $data['body']    = sprintf($body, $this->data->nombre, $this->data->numero, money($this->data->total), buildURL(URL.'admin/recargas', [], false));
    //$data['banner']  = URL.IMG.'new_user.png';

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' '.sprintf('Nuevo ticket %s de recarga solicitado', $this->data->numero));
    $email->addAddress(get_smtp_email()); // Actualizar esto de forma dinámica

    /** Get body  */
    $body = new parent(get_email_template() , $data);
    $body->parseBody();
    $email->setBody($body->getOutput());
    if (!$email->send()) {
      return false;
    }
    
    $email = null;
    return true;
  }

  public function abono_aprobado()
  {
    $body = sprintf('Hola <b>%s</b>, tu ticket <b>%s</b> ha sido aprobado y hemos abonado un total de <b>%s</b> MXN a tu cuenta, muchas gracias.<br><br>
    <p>Saldo abonado con éxito:</p>
    <div class="dropzone">
      <h2 style="margin:0px;text-align:center;"><b>%s</b> MXN</h2>
    </div><br><br>'.get_email_ty_message(), $this->data->nombre, $this->data->numero, money($this->data->total), money($this->data->total));
      
    $data['title']   = 'Saldo abonado con éxito';
    $data['altbody'] = 'Saldo abonado con éxito';
    $data['body']    = $body;
    //$data['banner']  = URL.IMG.'new_user.png';

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' '.sprintf('Hemos abonado %s a tu cuenta', money($this->data->total)));
    $email->addAddress($this->usuario->email); // Actualizar esto de forma dinámica

    /** Get body  */
    $body = new parent(get_email_template() , $data);
    $body->parseBody();
    $email->setBody($body->getOutput());
    if (!$email->send()) {
      return false;
    }
    
    $email = null;
    return true;
  }

  public function abono_rechazado()
  {
    $body = sprintf('Hola <b>%s</b>, te informamos que tu ticket <b>%s</b> lamentablemente ha sido rechazado y no será abonado saldo a tu cuenta.<br><br>'.get_email_ty_message(), $this->data->nombre, $this->data->numero, money($this->data->total));
      
    $data['title']   = 'Ticket rechazado';
    $data['altbody'] = 'Ticket rechazado';
    $data['body']    = $body;
    //$data['banner']  = URL.IMG.'new_user.png';

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' '.sprintf('Hemos rechazado el ticket %s', $this->data->numero));
    $email->addAddress($this->usuario->email); // Actualizar esto de forma dinámica

    /** Get body  */
    $body = new parent(get_email_template() , $data);
    $body->parseBody();
    $email->setBody($body->getOutput());
    if (!$email->send()) {
      return false;
    }
    
    $email = null;
    return true;
  }

  public function suspendido($to = 'system')
  {
    if(!$this->usuario){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        'Hola '.$this->usuario->nombre.',<br><br>
        Queremos informarte que has sido suspendido por tiempo indefinido de <a href="'.URL.'">'.get_sitename().'</a>, por favor ponte en contacto con un superior para entender la razón del problema.<br><br>
        '.get_sitename();
          
        $data['title']   = 'Has sido suspendido del sistema';
        $data['altbody'] = 'Has sido suspendido del sistema';
        $data['banner']  = URL.IMG.'jserp-usuario-suspendido.png';
        $data['body']    = $body;
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Has sido suspendido del sistema');
        $email->addAddress($this->usuario->email);
    
        /** Get body  */
        $body = new parent(get_email_template(), $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
        break;
      
      default:
        $url  = buildURL(URL.'usuarios/revertir-suspension/'.$this->usuario->id_usuario);
        $body =
        'Hola '.$this->usuario->nombre.',<br><br>
        Queremos informarte que '.$this->usuario->nombre.' ha sido suspendido por tiempo indefinido, si esto no fue autorizado por '.get_sitename().' puedes revertir la acción con el siguiente botón o dando clic <a href="'.$url.'">aquí</a>.<br><br>
        '.get_sitename().'<br><br>
        <a class="btn btn-danger" href="'.$url.'">Revertir acción</a>
        ';
          
        $data['title']   = 'Un usuario ha sido suspendido del sistema';
        $data['altbody'] = 'Un usuario ha sido suspendido del sistema';
        $data['banner']  = URL.IMG.'jserp-usuario-suspendido.png';
        $data['body']    = $body;
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Usuario suspendido');
        $email->addAddress(get_smtp_email()); // Actualizar esto de forma dinámica
    
        /** Get body  */
        $body = new parent(get_email_template(), $data);
        $body->parseBody();
        $email->setBody($body->getOutput());
        if (!$email->send()) {
          return false;
        }
        $email = null;
        $body = null;
        return true;
        break;
    }
  }

  public function invitacion()
  {
    # shippertodo
  }
}
