<?php 

class compraMailer extends MailerBody
{

  private $data = [];

  public function __construct($compra)
  {
    if(empty($compra)){
      return false;
    }

    if(is_array($compra)){
      $this->data = json_decode(json_encode($compra));
    }

    return $this;
  }

  /**
   * Para nuevas compras o primer correo
   * antes de realizar el pago
   *
   * @param string $to
   * @return void
   */
  public function nueva_compra($to = 'va')
  {
    if(!$this->data){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        <h2>Compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        Hola '.$this->data->nombre.', aquí tenemos el resumen de tu compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br>

        Tu pedido aún está pendiente de pago, la generación de guías será aprobada una vez completado el pago.<br><br>

        '.get_email_ty_message().'

        <a class="btn btn-primary" href="'.URL.'compras/ver/'.$this->data->folio.'">Ver compra</a>
        <a class="btn btn-primary" href="'.URL.'envios/nuevo">Seguir comprando</a>
        ';
          
        $data['title']   = 'Nueva compra realizada';
        $data['altbody'] = 'Nueva compra realizada';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-new-order.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' El resumen de tu compra #'.$this->data->folio);
        $email->addAddress($this->data->email); // Actualizar esto de forma dinámica

       
    
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
        <h2>Venta <a href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        Hemos recibido un pedido de '.$this->data->nombre.', aquí tenemos el resumen de su compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br><br>

        <a class="btn btn-primary" href="'.URL.'admin/ventas-index">Administrar</a>
        <a class="btn btn-primary" href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">Ver compra</a>
        ';
          
        $data['title']   = 'Nueva venta realizada';
        $data['altbody'] = 'Nueva venta realizada';
        $data['body']    = $body;
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' ¡Vendimos! Nuevo pedido #'.$this->data->folio);
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

