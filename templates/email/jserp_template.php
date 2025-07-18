<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
  <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
  <title>*|JS_SUBJECT|*</title> <!-- The title tag shows in email notifications, like Android 4.4. -->

  <style>

    /* What it does: Remove spaces around the email design added by some email clients. */
    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
    html,
    body {
      margin: 0 auto !important;
      padding: 0 !important;
      height: 100% !important;
      width: 100% !important;
    }

    /* What it does: Stops email clients resizing small text. */
    * {
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%;
    }

    /* What it does: Centers email on Android 4.4 */
    div[style*="margin: 16px 0"] {
      margin: 0 !important;
    }

    /* What it does: Stops Outlook from adding extra spacing to tables. */
    table,
    td {
      mso-table-lspace: 0pt !important;
      mso-table-rspace: 0pt !important;
    }

    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
    table {
      border-spacing: 0 !important;
      border-collapse: collapse !important;
      table-layout: fixed !important;
      margin: 0 auto !important;
    }
    table table table {
      table-layout: auto;
    }

    /* What it does: Uses a better rendering method when resizing images in IE. */
    img {
      -ms-interpolation-mode:bicubic;
    }

    /* What it does: A work-around for email clients meddling in triggered links. */
    *[x-apple-data-detectors],  /* iOS */
    .x-gmail-data-detectors,    /* Gmail */
    .x-gmail-data-detectors *,
    .aBn {
      border-bottom: 0 !important;
      cursor: default !important;
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
    .a6S {
      display: none !important;
      opacity: 0.01 !important;
    }
    /* If the above doesn't work, add a .g-img class to any image in question. */
    img.g-img + div {
      display: none !important;
    }

    /* What it does: Prevents underlining the button text in Windows 10 */
    .button-link {
      text-decoration: none !important;
    }

    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
    /* Create one of these media queries for each additional viewport size you'd like to fix */

    /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
      .email-container {
        min-width: 320px !important;
      }
    }
    /* iPhone 6, 6S, 7, 8, and X */
    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
      .email-container {
        min-width: 375px !important;
      }
    }
    /* iPhone 6+, 7+, and 8+ */
    @media only screen and (min-device-width: 414px) {
      .email-container {
        min-width: 414px !important;
      }
    }

  </style>
  <!-- CSS Reset : END -->

  <!-- Progressive Enhancements : BEGIN -->
  <style>

  /* What it does: Hover styles for buttons */
  .btn {
    font-family: sans-serif; 
    font-size: 16px; 
    padding: 10px 20px; 
    max-width: 300px; 
    font-weight: 500; 
    margin-right: 10px; 
    color: white; 
    font-weight: bold; 
    text-decoration: none; 
    display: inline-block; 
    margin-bottom: 20px;
  }

  .btn-primary {
    background-color: #146dcc; 
    transition: all 300ms ease-in;
  }
  .btn-primary:hover {
    background: #0f61b9 !important;
  }

   .btn-secondary {
    background-color: #6C757D;
    transition: all 300ms ease-in;
  }
  .btn-secondary:hover {
    background: #5F676E !important;
  }

   .btn-success {
    background-color: #28A745;
    transition: all 300ms ease-in;
  }
  .btn-success:hover {
    background: #228F3B !important;
  }

   .btn-warning {
    background-color: #FFC107;
    transition: all 300ms ease-in;
  }
  .btn-warning:hover {
    background: #DEA806 !important;
  }

   .btn-danger {
    background-color: #DC3545;
    transition: all 300ms ease-in;
  }
  .btn-danger:hover {
    background: #C22F3D !important;
  }

  /* Media Queries */
  @media screen and (max-width: 600px) {

    /* What it does: Adjust typography on small screens to improve readability */
    .email-container p {
      font-size: 17px !important;
    }

  }

  </style>


