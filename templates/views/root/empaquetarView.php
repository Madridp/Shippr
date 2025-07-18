<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!-- content  -->
<div class="content">
	<?php echo get_breadcrums([['root','Root'],['',$d->title]]); ?>
	<?php flasher() ?>

	<div class="row">
		<div class="col-xl-6 col-12">
      <div class="pvr-wrapper">
        <div class="pvr-box horizontal-form">
          <h5 class="pvr-header">Completa el formulario</h5>
          <p>Empaquetar nueva versión de ERP para lanzamiento</p>
          <form action="root/pack-new-version" method="POST">
            <?php echo insert_inputs(); ?>
            <div class="form-group">
              <label for="">Versión</label>
              <input type="text" class="form-control" name="version" placeholder="<?php echo get_siteversion(); ?>" required>
            </div>
            <label for="">Excluir carpetas</label>
            <div class="form-group row">
              <?php foreach (get_newversion_excluded_dirs() as $dir): ?>
                <div class="col-xl-4 col-12">
                  <input class="form-check-check" type="checkbox" name="excluded[]" value="<?php echo $dir ?>" id="<?php echo $dir ?>" checked>
                  <label class="form-check-label" for="<?php echo $dir ?>"><?php echo $dir ?></label>
                </div>
              <?php endforeach; ?>
            </div>
            <button class="btn btn-success ladda-button do-backup" data-style="expand-right" name="submit"><span class="ladda-label">Launch</span></button>
          </form>
        </div>
      </div>
		</div>
	</div>
</div>
<!-- ends content -->

<?php require INCLUDES . 'footer.php' ?>