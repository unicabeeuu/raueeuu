 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../index.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

include "conexion.php";
$n_matricula=$_POST['n_matricula'];
$fecha_ingreso=$_POST['fecha_ingreso'];
$estado="activo";
$id_estudiante=$_POST['id'];
$id_grado=$_POST['id_grado'];	
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
$sql='INSERT INTO `matricula`(`n_matricula`, `fecha_ingreso`, `estado`, `id_estudiante`, `id_grado`) 
VALUES ("'.$n_matricula.'","'.$fecha_ingreso.'","'.$estado.'",'.$id_estudiante.','.$id_grado.')';
$rec = mysqli_query($conexion, $sql);
$sql1="UPDATE estudiantes SET estado='activo' where id=".$id_estudiante;
$rec1=mysqli_query($conexion,$sql1);
	// MENSAJE DE ENVIO
//echo"<script>alert('La matricula está siendo almacendao')</script>";
echo"<script>alert('La matricula se generó con éxito.')</script>";
?>