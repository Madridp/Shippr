<!-- starts sidebar.php -->
<!--Begin wrapper-->
<div class="wrapper">
	<!--Begin Sidebar-->
	<div class="sidebar 
	<?php echo get_sidebar_alignment() === 'left' ? 'sidebar-left' : 'sidebar-right' ?>" data-color="purple" 
	data-image="<?php echo get_sidebar_opacity() ? get_sidebar_bg() : ''; ?>">
		<div class="sidebar-wrapper">
			<!--Begins Logo start-->
			<div class="logo">
				<a href="<?php echo get_siteurl(); ?>">
					<img src="<?php echo get_sitelogo(250);?>" alt="<?php echo get_sitename(); ?>" style="width: 150px;">
				</a>
			</div>
			<!--End Logo start-->

			<!--Begins User Section-->
			<div class="user">
				<div class="photo">
					<img src="<?php echo get_user_avatar(); ?>"/>
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#pvr_user_nav" class="collapsed">
						<span>
							<small><?php echo get_user_name(); ?></small><br>
							<small><i class="icon-wallet"></i> <?php echo money(get_user_saldo()) ?></small>
							<b class="caret"></b>
						</span>
					</a>
					<div class="collapse m-t-10" id="pvr_user_nav">
						<ul class="nav">
							<li>
								<a class="profile-dropdown" href="usuarios/perfil">
									<span class="sidebar-mini"><i class="icon-user"></i></span>
									<span class="sidebar-normal">Mi perfil</span>
								</a>
							</li>
							<li>
								<a class="profile-dropdown" href="usuarios/editar-mi-perfil">
									<span class="sidebar-mini"><i class="icon-settings"></i></span>
									<span class="sidebar-normal">Editar perfil</span>
								</a>
							</li>
							<li>
								<a class="profile-dropdown" href="usuarios/recargar-saldo">
									<span class="sidebar-mini"><i class="icon-wallet"></i></span>
									<span class="sidebar-normal">Recargar saldo</span>
								</a>
							</li>
							<li>
								<a class="profile-dropdown" href="usuarios/logout">
									<span class="sidebar-mini"><i class="icon-logout"></i></span>
									<span class="sidebar-normal">Cerrar sesión</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!--End User Section-->

			<ul class="nav">

				<?php if (is_root(get_user_role())): ?>
				<!-- Root nav -->
					<?php require_once INCLUDES.'root_nav.php'; ?>
				<!-- ends root -->
				<?php endif; ?>
			
				<?php if (is_admin(get_user_role())): ?>
				<!-- dirección -->
					<?php require_once INCLUDES.'dir_nav.php'; ?>
				<!-- ends dirección -->
				<?php endif; ?>

				<?php if (is_user(get_user_role(), ['worker'])): ?>
				<!-- Administración general -->
					<?php require_once INCLUDES.'admin_nav.php'; ?>
				<!-- ends administración gral -->
				<?php endif; ?>

				<!-- Dashboard -->
				<li class="nav-item <?php echo current_link(['dashboard'])?>">
					<a class="nav-link" href="dashboard">
						<i class="material-icons">home</i>
						<p>Dashboard</p>
					</a>
				</li>

				<hr>

				<!-- Nuevo envío de usuario -->
				<li class="nav-item <?php echo current_link(['envios'], ['nuevo'])?>">
					<a class="nav-link" href="carrito/nuevo">
						<i class="material-icons">local_shipping</i>
						<p>Nuevo envío</p>
					</a>
				</li>

				<!-- Carrito de compras -->
				<li class="nav-item <?php echo current_link(['carrito'])?>">
					<a class="nav-link" href="carrito">
						<i class="material-icons">shopping_cart</i>
						<p>Carrito <span class="float-right"><?php echo get_cart_count(); ?></span></p>
					</a>
				</li>

				<!-- Direcciones -->
				<li class="nav-item <?php echo current_link(['direcciones'])?>">
					<a class="nav-link" href="direcciones">
						<i class="material-icons">art_track</i>
						<p>Mis direcciones</p>
					</a>
				</li>

				<!-- Compras -->
				<li class="nav-item <?php echo current_link(['compras'])?>">
					<a class="nav-link" href="compras">
						<i class="material-icons">add_shopping_cart</i>
						<p>Mis compras</p>
					</a>
				</li>

				<!-- Envíos -->
				<li class="nav-item <?php echo current_link(['envios'])?>">
					<a class="nav-link" href="envios">
						<i class="material-icons">format_list_bulleted</i>
						<p>Mis envíos</p>
					</a>
				</li>

				<!-- Transacciones -->
				<li class="nav-item <?php echo current_link(['transacciones'])?>">
					<a class="nav-link" href="transacciones">
						<i class="material-icons">credit_card</i>
						<p>Mis transacciones</p>
					</a>
				</li>

				<!-- Recolecciones -->
				<li class="nav-item <?php echo current_link(['recoleccion'])?>">
					<a class="nav-link" href="recoleccion">
						<i class="material-icons">alarm_on</i>
						<p>Recolección</p>
					</a>
				</li>

				<hr>

				<li class="nav-item <?php echo current_link(['informacion'], ['calcular_peso_volumetrico'])?>">
					<a class="nav-link" href="informacion/calcular-peso-volumetrico">
						<i class="material-icons">assignment_returned</i>
						<p>Cotizar envío</p>
					</a>
				</li>
				<li class="nav-item <?php echo current_link('p','precios')?>">
					<a class="nav-link" href="p/tarifas">
						<i class="material-icons">attach_money</i>
						<p>Lista de precios <span class="badge badge-dark">NEW</span></p>
					</a>
				</li>
				<hr>

				<!-- Contacto -->
				<li class="nav-item <?php echo current_link(['informacion'], ['contacto'])?>">
					<a class="nav-link" href="informacion/contacto">
						<i class="material-icons">contact_phone</i>
						<p>Contáctanos</p>
					</a>
				</li>

				<!-- FAQ -->
				<li class="nav-item <?php echo current_link(['informacion'], ['preguntas_frecuentes'])?>">
					<a class="nav-link" href="informacion/preguntas-frecuentes">
						<i class="material-icons">announcement</i>
						<p>FAQ</p>
					</a>
				</li>
				
			</ul>
		</div>
	</div>
	<!--End Sidebar-->

	<!--Begin Main Panel-->
	<div class="main-panel <?php echo get_sidebar_alignment() === 'left' ? 'main-panel-right' : 'main-panel-left' ?>">
		<!-- Top Navbar -->
		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid">
				<div class="navbar-wrapper">
					<div class="navbar-minimize">
						<button id="minimizeSidebar" data-color="purple"
						class="btn btn-fill btn-round btn-icon d-none d-lg-block">
						<i class="fa fa-ellipsis-v visible-on-sidebar-regular"></i>
						<i class="fa fa-navicon visible-on-sidebar-mini"></i>
					</button>
				</div>
				<a class="navbar-brand" id="page_header_title" href="javascript:void(0)">
					<?php echo $data['title'] ?>
				</a>
				</div>
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
				aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-bar burger-lines"></span>
					<span class="navbar-toggler-bar burger-lines"></span>
					<span class="navbar-toggler-bar burger-lines"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end">
					<ul class="navbar-nav">
						<li class="nav-item" <?php echo tooltip((is_working_hours() ? 'Estamos en línea' : 'No estamos disponibles')) ?>>
							<a class="nav-link" href="javascript:void(0)">
								<i class="material-icons <?php echo (is_working_hours() ? 'text-success' : 'text-danger') ?>"><?php echo (is_working_hours() ? 'cloud_done' : 'report_problem') ?></i>
							</a>
						</li>

						<li class="nav-item dropdown dropdown-slide">
							<a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdownMenuLink"
							data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="material-icons">account_box</i>
							</a>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
								<!-- 
								<a class="dropdown-item" href="inbox">
									<i class="material-icons align-middle">mail_outline</i> Mensajes
								</a> -->
								<a class="dropdown-item" href="usuarios/perfil">
									<i class="material-icons align-middle">account_circle</i> Perfil
								</a>
								<a class="dropdown-item" href="usuarios/editar-mi-perfil">
									<i class="material-icons align-middle">settings</i> Editar perfil
								</a>
								<div class="divider"></div>
								<a href="usuarios/logout" class="dropdown-item">
									<i class="material-icons align-middle">power_settings_new</i> Cerrar sesión
								</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
<!-- End Navbar -->
<!-- ends sidebar.php -->