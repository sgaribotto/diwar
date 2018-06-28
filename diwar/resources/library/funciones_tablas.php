<?php
	//PARA USAR EN EL AJAZ
	//REQUIERE CONEXION A MYSQLI PREVIA
	function tablaListado($mysqli, $query, $eliminar = true, $paginaEdicion = '', $editarInline = '', $reference = '', $maestro = '') {
		$result = $mysqli->query($query);
		$tabla = array();
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$tabla[] = $row;
		}
		if (isset($tabla[0])){
			$headers = array_keys($tabla[0]);
		}
		if ($eliminar) {
			$headers[] = 'Eliminar';
		}
		if ($editarInline != '' or $paginaEdicion != '') {
			$headers[] = 'Editar';
		}
		
		echo "<table class='listado'>";
		echo "<thead class='listado'><tr class='listado'>";
		foreach ($headers as $header) {
			if (!in_array($header, ['id', 'en_uso', 'clave', $reference])) {
				echo "<th class='listado {$header}'>" . ucfirst($header) . "</th>";
			}
		}
		echo "</tr></thead>";
		echo "<tbody class='listado'>";
		foreach ($tabla as $nro => $datos) {
			
			echo "<tr class='listado'>";
			
			foreach ($datos as $campo => $valor) {
				if (!in_array($campo, ['id', 'en_uso', 'clave', $reference])){
					echo "<td class='listado {$campo}'>{$valor}</td>";
				}
				
				
			}
			
			if ($eliminar) {
				if ($datos	['en_uso'] == 1) {
					echo "<td class='listado eliminar'><button class='eliminarElemento eliminar' data-id='{$datos['id']}' data-tabla='{$editarInline}'>X</button></td>";
				} else {
					echo "<td>Eliminado</td>";
				}
			}
			
			if ($paginaEdicion != '') {
				echo "<td class='listado editar'>";
				echo "<a class='editarTR editar' href='{$paginaEdicion}?id={$datos['id']}' data-id='{$datos['id']}'>";
				echo 'Editar';
				echo '</a>';
				echo "</td>";
			}
			
			if ($editarInline != '') {
				echo "<td class='listado'>";
				echo "<button class='editarInline {$editarInline}' type='button' data-id='{$datos['id']}' data-tabla='{$editarInline}'>";
				echo 'Editar';
				echo '</button>';
				echo "</td>";
			}
			
			echo "</tr>";
			
		}			

		echo "</tbody></table>";
		
		return 0;
		//print_r($tabla);
	}
	
	function armarFormulario($mysqli, $tabla, $id = 'nuevo') {
		$query = "DESCRIBE {$tabla}";
		$result = $mysqli->query($query);
		$campos = array();
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$campos[$row['Field']] = $row;
		}
		
		$query = "SELECT 
					  TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME, REFERENCED_TABLE_NAME,REFERENCED_COLUMN_NAME
					FROM
					  INFORMATION_SCHEMA.KEY_COLUMN_USAGE
					WHERE
					   TABLE_NAME = '{$tabla}'
					   AND NOT ISNULL(REFERENCED_TABLE_NAME);";
		$result = $mysqli->query($query);
		$constraints = array();
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$constraints[$row['COLUMN_NAME']] = $row;
		}
		
		if ($id != 'nuevo') {
			$query = "SELECT * FROM {$tabla} WHERE id = {$id}";
			$result = $mysqli->query($query);
			echo $mysqli->error;
			//print_r($result);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			foreach ($row as $key => $value) {
				$campos[$key]['Default'] = $value;
			}
		}
		
		//print_r($campos);
		//print_r($constraints);
		$excluir = ['id', 'en_uso', 'clave'];
		foreach ($campos as $key => $detalles) {
			if (!in_array($detalles['Field'], $excluir)) {
				$label = ucfirst(str_replace('_', ' ', $detalles['Field']));
				if (!isset($constraints[$detalles['Field']])) {
					switch ($detalles['Type']) {
						case 'varchar(255)':
							
							echo "<label for='{$detalles['Field']}' class='text {$detalles['Field']}'>{$label}: </label>";
							if ($detalles['Field'] != 'descripcion') {
							echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' maxlength='255' type='text' required />";
							} else {
								echo "<br><textarea name='{$detalles['Field']}' placeholder='descripción del producto...' maxlength='254' >{$detalles['Default']}</textarea>";
							}
							echo "<br />";
							break;
						case 'text':
							
							echo "<label for='{$detalles['Field']}' class='text {$detalles['Field']}'>{$label}: </label>";
							echo "<textarea name='{$detalles['Field']}' placeholder='Observaciones...'>{$detalles['Default']}</textarea>";
							
							echo "<br />";
							break;
							
						case 'double':
						case 'int(11)':
							echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$label}: </label>";
							echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}'  type='text' required/>";
							echo "<br />";
							break;
							
						case "tinyint(4)":
							echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$label}: </label>";
							$checked = '';
							if ($detalles['Default'] == 1) {
								$checked = 'checked';
							}
							echo "<input class='checkbox {$detalles['Field']}' name='{$detalles['Field']}' type='checkbox' {$checked} />";
							echo "<br />";
							break;
							break;
						
						default:
							echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$label}: </label>";
							echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' type='text' required />";
							echo "<br />";
							break;
					}
				} else {
					//print_r($constraints[$detalles['Field']]);
					echo "<label for='{$detalles['Field']}' class='{$detalles['Field']}'>{$label}: </label>";
					echo "<select name='{$detalles['Field']}' class='{$detalles['Field']}'>";
					
					$query = "SELECT id, nombre
								FROM {$constraints[$detalles['Field']]['REFERENCED_TABLE_NAME']}
								WHERE en_uso = 1;";
					$result = $mysqli->query($query);
					echo $query . "<br>";
					echo $mysqli->error;
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$selected = '';
						if ($detalles['Default'] == $row['id']) {
							$selected = 'selected';
						}
						echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
					}
					echo "<option>TEST</option>";
					echo "</select>";
					echo "<br>";
				}
			}
			 
		}
		
		$textoBoton = 'Agregar';
		
		if ($id != 'nuevo') {
			$textoBoton = "Modificar";
		}
		echo "<button type='submit' class='formulario submit agregarMaestro {$tabla}' data-id='{$id}'>{$textoBoton}</button>";
		echo "<button type='button' class='formulario limpiar nuevo maestro {$tabla}'>Nuevo</button>";
		
		return 0;
	}
	
