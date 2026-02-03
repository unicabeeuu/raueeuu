 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-estudiantes_presol.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

include "conexion.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	$apellidos=strtoupper($_POST['apellidos']);
	$nombres=strtoupper($_POST['nombres']);
	$tipo_documento=$_POST['tDocumento'];
	$n_documento=$_POST['n_documento'];
	$estado=$_POST['estado'];
	$id=$_POST['id'];
	echo $estado;
	
	//Se busca el idMatricula
	$sql_idmat = "SELECT MAX(idMatricula) idMatricula FROM matricula WHERE id_estudiante = $id";
	$exe_idmat = mysqli_query($conexion, $sql_idmat);
	while($row_idmat = mysqli_fetch_array($exe_idmat)) {
	    $idmat = $row_idmat['idMatricula'];
	}
	
	//Se actualza la tabla de matricula cuando el estado es Retirado o activod
	$sql1 = "UPDATE matricula SET estado = '$estado' WHERE id_estudiante = $id 
	AND idMatricula = $idmat";
	//echo $sql1;
	$rec1 = mysqli_query($conexion, $sql1);
	//MENSAJE DE ENVIO
	echo"<script>alert('Los datos se han actualizado')</script>";
?>