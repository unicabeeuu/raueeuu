<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/docenteunicab/updreg/ct_preg_getdat.php?idgra=10&idpen=5
	
	$idgra = $_REQUEST['idgra'];
	$idpen = $_REQUEST['idpen'];
	$cadena = "";
	
	$cadena .= '<table border="1px" class="table" id="tblpreg"><thead>';
	$cadena .= '<tr class="GridViewScrollHeader">';
	$cadena .= '<td><b>TEMA</b></td>';
	$cadena .= '<td><b>CT MIN</b></td>';
	$cadena .= '<td><b>CT TOT</b></td></tr></thead><tbody>';
	
	/*$sql = "SELECT COUNT(1) ct, p.id_materia, p.id_tema, t.tema 
        FROM tbl_preguntas p, tbl_temas_preguntas t 
        WHERE p.id_tema = t.id 
        AND p.id_grado = $idgra AND p.id_materia = $idpen 
        GROUP BY id_materia, id_tema, t.tema";*/
    $sql = "SELECT COUNT(1) ct, IFNULL(p.id_materia, -1) id_materia, IFNULL(p.id_tema, -1) id_tema, t.tema, t.ct_preguntas 
        FROM tbl_preguntas p RIGHT JOIN tbl_temas_preguntas t 
        ON p.id_tema = t.id AND p.id_grado = t.id_grado AND p.id_materia = t.id_materia 
        WHERE t.id_grado = $idgra AND t.id_materia = $idpen 
        GROUP BY p.id_materia, p.id_tema, t.tema, t.ct_preguntas";
	
	$res=mysqli_query($conexion,$sql);
	
	$control = 0;

	while ($fila = mysqli_fetch_array($res)){
	    $ct = $fila['ct'];
	    $id_materia = $fila['id_materia'];
	    if($id_materia == -1) {
	        $ct = 0;
	    }
	    if($fila['ct_preguntas'] > $ct) {
	        $cadena .= '<tr class="blanco" style="color: red;">';
	        $control++;
	    }
	    else {
	        $cadena .= '<tr class="blanco">';
	    }
	    
    	$cadena .= '<td><b>'.$fila['tema'].'</b></td>';
    	$cadena .= '<td><b>'.$fila['ct_preguntas'].'</b></td>';
    	$cadena .= '<td><b>'.$ct.'</b></td></tr>';
	}
	$cadena .= '</tbody></table>';
	if($control > 0) {
	    $cadena .= '<label style="color: red;">NOTA: La cantidad total debe ser igual o mayor a la cantidad mínima.</label>';
	}
	
	echo $cadena;
?>