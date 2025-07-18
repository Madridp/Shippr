<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['usuarios/perfil','Mi Perfil'],['',$d->title]]) ?>
  <?php flasher() ?>
	
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Vamos a recargar saldo a tu cuenta</h5>
          <div class="text-center py-5">
            <img class="w-200" src="<?php echo URL.IMG.'undraw_vault.svg'; ?>" alt="Recargar saldo">
          </div>

					<form action="usuarios/post_recargar_saldo" method="POST">
						<input type="hidden" name="id_usuario" value="<?php echo get_user_id(); ?>">
						<?php echo insert_inputs(); ?>
            
            <p><?php echo sprintf('Hola <b>%s</b>, ¿cuánto saldo quieres recargar a tu cuenta?', get_user_name()) ?></p>
            <p>Este es tu saldo hasta la fecha.</p>
            <div class="table-responsive mb-5">
              <table class="table table-sm table-striped vmiddle">
                <tbody>
                  <tr>
                    <th>Saldo pendiente <?php echo more_info('Saldo pendiente de pago o de aprobación') ?></th>
                    <td><?php echo money(get_user_saldo('pendiente')); ?></td>
                  </tr>
                  <tr>
                    <th>Saldo usado <?php echo more_info('Saldo utilizado en compras o cargos adicionales (sobrepeso de envíos)') ?></th>
                    <td><?php echo money(get_user_saldo('retirado')); ?></td>
                  </tr>
                  <tr>
                    <th>Saldo disponible</th>
                    <td><?php echo money(get_user_saldo('saldo')); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
						<div class="form-group row">
              <div class="col-xl-6 col-lg-6 col-12">
                <label for="email">Aquí recibirás tu ticket</label>
                <input type="email" class="form-control" readonly name="email" value="<?php echo get_user_email(); ?>" required>
              </div>
              <div class="col-xl-6 col-lg-6 col-12">
                <label for="amount">Saldo a recargar</label>
                <select name="amount" id="amount" class="form-control select2-basic-single">
                  <?php foreach(get_saldo_montos() as $monto): ?>
                    <option value="<?php echo $monto; ?>"><?php echo money($monto) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <p class="text-muted">Selecciona una de las opciones de arriba, <b>te enviaremos a tu correo electrónico</b> la información de pago y folio.</p>
            </div>
            
            <button type="submit" class="btn btn-success btn-lg">Generar ticket</button>
            <button type="reset" class="btn btn-light btn-lg float-right">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>