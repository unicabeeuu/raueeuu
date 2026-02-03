<?php
    include "php/conexion.php";    
	require("../docenteunicab/updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/adminunicab/stickers_correspondencia3.php?selgra1_=6&txtidest=1,2,3&pa_=2025
    
    require_once '../docenteunicab/updreg/dompdf/dompdf/autoload.inc.php';
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
    
    $idgra = strtoupper($_REQUEST['selgra1_']);
    //$id = $_REQUEST['idest_'];
    $ids = $_REQUEST['txtidest'];
    $anio = $_REQUEST['a_'];
	
	$idsArray = explode(',', $ids);
	$hojas = intdiv(count($idsArray), 6) + 1;
	//$hojas = 3;
	//echo $hojas;
    $nom_pdf = "";
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    
    $fecha2 =$fanio."/".$mes."/". $dia;
	//echo $fecha2;
	
	$i = 1;
	$query1 = "SELECT * FROM tbl_diplomas_virtuales WHERE grado = ".$idgra." AND a = ".$anio." AND id IN ($ids)";
	//echo $query1;	
    
    $content = '<html>';
    $content .= '<head>';
    $content .= '<style>';
    //$content .= '#divmarca {background-image: url("img/marcaagua28_2025.jpg"); background-repeat: no-repeat; background-size: cover;}';
	//$content .= '.logo {background-image: url("../images/nuevo_logo1.jpg"); background-repeat: no-repeat; background-size: cover;}';
	$content .= 'table {border-collapse: collapse; border-spacing: 0; page-break-inside: avoid; break-inside: avoid; -webkit-column-break-inside: avoid;}';
    //$content .= 'thead, tr, td {border: 1px solid gray;}';
    $content .= 'thead {font-weight: bold;}';
	$content .= '.negrilla {font-weight: bold;}';
	$content .= '.bl {border-left: 1px solid black;}';
	$content .= '.br {border-right: 1px solid black;}';
	$content .= '.bt {border-top: 1px solid black;}';
	$content .= '.bb {border-bottom: 1px solid black;}';
	//$content .= '.borde-t {border: 1px solid white;}';
	$content .= '.small1 {width: 10px;}';
	$content .= '.small2 {width: 20px;}';
	$content .= '.medium1 {width: 23px;}';
	$content .= '.medium2 {width: 43px;}';
	$content .= '.medium3 {width: 58px;}';
	$content .= '.medium31 {width: 105px;}';
	$content .= '.medium4 {width: 105px;}';
	$content .= '.fs16 {font-size: 16px;}';
	$content .= '.fs12 {font-size: 12px;}';
	$content .= '.fs10 {font-size: 10px;}';
	$content .= '.t1 {font-size: 16px; width: 264px;}';
	$content .= '.blanco {color: white;}';
	//$content .= '.page-break {page-break-after: always; break-after: page;}';
    //content .= 'span {background: #CEF6CE;}';
    $content .= '</style>';
	
    $content .= '</head><body>';    
	$content .= '<table><tbody>';	
	
	$controlRegistroImpar = 0;
	$destinatario1 = "";
	$direccion1 = "";
	$ciudad1 = "";
	$celular1 = "";
	
	$consulta = mysqli_query($conexion, $query1);
    while ($row = mysqli_fetch_array($consulta)){        
		if ($i % 2 != 0) {
			$destinatario1 = $row['nombres']." ".$row['apellidos'];
			$direccion1 = $row['direccion'];
			$ciudad1 = $row['ciudad']." - ".$row['departamento'];
			$celular1 = $row['celular'];
			$controlRegistroImpar = 1;
		}
		else if ($i % 2 == 0) {
			$destinatario2 = $row['nombres']." ".$row['apellidos'];
			$direccion2 = $row['direccion'];
			$ciudad2 = $row['ciudad']." - ".$row['departamento'];
			$celular2 = $row['celular'];
			$controlRegistroImpar = 0;
			
			$content .= '<tr><td style="width: 300px;"></td><td style="width: 20px;"></td><td style="width: 300px;"></td></tr>';
			$content .= '<tr>';
			$content .= '<td><table><tbody>';
			$content .= '<tr><!-- 1 -->
					<td class="small1 bl bt"></td>
					<td class="negrilla bt t1" colspan="4">COLEGIO VIRTUAL UNICAB</td>
					<td class="medium1 bt br"></td>
				  </tr>				
				  <tr><!-- 2 -->
					<td class="small1 bl"></td>
					<td class="medium2 negrilla fs12">DIR:</td>
					<td class="medium4 fs12" colspan="2">CALLE 13A # 16-60</td>
					<td class="medium31 logo borde-t" rowspan="5"><img src="../images/nuevo_logo1.jpg" width="80px"/></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 3 -->
					<td class="small1 bl"></td>
					<td class="fs12" colspan="3">SOGAMOSO, BOYACÁ</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 4 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">315 696 5291</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 5 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">NIT:</td>
					<td class="fs12" colspan="2">826002762-1</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 6 -->
					<td class="small1 bl"></td>
					<td class="blanco fs12">NIT:</td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 7 -->
					<td class="small1 bl"></td>
					<td class="blanco fs12">NIT:</td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 8 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DEST:</td>
					<td class="negrilla br fs12" colspan="4">'.$destinatario1.'</td>
				  </tr>
				  <tr><!-- 9 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DIR:</td>
					<td class="br fs12" colspan="4">'.$direccion1.'</td>
				  </tr>
				  <tr><!-- 10 -->
					<td class="small1 bl"></td>
					<td class="br fs12" colspan="5">'.$ciudad1.'</td>
				  </tr>
				  <tr><!-- 11 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">'.$celular1.'</td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 12 -->
					<td class="small1 bl bb"></td>
					<td class="blanco bb fs12">Bogotá</td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb br"></td>
				  </tr>
				  <tr><!-- 13 Espacio en blanco -->
					<td class="small1"></td>
					<td class="blanco fs10">Bogotá</td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
				  </tr>';
			$content .= '</tbody></table>';
			$content .= '</td><td></td>';
			$content .= '<td><table><tbody>';
			$content .= '<tr><!-- 1 -->
					<td class="small1 bl bt"></td>
					<td class="negrilla bt t1" colspan="4">COLEGIO VIRTUAL UNICAB</td>
					<td class="medium1 bt br"></td>
				  </tr>				
				  <tr><!-- 2 -->
					<td class="small1 bl"></td>
					<td class="medium2 negrilla fs12">DIR:</td>
					<td class="medium4 fs12" colspan="2">CALLE 13A # 16-60</td>
					<td class="medium31 logo borde-t" rowspan="5"><img src="../images/nuevo_logo1.jpg" width="80px"/></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 3 -->
					<td class="small1 bl"></td>
					<td class="fs12" colspan="3">SOGAMOSO, BOYACÁ</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 4 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">315 696 5291</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 5 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">NIT:</td>
					<td class="fs12" colspan="2">826002762-1</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 6 -->
					<td class="small1 bl"></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 7 -->
					<td class="small1 bl"></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 8 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DEST:</td>
					<td class="negrilla br fs12" colspan="4">'.$destinatario2.'</td>
				  </tr>
				  <tr><!-- 9 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DIR:</td>
					<td class="br fs12" colspan="4">'.$direccion2.'</td>
				  </tr>
				  <tr><!-- 10 -->
					<td class="small1 bl"></td>
					<td class="br fs12" colspan="5">'.$ciudad2.'</td>
				  </tr>
				  <tr><!-- 11 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">'.$celular2.'</td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 12 -->
					<td class="small1 bl bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb br"></td>
				  </tr>
				  <tr><!-- 13 Espacio en blanco -->
					<td class="small1"></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
				  </tr>';
			$content .= '</tbody></table>';
			$content .= '</td></tr>';
		}	
		$i++;
    }
	
	if ($controlRegistroImpar == 1) {
		//Se agrega el sticker impar que quedó pendiente
		$content .= '<tr>';
		$content .= '<td><table><tbody>';
		$content .= '<tr><!-- 1 -->
					<td class="small1 bl bt"></td>
					<td class="negrilla bt t1" colspan="4">COLEGIO VIRTUAL UNICAB</td>
					<td class="medium1 bt br"></td>
				  </tr>				
				  <tr><!-- 2 -->
					<td class="small1 bl"></td>
					<td class="medium2 negrilla fs12">DIR:</td>
					<td class="medium4 fs12" colspan="2">CALLE 13A # 16-60</td>
					<td class="medium31 logo borde-t" rowspan="5"><img src="../images/nuevo_logo1.jpg" width="80px"/></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 3 -->
					<td class="small1 bl"></td>
					<td class="fs12" colspan="3">SOGAMOSO, BOYACÁ</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 4 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">315 696 5291</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 5 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">NIT:</td>
					<td class="fs12" colspan="2">826002762-1</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 6 -->
					<td class="small1 bl"></td>
					<td class="blanco fs12">NIT:</td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 7 -->
					<td class="small1 bl"></td>
					<td class="blanco fs12">NIT:</td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 8 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DEST:</td>
					<td class="negrilla br fs12" colspan="4">'.$destinatario1.'</td>
				  </tr>
				  <tr><!-- 9 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DIR:</td>
					<td class="br fs12" colspan="4">'.$direccion1.'</td>
				  </tr>
				  <tr><!-- 10 -->
					<td class="small1 bl"></td>
					<td class="br fs12" colspan="5">'.$ciudad1.'</td>
				  </tr>
				  <tr><!-- 11 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">'.$celular1.'</td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 12 -->
					<td class="small1 bl bb"></td>
					<td class="blanco bb fs12">Bogotá</td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb br"></td>
				  </tr>
				  <tr><!-- 13 Espacio en blanco -->
					<td class="small1"></td>
					<td class="blanco fs10">Bogotá</td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
				  </tr>';
		$content .= '</tbody></table>';
		$content .= '</td><td></td>';
		$content .= '<td><table><tbody>';
		$content .= '<tr><!-- 1 -->
					<td class="small1 bl bt"></td>
					<td class="negrilla bt t1" colspan="4">COLEGIO VIRTUAL UNICAB</td>
					<td class="medium1 bt br"></td>
				  </tr>				
				  <tr><!-- 2 -->
					<td class="small1 bl"></td>
					<td class="medium2 negrilla fs12">DIR:</td>
					<td class="medium4 fs12" colspan="2">CALLE 13A # 16-60</td>
					<td class="medium31 logo borde-t" rowspan="5"><img src="../images/nuevo_logo1.jpg" width="80px"/></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 3 -->
					<td class="small1 bl"></td>
					<td class="fs12" colspan="3">SOGAMOSO, BOYACÁ</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 4 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2">315 696 5291</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 5 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">NIT:</td>
					<td class="fs12" colspan="2">826002762-1</td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 6 -->
					<td class="small1 bl"></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 7 -->
					<td class="small1 bl"></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 8 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DEST:</td>
					<td class="negrilla br fs12" colspan="4"></td>
				  </tr>
				  <tr><!-- 9 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">DIR:</td>
					<td class="negrilla br fs12" colspan="4"></td>
				  </tr>
				  <tr><!-- 10 -->
					<td class="small1 bl"></td>
					<td class="br fs12" colspan="5"></td>
				  </tr>
				  <tr><!-- 11 -->
					<td class="small1 bl"></td>
					<td class="negrilla fs12">CELULAR:</td>
					<td class="fs12" colspan="2"></td>
					<td class=""></td>
					<td class="br"></td>
				  </tr>
				  <tr><!-- 12 -->
					<td class="small1 bl bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb"></td>
					<td class="bb br"></td>
				  </tr>
				  <tr><!-- 13 Espacio en blanco -->
					<td class="small1"></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
					<td class=""></td>
				  </tr>';
		$content .= '</tbody></table>';
		$content .= '</td></tr>';
	}
    $content .= '</tbody></table>';
	
	$content1 = "";
	$content1 .= '</body></html>';
	
	echo $content;
	echo $content1;
	
	$folder0 = '/php/stickers/';
	//$inputFileName = 'php/stickers/formato_sticker_direcciones_f.xlsx';
	$nom_pdf = "formato_sticker_direcciones_f.pdf";
	$folder = __DIR__.$folder0;
	//echo $folder.$nom_pdf;
	PDF::saveDisk($nom_pdf,$content.$content1,$folder);
	
	$ruta = "https://unicab.org/registro/adminunicab".$folder0.$nom_pdf;
    //echo "<br>".$ruta;
    	
?>

<html>
    <head>
        
    </head>
    <body>
        <a href="<?php echo $ruta; ?>" target="_blank">ABRIR STICKERS PARA IMPRIMIR</a>
    </body>
</html>
