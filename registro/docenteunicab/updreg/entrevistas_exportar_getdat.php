<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	header("Content-type:application/xls; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=base_datos.xls");
	
	$idest = $_REQUEST['idest'];
	//echo $idest;
	
	$query = "SELECT en.*, m.id_grado, m.estado, e.nombres, e.apellidos, e.actividad_extra, e.acudiente_1, e.telefono_acudiente_1, e.email_acudiente_1, e.ciudad 
        FROM entrevistas en LEFT JOIN estudiantes e 
        ON en.documento = e.n_documento LEFT JOIN matricula m 
        ON e.id = m.id_estudiante 
        ORDER BY en.id, m.id_grado DESC";
	
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
				<legend>Base de Datos de Estudiantes
				</legend>
				<?php
					echo '<label>Base de Datos de Estudiantes. Total Registros &#9658; '.$sel.'</label>';
				?>
				<table border="1px" class="table" id="tblest">
					<thead>
					<tr>
						<td class="tdcorto"><b>ID</b></td>
						<td class="tdmedia"><b>DOCUMENTO</b></td>
						<td class="tdnormal"><b>FECHA</b></td>
						<td class="tdmediol"><b>PSICOLOGO</b></td>
						<td class="tdnormal"><b>OBSERVACIONES</b></td>
						<td class="tdmedia"><b>ID GRADO</b></td>
						<td class="tdmediol"><b>ESTADO</b></td>
						<td class="tdmediol1"><b>NOMBRES</b></td>
						<td class="tdmediol"><b>APELLIDOS</b></td>
						<td class="tdlargo"><b>ACT EXTRA</b></td>
						<td class="tdlargo"><b>ACUDIENTE 1</b></td>
						<td class="tdmediol1"><b>TELEFONO ACUDIENTE 1</b></td>
						<td class="tdlargo"><b>EMAIL ACUDIENTE 1</b></td>
						<td class="tdmediol1"><b>CIUDAD</b></td>
					</tr>
					</thead>
					<tbody>
					<?php
					    while($row = $resultado->fetch_assoc()){
					?>
					<tr>
						<td class="tdcorto"><?php echo $row['id'];?></td>
						<td class="tdmedia"><?php echo $row['documento'];?></td>
						<td class="tdnormal"><?php echo $row['fecha'];?></td>
						<td class="tdmediol"><?php echo $row['psicologo'];?></td>
						<td class="tdnormal"><?php echo $row['observaciones'];?></td>
						<td class="tdmedia"><?php echo $row['id_grado'];?></td>
						<td class="tdmediol"><?php echo $row['estado'];?></td>
						<td class="tdmediol1"><?php echo $row['nombres'];?></td>
						<td class="tdmediol"><?php echo $row['apellidos'];?></td>
						<td class="tdlargo"><?php echo $row['actividad_extra'];?></td>
						<td class="tdlargo"><?php echo $row['acudiente_1'];?></td>
						<td class="tdmediol1"><?php echo $row['telefono_acudiente_1'];?></td>
						<td class="tdlargo"><?php echo $row['email_acudiente_1'];?></td>
						<td class="tdmediol1"><?php echo $row['ciudad'];?></td>
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