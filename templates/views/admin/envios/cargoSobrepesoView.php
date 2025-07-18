<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['admin','Administración'],['admin/envios-index','Envíos'],['',$d->title]]) ?>
	<?php flasher(); ?>
	
	<div class="row">
    <!-- Paquete y carrier -->
    <div class="col-xl-4">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">Información del paquete <img src="<?php echo IMG.'es-paquete.svg' ?>" alt="Paquete" style="width: 20px;"></h5>

          <div class="text-center">
            <img class="img-thumbnail img-fluid"
            src="<?php echo (is_file(UPLOADS.$d->e->imagenes)) ? URL.UPLOADS.$d->e->imagenes : URL.IMG.'no-carrier.jpg'; ?>"
            alt="<?php echo $d->e->titulo; ?>" style="width: 150px; border-radius: 50%;">
            <h5 class="card-title mt-3"><?php echo $d->e->titulo; ?></h5>
            <?php if (!empty($d->e->num_guia)): ?>
              <a href="<?php echo get_tracking_link($d->e->slug, $d->e->num_guia); ?>" target="_blank"><?php echo $d->e->num_guia; ?></a>
            <?php else: ?>
              <span class="text-muted">Número de rastreo no asignado aún</span>
            <?php endif; ?>
          </div>
          <br>
          
          <div class="text-center">
            <h6>Estado del envío</h6>
            <?php if ($d->e->status == 'Delivered' && !empty($d->e->entregado)): ?>
              <small class="text-muted d-block"><?php echo 'Entregado el '.fecha($d->e->entregado); ?></small>
              <small class="text-muted"><?php echo 'Firmado por <b>'.$d->e->firmado_por.'</b>'; ?></small>
            <?php endif; ?>
              <p class="text-muted mt-2">
                <img src="<?php echo get_tracking_image($d->e->status); ?>" class="img-fluid mr-2" alt="<?php echo get_tracking_status($d->e->status); ?>" <?php echo tooltip(get_tracking_status($d->e->status)) ?> style="width: 40px;">
                <?php echo get_tracking_status($d->e->status); ?>
              </p>
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
              <?php if (!empty($d->e->peso_real)): ?>
                <tr>
                  <td>Peso real <i class="fas fa-exclamation-circle text-info" <?php echo tooltip('Es el peso declarado por la paquetería al ser procesado') ?>></i></td>
                  <td><b><?php echo $d->e->peso_real.' kg' ?></b></td>
                </tr>
              <?php endif; ?>
              <tr>
                <td>Peso amparado <i class="fas fa-exclamation-circle text-info" <?php echo tooltip('Es el peso soportado por la guía adquirida') ?>></i></td>
                <td class="text-primary"><b><?php echo $d->e->capacidad.' kg' ?></b></td>
              </tr>
              <?php if ((int) $d->e->con_sobrepeso === 1): ?>
                <tr>
                  <td class="text-danger">Sobrepeso generado</td>
                  <td class="text-danger"><b><?php echo (abs($d->e->peso_real - $d->e->capacidad)).' kg' ?></b></td>
                </tr>
              <?php endif; ?>
              <tr>
                <td>Referencia de compra</td>
                <td>
                  <b><?php echo get_envio_referencia($d->e); ?></b>
                </td>
              </tr>
              <tr>
                <td>Etiqueta solicitada</td>
                <td>
                  <b><?php echo ((int) $d->e->solicitado === 1 ? 'Ya solicitada' : 'No solicitada aún') ?></b>
                </td>
              </tr>
              <tr>
                <td>Etiqueta de envío</td>
                <td>
                  <b><?php echo (!empty($d->e->adjunto) ? (is_file(UPLOADS.$d->e->adjunto) ? 'Archivo listo para imprimir <a href="'.buildURL('admin/envios-print-label/'.$d->e->id,['label' => $d->e->adjunto,'nonce' => randomPassword(20,'numeric')]).'"><i class="fa fa-print"></i></a>' : 'Archivo dañado o no existente') : 'No disponible aún'); ?></b>
                </td>
              </tr>
              <tr>
                <td>Etiqueta descargada</td>
                <td>
                  <b><?php echo (intval($d->e->descargado) === 1 ? '<i class="fa fa-check text-success"></i> Ya descargada' : '<i class="fa fa-times text-danger"></i> No ha sido descargada' ); ?></b>
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
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>

          <h6>Datos de la transacción</h6>
          <form action="admin/post_sobrepeso" method="POST">
            <?php echo insert_inputs(); ?>
            <input type="hidden" name="id" value="<?php echo $d->e->id; ?>">

            <div class="form-group row">
              <div class="<?php echo bs_col([4,4,6,12,12]) ?>">
                <label for="importe">Importe a cobrar <?php echo bs_required(); ?> <?php echo more_info('Es el monto neto del cargo a cobrar al usuario'); ?></label>
                <input type="text" class="form-control money" name="importe" placeholder="0.00" required>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn_requires_confirmation">Crear cargo</button>
            <button type="reset" class="btn btn-default">Cancelar</button>
          </form>
        </div>
			</div>
		</div>
	</div>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>