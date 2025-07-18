<?php require INCLUDES . 'header.php' ?>

<div class="animated slideInRight py-5">
  <div class="auth_v2_box">
    <div class="logo-w">
      <a href="javascript:void(0)"><img class="img-fluid" style="width: 200px;" alt="<?php echo get_sitename() ?>" src="<?php echo get_sitelogo() ?>"></a>
    </div>
    <h4 class="auth-header m-0 m-b-20">
      Regístrate
    </h4>
    <div class="p-5">
      <?php flasher(); ?>
    </div>
    <form action="registro/store" method="POST" style="padding: 40px;" <?php $form = FormHandler::create('registro_usuario'); ?>>
      <?php echo insert_inputs(); ?>

      <div class="form-group">
        <label>Nombre completo <?php echo bs_required(); ?></label>
        <input class="form-control" placeholder="Walter White Jr" type="text" name="nombre" value="<?php echo $form->get_field('nombre'); ?>" required>
        <small class="text-muted">Incluye nombre(s) y apellido(s).</small>
      </div>

      <div class="form-group">
        <label>Correo electrónico <?php echo bs_required(); ?></label>
        <input class="form-control" placeholder="walter@shippr.com.mx" type="text" name="email" value="<?php echo $form->get_field('email'); ?>" required>
      </div>

      <div class="form-group">
        <label>Usuario <?php echo bs_required(); ?></label>
        <input class="form-control" placeholder="walterwhite" type="text" name="usuario" value="<?php echo $form->get_field('usuario'); ?>" required>
        <small class="text-muted">No debe contener espacios ni caracteres especiales, lo usarás para iniciar sesión.</small>
      </div>

      <div class="form-group">
        <label>Contraseña <?php echo bs_required(); ?></label>
        <input class="form-control" placeholder="Escribe tu contraseña" type="password" name="password" required>
        <small class="text-muted">Longitud mínima de 5 caracteres.</small>
      </div>

      <div class="form-group">
        <label>Confirma tu contraseña <?php echo bs_required(); ?></label>
        <input class="form-control" placeholder="Escríbela de nuevo" type="password" name="conf-password" required>
      </div>

      <input type="submit" class="btn btn-primary " value="Registrarse" name="login" />
      <div class="col-lg-12 m-t-20 p-l-0">
        <small>¿Ya tienes cuenta? <a href="login">Inicia sesión</a></small>
      </div>
    </form>
  </div>
</div>
<div class="auth_bg"><img src="<?php echo get_site_login_bg(); ?>" alt="<?php echo get_sitename(); ?>"></div>

<!-- begin scroll to top btn -->
<a href="javascript:void(0)" class="btn btn-icon btn-circle btn-scroll-to-top btn-sm animated invisible text-light" data-color="purple" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->

<!--   Core JS Files   -->
<?php require_once INCLUDES.'scripts.php'; ?>
<!-- END PAGE LEVEL JS -->

</body>
<!--End Body-->
</html>