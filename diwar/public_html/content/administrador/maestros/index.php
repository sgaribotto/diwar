<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<?php $maestros = ['modelos', 'mecanismos', 'variaciones', 'colores']; ?>
<h2>Maestros - Componentes</h2>

<div class='formulario' id="formulario">
	<label for='maestro' class='maestro'>Maestro: </label>
	<select name='maestro' class='maestro'>
		<?php
			foreach ($maestros as $maestro) {
				echo "<option value='{$maestro}'>{$maestro}</option>";
			}
		?>
	</select>
	<form class="agregarMaestro formulario maestro">
		<fieldset class="formularioLateral formulario maestro agregarMaestro">
		</fieldset>
	</form>
</div>

<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/filtros.php'; ?>

<div class='tablaMaestro'>
</table>	

<script>
	$(document).ready(function() {
		var actualizarTablaMaestro = function(maestro, filtro) {
			//var formValues = $('form.filtros').serialize();
			//var library_path = '<?php echo LIBRARY_PATH; ?>';
			var en_uso = 1;
			if ($('input.en_uso').is(':checked')) {
				en_uso = 0;
			}

			var url = "../../../../resources/library/AJAX.php?act=actualizarTablaMaestro";
			//var numero = $('input.numero').val();
			//console.log(url);
			$('div.tablaMaestro').load(url, {'maestro': maestro, 'filtro': filtro, 'en_uso': en_uso}, function() {
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
				
				$('th.editar, th.tipo, th.precio, th.eliminar').addClass('angosto');
				$('th.descripcion').addClass('muy-ancho');
				$('td.editar, td.tipo, td.precio, td.eliminar').addClass('angosto');
				$('td.descripcion').addClass('muy-ancho');
				$('th.nombre').addClass('ancho');
				$('td.nombre').addClass('ancho');
				$('button').button();
		
				
				
			});
		} 
		var filtro = $('input.filtro').val();
		var maestro = $('select.maestro').val();
		
		$('select.maestro').on('change', function() {
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
				//actualizarFormularioMaestro(maestro, data);
			});
			
			
		});
		
		$('input.filtro').keyup(function() {
			var filtro = $(this).val();
			var maestro = $('select.maestro').val();
			actualizarTablaMaestro(maestro, filtro);
		});
		
		$('button.limpiarFiltro').click(function() {
			$('input.filtro').val('');
			$('input.filtro').keyup();
		});
		
		$('input.en_uso').change(function() {
			var filtro = $('input.filtro').val();
			var maestro = $('select.maestro').val();
			actualizarTablaMaestro(maestro, filtro);
		});
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	
