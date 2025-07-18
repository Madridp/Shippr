<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['direcciones', 'Todas mis direcciones'],['', $d->title]]) ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="offset-xl-3 col-xl-6">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<form action="direcciones/post_agregar" method="POST">
            <?php echo insert_inputs(); ?>

            <div class="form-group row">
              <div class="col-6">
                <small class="d-block">Nombre de persona <span class="text-danger">*</span></small>
                <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellidos de la persona" required>
              </div>
              <div class="col-6">
                <small class="d-block">Teléfono <span class="text-danger">*</span></small>
                <input type="text" class="form-control" name="telefono" placeholder="Número de teléfono fijo o celular" required>
              </div>
            </div>

            <div class="form-group">
              <small class="d-block">E-mail</small>
              <input type="email" class="form-control" name="email" placeholder="Dirección de correo electrónico">
            </div>

            <div class="form-group">
              <small class="d-block">Empresa</small>
              <input type="text" class="form-control" name="empresa" placeholder="Nombre de la empresa">
            </div>
            <br>

            <h6>Dirección</h6>
            <div class="form-group">
              <small class="d-block">Código postal <span class="text-danger">*</span></small>
              <input type="text" class="form-control do_sepomex_api_rem" id="rem_cp" name="cp" placeholder="Código postal del área" required>
            </div>

            <div class="form-group">
              <small class="d-block">Calle <span class="text-danger">*</span></small>
              <input type="text" class="form-control" name="calle" placeholder="Nombre de la calle" required>
            </div>

            <div class="form-group row">
              <div class="col-6">
                <small class="d-block">Número exterior <span class="text-danger">*</span></small>
                <input type="text" class="form-control" name="num_ext" placeholder="15B" required>
              </div>
              <div class="col-6">
                <small class="d-block">Número interior</small>
                <input type="text" class="form-control" name="num_int" placeholder="Apartamento 34A">
              </div>
            </div>

            <div class="form-group">
              <small class="d-block">Colonia <span class="text-danger">*</span></small>
              <select name="colonia" id="rem_colonia" class="form-control" disabled required></select>
            </div>

            <div class="form-group">
              <small class="d-block">Ciudad o alcaldia <span class="text-danger">*</span></small>
              <input type="text" class="form-control" id="rem_ciudad" name="ciudad" placeholder="Benito Juárez" readonly required>
            </div>

            <div class="form-group">
              <small class="d-block">Estado <span class="text-danger">*</span></small>
              <input type="text" class="form-control" id="rem_estado" name="estado" placeholder="CDMX" readonly required>
              <input type="hidden" class="form-control" name="pais" value="México" required>
            </div>

            <div class="form-group">
              <small class="d-block">Referencias <span class="text-danger">*</span></small>
              <input type="text" class="form-control" name="referencias" placeholder="Pared color salmón" required>
            </div>

            <div class="form-group">
              <small class="d-block">Convertir en dirección remitente por defecto</small>
              <div class="pretty p-switch p-fill">
                <input type="checkbox" name="default_address" value="on" />
                <div class="state p-success">
                  <label>Si</label>
                </div>
              </div>
            </div>
            <br>

            <button type="submit" class="btn btn-primary">Agregar a mis direcciones</button>
            <button type="reset" class="btn btn-light">Cerrar</button>
          </form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<!-- Actualizado en versión 2.0.0 -->
<?php require INCLUDES.'footer.php' ?>