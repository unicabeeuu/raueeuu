<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/pregunta_upddat_html5.php?idgra=19&idpen=0&idtp=2&idtema=348&preg=¿CUAL_ES_EL_RESULTADO_DE:_7_+_3/4?._EXPRESE_EL_RESULTADO_EN_FRACCIONES.&r1ok=31/4&retro=REFORZAR_HTML5.$idpreg=1062
	
	$idgra = $_REQUEST['idgra'];
	$idpen = $_REQUEST['idpen'];
	$idtp = $_REQUEST['idtp'];
	$idtema = $_REQUEST['idtema'];
	$preg = nl2br(str_replace("_", " ", $_REQUEST['preg']));
	$preg = nl2br(str_replace("|", "+", $preg));
	$r1ok = str_replace("_", " ", $_REQUEST['r1ok']);
	$retro = str_replace("_", " ", $_REQUEST['retro']);
	$idpreg = $_REQUEST['idpreg'];
	//echo $preg;
	
	$soporte_subido = "../../images/preguntas/html5/";
	
	if ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpg") {
	    $soporte_subido = $soporte_subido . basename($_FILES['file']['name']);
	
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../images/preguntas/html5/".$_FILES['file']['name'])) {
            //more code here...
            echo "imagen ok";
        } else {
            echo "imagen error";
        }
    }
	echo $soporte_subido;
	
	if ($idtp == 2) {
	    if($soporte_subido == "../../images/preguntas/html5/") {
        	$sql_update = "UPDATE tbl_preguntas SET id_tema = $idtema, pregunta = '$preg', r1ok = '$r1ok', retroalimentacion = '$retro' 
        	WHERE id = $idpreg";
	    }
	    else {
	        $sql_update = "UPDATE tbl_preguntas SET id_tema = $idtema, pregunta = '$preg', r1ok = '$r1ok', retroalimentacion = '$retro', imagen = '$soporte_subido' 
        	WHERE id = $idpreg";
	    }
	}
	echo "<br>".$sql_update;
	$res_update=mysqli_query($conexion,$sql_update);
	
	//Se borran los saltos de línea
	$sql_upd = "UPDATE tbl_preguntas SET pregunta = replace(pregunta, '<br /><br />', ' ') WHERE id = $idpreg";
	$exe_upd = mysqli_query($conexion,$sql_upd);
	$sql_upd1 = "UPDATE tbl_preguntas SET pregunta = replace(pregunta, '\n', '') WHERE id = $idpreg";
	$exe_upd1 = mysqli_query($conexion,$sql_upd1);
	$sql_upd2 = "UPDATE tbl_preguntas SET pregunta = replace(pregunta, '<br />', ' ') WHERE id = $idpreg";
	$exe_upd2 = mysqli_query($conexion,$sql_upd2);
?>