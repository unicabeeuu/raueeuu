<?php
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/updreg/pazysalvo_getdat1.php?selgra1_=12&idest_=325&txtidest=1851,1865
    
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
    
    $idgra = strtoupper($_REQUEST['selgra1_']);
    $id = $_REQUEST['idest_'];
    $ids = $_REQUEST['txtidest'];
    $anio_pys = $_REQUEST['a_'];
    echo $ids."|".$anio_pys;
    //echo "<br>".$anio_pys;
    //$idgra = 10;
    //$id = 621;
    $nom_pdf = "";
    
    date_default_timezone_set('America/Bogota');
    //$dia=date("d"); //día con ceros
    $dia=date("j"); //día sin ceros
    $nombredia=date("N");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $fanionormal = $fanio;
    $espaniol="";
    
    $fecha2 =$fanio."/".$mes."/". $dia;
	//echo $fecha2;
	
	switch ($nombredia){
        case 1: $nombredia1 = "lunes"; break;
        case 2: $nombredia1 = "martes"; break;
        case 3: $nombredia1 = "miércoles"; break;
        case 4: $nombredia1 = "jueves"; break;
        case 5: $nombredia1 = "viernes"; break;
        case 6: $nombredia1 = "sabado"; break;
        case 7: $nombredia1 = "domingo"; break;
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
    
    if($mes == '01' || $mes == '02') {
	    //echo $mes;
	    //$fanio--;
	}
	//echo "<br>".$fanio." ".$anio_pys;
	
	//$tabla_est_mood = "tbl_estudiantes_mood";
	if($anio_pys == $fanio) {
	    $tabla_est_mood = "tbl_estudiantes_mood";
	}
	else {
	    //$tabla_est_mood = "tbl_estudiantes_mood_2022";
		$tabla_est_mood = "tbl_estudiantes_mood";
	}
	
    if(!$id || $id == "0") {
        $query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.grado_ra grado, CONCAT(e.nombres,' ',e.apellidos) nombre, td.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero, m.estado, 
    	    case td.id when 1 then 'T.I.' when 2 then 'R.C.' when 3 then 'C.C.' when 4 then 'P.' when 5 then 'P.E.P.' end td 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM $tabla_est_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a, tbl_tipos_documento td 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND e.tipo_documento = td.id 
    		AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND eg.id_grado_ra = ".$idgra." AND m.id_grado = ".$idgra." 
    		AND e.id IN ($ids) AND m.n_matricula like '%".$anio_pys."%' 
    		ORDER BY a.grado, nombre";
    }
    else {
		if ($fanio > $anio_pys) {
			$query1 = "SELECT DISTINCT e.id, eg.id id_grado_ra, eg.grado grado, CONCAT(e.nombres,' ',e.apellidos) nombre, td.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero, m.estado, 
    	    case td.id when 1 then 'T.I.' when 2 then 'R.C.' when 3 then 'C.C.' when 4 then 'P.' when 5 then 'P.E.P.' end td 
    		FROM estudiantes e, matricula m, grados eg, tbl_tipos_documento td 
    		WHERE e.id = m.id_estudiante AND m.id_grado = eg.id AND e.tipo_documento = td.id 
    		AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND eg.id = ".$idgra." AND m.id_grado = ".$idgra." 
    		AND e.id = $id AND m.n_matricula like '%".$anio_pys."%' 
    		ORDER BY eg.grado, nombre";
		}
		else {
			$query1 = "SELECT DISTINCT e.id, eg.id_grado_ra, eg.grado_ra grado, CONCAT(e.nombres,' ',e.apellidos) nombre, td.tipo_documento, e.n_documento, 
    	    e.expedicion, UPPER(e.genero) genero, m.estado, 
    	    case td.id when 1 then 'T.I.' when 2 then 'R.C.' when 3 then 'C.C.' when 4 then 'P.' when 5 then 'P.E.P.' end td 
    		FROM estudiantes e, matricula m, equivalence_idgra eg, 
    		(SELECT em.*, ee.id_registro 
    		FROM $tabla_est_mood em LEFT JOIN equivalence_idest ee
    		ON em.id = ee.id_moodle ) a, tbl_tipos_documento td 
    		WHERE e.id = m.id_estudiante AND e.id = a.id_registro AND a.grado = eg.name AND e.tipo_documento = td.id 
    		AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND eg.id_grado_ra = ".$idgra." AND m.id_grado = ".$idgra." 
    		AND e.id = $id AND m.n_matricula like '%".$anio_pys."%' 
    		ORDER BY a.grado, nombre";
		}
    }
	//echo "<br>".$query1;	
    //https://www.youtube.com/watch?v=Mp--Ymcmgkk
    //https://www.youtube.com/watch?v=5HQ7GAVGL54
    
    $content = '<html>';
    $content .= '<head>';
    $content .= '<style>';
    //$content .= '#divmarca {background-image: url("img/marcaagua28_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
	$content .= '#divmarca {background-image: url("img/marcaagua28_2025.jpg"); background-repeat: no-repeat; background-size: cover;}';
    $content .= 'table {margin: 0 auto;}';
    $content .= 'thead, tr, td {text-align: center;}';
    $content .= 'thead {font-weight: bold;}';
    $content .= 'span {background: #CEF6CE;}';
    $content .= '#divprincipal {border: 2px solid blue;}';
    $content .= '#divcontenido {margin-left: 10px; margin-right: 10px;}';
    $content .= '#divdatos {background-image: url("../../images/fondo_div3.jpg"); background-repeat: no-repeat; width: 100%; height: 130px; margin-bottom:20px;}';
    //$content .= '#divdatos {border: 2px solid blue; -moz-border-radius: 20px; -webkit-border-radius: 20px; width: 100%; margin: 0 auto;}';
    $content .= '.b1 {background: #D5DCE4; font-weight: bold;}';
    $content .= '.b2 {background: #EEEEEE;}';
    $content .= '</style>';
    $content .= '</head><body><div id="divprincipal"><div id="divcontenido"><center><table><tbody><tr><td>';
    $content .= '<div>';
    $content .= '<img src="../../images/logo3_2025.jpg" width="120px" height="108px"/>';
	//$content .= '<img src="../../../assets/img/footer_logo2025.png" width="120px" height="108px"/>';
    $content .= '</div>';
    $content .= '</tr></td><tr><td>';
    //$content .= '<div id="divmarca">'; //abre el div id="divmarca"
    $content .= '<br><p>';
    $content .= '<strong>CERTIFICADO DE PAZ Y SALVO ACADÉMICO Y FINANCIERO</strong>';
    
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
    	/*$content1 .= '<div><p>';
        $content1 .= 'El <strong>Colegio UNICAB Virtual</strong> se permite certificar que '.$variable.' estudiante <strong>'.$row['nombre'].'</strong>, '.$variableDos.' con '.$t_doc.' No. '.$n_doc.' de '.$expedida.', del grado <strong>'.$grado.' de '.$educacion.'</strong>, se encuentra a paz y salvo por todo concepto.';
        $content1 .= '</p>';
        $content1 .= '</div>';*/
        
        $content1 = "";
        
        $content1 .= '</p></td></tr></tbody></table></center><br>';
        $content1 .= '<div id="divdatos">';
        $content1 .= '<table id="tbldatos"><tbody>';
        $content1 .= '<tr><td colspan="5" height="15px"></td></tr>';
        $content1 .= '<tr>';
        $content1 .= '<td></td>';
        $content1 .= '<td></td>';
        $content1 .= '<td></td>';
        $content1 .= '<td class="b1">Fecha de Solicitud</td>';
        $content1 .= '<td class="b2">'.$dia.' de '.$espaniol.' de '.$fanionormal.'</td>';
        $content1 .= '</tr>';
        $content1 .= '<tr>';
        $content1 .= '<td class="b1">Nombre del Estudiante</td>';
        $content1 .= '<td colspan="4" class="b2">'.$row['nombre'].'</td>';
        $content1 .= '</tr>';
        $content1 .= '<tr>';
        $content1 .= '<td class="b1">Documento Identidad</td>';
        $content1 .= '<td class="b2">'.$row['td'].'</td>';
        $content1 .= '<td class="b2">'.$n_doc.'</td>';
        $content1 .= '<td class="b1">Ultimo Grado Realizado</td>';
        $content1 .= '<td class="b2">'.$grado.'</td>';
        $content1 .= '</tr>';
        $content1 .= '<tr>';
        $content1 .= '<td class="b1">Situación Académica</td>';
        $content1 .= '<td colspan="2" class="b2">'.ucfirst($row['estado']).'</td>';
        $content1 .= '<td class="b1">Situación Financiera</td>';
        $content1 .= '<td class="b2">Paz y Salvo</td>';
        $content1 .= '</tr>';
        //$content .= '<tr><td colspan="5"></td></tr>';
        $content1 .= '</tbody></table>';
        $content1 .= '</div>';
        
        $content1 .= '<div><p style="text-align: justify; font-size: 14px;">';
        $content1 .= 'La suscrita secretaria general de la institución educativa colegio UNICAB Virtual, entidad de educación formal en la modalidad virtual con licencia de funcionamiento otorgada en administrativo de la Secretaría de Educación y Cultura De Sogamoso mediante la Resolución No. 326 del 22 de septiembre de 2015, medio del presente escrito se permite certificar, que una vez revisadas las bases de datos de los procesos de gestión académica y gestión financiera, el estudiante de la referencia se encuentra a paz y salvo por todo concepto con la institución.';
        $content1 .= '</p>';
        $content1 .= '<p style="text-align: justify; font-size: 14px;">';
        $content1 .= 'Del mismo modo, señala que la presente certificación se expide en cumplimiento a la obligación legal de mantener actualizado el sistema Nacional de Información de Educación que está soportado por la ley 115 de 1994, y describe como objetivos fundamentales: Divulgar información para orientar a la comunidad sobre la calidad, cantidad y características de las instituciones y servir como factor para la administración y planeación de la educación, para la determinación de políticas educativas a nivel nacional y territorial.';
        $content1 .= '</p>';
        $content1 .= '<p style="text-align: justify; font-size: 14px;">';
        $content1 .= 'Por otra parte, la administración del sistema de información del sector educativo está reglamentada por el Decreto 1526 de 2002, que es el que establece los conceptos básicos que debe tener el Sistema de Información de Educación Básica y Media -SINEB acordes con los principios de objetividad, comparabilidad y publicidad, con el fin de permitir el uso de datos medibles, comunes a cada uno de los niveles de la administración del servicio educativo, que permita la planeación del servicio educativo, la evaluación de resultados y toma de decisiones en los niveles nacional, departamental, distrital, municipal y de las instituciones educativas. Asimismo, es utilizado como base para la distribución de recursos y generación de estadísticas sectoriales como quiera que, los reportes de información de matrícula y/o retiro al Ministerio de Educación Nacional es indispensable para la verificación de requisitos esenciales en los procesos de matrícula de cada uno de los establecimientos educativos en el sistema de matrículas SIMAT pues dicha información reportada es validada con la información registrada en el Directorio de Establecimientos Educativos.';
        $content1 .= '</p>';
        $content1 .= '<p style="text-align: justify; font-size: 14px;">';
        $content1 .= 'La presente certificación se expide a solicitud del interesado y con destino a quien pueda interesar, para los fines dispuesto en la ley, el '.$nombredia1.' '.$dia.' de '.$espaniol.' de '.$fanionormal.'. Sin otro particular, me suscribo.';
        $content1 .= '</p></div>';
    	
        $content1 .= '<p style="text-align: justify; font-size: 14px;">Atentamente.</p>';
        
        //$content1 .= '</div>'; //Cierra el div id="divmarca"
        
        $content2 = "";
        $content2 .= '<div>';
        //$content2 .= '<img src="../../images/firma_certficados.JPG" width="600" height="203"/>';
        $content2 .= '<img src="../../images/firma_liliana1_1.jpg" width="200"/>';
        $content2 .= '</div><br>';
        $content2 .= '</div></div></body></html>';
        
        $content3 = "";
        $content3 .= '<br><br><br><br><br><div>';
        $content3 .= '<img src="../../images/firma_liliana_1.jpg" width="200"/>';
        $content3 .= '</div><br>';
        $content3 .= '</div></div></body></html>';
        
        //echo $content;
        //echo $content1;
        //echo $content2;
    	
    	$nom_pdf = "pys_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$anio_pys.".pdf";
    	$nom_pdf_sf = "pyssf_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$anio_pys.".pdf";
    	
    	//PDF::stream($nom_pdf,$content);
    
        $folder0 = '/pazysalvos/'.$anio_pys.'/'.str_replace(" ","_",$row['grado']).'/';
        $folder = __DIR__.$folder0;
        PDF::saveDisk($nom_pdf,$content.$content1.$content2,$folder);
        PDF::saveDisk($nom_pdf_sf,$content.$content1.$content3,$folder);
        $content1 = "";
        $content2 = "";
        $content3 = "";
        $nivel = "";
        $variable = "";
		$variableDos = "";
		$variableTres = "";
		$variableCuatro = "";
		$educacion = "";
        
        $ruta = "https://unicab.org/registro/docenteunicab/updreg".$folder0.$nom_pdf;
        $ruta1 = "https://unicab.org/registro/docenteunicab/updreg".$folder0.$nom_pdf_sf;
        //echo $ruta;
        
        //Se valida si el archivo pdf ya existe (con firma)
        $sql_validacion = "SELECT * FROM tbl_pazysalvos WHERE ruta = '$ruta'";
        $exe_sql_val=$mysqli1->query($sql_validacion);
    	$ct_pdf = $mysqli1->affected_rows;
        
        if($ct_pdf > 0) {
            //No hace naca
        }
        else {
            $sql_insert='INSERT INTO tbl_pazysalvos (fecha_expedicion, id_estudiante, id_grado, ruta, identificacion, a, firma) 
            VALUES ("'.$fecha2.'","'.$idest.'","'.$idgra.'","'.$ruta.'","'.$n_doc.'","'.$anio_pys.'", "SI")';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert);
        }
        
        //Se valida si el archivo pdf ya existe (sin firmas)
        $sql_validacion1 = "SELECT * FROM tbl_pazysalvos WHERE ruta = '$ruta1'";
        $exe_sql_val1=$mysqli1->query($sql_validacion1);
    	$ct_pdf1 = $mysqli1->affected_rows;
        
        if($ct_pdf1 > 0) {
            //No hace naca
        }
        else {
            $sql_insert1='INSERT INTO tbl_pazysalvos (fecha_expedicion, id_estudiante, id_grado, ruta, identificacion, a, firma) 
            VALUES ("'.$fecha2.'","'.$idest.'","'.$idgra.'","'.$ruta1.'","'.$n_doc.'","'.$anio_pys.'", "NO")';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert1);
        }
    }
    
    if(!$id || $id == "0") {
        $query_tc = "SELECT *  FROM tbl_pazysalvos WHERE id_grado = $idgra AND id_estudiante IN ($ids) ";
    }
    else {
       $query_tc = "SELECT *  FROM tbl_pazysalvos WHERE id_estudiante = $idest"; 
    }
    
    $exe_query_tc=mysqli_query($conexion,$query_tc);
    //echo "<br>".$query_tc;
    	
?>

<html>
    <head>
        
    </head>
    <body>
        <table border="1">
            <thead>
                <tr>
                    <td>ID_EST</td>
                    <td>ID_GRADO</td>
                    <td>RUTA</td>
                    <td>FIRMA</td>
                </tr>
            </thead>
            <tbody>
            <?php  
                while ($row_tc=mysqli_fetch_array($exe_query_tc)) {
            ?>
                <tr>
                    <td><?php echo $row_tc['id_estudiante']; ?></td>
                    <td><?php echo $row_tc['id_grado']; ?></td>
                    <td><?php echo $row_tc['ruta']; ?></td>
                    <td><?php echo $row_tc['firma']; ?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>
    </body>
</html>
