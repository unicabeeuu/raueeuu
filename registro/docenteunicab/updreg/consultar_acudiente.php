<?php
    session_start();
	//Genera botón de ver registros a procesar
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idest = $_REQUEST['idest'];
	
	$datos = new stdClass();
	$configurados = array();
	$cadena = "";
	
	$query1 = "SELECT * FROM estudiantes WHERE id = $idest";
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	//$sel = $mysqli1->affected_rows;
	
	while($row = $resultado->fetch_assoc()){
	    /*$nombre = $row['nombre'];
	    $id = $row['id'];*/
	    $cadena = $cadena.$row['acudiente_1']."|".$row['telefono_acudiente_1']."|".$row['acudiente_2']."|".$row['telefono_acudiente_2'];
		
	}
	echo $cadena;
	
	$datos->configurados = $configurados;
	
	//echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>