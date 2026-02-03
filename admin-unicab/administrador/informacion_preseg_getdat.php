<?php
	require "../php/conexion.php";
    //https://unicab.org/admin-unicab/administrador/informacion_preseg_getdat.php?buscar=999999   / 1051074066
	
	$buscar = $_REQUEST["buscar"];
	
	$datos = new stdClass();
	$seguimientos = array();
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$fanio = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	
	//Se hace la consulta del seguimiento abierto
	 $query0 = "SELECT COUNT(1) ct FROM tbl_seg_psi_val sv, tbl_seg_psi s WHERE sv.id = s.id_valoracion AND sv.n_documento = '".$buscar."' 
	 AND s.estado = 'abierto'";
	//echo $query0;
	$exe_query0 = mysqli_query($conexion, $query0);
    while ($fila = mysqli_fetch_array($exe_query0)) {
        $ct = $fila['ct'];
	}
	
	if($ct > 0) {
    	$datos->estado = "SEGUIMIENTO_ABIERTO";
    	
    	//Se consulta el detalle del seguimiento abierto
    	$query_abierto = "SELECT sv.*, s.id id_seg, s.id_psicologo id_psicologo_seg, s.objetivo, s.fecha, s.hora, e.id id_emp, e.nombres nombres_emp, e.apellidos apellidos_emp, 
    	es.nombres nombres_est, es.apellidos apellidos_est, m.id_grado, g.grado, em.nombres nombres_sol, em.apellidos apellidos_sol 
    	FROM tbl_seg_psi_val sv, tbl_seg_psi s, tbl_empleados e, estudiantes es, matricula m, grados g, tbl_empleados em 
    	WHERE sv.id = s.id_valoracion AND sv.id_psicologo = e.id AND sv.id_empleado = em.id AND sv.n_documento = es.n_documento AND es.id = m.id_estudiante AND m.id_grado = g.id 
    	AND sv.n_documento = '".$buscar."' AND date_format(m.fecha_ingreso, '%Y') >= 2018 
	    AND s.estado = 'abierto'";
	    //echo $query_abierto;
    	$exe_abierto = mysqli_query($conexion, $query_abierto);
    	while ($fila_abierto = mysqli_fetch_array($exe_abierto)) {
    	    $nombre_empleado = $fila_abierto['nombres_emp']." ".$fila_abierto['apellidos_emp'];
    	    $nombre_solicito = $fila_abierto['nombres_sol']." ".$fila_abierto['apellidos_sol'];
    	    $id_val = $fila_abierto['id'];
    	    
    	    $datos->id_val = $fila_abierto['id'];
            $datos->id_emp = $fila_abierto['id_emp'];
            $datos->nom_emp = $nombre_empleado;
            $datos->nom_sol = $nombre_solicito;
            $datos->id_grado = $fila_abierto['id_grado'];
            $datos->grado = $fila_abierto['grado'];
            $datos->nom_est = $fila_abierto['nombres_est'];
    	    $datos->ape_est = $fila_abierto['apellidos_est'];
    	    $datos->doc_est = $fila_abierto['n_documento'];
    	    $datos->id_seg = $fila_abierto['id_seg'];
    	    $datos->obj = nl2br($fila_abierto['objetivo']);
    	    $datos->fecha = $fila_abierto['fecha'];
    	    $datos->hora = $fila_abierto['hora'];
    	}
    	
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
	        //Se consulta la información de valoración
        	$query2 = "SELECT v.* 
        	FROM tbl_seg_psi_val v WHERE v.id = $id_val";
        	//echo $query2;
        	$exe_query2 = mysqli_query($conexion, $query2);
            while ($fila2 = mysqli_fetch_array($exe_query2)) {
                $datos->piar = $fila2['piar'];
                $datos->motivo = $fila2['motivo'];
        	    $datos->niv_bio = nl2br($fila2['nivel_biologico']);
        	    $datos->niv_int = nl2br($fila2['nivel_intelectual']);
        	    $datos->niv_mot = nl2br($fila2['nivel_motor']);
        	    $datos->autonomia = nl2br($fila2['autonomia']);
        	    $datos->niv_len = nl2br($fila2['nivel_lenguaje']);
        	    $datos->niv_soc = nl2br($fila2['nivel_social']);
        	    $datos->personalidad = nl2br($fila2['personalidad']);
        	    $datos->niv_esc = nl2br($fila2['nivel_escolar']);
        	    $datos->con_soc_fam = nl2br($fila2['contexto_socio_fam']);
        	    $datos->obs = nl2br($fila2['observaciones']);
        	}
    	
	        //Se consulta el detalle de los otros seguimientos
	        $query_realizados = "SELECT s.*, e.nombres, e.apellidos 
        	FROM tbl_seg_psi s, tbl_empleados e 
        	WHERE s.id_psicologo = e.id AND s.estado != 'abierto' AND s.id_valoracion = $id_val";
    	    //echo $query_realizados;
        	$exe_realizados = mysqli_query($conexion, $query_realizados);
        	while ($fila_realizados = mysqli_fetch_array($exe_realizados, MYSQLI_ASSOC)) {
        	    $seguimientos[] = $fila_realizados;
        	}
	    }
	}
	else {
	    $datos->estado = "SIN_SEGUIMIENTOS_ABIERTOS";
	    $datos->doc_est = $buscar;
	}
	$datos->seguimientos = $seguimientos;
	
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>