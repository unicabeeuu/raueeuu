<?php
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
    
    $idgra = strtoupper($_REQUEST['selgra1']);
    $id = $_REQUEST['id'];
    //$est = "ANA SOFIA CHAVEZ PUERTA";
    //echo $idgra;
    //echo $id;
    //$idgra = 10;
    
    //https://www.youtube.com/watch?v=Mp--Ymcmgkk
    //https://www.youtube.com/watch?v=OaKEXD2U8uo
    //https://unicab.org/registro/docenteunicab/updreg/reporte_notas_getdat0.php?selgra1=10&id=621
    //pasar array a otra página... http://www.forosdelweb.com/f18/pasar-arreglo-pagina-php-otra-695348/
    
    $nom_pdf = "prueba.pdf";
    
    $estudiantes = array();
    $est = new stdClass();
    $datos = new stdClass();
	
	$calif_finales = array();
	$keys = ['n_calif','pensamiento','asignatura','valoracion','nivel'];
	$i = 0;
	$e = 0;
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    
    $fecha2 =$fanio."/".$mes."/". $dia;
	//echo $fecha2;
	
	//Se valida la fecha actual con respecto a los cierres de periodo
	if(date($fecha2) >= date('2022/02/01') && date($fecha2) < date('2022/04/08')) {
	    $per = 1;
	}
	else if(date($fecha2) >= date('2022/04/09') && date($fecha2) < date('2022/07/01')) {
	    $per = 2;
	}
	else if(date($fecha2) >= date('2022/07/02') && date($fecha2) < date('2022/09/09')) {
	    $per = 3;
	}
	else if(date($fecha2) >= date('2022/09/12')) {
	    $per = 4;
	}
    
    switch ($mes) {
    	case '1':
    		$espaniol="Enero"; 
    		break;
    	case '2':
    		$espaniol="Febrero";
    		break;
    	case '3':
    		$espaniol="Marzo";
    		break;
    	case '4':
    		$espaniol="Abril";
    		break;
    	case '5':
    		$espaniol="Mayo";
    		break;
    	case '6':
    		$espaniol="Junio";
    		break;
    	case '7':
    		$espaniol="Julio";
    		break;
    	case '8':
    		$espaniol="Agosto";
    		break;
    	case '9':
    		$espaniol="Septiembre";
    		break;
    	case '10':
    		$espaniol="Octubre";
    		break;
    	case '11':
    		$espaniol="Noviembre";
    		break;
    	case '12':
    		$espaniol="Diciembre";
    		break;
    }
    
    // numero certificado
	$sql_certificado="SELECT * FROM certificado";
	$exe_certificado=$mysqli1->query($sql_certificado);
	$certicado_total = $mysqli1->affected_rows;
	// numero certificado
    
    /*$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, CONCAT(e.nombres,' ',e.apellidos) nombre, e.tipo_documento, e.n_documento, 
	    e.expedicion, UPPER(e.genero) genero 
		FROM estudiantes e, matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND m.estado = 'Activo' AND eg.id_grado_ra = ".$idgra." 
		AND e.id = $id
		ORDER BY a.grado, nombre";*/
	$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, a.grado, CONCAT(e.nombres,' ',e.apellidos) nombre, e.tipo_documento, e.n_documento, 
	    e.expedicion, UPPER(e.genero) genero 
		FROM estudiantes e, matricula m, equivalence_idgra eg, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND m.estado = 'Activo' AND eg.id_grado_ra = ".$idgra." 
		ORDER BY a.grado, nombre";
	//echo $query1;	
    
    $consulta=mysqli_query($conexion,$query1);
    while ($row = mysqli_fetch_array($consulta)){
        //echo $row['nombre'];;
        $n_est = $row['nombre'];
        $genero = $row['genero'];
        $t_doc = $row['tipo_documento'];
        $n_doc = $row['n_documento'];
        $expedida = $row['expedicion'];
        $grado = $row['grado'];
        $idest = $row['id'];
        
        if ($genero=="MASCULINO") {
    		$var0="el";
    		$var1="identificado";
    		$var2="matriculado";
    		$var3="activo";
    	}
    	else{
    		$var0="la";
    		$var1="identificada";
    		$var2="matriculada";
    		$var3="activa";
    	}
    	$est->id = $idest;
    	$datos->nombre = $n_est;
    	$datos->genero = $genero;
    	$datos->t_doc = $t_doc;
    	$datos->n_doc = $n_doc;
    	$datos->expedida = $expedida;
    	$datos->grado = $grado;
    	$datos->var0 = $var0;
    	$datos->var1 = $var1;
    	$datos->var2 = $var2;
    	$datos->var3 = $var3;
    	//echo $certicado_total;
    	$datos->num_certif = $certicado_total;
    	
        $est->datos = $datos;
        $datos = new stdClass();
        //echo json_encode($est, JSON_UNESCAPED_UNICODE);
    
    	//*****************************************************************
    	if($per == 1) {
    	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			p1.nota
    			FROM 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1 
    			ORDER BY 2";
    	}
    	else if($per == 2) {
    	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			(p1.nota + p2.nota)/2 nota 
    			FROM 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1, 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 2) p2 
    			WHERE p1.id_estudiante = p2.id_estudiante  
    			AND p1.id = p2.id  
    			AND p1.id_grado = p2.id_grado  
    			ORDER BY 2";
    	}
    	else if($per == 3) {
    	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			(p1.nota + p2.nota + p3.nota)/3 nota 
    			FROM 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM noas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1, 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 2) p2, 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 3) p3 
    			WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante  
    			AND p1.id = p2.id AND p1.id = p3.id  
    			AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado  
    			ORDER BY 2";
    	}
    	else if($per == 4) {
    	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    		(p1.nota + p2.nota + p3.nota + p4.nota)/4 nota 
    		FROM 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1, 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 2) p2, 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 3) p3, 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 4) p4 
    		WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante AND p1.id_estudiante = p4.id_estudiante 
    		AND p1.id = p2.id AND p1.id = p3.id AND p1.id = p4.id 
    		AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado AND p1.id_grado = p4.id_grado 
    		ORDER BY 2";
    	}
    	//echo $sql_notas;
    	
    	$exe_notas=mysqli_query($conexion,$sql_notas);
    	while ($row1=mysqli_fetch_array($exe_notas)) {
    	    if ($row1['nota']<=3.0) {
		      	$nivel = "BAJO";
	      	}
	      	if ($row1['nota']>=3.1 && $row['nota1']<=4.4) {
		      	$nivel = "ALTO";
	      	}
	      	if ($row1['nota']>=4.5) {
		      	$nivel = "SUPERIOR";
	      	}
  			$valores = [$i,str_replace(" ","_",$row1['pensamiento']),str_replace(" ","_",$row1['materia']),$row1['nota'],$nivel];
  			$calif = array_combine($keys,$valores);
  			$calif_finales[$i] = $calif;
  			$i++;
  			
 			//esta validación es para las asignaturas de bioético y humanístico
  			if($row1['id_materia'] == 10 || $row1['id_materia'] == 1) {
  			    $valores = [$i,str_replace(" ","_",$row1['pensamiento']),'EDUCACIÓN ÉTICA Y EN VALORES',$row1['nota'],$nivel];
      			$calif = array_combine($keys,$valores);
      			$calif_finales[$i] = $calif;
      			$i++;
      			
      			$valores = [$i,str_replace(" ","_",$row1['pensamiento']),'EDUCACIÓN FÍSICA',$row1['nota'],$nivel];
      			$calif = array_combine($keys,$valores);
      			$calif_finales[$i] = $calif;
      			$i++;
		      	
			}
			else if($row1['id_materia'] == 15) {
			    $valores = [$i,str_replace(" ","_",$row1['pensamiento']),'ARTISTICA',$row1['nota'],$nivel];
      			$calif = array_combine($keys,$valores);
      			$calif_finales[$i] = $calif;
      			$i++;
      			
      			$valores = [$i,str_replace(" ","_",$row1['pensamiento']),'FILOSOFÍA',$row1['nota'],$nivel];
      			$calif = array_combine($keys,$valores);
      			$calif_finales[$i] = $calif;
      			$i++;
				
			}
			else if($row1['id_materia'] == 6) {
			    $valores = [$i,str_replace(" ","_",$row1['pensamiento']),'ARTISTICA',$row1['nota'],$nivel];
      			$calif = array_combine($keys,$valores);
      			$calif_finales[$i] = $calif;
      			$i++;
			}
		}
		//echo json_encode($calif_finales, JSON_UNESCAPED_UNICODE);
    	//*****************************************************************
    	$est->calificaciones = $calif_finales;
    	//echo json_encode($est, JSON_UNESCAPED_UNICODE);
    	//echo $e;
    	$estudiantes[$e] = $est;
    	$est = new stdClass();
    	$e++;
    	$i = 0;
    	$certicado_total++;
    }
    //echo count($estudiantes);
    //echo json_encode($est, JSON_UNESCAPED_UNICODE);
    echo json_encode($estudiantes, JSON_UNESCAPED_UNICODE);
    
    //Pasar un array a otra página
    //Página 1
    /*session_start();
    $array = array(54, 64, 87);
    $_SESSION['valores'] = $array;*/
    
    //Página 2
    /*session_start();
    $mi_array=$_SESSION['valores'];
    echo $mi_array[0];*/

?>

