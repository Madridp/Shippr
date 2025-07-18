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
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<?php if ($d->couriers): ?>
            <div class="row">
              <div class="col-12 mb-3">
                <?php echo sprintf('Estos son los couriers disponibles en %s, seguimos trabajando para integrar nuevos socios al sistema.', get_system_name()); ?>
              </div>
              <?php foreach ($d->couriers as $c): ?>
                <div class="col-xl-2 col-lg-4 col-md-4 col-12 mb-3">
                  <div class="card">
                    <img src="<?php echo is_file(COURIERS.$c->thumb) ? URL.COURIERS.$c->thumb : URL.IMG.'broken.png'; ?>" alt="<?php echo $c->name; ?>" class="card-img-top">
                    <div class="card-body">
                      <h5 class="card-title f-w-600"><?php echo $c->other_name; ?></h5>
                      <p class="mb-0">Contacto</p>
                      <small class="text-muted"><?php echo $c->phone; ?></small>

                      <small class="text-muted d-block"><?php echo sprintf('Identificador (ID) <b>%s</b>', $c->id); ?> <?php echo more_info('Es el número identificador del courier, es utilizado para definir la cobertura personalizada de cada uno en documentos .csv') ?></small>
                    </div>
                    <div class="card-footer text-right">
                      <a class="btn btn-primary btn-sm" href="<?php echo $c->web_url; ?>" target="_blank">Web oficial</a>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
					<?php else : ?>
						<div class="text-center py-5">
							<img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_void.svg'; ?>" alt="No hay registros" style="width: 250px;">
							<h4 class="mt-3 mb-2"><b>Upps... no hay couriers registrados aún</b></h4>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>