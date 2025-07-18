<footer class="text-muted py-5">
  <div class="container">
    <p class="float-right">
      <a href="<?php echo CUR_PAGE.'#'; ?>">Subir</a>
    </p>
    <a class="text-theme" href="<?php echo get_system_url(); ?>" target="_blank"><?php echo get_system_name(); ?></a> <?php echo date('Y') ?> © Todos los derechos reservados.
  </div>
</footer>

<?php require_once INCLUDES.'scripts.php'; ?>

<!-- Dynamic Chart JS -->
<?php echo GraphHandler::load(); ?>

</body>
<!--End Body-->
</html>