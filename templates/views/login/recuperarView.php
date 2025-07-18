<?php require INCLUDES . 'header.php' ?>
<div class="animated slideInRight py-5">
  <div class="auth_v2_box">
    <div class="logo-w">
      <a href="javascript:void(0)"><img class="img-fluid" style="width: 200px;" alt="<?php echo get_sitename() ?>" src="<?php echo get_sitelogo() ?>"></a>
    </div>
    <h4 class="auth-header m-0 m-b-20">
      Recuperar contraseña
    </h4>
    <div class="p-5">
      <?php flasher(); ?>
    </div>
    <form method="POST" action="login/recuperar_contrasena_submit">
      <input type="hidden" name="redirect_to" value="<?php echo CUR_PAGE; ?>">
      <div class="form-group">
        <label>Usuario registrado</label>
        <input class="form-control" placeholder="nombredeusuario" type="text" name="usuario">
        <div class="pre-icon material-icons">verified_user</div>
      </div>
      <div class="buttons-w">
        <input type="submit" class="btn btn-primary " value="Recuperar contraseña" name="submit" />
      </div>
      <div class="col-lg-12 m-t-20 p-l-0">
        <small><a href="login">Iniciar sesión</a></small>
      </div>
    </form>
  </div>
</div>
<div class="auth_bg"><img src="<?php echo get_site_login_bg(); ?>" alt="<?php echo get_sitename(); ?>"></div>

</div>
<!--EndMain Panel-->
</div>
<!--End wrapper-->
<!-- begin scroll to top btn -->
<a href="javascript:void(0)" class="btn btn-icon btn-circle btn-scroll-to-top btn-sm animated invisible text-light" data-color="purple" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->

<!--   Core JS Files   -->
<?php require_once INCLUDES.'scripts.php'; ?>
<!-- END PAGE LEVEL JS -->

</body>
<!--End Body-->
</html>