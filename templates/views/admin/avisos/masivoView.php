<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['admin','Administración'], ['',$d->title]]) ?>
	
	<?php flasher(); ?>

	<div class="row">
		<!-- New email screen editor -->
		<div class="col-xl-8 col-lg-8 col-md-12 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<p>Completa el formulario para enviar un mensaje masivo a todos tus usuarios registrados.</p>
					
					<form action="admin/enviar-aviso-masivo" method="POST" enctype="multipart/form-data"
					onsubmit="return confirm('¿Estás seguro?');">
						<?php echo insert_inputs(); ?>
						<div class="form-group">
							<label for="asunto"><small>Asunto</small></label>
							<input type="text" class="form-control form-control-sm" id="asunto" name="subject">
						</div>

						<!-- Cuerpo del mensaje -->
						<div class="form-group">
							<label for="asunto"><small>Mensaje</small></label>
							<textarea class="form-control" name="body" rows="10" id="summernote"></textarea>
						</div>

						<div class="form-group">
							<label for=""><small>Adjuntar archivos:</small></label>
							<input type="file" class="text-truncate form-control" name="adjuntos[]" multiple>
						</div>
						
						<div class="form-group">	
							<button type="submit" class="btn btn-success">Enviar mensaje</button>
							<button type="reset" class="btn btn-danger float-right">Descartar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES . 'footer.php' ?>