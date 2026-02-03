<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	include "mcript.php";
	
	$nomconv=strtoupper(str_replace("_"," ",$_REQUEST['nomconv']));
	//echo $nomconv;
	
	//Se busca la pc
	$query0 = "Select pc FROM tbl_cp WHERE convenio like '%".$nomconv."%'";
	//echo $query0;
	$resultado0=$mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()){
		$pc1 = $row0['pc'];
	}
	//echo $pc1;
	$pc1 = str_replace("_","+",$pc1);
	
	$query="SELECT *, '".$dev_enc($pc1)."' pc1 FROM tbl_cp WHERE convenio like '%".$nomconv."%'";
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