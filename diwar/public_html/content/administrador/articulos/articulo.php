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
	echo "</div>";
?>
<script>
	$(document).ready(function() {
		
							
		var actualizarCheckboxes = function(tabla, tipo, modeloConMecanismo) {
			
			var modelo = $('select.modelos').val();
			var url = "../../../../resources/library/AJAX.php?act=actualizarCheckboxes";
			$('div.' + tipo).load(url, {'tabla': tabla, 'tipo': tipo, 'modelo': modelo, 'modeloConMecanismo': modeloConMecanismo}, function() {
				
				$('input.variaciones:checkbox').off();
				$('input.variaciones:checkbox').change(function() {
					
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
				$('input.mecanismos:checkbox').change(function() {
					
					var modelo = $(this).data('modelo');
					var mecanismo = $(this).data('mecanismo');
					var en_uso = 0;
					if ($(this).prop('checked')) {
						en_uso = 1;
					}
					var url = "../../../../resources/library/AJAX.php?act=actualizarModeloConMecanismo";
					$.post(url, {"modelo": modelo, "mecanismo": mecanismo, "en_uso": en_uso }, function(data) {
						$('select.modeloConMecanismo').change();
					});
				});
				
				$('select.modeloConMecanismo').change(function() {
					
					var modeloConMecanismo = $(this).val();
					$('div.variaciones').each( function(index) {
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
		
		
		
		$( "div.tabs" ).tabs();
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	