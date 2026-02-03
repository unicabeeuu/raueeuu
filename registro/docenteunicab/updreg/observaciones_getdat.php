<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idest = $_REQUEST['idest'];
	//echo $idest;
	
	$query = "SELECT * FROM tbl_estudiantes_param WHERE id_estudiante = $idest";
	//echo $query;
	
	$resultado=$mysqli1->query($query);
	while($row = $resultado->fetch_assoc()){
	    $obs = $row['observacion'];
	}
	
	//echo str_replace(" ","_",$obs);
	echo $obs;
?>