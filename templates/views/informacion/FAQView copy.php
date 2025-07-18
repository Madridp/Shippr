<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['informacion','Información'],['',$d->title]]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            <?php echo $d->title; ?>
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <h1><?php echo $d->title; ?></h1>
          <p class="text-muted"><?php echo 'Última actualización '.fecha('2018-11-22'); ?></p>
          <div class="accordion" id="faq">
            <div class="card">
              <div class="card-header">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#0" aria-expanded="true" aria-controls="collapseOne">
                ¿Quiénes somos?
                </button>
              </div>
              <div id="0" class="collapse-info-faq show" data-parent="#faq">
                <div class="card-body">
                  Somos una empresa 100% Mexicana visionaria y emprendedora, fundada en el año 2017, nuestro camino inicio como distribuidores de textiles de las mejores marcas del mercado en México, pero nos expandimos a diferentes áreas, creando nuestra plataforma para envíos nacionales en el año 2018, en Shippr hemos sacrificado un nivel de automatización dentro del proceso de generación de guías para darle a nuestros clientes el mejor costo posible por sus envíos, la elaboración es estrictamente manual, pero todos los procesos anteriores y posteriores a la generación de la guía son automatizados por la plataforma, es por eso que Shippr puede ofrecerte costos más bajos que las propias paqueterías, debido a la cantidad de guías solicitadas diariamente y la eficiencia al momento de administrar la información.
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#1" aria-expanded="true" aria-controls="collapseOne">
                ¿Cómo hago mi primer envío en Shippr Envíos?
                </button>
              </div>
              <div id="1" class="collapse-info-faq" data-parent="#faq">
                <div class="card-body">
                  Es muy fácil, solo debes hacer lo siguiente o puedes ver el video siguiente:
                  <ol class="m-0">
                    <li style="list-style: numeric;">Regístrate</li>
                    <li style="list-style: numeric;">Ve a la sección <a href="envios/nuevo"><i>Nuevo envío</i></a>, también puedes agregar una dirección de <b>remitente por defecto</b> en la sección <a href="direcciones"><i>Mis direcciones</i></a></li>
                    <li style="list-style: numeric;">Completa el formulario de <b>remitente</b> y de <b>destinatario</b> o selecciona de <i>Mis direcciones</i> la que necesites</li>
                    <li style="list-style: numeric;">Completa la información de tu paquete, medidas y peso</li>
                    <li style="list-style: numeric;">Si gustas selecciona una paquetería preferida</li>
                    <li style="list-style: numeric;">Da clic en <b>Siguiente paso</b></li>
                    <li style="list-style: numeric;">Selecciona la <b>opción</b> propuesta por Shippr que más te guste</li>
                    <li style="list-style: numeric;">Escoge un <b>método de pago</b> y da clic en <b>Pagar ahora</b></li>
                    <li style="list-style: numeric;">Realiza tu pago y envía el comprobante (sólo para métodos que lo requieran)</li>
                    <li style="list-style: numeric;"><b>Espera la notificación</b> en tu correo electrónico, te diremos cuando esten listas para descargar e imprimir tus guías de envío</li>
                    <li style="list-style: numeric;">Descarga, imprime y pega</li>
                    <li style="list-style: numeric;">¡Listo!</li>
                  </ol>
                  <div class="responsive-embed-container">
                    <iframe class="mt-2 responsive-embed-item" src="https://www.youtube-nocookie.com/embed/5wCmiObf1UY" frameborder="0" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  </div>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#2" aria-expanded="true" aria-controls="collapseOne">
                ¿Puedo cotizar sin tener que pagar algun monto?
                </button>
              </div>
              <div id="2" class="collapse-info-faq" data-parent="#faq">
                <div class="card-body">
                  ¡Claro que sí!, en Shippr te damos todas las herramientas necesarias para que enviar sea rápido y sencillo, puedes cotizar fácilmente cualquier envío <a href="informacion/calcular-peso-volumetrico">aquí</a>, te mostraremos tarifas basadas en las medida de tu paquete y su peso volumétrico.
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#3" aria-expanded="true" aria-controls="collapseOne">
                ¿Cuántos envíos puedo hacer?
                </button>
              </div>
              <div id="3" class="collapse-info-faq" data-parent="#faq">
                <div class="card-body">
                Todos los que necesites, en Shippr no tenemos ningún límite de envíos por usuario, puedes hacer todos los que requiera tu empresa o negocio para operar eficientemente y en su totalidad, puedes agregar más de 1 envío por operación o compra, facilitándote el proceso de pago y administración de todos estos.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulario de consulta extra -->
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            ¿No encuentras respuesta a lo que buscas?
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <h3>Completa el formulario</h3>
          <p>Déjanos tu pregunta o comentario para poder ayudarte lo más pronto posible</p>
          <form id="inf_consulting_form">
            <div class="form-group">
              <small class="d-block">¿Cuál es tu dirección de correo electrónico?</small>
              <input type="email" class="form-control" name="inf_email" value="<?php echo get_user_email() ?>">
            </div>
            <div class="form-group">
              <small class="d-block">¿Cuál es tu duda?</small>
              <input type="hidden" class="form-control" name="inf_asunto" value="Nueva consulta recibida" required>
              <input type="text" class="form-control" name="inf_pregunta" required>
            </div>
            <div class="form-group">
              <small class="d-block">¿Nos cuentas más por favor?</small>
              <textarea name="inf_contenido" cols="30" rows="5" class="form-control" required></textarea>
            </div>
            <button class="btn btn-success" type="submit">Enviar pregunta</button>
          </form>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>