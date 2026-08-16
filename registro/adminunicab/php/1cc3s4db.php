<?php
    $mysqli1 = new mysqli("localhost","root","Root1234*","admin_unieeuu");
    //$mysqli1 = new mysqli("localhost","u512774881_s5p3r5s5_Un325","s5p3r_5Ni2255*","u512774881_admin_unieeuu");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Registro:"),mysqli_connect_error();
         exit();
    }
    
    $mysqli1->set_charset("utf8");
?>