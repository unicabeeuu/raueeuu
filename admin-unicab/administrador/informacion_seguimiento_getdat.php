<?php
	require "../php/conexion.php";
    //https://unicab.org/admin-unicab/administrador/informacion_seguimiento_getdat.php?buscar=999999
	
	$buscar = $_REQUEST["buscar"];
	
	$datos = new stdClass();
	//$grados_val = array();
	//$grados_val1 = array();
	//$keys = ['id_grav','grav'];
	
	//Se hace la consulta
	$query0 = "SELECT e.*, m.*, g.grado 
    FROM estudiantes e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND e.n_documento = '$buscar' 
    AND date_format(m.fecha_ingreso, '%Y') = 2021";
	//echo $query0;
	$exe_query0 = mysqli_query($conexion, $query0);
    while ($fila = mysqli_fetch_array($exe_query0)) {
        $nombre_completo = $fila['nombres']." ".$fila['apellidos'];
            
	    $datos->nom_completo = $nombre_completo;
        $datos->id_grado = $fila['id_grado'];
        $datos->grado = $fila['grado'];
        $datos->nom_est = $fila['nombres'];
	    $datos->ape_est = $fila['apellidos'];
	    $datos->doc_est = $fila['n_documento'];
	    $datos->act_ext = $fila['actividad_extra'];
	    $datos->nom_a = $fila['acudiente_1'];
	    $datos->cel_a = $fila['telefono_acudiente_1'];
	    $datos->email_a = $fila['email_acudiente_1'];
	}
	
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>