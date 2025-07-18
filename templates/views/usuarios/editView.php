<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
  <?php flasher() ?>

  <div class="row">
    <div class="col-sm-5">
      <div class="user-profile compact">
        <div class="up-head-w">
          <div class="user-profile-bg"><img src="<?php echo (is_file(UPLOADS.$d->u->background) ? UPLOADS.$d->u->background : URL.IMG.'bg-dummy.jpg'); ?>" alt="<?php echo $d->u->nombre; ?>"></div>
          <div class="up-social">
            <?php
            echo redesSociales($d->u->redesSociales);
            ?>
          </div>
          <div class="up-main-info">
            <div class="avatar">
              <img alt="<?php echo $d->u->usuario; ?>" class="avatar" src="<?php echo (is_file(UPLOADS . $d->u->perfil)) ? UPLOADS.$d->u->perfil : URL.IMG.'user-dummy.jpg'; ?>">
            </div>
            <h2 class="up-header">
              <?php echo $d->u->nombre; ?>
            </h2>
            <h6 class="up-sub-header">
              <?php echo $d->u->titulo." / ".get_sitename(); ?>
            </h6>
          </div>
        </div>
      </div>
    </div>
  
    <div class="col-sm-7">
    <form action="usuarios/mi-perfil-update" enctype="multipart/form-data" method="POST">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <div class="pvr-header">Mi perfil</div>

          <h6>Mi información</h6>
          <?php echo insert_inputs(); ?>
          <input type="hidden" name="id_usuario" value="<?php echo $d->u->id_usuario; ?>" required>

          <div class="row">
            <div class="col-xl-12 col-12">
              <div class="form-group">
                <small class="text-muted">Nombre completo</small>
                <input type="text" class="form-control" name="nombre" value="<?php echo $d->u->nombre; ?>" required>
              </div>
            </div>
            <div class="col-xl-6 col-12">
              <div class="form-group">
                <small class="text-muted">Email</small>
                <p><?php echo $d->u->email; ?></p>
              </div>
            </div>
            <div class="col-xl-6 col-12">
              <div class="form-group">
                <small class="text-muted">Usuario</small>
                <p><?php echo $d->u->usuario; ?></p>
              </div>
            </div>
          </div>

          <div class="form-group">
            <small class="text-muted">Biografía</small>
            <textarea type="text" class="form-control" name="bio"><?php echo $d->u->bio; ?></textarea>
          </div>
          <br>

          <h6>Mis redes sociales</h6>
          <div class="row">
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small class="text-muted">Facebook</small>
                <input type="text" class="form-control" name="redes[facebook]"
                value="<?php echo (empty($d->u->redesSociales)) ? '' : json_decode($d->u->redesSociales)->facebook ?>">
              </div>
            </div>
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small class="text-muted">Twitter</small>
                <input type="text" class="form-control" name="redes[twitter]"
                value="<?php echo (empty($d->u->redesSociales)) ? '' : json_decode($d->u->redesSociales)->twitter ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small class="text-muted">Instagram</small>
                <input type="text" class="form-control" name="redes[instagram]"
                value="<?php echo (empty($d->u->redesSociales)) ? '' : json_decode($d->u->redesSociales)->instagram ?>">
              </div>
            </div>
            <div class="col-sm-6 col-12">
              <div class="form-group">
                <small class="text-muted">Whatsapp</small>
                <input type="text" class="form-control" name="redes[whatsapp]"
                value="<?php echo (empty($d->u->redesSociales)) ? '' : json_decode($d->u->redesSociales)->whatsapp ?>">
                <input type="hidden" class="form-control" name="redes[email]" value="<?php echo $d->u->email; ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12 col-12">
              <div class="form-group">
                <small class="text-muted">Google +</small>
                <input type="text" class="form-control" name="redes[google]"
                value="<?php echo (empty($d->u->redesSociales)) ? '' : json_decode($d->u->redesSociales)->google ?>">
              </div>
            </div>
          </div>
          <br>

          <h6>Mi empresa</h6>
          <div class="form-group row">
            <div class="col-xl-6">
              <small class="text-muted d-block">Empresa</small>
              <input type="text" class="form-control" name="empresa" value="<?php echo $d->u->empresa; ?>">
            </div>
            <div class="col-xl-6">
              <small class="text-muted d-block">Razón social</small>
              <input type="text" class="form-control" name="razon_social" value="<?php echo $d->u->razon_social; ?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-xl-6">
              <small class="text-muted d-block">RFC</small>
              <input type="text" class="form-control" name="rfc" value="<?php echo $d->u->rfc; ?>">
            </div>
            <div class="col-xl-6">
              <small class="text-muted d-block">Teléfono</small>
              <input type="text" class="form-control" name="telefono" value="<?php echo $d->u->telefono; ?>">
            </div>
          </div>
          <br>

          <h6>Mi dirección o de la empresa</h6>
          <div class="form-group row">
            <div class="col-xl-2">
              <small class="text-muted d-block">CP</small>
              <input type="text" class="form-control" name="cp" value="<?php echo $d->u->cp; ?>">
            </div>
            <div class="col-xl-6">
              <small class="text-muted d-block">Calle</small>
              <input type="text" class="form-control" name="calle" value="<?php echo $d->u->calle; ?>">
            </div>
            <div class="col-xl-2">
              <small class="text-muted d-block">Núm. exterior</small>
              <input type="text" class="form-control" name="num_ext" value="<?php echo $d->u->num_ext; ?>">
            </div>
            <div class="col-xl-2">
              <small class="text-muted d-block">Núm. interior</small>
              <input type="text" class="form-control" name="num_int" value="<?php echo $d->u->num_int; ?>">
            </div>
          </div>

          <div class="form-group row">
            <div class="col-xl-4">
              <small class="text-muted d-block">Colonia</small>
              <input type="text" class="form-control" name="colonia" value="<?php echo $d->u->colonia; ?>">
            </div>
            <div class="col-xl-4">
              <small class="text-muted d-block">Ciudad</small>
              <input type="text" class="form-control" name="ciudad" value="<?php echo $d->u->ciudad; ?>">
            </div>
            <div class="col-xl-4">
              <small class="text-muted d-block">Estado</small>
              <input type="text" class="form-control" name="estado" value="<?php echo $d->u->estado; ?>">
              <input type="hidden" class="form-control" name="pais" value="México">
            </div>
          </div>
          <br>

          <h6>Personaliza tu perfil</h6>
          <div class="form-group row">
            <div class="col-xl-4">
              <small class="text-muted d-block mb-1">Imagen de perfil</small>
              <div class="upload-btn-wrapper">
                <input type="file" class="upload-btn-input" name="img_perfil[]" accept="image/*" size="3145728"/>
                <button class="upload-btn btn btn-outline-info"><i class="fa fa-upload"></i> Subir imagen</button>
              </div>
            </div>
            <div class="col-xl-4">
              <small class="text-muted d-block mb-1">Imagen de fondo</small>
              <div class="upload-btn-wrapper">
                <input type="file" class="upload-btn-input" name="img_background[]" accept="image/*" size="3145728"/>
                <button class="upload-btn btn btn-outline-info"><i class="fa fa-upload"></i> Subir imagen</button>
              </div>
            </div>
          </div>
          <br>

          <?php echo insert_inputs(); ?>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>
<!--End Content-->



<?php require INCLUDES . 'footer.php' ?>