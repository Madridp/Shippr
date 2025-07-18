<!DOCTYPE html>
<html lang="es">
<head>
	<base href="<?php echo BASEPATH ?>">
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<title><?php echo (isset($data['title'])) ? $data['title']." - ". get_sitename() : "Bienvenido - ".get_sitename(); ?></title>
	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
	name='viewport'/>

	<!-- SEO -->
	<meta name="keywords" content="<?php echo get_sitekeywords(); ?>">
	<meta name="robots" content="index">
	<meta name="description" content="<?php echo get_sitedesc(); ?>">
	<link rel="canonical" href="<?php echo get_siteurl(); ?>" />
	<meta property="og:locale" content="es_ES" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="<?php echo (isset($data['title'])) ? $data['title']." - ". get_sitename() : "Bienvenido - ".get_sitename(); ?>" />
	<meta property="og:description" content="<?php echo get_sitedesc(); ?>" />
	<meta property="og:url" content="<?php echo get_siteurl(); ?>" />
	<meta property="og:site_name" content="<?php echo get_sitename(); ?>" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="<?php echo get_sitedesc(); ?>" />
	<meta name="twitter:title" content="<?php echo get_sitename(); ?>" />
	<meta name="twitter:image" content="<?php echo get_sitelogo(); ?>" />
	<!-- 
	<script type='application/ld+json'>{"@context":"https:\/\/schema.org","@type":"WebSite","@id":"#website","url":"https:\/\/www.joystick.com.mx\/","name":"Joystick","potentialAction":{"@type":"SearchAction","target":"https:\/\/www.joystick.com.mx\/?s={search_term_string}","query-input":"required name=search_term_string"}}</script>
	Ends SEO. -->

	<!-- Dinamyc favicon -->
	<?php echo get_header_sitefavicon() ?>

	<!--Fonts-->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,600,700,800,900" rel="stylesheet">

	<!-- Lightbox -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">

	<!-- Ionicons CDN -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

	<!-- Sweet alert css -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

	<!-- Dropzone CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.css">

	<!-- Bootstrap Select 2.0 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

	<!-- jQuery UI theme -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<!-- Font Awesome 5 shims -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/v4-shims.css">

	<!-- Morris js -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

	<!-- DataTables js -->
	<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet"/>
	<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet"/>

	<!-- Full calendar -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css" media="print">

	<!-- Editor WYSIWYG-->
	<link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
	<link href='https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_style.min.css' rel='stylesheet' type='text/css' />

	<!-- Pretty Checkbox -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css"/>

	<!-- Toastr notifications -->
	<link href="<?php echo PLUGINS.'toastr/toastr.min.css' ?>" rel="stylesheet"/>

	<!-- Mercado Pago -->
	<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

	<!-- Lazy loaded files -->

	<?php echo load_styles(); ?>
	
	<!-- End of lazy loaded files -->

	<!-- Custom CSS Files -->
	<link href="assets/plugins/bootstrap/css/bootstrap.css" rel="stylesheet"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-grid.css" rel="stylesheet"/>
	<link href="assets/plugins/bootstrap/css/bootstrap-reboot.css" rel="stylesheet"/>
	<!-- <link href="assets/css/colors.css" rel="stylesheet" id="themecolor"/> -->
	<link href="<?php echo URL.'assets/css/style.css' ?>" rel="stylesheet"/>
	<link href="<?php echo URL.'assets/css/main.css' ?>" rel="stylesheet"/>

	<!-- Load sitetheme dynamictly -->
	<?php echo load_sitetheme(get_sitetheme()); ?>
	<!-- ends sitetheme -->
	
	<style id="clock-animations"></style>

	<style>
		.v-middle tr td,
		.v-middle tr th {
			vertical-align: middle;
		}
	</style>

	<?php echo get_hotjar_script(); ?>
</head>
<!--Body Begins-->
<body>
<!--Begin Loading-->
<div class="preloader">
	<div class="loading">
		<h2>
				Cargando...
		</h2>
		<span class="progress"></span>
	</div>
</div>
<!--End Loading-->
<!-- header.php ends -->