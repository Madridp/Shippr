<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['direccion','Dirección General'],['',$d->title]]); ?>
	<?php flasher() ?>

	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Completa el formulario</h5>

					<form action="direccion/facturacion_store" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<?php echo insert_inputs(); ?>

						<h6>Datos fiscales</h6>
						<p>Estos datos aparecerán en la cabecera de todos los documentos generados de forma dinámica.</p>
						<div class="form-group">
							<label for="siterazonSocial">Razón social</label>
							<input class="form-control" name="siterazonSocial" id="siterazonSocial" type="text" value="<?php echo get_siterazonSocial(); ?>">
						</div>

						<div class="form-group">
							<label for="siterfc">RFC</label>
							<input class="form-control" name="siterfc" id="siterfc" type="text" value="<?php echo get_siterfc(); ?>">
						</div>

						<div class="form-group">
							<label for="site_regimen">Régimen fiscal</label>
							<select name="site_regimen" id="site_regimen" class="form-control">
								<?php foreach (get_sat_regimenes() as $regimen): ?>
									<option value="<?php echo $regimen->id; ?>" <?php echo get_site_regimen() === $regimen->id ? 'selected' : '' ?>><?php echo $regimen->id.' - '.$regimen->descripcion; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="row">
							<div class="col-xl-6">
								<div class="form-group">
									<label for="calle">Calle</label>
									<input class="form-control" name="calle" id="calle" type="text" value="<?php echo get_siteaddress()->calle; ?>">
								</div>
							</div>

							<div class="col-xl-3">
								<div class="form-group">
									<label for="num_ext">Núm. exterior</label>
									<input class="form-control" name="num_ext" id="num_ext" type="text" value="<?php echo get_siteaddress()->num_ext; ?>">
								</div>
							</div>

							<div class="col-xl-3">
								<div class="form-group">
									<label for="num_int">Núm. interior</label>
									<input class="form-control" name="num_int" id="num_int" type="text" value="<?php echo get_siteaddress()->num_int; ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xl-6">
								<div class="form-group">
									<label for="colonia">Colonia</label>
									<input class="form-control" name="colonia" id="colonia" type="text" value="<?php echo get_siteaddress()->colonia; ?>">
								</div>
							</div>
							<div class="col-xl-6">
								<div class="form-group">
									<label for="ciudad">Ciudad, alcaldía o municipio</label>
									<input class="form-control" name="ciudad" id="ciudad" type="text" value="<?php echo get_siteaddress()->ciudad; ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xl-6">
								<div class="form-group">
									<label for="estado">Estado</label>
									<input class="form-control" name="estado" id="estado" type="text" value="<?php echo get_siteaddress()->estado; ?>">
									<input class="form-control" name="pais" id="pais" type="hidden" value="México">
								</div>
							</div>
							<div class="col-xl-6">
								<div class="form-group">
									<label for="cp">Código postal</label>
									<input class="form-control" name="cp" id="cp" type="text" value="<?php echo get_siteaddress()->cp; ?>">
								</div>
							</div>
						</div>
						<br>

						<h6>Datos bancarios <?php echo more_info('Es importante completar estos datos para que tus usuarios realicen sus pagos') ?></h6>
						<p>Es importante completar los siguientes campos para que tus usuarios puedan realizar pagos y abonar saldo a sus cuentas.</p>
						<div class="form-group">
							<label for="bank_name">Banco <?php echo bs4_required() ?></label>
							<input class="form-control" name="bank_name" id="bank_name" type="text" value="<?php echo get_bank_info()->name; ?>" required>
						</div>

						<div class="form-group">
							<label for="bank_number">Número de sucursal <?php echo bs4_required() ?></label>
							<input class="form-control" name="bank_number" id="bank_number" type="text" value="<?php echo get_bank_info()->number; ?>" required>
						</div>

						<div class="form-group">
							<label for="bank_account_name">Títular <?php echo bs4_required() ?></label>
							<input class="form-control" name="bank_account_name" id="bank_account_name" type="text" value="<?php echo get_bank_info()->account_name; ?>" required>
						</div>
							
						<div class="row">
							<div class="col-xl-6">
								<div class="form-group">
									<label for="bank_account_number">Número de cuenta <?php echo bs4_required() ?></label>
									<input class="form-control" name="bank_account_number" id="bank_account_number" type="text" value="<?php echo get_bank_info()->account_number; ?>" required>
								</div>
							</div>

							<div class="col-xl-6">
								<div class="form-group">
									<label for="bank_clabe">CLABE Interbancaria <?php echo bs4_required() ?></label>
									<input class="form-control" name="bank_clabe" id="bank_clabe" type="text" value="<?php echo get_bank_info()->clabe; ?>" required>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-xl-6">
								<div class="form-group">
									<label for="bank_card_number">Pago en OXXO / 7Eleven <?php echo bs4_required(); ?> <?php echo more_info('Número de cuenta o tarjeta para pago en OXXO / 7Eleven') ?> </label>
									<input class="form-control" name="bank_card_number" id="bank_card_number" type="text" value="<?php echo get_bank_info()->card_number; ?>" required>
								</div>
							</div>
						</div>
						<br>

            <button class="btn btn-success" type="submit">Guardar cambios</button>
            <button class="btn btn-default" type="reset">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>