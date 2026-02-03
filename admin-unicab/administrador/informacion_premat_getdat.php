<?php
	require "../php/conexion.php";
    //https://unicab.org/admin-unicab/administrador/informacion_premat_getdat.php?buscar=1020318995&tipo=DOC
	
	$buscar = $_REQUEST["buscar"];
	$tipo = $_REQUEST["tipo"];
	//echo $tipo;
	
	$datos = new stdClass();
	$grados_val = array();
	$grados_val1 = array();
	$keys = ['id_grav','grav'];
	$keys_eval = ['estado','ct'];
	$eval_val = array();
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$fanio = date("Y",$fecha);
	if($mes >= 10) {
        $fanio = $fanio + 1;
    }
	//echo $fanio;
	
	//Se busca información en la tabla de etudiantes
    $sql_ct_est = "SELECT COUNT(1) ct FROM estudiantes WHERE n_documento = '".$buscar."'";
    //echo $sql_ct_est;
    $exe_ct_est = mysqli_query($conexion, $sql_ct_est);
    while ($fila_ct_est = mysqli_fetch_array($exe_ct_est)) {
        $ct_est = $fila_ct_est['ct'];
	    $datos->ct_est = $fila_ct_est['ct'];
	}
    	
	//Se hace la consulta en la tabla pre matrícula
	/*if($tipo == "DOC") {
	    $query0 = "SELECT COUNT(1) ct FROM tbl_pre_matricula WHERE documento_est = '".$buscar."'";
	}
	else if($tipo == "CEL") {
	    $query0 = "SELECT COUNT(1) ct FROM tbl_pre_matricula WHERE celular_a = '".$buscar."'";
	}
	//echo $query0;
	$exe_query0 = mysqli_query($conexion, $query0);
    while ($fila = mysqli_fetch_array($exe_query0)) {
        $ct = $fila['ct'];
	    $datos->ct = $fila['ct'];
	}*/
	
	//Se hace la consulta del mÃ¡ximo registro en matrículas
	if($tipo == "DOC") {
	    $query0 = "SELECT IFNULL(max(m.idmatricula), 0) maxid FROM estudiantes e, matricula m 
		WHERE e.id = m.id_estudiante AND e.n_documento = '$buscar'";
	}
	else if($tipo == "CEL") {
	    $query0 = "SELECT IFNULL(max(m.idmatricula), 0) maxid FROM estudiantes e, matricula m 
		WHERE e.id = m.id_estudiante AND e.telefono_acudiente_1 = '$buscar'";
	}
	//echo "<br>query0: ".$query0;
	$exe_query0 = mysqli_query($conexion, $query0);
    while ($fila = mysqli_fetch_array($exe_query0)) {
        $ct = $fila['maxid'];
		$maxid = $fila['maxid'];
	    $datos->maxid = $fila['maxid'];
	}
	//echo "<br>ct: ".$ct;
	
	//Se valida si es estudiante NUEVO
	/*$sql_val_nuevo = "SELECT a_matricula FROM estudiantes 
	WHERE id = (SELECT id_estudiante FROM matricula WHERE idMatricula = $ct)";
	//echo "<br>sql_val_nuevo: ".$sql_val_nuevo;
	$exe_val_nuevo = mysqli_query($conexion, $sql_val_nuevo);
	while ($fila_nuevo = mysqli_fetch_array($exe_val_nuevo)) {
		$a_matricula = $fila_nuevo['a_matricula'];
		$datos->a_matricula = $fila_nuevo['a_matricula'];
	}
	
	if ($a_matricula == $fanio) {
		$datos->estado = "NUEVO";
	}
	else {
		$datos->estado = "ANTIGUO";
	}*/
	
	$sql_val_nuevo = "SELECT COUNT(1) ct FROM matricula WHERE id_estudiante = (SELECT id FROM estudiantes WHERE n_documento = '$buscar')";
	//echo "<br>sql_val_nuevo: ".$sql_val_nuevo;
	$exe_val_nuevo = mysqli_query($conexion, $sql_val_nuevo);
	while ($fila_nuevo = mysqli_fetch_array($exe_val_nuevo)) {
		$ctMatriculas = $fila_nuevo['ct'];		
	}
	//echo $ctMatriculas;
	$datos->a_matricula = $fanio;
	
	if ($ctMatriculas > 1) {
		$datos->estado = "ANTIGUO";
	}
	else {
		$datos->estado = "NUEVO";
	}
	
	if($tipo == "DOC") {
		/*$query1 = "SELECT p.*, e.nombres, e.apellidos, g.grado 
		FROM tbl_pre_matricula p, tbl_empleados e, grados g 
		WHERE p.id_empleado = e.id AND p.id_grado = g.id 
		AND p.documento_est = '".$buscar."'";*/
		$query1 = "SELECT pm.*, g.grado 
		FROM tbl_pre_matricula pm, grados g WHERE pm.id_grado = g.id AND pm.documento_est = '".$buscar."'";
	}
	else if($tipo == "CEL") {
		/*$query1 = "SELECT p.*, e.nombres, e.apellidos, g.grado 
		FROM tbl_pre_matricula p, tbl_empleados e, grados g 
		WHERE p.id_empleado = e.id AND p.id_grado = g.id 
		AND p.celular_a = '".$buscar."'";*/
		$query1 = "SELECT pm.*, g.grado 
		FROM tbl_pre_matricula pm WHERE pm.id_grado = g.id AND pm.celular_a = '".$buscar."'";
	}
	//echo "<br>query1: ".$query1;
	$exe_query1 = mysqli_query($conexion, $query1);
	while ($fila1 = mysqli_fetch_array($exe_query1)) {
		//$nombre_empleado = $fila1['nombres']." ".$fila1['apellidos'];
		
		$datos->id = $fila1['id'];
		$datos->nom_a = $fila1['nombre_a'];
		$datos->cel_a = $fila1['celular_a'];
		$datos->email_a = $fila1['email_a'];
		$datos->ciu_a = $fila1['ciudad_a'];
		$datos->nombres = $fila1['nombres_est'];
		$datos->apellidos = $fila1['apellidos_est'];
		$datos->documento = $fila1['documento_est'];
		$datos->extra = $fila1['actividad_extra'];
		$datos->idgrado = $fila1['id_grado'];
		$datos->grado = $fila1['grado'];
		$datos->idmedio = $fila1['id_medio'];
		$datos->interesado = $fila1['interesado'];
		$datos->obs = nl2br($fila1['observaciones']);
		//$datos->entrevista = $fila1['entrevista'];
		$datos->obs_ent = nl2br($fila1['observaciones_ent']);
		$datos->admitido = nl2br($fila1['admitido']);
		//$datos->eval = nl2br($fila1['eval']);
		//$datos->medio = $fila1['id_medio'];
		//$datos->interesado = $fila1['interesado'];
	}

	$i = 0;
	//Se cargan el máximo grado a validar
	//Se cargan el mínimo grado a validar
    $query_g = "SELECT v.*, g.grado FROM tbl_validaciones v, grados g 
    WHERE v.id_grado = g.id AND v.documento_est = ".$buscar." AND v.id_grado = (SELECT MIN(id_grado) id_grado FROM tbl_validaciones WHERE documento_est = '$buscar' AND resultado = 'NA')";
    //echo $query_g;
    $exe_query_g = mysqli_query($conexion, $query_g);
	while ($rowg = mysqli_fetch_array($exe_query_g)) {
	    $fecha_val = $rowg['fecha_programacion'];
	    $registrado_para_validar = $rowg['documento_est'];
	    $valores = [$rowg['id_grado'],$rowg['grado']];
	    $grados_temp = array_combine($keys,$valores);
  		$grados_val[$i] = $grados_temp;
  		$i++;
	}
	$datos->grados_val = $grados_val;
	
	$i = 0;
	//Se cargan todos los grados a validar
    $query_g = "SELECT v.*, g.grado FROM tbl_validaciones v, grados g 
    WHERE v.id_grado = g.id AND v.documento_est = ".$buscar." ORDER BY v.id_grado";
    $exe_query_g = mysqli_query($conexion, $query_g);
	while ($rowg = mysqli_fetch_array($exe_query_g)) {
	    $valores = [$rowg['id_grado'],$rowg['grado']];
	    $grados_temp = array_combine($keys,$valores);
  		$grados_val1[$i] = $grados_temp;
  		$i++;
	}
	$datos->grados_val_total = $grados_val1;
	
	$datos->fecha_val = $fecha_val;
	if($registrado_para_validar == "") {
	    $datos->registrado_para_val = "NO";
	}
	else {
	    $datos->registrado_para_val = "SI";
	}
	
	//Se busca si ya tiene valoración que no tenga cierre
	$sql_val = "SELECT COUNT(1) ct FROM tbl_seg_psi_val WHERE n_documento = '".$buscar."' 
	AND id = (SELECT MIN(id) FROM tbl_seg_psi_val WHERE n_documento = '$buscar') 
	AND id NOT IN (SELECT id_valoracion FROM tbl_seg_psi_cierre)";
	//echo $sql_val;
	$exe_val = mysqli_query($conexion, $sql_val);
    while ($fila_val = mysqli_fetch_array($exe_val)) {
        $ct = $fila_val['ct'];
        $datos->ct_val = $fila_val['ct'];
	}
	
	//Se busca si ya tiene valoración anteriores cerradas
	$sql_val = "SELECT COUNT(1) ct FROM tbl_seg_psi_val WHERE n_documento = '".$buscar."' 
	AND id IN (SELECT id_valoracion FROM tbl_seg_psi_cierre)";
	//echo $sql_val;
	$exe_val = mysqli_query($conexion, $sql_val);
    while ($fila_val = mysqli_fetch_array($exe_val)) {
        //$ct = $fila_val['ct'];
        $datos->ct_val_ant = $fila_val['ct'];
	}
	
	//Se busca si fue reprogramado
	$ct_reprog = 0;
	$sql_reprog = "SELECT COUNT(1) ct FROM tbl_entrevistas WHERE documento_est = '$buscar'";
	$exe_reprog = mysqli_query($conexion, $sql_reprog);
    while ($fila_reprog = mysqli_fetch_array($exe_reprog)) {
        $ct_reprog = $fila_reprog['ct'];
	}
	if ($ct_reprog > 1) {
	    $datos->reprogramado = "SI";
	}
	else {
	    $datos->reprogramado = "NO";
	}
	
	//Se busca si ya tiene programda la evaluación de admisión
	$sql_eval_adm = "SELECT COUNT(1) ct FROM estudiantes_eval_admision WHERE n_documento = '$buscar' AND año = $fanio";
	$exe_eval_adm = mysqli_query($conexion, $sql_eval_adm);
    while ($fila_eval_adm = mysqli_fetch_array($exe_eval_adm)) {
        $ct_eval_adm = $fila_eval_adm['ct'];
	}
	$datos->eval_adm = $ct_eval_adm;
	
	//Se busca el motivo o situación socio-económica
	$sql_motivo = "SELECT situacion_se FROM estudiantes WHERE n_documento = '$buscar'";
	$exe_motivo = mysqli_query($conexion, $sql_motivo);
    while ($fila_motivo = mysqli_fetch_array($exe_motivo)) {
        $se = $fila_motivo['situacion_se'];
	}
	$datos->motivo = $se;
	
	//Si es antiguo se busca el último estado y grado
	$sql_ultimo_grado = "SELECT * FROM matricula WHERE idMatricula = $maxid";
	$exe_ultimo_grado = mysqli_query($conexion, $sql_ultimo_grado);
    while ($fila_ultimo_grado = mysqli_fetch_array($exe_ultimo_grado)) {
        $ultimo_estado = $fila_ultimo_grado['estado'];
		$ultima_matricula = $fila_ultimo_grado['n_matricula'];
	}
	$partes_matricula = explode("-", $ultima_matricula);
	$grado_matricula = substr($partes_matricula[2], 0, 1);
	
	//Se busca el último grado matrícula
	$sql_grado_matricula = "SELECT grado FROM grados WHERE id = $grado_matricula";
	$exe_grado_matricula = mysqli_query($conexion, $sql_grado_matricula);
    while ($fila_grado_matricula = mysqli_fetch_array($exe_grado_matricula)) {
        $ultimo_grado_matricula = $fila_grado_matricula['grado'];
	}
	$datos->ultimo_estado = $ultimo_estado;
	$datos->ultimo_grado = $ultimo_grado_matricula;
	$datos->ultimo_año = $partes_matricula[1];
	
	//Se busca el estado de la evaluacion
	$sql_estado_eval = "SELECT COUNT(1) ct, 'TOTAL PREGUNTAS' estado FROM `tbl_respuestas` WHERE identificacion = '$buscar'
	UNION ALL
	SELECT COUNT(1) ct, estado FROM `tbl_respuestas` WHERE identificacion = '$buscar'
	GROUP BY estado";
	$exe_estado_eval = mysqli_query($conexion, $sql_estado_eval);
	while ($row_estado_eval = mysqli_fetch_array($exe_estado_eval)) {
	    $valores = [$row_estado_eval['estado'],$row_estado_eval['ct']];
	    $eval_temp = array_combine($keys_eval,$valores);
  		$eval_val[$i] = $eval_temp;
  		$i++;
	}
	$datos->eval_val = $eval_val;
	
	//echo "<br>";
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>