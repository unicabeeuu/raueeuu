<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/temapreg_putdat.php?ntema=OPERACIONES_CON_FRACCIONES&idgra=10&idpen=5
	
	$tema = str_replace("_", " ", $_REQUEST['ntema']);
	$idgra = $_REQUEST['idgra'];
	$idpen = $_REQUEST['idpen'];
	
	$sql_insert = "INSERT INTO tbl_temas_preguntas (id_grado, id_materia, tema) 
	VALUES ($idgra, $idpen, '$tema')";
	
	$res_insert=mysqli_query($conexion,$sql_insert);

	//Se consulta el id del nuevo tema
	$sql = "SELECT * FROM tbl_temas_preguntas WHERE tema = '$tema'";
	
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
	    $idtema = $fila['id'];
	}
	
	echo $idtema;
?>