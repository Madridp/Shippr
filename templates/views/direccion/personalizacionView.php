<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['direccion','Dirección General'],['','Personalización']]) ?>

  <?php flasher() ?>

  <div class="row">
    <!-- Site theme and alignment -->
    <div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Selecciona las opciones
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>
          <form action="direccion/personalizacion_store" method="POST" enctype="multipart/form-data">
            <?php echo insert_inputs(); ?>
            <div class="row">
              <div class="col-xl-12 col-xm-12">
                <h6>Tema del sitio</h6>
                <p>Selecciona el tema que se utilizará en toda la aplicación, personaliza tu experiencia.</p><br>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-12 col-xm-12">
                      <!-- Dashboard color -->
                      <div class="custom-radios">
                        <?php foreach (get_theme_colors() as $o): ?>
                          <?php if ($o == get_sitetheme()): ?>
                            <input type="radio" id="<?php echo $o ?>" name="sitetheme" value="<?php echo $o ?>" class="image-input" checked>
                            <label for="<?php echo $o; ?>">
                              <span>
                                <img src="<?php echo IMG.'dashboard-'.$o.'.svg' ?>" alt="<?php echo $o; ?>" class="dashboard-img" />
                              </span>
                            </label>
                          <?php else: ?>
                            <input type="radio" id="<?php echo $o ?>" name="sitetheme" value="<?php echo $o ?>" class="image-input">
                            <label for="<?php echo $o; ?>">
                              <span>
                                <img src="<?php echo IMG.'dashboard-'.$o.'.svg' ?>" alt="<?php echo $o; ?>" class="dashboard-img" />
                              </span>
                            </label>
                          <?php endif; ?>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <br>

                <h6>Alineación de la barra de navegación</h6>
                <p>Selecciona la dirección en la que estará alineada la barra de navegación lateral.</p><br>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-12">
                      <!-- Sidebar alignment -->
                      <div class="custom-radios">
                        <?php foreach (['left','right'] as $sb_alignment): ?>
                        <input type="radio" id="<?php echo 'sb_alignment-'.$sb_alignment ?>" name="sidebar_alignment" value="<?php echo $sb_alignment ?>" class="image-input" <?php echo $sb_alignment == get_sidebar_alignment() ? 'checked' : '' ?>>
                        <label for="<?php echo 'sb_alignment-'.$sb_alignment; ?>">
                          <span><img style="padding: 5px;" src="<?php echo URL.IMG.'sidebar-'.$sb_alignment.'.png' ?>" alt="<?php echo $sb_alignment; ?>" /></span>
                        </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <br>

                <h6>Barra lateral semitransparente</h6>
                <p>Al activar la siguiente casilla, el color de barra de navegación será semi-transparente.</p>
                <div class="form-group">
                  <label for="sidebar_opacity">Semitransparencia</label>
                  <div class="onoffswitch">
                    <input type="checkbox" name="sidebar_opacity" class="onoffswitch-checkbox" id="sidebar_opacity" <?php echo get_sidebar_opacity() ? 'checked' : ''; ?>>
                    <label class="onoffswitch-label" for="sidebar_opacity">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                  </div>
                </div>
                <br>

                <h6>Alineación de plantilla de correo electrónico</h6>
                <p>Selecciona la dirección en la que estará alineado el logotipo en los correos electrónicos de la aplicación.</p><br>
                <div class="form-group">
                  <div class="row">
                    <div class="col-xl-12">
                      <!-- Email alignment -->
                      <div class="custom-radios">
                        <?php foreach ($d->email_options as $o): ?>
                        <?php if ($o == get_email_alignment()): ?>
                        <input type="radio" id="<?php echo 'email-'.$o ?>" name="email_alignment" value="<?php echo $o ?>" class="image-input" checked>
                        <label for="<?php echo 'email-'.$o; ?>">
                          <span>
                            <img src="<?php echo IMG.'email-gray-'.$o.'.svg' ?>" alt="<?php echo $o; ?>" />
                          </span>
                        </label>
                        <?php else: ?>
                        <input type="radio" id="<?php echo 'email-'.$o ?>" name="email_alignment" value="<?php echo $o ?>" class="image-input">
                        <label for="<?php echo 'email-'.$o; ?>">
                          <span>
                            <img src="<?php echo URL.IMG.'email-gray-'.$o.'.svg' ?>" alt="<?php echo $o; ?>" />
                          </span>
                        </label>
                        <?php endif; ?>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
              </div>
            </div>
            <br>

            <input type="submit" class="btn btn-success" value="Guardar cambios" name="submit">
            <input type="reset" class="btn btn-default" value="Cancelar" name="cancel">
          </form>
        </div>
      </div>
    </div>

    <!-- Login bg -->
    <div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Personaliza
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>
          <form action="direccion/personalizacion-images-submit" method="POST" class="form-horizontal" enctype="multipart/form-data">
            <?php echo insert_inputs(); ?>

            <h6>Imagen de fondo para ingreso de usuarios</h6>
            <p>Personaliza la imagen que se verá de fondo en la sección de ingreso y recuperación de contraseña.</p>
            <div class="serp-img-container">
              <a href="<?php echo get_site_login_bg() ?>" data-lightbox="Imagen de ingreso" data-title="<?php echo pathinfo(get_site_login_bg(), PATHINFO_BASENAME) ?>">
                <img src="<?php echo get_site_login_bg() ?>" class="img-fluid wrapper_site_login_bg" alt="<?php echo get_sitename() ?>">
              </a>
              <button type="button" class="serp-l-button serp-l-r-button serp-l-button-danger do_delete_site_login_bg"><i class="fas fa-trash"></i></button>
            </div>
            <div class="form-group mt-3">
              <label for="">Slecciona una imagen de fondo</label>
              <input type="file" class="form-control text-truncate" name="site_login_bg" accept="image/*">
              <small class="text-muted">Medidas recomendadas <span class="text-danger">2000 px</span> por <span class="text-danger">1300 px</span>, 
              con un peso menor a <span class="text-danger">3 MB</span></small>
            </div>
            <br>

            <h6>Imagen de fondo para barra lateral</h6>
            <p>Personaliza la imagen que se verá de fondo en la barra de navegación lateral.</p>
            <div class="serp-img-container w-200">
              <a href="<?php echo get_sidebar_bg() ?>" data-lightbox="Imagen de Fondo" data-title="<?php echo pathinfo(get_sidebar_bg(), PATHINFO_BASENAME) ?>">
                <img src="<?php echo get_sidebar_bg() ?>" class="img-fluid wrapper_sidebar_bg" alt="<?php echo get_sitename() ?>">
              </a>
              <button type="button" class="serp-l-button serp-l-r-button serp-l-button-danger do_delete_sidebar_bg"><i class="fas fa-trash"></i></button>
            </div>
            <div class="form-group mt-3">
              <label for="">Slecciona una imagen de fondo</label>
              <input type="file" class="form-control text-truncate" name="sidebar_bg" accept="image/*">
              <small class="text-muted">Medidas recomendadas <span class="text-danger">500 px</span> por <span class="text-danger">1200 px</span>, 
              con un peso menor a <span class="text-danger">3 MB</span></small>
            </div>
            <br>

            <h6>Favicon del sitio</h6>
            <p>Es el icono mostrado en la barra superior de todos los navegadores, suele ser el logotipo de la empresa en formato cuadrado.</p>
            <div class="row">
              <div class="col-xl-6 col-12">
                <img src="<?php echo URL.IMG.'jserp-favicon-mu.png'; ?>" alt="<?php echo get_sitename() ?>" class="img-fluid img-thumbnail">
              </div>
              <div class="col-xl-6 col-12">
                <img src="<?php echo get_sitefavicon() ?>" class="img-thumbnail" alt="<?php echo get_sitename() ?>" <?php echo tooltip('Favicon actual de '.get_sitename()) ?> style="width: 25px;">
              </div>
            </div>
            <div class="form-group mt-3">
              <label for="">Slecciona una imagen para favicon</label>
              <input type="file" class="form-control text-truncate" name="sitefavicon" accept="image/*">
              <small class="text-muted">Medidas recomendadas <span class="text-danger">100 px</span> por <span class="text-danger">100 px</span>, 
              con un peso menor a <span class="text-danger">3 MB</span></small>
            </div>
            <br>

            <input type="submit" class="btn btn-success" value="Guardar imágenes" name="submit">
            <input type="reset" class="btn btn-default" value="Cancelar" name="cancel">
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>