<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<h2>CLIENTES</h2>
<a href="vendedor.php?num=nuevo" class='jquibutton'>NUEVO</a>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/filtros.php'; ?>
<div class="listado vendedores" data-tabla='vendedores'></div>
		

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
					if (confirm('¿Desea Eliminar el vendedor?')) {
						var id = $(this).data('id');
						$.post("../../../../resources/library/AJAX.php?act=eliminarElemento", {"id":id, "tabla": tabla }, function(data) {
							actualizarTabla(tabla, filtro);
						});
					}
					
					
				});
				
				$('.jquibutton, button.eliminar, button.editar, a.editar').button();
				
				$('th.editar, th.tipo, th.precio, th.eliminar, th.codigo_postal').addClass('angosto');
				$('td.editar, td.tipo, td.precio, td.eliminar, td.codigo_postal').addClass('angosto');
			});
		} 
		var filtro = $('input.filtro').val();
		var tabla = $('div.listado').data('tabla');
		
		actualizarTabla(tabla, filtro);
		
		$('input.filtro').keyup(function() {
			var filtro = $(this).val();
			var tabla = $('div.listado').data('tabla');
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