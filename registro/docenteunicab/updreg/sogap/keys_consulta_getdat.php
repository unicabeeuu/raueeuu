<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$idconv=$_REQUEST['idconv'];
	$modelo=$_REQUEST['modelo'];
	
	$query="SELECT * FROM tbl_keys WHERE id_convenio = ".$idconv." AND modelo = '$modelo'";
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