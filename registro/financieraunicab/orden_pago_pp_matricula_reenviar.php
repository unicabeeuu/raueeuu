<?php
    include "../adminunicab/php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/financieraunicab/orden_pago_pp_matricula_reenviar.php?documento=1014883369
    
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
    $mpdf = new \Mpdf\Mpdf(["format" => "Letter", "margin_left" => 10, "margin_right" => 10, "margin_top" => 10, "margin_bottom" => 0]);
    $mpdf->SetDisplayMode('fullpage');
    
    $idest = $_REQUEST['idest'];
    $documento = $_REQUEST['documento'];
    //$tdoc = $_REQUEST['register_tipo_documento'];
    //$cel = $_REQUEST['register_telefono'];
    //$email = $_REQUEST['register_email'];
    //$estnuevo = $_REQUEST['estnuevo'];
    //$td_text = $_REQUEST['td_text'];
    //echo $documento;
    
    //echo $estnuevo;
    
    //Se buscan los datos del estudiante
    $sql_datos = "SELECT e.*, m.* 
    FROM estudiantes e, matricula m 
    WHERE e.id = m.id_estudiante AND e.n_documento = '$documento' AND m.estado IN ('pre_solicitud','solicitud')";
    $exe_datos = $mysqli1->query($sql_datos);
    while($row_datos = $exe_datos->fetch_assoc()) {
        $idest = $row_datos['id'];
        $nombres = $row_datos['nombres'];
        $apellidos = $row_datos['apellidos'];
        $idgra = $row_datos['id_grado'];
        $documentoA = $row_datos['documento_responsable'];
        $nombre_completoA = $row_datos['acudiente_1'];
        $emailA = $row_datos['email_acudiente_1'];
        $n_matricula = $row_datos['n_matricula'];
    }
    $nombre_completo = $apellidos." ".$nombres;
    echo "<br>nombre_completoA=".$nombre_completoA;
    echo "<br>emailA=".$emailA;
    
    $nom_pdf = "";
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $faniop=date("Y");
    $espaniol="";
    //echo $fanio;
    if($mes == 12) {
	    $fanio++;
	}
    
    $fecha2 = $fanio."/".$mes."/". $dia;
    $fecha_cbpp = date("Ymd");
    if($mes == "02") {
        $diapp = 28;
    }
    else {
        $diapp = 30;
    }
    $fecha1_cbpp = $fanio.$mes.$diapp;
    $fecha2_cbpp = date("Ymd",strtotime($fecha1_cbpp."+ 30 days"));
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
    
    $codigo = "";
	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
            "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
	
	for($i = 1; $i <=10; $i++) {
		$ale=mt_rand(1,sizeof($sa1));
		$codigo = $codigo.$sa1[$ale-1];
	}
	//echo $codigo;
	
	//Se valida si el documento ya tiene código de pre-matrícula para el año lectivo
	$ct_pre = 0;
	$sql = "SELECT COUNT(1) ct, codigo FROM tbl_cod_pre_matricula WHERE identificacion = $documento AND periodo_lectivo = $fanio 
	GROUP BY codigo";
	//echo $sql;
	
	$res_sql=$mysqli1->query($sql);
    while($row_sql = $res_sql->fetch_assoc()){
        $ct_pre = $row_sql['ct'];
        $codigo = $row_sql['codigo'];
    }
    //echo "<br>".$codigo;
    //echo $ct_pre;
    if($ct_pre == 0) {
        $sql_insert0 = "INSERT INTO tbl_cod_pre_matricula (identificacion, periodo_lectivo, codigo, email_pre_mat) VALUES 
        ($documento, $fanio, '$codigo', '$email')";
        //echo $sql_insert0;
        //$res_insert0=$mysqli1->query($sql_insert0);
    }
    
    
    //**************************************************************************************************************
    //Se actualizan las tablas de estudiantes con los pagos y matrículas
    
    //Se valida la fecha actual con respecto a los cierres de periodo para el periodo de ingreso
    $per = "1";
	if(date($fecha2) >= date('2021/02/03') && date($fecha2) < date('2021/04/11')) {
	    $per = "1";
	}
	else if(date($fecha2) >= date('2021/04/11') && date($fecha2) < date('2021/06/28')) {
	    $per = "2";
	}
	else if(date($fecha2) >= date('2021/06/28') && date($fecha2) < date('2021/09/12')) {
	    $per = "3";
	}
	else if(date($fecha2) >= date('2021/09/12')) {
	    $per = "4";
	}
	//beca = 0 -> sin beca; = 1 media beca; = 2 beca completa
	//pension_a -> es la nueva pensión de promoción anticipada
	$beca = 0;
    $descuento = 0;
    $ct_pagos = 0;
        
	$sql_beca = "SELECT * FROM tbl_becas WHERE identificacion = $documento AND periodo_lectivo = $fanio";
	$res_beca=$mysqli1->query($sql_beca);
    while($row_beca = $res_beca->fetch_assoc()){
        $beca = $row_beca['beca'];
        $descuento = $row_beca['descuento'];
        $ct_pagos = $row_beca['ct_pagos'];
    }
    
    $sql_costos = "SELECT * FROM tbl_costos_unicab WHERE a = $fanio AND id_grado = $idgra";
    echo "<br>sql_costos=".$sql_costos;
	$res_costos=$mysqli1->query($sql_costos);
    while($row_costos = $res_costos->fetch_assoc()){
        $matricula = $row_costos['matricula'];
        $pension = $row_costos['pension'];
        $ocp = $row_costos['ocp'];
        $poliza = $row_costos['poliza'];
        $dg = $row_costos['dg'];
        $pp = $row_costos['pp'];
    }
    
    if($idgra > 16) {
        if($per == 2) {
            $pagos_anuales_de = 2.5;
        }
        else {
            $pagos_anuales_de = 5;
        }
    }
    else {
        if($per == 2) {
            $pagos_anuales_de = 7.5;
        }
        else if($per == 3) {
            $pagos_anuales_de = 5;
        }
        else {
            $pagos_anuales_de = 10;
        }
    }
    $total_anual_de = $pension * $pagos_anuales_de;
    $descuento1 = $descuento/100 * $pension;
    $total_anual_sd = ($pension - $descuento1) * $pagos_anuales_de;
    if($beca == 1) {
        $beca1 = $pension/2;
    }
    else if($beca == 2) {
        $beca1 = $pension;
    }
    else {
        $beca1 = 0;
    }
    $total_anual_sb = ($pension - $beca1) * $pagos_anuales_de;
    $pension_final = $total_anual_sb / $pagos_anuales_de;
    
    $estnuevo = "NO";
    if($estnuevo == "NO") {
        /*$sql_updins_est = "UPDATE estudiantes SET periodo_ing = $per, descuento = $descuento, beca = $beca, acuerdo_ct_pagos = $ct_pagos, pension_de = $pension, 
        pension_a = 0, pagos_anuales_de = $pagos_anuales_de, pagos_anuales_a = 0, pagos_anuales_f = $pagos_anuales_de, tot_anual_de = $total_anual_de, 
        descuento1 = $descuento1, tot_anual_sd = $total_anual_sd, beca1 = $beca1, tot_anual_sb = $total_anual_sb, pension_final = $pension_final 
        WHERE n_documento = '$documento'";*/
        $sql_updins_est = "UPDATE estudiantes SET periodo_ing = $per, descuento = $descuento, beca = $beca, acuerdo_ct_pagos = $ct_pagos, pension_de = $pension, 
        pension_a = 0, pagos_anuales_de = $pagos_anuales_de, pagos_anuales_a = 0, pagos_anuales_f = $pagos_anuales_de, tot_anual_de = $total_anual_de, 
        descuento1 = $descuento1, tot_anual_sd = $total_anual_sd, beca1 = $beca1, tot_anual_sb = $total_anual_sb, pension_final = $pension_final, 
        email_acudiente_1 = '$emailA', acudiente_1 = '$nombre_completoA', telefono_acudiente_1 = '$celA', documento_responsable = '$documentoA' 
        WHERE n_documento = '$documento'";
    }
    else if($estnuevo == "SI") {
        $sql_updins_est = "INSERT INTO estudiantes 
        (apellidos, nombres, genero, tipo_documento, n_documento, fecha_nacimiento, expedicion, ciudad, direccion, direccion_estudiante, telefono_estudiante, email_institucional, 
        actividad_extra, email_acudiente_1, email_acudiente_2, acudiente_1, acudiente_2, telefono_acudiente_1, telefono_acudiente_2, estado, password, mensaje, fecha_datos, 
        documento_responsable, periodo_ing, descuento, beca, acuerdo_ct_pagos, pension_de, pension_a, pagos_anuales_de, pagos_anuales_a, pagos_anuales_f, tot_anual_de, 
        descuento1, tot_anual_sd, beca1, tot_anual_sb, pension_final) 
        VALUES 
        ('$apellidos', '$nombres', 'NA', '$tdoc', '$documento', '1900/01/01', 'NA', 'NA', '$dirA', 'NA', '$cel', 'NA', 
        'NA', '$emailA', 'NA', '$nombre_completoA', 'NA', '$celA', 'NA', 'NA', 'NA', 'NA', '$fecha2', 
        '$documentoA', $per, $descuento, $beca, $ct_pagos, $pension, 0, $pagos_anuales_de, 0, $pagos_anuales_de, $total_anual_de, 
        $descuento1, $total_anual_sd, $beca1, $total_anual_sb, $pension_final)";
    }
    echo "<br>sql_updins_est=".$sql_updins_est;
    //$res_updinst_est = $mysqli1->query($sql_updins_est);
    
    //Se hace el insert en la tabla de matrículas
	if($idest > 0) {
	    //Se valida si ya existe un registro en estado pre_solicitud
	    $ct_matric = 0;
	    $sql_valm = "SELECT COUNT(1) ct FROM matricula WHERE n_matricula = '$n_matricula' AND id_estudiante = $idest AND estado = 'pre_solicitud'";
	    $msg_estudiante = "EstudianteOK";
	    $exe_valm = mysqli_query($conexion,$sql_valm);
        while ($row_valm = mysqli_fetch_array($exe_valm)) {
            $ct_matric = $row_valm['ct'];
        }
        echo "<br/>ct_matric=".$ct_matric;
        if($ct_matric == 0) {
            $sql_insert1 = "INSERT INTO matricula (n_matricula, fecha_ingreso, estado, id_estudiante, id_grado, EstadoGrado) 
            VALUES ('$n_matricula', '$fecha2', 'pre_solicitud', $idest, $idgra, 'NA')";
            echo "<br/>".$sql_insert1;
            //$exe_insert1=mysqli_query($conexion,$sql_insert1);
        }
	}
	
    //************FIN ACTUALIZACION TABLAS ESTUDIANTES Y MATRICULA **************************************************************
    
    /*$pagos = array("pp");
    $des = array("Primer pago");*/
    
    $query = "SELECT DISTINCT e.*, m.id_grado, cu.matricula, cu.pension, cu.ocp, cu.poliza, cu.dg, cu.pp, eg.grado_ra, 
        lpad(e.n_documento, 12, 0) n_documentolargo, lpad(cu.pp, 8, 0) pplargo 
        FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
        WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
        AND m.estado IN ('pre_solicitud', 'solicitud') AND cu.a = $fanio AND m.id_grado = $idgra AND e.n_documento = $documento";
    //echo $query;
    
    $ct = 0;
    $resultado=$mysqli1->query($query);
    while($row = $resultado->fetch_assoc()){
        
        $content = '<html>';
        $content .= '<head>';
        $content .= '<style>';
        //$content .= '@font-face {font-family: "Anton"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/anton/v12/1Ptgg87LROyAm3Kz-C8.woff2) format("woff2");}';
        $content .= 'table {border-collapse: collapse; width: 100%;}';
        //$content .= 'thead, tr, td {text-align: center; border: 1px solid gray;}';
        $content .= 'thead, tr, td {text-align: center;}';
        $content .= '.thfondo {font-weight: bold; background: lightblue; color: black;}';
        $content .= 'span {background: #CEF6CE;}';
        $content .= 'body {}';
        //$content .= '.nom {font-family: "Marck Script"; font-weight: bold; font-size: 30pt;}';
        $content .= '#divhead {background: gray; color: white;}';
        $content .= '#divbody0 {width: 100%;}';
        //$content .= '#divop {background: blue; color: white;}';
        $content .= '.tdop {font-weight: bold; background: lightblue; color: black;}';
        $content .= 'tr {height: 25px;}';
        //$content .= '#lblconvenciones {color: purple;}';
        $content .= '.cpurple {color: purple;}';
        $content .= '.crojo {color: red; font-weight: bold; font-size: 12px; text-align: justify;}';
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
        $content .= '.h4 {font-size: 16px; font-weight: bold;}';
        $content .= '</style>';
        $content .= '</head><body>';
        
        $content1 = '';
        $content1 .= '<div>';
            $content1 .= '<div id="divhead">';
                $content1 .= '<table>';
                    $content1 .= '<tbody>';
                        $content1 .= '<tr>';
                            $content1 .= '<td class="tdsinborde1">';
                                $content1 .= '<h3>UNIDAD DE CAPACITACION EMPRESARIAL DE BOYACA</h3>';
                                $content1 .= '<h3>NIT: 826.002.762-1</h3>';
                            $content1 .= '</td>';
                            $content1 .= '<td class="tdsinborde1"><img src="img/logoBlancoUnicab.png" width="168" height="140"/></td>';
                        $content1 .= '</tr>';
                    $content1 .= '</tbody>';
                $content1 .= '</table>';
            $content1 .= '</div><br>';
            
            $content1 .= '<div>';
                $content1 .= '<table>';
                    $content1 .= '<tbody>';
                        $content1 .= '<tr>';
                            $content1 .= '<td>';
                                $content1 .= '<h4>ORDEN DE PAGO No.</h4>';
                            $content1 .= '</td>';
                            $content1 .= '<td class="tdop">';
                                $content1 .= '<h4>'.$documento.'_'.$fanio.'_pp</h4>';
                            $content1 .= '</td>';
                            $content1 .= '<td class="tdsinborde2"><h4>Fecha de expedición: '.$fecha2.'</h4></td>';
                        $content1 .= '</tr>';
                    $content1 .= '</tbody>';
                $content1 .= '</table>';
            $content1 .= '</div><br>';
            
            $content1 .= '<p class="h4">DATOS DE REFERENCIA</p>';
            
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
                            $content1 .= '<td class="tdborde">'.strtoupper($nombre_completoA).'</td>';
                            $content1 .= '<td class="tdborde">'.$documentoA.'</td>';
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
                    
                    $content1 .= '<tr>';
                            $content1 .= '<td class="tdborde">'.$apellidos.' '.$nombres.'</td>';
                            $content1 .= '<td class="tdborde">'.$documento.'</td>';
                            $content1 .= '<td class="tdborde">'.$row['grado_ra'].'</td>';
                            $content1 .= '<td class="tdborde">Primer pago</td>';
                            $content1 .= '<td class="tdborde">'.$documento.'_'.$fanio.'_pp</td>';
                            $valor = $row['pension_final'] + $row['matricula'] + $row['ocp'] + $row['poliza'];
                            $content1 .= '<td class="tdborde">'.$valor.'</td>';
                            $number = $valor;
                        $content1 .= '</tr>';
                        $content1 .= '<tr>';
                            $content1 .= '<td colspan="4" class="tdsinborde"></td>';
                            $content1 .= '<td class="tdsinborde fondo1 h3 ar">TOTAL:</td>';
                            $content1 .= '<td class="tdsinborde fondo1 h3">$ '.$number.'</td>';
                        $content1 .= '</tr>';
                    $content1 .= '</tbody>';
                $content1 .= '</table>';
            $content1 .= '</div><br>';
            
            $content1 .= '<div id="divnumletras">';
                $content1 .= '<p>SON: '.$formatter->toMoney($number, $decimales, $currency, $cents).'</p>';
            $content1 .= '</div>';
            
            $content1 .= '<p id="lblconvenciones" class="cpurple">* Primer pago (pp) => Matrícula (m) {'.$row['matricula'].'} + pensión mes 1 (pm1) {'.$row['pension_final'].'} + otros cobros periódicos (ocp) {'.$row['ocp'].'} + poliza {'.$row['poliza'].'}.</p>';
            
            //Las siguientes líneas son el mensaje en caso de liquidar el primer pago con los valores del año anterior **********************************
            $connota = 0;
            $sql_nota_costos = "SELECT v1 FROM tbl_parametros WHERE parametro = 'nota_costos_año_anterior'";
            $exe_nota_costos = $mysqli1->query($sql_nota_costos);
            while($row_nota_costos = $exe_nota_costos->fetch_assoc()) {
                $connota = $row_nota_costos['v1'];
            }
            if($connota == 1) {
                $content1 .= '<p class="crojo">';
                $content1 .= 'NOTA: La presente liquidación se encuentra expedida según resolución de costos para la vigencia 2020. Los costos por conceptos académicos ';
                $content1 .= 'se encuentran supeditados al incremento anual establecido por el órgano de control, una vez expedido el acto administrativo, ';
                $content1 .= 'se realizará el ajuste según lo ordenado para la vigencia 2021. Agradecemos su comprensión.';
                $content1 .= '</p>';
            }
            //*******************************************************************************************************************************************
            
            /*$content1 .= '<hr><p>Para pagos en Banco Caja Social</p>
            <img src="barcode.php?text='.$row['n_documentolargo'].$fanio.'01'.$row['pplargo'].$fecha1_cbpp.$row['pplargo'].$fecha2_cbpp.'&size=50&codetype=code39&print=true&sizefactor=1"/><hr>
            <img src="barcode.php?text='.$row['n_documentolargo'].$fanio.'01'.$row['pplargo'].$fecha1_cbpp.$row['pplargo'].$fecha2_cbpp.'&size=50&codetype=code128&print=true&sizefactor=1"/><hr>';*/
            
        $content1 .= '</div>';
        
        $content1 .= '</body></html>';
        
        $nom_pdf = "oppp_".$row['grado_ra']."_".str_replace(" ","_",$nombre_completo)."_".$fanio.".pdf";
        
        $mpdf->WriteHTML($content.$content1);
        echo $content;
        echo $content1;
        
        //Se crea la carpeta
        $path = 'op/'.$fanio.'/'.str_replace(" ","_",$row['grado_ra']).'/';
        //echo $path;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        $folder0 = '/op/'.$fanio.'/'.str_replace(" ","_",$row['grado_ra']).'/';
        //echo $folder0;
        $folder_correo = 'op/'.$fanio.'/'.str_replace(" ","_",$row['grado_ra']).'/';
        $folder = __DIR__.$folder0;
        //echo $nom_pdf;
        //echo "<br>".$folder;
        $ruta = "https://unicab.org/registro/financieraunicab".$folder0.$nom_pdf;
        //echo "<br>".$ruta;
        
        // I = Inline; D = Download; F = File; S = Cadena
        //$mpdf->Output($nom_pdf, 'I');
        $mpdf->Output($folder.$nom_pdf, 'F');
        //echo "hasta aquí OK";
        
        // ###################### INICIO ENVIO DE CORREO ###################
        $mail = new PHPMailer(true);
        
        try {
            //echo $email;
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
            //$mail->addAddress('g.h.fig.1073@gmail.com');     // Add a recipient
            //$mail->addAddress('unicabfinanciera@gmail.com');     // Add a recipient
            $mail->addAddress($emailA);     // Add a recipient
            //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
            //$mail->addCC('cc@example.com');
            $mail->addBCC('numericopensamientoclei2@gmail.com');
        
            // Attachments
            //$mail->addAttachment('../docenteunicab/dhonor/2020/prueba.pdf', 'prueba.pdf');
            $mail->addAttachment($folder_correo.$nom_pdf, $nom_pdf);         // Add attachments
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'CONFIRMACION CORREO PROCESO DE MATRICULA UNICAB 2021'.$fanio;
            $mail->Body    = '<p>Señor(a): '.strtoupper($nombre_completoA).'</p>
                <br><p>Este es un envío de correo automático de UNICAB COLEGIO VIRTUAL.</p>
                <p>A continuación encontrará un documento pdf con la órden de pago del primer pago.</p>
                <p>Para proceder con el pago diríjase a una de las entidades bancarias o a uno de los diferentes canales de pago virtual que UNICAB ofrece en nuestra página:  
                <a href="https://unicab.org/pagos_payservices.php">PAGOS VIRTUALES</a>.</p>
                <p>Utilice el número de orden de pago como referencia de pago.</p>
                <p>Haga clic <a download style="color:#0C0; display:inline-block;" href="https://unicab.org/assets/descargas/matricula/CONTRATO_DE_MATRICULA_UNICAB_2021.pdf">AQUI</a> para descargar el Contrato de Matrícula. Diligéncielo y escanéelo en un sólo archivo pdf.</p><hr>
                <p>Haga clic <a href="https://unicab.org/admisiones_final.php?c='.$codigo.'">AQUI</a> para que termine el proceso de matrícula.</p>
                <br><p>--</p>
                <p>Áreas de Admisiones y Financiera</p>
                <p>UNICAB COLEGIO VIRTUAL</p>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            //echo 'Message has been sent';
            $msg_correo = "CorreoOK";
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $msg_correo = "CorreoError";
        }
        
        // ###################### FIN ENVIO DE CORREO ###################
        
        $mpdf = new \Mpdf\Mpdf(["format" => "Letter", "margin_left" => 10, "margin_right" => 10, "margin_top" => 10, "margin_bottom" => 0]);
        $mpdf->SetDisplayMode('fullpage');
        
        //Se valida si el archivo pdf ya existe
        $sql_validacion = "SELECT * FROM tbl_ordenes_pago WHERE ruta = '$ruta' AND a = $fanio";
        //$exe_sql_val=$mysqli1->query($sql_validacion);
        //echo $sql_validacion;
    	$ct_pdf = $mysqli1->affected_rows;
    	//echo $ct_pdf;
        
        if($ct_pdf > 0) {
            $sql_upd="UPDATE tbl_ordenes_pago SET fecha_expedicion = '".$fecha2."', msgcorreo = '".$msg_correo."' WHERE ruta = '".$ruta."'";
            //echo $sql_upd;
            //$exe_upd=mysqli_query($conexion,$sql_upd);
        }
        else {
            $sql_insert='INSERT INTO tbl_ordenes_pago (fecha_expedicion, id_estudiante, id_grado, a, ruta, identificacion, msgcorreo) 
            VALUES ("'.$fecha2.'",'.$idest.','.$idgra.','.$fanio.',"'.$ruta.'",'.$row['n_documento'].',"'.$msg_correo.'")';
            //echo $sql_insert;
            //$exe_insert=mysqli_query($conexion,$sql_insert);
        }
    }
    
    if ($msg_correo == "CorreoOK") {
        $query_op = "SELECT *  FROM tbl_ordenes_pago WHERE fecha_expedicion >= '$fecha2' AND id_grado = $idgra AND identificacion = $documento";
    }
    //echo $query_op;
    //$exe_query_op = mysqli_query($conexion,$query_op);
    
    
    //$resultado = $msg_correo1."_".$msg_estudiante."_".$msg_matricula;
    $resultado = $msg_correo."_".$msg_estudiante."_".$emailA;
    echo "<br>".$resultado;
    
    //Se hace el insert en la tabla de solicitudes
	$sql_log = 'INSERT INTO solicitudes_matricula (msg, id_est, sentencia) VALUES ("'.$resultado.'", '.$idest.', "'.$sql_insert1.'")';
	//$exe_log=mysqli_query($conexion,$sql_log);
	
    //redireccionamos a la misma url conforme se ha enviado correctamente con la variable si
	//header('Location: ../../resultado_pre_admisiones_f.php?s='.$resultado);
    	
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
