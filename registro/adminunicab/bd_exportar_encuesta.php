<?php
    session_start();
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	//include "../../adminunicab/php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	header("Content-type:application/xls; charset=iso-8859-1");
	header("Content-Disposition: attachment; filename=encuesta_bimestre4_2024.xls");
	
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
	
	//$idest = $_REQUEST['idest'];
	echo $id;
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
	
	$peticion = "SELECT er.*, ep.pregunta, ep.tipo, g.grado, CONCAT(e.nombres, ' ', e.apellidos) nombre,
	CASE er.resultado WHEN 'A' THEN ep.a WHEN 'B' THEN ep.b WHEN 'C' THEN ep.c WHEN 'D' THEN ep.d WHEN 'E' THEN ep.e ELSE er.resultado END resultado1
	FROM tbl_encuestas_resultados er, tbl_encuestas_preguntas ep, grados g, estudiantes e  
	WHERE er.id_pregunta = ep.id AND er.id_encuesta = ep.id_encuesta AND er.id_grado = g.id AND er.n_documento = e.n_documento
	AND er.id_encuesta = 1 
	ORDER BY er.id_grado, er.n_documento, er.id_pregunta";
	//$resultado = mysqli_query($conexion, $peticion);
	$resultado = $mysqli1->query($peticion);
	$sel = $mysqli1->affected_rows;

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<center>
			<fieldset>
				<legend>Resultados Encuesta Bimestre 4 2024
				</legend>
				<?php
					echo '<label>Total Registros &#9658; '.$sel.'</label>';
				?>
				<table border="1px" class="table" id="tblest">
					<thead>
					<tr>
						<td class="tdlargo"><b>GRADO</b></td>
						<td class="tdcorto"><b>DOCUMENTO</b></td>
						<td class="tdmedia"><b>NOMBRE</b></td>
						<td class="tdnormal"><b>TIPO PREGUNTA</b></td>
						<td class="tdnormal"><b>PREGUNTA</b></td>
						<td class="tdmediol"><b>RESULTADO</b></td>
						<td class="tdnormal"><b>AÑO</b></td>
					</tr>
					</thead>
					<tbody>
					<?php
					    while($row = $resultado->fetch_assoc()){
					?>
					<tr>
						<td class="tdlargo"><?php echo $row['grado'];?></td>
						<td class="tdcorto"><?php echo $row['n_documento'];?></td>
						<td class="tdmedia"><?php echo $row['nombre'];?></td>
						<td class="tdnormal"><?php echo $row['tipo'];?></td>
						<td class="tdnormal"><?php echo $row['pregunta'];?></td>
						<td class="tdmediol"><?php echo $row['resultado1'];?></td>
						<td class="tdnormal"><?php echo $row['año'];?></td>
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
	<?php 
	}else{
		echo "<script>alert('Debes iniciar sesión');</script>";
		echo "<script>location.href='../../login_registro.php'</script>";
	}
	?>
</html>