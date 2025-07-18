<?php require PDF . 'header_pdf.php'; ?>
<page backtop="30mm" backbottom="50mm" backleft="0mm" backright="0mm">
  <page_header>
    <?php switch(get_pdf_alignment()) : case 'left': ?>
    <table style="width: 100%; font-size: 9px;">
      <tr>
        <td style="width: 25%;vertical-align: top;" class="text-left">
          <img src="<?php echo get_sitelogo(); ?>" alt="<?php echo get_sitename() ?>" style="width: 120px">
        </td>

        <td style="width: 25%; vertical-align: top;">
          <table style="width: 100%;">
            <tr>
              <td class="text-left">Folio de reporte</td>
            </tr>
            <tr>
              <td class="write-line"></td>
            </tr>
            <tr>
              <td class="text-left">Fecha</td>
            </tr>
            <tr>
              <td class="write-line"></td>
            </tr>
          </table>
        </td>

        <td style="width: 5%; vertical-align: top;">
        </td>

        <td style="width: 20%; vertical-align: top;">
          <table style="width: 100%;">
            <tr>
              <td class="text-right">Tipo de servicio</td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td class="write-checkbox"></td>
              <td>Preventivo</td>
              <td class="write-checkbox"></td>
              <td>Correctivo</td>
            </tr>
            <tr>
              <td class="write-checkbox"></td>
              <td>Rev. y diag.</td>
              <td class="write-checkbox-checked"></td>
              <td>Montaje</td>
            </tr>
          </table>
        </td>

        <td style="width: 25%; vertical-align: top;" class="text-right">
          Datos de contacto<br>
          <?php echo get_email_address_for('contacto'); ?><br>
          <?php echo get_sitedomain() ?><br>
          <span style="margin-top: 5px;">Folio de orden<br>
          <strong class="text-danger"><?php echo 'OS-' . randomPassword(6, 'numeric') ?></strong></span>
        </td>
      </tr>
    </table>
    <?php break; ?>
    <?php case 'right': ?>
    <table style="width: 100%; font-size: 9px;">
      <tr>
        <td style="width: 25%; vertical-align: top;" class="text-left">
          Datos de contacto<br>
          <?php echo get_email_address_for('contacto'); ?><br>
          <?php echo get_sitedomain() ?><br>
          <span style="margin-top: 5px;">Folio de orden<br>
          <strong class="text-danger"><?php echo 'OS-' . randomPassword(6, 'numeric') ?></strong></span>
        </td>

        <td style="width: 25%; vertical-align: top;">
          <table style="width: 100%;">
            <tr>
              <td class="text-left">Folio de reporte</td>
            </tr>
            <tr>
              <td class="write-line"></td>
            </tr>
            <tr>
              <td class="text-left">Fecha</td>
            </tr>
            <tr>
              <td class="write-line"></td>
            </tr>
          </table>
        </td>

        <td style="width: 5%; vertical-align: top;">
        </td>

        <td style="width: 20%; vertical-align: top;">
          <table style="width: 100%;">
            <tr>
              <td class="text-right">Tipo de servicio</td>
            </tr>
          </table>
          <table style="width: 100%;">
            <tr>
              <td class="write-checkbox"></td>
              <td>Preventivo</td>
              <td class="write-checkbox"></td>
              <td>Correctivo</td>
            </tr>
            <tr>
              <td class="write-checkbox"></td>
              <td>Rev. y diag.</td>
              <td class="write-checkbox-checked"></td>
              <td>Montaje</td>
            </tr>
          </table>
        </td>

        <td style="width: 25%;vertical-align: top;" class="text-right">
          <img src="<?php echo get_sitelogo(); ?>" alt="<?php echo get_sitename() ?>" style="width: 120px">
        </td>

        
      </tr>
    </table>
    <?php break; ?>
    <?php default: ?>
    <table style="width: 100%; font-size: 9px;">
      <tr>
        <td style="width: 25%; vertical-align: top;">
          Datos de contacto<br>
          <?php echo get_email_address_for('contacto'); ?><br>
          <?php echo get_sitedomain() ?><br>
          <span style="margin-top: 5px;">Folio de orden<br>
          <strong class="text-danger"><?php echo 'OS-'.randomPassword(6,'numeric') ?></strong></span>
        </td>

        <td style="width: 50%; text-align: center; vertical-align: top;">
          <img src="<?php echo get_sitelogo(); ?>" alt="<?php echo get_sitename() ?>" style="width: 120px">
        </td>

        <td style="width: 25%; vertical-align: top;">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td class="text-right">Folio de reporte</td>
              </tr>
              <tr>
                <td class="write-line"></td>
              </tr>
              <tr>
                <td class="text-right">Fecha</td>
              </tr>
              <tr>
                <td class="write-line"></td>
              </tr>
            </tbody>
          </table>
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td class="text-right">Tipo de servicio</td>
              </tr>
            </tbody>
          </table>
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td class="write-checkbox"></td>
                <td>Preventivo</td>
                <td class="write-checkbox"></td>
                <td>Correctivo</td>
              </tr>
              <tr>
                <td class="write-checkbox"></td>
                <td>Rev. y diag.</td>
                <td class="write-checkbox-checked"></td>
                <td>Montaje</td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
    <?php endswitch; ?>
  </page_header>
    
  <h1 style="font-size: 16px; color: #146dcc; margin-top: 0px; margin-bottom: 5px;">Orden de servicio</h1>
  <!-- Cliente -->
  <table>
    <tbody>
      <tr>
        <td>Datos del cliente</td>
      </tr>
    </tbody>
  </table>
  <table style="width: 100%;">
    <tr>
      <td class="w-20">
        <label>Nombre o razón social</label><br>
      </td>
      <td class="write-line w-80"></td>
    </tr>
    <tr>
      <td class="w-20">
        <label>Sucursal</label><br>
      </td>
      <td class="write-line w-80"></td>
    </tr>
    <tr>
      <td class="w-20">
        <label>Dirección</label><br>
      </td>
      <td class="write-line w-80"></td>
    </tr>
  </table>
  <br>

  <!-- Equipo -->
  <table>
    <tbody>
      <tr>
        <td>Datos del equipo</td>
      </tr>
    </tbody>
  </table>
  <table style="width: 100%;">
    <tr>
      <td class="w-20">
        <label>Tipo de equipo</label><br>
      </td>
      <td class="write-line w-30"></td>
      <td class="w-20">
        <label>Marca</label><br>
      </td>
      <td class="write-line w-30"></td>
    </tr>
    <tr>
      <td class="w-20">
        <label>Modelo</label><br>
      </td>
      <td class="write-line w-30"></td>
      <td class="w-20">
        <label>Número de serie</label><br>
      </td>
      <td class="write-line w-30"></td>
    </tr>
  </table>
  <br>

  <!-- Descripción del trabajo -->
  <table>
    <tbody>
      <tr>
        <td>Datos del trabajo</td>
      </tr>
    </tbody>
  </table>
  <table style="width: 100%;">
    <tbody>
      <tr>
        <td style="width: 100%;">
          <label>Trabajo realizado</label><br>
        </td>
      </tr>
      <tr>
        <td style="height: 180px; width: 100%; border: 0.5px solid #9A9A9A;"></td>
      </tr>
    </tbody>
  </table>
  
  <!-- Horarios y sistemas -->
  <table style="width: 100%;">
    <tbody>
      <tr>
        <td style="width: 50%; vertical-align: top;">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td style="width: 100%;">
                  <label>Horarios y fechas de trabajo</label><br>
                </td>
              </tr>
              <tr>
                <td style="width: 100%;">
                  <small>Horas: 13:00-14:00 y fechas: 01/12/2018</small>
                </td>
              </tr>
            </tbody>
          </table>
          <table style="width: 100%;">
            <tbody>
              <tr style="padding-bottom: 10px;">
                <td style="width: 26%;">
                  <small>Lunes</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Martes</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Miercoles</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Jueves</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Viernes</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Sábado</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Domingo</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
              <tr>
                <td style="width: 26%;">
                  <small>Totales</small>
                </td>
                <td class="write-line w-30"></td>
                <td class="write-line w-30"></td>
              </tr>
            </tbody>
          </table>
        </td>
        <td style="width: 50%; vertical-align: top;">
          <table style="width: 100%;">
            <tbody>
              <tr>
                <td style="width: 100%;">
                  <label>Sistemas revisados</label><br>
                </td>
              </tr>
            </tbody>
          </table>
          <table style="width: 100%; font-size: 9px; border: 1px solid #9A9A9A; padding: 3px;">
            <tbody>
              <tr>
                <td style="width: 6px; height: 6px; border: 1px solid #146dcc;"></td>
                <td>Electrónico</td>
              </tr>
              <tr>
                <td style="width: 6px; height: 6px; border: 1px solid #146dcc;"></td>
                <td>Mecánico</td>
              </tr>
              <tr>
                <td style="width: 6px; height: 6px; border: 1px solid #146dcc;"></td>
                <td>Software</td>
              </tr>
              <tr>
                <td style="width: 6px; height: 6px; border: 1px solid #146dcc;"></td>
                <td>Emisión de Rx</td>
              </tr>
              <tr>
                <td style="width: 6px; height: 6px; border: 1px solid #146dcc;"></td>
                <td>Digital</td>
              </tr>
              <tr>
                <td style="width: 6px; height: 6px; border: 1px solid #146dcc;"></td>
                <td>Periférico</td>
              </tr>
            </tbody>
          </table>
          <table style="width: 100%; margin-top: 30px;">
            <tbody>
              <tr>
                <td style="width: 100%;">
                  <label>Refacciones utilizadas</label><br>
                </td>
              </tr>
              <tr>
                <td class="write-line w-100"></td>
              </tr>
              <tr>
                <td class="write-line w-100"></td>
              </tr>
              <tr>
                <td class="write-line w-100"></td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
  <!-- Firmas -->
  <page_footer>
    <table style="width: 100%;">
      <tbody>
        <tr>
          <td style="width: 6%;"></td>
          <td style="width: 40%;">
            <table style="width: 100%; font-size: 9px;">
              <tbody>
                <tr>
                  <td style="height: 70px; width: 100%; border: 1px solid #9A9A9A; border-radius: 2px;"></td>
                </tr>
                <tr>
                  <td style="text-align: center; color:#9A9A9A;">
                    Nombre y firma Ingeniero<br>
                    <?php echo get_sitename(); ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td style="width: 8%;"></td>
          <td style="width: 40%;">
            <table style="width: 100%; font-size: 9px;">
              <tbody>
                <tr>
                  <td style="height: 70px; width: 100%; border: 1px solid #9A9A9A; border-radius: 2px;"></td>
                </tr>
                <tr>
                  <td style="text-align: center; color: #9A9A9A;">
                    Nombre y firma del cliente<br><br>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td style="width: 6%;"></td>
        </tr>
      </tbody>
    </table>
  </page_footer>
</page>






