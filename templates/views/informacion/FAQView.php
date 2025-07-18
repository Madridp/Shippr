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
          <h5 class="pvr-header"><?php echo $d->title; ?></h5>
          <h3><?php echo $d->title; ?></h3>
          <?php echo get_site_faq(); ?>
          <small class="text-muted mt-5 d-block"><?php echo sprintf('Última actualización: %s', get_faq_date()); ?></small>
        </div>
      </div>

      <!-- Formulario de consulta extra -->
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">¿No encuentras respuesta a lo que buscas?</h5>

          <h3>Completa el formulario</h3>
          <p>Déjanos tu pregunta o comentario para poder ayudarte lo más pronto posible</p>
          <form id="inf_consulting_form">
            <?php echo insert_inputs(); ?>
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