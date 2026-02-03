<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	header("Content-type:application/xls; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=evaluaciones_admision.xls");
	
	$idest = $_REQUEST['idest'];
	//echo $idest;
	
	$query = "SELECT e.n_documento, e.nombres, e.apellidos, g.grado, d.DSA, d.DA, d.DM, d.DB, 
		CASE WHEN e.id < 2724 THEN 'Antiguo' ELSE 'Nuevo' END estado 
        FROM estudiantes e, matricula m, grados g, tbl_desemp_pres d 
        WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND e.n_documento = d.identificacion
        AND m.estado IN ('activo', 'pre_solicitud', 'solicitud') AND d.año >= 2023
        ORDER BY g.id, e.apellidos";
	//echo $query;
	
	$resultado=$mysqli1->query($query);
	$sel = $mysqli1->affected_rows;

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<center>
			<fieldset>
				<legend>Listado de Evaluaciones de Admisión
				</legend>
				<?php
					echo '<label>Total Registros &#9658; '.$sel.'</label>';
				?>
				<table border="1px" class="table" id="tblest">
					<thead>
					<tr>
						<td class="tdcorto"><b>APELLIDOS</b></td>
						<td class="tdlargo"><b>NOMBRES</b></td>
						<td class="tdlargo"><b>IDENTIFICACIÓN</b></td>
						<td class="tdmedia"><b>GRADO</b></td>
						<td class="tdnormal"><b>ESTADO</b></td>
						<td class="tdnormal"><b>DSA</b></td>
						<td class="tdnormal"><b>DA</b></td>
						<td class="tdnormal"><b>DM</b></td>
						<td class="tdnormal"><b>DB</b></td>
					</tr>
					</thead>
					<tbody>
					<?php
					    while($row = $resultado->fetch_assoc()){
					?>
					<tr>
						<td class="tdcorto"><?php echo $row['apellidos'];?></td>
						<td class="tdlargo"><?php echo $row['nombres'];?></td>
						<td class="tdlargo"><?php echo $row['n_documento'];?></td>
						<td class="tdmedia"><?php echo $row['grado'];?></td>
						<td class="tdmediol"><?php echo $row['estado'];?></td>
						<td class="tdmediol"><?php echo $row['DSA'];?></td>
						<td class="tdmediol"><?php echo $row['DA'];?></td>
						<td class="tdmediol"><?php echo $row['DM'];?></td>
						<td class="tdmediol"><?php echo $row['DB'];?></td>
					</tr>
					<?php 
					        $fila++;
					    }
						$resultado->close();
						$mysqli1->close();
					?>
					</tbody>
				</table>
			</fieldset>
		</center>
	</body>
	
</html>