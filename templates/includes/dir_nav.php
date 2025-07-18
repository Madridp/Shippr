<li class="nav-item has-sub-menu <?php echo current_link(['direccion','trabajadores'])?>">
  <a class="nav-link" data-toggle="collapse" href="#ss_dirección">
    <i class="material-icons">settings</i>
    <p>Dirección general<b class="caret"></b></p>
  </a>
  <div class="collapse sub-menu" id="ss_dirección">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link sub_link" href="direccion/configuracion">
          <span class="sidebar-normal">Configuración</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link sub_link" href="trabajadores">
          <span class="sidebar-normal">Trabajadores</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link sub_link" href="direccion/facturacion">
          <span class="sidebar-normal">Pagos y facturación</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link sub_link" href="direccion/correos">
          <span class="sidebar-normal">Correos</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link sub_link" href="direccion/personalizacion">
          <span class="sidebar-normal">Temas y colores</span>
        </a>
      </li>
      <?php if (is_root(get_user_role())): ?>
        <li class="nav-item">
          <a class="nav-link sub_link" href="direccion/log">
            <span class="sidebar-normal">Log del sistema</span>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </div>
</li>