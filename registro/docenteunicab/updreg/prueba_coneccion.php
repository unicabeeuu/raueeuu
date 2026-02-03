<?php
	// COMENTARIOS //
    //   $mysqli1 = new mysqli("localhost","u756063299_s5p3r5s51r34","5n3c1b*V3r","u756063299_admin_unicab"); PRUEBA
    //	$mysqli = new mysqli("51.79.19.3","czWserunicab","Yknsd938u9h-pz7xrvw4","i517252_mood1"); FUNCIONANDO
    //	$mysqli = new mysqli("unicab.edu-labs.co","czWserunicab","Yknsd938u9h-pz7xrvw4","i517252_mood1"); ORIGINAL 

	//$mysqli = new mysqli("51.79.19.3","czWserunicab","5*ñ0rbM/r2AG5ywG*ñ25Z8SYkBj2z2-It/","i517252_mood1");
	//$mysqli = new mysqli("158.69.226.213","usrextunicab","Cajkl2s1++cPue-18","i517252_mood1");
	$mysqli = new mysqli("51.161.12.236","unicabconsulta",";NYwP1LF*1W9dpu5x-f2","unicabdb");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Moodle:"),mysqli_connect_error();
         exit();
    }
	else {
		echo utf8_encode("Conectado con Moodle:");
         exit();
	}

?>