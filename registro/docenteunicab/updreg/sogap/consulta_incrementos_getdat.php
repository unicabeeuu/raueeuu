<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$convenio=$_REQUEST['convenio'];
	$convenio = str_replace("_"," ",$convenio);
	$tipo=$_REQUEST['tipo'];
	$tipo1=$_REQUEST['tipo1'];
	$valor=$_REQUEST['valor'];
	
	$query = "SELECT a.*, ifnull(tg.val_fijo_gateway, 0) val_gateway, '$tipo1' tipo1 
        FROM 
        (SELECT cp.incremento, cp.id id_conv, i.*  
        FROM tbl_cp cp, (SELECT * FROM tbl_incrementos WHERE tipo = '$tipo') i 
        WHERE cp.convenio = '$convenio') a 
        LEFT OUTER JOIN (SELECT * FROM tbl_gateway WHERE estado = 'ACTIVO' AND ct_actual > 30) tg 
        ON a.id_conv = tg.id_convenio";
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