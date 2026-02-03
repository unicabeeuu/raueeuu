<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/pregunta_upddat.php?idgra=7&idpen=5&idtp=2&idtema=6&preg=Â¿CUAL_ES_EL_RESULTADO_DE:_7_+_3/4?._EXPRESE_EL_RESULTADO_EN_FRACCIONES.&r1ok=31/4&retro=DEBES_REFORZAR_OPERACIONES_CON_FRACCIONES.
	
	$idgra = $_REQUEST['idgra'];
	$idpen = $_REQUEST['idpen'];
	$idtp = $_REQUEST['idtp'];
	$idtema = $_REQUEST['idtema'];
	$preg = nl2br(str_replace("_", " ", $_REQUEST['preg']));
	$preg = nl2br(str_replace("|", "+", $preg));
	$r1ok = str_replace("_", " ", $_REQUEST['r1ok']);
	$r1no = str_replace("_", " ", $_REQUEST['r1no']);
	$r2no = str_replace("_", " ", $_REQUEST['r2no']);
	$r2ok = str_replace("_", " ", $_REQUEST['r2ok']);
	$retro = str_replace("_", " ", $_REQUEST['retro']);
	$idpreg = $_REQUEST['idpreg'];
	//echo $preg;
	
	$soporte_subido = "../../images/preguntas/";
	
	if ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpg") {
	    $soporte_subido = $soporte_subido . basename($_FILES['file']['name']);
	
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../images/preguntas/".$_FILES['file']['name'])) {
            //more code here...
            echo "imagen ok";
        } else {
            echo "imagen error";
        }
    }
	echo $soporte_subido;
	
	if ($idtp == 4) {
	    if($soporte_subido == "../../images/preguntas/") {
        	$sql_update = "UPDATE tbl_preguntas SET id_tema = $idtema, pregunta = '$preg', r1ok = '$r1ok', retroalimentacion = '$retro',
        	r1no = '$r1no', r2no = '$r2no', r2ok = '$r2ok' 
        	WHERE id = $idpreg";
	    }
	    else {
	        $sql_update = "UPDATE tbl_preguntas SET id_tema = $idtema, pregunta = '$preg', r1ok = '$r1ok', retroalimentacion = '$retro', imagen = '$soporte_subido', 
        	r1no = '$r1no', r2no = '$r2no', r2ok = '$r2ok'
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