<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<?php 
	//print_r($config);
	$mysqli = connection($config, 'db1');
	$mysqli->set_charset("utf8");
	
	$tipoUsuario = $_SESSION['tipo'];
	if (isset($_REQUEST['num'])) {
		if ($_REQUEST['num'] != 'nuevo') {
			$numero = $_REQUEST['num'];
			
			$query = "SELECT DISTINCT dp.emitido, 
					c.nombre AS cliente,
					c.id AS id_cliente,
					v.nombre AS vendedor,
					v.id AS id_vendedor,
					dp.fecha_emision,
					SUM(p.precio_a_la_emision) AS subtotal,
					dp.iva, dp.descuento, dp.embalaje,
					dp.condicion, dp.observaciones
					
				FROM datos_presupuesto AS dp
				LEFT JOIN presupuestos AS p
					ON p.numero = dp.numero
				LEFT JOIN clientes AS c
					ON c.id = dp.cliente
				LEFT JOIN vendedores AS v
					ON v.id = dp.vendedor
				WHERE dp.numero = {$numero}
				GROUP BY p.numero";
			
			$result = $mysqli->query($query);
			//echo $mysqli->error;
			//echo $query;
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$emitido = $row['emitido'];
			$vendedor = $row['vendedor'];
			$idVendedor = $row['id_vendedor'];
			$cliente = $row['cliente'];
			$idCliente = $row['id_cliente'];
			$fechaEmision = $row['fecha_emision'];
			$precioEmitido = $row['subtotal'];
			
		} else {
			$query = "SELECT IFNULL(MAX(numero), 0) + 1 AS numero	
						FROM datos_presupuesto";
			$result = $mysqli->query($query);
			$numero = $result->fetch_array(MYSQLI_ASSOC)['numero'];
			
		}
	} else {
		$query = "SELECT IFNULL(MAX(numero), 0) + 1 AS numero	
						FROM datos_presupuesto";
			$result = $mysqli->query($query);
			$numero = $result->fetch_array(MYSQLI_ASSOC)['numero'];
			
	}
	
	if (!isset($vendedor)) {
		$idUsuario = $_SESSION['id'];
			
		$query = "SELECT v.nombre, v.id
					FROM usuarios AS u
					LEFT JOIN vendedores AS v
					ON v.id = u.vendedor
				WHERE u.id = {$idUsuario}";
		$result = $mysqli->query($query);
		$row = $result->fetch_array();
		$vendedor = $row['nombre'];
		$idVendedor = $row['id'];
		$emitido = false;
	}
	
	
?>


<h2>Presupuesto</h2>
<a href='../presupuestos' class='jquibutton'>Volver al listado de presupuestos</a>
<?php echo "<a href='presupuestoPDF.php?num={$numero}' target='_blank' class='jquibutton'>PDF</a>"; ?>
<div class='presupuesto-nuevo form-container'>
	<form class='presupuesto-nuevo' method='post' acticion='emitirpresupuesto.php'>
		<fieldset class='presupuesto-nuevo'>
			<div class='inline formulario'>
				<label class='presupuesto-nuevo' for='numero'>Número: </label>
				<input type='text' readonly class='presupuesto-nuevo numero' name='numero' value='<?php echo $numero; ?>' />
				<label class='presupuesto-nuevo' for='vendedor'>Vendedor: </label>
				
				<span class='fijo presupuesto-emitido vendedor' data-vendedor='<?php echo $idVendedor; ?>'><?php echo $vendedor; ?></span>
				
				<br />
				
				
				<span class='clientes' data-type='select'></span>
				<?php if ($emitido != 1 and $tipoUsuario == 'vendedor') { ?>
					<button type='button' class='ABMcliente' data-id='nuevo'>Modificar</button>
				<?php } ?>
			
				<span class='datos_presupuesto'></span>
				
				<?php if ($emitido != 1 and $tipoUsuario == 'vendedor') { ?>
				<br>
				<button type='button' class='emitir presupuesto-nuevo'>Emitir presupuesto</button>
				<?php } else { 
					
				}
				?>
			</div>
		</fieldset>
	</form>
