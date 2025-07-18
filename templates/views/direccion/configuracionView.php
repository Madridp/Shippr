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

					<form action="direccion/configuracion_store" method="POST" enctype="multipart/form-data">
						<?php echo insert_inputs(); ?>

						<h6><?php echo $d->title; ?></h6>
						<p>Para que la plataforma funcione correctamente es necesario llenar estos campos.</p>
						<div class="form-group">
							<label for="sitename">Nombre de la empresa <?php echo more_info('Es el nombre que aparecerá en la plataforma, correos y notificaciones') ?></label>
							<input class="form-control" name="sitename" id="sitename" type="text" value="<?php echo get_sitename(); ?>" required>
						</div>

						<div class="form-group">
							<label>Eslogan <?php echo more_info(sprintf('Es opcional, utilizado para mejorar el SEO de tu instancia de %s en los buscadores', get_system_name())) ?></label>
							<input class="form-control" name="siteslogan" id="siteslogan" type="text" value="<?php echo get_siteslogan(); ?>" required>
						</div>

						<div class="form-group">
							<label for="siteph">Teléfono <?php echo more_info(sprintf('Aparecerá en la información de contacto de %s', get_system_name())) ?></label>
							<input class="form-control" name="siteph" id="siteph" type="text" value="<?php echo get_siteph() ?>" required>
						</div>

						<div class="form-group">
							<label for="time_zone">Zona horaria <?php echo more_info('Es la zona horario en la cual tu empresa funciona, depende de tu ubicación en el mundo y afecta las fechas registradas') ?></label>
							<select name="time_zone" class="form-control select2-basic-single" id="time_zone" required>
							<?php foreach ($d->timezones as $t) : ?>
								<?php if (get_timezone() == $t->value): ?>
									<option value="<?php echo $t->value; ?>" selected><?php echo $t->name; ?></option>
								<?php else: ?>
									<option value="<?php echo $t->value; ?>"><?php echo $t->name; ?></option>
								<?php endif; ?>
							<?php endforeach ?>
							</select>
						</div>
						<br>

						<h6>Logotipo de la empresa</h6>
						<p>Selecciona el logotipo de tu empresa, será mostrado en la plataforma, documentos generados dinámicamente y correos electrónicos.</p>
						<div class="form-group">
							<img src="<?php echo get_sitelogo() ?>" alt="<?php echo get_sitename(); ?>" class="d-inline img-mini-60">
							<span class="d-inline w-500">
								<small class="text-muted"><?php echo '('.get_sitelogo_filename().') '.getimagesize(get_sitelogo())[0].' x '.getimagesize(get_sitelogo())[1] ?></small>
							</span>
						</div>
						<div class="form-group">
							<label for="sitelogo">Selecciona un archivo</label>
							<input type="file" class="form-control" name="sitelogo" accept='image/*'>
							<small class="text-danger">Recomendamos el uso de imágenes con dimensiones similares a 560 px de ancho por 170 px de alto.</small>
						</div>
						<br>

            <h6>MercadoPago</h6>
            <p>Al activar esta casilla MercadoPago trabajará en modo de pruebas o Sandbox, sin aceptar pagos de forma real.</p>
            <div class="form-group">
              <!-- Rounded switch -->
							<label>Sandbox MercadoPago</label>
							<div class="custom-slider">
								<label class="switch m-0">
									<input type="checkbox" name="mp_sandbox" id="mp_sandbox" <?php echo (get_mp_sandbox() ? 'checked' : '') ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<br>
						
						<h6>Preguntas frecuentes</h6>
						<p>Aquí puedes agregar información que tus usuarios solicitan de forma frecuente.</p>
						<div class="form-group">
							<textarea class="form-control" name="faq" rows="10" id="summernote"><?php echo get_option('faq') ?></textarea>
							<small class="text-muted"><?php echo sprintf('Última actualización: %s', get_faq_date()); ?></small>
						</div>
						<br>

						<h6>Estado del sistema <?php echo more_info('Activa esta opción para aceptar nuevas ventas') ?></h6>
						<div class="form-group">
							<!-- Rounded switch -->
							<label form="site_status">Aceptando nuevas ventas o pedidos</label>
							<div class="custom-slider">
								<label class="switch m-0">
									<input type="checkbox" name="site_status" id="site_status" <?php echo (get_system_status() ? 'checked' : '') ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<br>

						<h6>Activar coberturas personalizadas <?php echo more_info('Activa esta opción para especificar la cobertura de cada courier de forma manual usando una plantilla CSV') ?></h6>
						<div class="form-group">
							<!-- Rounded switch -->
							<label form="site_custom_zones">Cobertura personalizada</label>
							<div class="custom-slider">
								<label class="switch m-0">
									<input type="checkbox" name="site_custom_zones" id="site_custom_zones" <?php echo (get_custom_zones() ? 'checked' : '') ?>>
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<br>

						<h6>Integración con Aftership</h6>
						<div class="form-group">
              <label for="aftership_api_key">Pega tu API Key</label>
              <input type="text" class="form-control" name="aftership_api_key" id="aftership_api_key" placeholder="asd123-12314-bocAECmaose-28318209" value="<?php echo get_option('aftership_api_key') ?>">
							<small class="text-muted">¿Qué es <a href="direccion/aftership">Aftership</a>?</small>
            </div>
						<br>

						<h6>Horarios laborales <?php echo more_info(sprintf('Le informaremos a tus usuarios si %s está en servicio actualmente', get_sitename())); ?></h6>
						<div class="form-group row">
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label form="site_lv_opening">Hora de apertura lunes a viernes</label>
								<select name="site_lv_opening" id="site_lv_opening" class="form-control">
									<?php foreach (get_hours_list() as $hour): ?>
										<option value="<?php echo $hour[0]; ?>" <?php echo get_option('site_lv_opening') == $hour[0] ? 'selected' : ''; ?>><?php echo $hour[1]; ?></option>
									<?php endforeach; ?>
								</select>
								<small class="text-muted">Utiliza formato de 24 horas.</small>
							</div>
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label form="site_lv_closing">Hora de cierre lunes a viernes</label>
								<select name="site_lv_closing" id="site_lv_closing" class="form-control">
									<?php foreach (get_hours_list() as $hour): ?>
										<option value="<?php echo $hour[0]; ?>" <?php echo get_option('site_lv_closing') == $hour[0] ? 'selected' : ''; ?>><?php echo $hour[1]; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label form="site_sat_opening">Hora de apertura sábados</label>
								<select name="site_sat_opening" id="site_sat_opening" class="form-control">
									<?php foreach (get_hours_list() as $hour): ?>
										<option value="<?php echo $hour[0]; ?>" <?php echo get_option('site_sat_opening') == $hour[0] ? 'selected' : ''; ?>><?php echo $hour[1]; ?></option>
									<?php endforeach; ?>
								</select>
								<small class="text-muted">Utiliza formato de 24 horas.</small>
							</div>
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label form="site_sat_closing">Hora de cierre sábados</label>
								<select name="site_sat_closing" id="site_sat_closing" class="form-control">
									<?php foreach (get_hours_list() as $hour): ?>
										<option value="<?php echo $hour[0]; ?>" <?php echo get_option('site_sat_closing') == $hour[0] ? 'selected' : ''; ?>><?php echo $hour[1]; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label form="site_sun_opening">Hora de apertura domingos <?php echo more_info('Si no laboran en días domingo, debes dejar este campo vacío') ?></label>
								<select name="site_sun_opening" id="site_sun_opening" class="form-control">
									<?php foreach (get_hours_list() as $hour): ?>
										<option value="<?php echo $hour[0]; ?>" <?php echo get_option('site_sun_opening') == $hour[0] ? 'selected' : ''; ?>><?php echo $hour[1]; ?></option>
									<?php endforeach; ?>
								</select>
								<small class="text-muted">Utiliza formato de 24 horas.</small>
							</div>
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label form="site_sun_closing">Hora de cierre domingos</label>
								<select name="site_sun_closing" id="site_sun_closing" class="form-control">
									<?php foreach (get_hours_list() as $hour): ?>
										<option value="<?php echo $hour[0]; ?>" <?php echo get_option('site_sun_closing') == $hour[0] ? 'selected' : ''; ?>><?php echo $hour[1]; ?></option>
									<?php endforeach; ?>
								</select>
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