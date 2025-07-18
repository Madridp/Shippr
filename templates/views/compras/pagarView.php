<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['compras','Compras'],['compras/ver/'.$d->v->folio, 'Ver'],['', $d->title]]) ?>
  <?php flasher() ?>

  <div class="row">
    <div class="offset-xl-3 col-xl-6 col-sm-12">
      <div class="col-12">
        <div class="pvr-wrapper">
          <div class="pvr-box">
            <h5 class="pvr-header"><?php echo $d->title; ?></h5>
            <h6>El resumen de tu compra</h6>
            <?php if (isset($d->v->items) && !empty($d->v->items)): ?>
            <table class="table table-borderless table-hover vmiddle">
              <thead>
                <th>Producto</th>
                <th class="text-center">Precio unitario</th>
                <th class="text-center">Cantidad</th>
                <th class="text-right">Total</th>
              </thead>
              <tbody>
                <?php foreach ($d->v->items as $i): ?>
                  <tr>
                    <td class="">
                      <?php echo $i->titulo; ?>
                      <small class="text-muted d-block"><?php echo 'De '.json_decode($i->remitente)->cp.' a '.json_decode($i->destinatario)->cp ?></small>
                      <small><a href="<?php echo 'envios/ver/'.$i->id; ?>" target="_blank">Ver envío</a></small>
                    </td>
                    <td class="text-center"><?php echo money($i->precio,'$') ?></td>
                    <td class="text-center"><?php echo $i->cantidad; ?></td>
                    <td class="text-right"><?php echo money((float) $i->precio * 1) ?></td>
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
                  <td class="align-middle text-right"><?php echo money($d->v->subtotal) ?></td>
                </tr>
                <tr>
                  <th>Comisiones</th>
                  <td class="align-middle text-right"><?php echo money($d->v->comision) ?></td>
                </tr>
                <tr>
                  <th>Total</th>
                  <td class="align-middle text-right"><?php echo money($d->v->total) ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="pvr-wrapper">
          <div class="pvr-box">
            <form action="transacciones/nueva" method="POST">
              <?php echo insert_inputs(); ?>
              <input type="hidden" name="id_venta" value="<?php echo $d->v->id; ?>" required>
              <input type="hidden" name="id_usuario" value="<?php echo get_user_id(); ?>" required>
              <button class="btn btn-success btn-lg btn-block"><?php echo sprintf('Pagar ahora %s MXN', money($d->v->total)); ?></button>
              <div class="text-center mt-2">
                <small class="text-muted">Debes completar el pago para que tu compra sea procesada</small>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>  
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>