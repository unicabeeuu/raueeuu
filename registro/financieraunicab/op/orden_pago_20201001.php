<?php
    include "../adminunicab/php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/financieraunicab/orden_pago.php?idgra=10&idest=1014859175
    //1000319642 CicloVI | 1014859175 Noveno | 1092856048 Tercero | 1027283932  Quinto | 1075871080 Once | 1105377298 Cuarto
    //1193584907 ciclo iv con cilco vi	doc res 79491812
    //1011323363 sexto con ciclo vi		doc res 79553189
    
    include '../docenteunicab/updreg/mpdf8/vendor/autoload.php';
    include('numlet/vendor/autoload.php');
    use Luecano\NumeroALetras\NumeroALetras;
    
    require('PHPMailer_master/src/Exception.php');
    require('PHPMailer_master/src/PHPMailer.php');
    require('PHPMailer_master/src/SMTP.php');
    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
    
    $number = 0;
	$decimales = 2;
	$currency = "PESOS M/CTE";
	//$cents = "CENTAVOS";
	$pm10 = 0;
	$dg = 0;
	$pm10dg = 0;
	
	$formatter = new NumeroALetras;
    
    //'A0'- 'A10', 'B0'- 'B10', 'C0'-'C10'
    //'4A0', '2A0', 'RA0'- 'RA4', 'SRA0'-'SRA4'
    //'Letter', 'Legal', 'Executive','Folio'
    //'Demy', 'Royal'
    //'A' (Tapa blanda tipo A 111x178mm)
    //'B' (Tapa blanda tipo B 128x198mm)
    //'Ledger'*, 'Tabloid'*
    //Todos los valores anteriores se pueden agregar como sufijo '-L'para forzar un documento de orientación de página horizontal, por ejemplo 'A4-L'.
    
    //$mpdf = new mPDF('c', 'Letter-L');
    $mpdf = new \Mpdf\Mpdf(["format" => "Letter-L", "margin_left" => 10, "margin_right" => 10, "margin_top" => 10, "margin_bottom" => 0]);
    $mpdf->SetDisplayMode('fullpage');
    
    $idgra = strtoupper($_REQUEST['selgra1']);
    $documento = $_REQUEST['idest'];
    
    $nom_pdf = "";
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    //echo $fanio;
    
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
    
    /*$pagos = array("pp", "pm2", "pm3", "pm4", "pm5", "pm6", "pm7","pm8", "pm9", "pm10", "dg", "pm10dg");
    $pagos1 = array("pp", "pm2", "pm3", "pm4", "pm5", "pm6", "pm7","pm8", "pm9", "pm10");
    $pagos2 = array("pp", "pm2", "pm3", "pm4", "pm5", "dg", "pm5dg");
    $pagos3 = array("pp", "pm2", "pm3", "pm4", "pm5");
    
    $des = array("* Primer pago", "Pago mes 2", "Pago mes 3", "Pago mes 4", "Pago mes 5", "Pago mes 6", "Pago mes 7","Pago mes 8", "Pago mes 9", "Pago mes 10", "Derechos grado", "* Pago mes 10 con dg");
    $des1 = array("* Primer pago", "Pago mes 2", "Pago mes 3", "Pago mes 4", "Pago mes 5", "Pago mes 6", "Pago mes 7","Pago mes 8", "Pago mes 9", "Pago mes 10");
    $des2 = array("* Primer pago", "Pago mes 2", "Pago mes 3", "Pago mes 4", "Pago mes 5", "Derechos grado", "* Pago mes 5 con dg");
    $des3 = array("* Primer pago", "Pago mes 2", "Pago mes 3", "Pago mes 4", "Pago mes 5");*/
    
    $pagos = array("pm9", "pm10", "dg", "pm10dg");
    //$pagos1 = array("pm9", "pm10");
    $pagos2 = array("pm4", "pm5", "dg", "pm5dg");
    //$pagos3 = array("pm4", "pm5");
    
    $des = array("Pago mes 9", "Pago mes 10", "Derechos grado", "* Pago mes 10 con dg");
    //$des1 = array("Pago mes 9", "Pago mes 10");
    $des2 = array("Pago mes 4", "Pago mes 5", "Derechos grado", "* Pago mes 5 con dg");
    //$des3 = array("Pago mes 4", "Pago mes 5");
    
    $longitud = count($pagos);
    //$longitud1 = count($pagos1);
    $longitud2 = count($pagos2);
    //$longitud3 = count($pagos3);
    $longitud_f = 0;
    $pago = 1;
    $content1 = '';
    $dg_array = array(0, 0, 0, 0, 0, 0, 0, 0);
    $pm10_array = array(0, 0, 0, 0, 0, 0, 0, 0);
    $pm5_array = array(0, 0, 0, 0, 0, 0, 0, 0);
    $j = 0;
    $idgra1 = 0; //Se utiliza en caso de haber más de un estudiante por documento responsable
    
    if ($documento == 0) {
        $query = "SELECT e.*, m.id_grado, cu.matricula, cu.pension, cu.ocp, cu.poliza, cu.dg, cu.pp, eg.grado_ra 
        FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
        WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
        AND m.estado = 'activo' AND cu.a = $fanio AND m.id_grado = $idgra";
    }
    else {
        $query = "SELECT e.*, m.id_grado, cu.matricula, cu.pension, cu.ocp, cu.poliza, cu.dg, cu.pp, eg.grado_ra 
        FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
        WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
        AND m.estado = 'activo' AND cu.a = $fanio AND m.id_grado = $idgra AND e.n_documento = $documento";
    }
    //echo $query;
    
    $dg = -1; //Se utiliza para añadir una nueva página si tiene dg
    $dg1 = 0; //Se utiliza para añadir una nueva página si tiene dg
    $ct = 0;
    $resultado=$mysqli1->query($query);
    while($row = $resultado->fetch_assoc()){
        $number = 0;
        if($dg >= 0) {
            //No hace nada
        }
        else {
            $dg = -1;
        }
        $nombrecompleto = $row['apellidos'].' '.$row['nombres'];
        $idest = $row['id'];
        
        if($idgra > 16) {
            $longitud_f = $longitud2;
            $pagos_f = $pagos2;
        }
        else {
            $longitud_f = $longitud;
            $pagos_f = $pagos;
        }
        for($i=0; $i<$longitud_f; $i++) {
            if($pagos_f[$i] == "pm10") {
                //$pm10 = $row['pension'];
                $pm10 = $row['pension_final'];
            }
            else if($pagos_f[$i] == "pm5" && $idgra == 18) {
                //$pm10 = $row['pension'];
                $pm5 = $row['pension_final'];
            }
            else if($pagos_f[$i] == "dg") {
                $dg = $row['dg'];
            }
            $pm10dg = $pm10 + $dg;
            $pm5dg = $pm5 + $dg;
            
            //Se valida si $dg es igual a cero
            $content = '<html>';
            $content .= '<head>';
            $content .= '<style>';
            //$content .= '@font-face {font-family: "Anton"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/anton/v12/1Ptgg87LROyAm3Kz-C8.woff2) format("woff2");}';
            $content .= 'table {border-collapse: collapse; width: 100%;}';
            //$content .= 'thead, tr, td {text-align: center; border: 1px solid gray;}';
            $content .= 'thead, tr, td {text-align: center;}';
            $content .= '.thfondo {font-weight: bold; background: blue; color: white;}';
            $content .= 'span {background: #CEF6CE;}';
            $content .= 'body {}';
            //$content .= '.nom {font-family: "Marck Script"; font-weight: bold; font-size: 30pt;}';
            $content .= '#divhead {background: gray; color: white;}';
            $content .= '#divbody0 {width: 100%;}';
            //$content .= '#divop {background: blue; color: white;}';
            $content .= '.tdop {font-weight: bold; background: blue; color: white;}';
            $content .= 'tr {height: 25px;}';
            //$content .= '#lblconvenciones {color: purple;}';
            $content .= '.cpurple {color: purple;}';
            $content .= '.tdborde {border: 1px solid gray;}';
            $content .= '.tdsinborde {text-align: left;}';
            $content .= '.tdsinborde1 {color: white;}';
            //$content .= '.tdsinborde2 {border: 1px solid transparent;}';
            $content .= '.fondo1 {background: gray; color: white;}';
            $content .= '.ar {text-align: center;}';
            $content .= 'p {text-align: center;}';
            $content .= '#divnumletras {border: 2px solid black; height: 25px; font-weight: bold;}';
            $content .= '.h2 {font-size: 22px; font-weight: bold;}';
            $content .= '.h3 {font-size: 20px; font-weight: bold;}';
            $content .= '</style>';
            $content .= '</head><body>';
            
            $content1 = '';
            $content1 .= '<div>';
                $content1 .= '<div id="divhead">';
                    $content1 .= '<table>';
                        $content1 .= '<tbody>';
                            $content1 .= '<tr>';
                                $content1 .= '<td class="tdsinborde1">';
                                    $content1 .= '<h2>UNIDAD DE CAPACITACION EMPRESARIAL DE BOYACA</h2>';
                                    $content1 .= '<h2>NIT: 826.002.762-1</h2>';
                                $content1 .= '</td>';
                                $content1 .= '<td class="tdsinborde1"><img src="img/logoBlancoUnicab.png" width="168" height="140"/></td>';
                            $content1 .= '</tr>';
                        $content1 .= '</tbody>';
                    $content1 .= '</table>';
                $content1 .= '</div><br>';
                
                //Se consultan otros estudiantes con el mismo documento acudiente
                $sql_otros = "SELECT COUNT(1) ct 
                    FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
                    WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
                    AND e.documento_responsable = ".$row['documento_responsable']." AND m.estado = 'activo'";
                    
                $sql_otros1 = "SELECT e.*, m.id_grado, cu.matricula, cu.pension, cu.ocp, cu.poliza, cu.dg, cu.pp, eg.grado_ra 
                    FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
                    WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
                    AND e.documento_responsable = ".$row['documento_responsable']." AND m.estado = 'activo'";
                //echo $sql_otros1;
                $res_otros=$mysqli1->query($sql_otros);
                $res_otros1=$mysqli1->query($sql_otros1);
                while($rowo = $res_otros->fetch_assoc()){
                    $ct = $rowo['ct'];
                }
                //$ct = 1;
                if ($ct > 1) {
                    $content1 .= '<div>';
                        $content1 .= '<table>';
                            $content1 .= '<tbody>';
                                $content1 .= '<tr>';
                                    $content1 .= '<td>';
                                        $content1 .= '<h2>ORDEN DE PAGO No.</h2>';
                                    $content1 .= '</td>';
                                    $content1 .= '<td class="tdop">';
                                        $content1 .= '<h2>'.$row['documento_responsable'].'_'.$fanio.'_'.$pagos_f[$i].'_a</h2>';
                                    $content1 .= '</td>';
                                    $content1 .= '<td class="tdsinborde2"><h2>Fecha de expedición: '.$fecha2.'</h2></td>';
                                $content1 .= '</tr>';
                            $content1 .= '</tbody>';
                        $content1 .= '</table>';
                    $content1 .= '</div>';
                }
                else {
                    $content1 .= '<div>';
                        $content1 .= '<table>';
                            $content1 .= '<tbody>';
                                $content1 .= '<tr>';
                                    $content1 .= '<td>';
                                        $content1 .= '<h2>ORDEN DE PAGO No.</h2>';
                                    $content1 .= '</td>';
                                    $content1 .= '<td class="tdop">';
                                        $content1 .= '<h2>'.$row['n_documento'].'_'.$fanio.'_'.$pagos_f[$i].'</h2>';
                                    $content1 .= '</td>';
                                    $content1 .= '<td class="tdsinborde2"><h2>Fecha de expedición: '.$fecha2.'</h2></td>';
                                $content1 .= '</tr>';
                            $content1 .= '</tbody>';
                        $content1 .= '</table>';
                    $content1 .= '</div>';
                }
                
                $content1 .= '<p class="h2">DATOS DE REFERENCIA</p>';
                
                $content1 .= '<div id="divbody0">';
                    $content1 .= '<table>';
                        $content1 .= '<thead class="thfondo">';
                            $content1 .= '<tr>';
                                $content1 .= '<td class="tdop tdborde">NOMBRE FAMILIAR Y/O ACUDIENTE RESPONSABLE</td>';
                                $content1 .= '<td class="tdop tdborde">IDENTIFICACION</td>';
                            $content1 .= '</tr>';
                        $content1 .= '</thead>';
                        $content1 .= '<tbody>';
                            $content1 .= '<tr>';
                                //$content1 .= '<td class="tdborde">'.$row['apellidos'].' '.$row['nombres'].'</td>';
                                $content1 .= '<td class="tdborde">'.strtoupper($row['acudiente_1']).'</td>';
                                $content1 .= '<td class="tdborde">'.$row['documento_responsable'].'</td>';
                            $content1 .= '</tr>';
                        $content1 .= '</tbody>';
                    $content1 .= '</table>';
                $content1 .= '</div><br>';
                
                $content1 .= '<div id="divbody0">';
                    $content1 .= '<table>';
                        $content1 .= '<thead class="thfondo">';
                            $content1 .= '<tr>';
                                $content1 .= '<td class="tdop tdborde">NOMBRE ALUMNO</td>';
                                $content1 .= '<td class="tdop tdborde">IDENTIFICACION</td>';
                                $content1 .= '<td class="tdop tdborde">GRADO</td>';
                                $content1 .= '<td class="tdop tdborde">CONCEPTO</td>';
                                $content1 .= '<td class="tdop tdborde">REFERENCIA</td>';
                                $content1 .= '<td class="tdop tdborde">VALOR</td>';
                            $content1 .= '</tr>';
                        $content1 .= '</thead>';
                        $content1 .= '<tbody>';
                        
                        if ($ct > 1) {
                            $number = 0;
                            while($rowo1 = $res_otros1->fetch_assoc()){
                                $idgra1 = $rowo1['id_grado'];
                                $content1 .= '<tr>';
                                    $content1 .= '<td class="tdborde">'.$rowo1['apellidos'].' '.$rowo1['nombres'].'</td>';
                                    $content1 .= '<td class="tdborde">'.$rowo1['n_documento'].'</td>';
                                    $content1 .= '<td class="tdborde">'.$rowo1['grado_ra'].'</td>';
                                    if($idgra1 == 18) {
                                        $content1 .= '<td class="tdborde">'.$des2[$i].'</td>';
                                        $content1 .= '<td class="tdborde">'.$rowo1['n_documento'].'_'.$fanio.'_'.$pagos2[$i].'</td>';
                                    }
                                    else {
                                        $content1 .= '<td class="tdborde">'.$des[$i].'</td>';
                                        $content1 .= '<td class="tdborde">'.$rowo1['n_documento'].'_'.$fanio.'_'.$pagos[$i].'</td>';
                                    }
                                    
                                    if($pagos_f[$i] == "pp") {
                                        $valor = $rowo1['pension_final'] + $rowo1['matricula'] + $rowo1['ocp'] + $rowo1['poliza'];
                                        $content1 .= '<td class="tdborde">'.$valor.'</td>';
                                        $number += $valor;
                                    }
                                    else if ($pagos_f[$i] == "dg") {
                                        $dg_array[$j] = $rowo1['dg'];
                                        $content1 .= '<td class="tdborde">'.$rowo1['dg'].'</td>';
                                        $number += $rowo1['dg'];
                                        $dg = $rowo1['dg'];
                                        $dg1 += $rowo1['dg'];
                                    }
                                    else if ($pagos_f[$i] == "pm10") {
                                        $pm10_array[$j] = $rowo1['pension_final'];
                                        $content1 .= '<td class="tdborde">'.$rowo1['pension_final'].'</td>';
                                        $number += $rowo1['pension_final'];
                                    }
                                    else if ($pagos_f[$i] == "pm5") {
                                        $pm5_array[$j] = $rowo1['pension_final'];
                                        $content1 .= '<td class="tdborde">'.$rowo1['pension_final'].'</td>';
                                        $number += $rowo1['pension_final'];
                                    }
                                    else if ($pagos_f[$i] == "pm10dg") {
                                        $pm10dg = $dg_array[$j] + $pm10_array[$j];
                                        $content1 .= '<td class="tdborde">'.$pm10dg.'</td>';
                                        $number += $pm10dg;
                                    }
                                    else if ($pagos_f[$i] == "pm5dg") {
                                        $pm5g = $dg_array[$j] + $pm5_array[$j];
                                        $content1 .= '<td class="tdborde">'.$pm5dg.'</td>';
                                        $number += $pm5dg;
                                    }
                                    else {
                                        $content1 .= '<td class="tdborde">'.$rowo1['pension_final'].'</td>';
                                        //$number = $row['pension'];
                                        $number += $rowo1['pension_final'];
                                    }
                                    //echo "<br>".$pagos_f[$i]." ".$number;
                                    //echo "<br>dg=".$dg;
                                $content1 .= '</tr>';
                                $j++;
                            }
                            $j = 0;
                            $content1 .= '<tr>';
                                $content1 .= '<td colspan="4" class="tdsinborde"></td>';
                                $content1 .= '<td class="tdsinborde fondo1 h3 ar">TOTAL:</td>';
                                $content1 .= '<td class="tdsinborde fondo1 h3">$ '.$number.'</td>';
                            $content1 .= '</tr>';
                        }
                        else {
                            $content1 .= '<tr>';
                                $content1 .= '<td class="tdborde">'.$row['apellidos'].' '.$row['nombres'].'</td>';
                                $content1 .= '<td class="tdborde">'.$row['n_documento'].'</td>';
                                $content1 .= '<td class="tdborde">'.$row['grado_ra'].'</td>';
                                if($idgra == 18) {
                                    $content1 .= '<td class="tdborde">'.$des2[$i].'</td>';
                                    $content1 .= '<td class="tdborde">'.$row['n_documento'].'_'.$fanio.'_'.$pagos2[$i].'</td>';
                                }
                                else {
                                    $content1 .= '<td class="tdborde">'.$des[$i].'</td>';
                                    $content1 .= '<td class="tdborde">'.$row['n_documento'].'_'.$fanio.'_'.$pagos[$i].'</td>';
                                }
                                
                                if($pagos_f[$i] == "pp") {
                                    $valor = $row['pension_final'] + $row['matricula'] + $row['ocp'] + $row['poliza'];
                                    $content1 .= '<td class="tdborde">'.$valor.'</td>';
                                    $number = $valor;
                                }
                                else if ($pagos_f[$i] == "dg") {
                                    $content1 .= '<td class="tdborde">'.$row['dg'].'</td>';
                                    $number = $row['dg'];
                                    $dg = $row['dg'];
                                    $dg1 = $row['dg'];
                                }
                                else if ($pagos_f[$i] == "pm10dg") {
                                    $content1 .= '<td class="tdborde">'.$pm10dg.'</td>';
                                    $number = $pm10dg;
                                }
                                else if ($pagos_f[$i] == "pm5dg") {
                                    $content1 .= '<td class="tdborde">'.$pm5dg.'</td>';
                                    $number = $pm5dg;
                                }
                                else {
                                    $content1 .= '<td class="tdborde">'.$row['pension_final'].'</td>';
                                    //$number = $row['pension'];
                                    $number = $row['pension_final'];
                                }
                            $content1 .= '</tr>';
                            $content1 .= '<tr>';
                                $content1 .= '<td colspan="4" class="tdsinborde"></td>';
                                $content1 .= '<td class="tdsinborde fondo1 h3 ar">TOTAL:</td>';
                                $content1 .= '<td class="tdsinborde fondo1 h3">$ '.$number.'</td>';
                            $content1 .= '</tr>';
                        }
                        $content1 .= '</tbody>';
                    $content1 .= '</table>';
                $content1 .= '</div><br>';
                
                $content1 .= '<div id="divnumletras">';
                    $content1 .= '<p>SON: '.$formatter->toMoney($number, $decimals, $currency, $cents).'</p>';
                $content1 .= '</div>';
                
                if($ct > 1) {
                    if($pagos_f[$i] == "pp") {
                        $content1 .= '<p id="lblconvenciones" class="cpurple">* Primer pago (pp) => Matrícula (m) + pensión mes 1 (pm1) + otros cobros periódicos (ocp) + poliza.</p>';
                    }
                    else if($pagos_f[$i] == "pm10dg") {
                        $content1 .= '<p id="lblconvenciones" class="cpurple">* Pago mes 10 con dg (pm10dg) => pensión mes 10 (pm10) + derechos de grado.</p>';                        
                    }
                    else if($pagos_f[$i] == "pm5dg") {
                        $content1 .= '<p id="lblconvenciones" class="cpurple">* Pago mes 5 con dg (pm5dg) => pensión mes 5 (pm5) + derechos de grado</p>';                        
                    }
                }
                else {
                    if($pagos_f[$i] == "pp") {
                        $content1 .= '<p id="lblconvenciones" class="cpurple">* Primer pago (pp) => Matrícula (m) {'.$row['matricula'].'} + pensión mes 1 (pm1) {'.$row['pension_final'].'} + otros cobros periódicos (ocp) {'.$row['ocp'].'} + poliza {'.$row['poliza'].'}.</p>';
                    }
                    else if($pagos_f[$i] == "pm10dg") {
                        $content1 .= '<p id="lblconvenciones" class="cpurple">* Pago mes 10 con dg (pm10dg) => pensión mes 10 (pm10) {'.$row['pension_final'].'} + derechos de grado {'.$row['dg'].'}.</p>';                        
                    }
                    else if($pagos_f[$i] == "pm5dg") {
                        $content1 .= '<p id="lblconvenciones" class="cpurple">* Pago mes 5 con dg (pm5dg) => pensión mes 5 (pm5) {'.$row['pension_final'].'} + derechos de grado {'.$row['dg'].'}.</p>';                        
                    }
                }
            $content1 .= '</div>';
            
            $content1 .= '</body></html>';
            
            $nom_pdf = "op_".$row['grado_ra']."_".str_replace(" ","_",$nombrecompleto)."_".$fanio.".pdf";
            
            if ($pago == 1) {
                $mpdf->WriteHTML($content.$content1);
                //echo $content;
                //echo $content1;
            }
            else {
                //echo "<br>dg1=".$dg1;
                if($dg1 > 0 || $dg == -1) {
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($content.$content1);
                }
            }
            $pago++;
            $content1 = '';
        }
        
        $folder0 = '/op/'.$fanio.'/'.str_replace(" ","_",$row['grado_ra']).'/';
        $folder_correo = 'op/'.$fanio.'/'.str_replace(" ","_",$row['grado_ra']).'/';
        $folder = __DIR__.$folder0;
        //echo $nom_pdf;
        //echo "<br>".$folder;
        $ruta = "https://unicab.org/registro/financieraunicab".$folder0.$nom_pdf;
        //echo $ruta;
        
        // I = Inline; D = Download; F = File; S = Cadena
        //$mpdf->Output($nom_pdf, 'I');
        $mpdf->Output($folder.$nom_pdf, 'F');
        $pago = 1;
        //exit;
        
        //Se muestran los array
        /*for($k=0; $k<8; $k++) {
            echo "<br>";
            echo $k." ".$dg_array[$k];
            echo " | ".$pm5_array[$k];
            echo " | ".$pm10_array[$k];
        }*/
        
        // ###################### INICIO ENVIO DE CORREO ###################
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            //$mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = false;
            //$mail->Username   = 'numericopensamientoclei2@gmail.com';                     // SMTP username
            $mail->Username   = 'unicabfinanciera@gmail.com';
            $mail->Password   = 'Financiera2020#';
            //$mail->Username   = 'sistemasunicab@gmail.com';
            //$mail->Password   = 'psfa0301';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 25;
        
            //Recipients
            $mail->setFrom('unicabfinanciera@gmail.com');
            $mail->addAddress('g.h.fig.1073@gmail.com');     // Add a recipient
            //$mail->addAddress($row['email_acudiente_1']);     // Add a recipient
            //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
            //$mail->addCC('cc@example.com');
            $mail->addBCC('numericopensamientoclei2@gmail.com');
        
            // Attachments
            //$mail->addAttachment('../docenteunicab/dhonor/2020/prueba.pdf', 'prueba.pdf');
            $mail->addAttachment($folder_correo.$nom_pdf, $nom_pdf);         // Add attachments
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Ordenes de pago UNICAB '.$fanio;
            /*$mail->Body    = '<p>Señor(a): GREGORY FIGUEREDO</p>
                <br><p>Este es un envío de correo automático de UNICAB COLEGIO VIRTUAL.</p>
                <p>A continuación encontrará un documento pdf con las órdenes de pago de cada uno de los conceptos.</p>
                <p>Para proceder con el pago diríjase a una de las entidades bancarias o a uno de los diferentes canales de pago virtual que UNICAB ofrece en nuestra página (https://unicab.org/pagos_payservices.php ).</p>
                <p>Utilice el número de orden de pago como referencia de pago.</p>
                <p>También le recomendamos hacer el pago del mes 10 y los derechos de grado en un solo pago. Encontrará ésta orden al final del documento para los grados quinto, noveno, once, ciclo IV y ciclo VI.</p>
                <p>Si también desea hacer el pago de más de un mes al mismo tiempo, puede comunicarse con el área de financiera (correo: unicabfinanciera@gmail.com; cel: 318 714 3774) para solicitar una orden de pago que agrupe los meses a pagar.</p>
                <br><p>--</p>
                <p>Área Financiera</p>
                <p>UNICAB COLEGIO VIRTUAL</p>
                <p>cel 3187143774</p>';*/
            $mail->Body    = '<p>Señor(a): '.strtoupper($row['acudiente_1']).'</p>
                <br><p>Este es un envío de correo automático de UNICAB COLEGIO VIRTUAL.</p>
                <p>A continuación encontrará un documento pdf con las órdenes de pago de cada uno de los conceptos.</p>
                <p>Para proceder con el pago diríjase a una de las entidades bancarias o a uno de los diferentes canales de pago virtual que UNICAB ofrece en nuestra página (https://unicab.org/pagos_payservices.php ).</p>
                <p>Utilice el número de orden de pago como referencia de pago.</p>
                <p>También le recomendamos hacer el pago del mes 10 y los derechos de grado en un solo pago. Encontrará ésta orden al final del documento para los grados quinto, noveno, once, ciclo IV y ciclo VI.</p>
                <br><p>--</p>
                <p>Área Financiera</p>
                <p>UNICAB COLEGIO VIRTUAL</p>
                <p>cel 3187143774</p>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            //echo 'Message has been sent';
            $msg_correo = "CorreoOK";
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $msg_correo = "CorreoError";
        }
        
        // ###################### FIN ENVIO DE CORREO ###################
        
        $mpdf = new \Mpdf\Mpdf(["format" => "Letter-L", "margin_left" => 10, "margin_right" => 10, "margin_top" => 10, "margin_bottom" => 0]);
        $mpdf->SetDisplayMode('fullpage');
        $dg = -1;
        $dg1 = 0;
        $ct = 0;
        $j = 0;
        //Se limpian los array
        for($k=0; $k<8; $k++) {
            $dg_array[$k] = 0;
            $pm5_array[$k] = 0;
            $pm10_array[$k] = 0;
        }
        //Se muestran los array
        /*for($k=0; $k<8; $k++) {
            echo "<br>";
            echo $k." ".$dg_array[$k];
            echo " | ".$pm5_array[$k];
            echo " | ".$pm10_array[$k];
        }*/
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM tbl_ordenes_pago WHERE ruta = '$ruta' AND a = $fanio";
        $exe_sql_val=$mysqli1->query($sql_validacion);
        //echo $sql_validacion;
    	$ct_pdf = $mysqli1->affected_rows;
    	//echo $ct_pdf;
        
        if($ct_pdf > 0) {
            $sql_upd="UPDATE tbl_ordenes_pago SET fecha_expedicion = '".$fecha2."', msgcorreo = '".$msg_correo."' WHERE ruta = '".$ruta."'";
            //echo $sql_upd;
            $exe_upd=mysqli_query($conexion,$sql_upd);
        }
        else {
            $sql_insert='INSERT INTO tbl_ordenes_pago (fecha_expedicion, id_estudiante, id_grado, a, ruta, identificacion, msgcorreo) 
            VALUES ("'.$fecha2.'",'.$idest.','.$idgra.','.$fanio.',"'.$ruta.'",'.$row['n_documento'].',"'.$msg_correo.'")';
            //echo $sql_insert;
            $exe_insert=mysqli_query($conexion,$sql_insert);
        }
    }
    
    //$nom_pdf = "dhm_".str_replace(" ","_","Grado 1°")."_".str_replace(" ","_","Maria Paulina Figueredo Rodriguez")."_".$fanio.".pdf";
    	
	//$folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
    //$folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_","Grado 1°").'/';
    //$folder = __DIR__.$folder0;
    
    //$mpdf->WriteHTML($content.$content1);
    //$mpdf->WriteHTML('<div>Section 1 text</div>');
    // I = Inline; D = Download; F = File; S = Cadena
    //$mpdf->Output($nom_pdf, 'I');
    //$mpdf->Output($folder.$nom_pdf, 'F');
    //exit;
    
    if ($documento == 0) {
        $query_op = "SELECT *  FROM tbl_ordenes_pago WHERE fecha_expedicion >= '$fecha2' AND id_grado = $idgra";
    }
    else {
        $query_op = "SELECT *  FROM tbl_ordenes_pago WHERE fecha_expedicion >= '$fecha2' AND id_grado = $idgra AND identificacion = $documento";
    }
    //echo $query_op;
    $exe_query_op = mysqli_query($conexion,$query_op);
    	
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
                    <td>IDENTIFICACION</td>
                    <td>MSG_CORREO</td>
                </tr>
            </thead>
            <tbody>
            <?php  
                while ($row_tc=mysqli_fetch_array($exe_query_op)) {
            ?>
                <tr>
                    <td><?php echo $row_tc['id_estudiante']; ?></td>
                    <td><?php echo $row_tc['id_grado']; ?></td>
                    <td><?php echo $row_tc['ruta']; ?></td>
                    <td><?php echo $row_tc['identificacion']; ?></td>
                    <td><?php echo $row_tc['msgcorreo']; ?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>
    </body>
</html>
