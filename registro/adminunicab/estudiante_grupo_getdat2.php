<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/estudiante_grupo_getdat2.php?id_est=1176&grupo=A
	
	$id_est = $_REQUEST['id_est'];
	$grupo = $_REQUEST['grupo'];
	
	$datos = new stdClass();

    /*$query = "SELECT e.id, e.nombres, e.apellidos, e.ciudad, g.grado, m.grupo 
    FROM estudiantes e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = 2021 
    AND e.id = $id_est AND m.grupo = '$grupo'";*/
    
    $query = "SELECT e.id, e.nombres, e.apellidos, e.ciudad, g.grado, m.grupo 
    FROM estudiantes e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND m.estado = 'activo' AND m.n_matricula like '%2025%' 
    AND e.id = $id_est AND m.grupo = '$grupo'";
    //echo $query;
    
    $resultado1 = $mysqli1->query($query);
    while($row = $resultado1->fetch_assoc()) {
        $datos->id = $row['id'];
        $datos->nombres = $row['nombres'];
        $datos->apellidos = $row['apellidos'];
        $datos->grado = $row['grado'];
    }
    
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
?>