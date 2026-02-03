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
	
	$query = "SELECT e.*, CONCAT(e.nombres,' ',e.apellidos) nombre 
	FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.estado = 'retirado' AND m.n_matricula like '%2023%'";
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
					echo '<label>Estudiantes Retirados. Total Registros &#9658; '.$sel.'</label>';
				?>
				<table border="1px" class="table" id="tblest">
					<thead>
					<tr>
						<td class="tdlargo"><b>NOMBRE</b></td>
						<td class="tdcorto"><b>ID</b></td>
						<td class="tdmedia"><b>TIPO DOCUMENTO</b></td>
						<td class="tdnormal"><b>No. DOCUMENTO</b></td>
						<td class="tdmediol"><b>EXPEDICION</b></td>
						<td class="tdnormal"><b>FECHA NACIMIENTO</b></td>
						<td class="tdlargo"><b>EMAIL INST</b></td>
						<td class="tdmedia"><b>CIUDAD</b></td>
						<td class="tdmediol"><b>DIRECCION.</b></td>
						<td class="tdlargo"><b>ACUDIENTE 1</b></td>
						<td class="tdlargo"><b>EMAIL ACUDIENTE 1</b></td>
						<td class="tdmediol1"><b>TELEFONO ACUDIENTE 1</b></td>
						<td class="tdlargo"><b>ACUDIENTE 2</b></td>
						<td class="tdlargo"><b>EMAIL ACUDIENTE 2</b></td>
						<td class="tdmediol1"><b>TELEFONO ACUDIENTE 2</b></td>
						<td class="tdmediol"><b>ACTIVIDAD EXTRA</b></td>
					</tr>
					</thead>
					<tbody>
					<?php
					    while($row = $resultado->fetch_assoc()){
					?>
					<tr>
						<td class="tdlargo"><?php echo $row['nombre'];?></td>
						<td class="tdcorto"><?php echo $row['id'];?></td>
						<td class="tdmedia"><?php echo $row['tipo_documento'];?></td>
						<td class="tdmediol"><?php echo $row['n_documento'];?></td>
						<td class="tdmediol1"><?php echo $row['expedicion'];?></td>
						<td class="tdmediol"><?php echo $row['fecha_nacimiento'];?></td>
						<td class="tdlargo"><?php echo $row['email_institucional'];?></td>
						<td class="tdmediol1"><?php echo $row['ciudad'];?></td>
						<td class="tdelargo"><?php echo $row['direccion'];?></td>
						<td class="tdlargo"><?php echo $row['acudiente_1'];?></td>
						<td class="tdlargo"><?php echo $row['email_acudiente_1'];?></td>
						<td class="tdmediol1"><?php echo $row['telefono_acudiente_1'];?></td>
						<td class="tdlargo"><?php echo $row['acudiente_2'];?></td>
						<td class="tdlargo"><?php echo $row['email_acudiente_2'];?></td>
						<td class="tdmediol1"><?php echo $row['telefono_acudiente_2'];?></td>
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