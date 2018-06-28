<?php require_once $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/library/tcpdf/tcpdf.php'; ?>
<?php 
	//$mysqli = new mysqli('localhost', 'id5714927_diwar', 'diwar', 'id5714927_diwar');
	$mysqli = new mysqli('localhost', 'diwar', 'diwar', 'diwar');
	
	ini_set('max_execution_time', 60);
	if (isset($_REQUEST['num'])) {
		if ($_REQUEST['num'] != 'nuevo') {
			$numero = $_REQUEST['num'];
			
			$query = "SELECT DISTINCT dp.emitido, 
					c.nombre AS cliente,
					c.id AS id_cliente,
					v.nombre AS vendedor,
					v.id AS id_vendedor,
					v.telefono, v.mail,
					DATE_FORMAT(dp.fecha_emision, '%d/%m/%Y') AS fecha_emision,
					SUM(p.precio_a_la_emision) AS subtotal,
					dp.iva, dp.descuento, dp.embalaje,
					dp.condicion, dp.observaciones,
					CONCAT_WS(' ', de.direccion, de.codigo_postal, de.localidad, '-', de.provincia) AS direccion_entrega,
					CONCAT_WS(' ', c.direccion, c.codigo_postal, c.localidad, '-', c.provincia) AS direccion_fiscal
					
				FROM datos_presupuesto AS dp
				LEFT JOIN presupuestos AS p
					ON p.numero = dp.numero
				LEFT JOIN clientes AS c
					ON c.id = dp.cliente
				LEFT JOIN vendedores AS v
					ON v.id = dp.vendedor
				LEFT JOIN direcciones_entrega AS de
					ON de.id = dp.direccion_entrega
				WHERE dp.numero = {$numero}
				GROUP BY p.numero";
			
			$result = $mysqli->query($query);
			//echo $mysqli->error;
			//echo $query;
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$datosPresupuesto = $row;
			$emitido = $row['emitido'];
			$vendedor = $row['vendedor'];
			$idVendedor = $row['vendedor'];
			$cliente = $row['cliente'];
			$idCliente = $row['id_cliente'];
			$fechaEmision = $row['fecha_emision'];
			$precioEmitido = $row['subtotal'];
			$direccionEntrega = $row['direccion_entrega'];
			$direccionFiscal = $row['direccion_fiscal'];
		}
			
	}

?>
<?php

$htmlStyle = "<style>";

$htmlStyle .= "
		table {
			border-collapse: collapse;
			border-collapse: collapse;
		}
		
		th.articulos {
			background-color: #BBBBBB;
			font-weight: bold;
			font-size: 11pt;
		}
		
		td.cliente {
			font-size: 10pt
		}
		
		td.articulos, td.final {
			border-bottom: 1pt solid black;
			font-size: 9pt;
			vertical-align: middle;
			
		}
		
		td.inicial {
			border-top: 1pt solid black;
			font-size: 9pt;
			vertical-align: middle;
		}
		
		td.condicion, td.observaciones {
			font-size: 9pt;
			vertical-align: middle;
		}
		
		td.titulo-subtotal {
			font-weight: bold;
		}
";
		

$htmlStyle .= "</style>";


$htmlCliente = '<table class="presupuesto-nuevo encabezado" width="600" cellpadding="6" cellspacing="0">
			<tr class="encabezado">
				<td class="presupuesto-nuevo cliente pdf"  width="100" align="right"><b>Cliente: </b></td>
				<td class="fijo presupuesto-emitido cliente" width="300" align="left"> ' . $cliente . '</td>
			</tr>
			<tr class="encabezado">
				<td class="presupuesto-nuevo cliente pdf" width="100" align="right" ><b>Dirección Fiscal: </b></td>
				<td class="fijo presupuesto-emitido cliente" width="300" align="left"> ' . $direccionFiscal . '</td>
			</tr>
			<tr class="encabezado">
				<td class="presupuesto-nuevo cliente pdf" width="100" align="right"><b>Dirección de entrega: </b></td>
				<td class="fijo presupuesto-emitido cliente" width="300" align="left"> ' . $direccionEntrega . '</td>
			</tr>
</table>';

