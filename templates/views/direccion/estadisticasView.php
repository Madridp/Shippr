<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['','Estadísticas']]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            <?php echo 'Crecimiento de '.get_sitename(); ?>
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="clientes-tab" data-toggle="tab" href="#clientes" role="tab" aria-controls="clientes" aria-expanded="true" aria-selected="true">Clientes</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="equipos-tab" data-toggle="tab" href="#equipos" role="tab" aria-controls="equipos" aria-expanded="false" aria-selected="false">Equipos</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div role="tabpanel" class="tab-pane fade active show" id="clientes" aria-labelledby="clientes-tab" aria-expanded="true">
                  <h5>Clientes <span class="badge badge-primary"><?php echo ($d->c ? count($d->c) : 0); ?></span></h5>
                  <p>Crecimiento anual de clientes.</p>
                  <canvas id="clientes-chartjs" height="150"></canvas>
                </div>
                <div class="tab-pane fade" id="equipos" role="tabpanel" aria-labelledby="equipos-tab" aria-expanded="false">
                  <h5>Equipos <span class="badge badge-primary"><?php echo ($d->e ? count($d->e) : 0); ?></span></h5>
                  <p>Crecimiento anual de equipos.</p>
                  <canvas id="equipos-chartjs" height="150"></canvas>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-4">
      <div class="box_dashboard_v2 inbox_v2 bg-primary">
        <div class="charjs-chart">
          <canvas id="jserp-tipos-chartjs" height="180"width="180"></canvas>
          <div class="charjs-chart-label">
            <strong><span data-count="true" data-number="<?php echo ($d->t ? count($d->t) : 0) ?>" id="total_visit"></span></strong><span><span id="tot_vis">Tipos de equipo</span></span>
          </div>
        </div>
        <h2 class="text-center m-b-0">
          Tipos de Equipo
        </h2>
      </div>
    </div>

    <!-- Reportes -->
    <div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            Reportes
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>
          <div class="dashboard-reportes-morris"></div>
        </div>
      </div>
    </div>

    <!-- Anticipos -->
    <div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            Anticipos
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>
          <div class="dashboard-anticipos-morris"></div>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>