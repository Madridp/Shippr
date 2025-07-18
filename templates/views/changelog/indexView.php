<?php require INCLUDES.'header.php' ?>
<?php require INCLUDES.'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['',$d->title]]) ?>
	<?php flasher(); ?>

	<div class="row">
		<div class="offset-xl-3 col-xl-6 col-12">
      <div class="row">
        <div class="col-12">
        <?php if ($d->changes): ?>
          <?php foreach ($d->changes as $v => $changes): ?>
            <div class="pvr-wrapper">
              <div class="pvr-box">
                <h5 class="pvr-header"><?php echo sprintf('Release <b>%s</b>', $v); ?></h5>
                <ul class="list-group">
                <?php foreach ($changes as $c): ?>
                  <li class="list-group-item">
                    <?php if ($c[0] == 'done'): ?>
                      <span class="badge badge-success"><?php echo $c[0] ?></span>
                    <?php elseif($c[0] == 'working'): ?>
                      <span class="badge badge-info"><?php echo $c[0] ?></span>
                    <?php elseif($c[0] == 'pending'): ?>
                      <span class="badge badge-danger"><?php echo $c[0] ?></span>
                    <?php elseif($c[0] == 'fixed'): ?>
                      <span class="badge badge-warning"><?php echo $c[0] ?></span>
                    <?php elseif($c[0] == 'to-do'): ?>
                      <span class="badge badge-primary"><?php echo $c[0] ?></span>
                    <?php else: ?>
                      <span class="badge badge-default">...</span>
                    <?php endif; ?>
                    <?php echo $c[1]; ?>
                  </li>
                <?php endforeach; ?>
                </ul>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="pvr-wrapper">
            <div class="pvr-box">
              <h5 class="pvr-header"><?php echo $d->title; ?></h5>
              <div class="text-center py-5">
                <img src="<?php echo IMG . 'es-changelog.png'; ?>" alt="No hay cambios" class="img-fluid" style="width: 150px;">
                <h4 class="mt-3 mb-2"><b>Ejeeeeeeeem... no hay cambios aún</b></h4>
                <p class="text-muted">¡Mantente atento a todo lo nuevo!</p>
              </div>
            </div>
          </div>
        <?php endif ?>
        </div>
      </div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES.'footer.php' ?>