$query = "SELECT DISTINCT p.id, IFNULL(a.codigo_articulo, '') AS codigo_articulo, p.variaciones, cred.nombre AS cred, 
			ctapiz.nombre AS ctapiz, ccasco.nombre AS ccasco, 
			p.articulo, p.cantidad, p.descuento_articulo, mm.modelo, mm.mecanismo, mm.descripcion AS imagen,
			p.emitido, p.precio_a_la_emision AS precio_emitido, p.colores
		FROM presupuestos AS p
		LEFT JOIN articulos AS a
			ON a.modelo_con_mecanismo = p.articulo
		LEFT JOIN modelos_con_mecanismo AS mm
			ON mm.id = p.articulo
		LEFT JOIN colores AS cred
			ON p.color_red = cred.id
		LEFT JOIN colores AS ctapiz
			ON p.color_tapizado = ctapiz.id
			LEFT JOIN colores AS ccasco
			ON p.color_casco = ccasco.id
		WHERE numero = {$numero}";
$result = $mysqli->query($query);


$articulos = array();
$imagenes = array();
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	$articulos[] = $row;
	if ($row['imagen'] != '' and count($imagenes) < 12) {
		$imagenes[] = $row['imagen'];
	}
}

$tableHeader = '<table class="articulos presupuesto" cellpadding="3" cellspacing="0">';
$tableHeader .= '<thead>';
$tableHeader .= '<tr>';
$tableHeader .= '<th class="articulos" width="70" align="center">Artículo</th>';
$tableHeader .= '<th class="articulos" width="370" align="left">Detalle</th>';
$tableHeader .= '<th class="articulos" width="70" align="center">Cantidad</th>';
$tableHeader .= '<th class="articulos" width="70" align="center">Desc.</th>';
$tableHeader .= '<th class="articulos" width="70" align="center">Precio</th>';
//$html .= "<th class='articulos'></th>";
$tableHeader .= "</tr>";
$tableHeader .= "</thead>";
//$html .= "</table>";
$tableHeader .= "<tbody>";

$cantidadArticulos = count($articulos);
$articulosPrimeraPagina = 7;
$articulosPorPagina = 9;

if ($cantidadArticulos > 9) {
	$articulosPrimeraPagina = 9;
}

$cantidadPaginas = 1;
$agregarPaginas = 0;
if ($cantidadArticulos > $articulosPrimeraPagina) {
	$agregarPaginas = ceil(($cantidadArticulos - $articulosPrimeraPagina) / $articulosPorPagina);
}	

$cantidadPaginas += $agregarPaginas;
$html = array();
//foreach ($articulos as $id => $detalles) {
for ($i = 1; $i <= $cantidadPaginas; $i++) {
	if ($i == $cantidadPaginas) {
		$fin = $cantidadArticulos - 1;
	} else {
		$fin = ($articulosPrimeraPagina - 1) + (($i - 1) * $articulosPorPagina);
	}
	if ($i == 1) {
		$inicio = 0;
	} else {
		$inicio = ($articulosPrimeraPagina) + (($i - 2) * $articulosPorPagina);
	}
	
	$html[$i] = "";
	/*echo $inicio;
	echo "<br>";
	echo $fin;*/
	
	for ($j = $inicio; $j <= $fin; $j++) {
		$detalles = $articulos[$j];
	
	
		
		$coloresArticulo = array();
		if ($detalles['colores']) {
			$query = "SELECT tipo, nombre AS color
						FROM colores
						WHERE id IN ({$detalles['colores']})";
			$result = $mysqli->query($query);
			//echo $query;
			//echo $mysqli->error;
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$coloresArticulo[$row['tipo']] = $row['color'];
			}
			//print_r($coloresArticulo);
		}
		
		$detalle = "";
		$precio = 0;
		
		$query = "SELECT descripcion, precio
					FROM modelos
					WHERE id = {$detalles['modelo']};";
		$result = $mysqli->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$descrip = $row['descripcion'];
		$detalle .= $descrip . " ";
		$precio += $row['precio'];
		
		
		$query = "SELECT descripcion, precio
					FROM mecanismos
					WHERE id = {$detalles['mecanismo']};";
		
		$result = $mysqli->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$descrip = $row['descripcion'];
		$detalle .= $descrip . " ";
		//$precio += $row['precio'];
		
		$query = "SELECT  precio
					FROM modelos_con_mecanismo
					WHERE modelo = {$detalles['modelo']}
						AND mecanismo = {$detalles['mecanismo']};";
		
		$result = $mysqli->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		//$descrip = $row['descripcion'];
		//$detalle .= $descrip . ". ";
		$precio += $row['precio'];
		
		if ($detalles['variaciones'] != '') {
			$query = "SELECT tipo, descripcion, precio, nombre
						FROM variaciones
						WHERE id IN ({$detalles['variaciones']});";
			$result = $mysqli->query($query);
			
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($row['descripcion'] != '') {
					$detalle .= $row['descripcion'] . " ";
					
					if (isset($coloresArticulo[$row['tipo']])) {
						$detalle .= $coloresArticulo[$row['tipo']] . ". ";
					} else {
						$nombre = strtolower($row['nombre']);
						if (isset($coloresArticulo[$nombre])) {
							$detalle .= $coloresArticulo[$nombre] . ". ";
						}
					}
				}
				$precio += $row['precio'];
					
					
				
			}
		}
		
		$precio = $precio * (1 - $detalles['descuento_articulo'] / 100);
		
		if ($detalles['precio_emitido']) {
			$precio = $detalles['precio_emitido'];
		}
					
		
		$html[$i] .= '<tr class="presupuesto articulos">';
		$html[$i] .= '<td class="articulos" width="70" align="center" valign="middle">' . $detalles["codigo_articulo"] . '</td>';
		$html[$i] .= '<td class="articulos" width="370" align="left">' . $detalle . '</td>';
		$html[$i] .= '<td class="articulos cantidad" width="70" align="center" valign="middle">' . $detalles["cantidad"] . '</td>';
		$html[$i] .= '<td class="articulos cantidad" width="70" align="center" valign="middle">' . $detalles["descuento_articulo"] . '%</td>';
		$html[$i] .= '<td class="articulos precio" width="70" align="center" valign="middle">$ ' . $precio . '</td>';
		$html[$i] .= '</tr>';
	}
}

