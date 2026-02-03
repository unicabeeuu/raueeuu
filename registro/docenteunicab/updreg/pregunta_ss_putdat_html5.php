<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/pregunta_putdat.php?idgra=7&idpen=5&idtp=2&idtema=6&preg=Â¿CUAL_ES_EL_RESULTADO_DE:_7_+_3/4?._EXPRESE_EL_RESULTADO_EN_FRACCIONES.&r1ok=31/4&retro=DEBES_REFORZAR_OPERACIONES_CON_FRACCIONES.
	
	$idgra = $_REQUEST['idgra'];
	$idpen = $_REQUEST['idpen'];
	$idtp = $_REQUEST['idtp'];
	$idtema = $_REQUEST['idtema'];
	$preg = nl2br(str_replace("_", " ", $_REQUEST['preg']));
	$preg = nl2br(str_replace("|", "+", $preg));
	$r1ok = str_replace("_", " ", $_REQUEST['r1ok']);
	$r1no = str_replace("_", " ", $_REQUEST['r1no']);
	$r2no = str_replace("_", " ", $_REQUEST['r2no']);
	$r3no = str_replace("_", " ", $_REQUEST['r3no']);
	$retro = str_replace("_", " ", $_REQUEST['retro']);
	//echo $preg;
	
	$soporte_subido = "../../images/preguntas/html5/";
	
	if ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpg") {
	    $soporte_subido = $soporte_subido . basename($_FILES['file']['name']);
	
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../images/preguntas/html5/".$_FILES['file']['name'])) {
            //more code here...
            //echo "imagen ok";
        } else {
            //echo "imagen error";
        }
    }
	//echo $soporte_subido;
	
	if ($idtp == 3) {
	    if($soporte_subido == "../../images/preguntas/html5/") {
        	$sql_insert = "INSERT INTO tbl_preguntas (id_grado, id_materia, id_tipo_pregunta, id_tema, pregunta, r1ok, r2ok, r3ok, r1no, r2no, r3no, r4no, retroalimentacion, imagen) 
        	VALUES ($idgra, $idpen, $idtp, $idtema, '$preg', '$r1ok', 'NA', 'NA', '$r1no', '$r2no', '$r3no', 'NA', '$retro', 'NA')";
	    }
	    else {
	        $sql_insert = "INSERT INTO tbl_preguntas (id_grado, id_materia, id_tipo_pregunta, id_tema, pregunta, r1ok, r2ok, r3ok, r1no, r2no, r3no, r4no, retroalimentacion, imagen) 
        	VALUES ($idgra, $idpen, $idtp, $idtema, '$preg', '$r1ok', 'NA', 'NA', '$r1no', '$r2no', '$r3no', 'NA', '$retro', '$soporte_subido')";
	    }
	}
	//echo "<br>".$sql_insert;
	$res_insert=mysqli_query($conexion,$sql_insert);
	
	//Se consulta el id de la pregunta
	$sql_idpreg = "SELECT id FROM tbl_preguntas WHERE pregunta = '$preg'";
	$exe_idpreg = mysqli_query($conexion,$sql_idpreg);

	while ($fila = mysqli_fetch_array($exe_idpreg)){
	    $idpreg = $fila['id'];
	}
	echo $idpreg;
	
	//Se borran los saltos de línea
	$sql_upd = "UPDATE tbl_preguntas SET pregunta = replace(pregunta, '<br /><br />', ' ') WHERE id = $idpreg";
	$exe_upd = mysqli_query($conexion,$sql_upd);
	$sql_upd1 = "UPDATE tbl_preguntas SET pregunta = replace(pregunta, '\n', '') WHERE id = $idpreg";
	$exe_upd1 = mysqli_query($conexion,$sql_upd1);
	$sql_upd2 = "UPDATE tbl_preguntas SET pregunta = replace(pregunta, '<br />', ' ') WHERE id = $idpreg";
	$exe_upd2 = mysqli_query($conexion,$sql_upd2);
?>