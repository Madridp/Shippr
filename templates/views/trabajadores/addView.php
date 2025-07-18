<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['direccion','Dirección general'],['trabajadores','Trabajadores'],['', $d->title]]) ?>
  <?php flasher() ?>
	
	<div class="row">
		<div class="offset-xl-2 col-xl-8 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Completa el formulario</h5>

          <form action="trabajadores/store" method="POST">
            <?php echo insert_inputs(); ?>
						
						<h6>Datos del trabajador</h6>
						<div class="form-group">
							<label for="">Nombre completo <?php echo bs_required(); ?></label>
							<input type="text" class="form-control" name="nombre" placeholder="Walter White" required>
						</div>

						<div class="form-group">
							<label for="">Usuario <?php echo bs_required(); ?></label>
							<input type="text" class="form-control" name="usuario" placeholder="walterwhite69" required>
						</div>

						<div class="form-group">
							<label for="">Email <?php echo bs_required(); ?></label>
							<input type="email" class="form-control" name="email" placeholder="walter@white.com" required>
						</div>

						<div class="form-group">
							<label for="">Generar contraseña <?php echo bs_required(); ?> <?php echo more_info('Selecciona Si para generar una contraseña segura de forma automática'); ?></label>
							<select name="auto_password" class="form-control select2-basic-single">
								<option value="si">Si</option>
								<option value="no">No</option>
							</select>
							<small class="text-muted">La contraseña escrita no será procesada.</small>
						</div>

						<div class="form-group">
							<label for="">Contraseña</label>
							<input type="password" class="form-control" name="password">
						</div>

						<div class="form-group">
							<label for="">Confirmar contraseña</label>
							<input type="password" class="form-control" name="conf_password">
            </div>
            <br>

						<input type="submit" class="btn btn-success" value="Agregar" name="submit">
						<input type="reset" class="btn btn-default" value="Cancelar" name="cancel">
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>