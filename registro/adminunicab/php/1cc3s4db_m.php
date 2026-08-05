<?php
	//$mysqli = new mysqli("unicab.edu-labs.co","czWserunicab","Yknsd938u9h-pz7xrvw4","i517252_mood1");
	//$mysqli = new mysqli("51.161.12.236","unicabconsulta",";NYwP1LF*1W9dpu5x-f2","unicabdb");
    $mysqli = new mysqli("51.222.47.67","thriveusaconsulta","kR7Q4&jkuy3U1wu","campusthriveusadb");
	if(mysqli_connect_error()) {
         echo utf8_encode("Error al conectar con Moodle:"),mysqli_connect_error();
         exit();
    }

?>