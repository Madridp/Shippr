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

                <div class="form-group row">
                  <div class="col-xl-3 col-12">
                    <label for="rem_cp"><small>Código Postal</small> <?php echo bs_required(); ?></label>
                    <input type="text" class="form-control do_sepomex_api_rem" id="rem_cp" name="remitente[cp]" value="<?php echo get_session('remitente.cp') ?>" placeholder="57301" required>
                    <div class="wrapper_rem_cp"></div>
                  </div>
                  <div class="col-xl-3 col-12">
                    <label for="rem_colonia"><small>Colonia</small> <?php echo bs_required(); ?></label>
                    <select class="form-control" id="rem_colonia" name="remitente[colonia]" <?php echo get_session('remitente.colonia') ? '' : 'disabled'; ?> required>
                      <?php if(get_session('remitente.colonia')): ?>
                        <option value="<?php echo get_session('remitente.colonia') ?>"><?php echo get_session('remitente.colonia'); ?></option>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="col-xl-3 col-12">
                    <label for="rem_ciudad"><small>Ciudad o alcaldia</small> <?php echo bs_required(); ?></label>
                    <input type="text" class="form-control" id="rem_ciudad" name="remitente[ciudad]" value="<?php echo get_session('remitente.ciudad') ?>" readonly required>
                  </div>
                  <div class="col-xl-3 col-12">
                    <label for="rem_estado"><small>Estado</small> <?php echo bs_required(); ?></label>
                    <input type="text" class="form-control" id="rem_estado" name="remitente[estado]" value="<?php echo get_session('remitente.estado') ?>" readonly required>
                  </div>
                </div>

                <h6>Dirección</h6>
                <div class="form-group row">
                  <div class="col-xl-6">
                    <label for="rem_calle"><small>Calle</small> <span class="text-danger">*</span></label>
                    <input type="text" id="r_route" class="form-control" name="remitente[calle]" value="<?php echo get_session('remitente.calle') ?>" required>
                  </div>
                  <div class="col-xl-3">
                    <label for="rem_num_ext"><small>Núm. exterior <span class="text-danger">*</span></small></label>
                    <input type="text" class="form-control" id="rem_num_ext" name="remitente[num_ext]" value="<?php echo get_session('remitente.num_ext') ?>" required>
                  </div>
                  <div class="col-xl-3">
                    <label for="rem_num_int"><small>Núm. interior</small></label>
                    <input type="text" class="form-control" id="rem_num_int" name="remitente[num_int]" value="<?php echo get_session('remitente.num_int') ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="rem_referencias"><small>Referencias</small></label>
                  <input type="text" class="form-control" name="remitente[referencias]" value="<?php echo get_session('remitente.referencias') ?>">
                </div>

                <h6>Datos del remitente del paquete</h6>
                <div class="form-group row">
                  <div class="col-xl-3">
                    <label for="rem_nombre"><small>Nombre <span class="text-danger">*</span></small></label>
                    <input type="text" class="form-control" name="remitente[nombre]" value="<?php echo (get_session('remitente.nombre') ? get_session('remitente.nombre') : get_user_name()) ?>" required>
                  </div>

                  <div class="col-xl-3">
                    <label for="rem_email"><small>E-mail</small></label>
                    <input type="email" class="form-control" name="remitente[email]" value="<?php echo (get_session('remitente.email') ? get_session('remitente.email') : get_user_email()) ?>">
                  </div>

                  <div class="col-xl-3">
                    <label for="rem_telefono"><small>Teléfono <span class="text-danger">*</span></small></label>
                    <input type="tel" class="form-control" name="remitente[telefono]" value="<?php echo (get_session('remitente.telefono') ? get_session('remitente.telefono') : get_user_phone()) ?>" required>
                  </div>

                  <div class="col-xl-3">
                    <label for="rem_empresa"><small>Empresa</small></label>
                    <input type="text" class="form-control" name="remitente[empresa]" value="<?php echo (get_session('remitente.empresa') ? get_session('remitente.empresa') : get_user_company()) ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Destinatario -->
          <div class="col-xl-12 col-12">
            <div class="pvr-wrapper">
              <div class="pvr-box">
                <h5 class="pvr-header">Destinatario <img src="<?php echo URL.IMG.'es-destinatario.svg' ?>" alt="Destinatario" style="width: 20px;"></h5>
                <p>Escribe el código postel del destinatario o <b>selecciona</b> una de tus direcciones guardadas.</p>

                <div class="form-group row">
                  <div class="col-xl-4 col-12">
                    <label for="des_cp"><small>Código Postal</small> <?php echo bs_required(); ?></label>
                    <input type="text" class="form-control do_sepomex_api_des" id="des_cp" name="destinatario[cp]" value="<?php echo get_session('destinatario.cp') ?>" placeholder="57896" required>
                    <div class="wrapper_des_cp"></div>
                  </div>
                  <div class="col-xl-4 col-12">
                    <label for="id_direccion"><small>Mis direcciones</small></label>
                    <?php if ($d->direcciones): ?>
                      <select class="form-control do_choose_direccion_destinatario" name="id_direccion" id="id_direccion">
                        <option value="">Selecciona una dirección</option>
                        <?php foreach ($d->direcciones as $direccion): ?>
                        <option value="<?php echo $direccion->id; ?>"><?php echo (empty($direccion->empresa) ? '' : '('.$direccion->empresa.')').' '.$direccion->nombre.' - '.$direccion->cp.' - '.$direccion->colonia.', '.$direccion->ciudad.' en '.$direccion->estado.($direccion->tipo === 'remitente' ? ' / Remitente por defecto' : '' ); ?></option>
                        <?php endforeach; ?>
                      </select>
                    <?php else: ?>
                      <div class="alert alert-danger my-0">
                        No tienes direcciones guardadas.
                      </div>
                    <?php endif; ?>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-xl-4 col-12">
                    <label for="des_colonia"><small>Colonia</small> <?php echo bs_required(); ?></label>
                    <select class="form-control" id="des_colonia" name="destinatario[colonia]" <?php echo get_session('destinatario.colonia') ? '' : 'disabled'; ?> required>
                      <?php if(get_session('destinatario.colonia')): ?>
                        <option value="<?php echo get_session('destinatario.colonia') ?>"><?php echo get_session('destinatario.colonia'); ?></option>
                      <?php endif; ?>
                    </select>
                  </div>
                  <div class="col-xl-4 col-12">
                    <label for="des_ciudad"><small>Ciudad o alcaldia</small> <?php echo bs_required(); ?></label>
                    <input type="text" class="form-control" id="des_ciudad" name="destinatario[ciudad]" value="<?php echo get_session('destinatario.ciudad') ?>" readonly required>
                  </div>
                  <div class="col-xl-4 col-12">
                    <label for="des_estado"><small>Estado</small> <?php echo bs_required(); ?></label>
                    <input type="text" class="form-control" id="des_estado" name="destinatario[estado]" value="<?php echo get_session('destinatario.estado') ?>" readonly required>
                  </div>
                </div>

                <h6>Dirección</h6>
                <div class="form-group row">
                  <div class="col-xl-6">
                    <label for="des_calle"><small>Calle</small> <span class="text-danger">*</span></label>
                    <input type="text" id="des_calle" class="form-control" name="destinatario[calle]" value="<?php echo get_session('destinatario.calle') ?>" required>
                  </div>
                  <div class="col-xl-3">
                    <label for="des_num_ext"><small>Núm. exterior <span class="text-danger">*</span></small></label>
                    <input type="text" class="form-control" id="des_num_ext" name="destinatario[num_ext]" value="<?php echo get_session('destinatario.num_ext') ?>" required>
                  </div>
                  <div class="col-xl-3">
                    <label for="des_num_int"><small>Núm. interior</small></label>
                    <input type="text" class="form-control" id="des_num_int" name="destinatario[num_int]" value="<?php echo get_session('destinatario.num_int') ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label for="des_referencias"><small>Referencias</small></label>
                  <input type="text" class="form-control" id="des_referencias" name="destinatario[referencias]" value="<?php echo get_session('destinatario.referencias') ?>">
                </div>

                <h6>Datos del destinatario</h6>
                <div class="form-group row">
                    <div class="col-xl-3">
                      <label for="des_nombre"><small>Nombre <span class="text-danger">*</span></small></label>
                      <input type="text" class="form-control" id="des_nombre" name="destinatario[nombre]" value="<?php echo get_session('destinatario.nombre'); ?>" required>
                    </div>

                    <div class="col-xl-3">
                      <label for="des_email"><small>E-mail</small></label>
                      <input type="email" class="form-control" id="des_email" name="destinatario[email]" value="<?php echo get_session('destinatario.email'); ?>">
                    </div>

                    <div class="col-xl-3">
                      <label for="des_telefono"><small>Teléfono <span class="text-danger">*</span></small></label>
                      <input type="tel" class="form-control" id="des_telefono" name="destinatario[telefono]" value="<?php echo get_session('destinatario.telefono'); ?>" required>
                    </div>

                    <div class="col-xl-3">
                      <label for="des_empresa"><small>Empresa</small></label>
                      <input type="text" class="form-control" id="des_empresa" name="destinatario[empresa]" value="<?php echo get_session('destinatario.empresa'); ?>">
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

            <?php echo disable_on_enter(); ?>
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