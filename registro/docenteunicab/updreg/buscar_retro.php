<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/buscar_retro.php?idtema=6
	
	$idtema = $_REQUEST['idtema'];
	
	$sql = "SELECT DISTINCT retroalimentacion FROM tbl_preguntas 
            WHERE id_tema = $idtema";
	
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
	    $retro = $fila['retroalimentacion'];
	}
	
	echo $retro;
	
	/*if($retro == "") {
	    echo "vacío";
	}*/
?>