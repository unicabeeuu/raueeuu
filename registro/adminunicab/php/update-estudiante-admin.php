 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-estudiantes.php">
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
	$genero=$_POST['genero'];
	$tipo_documento=$_POST['tDocumento'];
	$n_documento=$_POST['n_documento'];
	$fecha_nacimiento=$_POST['fecha_nacimiento'];
	$expedicion=strtoupper($_POST['expedicion']);
	$ciudad=strtoupper($_POST['ciudad']);
	$direccion=$_POST['direccion'];
	$direccion_est=$_POST['direccion_est'];
	$email_institucional=$_POST['email_institucional'];
	$actividad_extra=$_POST['actividad_extra'];
	$email_acudiente_1=$_POST['email_acudiente_1'];
	$email_acudiente_2=$_POST['email_acudiente_2'];
	$acudiente_1=$_POST['acudiente_1'];
	$documento_acu=$_POST['documento_acu'];
	$acudiente_2=$_POST['acudiente_2'];
	$telefono_acudiente_1=$_POST['telefono_acudiente_1'];
	$telefono_acudiente_2=$_POST['telefono_acudiente_2'];
	$parentesco_acudiente_1=strtoupper($_POST['parentesco_acudiente_1']);
	$parentesco_acudiente_2=strtoupper($_POST['parentesco_acudiente_2']);
	$estado=$_POST['estado'];
	$password=$_POST['password'];
	$id=$_POST['id'];
	$mensaje=$_POST['mensaje'];
	$rh=$_POST['rh'];

	$sql="UPDATE `estudiantes` SET `apellidos`='".$apellidos."',`nombres`='".$nombres."',`genero`='".$genero."', `tipo_documento`='".$tipo_documento."', 
	`n_documento`='".$n_documento."',`fecha_nacimiento`='".$fecha_nacimiento."', `expedicion`='".$expedicion."', `ciudad`='".$ciudad."',`direccion_estudiante`='".$direccion_est."', 
	`email_institucional`='".$email_institucional."',`actividad_extra`='".$actividad_extra."',`email_acudiente_1`='".$email_acudiente_1."', 
	`email_acudiente_2`='".$email_acudiente_2."',`acudiente_1`='".$acudiente_1."',`acudiente_2`='".$acudiente_2."',`telefono_acudiente_1`='".$telefono_acudiente_1."', 
	`telefono_acudiente_2`='".$telefono_acudiente_2."',`estado`='".$rh."',`password`='".$password."', mensaje='".$mensaje."', documento_responsable='".$documento_acu."', direccion='".$direccion."', 
	`parentesco_acudiente_1`='".$parentesco_acudiente_1."',`parentesco_acudiente_2`='".$parentesco_acudiente_2."' 
	WHERE id='".$id."'";
	$rec = mysqli_query($conexion, $sql);
	//echo $sql;
	
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