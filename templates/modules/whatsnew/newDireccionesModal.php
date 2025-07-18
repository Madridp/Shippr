<div class="modal fade" id="do_load_whats_new_modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="<?php echo get_sitename(); ?>">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xl-12 text-center">
            <img src="<?php echo URL.IMG.'va-nueva-seccion-direcciones.png' ?>" alt="<?php echo sprintf('¿Qué hay de nuevo en %s?', get_system_name()) ?>" class="img-fluid" style="width: 300px;">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-xl-2"></div>
          <div class="col-xl-8 text-center">
            <h3 class="f-w-600"><?php echo sprintf('¡Nueva versión %s!', get_siteversion()) ?></h3>
            <p>Nuevas mejoras dentro de <b><?php echo get_system_name(); ?></b></p>
            <p>Seguimos trabajando en mejorar el sistema.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-xl-12 text-center">
            <a href="changelog" class="btn btn-primary btn-lg mt-3">¿Qué hay de nuevo?</a>
          </div>
        </div>
      </div>
      <div class="modal-footer text-right">
        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal" aria-label="Close">Cerrar</button>
      </div>
    </div>
  </div>
</div>