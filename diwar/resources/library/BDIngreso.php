<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
<?php
	$usuario = $_REQUEST['usuario'];
	$clave = $_REQUEST['clave'];
	
	$mysqli = connection($config, 'db1');
	
	$query = "SELECT id, tipo, vendedor, usuario
				FROM usuarios
				WHERE usuario = '{$usuario}'
					AND clave = MD5('{$clave}')
					AND en_uso = 1;";
	$result = $mysqli->query($query);
	if ($result->num_rows == 1) {
		$row = $result->fetch_array(MYSQLI_ASSOC);
		session_start();
		$_SESSION['usuario'] = $row['usuario'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['tipo'] = $row['tipo'];
		print_r($_SESSION);
	} else {
		echo "Usuario o contraseña incorrectos";
	}
	
	
	
?>