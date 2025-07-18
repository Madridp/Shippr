<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- Área del contenido principal -->
<div class="content">
  <?php flasher() ?>

  <div class="row">
    <div class="col-xl-3"></div>
    <div class="col-xl-6 col-sm-12">
      <div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header"><?php echo $d->title; ?>
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

          <h1 class="m-0">Compra exitosa</h1>
          <small class="text-muted m-0">Compra <a href="<?php echo 'compras/ver/'.$d->v->folio; ?>" target="_blank"><?php echo '#'.$d->v->folio; ?></a></small>
          <h3>¡Gracias por tu compra <?php echo get_user_name(); ?>!</h3>
          <p>Aun debes realizar tu pago usando la App de <a href="https://www.mercadopago.com.mx/servicios?matt_tool=55129772&matt_word=exact&gclid=CjwKCAiAu_LgBRBdEiwAkovNsH_-26fm6EsjQcooZpSxVGn45-j9MBFhPA2m8vs-C5Dz8Vq27-GtthoCSw4QAvD_BwE" target="_blank">Mercado Pago</a> o <a href="https://www.mercadolibre.com.mx/gz/app" target="_blank">Mercado Libre</a>, selecciona la opción <b>Pagar con código QR</b>, escanea, ingresa el monto y paga.</p>
          <a href="<?php echo URL.IMG.'va-qr-example-app.png' ?>" data-lightbox="Ejemplos" data-title="Ejemplo QR Mercado Pago VA">
            <img src="<?php echo URL.IMG.'va-qr-example-app.png' ?>" alt="Ejemplo QR Mercado Pago VA" class="img-fluid img-thumbnail" style="width: 100px;">
          </a>
          <a href="<?php echo URL.IMG.'va-example-qr-code-app-ml.png' ?>" data-lightbox="Ejemplos" data-title="Ejemplo QR Mercado Libre VA">
            <img src="<?php echo URL.IMG.'va-example-qr-code-app-ml.png' ?>" alt="Ejemplo QR Mercado Libre VA" class="img-fluid img-thumbnail" style="width: 100px;">
          </a>
          <p>Al finalizar envía el comprobante a <?php echo get_smtp_email() ?> con el asunto <?php echo '"Comprobante de pago compra #'.$d->v->folio.'".'; ?></p>
          <p>¡Listo, apresúrate!, tus clientes aún esperan sus productos.</p>
          <div class="text-center">
            <img src="<?php echo URL.IMG.'va-qr-code-500.png' ?>" alt="Código QR" class="img-fluid">
          </div>
          <br><br>

          <h6>Resumen de compra</h6>
          <?php if (isset($d->v->items) && !empty($d->v->items)): ?>
          <table class="table table-borderless table-hover">
            <thead>
              <th>Producto</th>
              <th>P. unitario</th>
              <th class="text-center">Cantidad</th>
              <th class="text-right">Total</th>
            </thead>
            <tbody>
              <?php foreach ($d->v->items as $i): ?>
              <tr>
                <td class="align-middle">
                  <?php echo $i->titulo.' '.$i->tipo_servicio.' ('.$i->tiempo_entrega.')'; ?>
                  <small class="text-muted d-block"><?php echo 'Capacidad de '.$i->capacidad.' kg'; ?></small>
                  <small class="text-muted d-block"><?php echo 'De '.json_decode($i->remitente)->cp.' a '.json_decode($i->destinatario)->cp ?></small>
                  <small><a href="<?php echo 'envios/ver/'.$i->id; ?>" target="_blank">Ver envío</a></small>
                </td>
                <td class="align-middle"><?php echo money($i->precio,'$') ?></td>
                <td class="align-middle text-center">1</td>
                <td class="align-middle text-right"><?php echo money((float) $i->precio * 1,'$') ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
          Ocurrió un error o no hay registros en esta compra.
          <?php endif; ?>

          <table class="table table-borderless table-hover table-sm">
            <tbody>
              <tr>
                <th width="40%">Estado del pago</th>
                <td class="align-middle text-right">
                  <?php echo get_payment_status($d->v->pago_status) ?>
                  <img class="img-fluid float-right m-l-10" src="<?php echo get_payment_image($d->v->pago_status) ?>" alt="<?php echo get_payment_status($d->v->pago_status) ?>" style="width: 20px;">
                </td>
              </tr>
              <tr>
                <th width="40%">Método de pago</th>
                <td class="align-middle text-right">
                  <?php echo get_payment_method_status($d->v->metodo_pago) ?>
                  <img class="img-fluid float-right m-l-10" src="<?php echo get_payment_method_image($d->v->metodo_pago) ?>" alt="<?php echo get_payment_method_status($d->v->metodo_pago) ?>" style="width: 20px;">
                </td>
              </tr>
              <tr>
                <th width="40%">Subtotal</th>
                <td class="align-middle text-right"><?php echo money($d->v->subtotal,'$') ?></td>
              </tr>
              <tr>
                <th>Comisiones</th>
                <td class="align-middle text-right"><?php echo money($d->v->comision,'$') ?></td>
              </tr>
              <tr>
                <th>Total</th>
                <td class="align-middle text-right"><?php echo money($d->v->total,'$') ?></td>
              </tr>
            </tbody>
          </table>
        </div>
			</div>
    </div>
  </div>  
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>