<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <div class="row">
    <div class="col">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="direccion">Dirección General</a></li>
        <li class="breadcrumb-item active" aria-current="page">Correos</li>
        </ol>
      </nav>
    </div>
  </div>
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

          <form action="direccion/correos_store" method="POST" class="form-horizontal" id="direccion-correos">
            <input type="hidden" name="redirect_to" value="<?php echo CUR_PAGE ?>">
            <h6>Configuración de correos</h6>
            <p>Requerimos autenticar la cuenta principal para poder hacer envío de correos compuestos y dinámicos desde el servidor de la plataforma.</p>
            <br>

            <div class="form-group">
              <label for="site_smtp_host">Nombre del host <span class="text-danger">*</span></label>
              <input class="form-control" name="site_smtp_host" id="site_smtp_host" type="text" value="<?php echo get_smtp_host() ?>" required>
            </div>

            <div class="form-group">
              <label for="site_smtp_port">Puerto del host <span class="text-danger">*</span></label>
              <input class="form-control" name="site_smtp_port" id="site_smtp_port" type="text" value="<?php echo get_smtp_port() ?>"  required>
            </div>

            <div class="form-group">
              <label for="site_smtp_email">Correo electrónico principal<span class="text-danger">*</span></label>
              <input class="form-control" name="site_smtp_email" id="site_smtp_email" type="email" value="<?php echo get_smtp_email() ?>" required>
              <small class="text-muted">Este será el correo electrónico por defecto de la plataforma.</small>
            </div>

            <div class="form-group">
              <label for="site_smtp_password">Contraseña <span class="text-danger">*</span></label>
              <input class="form-control" name="site_smtp_password" id="site_smtp_password" type="password" value="<?php echo get_smtp_password() ?>" required>
              <small class="text-muted">Solo el administrador o Director General tendrá acceso a esta información.</small>
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-sm btn-primary smtp-test-connection">Probar conexión</button>
              <small class="text-muted d-block">Puede tomar unos minutos.</small>
            </div>

            <br>
            <h6>Correos para notificaciones</h6>
            <p>Correos dedicados a recibir notificaciones de nuevos reportes, anticipos, 
            correos de contabilidad e información de contacto.</p>
            <small class="text-muted d-block mb-2">En caso de no definir uno de los siguientes correos, se utilizará la dirección de correo principal definida anteriormente.</small>
            <br>

            <div class="form-group">
              <label for="email_address_for_reportes">Reportes</label>
              <input class="form-control" name="email_address_for_reportes" id="email_address_for_reportes" type="text" value="<?php echo get_email_address_for('reportes'); ?>">
            </div>

            <div class="form-group">
              <label for="email_address_for_anticipos">Anticipos</label>
              <input class="form-control" name="email_address_for_anticipos" id="email_address_for_anticipos" type="text" value="<?php echo get_email_address_for('anticipos'); ?>">
            </div>

            <div class="form-group">
              <label for="email_address_for_contabilidad">Contabilidad</label>
              <input class="form-control" name="email_address_for_contabilidad" id="email_address_for_contabilidad" type="text" value="<?php echo get_email_address_for('contabilidad'); ?>">
            </div>

            <div class="form-group">
              <label for="email_address_for_contacto">Contacto</label>
              <input class="form-control" name="email_address_for_contacto" id="email_address_for_contacto" type="text" value="<?php echo get_email_address_for('contacto'); ?>">
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