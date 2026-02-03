<?php
    session_start();
	//Genera botón de ver registros a procesar
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/buscar_notas_enfasis.php?idest=1242&idgra=11
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idest = $_REQUEST["idest"];
	$idgra = $_REQUEST["idgra"];
	//$idest = 512;
	//$idgra = 18;
	
	//$lbls = array("ENFASIS EDU. FISICA","","","","","");
	$lbls = array("ENFASIS EDU. FISICA");
	$notas = new stdClass();
	//$lbls = array();
	$p1 = array();
	$p2 = array();
	$p3 = array();
	$p4 = array();
	
	$query1 = "SELECT DISTINCT a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'FÍSICA' then 'BIOÉTICO F' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (1,4,5,6,7,9,10,11,12,15,16) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a";
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()){
		//$lbls[] = $row['pensamiento'];
		//echo $row['pensamiento'];
	}
	//echo json_encode($lbls);
	//$notas->lbls = $lbls;
	
	$query2 = "SELECT a.nota, a.pensamiento, a.id_periodo  
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'ÉNFASIS EN EDUCACIÓN FÍSICA' then 'ÉNFASIS EN EDUCACIÓN FÍSICA' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (16) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo IN (1, 2, 3, 4) 
		ORDER BY a.pensamiento, a.materia";
	$resultado2=$mysqli1->query($query2);
	while($row2 = $resultado2->fetch_assoc()){
	    //$lbls[] = $row2['pensamiento'];
		//$p1[] = $row2['nota'];
		if($idgra == 10 || $idgra == 11 || $idgra == 12) {
		    if($row2['pensamiento'] == "ÉNFASIS EN EDUCACIÓN FÍSICA") {
		       if($row2['id_periodo'] == 1) { 
    	            $p1[0] = $row2['nota'];
		       }
		       else if($row2['id_periodo'] == 2) { 
    	            $p2[0] = $row2['nota'];
		       }
		       else if($row2['id_periodo'] == 3) { 
    	            $p3[0] = $row2['nota'];
		       }
		       else if($row2['id_periodo'] == 4) { 
    	            $p4[0] = $row2['nota'];
		       }
    	       /*$p1[1] = 0;
    	       $p1[2] = 0;
    	       $p1[3] = 0;
    	       $p1[4] = 0;
    	       $p1[5] = 0;*/
    	    }
    	    else {
    	        $p1[] = "0.0";
    	        $p2[] = "0.0";
    	        $p3[] = "0.0";
    	        $p4[] = "0.0";
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
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'ÉNFASIS EN EDUCACIÓN FÍSICA' then 'ÉNFASIS EN EDUCACIÓN FÍSICA' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (16) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 2 
		ORDER BY a.pensamiento, a.materia";
	$resultado3=$mysqli1->query($query3);
	while($row3 = $resultado3->fetch_assoc()){
	    if($idgra == 10 || $idgra == 11 || $idgra == 12) {
		    if($row2['pensamiento'] == "ÉNFASIS EN EDUCACIÓN FÍSICA") {
    	       $p2[0] = $row2['nota'];
    	       /*$p2[1] = 0;
    	       $p2[2] = 0;
    	       $p2[3] = 0;
    	       $p2[4] = 0;
    	       $p2[5] = 0;*/
    	    }
    	    else {
    	        $p1[] = "0.0";
    	    }
		}
		//$p2[] = $row3['nota'];
	}
	//echo json_encode($p2);;
	$notas->p2 = $p2;
	$query4 = "SELECT a.nota, a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'ÉNFASIS EN EDUCACIÓN FÍSICA' then 'ÉNFASIS EN EDUCACIÓN FÍSICA' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (16) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 3 
		ORDER BY a.pensamiento, a.materia";
	$resultado4=$mysqli1->query($query4);
	while($row4 = $resultado4->fetch_assoc()){
		//$p3[] = $row4['nota'];
		if($idgra == 10 || $idgra == 11 || $idgra == 12) {
		    if($row2['pensamiento'] == "ÉNFASIS EN EDUCACIÓN FÍSICA") {
    	       $p3[0] = $row2['nota'];
    	       /*$p3[1] = 0;
    	       $p3[2] = 0;
    	       $p3[3] = 0;
    	       $p3[4] = 0;
    	       $p3[5] = 0;*/
    	    }
    	    else {
    	        $p1[] = "0.0";
    	    }
		}
	}
	//echo json_encode($p3);;
	$notas->p3 = $p3;
	$query5 = "SELECT a.nota, a.pensamiento 
		FROM 
		(SELECT DISTINCT e.id id_est, m.materia, case m.materia when 'ÉNFASIS EN EDUCACIÓN FÍSICA' then 'ÉNFASIS EN EDUCACIÓN FÍSICA' else m.pensamiento end as pensamiento, 
		g.id id_grado, g.grado, n.nota, n.id_periodo 
		FROM notas n, estudiantes e, materias m, grados g  
		WHERE n.id_estudiante = e.id AND n.id_materia = m.id AND n.id_grado = g.id AND e.id='$idest' and g.id='$idgra' 
		AND m.id IN (16) 
		ORDER BY m.pensamiento, m.materia, n.id_periodo ) a 
		WHERE a.id_periodo = 4 
		ORDER BY a.pensamiento, a.materia";
	$resultado5=$mysqli1->query($query5);
	while($row5 = $resultado5->fetch_assoc()){
		//$p4[] = $row5['nota'];
		if($idgra == 10 || $idgra == 11 || $idgra == 12) {
		    if($row2['pensamiento'] == "ÉNFASIS EN EDUCACIÓN FÍSICA") {
    	       $p4[0] = $row2['nota'];
    	       /*$p4[1] = 0;
    	       $p4[2] = 0;
    	       $p4[3] = 0;
    	       $p4[4] = 0;
    	       $p4[5] = 0;*/
    	    }
    	    else {
    	        $p1[] = "0.0";
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