<?php require_once $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/library/tcpdf/tcpdf.php'; ?>
<?php 
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

$html = "<style>";

$html .= "
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
		

$html .= "</style>";


$html .= '<table class="presupuesto-nuevo encabezado" width="600" cellpadding="6" cellspacing="0">
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

$query = "SELECT DISTINCT p.id, a.codigo_articulo, p.variaciones, cred.nombre AS cred, 
			ctapiz.nombre AS ctapiz, ccasco.nombre AS ccasco, 
			p.articulo, p.cantidad, p.descuento_articulo, mm.modelo, mm.mecanismo,
			p.emitido
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
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	$articulos[] = $row;
}
//print_r($articulos);
$html .= '<table class="articulos presupuesto" cellpadding="3" cellspacing="0">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th class="articulos" width="70" align="center">Artículo</th>';
$html .= '<th class="articulos" width="370" align="left">Detalle</th>';
$html .= '<th class="articulos" width="70" align="center">Cantidad</th>';
$html .= '<th class="articulos" width="70" align="center">Desc.</th>';
$html .= '<th class="articulos" width="70" align="center">Precio</th>';
//$html .= "<th class='articulos'></th>";
$html .= "</tr>";
$html .= "</thead>";
//$html .= "</table>";
$html .= "<tbody>";

foreach ($articulos as $id => $detalles) {
	$detalle = "";
	$precio = 0;
	
	$query = "SELECT descripcion, precio
				FROM modelos
				WHERE id = {$detalles['modelo']};";
	$result = $mysqli->query($query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$descrip = $row['descripcion'];
	$detalle .= $descrip . ". ";
	$precio += $row['precio'];
	
	
	$query = "SELECT descripcion, precio
				FROM mecanismos
				WHERE id = {$detalles['mecanismo']};";
	
	$result = $mysqli->query($query);
	$row = $result->fetch_array(MYSQLI_ASSOC);
	
	
	$descrip = $row['descripcion'];
	$detalle .= $descrip . ". ";
	$precio += $row['precio'];
	//$detalle .= "TESTTETST";
	//print_r($detalle);
	if ($detalles['variaciones'] != '') {
		$query = "SELECT descripcion, precio
					FROM variaciones
					WHERE id IN ({$detalles['variaciones']});";
		$result = $mysqli->query($query);
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			if ($row['descripcion'] != '') {
				$detalle .= $row['descripcion'] . ". ";
				$precio += $row['precio'];
			}
		}
	}
	
	$precio = $precio * (1 - $detalles['descuento_articulo'] / 100);
	
	
	if ($detalles['ctapiz'] != '') {
		$detalle .= "Tapizado color " . $detalles['ctapiz'] . ". ";
	}
	if ($detalles['cred'] != '') {
		$detalle .= "Red color " . $detalles['cred'] . ". ";
	}
	if ($detalles['ccasco'] != '') {
		$detalle .= "Casco color " . $detalles['ccasco'] . ". ";
	}
				
	
	$html .= '<tr class="presupuesto articulos">';
	$html .= '<td class="articulos" width="70" align="center" valign="middle">' . $detalles["codigo_articulo"] . '</td>';
	$html .= '<td class="articulos" width="370" align="left">' . $detalle . '</td>';
	$html .= '<td class="articulos cantidad" width="70" align="center" valign="middle">' . $detalles["cantidad"] . '</td>';
	$html .= '<td class="articulos cantidad" width="70" align="center" valign="middle">' . $detalles["descuento_articulo"] . '%</td>';
	$html .= '<td class="articulos precio" width="70" align="center" valign="middle">$ ' . $precio . '</td>';
	$html .= '</tr>';
}

//echo $html;




$subtotal = round($datosPresupuesto['subtotal'], 2);
$embalaje = round($datosPresupuesto['subtotal'] * $datosPresupuesto['embalaje'] / 100, 2);
$descuento = round((-1) * $datosPresupuesto['subtotal']* $datosPresupuesto['descuento'] / 100, 2);
$subtotalSinIva = $subtotal + $embalaje + $descuento;
$iva =round($subtotalSinIva * $datosPresupuesto['iva'] / 100, 2);
$total = $subtotalSinIva + $iva;



$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="2" align="right"></td>';
$html .= '<td class="titulo-subtotal subtotales" colspan="2" align="right">Subtotal</td>';
$html .= '<td class="subtotal subtotales" >$ ' . $subtotal . '</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="2" align="right"></td>';
$html .= '<td class="titulo-subtotal subtotales embalaje" colspan="2" align="right" >Embalaje ' . $datosPresupuesto["embalaje"] . '%</td>';
$html .= '<td class="subtotal subtotales embalaje" >$ ' . $embalaje . '</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="2" align="right"></td>';
$html .= '<td class="titulo-subtotal subtotales descuento" colspan="2" align="right">Descuento ' . $datosPresupuesto["descuento"] . '%</td>';
$html .= '<td class="subtotal subtotales embalaje" >$ ' . $descuento . '</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="2" align="right"></td>';
$html .= '<td class="titulo-subtotal subtotales" colspan="2" align="right">Subtotal</td>';
$html .= '<td class="subtotal subtotales" >$ ' . $subtotalSinIva . '</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="2" align="right"></td>';
$html .= '<td class="titulo-subtotal subtotales descuento" colspan="2" align="right">IVA ' . $datosPresupuesto["iva"] . '%</td>';
$html .= '<td class="subtotal subtotales embalaje" >$ ' . $iva . '</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="2" align="right"></td>';
$html .= '<td class="titulo-subtotal subtotales" colspan="2" align="right" >Total</td>';
$html .= '<td class="subtotal subtotales" >$ ' . $total . '</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="blanco" colspan="5" align="right"></td>';
$html .= '</tr>';

if ($datosPresupuesto['condicion'] != 'Otro') {
	$html .= '<tr class="subtotales">';
	$html .= '<td class="condicion inicial" colspan="5" align="left"><b>Condición: </b>' . $datosPresupuesto['condicion'] . '</td>';
	$html .= '</tr>';
}

$observaciones = '';
if ($datosPresupuesto['observaciones'] != '') {
	$observaciones = $datosPresupuesto['observaciones'];
}
	$html .= '<tr class="subtotales">';
	$html .= '<td class="observaciones" colspan="5" align="left"><b>Observaciones:</b>' . $observaciones . '</td>';
	$html .= '</tr>';


$html .= '<tr class="subtotales">';
$html .= '<td class="observaciones" colspan="5" align="left"> - Todos los importes están expresados en Pesos.</td>';
$html .= '</tr>';

$html .= '<tr class="subtotales">';
$html .= '<td class="final observaciones" colspan="5" align="left"> - Validez: 15 días desde la fecha de emisión.</td>';
$html .= '</tr>';




$html .= "</tbody>";
$html .= "</table>";

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
	$pdf->writeHTML($html, true, false, true, false, '');
	
	$pdf->writeHTMLCell('', '', '', '268', $htmlFooter, 0, 0, false, "L", false, false);
	
	$pdf->lastPage();
	
	//ob_end_clean();
	$pdf->Output("Presupuesto nº {$numero}", 'I');
?>