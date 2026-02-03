 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../registro-carga.php?id=1">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php 
require "conexion.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
$id_profesor=$_POST['id_profesor'];
$id_grado=$_POST['id_grado'];
$id_materia=$_POST['id_materia'];

$buscar="SELECT * FROM `carga_profesor` WHERE id_grado=".$id_grado." and id_materia=".$id_materia."";
$exe=mysqli_query($conexion,$buscar);
$total_busqueda=mysqli_num_rows($exe);
if ($total_busqueda>=1) {
	echo '<script language="javascript" type="text/javascript" > alert("¡Advertencia! \nLa asignatura de este grado ya fue asignada a otro docente"); </script>  ';
}else{
	$sql="INSERT INTO `carga_profesor`(`id_profesor`, `id_grado`, `id_materia`) VALUES ('".$id_profesor."','".$id_grado."','".$id_materia."')";
$rec=mysqli_query($conexion,$sql);
echo"<script>alert('La información esta siendo almacenada')</script>";
}

?>