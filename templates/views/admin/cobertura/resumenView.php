<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['admin','Administración'],['',$d->title]]) ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<?php if ($d->coverturas): ?>
						<table class="table table-striped table-sm table-hover vmiddle" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th>CP</th>
									<th class="text-center">Courier</th>
									<th class="text-center">Recolección</th>
									<th class="text-center">ZE <?php echo more_info('Zona Extendida'); ?></th>
									<th class="text-center">Cargo</th>
								</tr>
							</thead>
							<tbody>
									<?php foreach ($d->coverturas as $r): ?>
										<tr>
											<td><?php echo $r->cp; ?></td>
											<td class="text-center"><?php echo $r->id_courier; ?></td>
											<td class="text-center"><?php echo $r->recoleccion == 1 ? 'Si' : 'No'; ?></td>
											<td class="text-center"><?php echo $r->zona_extendida == 1 ? 'Si' : 'No'; ?></td>
											<td class="text-center"><?php echo money($r->cargo); ?></td>
										</tr>
									<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_empty_orders.svg'; ?>" alt="No hay registros" style="width: 300px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay coberturas actualizadas</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>