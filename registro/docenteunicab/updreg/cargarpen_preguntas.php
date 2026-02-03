<?php
	session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	//echo $idgra;
	
	$cadena = "";
	
	$query1 = "SELECT gm.id_materia, m.pensamiento 
	    FROM grado_materia gm, materias m 
	    WHERE gm.id_materia = m.id AND gm.id_grado = $idgra 
	    ORDER BY m.pensamiento";
	
	$cadena = $cadena."<option value='NA' selected>Seleccione pensamiento</option>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
		$cadena = $cadena."<option value='".$row['id_materia']."'>".$row['pensamiento']."</option>";
	}
	echo $cadena;
?>