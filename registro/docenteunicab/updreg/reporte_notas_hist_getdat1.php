<?php
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/updreg/reporte_notas_hist_getdat1.php?selgra1=6&idest=786&periodo=4

    require_once 'dompdf/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    
    class PDF {
        public static function stream($nom_pdf, $html) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
            $dompdf->render(); // Generar el PDF desde contenido HTML
            $pdf = $dompdf->output(); // Obtener el PDF generado
            $dompdf->stream($nom_pdf); // Enviar el PDF generado al navegador
        }
        
        public static function saveDisk($nom_pdf, $html, $folder) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
            $dompdf->render(); // Generar el PDF desde contenido HTML
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
    
    //Esto es para consultar el número de documento
	$sql_ndoc = "SELECT n_documento FROM estudiantes WHERE id = $id";
	//echo $sql_ndoc;
	$exe_ndoc = mysqli_query($conexion,$sql_ndoc);
	while ($row_ndoc=mysqli_fetch_array($exe_ndoc)) {
	    $numero_documento = $row_ndoc['n_documento'];
	}
	//echo $numero_documento;
	
	//Esto es para consultar el número de matrícula
	$sql_peticion="SELECT e.nombres, e.apellidos, e.n_documento, m.n_matricula 
        FROM estudiantes e INNER JOIN 
        (SELECT * FROM matricula WHERE idMatricula = 
        (SELECT MAX(idMatricula) maxid FROM matricula WHERE id_estudiante = ".$id." AND estado IN ('aprobado', 'reprobado', 'activo', 'retirado'))) m ON e.id = m.id_estudiante 
        INNER JOIN grados g ON m.id_grado=g.id 
        WHERE m.id_estudiante=".$id;
	//echo $sql_peticion;
	
	$exe_peticion=mysqli_query($conexion,$sql_peticion);
	while ($row_pet=mysqli_fetch_array($exe_peticion)) {
		$n_matricula = $row_pet['n_matricula'];
 	}
 	//echo $n_matricula;
    
    if(!$id || $id == "0") {
        $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.grado_ra grado, CONCAT(e.nombres,' ',e.apellidos) nombre, e.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND m.n_matricula = '$n_matricula' AND eg.id_grado_ra = ".$idgra." 
    		ORDER BY a.grado, nombre";
    }
    else {
        $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.grado_ra grado, CONCAT(e.nombres,' ',e.apellidos) nombre, e.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND m.n_matricula = '$n_matricula' AND eg.id_grado_ra = ".$idgra." 
    		AND e.id = $id
    		ORDER BY a.grado, nombre";
    }
	//echo $query1;	
    
    $content = '<html>';
    $content .= '<head>';
    $content .= '<style>';
    $content .= '#divmarca {background-image: url("img/marcaagua28_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
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
    $content .= '<img src="../../images/logo3.jpg" width="120px" height="108px"/>';
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
    	
    	$nom_pdf = "cn_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$fanio.".pdf";
    	$folder0 = '/certificados/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
        $ruta = "https://unicab.org/registro/docenteunicab/updreg".$folder0.$nom_pdf;
        //echo $ruta;
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM certificado WHERE ruta = '$ruta'";
        $exe_sql_val=$mysqli1->query($sql_validacion);
        while ($row_val = mysqli_fetch_array($exe_sql_val)) {
            $certicado_total = $row_val['numero'];
        }
        
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
    	//Se valida si hay calificaciones en la tabla de notas
    	$sql_ct_notas = "SELECT COUNT(1) ct FROM notas WHERE id_estudiante = $idest AND id_grado = ".$idgra;
    	//echo $sql_ct_notas;
    	$res_ct_notas = mysqli_query($conexion, $sql_ct_notas);
        while ($ct_notas = mysqli_fetch_array($res_ct_notas)){
            $ct_tabla_notas = $ct_notas['ct'];
        }
        //echo $ct_tabla_notas;
        if($ct_tabla_notas == 0) {
           //Se capturan las notas en la tabla tbl_notas_historia
    	    $sql_nota = "SELECT * FROM tbl_notas_historia WHERE id_est = ".$idest." AND n_matricula = '$n_matricula'";
    	    //echo $sql_nota;
    	    $exe_notas1=mysqli_query($conexion,$sql_nota);
        	
        	//$total_materias=mysqli_num_rows($exe_notas1);
        	$pasada=0;
        	$perdida=0;
            //echo $total_materias;
        
        	while ($fila_promedio=mysqli_fetch_array($exe_notas1)) {
        	    $json = $fila_promedio['json'];
        	}
        	//echo "json=".$json;
        	$obj = json_decode($json, true);
        	//echo "obj=".$obj;
        	//var_dump($obj);
            /*$perdida = $obj->{'perdidas'};
            $calif = $obj->{'calificaciones'};
            $json_id_grado = $obj->{'id_grado'};*/ 
            $perdida = $obj['perdidas'];
            $calif = $obj['calificaciones'];
            $json_id_grado = $obj['id_grado'];
        }
        //echo "calif=".$calif;
        //var_dump($calif);
        
        foreach($calif as $promedios) {
            //$json_id_mat = $promedios->{'id_mat'};
            $json_id_mat = $promedios['id_mat'];
            //echo $json_id_mat;
            /*$json_nfinal = $promedios->{'nfinal'};
            $p1 = $promedios->{'per1'};
            $p2 = $promedios->{'per2'};
            $p3 = $promedios->{'per3'};
            $p4 = $promedios->{'per4'};*/
            $json_nfinal = $promedios['nfinal'];
            $p1 = $promedios['per1'];
            $p2 = $promedios['per2'];
            $p3 = $promedios['per3'];
            $p4 = $promedios['per4'];
            
            //Se busca el pensamiento y la materia
            $sql_materia = "SELECT * FROM materias WHERE id = ".$json_id_mat;
            $exe_materia=mysqli_query($conexion,$sql_materia);
        	while ($fila_materia = mysqli_fetch_array($exe_materia)) {
        	    $pensamiento = $fila_materia['pensamiento'];
        	    $materia = $fila_materia['materia'];
        	}
            //echo $json_nfinal;
            if ($json_nfinal < 3.0) {
  			    $nivel = "BAJO";
  			}
  			else if ($json_nfinal >= 3.0 && $json_nfinal <= 3.9) {
  			    $nivel = "BASICO";
  			}
  			else if ($json_nfinal >= 4.0 && $json_nfinal <= 4.5) {
  			    $nivel = "ALTO";
  			}
  			else if ($json_nfinal > 4.5) {
  			    $nivel = "SUPERIOR";
  			}
  			//echo $nivel;
  			
	      	//**************************************
            if($nivel == "BAJO") {
      		    if($json_id_grado == 17 || $json_id_grado == 18) {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      		    }
      		    else {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      		    }
      		    
      		}
      		else if($nivel == "BASICO") {
      		    if($json_id_grado == 17 || $json_id_grado == 18) {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      		    }
      		    else {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      		    }
      		    
      		}
      		else if($nivel == "ALTO") {
      		    if($json_id_grado == 17 || $json_id_grado == 18) {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      		    }
      		    else {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      		    }
      		    
      		}
      		else if($nivel == "SUPERIOR") {
      		    if($json_id_grado == 17 || $json_id_grado == 18) {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      		    }
      		    else {
      		        $content1 .= '<tr><td>'.$pensamiento.'</td><td>'.$materia.'</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      		    }
      		    
      		}
      		
      		//esta validación es para las asignaturas de bioético y humanístico
      		if($json_id_mat == 10 || $json_id_mat == 1) {
      		    if($nivel == "BAJO") {
      		        if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "BASICO") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "ALTO") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "SUPERIOR") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>EDUCACIÓN FÍSICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      		    
    		}
    		else if($json_id_mat == 15) {
    		    if($nivel == "BAJO") {
    		        if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "BASICO") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "ALTO") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "SUPERIOR") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>FILOSOFÍA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
    		    
    		}
    		else if($json_id_mat == 6) {
    		    if($nivel == "BAJO") {
    		        if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: red;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "BASICO") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: orange;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "ALTO") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: blue;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
      			else if($nivel == "SUPERIOR") {
      			    if($idgra == 17 || $idgra == 18) {
      		            $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    else {
      			        $content1 .= '<tr><td>'.$pensamiento.'</td><td>ARTISTICA</td><td>'.$p1.'</td><td>'.$p2.'</td><td>'.$p3.'</td><td>'.$p4.'</td><td>'.$json_nfinal.'</td><td style="color: green;">'.$nivel.'</td></tr>';
      			    }
      			    
      			}
    		}
        	//**************************************
        }
    	
    	//*****************************************************************
    	
    	$content1 .= '</tbody>';
        $content1 .= '</table></div></center>';
        
        $content1 .= '<p>';
        $content1 .= 'Se expide a los ('.$dia.') días del mes de '.$espaniol.' de ('.$fanio.').';
        $content1 .= '</p>';
        
        $content1 .= '<center><div>';
        $content1 .= '<img src="../../images/firma_certficados.JPG" width="600" height="203"/>';
        $content1 .= '</div>';
        $content1 .= '<p>';
        $content1 .= 'Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 315 696 5291 - 315 889 5275';
        $content1 .= '</p>';
        $content1 .= '<p>';
        $content1 .= 'www.unicab.org';
        $content1 .= '</p>';
        $content1 .= '<p>';
        //$content1 .= '<span>Certificado No. CN'.$fanio.$certicado_total.'</span>';
        $content1 .= '<span>Certificado No. '.$certicado_total.'</span>';
        $content1 .= '</p>';
        $content1 .= '</center>';
        $content1 .= '</body></html>';
        
        echo $content;
        echo $content1;
    	
    	//$nom_pdf = "cn_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$fanio.".pdf";
    	
    	//PDF::stream($nom_pdf,$content);
    
        //$folder0 = '/certificados/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
        $folder = __DIR__.$folder0;
        PDF::saveDisk($nom_pdf,$content.$content1,$folder);
        $content1 = "";
        $nivel = "";
        $variable = "";
		$variableDos = "";
		$variableTres = "";
		$variableCuatro = "";
		$educacion = "";
        
        //$ruta = "https://unicab.org/registro/docenteunicab/updreg".$folder0.$nom_pdf;
        //echo $ruta;
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM certificado WHERE ruta = '$ruta'";
        $exe_sql_val=$mysqli1->query($sql_validacion);
    	$ct_pdf = $mysqli1->affected_rows;
        
        if($ct_pdf > 0) {
            //$sql_upd="UPDATE certificado SET numero = 'CN".$fanio.$certicado_total."', numero1 = ".$fanio.$certicado_total." WHERE ruta = '".$ruta."'";
            //echo $sql_upd;
            //$exe_upd=mysqli_query($conexion,$sql_upd);
        }
        else {
            /*$sql_insert='INSERT INTO certificado (fecha_expedicion, numero, tipo_certificado, id_estudiante, id_grado, ruta, numero1, identificacion) 
            VALUES ("'.$fecha2.'","CN'.$fanio.$certicado_total.'","Certificado de notas","'.$idest.'","'.$idgra.'","'.$ruta.'",'.$fanio.$certicado_total.',"'.$n_doc.'")';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert);*/
        }
        
        //$certicado_total++;
    	//$cert_num = $fanio.$certicado_total;
    }
    
    //Se modifica el consecutivo_cn
    //$sql_certificado1="UPDATE tbl_parametros SET v1 = ".$certicado_total." WHERE parametro = 'consecutivo_cn'";
	//$exe_certificado1=$mysqli1->query($sql_certificado1);
    
    $fanio1 = $fanio + 1;
    $fanioa = $fanio * 100000;
    $faniob = $fanio1 * 100000;
    $query_tc = "SELECT *  FROM certificado WHERE id_estudiante = $id AND tipo_certificado = 'Certificado de notas' 
    AND numero1 BETWEEN $fanioa AND $faniob";
    //echo $query_tc;
    $exe_query_tc=mysqli_query($conexion,$query_tc);
    	
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
                    <td><?php echo $row_tc['ruta']; ?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>
    </body>
</html>
