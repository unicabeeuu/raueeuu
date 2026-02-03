<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$id = $_REQUEST["id"];
	
	$datos = new stdClass();
	$calif_finales = array();
	$keys = ['id_mat','per1','per2','per3','per4'];
	$i = 0;
	
	//Se hace la consulta
    $query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, 
        round((case when n.id_periodo = 1 then nota end),1) as per1, 
        round((case when n.id_periodo = 2 then nota end),1) as per2, 
        round((case when n.id_periodo = 3 then nota end),1) as per3, 
        round((case when n.id_periodo = 4 then nota end),1) as per4 
        FROM notas n, estudiantes e 
        WHERE n.id_estudiante = e.id AND n.id_estudiante = $id";
    $resultado0 = $mysqli1->query($query0);
    while($row0 = $resultado0->fetch_assoc()) {
	    $datos->id_est = $row0['id_estudiante'];
	    $datos->nombre = $row0['nombre'];
	    $datos->id_grado = $row0['id_grado'];
	    
	    $valores = [$row0['id_materia'],$row0['per1'],$row0['per2'],$row0['per3'],$row0['per4']];
  		$calif = array_combine($keys,$valores);
  		$calif_finales[$i] = $calif;
  		$i++;
	}
	$datos->calificaciones = $calif_finales;
	
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>