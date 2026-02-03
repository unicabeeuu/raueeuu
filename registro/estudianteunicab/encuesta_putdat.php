<?php
    include "../adminunicab/php/conexion.php";
    header("Cache-Control: no-store");
	//https://unicab.org/registro_inicial_putdat.php?register_nombrea=yenny&register_emaila=ghernandof@gmail.com&register_telefonoa=3006510212&register_ciudada=pesca&register_documentoe=46379709
    
    $idGrado = $_REQUEST['idGrado'];
	$documento = $_REQUEST['documento'];
	$idEncuesta = $_REQUEST['idEncuesta'];
    $encuesta1p1 = $_REQUEST['encuesta1p1'];
    $encuesta1p2 = $_REQUEST['encuesta1p2'];
	$encuesta1p3 = $_REQUEST['encuesta1p3'];
	$encuesta1p4 = $_REQUEST['encuesta1p4'];
	$encuesta1p5 = $_REQUEST['encuesta1p5'];
	$encuesta1p6 = $_REQUEST['encuesta1p6'];
	$encuesta1p7 = $_REQUEST['encuesta1p7'];
	$encuesta1p8 = $_REQUEST['encuesta1p8'];
	$encuesta1p9 = $_REQUEST['encuesta1p9'];
	$encuesta1p10 = $_REQUEST['encuesta1p10'];
	$encuesta1p11 = $_REQUEST['encuesta1p11'];
	$encuesta1p12 = $_REQUEST['encuesta1p12'];
	$encuesta1p13 = str_replace("_", " ", $_REQUEST['encuesta1p13']);
	$encuesta1p14 = str_replace("_", " ", $_REQUEST['encuesta1p14']);
	$encuesta1p15 = str_replace("_", " ", $_REQUEST['encuesta1p15']);
	$encuesta1p16 = str_replace("_", " ", $_REQUEST['encuesta1p16']);
	$encuesta1p17 = str_replace("_", " ", $_REQUEST['encuesta1p17']);
	$encuesta1p18 = str_replace("_", " ", $_REQUEST['encuesta1p18']);
	$encuesta1p19 = str_replace("_", " ", $_REQUEST['encuesta1p19']);
	$encuesta1p20 = str_replace("_", " ", $_REQUEST['encuesta1p20']);
	$encuesta1p21 = str_replace("_", " ", $_REQUEST['encuesta1p21']);
	//echo $idGrado;
    
    date_default_timezone_set('America/Bogota');
    $dia = date("d");
    $mes = date("m");
    $mesLetra = date("M");
    $fanio = date("Y");
    $espaniol="";
    //echo $fanio;
    $fecha2 = $fanio."/".$mes."/". $dia;
	
	//Se hacen los inserts
	$sql_ins1 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 1, $idGrado, '$documento', '$encuesta1p1', $fanio)";
	//echo "<br>".$sql_ins1;
	$exe_ins1 = mysqli_query($conexion,$sql_ins1);
	
	$sql_ins2 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 2, $idGrado, '$documento', '$encuesta1p2', $fanio)";
	//echo "<br>".$sql_ins2;
	$exe_ins2 = mysqli_query($conexion,$sql_ins2);
	
	$sql_ins3 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 3, $idGrado, '$documento', '$encuesta1p3', $fanio)";
	//echo "<br>".$sql_ins3;
	$exe_ins3 = mysqli_query($conexion,$sql_ins3);
	
	$sql_ins4 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 4, $idGrado, '$documento', '$encuesta1p4', $fanio)";
	//echo "<br>".$sql_ins4;
	$exe_ins4 = mysqli_query($conexion,$sql_ins4);
	
	$sql_ins5 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 5, $idGrado, '$documento', '$encuesta1p5', $fanio)";
	//echo "<br>".$sql_ins5;
	$exe_ins5 = mysqli_query($conexion,$sql_ins5);
	
	$sql_ins6 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 6, $idGrado, '$documento', '$encuesta1p6', $fanio)";
	//echo "<br>".$sql_ins6;
	$exe_ins6 = mysqli_query($conexion,$sql_ins6);
	
	$sql_ins7 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 7, $idGrado, '$documento', '$encuesta1p7', $fanio)";
	//echo "<br>".$sql_ins7;
	$exe_ins7 = mysqli_query($conexion,$sql_ins7);
	
	$sql_ins8 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 8, $idGrado, '$documento', '$encuesta1p8', $fanio)";
	//echo "<br>".$sql_ins8;
	$exe_ins8 = mysqli_query($conexion,$sql_ins8);
	
	$sql_ins9 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 9, $idGrado, '$documento', '$encuesta1p9', $fanio)";
	//echo "<br>".$sql_ins9;
	$exe_ins9 = mysqli_query($conexion,$sql_ins9);
	
	$sql_ins10 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 10, $idGrado, '$documento', '$encuesta1p10', $fanio)";
	//echo "<br>".$sql_ins10;
	$exe_ins10 = mysqli_query($conexion,$sql_ins10);
	
	$sql_ins11 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 11, $idGrado, '$documento', '$encuesta1p11', $fanio)";
	//echo "<br>".$sql_ins11;
	$exe_ins11 = mysqli_query($conexion,$sql_ins11);
	
	$sql_ins12 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 12, $idGrado, '$documento', '$encuesta1p12', $fanio)";
	//echo "<br>".$sql_ins12;
	$exe_ins12 = mysqli_query($conexion,$sql_ins12);
	
	$sql_ins13 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 13, $idGrado, '$documento', '$encuesta1p13', $fanio)";
	//echo "<br>".$sql_ins13;
	$exe_ins13 = mysqli_query($conexion,$sql_ins13);
	
	$sql_ins14 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 14, $idGrado, '$documento', '$encuesta1p14', $fanio)";
	//echo "<br>".$sql_ins14;
	$exe_ins14 = mysqli_query($conexion,$sql_ins14);
	
	$sql_ins15 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 15, $idGrado, '$documento', '$encuesta1p15', $fanio)";
	//echo "<br>".$sql_ins15;
	$exe_ins15 = mysqli_query($conexion,$sql_ins15);
	
	$sql_ins16 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 16, $idGrado, '$documento', '$encuesta1p16', $fanio)";
	//echo "<br>".$sql_ins16;
	$exe_ins16 = mysqli_query($conexion,$sql_ins16);
	
	$sql_ins17 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 17, $idGrado, '$documento', '$encuesta1p17', $fanio)";
	//echo "<br>".$sql_ins17;
	$exe_ins17 = mysqli_query($conexion,$sql_ins17);
	
	$sql_ins18 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 18, $idGrado, '$documento', '$encuesta1p18', $fanio)";
	//echo "<br>".$sql_ins18;
	$exe_ins18 = mysqli_query($conexion,$sql_ins18);
	
	$sql_ins19 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 19, $idGrado, '$documento', '$encuesta1p19', $fanio)";
	//echo "<br>".$sql_ins19;
	$exe_ins19 = mysqli_query($conexion,$sql_ins19);
	
	$sql_ins20 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 20, $idGrado, '$documento', '$encuesta1p20', $fanio)";
	//echo "<br>".$sql_ins20;
	$exe_ins20 = mysqli_query($conexion,$sql_ins20);
	
	$sql_ins21 = "INSERT INTO tbl_encuestas_resultados (id_encuesta, id_pregunta, id_grado, n_documento, resultado, año) 
	VALUES ($idEncuesta, 21, $idGrado, '$documento', '$encuesta1p21', $fanio)";
	//echo "<br>".$sql_ins21;
	$exe_ins21 = mysqli_query($conexion,$sql_ins21);
	
	$datos = new stdClass();
	$datos->insert = "OK";
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
	//Se direcciona
	//header('Location: certificado_notas.php');
    	
?>

