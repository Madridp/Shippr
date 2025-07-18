<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  <title><?php echo (isset($data['title'])) ? $data['title'] . " - " . get_sitename() : "En mantenimiento - " . get_sitename(); ?></title>

  <style>
    body {
      background: red;
    }
  </style>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body style="background: #f5f5f5;">

<div class="container p-5 mt-5 h-100">
  <div class="row h-100 align-items-center">
    <div class="col-xl-6 mx-auto text-center">
      <img src="<?php echo URL.IMG.'maintenance_mode.png'; ?>" alt="En mantenimiento" class="img-fluid" style="width: 250px;">
      <h2>Bee duuu be duu!</h2>
      <h5>Estamos ajustando algunos tornillos</h5>
      <p class="text-muted">La plataforma volverá en línea en unos minutos</p>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>