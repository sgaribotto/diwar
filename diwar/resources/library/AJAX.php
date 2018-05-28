<?php require '../config.php'; ?>
<?php require 'funciones_tablas.php'; ?>
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
					
				case "actualizarFormularioMaestro":
				
					//print_r($_REQUEST);
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$id = $_REQUEST['id'];
					
					
					armarFormulario($mysqli, $maestro, $id);
					
					break;
				
				case "actualizarFormularioSecundario":
				
					//print_r($_REQUEST);
					$reference = $mysqli->real_escape_string($_REQUEST['reference']);
					//$idMaestro = $_REQUEST['idMaestro'];
					$tabla = $mysqli->real_escape_string($_REQUEST['tabla']);
					$id = $_REQUEST['id'];
					
					armarFormularioSecundario($mysqli, $tabla, $reference, $id);
					
					break;
					
				case "actualizarTablaMaestro":
					//print_r($_REQUEST);
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$filtro = $mysqli->real_escape_string($_REQUEST['filtro']);
					$en_uso = $mysqli->real_escape_string($_REQUEST['en_uso']);
					
					
					$query = "SELECT *
								FROM {$maestro}
								WHERE en_uso >= {$en_uso}
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
					
				case "actualizarAutocompletar":
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$tipo = $mysqli->real_escape_string($_REQUEST['tipo']);
					
					$query = "SELECT DISTINCT {$tipo}
								FROM {$maestro}
								WHERE en_uso = 1
								ORDER BY {$tipo};";
					$result = $mysqli->query($query);
					//echo $query;
					//echo $mysqli->error;
					$tipos = array();
					if (!$mysqli->errno) {
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							$tipos[] = $row['tipo'];
						}
						$tipos = json_encode($tipos);
						echo $tipos;
					}
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
					
					if ($id == 'nuevo') {
						$query = "REPLACE INTO {$maestro} SET ";
						foreach ($campos as $campo => $valor) {
							if (!in_array($campo, $excluir)) {
								$query .= " {$campo} = '{$valor}', ";
							}
						}
						$query .= " en_uso = 1 ";
						$mysqli->query($query);
					
						$id = $mysqli->insert_id;
					} else {
						$query = "UPDATE {$maestro} SET ";
						foreach ($campos as $campo => $valor) {
							if (!in_array($campo, $excluir)) {
								$query .= " {$campo} = '{$valor}', ";
							}
						}
						$query .= " en_uso = 1 ";
						$query .= " WHERE id = {$id} ";
						$mysqli->query($query);
					}
					
					//echo $query;
					//echo $mysqli->error;
					
					echo $id;
					break;
				case "agregarSecundario":
					$campos = array();
					$id = $_REQUEST['id'];
					//print_r($_REQUEST);
					$excluir = ['maestro', 'id', 'act', 'idMaestro', 'tabla', 'reference'];
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $maestro = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}
					$tabla = $campos['tabla'];
					$maestro = $campos['maestro'];
					$reference = $campos['reference'];
					$idMaestro = $campos['idMaestro'];
					
					if ($id == 'nuevo') {
						$query = "INSERT INTO {$tabla} SET ";
						foreach ($campos as $campo => $valor) {
							if (!in_array($campo, $excluir)) {
								$query .= " {$campo} = '{$valor}', ";
							}
						}
						$query .= " en_uso = 1, ";
						$query .= " {$reference} = {$idMaestro} ";
						$mysqli->query($query);
					
						$id = $mysqli->insert_id;
					} else {
						$query = "UPDATE {$tabla} SET ";
						foreach ($campos as $campo => $valor) {
							if (!in_array($campo, $excluir)) {
								$query .= " {$campo} = '{$valor}', ";
							}
						}
						$query .= " en_uso = 1 ";
						$query .= " WHERE id = {$id} ";
						$mysqli->query($query);
					}
					
					echo $query;
					echo $mysqli->error;
					
					echo $id;
					break;
					
				case "eliminarMaestro":
					$maestro = $mysqli->real_escape_string($_REQUEST['maestro']);
					$id = $_REQUEST['id'];
					$query = "UPDATE {$maestro} SET en_uso = 0 WHERE id = {$id}";
					$mysqli->query($query);
					break;
					
				case "actualizarTabla":
					$campos = array();
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $maestro = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}
					//$id = $_REQUEST['id'];
					//$excluir = ['maestro', 'id', 'act'];
					
					
					
					$tabla = $campos['tabla'];
					switch($tabla) {
						case 'clientes':
							$where = '';
							$filtro = $campos['filtro'];
							if ($filtro != '') {
								$where = " AND (nombre LIKE '%{$filtro}%' 
										OR codigo_cliente LIKE '%{$filtro}%'
										OR localidad LIKE '%{$filtro}%'
										OR provincia LIKE '%{$filtro}%'
										OR cuit LIKE '%{$filtro}%')";
							}
							$query = "SELECT id, codigo_cliente, cuit, nombre, localidad, provincia
								FROM clientes
								WHERE en_uso = {$campos['en_uso']} {$where}";
							tablaListado($mysqli, $query, true, 'cliente.php', '');
							break;
						
						case "vendedores":
							$where = '';
							$filtro = $campos['filtro'];
							if ($filtro != '') {
								$where = " AND (nombre LIKE '%{$filtro}%' 
										OR codigo_cliente LIKE '%{$filtro}%'
										OR localidad LIKE '%{$filtro}%'
										OR provincia LIKE '%{$filtro}%'
										OR cuit LIKE '%{$filtro}%')";
							}
							$query = "SELECT *
								FROM {$tabla}
								WHERE en_uso = {$campos['en_uso']}
									{$where}";
									
							tablaListado($mysqli, $query, true, 'vendedor.php', '');
							break;
							
						default:
							$where = '';
							$filtro = $campos['filtro'];
							if ($filtro != '') {
								$where = " AND (nombre LIKE '%{$filtro}%' 
										OR codigo_cliente LIKE '%{$filtro}%'
										OR localidad LIKE '%{$filtro}%'
										OR provincia LIKE '%{$filtro}%'
										OR cuit LIKE '%{$filtro}%')";
							}
							$query = "SELECT *
								FROM {$tabla}
								WHERE en_uso = {$campos['en_uso']}
									{$where}";
									
							tablaListado($mysqli, $query, true, '', '');
							break;
						
					}
					break;
					
				case "eliminarElemento":
					$campos = array();
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $maestro = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}

					$tabla = $campos['tabla'];
					switch($tabla) {
						case "clientes":
							$query = "UPDATE clientes SET en_uso = 0 WHERE id = {$campos['id']}";
							$mysqli->query($query);
							break;
						
						default:
							$query = "UPDATE {$tabla} SET en_uso = 0 WHERE id = {$campos['id']}";
							$mysqli->query($query);
							break;
					}
					break;
					
					case "actualizarFormulario":
						$campos = array();
						foreach($_REQUEST as $key => $value) {
							if (is_string($value)) {
								$campos[$key] = $maestro = $mysqli->real_escape_string($value);
							} else {
								$campos[$key] = $value;
							}
						}
						$tabla = $campos['tabla'];
						
						switch($tabla) {
							case 'clientes':
								$where = '';
								$filtro = $campos['filtro'];
								if ($filtro != '') {
									$where = " AND (nombre LIKE '%{$filtro}%' 
											OR codigo_cliente LIKE '%{$filtro}%'
											OR localidad LIKE '%{$filtro}%'
											OR provincia LIKE '%{$filtro}%'
											OR cuit LIKE '%{$filtro}%')";
								}
								$query = "SELECT id, codigo_cliente, cuit, nombre, localidad, provincia
									FROM clientes
									WHERE en_uso = {$campos['en_uso']} {$where}";
								tablaListado($mysqli, $query, true, 'cliente.php', false);
								break;
							
						}
					break;
					
				case "actualizarTablaSecundario":
					//print_r($_REQUEST);
					$campos = array();
						foreach($_REQUEST as $key => $value) {
							if (is_string($value)) {
								$campos[$key] = $maestro = $mysqli->real_escape_string($value);
							} else {
								$campos[$key] = $value;
							}
						}
						$tabla = $campos['tabla'];
						$reference = $campos['reference'];
						$idMaestro = $campos['idMaestro'];
						$en_uso = $campos['en_uso'];
					$query = "SELECT *
								FROM {$tabla}
								WHERE {$reference} = {$idMaestro}
									AND en_uso = {$en_uso}";
					tablaListado($mysqli, $query, true, '', $tabla, $reference);
					break;
					
				case "actualizarCheckboxes":
					$campos = array();
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $maestro = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}
					$tabla = $campos['tabla'];
					$tipo = $campos['tipo'];
					$modeloConMecanismo = $campos['modeloConMecanismo'];
					$modelo = $campos['modelo'];
					
					switch ($tabla) {
						case "mecanismos":
							$query = "SELECT DISTINCT m.id, m.nombre, IFNULL(mm.en_uso, 0) AS checked 
										FROM mecanismos AS m
										LEFT JOIN modelos_con_mecanismo AS mm
											ON mm.mecanismo = m.id
												AND mm.modelo = {$modelo}
										WHERE m.en_uso = 1
										ORDER BY m.nombre";
							$result = $mysqli->query($query);
							
							while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
								$checked = '';
								if ($row['checked'] == 1) {
									$checked = 'checked';
								}
								echo "<input type='checkbox' value='{$row['id']}' data-mecanismo='{$row['id']}' data-tabla='mecanismos' 
										data-modelo='{$modelo}' {$checked} name='mecanismo' class='mecanismos'/>";
								echo "<label for='mecanismo' class='checkbox'>{$row['nombre']}</label>";
								echo "<br>";
							}
							
							break;
							
						case "variaciones":
							echo "<select class='modeloConMecanismo' name='modeloConMecanismo'>";
							$query = "SELECT mm.id, m.nombre
										FROM modelos_con_mecanismo AS mm
										LEFT JOIN mecanismos AS m
											ON mm.mecanismo = m.id
										WHERE mm.modelo = {$modelo}
											AND mm.en_uso = 1
										ORDER BY m.nombre";
										
							//echo $query;
							$result = $mysqli->query($query);
							//echo $mysqli->error;
							if ($result->num_rows) {
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									if ($modeloConMecanismo == 'nulo') {
										$modeloConMecanismo = $row['id'];
									}
									
									$selected = '';
									if ($row['id'] == $modeloConMecanismo) {
										$selected = 'selected';
									}
									echo "<option value='{$row['id']}' {$selected}>{$row['nombre']}</option>";
								}
								echo "</select><br>";
								
								$query = "SELECT v.id, v.nombre, IFNULL(a.en_uso, 0) AS checked
											FROM diwar.variaciones AS v
											LEFT JOIN articulos AS a
												ON a.variaciones = v.id
													AND a.modelo_con_mecanismo = {$modeloConMecanismo}
											WHERE v.tipo = '{$tipo}'
											ORDER BY v.nombre";
								$result = $mysqli->query($query);
								
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									$checked = '';
									if ($row['checked'] == 1) {
										$checked = 'checked';
									}
									echo "<input type='checkbox' value='{$row['id']}' data-variacion='{$row['id']}' data-tabla='variaciones' 
											data-tipo='{$tipo}' {$checked} name='mecanismo' class='variaciones' 
											data-modeloconmecanismo='{$modeloConMecanismo}' />";
									echo "<label for='mecanismo' class='checkbox'>{$row['nombre']}</label>";
									echo "<br>";
								}
							}
							break;
							
						
							
						default:
							echo "No se reconoce la tabla solicitada";
							break;
							
					}
						
					break;
					
				case "actualizarModeloConMecanismo":
					$campos = array();
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}
					$modelo = $campos['modelo'];
					$mecanismo = $campos['mecanismo'];
					$en_uso = $campos['en_uso'];
					
					$query = "SELECT id
								FROM modelos_con_mecanismo
								WHERE modelo = {$modelo}
									AND mecanismo = {$mecanismo}";
					$result = $mysqli->query($query);
					
					$id = false;
					if ($result->num_rows) {
						$id = $result->fetch_array(MYSQLI_ASSOC)['id'];
					}
					
					
					if ($id) {
						$query = "UPDATE modelos_con_mecanismo
									SET modelo = {$modelo},
										mecanismo = {$mecanismo},
										en_uso = {$en_uso}
									WHERE id = {$id}";
					} else {
						$query = "INSERT INTO modelos_con_mecanismo
									SET modelo = {$modelo},
										mecanismo = {$mecanismo},
										en_uso = {$en_uso}";
					}
					$mysqli->query($query);
					//echo $query;
					//echo $mysqli->error;
					break;
				case "actualizarVariacionesArticulo":
					$campos = array();
					foreach($_REQUEST as $key => $value) {
						if (is_string($value)) {
							$campos[$key] = $mysqli->real_escape_string($value);
						} else {
							$campos[$key] = $value;
						}
					}
					$modeloConMecanismo = $campos['modeloConMecanismo'];
					$variacion = $campos['variacion'];
					$en_uso = $campos['en_uso'];
					
					$query = "SELECT id
								FROM articulos
								WHERE modelo_con_mecanismo = {$modeloConMecanismo}
									AND variaciones = {$variacion}";
					$result = $mysqli->query($query);
					
					$id = false;
					if ($result->num_rows) {
						$id = $result->fetch_array(MYSQLI_ASSOC)['id'];
					}
					
					
					if ($id) {
						$query = "UPDATE articulos
									SET modelo_con_mecanismo = {$modeloConMecanismo},
										variaciones = {$variacion},
										en_uso = {$en_uso}
									WHERE id = {$id}";
					} else {
						$query = "INSERT INTO articulos
									SET modelo_con_mecanismo = {$modeloConMecanismo},
										variaciones = {$variacion},
										en_uso = {$en_uso}";
					}
					$mysqli->query($query);
					echo $query;
					echo $mysqli->error;
					break;

				case "actualizarOptionsModelosConMecanismo":
					$modelo = $_REQUEST['modelo'];
					
					$query = "SELECT mm.id, m.nombre
								FROM modelos_con_mecanismo AS mm
								LEFT JOIN mecanismos AS m
									ON m.id = mm.mecanismo
								WHERE mm.modelo = {$modelo}
									AND mm.en_uso = 1
								ORDER BY m.nombre";
					$result = $mysqli->query($query);
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
					}
					break;
				default:
					echo "No se realizó la búsqueda";
					break;
			}
		$mysqli->close();
	}
	
	

?>