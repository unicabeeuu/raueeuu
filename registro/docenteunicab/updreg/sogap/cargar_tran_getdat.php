<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$ced=$_REQUEST['ced'];
	
	$query="SELECT * FROM 
	(SELECT descripcion, v1l, f1c, recibo, 'TC' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_tc WHERE c4dd4c = '$ced' 
	UNION ALL 
	SELECT descripcion, v1l, f1c, recibo, 'EF' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_ef WHERE c4dd4c = '$ced' 
	UNION ALL 
	SELECT descripcion, v1l, f1c, recibo, 'BAL' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_bal WHERE c4dd4c = '$ced' 
	UNION ALL 
	SELECT descripcion, v1l, f1c, recibo, 'PSE' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_pse WHERE c4dd4c = '$ced'
	UNION ALL 
	SELECT descripcion, v1l, f1c, recibo, 'PUNR' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_punr WHERE c4dd4c = '$ced'
	UNION ALL 
	SELECT descripcion, v1l, f1c, recibo, 'REDS' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_reds WHERE c4dd4c = '$ced'
	UNION ALL 
	SELECT descripcion, v1l, f1c, recibo, 'GANA' tipo, fecha_upd, ref_payco, c4dv3 FROM tbl_transac_gana WHERE c4dd4c = '$ced') a 
	ORDER BY a.fecha_upd";
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