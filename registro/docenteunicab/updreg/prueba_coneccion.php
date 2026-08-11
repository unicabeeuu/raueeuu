<?php
	$mysqli = new mysqli("51.222.47.67","thriveusaconsulta","kR7Q4&jkuy3U1wu","campusthriveusadb");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Moodle:"),mysqli_connect_error();
         exit();
    }
	else {
		echo utf8_encode("Conect with Moodle:");
         exit();
	}

?>