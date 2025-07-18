<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['', $d->title]]) ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<?php if ($d->e): ?>
						<table class="table table-striped table-borderless table-hover" id="data-table" style="width: 100% !important;">
							<thead class="thead-dark">
								<tr>
									<th class="text-center">Carrier</th>
									<th class="text-left">Información</th>
									<th class="text-center">Rastreo</th>
									<th class="text-center">Estado</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
									<?php foreach ($d->e as $e): ?>
										<tr>
											<td class="text-center align-middle" width="10%">
												<img class="img-thumbnail img-fluid" src="<?php echo is_file(COURIERS.$e->imagenes) ? URL.COURIERS.$e->imagenes : URL.IMG.'no-carrier.jpg'; ?>" alt="<?php echo $e->titulo; ?>" style="border-radius: 50%; width: 80px;">
											</td>
											
											<td class="align-middle">
												<small class="float-right"><a href="<?php echo 'compras/ver/'.$e->venta_folio ?>"><?php echo 'Compra #'.$e->venta_folio; ?></a></small>
												
												<?php if (get_envio_referencia($e)): ?>
													<small class="text-muted d-block">Referencia de compra</small>
													<span class="text-danger"><?php echo get_envio_referencia($e) ?></span>
												<?php endif; ?>

												<small class="text-muted d-block">Carrier y tipo de servicio</small>
												<?php echo $e->titulo; ?>
												<small class="text-muted d-block"><?php echo get_single_shipment_address($e); ?></small>

												<?php if (!empty($e->adjunto)): ?>
													<?php if (is_file(UPLOADS.$e->adjunto)): ?>
														<a class="btn btn-sm btn-info text-white mt-1" href="<?php echo buildURL('envios/print-label/'.$e->id,['label' => $e->adjunto,'nonce' => randomPassword(20,'numeric')]); ?>" tile="Descargar etiqueta"><i class="fa fa-download"></i><?php echo sprintf('%s etiqueta',($e->descargado ? 'Volver a descargar':'Descargar')); ?></a>
													<?php else: ?>
														<button class="btn btn-danger btn-sm" disabled><i class="fa fa-chain-broken"></i> Archivo dañado</button>
													<?php endif; ?>
												<?php endif; ?>
											</td>
											
											<td class="text-center align-middle">
												<?php if (get_tracking_link($e->slug, $e->num_guia)): ?>
													<a href="<?php echo get_tracking_link($e->slug, $e->num_guia) ?>" target="_blank"><?php echo $e->num_guia; ?></a>
												<?php else: ?>
													<span class="text-muted">No asignado aún</span>
												<?php endif; ?>
											</td>

											<td class="text-center align-middle" width="10%">
												<img src="<?php echo get_tracking_image($e->status); ?>" class="img-fluid" alt="<?php echo get_tracking_status($e->status); ?>" <?php echo tooltip(get_tracking_status($e->status)) ?> style="width: 40px;">
											</td>
											
											<td class="text-right align-middle">
												<?php if ((int) $e->con_sobrepeso == 1): ?>
													<a class="btn btn-danger text-white" <?php echo tooltip('Sobrepeso generado') ?> href="<?php echo 'envios/ver/'.$e->id ?>"><i class="fas fa-balance-scale "></i></a>
												<?php endif; ?>
												<div class="btn-group" role="group">
													<a class="btn btn-primary text-white" href="<?php echo 'envios/ver/'.$e->id ?>"><i class="fa fa-eye"></i></a>
													<?php if (get_aftership_key() !== null): ?>
														<button class="btn btn-primary text-white do-track-shipment" data-id="<?php echo $e->id; ?>" <?php echo tooltip('Rastrear envío') ?>><i class="fas fa-map-marker-alt"></i></button>
													<?php endif; ?>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
							</tbody>
						</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto" src="<?php echo URL.IMG.'undraw_empty_shipments.svg' ?>" alt="No hay registros" style="width: 300px;">
							<a href="carrito/nuevo" class="btn btn-success btn-lg text-white mt-5">Agregar un envío</a>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>