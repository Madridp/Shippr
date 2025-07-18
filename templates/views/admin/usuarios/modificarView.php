<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['admin','Administración'],['admin/usuarios_index','Usuarios'], ['admin/usuarios_ver/'.$d->usuario->id_usuario, 'Ver'], ['','Editando '.$d->usuario->nombre]]) ?>
	
	<?php flasher() ?>
	
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Completa el formulario</h5>

					<form action="admin/usuarios_modificar_submit" method="POST">
						<input type="hidden" name="id_usuario" value="<?php echo $d->usuario->id_usuario; ?>">
						<?php echo insert_inputs(); ?>

						<h6>Datos del usuario</h6>
						<div class="form-group">
							<label for="">Nombre completo</label>
							<input type="text" class="form-control" name="nombre" value="<?php echo $d->usuario->nombre ?>" required>
						</div>

						<div class="form-group">
							<label for="">Usuario</label>
							<input type="text" class="form-control" name="usuario" value="<?php echo $d->usuario->usuario ?>" required>
						</div>

						<div class="form-group">
							<label for="">E-mail</label>
              <input type="email" class="form-control" name="email" value="<?php echo $d->usuario->email ?>" required>
						</div>

						<div class="form-group">
							<label for="">Generar nueva contraseña</label>
							<select name="auto_password" class="form-control select2-basic-single">
								<option value="si">Si</option>
								<option value="no" selected>No</option>
							</select>
							<small class="text-muted">La contraseña será generada y enviada al usuario.</small>
						</div>
						<hr>

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