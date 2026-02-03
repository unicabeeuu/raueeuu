<?php
    require("../docenteunicab/updreg/1cc3s4db.php");
    
    require('PHPMailer_master/src/Exception.php');
    require('PHPMailer_master/src/PHPMailer.php');
    require('PHPMailer_master/src/SMTP.php');

    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$fecha2 =$a."/".$mes."/". $dia;
	
	$msg_correo1 = "";
	$msgregistro = "";

    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
    
    $msgregistro = "RegistroOK";
    if($msgregistro == "RegistroOK") {
        // Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            //$mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            //$mail->Host       = 'localhost';
            //$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->SMTPAuth   = false;
            $mail->Username   = 'numericopensamientoclei2@gmail.com';                     // SMTP username
            $mail->Password   = 'psfa0301';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            //$mail->SMTPAutoTLS = false ;
            //$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            $mail->Port       = 25;
        
            //Recipients
            $mail->setFrom('numericopensamientoclei2@gmail.com');
            $mail->addAddress('numericopensamientoclei2@gmail.com');     // Add a recipient
            //$mail->addAddress('ellen@example.com');               // Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
        
            // Attachments
            $mail->addAttachment('../docenteunicab/dhonor/2020/prueba.pdf', 'prueba.pdf');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Nueva prueba de envío de PDF';
            $mail->Body    = '<h2>--- DATOS ----</h2>
                <br> Mensaje: Esto es una prueba de envío de PDF guardado localmente en serviror<br>';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    
        //$adjunto_c= $_FILES['adjunto']['name'];
        //echo "adjunto: ".$adjunto_c;
        //$correoorigen1="impactodigitalcol@gmail.com";
        $correoorigen1="numericopensamientoclei2@gmail.com";
        
        //Se envía el correo
        //$msg_correo1 = $obj->enviar($correoorigen1, $emailReceptor, $asuntoMensaje, $cuerpoMensaje, $adjunto_c);
    }
    
    //echo "<br/>".$msg_correo1;
    
    //$resultado = $msgregistro."_".$msg_correo1."_".$id;
	//echo "<br/>".$resultado;
    
    //header('Location: ../form1.php?s='.$resultado);
?>