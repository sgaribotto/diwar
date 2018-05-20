<?php require '../config.php'; ?>
<?php
	//header('Content-Type: text/html; charset=utf-8');
//Consultas vía AJAX
	//Autoload de la clase.
	
	//print_r($_SESSION);
	
	if (isset($_GET['act'])) {
			
			$mysqli = connection($config, 'db1');
			switch($_GET['act']) {
				
				case "errorLogging":
					$errorLog = fopen('errorLog.txt', 'a+');
					
					$error = $_GET['error'];
					$date = date('Y - m - d');
					$sesion = json_encode($_SESSION);
					
					$log = $date . "\t" . $error . "\t" . $sesion . "\n";
					
					fwrite($errorLog, $log);
					fclose($errorLog);
					break;
					
				case "optionsmecanismo":
					
					$valor = $_REQUEST['valor'];
					
					$query = "SELECT mm.id, m.nombre
								FROM modelos_con_mecanismo AS mm
								LEFT JOIN mecanismos AS m
									ON mecanismo = m.id
								WHERE modelo = '{$valor}'
									AND mm.en_uso = 1;";
					$result = $mysqli->query($query);
					echo "<option value=''>Seleccione mecanismo...</option>";
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
					}
					
					break;
					
				case "optionscolor-tapizado":
					
					$valor = $_REQUEST['valor'];
					$query = "SELECT v.nombre
								FROM variaciones AS v
								
								WHERE v.id = {$valor};";
					$result = $mysqli->query($query);
					$tipo = $result->fetch_array()[0];
					
					$query = "SELECT id, nombre 
								FROM colores
								WHERE tipo = '{$tipo}'
									AND en_uso = 1;";
					//echo $query;
					$result = $mysqli->query($query);
					echo "<option value=''>Seleccione color de tapizado...</option>";
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
					}
					
					break;
				
					
				case "optionsvariaciones":
					
					$valor = $_REQUEST['valor'];
					
					
					$query = "SELECT v.id, a.modelo_con_mecanismo, a.codigo_articulo, 
									v.tipo, v.nombre
								FROM articulos AS a
								LEFT JOIN variaciones AS v
									ON a.variaciones = v.id
								WHERE modelo_con_mecanismo = '{$valor}'
									AND v.en_uso = 1;";
					$result = $mysqli->query($query);
					//echo $query;
					
					$variaciones = array();
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$variaciones[$row['tipo']][$row['id']] = $row['nombre'];
					}
					//print_r($variaciones);
					foreach ($variaciones as $tipo => $options) {
						echo "<label class='variaciones label-variaciones-{$tipo} {$tipo} agregar-articulo' for='{$tipo}'>{$tipo}: </label>";
						echo "<select class='variaciones agregar-articulo variaciones-{$tipo} {$tipo}' name='{$tipo}' required>";
						echo "<option value=''>Seleccione {$tipo}...</option>";
						foreach ($options as $id => $nombre) {
							echo "<option value='{$id}'>{$nombre}</option>";
						}
						
							
						echo "</select>";
						
						if (in_array($tipo, ['tapizado', 'red', 'casco'])) {
							echo "<label class='variaciones label-color-{$tipo} colores agregar-articulo ' for='color-{$tipo}'>Color {$tipo}: </label>";
							echo "<select class='variaciones color-{$tipo} colores agregar-articulo ' name='color-{$tipo}' required>";
							echo "<option value=''>Seleccione color de {$tipo}...</option>";
							
							if ($tipo != 'tapizado') {
								//echo "RED";
								$query = "SELECT c.id, c.nombre
											FROM colores AS c
											WHERE c.tipo = '{$tipo}'
												AND c.en_uso = 1;";
								echo $query;
								$result = $mysqli->query($query);
								
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									echo "<option value='{$row['id']}' >{$row['nombre']}</option>";
								}
							}
							echo "</select>";
						}
						echo "<br />";
					}
					echo "<button type='submit'>Agregar artículo</button>";
					break;
					
					
				case "agregarArticuloPresupuesto":
				
					
					$query = "SELECT DISTINCT tipo
								FROM variaciones
								WHERE en_uso = 1;";
					$tipos = array();
					$variaciones = array();
					$result = $mysqli->query($query);
					$informacion = array();
					echo $mysqli->error;
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$tipos[] = $row['tipo'];
					}
					
					foreach ($_REQUEST as $tipo => $valor) {
						if (in_array($tipo, $tipos)) {
							$variaciones[$tipo] = $mysqli->real_escape_string($_REQUEST[$tipo]);
						} else {
							$informacion[$tipo] = $mysqli->real_escape_string($_REQUEST[$tipo]);
						}
					}
					
					if (!isset($informacion['color-tapizado'])) {
						$informacion['color-tapizado'] = 'NULL';
					}
					if (!isset($informacion['color-red'])) {
						$informacion['color-red'] = 'NULL';
					}
					if (!isset($informacion['color-casco'])) {
						$informacion['color-casco'] = 'NULL';
					}
					
					$variaciones = implode(', ', $variaciones);
					
										
					
					$query = "INSERT INTO presupuestos
								(variaciones, articulo, numero, cliente, vendedor, cantidad, color_tapizado, color_red, color_casco, descuento_articulo) VALUES
								('{$variaciones}', '{$informacion['mecanismo']}', '{$informacion['numero']}', '{$informacion['cliente']}',
									'{$informacion['vendedor']}', '{$informacion['cantidad']}', {$informacion['color-tapizado']}, 
									{$informacion['color-red']}, {$informacion['color-casco']}, '{$informacion['descuento_articulo']}')";
					
					$mysqli->query($query);
					echo $query;
					echo "<br>";
					echo $mysqli->error;
					
					break;
					
				case 'actualizarTabla-articulos-cargados':
					$numero = $_REQUEST['numero'];
					$query = "SELECT DISTINCT p.id, a.codigo_articulo, p.variaciones, cred.nombre AS cred, 
								ctapiz.nombre AS ctapiz, ccasco.nombre AS ccasco, 
								p.articulo, p.cantidad, p.descuento_articulo, mm.modelo, mm.mecanismo,
								p.emitido
							FROM presupuestos AS p
							LEFT JOIN articulos AS a
								ON a.modelo_con_mecanismo = p.articulo
							LEFT JOIN modelos_con_mecanismo AS mm
								ON mm.id = p.articulo
							LEFT JOIN colores AS cred
								ON p.color_red = cred.id
							LEFT JOIN colores AS ctapiz
								ON p.color_tapizado = ctapiz.id
								LEFT JOIN colores AS ccasco
								ON p.color_casco = ccasco.id
							WHERE numero = {$numero}";
					$result = $mysqli->query($query);
					
					
					$articulos = array();
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$articulos[] = $row;
					}
					//print_r($articulos);
					echo "<table class='articulos presupuesto'>";
					echo "<thead>";
					echo "<tr>";
					echo "<th class='articulos'>Artículo</th>";
					echo "<th class='articulos'>Detalle</th>";
					echo "<th class='articulos'>Cantidad</th>";
					echo "<th class='articulos'>Descuento</th>";
					echo "<th class='articulos'>Precio</th>";
					echo "<th class='articulos'></th>";
					echo "</tr>";
					echo "</thead>";
					echo "<tbody>";
					foreach ($articulos as $id => $detalles) {
						$detalle = "";
						$precio = 0;
						
						$query = "SELECT descripcion, precio
									FROM modelos
									WHERE id = {$detalles['modelo']};";
						$result = $mysqli->query($query);
						$row = $result->fetch_array(MYSQLI_ASSOC);
						$descrip = $row['descripcion'];
						$detalle .= $descrip . ". ";
						$precio += $row['precio'];
						
						
						$query = "SELECT descripcion, precio
									FROM mecanismos
									WHERE id = {$detalles['mecanismo']};";
						
						$result = $mysqli->query($query);
						$row = $result->fetch_array(MYSQLI_ASSOC);
						$descrip = $row['descripcion'];
						$detalle .= $descrip . ". ";
						$precio += $row['precio'];
						
						if ($detalles['variaciones'] != '') {
							$query = "SELECT descripcion, precio
										FROM variaciones
										WHERE id IN ({$detalles['variaciones']});";
							$result = $mysqli->query($query);
							
							while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
								if ($row['descripcion'] != '') {
									$detalle .= $row['descripcion'] . ". ";
									$precio += $row['precio'];
								}
							}
						}
						
						$precio = $precio * (1 - $detalles['descuento_articulo'] / 100);
						
						
						if ($detalles['ctapiz'] != '') {
							$detalle .= "Tapizado color " . $detalles['ctapiz'] . ". ";
						}
						if ($detalles['cred'] != '') {
							$detalle .= "Red color " . $detalles['cred'] . ". ";
						}
						if ($detalles['ccasco'] != '') {
							$detalle .= "Casco color " . $detalles['ccasco'] . ". ";
						}
									
									
						
						
						echo "<tr class='presupuesto articulos'>";
						echo "<td class='articulos codigo'>{$detalles['codigo_articulo']}</td>";
						echo "<td class='articulos detalle'>{$detalle}</td>";
						echo "<td class='articulos cantidad'>{$detalles['cantidad']}</td>";
						echo "<td class='articulos cantidad'>{$detalles['descuento_articulo']}</td>";
						echo "<td class='articulos precio'>{$precio}</td>";
						if ($detalles['emitido'] == 0) {
							echo "<td class='articulos'><button type='button' class='botonEliminar' data-id='{$detalles['id']}'>X</button></td>";
						}
						echo "</tr>";
						
					}
					echo "</tbody>";
					echo "</table>";
					
					break;
					
				case "emitirPresupuesto":
					$numero = $_REQUEST['numero'];
					$query = "SELECT DISTINCT p.id, a.codigo_articulo, p.variaciones, cred.nombre AS cred, 
								ctapiz.nombre AS ctapiz, ccasco.nombre AS ccasco, 
								p.articulo, p.cantidad, p.descuento_articulo, mm.modelo, mm.mecanismo,
								p.descuento_articulo
							FROM presupuestos AS p
							LEFT JOIN articulos AS a
								ON a.modelo_con_mecanismo = p.articulo
							LEFT JOIN modelos_con_mecanismo AS mm
								ON mm.id = p.articulo
							LEFT JOIN colores AS cred
								ON p.color_red = cred.id
							LEFT JOIN colores AS ctapiz
								ON p.color_tapizado = ctapiz.id
								LEFT JOIN colores AS ccasco
								ON p.color_casco = ccasco.id
							WHERE numero = {$numero}";
					$result = $mysqli->query($query);
					
					
					$articulos = array();
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$articulos[] = $row;
					}
					
					
					foreach ($articulos as $id => $detalles) {
						$precio = 0;
						
						$query = "SELECT descripcion, precio
									FROM modelos
									WHERE id = {$detalles['modelo']};";
						$result = $mysqli->query($query);
						$row = $result->fetch_array(MYSQLI_ASSOC);
						$precio += $row['precio'];
						
						$query = "SELECT descripcion, precio
									FROM mecanismos
									WHERE id = {$detalles['mecanismo']};";
						
						$result = $mysqli->query($query);
						$row = $result->fetch_array(MYSQLI_ASSOC);
						$precio += $row['precio'];
						
						if ($detalles['variaciones'] != '') {
							$query = "SELECT descripcion, precio
										FROM variaciones
										WHERE id IN ({$detalles['variaciones']});";
							$result = $mysqli->query($query);
							
							while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
								if ($row['descripcion'] != '') {
									$precio += $row['precio'];
								}
							}
						}
						
						$precio = $precio * (1 - $detalles['descuento_articulo'] / 100);
						
						$query = "UPDATE presupuestos SET
									emitido = 1,
									precio_a_la_emision = {$precio},
									fecha_emision = CURRENT_TIMESTAMP
								WHERE id = {$detalles['id']}";
						$mysqli->query($query);
						echo $mysqli->error;
					}
					break;
					
				case "eliminar-articulos-cargados":
					$id = $_REQUEST['id'];
					$query = "DELETE FROM presupuestos
								WHERE id = $id";
					$mysqli->query($query);
					echo $query;
					echo $mysqli->error;
					break;
					
				/*case "eliminarMaestro":
					$id = $_REQUEST['id'];
					$query = "DELETE FROM presupuestos
								WHERE id = $id";
					$mysqli->query($query);
					echo $query;
					echo $mysqli->error;
					break;*/
					
				case "actualizarFormularioMaestro":
				
					//print_r($_REQUEST);
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$id = $_REQUEST['id'];
					
					$query = "DESCRIBE {$maestro}";
					$result = $mysqli->query($query);
					$campos = array();
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						$campos[$row['Field']] = $row;
					}
					
					if ($id != 'nuevo') {
						$query = "SELECT * FROM {$maestro} WHERE id = {$id}";
						$result = $mysqli->query($query);
						echo $mysqli->error;
						//print_r($result);
						$row = $result->fetch_array(MYSQLI_ASSOC);
						
						foreach ($row as $key => $value) {
							$campos[$key]['Default'] = $value;
						}
						
					}
					
					//print_r($campos);
					$excluir = ['id', 'en_uso'];
					foreach ($campos as $key => $detalles) {
						if (!in_array($detalles['Field'], $excluir)) {
							switch ($detalles['Type']) {
								case 'varchar(255)':
									
									echo "<label for='{$detalles['Field']}' class='text {$detalles['Field']}'>{$detalles['Field']}: </label>";
									if ($detalles['Field'] != 'descripcion') {
										echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' maxlength='255' type='text' />";
									} else {
										echo "<textarea name='{$detalles['Field']}' placeholder='descripción del producto...' maxlength='254'>{$detalles['Default']}</textarea>";
									}
									echo "<br />";
									break;
									
								case 'double':
								case 'int(11)':
									echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$detalles['Field']}: </label>";
									echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' maxlength='255' type='number'/>";
									echo "<br />";
									break;
								
								default:
									echo "<label for='{$detalles['Field']}' class='number {$detalles['Field']}'>{$detalles['Field']}: </label>";
									echo "<input class='text {$detalles['Field']}' name='{$detalles['Field']}' value='{$detalles['Default']}' type='text' />";
									echo "<br />";
									break;
							}
						}
					}
					
					$textoBoton = 'Agregar';
					
					if ($id != 'nuevo') {
						$textoBoton = "Modificar";
					}
					echo "<button type='submit' class='formulario submit agregarMaestro' data-id='{$id}'>{$textoBoton}</button>";
							
					break;
					
				case "actualizarTablaMaestro":
					//print_r($_REQUEST);
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$filtro = $mysqli->real_escape_string($_REQUEST['filtro']);
					
					
					
					$query = "SELECT *
								FROM {$maestro}
								WHERE en_uso = 1
									AND (nombre LIKE '%{$filtro}%')
								ORDER BY nombre, id";
					$result = $mysqli->query($query);
					//echo $query;
					$campos = array();
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						foreach ($row as $key => $value) {
							$campos[$row['id']][$key] = $value;
						}
					}
					
					
						
					echo "<table class='{$maestro} maestro datos'>";
					echo "<thead class='{$maestro} maestro datos'>";
					echo "<tr class='{$maestro} maestro datos'>";
					echo "<th class='{$maestro} maestro datos editar'>Editar</th>";
					//print_r($campos);
					$excluir = ['id', 'en_uso'];
					foreach ($campos as $id => $detalles) {
						foreach ($detalles as $key => $value) {
							if (!in_array($key, $excluir)) {
								echo "<th class='{$maestro} maestro datos'>{$key}</th>";
							}
						}
						break;
					}
					echo "<th class='{$maestro} maestro datos eliminar'>Eliminar</th>";
					echo "</tr>";
					
					foreach ($campos as $id => $detalles) {
						echo "<tr class='{$maestro} maestro datos'>";
						echo "<td class='{$maestro} maestro datos id {$key} editar'>";
						echo "<button type='button' class='editar-{$maestro} editarMaestro' data-id='{$id}'>E</button>";
						echo "</td>";
						foreach ($detalles as $key => $value) {
							if (!in_array($key, $excluir)) {
								echo "<td class='{$maestro} maestro datos {$key}'>{$value}</td>";
							}
						}
						echo "<td class='{$maestro} maestro datos id {$key} eliminar'>";
						echo "<button type='button' class='eliminarMaestro eliminarMaestro-{$maestro}' data-id='{$id}'>X</button>";
						
						echo "</td>";
						echo "</tr>";
					}
					echo "</table>";		
					break;
					
				case "agregarMaestro":
					$campos = array();
					$id = $_REQUEST['id'];
					$excluir = ['maestro', 'id', 'act'];
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $maestro = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}
					$maestro = $campos['maestro'];
					$query = "REPLACE INTO {$maestro} SET ";
					foreach ($campos as $campo => $valor) {
						if (!in_array($campo, $excluir)) {
							$query .= " {$campo} = '{$valor}', ";
						}
					}
					
					if ($id != 'nuevo') {
						$query .= " id = {$id}, ";
					}
					$query .= " en_uso = 1";
					//echo $query;
					$mysqli->query($query);
					if ($id == 'nuevo') {
						$id = $mysqli->insert_id;
					}
					
					
					echo $id;
					break;
					
				case "eliminarMaestro":
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$id = $_REQUEST['id'];
					$query = "UPDATE {$maestro} SET en_uso = 0 WHERE id = {$id}";
					$mysqli->query($query);
					break;
				
				
				default:
					echo "No se realizó la búsqueda";
					
			}
		$mysqli->close();
	}
	
	

?>