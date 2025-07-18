<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['','Mi Perfil']]) ?>
  <?php flasher() ?>
  
  <div class="row">
    <div class="col-sm-5">
      <div class="user-profile compact">
        <div class="up-head-w">
          <div class="user-profile-bg"><img src="<?php echo (is_file(UPLOADS.$data['usuario']['background'])) ? UPLOADS.$data['usuario']['background'] : IMG.'bg-dummy.jpg'; ?>" alt="<?php echo $data['usuario']['nombre'] ?>"></div>
          <div class="up-social">
            <?php
             echo ($data['usuario']['redesSociales']) ? redesSociales($data['usuario']['redesSociales']) : '';
            ?>
          </div>
          <div class="up-main-info">
            <div class="avatar">
              <img alt="" class="avatar" src="<?php echo (is_file(UPLOADS.$data['usuario']['perfil'])) ? UPLOADS.$data['usuario']['perfil'] : IMG.'user-dummy.jpg'; ?>">
            </div>
            <h2 class="up-header">
              <?php echo $data['usuario']['nombre'] ?>
            </h2>
            <h6 class="up-sub-header">
              <?php echo $data['usuario']['titulo']." / ".get_sitename(); ?>
            </h6>
          </div>
        </div>
      </div>
    </div>

    <div class="col-sm-7">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <div class="pvr-header">Mi perfil</div>
          
          <div class="row">
            <div class="col-xl-6 col-12">
              <div class="form-group">
                <small class="text-muted">Nombre completo</small>
                <p><?php echo not_empty($d->usuario->nombre); ?></p>
              </div>
            </div>
            <div class="col-xl-6 col-12">
              <div class="form-group">
                <small class="text-muted">Usuario</small>
                <p><?php echo not_empty($d->usuario->usuario); ?></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xl-6 col-12">
              <div class="form-group">
                <small class="text-muted">Email</small>
                <p><a href="<?php echo 'mailto:'.$d->usuario->email ?>"><?php echo $d->usuario->email; ?></a></p>
              </div>
            </div>
          </div>

          <div class="form-group">
            <small class="text-muted">Biografía</small>
            <p><?php echo not_empty($d->usuario->bio) ?></p>
          </div>

          <hr>

          <div class="form-group row">
            <div class="col-xl-6">
              <small class="text-muted d-block">Empresa</small>
              <p><?php echo not_empty($d->usuario->empresa); ?></p>
            </div>
            <div class="col-xl-6">
              <small class="text-muted d-block">Razón social</small>
              <p><?php echo not_empty($d->usuario->razon_social); ?></p>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-xl-6">
              <small class="text-muted d-block">RFC</small>
              <p><?php echo not_empty($d->usuario->rfc); ?></p>
            </div>
            <div class="col-xl-6">
              <small class="text-muted d-block">Teléfono</small>
              <p><?php echo not_empty($d->usuario->telefono); ?></p>
            </div>
          </div>

          <hr>

          <div class="form-group row">
            <div class="col-xl-2">
              <small class="text-muted d-block">CP</small>
              <p><?php echo not_empty($d->usuario->cp); ?></p>
            </div>
            <div class="col-xl-6">
              <small class="text-muted d-block">Calle</small>
              <p><?php echo not_empty($d->usuario->calle); ?></p>
            </div>
            <div class="col-xl-2">
              <small class="text-muted d-block">Núm. exterior</small>
              <p><?php echo not_empty($d->usuario->num_ext); ?></p>
            </div>
            <div class="col-xl-2">
              <small class="text-muted d-block">Núm. interior</small>
              <p><?php echo not_empty($d->usuario->num_int); ?></p>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-xl-4">
              <small class="text-muted d-block">Colonia</small>
              <p><?php echo not_empty($d->usuario->colonia); ?></p>
            </div>
            <div class="col-xl-4">
              <small class="text-muted d-block">Ciudad</small>
              <p><?php echo not_empty($d->usuario->ciudad); ?></p>
            </div>
            <div class="col-xl-4">
              <small class="text-muted d-block">Estado</small>
              <p><?php echo not_empty($d->usuario->estado); ?></p>
            </div>
          </div>

          <?php if (get_user_id() == $d->usuario->id_usuario): ?>
          <div class="row">
            <div class="col">
              <a href="<?php echo 'usuarios/editar-mi-perfil' ?>" class="btn btn-primary">Editar mi perfil</a>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require INCLUDES . 'footer.php' ?>