<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['usuarios/suscripcion','Mi suscripción'],['',$d->title]]); ?>
  
  <!-- Payment -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">

          <h1 class="text-center"><?php echo $d->title; ?></h1>
          <p class="text-muted f-s-12  text-center">ESTÁS RENOVANDO TU SUSCRIPCIÓN</p>
          <p class="text-center">Sigue ahorrando en cada envío con Shippr Envíos.</p>
          <br>
          <div class="row">
            <div class="col-xl-6 col-12 offset-xl-3">
              <?php if ($d->s->id_sub_type == 1): ?>
              <div class="card mb-4 shadow-sm text-center">
                <div class="card-header">
                  <h4 class="my-0 font-weight-normal">1 x Socio <img src="<?php echo get_user_badge('socio'); ?>" alt="Socio" style="width: 25px;"></h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title">$199 <small class="text-muted">/ mes</small></h1>
                  <ul class="list-unstyled mt-3 mb-4">
                    <li>Precios especiales</li>
                    <li>Comisión del 5.0%</li>
                    <li>Soporte prioritario por email</li>
                    <li>—</li>
                  </ul>
                </div>
              </div>
              <?php elseif($d->s->id_sub_type == 2): ?>
              <div class="card mb-4 shadow-sm text-center">
                <div class="card-header">
                  <h4 class="my-0 font-weight-normal">1 x Premium <img src="<?php echo get_user_badge('premium'); ?>" alt="Premium" style="width: 25px;"></h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title mt-1">$299 <small class="text-muted">/ mes</small></h1>
                  <ul class="list-unstyled mt-3 mb-4">
                    <li>Los precios más bajos</li>
                    <li><b>!Sin comisiones¡</b></li>
                    <li>Soporte prioritario por email</li>
                    <li>Tarifas únicas por recargos</li>
                  </ul>
                </div>
              </div>
              <?php endif; ?>
              <form method="post" id="do_pay_subscription" class="bg-light p-50" style="border-radius: 10px;">
                <!-- Hidden -->
                <h3>Completa el formulario</h3>
                <img src="<?php echo URL.IMG.'paypal-logo.png'; ?>" alt="Métodos de pago" class="img-fluid mb-5" style="width: 180px;">
                <?php flasher() ?>

                <input type="hidden" name="id_sub_type" value="<?php echo $d->s->id_sub_type; ?>">
                <input type="hidden" name="action" value="renewing">
                <div class="form-group">
                  <label for="cardNumber">Número en la tarjeta <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="cardNumber" data-checkout="cardNumber"/>
                </div>
                <div class="form-group row">
                  <div class="col-xl-3">
                    <label for="cardExpirationMonth">Mes <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="cardExpirationMonth" data-checkout="cardExpirationMonth"/>
                  </div>
                  <div class="col-xl-3">
                    <label for="cardExpirationYear">Año <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="cardExpirationYear" data-checkout="cardExpirationYear"/>
                  </div>
                  <div class="col-xl-6">
                    <label for="securityCode">CVC <span class="text-danger">*</span> </label>
                    <div class="row">
                      <div class="col-8">
                        <input type="text" class="form-control" id="securityCode" data-checkout="securityCode"/>
                      </div>
                      <div class="col-4">
                        <img src="<?php echo URL.IMG.'va-cvc.png' ?>" class="text-center obf-cover img-fluid" alt="CVC">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="cardholderName">Titular de la tarjeta <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="cardholderName" data-checkout="cardholderName"/>
                </div>
                <div class="form-group">
                  <label for="issuerId">Emisor de la tarjeta <span class="text-danger">*</span></label>
                  <select id="issuerId" class="form-control" name="issuerId"></select>
                </div>
                <div class="form-group">
                  <label for="docType">Issuer id:</label>
                  <select id="docType" class="form-control" data-checkout="docType"></select>
                </div>
                <div class="form-group d-none">
                  <label for="docNumber">Document number:</label>
                  <input type="text" class="form-control" id="docNumber" data-checkout="docNumber" placeholder="12345678" />
                </div>

                <input type="hidden" class="form-control" name="paymentMethodId" id="paymentMethodId" />
                <input type="hidden" class="form-control" name="token" id="token" />
                <p class="text-muted">No haremos ningún cargo automático mensualmente, la suscripción debe ser renovada por el usuario de forma manual.</p>
                <button type="submit" class="btn btn-primary btn-lg btn-block" id="do_pay_now_button">Renovar ahora</button>
                <img class="img-fluid float-right mt-4" style="width: 125px;" src="<?php echo URL.IMG.'norton-secured.svg'; ?>" alt="Norton Secured">
                <div class="clearfix"></div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>