//echo $html;




$subtotal = round($datosPresupuesto['subtotal'], 2);
$embalaje = round($datosPresupuesto['subtotal'] * $datosPresupuesto['embalaje'] / 100, 2);
$descuento = round((-1) * $datosPresupuesto['subtotal']* $datosPresupuesto['descuento'] / 100, 2);
$subtotalSinIva = $subtotal + $embalaje + $descuento;
$iva =round($subtotalSinIva * $datosPresupuesto['iva'] / 100, 2);
$total = $subtotalSinIva + $iva;



$htmlTotales = '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="2" align="right"></td>';
$htmlTotales .= '<td class="titulo-subtotal subtotales" colspan="2" align="right">Subtotal</td>';
$htmlTotales .= '<td class="subtotal subtotales" >$ ' . $subtotal . '</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="2" align="right"></td>';
$htmlTotales .= '<td class="titulo-subtotal subtotales embalaje" colspan="2" align="right" >Embalaje ' . $datosPresupuesto["embalaje"] . '%</td>';
$htmlTotales .= '<td class="subtotal subtotales embalaje" >$ ' . $embalaje . '</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="2" align="right"></td>';
$htmlTotales .= '<td class="titulo-subtotal subtotales descuento" colspan="2" align="right">Descuento ' . $datosPresupuesto["descuento"] . '%</td>';
$htmlTotales .= '<td class="subtotal subtotales embalaje" >$ ' . $descuento . '</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="2" align="right"></td>';
$htmlTotales .= '<td class="titulo-subtotal subtotales" colspan="2" align="right">Subtotal</td>';
$htmlTotales .= '<td class="subtotal subtotales" >$ ' . $subtotalSinIva . '</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="2" align="right"></td>';
$htmlTotales .= '<td class="titulo-subtotal subtotales descuento" colspan="2" align="right">IVA ' . $datosPresupuesto["iva"] . '%</td>';
$htmlTotales .= '<td class="subtotal subtotales embalaje" >$ ' . $iva . '</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="2" align="right"></td>';
$htmlTotales .= '<td class="titulo-subtotal subtotales" colspan="2" align="right" >Total</td>';
$htmlTotales .= '<td class="subtotal subtotales" >$ ' . $total . '</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="blanco" colspan="5" align="right"></td>';
$htmlTotales .= '</tr>';

if ($datosPresupuesto['condicion'] != 'Otro') {
	$htmlTotales .= '<tr class="subtotales">';
	$htmlTotales .= '<td class="condicion inicial" colspan="5" align="left"><b>Condición: </b>' . $datosPresupuesto['condicion'] . '</td>';
	$htmlTotales .= '</tr>';
}

$observaciones = '';
if ($datosPresupuesto['observaciones'] != '') {
	$observaciones = $datosPresupuesto['observaciones'];
}
	$htmlTotales .= '<tr class="subtotales">';
	$htmlTotales .= '<td class="observaciones" colspan="5" align="left"><b>Observaciones:</b>' . $observaciones . '</td>';
	$htmlTotales .= '</tr>';


$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="observaciones" colspan="5" align="left"> - Todos los importes están expresados en Pesos.</td>';
$htmlTotales .= '</tr>';