  public function payment_pending($to = 'va')
  {
    if(!$this->data){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        <h2>Compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        Hola '.$this->data->nombre.', este es un correo para informarte que el pago de tu compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">'.$this->data->folio.'</a> aún está pendiente, de no ser recibido en las próximas 24 horas hábiles, el pedido será cancelado.<br><br>
        Aquí tenemos el resumen de tu compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br>

        '.get_email_ty_message().'

        <a class="btn btn-primary" href="'.URL.'compras/ver/'.$this->data->folio.'">Ver compra</a>
        <a class="btn btn-primary" href="'.URL.'envios/nuevo">Seguir comprando</a>
        ';
          
        $data['title']   = 'Pago pendiente';
        $data['altbody'] = 'Pago pendiente';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-pending.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Compra #'.$this->data->folio.' pendiente de pago');
        $email->addAddress($this->data->email); // Actualizar esto de forma dinámica
    
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
        <h2>Venta <a href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        El pago del pedido de '.$this->data->nombre.' aún está pendiente, aquí tenemos el resumen de su compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br><br>

        <a class="btn btn-primary" href="'.URL.'admin/ventas-index">Administrar</a>
        <a class="btn btn-primary" href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">Ver venta</a>
        ';
          
        $data['title']   = 'Pago pendiente';
        $data['altbody'] = 'Pago pendiente';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-approved.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pedido #'.$this->data->folio.' pendiente de pago');
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

  public function compra_pagada($to = 'va')
  {
    if(!$this->data){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        <h2>Compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        Hola '.$this->data->nombre.', aquí tenemos el resumen de tu compra del día '.fecha($this->data->creado).'.<br><br>
        Tu pago ha sido aprobado con éxito, las guías solicitadas serán generadas en breve y estarán disponibles para su impresión en <a href="'.URL.'envios">'.get_sitename().'</a>.
        <br><br>
        '.$this->build_items_table().'
        <br>

        '.get_email_ty_message().'

        <a class="btn btn-primary" href="'.URL.'compras/ver/'.$this->data->folio.'">Ver compra</a>
        <a class="btn btn-primary" href="'.URL.'envios/nuevo">Seguir comprando</a>
        ';
          
        $data['title']   = 'Pago aprobado con éxito';
        $data['altbody'] = 'Pago aprobado con éxito';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-approved.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pago aprobado con éxito de tu compra #'.$this->data->folio);
        $email->addAddress($this->data->email); // Actualizar esto de forma dinámica
    
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
        '<h2>Venta <a href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        El pago del pedido de '.$this->data->nombre.' ha sido aprobado con éxito, aquí tenemos el resumen de su compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br><br>

        <a class="btn btn-primary" href="'.URL.'admin/ventas-index">Administrar</a>
        <a class="btn btn-primary" href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">Ver venta</a>
        ';
          
        $data['title']   = 'Pago recibido con éxito';
        $data['altbody'] = 'Pago recibido con éxito';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-approved.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pago recibido con éxito del pedido #'.$this->data->folio);
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

  public function payment_canceled($to = 'va')
  {
    if(!$this->data){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        <h2>Compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        Hola '.$this->data->nombre.', este es un correo para informarte que el pago de tu compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">'.$this->data->folio.'</a> ha sido cancelado y se procederá a hacer la devolución pertinente del monto total cobrado.<br><br>
        Aquí tenemos el resumen de tu compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br>

        '.get_email_ty_message().'

        <a class="btn btn-primary" href="'.URL.'compras/ver/'.$this->data->folio.'">Ver compra</a>
        <a class="btn btn-primary" href="'.URL.'envios/nuevo">Seguir comprando</a>
        ';
          
        $data['title']   = 'Pago cancelado';
        $data['altbody'] = 'Pago cancelado';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-canceled.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pago cancelado de tu compra #'.$this->data->folio);
        $email->addAddress($this->data->email); // Actualizar esto de forma dinámica
    
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
        <h2>Venta <a href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        El pago del pedido de '.$this->data->nombre.' ha sido cancelado y se procederá a hacer la devolución pertinente, aquí tenemos el resumen de su compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br><br>

        <a class="btn btn-primary" href="'.URL.'admin/ventas-index">Administrar</a>
        <a class="btn btn-primary" href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">Ver venta</a>
        ';
          
        $data['title']   = 'Pago cancelado';
        $data['altbody'] = 'Pago cancelado';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-canceled.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pago cancelado del pedido #'.$this->data->folio);
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

  public function payment_refunded($to = 'va')
  {
    if(!$this->data){
      return false;
    }

    switch ($to) {
      case 'usuario':
        $body =
        '
        <h2>Compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        Hola '.$this->data->nombre.', este es un correo para informarte que el pago de tu compra <a href="'.URL.'compras/ver/'.$this->data->folio.'">'.$this->data->folio.'</a> ha sido completamente devuelto, si tu pago fue con <b>MercadoPago</b>, este se verá reflejado ahí en menos de <i>24 horas hábiles</i>, si fue con transferencia se te hará la devolución directa a la cuenta de origen y se reflejará en <i>24 a 72 horas hábiles</i>, si fue en efectivo, nuestro equipo se comunicará contigo para proceder con el reembolso.<br><br>
        Aquí tenemos el resumen de tu compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br>

        '.get_email_ty_message().'

        <a class="btn btn-primary" href="'.URL.'compras/ver/'.$this->data->folio.'">Ver compra</a>
        <a class="btn btn-primary" href="'.URL.'envios/nuevo">Seguir comprando</a>
        ';
          
        $data['title']   = 'Pago devuelto';
        $data['altbody'] = 'Pago devuelto';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-refunded.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pago devuelto de tu compra #'.$this->data->folio);
        $email->addAddress($this->data->email); // Actualizar esto de forma dinámica
    
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
        <h2>Venta <a href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">#'.$this->data->folio.'</a></h2>
        El pago del pedido de '.$this->data->nombre.' ha sido devuelto o reembolsado, aquí tenemos el resumen de su compra del día '.fecha($this->data->creado).'.<br><br>
        '.$this->build_items_table().'
        <br><br>

        <a class="btn btn-primary" href="'.URL.'admin/ventas-index">Administrar</a>
        <a class="btn btn-primary" href="'.URL.'admin/ventas-ver/'.$this->data->folio.'">Ver venta</a>
        ';
          
        $data['title']   = 'Pago cancelado';
        $data['altbody'] = 'Pago cancelado';
        $data['body']    = $body;
        $data['banner']  = URL.IMG.'va-payment-refunded.png';
    
        $email = new Mailer();
        $email->setFrom(get_noreply_email() , get_sitename());
        $email->setSubject(get_email_sitename().' Pago devuelto del pedido #'.$this->data->folio);
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

  private function build_items_table()
  {
    $output = '<table style="width: 100%; border: none;">
      <tr>
        <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Producto
        </td>
        <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          Total
        </td>
      </tr>';

    foreach ($this->data->items as $i) {
      $output .= '
      <tr style="border-bottom: 1px solid #E9ECEF;">
        <td style="font-weight:normal; line-height: 14px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          <b>'.$i->titulo.'</b>
          <small><a href="'.URL.'envios/ver/'.$i->id.'" style="font-size:12px;">Ver envío</a></small>
        </td>
        <td style="font-weight:normal; line-height: 14px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money((float) $i->cantidad * $i->precio).'
        </td>
      </tr>';
    }
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Estado de compra
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.get_sale_status($this->data->status).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Estado de pago
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.get_payment_status($this->data->pago_status).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Método de pago
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.get_payment_method_status($this->data->metodo_pago).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Número de pago
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.$this->data->collection_id.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Orden mercantil (MercadoPago)
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.$this->data->merchant_order_id.'
        </td>
      </tr>';
    
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Subtotal
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money($this->data->subtotal).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Comisiones
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money($this->data->comision).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Total
        </td>
        <td style="vertical-align: middle; font-weight:bold; color: red; font-size: 20px; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money($this->data->total).'
        </td>
      </tr>';
    $output .= '</table>';
    return $output;
  }

  private function build_items_table2()
  {
    $output = '<table style="width: 100%; border: none;">
      <tr>
        <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Producto
        </td>
        <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
          P. unitario
        </td>
        <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
          Cantidad
        </td>
        <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          Total
        </td>
      </tr>';

    foreach ($this->data->items as $i) {
      $output .= '
      <tr>
        <td style="font-weight:normal; line-height: 14px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          <b>'.$i->titulo.'</b>
          <small class="d-block">Capacidad de '.$i->capacidad.'</small>
          <small><a href="'.URL.'envios/ver/'.$i->id.'" style="font-size:12px;">Ver envío</a></small>
        </td>
        <td style="font-weight:normal; line-height: 14px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
          '.money($i->precio).'
        </td>
        <td style="font-weight:normal; line-height: 14px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
          '.$i->cantidad.'
        </td>
        <td style="font-weight:normal; line-height: 14px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money((float) $i->cantidad * $i->precio).'
        </td>
      </tr>';
    }
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Estado de compra
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.get_sale_status($this->data->status).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Estado de pago
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.get_payment_status($this->data->pago_status).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Método de pago
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.get_payment_method_status($this->data->metodo_pago).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Número de pago
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.$this->data->collection_id.'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="2" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Orden mercantil (MercadoPago)
        </td>
        <td colspan="2" style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.$this->data->merchant_order_id.'
        </td>
      </tr>';
    
    $output .= '
      <tr>
        <td colspan="3" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Subtotal
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money($this->data->subtotal).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="3" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Comisiones
        </td>
        <td style="font-weight:bold; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money($this->data->comision).'
        </td>
      </tr>';
    $output .= '
      <tr>
        <td colspan="3" style="font-weight:normal; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
          Total
        </td>
        <td style="font-weight:bold; color: red; font-size: 16px; line-height: 16px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
          '.money($this->data->total).'
        </td>
      </tr>';
    $output .= '</table>';
    return $output;
  }
}