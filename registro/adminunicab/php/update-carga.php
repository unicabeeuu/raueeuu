 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../carga-docente.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php 
include "conexion.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
$id_carga=$_GET['id'];
$sql="DELETE FROM `carga_profesor` WHERE id=".$id_carga."";
$exe=mysqli_query($conexion,$sql);
echo"<script>alert('La carga del docente ha sido eliminada')</script>";


// var_dump($id_carga_profesor);

?>
