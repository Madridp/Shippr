<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content">
  <?php echo get_breadcrums([['','Recolección']]); ?>

  <?php flasher() ?>
  
  <!-- Gráficas -->
  <div class="row">
    <div class="col-xl-2"></div>
    <div class="col-xl-8">
      <div class="pvr-wrapper">
        <div class="pvr-box">
          <h5 class="pvr-header">
            Recolección de paquetes
            <div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
          </h5>

          <div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#fedex" role="tab" aria-controls="fedex" aria-expanded="true" aria-selected="true">FedEx</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#dhl" role="tab" aria-controls="dhl" aria-expanded="false" aria-selected="false">DHL</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#redpack" role="tab" aria-controls="redpack" aria-expanded="false" aria-selected="false">Redpack</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#ups" role="tab" aria-controls="ups" aria-expanded="false" aria-selected="false">UPS</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="#estafeta" role="tab" aria-controls="estafeta" aria-expanded="false" aria-selected="false">Estafeta</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div role="tabpanel" class="tab-pane fade active show" id="fedex" aria-labelledby="fedex-tab" aria-expanded="true">
                  <img src="<?php echo URL.IMG.'picking-fedex.png' ?>" alt="FedEx" class="img-fluid" style="width: 100%;">
                  <h1>Recolección FedEx</h1>
                  <p>Para realizar el envío de tu paquete, debes imprimir el documento o guía dos veces, una será pegada en el paquete y la otra entregada al personal de FedEx que reciba el envío.</p>
                  <p>Puedes llevarlo a cualquier sucursal y entregarlo en mostrador, o solicitar la recolección a tu domicilio por teléfono, debe ser antes de las 15:00 horas de lunes a viernes, solo deberás mencionar el número de guía y confirmar la dirección de recolección.</p>
                  <p>Los días sábados la recolección puede tener un costo extra.</p>
                  <p>Línea FedEx: <b>01-800-003-3339</b></p>
                  <p>Gracias por la confianza y preferencia.</p>
                  <hr>
                  <p>Recuerda que hay normativas y reglas referentes a los <a href="informacion/articulos-prohibidos">artículos prohibidos</a>, los cuáles no deben ser mandados por paquetería o mensajería, el envío de dichos productos es completa responsabilidad del cliente y <?php echo get_sitename() ?> no se hace responsable por las consecuencias.</p>
                </div>

                <div class="tab-pane fade" id="dhl" role="tabpanel" aria-labelledby="dhl-tab" aria-expanded="false">
                  <img src="<?php echo URL.IMG.'picking-dhl.png' ?>" alt="DHL" class="img-fluid" style="width: 100%;">
                  <h1>Recolección DHL</h1>
                  <p>Para realizar el envío de tu paquete, debes imprimir el documento o guía dos veces, una será pegada en el paquete y la otra entregada al personal de DHL que reciba el envío.</p>
                  <p>Puedes llevarlo a cualquier sucursal y entregarlo en mostrador, o solicitar la recolección a tu domicilio por teléfono, debe ser antes de las 15:00 horas de lunes a viernes, solo deberás mencionar el número de guía y confirmar la dirección de recolección.</p>
                  <p>Los días sábados la recolección puede tener un costo extra.</p>
                  <p>Líneas DHL: <b>55-53-45-70-00</b> o <b>501-2-31070</b></p>
                  <p>Gracias por la confianza y preferencia.</p>
                  <hr>
                  <p>Recuerda que hay normativas y reglas referentes a los <a href="informacion/articulos-prohibidos">artículos prohibidos</a>, los cuáles no deben ser mandados por paquetería o mensajería, el envío de dichos productos es completa responsabilidad del cliente y <?php echo get_sitename() ?> no se hace responsable por las consecuencias.</p>
                </div>

                <div class="tab-pane fade" id="redpack" role="tabpanel" aria-labelledby="redpack-tab" aria-expanded="false">
                  <img src="<?php echo URL.IMG.'picking-redpack.png' ?>" alt="Redpack" class="img-fluid" style="width: 100%;">
                  <h1>Recolección Redpack</h1>
                  <p>Para realizar el envío de tu paquete, debes imprimir el documento o guía dos veces, una será pegada en el paquete y la otra entregada al personal de Redpack que reciba el envío.</p>
                  <p>Puedes llevarlo a cualquier sucursal y entregarlo en mostrador, o solicitar la recolección a tu domicilio por teléfono o internet, debe ser antes de las 15:00 horas de lunes a viernes, solo deberás mencionar el número de guía y confirmar la dirección de recolección.</p>
                  <p>Interior de la república <b>01-800-013-3333</b></p>
                  <p>Ciudad de México y Área Metropolitana <b>55 3682-4040</b></p>
                  <p>También puedes solicitarla <a href="https://extranet.redpack.com.mx/extranet/Recoleccion_Redpack.do" target="_blank">aquí</a> en cuestión de segundos.</p>
                  <p>Gracias por la confianza y preferencia.</p>
                  <hr>
                  <p>Recuerda que hay normativas y reglas referentes a los <a href="informacion/articulos-prohibidos">artículos prohibidos</a>, los cuáles no deben ser mandados por paquetería o mensajería, el envío de dichos productos es completa responsabilidad del cliente y <?php echo get_sitename() ?> no se hace responsable por las consecuencias.</p>
                </div>

                <div class="tab-pane fade" id="ups" role="tabpanel" aria-labelledby="ups-tab" aria-expanded="false">
                  <img src="<?php echo URL.IMG.'picking-ups.png' ?>" alt="UPS" class="img-fluid" style="width: 100%;">
                  <h1>Recolección UPS</h1>
                  <p>Para realizar el envío de tu paquete, debes imprimir el documento o guía dos veces, una será pegada en el paquete y la otra entregada al personal de UPS que reciba el envío.</p>
                  <p>Puedes llevarlo a cualquier sucursal y entregarlo en mostrador, o solicitar la recolección a tu domicilio por teléfono o internet, debe ser antes de las 15:00 horas de lunes a viernes, solo deberás mencionar el número de guía y confirmar la dirección de recolección.</p>
                  <p>Línea UPS: <b>01-800-PIDE-UPS</b> o <b>01-800-7433-877</b></p>
                  <p>Descuento promocional para PYMES <b>01-800-7433-877 Opción 5</b></p>
                  <p>También puedes solicitarla <a href="https://wwwapps.ups.com/pickup/schedule?loc=es_MX" target="_blank">aquí</a> en cuestión de minutos.</p>
                  <p>Gracias por la confianza y preferencia.</p>
                  <hr>
                  <p>Recuerda que hay normativas y reglas referentes a los <a href="informacion/articulos-prohibidos">artículos prohibidos</a>, los cuáles no deben ser mandados por paquetería o mensajería, el envío de dichos productos es completa responsabilidad del cliente y <?php echo get_sitename() ?> no se hace responsable por las consecuencias.</p>
                </div>

                <div class="tab-pane fade" id="estafeta" role="tabpanel" aria-labelledby="estafeta-tab" aria-expanded="false">
                  <img src="<?php echo URL.IMG.'picking-estafeta.png' ?>" alt="Estafeta" class="img-fluid" style="width: 100%;">
                  <h1>Recolección Estafeta</h1>
                  <p>Para realizar el envío de tu paquete, debes imprimir el documento o guía dos veces, una será pegada en el paquete y la otra entregada al personal de Estafeta que reciba el envío.</p>
                  <p>Puedes llevarlo a cualquier sucursal y entregarlo en mostrador, o solicitar la recolección a tu domicilio por teléfono, debe ser antes de las 15:00 horas de lunes a viernes, solo deberás mencionar el número de guía y confirmar la dirección de recolección.</p>
                  <p>Línea Estafeta: <b>01 800 3782 338 Opción 3</b> y proporciona tu número confirmación de 22 dígitos (se encuentra debajo del código de rastreo). El horario de atención es de lunes a viernes de 08:00 a 20:00 horas, los días sábados atienden de 08:00 a 12:00.</p>
                  <p>Si solicitaste una recolección y no acudieron, ingresa <a href="https://www.estafeta.com/Contacto/" target="_blank">aquí</a>.</p>
                  <p>Gracias por la confianza y preferencia.</p>
                  <hr>
                  <p>Recuerda que hay normativas y reglas referentes a los <a href="informacion/articulos-prohibidos">artículos prohibidos</a>, los cuáles no deben ser mandados por paquetería o mensajería, el envío de dichos productos es completa responsabilidad del cliente y <?php echo get_sitename() ?> no se hace responsable por las consecuencias.</p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- row -->
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>