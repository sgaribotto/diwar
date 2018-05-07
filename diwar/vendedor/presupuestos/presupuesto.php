<!DOCTYPE html>
<html>
	<head>
	</head>
		<body>

		<h2>PRESUPUESTO NUEVO</h2>
		<div class='presupuesto-nuevo form-container'>
			<form class='presupuesto-nuevo' method='post' acticion='emitirpresupuesto.php'>
				<fieldset class='presupuesto-nuevo'>
					<label class='presupuesto-nuevo' for='numero'>Número</label>
					<input type='text' readonly class='presupuesto-nuevo' name='numero' />
					<label class='presupuesto-nuevo' for='vendedor'>Vendedor</label>
					<select readonly class='presupuesto-nuevo' name='vendedor' />
						<?php //TRAER LAS OPCIONES ?>
					</select>
					<label class='presupuesto-nuevo' for='cliente'>Cliente</label>
					<select readonly class='presupuesto-nuevo' name='cliente' />
						<?php //TRAER LAS OPCIONES ?>
					</select>
					
				</fieldset>
			</form>
		</div>
		
		<div class='agregar-articulos form-container'>
			<form class='agregar-articulos' method='post' acticion='agregararticulos.php'>
				<fieldset class='agregar-articulos'>
					<label class='agregar-articulos' for='articulo'>Artículo</label>
					<select readonly class='agregar-articulo' name='articulo' />
						<?php //TRAER LAS OPCIONES DE ARTICULOS ?>
					</select>
					<label class='agregar-articulo' for='mecanismo'>Mecanisimo</label>
					<select readonly class='agregar-articulo' name='mecanismo' />
						<?php //TRAER LAS OPCIONES DE MECANISMOS PARA ESE ARTICULO ?>
					</select>
					<?php //TRAER LAS OPCIONES DE VARIACIONES PARA EL ARTICULO Y MECANISMOS
							//CON UN SELECT POR TIPO
					?>
					
				</fieldset>
			</form>
		</div>
	</body>
</html>