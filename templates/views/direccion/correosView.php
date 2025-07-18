<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['direccion','Dirección General'],['',$d->title]]); ?>
  <?php flasher() ?>
  
  <div class="row">
    <div class="col-xl-3"></div>
    <div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Completa el formulario
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <form action="direccion/correos_store" method="POST">
            <?php echo insert_inputs(); ?>
            <h6>Configuración de correos</h6>
            <p>Requerimos autenticar la cuenta principal para poder hacer envío de correos compuestos y dinámicos desde el servidor de <?php echo get_system_name() ?>.</p>
            <div class="form-group">
              <label for="site_smtp_email">Correo principal</label>
              <input class="form-control" name="site_smtp_email" id="site_smtp_email" type="email" value="<?php echo get_smtp_email(); ?>">
            </div>
            <br>

            <h6>Título en correos electrónicos</h6>
            <p>Configura como aparecerá el título de los correos electrónicos enviados desde la plataforma.</p>
            <div class="form-group">
              <label for="email_sitename">Título</label>
              <input class="form-control" name="email_sitename" id="email_sitename" type="text" value="<?php echo get_email_sitename(); ?>">
            </div>
            <div class="wrapper_email_sitename mb-3">
              <small class="text-muted d-block">Previsualización</small>
              <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                  <div class="bg-light f-s-12 p-2 text-center text-truncate" style="border-bottom: 1px solid #ebebeb; border-top: 1px solid #A5A5A5; border-right: 1px solid #A5A5A5; border-left: 1px solid #A5A5A5; border-radius: 3px 3px 0px 0px;">
                    <span class="title"><?php echo get_email_sitename(); ?></span><?php echo ' Nueva guía generada en '.get_system_name() ?>
                    <span class="title_default d-none"><?php echo get_email_sitename(); ?></span>
                  </div>
                </div>
              </div>
            </div>
            <br>

            <input type="submit" class="btn btn-success" value="Guardar cambios" name="submit">
            <input type="reset" class="btn btn-default" value="Cancelar" name="cancel">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>