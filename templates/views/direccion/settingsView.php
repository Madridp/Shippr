<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<div class="row">
		<div class="col">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="direccion">Dirección General</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Configuración</li>
			  </ol>
			</nav>
		</div>
	</div>

	<?php flasher() ?>

	<div class="row">
		<div class="col-xl-12 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Completa el formulario
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

					<form action="direccion/settings_store" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<input type="hidden" name="redirect_to" value="<?php echo CUR_PAGE ?>">
						<div class="row">
							<div class="col-xl-6">
								<h6>Configuración</h6>
								<p>Para que la plataforma funcione correctamente es necesario llenar estos campos.</p>
								<div class="form-group">
									<label>Sandbox MercadoPago</label>
									<!-- Rounded switch -->
									<div class="custom-slider">
										<label class="switch m-0">
											<input type="checkbox" name="mp_sandbox" id="mp_sandbox" <?php echo (get_mp_sandbox() ? 'checked' : '') ?>>
											<span class="slider round"></span>
										</label>
									</div>
								</div>

								<div class="form-group">
									<label for="sitename">Nombre de la empresa</label>
									<input class="form-control" name="sitename" id="sitename" type="text" value="<?php echo get_sitename(); ?>" required>
								</div>

								<div class="form-group">
									<label>Eslogan</label>
									<input class="form-control" name="siteslogan" id="siteslogan" type="text" value="<?php echo get_siteslogan(); ?>" required>
								</div>

								<div class="form-group">
									<label for="sitedesc">Descripción de la empresa (opcional)</label>
									<textarea name="sitedesc" id="sitedesc" cols="30" rows="3" class="form-control"><?php echo get_sitedesc(); ?></textarea>
								</div>

								<div class="form-group <?php echo (is_root(Auth::get_user_role()) ? '' : 'd-none') ?>">
									<label for="siteurl">URL del sitio</label>
									<input class="form-control" name="siteurl" id="siteurl" type="text" 
									value="<?php echo get_siteurl(); ?>">
									<small class="text-muted">Solo cambiar en caso de migración de servidor o ruta de la plataforma.</small>
								</div>

								<div class="form-group">
									<label for="siteph">Teléfono</label>
									<input class="form-control" name="siteph" id="siteph" type="text" value="<?php echo get_siteph() ?>" required>
								</div>

								<div class="form-group">
									<label for="time_zone">Zona horaria</label>
									<select name="time_zone" class="form-control select2-basic-single" id="time_zone" required>
									<?php foreach ($dataObj->timezones as $t) : ?>
										<?php if (get_timezone() == $t->value): ?>
											<option value="<?php echo $t->value; ?>" selected><?php echo $t->name; ?></option>
										<?php else: ?>
											<option value="<?php echo $t->value; ?>"><?php echo $t->name; ?></option>
										<?php endif; ?>
									<?php endforeach ?>
									</select>
								</div>

								<br>
									<h6>Datos fiscales</h6>
									<p>
									Estos datos aparecerán en la cabecera de todos los documentos generados de forma dinámica.
									</p>
								<br>

								<div class="form-group">
									<label for="siterazonSocial">Razón social</label>
									<input class="form-control" name="siterazonSocial" id="siterazonSocial" type="text" value="<?php echo get_siterazonSocial(); ?>">
								</div>

								<div class="form-group">
									<label for="siterfc">RFC</label>
									<input class="form-control" name="siterfc" id="siterfc" type="text" value="<?php echo get_siterfc(); ?>">
								</div>

								<div class="row">
									
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
											<label for="ciudad">Ciudad, delegación o municipio</label>
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
											<label for="cp">Código Postal</label>
											<input class="form-control" name="cp" id="cp" type="text" value="<?php echo get_siteaddress()->cp; ?>">
										</div>
									</div>
								</div>
							</div>

							<!-- segunda columna -->
							<div class="col-xl-6">
								<h6>Datos bancarios</h6>
								<p>
									Estos datos aparecerán en todos los documentos generados de forma dinámica, como cotizaciones, para que clientes y proveedores puedan saber a donde pagar
									si así lo desean, de lo contrario no aparecerán.
								</p>
								<br>
									
								<div class="form-group">
									<label for="bank_name">Banco</label>
									<input class="form-control" name="bank_name" id="bank_name" type="text" value="<?php echo get_bank_info()->name; ?>">
								</div>

								<div class="form-group">
									<label for="bank_number">Número de sucursal</label>
									<input class="form-control" name="bank_number" id="bank_number" type="text" value="<?php echo get_bank_info()->number; ?>">
								</div>

								<div class="form-group">
									<label for="bank_account_name">Títular</label>
									<input class="form-control" name="bank_account_name" id="bank_account_name" type="text" value="<?php echo get_bank_info()->account_name; ?>">
								</div>
									
								<div class="row">
									<div class="col-xl-6">
										<div class="form-group">
											<label for="bank_account_number">Número de cuenta</label>
											<input class="form-control" name="bank_account_number" id="bank_account_number" type="text" value="<?php echo get_bank_info()->account_number; ?>">
										</div>
									</div>

									<div class="col-xl-6">
										<div class="form-group">
											<label for="bank_clabe">CLABE Interbancaria</label>
											<input class="form-control" name="bank_clabe" id="bank_clabe" type="text" value="<?php echo get_bank_info()->clabe; ?>">
										</div>
									</div>
								</div>

								<h6>Notificaciones email</h6>
								<p>
								Selecciona la frecuencia en que los usuarios y administradores recibirán notificaciones automáticas de la plataforma.
								</p>
								<div class="form-group">
									<label for="cron_repeat_time">Frecuencia</label>
									<select name="cron_repeat_time" class="form-control select2-basic-single" id="cron_repeat_time" required>
									<?php foreach (get_frecuency() as $k => $v) : ?>
										<?php if (get_cron_repeat_time() == $k) : ?>
											<option value="<?php echo $k; ?>" selected><?php echo $v; ?></option>
										<?php else : ?>
											<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
										<?php endif; ?>
									<?php endforeach ?>
									</select>
								</div>

								<h6>Logotipo de la empresa</h6>
								<p>
								Selecciona el logotipo de tu empresa, será mostrado en la plataforma, documentos generados dinámicamente y correos electrónicos.
								</p>
								<small class="text-danger">Recomendamos el uso de imágenes con dimensiones similares a 560 px de ancho por 170 px de alto.</small>
								<div class="form-group">
									<label for="sitelogo">Selecciona un archivo</label>
									<input type="file" class="form-control" name="sitelogo" accept='image/*'>
								</div>

								<div class="row">
									<div class="col-xl-4 col-12">
										<div class="card">
											<img src="<?php echo get_sitelogo() ?>" alt="<?php echo get_sitename(); ?>" class="img-fluid card-img-top">
											<div class="card-body text-center">
												Logotipo actual
												<span class="text-muted d-block"><?php echo getimagesize(get_sitelogo())[0].' x '.getimagesize(get_sitelogo())[1] ?></span>
											</div>
										</div>
									</div>
								</div>
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