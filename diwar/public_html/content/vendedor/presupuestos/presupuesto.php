	<!DOCTYPE html>
	<html>
		<head>
			<meta charset="utf-8">
			<link rel="stylesheet" type="text/css" href="../../../css/general.css">
			<style>
				
				label.presupuesto-nuevo, label.agregar-articulo {
					display:inline-block;
					font-weight: bold;
					width: 96px;
					margin: 5px;
					padding: 5px;
				}
				
				input.presupuesto-nuevo {
					width: 32px;
					margin: 5px;
					padding: 5px;
				}
				
				select.presupuesto-nuevo, select.agregar-articulo {
					width: 160px;
					margin: 5px;
					padding: 5px;
				}
				
				table.presupuesto {
					width: 100%;
					border-collapse: collapse;
				}
				
				td.cantidad, th, td.codigo {
					text-align: center;
					width: 8%;
					padding: 2px;
				}
				
				td.detalle {
					text-align: left;
					width: 40%;
					padding: 2px;
				}
				
				tr.articulos td {
				  border-bottom:1pt solid black;
				}
				
				
			</style>
			<?php require '../../../../resources/config.php'; ?>
			<?php require LIBRARY_PATH . '/scripts.php'; ?>
			
			<?php 
				//print_r($config);
				$mysqli = connection($config, 'db1');
				if (isset($_REQUEST['num'])) {
					if ($_REQUEST['num'] != 'nuevo') {
						$numero = $_REQUEST['num'];
					} else {
						$query = "SELECT IFNULL(MAX(numero), 0) + 1 AS numero	
									FROM presupuestos";
						$result = $mysqli->query($query);
						$numero = $result->fetch_array(MYSQLI_ASSOC)['numero'];
					}
				}
				
				
				$query = "SELECT DISTINCT p.emitido, 
								c.nombre AS cliente, 
								v.nombre AS vendedor,
								p.fecha_emision,
								p.precio_a_la_emision
							FROM presupuestos AS p
							LEFT JOIN clientes AS c
								ON c.id = p.cliente
							LEFT JOIN vendedores AS v
								ON v.id = p.vendedor
							WHERE numero = {$numero}";
				$result = $mysqli->query($query);
				$row = $result->fetch_array(MYSQLI_ASSOC);
				$emitido = $row['emitido'];
				$vendedor = $row['vendedor'];
				$cliente = $row['cliente'];
				$fechaEmision = $row['fecha_emision'];
				$precioEmitido = $row['precio_a_la_emision'];
			?>
		</head>
			<div class="header">
			<img src="<?php echo $config['paths']['images']['layout'] . "/diwar-logo.png"; ?>" class='logo' />
		</div>
			<h2>PRESUPUESTO NUEVO</h2>
			<a href='presupuestos.php'>Volver al listado de presupuestos</a>
			<div class='presupuesto-nuevo form-container'>
				<form class='presupuesto-nuevo' method='post' acticion='emitirpresupuesto.php'>
					<fieldset class='presupuesto-nuevo'>
						<label class='presupuesto-nuevo' for='numero'>Número: </label>
						<input type='text' readonly class='presupuesto-nuevo numero' name='numero' value='<?php echo $numero; ?>' />
						<label class='presupuesto-nuevo' for='vendedor'>Vendedor: </label>
						<?php if ($emitido != 1) { ?>
						<select class='presupuesto-nuevo vendedor' name='vendedor' />
							<?php
								
								
								$query = "SELECT id, nombre 
											FROM vendedores
											WHERE en_uso = 1
												
												ORDER BY nombre";
								$result = $mysqli->query($query);
								
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
								}
							?>
						</select>
						<?php } else { ?>
						<span class='fijo presupuesto-emitido'><?php echo $vendedor; ?></span>
						<?php }  ?>
						<label class='presupuesto-nuevo' for='cliente'>Cliente: </label>
						<?php if ($emitido != 1) { ?>
						<select readonly class='presupuesto-nuevo cliente' name='cliente' />
							<?php
								$mysqli = connection($config, 'db1');
								
								$query = "SELECT id, nombre 
											FROM clientes
											WHERE en_uso = 1
												
												ORDER BY nombre";
								$result = $mysqli->query($query);
								
								while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
									echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
								}
							?>
						</select>
						<?php } else { ?>
						<span class='fijo presupuesto-emitido'><?php echo $cliente; ?></span>
						<?php }  ?>
						<?php if ($emitido != 1) { ?>
						<br>
						<button type='button' class='emitir presupuesto-nuevo'>Emitir presupuesto</button>
						<?php } else { ?>
						<span class='fijo presupuesto-emitido'>Fecha emisión: <?php echo $fechaEmision; ?></span>
						<br>
						<span class='fijo presupuesto-emitido'>Precio emisión: <?php echo $precioEmitido; ?></span>
						<?php }   ?>
					</fieldset>
				</form>
			</div>
			
			<?php if ($emitido != 1) { ?>
			<div class='agregar-articulos form-container'>
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
						
						console.log(valor);
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
					
					/*
					$('#dni').keyup(function() {
						dni = $('#dni').val();
						$('#filtro').val(dni);
						$('#filtro').keyup();
						$.post("./fuentes/AJAX.php?act=buscarDNI", {"dni":dni, }, function(data) {
							if (data != "nuevo") {
								datosDocente = data.split(',');
								$('#apellido').val(datosDocente[1]);
								$('#nombre').val(datosDocente[2]);
								$('#fechanacimiento').val(datosDocente[3]);
								$('#fechaingreso').val(datosDocente[4]);
							}
							
						});
						
					});
					
					
					function togglerButtonColor() {
						
						var gris = '#f9f9f9';
						
						if ($('div#formulario').is(':visible')) {
							$('#mostrarFormulario').css('backgroundColor', 'black');
							$('#mostrarFormulario').css('color', gris);
						} else {
							$('#mostrarFormulario').css('backgroundColor', gris);
							$('#mostrarFormulario').css('color', 'black');
						}
						
						if ($('div#filtros').is(':visible')) {
							$('#mostrarFiltros').css('backgroundColor', 'black');
							$('#mostrarFiltros').css('color', gris);
						} else {
							$('#mostrarFiltros').css('backgroundColor', gris);
							$('#mostrarFiltros').css('color', 'black');
						}
					}
					
					
					$('#mostrarFormulario').click(function() {
						$('div #formulario').slideToggle(function() {
							if ($('div#formulario').is(':visible')) {
							$('#mostrarFormulario').css('backgroundColor', 'black');
							$('#mostrarFormulario').css('color', gris);
						} else {
							$('#mostrarFormulario').css('backgroundColor', gris);
							$('#mostrarFormulario').css('color', 'black');
						}
							
						});
						$('div #filtros').slideUp();
						
						var gris = '#f9f9f9';
						$('#mostrarFiltros').css('backgroundColor', gris);
							$('#mostrarFiltros').css('color', 'black');
						
						
					});
					
					$('#mostrarFiltros').click(function() {
						$('div #filtros').slideToggle(function() {
							if ($('div#filtros').is(':visible')) {
								$('#mostrarFiltros').css('backgroundColor', 'black');
								$('#mostrarFiltros').css('color', gris);
							} else {
								$('#mostrarFiltros').css('backgroundColor', gris);
								$('#mostrarFiltros').css('color', 'black');
							}
						});
						$('div #formulario').slideUp();
						
						var gris = '#f9f9f9';
						
						$('#mostrarFormulario').css('backgroundColor', gris);
						$('#mostrarFormulario').css('color', 'black');
						
						
					});
					$('#mostrarFiltros').click();
					
					$('#filtro').on('keyup', function(event) {
						if ($(this).val().length > 1) {
							actualizarTabla();
						}
					});
					
					$('#filtro').focus();
					
					$.ajaxSetup({
						contentType: "application/x-www-form-urlencoded;charset=UTF-8"
					});
					var dialogOptions = {
						autoOpen: false,
						width:1000,
						height: 600,
						modal: true,
						appendTo: "#Botonera",
						close: function() {
							$('#mostrarFormulario').off('click');
							$('#mostrarFormulario').click(function() {
								$('div #formulario').slideToggle();
							
							});
						},
							
					};
					
					$(".datepicker").datepicker({
						changeMonth:true,
						changeYear:true,
						dateFormat:'yy-mm-dd',
						yearRange:'c-80:c',
						
					});*/
					
				});
			</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	