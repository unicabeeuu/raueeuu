 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-profesores.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

include "conexion.php";
require("mcript.php");
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$id=$_REQUEST['id'];
	
	$apellidos=strtoupper($_REQUEST['apellidos']);
	$nombres=strtoupper($_REQUEST['nombres']);
	$email=$_REQUEST['email'];
	$n_documento=$_REQUEST['n_documento'];
	$pc = $gen_enc($_REQUEST['pass']);
	$depen=$_REQUEST['txtdepen'];
	$skype=$_REQUEST['skype'];
	$cel=$_REQUEST['celular'];
	$cargo=$_REQUEST['txtcargo'];
	$profesion=strtoupper($_REQUEST['profesion']);
	$desc=nl2br($_REQUEST['descripcion']);
	$nombrec=strtoupper($_REQUEST['nombrec']);

	//$sql="UPDATE `profesores` SET `apellidos`='".$apellidos."',`nombres`='".$nombres."',`email_institucional`='".$email_institucional."',`n_documento`='".$n_documento."',`d_pensamiento`='".$d_pensamiento."',`password`='".$password."' WHERE id='".$id."'";
	$sql="UPDATE tbl_empleados 
	SET apellidos = '".$apellidos."', nombres = '".$nombres."', email = '".$email."', n_documento = '".$n_documento
	."', pc = '".$pc."', dependencia = '".$depen."', skype = '".$skype."', celular = '".$cel."', celular_what = '".$cel."', cargo = '".$cargo
	."', descripcion = '".$desc."', profesion = '".$profesion."', nombre_corto = '".$nombrec."'  WHERE id='".$id."'";

	$rec = mysqli_query($conexion, $sql);
	//MENSAJE DE ENVIO
	//echo"<script>alert('Los datos se estan actualizando')</script>";
	echo"<script>alert('El empleado se ha actualizado')</script>";
?>