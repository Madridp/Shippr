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
					<?php if ($d->v): ?>
						<table class="table table-striped table-sm table-hover v-middle" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th>Folio</th>
									<th class="text-left">Información</th>
									<th class="text-center">Estado de compra</th>
									<th class="text-center">Estado del pago</th>
									<th class="text-center">Subtotal</th>
									<th class="text-center">Comisiones</th>
									<th class="text-center">Total</th>
									<th class="text-right">Fecha</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($d->v as $v): ?>
									<tr>
										<td><?php echo sprintf('<a href="%s">#%s</a>', 'admin/ventas-ver/'.$v->folio, $v->folio); ?></td>
										<td>
											<small class="text-muted float-right"><?php echo sprintf('Tiene %s envíos', $v->envios); ?></small>
											<?php echo $v->nombre.' ('.$v->usuario.')'; ?>
										</td>
										<td class="text-center">
											<?php echo get_venta_status_boton($v->status) ?>
										</td>
										<td class="text-center">
											<?php echo format_payment_status_pill($v->pago_status) ?>
										</td>
										<td class="text-center">
											<?php echo money($v->subtotal,'$') ?>
										</td>
										<td class="text-center">
											<?php echo money($v->comision,'$') ?>
										</td>
										<td class="text-center">
											<?php echo money($v->total,'$') ?>
										</td>
										<td class="text-right"><?php echo fecha($v->creado); ?></td>
										<td class="text-right">
											<div class="btn-group" role="group">
												<!-- <button class="btn btn-primary btn-sm do-open-edit-venta-modal" data-folio="<?php echo $v->folio; ?>"><i class="fas fa-edit"></i></button> -->
												<a class="btn btn-sm  btn-primary text-white" href="<?php echo 'admin/ventas-ver/'.$v->folio ?>"><i class="fa fa-eye"></i></a>
												<button id="<?php echo 'r'.$v->id ?>" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r'.$v->id ?>">
													<a class="dropdown-item" href="<?php echo 'admin/ventas-actualizar/'.$v->folio ?>"><i class="fa fa-edit"></i> Editar</a>
													<?php if (in_array($v->status, ['pendiente'])): ?>
														<small class="dropdown-header">Estado</small>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-cambiar-status/'.$v->id,['status' => 'en-proceso']); ?>"><i class="fas fa-forward"></i> En proceso</a>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-cambiar-status/'.$v->id,['status' => 'cancelada']); ?>"><i class="fas fa-undo"></i> Cancelada</a>
													<?php elseif($v->status === 'en-proceso'): ?>
														<small class="dropdown-header">Estado</small>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-cambiar-status/'.$v->id,['status' => 'completada']); ?>"><i class="fas fa-check"></i> Completada</a>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-cambiar-status/'.$v->id,['status' => 'cancelada']); ?>"><i class="fas fa-undo"></i> Cancelada</a>
													<?php elseif($v->status === 'pendiente'): ?>
														<small class="dropdown-header">Estado</small>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-cambiar-status/'.$v->id,['status' => 'en-proceso']); ?>"><i class="fas fa-forward"></i> En proceso</a>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-cambiar-status/'.$v->id,['status' => 'completada']); ?>"><i class="fas fa-check"></i> Completada</a>
													<?php elseif($v->status === 'completada'): ?>
													<?php endif; ?>

													<?php if ($v->status === 'cancelada' && $v->pago_status === 'devuelto'): ?>
														<div class="dropdown-divider"></div>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/ventas-borrar/'.$v->id, ['nonce' => randomPassword(20)]); ?>"><i class="fas fa-trash"></i> Borrar</a>
													<?php endif; ?>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img src="<?php echo URL.IMG.'es-nosales.svg'; ?>" alt="No hay registros" class="img-fluid" style="width: 200px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay ventas registradas aún</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>