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
					<h5 class="pvr-header"><?php echo $d->title; ?>
						<div class="button-group float-right">
							<a href="admin/productos-agregar" class="btn btn-success"><i class="fas fa-plus"></i> Agregar producto</a>
						</div>
					</h5>
					<?php if($d->p): ?>
					<table class="table table-borderless table-sm table-hover vmiddle" id="data-table" style="width: 100% !important;">
						<thead>
							<tr>
                <th class="text-center">Imagen</th>
								<th class="text-left">Información</th>
								<th class="text-center">Precio</th>
								<th class="text-center">Ventas</th>
                <th class="text-center">Publicado</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($d->p as $p): ?>
								<tr>
									<td class="text-center" width="5%">
										<img class="img-fluid" src="<?php echo get_producto_imagen($p->imagenes) ?>" alt="<?php echo $p->titulo; ?>" style="border-radius: 50px;">
									</td>
									<td class="">
										<?php echo sprintf('%s %s %skg (%s)', $p->titulo, $p->tipo_servicio, $p->capacidad, $p->tiempo_entrega); ?>
										<small class="text-muted d-block"><?php echo $p->descripcion; ?></small>
										<small class="text-muted d-block"><?php echo 'Para '.$p->capacidad.' kg'; ?></small>
									</td>
									<td class="text-center"><?php echo money($p->precio); ?></td>
									<td class="text-center"><?php echo $p->ventas; ?></td>
									<td class="text-center" width="10%">
										<?php if (get_producto_status($p->publicado)): ?>
											<button class="btn btn-success btn-block btn-sm"><i class="fa fa-check"></i></button>
										<?php else: ?>
											<button class="btn btn-danger btn-block btn-sm"><i class="fa fa-eye-slash"></i></button>
										<?php endif; ?>
									</td>
									<td class="text-right">
										<div class="btn-group dropleft" role="group">
											<button id="<?php echo 'r'.$p->id ?>" type="button" class="btn btn-sm btn-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
											<div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r'.$p->id ?>">
												<a class="dropdown-item" href="<?php echo buildURL('admin/productos-actualizar/'.$p->id) ?>"><i class="fa fa-edit"></i> Editar</a>
												<small class="dropdown-header">Estado</small>
												<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/productos-cambiar-status', ['status' => 0,'id' => $p->id]); ?>"><i class="fa fa-eye-slash"></i> Despublicar</a>
												<hr class="dropdown-divisor"></hr>
												<a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('admin/productos-borrar/'.$p->id); ?>"><i class="fa fa-trash"></i> Borrar</a>
											</div>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<?php else : ?>
						<div class="text-center py-5">
							<img src="<?php echo IMG.'va-noproducts.svg'; ?>" alt="No hay registros" class="img-fluid" style="width: 200px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay productos registrados aún</b></h4>
							<p class="text-muted">Comienza agregando un producto</p>
							<a href="admin/productos-agregar" class="btn btn-primary btn-lg text-white">Agregar un producto</a>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>