</div>
<div id="ABMcliente" class="ui-widget dialog ABMcliente"></div>
			
			<?php if ($emitido != 1 and $tipoUsuario == 'vendedor') { ?>
			<div class='agregar-articulos form-container formulario'>
				<form class='agregar-articulos' method='post' action='#'>
					<fieldset class='agregar-articulos'>
						<label class='presupuesto-nuevo' for='cantidad'>Cantidad: </label>
						<input type='number' class='presupuesto-nuevo cantidad' name='cantidad' value='1' min='1'/>
						<label class='presupuesto-nuevo' for='descuento_articulo'>Descuento del artículo: </label>
						<input type='number' class='presupuesto-nuevo descuento-articulo' name='descuento_articulo' value='0' min='0' max='100'/>%
						<br>
						<label class='agregar-articulo' for='articulo'>Modelo: </label>
						<select class='agregar-articulo modelo' name='modelo' required >
						<option value=''>Seleccionar modelo...</option>
							<?php 
								$mysqli = connection($config, 'db1');
								
								$query = "SELECT id, nombre 
											FROM modelos
											WHERE en_uso = 1
												AND tipo = 'silla'
												ORDER BY nombre";
								$result = $mysqli->query($query);
								
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
								}
								
							?>
						</select>
						<label class='agregar-articulo' for='mecanismo'>Mecanisimo: </label>
						<select class='agregar-articulo mecanismo' name='mecanismo' required >
							<option value=''>Seleccione mecanismo...</option>
						</select>
						<div class="variaciones"></div>
						
					</fieldset>
				</form>
			</div>
			<?php } ?>
			<div class="articulos-cargados"></div>
			<div class="totales"></div>
			
			<script>
				$(document).ready(function() {
					
					var actualizarTabla = function(tabla) {
						//var formValues = $('form.filtros').serialize();
						//var library_path = '<?php echo LIBRARY_PATH; ?>';
						var url = "../../../../resources/library/AJAX.php?act=actualizarTabla-" + tabla;
						var numero = $('input.numero').val();
						//console.log(url);
					$('div.' + tabla).load(url, {'numero': numero, }, function() {
							$('.botonEliminar').click(function() {
								if (confirm('¿Desea Eliminar el artículo?')) {
									var id = $(this).data('id');
									$.post("../../../../resources/library/AJAX.php?act=eliminar-" + tabla, {"id":id, }, function(data) {
										actualizarTabla(tabla);
									});
								}
							});
						});
					} 
					actualizarTabla('articulos-cargados');
					
					var actualizarOptions = function(select, busqueda) {
						//console.log(select);
						if (select != 'color-tapizado') {
							$('div.variaciones').empty();
						}
						
						var url = "../../../../resources/library/AJAX.php?act=options" + select;
						//console.log(url);
						var valor = $('select.' + busqueda).val();
						
						//console.log(valor);
						$('.' + select).load(url, {"valor": valor}, function() {
								
							$('select.tapizado').change(function() {
								
								actualizarOptions('color-tapizado', 'tapizado');
								
							});
						});
						
					}
					
					$('select.modelo').change(function() {
						//alert('change');
						actualizarOptions('mecanismo', 'modelo');
					});
					
					$('select.mecanismo').change(function() {
						//console.log('mecabusca');
						actualizarOptions('variaciones', 'mecanismo');
						
					});
					
										
					$("form.agregar-articulos").submit(function(event) {
						event.preventDefault();
						formValues = $(this).serialize();
						formValues += '&numero=' + $('input.numero').val();
						formValues += '&vendedor=' + $('select.vendedor').val();
						formValues += '&cliente=' +  $('select.cliente').val();
						
						//console.log( formValues);
						var url = "../../../../resources/library/AJAX.php?act=agregarArticuloPresupuesto";
						
						$.post(url, formValues, function(data) {
							//console.log(data);
							//actualizarTabla();
							//$("#cargarDocenteNuevo")[0].reset();
							actualizarTabla('articulos-cargados');
						});
						
					});
					
					$('button.emitir').click(function() {
						var url = "../../../../resources/library/AJAX.php?act=emitirPresupuesto";
						var num = $('input.numero').val();
						$.post(url, {"numero": num}, function(data) {
							//console.log(data);
							//actualizarTabla();
							//$("#cargarDocenteNuevo")[0].reset();
							location.assign('presupuestos.php');
						});
					});
					
					var actualizarOptionsDatosPresupuesto = function(campo) {
						var vendedor = $('span.vendedor').data('vendedor');
						var numero = $('input.numero').val();
						var cliente = $('select.clientes').val() || 0;
						
						if (cliente == 'nuevo' || cliente == '' || cliente == 0) {
							$('button.ABMcliente').text('Agregar');
						} else {
							$('button.ABMcliente').text('Modificar');
						}
						
						
						var url = "../../../../resources/library/AJAX.php?act=optionsDatosPresupuesto";
						$('span.' + campo).load(url, {'campo': campo, 'vendedor': vendedor,'numero': numero, 'cambioCliente': cliente}, function() {
							
							$('select.clientes').change(function() {
								cliente = $(this).val();
								actualizarOptionsDatosPresupuesto('datos_presupuesto');
								if (cliente == 'nuevo' || cliente == '') {
									$('button.ABMcliente').text('Agregar');
								} else {
									$('button.ABMcliente').text('Modificar');
								}
							})
							
							$('select.datos-presupuesto, input.datos-presupuesto, textarea.datos-presupuesto').change(function() {
								//alert('change');
								var valor = $(this).val();
								var campo = $(this).data('campo');
								var num = $('input.numero').val();
								var url = "../../../../resources/library/AJAX.php?act=actualizarDatosPresupuesto";
								$.post(url, {"numero": num, 'valor': valor, 'campo': campo}, function(data) {
									
								});
							});
							
							$('input.datos-presupuesto, textarea.datos-presupuesto').keyup(function() {
								//alert('change');
								var valor = $(this).val();
								var campo = $(this).data('campo');
								var num = $('input.numero').val();
								var url = "../../../../resources/library/AJAX.php?act=actualizarDatosPresupuesto";
								$.post(url, {"numero": num, 'valor': valor, 'campo': campo}, function(data) {
									
								});
							});
							
						});
						
						
						
					};
					
					/*var actualizarTotales = function() {
						var numero = $('input.numero').val();
						var url = "../../../../resources/library/AJAX.php?act=actualizarTotalesPresupuesto";
						$('div.totales').load(url, {"numero": numero}, function() {
								
						});
					}
					actualizarTotales();*/	
					
					
					actualizarOptionsDatosPresupuesto('clientes');
					actualizarOptionsDatosPresupuesto('datos_presupuesto');	
					
					$( "div.dialog" ).dialog({
					  autoOpen: false,
					  height: 1000,
					  width: 700,
					  modal: true,
					  
					  /*buttons: {
						"Create an account": addUser,
						Cancel: function() {
						  dialog.dialog( "close" );
						}
					  },*/
					  close: function() {
						location.reload();
					  }
					});
					
					$('button.ABMcliente').click(function() {
						var id = $('select,clientes').val() || 'nuevo';
						var url = '../clientes/cliente.php?dialog=true&id=' + id;
						
						$('div.ABMcliente').load(url, function() {
							//alert(url);
							$('div.dialog').dialog( "open" );
						});
						
						
					});
					
				});
			</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	