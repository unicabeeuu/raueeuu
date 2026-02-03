<?php
    include "../adminunicab/php/conexion.php";
    require("updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/mencion_honormpdf.php?selgra1=10&idest=621&periodo=3
    
    //include 'updreg/mpdf/mpdf.php';
    //include 'updreg/mpdf/prueba.php';
    include 'updreg/mpdf8/vendor/autoload.php';
    
    //'A0'- 'A10', 'B0'- 'B10', 'C0'-'C10'
    //'4A0', '2A0', 'RA0'- 'RA4', 'SRA0'-'SRA4'
    //'Letter', 'Legal', 'Executive','Folio'
    //'Demy', 'Royal'
    //'A' (Tapa blanda tipo A 111x178mm)
    //'B' (Tapa blanda tipo B 128x198mm)
    //'Ledger'*, 'Tabloid'*
    //Todos los valores anteriores se pueden agregar como sufijo '-L'para forzar un documento de orientación de página horizontal, por ejemplo 'A4-L'.
    
    //$mpdf = new mPDF('c', 'Letter-L');
    $mpdf = new \Mpdf\Mpdf(["format" => "Letter-L", "margin_left" => 0, "margin_right" => 0, "margin_top" => 10, "margin_bottom" => 0]);
    $mpdf->SetDisplayMode('fullpage');
    
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
    
    $content = '<html>';
    $content .= '<head>';
    //$contect .= '<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">';
    $content .= '<style>';
    //$content .= '@font-face {font-family: "Oswald"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/oswald/v35/TK3_WkUHHAIjg75cFRf3bXL8LICs1_FvsUZiZQ.woff2) format("woff2");}';
    //$content .= '@font-face {font-family: "Anton"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/anton/v12/1Ptgg87LROyAm3Kz-C8.woff2) format("woff2");}';
    //$content .= '@font-face {font-family: "Marck Script"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/marckscript/v11/nwpTtK2oNgBA3Or78gapdwuyyCg_.woff2) format("woff2");}';
    $content .= '@font-face {font-family: "marckscript"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/MarckScript-Regular.ttf") format("TrueType");}';
    $content .= '@font-face {font-family: "anton"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Anton-Regular.ttf") format("TrueType");}';
    $content .= '@font-face {font-family: "oswald"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Oswald-SemiBold.ttf") format("TrueType");}';
    //$content .= '#divcontenido {width: 80%; display: flex; justify-content: center; align-items: center;}';
    //$content .= '#divcontenido {width: 100%; position: absolute; top: 200px; left: 50px;}';
    $content .= '#divcontenido {width: 100%;}';
    $content .= 'table {border-collapse: collapse; width: 100%;}';
    //$content .= 'thead, tr, td {border: 1px solid gray; text-align: center;}';
    $content .= 'thead, tr, td {text-align: center;}';
    $content .= 'thead {font-weight: bold;}';
    $content .= 'span {background: #CEF6CE;}';
    //$content .= 'body {background-image: url("updreg/img/fondo_mencion_honor40_1.jpg"); background-repeat: no-repeat; background-size: cover; top: 50px;}';
    $content .= '#divbody {width: 100%; background-image: url("updreg/img/fondo_mencion_honor40_1.jpg"); background-repeat: no-repeat; background-size: cover; top: 50px;}';
    $content .= '.t1 {font-family: "oswald"; font-size: 30pt;}';
    $content .= '.t2 {font-weight: bold; font-size: 16pt;}';
    //$content .= '.nom {font-family: "marckscript"; font-weight: bold; font-size: 40pt;}';
    //$content .= '.nom {font-family: "cherryswash"; font-weight: bold; font-size: 40pt;}';
    $content .= '.nom {font-family: "spirax"; font-weight: bold; font-size: 40pt;}';
    $content .= '.d1 {font-weight: bold; font-size: 16pt;}';
    $content .= '.rec {font-family: "anton"; font-size: 30pt;}';
    $content .= '.f1 {font-weight: bold; font-size: 16pt;}';
    $content .= '</style>';
    $content .= '</head><body>';
    $content1 = "";
    
    $content1 .= '<div id="divbody"><br><br><br><br><br><br><br><br><center><div id="divcontenido"><div>';
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
    $content1 .= '</div></div></center></div></body></html>';
    
    echo $content;
    echo $content1;
    
    //$nom_pdf = "dh_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$fanio."_ggg.pdf";
    $nom_pdf = "dhm_".str_replace(" ","_","Grado 1°")."_".str_replace(" ","_","Maria Paulina Figueredo Rodriguez")."_".$fanio.".pdf";
    	
	//PDF::stream($nom_pdf,$content);

    //$folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
    $folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_","Grado 1°").'/';
    $folder = __DIR__.$folder0;
    //PDF::saveDisk($nom_pdf,$content.$content1,$folder);
    
    $mpdf->WriteHTML($content.$content1);
    //$mpdf->WriteHTML('<div>Section 1 text</div>');
    // I = Inline; D = Download; F = File; S = Cadena
    //$mpdf->Output($nom_pdf, 'I');
    $mpdf->Output($folder.$nom_pdf, 'F');
    exit;
    
    //$content1 = "";
    
    //$ruta = "https://unicab.org/registro/docenteunicab".$folder0.$nom_pdf;
    echo $ruta;
    
    	
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
