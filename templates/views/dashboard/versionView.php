<?php require INCLUDES . 'header.php' ?>
<?php require INCLUDES . 'sidebar.php' ?>
<!-- Área del contenido principal -->
<div class="content" id="app">
	<?php flasher() ?>

	<div class="row">
		<div class="col-12">
			<h3 class="mt-2 mb-0">Dashboard en construcción</h3>
			<p><small>Para reportar bugs o fallas <a href="mailto:soporte@joystick.com.mx">soporte@joystick.com.mx</a></small></p>
		</div>
	</div>
	
	<div class="row">
	
		<!-- Actualizaciones -->
		<div class="col-xl-4 col-md-3 col-12">
			<div class="pvr-wrapper">
				<div class="pvr-box">
					<h5 class="pvr-header">Actualizaciones
						<div class="pvr-box-controls">
							<i class="material-icons" data-box="refresh" data-effect="win8_linear">refresh</i>
							<i class="material-icons" data-box="fullscreen">fullscreen</i>
							<i class="material-icons" data-box="close">close</i>
						</div>
					</h5>

					<!-- Actualizaciones -->
					<ul class="list-group">
						<br>
						<li class="list-group-item bg-primary text-white">v 3.4.6</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Función para generar una plantilla para imprimir en tamaño tabloide de hasta 18 códigos QR de equipos.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Función para reportar equipos de forma remota utilizando los códigos QR generados.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Descargar, ver y regenarar QR están en construcción.</li>

						<br>
						<li class="list-group-item bg-primary text-white">v 3.4.5</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>El usuario ahora podrá solicitar anticipos o si lo requiere un complemento para el mismo.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Cada equipo registrado tendrá la opción para generar un QR para realizar la operación de reporte más sencilla.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Cada complemento de anticipo ahora manda correos notificación para administradores de SAISCO.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Los reportes ahora pueden actualizar su estado de forma más accesible.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Ahora es posible generar QR para cada equipo.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Mejora de procesos y rendimiento del sistema en general.</li>
						
						<br>
						<li class="list-group-item bg-primary text-white">v 3.4.0</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Solo los administradores podrán ver el listado de usuarios y realizar un borrado permanente de los mismos.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>El usuario ahora puede editar su perfil, cambiar imagen o avatar, e imagen de fondo, agregar redes sociales de contacto y su biografía.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>El usuario ahora puede borrar otros usuarios, solo si su rol es administrador.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Se pueden borrar y agregar negocios en el CRM del sistema, sin edición y para objeto de seguimiento.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Correcciones menores en el sistema de mensajes de notificaciones.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Ahora todos los correos de anticipos son recibidos por administradores con un número de folio en el asunto.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Estadísticas de anticipos implementada.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Correcciones parciales en los formatos PDF.</li>
						<br>
						<li class="list-group-item bg-primary text-white">v 3.3.4</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>El panel de administrador de archivos está funcionando, por lo que todo archivo será permanentemente borrado de seleccionar la acción "borrar".</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>El panel de administrador de archivos acepta subir archivos en grupos o uno por uno, serán guardados en el servidor al procesarse. <i>Aun tiene bugs</i></li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>El panel básico de anticipos está listo, cada usuario puede pedir anticipos, cancelar los anticipos solicitados, una vez aprobados no se pueden cancelar, solo por un administrador, el proceso de aprobación está en construcción.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Los administradores son los únicos que pueden ver todos los anticipos, incluyendo los de otros usuarios.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Ahora es posible actualizar información de perfil como es nombre, usuario, correo y la biografía del usuario.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Correo de notificación a SAISCO al generar un reporte desde la plataforma.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Correo de notificación a SAISCO y usuario al solicitar un anticipo.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>La redirección después de agregar un Equipo, Reporte, Tipo de equipo, Marca, Anticipo, Usuario es directo al formulario para agregar.</li>
						<li class="list-group-item"><i class="fa fa-check mr-2"></i>Sistema de mensajes para ofrecer una mejor experiencia de usuario y de información al cliente o usuario.</li>
					</ul>
				</div>
			</div>
		</div>

		
	</div>
</div>
<!-- ends -->

<?php require INCLUDES . 'footer.php' ?>