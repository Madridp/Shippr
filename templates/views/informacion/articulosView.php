<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['informacion','Información'],['','Artículos prohibidos']]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            <?php echo $d->title; ?>
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <h1>Artículos prohibidos</h1>
          <p>Antes de realizar cualquier envío, asegurate que el contenido de tu paquete no se encuentra dentro de la siguiente lista:</p>
          <div class="row">
            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/firearms.png' ?>" alt="Armas" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Armas de fuego o de cualquier otro tipo.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/diamond.png' ?>" alt="Joyas" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Joyas, piedras preciosas, dinero u otros documentos negociables.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/diet.png' ?>" alt="Productos" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Productos perecederos o de fácil descomposición.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/wine-bottle.png' ?>" alt="Alcohol" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Bebidas alcohólicas y líquidos en general.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/pills.png' ?>" alt="Estupefacientes" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Estupefacientes, psicotrópicos o medicamentos controlados y de circulación restringida.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/flask.png' ?>" alt="Muestras de laboratorio" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Muestras de laboratorio tóxicas, peligrosas o que requieren manejo especial.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/dog.png' ?>" alt="Animales" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Plantas o animales vivos o muertos.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/leather.png' ?>" alt="Piel y cuero animal" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Piel o cuero animal.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/glass.png' ?>" alt="Vidrio o cristal" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Vidrio o cristal en cualquier presentación.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/biohazard.png' ?>" alt="Tóxicas" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Sustancias peligrosas (tóxicas, irritantes, infecciosas, corrosivas, solventes, oxidantes o inflamables).</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/explosion.png' ?>" alt="Explosivos" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Explosivos y gases comprimidos.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/radiation.png' ?>" alt="Radioactivos" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Objetos magneticos o radioactivos.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/fake-website.png' ?>" alt="Replicas" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Mercancía falsificada o de procedencia extranjera que no cuente con los documentos de importación.</small>
                </div>
              </div>
            </div>

            <div class="col-xl-3">
              <div class="card m-b-25">
                <div class="card-body text-center">
                  <img class="img-fluid" src="<?php echo URL.IMG.'banned/condom.png' ?>" alt="Pornografía" style="width: 100px;">
                  <small class="d-block text-muted mt-3">Material pornográfico.</small>
                </div>
              </div>
            </div>
          </div>

          <p>Dependiento del carrier o courier y de las disposiciones locales, es posible enviar perecederos, bebidas alcohólicas y otros líquidos, muestras clínicas o biológicas no infecciosas, plantas o flores y artículos de cristal, vidrio, cerámica, etcétera, siempre que estos vengan correctamente empacados y señalizados.</p>
          <p>Para conocer más sobre los requerimientos de envío de artículos especiales puedes consultar directamente las páginas de los couriers.</p>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>