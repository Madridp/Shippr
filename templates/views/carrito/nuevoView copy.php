<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['envios','Envíos'],['','Nuevo envío']]) ?>
	<?php flasher(); ?>
	
  <form action="carrito/store_step_two" method="POST">
    <?php echo insert_inputs(); ?>
    
    <div class="row">
      <div class="col-xl-8">
        <div class="row">
          <!-- Remitente -->
          <div class="col-xl-12 col-12">
            <div class="pvr-wrapper">
              <div class="pvr-box">
                <h5 class="pvr-header">Remitente <img src="<?php echo URL.IMG.'es-remitente.svg' ?>" alt="Remitente" style="width: 20px;"></h5>
                <p>Debes ingresar ambas direcciones y la información de tu paquete antes de proseguir.</p>

                <div class="form-group">
                  <small>Escribe la dirección del remitente <i class="fas fa-exclamation-circle text-info" aria-hidden="true" <?php echo tooltip('Quien realiza el envío') ?>></i></small>
                  <input type="text" class="form-control" id="autocomplete-remitente" onFocus="geolocate()">
                </div>

                <div class="<?php echo (get_session('remitente') ? '' : 'd-none') ?>" id="wrapper-new-shipment-remitent">
                  <h6>Datos del remitente del paquete</h6>
                  <div class="form-group row">
                    <div class="col-xl-3">
                      <small>Nombre <span class="text-danger">*</span></small>
                      <input type="text" class="form-control form-control-sm" name="remitente[nombre]" value="<?php echo (get_session('remitente.nombre') ? get_session('remitente.nombre') : get_user_name()) ?>" required>
                    </div>

                    <div class="col-xl-3">
                      <small>E-mail</small>
                      <input type="email" class="form-control form-control-sm" name="remitente[email]" value="<?php echo (get_session('remitente.email') ? get_session('remitente.email') : get_user_email()) ?>">
                    </div>

                    <div class="col-xl-3">
                      <small>Teléfono <span class="text-danger">*</span></small>
                      <input type="tel" class="form-control form-control-sm" name="remitente[telefono]" value="<?php echo (get_session('remitente.telefono') ? get_session('remitente.telefono') : get_user_phone()) ?>" required>
                    </div>

                    <div class="col-xl-3">
                      <small>Empresa</small>
                      <input type="text" class="form-control form-control-sm" name="remitente[empresa]" value="<?php echo (get_session('remitente.empresa') ? get_session('remitente.empresa') : get_user_company()) ?>">
                    </div>
                  </div>

                  <h6>Dirección</h6>
                  <div class="form-group row">
                    <div class="col-xl-2">
                      <small>Código postal <span class="text-danger">*</span></small>
                      <input type="number" id="r_postal_code" min="00000" max="99999" class="form-control form-control-sm" name="remitente[cp]" value="<?php echo get_session('remitente.cp') ?>" required>
                    </div>
                    <div class="col-xl-6">
                      <small>Calle <span class="text-danger">*</span></small>
                      <input type="text" id="r_route" class="form-control form-control-sm" name="remitente[calle]" value="<?php echo get_session('remitente.calle') ?>" required>
                    </div>
                    <div class="col-xl-2">
                      <small>Núm. exterior <span class="text-danger">*</span></small>
                      <input type="text" id="r_street_number" class="form-control form-control-sm" name="remitente[num_ext]" value="<?php echo get_session('remitente.num_ext') ?>" required>
                    </div>
                    <div class="col-xl-2">
                      <small>Núm. interior</small>
                      <input type="text" class="form-control form-control-sm" name="remitente[num_int]" value="<?php echo get_session('remitente.num_int') ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-xl-4">
                      <small>Colonia <span class="text-danger">*</span></small>
                      <input type="text" id="r_sublocality_level_1" class="form-control form-control-sm" name="remitente[colonia]" value="<?php echo get_session('remitente.colonia') ?>" required>
                    </div>
                    <div class="col-xl-4">
                      <small>Ciudad <span class="text-danger">*</span></small>
                      <input type="text" id="r_locality" class="form-control form-control-sm" name="remitente[ciudad]" value="<?php echo get_session('remitente.ciudad') ?>" required>
                    </div>
                    <div class="col-xl-4">
                      <small>Estado <span class="text-danger">*</span></small>
                      <input type="text" id="r_administrative_area_level_1" class="form-control form-control-sm" name="remitente[estado]" value="<?php echo get_session('remitente.estado') ?>" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <small>Referencias</small>
                    <input type="text" class="form-control form-control-sm" name="remitente[referencias]" value="<?php echo get_session('remitente.referencias') ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Destinatario -->
          <div class="col-xl-12 col-12">
            <div class="pvr-wrapper">
              <div class="pvr-box horizontal-form">
                <h5 class="pvr-header">Destinatario <img src="<?php echo IMG.'es-destinatario.svg' ?>" alt="Destinatario" style="width: 20px;"></h5>

                <div class="form-group">
                  <small>Escribe la dirección del destinatario <label for="id_direccion">ó <b>selecciona una de tus direcciones</b></label> <i class="fas fa-exclamation-circle text-info" aria-hidden="true" <?php echo tooltip('Quien recibe el paquete') ?>></i></small>
                  <input type="text" class="form-control" id="autocomplete-destinatario" onFocus="geolocate()">
                </div>

                <?php if ($d->direcciones): ?>
                <div class="form-group">
                  <label for="id_direccion">Mis direcciones</label>
                  <select class="form-control do_choose_direccion_destinatario" name="id_direccion" id="id_direccion">
                    <option value="">-- Selecciona una opción --</option>
                    <?php foreach ($d->direcciones as $direccion): ?>
                    <option value="<?php echo $direccion->id; ?>"><?php echo (empty($direccion->empresa) ? '' : '('.$direccion->empresa.')').' '.$direccion->nombre.' - '.$direccion->cp.' - '.$direccion->colonia.', '.$direccion->ciudad.' en '.$direccion->estado.($direccion->tipo === 'remitente' ? ' / REMITENTE POR DEFECTO' : '' ); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <?php endif; ?>

                <div class="<?php echo (get_session('destinatario') ? '' : 'd-none') ?>" id="wrapper-new-shipment-destinatary">
                  <h6>Datos del destinatario</h6>
                  <div class="form-group row">
                    <div class="col-xl-3">
                      <small>Nombre <span class="text-danger">*</span></small>
                      <input type="text" class="form-control form-control-sm" name="destinatario[nombre]" value="<?php echo get_session('destinatario.nombre'); ?>" required>
                    </div>

                    <div class="col-xl-3">
                      <small>E-mail</small>
                      <input type="email" class="form-control form-control-sm" name="destinatario[email]" value="<?php echo get_session('destinatario.email'); ?>">
                    </div>

                    <div class="col-xl-3">
                      <small>Teléfono <span class="text-danger">*</span></small>
                      <input type="tel" class="form-control form-control-sm" name="destinatario[telefono]" value="<?php echo get_session('destinatario.telefono'); ?>" required>
                    </div>

                    <div class="col-xl-3">
                      <small>Empresa</small>
                      <input type="text" class="form-control form-control-sm" name="destinatario[empresa]" value="<?php echo get_session('destinatario.empresa'); ?>">
                    </div>
                  </div>

                  <h6>Dirección</h6>
                  <div class="form-group row">
                    <div class="col-xl-2">
                      <small>Código postal <span class="text-danger">*</span></small>
                      <input type="number" id="d_postal_code" min="00000" max="99999" class="form-control form-control-sm" name="destinatario[cp]" value="<?php echo get_session('destinatario.cp') ?>" required>
                    </div>
                    <div class="col-xl-6">
                      <small>Calle <span class="text-danger">*</span></small>
                      <input type="text" id="d_route" class="form-control form-control-sm" name="destinatario[calle]" value="<?php echo get_session('destinatario.calle') ?>" required>
                    </div>
                    <div class="col-xl-2">
                      <small>Núm. exterior <span class="text-danger">*</span></small>
                      <input type="text" id="d_street_number" class="form-control form-control-sm" name="destinatario[num_ext]" value="<?php echo get_session('destinatario.num_ext') ?>" required>
                    </div>
                    <div class="col-xl-2">
                      <small>Núm. interior</small>
                      <input type="text" class="form-control form-control-sm" name="destinatario[num_int]" value="<?php echo get_session('destinatario.num_int') ?>">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-xl-4">
                      <small>Colonia <span class="text-danger">*</span></small>
                      <input type="text" id="d_sublocality_level_1" class="form-control form-control-sm" name="destinatario[colonia]" value="<?php echo get_session('destinatario.colonia') ?>" required>
                    </div>
                    <div class="col-xl-4">
                      <small>Ciudad <span class="text-danger">*</span></small>
                      <input type="text" id="d_locality" class="form-control form-control-sm" name="destinatario[ciudad]" value="<?php echo get_session('destinatario.ciudad') ?>" required>
                    </div>
                    <div class="col-xl-4">
                      <small>Estado <span class="text-danger">*</span></small>
                      <input type="text" id="d_administrative_area_level_1" class="form-control form-control-sm" name="destinatario[estado]" value="<?php echo get_session('destinatario.estado') ?>" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <small>Referencias <span class="text-danger">*</span></small>
                    <input type="text" class="form-control form-control-sm" name="destinatario[referencias]" value="<?php echo get_session('destinatario.referencias') ?>" required>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Paquete -->
      <div class="col-xl-4 col-12">
        <div class="pvr-wrapper">
          <div class="pvr-box horizontal-form">
            <h5 class="pvr-header">Información del paquete <img src="<?php echo IMG.'es-paquete.svg' ?>" alt="Paquete" style="width: 20px;"></h5>
            <?php echo get_subscription_message() ?>

            <h6>Opcional</h6>
            <small>Referencia de compra</small>
            <input type="text" class="form-control form-control-sm" name="paq[referencia]" placeholder="<?php echo strtoupper(randomPassword(8)) ?>" value="<?php echo get_session('paq.referencia') ?>">
            <small class="text-muted d-block">Puedes utilizar este campo para sincronizar tu sistema de ventas o compras ingresando el número de venta o pedido.</small>
            <br>
            <h6>Datos del paquete</h6>
            <div class="form-group">
              <small>Descripción del contenido <span class="text-danger">*</span></small>
              <textarea class="form-control form-control-sm" name="paq[descripcion]" rows="4" required><?php echo get_session('paq.descripcion') ?></textarea>
            </div>

            <div class="form-group row">
              <div class="col-xl-4">
                <small>Alto en <span class="text-muted">cm</span> <span class="text-danger">*</span></small>
                <input type="text" class="form-control form-control-sm money" name="paq[alto]" value="<?php echo get_session('paq.alto') ?>" required>
              </div>
              <div class="col-xl-4">
                <small>Ancho en <span class="text-muted">cm</span> <span class="text-danger">*</span></small>
                <input type="text" class="form-control form-control-sm money" name="paq[ancho]" value="<?php echo get_session('paq.ancho') ?>" required>
              </div>
              <div class="col-xl-4">
                <small>Largo en <span class="text-muted">cm</span> <span class="text-danger">*</span></small>
                <input type="text" class="form-control form-control-sm money" name="paq[largo]" value="<?php echo get_session('paq.largo') ?>" required>
              </div>
            </div>
            <div class="form-group">
              <small>Peso neto en <span class="text-muted">kg</span> <span class="text-danger">*</span></small>
              <input type="text" class="form-control form-control-sm money" name="paq[peso_neto]" value="<?php echo get_session('paq.peso_neto') ?>" required>
            </div>

            <?php if ($d->couriers): ?>
            <h6>¿Algún courier preferido?</h6>
            <div class="form-group">
              <small>Couriers disponibles</small>
              <select name="id_courier" class="form-control select2-basic-single">
                <option value="">Todos</option>
                <?php foreach ($d->couriers as $courier): ?>
                  <option value="<?php echo $courier->id; ?>"><?php echo $courier->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php endif; ?>

            <?php echo insert_inputs(); ?>

            <button type="submit" class="btn btn-success" name="submit">Siguiente paso (1 de 2)</button>
            <button type="reset" class="btn btn-default" name="cancel">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div><!-- ends content -->

<!-- Actualizado en versión 2.0.0 -->
<?php require INCLUDES.'footer.php' ?>