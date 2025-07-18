<?php 

class envioMailer extends MailerBody
{
  private $data = null;

  public function __construct($envio)
  {
    if(empty($envio)){
      return false;
    }

    if(is_array($envio)){
      $this->data = json_decode(json_encode($envio));
    }

    return $this;
  }

  public function label_ready($to = 'va')
  {
    if(!$this->data){
      return false;
    }

    switch ($to) {
      case 'usuario':
        if(!empty($this->data->num_guia)) {
          $body = 'Hola '.$this->data->u_nombre.', te informamos que la etiqueta para tu envío está lista para descargar e imprimir, el número de rastreo asignado es <b>'.$this->data->num_guia.'</b> por '.$this->data->titulo.'.';
        } else {
          $body = 'Hola '.$this->data->u_nombre.', te informamos que la etiqueta para tu envío está lista para descargar e imprimir.';
        }
        
        $body .= '<br><br>
        Recuerda que puedes agendar la recolección de tu envío, para ver como hacerlo visita el siguiente <a href="'.URL.'recoleccion">enlace</a>.
        <br><br>
        Da click <a href="'.buildURL(URL.'envios/print-label/'.$this->data->id,['label' => $this->data->adjunto,'nonce' => randomPassword(20)]).'">aquí</a> para descargar o en el botón de abajo.<br><br>'
        .get_single_shipment_address($this->data).'<br><br>

        '.get_email_ty_message().'

        <a class="btn btn-primary" href="'.buildURL(URL.'envios/print-label/'.$this->data->id,['label' => $this->data->adjunto,'nonce' => randomPassword(20)]).'">Descargar etiqueta</a>
        <a class="btn btn-primary" href="'.URL.'envios/nuevo">Seguir comprando</a>
        ';
          
        $data['title']   = 'Etiqueta lista para imprimir';
        $data['altbody'] = 'Etiqueta lista para imprimir';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-label-ready.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' ¡Etiqueta lista para imprimir!');
        $email->addAddress($this->data->u_email); // Actualizar esto de forma dinámica

       
    
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
        $body = 'Una etiqueta está lista para imprimir:
        <br><br>
        Da click <a href="'.buildURL(URL.'admin/envios-print-label/'.$this->data->id,['label' => $this->data->adjunto,'nonce' => randomPassword(20)]).'">aquí</a> para descargar o en el botón de abajo.<br><br>'
        .get_single_shipment_address($this->data).'<br><br>
        Mensaje adicional de iPack:<br>
        '.$this->data->mensaje.'<br><br>

        <a class="btn btn-primary" href="'.buildURL(URL.'admin/envios-print-label/'.$this->data->id,['label' => $this->data->adjunto,'nonce' => randomPassword(20)]).'">Descargar etiqueta</a>
        <a class="btn btn-primary" href="'.URL.'admin/envios-index">Administrar</a>
        ';
          
        $data['title']   = 'Se ha subido una etiqueta';
        $data['altbody'] = 'Se ha subido una etiqueta';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-label-ready.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Se ha subido una etiqueta');
        $email->addAddress(get_smtp_email());
    
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

  public function solicitar_generacion()
  {
    if(!$this->data) {
      return false;
    }

    $body = 'Hola, este es un correo electrónico con el resumen del envío <a href="'.buildURL(URL.'admin/envios-ver/'.$this->data->id).'">'.$this->data->id.'</a> para generación de documento de rastreo:
    <br><br>
    <a class="btn btn-primary" href="'.$this->upload_link().'">Subir documento</a>
    <br><br>
    '.$this->formatear_cotizacion().'
    <br>
    '.$this->formatear_remitente().'
    <br>
    '.$this->formatear_destinatario().'
    <br>'.get_email_ty_message();

    $data['title']   = 'Resumen de envío';
    $data['altbody'] = 'Resumen de envío';
    $data['body']    = $body;
    $data['banner']  = URL.IMG.'va-create-label.png';

    $email = new Mailer();
    $email->setFrom(get_smtp_email() , get_sitename());
    $email->setSubject(get_email_sitename().' Generar guía de envío #ID '.$this->data->id);
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
  }

  private function formatear_cotizacion()
  {
    if(!$this->data || !isset($this->data->remitente)){
      return false;
    }

    $remitente = json_decode($this->data->remitente);
    $destinatario = json_decode($this->data->destinatario);

    $output = '<h2>Información del envío</h2>';
    $output .= '<table style="width: 100%; border: none;">';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Código Postal Remitente (México)
        </td>
        <td colspan="2" style="color: red; font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->cp.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Código Postal Destinatario (México)
        </td>
        <td colspan="2" style="color: blue; font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->cp.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Peso (Kilos)
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$this->data->peso_neto.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Largo (Centimetros)
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$this->data->paq_largo.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Ancho (Centimetros)
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$this->data->paq_ancho.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Alto (Centimetros)
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$this->data->paq_alto.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Peso volumétrico
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.((float) $this->data->paq_alto * $this->data->paq_largo * $this->data->paq_ancho / 5000).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Forma de pago
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.get_payment_method_status($this->data->venta_metodo_pago).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Tipo de servicio
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.ucfirst($this->data->tipo_servicio).' ('.$this->data->tiempo_entrega.')
        </td>
      </tr>';
      $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Paquetería
        </td>
        <td colspan="2" style="color: red; font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$this->data->titulo.'
        </td>
      </tr>';
      $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Contenido del paquete
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$this->data->descripcion.'
        </td>
      </tr>';
    $output .= '</table>';
    return $output;
  }

  private function formatear_remitente()
  {
    if(!$this->data || !isset($this->data->remitente)){
      return false;
    }

    $remitente = json_decode($this->data->remitente);

    $output = '<h2>Datos del remitente</h2>';
    $output .= '<table style="width: 100%; border: none;">';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Código Postal
        </td>
        <td colspan="2" style="color: red; font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->cp.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Nombre
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->nombre.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Empresa:
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->empresa.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Teléfono
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->telefono.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Calle
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->calle.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Núm. exterior
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->num_ext.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Núm. interior
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.(empty($remitente->num_int) ? 'S/N' : $remitente->num_int).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Colonia
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->colonia.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Ciudad
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->ciudad.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Estado
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->estado.'
        </td>
      </tr>';
      $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Referencias
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$remitente->referencias.'
        </td>
      </tr>';
    $output .= '</table>';
    return $output;
  }

  private function formatear_destinatario()
  {
    if(!$this->data || !isset($this->data->destinatario)){
      return false;
    }

    $destinatario = json_decode($this->data->destinatario);

    $output = '<h2>Datos del destinatario</h2>';
    $output .= '<table style="width: 100%; border: none;">';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Código Postal
        </td>
        <td colspan="2" style="color: red; font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->cp.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Nombre
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->nombre.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Empresa:
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->empresa.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Teléfono
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->telefono.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Calle
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->calle.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Núm. exterior
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->num_ext.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Núm. interior
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.(empty($destinatario->num_int) ? 'S/N' : $destinatario->num_int).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Colonia
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->colonia.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Ciudad
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->ciudad.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Estado
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->estado.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Referencias
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-left: 12px; direction: ltr;">
          '.$destinatario->referencias.'
        </td>
      </tr>';
    $output .= '</table>';
    return $output;
  }

  private function upload_link()
  {
    if(empty($this->data->token) || !isset($this->data->token)) {
      //return false;
    }

    //return URL.'admin/upload-document?token='.urlencode($this->data->token).'&id='.urlencode($this->data->id).'&time='.urlencode(time());
    return sprintf(URL.'admin/envios-actualizar/%s', $this->data->id);
  }

  public function cargo_sobrepeso()
  {
    $body = 'Hola <b>%s</b>,<br>
    Lamentamos informarte que tu <b><a href="%s">envío #%s</a></b> generó un recargo ya que el peso real declarado por la paquetería fue <b>mayor</b> al amparado en la guía.<br><br>
    Tienes <b>3 días</b> hábiles para realizar el pago con el saldo de tu cuenta:<br>
    <div class="dropzone" style="text-align:center;">
      Importe total %s
    </div>
    <br>
    <a href="%s" class="btn btn-success">Pagar ahora</a><br><br>'.get_email_ty_message();
    $body = sprintf($body, $this->data->u_nombre, URL.'envios/ver/'.$this->data->id, $this->data->id, money($this->data->t_total, '$'), URL.'envios/ver/'.$this->data->id);
      
    $data['title']   = sprintf('Tu envío #%s tiene un recargo', $this->data->id);
    $data['altbody'] = 'Cargo por sobrepeso generado en tu envío';
    $data['body']    = $body;
    //$data['banner']  = URL.IMG.'new_user.png';

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' '.sprintf('Tu envío #%s tiene un recargo', $this->data->id));
    $email->addAddress($this->data->u_email); // Actualizar esto de forma dinámica

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

  public function cobro_sobrepeso()
  {
    $body = 'Hola <b>%s</b>,<br>
    Lamentamos informarte que hemos debitado de tu cuenta un monto total de <b>%s</b>, ya que tu <b><a href="%s">envío #%s</a></b> generó un recargo por sobrepeso, el peso real declarado por la paquetería fue <b>mayor</b> al amparado en la guía.<br><br>
    <div class="dropzone" style="text-align:center;">
      Importe total %s
    </div>
    <br>
    <a href="%s" class="btn btn-success">Transacciones</a><br><br>'.get_email_ty_message();
    $body = sprintf($body, $this->data->u_nombre, money($this->data->t_total, '$'), URL.'envios/ver/'.$this->data->id, $this->data->id, money($this->data->t_total, '$'), URL.'transacciones');
      
    $data['title']   = 'Debitamos de tu cuenta un cargo por sobrepeso';
    $data['altbody'] = 'Cargo por sobrepeso generado en tu envío';
    $data['body']    = $body;

    $email = new Mailer();
    $email->setFrom(get_noreply_email() , get_sitename());
    $email->setSubject(get_email_sitename().' '.sprintf('Debitamos de tu cuenta un cargo por sobrepeso del envío #%s', $this->data->id));
    $email->addAddress($this->data->u_email); // Actualizar esto de forma dinámica

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
}