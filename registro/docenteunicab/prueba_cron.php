<?php
	require("updreg/1cc3s4db.php");
	
	echo "hola";
	
	date_default_timezone_set('America/Bogota');
    $dia = date("d");
    $mes = date("m");
    $mesLetra = date("M");
    $fanio = date("Y");
	$hora = date("G");
	$minutos = date("i");
    $fecha2 = $fanio."/".$mes."/".$dia." ".$hora.":".$minutos;
	
	$sql = "INSERT INTO tbl_temp1 (t1) VALUES ('$fecha2')";
	$reso = $mysqli1->query($sql);
	
	//Se direcciona al envío de correo 
	echo "<script>location.href='https://unicab.solutions/prueba_correo.php';</script>";

?>