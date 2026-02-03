<?php
    include "../adminunicab/php/conexion.php";
    require("updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/carnet_mpdf.php?selgra1=10&idest=621&tipo_carnet=EST
    
    $idgra = strtoupper($_REQUEST['selgra1']);
    $id = $_REQUEST['idest'];
    $tipo_c = $_REQUEST['tipo_carnet'];
    //$idgra = 10;
    //$id = 621;
    if(!$idgra) {
        $idgra = 0;
    }
    //echo $idgra;
    $nom_pdf = "";
    
    //Estas líneas son para generar qr
    require '../financieraunicab/phpqrcode/qrlib.php';
    $dir = 'carnets/qr/';
    
    include 'updreg/mpdf8/vendor/autoload.php';
    
    require('../financieraunicab/PHPMailer_master/src/Exception.php');
    require('../financieraunicab/PHPMailer_master/src/PHPMailer.php');
    require('../financieraunicab/PHPMailer_master/src/SMTP.php');
    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
    
    require('AttachMailer.php');
    
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
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    
    $fecha2 =$fanio."/".$mes."/". $dia;
	//echo $fecha2;
	
	$content = '<html>';
    $content .= '<head>';
    //$contect .= '<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&display=swap" rel="stylesheet">';
    $content .= '<style>';
        $content .= '@font-face {font-family: "HelveticaBold"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Helvetica-Bold.ttf") format("TrueType");}';
        $content .= '@font-face {font-family: "Helvetica"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Helvetica.ttf") format("TrueType");}';
        $content .= '@font-face {font-family: "HelveticaBoldObliq"; src: url("updreg/mpdf8/vendor/mpdf/mpdf/ttfonts/Helvetica-BoldOblique.ttf") format("TrueType");}';
        
        //$content .= '#divcontenido {display: flex; justify-content: space-around; margin-left: 100px;}';
        //$content .= '#tblfondo {border-collapse: collapse; width: 1004px; margin-top: 350px;}';
        //$content .= '#tblfondo {border: 2px solid black; width: 1004px; margin-top: 350px;}';
        $content .= 'thead, tr, td {text-align: center;}';
        //$content .= 'thead {font-weight: bold;}';
        $content .= '#div2 {width: 1004px; height: 650px; background-image: url("carnets/img/fondo_carnet_2021_6.jpg"); background-repeat: no-repeat; background-size: cover;  margin-left: 100px; border: 1px dashed lightgray;}';
        $content .= '#div4 {width: 1004px; height: 650px; background-image: url("carnets/img/posterior_1.jpg"); background-repeat: no-repeat; background-size: cover;  margin-left: 100px;}';
        $content .= '#div1, #div3 {width: 10%; height: 100px;  margin-left: 100px;}';
        $content .= '.nom {font-family: "HelveticaBold"; font-weight: bold; font-size: 18pt; color: white;}';
        $content .= '.nom1 {font-family: "Helvetica"; font-weight: bold; font-size: 24pt; color: white;}';
        $content .= '#imgqr {margin-bottom: 10px;}';
        //$content .= 'div {border: 2px solid black;}';
        $content .= 'p {line-height: 90%;}';
        $content .= '#divcontxt {margin-top: 335px;}';
        $content .= '#divtxt {width: 620px; height: 200px; float: left; margin-left: 10px;  text-align: center;}';
        $content .= '#divqr {width: 260px; height: 260px; float: left; margin-left: 70px;}';
    $content .= '</style>';
    $content .= '</head><body>';
    $content1 = "";
    
    //Se hace la consulta para generar los carnets
    if($id == 0) {
        if($tipo_c == "EST") {
            $sql_carnets = "SELECT e.*, g.grado, m.id_grado, m.grupo 
            FROM estudiantes e, matricula m, grados g 
            WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
            AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = $fanio AND m.id_grado = $idgra AND e.estado != 'NA'";
        }
        else if($tipo_c == "EMP") {
            $sql_carnets = "SELECT * FROM tbl_empleados WHERE rh != 'NA'";
        }
    }
    else {
        if($tipo_c == "EST") {
            $sql_carnets = "SELECT e.*, g.grado, m.id_grado, m.grupo 
            FROM estudiantes e, matricula m, grados g 
            WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
            AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = $fanio AND m.id_grado = $idgra AND e.estado != 'NA' AND e.id = $id";
        }
        else if($tipo_c == "EMP") {
            $sql_carnets = "SELECT * FROM tbl_empleados WHERE id = $id AND rh != 'NA'";
        }
    }
    //echo $sql_carnets;
    
    $exe_carnets = $mysqli1->query($sql_carnets);
    while($row_carnets = $exe_carnets->fetch_assoc()) {
        $nombre_completo = $row_carnets['nombres']." ".$row_carnets['apellidos'];
        $id1 = $row_carnets['id'];
        
        //Se crea la carpeta del codigo qr
        if($tipo_c == "EST") {
            $path = $dir.$fanio.'/'.str_replace(" ","_",$row_carnets['grado']).'/';
        }
        else {
            $path = $dir.$fanio.'/Empleados/';
        }
        //echo $path;
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        
        $filename = $path.'qr_'.$nombre_completo.'.png';
        $tamano = 10; //
        $level = 'H'; //Tipo de precisión: Baja: L, Mediana: M, Alta: Q y Máxima: H
        $framesize = 2; //Marco en blanco alrededor de la imagen
        if($tipo_c == "EST") {
            $contenido = 'Acud='.$row_carnets['acudiente_1'].'|Cel=(57) '.$row_carnets['telefono_acudiente_1'].'|Email='.$row_carnets['email_acudiente_1'].'|Dir='.$row_carnets['direccion'];
        }
        else {
            $contenido = 'Cel=(57) '.$row_carnets['celular'].'|Email='.$row_carnets['email'];
        }
        
        QRcode::png($contenido, $filename, $level, $tamano, $framesize);
        //Fin código qr
        
        //Se inserta los datos en la tabla de carnets
        $ct_carnet = 0;
        $sql_val_carnet = "SELECT COUNT(1) ct FROM tbl_carnets WHERE id_emp_est = $id1 AND tipo = '$tipo_c'";
        $exe_val_carnet = $mysqli1->query($sql_val_carnet);
        while($row_val_carnet = $exe_val_carnet->fetch_assoc()) {
            $ct_carnet = $row_val_carnet['ct'];
        }
        
        if($ct_carnet > 0 ) {
            //No hace nada
        }
        else {
            $sql_ins_carnet = "INSERT INTO tbl_carnets (id_emp_est, id_grado, tipo, ruta, ruta_codqr, a) VALUES ($id1, $idgra, '$tipo_c', 'NA', '$filename', '$fanio')";
            $exe_ins_carnet = $mysqli1->query($sql_ins_carnet);
        }
        
        //#######################################################################################################################################
        
        if($tipo_c == "EST") {
            //************************************************* SE CREA EL PDF ******************************************
            $tipo_doc = $row_carnets['tipo_documento'];
            if($tipo_doc == 1) {
                $tipo_doc1 = "T.I.";
            }
            else if($tipo_doc == 2) {
                $tipo_doc1 = "R.C.";
            }
            else if($tipo_doc == 3) {
                $tipo_doc1 = "C.C.";
            }
            else if($tipo_doc == 4) {
                $tipo_doc1 = "PAS.";
            }
            
            $content1 .= '<div id="div1">...</div>';
            
            $content1 .= '<div id="div2">';
                $content1 .= '<div id="divcontxt"></div>';
                    $content1 .= '<div id="divtxt">';
                        $content1 .= '<p class="nom1">'.$nombre_completo.'</p>';
                        $content1 .= '<p class="nom1">'.$tipo_doc1.' '.$row_carnets['n_documento'].'  ---  RH: '.$row_carnets['estado'].'</p>';
                        $content1 .= '<p class="nom1">'.$row_carnets['grado'].' '.$row_carnets['grupo'].'</p>';
                    $content1 .= '</div>';
                    $content1 .= '<div id="divqr">';
                        //$content1 .= '<img id="imgqr" src="../financieraunicab/phpqrcode/img/qr2.png" width="230px">';
                        $content1 .= '<img id="imgqr" src="'.$filename.'" width="260px">';
                    $content1 .= '</div>';
                $content1 .= '</div>';
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
        
            $content1 .= '</body></html>';
            
            $nom_pdf = "cu_".str_replace(" ","_",$row_carnets['grado'])."_".str_replace(" ","_",$nombre_completo)."_".$fanio.".pdf";
            
        	//PDF::stream($nom_pdf,$content);
        	
        	//Se crea la carpeta del pdf
            $path = 'carnets/'.$fanio.'/'.str_replace(" ","_",$row_carnets['grado']).'/';
            //echo $path;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        
            $folder0 = '/carnets/'.$fanio.'/'.str_replace(" ","_",$row_carnets['grado']).'/';
            $folder_correo = 'carnets/'.$fanio.'/'.str_replace(" ","_",$row_carnets['grado']).'/';
            $folder = __DIR__.$folder0;
            //echo "<br>".$folder0;
            //echo "<br>".$folder;
            //PDF::saveDisk($nom_pdf,$content.$content1,$folder);
            
            $ruta = "https://unicab.org/registro/docenteunicab".$folder0.$nom_pdf;
            //echo "<br>".$ruta;
        }
        else {
            //echo "control";
            //************************************************* SE CREA EL PDF ******************************************
            $content1 .= '<div id="div1">...</div>';
            
            $content1 .= '<div id="div2">';
                $content1 .= '<div id="divcontxt"></div>';
                    $content1 .= '<div id="divtxt">';
                        $content1 .= '<p class="nom1">'.$nombre_completo.'</p>';
                        $content1 .= '<p class="nom1">C.C. '.$row_carnets['n_documento'].'  ---  RH: '.$row_carnets['rh'].'</p>';
                        $content1 .= '<p class="nom1">'.$row_carnets['cargo'].'</p>';
                    $content1 .= '</div>';
                    $content1 .= '<div id="divqr">';
                        //$content1 .= '<img id="imgqr" src="../financieraunicab/phpqrcode/img/qr2.png" width="230px">';
                        $content1 .= '<img id="imgqr" src="'.$filename.'" width="260px">';
                        //$content1 .= '<img id="imgqr" src="carnets/qr/qr_imelda.png" width="260px">';
                    $content1 .= '</div>';
                $content1 .= '</div>';
            $content1 .= '</div>';
            
            $content1 .= '<div id="div3">...</div>';
            
            $content1 .= '<div id="div4">';
            $content1 .= '</div>';
        
            $content1 .= '</body></html>';
            
            //$nom_pdf = "cu_".str_replace(" ","_","Grado 1°")."_".str_replace(" ","_","Maria Paulina Figueredo Rodriguez")."_".$fanio.".pdf";
            $nom_pdf = "cu_".str_replace(" ","_",$nombre_completo)."_".$fanio.".pdf";
        	
        	//PDF::stream($nom_pdf,$content);
        	
        	//Se crea la carpeta del pdf
            //$path = 'carnets/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
            $path = 'carnets/'.$fanio.'/Empleados/';
            //echo $path;
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        
            //$folder0 = '/dhonor/'.$fanio.'/'.str_replace(" ","_",$row['grado']).'/';
            $folder0 = '/carnets/'.$fanio.'/Empleados/';
            $folder_correo = 'carnets/'.$fanio.'/Empleados/';
            $folder = __DIR__.$folder0;
            //echo "<br>".$folder0;
            //echo "<br>".$folder;
            //PDF::saveDisk($nom_pdf,$content.$content1,$folder);
            
            $ruta = "https://unicab.org/registro/docenteunicab".$folder0.$nom_pdf;
            //echo "<br>".$ruta;
        }
        
        $mpdf->WriteHTML($content.$content1);
        //$mpdf->WriteHTML('<div>Section 1 text</div>');
        // I = Inline; D = Download; F = File; S = Cadena
        //$mpdf->Output($nom_pdf, 'I');
        $mpdf->Output($folder.$nom_pdf, 'F');
        //exit;
        
        $content1 = "";
        
        //Se actualiza el registro del carnet con la ruta del pdf
        $sql_upd_carnet = "UPDATE tbl_carnets SET ruta = '$ruta' WHERE id_emp_est = $id1 AND tipo = '$tipo_c' AND a = '$fanio'";
        $exe_upd_carnet = $mysqli1->query($sql_upd_carnet);
        
        //************************************************* FIN PDF ******************************************
        
        //Se busca la póliza
        $poliza = "";
        if(!$row_carnets['id_grado']) {
            $idgra = 0;
        }
        else {
           $idgra =  $row_carnets['id_grado'];
        }
        $sql_poliza = "SELECT * FROM tbl_polizas WHERE n_documento = '".$row_carnets['n_documento']."' AND a = '$fanio' AND id_grado = ".$idgra;
        //echo $sql_poliza;
        $exe_poliza = $mysqli1->query($sql_poliza);
        while($row_poliza = $exe_poliza->fetch_assoc()) {
            $poliza = $row_poliza['ruta'];
        }
        
        // ###################### INICIO ENVIO DE CORREO ###################
        $mail = new PHPMailer(true);
        
        if($tipo_c == "EST") {
            $correo_destino = $row_carnets['email_institucional'].".test-google-a.com";
            $correo_destino1 = $row_carnets['email_acudiente_1'];
        }
        else {
            $extension =substr($row_carnets['email'],strlen($row_carnets['email'])-4,strlen($row_carnets['email']));
            //echo $extension;
            if($extension == ".org") {
                $correo_destino = $row_carnets['email'].".test-google-a.com";
            }
            else {
                $correo_destino = $row_carnets['email'];
            }
        }
        //$correo_destino = "gregory.figueredo@unicab.org.test-google-a.com";
        //$correo_destino = "g.h.fig.1073@gmail.com";
        //echo $correo_destino;
        
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            //$mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = false;
            //$mail->Username   = 'numericopensamientoclei2@gmail.com';                     // SMTP username
            //$mail->Username   = 'matriculas.unicab@gmail.com';
            //$mail->Password   = '1057592816';
            $mail->Username   = 'matriculas.academica@unicab.org';
            $mail->Password   = '1057592816';
            //$mail->Username   = 'sistemasunicab@gmail.com';
            //$mail->Password   = 'psfa0301';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 25;
        
            //Recipients
            //$mail->setFrom('sistemasunicab@gmail.com');
            $mail->setFrom('matriculas.academica@unicab.org');
            if($tipo_c == "EST") {
                $mail->addAddress($correo_destino);     // Add a recipient
                $mail->addAddress($correo_destino1);     // Add a recipient
            }
            else {
                $mail->addAddress($correo_destino);     // Add a recipient
            }
            //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
            $mail->addBCC('numericopensamientoclei2@gmail.com');
            //$mail->addBCC('matriculas.unicab@gmail.com');
        
            // Attachments
            $mail->addAttachment($folder_correo.$nom_pdf, $nom_pdf);         // Add attachments
            if($poliza != "") {
                $mail->addAttachment($poliza, "poliza_2021_".$nombre_completo.".pdf");         // Add attachments
            }
            
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Carnet UNICAB '.$fanio;
            if($tipo_c == "EST") {
                if($poliza != "") {
                    $mail->Body    = '<p>Estimada familia</p>
                    <p>Reciban un cordial saludo. Deseándoles éxitos en sus labores diarias.</p>
                    <p>Desde el área de Secretaría Académica se emiten los siguientes documentos de '.$nombre_completo.' para fines pertinentes:</p>
                    <p>- Carnet estudiantil corespondiente al año '.$fanio.'. Por favor imprimir, pegar foto, recortar y plastificar</p>
                    <p>- Póliza contra accidentes. (Unicamente para grados de primero a once y residentes en Colombia. Para ciclos no aplica)</p>
                    <br><p>NOTA: Se recomienda imprimir en impresora láser para mayor nitidez.</p>
                    <br><p>--</p>
                    <p>Cordialmente</p>
                    <p>ANDREA RODRIGUEZ PINTO</p>
                    <p>SECRETARIA ACADEMICA Y ADMINISTRATIVA</p>
                    <p>UNICAB CORPORACION EDUCATIVA</p>
                    <p>Tel: (8)7752309)</p>
                    <p>Celular/Whatsapp: 3156965291</p>';
                }
                else {
                    $mail->Body    = '<p>Estimada familia</p>
                    <p>Reciban un cordial saludo. Deseándoles éxitos en sus labores diarias.</p>
                    <p>Desde el área de Secretaría Académica se emite el siguiente documento de '.$nombre_completo.' para fines pertinentes:</p>
                    <p>- Carnet estudiantil corespondiente al año '.$fanio.'. Por favor imprimir, pegar foto, recortar y plastificar</p>
                    <br><p>NOTA: Se recomienda imprimir en impresora láser para mayor nitidez.</p>
                    <br><p>--</p>
                    <p>Cordialmente</p>
                    <p>ANDREA RODRIGUEZ PINTO</p>
                    <p>SECRETARIA ACADEMICA Y ADMINISTRATIVA</p>
                    <p>UNICAB CORPORACION EDUCATIVA</p>
                    <p>Tel: (8)7752309)</p>
                    <p>Celular/Whatsapp: 3156965291</p>';
                }
            }
            else {
                $mail->Body    = '<p>Señor(a): '.strtoupper($nombre_completo).'</p>
                <br><p>Este es un envío de correo automático de UNICAB COLEGIO VIRTUAL.</p>
                <p>A continuación encontrará el carnet corporativo corespondiente al año '.$fanio.'. Por favor imprimir, recortar y plastificar.</p>
                <p>NOTA: Se recomienda imprimir en impresora láser para mayor nitidez.</p>
                <br><p>--</p>
                <p>Cordialmente</p>
                <p>ANDREA RODRIGUEZ PINTO</p>
                <p>SECRETARIA ACADEMICA Y ADMINISTRATIVA</p>
                <p>UNICAB CORPORACION EDUCATIVA</p>
                <p>Tel: (8)7752309)</p>
                <p>Celular/Whatsapp: 3156965291</p>';
            }
                
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            //echo 'Message has been sent';
            $msg_correo = "CorreoOK";
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            //$msg_correo = "CorreoError";
            $msg_correo = $mail->ErrorInfo;
        }
        
        //Esta opción es utilizando la librería AttachMailer
        $mensaje = '<p>Señor(a): '.strtoupper($nombre_completo).'</p>
                <br><p>Este es un envío de correo automático de UNICAB COLEGIO VIRTUAL.</p>
                <p>A continuación encontrará el carnet corporativo corespondiente al año '.$fanio.'. Por favor imprimir, recortar y plastificar.</p>
                <p>NOTA: Se recomienda imprimir en impresora láser para mayor nitidez.</p>
                <br><p>--</p>
                <p>Cordialmente</p>
                <p>ANDREA RODRIGUEZ PINTO</p>
                <p>SECRETARIA ACADEMICA Y ADMINISTRATIVA</p>
                <p>UNICAB CORPORACION EDUCATIVA</p>
                <p>Tel: (8)7752309)</p>
                <p>Celular/Whatsapp: 3156965291</p>';
        $to = $correo_destino.",numericopensamientoclei2@gmail.com";
        //$mailer = new AttachMailer("matriculas.unicab@gmail.com", $to, "Carnet UNICAB ".$fanio, $mensaje);
        //$mailer->attachFile($folder_correo.$nom_pdf);
        //$mailer->send() ? $msg_correo = "CorreoOK" : $msg_correo = "CorreoError";
        
        // ###################### FIN ENVIO DE CORREO ###################
        
        $mpdf = new \Mpdf\Mpdf(["format" => "C1", "margin_left" => 0, "margin_right" => 0, "margin_top" => 0, "margin_bottom" => 0]);
        $mpdf->SetDisplayMode('real');
        
        //Se actualiza el registro del carnet con el mensaje del envío de correo
        $sql_upd_carnet1 = "UPDATE tbl_carnets SET msg_correo = '$msg_correo' WHERE id_emp_est = $id1 AND tipo = '$tipo_c' AND a = '$fanio'";
        $exe_upd_carnet1 = $mysqli1->query($sql_upd_carnet1);
    }
    
    //echo $content;
    //echo $content1;
    //echo "<br>".$msg_correo;
    
    //Se consultan los carnets
    if($id == 0) {
        if($tipo_c == "EST") {
            $sql_carnet_getdat = "SELECT * FROM tbl_carnets WHERE tipo = 'EST' AND id_grado = $idgra";
            
            $sql_sin_carnet_getdat = "SELECT e.*, g.grado, m.id_grado, m.grupo 
            FROM estudiantes e, matricula m, grados g 
            WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
            AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = $fanio AND m.id_grado = $idgra AND e.estado = 'NA'";
        }
        else {
            $sql_carnet_getdat = "SELECT * FROM tbl_carnets WHERE tipo = 'EMP'";
            
            $sql_sin_carnet_getdat = "SELECT *, '0' id_grado FROM tbl_empleados WHERE rh = 'NA'";
        }
    }
    else {
        if($tipo_c == "EST") {
            $sql_carnet_getdat = "SELECT * FROM tbl_carnets WHERE tipo = 'EST' AND id_grado = $idgra AND id_emp_est = $id";
            
            $sql_sin_carnet_getdat = "SELECT e.*, g.grado, m.id_grado, m.grupo 
            FROM estudiantes e, matricula m, grados g 
            WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
            AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = $fanio AND m.id_grado = $idgra AND e.estado = 'NA' AND e.id = $id";
        }
        else {
            $sql_carnet_getdat = "SELECT * FROM tbl_carnets WHERE tipo = 'EMP' AND id_emp_est = $id";
            
            $sql_sin_carnet_getdat = "SELECT *, '0' id_grado FROM tbl_empleados WHERE rh = 'NA' AND id = $id";
        }
    }
    //echo $sql_carnet_getdat;
    //echo $sql_sin_carnet_getdat;
    $exe_carnet_getdat = $mysqli1->query($sql_carnet_getdat);
    $exe_sin_carnet_getdat = $mysqli1->query($sql_sin_carnet_getdat);
    
