<?php
	session_start();
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	$idmat = $_REQUEST["idmat"];
	//echo $idgra;
	
	$cadena = "";
	
	/*$query1 = "SELECT * FROM tbl_temas_preguntas WHERE id IN (1,2)  
	    UNION ALL 
	    SELECT * FROM tbl_temas_preguntas WHERE id_grado = $idgra AND id_materia = $idmat 
	    ORDER BY tema";*/
	$query1 = "SELECT * FROM tbl_temas_preguntas WHERE id IN (1)  
	    UNION ALL 
	    SELECT * FROM tbl_temas_preguntas WHERE id_materia = $idmat AND id_grado = $idgra 
	    ORDER BY tema";
	
	//$cadena = $cadena."<option value='NA'>Seleccione pensamiento</option>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
		$cadena = $cadena."<option value='".$row['id']."'>".$row['tema']."</option>";
	}
	echo $cadena;
?>