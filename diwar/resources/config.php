<?php //phpinfo(); ?>
<?php
 
	/*
	  The important thing to realize is that the config file should be included in every
		page of your project, or at least any page you want access to these settings.
		This allows you to confidently use these settings throughout a project because
		if something changes such as your database credentials, or a path to a specific resource,
		you'll only need to update it here.
	*/
	 
	$config = array(
		"db" => array(
			"db1" => array(
				"dbname" => "diwar",
				"username" => "diwar",
				"password" => "diwar",
				"host" => "localhost"
			),
			"db2" => array(
				"dbname" => "",
				"username" => "",
				"password" => "",
				"host" => "localhost"
			)
		),
		"urls" => array(
			"baseUrl" => "http://example.com"
		),
		"paths" => array(
			"resources" => "/path/to/resources",
			"images" => array(
				"content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
				"layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
			)
		)
	);
	 
	/*
		I will usually place the following in a bootstrap file or some type of environment
		setup file (code that is run at the start of every page request), but they work 
		just as well in your config file if it's in php (some alternatives to php are xml or ini files).
	*/
	 
	/*
		Creating constants for heavily used paths makes things a lot easier.
		ex. require_once(LIBRARY_PATH . "Paginator.php")
	*/
	defined("LIBRARY_PATH")
		or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
		 
	defined("TEMPLATES_PATH")
		or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
	 
	/*
		Error reporting.
	*/
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	 
	print_r($config);
	function connection($db) {
		$mysqli = new mysqli($config[$db]['host'], $config[$db]['username'], $config[$db]['password'], $config[$db]['dbname']);
		if ($mysqli->connect_errno) {
			// La conexión falló. ¿Que vamos a hacer? 
			// Se podría contactar con uno mismo (¿email?), registrar el error, mostrar una bonita página, etc.
			// No se debe revelar información delicada

			// Probemos esto:
			echo "Lo sentimos, este sitio web está experimentando problemas.";

			// Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
			// de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
			echo "Error: Fallo al conectarse a MySQL debido a: \n";
			echo "Errno: " . $mysqli->connect_errno . "\n";
			echo "Error: " . $mysqli->connect_error . "\n";
			
			// Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
			exit;
		}
		
		return $mysqli;
	}
?>