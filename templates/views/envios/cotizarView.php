<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['envios','Envíos'],['','Cotizar envío']]) ?>

	<?php flasher() ?>
	
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Completa el formulario
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

					<form method="POST" class="form-horizontal" id="cotizar-envio">
            <?php echo insert_inputs() ?>

						<h6>Cotizar envío</h6>
						<div class="form-group">
							<label for="">Paquetería de preferencia</label>
							<select class="form-control" name="carrier" required>
                <option value="fedex" selected>FedEx</option>
                <option value="dhl">DHL</option>
              </select>
						</div>

            <h6>Información del paquete</h6>
            <div class="row">
              <div class="col-xl-4">
                <div class="form-group">
                  <label for="">Alto <small>cm</small></label>
                  <input type="text" class="form-control money" name="pckg_h" required>
                </div>
              </div>
              <div class="col-xl-4">
                <div class="form-group">
                  <label for="">Ancho <small>cm</small></label>
                  <input type="text" class="form-control money" name="pckg_w" required>
                </div>
              </div>
              <div class="col-xl-4">
                <div class="form-group">
                  <label for="">Largo <small>cm</small></label>
                  <input type="text" class="form-control money" name="pckg_l" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xl-6">
                <div class="form-group">
                  <label for="">Peso <small>kg</small></label>
                  <input type="text" class="form-control" name="pckg_weight" required>
                </div>
              </div>
              <div class="col-xl-6">
              	<div class="form-group">
                  <label for="">Peso volumétrico del paquete</label>
                  <input type="text" class="form-control money" name="pckg_vol" value="0" disabled>
                </div>
              </div>
            </div>

						<button type="submit" class="btn btn-success" name="submit">Cotizar</button>
						<button type="reset" class="btn btn-default" name="cancel">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>

  <div class="row">
    <div class="col-xl-3"></div>
    <div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <table class="table table-sm table-striped table-hover">
          <thead>
            <tr>
              <th>Paquetería</th>
              <th class="text-center">Peso</th>
              <th class="text-right">Precio</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>FedEx</td>
              <td class="text-center">3 kg</td>
              <td class="text-right">$170.00 MXN</td>
            </tr>
            <tr>
              <td>DHL</td>
              <td class="text-center">3 kg</td>
              <td class="text-right">$170.00 MXN</td>
            </tr>
            <tr>
              <td>Estafeta</td>
              <td class="text-center">3 kg</td>
              <td class="text-right">$170.00 MXN</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>