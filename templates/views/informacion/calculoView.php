<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['',$d->title]]); ?>

  <!-- Formulario -->
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

          <?php flasher() ?>

          <img src="<?php echo URL.IMG.'va-volumetric-image.jpg' ?>" alt="Peso volumétrico" class="img-fluid" style="width: 100%;">
          <h1><?php echo $d->title; ?></h1>
          <p>El peso volumétrico de un envío es el cálculo que refleja la densidad de un paquete. Un artículo menos denso generalmente ocupa menos volumen de espacio, comparado con el peso real. El peso volumétrico o dimensional se calcula y compara con el peso real del envío para calcular cual es mayor. El peso mayor se utiliza para determinar el costo del envío.</p>
          <div class="row">
            <div class="col-xl-6">
              <h5><b>¿Cómo calcular el peso volumétrico de tu envío?</b></h5>
              <p>El divisor volumétrico ha cambiado a 5000 y se aplicará a los productos de acuerdo a la siguiente fórmula:</p>
              <p><strong>longitud x ancho x altura / 5000</strong></p>
              <p>Utiliza la siguiente calculadora para determinar el peso volumétrico de tu paquete:</p>          
            </div>

            <div class="col-xl-6">
              <p>Ingresa las medidas de tu paquete en <strong class="text-danger">centímetros</strong></p>
              <form id="calculadora-peso-volumetrico" method="POST">
                <div class="form-group row"> 
                  <div class="col-xl-12">
                    <label for="alto"><small class="d-block">Alto <span class="text-danger">*</span></small></label>
                    <input type="text" class="form-control form-control-sm money" placeholder="0.00" name="alto" required>
                  </div>
                  <div class="col-xl-12">
                    <label for=""><small class="d-block">Ancho <span class="text-danger">*</span></small></label>
                    <input type="text" class="form-control form-control-sm money" placeholder="0.00" name="ancho" required>
                  </div>
                  <div class="col-xl-12">
                    <label for=""><small class="d-block">Largo <span class="text-danger">*</span></small></label>
                    <input type="text" class="form-control form-control-sm money" placeholder="0.00" name="largo" required>
                  </div>
                  <div class="col-xl-12">
                    <label for=""><small class="d-block">Peso volumétrico</small></label>
                    <input type="text" class="form-control form-control money" name="peso_vol" disabled>
                  </div>
                </div>
                <div class="form-group">
                  <p>Para obtener resultados más precisos ingresa el código postal del destino.</p>
                  <label for="des_cp"><small>Código postal <?php echo bs_required(); ?></small></label>
                  <input type="text" class="form-control" id="des_cp" name="des_cp" placeholder="57896">
                </div>
              </form>
            </div>
          </div>

          <div id="calcular-opciones-wrapper">
          </div>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>