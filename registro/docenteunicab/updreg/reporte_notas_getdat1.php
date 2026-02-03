<?php
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/updreg/reporte_notas_getdat1.php?selgra1=6&idest=1559&periodo=1
    
    require_once 'dompdf/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    
    class PDF {
        /*public static function stream($nom_pdf, $html) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
			$dompdf->render(); // Generar el PDF desde contenido HTML
            $pdf = $dompdf->output(); // Obtener el PDF generado
            $dompdf->stream($nom_pdf); // Enviar el PDF generado al navegador
        }*/
        
        public static function saveDisk($nom_pdf, $html, $folder) {
			$dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
            //echo "<br>".$html;
			$dompdf->render(); // Generar el PDF desde contenido HTML
            //echo "<br>".$folder;
            $pdf = $dompdf->output(); // Obtener el PDF generado
            
            $pdf_guardar = $folder.$nom_pdf;
            //echo $pdf_guardar;
            
            if(!file_exists($folder)) {
                if(mkdir($folder, 0755, true)) {
                    file_put_contents($pdf_guardar, $pdf);
                }
            }
            else {
                file_put_contents($pdf_guardar, $pdf);
            }
        }
    }
    
    $idgra = strtoupper($_REQUEST['selgra1']);
    $id = $_REQUEST['idest'];
    $per = $_REQUEST['periodo'];
    //$est = "ANA SOFIA CHAVEZ PUERTA";
    //echo $est;
    //$idgra = 10;
    //$id = 621;
    $nom_pdf = "";
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    
    $fecha2 =$fanio."/".$mes."/". $dia;
	//echo $fecha2;
	
	//Se valida la fecha actual con respecto a los cierres de periodo
	/*if(date($fecha2) >= date('2020/02/03') && date($fecha2) < date('2020/04/11')) {
	    $per = 1;
	}
	else if(date($fecha2) >= date('2020/04/11') && date($fecha2) < date('2020/06/28')) {
	    $per = 2;
	}
	else if(date($fecha2) >= date('2020/06/28') && date($fecha2) < date('2020/09/12')) {
	    $per = 3;
	}
	else if(date($fecha2) >= date('2020/09/12')) {
	    $per = 4;
	}*/
    
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
    
    if($mes == '01' || $mes == '02') {
	    //echo $mes;
	    $fanio--;
	}
	
    // numero certificado
	//$sql_certificado="SELECT * FROM certificado";
	$sql_certificado="SELECT v1 FROM tbl_parametros WHERE parametro = 'consecutivo_cn'";
	$exe_certificado=$mysqli1->query($sql_certificado);
	while ($row0=mysqli_fetch_array($exe_certificado)) {
	    $certicado_total = $row0['v1'];
	}
	//$certicado_total = $mysqli1->affected_rows;
	$cert_num = $fanio.$certicado_total;
	$cert_num1 = $fanio.$certicado_total;
	//echo $cert_num;
	// numero certificado
    
    if(!$id || $id == "0") {
        $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.grado_ra grado, CONCAT(e.nombres,' ',e.apellidos) nombre, td.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a, tbl_tipos_documento td  
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND e.tipo_documento = td.id AND m.estado = 'Activo' AND eg.id_grado_ra = ".$idgra." 
    		ORDER BY a.grado, nombre";
    }
    else {
        $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.grado_ra grado, CONCAT(e.nombres,' ',e.apellidos) nombre, td.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a, tbl_tipos_documento td  
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND e.tipo_documento = td.id AND m.estado IN ('Activo') AND eg.id_grado_ra = ".$idgra." 
    		AND e.id = $id
    		ORDER BY a.grado, nombre";
    }
	//echo $query1;	
    //https://www.youtube.com/watch?v=Mp--Ymcmgkk
    //https://www.youtube.com/watch?v=5HQ7GAVGL54
    
    /*if ( ! isset($_GET['pdf']) ) {
    	$content = '<html>';
    	$content .= '<head>';
    	$content .= '<style>';
    	$content .= 'body { font-family: DejaVu Sans; }';
    	$content .= '</style>';
    	$content .= '</head><body>';
    	$content .= '<h1>Ejemplo generaci&oacute;n PDF</h1>';
    	$content .= '<a href="reporte_notas_getdat1.php?pdf=1">Generar documento PDF</a>';
    	$content .= '</body></html>';
    	echo $content;
    	exit;
    }*/
    
    $content = '<html>';
    $content .= '<head>';
    $content .= '<style>';
    //$content .= '#divmarca {background-image: url("img/marcaagua28_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
	$content .= '#divmarca {background-image: url("img/marcaagua28_2025.jpg"); background-repeat: no-repeat; background-size: cover;}';
    $content .= 'table {border-collapse: collapse;}';
    $content .= 'thead, tr, td {border: 1px solid gray; text-align: center;}';
    $content .= 'thead {font-weight: bold;}';
    $content .= 'span {background: #CEF6CE;}';
    $content .= '</style>';
    $content .= '</head><body>';
    /*$content .= '<h1>Ejemplo generaci&oacute;n PDF</h1>';
    $content .= 'Almacena en una variable todo el contenido que quieras incorporar ';
    $content .= 'en el documento <b>formato HTML</b> para generar a partir de &eacute;ste ';
    $content .= 'el documento PDF.<br><br>';
    $content .= 'Ejemplo lista<br>';
    $content .= '<ul><li>Uno</li><li>Dos</li><li>Tres</li></ul>';
    $content .= 'Ejemplo imagen<br><br>';
    $content .= '<img src="../../images/logo20.png" />';*/
    $content .= '<center><div>';
    $content .= '<img src="../../images/logo3_2025.jpg" width="120px" height="108px"/>';
    $content .= '</div>';
    $content .= '<p>';
    $content .= '<strong>UNICAB VIRTUAL</strong>, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la Secretaría de Educación y Cultura de Sogamoso 
                según resolución 061 del 15 de diciembre de 2007, y Resolución Nº 0155 21 de Julio de 2010 y Resolución No. 326 del 22 de septiembre de 2015, para todos los niveles 
                e Educación Básica Primaria, Básica Secundaria y Media Académica,';
    $content .= '</p>';
    $content .= '<p>';
    $content .= '<strong>LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL</strong>';
    $content .= '</p>';
    $content .= '<p>';
    $content .= '<strong>CERTIFICAN:</strong>';
    $content .= '</p>';
    $content1 = "";
    
    $consulta=mysqli_query($conexion,$query1);
    while ($row = mysqli_fetch_array($consulta)){
        $est = $row['nombre'];
        $genero = $row['genero'];
        $t_doc = $row['tipo_documento'];
        $n_doc = $row['n_documento'];
        $expedida = $row['expedicion'];
        $grado = $row['grado'];
        $idest = $row['id'];
        $idgra = $row['id_grado_ra'];
        //echo $t_doc;
        
        if ($genero=="MASCULINO") {
    		$variable="el";
    		$variableDos="identificado";
    		$variableTres="matriculado";
    		$variableCuatro="activo";
    	}
    	else{
    		$variable="la";
    		$variableDos="identificada";
    		$variableTres="matriculada";
    		$variableCuatro="activa";
    	}
    	
    	if($idgra <= 6 || $idgra == 13 || $idgra == 14) {
    	    $educacion = "EDUCACION BASICA PRIMARIA";
    	}
    	else if($idgra <= 10 || $idgra == 15 || $idgra == 16) {
    	    $educacion = "EDUCACION BASICA SECUNDARIA";
    	}
    	else if($idgra <= 12 || $idgra == 17 || $idgra == 18) {
    	    $educacion = "EDUCACION MEDIA ACADEMICA";
    	}
    	//echo $educacion;
    	
    	$content1 .= '<div id="divmarca"><p>';
        $content1 .= 'Que, '.$variable.' estudiante, <strong>'.$row['nombre'].'</strong>, '.$variableDos.' con '.$t_doc.' No. '.$n_doc.' de '.$expedida.', en la actualidad es 
                    <strong>estudiante activo</strong> del grado <strong>'.$grado.' de '.$educacion.'</strong>, cumpliendo los requisitos establecidos.';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= '<strong>Promedio Acumulado Periodo: '.$per.'</strong>';
        $content1 .= '</p>';
        
        $content1 .= '<table><thead><tr>';
        //$content1 .= '<td width="120">Pensamiento</td><td width="200">Area-Asignatura</td><td width="80">Acumulado</td><td width="130">Nivel de desempeño</td>';
        if($idgra == 17 || $idgra == 18) {
    	    $content1 .= '<td width="110">Pensamiento</td><td width="200">Area-Asignatura</td><td>P1</td><td>P2</td><td width="70">Acumulado</td><td width="80">Desempeño</td>';
    	}
    	else {
    	    $content1 .= '<td width="110">Pensamiento</td><td width="200">Area-Asignatura</td><td>P1</td><td>P2</td><td>P3</td><td>P4</td><td width="70">Acumulado</td><td width="80">Desempeño</td>';
    	}
        
        $content1 .= '</tr></thead>';
        $content1 .= '<tbody style="text-size: 12px;">';
    
    	//*****************************************************************
    	if($idgra == 17 || $idgra == 18) {
    	    if($per > 2) {
    	        $per = 2;
    	    }
    	}
    	
    	if($per == 1) {
    	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			ROUND(ifnull(p1.nota, 0), 1) P1, ' ' P2, ' ' P3, ' ' P4, ROUND(ifnull(p1.nota, 0), 1) acumulado 
    			FROM 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1 
    			ORDER BY 3";
    	}
    	else if($per == 2) {
    	    /*$sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			ROUND(p1.nota, 1) P1, ROUND(p2.nota, 1) P2, ' ' P3, ' ' P4, ROUND((p1.nota + p2.nota)/2, 1) acumulado 
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
    			ORDER BY 3";*/
    		$sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			ROUND(ifnull(p1.nota, 0), 1) P1, ROUND(ifnull(p2.nota, 0), 1) P2, ' ' P3, ' ' P4, 
    			ROUND((ifnull(p1.nota, 0) + ifnull(p2.nota, 0))/2, 1) acumulado 
    			FROM 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1 left join 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 2) p2 
    			ON p1.id_estudiante = p2.id_estudiante  
    			AND p1.id = p2.id  
    			AND p1.id_grado = p2.id_grado  
    			ORDER BY 3";
    	}
    	else if($per == 3) {
    	    /*$sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			ROUND(p1.nota, 1) P1, ROUND(p2.nota, 1) P2, ROUND(p3.nota, 1) P3, ' ' P4, ROUND((p1.nota + p2.nota + p3.nota)/3, 1) acumulado 
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
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 3) p3 
    			WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante  
    			AND p1.id = p2.id AND p1.id = p3.id  
    			AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado  
    			ORDER BY 3";*/
    		$sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    			ROUND(ifnull(p1.nota, 0), 1) P1, ROUND(ifnull(p2.nota, 0), 1) P2, ROUND(ifnull(p3.nota, 0), 1) P3, ' ' P4, 
    			ROUND((ifnull(p1.nota, 0) + ifnull(p2.nota, 0) + ifnull(p3.nota, 0))/3, 1) acumulado 
    			FROM 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1 left join 
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 2) p2 
    			ON p1.id_estudiante = p2.id_estudiante AND p1.id = p2.id AND p1.id_grado = p2.id_grado left join
    			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    			FROM notas n, estudiantes e, materias m, grados g, periodos p 
    			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    			AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 3) p3 
    			ON p1.id_estudiante = p3.id_estudiante  
    			AND p1.id = p3.id  
    			AND p1.id_grado = p3.id_grado  
    			ORDER BY 3";
    	}
    	else if($per == 4) {
    	    /*$sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    		ROUND(p1.nota, 1) P1, ROUND(p2.nota, 1) P2, ROUND(p3.nota, 1) P3, ROUND(p4.nota, 1) P4, ROUND((p1.nota + p2.nota + p3.nota + p4.nota)/4, 1) acumulado 
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
    		ORDER BY 3";*/
    	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
    		ROUND(ifnull(p1.nota, 0), 1) P1, ROUND(ifnull(p2.nota, 0), 1) P2, ROUND(ifnull(p3.nota, 0), 1) P3, ROUND(ifnull(p4.nota, 0), 1) P4, 
    		ROUND((ifnull(p1.nota, 0) + ifnull(p2.nota, 0) + ifnull(p3.nota, 0) + ifnull(p4.nota, 0))/4, 1) acumulado 
    		FROM 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 1) p1 left join 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 2) p2 
    		ON p1.id_estudiante = p2.id_estudiante AND p1.id = p2.id AND p1.id_grado = p2.id_grado left join  
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 3) p3 
    		ON p1.id_estudiante = p3.id_estudiante AND p1.id = p3.id AND p1.id_grado = p3.id_grado left join 
    		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
    		FROM notas n, estudiantes e, materias m, grados g, periodos p 
    		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
    		AND e.id = ".$idest." AND g.id = ".$idgra." AND p.id = 4) p4 
    		ON p1.id_estudiante = p4.id_estudiante 
    		AND p1.id = p4.id 
    		AND p1.id_grado = p4.id_grado 
    		ORDER BY 3";
    	}
    	//echo $sql_notas;
    	$exe_notas=mysqli_query($conexion,$sql_notas);
    	while ($row1=mysqli_fetch_array($exe_notas)) {
    	    if ($row1['acumulado']<3.5) {
		      	$nivel = "BAJO";
	      	}
	      	else if ($row1['acumulado']>=3.5 && $row1['acumulado']<=3.9) {
		      	$nivel = "BASICO";
	      	}
	      	else if ($row1['acumulado']>=4.0 && $row1['acumulado']<=4.5) {
		      	$nivel = "ALTO";
	      	}
	      	else if ($row1['acumulado']>4.5) {
		      	$nivel = "SUPERIOR";
	      	}
	      	//echo $row1['nota'];
	      	//echo $nivel;
  			
  			if($nivel == "BAJO") {
  			    if($idgra == 17 || $idgra == 18) {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
  			    }
  			    else {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
  			    }
  			    
  			}
  			else if($nivel == "BASICO") {
  			    if($idgra == 17 || $idgra == 18) {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
  			    }
  			    else {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
  			    }
  			    
  			}
  			else if($nivel == "ALTO") {
  			    if($idgra == 17 || $idgra == 18) {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
  			    }
  			    else {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
  			    }
  			    
  			}
  			else if($nivel == "SUPERIOR") {
  			    if($idgra == 17 || $idgra == 18) {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
  			    }
  			    else {
  			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>'.$row1['materia'].'</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
  			    }
  			    
  			}
  			
 			//esta validación es para las asignaturas de bioético y humanístico
  			if($row1['id_materia'] == 10 || $row1['id_materia'] == 1) {
  			    if($nivel == "BAJO") {
  			        if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "BASICO") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "ALTO") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "SUPERIOR") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>EDUCACIÓN FÍSICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
  			    
			}
			else if($row1['id_materia'] == 15) {
			    if($nivel == "BAJO") {
			        if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "BASICO") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "ALTO") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "SUPERIOR") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>FILOSOFÍA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
			    
			}
			else if($row1['id_materia'] == 6) {
			    if($nivel == "BAJO") {
			        if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "BASICO") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "ALTO") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "SUPERIOR") {
      			    if($idgra == 17 || $idgra == 18) {
  			            $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$row1['pensamiento'].'</td><td>ARTISTICA</td><td>'.$row1['P1'].'</td><td>'.$row1['P2'].'</td><td>'.$row1['P3'].'</td><td>'.$row1['P4'].'</td><td>'.$row1['acumulado'].'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
			}
		}
    	//*****************************************************************
    	
    	$content1 .= '</tbody>';
        $content1 .= '</table></div></center>';
        
        $content1 .= '<p>';
        $content1 .= 'Se expide a los ('.$dia.') días del mes de '.$espaniol.' de ('.$fanio.').';
        $content1 .= '</p>';
        
        $content1 .= '<center><div>';
        $content1 .= '<img src="../../images/firma_certificados.JPG" width="600" height="203"/>';
        $content1 .= '</div>';
        $content1 .= '<p>';
        $content1 .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 608 7752309 Cel. 300 815 6531 - 315 696 5291';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= 'www.unicab.org';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= '<span>Certificado No. CN'.$fanio.$certicado_total.'</span>';
        $content1 .= '</p>';
        $content1 .= '</center>';
        $content1 .= '</body></html>';
        
        //echo $content;
        //echo $content1;
    	
    	$nom_pdf = "cn_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$fanio.".pdf";
		//echo $nom_pdf;
    	
    	//PDF::stream($nom_pdf,$content);
    
        $folder0 = '/certificados/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
        $folder = __DIR__.$folder0;
		PDF::saveDisk($nom_pdf,$content.$content1,$folder);
		//echo $folder;
		$content1 = "";
        $nivel = "";
        $variable = "";
		$variableDos = "";
		$variableTres = "";
		$variableCuatro = "";
		$educacion = "";
        
        $ruta = "https://unicab.org/registro/docenteunicab/updreg".$folder0.$nom_pdf;
        //echo $ruta;
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM certificado WHERE ruta = '$ruta'";
        $exe_sql_val=$mysqli1->query($sql_validacion);
    	$ct_pdf = $mysqli1->affected_rows;
        
        if($ct_pdf > 0) {
            $sql_upd="UPDATE certificado SET numero = 'CN".$fanio.$certicado_total."', numero1 = ".$fanio.$certicado_total.", fecha_expedicion = '".$fecha2."' 
			WHERE ruta = '".$ruta."'";
            //echo $sql_upd;
            $exe_upd=mysqli_query($conexion,$sql_upd);
        }
        else {
            $sql_insert='INSERT INTO certificado (fecha_expedicion, numero, tipo_certificado, id_estudiante, id_grado, ruta, numero1, identificacion, a) 
            VALUES ("'.$fecha2.'","CN'.$fanio.$certicado_total.'","Certificado de notas","'.$idest.'","'.$idgra.'","'.$ruta.'",'.$fanio.$certicado_total.',"'.$n_doc.'",'.$fanio.')';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert);
        }
        
        $certicado_total++;
    	$cert_num = $fanio.$certicado_total;
    }
    
    //Se modifica el consecutivo_cn
    $sql_certificado1="UPDATE tbl_parametros SET v1 = ".$certicado_total." WHERE parametro = 'consecutivo_cn'";
	$exe_certificado1=$mysqli1->query($sql_certificado1);
    
    /*$content .= '<div id="divmarca"><p>';
    $content .= 'Que, '.$variable.' estudiante, <strong>'.$est.'</strong>, '.$variableDos.' con '.$t_doc.' No. '.$n_doc.' de '.$expedida.', en la actualidad es 
                <strong>estudiante activo</strong> del grado <strong>'.$grado.' de EDUCACION BASICA SECUNDARIA</strong>, cumpliendo los requisitos establecidos.';
    $content .= '</p>';
    $content .= '<p>';
    $content .= '<strong>Periodo: 1</strong>';
    $content .= '</p>';
    
    $content .= '<table><thead><tr>';
    $content .= '<td width="120">Pensamiento</td><td width="200">Area-Asignatura</td><td width="80">Valoración</td><td width="130">Nivel de desempeño</td>';
    $content .= '</tr></thead>';
    $content .= '<tbody>';*/
    /*$content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '<tr><td>Pensamiento</td><td>Area-Asignatura</td><td>Valoración</td><td>Nivel de desempeño</td></tr>';
    $content .= '</tbody>';
    $content .= '</table></div></center>';
    
    $content .= '<p>';
    $content .= 'Se expide a los ('.$dia.') días del mes de '.$espaniol.' de ('.$fanio.').';
    $content .= '</p>';
    
    $content .= '<center><div>';
    $content .= '<img src="../../images/firma_certficados.JPG" width="600" height="203"/>';
    $content .= '</div>';
    $content .= '<p>';
    $content .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 315 696 5291 - 315 889 5275';
    $content .= '</p>';
    $content .= '<p>';
    $content .= 'www.unicab.org';
    $content .= '</p>';
    $content .= '<p>';
    $content .= '<span>Certificado No. CS'.$certicado_total.'</span>';
    $content .= '</p>';
    $content .= '</center>';
    $content .= '</body></html>';*/
    
    //echo $content; exit;
    
    /*$dompdf = new Dompdf();
    $dompdf->loadHtml($content);
    $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
    $dompdf->render(); // Generar el PDF desde contenido HTML
    $pdf = $dompdf->output(); // Obtener el PDF generado
    $dompdf->stream($nom_pdf); // Enviar el PDF generado al navegador
    
    //PDF::stream($nom_pdf,$content);
    
    $folder = __DIR__.'/certificados/2020/noveno/';
    PDF::saveDisk($nom_pdf,$content,$folder);*/
    
    $query_tc = "SELECT *  FROM certificado WHERE numero1 >= $cert_num1 AND numero1 <= $cert_num AND tipo_certificado = 'Certificado de notas'";
    $exe_query_tc=mysqli_query($conexion,$query_tc);
    //echo $query_tc;
    	
?>

<html>
    <head>
        
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <td>NUMERO</td>
                    <td>ID_EST</td>
                    <td>ID_GRADO</td>
                    <td>RUTA</td>
                </tr>
            </thead>
            <tbody>
            <?php  
                while ($row_tc=mysqli_fetch_array($exe_query_tc)) {
            ?>
                <tr>
                    <td><?php echo $row_tc['numero']; ?></td>
                    <td><?php echo $row_tc['id_estudiante']; ?></td>
                    <td><?php echo $row_tc['id_grado']; ?></td>
                    <td><a href="<?php echo $row_tc['ruta']; ?>" target="_blank"><?php echo $row_tc['ruta']; ?></a></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>
    </body>
</html>
