<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['carrito','Carrito'],['carrito/nuevo','Editar envío'],['','Confirmar información']]) ?>
	<?php flasher(); ?>
	
  <form action="carrito/agregar" method="POST">
    <?php echo insert_inputs(); ?>
    
    <div class="row">
      <!-- Información de guía -->
      <div class="col-xl-6 col-12">
        <div class="pvr-wrapper">
          <div class="pvr-box horizontal-form">
            <h5 class="pvr-header">
              <a href="carrito/nuevo" class="btn btn-warning float-right">Regresar y editar</a>
              Remitente <img src="<?php echo URL.IMG.'es-remitente.svg' ?>" alt="Remitente" style="width: 20px;"> <small><i class="fa fa-arrow-right"></i></small> Destinatario <img src="<?php echo URL.IMG.'es-destinatario.svg' ?>" alt="Destinatario" style="width: 20px;">
            </h5>

            <h6>Remitente</h6>
            <!-- <?php if (productoModel::has_pickup($d->r->cp)): ?>
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-truck"></i> Recolección a domicilio disponible.
              </div>
            <?php else: ?>
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <i class="fas fa-truck"></i> Recolección a domicilio no disponible, deberás llevar el paquete a la sucursal más cercana.
              </div>
            <?php endif; ?> -->
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nombre</td>
                  <td><b><?php echo $d->r->nombre ?></b></td>
                </tr>
                <tr>
                  <td>E-mail</td>
                  <td><b><?php echo $d->r->email ?></b></td>
                </tr>
                <tr>
                  <td>Teléfono</td>
                  <td><b><?php echo $d->r->telefono ?></b></td>
                </tr>
                <tr>
                  <td>Empresa</td>
                  <td><b><?php echo $d->r->empresa ?></b></td>
                </tr>
                <tr>
                  <td>Dirección</td>
                  <td><b><?php echo build_address($d->r); ?></b></td>
                </tr>
                <tr>
                  <td>Referencias</td>
                  <td><b><?php echo $d->r->referencias ?></b></td>
                </tr>
              </tbody>
            </table>

            <h6>Destinatario</h6>
            <table class="table table-borderless">
              <tbody>
                <tr>
                  <td>Nombre</td>
                  <td><b><?php echo $d->d->nombre ?></b></td>
                </tr>
                <tr>
                  <td>E-mail</td>
                  <td><b><?php echo $d->d->email ?></b></td>
                </tr>
                <tr>
                  <td>Teléfono</td>
                  <td><b><?php echo $d->d->telefono ?></b></td>
                </tr>
                <tr>
                  <td>Empresa</td>
                  <td><b><?php echo $d->d->empresa ?></b></td>
                </tr>
                <tr>
                  <td>Dirección</td>
                  <td><b><?php echo build_address($d->d); ?></b></td>
                </tr>
                <tr>
                  <td>Referencias</td>
                  <td><b><?php echo $d->d->referencias ?></b></td>
                </tr>
              </tbody>
            </table>
            
          </div>
        </div>
      </div>

      <!-- Paquete y opciones -->
      <div class="col-xl-6 col-12">
        <div class="pvr-wrapper">
          <div class="pvr-box horizontal-form">
            <h5 class="pvr-header">Información del paquete <img src="<?php echo URL.IMG.'es-paquete.svg' ?>" alt="Paquete" style="width: 20px;"></h5>

            <h6> Datos del paquete</h6>
            <table class="table table-borderless table-sm">
              <tbody>
                <tr>
                  <td width="40%">Descripción</td>
                  <th><?php echo $d->p->descripcion ?></th>
                </tr>
                <tr>
                  <td>Alto</td>
                  <th><?php echo $d->p->alto.' cm' ?></th>
                </tr>
                <tr>
                  <td>Ancho</td>
                  <th><?php echo $d->p->ancho.' cm' ?></th>
                </tr>
                <tr>
                  <td>Largo</td>
                  <th><?php echo $d->p->largo.' cm' ?></th>
                </tr>
                <tr>
                  <td><img src="<?php echo URL.IMG.'va-weight.svg' ?>" alt="Peso netro" class="img-fluid" style="width: 30px;"> Peso neto</td>
                  <th><?php echo $d->p->peso_neto.' kg'; ?></th>
                </tr>
                <tr>
                  <td class="align-middle"><img src="<?php echo URL.IMG.'va-volumetric.svg' ?>" alt="Peso volumétrico" class="img-fluid" style="width: 30px;"> Peso volumétrico</td>
                  <th class="align-middle"><h3 class="m-0"><b><?php echo $d->p->peso_vol; ?></b></h3></th>
                </tr>
              </tbody>
            </table>
            <?php if ($d->p->peso_neto >= $d->p->peso_vol): ?>
              <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                  <span class="sr-only">Cerrar</span>
                </button>
                <strong><?php echo 'Recomendación '.get_sitename(); ?></strong><br>
                Ya que el peso neto de tu paquete es superior que su peso volumétrico, te recomendamos adquirir una guía de por lo menos <b><?php echo ceil($d->p->peso_neto) ?> kg</b> para evitar cualquier tipo de recargos por sobrepeso. <br>
                <small><a href="informacion/calcular-peso-volumetrico" class="text-white" target="_blank" rel="noopener noreferrer">¿Cómo calculo el peso volumétrico?</a></small>
              </div>
            <?php elseif($d->p->peso_neto < $d->p->peso_vol): ?>
              <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                  <span aria-hidden="true">&times;</span>
                  <span class="sr-only">Cerrar</span>
                </button>
                <strong><?php echo 'Recomendación '.get_sitename(); ?></strong><br>
                Ya que el peso volumétrico de tu paquete es superior que su peso neto en kilogramos, te recomendamos adquirir una guía de por lo menos <b><?php echo ceil($d->p->peso_vol) ?> kg</b> o <b>superior</b> para evitar cualquier tipo de recargos por sobrepeso.<br>
                <small><a href="informacion/calcular-peso-volumetrico" class="text-white" target="_blank" rel="noopener noreferrer">¿Cómo calculo el peso volumétrico?</a></small>
              </div>
            <?php endif; ?>

            <?php if ($d->o): ?>
              <h6 class="mt-5">Opciones de envío disponibles</h6>
              <p>Selecciona una de las opciones disponibles para tu envío.</p>
              <table class="table table-hover table-sm vmiddle">
                <thead>
                  <tr>
                    <th width="10%" class="text-center">#</th>
                    <th>Courier</th>
                    <th class="text-center">Capacidad</th>
                    <th class="text-right"><?php echo (is_sub_authorized() ? 'Precio especial' : 'Precio') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($d->o as $p): ?>
                    <?php if (((int) $p->zona_extendida === 0 && in_array($p->p_tipo_servicio, ['regular','express'])) || ((int) $p->zona_extendida === 1 && $p->p_tipo_servicio === 'regular')): ?>
                      <tr>
                        <td class="text-center">
                          <input type="radio" name="id_producto" value="<?php echo $p->id ?>" id="<?php echo 'opcion-'.$p->id; ?>">
                        </td>
                        <td class="">
                          <label class="m-0" for="<?php echo 'opcion-'.$p->id; ?>">
                            <div class="row">
                              <div class="col-2">
                                <img class="img-fluid" src="<?php echo URL.UPLOADS.$p->imagenes; ?>" alt="<?php echo $p->titulo; ?>" style="border-radius: 50%;">
                              </div>
                              <div class="col-10">
                                <?php if ((int) $p->rem_recoleccion == 1): ?>
                                  <span class="float-right">
                                    <small>Recolección disponible <i class="fas fa-truck text-success"></i></small>
                                  </span>
                                <?php else: ?>
                                  <span class="float-right text-danger">
                                    <small>Recolección no disponible</small>
                                  </span>
                                <?php endif; ?>
                                <?php echo sprintf('%s %s %skg', $p->titulo, $p->p_tipo_servicio, $p->capacidad); ?>
                                <?php if (in_array($p->p_tipo_servicio, ['express'])): ?>
                                  <span class="badge badge-success">Express <i class="fas fa-bolt"></i></span>
                                <?php endif; ?>
                                <?php if ($p->zona_extendida): ?>
                                  <small class="text-danger d-block f-w-600">Zona extendida</small>
                                <?php endif; ?>
                                <small class="text-muted d-block"><?php echo !empty($p->tiempo_entrega) ? sprintf('(Entrega %s)', $p->tiempo_entrega) : 'Tiempo de entrega desconocido'; ?></small>
                              </div>
                            </div>
                          </label>
                        </td>
                        <td class="text-center"><?php echo sprintf('%s kg', $p->capacidad); ?></td>
                        <td class="text-right"><strong><?php echo money($p->precio, '$'); ?></strong></td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <div class="form-group">
                <a href="carrito/nuevo" class="btn btn-warning float-right">Regresar y editar</a>
                <button type="submit" class="btn btn-success">Agregar al carrito (2 de 2)</button>
                <button type="reset" class="btn btn-default">Cancelar</button>
              </div>
            <?php else: ?>
              <div class="text-center py-4">
                <img src="<?php echo IMG.'es-empty.svg' ?>" alt="Sin resultados" style="width: 100px;"><br>
                <p>No tenemos opciones de envío disponibles para tu paquete, debido al peso, dimensiones o courier, intenta de nuevo por favor.</p>
                <a href="carrito/nuevo" class="btn btn-warning btn-lg mt-3">Regresar y editar</a>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </form>
</div><!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>