function actualizarFormularioMaestro(maestro, id) {
	//var formValues = $('form.filtros').serialize();
	//var library_path = '<?php echo LIBRARY_PATH; ?>';
	var url = "../../../../resources/library/AJAX.php?act=actualizarFormularioMaestro";
	//var numero = $('input.numero').val();
	//console.log(url);
	$('fieldset.maestro').load(url, {'maestro': maestro, 'id': id}, function() {
		
		var url = "../../../../resources/library/AJAX.php?act=actualizarAutocompletar";
		var tipo = 'tipo';
		$.post(url, {"maestro": maestro, "tipo": tipo}, function(data) {
			//console.log('data: ' + data);
			//data = "(" + data + ")";
			//data = eval(data);
			if (data) {
				data = JSON.parse(data);
				console.log(data);
				$('input.tipo').autocomplete({
					source: data
				});
			}
			
			$('button').button();
		});
		
		
		$('button.nuevo.clientes').click(function() {
			//alert('click');
			location.assign('cliente.php?id=nuevo');
		});
		
		$('button.limpiar').click(function() {
			$('select.maestro').change();
		});
		
		
		
		$('input.cuit').change(function() {
			var cuit = $(this).val();
			var url = "../../../../resources/library/AJAX.php?act=chequearCUIT";
			$.post(url, {"cuit": cuit}, function(data) {
				if (data != 'nuevo') {
					alert('El cuit que desea cargar ya existe, será redireccionado al cliente');
					location.assign('../clientes/cliente.php?id=' + data);
				}
			});
		});
		
		
		
		
		
	});
	
	$('form.filtros').submit(function(event) {
		event.preventDefault();
	});
}
