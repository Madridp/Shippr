<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- Área del contenido principal -->
<div class="content">

  <?php flasher() ?>

  <div class="row">
    <div class="col-xl-3"></div>
    <div class="col-xl-6 col-sm-12">
      <div class="pvr-wrapper">
				<div class="pvr-box">
          <div class="text-center">
            <h1 class="m-0"><?php echo $d->title; ?></h1>
            <p class="text-muted m-0">Número de pago <a href="<?php echo 'usuarios/suscripcion'; ?>" target="_blank"><?php echo $d->t->payment_number; ?></a></p>
            <h3><?php echo 'Gracias '.get_user_name(); ?></h3>
            <p>Estamos verificando tu pago, puede tomar de 24 a 72 horas, sigue disfrutando de los beneficios de usar Shippr Envíos <strong><?php echo $d->t->title; ?></strong></p>
          </div>
          <div class="text-center py-5">
            <img src="<?php echo URL.IMG.'va-transaction-in-process.svg'; ?>" alt="<?php echo $d->title; ?>" style="width: 250px;">
          </div>
          <table class="table table-striped table-hover table-sm vmiddle">
            <tbody>
              <tr>
                <th width="40%">Estado del pago</th>
                <td class="align-middle text-right">
                  <?php echo $d->t->status; ?>
                </td>
              </tr>
              <tr>
                <th width="40%">Método de pago</th>
                <td class="align-middle text-right">
                  <?php echo $d->t->payment_method ?>
                </td>
              </tr>
              <tr>
                <th width="40%">Subtotal</th>
                <td class="align-middle text-right"><?php echo money($d->t->subtotal,'$') ?></td>
              </tr>
              <tr>
                <th>Restante</th>
                <td class="align-middle text-right"><?php echo money($d->t->due,'$') ?></td>
              </tr>
              <tr>
                <th>Total</th>
                <td class="align-middle text-right"><?php echo money($d->t->total,'$') ?></td>
              </tr>
            </tbody>
          </table>
        </div>
			</div>
    </div>
  </div>  
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>