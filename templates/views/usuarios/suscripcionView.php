<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['',$d->title]]); ?>

  <?php flasher() ?>
  
  <!-- Nuestros planes -->
  <div class="row">
    <div class="col-xl-8 offset-xl-2 col-12">
      <div class="row">
        <!-- subscription info -->
        <div class="col-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <div class="pvr-header">
                <?php echo $d->title; ?>
                <div class="pvr-box-controls">
                  <i class="material-icons" data-box="fullscreen">fullscreen</i>
                  <i class="material-icons" data-box="close">close</i>
                </div>
              </div>
              
              <div class="form-group row">
                <div class="col-xl-2 col-md-2 col-12">
                  <small class="text-muted d-block">Estado</small>
                  <?php echo $d->s->status; ?>
                </div>
                <div class="col-xl-2 col-md-2 col-12">
                  <small class="text-muted d-block">Tipo de suscripción</small>
                  <img class="mr-2" style="width: 20px;" src="<?php echo get_user_badge($d->s->type); ?>" alt="<?php echo $d->s->title; ?>"><?php echo $d->s->title; ?>
                </div>
                <div class="col-xl-2 col-md-2 col-12">
                  <small class="text-muted d-block">Mensualidad</small>
                  <?php echo money($d->s->regular_price); ?>
                </div>
                <div class="col-xl-3 col-md-3 col-12">
                  <small class="text-muted d-block">Fecha de inicio</small>
                  <?php echo fecha(date('Y-m-d',$d->s->start)); ?>
                </div>
                <div class="col-xl-3 col-md-3 col-12">
                  <small class="text-muted d-block">Fecha de expiración</small>
                  <?php echo ($d->s->end < time() ? 'Expiró el ' : '').fecha(date('Y-m-d',$d->s->end)); ?>
                </div>
              </div>
              <?php if ($d->s->end < time()): ?>
              <a href="usuarios/renovar" class="btn btn-primary mb-1">Renovar ahora</a>
              <?php endif; ?>
              <a href="#" class="btn btn-danger mb-1">Cancelar suscripción</a>
            </div>
          </div>
        </div>

        <!-- transaction list -->
        <div class="col-12">
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <div class="pvr-header">
                Transacciones
                <div class="pvr-box-controls">
                  <i class="material-icons" data-box="fullscreen">fullscreen</i>
                  <i class="material-icons" data-box="close">close</i>
                </div>
              </div>

              <?php if ($d->t): ?>
              <table class="table table-striped table-hover table-sm vmiddle" id="data-table">
                <thead class="thead-dark">
                  <tr>
                    <th>Estado</th>
                    <th>Folio</th>
                    <th>Método de pago</th>
                    <th>Mensualidades</th>
                    <th>Subtotal</th>
                    <th>Total</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($d->t as $t): ?>
                  <tr>
                    <td><?php echo $t->status; ?></td>
                    <td><?php echo $t->payment_number; ?></td>
                    <td><?php echo $t->payment_method; ?></td>
                    <td><?php echo $t->installments; ?></td>
                    <td><?php echo money($t->subtotal); ?></td>
                    <td><?php echo money($t->total); ?></td>
                    <td><?php echo fecha($t->created_at); ?></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <?php else: ?>
              <p>No hay transacciones registradas</p>
              <?php endif; ?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>