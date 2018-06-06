<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>		

<h2 class="formularioLateral">Cambiar contraseña</h2>
<div id="formulario">
	<fieldset class="formularioLateral">
	
		<form method="post" class="cambiarClave" action="#">
		
			<label for="nombre" class="formularioLateral">Contraseña actual: </label>
			<input class="formularioLateral iconPassword" type="password" name="claveactual" pattern="[A-Za-z0-9]{4,}" 
				placeholder="Contraseña actual" required 
				title="4 o más caracteres alfanuméricos. Puede incluir mayúsculas o minúsculas.">
			<br />
			<label for="nombre" class="formularioLateral">Contraseña nueva: </label>
			<input class="formularioLateral iconPassword" type="password" name="clavenueva" 
				pattern="[A-Za-z0-9]{4,}" placeholder="Contraseña nueva" 
				required title="4 o más caracteres alfanuméricos. Puede incluir mayúsculas o minúsculas.">
			<br />
			<label for="nombre" class="formularioLateral">Repetir contraseña nueva: </label>
			<input class="formularioLateral iconPassword" type="password" name="clavenueva2" 
				pattern="[A-Za-z0-9]{4,}" placeholder="Contraseña nueva" 
				required title="4 o más caracteres alfanuméricos. Puede incluir mayúsculas o minúsculas.">
			<br />
			<button tpye="submit" class="formularioLateral iconContinuar">Continuar</button>
			<br>
			<p class='error'></p>
		</form>
	</fieldset>
</div>
<script>
	$(document).ready(function() {
		
		$("form.cambiarClave").submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			var url = '../../../../resources/library/AJAX.php?act=cambiarClave';
			
			$.post(url, formValues, function(data) {
				data = JSON.parse(data);
				$('p.error').text(data.error);
				$('input').val('');
			});
		});
	});
</script>			

		
		
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	