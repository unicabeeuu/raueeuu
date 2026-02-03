 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {
 ?>
<!--<html>
	<head>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado_premat.php">
		<meta http-equiv="content-type" content="text/html" />
		<meta charset="UTF-8">
	</head>
</html>-->
<?php
		$nombree = strtoupper($_REQUEST['nombree']);
		$apellidoe = strtoupper($_REQUEST['apellidoe']);
		$documentoe = $_REQUEST['documentoe'];
		$selgrado = $_REQUEST['selgrado'];
		$observaciones = nl2br(strtoupper($_REQUEST['observaciones']));
		$id_emp = $_REQUEST['id_emp'];
		$email = $_REQUEST['email'];
		$selorigen = $_REQUEST['selorigen'];
		$nombreCompleto = $nombree." ".$apellidoe;
		
		// fecha publicado
		date_default_timezone_set('America/Bogota');
    	$fecha = time();
    	$dia = date("d",$fecha);
    	$mes = date("m",$fecha);
    	$fanio = date("Y",$fecha);
		if($mes >= 10) {
			$fanio++;
		}

		$fechaHoy = $fanio."/".$mes."/".$dia;
		// fecha publicado
		
		//Se valida que el documento y grado ya existan
		$sql_val = "SELECT COUNT(1) ct FROM estudiantes_eval_admision WHERE n_documento = '$documentoe' AND id_grado = ".$selgrado." AND año = $fanio";
		$exe_val = mysqli_query($conexion, $sql_val);
		while ($row_val = mysqli_fetch_array($exe_val)) {
			$ct = $row_val["ct"];
		}
		
		if ($ct == 0) {
			try {	
				$sql_ins = "INSERT INTO estudiantes_eval_admision (nombre, n_documento, id_grado, email, observaciones, origen, año) 
				VALUES ('$nombreCompleto', '$documentoe', $selgrado, '$email', '$observaciones', '$selorigen', $fanio)";
				//echo $sql_prem;
				$exe_ins = mysqli_query($conexion, $sql_ins);	
			
				echo "<script>alert('La información se generó correctamente');</script>";
				echo "<script>location.href='../programar_eval_admision.php';</script>";
					
			} catch (Exception $e) {
				echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
				echo "<script>location.href='../programar_eval_admision.php';</script>";
			}
		}
		else {
			echo "<script>alert('Este documento ya tiene un registro de evaluación de admisión para el grado ".$selgrado."');</script>";
			echo "<script>location.href='../programar_eval_admision.php';</script>";
		}
		
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
	
?>