 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../estudianteunicab/index.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

include "conexion.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$password=$_POST['password'];
	$id=$_POST['id'];

	$sql="UPDATE `estudiantes` SET `password`='".$password."' WHERE `id`='".$id."'";
	$rec = mysqli_query($conexion, $sql);
	//MENSAJE DE ENVIO
	echo"<script>alert('Los datos se estan actualizando')</script>";
?>