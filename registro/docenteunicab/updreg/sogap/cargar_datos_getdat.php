<?php
	
	require("1cc3s4db.php");
	//require("c4nf3g.php");
	
	$query="SELECT * FROM 
	(SELECT 'PAISES' fuente, id, nombre descripcion, abreviatura abrv FROM tbl_paises 
	UNION ALL 
	SELECT 'DEPTOS' fuente, id, nombre descripcion, 'NA' abrv FROM tbl_deptos 
	UNION ALL 
	SELECT 'MONEDAS' fuente, id, nombre descripcion, abreviatura abrv FROM tbl_monedas 
	UNION ALL 
	SELECT 'FRANQUICIAS' fuente, id, nombre descripcion, 'NA' abrv FROM tbl_tt WHERE id <> 4 
	UNION ALL 
	SELECT 'MUNICIPIOS' fuente, id, nombre descripcion, id_depto abrv FROM tbl_municipios WHERE id = -1 
	UNION ALL 
	SELECT 'CONVENIOS' fuente, id, convenio descripcion, 'NA' abrv FROM tbl_cp WHERE estado = 'ACTIVO' 
	UNION ALL 
	SELECT 'TIPOPER' fuente, id, tipo_persona descripcion, 'NA' abrv FROM tbl_tp 
	UNION ALL 
	SELECT 'TIPODOC' fuente, id, tipo_documento descripcion, 'NA' abrv FROM tbl_td) a ORDER BY 1, 3";
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