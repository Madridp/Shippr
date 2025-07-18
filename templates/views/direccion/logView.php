<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['direccion','Dirección General'],['',$d->title]]); ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="offset-xl-2 col-xl-8 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header"><?php echo $d->title; ?>
            <button class="btn btn-success btn-sm do_get_log float-right"><i class="fas fa-sync"></i></button>
          </h5>
          <div class="wrapper_log" style="white-space: pre-wrap;"><!-- ajax fill --></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>