$htmlTotales .= '<tr class="subtotales">';
$htmlTotales .= '<td class="final observaciones" colspan="5" align="left"> - Validez: 15 días desde la fecha de emisión.</td>';
$htmlTotales .= '</tr>';




$htmlCierre = "</tbody>";
$htmlCierre .= "</table>";

$htmlFooter = '<table><tbody>';
$htmlFooter .= '<tr class="subtotales">';
$htmlFooter .= '<td class="condicion inicial" colspan="5" align="left"><b>Ejecutivo de cuenta: </b>' . $datosPresupuesto['vendedor'] . ' ' . 
				$datosPresupuesto['telefono'] . ' ' . $datosPresupuesto['mail'] . '</td>';
$htmlFooter .= '</tr>';


$htmlFooter .= '<tr class="subtotales">';
$htmlFooter .= '<td class="observaciones inicial" colspan="5" align="left"><b>Showroom:</b> Perdriel 4262, Villa Lynch, Buenos Aires</td>';
$htmlFooter .= '</tr>';


$htmlFooter .= '<tr class="subtotales">';
$htmlFooter .= '<td class="observaciones final" colspan="5" align="left"><b>Sitio web: </b>www.diwar.com.ar</td>';
$htmlFooter .= '</tr>';

$htmlFooter .= "</tbody>";
$htmlFooter .= "</table>";



//echo $html;
	

	class MYPDF extends TCPDF {

    //Page header
		/*public function Header() {
			// Logo
			$image_file = '/diwar/public_html/img/layouts/logo-diwar.jpg';
			$this->Image($image_file, 5, 5, 38, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 20);
			// Title
			$this->Cell(0, 15, "Presupuesto Nº ", 0, false, 'R', 0, '', 0, false, 'M', 'M');
			$this->Cell(0, 15, "Fecha: ", 0, false, 'R', 0, '', 0, false, 'M', 'M');
		}*/

		// Page footer
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
			$this->SetFont('helvetica', 'I', 8);
			// Page number
			
			$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
	}


	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('DIWAR');
	$pdf->SetTitle("Presupuesto nº {$numero}");
	$pdf->SetSubject('Presupuesto DIWAR');
	$pdf->SetKeywords('Presupuesto, diwar, sillas');

	// set default header data
	$image_file = 'logo-diwar.jpg';
	$pdf->SetHeaderData($image_file, PDF_HEADER_LOGO_WIDTH, "Presupuesto Nº {$numero}", "Fecha: {$fechaEmision}");
	//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'TESTTEST', 'STRINGSTRING');

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, 10);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	// ---------------------------------------------------------

	// set font
	$pdf->SetFont('times', '', 10);

	// add a page
	$pdf->AddPage();
	
	//$html = 'regulacion de altura,  mecanismo syncrhon que  permite regular la inclinacion del respaldo,   UP-Down en la riñonera para regular  la misma Asiento multilaminado con goma espuma inyectada termoformado';
	//$pdf->writeHTML($htmlStyle, true, false, true, false, '');
	$pdf->writeHTML($htmlStyle . $htmlCliente, true, false, true, false, '');
	
	
	foreach ($html as $pagina => $contenido) {
		
		$imprimir = $htmlStyle . $tableHeader;
		$imprimir .= $contenido;
		
		
		if ($pagina == $cantidadPaginas) {
			$imprimir .= $htmlTotales;
			//$pdf->writeHTML($htmlTotales, true, false, true, false, '');
		}
		//$pdf->writeHTML($htmlCierre, true, false, true, false, '');
		$imprimir .= $htmlCierre;
		
		
		$pdf->writeHTML($imprimir, true, false, true, false, '');
		if ($pagina < $cantidadPaginas) {
			$pdf->AddPage();
		}
	}
		
	
	
	/*$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/5172/miro_perfil.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/5172/miro_perfil.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/5172/miro_perfil.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/5172/miro_perfil.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/5172/miro_perfil.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/4844/producto-300-460x580-1.jpg';
	$imagenes[] = 'http://www.diwar.com.ar/site/assets/files/5172/miro_perfil.jpg';*/
	$x = 15;
	foreach ($imagenes as $imagen) {
		$pdf->Image($imagen, $x, 248, 15, 20, 'JPG', $imagen, '', false, 150, '', false, false, 1, false, false, false);
		$x += 15;
	}
	
	$pdf->writeHTMLCell('', '', '', '268', $htmlFooter, 0, 0, false, "L", false, false);
	
	$pdf->lastPage();
	
	//ob_end_clean();
	$pdf->Output("Presupuesto nº {$numero}", 'I');
?>