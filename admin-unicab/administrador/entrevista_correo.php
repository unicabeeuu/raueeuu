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
    $psi = str_replace("_", " ", $_REQUEST['psi']);
    $celp = $_REQUEST['celp'];
    $emaila = $_REQUEST['emaila'];
    $cela = $_REQUEST['cela'];
    $f = $_REQUEST['f'];
    $h = $_REQUEST['h'];
    $meet = $_REQUEST['meet'];
    $doc_est = $_REQUEST['doc_est'];
    //echo $documento;
    
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
    try {
        $mail = new PHPMailer(true);
    }
    catch(Exception $e) {
        echo $e;
    }
    
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
        //$mail->Username   = 'sistemasunicab@gmail.com';
        //$mail->Password   = 'psfa0301';
        $mail->Username   = 'webmasterunicab@unicab.org';
        $mail->Password   = 'psfa0301';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 25;
    
        //Recipients
        //$mail->setFrom('sistemasunicab@gmail.com');
        $mail->setFrom('webmasterunicab@unicab.org');
        //$mail->addAddress('liliasda19@gmail.com');     // Add a recipient
        //$mail->addAddress('unicabfinanciera@gmail.com');     // Add a recipient
        $mail->addAddress($emaila);     // Add a recipient
        //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
        //$mail->addCC('gregory.figueredo@unicab.org');
        $mail->addCC('admisiones02@unicab.org');
        $mail->addBCC('numericopensamientoclei2@gmail.com');
    
        // Attachments
        $mail->addAttachment('../../assets/descargas/Portafolio_unicab_2022.pdf', 'Portafolio_unicab_2022.pdf');         // Add attachments
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'CONFIRMACION ENTREVISTA ';
        $mail->Body    = '<p>Señor(a): </p>
            <p>'.strtoupper($nombrea).'</p>
            <p style="text-align: justify">Reciba un cordial saludo de bienvenida por parte del Colegio UNICAB Virtual, agradecemos que nos hayan contactado y deseamos éxito en sus labores diarias.</p>
            <p style="text-align: justify">El perfil de los estudiantes que culminan su año lectivo con nosotros, es el de ser un ser humano <strong>activo, autónomo, creativo y talentoso</strong> ya que nuestro servicio se presta a través de un modelo innovador el cual es mediado a través de nuestra plataforma tecnológica Moodle y maestros mediadores, para que el estudiante desarrolle sus habilidades y talentos en el deporte, las artes, las ciencias y la cultura entre otras.</p>
            <p>Atentamente nos permitimos enviar los datos para la entrevista con el área de psicología:</p>
            <p><strong>Ps.</strong> '.$psi.'</p>
            <p><strong>Whatsapp:</strong> '.$celp.'</p>
            <p><strong>Enlace GOOGLE MEET:</strong> '.$meet.'</p>
            <p><strong>Fecha:</strong> '.$f.'</p>
            <p><strong>Hora:</strong> '.$h.'</p>
            <p><strong>Identificación estudiante:</strong> '.$doc_est.'</p>
            <p style="text-align: justify">Tener en cuenta contactar 10 minutos antes al Whatsapp '.$celp.'. El tiempo máximo de espera es de 10 minutos después de la hora asignada, de no presentarse a tiempo deberá asignarse nuevamente.</p>
            <p>Se anexa nuestro portafolio con la información de la Institución y un link con un formulario de Informe de Procedencia para ser diligenciado por parte del acudiente 
                del estudiatne y de esta manera pueda ser evaluado por el equipo de Psicología previo a la fecha de la entrevista.</p>
            <p><a href="https://forms.gle/9AHSC6i7hoRJ7Tig6" target="_blank">Descargar Informe de Procedencia</a></p>

            <p>NOTA: Este es un sistema de envío automático de correos. Por favor no contestar a este email.</p>
            <p></p>
            <br><p>Atentamente</p>
            <p>--</p>
            <p><img src="https://www.unicab.org/assets/img/firma_correo_entrevista1.jpg" width="600px"/></p>';
            /*<p>OLGA GOMEZ PEREZ</p>
            <p>Área de Admisiones</p>
            <p>Unicab Corporación Educativa</p>
            <p>Tel. 8 7752309</p>
            <p>Cel. Whatsapp: 300 815 6531</p>
            <p>unicab.org</p>';*/
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        //echo 'Message has been sent';
        $msg_correo = "CorreoOK";
    } catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        //$msg_correo = "CorreoError"." | ".$mail->ErrorInfo." | ".$e;
        $msg_correo = "CorreoError";
    }
    
    // ###################### FIN ENVIO DE CORREO ###################
    
    
    
    // ###################### INICIO ENVIO DE WHATSAPP ###################
    //Se consultan los datos del whatsapp
    $sql_url = "SELECT t1 FROM tbl_parametros WHERE parametro = 'APIurl'";
    $exe_url = $mysqli1->query($sql_url);
    while($row_url = $exe_url->fetch_assoc()) {
        $APIurl = $row_url['t1'];
    }
    //echo $APIurl;
    
    $sql_tok = "SELECT t1 FROM tbl_parametros WHERE parametro = 'token'";
    $exe_tok = $mysqli1->query($sql_tok);
    while($row_tok = $exe_tok->fetch_assoc()) {
        $token = $row_tok['t1'];
    }
    //echo "<br>".$token;
    
    $message = "Señor(a) ".strtoupper($nombrea).", cordial saludo.\n";
    $message .= "Los datos para entrevista de admisión son:\n";
    $message .= "Ps. ".$psi."\n";
    $message .= "Cel/Whatsapp ".$celp."\n";
    $message .= "Enlace de Mett ".$meet."\n";
    $message .= "Fecha: ".$f."\n";
    $message .= "Hora: ".$h."\n";
    $message .= "Tener en cuenta contactar 10 minutos antes al Whatsapp ".$celp.". El tiempo máximo de espera es de 10 minutos después de la hora asignada, de no presentarse a tiempo deberá agendarse nuevamente.\n";
    //$message .= "En el siguiente enlace https://unicab.org/pre_admisiones.php encontrará todos los requisitos de matrícula para que los puedan ir realizando.\n";
    $message .= "Atentamente\n";
    $message .= "OLGA GOMEZ PEREZ\n";
    $message .= "Área de Admisiones\n";
    $message .= "Unicab Corporación Educativa\n";
    $message .= "Tel. 8 7752309\n";
    $message .= "Cel. Whatsapp 3008156531";
    $phone = '57'.$cela;
    //echo "<br>".$phone;
    
    $data = json_encode(
        array(
            'chatId'=>$phone.'@c.us',
            'body'=>$message
        )
    );
    
    try {
        //$url = $APIurl.'sendMessage?token='.$token;
        $options = stream_context_create(
            array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/json',
                    'content' => $data
                )
            )
        );
        //$response = file_get_contents($APIurl.'sendMessage?token='.$token,false,$options);
        $msg_whatsapp = "WhatsappOK";
    }
    catch (Exception $e) {
        $msg_whatsapp = "WhatsappError";
    }
    //echo "<br>respuesta ->".$response;
    // ###################### FIN ENVIO DE WHATSAPP ###################
    
    $resultado = $msg_correo."_".$emaila."_".$msg_whatsapp;
    echo "<br>".$resultado;
    
    //redireccionamos a la misma url conforme se ha enviado correctamente con la variable si
	header('Location: entrevista_putdat0.php');
    	
?>

