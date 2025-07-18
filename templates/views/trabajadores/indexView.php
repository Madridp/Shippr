<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['direccion','Dirección general'],['', $d->title]]) ?>
	
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?>
						<div class="button-group float-right">
							<?php if(!reached_workers_limit()): ?>
								<a href="trabajadores/agregar" class="btn btn-success"><i class="fas fa-plus"></i> Agregar trabajador</a>
							<?php else: ?>
								<small class="text-muted">Haz alcanzado el límite de trabajadores disponibles en tu plan.</small>
							<?php endif; ?>
						</div>
					</h5>
					<p><?php echo sprintf('Tienes disponibilidad de <b>%s</b> lugares para trabajadores en tu plan.', get_workers_limit()) ?></p>
					<?php echo $d->table; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>