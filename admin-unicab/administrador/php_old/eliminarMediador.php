<?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head>
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-mediadores.php">
		<meta http-equiv="content-type" content="text/html" />
		<meta charset="UTF-8">
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$id=$_GET['id'];
	try {

		$sql_eliminar="DELETE FROM mediadores WHERE `id`=".$id."";
		$exe_eliminar=mysqli_query($conexion,$sql_eliminar);
		echo "<script>alert('El mediador fue eliminado correctamente');</script>";

	} catch (Exception $e) {

		echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
		echo "<script>location.href='../index.php';</script>";
		
	}
	
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../../login_registro.php'</script>";
}
?>