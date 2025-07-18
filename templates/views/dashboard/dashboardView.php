<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content" id="app">
  <?php flasher() ?>

  <!-- Contador de envíos -->
  <div class="row">
    <div class="col-xl-4 col-sm-4 col-12 m-b-30">
      <div class="card card-shadow">
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <span class="bg-success text-center pvr-icon-box">
                <i class="icon-direction text-light f-s-24"></i>
              </span>
            </div>
            <div class="col-9">
              <h6 class="mt-1 mb-0">Envíos</h6>
              <p class="mb-0"><?php echo ($d->e_t->total == 0 ? 'No has realizado envíos aún' : $d->e_t->total.' envíos realizados') ?></p>
              <small><a href="envios">Mis envíos</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-sm-4 col-12 m-b-30">
      <div class="card card-shadow">
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <span class="bg-primary text-center pvr-icon-box">
                <i class="icon-credit-card text-light f-s-24"></i>
              </span>
            </div>
            <div class="col-9">
              <h6 class="mt-1 mb-0">Compras</h6>
              <p class="mb-0"><?php echo ($d->c_t->total == 0 ? 'No has realizado compras aún' : $d->c_t->total.' compras realizadas') ?></p>
              <small><a href="compras">Mis compras</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-sm-4 col-12 m-b-30">
      <div class="card card-shadow">
        <div class="card-body">
          <div class="row">
            <div class="col-3">
              <span class="bg-danger text-center pvr-icon-box">
                <i class="icon-control-forward text-light f-s-24"></i>
              </span>
            </div>
            <div class="col-9">
              <h6 class="mt-1 mb-0">Envíos en camino</h6>
              <p class="mb-0"><?php echo ($d->e_ec == 0 ? 'No hay envíos en camino' : ($d->e_ec == 1 ? $d->e_ec.' envío en camino' : $d->e_ec.' envíos en camino')) ?></p>
              <small><a href="envios">Ver envíos</a></small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Hello message -->
    <div class="col-xl-4 col-lg-4 col-12">
      <div class="row">
        <div class="col-xl-12 col-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <h3 class="element-inner-header m-t-0 text-theme"><?php echo greeting().' '.get_user_name(); ?></h3>
              <div class="element-inner-desc">
                Bienvenido, juntos vamos a cambiar la forma en que haces envíos, todo lo tendrás en un mismo lugar de forma sencilla y rápida, podrás hacer envíos en cuestión de segundos a toda la República Mexicana y al mejor costo posible.
              </div>
              <!-- <h4 class="f-w-500">¿Cómo realizar tus envíos?</h4> -->
              <?php //echo embed_video(get_youtube_video()); ?>

              <?php if ($missing_fields = missing_fields_on_user_profile()): ?>
                <div class="alert alert-danger" role="alert">
                  <h4 class="alert-heading mt-0 mb-3">¡Tu perfil está incompleto!</h4>
                  <?php foreach ($missing_fields as $mf): ?>
                  <p class="my-0">- <?php echo $mf; ?></p>
                  <?php endforeach; ?>
                  <a href="usuarios/editar-mi-perfil" class="btn btn-light text-dark mt-2">Completar ahora</a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <!-- if saldo === 0 -->
        <?php if (get_user_saldo('saldo') == 0): ?>
          <div class="col-xl-12 col-12">
            <div class="pvr-wrapper">
              <div class="pvr-box">
                <div class="text-center py-3">
                  <img src="<?php echo URL.IMG.'undraw_money.svg'; ?>" alt="Saldo agotado" class="img-fluid" style="width: 250px;">
                </div>
                <div class="alert alert-danger text-center">
                  <h5 class="f-w-600">¡Tu saldo está agotado!</h5>
                  <?php echo sprintf('Para realizar compras en <b>%s</b>, debes contar con saldo en tu cuenta, es <b>100%%</b> seguro, rápido y fácil de abonar.', get_sitename()) ?>
                </div>
                <a href="usuarios/recargar-saldo" class="btn btn-success btn-lg btn-block">Haz una recarga</a>

                <div class="text-center mt-5">
                  <img src="<?php echo URL.IMG.'screen_0001.png'; ?>" alt="Saldo agotado" class="w-250 img-thumbnail" <?php echo tooltip('Puedes ver tu saldo disponible en la esquina superior izquierda del navegador, debajo de tu nombre') ?>>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="col-xl-12 col-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <h3 class="element-inner-header m-t-0 text-theme">Más fácil y rápido</h3>
              <p><?php echo sprintf('En %s seguimos trabajando para ofrecer el mejor sistema de venta de envíos y guías en todo México.', get_system_name()); ?></p>
              <img src="<?php echo get_system_logo(250) ?>" alt="<?php echo get_system_name(); ?>" style="width: 80px;">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4 col-lg-4 col-12">
      <div class="row">
        <?php if (!is_working_hours()): ?>
          <div class="col-xl-12">
            <?php echo get_working_hours_message(); ?>
          </div>
        <?php endif; ?>

        <div class="col-xl-12">
          <div class="pvr-wrapper">
            <div class="pvr-box p-50">
              <div class="text-center">
                <img src="<?php echo URL.IMG.'va-new-shipment.svg'; ?>" alt="Nuevo envío" class="img-fluid" style="width: 200px;">
                <h3 class="m-t-20 m-b-30">¿Vamos a enviar algo hoy?</h3>
                <a href="envios/nuevo" class="btn btn-success btn-lg">Agregar nuevo envío</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Prices -->
    <div class="col-xl-4 col-lg-4 col-12">
      <?php echo $d->owl_tarifas; ?>
    </div>
  </div>
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>