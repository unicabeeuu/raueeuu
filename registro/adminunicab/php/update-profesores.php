 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../docenteunicab/index.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

include "conexion.php";
include "../../docenteunicab/updreg/mcript.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$password=$_POST['password'];
	$id=$_POST['id'];
	$password = $gen_enc($password);

	//$sql="UPDATE `profesores` SET `password`='".$password."' WHERE id='".$id."'";
	$sql="UPDATE `tbl_empleados` SET `pc`='".$password."' WHERE id='".$id."'";
	$rec = mysqli_query($conexion, $sql);
	//MENSAJE DE ENVIO
echo"<script>alert('Sus datos se estan actualizando')</script>";
?>