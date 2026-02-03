<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	$idpen = $_REQUEST["idpen"];
	$idact = $_REQUEST["idact"];
	$por = $_REQUEST["por"];
	$comp = $_REQUEST["comp"];
	
	$query1 = "UPDATE tbl_config_act SET porcentaje = $por/100, computar_en = $comp WHERE id_act = $idact AND id_grado = $idgra AND id_pensamiento = $idpen";
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	
	echo "Registro actualizado";
?>