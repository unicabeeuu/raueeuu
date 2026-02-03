 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../index.php">
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
	$perfil = "NA";
	$foto = "NA";

	//$buscar="SELECT * FROM profesores where n_documento='".$n_documento."'";
	$buscar="SELECT * FROM tbl_empleados where n_documento='".$n_documento."'";
	$petecion=mysqli_query($conexion,$buscar);
	if (mysqli_num_rows($petecion)>=1) {
		echo"<script>alert('El empleado ya esta registrado')</script>";
	}else{
		/*$sql='INSERT INTO `profesores`(`apellidos`, `nombres`, `email_institucional`, `n_documento`, `d_pensamiento`, `password`) VALUES (
		"'.$apellidos.'",
		"'.$nombres.'",
		"'.$email_institucional.'",
		"'.$n_documento.'",
		"'.$d_pensamiento.'",
		"'.$n_documento.'")';*/
		$sql='INSERT INTO `tbl_empleados` (`nombres`, `apellidos`, `email`, `pc`, `perfil`, `n_documento`, `dependencia`, `skype`, `celular`
		    , `celular_what`, `cargo`, `profesion`, `descripcion`, `foto`, `nombre_corto`) VALUES (
		"'.$nombres.'",
		"'.$apellidos.'",
		"'.$email.'",
		"'.$pc.'",
		"'.$perfil.'",
		"'.$n_documento.'",
		"'.$depen.'",
		"'.$skype.'",
		"'.$cel.'",
		"'.$cel.'",
		"'.$cargo.'",
		"'.$profesion.'",
		"'.$desc.'",
		"'.$foto.'",
		"'.$nombrec.'")';
    	$rec = mysqli_query($conexion, $sql);
    	$row_cnt = mysqli_num_rows($rec);
        //echo $sql;
        //echo $row_cnt;
        if($row_cnt > 0) {
            echo"<script>alert('El empleado ha sido almacendao')</script>";
        }
        else {
            echo"<script>alert('Error guardando empleado')</script>";
        }
    	
	}
?>