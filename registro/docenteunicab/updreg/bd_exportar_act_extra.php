<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	header("Content-type:application/xls; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=retirados.xls");
	
	$idest = $_REQUEST['idest'];
	//echo $idest;
	
	$query = "SELECT e.nombres, e.apellidos, g.grado, g.id, e.actividad_extra 
        FROM estudiantes e, matricula m, grados g 
        WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
        AND m.estado = 'activo'
        ORDER BY g.id";
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
				<legend>Listado de Estudiantes con Actividades Extra
				</legend>
				<?php
					echo '<label>Total Registros &#9658; '.$sel.'</label>';
				?>
				<table border="1px" class="table" id="tblest">
					<thead>
					<tr>
						<td class="tdlargo"><b>NOMBRES</b></td>
						<td class="tdcorto"><b>APELLIDOS</b></td>
						<td class="tdmedia"><b>GRADO</b></td>
						<td class="tdnormal"><b>ACTIVIDAD EXTRA</b></td>
					</tr>
					</thead>
					<tbody>
					<?php
					    while($row = $resultado->fetch_assoc()){
					?>
					<tr>
						<td class="tdlargo"><?php echo $row['nombres'];?></td>
						<td class="tdcorto"><?php echo $row['apellidos'];?></td>
						<td class="tdmedia"><?php echo $row['grado'];?></td>
						<td class="tdmediol"><?php echo $row['actividad_extra'];?></td>
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