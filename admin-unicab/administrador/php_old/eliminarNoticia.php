<?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-noticias.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$idNoticia=$_GET['id'];
	try {
		$sql_eliminar="DELETE FROM `noticia` WHERE IdNoticia=".$idNoticia."";
		$exe_eliminar=mysqli_query($conexion,$sql_eliminar);
		echo "<script>alert('Noticia eliminada correctamente');</script>";
	} catch (Exception $e) {
		echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
		echo "<script>location.href='../index.php';</script>";
	}
	
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../../login_registro.php'</script>";
}
?>