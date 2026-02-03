 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../registro-evento.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$nombre=$_POST['NombreE'];
		$descripcion=$_POST['DescripcionE'];

		// fecha publicado
		date_default_timezone_set('America/Bogota');

		$dia=date("d");
		$mes=date("m");
		$mesLetra=date("M");
		$fanio=date("Y");

		$fechaHoy=$fanio."-".$mes."-".$dia;
		// fecha publicado

		$fecha=$_POST['FechaE'];
		$hora=$_POST['HoraE'];
		$lugar=$_POST['LugarE'];

		// imagen 
		$imagen=$_FILES['ImagenE']['name'];
		$ruta=$_FILES['ImagenE']['tmp_name'];
		$tipo_archivo =$_FILES['ImagenE']['type'];
		$destino="../../../assets/img/eventos/".$imagen;
		copy($ruta, $destino);
		// imagen

		$link=$_POST['LinkE'];
		$idAdministrador=$_POST['IdAdministrador'];

		try {	
			$sql_evento="INSERT INTO `evento`(`NombreE`, `DescripcionE`, `FechaPublicacionE`, `FechaE`, `HoraE`, `LugarE`, `ImagenE`, `LinkE`, `IdAdministrador`) VALUES ('".$nombre."','".$descripcion."','".$fechaHoy."','".$fecha."','".$hora."','".$lugar."','".$destino."','".$link."',".$idAdministrador.")";
			$exe_evento=mysqli_query($conexion,$sql_evento);	
				echo "<script>alert('Evento creado correctamente');</script>";
				// echo "<script>location.href='../index.php';</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>