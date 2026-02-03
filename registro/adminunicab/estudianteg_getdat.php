<?php
	require("php/1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$gra = strtoupper($_POST['selgra1']);
	//echo $gra;
	
	if($gra == "NA") {
	    $query1 = "SELECT e.id, a.grado, m.n_matricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra 
		FROM estudiantes e, matricula m, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro 
		ORDER BY a.grado, nombre";
	}
	else {
	    $query0 = "SELECT * FROM equivalence_idgra WHERE id_category = ".$gra;
    	$resultado0=$mysqli1->query($query0);
    	while($row0 = $resultado0->fetch_assoc()){
    	    $gra1 = $row0['name'];
    	}
	
	    $query1 = "SELECT e.id, a.grado, m.n_matricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra 
		FROM estudiantes e, matricula m, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro 
		AND a.grado = '".$gra1."'  
		ORDER BY a.grado, nombre";
	}
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	$sel = $mysqli1->affected_rows;
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="../docenteunicab/updreg/css/reg.css" >
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
	</head>
	<body>
		<center>
			<div id="enc">
				<img src="../docenteunicab/updreg/img/enc2.png" alt="enc2" />
			</div>
			<div id="divres">
				<table>
					<tbody>
						<tr>
							<td height="30">
							</td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend></legend>
									<div>
									    <?php
										echo '<label>Total Registros &#9658; '.$sel.'</label>';
										?>
										<table border="1px" class="tr">
											<thead>
											<tr>
												<td><b>ID</b></td>
												<td><b>GRADO</b></td>
												<td><b>MATRICULA</b></td>
												<td><b>USUARIO</b></td>
												<td><b>NOMBRE</b></td>
												<td><b>DOCUMENTO No.</b></td>
												<td><b>FECHA NACIMIENTO</b></td>
												<td><b>EMAIL INST</b></td>
												<td><b>ACUDIENTE 1</b></td>
												<td><b>EMAIL ACUDIENTE 1</b></td>
												<td><b>TELEFONO ACUDIENTE 1</b></td>
												<td><b>ACUDIENTE 2</b></td>
												<td><b>EMAIL ACUDIENTE 2</b></td>
												<td><b>TELEFONO ACUDIENTE 2</b></td>
												<td><b>DIRECCION</b></td>
												<td><b>CIUDAD</b></td>
												<td><b>ACTIVIDAD EXTRA</b></td>
											</tr>
											</thead>
											<tbody>
											<?php
											    while($row = $resultado->fetch_assoc()){
											?>
											<tr>
												<td><?php echo $row['id'];?></td>
												<td><?php echo $row['grado'];?></td>
												<td><?php echo $row['n_matricula'];?></td>
												<td><?php echo $row['usuario'];?></td>
												<td><?php echo $row['nombre'];?></td>
												<td><?php echo $row['n_documento'];?></td>
												<td><?php echo $row['fecha_nacimiento'];?></td>
												<td><?php echo $row['email_institucional'];?></td>
												<td><?php echo $row['acudiente_1'];?></td>
												<td><?php echo $row['email_acudiente_1'];?></td>
												<td><?php echo $row['telefono_acudiente_1'];?></td>
												<td><?php echo $row['acudiente_2'];?></td>
												<td><?php echo $row['email_acudiente_2'];?></td>
												<td><?php echo $row['telefono_acudiente_2'];?></td>
												<td><?php echo $row['direccion'];?></td>
												<td><?php echo $row['ciudad'];?></td>
												<td><?php echo $row['actividad_extra'];?></td>
											</tr>
											<?php }
												$resultado->close();
												$mysqli1->close();
											?>
											</tbody>
										</table>
									</div>
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
		</center>
	</body>
	
</html>