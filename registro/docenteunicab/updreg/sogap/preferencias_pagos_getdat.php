<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$conv=strtoupper(str_replace("_"," ",$_REQUEST['conv']));
	$tran=$_REQUEST['tran'];
	$vgatw = 0;
	
	if($tran == "TC" || $tran == "PSE") {
	    //Se captura un cиоdigo de pago del convenio
    	/*$query0 = "SELECT max(tp.codigo) codigo 
            FROM tbl_pagos tp, tbl_cp cp 
            WHERE tp.id_convenio = cp.id AND cp.convenio = '$conv'";
        $resultado0=$mysqli1->query($query0);
        while($row0 = $resultado0->fetch_assoc()){
    		$codigo = $row0['codigo'];
    	}*/
    	
    	//Se consulta si el convenio tiene modelo Gateway
    	/*$query01 = "SELECT a.*, ifnull(tg.val_fijo_gateway, 0) val_gateway 
            FROM 
            (SELECT tp.valor total, cp.incremento, tp.id_convenio, i.* 
            FROM tbl_pagos tp, tbl_cp cp, (SELECT * FROM tbl_incrementos WHERE tipo = 'PEB') i 
            WHERE tp.id_convenio = cp.id AND tp.codigo = '$codigo' AND cp.convenio = '$conv') a 
            LEFT OUTER JOIN (SELECT * FROM tbl_gateway WHERE estado = 'ACTIVO' AND ct_actual > 30) tg 
            ON a.id_convenio = tg.id_convenio";*/
        $query01 = "SELECT cp.convenio, ifnull(tg.val_fijo_gateway, 0) val_gateway, tg.* 
            FROM (SELECT * FROM tbl_cp WHERE convenio = '$conv' ) cp 
            LEFT OUTER JOIN (SELECT * FROM tbl_gateway WHERE estado = 'ACTIVO' AND ct_actual > 30) tg 
            ON cp.id = tg.id_convenio ";
        $resultado01=$mysqli1->query($query01);
        while($row01 = $resultado01->fetch_assoc()){
    		$vgatw = $row01['val_gateway'];
    	}
	}
	
	if($vgatw > 0) {
	    $query="SELECT pic_key, pte_key, vi FROM tbl_keys WHERE modelo = 'GATEWAY' AND id_convenio IN (SELECT id FROM tbl_cp WHERE convenio = '$conv')";
	}
	else {
	    $query="SELECT pic_key, pte_key, vi FROM tbl_keys WHERE modelo = 'AGREGADOR' AND id_convenio IN (SELECT id FROM tbl_cp WHERE convenio = '$conv')";
	}
	
	//$query="SELECT parametro, t1 FROM tbl_parametros WHERE parametro IN ('vi','pte_key','pic_key') ORDER BY parametro";
	//$query="SELECT pic_key, pte_key, vi FROM tbl_keys WHERE id_convenio IN (SELECT id FROM tbl_cp WHERE convenio = '$conv')";
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