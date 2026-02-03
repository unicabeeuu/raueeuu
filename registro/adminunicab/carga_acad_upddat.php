<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$tutor = $_REQUEST["tutor"];
	$idgra = $_REQUEST["idgra"];
	$idpen = $_REQUEST["idpen"];
	//echo $tutor;
	
	//Se actuliza la carga
	$query = "UPDATE carga_profesor SET id_empleado = $tutor WHERE id_grado = $idgra AND id_materia = $idpen";
	//echo $query;
	$resultado2=$mysqli1->query($query);
	$sel = $mysqli1->affected_rows;
	
	//echo json_encode($formula, JSON_UNESCAPED_UNICODE);
	echo $sel;
	
?>