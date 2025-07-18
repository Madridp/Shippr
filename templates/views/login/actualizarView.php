<?php require INCLUDES . 'header.php' ?>
<div class="animated slideInRight py-5">
  <div class="auth_v2_box">
    <div class="logo-w">
      <a href="javascript:void(0)"><img class="img-fluid" style="width: 200px;" alt="<?php echo get_sitename() ?>" src="<?php echo get_sitelogo() ?>"></a>
    </div>
    <h4 class="auth-header m-0 m-b-20">
      Actualiza tu contraseña
    </h4>
    <div class="p-5">
      <?php flasher(); ?>
    </div>
    <form method="POST" action="login/actualizar_contrasena_submit">
      <input type="hidden" name="redirect_to" value="<?php echo CUR_PAGE; ?>">
      <input type="hidden" name="id_usuario" value="<?php echo $dataObj->usuario->id_usuario; ?>">
      <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
      <div class="form-group">
        <label>Password</label>
        <input class="form-control" type="password" name="password">
        <div class="pre-icon material-icons">fingerprint</div>
      </div>

      <div class="form-group">
        <label>Confirma tu password</label>
        <input class="form-control" type="password" name="conf-password">
        <div class="pre-icon material-icons">fingerprint</div>
      </div>
      <div class="buttons-w">
        <input type="submit" class="btn btn-primary " value="Actualizar contraseña" name="submit" />
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
