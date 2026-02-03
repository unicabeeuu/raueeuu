<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$ref_payco=$_REQUEST['ref_payco'];
	$tipo=$_REQUEST['tipo'];
	
	if($tipo == "TC") {
		$query = "SELECT scp, convenio FROM tbl_transac_tc WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "EF") {
		$query = "SELECT scp, convenio FROM tbl_transac_ef WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "BAL") {
		$query = "SELECT scp, convenio FROM tbl_transac_bal WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "PUNR") {
		$query = "SELECT scp, convenio FROM tbl_transac_punr WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "REDS") {
		$query = "SELECT scp, convenio FROM tbl_transac_reds WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "GANA") {
		$query = "SELECT scp, convenio FROM tbl_transac_gana WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "PSE") {
		$query = "SELECT scp, convenio FROM tbl_transac_pse WHERE ref_payco = '$ref_payco'";
	}
	//echo $query;
	$resultado=$mysqli1->query($query);
	
	$datos=array();
	while($row = $resultado->fetch_assoc()){
		$datos[] = $row;
	}
	
	if ($datos) { 
  
         $datos1["estado"] = 1; 
         $datos1["registros"] = $datos; 
  
         echo json_encode($datos1); 
     } else { 
         print json_encode(array( 
             "estado" => 2, 
             "mensaje" => "Ha ocurrido un error" 
         )); 
     }
	
	//echo json_encode($datos);
	$resultado->close();
	$mysqli1->close();
	
?>