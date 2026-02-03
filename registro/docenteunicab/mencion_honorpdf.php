<?php
    include "../adminunicab/php/conexion.php";
    require("updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/mencion_honorpdf.php?selgra1=10&idest=621&periodo=3
    
    require_once 'updreg/dompdf/dompdf/autoload.inc.php';
    use Dompdf\Dompdf;
    
    class PDF {
        public static function stream($nom_pdf, $html) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('letter', 'landscape'); // (Opcional) Configurar papel y orientación landscape | portrait
            $dompdf->render(); // Generar el PDF desde contenido HTML
            $pdf = $dompdf->output(); // Obtener el PDF generado
            $dompdf->stream($nom_pdf); // Enviar el PDF generado al navegador
        }
        
        public static function saveDisk($nom_pdf, $html, $folder) {
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            //$dompdf->setPaper('A4', 'portrait'); // (Opcional) Configurar papel y orientación landscape | portrait
            $dompdf->setPaper('letter', 'landscape'); // (Opcional) Configurar papel y orientación landscape | portrait
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
    
    // numero certificado
	// numero certificado
    
    //https://www.youtube.com/watch?v=Mp--Ymcmgkk
    //https://www.youtube.com/watch?v=5HQ7GAVGL54
    
    $content = '<html>';
    $content .= '<head>';
    //$contect .= '<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">';
    $content .= '<style>';
    $content .= '@font-face {font-family: "Oswald"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/oswald/v35/TK3_WkUHHAIjg75cFRf3bXL8LICs1_FvsUZiZQ.woff2) format("woff2");}';
    $content .= '@font-face {font-family: "Anton"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/anton/v12/1Ptgg87LROyAm3Kz-C8.woff2) format("woff2");}';
    //$content .= '@font-face {font-family: "Marck Script"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/marckscript/v11/nwpTtK2oNgBA3Or78gapdwuyyCg_.woff2) format("woff2");}';
    $content .= '@font-face {font-family: "Marck Script"; src: url("updreg/dompdf/dompdf/lib/fonts/MarckScript-Regular.ttf") format("TrueType");}';
    //$content .= '#divmarca {background-image: url("updreg/img/marca_agua1.png"); background-repeat: no-repeat; background-size: 100%;}';
    //$content .= '#divmarca {background-image: url("../images/macadeagua.jpg"); background-repeat: no-repeat; background-size: 100%;}';
    //$content .= '#divcontenido {width: 80%; display: flex; justify-content: center; align-items: center;}';
    $content .= '#divcontenido {width: 80%; position: absolute; top: 250px; left: 50px;}';
    $content .= 'table {border-collapse: collapse; width: 900px;}';
    //$content .= 'thead, tr, td {border: 1px solid gray; text-align: center;}';
    $content .= 'thead, tr, td {text-align: center;}';
    $content .= 'thead {font-weight: bold;}';
    $content .= 'span {background: #CEF6CE;}';
    $content .= 'body {background-image: url("updreg/img/fondo_mencion_honor40_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
    $content .= '.t1 {font-family: "Oswald"; font-weight: bold; font-size: 30px;}';
    $content .= '.t2 {font-weight: bold; font-size: 16px;}';
    $content .= '.nom {font-family: "Marck Script"; font-weight: bold; font-size: 50px;}';
    $content .= '.d1 {font-weight: bold;}';
    $content .= '.rec {font-family: "Anton"; font-weight: bold; font-size: 40px;}';
    $content .= '.f1 {font-weight: bold; font-size: 14px;}';
    $content .= '</style>';
    $content .= '</head><body>';
    $content1 = "";
    
    $content1 .= '<center><div id="divcontenido"><div>';
    $content1 .= '<table><tbody>';
    $content1 .= '<tr><td class="t1">MENCIÓN DE HONOR</td></tr>';
    $content1 .= '<tr><td class="t2">Concedida a:</td></tr>';
    $content1 .= '<tr><td class="nom">Maria Paulina Figueredo Rodriguez</td></tr>';
    $content1 .= '<tr><td></td></tr>';
    $content1 .= '<tr><td class="d1"><br>Teniendo en cuenta que durante el grado 1° se distinguió por su:</td></tr>';
    $content1 .= '<tr><td class="rec">TERCER PUESTO PRUEBAS DE ESTADO</td></tr>';
    $content1 .= '<tr><td></td></tr>';
    $content1 .= '<tr><td class="f1"><br>Dado en Sogamoso, Boyacá a los '.$dia.' días de '.$espaniol.' del '.$fanio.'.</td></tr>';
    $content1 .= '<tr><td></td></tr>';
    $content1 .= '<tr><td><img src="../images/firma_certficados.JPG" width="600" height="203"/></td></tr>';
    $content1 .= '</tbody></table>';
    $content1 .= '</div></div></center></body></html>';
    
    echo $content;
    echo $content1;
    
    //$nom_pdf = "dh_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$fanio."_ggg.pdf";
    $nom_pdf = "dh_".str_replace(" ","_","Grado 1°")."_".str_replace(" ","_","Maria Paulina Figueredo Rodriguez")."_".$fanio.".pdf";
    	
	//PDF::stream($nom_pdf,$content);

    //$folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
    $folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_","Grado 1°").'/';
    $folder = __DIR__.$folder0;
    PDF::saveDisk($nom_pdf,$content.$content1,$folder);
    $content1 = "";
    /*$nivel = "";
    $variable = "";
	$variableDos = "";
	$variableTres = "";
	$variableCuatro = "";
	$educacion = "";*/
    
    $ruta = "https://unicab.org/registro/docenteunicab".$folder0.$nom_pdf;
    //echo $ruta;
    
    //Se valida si el archivo pdf ya existe
    /*$sql_validacion = "SELECT * FROM certificado WHERE ruta = '$ruta'";
    $exe_sql_val=$mysqli1->query($sql_validacion);
	$ct_pdf = $mysqli1->affected_rows;
    
    if($ct_pdf > 0) {
        $sql_upd="UPDATE certificado SET numero = 'CN".$fanio.$certicado_total."', numero1 = ".$fanio.$certicado_total." WHERE ruta = '".$ruta."'";
        //echo $sql_upd;
        $exe_upd=mysqli_query($conexion,$sql_upd);
    }
    else {
        $sql_insert='INSERT INTO certificado (fecha_expedicion, numero, tipo_certificado, id_estudiante, id_grado, ruta, numero1, identificacion) 
        VALUES ("'.$fecha2.'","CN'.$fanio.$certicado_total.'","Certificado de notas","'.$idest.'","'.$idgra.'","'.$ruta.'",'.$fanio.$certicado_total.',"'.$n_doc.'")';
        //echo $sql_insert;
        $exe_insert=mysqli_query($conexion,$sql_insert);
    }
    
    $certicado_total++;
	$cert_num = $fanio.$certicado_total;*/
	
	
	
	
    
    //$content1 .= '<td width="120">Pensamiento</td><td width="200">Area-Asignatura</td><td width="80">Acumulado</td><td width="130">Nivel de desempeño</td>';
    
    //Se modifica el consecutivo_cn
    /*$sql_certificado1="UPDATE tbl_parametros SET v1 = ".$certicado_total." WHERE parametro = 'consecutivo_cn'";
	$exe_certificado1=$mysqli1->query($sql_certificado1);
    
    
    $query_tc = "SELECT *  FROM certificado WHERE numero1 >= $cert_num1 AND numero1 <= $cert_num AND tipo_certificado = 'Certificado de notas'";
    $exe_query_tc=mysqli_query($conexion,$query_tc);*/
    	
?>

<!--<html>
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
                    <td><?php //echo $row_tc['numero']; ?></td>
                    <td><?php //echo $row_tc['id_estudiante']; ?></td>
                    <td><?php //echo $row_tc['id_grado']; ?></td>
                    <td><?php //echo $row_tc['ruta']; ?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>
    </body>
</html>-->
