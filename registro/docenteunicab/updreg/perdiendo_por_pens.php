<?php
    session_start();
	//Genera botón de ver registros a procesar
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	////https://unicab.org/registro/docenteunicab/updreg/perdiendo_por_pens.php?idgra=10
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	//$idest = $_REQUEST["idest"];
	$idgra = $_REQUEST["idgra"];
	//$idest = 512;
	//$idgra = 18;
	
	if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
	    $lbls = array("BIOTEICO", "HUMANÍSTICO", "HUMANÍSTICO 1", "NUMÉRICO", "NUMÉRICO F", "SOCIAL", "TECNOLÓGICO");
	}
	else {
	    $lbls = array("BIOTEICO", "HUMANÍSTICO", "HUMANÍSTICO 1", "NUMÉRICO", "SOCIAL", "TECNOLÓGICO");
	}
	$notas = new stdClass();
	//$lbls = array();
	$p1 = array();
	$p2 = array();
	$p3 = array();
	$p4 = array();
	
	$query2 = "SELECT COUNT(1) ct, 
        case m.materia when 'FÍSICA' then 'NUMÉRICO F' else m.pensamiento end as pensamiento 
        FROM 
        (SELECT SUM(nota)/1, id_estudiante, id_materia 
        FROM `notas` 
        WHERE id_grado = $idgra AND id_periodo IN (1) 
        GROUP BY id_estudiante, id_materia HAVING SUM(nota)/1 <= 2.9) a, materias m 
        WHERE a.id_materia = m.id
        GROUP BY pensamiento";
	$resultado2=$mysqli1->query($query2);
	while($row2 = $resultado2->fetch_assoc()){
	    //$lbls[] = $row2['pensamiento'];
		//$p1[] = $row2['nota'];
		if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
		    if($row2['pensamiento'] == "BIOETICO") {
    	       $p1[0] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO") {
    	       $p1[1] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p1[2] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "NUMÉRICO") {
    	       $p1[3] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "NUMÉRICO F") {
    	       $p1[4] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "SOCIAL") {
    	       $p1[5] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "TECNOLÓGICO") {
    	       $p1[6] = $row2['ct']; 
    	    }
    	    else {
    	        $p1[] = "0.0";
    	    }
		}
		else {
		    if($row2['pensamiento'] == "BIOETICO") {
    	       $p1[0] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO") {
    	       $p1[1] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p1[2] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "NUMÉRICO") {
    	       $p1[3] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "SOCIAL") {
    	       $p1[4] = $row2['ct']; 
    	    }
    	    else if($row2['pensamiento'] == "TECNOLÓGICO") {
    	       $p1[5] = $row2['ct']; 
    	    }
    	    else {
    	        $p1[] = "0.0";
    	    }
		}
	}
	//echo json_encode($p1);;
	$c = count($lbls);
	//echo $c;
	$notas->lbls = $lbls;
	$notas->p1 = $p1;
	$query3 = "SELECT COUNT(1) ct, 
        case m.materia when 'FÍSICA' then 'NUMÉRICO F' else m.pensamiento end as pensamiento 
        FROM 
        (SELECT SUM(nota)/2, id_estudiante, id_materia 
        FROM `notas` 
        WHERE id_grado = $idgra AND id_periodo IN (1,2) 
        GROUP BY id_estudiante, id_materia HAVING SUM(nota)/2 <= 2.9) a, materias m 
        WHERE a.id_materia = m.id
        GROUP BY pensamiento";
	$resultado3=$mysqli1->query($query3);
	while($row3 = $resultado3->fetch_assoc()){
	    if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
		    if($row3['pensamiento'] == "BIOETICO") {
    	       $p2[0] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO") {
    	       $p2[1] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p2[2] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "NUMÉRICO") {
    	       $p2[3] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "NUMÉRICO F") {
    	       $p2[4] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "SOCIAL") {
    	       $p2[5] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "TECNOLÓGICO") {
    	       $p2[6] = $row3['ct']; 
    	    }
    	    else {
    	        $p2[] = "0.0";
    	    }
		}
		else {
		    if($row3['pensamiento'] == "BIOETICO") {
    	       $p2[0] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO") {
    	       $p2[1] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p2[2] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "NUMÉRICO") {
    	       $p2[3] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "SOCIAL") {
    	       $p2[4] = $row3['ct']; 
    	    }
    	    else if($row3['pensamiento'] == "TECNOLÓGICO") {
    	       $p2[5] = $row3['ct']; 
    	    }
    	    else {
    	        $p2[] = "0.0";
    	    }
		}
		//$p2[] = $row3['nota'];
	}
	//echo json_encode($p2);;
	$notas->p2 = $p2;
	$query4 = "SELECT COUNT(1) ct, 
        case m.materia when 'FÍSICA' then 'NUMÉRICO F' else m.pensamiento end as pensamiento 
        FROM 
        (SELECT SUM(nota)/3, id_estudiante, id_materia 
        FROM `notas` 
        WHERE id_grado = $idgra AND id_periodo IN (1,2,3) 
        GROUP BY id_estudiante, id_materia HAVING SUM(nota)/3 <= 2.9) a, materias m 
        WHERE a.id_materia = m.id
        GROUP BY pensamiento";
	$resultado4=$mysqli1->query($query4);
	while($row4 = $resultado4->fetch_assoc()){
		//$p3[] = $row4['nota'];
		if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
		    if($row4['pensamiento'] == "BIOETICO") {
    	       $p3[0] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO") {
    	       $p3[1] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p3[2] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "NUMÉRICO") {
    	       $p3[3] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "NUMÉRICO F") {
    	       $p3[4] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "SOCIAL") {
    	       $p3[5] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "TECNOLÓGICO") {
    	       $p3[6] = $row4['ct']; 
    	    }
    	    else {
    	        $p3[] = "0.0";
    	    }
		}
		else {
		    if($row4['pensamiento'] == "BIOETICO") {
    	       $p3[0] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO") {
    	       $p3[1] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p3[2] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "NUMÉRICO") {
    	       $p3[3] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "SOCIAL") {
    	       $p3[4] = $row4['ct']; 
    	    }
    	    else if($row4['pensamiento'] == "TECNOLÓGICO") {
    	       $p3[5] = $row4['ct']; 
    	    }
    	    else {
    	        $p3[] = "0.0";
    	    }
		}
	}
	//echo json_encode($p3);;
	$notas->p3 = $p3;
	$query5 = "SELECT COUNT(1) ct, 
        case m.materia when 'FÍSICA' then 'NUMÉRICO F' else m.pensamiento end as pensamiento 
        FROM 
        (SELECT SUM(nota)/4, id_estudiante, id_materia 
        FROM `notas` 
        WHERE id_grado = $idgra AND id_periodo IN (1,2,3,4) 
        GROUP BY id_estudiante, id_materia HAVING SUM(nota)/4 <= 2.9) a, materias m 
        WHERE a.id_materia = m.id
        GROUP BY pensamiento";
	$resultado5=$mysqli1->query($query5);
	while($row5 = $resultado5->fetch_assoc()){
		//$p4[] = $row5['nota'];
		if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
		    if($row5['pensamiento'] == "BIOETICO") {
    	       $p4[0] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO") {
    	       $p4[1] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p4[2] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "NUMÉRICO") {
    	       $p4[3] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "NUMÉRICO F") {
    	       $p4[4] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "SOCIAL") {
    	       $p4[5] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "TECNOLÓGICO") {
    	       $p4[6] = $row5['ct']; 
    	    }
    	    else {
    	        $p4[] = "0.0";
    	    }
		}
		else {
		    if($row5['pensamiento'] == "BIOETICO") {
    	       $p4[0] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO") {
    	       $p4[1] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO 1") {
    	       $p4[2] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "NUMÉRICO") {
    	       $p4[3] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "SOCIAL") {
    	       $p4[4] = $row5['ct']; 
    	    }
    	    else if($row5['pensamiento'] == "TECNOLÓGICO") {
    	       $p4[5] = $row5['ct']; 
    	    }
    	    else {
    	        $p4[] = "0.0";
    	    }
		}
	}
	//echo json_encode($p4);;
	$notas->p4 = $p4;
	
	echo json_encode($notas, JSON_UNESCAPED_UNICODE);
	//https://ejemplocodigo.com/ejemplo-php-crear-y-leer-json-de-una-tabla-mysql/
	//https://unicab.org/registro/docenteunicab/updreg/buscar_notas.php
	
/*}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../login.php'</script>";
}*/

?>