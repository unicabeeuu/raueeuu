<?php
    // $mysqli1 = new mysqli("localhost","u756063299_s5p3r5s51r34","5n3c1b*V3r","u756063299_admin_unicab"); original
    // venm $mysqli = new mysqli("51.79.19.3","czWserunicab","Yknsd938u9h-pz7xrvw4","i517252_mood1");
    
    $mysqli1 = new mysqli("localhost","u756063299_s5p3r5s51r34","5n3c1b*V3r","u756063299_admin_unicab");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Registro:"),mysqli_connect_error();
         exit();
    }
    
    $mysqli1->set_charset("utf8");
?>