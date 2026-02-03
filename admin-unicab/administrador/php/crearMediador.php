 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../registro-mediador.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$nombre=$_POST['nombre'];
		$cargo=$_POST['cargo'];
		$profesion=$_POST['profesion'];
		$dependencia=$_POST['dependencia'];
		$descripcion=$_POST['descripcion'];

		// imagen 
		$imagen=$_FILES['foto']['name'];
		$ruta=$_FILES['foto']['tmp_name'];
		$tipo_archivo=$_FILES['foto']['type'];
		$destino="../../../assets/img/equipo/".$imagen;
		copy($ruta, $destino);
		// imagen

		try {	

			$sql_insert='INSERT INTO mediadores(nombre, cargo, profesion, dependencia, descripcion, foto) VALUES ("'.$nombre.'","'.$cargo.'","'.$profesion.'","'.$dependencia.'","'.$descripcion.'","'.$destino.'")';
			$exe_insert=mysqli_query($conexion,$sql_insert);
			echo "<script>alert('El mediador fue creado con éxito');</script>";

		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>