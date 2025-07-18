<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['direccion','Dirección General'],['',$d->title]]); ?>

	<?php flasher() ?>

	<div class="row">
		<div class="col-xl-3"></div>
		<div class="col-xl-6 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Completa el formulario</h5>

					<form action="direccion/seo_store" method="POST" class="form-horizontal" enctype="multipart/form-data">
						<?php echo insert_inputs(); ?>

						<h6><?php echo $d->title; ?></h6>
						<h6>Google Analytics <?php echo more_info('Si quieres seguir las estadísticas de tráfico en el sitio, pega tu Google Key aquí') ?></h6>
						<p>Para llegistrar toda la actividad de tus usuarios o clientes dentro de la plataforma, te recomendamos pegar el código html generado por Google al registrar Shippr en Google Analytics.</p>
						<div class="form-group">
							<textarea name="site_google_analytics" cols="30" rows="10" placeholder="Pega el script generado por Google aquí..." class="form-control"><?php echo get_site_google_analytics(false) ?></textarea>
						</div>
						<br>

						<h6>Hotjar</h6>
						<p>Hotjar es una herramienta gratuita utilizada para grabar el comportamiento de tus usuarios para elaborar estrategias de marketing efectivas, pega el código html generado aquí.</p>
						<div class="form-group">
							<textarea name="site_hotjar" cols="30" rows="10" placeholder="Pega el script generado por Hotjar aquí..." class="form-control"><?php echo get_site_hotjar(false) ?></textarea>
						</div>
						<br>

						<button class="btn btn-success" type="submit">Guardar cambios</button>
            <button class="btn btn-default" type="reset">Cancelar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->


<?php require INCLUDES . 'footer.php' ?>