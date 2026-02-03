<?php
	
	require("1cc3s4db.php");
	
	$ref_payco=$_REQUEST['ref_payco'];
	$tipo=$_REQUEST['tipo'];
	$estado=$_REQUEST['estado'];
	$nomconv=str_replace("_"," ",$_REQUEST['nomconv']);
	
	$updest = new stdClass();
	$estados = array();
	$mensajes = array();
	
	if($tipo == "TC") {
		$sql="UPDATE tbl_transac_tc SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}
	else if($tipo == "EF") {
		$sql="UPDATE tbl_transac_ef SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}
	else if($tipo == "BAL") {
		$sql="UPDATE tbl_transac_bal SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}
	else if($tipo == "PUNR") {
		$sql="UPDATE tbl_transac_punr SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}
	else if($tipo == "REDS") {
		$sql="UPDATE tbl_transac_reds SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}
	else if($tipo == "GANA") {
		$sql="UPDATE tbl_transac_gana SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}
	else if($tipo == "PSE") {
		$sql="UPDATE tbl_transac_pse SET estado = '$estado' WHERE ref_payco = '$ref_payco' AND convenio = '$nomconv'";
	}	
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	if($resultado > 0) {
	    $estados[] = "OK";
	    $mensajes[] = "Registro actualizado";
	    /*print json_encode(array( 
            "estado" => 1, 
            "mensaje" => "Registro actualizado" 
        ));*/
	}
	else {
	    $estados[] = "ERR";
	    $mensajes[] = "Ha ocurrido un error";
	    /*print json_encode(array( 
            "estado" => 2, 
            "mensaje" => "Ha ocurrido un error" 
        ));*/
	}
	$estados[] = "NA";
	$mensajes[] = "NA";
	
	$updest->estados = $estados;
	$updest->mensajes = $mensajes;
	
	echo json_encode($updest, JSON_UNESCAPED_UNICODE);
	
	//$resultado->close();
	//$mysqli->close();
?>