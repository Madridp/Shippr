<?php require INCLUDES.'p_header.php' ?>
<?php require INCLUDES.'p_navbar.php' ?>

<!-- content  -->
<main role="main">
  <section class="jumbotron text-center mb-0">
    <div class="container">
      <h1>Nuestras tarifas de envío</h1>
      <p class="lead text-muted">Trabajamos con las mejores paqueterías de México y el mundo para llevar tus productos, a tus clientes.</p>
      <p>
        <?php if (is_logged()): ?>
          <a href="carrito/nuevo" class="btn btn-info my-2">Hacer un envío</a>
        <?php else: ?>
          <a href="registro" class="btn btn-info my-2">Quiero registrarme</a>
        <?php endif; ?>
        <a href="<?php echo buildURL('p/download-prices'); ?>" class="btn btn-primary my-2">Descargar tarifas <i class="fas fa-download"></i></a>
      </p>
    </div>
  </section>

  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <?php if (!empty($d->precios)): ?>
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-hover v-middle">
                <thead>
                  <tr>
                    <th>Courier</th>
                    <th>Detalles</th>
                    <th>Precio estimado</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($d->precios as $p): ?>
                    <tr>
                      <td><img src="<?php echo URL.COURIERS.$p->thumb; ?>" alt="<?php echo $p->titulo; ?>" class="img-fluid" style="width: 50px;"></td>
                      <td><?php echo sprintf('<b>%s</b> %s <b>%s kg</b> (%s)', $p->titulo, $p->tipo_servicio, $p->capacidad, $p->tiempo_entrega); ?></td>
                      <td><?php echo money($p->precio, '$') ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr>
                    <td colspan="3" class="text-center"><a href="<?php echo buildURL('p/download-prices'); ?>" class="btn btn-primary btn-lg my-2">Descargar tarifas <i class="fas fa-download"></i></a></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="text-center">
              <span class="text-muted">Las zonas extendidas pueden tener un cargo adicional al precio base.</span>
              <br>
              <span class="text-muted">Nuestras tarifas pueden cambiar sin previo aviso.</span>
            </div>
          <?php else: ?>
            <p>No tenemos tarifas para mostrar en estos momentos.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</main>
<?php flasher() ?>
<!-- ends content -->

<?php require INCLUDES.'p_footer.php' ?>