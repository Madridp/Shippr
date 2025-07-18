<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['',$d->title]]); ?>

  <!-- Formulario -->
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

          <img src="<?php echo URL.IMG.'vital-army.jpg' ?>" alt="Contáctanos" class="img-fluid" style="width: 100%;">
          <h1><?php echo $d->title; ?></h1>
          <p>Si tienes algún problema, duda o sugerencia, no dudes en ponerte en contacto con nosotros, estamos para apoyarte, te responderemos en un lapso no mayor a 24 horas hábiles.</p>
          <?php flasher() ?>
          <form action="informacion/contacto-submit" method="POST">
            <div class="form-group row"> 
              <div class="col-xl-4">
                <small class="d-block">Nombre completo <span class="text-danger">*</span></small>
                <input type="text" class="form-control" name="nombre" placeholder="John Doe" required>
              </div>
              <div class="col-xl-4">
                <small class="d-block">E-mail <span class="text-danger">*</span></small>
                <input type="email" class="form-control" name="email" placeholder="johndoe@empresa.com" required>
              </div>
              <div class="col-xl-4">
                <small class="d-block">Teléfono</small>
                <input type="text" class="form-control" name="telefono" placeholder="+52 55 2456 8754">
              </div>
            </div>
            <div class="form-group">
              <small class="d-block">Tu mensaje <span class="text-danger">*</span></small>
              <textarea name="mensaje" class="form-control" cols="30" rows="10" placeholder="Escribe un mensaje aquí..." required></textarea>
            </div>

            <?php echo insert_inputs(); ?>

            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="reset" class="btn btn-default">Cancelar</button>
          </form>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>