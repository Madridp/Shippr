<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['informacion','Información'],['',$d->title]]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            <?php echo $d->title; ?>
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <h1><?php echo $d->title; ?></h1>
          <p class="text-muted"><?php echo 'Última actualización '.fecha('2018-11-22'); ?></p>
          <?php if ($d->productos): ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover vmiddle" id="data-table">
              <thead class="thead-dark">
                <tr>
                  <th class="text-center">Courier</th>
                  <th>Tipo de servicio</th>
                  <th class="text-center">Capacidad</th>
                  <th class="text-center">Tiempo de entrega</th>
                  <th class="text-center">Costo regular</th>
                  <th class="text-center">Costo socios <i class="fas fa-exclamation-circle text-info" <?php echo tooltip('Contáctanos para saber más') ?>></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($d->productos as $p): ?>
                <tr>
                  <td class="text-center">
                    <img class="img-thumbnail" src="<?php echo URL.UPLOADS.$p->imagenes; ?>" alt="<?php echo $p->titulo; ?>" style="width: 50px; border-radius: 50%;">
                  </td>
                  <td><?php echo $p->titulo.' '.$p->tipo_servicio; ?></td>
                  <td class="text-center"><?php echo $p->capacidad.' kg'; ?></td>
                  <td class="text-center"><?php echo $p->tiempo_entrega; ?></td>
                  <td class="text-center"><?php echo money($p->precio); ?></td>
                  <td class="text-center">
                    <?php echo money($p->precio_descuento); ?>
                    <span class="d-block"><?php echo get_rating(rand(3,5)); ?></span>
                  </td>
                </tr>                
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          
          <?php else: ?>
          <div class="text-center py-4">
            <img src="<?php echo IMG.'shame-face.png' ?>" alt="Sin resultados" style="width: 150px;">
            <br><br>
            <p>No tenemos opciones de envío disponibles en estos momentos</p>
            <a href="dashboard" class="btn btn-warning btn-lg mt-3">Regresar</a>
          </div>
          <?php endif; ?>
        </div>
      </div>

      <!-- Formulario de consulta extra -->
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            ¿No encuentras respuesta a lo que buscas?
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <h3>Completa el formulario</h3>
          <p>Déjanos tu pregunta o comentario para poder ayudarte lo más pronto posible</p>
          <form id="inf_consulting_form">
            <div class="form-group">
              <small class="d-block">¿Cuál es tu dirección de correo electrónico?</small>
              <input type="email" class="form-control" name="inf_email" value="<?php echo get_user_email() ?>">
            </div>
            <div class="form-group">
              <small class="d-block">¿Cuál es tu duda?</small>
              <input type="hidden" class="form-control" name="inf_asunto" value="Nueva consulta recibida" required>
              <input type="text" class="form-control" name="inf_pregunta" required>
            </div>
            <div class="form-group">
              <small class="d-block">¿Nos cuentas más por favor?</small>
              <textarea name="inf_contenido" cols="30" rows="5" class="form-control" required></textarea>
            </div>
            <button class="btn btn-success" type="submit">Enviar pregunta</button>
          </form>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>