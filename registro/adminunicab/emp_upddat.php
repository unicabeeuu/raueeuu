<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	require("../docenteunicab/updreg/mcript.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$id = $_REQUEST["id"];
	$nom = str_replace("_"," ",strtoupper($_REQUEST["nom"]));
	$ape = str_replace("_"," ",strtoupper($_REQUEST["ape"]));
	$email = $_REQUEST["email"];
	$pc = $_REQUEST["pc"];
	$pc1 = $_REQUEST["pc1"];
	$depen = str_replace("_"," ",strtoupper($_REQUEST["depen"]));
	$skype = $_REQUEST["skype"];
	$cel = $_REQUEST["cel"];
	$cargo = str_replace("_"," ",strtoupper($_REQUEST["cargo"]));
	$prof = str_replace("_"," ",strtoupper($_REQUEST["prof"]));
	$nomc = str_replace("_"," ",strtoupper($_REQUEST["nomc"]));
	$rh = str_replace("_"," ",strtoupper($_REQUEST["rh"]));
	$rh = str_replace("ZZZ","+",($rh));
	//echo $id;
	//echo $cargo;
	
	//Se valida si cambio el pass
	if($pc == $pc1) {
	    $query = "UPDATE tbl_empleados SET nombres = '$nom', apellidos = '$ape', email = '$email', dependencia = '$depen', skype = '$skype', 
	        celular = '$cel', celular_what = '$cel', cargo = '$cargo', profesion = '$prof', nombre_corto = '$nomc', rh = '$rh' WHERE id = $id";
	}
	else {
	    $pc = $gen_enc($pc);
	    $query = "UPDATE tbl_empleados SET nombres = '$nom', apellidos = '$ape', email = '$email', pc = '$pc', dependencia = '$depen', skype = '$skype', 
	        celular = '$cel', celular_what = '$cel', cargo = '$cargo', profesion = '$prof', nombre_corto = '$nomc', rh = '$rh' WHERE id = $id";
	}
	
	
	//echo $query;
	$resultado2=$mysqli1->query($query);
	$sel = $mysqli1->affected_rows;
	
	//echo json_encode($formula, JSON_UNESCAPED_UNICODE);
	echo $sel;
	
?>