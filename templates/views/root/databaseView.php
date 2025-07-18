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

          <form action="root/post_database" method="POST">
            <?php echo insert_inputs(); ?>

            <div class="form-group">
              <?php if ($d->exists): ?>
                <p>Archivo de migración encontrado:</p>
                <span class="badge badge-success"><i class="fas fa-file"></i> <?php echo $d->migration; ?></span>
              <?php else: ?>
                <span class="badge badge-danger"><i class="fas fa-file"></i> No hay actualizaciones para la base de datos</span>
              <?php endif; ?>
            </div>
						
            <button type="submit" class="btn btn-success btn_requires_confirmation" <?php echo $d->exists ? null : 'disabled' ?>>Actualizar base de datos</button>
            <button type="reset" class="btn btn-light">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>