<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	$pen = $_POST["pen"];
	
	$query1 = "SELECT grados FROM querys_ra WHERE pensamiento = '$pen' AND id > 25 ORDER BY 1";
	$cadena = $cadena."<option value='NA'>Seleccione grado</option>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
		$cadena = $cadena."<option value='".$row['grados']."'>".$row['grados']."</option>";
	}
	echo $cadena;
?>