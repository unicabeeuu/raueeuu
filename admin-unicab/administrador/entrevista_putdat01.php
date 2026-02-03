<?php
    session_start();
	require "../php/conexion.php";
	//https://unicab.org/admin-unicab/administrador/entrevista_putdat01.php?psicologo=5
	//Esta página se hizo de pruebas y está implementada en ningún lado
	
	$id_psicologo = $_REQUEST['psicologo'];
	
	$datos = new stdClass();
	$eventos_finales = array();
	$keys = ['title','start'];
    $i = 0;
	
	$sql = "SELECT * FROM tbl_entrevistas WHERE id_psicologo = $id_psicologo";
	//echo $sql;
	$exe = mysqli_query($conexion, $sql);
    while ($fila = mysqli_fetch_array($exe)) {
		//$datos->title = $fila['nombre_est'];
		//$datos->start_f = $fila['fecha'];
		//$datos->start_h = $fila['hora'];
		//$datos->start = $fila['fecha']."T".$fila['hora'].":00:00";
		$valores = [$fila['nombre_est'],$fila['fecha']."T".$fila['hora'].":00:00"];
      	$evento = array_combine($keys,$valores);
      	$eventos_finales[$i] = $evento;
      	$i++;
    } 		
    $datos->eventos = $eventos_finales;
    
    //echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    echo json_encode($eventos_finales, JSON_UNESCAPED_UNICODE);
    $eventos_psi = json_encode($eventos_finales, JSON_UNESCAPED_UNICODE);
    echo "<script>location.href='entrevista_putdat.php?psicologo=".$id_psicologo."&ev=".$eventos_psi."';</script>";

?>