<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<!--<a href='vendedores.php'>Volver</a>-->
<h2 class='articulos'>Artículos</h2>
<label class='modelo' for='modelo'>Modelo: </label>
<select class="modelos" name='modelos'>
<?php
	$mysqli = connection($config, 'db1');
	$query = "SELECT DISTINCT id, nombre
				FROM modelos
				WHERE en_uso = 1
				ORDER BY nombre";
				
	$result = $mysqli->query($query);
	
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
	}
?>
</select>

<style>
div.preview *{
	padding: 3px;
}

div.preview {
	vertical-align: middle;
	margin-top: 0;
	margin-bottom: 0;
}
input.preview, textarea.preview, button.preview, select.preview {
	display: inline-block;
	vertical-align:middle;
	margin: 3px;
}

input.precio-hidden {
	display: none;
}
</style>
<?php
	$tablaSecundaria = "mecanismos";
	$variaciones = 'variaciones';
	$tablas = array(
		'mecanismos' => 'Mecanismo',
	); 
	
	$query = "SELECT DISTINCT tipo
				FROM variaciones
				WHERE en_uso = 1";
	$result = $mysqli->query($query);
	$variaciones = array();
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$tablas[$row['tipo']] = ucfirst($row['tipo']);
		$variaciones[] = $row['tipo'];
	}
	
	//print_r($tablas);
	echo "<div class='tabs'>";
	echo "<ul>";
	echo "<li><a href='#preview'>Preview</a></li>";
	foreach ($tablas as $tabla => $titulo) {
		echo "<li><a href='#{$tabla}'>{$titulo}</a></li>";
	}
	
	echo "</ul>";
	foreach ($tablas as $tabla => $titulo) {
		
		if (in_array($tabla, $variaciones)) {
			echo "<div class='variaciones tab {$tabla}' id='{$tabla}' data-tabla='variaciones' data-tipo='{$tabla}'></div>";
		} else {
			echo "<div class='{$tabla} tab' id='{$tabla}' data-tabla='{$tabla}' data-tipo='{$tabla}'></div>";
		}
		
		
		
	}
	echo "<div class='tab' id='preview' data-tabla='' data-tipo=''>";
	echo "<div class='resultado'>";
	echo "<p class='resultado'><b>Descripción: </b></p>";
						echo "<p class='resultado'><b>Precio: </b></p>";
	echo "</div>
			<div class='modelo preview'>
			
			<form class='preview' data-tipo='modelo'>
				
					<select name='id' class='modeloPreview modelo preview'>";
	echo "<option value=''>Seleccione Modelo...</option>";
	$query = "SELECT DISTINCT id, nombre, descripcion, precio
				FROM modelos
				WHERe en_uso = 1
					AND tipo = 'silla'
				ORDER BY nombre";
	$result = $mysqli->query($query);
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
	}
	echo "</select>";
	if ($_SESSION['tipo'] == 'administrador') {
		echo "<textarea name='descripcion' class='innerPreview descripcionModelo descripcion modelo preview' style='width:560px; height:64px;'></textarea>";
		echo "<input type='hidden' name='precio'class='innerPreview precio modelo preview' value='0' hidden/>";
		echo "<button class='modeloPreview hidden preview modelo' type='submit'>Modificar</button>";
		echo "</form>";
	}
		
	echo "<div class='preview mecanismo'></div>
			<div class='variaciones preview'></div>";
	
	echo "</div>";
	
	echo "</div>";
