<?php
    $mysqli1 = new mysqli("localhost","superimpacto","V~,Xsdt+{8TR","admin_unicab");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Registro:"),mysqli_connect_error();
         exit();
    }
    
    $mysqli1->set_charset("utf8");
?>