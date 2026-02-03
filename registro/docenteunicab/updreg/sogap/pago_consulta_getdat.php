<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$codref=strtoupper(str_replace("_"," ",$_REQUEST['codref']));
	
	$query="SELECT * FROM tbl_pagos WHERE codigo like '%".$codref."%'";
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