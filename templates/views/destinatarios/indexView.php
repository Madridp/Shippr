<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['','Todos los destinatarios']]) ?>
	
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">
						Destinatarios
					</h5>
					<?php if ($d->dest): ?>
					<table class="table table-bordered table-hover" id="data-table" style="width: 100% !important;">
						<thead>
							<tr>
								<th>Destinatario</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
								<?php foreach ($d->dest as $d): ?>
									<tr>
                    <td>
											<small class="text-muted d-block">Dirección</small>
                      <?php echo build_address($d); ?>
											<small><a href="http://maps.google.com/?q=<?php echo urlencode(build_address($d)) ?>" 
											target="_blank" ><i class="fa fa-map-marker"></i>Ver en mapa</a></small>

											<small class="text-muted d-block">Contacto</small>
											<?php echo $d->nombre; ?>
											<?php if (!empty($d->email)): ?>
												<small class="text-muted d-block"><a href="<?php echo 'mailto:'.$d->email ?>"><?php echo $d->email ?></a></small>
											<?php endif; ?>
											<?php if (!empty($d->telefono)): ?>
												<small class="text-muted d-block"><?php echo 'Tel. '.$d->telefono ?></small>
											<?php endif; ?>
                    </td>
										<td>
											<div class="btn-group" role="group">
												<a class="btn btn-sm  btn-primary text-white" href="http://maps.google.com/?q=<?php echo urlencode(build_address($d)); ?>"><i class="fa fa-eye"></i></a>
												<button id="servicio-<?php echo $d->id ?>" type="button" class="btn btn-sm  btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
												<div class="dropdown-menu" aria-labelledby="destinatario-<?php echo $d->id; ?>">
													<small class="dropdown-header">Destinatario</small>
                          <a class="dropdown-item" 
                          href="<?php echo buildURL('destinatario/editar/'.$d->id) ?>"><i class="fa fa-edit mr-1"></i>Editar</a>
                          <a class="dropdown-item confirmacion-requerida" 
                          href="<?php echo buildURL('destinatario/borrar/'.$d->id)?>"><i class="fa fa-trash mr-1"></i>Borrar</a>
												</div>
											</div>
										</td>
									</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
					<?php else : ?>
					<div class="text-center py-5">
            <img src="<?php echo IMG . 'es-services.svg'; ?>" alt="No hay registros" class="img-fluid" style="width: 150px;">
            <h4 class="mt-3 mb-2"><b>Upps... no hay destinatarios registrados aún</b></h4>
            <p class="text-muted">Comienza agregando tu primer destinatario</p>
            <a href="destinatario/agregar" class="btn btn-primary text-white">Agregar un destinatario</a>
          </div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>