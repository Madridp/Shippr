<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['direccion','Dirección general'],['admin/productos-index','Productos'],['', $d->title]]) ?>
  
  <?php flasher() ?>
	
	<div class="row">
		<div class="offset-xl-3 col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Completa el formulario</h5>

          <form action="admin/productos-update" method="POST">
            <?php echo insert_inputs(); ?>
						<input type="hidden" name="id" value="<?php echo $d->p->id; ?>" required>
						
						<h6>Datos del courier</h6>
						<div class="form-group row">
							<div class="<?php echo bs_col([6,6,6,12,12]); ?>">
								<label for="id_courier">Courier <?php echo bs4_required(); ?></label>
								<select name="id_courier" id="id_courier" class="form-control select2-basic-single" required>
									<?php foreach ($d->couriers as $courier): ?>
										<option value="<?php echo $courier->id; ?>" <?php echo $courier->id == $d->p->id_courier ? 'selected' : ''; ?>><?php echo $courier->name; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="<?php echo bs_col([6,6,6,12,12]) ?>">
								<label for="sku">SKU <?php echo more_info('Código único para identificar el producto') ?></label>
								<input type="text" class="form-control" name="sku" id="sku" value="<?php echo $d->p->sku; ?>">
							</div>
						</div>

						<div class="form-group row">
							<div class="<?php echo bs_col([4,4,4,12,12]) ?>">
								<label for="precio">Precio <?php echo bs4_required(); ?></label>
								<input type="text" class="form-control money" name="precio" id="precio" placeholder="0.00" value="<?php echo money($d->p->precio, ''); ?>" required>
							</div>
							<div class="<?php echo bs_col([4,4,4,12,12]) ?>">
								<label for="capacidad">Capacidad <?php echo bs4_required(); ?> <?php echo more_info('Es la capacidad amparada en kilogramos por la guía o producto') ?></label>
								<input type="number" class="form-control" min="1" max="999" name="capacidad" id="capacidad" placeholder="123" value="<?php echo $d->p->capacidad; ?>" required>
							</div>
							<div class="<?php echo bs_col([4,4,4,12,12]) ?>">
								<label for="tipo_servicio">Tipo de servicio <?php echo bs4_required(); ?> <?php echo more_info('Tipo de servicio aceptado por la guía o producto') ?></label>
								<select class="form-control" name="tipo_servicio" id="tipo_servicio" required>
									<?php foreach (get_producto_tipos_servicio() as $ts): ?>
										<option value="<?php echo $ts[0]; ?>" <?php echo $ts[0] === $d->p->tipo_servicio ? 'selected' : ''; ?>><?php echo $ts[1]; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<div class="<?php echo bs_col([4,4,4,12,12]) ?>">
								<label for="tiempo_entrega">Tiempo de entrega <?php echo bs4_required(); ?> <?php echo more_info('Tiempo de entrega estimado según el courier') ?></label>
								<select class="form-control" name="tiempo_entrega" id="tiempo_entrega" required>
									<?php foreach (get_producto_tiempos_entrega() as $te): ?>
										<option value="<?php echo $te[0]; ?>" <?php echo $te[0] === $d->p->tiempo_entrega ? 'selected' : ''; ?>><?php echo $te[0]; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>

						<button class="btn btn-success" type="submit">Guardar cambios</button>
						<button class="btn btn-light" type="reset">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>