function armarFormularioSecundario($mysqli, $tabla, $reference, $id = 'nuevo') {
		$query = "DESCRIBE {$tabla}";
		$result = $mysqli->query($query);
		$campos = array();
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$campos[$row['Field']] = $row;
		}
		
		if ($id != 'nuevo') {
			$query = "SELECT * FROM {$tabla} WHERE id = {$id}";
			//echo $query;
			$result = $mysqli->query($query);
			//echo $mysqli->error;
			//print_r($result);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			foreach ($row as $key => $value) {
				$campos[$key]['Default'] = $value;
			}
		}
		
		//print_r($campos);
		$excluir = ['id', 'en_uso', 'clave', $reference];
		
		$constraints = array(
			'vendedor' => array('value' => 'id',
									'text' => 'nombre',
									'table' => 'vendedores'),
			'cliente' => array('value' => 'id',
									'text' => 'nombre',
									'table' => 'clientes'),
		);
							
		
		//print_r($campos);
		//print_r($excluir);
		foreach ($campos as $key => $detalles) {
		
			if (!in_array($detalles['Field'], $excluir)) {
				
				$label = ucfirst(str_replace('_', ' ', $detalles['Field']));
				if (!isset($constraints[$detalles['Field']])) {
					switch ($detalles['Type']) {
						
						
						case 'varchar(255)':
							
							echo "<label for='{$detalles['Field']}' class='text {$detalles['Field']}'>{$label}: </label>";
							if ($detalles['Field'] != 'descripcion') {
							echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' maxlength='255' type='text' required />";
							} else {
								echo "<textarea name='{$detalles['Field']}' placeholder='descripción del producto...' maxlength='254' >{$detalles['Default']}</textarea>";
							}
							echo "<br />";
							break;
						case 'text':
							
							echo "<label for='{$detalles['Field']}' class='text {$detalles['Field']}'>{$label}: </label>";
							echo "<textarea name='{$detalles['Field']}' placeholder='Observaciones...'>{$detalles['Default']}</textarea>";
							
							echo "<br />";
							break;
							
						case 'double':
						case 'int(11)':
							echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$label}: </label>";
							echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}'  type='number' required/>";
							echo "<br />";
							break;
							
						case "tinyint(4)":
							echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$label}: </label>";
							$checked = '';
							if ($detalles['Default'] == 1) {
								$checked = 'checked';
							}
							echo "<input class='checkbox {$detalles['Field']}' name='{$detalles['Field']}' type='checkbox' {$checked} />";
							echo "<br />";
							break;
							break;
						
						default:
							echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$label}: </label>";
							echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' type='text' required />";
							echo "<br />";
							break;
					}
				} else {
					echo "<label for='{$detalles['Field']}' class='select {$detalles['Field']}'>{$label}: </label>";
					echo "<select class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' required >";
					
					$query = "SELECT {$constraints[$detalles['Field']]['value']} AS value, {$constraints[$detalles['Field']]['text']} AS text
								FROM {$constraints[$detalles['Field']]['table']}
								WHERE en_uso = 1";
					$result = $mysqli->query($query);
					echo $query;
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						echo "<option value='{$row['value']}'>{$row['text']}</option>";
					}
					echo "</select>";
					echo "<br />";
				}
			}
		}
		
		$textoBoton = 'Agregar';
		
		if ($id != 'nuevo') {
			$textoBoton = "Modificar";
		}
		echo "<button type='submit' class='formulario submit agregarSecundario {$tabla}' data-id='{$id}'>{$textoBoton}</button>";
		echo "<button type='button' class='formulario limpiar secundario'>Limpiar Formulario</button>";
		
		return 0;
	}


?>