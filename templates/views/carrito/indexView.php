<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['carrito','Tu carrito de compras']]) ?>

	<?php flasher(); ?>
	
	<div class="row">
    <!-- Carrito de compras -->
    <div class="col-xl-8 col-lg-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">
            <a href="carrito/nuevo" class="btn btn-success float-right">Agregar envío</a>
            Tu carrito de compras
					</h5>
          <?php if ($d->items): ?>
            <h6>Productos en carrito <div class="badge badge-primary"><?php echo $d->total_items; ?></div></h6>
            <div class="table-responsive">
              <table class="table table-hover table-borderless table-sm">
                <thead>
                  <tr>
                    <th class="text-center" width="10%">Carrier</th>
                    <th class="text-left">Información</th>
                    <th class="text-center">Precio unitario</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($d->items as $e): ?>
                  <tr>
                    <td class="text-center align-middle"><img class="img-thumbnail mr-2" src="<?php echo (is_file(COURIERS.$e->image) ? URL.COURIERS.$e->image : URL.IMG.'broken.png') ?>" alt="<?php echo $e->title; ?>" style="border-radius: 50%; width: 40px;"></td>
                    <td class="align-middle">
                      <?php echo $e->title; ?>
                      <small class="text-muted d-block"><?php echo get_cart_shipment_address($e); ?></small>
                    </td>
                    <td class="text-center align-middle"><?php echo money($e->unit_price); ?></td>
                    <td class="text-center align-middle"><?php echo $e->quantity; ?></td>
                    <td class="text-right align-middle"><b><?php echo money(((float)$e->unit_price * $e->quantity)); ?></b></td>
                    <td class="text-right align-middle">
                      <div class="button-group">
                        <a href="<?php echo buildURL('carrito/borrar',['id' => $e->id,'cart_nonce' => $d->cart->nonce]); ?>" class="text-danger"><i class="fa fa-times"></i></a>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <a href="carrito/nuevo" class="btn btn-success float-right">Agregar otro envío</a>
            <div class="clearfix"></div>
          <?php else: ?>
            <div class="text-center py-4">
              <img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_empty_cart.svg' ?>" alt="No hay envíos en tu carrito">
              <a href="carrito/nuevo" class="btn btn-lg btn-success mt-5">Agregar nuevo envío</a>
            </div>
          <?php endif; ?>
				</div>
			</div>
		</div>

    <!-- Cart totals -->
    <div class="col-xl-4 col-lg-6 col-12 cart-wrapper">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Total</h5>

          <h6>Selecciona un método de pago</h6>
          <form action="carrito/pagar-ahora" method="POST">
            <!-- 
            <div class="form-group">
              <label for="mp-qr-code" class="va-custom-radio">
                <input type="radio" id="mp-qr-code" name="pago_metodo" value="paying-qr-code">
                <img class="img-fluid" src="<?php echo URL.IMG.'va-qr-code.svg'; ?>" alt="QR Mercado Pago">
                <span>Con código QR <small>¡la mejor opción!</small> <i class="fas fa-exclamation-circle text-info" aria-hidden="true" <?php echo tooltip('¡Sin comisiones, paga con tarjeta de débito / crédito o dinero en cuenta de Mercado Pago!') ?>></i></span>
              </label>
            </div>
            <div class="form-group">
              <label for="mp-payment" class="va-custom-radio">
                <input type="radio" id="mp-payment" name="pago_metodo" value="paying-mercadopago">
                <img class="img-fluid" src="<?php echo URL.IMG.'va-mercadopago.svg'; ?>" alt="Mercado Pago">
                <span>MercadoPago</span>
              </label>
            </div>
            <div class="form-group">
              <label for="bank-transfer-payment" class="va-custom-radio">
                <input type="radio" id="bank-transfer-payment" name="pago_metodo" value="paying-bank-transfer">
                <img class="img-fluid" src="<?php echo URL.IMG.'va-bank-transfer.svg'; ?>" alt="Transferencia bancaria">
                <span>Transferencia bancaria</span>
              </label>
            </div>
            <div class="form-group">
              <label for="cash-payment" class="va-custom-radio">
                <input type="radio" id="cash-payment" name="pago_metodo" value="paying-cash">
                <img class="img-fluid" src="<?php echo URL.IMG.'va-cash.svg'; ?>" alt="Déposito en efectivo">
                <span>Depósito en efectivo</span>
              </label>
            </div> -->
            <div class="form-group">
              <label for="paying_user_wallet" class="va-custom-radio">
                <input type="radio" id="paying_user_wallet" name="pago_metodo" value="paying_user_wallet" selected>
                <img class="img-fluid" src="<?php echo URL.IMG.'va-account-money.svg'; ?>" alt="Dinero en cuenta">
                <span>Crédito en cuenta <small class="text-muted"><?php echo sprintf('(Disponible %s MXN)', money(get_user_saldo('saldo'))); ?></small></span>
              </label>
            </div>
            <?php echo insert_inputs(); ?>
            
            <div class="cart-totals-wrapper">
              <table class="table table-borderless">
                <tbody>
                  <tr>
                    <td class="text-left">Subtotal</td>
                    <th class="text-right"><?php echo money($d->a->subtotal,'$') ?></th>
                  </tr>
                  <tr>
                    <td class="text-left">Comisiones</td>
                    <th class="text-right"><?php echo money($d->a->comission,'$') ?></th>
                  </tr>
                  <tr>
                    <th class="text-left align-middle text-theme">Total a pagar</th>
                    <th class="text-right align-middle text-theme"><h3 class="m-0 p-0 f-w-600"><b><?php echo 'MXN '.money($d->a->total,'$') ?></b></h3></th>
                  </tr>
                </tbody>
              </table>
              <!--  Loaded dinamically -->
              <small class="text-muted">Recuerda que si alguno de tus paquetes supera la capacidad máxima permitida de peso neto o volumétrico, se aplicarán recargos.</small>
            </div>
            <br>

            <?php if (get_system_status()): ?>
              <button type="submit" class="btn btn-info btn-lg btn-block" <?php echo (!empty($d->items) ? '' : 'disabled') ?>>PAGAR AHORA</button>
            <?php else: ?>
              <div class="alert alert-danger">
                <h4 class="alert-heading mt-1">Sistema fuera de línea</h4>
                <p>En estos momentos nuestro sistema está fuera de línea, la generación de guías se reestablecerá el siguiente día hábil.</p>
                <hr>
                <p class="mb-1"><?php echo sprintf('Gracias por tu atención, %s.', get_sitename()); ?></p>
              </div>
            <?php endif; ?>
          </form>
          
          <div class="text-right m-t-25">
            <img class="img-fluid" src="<?php echo URL.IMG.'SSL_Secure.png' ?>" alt="Pago 100% seguro" style="width: 100px;" <?php echo tooltip('Tu pago es 100% seguro con nosotros') ?>>
          </div>
				</div>
			</div>
		</div>
	</div>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>