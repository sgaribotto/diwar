<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>

	
		<div class='menuNav'>
		<?php
			$enlaces = array(
				"maestros" => "Maestros",
				"articulos" => "Artículos",
				"presupuestos" => "Presupuestos",
				"usuarios" => "Usuarios",
				"vendedores" => "Vendedores",
				"clientes" => "Clientes",
				"configuracion" => "Configuracion"
			);
			
			foreach ($enlaces as $enlace => $nombre) {
				echo "<a class='nav'  href='{$enlace}'>{$nombre}</a>";
				echo "<br>";
			}
		?>
		</div>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	
