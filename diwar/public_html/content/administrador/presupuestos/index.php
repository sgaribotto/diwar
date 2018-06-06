<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<?php
	$tipo = $_SESSION['tipo'];
?>

		<h2>Presupuestos</h2>
		<?php if ($tipo == 'vendedor') { ?>
		<a href="presupuesto.php?num=nuevo" class='jquibutton'>Nuevo</a>
		<?php } ?>
		<div class="presupuestos">
		<div id="filtros filtros" class="desplegable">
			<fieldset class="formularioLateral">
				<form method="post" class="formularioLateral filtros" action="" >
					<label class="formularioLateral" for="filtro">Buscar:</label>
					<input type="text" class="formularioLateral iconCod filtro" name="filtro" id="filtro"/>
					<button type="button" class="limpiarFiltro">Limpiar</button>
					<label class="formularioLateral" for="filtro">Desde:</label>
					<input type="text" class="formularioLateral iconCod filtro fecha" name="fechaDesde" id="fechaDesde" style='width:100px;' >
					<label class="formularioLateral" for="filtro">Hasta:</label>
					<input type="text" class="formularioLateral iconCod filtro fecha" name="fechaHasta" id="fechaHasta" style='width:100px;'  >
					
					
					
					<!--<input type="checkbox" name='en_uso' value='en_uso' class="en_uso" style='width: 10px;' />
					<label for="en_uso" class="checker en_uso"  style='width: 200px;'>Mostrar borrados</label>-->
				</form>	
			</fieldset>
		</div>
		<div class='tablaPresupuestos'></div>
		
		
		
		</table>
		<div>
		<script>
		$(document).ready(function() {
			
			$('#fechaHasta').datepicker(
				{dateFormat: 'yy/m/d'}
			);
			$('#fechaDesde').datepicker(
				{dateFormat: 'yy/m/d'}
			);
			
			var actualizarTablaPresupuestos = function() {
				var filtros = $('form.filtros').serialize();
				var url = "../../../../resources/library/AJAX.php?act=actualizarTablaPresupuestos";
				
				$('div.tablaPresupuestos').load( url, filtros, function() {
					$('.jquibutton').button();
				});
			}
			
			actualizarTablaPresupuestos();
			
			$('input.filtro').keyup(function() {
				actualizarTablaPresupuestos();
			});
			
			$('input.fecha').change(function() {
				actualizarTablaPresupuestos();
			});
			
		});
		</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	