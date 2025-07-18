<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['envios','Envíos'],['envios/ver/'.$d->e->id,'Ver'],['','Actualizando envío']]) ?>
	<?php flasher(); ?>
	
  <div class="row">
    <!-- Paquete y carrier -->
    <div class="col-xl-4">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Información del paquete <img src="<?php echo IMG.'es-paquete.svg' ?>" alt="Paquete" style="width: 20px;"></h5>

          <div class="text-center">
            <img class="img-thumbnail img-fluid"
            src="<?php echo (is_file(UPLOADS.explode('|',$d->e->imagenes)[0]) ? URL.UPLOADS.(explode('|',$d->e->imagenes)[0]) : URL.IMG.'no-carrier.jpg'); ?>"
            alt="<?php echo $d->e->titulo; ?>" style="width: 150px; border-radius: 50%;">
            <h5 class="card-title mt-3"><?php echo (!empty($d->e->titulo) ? $d->e->titulo.' '.$d->e->tipo_servicio.' ('.$d->e->tiempo_entrega.')' : 'Desconocido'); ?></h5>
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
            </tbody>
          </table>

          <h6>Referencia de compra</h6>
          <form action="envios/post_actualizar" method="post">
            <?php echo insert_inputs(); ?>
            <input type="hidden" class="form-control" name="id" value="<?php echo $d->e->id; ?>">

            <div class="form-group">
              <input type="text" class="form-control" name="referencia" placeholder="5185AS4S" value="<?php echo $d->e->referencia; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
            <button type="reset" class="btn btn-default">Cancelar</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Información de guía -->
    <div class="col-xl-8 col-12">
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