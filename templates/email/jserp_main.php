<?php require 'jserp_email_header.php' ?>

<!-- Content goes below this line -->
<body width="100%" style="margin: 0; mso-line-height-rule: exactly;">
  <center style="width: 100%; background: #E9EBEE; text-align: left;">
  

    <!-- Visually Hidden Preheader Text : BEGIN -->
    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      <?php echo (isset($this->data['altbody']) ? $this->data['altbody'] : 'Nuevo mensaje generado') ?>
    </div>
    <!-- Visually Hidden Preheader Text : END -->

    <!--
      Set the email width. Defined in two places:
      1. max-width for all clients except Desktop Windows Outlook, allowing the email to squish on narrow but never go wider than 600px.
      2. MSO tags for Desktop Windows Outlook enforce a 600px width.
    -->
    <div style="max-width: 700px; margin: auto; padding: 0;" class="email-container">
      <!--[if mso]>
      <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="600" align="center">
      <t>
      <td>
      <![endif]-->
       
      <!-- Email Body : BEGIN -->
      <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 700px;">
        
        <!-- 2 Even Columns : BEGIN -->
        <tr>
          <?php switch(get_email_alignment()) : case 'center': ?>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 20px 10px 40px 10px">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr align="center">
                <td align="center" valign="top" width="100%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: right;">
                    <tr style="margin-bottom: 20px; margin-top: 20px; border-bottom: 1px solid #ebebeb;">
                      <td style="text-align: right; padding: 0 10px;">
                        <p style="padding-bottom: 20px;"><?php echo fecha(ahora()); ?></p>
                      </td>
                    </tr>  
                  </table>
                </td>
              </tr>
            </table>
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr align="center">
                <td align="center" valign="top" width="100%">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: center;">
                    <tr>
                      <td style="text-align: center; padding: 0 10px;">
                        <img src="<?php echo get_sitelogo(250); ?>" width="150px" height="" alt="<?php echo get_sitename(); ?>" border="0" align="center" style="width: 100%; max-width: 150px; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555; margin-top: 20px;">
                      </td>
                    </tr>                                        
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <?php break; ?>
          <?php case 'right': ?>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: left; padding: 0 10px;">
                        <p style="margin: 0;"><?php echo fecha(ahora()); ?></p>
                      </td>
                    </tr>                                       
                  </table>
                </td>
                <td align="left" valign="top" width="50%">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: right; padding: 0 10px;">
                        <img src="<?php echo get_sitelogo(250); ?>" width="150px" height="" alt="<?php echo get_sitename(); ?>" border="0" align="center" style="width: 100%; max-width: 150px; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                      </td>
                    </tr>                                        
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <?php break; ?>
          <?php default: ?>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: left; padding: 0 10px;">
                        <img src="<?php echo get_sitelogo(250); ?>" width="150px" height="" alt="<?php echo get_sitename(); ?>" border="0" align="center" style="width: 100%; max-width: 150px; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
                      </td>
                    </tr>                                        
                  </table>
                </td>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: right; padding: 0 10px;">
                        <p style="margin: 0;"><?php echo fecha(ahora()); ?></p>
                      </td>
                    </tr>                                       
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <?php break; ?>
          <?php endswitch; ?>
        </tr>

        <?php if (isset($this->data['banner'])): ?>
        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="middle" width="100%" style="padding: 0px">
            <img src="<?php echo $this->data['banner'] ?>" alt="<?php echo (isset($this->data['altbanner']) ? $this->data['altbanner'] : get_sitename()) ?>" style="width: 100%; height:auto;">
          </td>
        </tr>
        <?php endif; ?>

        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px; background-color: #F8F8FA;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: left; padding: 0 15px; font-family: sans-serif;" class="data-body">
                        <h1 style="margin: 0; max-width: 100%; line-height: 54px; font-weight: 500; color: black; margin-bottom: 20px;">
                        <?php echo (isset($this->data['title']) ? $this->data['title'] : 'Nuevo mensaje generado') ?></h1>

                        <?php echo (isset($this->data['body']) ? $this->data['body'] : 'El cuerpo del mensaje está vacío.') ?>
                      </td>
                    </tr>                                       
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <td align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px; background-color: #2f2f2f;">
          <p style=" font-family: sans-serif; margin: 0; max-width: 400px; 
          line-height: 20px; color: white; margin-bottom: 20px;" class="data-footer-text">
            <?php echo get_sitename() ?> © <?php echo date('Y') ?>. Todos los derechos reservados<br />
            Este es un email generado de forma automática.<br>
            Powered by <a href="https://www.joystick.com.mx" target="_blank" style="color: white;">Joystick</a>
          </p>
        </td>
        </tr>
      </table>
    </div>
  <!--[if mso | IE]>
  </td>
  </t>
  </table>
  <![endif]-->
  </center>
</body>
</html>