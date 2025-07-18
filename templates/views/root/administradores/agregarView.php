<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['root','Root'],['', $d->title]]) ?>
  <?php flasher() ?>
	
	<div class="row">
		<div class="offset-xl-3 col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Completa el formulario</h5>

          <form action="root/post_administradores" method="POST" <?php $form = FormHandler::create('agregar_administrador'); ?>>
            <?php echo insert_inputs(); ?>
						
						<h6>Datos del administrador</h6>
						<div class="form-group">
							<label for="">Nombre completo <?php echo bs_required(); ?></label>
							<input type="text" class="form-control" name="nombre" placeholder="Walter White" value="<?php echo $form->get_field('nombre'); ?>" required>
						</div>

						<div class="form-group">
							<label for="">Usuario <?php echo bs_required(); ?></label>
							<input type="text" class="form-control" name="usuario" placeholder="walterwhite69" value="<?php echo $form->get_field('usuario'); ?>" required>
						</div>

						<div class="form-group">
							<label for="">Email <?php echo bs_required(); ?></label>
							<input type="email" class="form-control" name="email" placeholder="walter@white.com" value="<?php echo $form->get_field('email'); ?>" required>
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