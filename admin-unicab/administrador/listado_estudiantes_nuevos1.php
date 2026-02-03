<?php 
	session_start();
	require "../php/conexion.php";
	//https://unicab.org/admin-unicab/administrador/listado_estudiantes_nuevos1.php
	
	$datos = new stdClass();
	$data = array();
	$campos = array();
	
	$sql_nuevos = "SELECT DISTINCT pm.nombres_est, pm.apellidos_est, pm.documento_est, pm.email_a, pm.celular_a, g.grado, 
	en.fecha, en.hora, IFNULL(ea.n_documento, '-') n_documento, e.situacion_se 
	FROM estudiantes e JOIN tbl_pre_matricula pm ON e.n_documento = pm.documento_est 
	LEFT JOIN estudiantes_eval_admision ea ON e.n_documento = ea.n_documento 
	LEFT JOIN tbl_entrevistas en ON e.n_documento = en.documento_est AND en.fecha > '2023-10-31'
	LEFT JOIN grados g ON pm.id_grado = g.id
	WHERE e.a_matricula = 2024";
	$exe_nuevos = mysqli_query($conexion,$sql_nuevos);
	while ($row = mysqli_fetch_array($exe_nuevos)) {
		$eval = '<a href="programar_eval_admision.php?documento='.$row['documento_est'].'" target="_blank" class="btn btn-info">Programar</a>';
		
		if ($row['n_documento'] == '-' && $row['grado'] != '') {
			$campos[] = $row['documento_est'];
			$campos[] = $row['nombres_est'];
			$campos[] = $row['apellidos_est'];
			$campos[] = $row['grado'];
			$campos[] = $eval;
			$campos[] = $row['fecha']." ".$row['hora'];
			$campos[] = $row['email_a'];
			$campos[] = $row['celular_a'];
			$campos[] = $row['documento_est'];
			$campos[] = $row['situacion_se'];
						
		}
		else {
			$campos[] = $row['documento_est'];
			$campos[] = $row['nombres_est'];
			$campos[] = $row['apellidos_est'];
			$campos[] = $row['grado'];
			$campos[] = $row['n_documento'];
			$campos[] = $row['fecha']." ".$row['hora'];
			$campos[] = $row['email_a'];
			$campos[] = $row['celular_a'];
			$campos[] = $row['documento_est'];
			$campos[] = $row['situacion_se'];
						
		}
		$data[] = $campos;
		unset($campos);
	}
	
	$datos->data = $data;
		
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>
