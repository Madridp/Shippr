<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['admin','Administración'],['admin/ventas-index','Ventas'],['admin/ventas-ver/'.$d->v->folio,'Ver'],['',$d->title]]) ?>

	<?php flasher() ?>
	
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>

					<form action="admin/ventas-update" method="POST">
            <input type="hidden" name="id" value="<?php echo $d->v->id; ?>" required>
            <?php echo insert_inputs(); ?>

            <h6>Información del cliente</h6>
            <div class="form-group">
              <small class="d-block">Usuario</small>
              <?php echo $d->v->usuario; ?>
            </div>
            <div class="form-group">
              <small class="d-block">Nombre completo</small>
              <?php echo $d->v->nombre; ?>
            </div>
            <div class="form-group">
              <small class="d-block">E-mail</small>
              <?php echo $d->v->email; ?>
            </div>
            <br>

						<h6>Información general</h6>
            <div class="form-group">
              <small class="d-block">Folio</small>
              <input type="text" class="form-control form-control-sm" value="<?php echo $d->v->folio; ?>" disabled>
            </div>

            <div class="form-group">
              <small class="d-block">Estado de la venta</small>
              <select class="form-control form-control-sm" name="data[status]" required>
                <?php foreach (get_estados_de_venta() as $status): ?>
                  <?php if ($status[0] == $d->v->status): ?>
                    <option value="<?php echo $status[0] ?>" selected><?php echo $status[1]; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $status[0] ?>"><?php echo $status[1]; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <small class="d-block">Estado del pago</small>
              <select class="form-control form-control-sm" name="data[pago_status]" required>
                <?php foreach (get_estados_de_pago() as $status): ?>
                  <?php if ($status[0] == $d->v->pago_status): ?>
                    <option value="<?php echo $status[0] ?>" selected><?php echo $status[1]; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $status[0] ?>"><?php echo $status[1]; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <small class="d-block">Métodos de pago</small>
              <select class="form-control form-control-sm" name="data[metodo_pago]" required>
                <?php foreach (get_metodos_de_pago() as $metodo): ?>
                  <?php if ($metodo[0] == $d->v->metodo_pago): ?>
                    <option value="<?php echo $metodo[0] ?>" selected><?php echo $metodo[1]; ?></option>
                  <?php else: ?>
                    <option value="<?php echo $metodo[0] ?>"><?php echo $metodo[1]; ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <small class="d-block">Número de pago</small>
              <input type="text" class="form-control form-control-sm" name="data[collection_id]" value="<?php echo $d->v->collection_id; ?>">
            </div>
            <br>
            
						<button type="submit" class="btn btn-success" name="submit">Guardar cambios</button>
						<button type="reset" class="btn btn-default" name="cancel">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>