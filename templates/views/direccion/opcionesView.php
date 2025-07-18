<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['direccion','Dirección general'],['','Opciones generales']]); ?>

	<?php flasher() ?>

	<div class="row">
		<div class="offset-xl-3 col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Completa el formulario
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

					<form action="direccion/opciones-submit" method="POST" enctype="multipart/form-data">
						<?php echo insert_inputs(); ?>

						<h6>Opciones del sitio</h6>
						<div class="form-group">
							<label>Versión actual del sistema</label>
							<input class="form-control" type="text" name="siteversion" value="<?php echo get_siteversion(); ?>" required>
						</div>

            <div class="form-group">
							<label>Comisión de Mercado Pago</label>
							<input class="form-control" type="text" name="va_mp_comission_rate" value="<?php echo get_va_mp_comission_rate(); ?>" required>
						</div>

						<div class="form-group">
							<label>Cargo por sobrepeso</label>
							<input class="form-control money" name="va_mp_overweight_price" type="text" value="<?php echo get_va_overweight_price(); ?>" required>
						</div>

						<div class="form-group">
							<label>Public Key</label>
							<input class="form-control" name="va_mp_public_key" type="text" value="<?php echo get_mp_public_key(); ?>" required>
						</div>

						<div class="form-group">
							<label>Access Token</label>
							<input class="form-control" name="va_mp_access_token" type="text" value="<?php echo get_mp_access_token(); ?>" required>
						</div>

						<div class="form-group">
							<!-- Rounded switch -->
							<label>Aceptando nuevos pedidos</label>
							<div class="custom-slider">
								<label class="switch m-0">
									<input type="checkbox" name="site_status" id="site_status" <?php echo (get_system_status() ? 'checked' : '') ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<br>

						<input type="submit" class="btn btn-success" value="Guardar cambios" name="submit">
						<input type="reset" class="btn btn-default" value="Cancelar" name="cancel">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>