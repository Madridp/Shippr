<?php echo sprintf('<p>Estas son las opciones que tenemos disponibles para tu envío al código postal <b>%s</b> con un peso volumétrico de <b>%s</b>.</p>', $d->destino, $d->peso_vol); ?>
<div class="table-responsive">
  <table class="table table-hover table-sm vmiddle">
    <thead>
      <tr>
        <th></th>
        <th>Courier</th>
        <th class="text-center">Capacidad</th>
        <th class="text-right">Precio</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($d->opciones as $o): ?>
        <tr>
          <td><img class="img-thumbnail" src="<?php echo URL.UPLOADS.$o->imagenes; ?>" alt="<?php echo $o->titulo; ?>" style="border-radius: 50%; width: 40px;"></td>
          <td class="">
            <?php echo  sprintf('%s %s %skg (%s)', $o->titulo, $o->p_tipo_servicio, $o->capacidad, $o->tiempo_entrega)?>
            <?php if (in_array($o->p_tipo_servicio, ['express'])): ?>
              <span class="badge badge-success">Express <i class="fas fa-bolt"></i></span>
            <?php endif; ?>
            <?php if ($o->zona_extendida): ?>
              <small class="text-danger d-block f-w-600">Zona extendida</small>
            <?php endif; ?>
          </td>
          <td class="text-center"><?php echo sprintf('%s kg', $o->capacidad); ?></td>
          <td class="text-right"><strong><?php echo money($o->precio); ?></strong></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<a class="btn btn-success" href="carrito/nuevo">Crear nuevo envío</a>