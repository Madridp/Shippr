<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['compras','Compras'],['','Compra #'.$d->v->folio]]) ?>

	<?php flasher(); ?>
	
	<div class="row">
    <!-- Paquete y carrier -->
    <div class="col-xl-4">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">Información de la compra</h5>

          <small class="text-muted float-right"><?php echo fecha($d->v->creado); ?></small>
          <h6><?php echo 'Compra #'.$d->v->folio; ?></h6>
          <br>

          <h6>Total de la compra</h6>
          <table class="table table-borderless table-hover table-sm">
            <tbody>
              <tr>
                <th>Estado de la compra</th>
                <td class="align-middle text-right"><?php echo get_venta_status_boton($d->v->status); ?></td>
              </tr>
              <tr>
                <th>Estado del pago</th>
                <td class="align-middle text-right">
                  <?php echo get_payment_status($d->v->pago_status) ?>
                  <img class="img-fluid" src="<?php echo get_payment_image($d->v->pago_status) ?>"
                  alt="<?php echo get_payment_status($d->v->pago_status) ?>"
                  style="width: 20px;">
                </td>
              </tr>
              <?php if ($d->v->collection_id !== 'null' && !empty($d->v->collection_id)): ?>
              <tr>
                <th>Número de pago</th>
                <td class="align-middle text-right"><?php echo $d->v->collection_id; ?></td>
              </tr>
              <?php endif; ?>
              <tr>
                <th>Método de pago</th>
                <td class="align-middle text-right">
                  <?php echo get_payment_method_status($d->v->metodo_pago) ?>
                  <img class="img-fluid" src="<?php echo get_payment_method_image($d->v->metodo_pago) ?>"
                  alt="<?php echo get_payment_method_status($d->v->metodo_pago) ?>"
                  style="width: 20px;">
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

    <!-- Productos -->
		<div class="col-xl-8 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Productos</h5>

          <h6>Productos en la compra</h6>
          <?php if (isset($d->v->items) && !empty($d->v->items)): ?>
          <table class="table table-borderless table-hover" id="data-table">
            <thead>
              <th>Producto</th>
              <th>P. unitario</th>
              <th class="text-center">Cantidad</th>
              <th class="text-center">Total</th>
              <th class="text-right"></th>
            </thead>
            <tbody>
              <?php foreach ($d->v->items as $e): ?>
                <tr>
                  <td class="align-middle">
                    <?php echo $e->titulo; ?>
                    <small class="text-muted d-block"><?php echo get_single_shipment_address($e) ?></small>

                    <?php if (!empty($e->adjunto)): ?>
                      <?php if (is_file(UPLOADS.$e->adjunto)): ?>
                        <a class="btn btn-sm btn-info text-white mt-1" href="<?php echo buildURL('envios/print-label/'.$e->id,['label' => $e->adjunto,'nonce' => randomPassword(20,'numeric')]); ?>" tile="Descargar etiqueta"><i class="fa fa-download"></i><?php echo sprintf('%s etiqueta',($e->descargado ? 'Volver a descargar':'Descargar')); ?></a>
                      <?php else: ?>
                        <button class="btn btn-danger btn-sm" disabled><i class="fa fa-chain-broken"></i> Archivo dañado</button>
                      <?php endif; ?>
                    <?php endif; ?>
                  </td>
                  <td class="align-middle"><?php echo money($e->precio,'$') ?></td>
                  <td class="align-middle text-center">1</td>
                  <td class="align-middle text-center"><?php echo money((float) $e->precio * 1,'$') ?></td>
                  <td class="align-middle text-right ">
                    <?php if ((int) $e->con_sobrepeso === 1): ?>
											<a class="btn btn-danger text-white" <?php echo tooltip('Sobrepeso generado') ?> href="<?php echo 'envios/ver/'.$e->id ?>"><i class="fas fa-balance-scale "></i></a>
										<?php endif; ?>
                    <div class="btn-group" role="group">
                      <a class="btn btn-primary text-white" href="<?php echo 'envios/ver/'.$e->id ?>" target="_blank"><i class="fa fa-eye"></i></a>
                      <button class="btn btn-primary text-white do-track-shipment" data-id="<?php echo $e->id; ?>" <?php echo tooltip('Rastrear envío') ?>><i class="fas fa-map-marker-alt"></i></button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
          Ocurrió un error o no hay registros en esta compra.
          <?php endif; ?>
        </div>
			</div>
		</div>
	</div>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>