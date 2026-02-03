<?php
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/buscar_img_domain.php?img=bus_1.png
	
	$img= $_REQUEST["img"];
	
	//$datos = new stdClass();
	$ct = 0;
	
	//Se hace la consulta
    $query0 = "SELECT COUNT(1) ct FROM tbl_metodo_domain WHERE imagen like '%$img%'";
    //echo $query0;
    $resultado0 = $mysqli1->query($query0);
    while($row0 = $resultado0->fetch_assoc()) {
	    //$datos->ct = $row0['ct'];
	    $ct = $row0['ct'];
	}
	
	//echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	echo $ct;
	
?>