<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>

<!--Begin Content-->
<div class="content">
	<?php echo get_breadcrums([['',$d->title]]) ?>
	
	<?php flasher(); ?>

	<div class="row">
		<!-- left side panel for quick buttons -->
		<div class="col-xl-3">
			<a href="email" class="btn btn-danger btn-block mb-3"><i class="fa fa-envelope mr-1"></i>Nuevo correo</a>
			<!-- 
			<ul class="list-group mb-3">
				<li class="list-group-item">
					<a href="#page-inbox.html"><i class="fa fa-inbox"></i> Inbox <span class="label label-danger">4</span></a>
				</li>
				<li class="list-group-item">
					<a href="#"><i class="fa fa-star"></i> Stared</a>
				</li>
				<li class="list-group-item">
					<a href="#"><i class="fa fa-rocket"></i> Sent</a>
				</li>
				<li class="list-group-item">
					<a href="#"><i class="fa fa-trash-o"></i> Trash</a>
				</li>
				<li class="list-group-item">
					<a href="#"><i class="fa fa-bookmark"></i> Important<span class="label label-info">5</span></a>
				</li>
			</ul>
			 -->
		</div>
		
		<!-- New email screen editor -->
		<div class="col-xl-9">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">
						<?php echo $d->title; ?>
						<div class="pvr-box-controls">
              <i class="material-icons" data-box="fullscreen">fullscreen</i>
              <i class="material-icons" data-box="close">close</i>
            </div>
					</h5>
					
					<form class="form-horizontal" action="email/send-email-submit" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="redirect_to" value="<?php echo CUR_PAGE; ?>">

						<div class="form-group d-none">
							<label for="to"><small>Para:</small></label>
							<input type="hidden" class="form-control form-control-sm" id="to" name="addresses" value="<?php echo get_smtp_email(); ?>">
							<small class="text-muted">Separa con comas cada destinatario</small>
						</div>

						<!-- 
						<div class="form-group">
							<label for="cc"><small>CC:</small></label>
							<input type="text" class="form-control form-control-sm" id="cc" name="cc" placeholder="CC: Escribe un email">
						</div> -->
						
						<div class="form-group">
							<label for="asunto"><small>Asunto:</small></label>
							<input type="text" class="form-control form-control-sm" id="asunto" name="subject">
						</div>

						<!-- text editor -->
						<div class="form-group">
							<label for="asunto"><small>Mensaje:</small></label>
							<textarea class="form-control" name="body" rows="10" id="summernote"><!-- Text editor --></textarea>
						</div>

						<!-- Attachments -->
						<div class="form-group">
							<label for=""><small>Adjuntos internos:</small></label>
							<?php if ($dataObj->adjuntos): ?>
								<?php foreach ($dataObj->adjuntos as $a): ?>
									<small class="text-muted d-block"><?php echo $a->filename.' ('.$a->filesize.')'; ?></small>
								<?php endforeach; ?>
							<?php else: ?>
								<small class="text-muted d-block">No hay adjuntos internos.</small>
							<?php endif; ?>
						</div>

						<div class="form-group">
							<label for=""><small>Adjuntar archivos:</small></label>
							<input type="file" class="text-truncate form-control" name="adjuntos[]" multiple>
						</div>
						
						<div class="form-group">	
							<button type="submit" class="btn btn-success">Enviar mensaje</button>
							<button type="reset" class="btn btn-danger float-right">Descartar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--End Content-->

<?php require INCLUDES . 'footer.php' ?>