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
					<h5 class="pvr-header">
						<button id="envios-sync-to-aftership" class="btn btn-primary btn-sm float-right" <?php echo tooltip('Sincronizar con AfterShip') ?>><i class="fa fa-refresh"></i></button>
						<?php echo $d->title; ?>
					</h5>
					<?php if ($d->e): ?>
					<table class="table table-striped table-hover" id="data-table" style="width: 100% !important;">
						<thead class="thead-dark">
							<tr>
								<th class="text-left">Información</th>
								<th class="text-left">Remitente y destino</th>
								<th class="text-center">Paquete</th>
								<th class="text-center">Rastreo</th>
								<th class="text-center">Estado</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
								<?php foreach ($d->e as $e): ?>
								<tr>
									<td class="align-middle" width="20%">
										<?php if ($e->venta_status == 'cancelada'): ?>
											<small class="float-right text-danger">Cancelada</small>
										<?php else: ?>
											<small class="float-right" <?php echo tooltip($e->venta_status) ?>><a href="<?php echo 'admin/ventas-ver/'.$e->venta_folio ?>"><?php echo '#'.$e->venta_folio; ?></a></small>
										<?php endif; ?>
										
										<small class="text-muted d-block">Courier y tipo de servicio</small>
										<?php echo $e->titulo; ?>
										
										<small class="text-muted d-block">Usuario</small>
										<span class="d-block"><?php echo $e->u_nombre; ?></span>
										<a href="<?php echo 'mailto:'.$e->u_email; ?>"><?php echo $e->u_email; ?></a>
									</td>
									<td class="text-left align-middle">
										<small class="text-muted"><?php echo get_single_shipment_address($e); ?></small>
									</td>
									<td class="text-center align-middle">
										<?php echo $e->descripcion ?>
										<small class="text-muted d-block">Medidas</small>
										<?php echo $e->paq_alto.'x'.$e->paq_ancho.'x'.$e->paq_largo ?>
									</td>
									<td class="text-center align-middle">
										<?php if (get_tracking_link($e->slug, $e->num_guia)): ?>
											<a href="<?php echo get_tracking_link($e->slug, $e->num_guia); ?>" target="_blank"><?php echo $e->num_guia ?></a>
										<?php else: ?>
											<span class="text-muted">No asignado aún</span>
										<?php endif; ?>
									</td>
									<td class="text-center align-middle">
										<img src="<?php echo get_tracking_image($e->status); ?>" class="img-fluid" alt="<?php echo get_tracking_status($e->status); ?>" <?php echo tooltip(get_tracking_status($e->status)) ?> style="width: 40px;">
									</td>
									<td class="text-right align-middle">
										<?php if ($e->venta_status !== 'cancelada'): ?>
											<?php if ((int) $e->con_sobrepeso == 1): ?>
												<?php if ($e->t_status === 'pagado'): ?>
													<a class="btn btn-sm btn-success" <?php echo tooltip('Sobrepeso pagado') ?> href="<?php echo 'admin/envios-ver/'.$e->id ?>"><i class="fas fa-balance-scale "></i></a>
												<?php elseif($e->t_status === 'pendiente'): ?>
													<a class="btn btn-sm btn-danger" <?php echo tooltip('Sobrepeso generado') ?> href="<?php echo 'admin/envios-ver/'.$e->id ?>"><i class="fas fa-balance-scale "></i></a>
												<?php endif; ?>
											<?php endif; ?>
											<div class="btn-group dropleft" role="group">
												<?php if (intval($e->solicitado) == 1): ?>
													<button class="btn btn-success btn-sm" <?php echo tooltip('Etiqueta solicitada') ?>><i class="fa fa-vcard"></i></button>
												<?php endif; ?>
												<?php if (is_file(UPLOADS.$e->adjunto)): ?>
													<button class="btn btn-success btn-sm" <?php echo tooltip('Etiqueta lista') ?>><i class="fa fa-check"></i></button>
												<?php endif; ?>
												<?php if (intval($e->descargado) == 1): ?>
													<button class="btn btn-success btn-sm" <?php echo tooltip('Etiqueta descargada por usuario') ?>><i class="fa fa-download"></i></button>
												<?php endif; ?>
												<?php if (get_aftership_key() !== null): ?>
													<button class="btn btn-sm btn-primary text-white do-track-shipment" data-id="<?php echo $e->id; ?>" <?php echo tooltip('Rastrear envío') ?>><i class="fas fa-map-marker-alt"></i></button>
												<?php endif; ?>
												<a class="btn btn-sm  btn-primary text-white" href="<?php echo 'admin/envios-ver/'.$e->id ?>"><i class="fa fa-eye"></i></a>
												<button id="<?php echo 'r-'.$e->id ?>" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r-'.$e->id ?>">
													<a class="dropdown-item" href="<?php echo 'admin/envios-actualizar/'.$e->id ?>"><i class="fa fa-edit"></i> Editar</a>
													<?php if (!is_file(UPLOADS.$e->adjunto)): ?>
														<small class="dropdown-header">Documento</small>
														<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/envios-solicitar-generacion/'.$e->id) ?>"><i class="fa fa-envelope"></i> Solicitar generación</a>
													<?php endif; ?>
													<small class="dropdown-header">Estado de envío</small>
													<a class="dropdown-item confirmacion-requerida" 
													href="<?php echo buildURL('admin/envios-cambiar-status/'.$e->id, ['status' => 'InTransit']); ?>"><i class="fa fa-archive"></i> Recolectado</a>
													<a class="dropdown-item confirmacion-requerida" 
													href="<?php echo buildURL('admin/envios-cambiar-status/'.$e->id, ['status' => 'OutForDelivery']); ?>"><i class="fa fa-truck"></i> Ruta de entrega</a>
													<a class="dropdown-item confirmacion-requerida" 
													href="<?php echo buildURL('admin/envios-cambiar-status/'.$e->id, ['status' => 'Delivered']); ?>"><i class="fa fa-check"></i> Entregado</a>
												</div>
											</div>
										<?php endif; ?>
									</td>
								</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img src="<?php echo URL.IMG.'es-envios.svg'; ?>" alt="No hay registros" class="img-fluid" style="width: 200px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay envíos registrados aún</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>