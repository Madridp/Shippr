<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['direccion','Dirección'],['',$d->title]]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header"><?php echo $d->title; ?></h5>
          <h3>¿Qué es Aftership?</h3>
          <p><b>Aftership</b> es una plataforma independiente diseñada para mantener al día el estado actual de todos tus envíos, tiene soporte para más de <b>591 couriers</b> a nivel mundial, incluyendo <b>Estafeta, Redpack, DHL, FedEx, UPS, Paquetexpress</b> y muchos más.</p>
          <p>El servicio es <b>100%</b> gratuito para <b>100 envíos</b> mensuales, a partir del envío 101 te será cobrado un monto de <i>$0.5 USD</i> por envío adicional, pero puedes encontrar planes con excelente precios y beneficios de hasta 50,000 envíos al mes, recomendamos la implementación para mantener a tus clientes al día con sus envíos de forma automática.</p>
          <img src="<?php echo URL.IMG.'aftership01.png'; ?>" alt="Aftership 1" class="img-fluid img-thumbnail">
          <h3>¿Cómo uso Aftership con <?php echo get_system_name(); ?>?</h3>
          <p>Para usar el servicio es muy fácil, sólo debes <a href="https://accounts.aftership.com/register" target="_blank">registrarte</a> en Aftership e <a href="https://accounts.aftership.com/login" target="_blank">iniciar sesión</a>, después deberás generar una API Key <?php echo more_info(sprintf('Una clave secreta utilizada para conectar %s con %s y hacer uso de sus servicios', get_system_name(), 'Aftership')) ?> <a href="https://admin.aftership.com/settings/api-keys" target="_blank">aquí</a>, una vez lista, copía tu clave y pégala en el capo de abajo, guarda los cambios y nosotros nos encargamos desde ahí.</p>
          <p>Es importante que no borres <?php echo more_info(sprintf('Si es borrada, deberás generar otra API Key y actualizarla también en %s', get_system_name())); ?> o compartas esta clave con alguien más, ya que podrá controlar el estado de los rastreos de Aftership.</p>
          <form action="direccion/save_aftership_key" method="POST">
            <?php echo insert_inputs(); ?>
            <div class="form-group">
              <label for="aftership_api_key">API Key</label>
              <input type="text" class="form-control" name="aftership_api_key" id="aftership_api_key" placeholder="asd123-12314-bocAECmaose-28318209" value="<?php echo get_option('aftership_api_key') ?>" required>
            </div>
            <button class="btn btn-success" type="submit">Guardar API Key</button>
          </form>
          <img src="<?php echo URL.IMG.'aftership02.png'; ?>" alt="Aftership" class="img-fluid img-thumbnail mt-3">
          <img src="<?php echo URL.IMG.'aftership03.png'; ?>" alt="Aftership" class="img-fluid img-thumbnail mt-3">
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