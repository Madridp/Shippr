<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content" id="app">
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
          <p>Aun debes realizar el pago, realiza tu depósito en ventanilla, tiendas OXXO o 7 Eleven y envíanos tu comprobante de pago a <?php echo get_smtp_email() ?> con el asunto <?php echo '"Comprobante de pago compra #'.$d->v->folio.'".'; ?></p>
          <p>¡Listo, apresúrate!, tus clientes aún esperan sus productos.</p>
          <div class="table-responsive">
            <table class="table table-borderless table-sm table-hover">
              <tr>
                <td class="align-middle" width="20%">Nombre</td>
                <td class="f-w-600">JOSÉ ROBERTO OROZCO AVILÉS</td>
              </tr>
              <tr>
                <td class="align-middle" width="20%">Banco</td>
                <td class="f-w-600">Santander</td>
              </tr>
              <tr>
                <td class="align-middle" width="20%">Sucursal</td>
                <td class="f-w-600">7855</td>
              </tr>
              <tr>
                <td class="align-middle" width="20%">Clabe</td>
                <td class="f-w-600">014180605818295363</td>
              </tr>
              <tr>
                <td class="align-middle" width="20%">N. de cuenta</td>
                <td class="f-w-600">60-58182953-6</td>
              </tr>
              <tr>
                <td class="align-middle" width="20%">OXXO / 7 Eleven</td>
                <td class="f-w-600">5579 0700 7962 8247</td>
              </tr>
            </table>
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