<?php
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/adminunicab/buscar_estudiante_getdat.php?doc=9397454
	
	$documento = $_REQUEST["doc"];
	
	$datos = new stdClass();
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    if($mes >= 11) {
        $fanio = $fanio + 1;
    }
	
	$tablae = "estudiantes";
	$tablam = "matricula";
	
	//Se hace la consulta
	$query0 = "SELECT e.*, m.*, CASE e.genero WHEN 'FEMENINO' THEN 1 WHEN 'MASCULINO' THEN 2 END idgenero, e.estado estadoe  
	FROM ".$tablae." e, ".$tablam." m WHERE e.id = m.id_estudiante AND e.n_documento = '$documento' AND fecha_ingreso like '%$fanio%'";
	//echo $query0;
	$resultado0 = $mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()) {
	    //$nuevo_array[] = $row0;
		$datos = $row0;
	}	
	
	//echo json_encode($nuevo_array, JSON_UNESCAPED_UNICODE);
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>