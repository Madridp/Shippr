<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<div class="content">
  <?php echo get_breadcrums([['usuarios','Usuarios'],['', $data['usuario']['nombre']]]) ?>
  
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
          <div class="pvr-header">
            <?php echo $data['usuario']['nombre']; ?>
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small><label class="text-muted">Nombre completo</label></small>
                <p class="form-control-static"><?php echo $data['usuario']['nombre'] ?></p>
              </div>
            </div>
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small><label class="text-muted">Usuario</label></small>
                <p class="form-control-static"><?php echo $data['usuario']['usuario'] ?></p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small><label class="text-muted">E-mail</label></small>
                <p class="form-control-static"><a href="mailto:<?php echo $data['usuario']['email'] ?>"><?php echo $data['usuario']['email'] ?></a></p>
              </div>
            </div>
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small><label class="text-muted">Rol de usuario</label></small>
                <p class="form-control-static"><?php echo $data['usuario']['titulo'] ?></p>
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col-12">
              <div class="form-group">
                <small><label class="text-muted">Biografía</label></small>
                <p class="form-control-static"><?php echo (!empty($data['usuario']['bio']) ? $data['usuario']['bio'] : '<span class="text-muted">No hay más información del usuario</span>') ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


<?php require INCLUDES . 'footer.php' ?>