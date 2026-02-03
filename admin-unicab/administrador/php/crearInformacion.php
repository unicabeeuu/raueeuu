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
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$nombrea = strtoupper($_REQUEST['nombrea']);
		$cela = $_REQUEST['cela'];
		$emaila = $_REQUEST['emaila'];
		$ciudad = strtoupper($_REQUEST['ciudad']);
		$nombree = strtoupper($_REQUEST['nombree']);
		$apellidoe = strtoupper($_REQUEST['apellidoe']);
		$documentoe = $_REQUEST['documentoe'];
		$actextra = strtoupper($_REQUEST['actextra']);
		$selgrado = $_REQUEST['selgrado'];
		$observaciones = nl2br(strtoupper($_REQUEST['observaciones']));
		$id_emp = $_REQUEST['id_emp'];
		$estado = $_REQUEST['estado'];
		$id_est = $_REQUEST['id_est'];
		$selmedio = $_REQUEST['selmedio'];
		$selinteresado = $_REQUEST['selinteresado'];
		
		
		// fecha publicado
		date_default_timezone_set('America/Bogota');
    	$fecha = time();
    	$dia = date("d",$fecha);
    	$mes = date("m",$fecha);
    	$fanio = date("Y",$fecha);

		$fechaHoy = $fanio."/".$mes."/".$dia;
		// fecha publicado

		if($estado == "NUEVO") {
    		try {	
    			$sql_prem = "INSERT INTO tbl_pre_matricula (id_empleado, id_grado, documento_est, nombres_est, apellidos_est, 
    			fecha, actividad_extra, nombre_a, celular_a, email_a, ciudad_a, observaciones, entrevista, observaciones_ent, id_medio, interesado) 
    			VALUES ($id_emp, $selgrado, '$documentoe', '$nombree', '$apellidoe', '$fechaHoy', '$actextra', '$nombrea', '$cela', '$emaila', '$ciudad', '$observaciones', 'NO', 
    			'NA', $selmedio, '$selinteresado')";
    			//echo $sql_prem;
    			$exe_prem = mysqli_query($conexion,$sql_prem);	
    		
				echo "<script>alert('La información se generó correctamente');</script>";
				echo "<script>location.href='../informacion_preent.php';</script>";
    				
    		} catch (Exception $e) {
    			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
    			//echo "<script>location.href='../index.php';</script>";
    		}
		}
		else if($estado == "ANTIGUO") {
		    try {	
    			$sql_prem = "UPDATE tbl_pre_matricula 
    			SET id_grado = $selgrado, nombres_est = '$nombree', apellidos_est = '$apellidoe', actividad_extra = '$actextra', documento_est = '$documentoe', 
    			nombre_a = '$nombrea', celular_a = '$cela', email_a = '$emaila', ciudad_a = '$ciudad', observaciones = '$observaciones', id_medio = $selmedio, 
    			interesado = '$selinteresado' 
    			WHERE id = $id_est";
    			echo $sql_prem;
    			$exe_prem = mysqli_query($conexion,$sql_prem);	
    		
				echo "<script>alert('La información se generó correctamente');</script>";
				echo "<script>location.href='../informacion_preent.php';</script>";
    				
    		} catch (Exception $e) {
    			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
    			//echo "<script>location.href='../index.php';</script>";
    		}
		}
		
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
	
?>