<div class="d-flex flex-column flex-md-row align-items-center p-3 bg-white border-bottom shadow-sm">
  <h5 class="my-0 mr-md-auto font-weight-normal">
    <a href="<?php echo URL; ?>">
      <img src="<?php echo get_sitelogo(250);?>" alt="<?php echo get_sitename(); ?>" style="width: 150px;">
    </a>
  </h5>
  <nav class="my-2 my-md-0 mr-md-3">
    <a class="p-2 text-dark" href="p/tarifas">Lista de precios</a>
    <!-- <a class="p-2 text-dark" href="https://www.shippr.com.mx/" target="_blank">Plataforma</a> -->
    <?php if (is_logged()): ?>
      <a class="btn btn-primary" href="dashboard">Mi cuenta</a>
    <?php else: ?>
      <a class="btn btn-primary" href="registro">Registrarme</a>
    <?php endif; ?>
  </nav>
</div>