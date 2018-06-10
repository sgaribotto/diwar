<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="1200">
		<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/config.php'; ?>
		<?php require LIBRARY_PATH . '/scripts.php'; ?>
		<?php
			session_start();
			//print_r($_SERVER);
			//PONER QUE PASA CUANDO NO HAY SESSION
			//print_r($_SERVER);
			if (!isset($_SESSION['tipo'])) {
				if ($_SERVER['PHP_SELF'] != $config['paths']['start']) {
					echo "<script>location.assign('/diwar/public_html')</script>";
				}
			
			} else {
				if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1200)) {
					// last request was more than 30 minutes ago
					$_SESSION = array();
					echo "<script>location.assign('/diwar/public_html')</script>";
				}
				$_SESSION['LAST_ACTIVITY'] = time();
			}
		?>
		<link rel="stylesheet" type="text/css" href="/diwar/public_html/css/general.css">
		
	</head>
		<body>
		<div class="header">
			<img src="<?php echo $config['paths']['images']['layout'] . "/logo-diwar-solo.jpg"; ?>" class='logo' />
			<?php if (isset($_SESSION['tipo'])) { ?>
			<nav class="site-nav">
				<ul class="site-nav-nav">
					<li class='nav'><a class='nav' href='<?php echo "{$config['paths']['content']}{$_SESSION['tipo']}"; ?>'>Volver al menú</a></li>
				<?php if ($_SESSION['tipo'] == 'administrador') { ?>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/maestros"; ?>'>Maestros</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/articulos"; ?>'>Artículos</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/presupuestos"; ?>'>Presupuestos</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/usuarios"; ?>'>Usuarios</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/vendedores"; ?>'>Vendedores</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/clientes"; ?>'>Clientes</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}administrador/configuracion"; ?>'>Configuración</a></li>

				<?php } elseif ($_SESSION['tipo'] == 'vendedor') { ?>
				
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}vendedor/presupuestos"; ?>'>Presupuestos</a></li>				
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}vendedor/clientes"; ?>'>Clientes</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}vendedor/articulos"; ?>'>Artículos</a></li>
						<li class="nav"><a class='nav' href='<?php echo "{$config['paths']['content']}vendedor/configuracion"; ?>'>Configuración</a></li>
					
				<?php } ?>
				<li class="nav"><a class='nav' href="/diwar/public_html/index.php?cerrar_sesion=1">Salir</a></li>
			<?php } ?>
			</ul>
			</nav>
		</div>
		<script>
			$(document).ready(function() {
				$('.jquibutton, button.eliminar, button.editar, a.editar').button();
				
				//$('select').selectmenu();
			});
		</script>
		
			
		
