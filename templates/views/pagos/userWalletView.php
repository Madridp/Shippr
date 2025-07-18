<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- Área del contenido principal -->
<div class="content">
  <?php flasher() ?>

  <div class="row">
    <div class="offset-xl-3 col-xl-6 col-sm-12">
      <div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
          <h2 class="m-0">Compra exitosa</h2>
          <small class="text-muted m-0">Compra <a href="<?php echo 'compras/ver/'.$d->v->folio; ?>" target="_blank"><?php echo '#'.$d->v->folio; ?></a></small>
          <h3 class="f-w-500">¡Gracias por tu compra <?php echo get_user_name(); ?>!</h3>
          <?php switch($d->v->pago_status): case 'pagado': ?>
            <p>Tu pago ha sido aprobado con éxito utilizando el <b>crédito de tu cuenta</b>.</p>
          <?php break; ?>
          <?php case 'pendiente': ?>
            <p class="mb-1">Pago <span class="text-danger">pendiente</span>, completa la transacción <a href="<?php echo buildURL('compras/pagar/'.$d->v->id, ['nonce' => $d->v->nonce], false); ?>" target="_blank">aquí</a> usando el <b>crédito de tu cuenta</b>.</p>
            <a href="<?php echo buildURL('compras/pagar/'.$d->v->id, ['nonce' => $d->v->nonce], false); ?>" class="btn btn-success mb-3" target="_blank">Pagar ahora</a>
            <a href="<?php echo 'usuarios/recargar-saldo'; ?>" class="btn btn-info mb-3" target="_blank">Recargar saldo</a>
          <?php break; ?>
          <?php endswitch; ?>
          <p>¡Listo, apresúrate!, tus clientes aún esperan sus productos.</p>
          <br><br>

          <h6>El resumen de tu compra</h6>
          <?php if (isset($d->v->items) && !empty($d->v->items)): ?>
          <table class="table table-borderless table-hover">
            <thead>
              <th>Producto</th>
              <th>Precio unitario</th>
              <th class="text-center">Cantidad</th>
              <th class="text-right">Total</th>
            </thead>
            <tbody>
              <?php foreach ($d->v->items as $i): ?>
                <tr>
                  <td class="align-middle">
                    <?php echo $i->titulo; ?>
                    <small class="text-muted d-block"><?php echo 'De '.json_decode($i->remitente)->cp.' a '.json_decode($i->destinatario)->cp ?></small>
                    <small><a href="<?php echo 'envios/ver/'.$i->id; ?>" target="_blank">Ver envío</a></small>
                  </td>
                  <td class="align-middle"><?php echo money($i->precio,'$') ?></td>
                  <td class="align-middle text-center"><?php echo $i->cantidad; ?></td>
                  <td class="align-middle text-right"><?php echo money((float) $i->precio * 1) ?></td>
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