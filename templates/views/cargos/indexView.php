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
					<?php if ($d->cargos): ?>
						<table class="table table-striped table-hover vmiddle" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th>Número</th>
									<th class="text-center">Tipo</th>
									<th class="text-center">Usuario</th>
									<th class="text-center">Monto</th>
									<th class="text-center">Estado</th>
									<th class="text-right">Fecha</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
									<?php foreach ($d->cargos as $t): ?>
										<tr>
											<td><?php echo $t->numero; ?></td>
											<td class="text-center"><?php echo format_trans_tipo($t->tipo); ?></td>
											<td class="text-center"><?php echo not_empty($t->u_nombre); ?></td>
											<td class="text-center"><?php echo money($t->total) ?></td>
											<td class="text-center"><?php echo format_payment_status_pill($t->status); ?></td>
											<td class="text-right"><?php echo fecha($t->creado); ?></td>
											<td class="text-right">
                        <?php if (!in_array($t->status, ['pagado'])): ?>
                          <button class="btn btn-sm btn-light" id="<?php echo 'r-'.$t->id; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r-'.$t->id; ?>">
                            <?php if (!in_array($t->status, ['cancelado','pagado','devuelto','rechazado'])): ?>
                              <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('cargos/cobrar/'.$t->id); ?>"><i class="fas fa-file-invoice-dollar"></i> Cobrar</a>
                            <?php endif; ?>
                            <?php if (in_array($t->status, ['cancelado'])): ?>
                              <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('cargos/borrar/'.$t->id); ?>"><i class="fas fa-trash"></i> Borrar</a>
                            <?php endif; ?>
                          </div>
                        <?php endif; ?>
											</td>
										</tr>
									<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_empty_orders.svg'; ?>" alt="No hay registros" style="width: 300px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay cargos registrados aún</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>