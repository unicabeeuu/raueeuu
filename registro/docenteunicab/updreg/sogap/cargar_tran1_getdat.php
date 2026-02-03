<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$ced=$_REQUEST['ced'];
	$tipo=$_REQUEST['tipo'];
	$fac=$_REQUEST['fac'];
	$ref=$_REQUEST['ref'];
	$recibo=$_REQUEST['recibo'];
	
	if($tipo == "TC") {
		$query = "SELECT *, 'TC' tipo FROM tbl_transac_tc WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
	}
	else if($tipo == "EF") {
		$query = "SELECT *, 'EF' tipo FROM tbl_transac_ef WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
	}
	else if($tipo == "BAL") {
		$query = "SELECT *, 'BAL' tipo FROM tbl_transac_bal WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
	}
	else if($tipo == "PUNR") {
		$query = "SELECT *, 'PUNR' tipo FROM tbl_transac_punr WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
	}
	else if($tipo == "REDS") {
		$query = "SELECT *, 'REDS' tipo FROM tbl_transac_reds WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
	}
	else if($tipo == "GANA") {
		$query = "SELECT *, 'GANA' tipo FROM tbl_transac_gana WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
	}
	else if($tipo == "PSE") {
		$query = "SELECT *, 'PSE' tipo FROM tbl_transac_pse WHERE c4dd4c = '$ced' AND f1c = '$fac' AND ref_payco = '$ref' AND recibo = '$recibo'";
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