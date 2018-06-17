<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<div class="container" id='container'>
<?php 
	if (isset($_REQUEST['dialog'])) {

?>
	<style>
	div.header {
		display: none;
	}
	</style>
	<?php } ?>
	
<?php 
	$id = 'nuevo';
	if (isset($_REQUEST['id'])) {
		$id = $_REQUEST['id'];
	}
	$maestro = 'clientes';
	$reference = 'cliente';
	
	$dialog = false;
	if (isset($_REQUEST['dialog'])) {
		$dialog = $_REQUEST['dialog'];
	}
	
	

	echo "<h2 class='formulario edicion {$maestro} maestro' data-maestro='{$maestro}' data-id='{$id}' data-reference='{$reference}' >
		Cliente Nuevo
	</h2>";
	if (!$dialog) {
		echo "<a href='../clientes' class='jquibutton'>Volver</a>";
	}	
	
	$tablas = array(
		'clientes' => 'Cliente',
		'contactos' => "Contactos", 
		'direcciones_entrega' => "Direcciones de entrega", 
	);
	if ($_SESSION['tipo'] == 'administrador') {
		$tablas['clientes_vendedores'] = "Vendedores";
	}
	//print_r($tablas);
	echo "<div class='tabs'>";
	echo "<ul>";
	foreach ($tablas as $tabla => $titulo) {
		echo "<li><a href='#{$tabla}'>{$titulo}</a></li>";
	}
	echo "</ul>";
	foreach ($tablas as $tabla => $titulo) {
		
		$tablaMaestro = 'secundario';
		$formMaestro = 'agregarSecundario';
		if ($tabla == $maestro) {
			$tablaMaestro = 'maestro';
			$formMaestro = 'agregarMaestro';
		}
		
		if ($id != 'nuevo' or $tablaMaestro != 'secundaria') {
			echo "<div class='cliente {$tabla} tab' id='{$tabla}'>
				<h3 class='cliente {$tabla}'>{$titulo}</h3>
				<div class='contenido  {$tabla} {$tablaMaestro}' data-tabla='{$tabla}'>
					<form action='#' method='post' class='{$tabla} {$tablaMaestro} {$formMaestro}' data-tabla='{$tabla}'>
						<fieldset class='{$tablaMaestro} {$tabla}' data-tabla='{$tabla}'></fieldset>
					</form>
				</div>";
			
			
		}
		
		if ($tablaMaestro == 'secundario') {
			echo "<hr>";
			echo "<label for='en_uso' class='checker en_uso'>Mostrar borrados</label>
					<input type='checkbox' name='en_uso' value='en_uso' class='en_uso' data-tabla={$tabla} />";
			echo "<div class='listado {$tabla} tablaSecundaria' data-tabla='{$tabla}'></div>";
		}
		
		echo "</div>";
	}
	echo "</div>";
