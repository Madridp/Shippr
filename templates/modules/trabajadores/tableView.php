<?php if (!empty($d->trabajadores)): ?>
  <table class="table table-striped table-borderless table-hover vmiddle" id="data-table" style="width: 100% !important;">
    <thead class="thead-dark">
      <tr>
        <th width="10%"></th>
        <th>Usuario</th>
        <th>Nombre</th>
        <th>Correo electrónico</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($d->trabajadores as $t): ?>
        <tr>
          <td><?php echo format_user_status(user_is_online($t->time_active)); ?></td>
          <td><?php echo $t->usuario; ?></td>
          <td><?php echo $t->nombre; ?></td>
          <td><?php echo $t->email; ?></td>
          <td class="text-right">
            <button class="btn btn-sm btn-light" id="<?php echo 'r-'.$t->id_usuario; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="<?php echo 'r-'.$t->id_usuario; ?>">
              <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('trabajadores/recuperar-contrasena/'.$t->id_usuario); ?>"><i class="fa fa-unlock-alt"></i> Recuperar contraseña</a>
              <?php if ((int) $t->status === 1): ?>
                <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('trabajadores/retirar-suspension/'.$t->id_usuario); ?>"><i class="fa fa-unlock"></i> Habilitar</a>
              <?php else: ?>
                <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('trabajadores/suspender/'.$t->id_usuario); ?>"><i class="fa fa-ban"></i> Suspender</a>
              <?php endif; ?>
              <a class="dropdown-item confirmacion-requerida" href="<?php echo buildURL('trabajadores/borrar/'.$t->id_usuario); ?>"><i class="fas fa-trash"></i> Borrar</a>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="text-center py-5">
    <img class="d-block mx-auto img-empty-state" src="<?php echo URL.IMG.'undraw_empty_workers.svg' ?>" alt="No hay trabajadores">
    <?php if (!reached_workers_limit()): ?>
      <a href="trabajadores/agregar" class="btn btn-lg btn-primary text-white mt-5">Agregar un trabajador</a>
    <?php endif; ?>
  </div>
<?php endif; ?>