<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/domain_put_pal_upddat_i.php?pal=prueba
	
	$pal = $_REQUEST['pal'];
	$idpal = $_REQUEST['idpal'];
	//echo $pal;
	
	$soporte_subido = "../../../assets/img/domaini/";
	
	if ($_FILES["file"]["type"] == "image/jpeg" || $_FILES["file"]["type"] == "image/png" || $_FILES["file"]["type"] == "image/jpg") {
	    $soporte_subido = $soporte_subido . basename($_FILES['file']['name']);
	
        if (move_uploaded_file($_FILES["file"]["tmp_name"], "../../../assets/img/domaini/".$_FILES['file']['name'])) {
            //more code here...
            //echo "imagen ok";
        } else {
            //echo "imagen error";
        }
    }
	echo $soporte_subido;
	
	if($soporte_subido == "../../../assets/img/domaini/") {
		$sql_update = "UPDATE tbl_metodo_domain_i SET palabra = '$pal' WHERE id = $idpal";
	}
	else {
		$sql_update = "UPDATE tbl_metodo_domain_i SET palabra = '$pal', imagen = '$soporte_subido' WHERE id = $idpal";
	}		
	
	echo "<br>".$sql_update;
	$res_update=mysqli_query($conexion,$sql_update);
	
?>