</head>
<body width="100%" style="margin: 0; mso-line-height-rule: exactly;">
  <center style="width: 100%; background: #E9EBEE; text-align: left;">
  

    <!-- Visually Hidden Preheader Text : BEGIN -->
    <div style="display: none; font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      *|JS_ALTBODY|*
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
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: left; padding: 0 10px;">
                        <img src="http://www.saisco.com.mx/templates/images/logo.svg" width="200" height="" alt="alt_text" border="0" align="center" style="width: 100%; max-width: 200px; background: #ffffff; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;">
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
        </tr>
        <!-- 

        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td style="text-align: left; padding: 0 10px; font-family: sans-serif;">
                  <img src="https://via.placeholder.com/800x400" alt="image" style="width: 100%; height:auto;">
                </td>
                
              </tr>
            </table>
          </td>
        </tr>

         -->
        
        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px; background-color: #F8F8FA;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: left; padding: 0 10px; font-family: sans-serif;">
                        <h1 style="margin: 0; font-size: 42px;  max-width: 350px; 
                        line-height: 54px; font-weight: 500; color: black; margin-bottom: 20px;">
                        <span style="font-weight: 700;">H1</span> - Este sera un título para encabezado.</h1>
                        <h2 style="margin: 0; font-size: 32px;  max-width: 350px; 
                        line-height: 44px; font-weight: 500; color: black; margin-bottom: 20px;">
                        <span style="font-weight: 700;">H2</span> - Este sera un título para encabezado.</h2>
                        <h3 style="margin: 0; font-size: 22px;  max-width: 350px; 
                        line-height: 34px; font-weight: 500; color: black; margin-bottom: 20px;">
                        <span style="font-weight: 700;">H3</span> - Este sera un título para encabezado.</h3>
                        <h4 style="margin: 0; font-size: 16px;  max-width: 350px; 
                        line-height: 28px; font-weight: 500; color: black; margin-bottom: 20px;">
                        <span style="font-weight: 700;">H4</span> - Este sera un título para encabezado.</h4>
                        <p style="font-size: 16px; line-height: 28px; color: black;">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque minus accusantium impedit praesentium.
                        Incidunt odit eaque assumenda vero distinctio in quasi iusto laudantium, aliquid impedit atque, neque aperiam, minus reprehenderit?
                        </p>
                        <p><span style="font-weight: 700;">Este es un span</span></p>
                        <p><span style="font-weight: 700; color: #146dcc">Este es un span con color</span></p>
                      </td>
                    </tr>                                       
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px; background-color: #146dcc;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td style="text-align: left; padding: 0 10px; font-family: sans-serif;">
                        <h1 style="margin: 0; font-size: 42px;  max-width: 350px; 
                        line-height: 54px; font-weight: 500; color: white; margin-bottom: 20px;">
                        <span style="font-weight: 700;">H1</span> - Este sera un título para encabezado.</h1>
                        <p style="font-size: 16px; line-height: 28px; color: white;">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Cumque minus accusantium impedit praesentium.
                        Incidunt odit eaque assumenda vero distinctio in quasi iusto laudantium, aliquid impedit atque, neque aperiam, minus reprehenderit?
                        </p>
                      </td>
                    </tr>                                   
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                       
                    <tr>
                      <a href="#" class="btn btn-primary">Primary</a>
                      <a href="#" class="btn btn-secondary">Secondary</a>
                      <a href="#" class="btn btn-success" >Success</a>
                      <a href="#" class="btn btn-warning">Warning</a>
                      <a href="#" class="btn btn-danger">Danger</a>
                    </tr>                                  
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
            <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px;">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
                <tr>
                  <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                      <tr>
                        <td>
                          <table style="width: 100%; border: none;">
                            <tr>
                              <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
                                <h2 style="margin: 0; font-size: 32px;  max-width: 350px; 
                                line-height: 44px; font-weight: 500; color: black; margin-bottom: 20px;">
                                <span style="font-weight: 700;">Armor</span></h2>
                              </td>
                              <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
                                <h2 style="margin: 0; font-size: 32px;  max-width: 350px; 
                                line-height: 44px; font-weight: 500; color: black; margin-bottom: 20px;">
                                $512</h2>
                              </td>
                            </tr>
                          </table>
                          <hr style="margin-top: 20px; margin-bottom: 20px; border: 0; border-top: 1px solid #146dcc;">
                          <table style="width: 100%; border: none;">
                            <tr>
                              <td style="line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
                                <p style="font-size: 16px; line-height: 28px; color: black;">
                                  Hola
                                </p>
                              </td>
                              <td style="line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
                                <p style="font-size: 16px; line-height: 28px; color: black;">
                                  Hola
                                </p>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>                                  
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

        <tr>
          <td bgcolor="#ffffff" align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px;">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0" align="center" width="100%" style="max-width:560px;">
              <tr>
                <td align="left" valign="top" width="50%" style="font-family: sans-serif;">
                  <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="font-size: 14px; text-align: left;">
                    <tr>
                      <td>
                        <hr style="margin-top: 20px; margin-bottom: 20px;">
                        <table style="width: 100%; border: none;">
                          <tr>
                            <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: left; padding-right: 12px; direction: ltr;">
                              Item1
                            </td>
                            <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
                              Item2
                            </td>
                            <td style="font-weight:bold; line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
                              Item3
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-bottom: 5px; padding-top: 5px; padding-right: 12px;">
                              One
                            </td>
                            <td style="line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
                              Two
                            </td>
                            <td style="line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
                              Tree
                            </td>
                          </tr>
                          <tr>
                            <td style="padding-bottom: 5px; padding-top: 5px; padding-right: 12px;">
                              Four
                            </td>
                            <td style="line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: center; direction: ltr;">
                              Five
                            </td>
                            <td style="line-height: 28px; padding-bottom: 5px; padding-top: 5px; text-align: right; padding-left: 12px; direction: ltr;">
                              Six
                            </td>
                          </tr>
                        </table>
                        <hr style="margin-top: 20px; margin-bottom: 20px; color: #bdbdbd;">
                      </td>
                    </tr>                                  
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>

        <tr>
          <td align="center" height="100%" valign="top" width="100%" style="padding: 40px 10px 40px 10px; background-color: #2f2f2f;">
            <p style=" font-family: sans-serif; margin: 0; font-size: 14px;  max-width: 350px; 
            line-height: 26px; font-weight: 500; color: white; margin-bottom: 20px;">
              © SAISCO 2018. Todos los derechos reservados <br />
              Este es un email generado de forma dinámica.
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