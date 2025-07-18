<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['',$d->title]]); ?>

	<?php flasher() ?>

	<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-settings text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Configuración general</h6>
							<a href="direccion/configuracion">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-notebook text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Facturación</h6>
							<a href="direccion/facturacion">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-magnifier text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">SEO y visibilidad</h6>
							<a href="direccion/seo">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-envelope text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Notificaciones y correos</h6>
							<a href="direccion/correos">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-equalizer text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Temas y colores</h6>
							<a href="direccion/personalizacion">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-chemistry text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Changelog</h6>
							<a href="changelog">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-doc text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Log</h6>
							<a href="direccion/log">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3 col-lg-3 col-md-6 col-12">
			<div class="card mb-4">
				<div class="card-body">
					<div class="row">
						<div class="col-2">
							<i class="icon-user text-danger f-s-40"></i>
						</div>
						<div class="col-10">
							<h6 class="m-0">Trabajadores</h6>
							<a href="trabajadores">Ver más</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<!-- módulos activos -->
		<div class="col-xl-6 col-lg-6 col-md-12 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Módulos activos</h5>
					<table class="table table-hover table-striped vmiddle">
						<thead>
							<tr>
								<th>Módulo</th>
								<th>Estado</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td width="30%">Envíos</td>
								<td><span class="badge badge-success">ACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
							<tr>
								<td width="30%">Rastreo Aftership</td>
								<td><span class="badge badge-success">ACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
							<tr>
								<td width="30%">Ventas</td>
								<td><span class="badge badge-success">ACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
							<tr>
								<td width="30%">Compras</td>
								<td><span class="badge badge-success">ACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
							<tr>
								<td width="30%">Transacciones</td>
								<td><span class="badge badge-success">ACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
							<tr>
								<td width="30%">Cotizador</td>
								<td><span class="badge badge-success">ACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
							<tr>
								<td width="30%">Mercado Pago</td>
								<td><span class="badge badge-danger">INACTIVO</span></td>
								<td class="text-right"><button class="btn btn-sm btn-danger"><i class="fas fa-toggle-on"></i></button></td>
							</tr>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
		<!-- ends -->

		<div class="col-xl-6 col-lg-6 col-md-12 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Información del sistema</h5>
					<small class="text-muted d-block">Versión de PHP</small>
					<?php echo phpversion(); ?>
					<div class="wrapper_guzzle_test"><!-- ajax fill --></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>