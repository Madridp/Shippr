<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['root','Root'],['',$d->title]]); ?>
	<?php flasher() ?>

	<div class="row">
		<div class="<?php echo bs_col([4,4,6,12,12]) ?>">
			<div class="row">
				<div class="<?php echo bs_col([12,12,12,12,12]) ?>">
					<div class="pvr-wrapper">
						<div class="pvr-box">
							<h5 class="pvr-header">Opciones de reinicio</h5>
							<button type="submit" class="btn btn-success do_restart_database"><i class="fas fa-database fa-fw"></i> Base de datos</button>
							<button type="submit" class="btn btn-info do_restart_opciones"><i class="fas fa-sync fa-fw"></i> Opciones</button>
							<button type="submit" class="btn btn-danger do_restart_system"><i class="fas fa-server fa-fw"></i> Reiniciar todo</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>