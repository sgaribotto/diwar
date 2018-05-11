<?php
	
	header('Content-Type: text/html; charset=utf-8');
//Consultas vía AJAX
	//Autoload de la clase.
	
	//print_r($_SESSION);
	
	if (isset($_GET['act'])) {
		
			switch($_GET['act']) {
				
				case "errorLogging":
					$errorLog = fopen('errorLog.txt', 'a+');
					
					$error = $_GET['error'];
					$date = date('Y - m - d');
					$sesion = json_encode($_SESSION);
					
					$log = $date . "\t" . $error . "\t" . $sesion . "\n";
					
					fwrite($errorLog, $log);
					fclose($errorLog);
					break;
				
				default:
					echo "No se realizó la búsqueda";
					
			}
		
	}
	
	

?>