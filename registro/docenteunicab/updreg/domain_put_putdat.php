<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/domain_put_putdat.php?pal=prueba
	
	//$pal = nl2br(str_replace("_", " ", $_REQUEST['pal']));
	$pal = $_REQUEST['pal'];
	//echo $preg;
	
	$soporte_subido = "../../../assets/img/domain/";
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	if($dia < 10) {
		//$dia = "0".$dia;
	}
	if($mes < 10) {
		//$mes = "0".$mes;
	}
	$fecha2 =$a."/".$mes."/". $dia;
	
	if ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpg") {
	    $soporte_subido = $soporte_subido . basename($_FILES['file']['name']);
	
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../../assets/img/domain/".$_FILES['file']['name'])) {
            //more code here...
            //echo "imagen ok";
        } else {
            //echo "imagen error";
        }
    }
	echo $soporte_subido;
	
	$sql_insert = "INSERT INTO tbl_metodo_domain (palabra, imagen, fecha, estado) 
        	VALUES ('$pal', '$soporte_subido', '$fecha2', 0)";
	//echo "<br>".$sql_insert;
	$res_insert=mysqli_query($conexion,$sql_insert);
	
	//Se consulta el id de la palabra
	$sql_idpreg = "SELECT id FROM tbl_metodo_domain WHERE palabra = '$pal'";
	$exe_idpreg = mysqli_query($conexion,$sql_idpreg);

	while ($fila = mysqli_fetch_array($exe_idpreg)){
	    $idpreg = $fila['id'];
	}
	echo $idpreg;
	
?>