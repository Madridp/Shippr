<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['admin','Administración'],['',$d->title]]) ?>
	<?php flasher() ?>
	
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Completa el formulario</h5>

					<form action="admin/post_cobertura" method="POST" enctype="multipart/form-data">
						<?php echo insert_inputs(); ?>

						<h6>Datos del documento</h6>
            <p>Aquí podrás actualizar la cobertura de forma personalizada de cada courier subiendo un documento <code>.csv</code></p>

            <div class="alert alert-info mb-4" role="alert">
              <h4 class="alert-heading m-0 f-w-600">¡Psst!</h4>
              <p class="mb-0">Recuerda que debes utilizar el documento tal cual es proporcionado, sin modificar el orden de columnas o puede ocurrir un error en la importación.</p>
            </div>

            <div class="card">
              <div class="card-header">Columnas requeridas</div>
              <div class="card-body">
                <div class="alert alert-danger mb-4" role="alert">
                  <p class="m-0">Ten en cuenta que las coberturas existentes del courier seleccionado serán reemplazadas con las nuevas para prevenir errores posteriores.</p>
                </div>
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-striped table-hover vmiddle">
                    <thead>
                      <tr>
                        <th>Columna</th>
                        <th>Descripción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Courier</td>
                        <td>Identificador ID numérico del courier <?php echo more_info('En la sección Couriers puedes encontrar el identificador de cada uno') ?></td>
                      </tr>
                      <tr>
                        <td>CP</td>
                        <td>Código postal de entre <b>4 y 5</b> caracteres numéricos</td>
                      </tr>
                      <tr>
                        <td>Recolección</td>
                        <td>Debe ser un número entero, valores aceptados <b>1</b> (Si) y <b>0</b> (No)</td>
                      </tr>
                      <tr>
                        <td>Servicio</td>
                        <td>Valores aceptados <b>EXP</b> para <b>Express</b> y <b>ECO</b> para <b>Económico</b>, o <b>1</b> y <b>0</b> <?php echo more_info('Debe ser escrito tal cual el valor aceptado', 'text-danger'); ?></td>
                      </tr>
                      <tr>
                        <td>Zona Extendida</td>
                        <td>Debe ser un número entero, valores aceptados <b>1</b> (Si) y <b>0</b> (No)</td>
                      </tr>
                      <tr>
                        <td>Cargo</td>
                        <td>Monto a cobrar en <b>valor decimal</b> si el código postal representa una zona extendida de envío <?php echo more_info('No hacer uso de símbolos de pesos o moneda', 'text-danger'); ?></td>
                      </tr>
                    </tbody>
                  </table>
                  <br>

                  <h6>Reglas de validación aplicadas</h6>
                  <ol class="m-0 p-0">
                    <li>1.- No es necesario poner el <code>ID</code> del courier en todos los registros, bastará con que sea colocado en las primeras 5 filas.</li>
                    <li>2.- Si un código postal es mayor a <code>5 dígitos</code> , este será ignorado ya que no será considerado válido.</li>
                    <li>3.- A los códigos postales que contengan sólo <code>4 dígitos</code> se les anexará de forma automática un <code>0</code> al comienzo, ejemplo <code>1000 será 01000</code>.</li>
                    <li>4.- Todos los valores aceptados para <code>servicio económico</code> son <code>económico, eco, regular, normal, economico y 0</code>.</li>
                    <li>5.- Todos los valores aceptados para <code>servicio express</code> son <code>express, exp, expres, xpress, xpres y 1</code>.</li>
                    <li>6.- Si el código postal representa una <code>zona extendida</code> y también viene marcado como <code>servicio express</code>, éste último será automáticamente establecido como <code>servicio económico</code>.</li>
                    <li>7.- Los cargos ingresados para cobrar zonas extendidas no deben tener <code>ningún símbolo especial de moneda</code> o no serán válidos.</li>
                    <li>8.- Es importante <b>no repetir</b> códigos postales de un mismo <b>Courier</b> para evitar problemas al cotizar nuevos envíos, un sólo registro puede representar servicio <b>express y económico</b>.</li>
                  </ol>
                  <br>

                  <img src="<?php echo URL.IMG.'cobertura_example.jpg'; ?>" alt="Coberturas" class="img-fluid img-thumbnail">
                </div>
              </div>
            </div>
            
            <div class="form-group mt-3">
              <label for="id_courier">Courier <?php echo bs_required(); ?></label>
              <select name="id_courier" id="id_courier" class="form-control select2-basic-single" required>
                <option value="none"></option>
                <?php foreach ($d->couriers as $courier): ?>
                  <option value="<?php echo $courier->id; ?>"><?php echo sprintf('ID %s %s (%s destinos)', $courier->id, $courier->name, $courier->cobertura); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
						<div class="form-group">
							<label for="csv_coberturas">Archivo <b>CSV</b> <?php echo bs_required(); ?></label>
							<input type="file" class="form-control" name="csv_coberturas" id="csv_coberturas" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
						</div>

            <button class="btn btn-success" type="submit">Importar coberturas</button>
            <button class="btn btn-light" type="reset">Cancelar</button>
					</form>
          <p class="mt-4 mb-0"><a href="<?php echo buildURL('admin/template-cobertura', [], false); ?>" target="_blank">Descarga</a> la plantilla si aún no cuentas con ella.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>