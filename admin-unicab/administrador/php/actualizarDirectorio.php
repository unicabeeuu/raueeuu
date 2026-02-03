 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-directorio.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$nombre=$_POST['nombreD'];
		$dependencia=$_POST['dependenciaD'];
		$correo=$_POST['correoD'];
		$skype=$_POST['skypeD'];
		$telefono=$_POST['telefonoD'];
		$what=$_POST['whatD'];
		$cargo=$_POST['cargoD'];

		$id=$_POST['idD'];

		
		try {
			$sql_actualizar="UPDATE `directorio` SET `nombre`='".$nombre."',`dependencia`='".$dependencia."',`correo`='".$correo."',`skype`='".$skype."',`telefono`='".$telefono."',`telefono_what`='".$what."',`cargo`='".$cargo."' WHERE `id`=".$id."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('Los datos de la persona fueron actualizados correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo más tarde');</script>";
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>