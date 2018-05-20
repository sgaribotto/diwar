<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<?php $maestros = ['modelos', 'mecanismos', 'clientes', 'vendedores', 'variaciones', 'colores']; ?>
<h1>Maestros</h1>
<select name='maestro' class='maestro'>
	<?php
		foreach ($maestros as $maestro) {
			echo "<option value='{$maestro}'>{$maestro}</option>";
		}
	?>
</select>
<div id="mostrarFormulario">Mostrar Formulario</div>
<div id="mostrarFiltros">Mostrar Filtros</div>
<div id="formulario">
	<form class="agregarMaestro formulario maestro">
		<fieldset class="formularioLateral formulario maestro agregarMaestro">
		</fieldset>
	</form>
</div>

<div id="filtros filtros" class="desplegable">
	<fieldset class="formularioLateral">
		<form method="post" class="formularioLateral filtros" action="" >
			<label class="formularioLateral" for="filtro">Buscar:</label>
			<input type="text" class="formularioLateral iconCod filtro" name="filtro" required="required" id="filtro" maxlength="10"/>
		</form>	
	</fieldset>
</div>

<hr>
<div class='tablaMaestro'>
</table>	

<script>
	$(document).ready(function() {
					
		var actualizarFormularioMaestro = function(maestro, id) {
			//var formValues = $('form.filtros').serialize();
			//var library_path = '<?php echo LIBRARY_PATH; ?>';
			var url = "../../../../resources/library/AJAX.php?act=actualizarFormularioMaestro";
			//var numero = $('input.numero').val();
			//console.log(url);
		$('fieldset.maestro').load(url, {'maestro': maestro, 'id': id}, function() {
				
			});
		} 
		
		var actualizarTablaMaestro = function(maestro, filtro) {
			//var formValues = $('form.filtros').serialize();
			//var library_path = '<?php echo LIBRARY_PATH; ?>';
			var url = "../../../../resources/library/AJAX.php?act=actualizarTablaMaestro";
			//var numero = $('input.numero').val();
			//console.log(url);
		$('div.tablaMaestro').load(url, {'maestro': maestro, 'filtro': filtro}, function() {
				$('button.eliminarMaestro').click(function() {
					if (confirm('¿Desea Eliminar el artículo?')) {
						var id = $(this).data('id');
						var maestro = $('select.maestro').val();
						$.post("../../../../resources/library/AJAX.php?act=eliminarMaestro", {"id":id, "maestro": maestro }, function(data) {
							actualizarTablaMaestro(maestro, filtro);
						});
					}
				});
				
				$('button.editarMaestro').click(function() {
					//alert('editar');
					var id = $(this).data('id');
					var maestro = $('select.maestro').val();
					actualizarFormularioMaestro(maestro, id);
				
				});
			});
		} 
		var filtro = $('input.filtro').val();
		var maestro = $('select.maestro').val();
		
		$('select.maestro').change(function() {
			var filtro = $('input.filtro').val();
			var maestro = $('select.maestro').val();
			actualizarFormularioMaestro(maestro, 'nuevo');
			actualizarTablaMaestro(maestro, filtro);
		});
		
		actualizarFormularioMaestro(maestro, 'nuevo');
		actualizarTablaMaestro(maestro, filtro);
		
		$('form.agregarMaestro').submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			var maestro = $('select.maestro').val();
			var id = $('button.agregarMaestro').data('id');
			formValues += "&maestro=" + maestro;
			formValues += "&id=" + id;
			
			
			var url = "../../../../resources/library/AJAX.php?act=agregarMaestro";
			$.post(url, formValues, function(data) {
				
				$('input.filtro').val($('input.nombre').val());
				var filtro = $('input.filtro').val();
				actualizarTablaMaestro(maestro, filtro);
				actualizarFormularioMaestro(maestro, data);
			});
			
			
		});
		
		$('input.filtro').keyup(function() {
			var filtro = $(this).val();
			var maestro = $('select.maestro').val();
			actualizarTablaMaestro(maestro, filtro);
		});
			
		
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	
