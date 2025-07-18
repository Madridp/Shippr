<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<div class="row">
		<div class="col">
			<nav aria-label="breadcrumb">
			  <ol class="breadcrumb">
			    <li class="breadcrumb-item"><a href="direccion">Dirección General</a></li>
			    <li class="breadcrumb-item active" aria-current="page">Respaldos del sistema</li>
			  </ol>
			</nav>
		</div>
	</div>

	<?php flasher() ?>

	<div class="row">
		<div class="col-xl-6 col-12">
			<div class="row">
				<div class="col-xl-12">
					<div class="pvr-wrapper">
						<div class="pvr-box horizontal-form">
							<h5 class="pvr-header">Completa el formulario
								<div class="pvr-box-controls">
									<i class="material-icons" data-box="fullscreen">fullscreen</i>
									<i class="material-icons" data-box="close">close</i>
								</div>
							</h5>
							<p>Los respaldos son generados de forma automática por el sistema para proteger tu información y siempre tenerla disponible en caso de que ocurra cualquier error, siempre podremos volver a una versión segura o anterior.</p>
							<button class="btn btn-success ladda-button do-backup" data-style="expand-right"><span class="ladda-label">Crear respaldo</span></button>
						</div>
					</div>
				</div>

				<?php if (is_root(get_user_role())) : ?>
				<div class="col-xl-12">
					<div class="pvr-wrapper">
						<div class="pvr-box horizontal-form">
							<h5 class="pvr-header">Completa el formulario
								<div class="pvr-box-controls">
									<i class="material-icons" data-box="fullscreen">fullscreen</i>
									<i class="material-icons" data-box="close">close</i>
								</div>
							</h5>
							<p>Empaquetar nueva versión de ERP para lanzamiento</p>
							<form action="direccion/pack-new-version" method="POST">
								<?php echo insert_inputs(); ?>
								<div class="form-group">
									<label for="">Versión</label>
									<input type="text" class="form-control" name="version" required>
								</div>
								<button class="btn btn-success ladda-button do-backup" data-style="expand-right" name="submit"><span class="ladda-label">Launch</span></button>
							</form>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>

    <div class="col-xl-6 col-12">
			<table class="table table-striped table-bordered table-hover" id="data-table" style="width: 100% !important;">
				<thead>
					<tr>
						<th>Respaldo</th>
						<?php if (is_root(Auth::get_user_role())): ?>
						<th></th>
						<?php endif; ?>
					</tr>
				</thead>
				<tbody>
					<?php if (!$d->respaldos) : ?>
						<tr>
							<td colspan="6">No hay respaldos.</td>
						</tr>
					<?php else : ?>
						<?php foreach (array_reverse($d->respaldos) as $r) : ?>
							<tr>
								<td>
									<small class="text-muted float-right">Versión <span class="text-primary"><?php $v = explode('-' , pathinfo($r , PATHINFO_FILENAME)); echo end($v); ?></span></small>
									<span class="text-muted mr-2"><?php echo basename($r); ?></span>
									<span class="d-block"><?php echo filesize_formatter(filesize($r)); ?></span>
								</td>

								<?php if (is_root(Auth::get_user_role())): ?>
								<td>
									<div class="btn-group" role="group">
										<a class="btn btn-sm btn-primary  text-white" href="<?php echo buildURL('descargar', ['redirect_to' => CUR_PAGE,'file' => $r]) ?>"><i class="fa fa-download"></i></a>
									</div>
								</td>
								<?php endif; ?>
							</tr>
						<?php endforeach; ?>
					<?php endif ?>
				</tbody>
			</table>
    </div>
	</div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>