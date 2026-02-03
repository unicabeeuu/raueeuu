<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	$param = $_POST["param"];
	
	$query = "SELECT v1, 'Valor 1 (v1)' Opcion FROM `tbl_parametros` WHERE id = '$param' AND v1 IS NOT NULL 
		UNION ALL 
		SELECT v2, 'Valor 2 (v2)' FROM `tbl_parametros` WHERE id = '$param' AND v2 IS NOT NULL 
		UNION ALL 
		SELECT t1, 'Texto 1 (t1)' FROM `tbl_parametros` WHERE id = '$param' AND t1 IS NOT NULL 
		UNION ALL 
		SELECT t2, 'Texto 2 (t2)' FROM `tbl_parametros` WHERE id = '$param' AND t2 IS NOT NULL 
		UNION ALL 
		SELECT f1, 'Fecha 1 (f1)' FROM `tbl_parametros` WHERE id = '$param' AND f1 IS NOT NULL 
		UNION ALL 
		SELECT f2, 'Fecha 2 (f2)' FROM `tbl_parametros` WHERE id = '$param' AND f2 IS NOT NULL";
	$cadena = $cadena."<option value='NA'>Seleccione opción</option>";
	$resultado=$mysqli1->query($query);
	while($row = $resultado->fetch_assoc()) {
		$cadena = $cadena."<option value='".$row['v1']."'>".$row['Opcion']."</option>";
	}
	echo $cadena;
?>