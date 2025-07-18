<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['admin','Administración'],['admin/envios-index','Envíos'],['','Viendo envío']]) ?>

	<?php flasher(); ?>
	
	<div class="row">
    <!-- Paquete y carrier -->
    <div class="col-xl-4">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Información del paquete <img src="<?php echo IMG.'es-paquete.svg' ?>" alt="Paquete" style="width: 20px;">
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <div class="text-center">
            <img class="img-thumbnail img-fluid"
            src="<?php echo (is_file(UPLOADS.explode('|',$d->e->imagenes)[0]) ? URL.UPLOADS.(explode('|',$d->e->imagenes)[0]) : URL.IMG.'no-carrier.jpg'); ?>"
            alt="<?php echo $d->e->titulo; ?>" style="width: 150px; border-radius: 50%;">
            <h5 class="card-title mt-3"><?php echo 'Carrier '.(!empty($d->e->titulo) ? $d->e->titulo.' de '.$d->e->capacidad.' kg' : 'desconocido'); ?></h5>
            <?php if (!empty($d->e->num_guia)): ?>
              <a href="<?php echo get_tracking_link($d->e->slug, $d->e->num_guia); ?>" target="_blank"><?php echo $d->e->num_guia; ?></a>
            <?php else: ?>
              <span class="text-muted">No asignado aún</span>
            <?php endif; ?>
            <a href="<?php echo buildURL('envios/actualizar/'.$d->e->id); ?>" class="text-primary" <?php echo tooltip('Editar número de rastreo') ?>><i class="fa fa-edit" ></i></a>
          </div>
          <br>
          
          <h6>Estado del envío</h6>
          <?php if ($d->e->status == 'entregado' && !empty($d->e->entregado)): ?>
            <small class="text-muted"><?php echo 'Entregado el '.fecha($d->e->entregado); ?></small>
          <?php endif; ?>
          <div class="text-center">
            <img src="<?php echo get_tracking_image($d->e->status); ?>" class="img-fluid" alt="<?php echo get_tracking_status($d->e->status); ?>" <?php echo tooltip(get_tracking_status($d->e->status)) ?>>
            <?php echo get_tracking_status($d->e->status); ?>
            <a href="<?php echo buildURL('envios/actualizar/'.$d->e->id); ?>" class="text-primary" <?php echo tooltip('Editar estado de envío') ?>><i class="fa fa-edit" ></i></a>
          </div>
          <br>

          <h6>Datos del paquete</h6>
          <table class="table table-borderless table-sm">
            <tbody>
              <tr>
                <td widtd="40%">Descripción</td>
                <td><b><?php echo $d->e->descripcion ?></b></td>
              </tr>
              <tr>
                <td>Alto</td>
                <td><b><?php echo $d->e->paq_alto.' cm' ?></b></td>
              </tr>
              <tr>
                <td>Ancho</td>
                <td><b><?php echo $d->e->paq_ancho.' cm' ?></b></td>
              </tr>
              <tr>
                <td>Largo</td>
                <td><b><?php echo $d->e->paq_largo.' cm' ?></b></td>
              </tr>
              <tr>
                <td>Peso neto</td>
                <td><b><?php echo $d->e->peso_neto.' kg' ?></b></td>
              </tr>
              <tr>
                <td>Peso volumétrico</td>
                <td><b><?php echo $d->e->peso_vol ?></b></td>
              </tr>
              <tr>
                <td>Referencia de compra</td>
                <td>
                  <b><?php echo get_envio_referencia($d->e); ?></b>
                  <div class="float-right">
                    <a href="<?php echo buildURL('envios/actualizar/'.$d->e->id); ?>" class="text-primary" <?php echo tooltip('Editar referencia de compra') ?>><i class="fa fa-edit" ></i></a>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Formulario -->
		<div class="col-xl-8 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Adjuntar documento de rastreo
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

          <?php if (is_file(UPLOADS.$d->e->adjunto)): ?>
            <h6>Documento actual</h6>
            <a class="btn btn-primary btn-sm"
            href="<?php echo buildURL('admin/envios-print-label/'.$d->e->id,['label' => $d->e->adjunto,'nonce' => randomPassword(20,'numeric')]); ?>">
            <i class="fa fa-download mr-2"></i> Descargar</a>
            <small class="text-muted d-block m-b-25"><?php echo $d->e->adjunto; ?></small>
          <?php endif; ?>

          <h6>Documento adjunto</h6>
          <p>Selecciona un archivo <b>.pdf</b> o documento de rastreo.</p>
          <form action="admin/envios-adjuntar-guia-process" method="POST" enctype="multipart/form-data">
            <?php echo insert_inputs() ?>
            <input type="hidden" name="id" value="<?php echo $d->e->id; ?>">
            <div class="form-group text-truncate">
              <input type="file" class="form-control" name="adjunto[]" accept="application/pdf, image/*">
            </div>

            <button type="submit" class="btn btn-primary">Guardar archivo</button>
            <button type="reset" class="btn btn-default">Cancelar</button>
          </form>
        </div>
			</div>
		</div>
	</div>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>