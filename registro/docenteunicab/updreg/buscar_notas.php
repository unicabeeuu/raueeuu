<?php
    session_start();
	//Genera botón de ver registros a procesar
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/buscar_notas.php?idest=621&idgra=10
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idest = $_REQUEST["idest"];
	$idgra = $_REQUEST["idgra"];
	//$idest = 512;
	//$idgra = 18;
	
	if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
	    //$lbls = array("BIOÉTICO", "HUMANÍSTICO E", "HUMANÍSTICO I", "NUMÉRICO", "BIOÉTICO F", "SOCIAL", "TECNOLÓGICO");
	    $lbls = array("BIOÉTICO", "BIOÉTICO F", "HUMANÍSTICO E", "HUMANÍSTICO I", "NUMÉRICO", "SOCIAL", "TECNOLÓGICO");
	}
	else {
	    $lbls = array("BIOÉTICO", "HUMANÍSTICO E", "HUMANÍSTICO I", "NUMÉRICO", "SOCIAL", "TECNOLÓGICO");
	}
	$notas = new stdClass();
	//$lbls = array();
	$p1 = array();
	$p2 = array();
	$p3 = array();
	$p4 = array();
	
	//Estas líneas cambiaron en todos los periodos
	//SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO F' else m.pensamiento end as pensamiento,
	//por
	//SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO' else m.pensamiento end as pensamiento,
	$query1 = "SELECT DISTINCT a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (1,4,5,6,7,9,10,11,12,15) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a";
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()){
		//$lbls[] = $row['pensamiento'];
		//echo $row['pensamiento'];
	}
	//echo json_encode($lbls);
	//$notas->lbls = $lbls;
	
	$query2 = "SELECT a.nota, a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (1,4,5,6,7,9,10,11,12,15) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 1 
		ORDER BY a.pensamiento, a.materia";
	$resultado2=$mysqli1->query($query2);
	while($row2 = $resultado2->fetch_assoc()){
	    //$lbls[] = $row2['pensamiento'];
		//$p1[] = $row2['nota'];
		if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
		    if($row2['pensamiento'] == "BIOÉTICO") {
    	       $p1[0] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "BIOÉTICO F") {
    	       $p1[1] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO E") {
    	       $p1[2] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO I") {
    	       $p1[3] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "NUMÉRICO") {
    	       $p1[4] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "SOCIAL") {
    	       $p1[5] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "TECNOLÓGICO") {
    	       $p1[6] = $row2['nota']; 
    	    }
    	    else {
    	        $p1[] = "0.0";
    	    }
		}
		else {
		    if($row2['pensamiento'] == "BIOÉTICO") {
    	       $p1[0] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO E") {
    	       $p1[1] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "HUMANÍSTICO I") {
    	       $p1[2] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "NUMÉRICO") {
    	       $p1[3] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "SOCIAL") {
    	       $p1[4] = $row2['nota']; 
    	    }
    	    else if($row2['pensamiento'] == "TECNOLÓGICO") {
    	       $p1[5] = $row2['nota']; 
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
	$query3 = "SELECT a.nota, a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (1,4,5,6,7,9,10,11,12,15) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 2 
		ORDER BY a.pensamiento, a.materia";
	$resultado3=$mysqli1->query($query3);
	while($row3 = $resultado3->fetch_assoc()){
	    if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
		    if($row3['pensamiento'] == "BIOÉTICO") {
    	       $p2[0] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "BIOÉTICO F") {
    	       $p2[1] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO E") {
    	       $p2[2] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO I") {
    	       $p2[3] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "NUMÉRICO") {
    	       $p2[4] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "SOCIAL") {
    	       $p2[5] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "TECNOLÓGICO") {
    	       $p2[6] = $row3['nota']; 
    	    }
    	    else {
    	        $p2[] = "0.0";
    	    }
		}
		else {
		    if($row3['pensamiento'] == "BIOÉTICO") {
    	       $p2[0] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO E") {
    	       $p2[1] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "HUMANÍSTICO I") {
    	       $p2[2] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "NUMÉRICO") {
    	       $p2[3] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "SOCIAL") {
    	       $p2[4] = $row3['nota']; 
    	    }
    	    else if($row3['pensamiento'] == "TECNOLÓGICO") {
    	       $p2[5] = $row3['nota']; 
    	    }
    	    else {
    	        $p2[] = "0.0";
    	    }
		}
		//$p2[] = $row3['nota'];
	}
	//echo json_encode($p2);;
	$notas->p2 = $p2;
	$query4 = "SELECT a.nota, a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (1,4,5,6,7,9,10,11,12,15) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 3 
		ORDER BY a.pensamiento, a.materia";
	$resultado4=$mysqli1->query($query4);
	while($row4 = $resultado4->fetch_assoc()){
		//$p3[] = $row4['nota'];
		if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
		    if($row4['pensamiento'] == "BIOÉTICO") {
    	       $p3[0] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "BIOÉTICO F") {
    	       $p3[1] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO E") {
    	       $p3[2] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO I") {
    	       $p3[3] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "NUMÉRICO") {
    	       $p3[4] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "SOCIAL") {
    	       $p3[5] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "TECNOLÓGICO") {
    	       $p3[6] = $row4['nota']; 
    	    }
    	    else {
    	        $p3[] = "0.0";
    	    }
		}
		else {
		    if($row4['pensamiento'] == "BIOÉTICO") {
    	       $p3[0] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO E") {
    	       $p3[1] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "HUMANÍSTICO I") {
    	       $p3[2] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "NUMÉRICO") {
    	       $p3[3] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "SOCIAL") {
    	       $p3[4] = $row4['nota']; 
    	    }
    	    else if($row4['pensamiento'] == "TECNOLÓGICO") {
    	       $p3[5] = $row4['nota']; 
    	    }
    	    else {
    	        $p3[] = "0.0";
    	    }
		}
	}
	//echo json_encode($p3);;
	$notas->p3 = $p3;
	$query5 = "SELECT a.nota, a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (1,4,5,6,7,9,10,11,12,15) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 4 
		ORDER BY a.pensamiento, a.materia";
	$resultado5=$mysqli1->query($query5);
	while($row5 = $resultado5->fetch_assoc()){
		//$p4[] = $row5['nota'];
		if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
		    if($row5['pensamiento'] == "BIOÉTICO") {
    	       $p4[0] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "BIOÉTICO F") {
    	       $p4[1] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO E") {
    	       $p4[2] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO I") {
    	       $p4[3] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "NUMÉRICO") {
    	       $p4[4] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "SOCIAL") {
    	       $p4[5] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "TECNOLÓGICO") {
    	       $p4[6] = $row5['nota']; 
    	    }
    	    else {
    	        $p4[] = "0.0";
    	    }
		}
		else {
		    if($row5['pensamiento'] == "BIOÉTICO") {
    	       $p4[0] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO E") {
    	       $p4[1] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "HUMANÍSTICO I") {
    	       $p4[2] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "NUMÉRICO") {
    	       $p4[3] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "SOCIAL") {
    	       $p4[4] = $row5['nota']; 
    	    }
    	    else if($row5['pensamiento'] == "TECNOLÓGICO") {
    	       $p4[5] = $row5['nota']; 
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