?>
<script>
	$(document).ready(function() {
		
							
		var actualizarCheckboxes = function(tabla, tipo, modeloConMecanismo) {
			
			var modelo = $('select.modelos').val();
			var url = "../../../../resources/library/AJAX.php?act=actualizarCheckboxes";
			$('div.' + tipo).load(url, {'tabla': tabla, 'tipo': tipo, 'modelo': modelo, 'modeloConMecanismo': modeloConMecanismo}, function() {
				
				$('input.variaciones:checkbox').off();
				$('input.variaciones:checkbox').on('change', function() {
					
					var modeloConMecanismo = $(this).data('modeloconmecanismo');
					var variacion = $(this).data('variacion');
					var en_uso = 0;
					if ($(this).prop('checked')) {
						en_uso = 1;
					}
					var url = "../../../../resources/library/AJAX.php?act=actualizarVariacionesArticulo";
					$.post(url, {"modeloConMecanismo": modeloConMecanismo, "variacion": variacion, "en_uso": en_uso }, function(data) {
					
					});
				});
				
				$('input.mecanismos:checkbox').off();
				$('input.mecanismos:checkbox').on('change',function() {
					//alert('test');
					//$(this).next('input').toggleClass('precio-hidden');
					var modelo = $(this).data('modelo');
					var mecanismo = $(this).data('mecanismo');
					var en_uso = 0;
					if ($(this).prop('checked')) {
						en_uso = 1;
						$(this).next().next().removeClass('precio-hidden');
					} else {
						$(this).next().next().addClass('precio-hidden');
					}
					var url = "../../../../resources/library/AJAX.php?act=actualizarModeloConMecanismo";
					$.post(url, {"modelo": modelo, "mecanismo": mecanismo, "en_uso": en_uso }, function(data) {
						$('select.modeloConMecanismo').first().change();
					});
					
					
				});
				
				$('input.precio-mm').off();
				$('input.precio-mm').on('change keyup', function() {
					var id = $(this).data('id');
					var precio = $(this).val();
					var url = "../../../../resources/library/AJAX.php?act=actualizarPrecioModeloConMecanismo";
					$.post(url, {"id": id, "precio": precio }, function(data) {
						//$('select.modeloConMecanismo').change();
					});
				});
				
				$('select.modeloConMecanismo').off();
				$('select.modeloConMecanismo').on('change',function() {
					
					var modeloConMecanismo = $(this).val();
					$('div.variaciones').each( function(index) {
						//console.log(index);
						//console.log($(this).data('tabla'));
						var tabla = $(this).data('tabla');
						var tipo = $(this).data('tipo');
						actualizarCheckboxes(tabla, tipo, modeloConMecanismo );
					});
				});
			});
		}
		
		actualizarCheckboxes('mecanismos', 'mecanismos', 'nulo');
		
		$('div.variaciones').each( function(index) {
			//console.log($(this).data('tabla'));
			var tabla = $(this).data('tabla');
			var tipo = $(this).data('tipo');
			actualizarCheckboxes(tabla, tipo, 'nulo');
		});
		
		$('select.modelos').change(function() {
			actualizarCheckboxes('mecanismos', 'mecanismos', 'nulo');
		
			$('div.variaciones').each( function(index) {
				//console.log($(this).data('tabla'));
				var tabla = $(this).data('tabla');
				var tipo = $(this).data('tipo');
				actualizarCheckboxes(tabla, tipo, 'nulo');
			});
		});
		
		
		$('select.modelo.preview').change(function() {
			var modelo = $(this).val();
			var url = "../../../../resources/library/AJAX.php?act=actualizarFormPreviewModelo";
			//actualizarResultado();
			$.post(url, {'modelo': modelo}, function(data) {
				data = JSON.parse(data);
				
				console.log(data);
				
				$('textarea.modelo.descripcion.preview').text(data.descripcion);
				$('input.precio.modelo.preview').val(data.precio);
				
				var url = "../../../../resources/library/AJAX.php?act=actualizarPreviewMecanismos";	
				$('div.preview.mecanismo').load(url, {'modelo': modelo}, function() {
					
					
					$('select.mecanismo.preview').change(function() {
						var valor = $(this).val();
						var url = "../../../../resources/library/AJAX.php?act=actualizarFormPreviewMecanismo";
						$.post(url, {'valor': valor}, function(data) {
							data = JSON.parse(data);
							
							actualizarResultado();
							$('form.preview').off();
							$('form.preview').submit(function(event) {
								event.preventDefault();
								var formValues = $(this).serialize();
								formValues += "&tabla=" + $(this).data('tipo');
								var url = "../../../../resources/library/AJAX.php?act=actualizarMaestroPreview";
								$.post(url, formValues, function() {
									actualizarResultado();
									
								});
							});
							
							$('textarea.mecanismo.descripcion.preview').text(data.descripcion);
							$('input.precio.mecanismo.preview').val(data.precio);
							$('input.imagen.mecanismo.preview').val(data.imagen);
							
							var url = "../../../../resources/library/AJAX.php?act=actualizarPreviewVariaciones";	
							$('div.preview.variaciones').load(url, {'valor': valor}, function() {
								$('select.variaciones.preview').change(function() {
								var valor = $(this).val();
								var tipo = $(this).data('tipo');
								var url = "../../../../resources/library/AJAX.php?act=actualizarPreviewVariacion";
								$.post(url, {'valor': valor}, function(data) {
									data = JSON.parse(data);
									
									//console.log(data);
									
									$('textarea.descripcion.preview.' + tipo).text(data.descripcion);
									$('input.precio.preview.' + tipo).val(data.precio);
									
									actualizarResultado();
									$('form.preview').off();
									$('form.preview').submit(function(event) {
										event.preventDefault();
										var formValues = $(this).serialize();
										formValues += "&tabla=" + $(this).data('tipo');
										var url = "../../../../resources/library/AJAX.php?act=actualizarMaestroPreview";
										$.post(url, formValues, function() {
											actualizarResultado();
											
										});
									});
									
								});
							});
								
							});
						});
					});
				
				});
			});
		});
		
		$('form.preview').submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			formValues += "&tabla=" + $(this).data('tipo');
			var url = "../../../../resources/library/AJAX.php?act=actualizarMaestroPreview";
			$.post(url, formValues, function() {
				
				actualizarResultado();
			});
		});
		
		var actualizarResultado = function() {
			var url = "../../../../resources/library/AJAX.php?act=actualizarPreviewResultado";
			
			var modeloConMecanismo = $('select.preview.mecanismo').val();
			var variaciones = '0, ';
			$.each($('select.variaciones'), function() {
				if ($(this).val()) {
					variaciones += $(this).val() + ', ';
				}
			});
			variaciones += '0';
			
			$('div.resultado').load(url, {"modeloConMecanismo": modeloConMecanismo, "variaciones": variaciones}, function() { 
			});
		}
		//actualizarResultado();
		
		
		
		$( "div.tabs" ).tabs();
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	