<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	//$id = $_REQUEST["id"];
	$td = str_replace("_"," ",strtoupper($_REQUEST["td"]));
	//echo $id;
	//echo $cargo;
	
	//Se actuliza el calculo
	$query = "INSERT INTO tbl_tipos_documento (tipo_documento) VALUES ('$td')";
	//echo $query;
	$resultado2=$mysqli1->query($query);
	$sel = $mysqli1->affected_rows;
	
	//echo json_encode($formula, JSON_UNESCAPED_UNICODE);
	echo $sel;
	
?>