<?php
    include "../../adminunicab/php/conexion.php";
    require("../updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/carnets/carnet_mpdf.php?selgra1=10&idest=621&periodo=3
    
    //include 'updreg/mpdf/mpdf.php';
    //include 'updreg/mpdf/prueba.php';
    include '../updreg/mpdf8/vendor/autoload.php';
    
    //'A0'- 'A10', 'B0'- 'B10', 'C0'-'C10'
    //'4A0', '2A0', 'RA0'- 'RA4', 'SRA0'-'SRA4'
    //'Letter', 'Legal', 'Executive','Folio'
    //'Demy', 'Royal'
    //'A' (Tapa blanda tipo A 111x178mm)
    //'B' (Tapa blanda tipo B 128x198mm)
    //'Ledger'*, 'Tabloid'*
    //Todos los valores anteriores se pueden agregar como sufijo '-L'para forzar un documento de orientación de página horizontal, por ejemplo 'A4-L'.
    
    //$mpdf = new mPDF('c', 'Letter-L');
    //$mpdf = new \Mpdf\Mpdf(["format" => "Letter-L", "margin_left" => 0, "margin_right" => 0, "margin_top" => 10, "margin_bottom" => 0]);
    $mpdf = new \Mpdf\Mpdf(["format" => "C1", "margin_left" => 0, "margin_right" => 0, "margin_top" => 0, "margin_bottom" => 0]);
    $mpdf->SetDisplayMode('real');
    
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
        $content .= '@font-face {font-family: "HelveticaBold"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Helvetica-Bold.ttf") format("TrueType");}';
        $content .= '@font-face {font-family: "Helvetica"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Helvetica.ttf") format("TrueType");}';
        $content .= '@font-face {font-family: "HelveticaBoldObliq"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Helvetica-BoldOblique.ttf") format("TrueType");}';
        
        $content .= '#divcontenido {display: flex; justify-content: space-around; margin-left: 100px;}';
        //$content .= '#tblfondo {border-collapse: collapse; width: 1004px; margin-top: 350px;}';
        $content .= '#tblfondo {border: 2px solid black; width: 1004px; margin-top: 350px;}';
        $content .= 'thead, tr, td {text-align: center;}';
        //$content .= 'thead {font-weight: bold;}';
        $content .= '#div2 {width: 1004px; height: 650px; background-image: url("carnets/img/fondo_carnet_completo.jpg"); background-repeat: no-repeat; background-size: cover; text-align: center;}';
        $content .= '#div4 {width: 1004px; height: 650px; background-image: url("carnets/img/posterior_1.jpg"); background-repeat: no-repeat; background-size: cover;}';
        $content .= '#div1, #div3 {width: 10%; height: 100px;}';
        $content .= '.nom {font-family: "HelveticaBold"; font-weight: bold; font-size: 18pt; color: white;}';
        $content .= '.nom1 {font-family: "Helvetica"; font-weight: bold; font-size: 20pt; color: white;}';
        $content .= '#imgqr {margin-bottom: 10px;}';
        $content .= 'div {border: 2px solid black;}';
        $content .= '#divtxt {width: 500px; height: 200px; margin: 350px auto 0;}';
    $content .= '</style>';
    $content .= '</head><body>';
    $content1 = "";
    
    $content1 .= '<div id="divcontenido">';
        $content1 .= '<div id="div1">...</div>';
        
        $content1 .= '<div id="div2">';
            $content1 .= '<div id="divtxt">...</div>';
            /*$content1 .= '<table id="tblfondo"><tbody>';
            $content1 .= '<tr><td colspan="3" class="nom1">Maria Paulina Figueredo Rodriguez</td></tr>';
            $content1 .= '<tr><td colspan="3" class="nom1"><br>T.I. 1072644681</td></tr>';
            $content1 .= '<tr><td colspan="3" class="nom1">Grado: Octavo 8°</td></tr>';
            $content1 .= '<tr><td colspan="3" class="nom1">RH: B+</td></tr>';
            $content1 .= '<tr><td width="35%"></td><td width="35%"></td><td><img id="imgqr" src="../financieraunicab/phpqrcode/img/qr2.png" width="150px"></td></tr>';
            $content1 .= '</tbody></table>';*/
        $content1 .= '</div>';
        
        $content1 .= '<div id="div3">...</div>';
        
        $content1 .= '<div id="div4">';
        $content1 .= '</div>';
    $content1 .= '</div>';
    
    $content1 .= '</body></html>';
    
    echo $content;
    echo $content1;
    
    //$nom_pdf = "dh_".str_replace(" ","_",$row['grado'])."_".str_replace(" ","_",$row['nombre'])."_".$fanio."_ggg.pdf";
    $nom_pdf = "cu_".str_replace(" ","_","Grado 1°")."_".str_replace(" ","_","Maria Paulina Figueredo Rodriguez")."_".$fanio.".pdf";
    	
	//PDF::stream($nom_pdf,$content);
	
	//Se crea la carpeta
    $path = 'carnets/'.$fanio.'/'.str_replace(" ","_","Grado 1°").'/';
    //echo $path;
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
    }

    //$folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
    $folder0 = '/carnets/'.$fanio.'/'.str_replace(" ","_","Grado 1°").'/';
    $folder = __DIR__.$folder0;
    //echo "<br>".$folder0;
    //echo "<br>".$folder;
    //PDF::saveDisk($nom_pdf,$content.$content1,$folder);
    
    $ruta = "https://unicab.org/registro/docenteunicab".$folder0.$nom_pdf;
    //echo "<br>".$ruta;
    
    $mpdf->WriteHTML($content.$content1);
    //$mpdf->WriteHTML('<div>Section 1 text</div>');
    // I = Inline; D = Download; F = File; S = Cadena
    //$mpdf->Output($nom_pdf, 'I');
	echo $folder.$nom_pdf;
    $mpdf->Output($folder.$nom_pdf, 'F');
    //exit;
    
    //$content1 = "";
    
    	
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
