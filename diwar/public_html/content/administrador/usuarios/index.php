<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<h2>Usuarios</h2>
<div id="formulario">
	<form class="agregarUsuario formulario usuarios">
		<fieldset class="formulario maestro agregarUsuario">
			<div class='formulario'>
				<label for='tipo' class='usuarios'>Tipo: </label>
				<select class='usuarios tipo' name='tipo' required>
					<option value='vendedor'>Vendedor</option>
					<option value='administrador' >Administrador</option>
				</select>
				<br>
				<label for='vendedor' class='usuarios'>Vendedor vinculado: </label>
				<select class='usuarios vendedor' name='vendedor'>
					<option value=''>Seleccione vendedor...</option>
					
				</select>
				<br>
				<label for='usuario' class='usuarios usuario'>Usuario: </label>
				<input type='text' class='usuario' pattern='[a-z]{6,}' title='6 o más caracteres sin espacios, números o símbolos' name='usuario' required/>
				<br>
				<label for='nombre' class='usuarios usuario'>Nombre: </label>
				<input type='text' class='usuario nombre' name='nombre' required/>
				<br>
				<button type="submit" class="usuarios agregarUsuario" data-id='nuevo'>Agregar usuario</button>
			</div>
		</fieldset>
	</form>
</div>

<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/filtros.php'; ?>

<div class='tablaMaestro'>
</table>	

<script>
	$(document).ready(function() {
		
		$('select.tipo').change(function() {
			$('input.nombre').val('');
			var tipo = $(this).val();
			var url = "../../../../resources/library/AJAX.php?act=actualizarOptionsVendedor";
			$('select.vendedor').load(url, {"tipo": tipo}, function(data) {
				$('select.vendedor').change(function(data) {
					var url = "../../../../resources/library/AJAX.php?act=actualizarNombreVendedor";
					var vendedor = $(this).val();
					$.post(url, {"vendedor": vendedor}, function(data) {
						$('input.nombre').val(data);
					});
				});
			});
		});
		
		$('select.tipo').change();
		
	

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
					if (confirm('¿Desea Eliminar el usuario?')) {
						var id = $(this).data('id');
						//var maestro = $('select.maestro').val();
						$.post("../../../../resources/library/AJAX.php?act=eliminarMaestro", {"id": id, "maestro": maestro }, function(data) {
							actualizarTablaMaestro(maestro, filtro);
						});
					}
				});
				
				$('button.editarMaestro').click(function() {
					var id = $(this).data('id');
					$.post("../../../../resources/library/AJAX.php?act=editarUsuario", {"id": id}, function(data) {
						data = JSON.parse(data);
						console.log(data.id);
						$.each(data, function(key, value) {
							$('input.' + key + ', select.' + key).val(value);
						});
						
						$('button.agregarUsuario').data('id', data.id)
							.text('Modificar usuario');
						//actualizarTablaMaestro(maestro, filtro);
					});
				});
				
				$('th.editar, th.eliminar').addClass('angosto');
				//$('th.descripcion').addClass('muy-ancho');
				$('td.editar, td.eliminar').addClass('angosto');
				//$('td.descripcion').addClass('muy-ancho');
				$('th.usuario, th.vendedor, th.tipo').addClass('ancho');
				$('td.usuario, td.vendedor, td.tipo').addClass('ancho');
				$('button').button();
			});
		} 
		var filtro = $('input.filtro').val();
		var maestro = 'usuarios';
		
		$('select.maestro').change(function() {
			var filtro = $('input.filtro').val();
			var maestro = $('select.maestro').val();
			actualizarTablaMaestro(maestro, filtro);
		});
		
		actualizarTablaMaestro(maestro, filtro);
		
		$('form.agregarUsuario').submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			var maestro = 'usuarios'
			var id = $('button.agregarUsuario').data('id');
			formValues += "&maestro=" + maestro;
			formValues += "&id=" + id;
			
			
			var url = "../../../../resources/library/AJAX.php?act=agregarUsuario";
			$.post(url, formValues, function(data) {
				
				$('input.filtro').val($('input.nombre').val());
				var filtro = $('input.filtro').val();
				actualizarTablaMaestro(maestro, filtro);
				//actualizarFormularioMaestro(maestro, data);
			});
			
			
		});
		
		$('input.filtro').keyup(function() {
			var filtro = $(this).val();
			var maestro = 'usuarios';
			actualizarTablaMaestro(maestro, filtro);
		});
		
		$('button.limpiarFiltro').click(function() {
			$('input.filtro').val('');
			$('input.filtro').keyup();
		});
		
		$('input.en_uso').change(function() {
			var filtro = $('input.filtro').val();
			var maestro = 'usuarios';
			actualizarTablaMaestro(maestro, filtro);
		});
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	
