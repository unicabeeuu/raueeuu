 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../registro-noticia.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$titulo=$_POST['TituloN'];
		$descripcion=$_POST['DescripcionN'];

		// imagen 
		$imagen=$_FILES['ImagenN']['name'];
		$ruta=$_FILES['ImagenN']['tmp_name'];
		$tipo_archivo =$_FILES['ImagenN']['type'];
		$destino="../../../assets/img/imgnoticias/".$imagen;
		copy($ruta, $destino);
		// imagen

		// fecha publicado
		date_default_timezone_set('America/Bogota');

		$dia=date("d");
		$mes=date("m");
		$mesLetra=date("M");
		$fanio=date("Y");

		$fechaHoy=$fanio."-".$mes."-".$dia;
		// fecha publicado

		// hora actual
		$hora=date("g");
		$minuto=date("i");
		$meridiano=date("A");
		$horaActual=$hora.':'.$minuto.' '.$meridiano;
		// hora actual

		$categoria=$_POST['CategoriaN'];
		$fuente=$_POST['FuenteN'];
		$idAdministrador=$_POST['IdAdministrador'];

		try {	
			$sql_noticia="INSERT INTO `noticia`(`TituloN`, `DescripcionN`, `ImagenN`, `FechaPublicacionN`, `HoraPublicacionN`, `CategoriaN`, `FuenteN`, `IdAdministrador`) VALUES ('".$titulo."','".$descripcion."','".$destino."','".$fechaHoy."','".$horaActual."','".$categoria."','".$fuente."','".$idAdministrador."')";
			$exe_noticia=mysqli_query($conexion,$sql_noticia);	
			echo "<script>alert('Noticia creada correctamente');</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>