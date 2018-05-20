<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/header.php'; ?>
		<h2>PRESUPUESTOS</h2>
		<a href="presupuesto.php?num=nuevo">NUEVO</a>
		<div class="presupuestos">
		<table>
			<tr>
				<th class='presupuestos'>numero</th>
				<th class='presupuestos'>vendedor</th>
				<th class='presupuestos'>cliente</th>
				<th class='presupuestos'>Cantidad de artículos</th>
				<th class='presupuestos'>Importe emitido</th>
				<th class='presupuestos'>Fecha de emisión</th>
				<th class='presupuestos'>Emitido</th>
			</tr>
		<?php
			$mysqli = connection($config, 'db1');
			$query = "SELECT p.numero, v.nombre AS vendedor, c.nombre AS cliente,
						COUNT(p.articulo) AS cantidad_articulos, 
						SUM(p.precio_a_la_emision) AS precio_total,
						p.fecha_emision, IF(p.emitido = 1, 'Sí', 'No') AS emitido
					FROM presupuestos As p
					LEFT JOIN vendedores AS v
						ON v.id = p.vendedor
					LEFT JOIN clientes AS c
						ON c.id = p.cliente
					GROUP BY numero";
			$result = $mysqli->query($query);
			/*echo $query;
			echo '<br>';
			echo $mysqli->error;*/
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr>
						<td class='presupuestos cantidad'><a href='presupuesto.php?num={$row['numero']}'>{$row['numero']}</a></td>
						<td class='presupuestos'>{$row['vendedor']}</td>
						<td class='presupuestos'>{$row['cliente']}</td>
						<td class='presupuestos cantidad'>{$row['cantidad_articulos']}</td>
						<td class='presupuestos cantidad'>{$row['precio_total']}</td>
						<td class='presupuestos'>{$row['fecha_emision']}</td>
						<td class='presupuestos cantidad'>{$row['emitido']}</td>
					</tr>";
			}
			
		
			$mysqli->close();
		?>
		
		
		</table>
		<div>
<?php require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/diwar/resources/templates/footer.php'; ?>	