<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<h2>CLIENTES</h2>
<a href="cliente.php?num=nuevo">NUEVO</a>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/filtros.php'; ?>
<div class="listado clientes"></div>
		

<script>
	$(document).ready(function() {
					
		var actualizarTabla = function(tabla, filtro) {
			//var formValues = $('form.filtros').serialize();
			//var library_path = '<?php echo LIBRARY_PATH; ?>';
			var en_uso = 1;
			if ($('input.en_uso').is(':checked')) {
				en_uso = 0;
			}

			var url = "../../../../resources/library/AJAX.php?act=actualizarTabla";
			//var numero = $('input.numero').val();
			//console.log(url);
				$('div.listado').load(url, {'tabla': tabla, 'filtro': filtro, 'en_uso': en_uso}, function() {
				$('button.eliminarElemento').click(function() {
					if (confirm('¿Desea Eliminar el cliente?')) {
						var id = $(this).data('id');
						$.post("../../../../resources/library/AJAX.php?act=eliminarElemento", {"id":id, "tabla": tabla }, function(data) {
							actualizarTabla(tabla, filtro);
						});
					}
				});
			});
		} 
		var filtro = $('input.filtro').val();
		var tabla = 'clientes';
		
		actualizarTabla(tabla, filtro);
		
		$('input.filtro').keyup(function() {
			var filtro = $(this).val();
			var tabla = 'clientes';
			actualizarTabla(tabla, filtro);
		});
		
		$('button.limpiarFiltro').click(function() {
			$('input.filtro').val('');
			$('input.filtro').keyup();
		});
		
		$('input.en_uso').change(function() {
			var filtro = $('input.filtro').val();
			$('input.filtro').keyup();
		});
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	