<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['admin', 'Administración'],['admin/ventas-index','Ventas'],['','Venta #'.$d->v->folio]]) ?>
	<?php flasher(); ?>
	
	<div class="row">
    <!-- Paquete y carrier -->
    <div class="col-xl-4">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Información de la venta</h5>

          <small class="text-muted float-right"><?php echo fecha($d->v->creado); ?></small>
          <h6><?php echo 'Venta #'.$d->v->folio; ?></h6>
          <br>

          <h6>Total de la compra</h6>
          <table class="table table-borderless table-hover table-sm">
            <tbody>
              <tr>
                <th>Usuario</th>
                <td class="align-middle text-right"><?php echo $d->v->nombre; ?></td>
              </tr>
              <tr>
                <th>Correo electrónico</th>
                <td class="align-middle text-right"><a href="<?php echo mailto($d->v->email, sprintf('Compra folio %s', $d->v->folio)); ?>"><?php echo $d->v->email; ?></a></td>
              </tr>
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
          <a href="<?php echo 'admin/ventas-actualizar/'.$d->v->folio; ?>" class="btn btn-primary">Editar</a>
        </div>
      </div>
    </div>

    <!-- Productos -->
		<div class="col-xl-8 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Productos</h5>

          <h6>Productos en la venta</h6>
          <?php if (isset($d->v->items) && !empty($d->v->items)): ?>
          <table class="table table-borderless table-hover" id="data-table">
            <thead>
              <th>Producto</th>
              <th class="align-middle text-center">P. unitario</th>
              <th class="align-middle text-center">Cantidad</th>
              <th class="align-middle text-center">Total</th>
              <th class="align-middle text-right"></th>
            </thead>
            <tbody>
              <?php foreach ($d->v->items as $e): ?>
                <tr>
                  <td class="align-middle">
                    <?php echo $e->titulo; ?>
                    <small class="text-muted d-block"><?php echo 'Capacidad de '.$e->capacidad.' kg'; ?></small>
                    <small class="text-muted d-block"><?php echo get_single_shipment_address($e) ?></small>
                  </td>
                  <td class="align-middle text-center"><?php echo money($e->precio,'$') ?></td>
                  <td class="align-middle text-center">1</td>
                  <td class="align-middle text-center"><?php echo money((float) $e->precio * 1,'$') ?></td>
                  <td class="align-middle text-right">
                    <?php if ((int) $e->con_sobrepeso === 1): ?>
											<a class="btn btn-sm btn-danger text-white" <?php echo tooltip('Sobrepeso generado') ?> href="<?php echo 'admin/envios-ver/'.$e->id ?>"><i class="fas fa-balance-scale "></i></a>
										<?php endif; ?>
                    <div class="btn-group dropleft" role="group">
                      <?php if (intval($e->solicitado) === 1): ?>
                        <button class="btn btn-success btn-sm" <?php echo tooltip('Etiqueta solicitada') ?>><i class="fa fa-vcard"></i></button>
                      <?php endif; ?>
                      <?php if (is_file(UPLOADS.$e->adjunto)): ?>
                        <button class="btn btn-success btn-sm" <?php echo tooltip('Etiqueta lista') ?>><i class="fa fa-check"></i></button>
                      <?php endif; ?>
                      <?php if (intval($e->descargado) === 1): ?>
                        <button class="btn btn-success btn-sm" <?php echo tooltip('Etiqueta descargada por usuario') ?>><i class="fa fa-download"></i></button>
                      <?php endif; ?>
                      <a class="btn btn-sm  btn-primary text-white" href="<?php echo 'admin/envios-ver/'.$e->id ?>"><i class="fa fa-eye"></i></a>
                      <button id="<?php echo 'r'.$e->id ?>" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r'.$e->id ?>">
                        <a class="dropdown-item" href="<?php echo 'admin/envios-actualizar/'.$e->id ?>"><i class="fa fa-edit"></i> Editar</a>
                        <small class="dropdown-header">Documento</small>
                        <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/envios-solicitar-generacion/'.$e->id) ?>"><i class="fa fa-envelope"></i> Solicitar generación</a>
                        <small class="dropdown-header">Estado de envío</small>
                        <a class="dropdown-item confirmacion-requerida" 
                        href="<?php echo buildURL('admin/envios-cambiar-status/'.$e->id,['status' => 'recolectado']); ?>"><i class="fa fa-archive"></i> Recolectado</a>
                        <a class="dropdown-item confirmacion-requerida" 
                        href="<?php echo buildURL('admin/envios-cambiar-status/'.$e->id,['status' => 'en-camino']); ?>"><i class="fa fa-truck"></i> En camino</a>
                        <a class="dropdown-item confirmacion-requerida" 
                        href="<?php echo buildURL('admin/envios-cambiar-status/'.$e->id,['status' => 'entregado']); ?>"><i class="fa fa-check"></i> Entregado</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/envios-borrar/'.$e->id,['nonce' => randomPassword()]); ?>"><i class="fa fa-trash"></i> Borrar</a>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
          Ocurrió un error o no hay registros en esta venta.
          <?php endif; ?>
        </div>
			</div>
		</div>
	</div>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>