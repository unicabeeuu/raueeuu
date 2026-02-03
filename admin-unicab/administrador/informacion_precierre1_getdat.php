<?php
	require "../php/conexion.php";
    //https://unicab.org/admin-unicab/administrador/informacion_precierre1_getdat.php?buscar=999999&id_val=3
	
	$buscar = $_REQUEST["buscar"];
	$id_val = $_REQUEST["id_val"];
	
	$datos = new stdClass();
	$seguimientos = array();
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$fanio = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	
	//Se valida si ya tiene cierre
	$query1 = "SELECT COUNT(1) ct FROM tbl_seg_psi_cierre sc, tbl_seg_psi_val sv 
	WHERE sc.id_valoracion = sv.id AND sv.id = $id_val";
	$exe_query1 = mysqli_query($conexion, $query1);
	while ($fila1 = mysqli_fetch_array($exe_query1)) {
	    $ct_cierre = $fila1['ct'];
	    $datos->ct_cierre = $fila1['ct'];
	}
    //echo $query1;
	
	if($ct_cierre > 0) {
        $datos->estado = "CON_CIERRE";
        $datos->doc_est = $buscar;
    }
    else {
        //Se consulta el detalle de los otros seguimientos
        $query_realizados = "SELECT s.*, e.nombres, e.apellidos 
    	FROM tbl_seg_psi s, tbl_empleados e 
    	WHERE s.id_psicologo = e.id AND s.id_valoracion = $id_val";
	    //echo $query_realizados;
    	$exe_realizados = mysqli_query($conexion, $query_realizados);
    	while ($fila_realizados = mysqli_fetch_array($exe_realizados, MYSQLI_ASSOC)) {
    	    $seguimientos[] = $fila_realizados;
    	}
    }
	    
	$datos->seguimientos = $seguimientos;
	
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>