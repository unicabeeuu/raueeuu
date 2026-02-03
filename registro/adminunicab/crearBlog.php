 <?php 
 	session_start();
 	require "php/conexion.php";
	//if (isset($_SESSION['admin_unicab'])) {
	
	require('PHPMailer_master/src/Exception.php');
    require('PHPMailer_master/src/PHPMailer.php');
    require('PHPMailer_master/src/SMTP.php');
    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
 ?>
<html>
	<head>
		<!--<META HTTP-EQUIV="Refresh" CONTENT="0; URL=post_putdat.php">-->
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$titulo=$_REQUEST['TituloA'];
		$descripcion=$_REQUEST['DescripcionA'];
		//$check = $_REQUEST['checkAvanzado'];
		$check = $_REQUEST['checkAvanzado'] == 1 ? 1 : 0;
		$idcat = $_REQUEST['selcat'];

		// imagen 
		$imagen=$_FILES['ImagenA']['name'];
		$ruta=$_FILES['ImagenA']['tmp_name'];
		$tipo_archivo =$_FILES['ImagenA']['type'];
		$destino="../../assets/img/imgblog/".$imagen;
		copy($ruta, $destino);
		// imagen

		// fecha publicado
		date_default_timezone_set('America/Bogota');

		$dia=date("d");
		$mes=date("m");
		$mesLetra=date("M");
		$fanio=date("Y");

		$fechaHoy=$fanio."-".$mes."-".$dia;
		// fecha publicado

		$idAdministrador=$_REQUEST['IdEmp'];

		try {	
			$sql_blog="INSERT INTO blog (TituloB, DescripcionB, ImagenB, FechaPublicacionB, DescripcionA, IdAdministrador, estado_rev_texto, estado_rev_mult, texto_img_vid, id_categoria) 
			VALUES ('".$titulo."','NA','".$destino."','".$fechaHoy."','".$descripcion."',".$idAdministrador.",0,0,".$check.",".$idcat.")";
			$exe_blog=mysqli_query($conexion,$sql_blog);
	        //echo $sql_blog;
	        
	        //Se consulta el id creado
	        $sql_id = "SELECT * FROM blog WHERE TituloB = '$titulo'";
	        $exe_id = mysqli_query($conexion,$sql_id);

        	while ($fila = mysqli_fetch_array($exe_id)){
                              
        	  	$id_post = $fila['IdBlog'];
        	}
        	
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
                $mail->Username   = 'webmasterunicab@unicab.org';
                $mail->Password   = 'psfa0301';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 25;
            
                //Recipients
                $mail->setFrom('webmasterunicab@unicab.org');
                //$mail->addAddress('numericopensamientoclei2@gmail.com');     // Add a recipient
                $mail->addAddress('equipocreativo@unicab.org');     // Add a recipient
                $mail->addAddress('alejandra.rivera@unicab.org');     // Add a recipient
                $mail->addAddress('olgastella.bioetico@unicab.org');     // Add a recipient
                //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
                $mail->addCC('gregory.figueredo@unicab.org');
                //$mail->addCC('admisiones02@unicab.org');
                //$mail->addBCC('numericopensamientoclei2@gmail.com');
            
                // Attachments
                //$mail->addAttachment('../../assets/descargas/Portafolio_unicab_2022.pdf', 'Portafolio_unicab_2022.pdf');         // Add attachments
                
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'CREACIÓN DE NUEVO BLOG PARA REVISIÓN ';
                $mail->Body    = '<p>Se ha creado un nuevo blog que requiere ser revisado en redacción, ortografía y diseño. </p>
                    <p>Título: <strong>'.$titulo.'</strong></p>
                    <p>Id: <strong>'.$id_post.'</strong></p>
                    <p style="text-align: justify">Por favor ingresa a registro académico y en el menú <strong>Blog/Ver</strong> podrás hacer la revisión para poder ser publicado en la página web.</p>
                    
                    <p>NOTA: Este es un sistema de envío automático de correos. Por favor no contestar a este email.</p>
                    <p></p>
                    <br><p>Atentamente</p>
                    <p>--</p>
                    <p>Equipo de sistemas</p>';
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
			
			//echo "<script>alert('Post creado correctamente');</script>";
			//redireccionamos
	        header('Location: post_putdat1.php?id='.$id_post);
	
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='index.php';</script>";
		}
	/*}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../login_registro.php';</script>";
	}*/
?>