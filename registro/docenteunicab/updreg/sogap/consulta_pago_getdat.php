<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$codigo=$_REQUEST['codigo'];
	$convenio=$_REQUEST['convenio'];
	$convenio = str_replace("_"," ",$convenio);
	$tipo=$_REQUEST['tipo'];
	$tipo1=$_REQUEST['tipo1'];
	$tran=$_REQUEST['tran'];
	
	/*$query="SELECT SUM(cantidad * valor_unitario) total
		FROM tbl_pedidos
		WHERE codigo = '$codigo' AND id_negocio = (SELECT id_negocio FROM tbl_negocios WHERE nombre = '$convenio')";*/
	
	/*$query="SELECT valor total
		FROM tbl_pagos  
		WHERE codigo = '$codigo' AND id_convenio = (SELECT id FROM tbl_cp WHERE convenio = '$convenio')";*/
		
	//Se consulta el valor del pago
	$query0 = "SELECT tp.valor FROM tbl_pagos tp, tbl_cp cp WHERE tp.id_convenio = cp.id AND tp.codigo = '$codigo' AND cp.convenio = '$convenio'";
	$resultado0=$mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()){
		$valor = $row0['valor'];
	}
	
	if($valor < 60000 && $tran == "PSE") {
	    /*$query = "SELECT tp.valor total, cp.incremento, i.* 
        FROM tbl_pagos tp, tbl_cp cp, (SELECT * FROM tbl_incrementos WHERE tipo = '$tipo1') i 
        WHERE tp.id_convenio = cp.id AND tp.codigo = '$codigo' AND cp.convenio = '$convenio'";*/
        $query = "SELECT a.*, ifnull(tg.val_fijo_gateway, 0) val_gateway 
        FROM 
        (SELECT tp.valor total, cp.incremento, tp.id_convenio, tp.concepto, i.* 
        FROM tbl_pagos tp, tbl_cp cp, (SELECT * FROM tbl_incrementos WHERE tipo = '$tipo1') i 
        WHERE tp.id_convenio = cp.id AND tp.codigo = '$codigo' AND cp.convenio = '$convenio') a 
        LEFT OUTER JOIN (SELECT * FROM tbl_gateway WHERE estado = 'ACTIVO' AND ct_actual > 30) tg 
        ON a.id_convenio = tg.id_convenio";
	}
	else {
	    /*$query = "SELECT tp.valor total, cp.incremento, i.* 
        FROM tbl_pagos tp, tbl_cp cp, (SELECT * FROM tbl_incrementos WHERE tipo = '$tipo') i 
        WHERE tp.id_convenio = cp.id AND tp.codigo = '$codigo' AND cp.convenio = '$convenio'";*/
        $query = "SELECT a.*, ifnull(tg.val_fijo_gateway, 0) val_gateway 
        FROM 
        (SELECT tp.valor total, cp.incremento, tp.id_convenio, tp.concepto, i.* 
        FROM tbl_pagos tp, tbl_cp cp, (SELECT * FROM tbl_incrementos WHERE tipo = '$tipo') i 
        WHERE tp.id_convenio = cp.id AND tp.codigo = '$codigo' AND cp.convenio = '$convenio') a 
        LEFT OUTER JOIN (SELECT * FROM tbl_gateway WHERE estado = 'ACTIVO' AND ct_actual > 30) tg 
        ON a.id_convenio = tg.id_convenio";
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