?>
<script>
	$(document).ready(function() {
		
		var maestro = $('h2.maestro').data('maestro');
		var id = $('h2.maestro').data('id');
		actualizarFormularioMaestro(maestro, id);
		
		$('form.agregarMaestro').submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			var maestro = $('h2.maestro').data('maestro');
			var id = $('button.agregarMaestro').data('id');
			formValues += "&maestro=" + maestro;
			formValues += "&id=" + id;
			
			var url = "../../../../resources/library/AJAX.php?act=agregarMaestro";
			$.post(url, formValues, function(data) {
				data = JSON.parse(data);
				if (data.error) {
					alert('Error inesperado' + data.error.numero);
				} else {
					alert('Se ha agregado un nuevo cliente');
				}
			});
		});
					
		var actualizarFormularioSecundario = function(tabla, id) {
			
			var reference = $('h2.maestro').data('reference');
			var url = "../../../../resources/library/AJAX.php?act=actualizarFormularioSecundario";
			$('fieldset.' + tabla).load(url, {'tabla': tabla, 'id': id, 'reference': reference}, function() {
				
				//var url = "../../../../resources/library/AJAX.php?act=actualizarAutocompletar";
				//var tipo = 'tipo';
				/*$.post(url, {"maestro": maestro, "tipo": tipo}, function(data) {
					//data = "(" + data + ")";
					//data = eval(data);
					data = JSON.parse(data);
					console.log(data);
					$('input.tipo').autocomplete({
						source: data
					});
				});*/
				
				/*$('button.limpiar').click(function() {
					$('select.maestro').change();
				});*/
			});
		}
		
		$('fieldset.secundario').each( function(index) {
			//console.log(index);
			var tabla = $(this).data('tabla');
			var id = 'nuevo';
			actualizarFormularioSecundario(tabla, id);
		});
		
		$('form.agregarSecundario').submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			var tabla = $(this).data('tabla');
			var maestro = $('h2.maestro').data('maestro');
			var idMaestro = $('h2.maestro').data('id');
			var reference = $('h2.maestro').data('reference');
			
			var id = $('button.agregarSecundario.' + tabla).data('id');
			formValues += "&maestro=" + maestro;
			formValues += "&id=" + id;
			formValues += "&tabla=" + tabla;
			formValues += "&idMaestro=" + idMaestro;
			formValues += "&reference=" + reference;
			
			console.log(formValues);
			var url = "../../../../resources/library/AJAX.php?act=agregarSecundario";
			$.post(url, formValues, function(data) {
				actualizarTablaSecundario(tabla, data);
			});
		});
		
		
		
		var actualizarTablaSecundario = function(tabla, filtro) {
			//var formValues = $('form.filtros').serialize();
			//var library_path = '<?php echo LIBRARY_PATH; ?>';
			var en_uso = 1;
			var idMaestro = $('h2.maestro').data('id');
			var reference = $('h2.maestro').data('reference');
			
			if ($('input.en_uso').is(':checked')) {
				en_uso = 0;
			}
			
			var url = "../../../../resources/library/AJAX.php?act=actualizarTablaSecundario";
			//var numero = $('input.numero').val();
			//console.log(url);
			$('div.tablaSecundaria.' + tabla).load(url, {'tabla': tabla, 'reference': reference, 'filtro': filtro, 'en_uso': en_uso, 'idMaestro': idMaestro}, function() {
				$('button.eliminarElemento').off();
				$('button.eliminarElemento').click(function() {
					var id = $(this).data('id');
					var tabla = $(this).data('tabla');
					if (confirm('¿Desea Eliminar el artículo?')) {
						
						$.post("../../../../resources/library/AJAX.php?act=eliminarElemento", {"id": id, "tabla": tabla }, function(data) {
							actualizarTablaSecundario(tabla, '');
						});
					}
				});
				$('button.editarInline').off();
				$('button.editarInline').click(function() {
					var tabla = $(this).data('tabla');
					var id = $(this).data('id');
					//var maestro = $('select.maestro').val();
					actualizarFormularioSecundario(tabla, id);
				
				});
				
				
			});
		}
		
		$('div.tablaSecundaria').each( function(index) {
			//console.log($(this).data('tabla'));
			var tabla = $(this).data('tabla');
			var filtro = ''
			actualizarTablaSecundario(tabla, filtro);
		});
		
		/*var filtro = $('input.filtro').val();
		var tabla = 'clientes';
		
		//actualizarTabla(tabla, filtro);
		
		$('input.filtro').keyup(function() {
			var filtro = $(this).val();
			var tabla = 'clientes';
			actualizarTabla(tabla, filtro);
		});
		
		$('button.limpiarFiltro').click(function() {
			$('input.filtro').val('');
			$('input.filtro').keyup();
		});*/
		
		$('input.en_uso').change(function() {
			var tabla = $(this).data('tabla');
			actualizarTablaSecundario(tabla, '');
		});
		
		
		
		$( "div.tabs" ).tabs();
		
				
	});
</script>
</div>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	