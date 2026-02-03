<?php
    
    require('PHPMailer_master/src/Exception.php');
    require('PHPMailer_master/src/PHPMailer.php');
    require('PHPMailer_master/src/SMTP.php');
    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
    
	// ###################### INICIO ENVIO DE CORREO ###################
    $mail = new PHPMailer(true);
    
    try {
        //echo $email;
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        //$mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = false;
        //$mail->SMTPAuth   = true;                                   //Cuando se envía con isSMTP
        $mail->Username   = 'webmasterunicab@unicab.org';
        $mail->Password   = 'psfa0301';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 25;
    
        //Recipients
        $mail->setFrom('webmasterunicab@unicab.org');
        $mail->addAddress('gregory.figueredo@unicab.org');  
        $mail->addAddress('sergio.cadena@unicab.org');// Add a recipient
        $mail->addBCC('numericopensamientoclei2@gmail.com');
        
        $mail->Body    = '<p>Señor(a): </p>
            <p>HERNANDO GUEVARA</p>
            <p>Cordial Saludo.</p>
            <br><p>Esto es una prueba de envío de correo</p>
            <br><p>Atentamente</p>
            <p>--</p>';
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Prueba de envío de correo';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        //echo 'Message has been sent';
        $msg_correo = "CorreoOK";
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $msg_correo = "CorreoError ".$e;
    }
    
    // ###################### FIN ENVIO DE CORREO ###################
    

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head> 
<body>
	<div class="main-content">
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Prueba de envío de correo:</h4>
						</div>
						<div class="form-body" style="height: 500px; overflow: scroll;">
							<?php
							    echo $msg_correo;
							?>
						</div>
                        
					</div>
           		</div>
      		</div>
		</section> 
	</div>
</body>
	

</html>