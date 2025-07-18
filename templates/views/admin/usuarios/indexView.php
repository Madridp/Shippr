<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
  <?php echo get_breadcrums([['admin','Administración'], ['','Todos los usuarios']]) ?>

  <?php flasher() ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header"><?php echo $d->title; ?></h5>
          
          <?php if ($d->usuarios): ?>
            <table id="data-table" class="table table-striped table-bordered table-hover vmiddle">
              <thead class="thead-dark">
              <tr>
                <th width="10%"></th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Correo electrónico</th>
                <th>Saldo disponible</th>
                <th>Total recargado</th>
                <th></th>
              </tr>
              </thead>
              <tbody>
                <?php foreach ($d->usuarios as $u): ?>
                  <tr>
                    <td width="10%"><?php echo format_user_status(user_is_online($u->time_active)); ?></td>
                    <td><?php echo $u->usuario; ?></td>
                    <td><?php echo $u->nombre; ?></td>
                    <td>
                      <?php if ((int) $u->status === 1): ?>
                        <span class="badge badge-warning"><i class="fas fa-ban"></i> Suspendido</span>
                      <?php elseif ((int) $u->status === 2): ?>
                        <span class="badge badge-warning"><i class="fas fa-clock"></i> Por confirmar</span>
                      <?php elseif ($u->role === 'demo' && (int) $u->status === 0): ?>
                        <span class="badge badge-success"><i class="fas fa-calendar-plus"></i> En demostración</span>
                      <?php elseif ($u->role === 'demo' && (int) $u->status === 3): ?>
                        <span class="badge badge-danger"><i class="fas fa-calendar-check"></i> Demostración concluida</span>
                      <?php elseif ((int) $u->status === 0): ?>
                        <span class="badge badge-success"><i class="fas fa-check"></i> Confirmado</span>
                      <?php endif; ?>
                    </td>
                    <td><?php echo $u->email; ?></td>
                    <td><?php echo money($u->saldo, '$'); ?></td>
                    <td><?php echo money($u->saldo_recargado, '$'); ?></td>
                    <td class="text-right">
                      <div class="btn-group" role="group">
                        <button id="<?php echo 'r-'.$u->id_usuario; ?>" type="button" class="btn btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r-'.$u->id_usuario; ?>">
                          <a class="dropdown-item" href="<?php echo 'admin/usuarios-ver/'.$u->id_usuario; ?>"><i class="fa fa-eye"></i> Ver</a>
                          <a class="dropdown-item" href="<?php echo mailto($u->email); ?>"><i class="fa fa-envelope"></i> Enviar correo</a>
                          <?php if (!is_admin($u->role)): ?>
                            <a class="dropdown-item" href="<?php echo buildURL('admin/usuarios_modificar/'.$u->id_usuario) ?>"><i class="fa fa-edit mr-1"></i>Editar</a>
                          <?php endif; ?>
                          <?php if ((int) $u->status === 0): ?>
                              <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('usuarios/suspender/'.$u->id_usuario) ?>"><i class="fas fa-lock mr-1"></i>Suspender</a>
                          <?php else: ?>
                            <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('usuarios/revertir-suspension/'.$u->id_usuario) ?>"><i class="fas fa-lock-open  mr-1"></i>Retirar suspensión</a>
                          <?php endif; ?>
                          <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('usuarios/recuperar-contrasena/'.$u->id_usuario) ?>"><i class="fa fa-unlock-alt mr-1"></i>Recuperar contraseña</a>
                          <?php if (!is_admin($u->role)): ?>
                            <a data-accion="borrar" class="dropdown-item" href="<?php echo buildURL('usuarios/borrar/'.$u->id_usuario) ?>"><i class="fa fa-trash mr-1"></i>Borrar</a>
                          <?php endif; ?>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          <?php else: ?>
            <div class="text-center py-5">
              <img class="d-block mx-auto" src="<?php echo URL.IMG.'undraw_empty_orders.svg' ?>" alt="No hay usuarios" style="width: 200px;">
              <h4 class="mt-3 mb-2"><b>Upps... no hay usuarios registrados aún</b></h4>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

  </div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>