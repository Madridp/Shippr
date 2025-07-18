<!-- Footer file begins -->
<!--Begin Footer-->
<footer class="footer">
	<div class="container-fluid">
		<nav>
			<ul class="footer-menu d-none d-sm-block">
				<li><a href="javascript:void(0)"><?php echo sprintf('Versión %s', get_siteversion()) ?></a></li>
				<li><a href="informacion/terminos-y-condiciones" target="_blank" rel="noopener noreferrer">Términos y condiciones</a></li>
				<li><a href="informacion/aviso-de-privacidad" target="_blank" rel="noopener noreferrer">Aviso de privacidad</a></li>
				<li><a href="informacion/articulos-prohibidos" target="_blank" rel="noopener noreferrer">Artículos prohibidos</a></li>
			</ul>
			<p class="copyright text-right">
				<a class="text-theme" href="<?php echo get_system_url(); ?>" target="_blank"><?php echo get_system_name(); ?></a> <?php echo date('Y') ?> © Todos los derechos reservados.
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

<!-- Dynamic Chart JS -->
<?php echo GraphHandler::load(); ?>

</body>
<!--End Body-->
</html>