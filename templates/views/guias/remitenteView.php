<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
  <?php echo get_breadcrums([['guias','Guías'],['','Agregar Remitente']]) ?>

	<?php flasher() ?>
	
	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box horizontal-form">
					<h5 class="pvr-header">Agregar remitente
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

					<form action="guias/remitente-store" method="POST" class="form-horizontal">
            <?php echo insert_inputs(); ?>

						<h6>Remitente</h6>
            <div class="row">
              <div class="form-group col-xl-6">
                <label for="">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
              </div>

              <div class="form-group col-xl-6">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>

              <div class="form-group col-xl-6">
                <label for="">Teléfono</label>
                <input type="text" class="form-control" name="telefono" required>
              </div>

              <div class="form-group col-xl-6">
                <label for="">Empresa</label>
                <input type="text" class="form-control" name="empresa" required>
              </div>
            </div>
            <br>
            
            <h6>Dirección del remitente</h6>
            <div class="row">
              <div class="form-group col-xl-3">
                <label for="">Código Postal</label>
                <input type="text" class="form-control" name="cp" required>
              </div>

              <div class="form-group col-xl-3">
                <label for="">Calle</label>
                <input type="text" class="form-control" name="calle" required>
              </div>

              <div class="form-group col-xl-3">
                <label for="">Número Exterior</label>
                <input type="text" class="form-control" name="num_ext" required>
              </div>

              <div class="form-group col-xl-3">
                <label for="">Número Interior</label>
                <input type="text" class="form-control" name="num_int" required>
              </div>
            </div>
            
            <div class="row">
              <div class="form-group col-xl-4">
                <label for="">Colonia</label>
                <input type="text" class="form-control" name="colonia" required>
              </div>

              <div class="form-group col-xl-4">
                <label for="">Alcaldia o Municipio</label>
                <input type="text" class="form-control" name="ciudad" required>
              </div>

              <div class="form-group col-xl-4">
                <label for="">Estado</label>
                <input type="text" class="form-control" name="estado" required>
              </div>

              <div class="form-group d-none">
                <label for="">País</label>
                <input type="text" class="form-control" name="pais" value="México" required>
              </div>
            </div>


						<button type="submit" class="btn btn-success" name="submit">Agregar</button>
						<button type="reset" class="btn btn-default" name="cancel">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>