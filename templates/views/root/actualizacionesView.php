<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['root','Root'],['',$d->title]]); ?>

	<?php flasher() ?>

	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="row">
				<div class="col-12">
					<div class="pvr-wrapper">
						<div class="pvr-box horizontal-form">
							<h5 class="pvr-header">Agregar actualización</h5>

							<form action="root/update_store" method="POST" enctype="multipart/form-data">
								<?php echo insert_inputs(); ?>
								<div class="form-group row">
									<div class="col-6">
										<label for="version">Versión de actualización <span class="text-danger">*</span></label>
										<input type="text" class="form-control" name="version" id="version" required>
									</div>
									<div class="col-6">
										<label for="filename">Archivo zip <span class="text-danger">*</span></label>
										<input type="file" class="form-control form-control-file" name="filename" id="filename" accept=".zip" required>
									</div>
								</div>
								<div class="form-group">
									<label>Disponible para descargar <span class="text-danger">*</span></label>
									<div class="onoffswitch">
										<input type="checkbox" name="disponible" value="on" class="onoffswitch-checkbox" id="disponible">
										<label class="onoffswitch-label" for="disponible">
												<span class="onoffswitch-inner"></span>
												<span class="onoffswitch-switch"></span>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label>Fecha de lanzamiento <span class="text-danger">*</span></label>
									<input type="date" class="form-control" name="fecha_lanzamiento" id="fecha_lanzamiento" value="<?php echo date('Y-m-d') ?>" required>
								</div>
								<br>
								
								<button type="submit" class="btn btn-success">Agregar actualización</button>
								<button type="reset" class="btn btn-default">Cancelar</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-12">
					<div class="pvr-wrapper">
						<div class="pvr-box">
						<h5 class="pvr-header">Actualizaciones</h5>
						<?php if ($d->updates): ?>
						<table class="table table-hover table-sm table-striped vmiddle" id="data-table">
							<thead>
								<tr>
									<th>Versión</th>
									<th class="text-center">Estado</th>
									<th class="text-right">Fecha de lanzamiento</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($d->updates as $u): ?>
								<tr>
									<td><?php echo $u->version; ?></td>
									<td class="text-center"><?php echo $u->disponible ? '<span class="text-success"><i class="fas fa-check"></i></span>' : '<span class="text-danger"><i class="fas fa-times"></i></span>' ?></td>
									<td class="text-right"><?php echo fecha($u->fecha_lanzamiento); ?></td>
									<td class="text-right align-middle">
										<div class="btn-group" role="group">
											<a class="btn btn-sm  btn-primary text-white" href="<?php echo 'root/ver-actualizacion/'.$u->id ?>"><i class="fa fa-eye"></i></a>
											<button id="<?php echo 'r-'.$u->id ?>" type="button" class="btn btn-sm  btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
											<div class="dropdown-menu" aria-labelledby="<?php echo 'r-'.$u->id; ?>">
												<?php if ((int) $u->disponible === 1): ?>
													<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('root/desactivar-actualizacion/'.$u->token); ?>"><i class="fas fa-times mr-1"></i>Desactivar</a>
												<?php elseif ((int) $u->disponible === 0): ?>
													<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('root/activar-actualizacion/'.$u->token); ?>"><i class="fas fa-check mr-1"></i>Activar</a>
												<?php endif; ?>
												<a class="dropdown-item" href="<?php echo 'root/editar/'.$u->id; ?>"><i class="fas fa-edit mr-1"></i>Editar</a>
												<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('root/borrar-actualizacion/'.$u->id,['nonce' => randomPassword(20)])?>"><i class="fas fa-trash mr-1"></i>Borrar</a>
											</div>
										</div>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
						<?php else: ?>
						<div class="text-center py-5">
							<img src="<?php echo IMG . 'es-equipments.svg'; ?>" alt="No hay registros" class="img-fluid" style="width: 150px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay actualizaciones registradas aún</b></h4>
						</div>
						<?php endif ?>
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>