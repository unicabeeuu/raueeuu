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
	$pc = $gen_enc($pc);
	$ndoc = $_REQUEST["ndoc"];
	$depen = str_replace("_"," ",strtoupper($_REQUEST["depen"]));
	$skype = $_REQUEST["skype"];
	$cel = $_REQUEST["cel"];
	$cargo = str_replace("_"," ",strtoupper($_REQUEST["cargo"]));
	$prof = str_replace("_"," ",strtoupper($_REQUEST["prof"]));
	$nomc = str_replace("_"," ",strtoupper($_REQUEST["nomc"]));
	//echo $id;
	//echo $cargo;
	
	$query = "INSERT INTO tbl_empleados (nombres, apellidos, email, pc, perfil, n_documento, dependencia, skype, celular, celular_what, 
	    cargo, profesion, descripcion, nombre_corto) 
	    VALUES ('$nom', '$ape', '$email', '$pc', 'TU', '$ndoc', '$depen', '$skype', '$cel', '$cel', '$cargo', '$prof', 'NA', '$nomc')";
	//echo $query;
	$resultado2=$mysqli1->query($query);
	$sel = $mysqli1->affected_rows;
	
	//echo json_encode($formula, JSON_UNESCAPED_UNICODE);
	echo $sel;
	
?>