<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php flasher() ?>

  <div class="row">
    <div class="<?php echo bs_col([6,6,12,12,12]) ?>">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h3 class="element-inner-header m-t-0 text-theme"><?php echo sprintf('%s <b>%s</b>', greeting(), get_user_name()); ?></h3>
          <div class="element-inner-desc">
            Bienvenido a tu panel de administración.
            <?php if (is_admin(get_user_role())): ?>
              <div class="list-group mt-3">
                <a href="direccion/configuracion" class="list-group-item list-group-item-action active"><i class="fas fa-image"></i> Cambiar logotipo</a>
                <?php if (empty(get_option('bank_clabe')) || empty(get_option('bank_account_number'))): ?>
                  <a href="direccion/facturacion" class="list-group-item list-group-item-action"><i class="fas fa-money-check-alt"></i> Completa tu información bancaria</a>
                <?php endif; ?>
                <?php if (get_option('bank_card_number') === null || empty(get_option('bank_card_number'))): ?>
                  <a href="direccion/facturacion" class="list-group-item list-group-item-action"><i class="fas fa-money-check-alt"></i> Completa tu número de tarjeta</a>
                <?php endif; ?>
                <a href="direccion/configuracion" class="list-group-item list-group-item-action"><i class="fas fa-clock"></i> Cambiar horario laboral</a>
                <a href="admin/productos-agregar" class="list-group-item list-group-item-action"><i class="fas fa-truck"></i> Agregar un producto</a>
                <a href="admin/ventas-index" class="list-group-item list-group-item-action"><i class="fas fa-shopping-cart"></i> Administrar ventas</a>
                <a href="trabajadores/agregar" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Agregar trabajadores</a>
              </div>
            <?php endif; ?>
            <?php if (get_system_status() && is_admin(get_user_role())): ?>
            <div class="mt-3">
              <p><?php echo sprintf('Actualmente %s <b>está aceptando</b> nuevos pedidos.', get_sitename()); ?></p>
              <a href="<?php echo buildURL('direccion/system-status', ['status' => 0]); ?>" class="btn btn-danger confirmacion-requerida">Dejar de recibir pedidos</a>
            </div>
            <?php else: ?>
            <div class="mt-3">
              <p><?php echo sprintf('Actualmente %s <b>no está aceptando</b> nuevos pedidos.', get_sitename()); ?></p>
              <a href="<?php echo buildURL('direccion/system-status', ['status' => 1]); ?>" class="btn btn-success confirmacion-requerida">Aceptar nuevos pedidos</a>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="<?php echo bs_col([6,6,6,12,12]) ?>">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">Ventas mensuales</h5>
          <canvas id="chartjs_ventas" height="200px"></canvas>
        </div>
      </div>
    </div>

    <div class="<?php echo bs_col([6,6,6,12,12]) ?>">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">Envíos mensuales</h5>
          <canvas id="chartjs_envios" height="200px"></canvas>
        </div>
      </div>
    </div>

    <div class="<?php echo bs_col([6,6,6,12,12]) ?>">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">Usuarios registrados</h5>
          <canvas id="chartjs_usuarios" height="200px"></canvas>
        </div>
      </div>
    </div>

    <div class="<?php echo bs_col([6,6,6,12,12]) ?>">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">Ingresos mensuales</h5>
          <canvas id="chartjs_ingresos" height="200px"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>