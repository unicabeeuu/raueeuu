<?php
    $mysqli1 = new mysqli("localhost","root","","admin_unieeuu");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Registro:"),mysqli_connect_error();
         exit();
    }
    
    $mysqli1->set_charset("utf8");
?>