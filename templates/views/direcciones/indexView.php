<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['','Todas mis direcciones']]) ?>
	
	<?php flasher(); ?>

	<div class="row">
		<div class="col-xl-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?></h5>
					<?php if ($d->d): ?>
            <div class="button-group mb-3 text-right">
              <a class="btn btn-primary" href="direcciones/agregar"><i class="fas fa-plus"></i> Agregar dirección</a>
            </div>
            <table class="vmiddle table table-striped table-borderless table-hover" id="data-table" style="width: 100% !important;">
              <thead class="thead-dark">
                <tr>
                  <th class="text-left">Nombre</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">Empresa</th>
                  <th class="text-center">Código postal</th>
                  <th class="text-center">Ciudad</th>
                  <th class="text-center">Estado</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($d->d as $d): ?>
                <tr>
                  <td class="align-middle">
                    <?php if ($d->tipo === 'remitente'): ?>
                      <img src="<?php echo URL.IMG.'va-default-remitente.png' ?>" alt="Remitente por defecto" class="img-fluid float-right" style="width: 24px;" <?php echo tooltip('Remitente por defecto') ?>>
                    <?php elseif($d->tipo === 'destinatario') : ?>
                      <img src="<?php echo URL.IMG.'va-default-destinatario.png' ?>" alt="Destinatario por defecto" class="img-fluid float-right" style="width: 24px;" <?php echo tooltip('Destinatario por defecto') ?>>
                    <?php endif; ?>
                    <?php echo $d->nombre; ?>
                  </td>

                  <td class="text-center align-middle">
                    <?php echo check_if_defined($d->telefono,true); ?>
                  </td>

                  <td class="text-center align-middle">
                    <?php echo check_if_defined($d->empresa,true); ?>
                  </td>

                  <td class="text-center align-middle">
                    <span class="badge badge-primary"><?php echo $d->cp; ?></span>
                  </td>

                  <td class="text-center align-middle">
                    <?php echo $d->ciudad; ?>
                  </td>

                  <td class="text-center align-middle">
                    <?php echo $d->estado; ?>
                  </td>
                  
                  <td class="text-right align-middle">
                    <div class="btn-group" role="group">
                      <button class="btn btn-primary text-white do_u_editar_direccion_modal" data-id="<?php echo $d->id; ?>"><i class="fas fa-edit"></i></button>
                      <button class="btn btn-primary text-white do_u_get_direccion_modal" data-id="<?php echo $d->id; ?>"><i class="fas fa-eye"></i></button>
                      <button class="btn btn-primary text-white do_u_delete_direccion" data-id="<?php echo $d->id; ?>"><i class="fas fa-trash"></i></button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
              </tbody>
            </table>
					<?php else : ?>
            <div class="text-center py-5">
              <img class="d-block mx-auto" src="<?php echo URL.IMG.'undraw_empty_address.svg' ?>" alt="No hay direcciones registradas" style="width: 300px;">
              <button class="btn btn-primary btn-lg do_u_create_direccion_modal mt-5"><i class="fas fa-plus"></i> Agregar dirección</button>
            </div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<!-- Actualizado en versión 2.0.0 -->
<?php require INCLUDES.'footer.php' ?>