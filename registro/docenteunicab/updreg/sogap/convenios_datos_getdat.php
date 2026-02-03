<?php
	
	require("1cc3s4db.php");
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$hora = date("G",$fecha);
	$dia = date("D",$fecha);
	
	$query="SELECT * FROM tbl_cp WHERE id > 0 ORDER BY convenio";
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