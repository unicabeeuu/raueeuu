<?php
	require "../php/conexion.php";
    //https://unicab.org/admin-unicab/administrador/informacion_preval_getdat.php?buscar=999999
	
	$buscar = $_REQUEST["buscar"];
	
	$datos = new stdClass();
	$grados_val = array();
	$grados_val1 = array();
	$keys = ['id_grav','grav'];
	
	//Se hace la consulta de valoración
	 $query0 = "SELECT COUNT(1) ct FROM tbl_seg_psi_val WHERE n_documento = '".$buscar."'";
	//echo $query0;
	$exe_query0 = mysqli_query($conexion, $query0);
    while ($fila = mysqli_fetch_array($exe_query0)) {
        $ct = $fila['ct'];
        $datos->ct_val = $fila['ct'];
	}
	
	if($ct > 0) {
    	$datos->estado = "CON_VALORACION";
    	
    	//Se consulta el id de la última valoración
    	$query_idval = "SELECT id FROM tbl_seg_psi_val WHERE n_documento = '".$buscar."' 
    	AND id = (SELECT MAX(id) FROM tbl_seg_psi_val WHERE n_documento = '$buscar')";
    	$exe_idval = mysqli_query($conexion, $query_idval);
    	while ($fila_idval = mysqli_fetch_array($exe_idval)) {
    	    $id_val = $fila_idval['id'];
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
	        $query2 = "SELECT v.*, e.nombres, e.apellidos, m.id_grado, g.grado, em.id id_emp, em.nombres nombres_emp, em.apellidos apellidos_emp, 
	        em1.nombres nombres_sol, em1.apellidos apellidos_sol, s.estado 
        	FROM tbl_seg_psi_val v, estudiantes e, matricula m, grados g, tbl_empleados em, tbl_empleados em1, tbl_seg_psi s 
        	WHERE v.n_documento = e.n_documento AND e.id = m.id_estudiante AND m.id_grado = g.id AND v.id_psicologo = em.id AND v.id_empleado = em1.id 
        	AND v.id = s.id_valoracion AND v.n_documento = '".$buscar."' AND v.id = $id_val 
        	AND s.id = (SELECT MAX(id) FROM tbl_seg_psi WHERE id_valoracion = $id_val)";
        	//echo $query2;
        	$exe_query2 = mysqli_query($conexion, $query2);
            while ($fila2 = mysqli_fetch_array($exe_query2)) {
                $nombre_empleado = $fila2['nombres_emp']." ".$fila2['apellidos_emp'];
                $nombre_solicita = $fila2['nombres_sol']." ".$fila2['apellidos_sol'];
                
        	    $datos->id = $fila2['id'];
                $datos->id_emp = $fila2['id_emp'];
                $datos->nom_emp = $nombre_empleado;
                $datos->nom_sol = $nombre_solicita;
                $datos->piar = $fila2['piar'];
                $datos->id_grado = $fila2['id_grado'];
                $datos->grado = $fila2['grado'];
                $datos->nom_est = $fila2['nombres'];
        	    $datos->ape_est = $fila2['apellidos'];
        	    $datos->doc_est = $fila2['n_documento'];
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
        	    $datos->est_seg = nl2br($fila2['estado']);
        	    //$datos->obj_sig = nl2br($fila2['objetivo_siguiente']);
        	}
	    }
	}
	else {
	    $datos->estado = "SIN_VALORACION";
	    $datos->doc_est = $buscar;
		$query2 = "SELECT e.nombres, e.apellidos, m.id_grado, g.grado 
		FROM estudiantes e, matricula m, grados g 
		WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND e.n_documento = '".$buscar."' AND m.estado = 'activo'";
		//echo $query2;
		$exe_query2 = mysqli_query($conexion, $query2);
		while ($fila2 = mysqli_fetch_array($exe_query2)) {
			$datos->id = $fila2['id'];
			$datos->id_grado = $fila2['id_grado'];
			$datos->grado = $fila2['grado'];
			$datos->nom_est = $fila2['nombres'];
			$datos->ape_est = $fila2['apellidos'];
			$datos->doc_est = $buscar;
			//$datos->obj_sig = nl2br($fila2['objetivo_siguiente']);
		}
	}
	
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>