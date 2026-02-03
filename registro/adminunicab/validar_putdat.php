<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	//$id = $_REQUEST["id"];
	$valor = str_replace("_"," ",strtoupper($_REQUEST["valor"]));
	$tabla = $_REQUEST['tabla'];
	$campo = $_REQUEST['campo'];
	//echo $id;
	//echo $cargo;
	
	//Se actuliza el calculo
	$query = "SELECT COUNT(1) ct FROM $tabla WHERE $campo = '$valor'";
	//echo $query;
	$resultado=$mysqli1->query($query);
	while($row = $resultado->fetch_assoc()) {
	    $ct = $row['ct'];
	}
	
	echo $ct;
	/*if($ct > 0) {
	    echo "<script>location.href='adm_tbl_param.php'</script>";
	}*/
?>