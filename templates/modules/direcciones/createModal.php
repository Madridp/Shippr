<div class="modal fade" id="create_direccion_modal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="<?php echo get_sitename(); ?>">
  <div class="modal-dialog modal-dialog-centered modal-lgs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nueva dirección de envío</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="do_u_create_direccion_form">
      <div class="modal-body">
        <div class="form-group row">
          <div class="col-6">
            <small class="d-block">Nombre <span class="text-danger">*</span></small>
            <input type="text" class="form-control" name="nombre" placeholder="Nombre y apellidos de la persona" required>
          </div>
          <div class="col-6">
            <small class="d-block">Teléfono <span class="text-danger">*</span></small>
            <input type="text" class="form-control" name="telefono" placeholder="Número de teléfono fijo o celular" required>
          </div>
        </div>
        <div class="form-group">
          <small class="d-block">Email</small>
          <input type="email" class="form-control" name="email" placeholder="Dirección de correo electrónico">
        </div>
        <div class="form-group">
          <small class="d-block">Empresa</small>
          <input type="text" class="form-control" name="empresa" placeholder="Nombre de la empresa">
        </div>
        <div class="form-group">
          <small class="d-block">Código postal <span class="text-danger">*</span></small>
          <input type="text" class="form-control" name="cp" placeholder="Código postal del área" required>
        </div>
        <div class="form-group">
          <small class="d-block">Calle <span class="text-danger">*</span></small>
          <input type="text" class="form-control" name="calle" placeholder="Nombre de la calle" required>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <small class="d-block">Número exterior <span class="text-danger">*</span></small>
            <input type="text" class="form-control" name="num_ext" placeholder="15B" required>
          </div>
          <div class="col-6">
            <small class="d-block">Número interior</small>
            <input type="text" class="form-control" name="num_int" placeholder="Apartamento 34A">
          </div>
        </div>
        <div class="form-group">
          <small class="d-block">Colonia <span class="text-danger">*</span></small>
          <input type="text" class="form-control" name="colonia" placeholder="Virgencitas Tamaulipas" required>
        </div>
        <div class="form-group">
          <small class="d-block">Ciudad o alcaldia <span class="text-danger">*</span></small>
          <input type="text" class="form-control" name="ciudad" placeholder="Benito Juárez" required>
        </div>
        <div class="form-group">
          <small class="d-block">Estado <span class="text-danger">*</span></small>
          <input type="text" class="form-control" name="estado" placeholder="CDMX" required>
          <input type="hidden" class="form-control" name="pais" value="México">
        </div>
        <div class="form-group">
          <small class="d-block">Referencias <span class="text-danger">*</span></small>
          <input type="text" class="form-control" name="referencias" placeholder="Pared color salmón" required>
        </div>
        <div class="form-group">
          <small class="d-block">Convertir en dirección remitente por defecto</small>
          <div class="pretty p-switch p-fill">
            <input type="checkbox" name="default_address" value="on" />
            <div class="state p-success">
              <label>Si</label>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Agregar</button>
        <button type="reset" class="btn btn-light" data-dismiss="modal">Cerrar</button>
      </div>
      </form>
    </div>
  </div>
</div>