?>

<html>
    <head>
        
    </head>
    <body>
        <?php
            if($tipo_c == "EST") {
        ?>
                <h3 style="color: red">Estudiante(s) registrado(s) que no se le(s) generó carnet por falta de información</h3>
        <?php
            }
            else {
        ?>
                <h3>Empleado(s) registrado(s) que no se le(s) generó carnet por falta de información</h3>
        <?php
            }
        ?>
        
        <table border="1">
            <thead>
                <?php
                    if($tipo_c == "EST") {
                ?>
                        <tr>
                            <td>ID_EMP_EST</td>
                            <td>ID_GRADO</td>
                            <td>NOMBRE</td>
                        </tr>
                <?php
                    }
                    else {
                ?>
                        <tr>
                            <td>ID_EMP_EST</td>
                            <td>NOMBRE</td>
                        </tr>
                <?php
                    }
                ?>
            </thead>
            <tbody>
            <?php  
                while ($row_scu = $exe_sin_carnet_getdat->fetch_assoc()) {
            ?>
                <?php
                    if($tipo_c == "EST") {
                ?>
                        <tr style="color: red">
                            <td><?php echo $row_scu['id']; ?></td>
                            <td><?php echo $row_scu['id_grado']; ?></td>
                            <td><?php echo $row_scu['nombres']." ".$row_scu['apellidos']; ?></td>
                        </tr>
                <?php
                    }
                    else {
                ?>
                        <tr style="color: red">
                            <td><?php echo $row_scu['id']; ?></td>
                            <td><?php echo $row_scu['nombres']." ".$row_scu['apellidos']; ?></td>
                        </tr>
                <?php
                    }
                ?>
            <?php  
                }
            ?>
            </tbody>
        </table>
        <br>
        <!-- ************************************************************************************ -->
        
        <?php
            //echo $sql_sin_carnet_getdat;
            if($tipo_c == "EST") {
        ?>
                <h3>Estudiante(s) con carnet</h3>
        <?php
            }
            else {
        ?>
                <h3>Empleado(s) con carnet</h3>
        <?php
            }
        ?>
        <table border="1">
            <thead>
                <tr>
                    <td>ID_EMP_EST</td>
                    <td>ID_GRADO</td>
                    <td>TIPO</td>
                    <td>RUTA</td>
                    <td>AÑO</td>
                    <td>MSG</td>
                </tr>
            </thead>
            <tbody>
            <?php  
                while ($row_cu = $exe_carnet_getdat->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row_cu['id_emp_est']; ?></td>
                    <td><?php echo $row_cu['id_grado']; ?></td>
                    <td><?php echo $row_cu['tipo']; ?></td>
                    <td><?php echo $row_cu['ruta']; ?></td>
                    <td><?php echo $row_cu['a']; ?></td>
                    <td><?php echo $row_cu['msg_correo']; ?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>
    </body>
</html>
