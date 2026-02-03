<?php 
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");	
	$datoADesencriptar = $_REQUEST['de'];	$dato_desencriptado = $dev_enc($datoADesencriptar);	echo $dato_desencriptado;
?>