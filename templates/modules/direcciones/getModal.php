<div class="modal fade" id="get_direccion_modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="<?php echo get_sitename(); ?>">
  <div class="modal-dialog modal-dialog-centered modal-lgs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Dirección de envío</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php if ($d->tipo == 'remitente'): ?>
          <img src="<?php echo URL.IMG.'va-default-remitente.png' ?>" alt="Remitente por defecto" class="img-fluid float-right" style="width: 36px;">
          <h4 class="my-0">Es el remitente por defecto</h4>
          <br>
        <?php endif; ?>
        <div class="form-group">
          <small class="d-block">Nombre</small>
          <?php echo $d->nombre; ?>
        </div>
        <div class="form-group">
          <small class="d-block">Teléfono</small>
          <?php echo $d->telefono; ?>
        </div>
        <div class="form-group">
          <small class="d-block">Email</small>
          <?php echo check_if_defined($d->email); ?>
        </div>
        <div class="form-group">
          <small class="d-block">Empresa</small>
          <?php echo check_if_defined($d->empresa); ?>
        </div>
        <div class="form-group">
          <small class="d-block">Dirección de envío</small>
          <?php echo build_address($d); ?>
        </div>
        <div class="form-group">
          <small class="d-block">Código postal</small>
          <span class="badge badge-primary"><?php echo $d->cp; ?></span>
        </div>
        <div class="form-group">
          <small class="d-block">Referencias</small>
          <span class="text-muted"><?php echo check_if_defined($d->referencias); ?></span>
        </div>
        <br>
        <?php if ($d->tipo == 'remitente'): ?>
        <button class="btn btn-primary do_u_delete_remitente_defecto" data-id="<?php echo $d->id; ?>"><i class="fas fa-times mr-1"></i>Quitar como remitente por defecto</button>
        <?php else: ?>
        <button class="btn btn-primary do_u_make_remitente_defecto" data-id="<?php echo $d->id; ?>"><i class="fas fa-check mr-1"></i>Hacer remitente por defecto</button>
        <?php endif; ?>
      </div>
      <div class="modal-footer text-center">
        <button class="btn btn-light" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>