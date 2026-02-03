 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-directorio.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$nombre=$_POST['nombreD'];
		$dependencia=$_POST['dependenciaD'];
		$correo=$_POST['correoD'];
		$skype=$_POST['skypeD'];
		$telefono=$_POST['telefonoD'];
		$telefono_what=$_POST['whatD'];
		$cargo=$_POST['cargoD'];

		
		try {	
			$sql_directorio="INSERT INTO `directorio`(`nombre`, `dependencia`, `correo`, `skype`, `telefono`, `telefono_what`, `cargo`) VALUES ('".$nombre."','".$dependencia."','".$correo."','".$skype."','".$telefono."','".$telefono_what."','".$cargo."')";
			$exe_directorio=mysqli_query($conexion,$sql_directorio);	
		
			echo "<script>alert('La persona fue agregada correctamente al directorio');</script>";
				
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	
?>