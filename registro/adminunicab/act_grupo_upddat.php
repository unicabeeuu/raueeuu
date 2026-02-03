<?php
	//Genera el select de los grados
	include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$id = $_REQUEST["idest"];
	$grupo = $_REQUEST["grupo"];
	
	$query1 = "UPDATE matricula SET grupo = '$grupo' WHERE id_estudiante = $id AND n_matricula like '%2025%'";
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	
	echo "Registro actualizado";
?>