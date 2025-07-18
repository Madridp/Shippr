<!-- Footer file begins -->
<!--Begin Footer-->
<footer class="footer">
	<div class="container-fluid">
		<nav>
			<ul class="footer-menu d-none d-sm-block">
				<li><a href="informacion/terminos-y-condiciones" target="_blank" rel="noopener noreferrer">Términos y condiciones</a></li>
				<li><a href="informacion/aviso-de-privacidad" target="_blank" rel="noopener noreferrer">Aviso de privacidad</a></li>
				<li><a href="informacion/articulos-prohibidos" target="_blank" rel="noopener noreferrer">Artículos prohibidos</a></li>
				<li>
					<a href="javascript:void(0)">
						Versión <?php echo get_siteversion() ?>
					</a>
				</li>
				<li>
					<a href="<?php echo 'mailto:'.get_email_address_for('contacto') ?>">
						<?php echo get_email_address_for('contacto') ?>
					</a>
				</li>
				<li>
					<a href="mailto:soporte@joystick.com.mx">
						soporte@joystick.com.mx
					</a>
				</li>
			</ul>
			<p class="copyright text-right">
				<a class="text-theme" href="<?php echo get_siteurl(); ?>" target="_blank"><?php echo get_system_name(); ?></a> © <span id="writeCopyrights"><?php echo date('Y') ?></span>. Todos los derechos reservados.
			</p>
		</nav>
	</div>
</footer>
<!--End Footer-->
</div>
<!--EndMain Panel-->
</div>
<!--End wrapper-->

<!-- begin scroll to top btn -->
<a href="javascript:void(0)" class="btn btn-icon btn-circle btn-scroll-to-top btn-sm animated invisible text-light" data-color="purple" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->

<?php require_once INCLUDES.'scripts.php'; ?>

<!-- END footer start -->