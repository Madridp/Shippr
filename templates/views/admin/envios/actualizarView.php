<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['admin/envios-index','Envíos'],['admin/envios-ver/'.$d->e->id,'Ver'],['',$d->title]]) ?>
	<?php flasher(); ?>
	
	<div class="row">
    <!-- Paquete y carrier -->
    <div class="col-xl-4">
      <div class="row">
        <div class="col-xl-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <h5 class="pvr-header">Información del paquete <img src="<?php echo URL.IMG.'es-paquete.svg' ?>" alt="Paquete" style="width: 20px;"></h5>

              <h6>Datos del envío</h6>
              <form action="admin/envios-update" method="POST">
                <?php echo insert_inputs(); ?>
                <input type="hidden" name="id" value="<?php echo $d->e->id; ?>">

                <div class="form-group">
                  <label>Courier</label>
                  <p class="m-0"><b><?php echo not_empty($d->e->titulo); ?></b></p>
                </div>

                <!--  
                <div class="form-group">
                  <label for="tracking_id">ID de rastreo Aftership <?php echo more_info('Es el ID del envío registrado en www.aftership.com, utilizado para mantener actualizado el estado de forma automática'); ?></label>
                  <input type="text" class="form-control form-control-sm" name="tracking_id" value="<?php echo $d->e->tracking_id; ?>">
                  <small class="text-muted">Para saber como obtener el id de rastreo de Aftership ve a <a href="direccion/aftership">aquí</a>, este valor será actualizado de forma automática por nosotros.</small>
                </div>-->

                <div class="form-group">
                  <label for="num_guia">Número de rastreo asignado</label>
                  <p class="m-0"><b><?php echo not_empty($d->e->num_guia); ?></b></p>
                </div>

                <div class="form-group">
                  <label for="status">Estado del envío <?php echo bs_required(); ?></label>
                  <select name="status" class="form-control" required>
                    <?php foreach (get_shipment_statuses() as $s): ?>
                      <?php if ($s === $d->e->status): ?>
                        <option value="<?php echo $s ?>" selected><?php echo get_tracking_status($d->e->status)?></option>
                      <?php else: ?>
                        <option value="<?php echo $s ?>"><?php echo get_tracking_status($s)?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
                <br>

                <h6>Datos del paquete</h6>
                <div class="form-group">
                  <label for="descripcion">Descripción <?php echo bs_required(); ?> <?php echo more_info('Es el contenido del paquete') ?></label>
                  <input type="text" class="form-control form-control-sm" name="descripcion" value="<?php echo $d->e->descripcion; ?>" required>
                </div>
                <div class="form-group">
                  <label for="paq_alto">Altura <?php echo bs_required(); ?></label>
                  <input type="text" class="form-control form-control-sm money" name="paq_alto" value="<?php echo $d->e->paq_alto; ?>" required>
                </div>
                <div class="form-group">
                <label for="paq_ancho">Ancho <?php echo bs_required(); ?></label>
                  <input type="text" class="form-control form-control-sm money" name="paq_ancho" value="<?php echo $d->e->paq_ancho; ?>" required>
                </div>
                <div class="form-group">
                  <label for="paq_largo">Largo <?php echo bs_required(); ?></label>
                  <input type="text" class="form-control form-control-sm money" name="paq_largo" value="<?php echo $d->e->paq_largo; ?>" required>
                </div>
                <div class="form-group">
                  <label for="peso_neto">Peso neto <?php echo bs_required(); ?> <?php echo more_info('Peso neto en kilogramos del paquete') ?></label>
                  <input type="text" class="form-control form-control-sm money" name="peso_neto" value="<?php echo $d->e->peso_neto; ?>" required>
                </div>
                <div class="form-group">
                  <label for="peso_vol">Peso volumétrico <?php echo bs_required(); ?> <?php echo more_info('Peso obtenido al multiplicar todos los lados y dividir el resultado entre 5000') ?></label>
                  <p><?php echo $d->e->peso_vol; ?></p>
                </div>
                <div class="form-group">
                  <label for="peso_real">Peso real <?php echo bs_required(); ?> <?php echo more_info('Es el peso registrado por la paquetería al ser procesado') ?></label>
                  <input type="text" class="form-control form-control-sm money" name="peso_real" value="<?php echo $d->e->peso_real; ?>" required>
                </div>
                <div class="form-group">
                  <label for="peso_vol">Tiene sobrepeso <?php echo bs_required(); ?> <?php echo more_info('La paquetería notificará si un paquete tiene más peso del amparado por la guía') ?></label>
                  <?php if ((int) $d->e->con_sobrepeso === 1): ?>
                    <p class="text-danger">El paquete tiene sobrepeso</p>
                  <?php else: ?>
                    <p>Sin sobrepeso</p>
                  <?php endif; ?>
                </div>
                
                <button type="submit" class="btn btn-success">Guardar cambios</button>
                <button type="reset" class="btn btn-light">Cancelar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      <div class="row">
        <!-- Documento de rastreo -->
        <div class="col-xl-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <h5 class="pvr-header">Documento de rastreo o guía</h5>

              <?php if (is_file(UPLOADS.$d->e->adjunto)): ?>
                <h6>Documento de rastreo actual</h6>
                <a class="btn btn-success mb-3" href="<?php echo buildURL('admin/envios-print-label/'.$d->e->id,['label' => $d->e->adjunto,'nonce' => randomPassword(20,'numeric')]); ?>"><i class="fa fa-download" title="<?php echo $d->e->adjunto; ?>"></i> Descargar</a>
              <?php endif; ?>

              <form action="admin/envios-adjuntar-guia-process" method="POST" enctype="multipart/form-data">
                <?php echo insert_inputs(); ?>
                <input type="hidden" name="id" value="<?php echo $d->e->id; ?>">

                <div class="form-group">
                  <label for="num_guia">Número de rastreo asignado <?php echo bs_required(); ?></label>
                  <input type="text" class="form-control" name="num_guia" placeholder="785615614538" value="<?php echo $d->e->num_guia; ?>" required>
                </div>

                <div class="form-group text-truncate">
                  <label for="adjunto">Archivo <b>pdf</b> o documento de rastreo <?php echo bs_required(); ?></label>
                  <input type="file" class="form-control" name="adjunto[]" accept="application/pdf, image/*" required>
                </div>

                <button type="submit" class="btn btn-success btn_requires_confirmation">Guardar archivo</button>
                <button type="reset" class="btn btn-light">Cancelar</button>
              </form>
            </div>
          </div>
        </div>

        <!-- Notificaciones -->
        <div class="col-xl-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <h5 class="pvr-header">Enviar notificación</h5>

              <form action="admin/envios-enviar-notificacion" method="POST">
                <?php echo insert_inputs(); ?>

                <input type="hidden" name="id" value="<?php echo $d->e->id; ?>">
                <div class="form-group text-truncate">
                  <label for="tipo_notificacion">Envía una notificación al usuario <?php echo bs_required(); ?></label>
                  <select name="tipo_notificacion" id="" class="form-control form-control-sm" required>
                    <option value="none">Selecciona una opción</option>
                    <?php if (is_file(UPLOADS.$d->e->adjunto)): ?>
                      <option value="label-ready">Guía de envío lista</option>
                    <?php endif; ?>
                    <option value="new-order">Resumen de compra</option>
                    <option value="payment-pending">Pago pendiente</option>
                    <option value="payment-approved">Pago aprobado</option>
                    <option value="payment-canceled">Pago cancelado</option>
                    <option value="payment-rejected">Pago rechazado</option>
                    <option value="payment-refunded">Pago devuelto</option>
                  </select>
                </div>

                <button type="submit" class="btn btn-success">Enviar</button>
                <button type="reset" class="btn btn-light">Cancelar</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      <!-- Información de guía -->
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Remitente <small><i class="fa fa-arrow-right"></i></small> Destinatario</h5>

          <h6>Remitente <img src="<?php echo IMG.'es-remitente.svg' ?>" alt="Remitente" style="width: 20px;"></h6>
          <table class="table table-borderless table-sm">
            <tbody>
              <tr>
                <td>Nombre</td>
                <td><?php echo $d->r->nombre ?></td>
              </tr>
              <tr>
                <td>E-mail</td>
                <td><?php echo $d->r->email ?></td>
              </tr>
              <tr>
                <td>Teléfono</td>
                <td><?php echo $d->r->telefono ?></td>
              </tr>
              <tr>
                <td>Empresa</td>
                <td><?php echo $d->r->empresa ?></td>
              </tr>
              <tr>
                <td>Dirección</td>
                <td><?php echo build_address($d->r); ?></td>
              </tr>
              <tr>
                <td>Referencias</td>
                <td><?php echo $d->r->referencias ?></td>
              </tr>
            </tbody>
          </table>

          <h6>Destinatario <img src="<?php echo IMG.'es-destinatario.svg' ?>" alt="Destinatario" style="width: 20px;"></h6>
          <table class="table table-borderless table-sm">
            <tbody>
              <tr>
                <td>Nombre</td>
                <td><?php echo $d->d->nombre ?></td>
              </tr>
              <tr>
                <td>E-mail</td>
                <td><?php echo $d->d->email ?></td>
              </tr>
              <tr>
                <td>Teléfono</td>
                <td><?php echo $d->d->telefono ?></td>
              </tr>
              <tr>
                <td>Empresa</td>
                <td><?php echo $d->d->empresa ?></td>
              </tr>
              <tr>
                <td>Dirección</td>
                <td><?php echo build_address($d->d); ?></td>
              </tr>
              <tr>
                <td>Referencias</td>
                <td><?php echo $d->d->referencias ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
	</div>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>