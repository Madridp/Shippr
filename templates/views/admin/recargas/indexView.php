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
					<?php if ($d->recargas): ?>
						<table class="table table-striped table-sm table-hover vmiddle" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th>Número</th>
									<th class="text-center">Referencia</th>
									<th class="text-center">Usuario</th>
									<th class="text-center">Monto</th>
									<th class="text-center">Estado</th>
									<th class="text-center">Fecha</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
									<?php foreach ($d->recargas as $r): ?>
										<tr>
											<td><?php echo $r->numero; ?></td>
											<td class="text-center"><?php echo $r->referencia; ?></td>
											<td class="text-center"><?php echo not_empty($r->u_nombre); ?></td>
											<td class="text-center"><?php echo money($r->total) ?></td>
											<td class="text-center"><?php echo format_payment_status_pill($r->status); ?></td>
											<td class="text-center"><?php echo fecha($r->creado); ?></td>
											<td class="text-right">
												<button class="btn btn-sm btn-light" id="<?php echo 'r-'.$r->id; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r-'.$r->id; ?>">
													<?php if (!in_array($r->status, ['abonado', 'cancelado', 'pagado', 'devuelto','rechazado'])): ?>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/recarga-aprobar/'.$r->id, ['hash' => $r->hash]); ?>"><i class="fas fa-check"></i> Aprobar</a>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/recarga-rechazar/'.$r->id, ['hash' => $r->hash]); ?>"><i class="fas fa-times"></i> Rechazar</a>
													<?php endif; ?>
													<a class="dropdown-item" href="<?php echo buildURL('admin/recarga-editar/'.$r->id, []); ?>"><i class="fas fa-edit"></i> Editar</a>
													<a class="dropdown-item" href="<?php echo 'admin/recarga/'.$r->id ?>"><i class="fa fa-eye"></i> Ver</a>
													<?php if (in_array($r->status, ['cancelado'])): ?>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/recarga-borrar/'.$r->id, []); ?>"><i class="fas fa-trash"></i> Borrar</a>
													<?php endif; ?>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_empty_orders.svg'; ?>" alt="No hay registros" style="width: 300px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay recargas registradas aún</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>