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
		
		$('button.limpiar').click(function() {
			$('select.maestro').change();
		});
		
		
	});
	
	$('form.filtros').submit(function(event) {
		event.preventDefault();
	});
}
