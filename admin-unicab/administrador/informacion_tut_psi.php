<?php
	session_start();
	require "../php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/admin-unicab/administrador/informacion_tut_psi.php?acomp=4
	
	$acomp = $_REQUEST["acomp"];
	//echo $idgra;
	
	$cadena = "";
	
	if($acomp == 4) {
	    $query1 = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW', 'PS') AND id NOT IN (1, 30, 31) ORDER BY id";
	}
	else if($acomp == 6) {
	    $query1 = "SELECT * FROM tbl_empleados WHERE perfil IN ('SU', 'TU', 'TU_AW', 'ST_PU') ORDER BY id";
	}
	//echo $query1;
	
	$cadena = $cadena."<option value='0' selected>--- SELECCIONE ---</option>";
	
	$resultado = mysqli_query($conexion, $query1);
	while ($row = mysqli_fetch_array($resultado)) {
	    $nombre = $row['nombres']." ".$row['apellidos'];
		$cadena = $cadena."<option value='".$row['id']."'>".$nombre."</option>";
	}
	echo $cadena;
?>