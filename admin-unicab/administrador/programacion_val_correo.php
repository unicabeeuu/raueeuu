<?php
    require "../php/conexion.php";
    require("../../registro/docenteunicab/updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/resultado_pre_admisiones_f.php?s=correoOK_EstudianteOK
    
    require('PHPMailer_master/src/Exception.php');
    require('PHPMailer_master/src/PHPMailer.php');
    require('PHPMailer_master/src/SMTP.php');
    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
    
    $nombrea = str_replace("_", " ", $_REQUEST['noma']);
    $emaila = $_REQUEST['emaila'];
    $cela = $_REQUEST['cela'];
    $doc_est = $_REQUEST['doc_est'];
    $nombre_est = $_REQUEST['nombre_est'];
    $idgrado = $_REQUEST['idgrado'];
    $grado = $_REQUEST['grado'];
    $grado_val = $_REQUEST['grado_val'];
    //echo $emaila;
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    //$faniop=date("Y");
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
        //$mail->Username   = 'unicabfinanciera@gmail.com';
        //$mail->Password   = 'Financiera2020#';
        $mail->Username   = 'sistemasunicab@gmail.com';
        $mail->Password   = 'psfa0301';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 25;
    
        //Recipients
        $mail->setFrom('sistemasunicab@gmail.com');
        //$mail->addAddress('liliasda19@gmail.com');     // Add a recipient
        //$mail->addAddress('unicabfinanciera@gmail.com');     // Add a recipient
        $mail->addAddress($emaila);     // Add a recipient
        //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
        //$mail->addCC('cc@example.com');
        $mail->addBCC('numericopensamientoclei2@gmail.com');
        $mail->addBCC('monicamolina960826@gmail.com');
    
        // Attachments
        //$mail->addAttachment($folder_correo.$nom_pdf, $nom_pdf);         // Add attachments
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'CONFIRMACION EVALUACION DE VALIDACION';
        $mail->Body    = '<p>Señor(a): </p>
            <p>'.strtoupper($nombrea).'</p>
            <p>Cordial Saludo.</p>
            <br><p>A partir del día de hoy '.$nombre_est.' puede ingresar al link de abajo para realizar la evaluación de validación de grado '.$grado_val.', para ingresar a grado '.$grado.'.</p>
            <p>https://unicab.org/eval_val.php</p>
            <br><p>Atentamente</p>
            <p>--</p>
            <p>LIZETH TATIANA GONZALEZ CUEVAS</p>
            <p>Área de Admisiones</p>
            <p>Unicab Corporación Educativa</p>
            <p>Tel. 8 7752309</p>
            <p>Cel. Whatsapp: 300 815 6531</p>
            <p>unicab.org</p>';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        //echo 'Message has been sent';
        $msg_correo = "CorreoOK";
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $msg_correo = "CorreoError";
    }
    
    // ###################### FIN ENVIO DE CORREO ###################
    
    
    
    $resultado = $msg_correo."_".$emaila;
    //echo "<br>".$resultado;
    
    //redireccionamos a la misma url conforme se ha enviado correctamente con la variable si
	header('Location: programar_val_putdat.php');
    	
?>

