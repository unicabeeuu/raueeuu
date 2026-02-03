 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-entrevistas.php">
		<meta http-equiv="content-type" content="text/html" />
		<meta charset="UTF-8">
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$documento=$_POST['documento'];
		$psicologo=$_POST['psicologo'];
		$observaciones=$_POST['observaciones'];
		
		
		// fecha publicado
		date_default_timezone_set('America/Bogota');

		$dia=date("d");
		$mes=date("m");
		$mesLetra=date("M");
		$fanio=date("Y");

		$fechaHoy=$fanio."-".$mes."-".$dia;
		// fecha publicado

		
		try {	
			$sql_blog="INSERT INTO `entrevistas`(`documento`, `fecha`, `psicologo`, `observaciones`) 
			VALUES ('".$documento."','".$fechaHoy."','".$psicologo."','".$observaciones."');";
			$exe_blog=mysqli_query($conexion,$sql_blog);	
		
				echo "<script>alert('El código se generó correctamente');</script>";
				
				
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	
?>