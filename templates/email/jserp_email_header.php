<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
  <meta name="x-apple-disable-message-reformatting">  <!-- Disable auto-scale in iOS 10 Mail entirely -->
  <title><?php echo (isset($this->data['subject']) ? $this->data['subject'] : 'Nuevo mensaje generado') ?></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

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

    span {
      font-weight: 700;
    }

    h1 {
      font-size: 42px;
    }
    
    .data-body,
    .email-contanier,
    .email-container p,
    .email-container a,
    p,a {
      font-size: 18px !important;
      line-height: 20px !important;
      color: black;
    }

    .data-footer-text,
    .data-footer-text a {
      font-size: 14px !important;
      color: white !important;
      font-weight: 300 !important;
    }

    /** What it does: Styles for all tables formatted */
    .table {
      width: 100%;
      border: none;
      border-collapse: collapse;
    }

    .table tr th {
      font-weight: bold;
      line-height: 28px;
      padding-bottom: 5px;
      padding-top: 5px;
      direction: ltr;
    }

    .table tr td {
      line-height: 28px;
      padding-bottom: 3px;
      padding-top: 3px;
      direction: ltr;
    }

    .text-left {
      text-align: left;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    hr .divisor {
      margin: 10px 0px;
      color: #bdbdbd;
      background: #bdbdbd;
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
    font-weight: 400 !important; 
    margin-right: 10px; 
    color: white !important; 
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

  .d-block{
    display: block;
    margin: 0px;
    padding: 0px;
  }



  /* Media Queries */
  @media screen and (max-width: 600px) {

    /* What it does: Adjust typography on small screens to improve readability */
    .data-body,
    .email-contanier,
    .email-container p,
    .email-container a,
    p,a {
      font-size: 12px !important;
      line-height: 20px !important;
      color: black;
    }

    .data-footer-text,
    .data-footer-text a {
      font-size: 12px !important;
      color: white !important;
      font-weight: 300 !important;
    }

    h1 {
      font-size: 26px;
    }
    h2 {
      font-size: 22px;
    }
  }

  </style>


</head>