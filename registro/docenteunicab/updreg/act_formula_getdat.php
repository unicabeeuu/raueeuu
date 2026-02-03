<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idact = $_REQUEST["idact"];
	
	$formula = new stdClass();
	$datos = new stdClass();
	
	$query = "SELECT calculation1, replace(calculation1,'#','') calculation2 FROM tbl_config_act WHERE id_act = $idact";
	$resultado=$mysqli1->query($query);
	while($row = $resultado->fetch_assoc()) {
	    //$formula = $row['calculation1'];
	    if($row['calculation1'] == "=") {
	        $datos->resultado = "Error";
	        $datos->form = "NA";
	        $datos->form1 = "NA";
	    }
	    else {
	        $datos->resultado = "Ok";
	        $datos->form = $row['calculation1'];
	        $datos->form1 = str_replace("gi","",$row['calculation2']);
	    }
	    
	}
	
	//echo $formula;
	$formula->datos = $datos;
	echo json_encode($formula, JSON_UNESCAPED_UNICODE);
	
?>