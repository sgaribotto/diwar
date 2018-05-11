<!DOCTYPE html>
<html>
	<head>
		<?php require '../../../../resources/library/scripts.php'; ?>
		<?php require '../../../../resources/config.php'; ?>
		
		<?php 
			
			$mysqli = connection('db1');
			print_r($mysqli);
		?>
	</head>
		<body>

		<h2>PRESUPUESTO NUEVO</h2>
		<div class='presupuesto-nuevo form-container'>
			<form class='presupuesto-nuevo' method='post' acticion='emitirpresupuesto.php'>
				<fieldset class='presupuesto-nuevo'>
					<label class='presupuesto-nuevo' for='numero'>Número</label>
					<input type='text' readonly class='presupuesto-nuevo' name='numero' />
					<label class='presupuesto-nuevo' for='vendedor'>Vendedor</label>
					<select readonly class='presupuesto-nuevo' name='vendedor' />
						<?php //TRAER LAS OPCIONES ?>
					</select>
					<label class='presupuesto-nuevo' for='cliente'>Cliente</label>
					<select readonly class='presupuesto-nuevo' name='cliente' />
						<?php //TRAER LAS OPCIONES ?>
					</select>
					
				</fieldset>
			</form>
		</div>
		
		<div class='agregar-articulos form-container'>
			<form class='agregar-articulos' method='post' acticion='agregararticulos.php'>
				<fieldset class='agregar-articulos'>
					<label class='agregar-articulos' for='articulo'>Artículo</label>
					<select readonly class='agregar-articulo' name='articulo' />
						<?php //TRAER LAS OPCIONES DE ARTICULOS ?>
					</select>
					<label class='agregar-articulo' for='mecanismo'>Mecanisimo</label>
					<select readonly class='agregar-articulo' name='mecanismo' />
						<?php //TRAER LAS OPCIONES DE MECANISMOS PARA ESE ARTICULO ?>
					</select>
					<?php //TRAER LAS OPCIONES DE VARIACIONES PARA EL ARTICULO Y MECANISMOS
							//CON UN SELECT POR TIPO
					?>
					
				</fieldset>
			</form>
		</div>
		
		<script>
			$(document).ready(function() {
				
				var actualizarTabla = function() {
					formValues = $('form.filtros').serialize();
					//console.log(formValues);
					$('#tablaDatos').load("fuentes/AJAX.php?act=tablaDocentes", formValues, function(data) {
						$('.botonEliminar').click(function() {
							if (confirm('¿Desea Eliminar el docente? \n Podrá agregarlo nuevamente solo con el DNI')) {
								var id = $(this).data('id');
								$.post("./fuentes/AJAX.php?act=eliminarDocente", {"id":id, }, function(data) {
									actualizarTabla();
								});
							}
						});
					});
				} 
				actualizarTabla();
				
				$("#cargarDocenteNuevo").submit(function(event) {
					event.preventDefault();
					formValues = $("#cargarDocenteNuevo").serialize();
					
					
					$.post("./fuentes/AJAX.php?act=agregarDocente", formValues, function(data) {
						alert(data);
						actualizarTabla();
						$("#cargarDocenteNuevo")[0].reset();
					});
					
				});
				
				
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
					
				});
				
			});
		</script>
	</body>
</html>