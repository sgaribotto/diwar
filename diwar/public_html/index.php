<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<h1 class='ingreso'>Ingreso presupuestos DIWAR</h1>
<div class="ingreso">
	<fieldset class="ingreso">
		<legend class="ingreso">Ingrese Usuario y Contraseña</legend>
		
		<form method="post" action="../resources/library/BDIngreso.php" class="ingreso">
			<!--<label class="ingreso" for="usuario">Usuario</label>-->
			<input class="ingreso iconUser" name="usuario" type="text" placeholder="Usuario" value="" autofocus>
			<br>
			<!--<label class="ingreso" for="password">Contraseña</label>-->
			<input class="ingreso iconPassword" name="clave" type="password" placeholder="Contraseña" value="">
			<br>
			<button type="submit" class="ingreso iconIngreso">Ingreso</button>
			<br>
			<p class="error" id="errorIngreso"><?php //if (isset($_GET['Error'])) { echo $_GET['Error']; } ?></p>
			
		</form>
		
	 </fieldset>
</div>
<script>
	$(document).ready(function() {
		
		$("form.ingreso").submit(function(event) {
			event.preventDefault();
			var formValues = $(this).serialize();
			var url = '../resources/library/AJAX.php?act=procesarIngreso';
			
			$.post(url, formValues, function(data) {
				
				data = JSON.parse(data);
				if (data.error) {
					$('p.error').text(data.error);
				} else {
					location.assign('content/' + data.tipo);
				}
			});
					
				
			
			
		});
		
		
				
	});
</script>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>
