<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['',$d->title]]); ?>

  <?php flasher() ?>
  
  <!-- Nuestros planes -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">

          <h1 class="text-center">Nuestros planes</h1>
          <p class="text-muted f-s-12  text-center">AHORRA EN CADA ENVÍO</p>
          <p class="text-center">Con nuestro programa de asociados siempre ahorrarás, tendrás acceso a los mejores precios y ofertas disponibles para envíos nacionales e internacionales, tenemos dos opciones que se ajustarán a tus necesidades.</p>

          <div class="card-deck mb-3 text-center mt-5">
            <div class="card mb-4 shadow-sm">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">Free <img src="<?php echo get_user_badge('free'); ?>" alt="Free" style="width: 25px;"></h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>Precios regulares</li>
                  <li>Comisión del 7.8%</li>
                  <li>—</li>
                  <li>—</li>
                </ul>
                <?php if (get_user_sub_type() === 'free'): ?>
                  <button type="button" class="btn btn-lg btn-block btn-outline-dark disabled text-dark">Ya lo tienes</button>
                <?php else: ?>
                <?php endif; ?>
              </div>
            </div>
            <div class="card mb-4 shadow-sm">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">Socio <img src="<?php echo get_user_badge('socio'); ?>" alt="Socio" style="width: 25px;"></h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">$199 <small class="text-muted">/ mes</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>Precios especiales</li>
                  <li>Comisión del 5.0%</li>
                  <li>Soporte prioritario por email</li>
                  <li>—</li>
                </ul>
                <a type="button" class="btn btn-lg btn-block btn-primary text-white" href="<?php echo buildURL('suscribirse/pay',['subType' => 1],false) ?>" data-type="premium">Pagar</a>
              </div>
            </div>
            <div class="card mb-4 shadow-sm">
              <div class="card-header">
                <h4 class="my-0 font-weight-normal">Premium <img src="<?php echo get_user_badge('premium'); ?>" alt="Premium" style="width: 25px;"></h4>
              </div>
              <div class="card-body">
                <h1 class="card-title pricing-card-title">$399 <small class="text-muted">/ mes</small></h1>
                <ul class="list-unstyled mt-3 mb-4">
                  <li>Los precios más bajos</li>
                  <li><b>!Sin comisiones¡</b></li>
                  <li>Soporte prioritario por email</li>
                  <li>Tarifas únicas por sobrepeso</li>
                </ul>
                <a type="button" class="btn btn-lg btn-block btn-primary text-white" href="<?php echo buildURL('suscribirse/pay',['subType' => 2],false) ?>" data-type="premium">Pagar ahora</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>