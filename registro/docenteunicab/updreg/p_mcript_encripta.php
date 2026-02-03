<?php 
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");		$datoAEncriptar = $_REQUEST['d'];	$dato_encriptado = $gen_enc($datoAEncriptar);	echo $dato_encriptado;		
?>