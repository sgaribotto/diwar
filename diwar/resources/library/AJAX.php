<?php require '../config.php'; ?>
<?php require 'funciones_tablas.php'; ?>
<?php
	//header('Content-Type: text/html; charset=utf-8');
//Consultas vía AJAX
	//Autoload de la clase.
	
	//print_r($_REQUEST);
	
	if (isset($_GET['act'])) {
			session_start();
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
				
				case "procesarIngreso":
					$usuario = $mysqli->real_escape_string($_REQUEST['usuario']);
					$clave = $mysqli->real_escape_string($_REQUEST['clave']);
					
					$query = "SELECT id, tipo, vendedor, usuario
								FROM usuarios
								WHERE usuario = '{$usuario}'
									AND clave = MD5('{$clave}')
									AND en_uso = 1;";
					$result = $mysqli->query($query);
					$data = array();
					if ($result->num_rows == 1) {
						$row = $result->fetch_array(MYSQLI_ASSOC);
						
						$_SESSION['usuario'] = $row['usuario'];
						$_SESSION['id'] = $row['id'];
						$_SESSION['tipo'] = $row['tipo'];
						
						$data['usuario'] = $row['usuario'];
						$data['id'] = $row['id'];
						$data['tipo'] = $row['tipo'];
						//print_r($_SESSION);
					} else {
						$data['error'] =  "Usuario o contraseña incorrectos";
					}
					
					$data = json_encode($data);
					echo $data;
					break;
					
				case "cambiarClave":
					
					$claveActual = $mysqli->real_escape_string($_REQUEST['claveactual']);
					$claveNueva = $mysqli->real_escape_string($_REQUEST['clavenueva']);
					$claveNueva2 = $mysqli->real_escape_string($_REQUEST['clavenueva2']);
					$id = $_SESSION['id'];
					$data = array();
					
					if ($claveNueva != $claveNueva2) {
						$data['error'] = "Las claves ingresadas no coinciden";
					} else {
					
						$query = "SELECT id, tipo, vendedor, usuario
									FROM usuarios
									WHERE id = {$id}
										AND clave = MD5('{$claveActual}')
										AND en_uso = 1;";
						$result = $mysqli->query($query);
						$data = array();
						if ($result->num_rows != 1) {
							
							$data['error'] = "La contraseña actual no coincide";
							
						} else {
						
						
							$query = "UPDATE usuarios
										SET clave = MD5('{$claveNueva}')
										WHERE id = {$id};";
							$mysqli->query($query);
							echo $mysqli->error;
							if (!$mysqli->error) {
								$data['error'] = "Se ha cambiado la contraseña";
							} else {
								$data['error'] = "Error inesperado";
							}
						}
					}
					
					$data = json_encode($data);
					echo $data;
					
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
							$selected = '';
							$cuenta = count($variaciones[$tipo]);
							if ($cuenta == 1) {
								
								$selected = 'selected';
							}
							echo "<option value='{$id}' {$selected}>{$nombre}</option>";
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
								(variaciones, articulo, numero, cantidad, color_tapizado, color_red, color_casco, descuento_articulo) VALUES
								('{$variaciones}', '{$informacion['mecanismo']}', '{$informacion['numero']}', 
									'{$informacion['cantidad']}', {$informacion['color-tapizado']}, 
									{$informacion['color-red']}, {$informacion['color-casco']}, '{$informacion['descuento_articulo']}')";
					
					$mysqli->query($query);
					//echo $query;
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
						echo "<td class='articulos cantidad'>{$detalles['descuento_articulo']} %</td>";
						echo "<td class='articulos precio importe'>$ {$precio}</td>";
						if ($detalles['emitido'] == 0) {
							echo "<td class='articulos'><button type='button' class='botonEliminar' data-id='{$detalles['id']}'>X</button></td>";
						}
						echo "</tr>";
						
					}
					
					//$numero = $_REQUEST['numero'];
					$query = "SELECT SUM(p.precio_a_la_emision) AS subtotal,
								dp.embalaje, dp.descuento, dp.iva
							FROM datos_presupuesto AS dp
							LEFT JOIN presupuestos AS p
								ON p.numero = dp.numero
							WHERE dp.numero = {$numero}
							GROUP BY dp.numero";
					$result = $mysqli->query($query);
					
					$row = $result->fetch_array();
					
					$subtotal = round($row['subtotal'], 2);
					echo "<tr>";
					echo "<td colspan='2' class='subtotales blanco'></td>";
					echo "<td colspan='2' class='subtotales titulo'>Subtotal</td>";
					echo "<td class='importe subtotales'> $ {$subtotal}</td>";
					echo "</tr>";
					$embalaje = round($row['subtotal'] * $row['embalaje'] / 100, 2);
					echo "<tr>";
					echo "<td colspan='2' class='subtotales blanco'></td>";
					echo "<td colspan='2' class='subtotales titulo'>Embalaje {$row['embalaje']} %</td>";
					
					echo "<td class='importe subtotales'> $ {$embalaje}</td>";
					echo "</tr>";
					echo "<tr>";
					$descuento = round((-1) * $row['subtotal']* $row['descuento'] / 100, 2);
					echo "<td colspan='2' class='subtotales blanco'></td>";
					echo "<td colspan='2' class='subtotales titulo'>Descuento {$row['descuento']} %</td>";
					echo "<td class='importe subtotales'> $ {$descuento}</td>";
					$subtotal = $subtotal + $embalaje + $descuento;
					echo "</tr>";
					echo "<tr>";
					echo "<td colspan='2' class='subtotales blanco'></td>";
					echo "<td colspan='2' class='subtotales titulo'>Subtotal</td>";
					echo "<td class='importe subtotales'> $ {$subtotal}</td>";
					$iva =round($subtotal * $row['iva'] / 100, 2);
					echo "</tr>";
					echo "<tr>";
					echo "<td colspan='2' class='subtotales blanco'></td>";
					echo "<td colspan='2' class='subtotales titulo'>IVA {$row['iva']} %</td>";
					echo "<td class='importe subtotales'> $ {$iva}</td>";
					$total = $subtotal + $iva;
					echo "</tr>";
					echo "<tr>";
					echo "<td colspan='2' class='subtotales blanco'></td>";
					echo "<td colspan='2' class='subtotales titulo'>Total</td>";
					echo "<td class='importe subtotales'> $ {$total}</td>";
					echo "</tr>";
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
					$query = "UPDATE datos_presupuesto SET
									emitido = 1,
									fecha_emision = CURRENT_TIMESTAMP
								WHERE numero = {$numero}";
					$mysqli->query($query);
					echo $mysqli->error;
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
					
					$campoFiltrado = 'nombre';
					if (in_array($maestro, ['variaciones', 'colores', 'modelos'])) {
						$campoFiltrado = "CONCAT(IFNULL(tipo, ''), IFNULL(nombre, ''))";
					}
					if ($maestro == 'usuarios') {
						$campoFiltrado = "CONCAT(IFNULL(tipo, ''), IFNULL(nombre, ''), IFNULL(usuario, ''))";
					}
					$query = "SELECT *
								FROM {$maestro}
								WHERE en_uso >= {$en_uso}
									AND {$campoFiltrado} LIKE '%{$filtro}%'
								ORDER BY nombre, id";
					$result = $mysqli->query($query);
					//echo $query;
					//echo $mysqli->error;
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
					$excluir = ['id', 'en_uso', 'clave'];
					foreach ($campos as $id => $detalles) {
						foreach ($detalles as $key => $value) {
							if (!in_array($key, $excluir)) {
								echo "<th class='{$maestro} maestro datos {$key}'>" .ucfirst($key) . "</th>";
							}
						}
						break;
					}
					echo "<th class='{$maestro} maestro datos eliminar'>Eliminar</th>";
					echo "</tr></thead><tbody>";
					
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
					
				case "actualizarTablaPresupuestos":
					echo "<table>
						<tr>
							<th class='presupuestos angosto'>Número</th>";
						if ($_SESSION['tipo'] != 'vendedor') { 
							echo "<th class='presupuestos ancho'>Vendedor</th>";
						}
						echo "<th class='presupuestos ancho'>Cliente</th>
							<th class='presupuestos angosto'>Cantidad de artículos</th>
							<th class='presupuestos angosto'>Importe emitido</th>
							<th class='presupuestos fecha'>Fecha de emisión</th>
							<th class='presupuestos angosto'>Emitido</th>
						</tr>";
						
						$fechaDesde = $mysqli->real_escape_string($_REQUEST['fechaDesde']);
						$fechaHasta = $mysqli->real_escape_string($_REQUEST['fechaHasta']);
						$filtro = $mysqli->real_escape_string($_REQUEST['filtro']);
						
						/*$fechaDesde = DateTime::createFromFormat('d/m/Y', $fechaDesde);
						$fechaHasta = DateTime::createFromFormat('d/m/Y', $fechaHasta);
						$fechaDesde = date_format($fechaDesde,"Y/m/d");
						$fechaHasta = date_format($fechaHasta,"Y/m/d");*/
						
						$where = ' WHERE dp.emitido = 1 ';
						if ($_SESSION['tipo'] == 'vendedor') {
							$query = "SELECT vendedor
										FROM usuarios
										WHERE id = {$_SESSION['id']}";
							$result = $mysqli->query($query);
							$vendedor = $result->fetch_array()['vendedor'];
							$where = " WHERE dp.vendedor = {$vendedor} ";
						}
						
						if ($fechaDesde != '') {
							$where .= " AND dp.fecha_emision >= '{$fechaDesde}' ";
						}
						if ($fechaHasta != '') {
							$where .= " AND dp.fecha_emision <= '{$fechaHasta}' ";
						}
						
						if ($filtro != '') {
							if ($_SESSION['tipo'] != 'vendedor') {
								$where .= " AND CONCAT(v.nombre, c.nombre) LIKE '%{$filtro}%' ";
							} else {
								$where .= " AND c.nombre LIKE '%{$filtro}%' ";
							}
						}
						
						
						$query = "SELECT dp.numero, v.nombre AS vendedor, c.nombre AS cliente,
									COUNT(p.articulo) AS cantidad_articulos, 
									SUM(p.precio_a_la_emision) AS precio_total,
									dp.fecha_emision, IF(dp.emitido = 1, 'Sí', 'No') AS emitido
								FROM datos_presupuesto AS dp
								LEFT JOIN presupuestos As p
									ON dp.numero = p.numero
								LEFT JOIN vendedores AS v
									ON v.id = dp.vendedor
								LEFT JOIN clientes AS c
									ON c.id = dp.cliente
									{$where}
								GROUP BY dp.numero
								ORDER BY dp.numero DESC";
						$result = $mysqli->query($query);
						//print_r($_SESSION);
						/*echo $query;
						echo '<br>';
						echo $mysqli->error;*/
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							echo "<tr>
									<td class='presupuestos cantidad'><a href='presupuesto.php?num={$row['numero']}' class='jquibutton'>{$row['numero']}</a></td>";
							if ($_SESSION['tipo'] != 'vendedor') { 
								echo "<td class='presupuestos'>{$row['vendedor']}</td>";
							}
							echo "<td class='presupuestos'>{$row['cliente']}</td>
									<td class='presupuestos cantidad'>{$row['cantidad_articulos']}</td>
									<td class='presupuestos cantidad'>{$row['precio_total']}</td>
									<td class='presupuestos'>{$row['fecha_emision']}</td>
									<td class='presupuestos cantidad'>";
								if ($row['emitido'] != 'No') {
									echo "<a href='presupuestoPDF.php?num={$row['numero']}' target='_blank' class='jquibutton'>PDF</a>";
								}
								echo "</td>
								</tr>";
						}
					
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
										OR localidad LIKE '%{$filtro}%'
										OR provincia LIKE '%{$filtro}%')";
							}
							$query = "SELECT *
								FROM {$tabla}
								WHERE en_uso = {$campos['en_uso']}
									{$where}";
							
							//echo $query;
							//echo $mysqli->error;							
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
										data-modelo='{$modelo}' {$checked} name='mecanismo' class='mecanismos' style='width: 10px;'/>";
								echo "<label for='mecanismo' class='checkbox' style='width: 200px;'>{$row['nombre']}</label>";
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
											data-modeloconmecanismo='{$modeloConMecanismo}' style='width: 10px;'/>";
									echo "<label for='mecanismo' class='checkbox' style='width: 200px;'>{$row['nombre']}</label>";
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
					
				case "actualizarOptionsVendedor":
					$tipo = $mysqli->real_escape_string($_REQUEST['tipo']);
					
					echo "<option value=''>Seleccione vendedor...</option>";
					if ($tipo == 'vendedor') {
						$query = "SELECT id, nombre
									FROM vendedores
									WHERE en_uso = 1";
						$result = $mysqli->query($query);
						while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
							echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
						}
					}	
					break;
				
				case "actualizarNombreVendedor":
					$vendedor = $_REQUEST['vendedor'];
					
					if ($vendedor != '') {
						$query = "SELECT nombre
									FROM vendedores
									WHERE id = {$vendedor}";
						$result = $mysqli->query($query);
						echo $result->fetch_array()['nombre'];
					} else {
						echo "";
					}
					break;
					
				case "agregarUsuario":
					$tipo = $mysqli->real_escape_string($_REQUEST['tipo']);
					$usuario = $mysqli->real_escape_string($_REQUEST['usuario']);
					$nombre = $mysqli->real_escape_string($_REQUEST['nombre']);
					$id = $_REQUEST['id'];
					$vendedor = $_REQUEST['vendedor'];
					
					if ($id == 'nuevo') {
						$query = "INSERT INTO usuarios
									SET tipo = '{$tipo}',
										usuario = '{$usuario}',
										clave = MD5('{$usuario}'),
										nombre = '{$nombre}',
										vendedor = '{$vendedor}';";
						$mysqli->query($query);
					} else {
						$query = "UPDATE usuarios
									SET tipo = '{$tipo}', 
									usuario = '{$usuario}',
										nombre = '{$nombre}',
										vendedor = '{$vendedor}',
										en_uso = 1
										
									WHERE id = {$id}";
						$mysqli->query($query);
					}
					break;
					
				case "editarUsuario":
					$id = $_REQUEST['id'];
					$query = "SELECT id, tipo, usuario, nombre, vendedor
								FROM usuarios
								WHERE id = {$id}";
					$result = $mysqli->query($query);
					$usuario = $result->fetch_array();
					
					$usuario = json_encode($usuario);
					echo $usuario;
					
					break;
				
				case "optionsDatosPresupuesto":
					$campo = $mysqli->real_escape_string($_REQUEST['campo']);
					$vendedor = $_REQUEST['vendedor'];
					$cambioCliente = $_REQUEST['cambioCliente'];
					$numero = $_REQUEST['numero'];
					
					$query = "SELECT cliente, vendedor, direccion_entrega,
								iva, tipo_factura, descuento, embalaje,
								observaciones, condicion, emitido
							FROM datos_presupuesto
							WHERE numero = {$numero}";
					//echo $query;		
					$result = $mysqli->query($query);
					$datosPresupuesto = $result->fetch_array(MYSQLI_ASSOC);
					$cliente = $datosPresupuesto['cliente'];
					$emitido = $datosPresupuesto['emitido'];
					$cambiar = false;
					if ($cambioCliente and $cambioCliente != $cliente) {
						$cliente = $cambioCliente;
						$cambiar = true;
					}
					
					switch ($campo) {
						case "clientes":
							echo "<label class='presupuesto-nuevo' for='cliente'>Cliente: </label>";
							if (!$emitido) {
								echo "<select class='presupuesto clientes' name='clientes'>";
								echo "<option value=''>Seleccione cliente</option>";
								$query = "SELECT c.id, c.nombre
									FROM clientes AS c
									LEFT JOIN clientes_vendedores AS v
										ON v.cliente = c.id
									WHERE c.en_uso = 1
										AND v.en_uso = 1 
										AND v.vendedor = {$vendedor}";
								echo $query;
								$result = $mysqli->query($query);
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									$selected = '';
									if ($row['id'] == $datosPresupuesto['cliente']) {
										$selected = 'selected';
									}
									echo "<option value='{$row['id']}' {$selected}>{$row['nombre']}</option>";
								}
								echo "</select>";
							} else {
								
								$query = "SELECT nombre
											FROM clientes
											WHERE id = {$datosPresupuesto['cliente']}";
								$result = $mysqli->query($query);
								$datoEmitido = $result->fetch_array()['nombre'];
								echo "<span class='emitido'>{$datoEmitido}</span>";
							}
							break;
						
						case "datos_presupuesto":
							//GUARDAR EL CAMBIO DE CLIENTE
							if ($cambiar) {
								$query = "REPLACE INTO datos_presupuesto
											SET CLIENTE = {$cliente},
												vendedor = {$vendedor},
												numero = {$numero}";
								$mysqli->query($query);
							}									
							//TRAER LOS OPTIONS DE LOS DATOS
							
							echo "<br>";
							echo "<label class='presupuesto-nuevo' for='direccionEntrega'>Dirección de entrega: </label>";
							if (!$emitido) {
								echo "<select class='presupuesto datos-presupuesto' name='direccionEntrega' data-campo='direccion_entrega'>";
								$query = "SELECT id, direccion, es_default
											FROM direcciones_entrega
											WHERE en_uso = 1
												AND cliente = {$cliente}";
								//echo $query;
								print_r($datosPresupuesto);
								$result = $mysqli->query($query);
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									$selected = '';
									if ($datosPresupuesto['direccion_entrega'] == '') {
										if ($row['es_default'] == 1) {
											$selected = 'selected';
										}
									} else {
										if ($row['id'] == $datosPresupuesto['direccion_entrega']) {
											$selected = 'selected';
										}
									}
									echo "<option value='{$row['id']}' {$selected}>{$row['direccion']}</option>";
								}
								echo "</select>";
							} else {
								$datoEmitido = '';
								if ($datosPresupuesto['direccion_entrega'] != '') {
									$query = "SELECT direccion, codigo_postal, localidad, provincia
												FROM direcciones_entrega
												WHERE id = {$datosPresupuesto['direccion_entrega']}";
												
									$result = $mysqli->query($query);
									//echo $query;
									//echo $mysqli->error;
									$row = $result->fetch_array();
									
									$datoEmitido = $row['direccion'] . "<br>" .  $row['codigo_postal'] . $row['localidad'] ."<br>" . $row['provincia'];
								} 
								echo "<span class='emitido'>{$datoEmitido}</span>";
							}

							
							$query = "SELECT iva, tipo_factura
										FROM clientes
										WHERE id = {$cliente}";
							$result = $mysqli->query($query);
							$row = $result->fetch_array(MYSQLI_ASSOC);
							$iva = $row['iva'];
							$tipoFactura = $row['tipo_factura'];
							//echo "<br>";
							echo "<label class='presupuesto-nuevo' for='iva'>IVA: </label>";
							if (!$emitido) {
								echo "<select class='presupuesto datos-presupuesto' name='iva' data-campo='iva'>";
								foreach ([21, 10.5, 0] as $tipoIva) {
									$selected = '';
									if ($datosPresupuesto['iva'] == '') {
										if ($iva == $tipoIva) {
											$selected = 'selected';
										}
									} else {
										if ($tipoIva== $datosPresupuesto['iva']) {
											$selected = 'selected';
										}
									}
										
									echo "<option value='{$tipoIva}' {$selected}>{$tipoIva} %</option>";
								}
								echo "</select>";
							} else {
								$datoEmitido = $datosPresupuesto['iva'];
									
								echo "<span class='emitido'>{$datoEmitido}%</span>";
							}
								
							echo "<label class='presupuesto-nuevo datos-presupuesto' for='tipoFactura'>Tipo de factura: </label>";
							if (!$emitido) {
							echo "<select class='presupuesto datos-presupuesto' name='tipoFactura' data-campo='tipo_factura'>";
								foreach (['A', 'B', 'C', 'Otro'] as $factura) {
									$selected = '';
									
									if ($datosPresupuesto['tipo_factura'] == '') {
										if ($tipoFactura == $factura) {
											$selected = 'selected';
										}
									} else {
										if ($tipoFactura == $datosPresupuesto['tipo_factura']) {
											$selected = 'selected';
										}
									}
								echo "<option value='{$factura}' {$selected}>{$factura}</option>";
								}
								echo "</select>";
							} else {
								$datoEmitido = $datosPresupuesto['tipo_factura'];
									
								echo "<span class='emitido'>{$datoEmitido}</span>";
							}
							
							echo "<br>";
							echo "<label class='presupuesto-nuevo ' for='embalaje'>Embalaje: </label>";
							if (!$emitido) {
							echo "<select class='presupuesto datos-presupuesto' name='embalaje' data-campo='embalaje'>";
								foreach (['0', '5', '8'] as $valor) {
									$selected = "";
									if ($valor == $datosPresupuesto['embalaje']) {
										$selected = 'selected';
									}
									
									echo "<option value='{$valor}' {$selected}>{$valor}%</option>";
								}
								echo "</select>";
							} else {
								$datoEmitido = $datosPresupuesto['embalaje'];
									
								echo "<span class='emitido'>{$datoEmitido}%</span>";
							}
							
							echo "<label class='presupuesto-nuevo' for='descuento'>Descuento: </label>";
							if (!$emitido) {
								echo "<input type='number' class='presupuesto datos-presupuesto' name='descuento' 
									data-campo='descuento' min='0' max='100' value='{$datosPresupuesto['descuento']}'>%";
							} else {
								$datoEmitido = $datosPresupuesto['descuento'];
									
								echo "<span class='emitido'>{$datoEmitido}%</span>";
							}
							
							//echo "<br>";
							echo "<label class='presupuesto-nuevo' for='condicion'>Condición venta: </label>";
							if (!$emitido) {
								echo "<select class='presupuesto datos-presupuesto' name='condicion' data-campo='condicion'>";
								foreach (['Contado', 'Seña 30% y saldo contraentrega.', 'Seña 50% y saldo contraentrega.', 'Seña 70% y saldo contraentrega.', 'Otro. (Aclarar en observaciones)'] as $valor) {
									$selected = "";
									if ($valor == $datosPresupuesto['condicion']) {
										$selected = 'selected';
									}								
									echo "<option value='{$valor}' {$selected} >{$valor}</option>";
								}
								echo "</select>";
							} else {
								$datoEmitido = $datosPresupuesto['condicion'];
									
								echo "<span class='emitido'>{$datoEmitido}</span>";
							}
							
							echo "<br>";
							echo "<label class='presupuesto-nuevo' for='observaciones'>Observaciones: </label>";
							if (!$emitido) {
								echo "<textarea class='presupuesto-nuevo datos-presupuesto' name='observaciones' data-campo='observaciones'>{$datosPresupuesto['observaciones']}</textarea>";
							} else {
								$datoEmitido = $datosPresupuesto['observaciones'];
									
								echo "<span class='emitido'>{$datoEmitido}</span>";
							}
							break;
						
							
							
						
					}
					break;
					
				case "actualizarDatosPresupuesto":
					$campo = $mysqli->real_escape_string($_REQUEST['campo']);
					$valor = $mysqli->real_escape_string($_REQUEST['valor']);
					$numero = $_REQUEST['numero'];
					
					$query = "UPDATE datos_presupuesto SET
								{$campo} = '{$valor}'
								WHERE numero = {$numero}";
					$mysqli->query($query);
					echo $mysqli->error;
					echo $query;
					break;
					
				case "actualizarTotalesPresupuesto":
					$numero = $_REQUEST['numero'];
					$query = "SELECT SUM(p.precio_a_la_emision) AS subtotal,
								dp.embalaje, dp.descuento, dp.iva
							FROM datos_presupuesto AS dp
							LEFT JOIN presupuestos AS p
								ON p.numero = dp.numero
							WHERE dp.numero = {$numero}
							GROUP BY dp.numero";
					$result = $mysqli->query($query);
					
					$row = $result->fetch_array();
					
					$subtotal = round($row['subtotal'], 2);
					echo "<label class='subtotal' for=''>Subtotal</label>";
					echo "<span class='totales subtotal'> $ {$subtotal}</span><br>";
					$embalaje = round($row['subtotal'] * $row['embalaje'] / 100, 2);
					echo "<label class='subtotal' for=''>Embalaje {$row['embalaje']} %</label>";
					echo "<span class='totales embalaje'> $ {$embalaje} </span><br>";
					$descuento = round((-1) * $row['subtotal']* $row['descuento'] / 100, 2);
					echo "<label class='subtotal' for=''>Descuento {$row['descuento']} %</label>";
					echo "<span class='totales descuento'> $ {$descuento}</span><br>";
					$subtotal = $subtotal + $embalaje + $descuento;
					echo "<label class='subtotal' for=''>Subtotal</label>";
					echo "<span class='totales subtotal'> $ {$subtotal}</span><br>";
					$iva =round($subtotal * $row['iva'] / 100, 2);
					echo "<label class='subtotal' for=''>IVA {$row['iva']} %</label>";
					echo "<span class='totales iva'> $ {$iva}</span><br>";
					$total = $subtotal + $iva;
					echo "<label class='subtotal' for=''>Total</label>";
					echo "<span class='totales total'> $ {$total}</span><br>";
					break;
					
				default:
					echo "No se realizó la búsqueda";
					break;
			}
		$mysqli->close();
	}
	
	

?>