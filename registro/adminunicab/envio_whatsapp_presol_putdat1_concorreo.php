<?php
    session_start();
    //require "../adminunicab/php/conexion.php";
    include "php/conexion.php";
    
    require('PHPMailer_master/src/Exception.php');
    require('PHPMailer_master/src/PHPMailer.php');
    require('PHPMailer_master/src/SMTP.php');
    use  PHPMailer\PHPMailer\PHPMailer ;
    use  PHPMailer\PHPMailer\SMTP ;
    use  PHPMailer\PHPMailer\Exception ;
    
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		$perfil = $fila['perfil'];
	}
	
	$usuario = $_REQUEST['selusuario'];
	$instancia = $_REQUEST['idInstancia'];
	$token = $_REQUEST['token'];
	$url = $_REQUEST['url'];
	$envio = $_REQUEST['selenvio'];
	$tipoimg = $_REQUEST['seltipoimg'];
	$imgservidor = $_REQUEST['selimg'];
	$textowhat = $_REQUEST['textoW'];
	
	$textoimg = $_REQUEST['textoI'];
	$idpre = $_REQUEST['txtidpre'];
	
	$resultados = new stdClass();
	$datos = array();
	//$keys = ['response','acudiente','celular','email','msg_correo'];
	$keys = ['response','acudiente','celular'];
	$i = 0;
	
	$curl = curl_init();
	
	//Se hace la consulta de los números de celular a enviar los whatsapp
	$sql_num = "SELECT e.n_documento, e.acudiente_1, e.telefono_acudiente_1, e.nombres, e.apellidos, e.email_acudiente_1, e.acudiente_1, m.estado 
    FROM estudiantes e, matricula m 
    WHERE e.id = m.id_estudiante AND m.estado = 'pre_solicitud' AND m.n_matricula like '%2022%' 
    ORDER BY e.telefono_acudiente_1";
    
    /*$sql_num = "SELECT * FROM estudiantes WHERE n_documento = '999999'";*/
    
    $res_num = mysqli_query($conexion,$sql_num);
    
    $destino = "0000000000";
    
    while ($fila_num = mysqli_fetch_array($res_num)){
        //Se valida que se envíe el mensaje a un número diferente
        if($destino == $fila_num['telefono_acudiente_1']) {
            //No hace nada
        }
        else {
            $destino = $fila_num['telefono_acudiente_1'];
            
            //Se valida si la imagen es local para subirla al servidor
        	if($envio == 1) {
        	    if($tipoimg == 1) {
        	        $imagen = $_FILES['ImagenW']['name'];
                	$ruta = $_FILES['ImagenW']['tmp_name'];
                	$tipo_archivo = $_FILES['ImagenW']['type'];
                	$destino = "../../assets/img/whatsapp/".$imagen;
                	copy($ruta, $destino);
                	//$imglocal = $_REQUEST['ImagenW'];
                	
                	$rutaimage = "https://unicab.org/assets/img/whatsapp/".$imagen;
        	    }
        	    else if($tipoimg == 2) {
        	        $rutaimage = "https://unicab.org/assets/img/whatsapp/".$imgservidor;
        	    }
                
                //Esto es para imágenes
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => "token=".$token."&to=+57".$fila_num['telefono_acudiente_1']."&image=".$rutaimage."&caption=".$textoimg."&referenceId=",
                  CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                  ),
                ));
        	}
        	else if($envio == 2) {
        	    //Esto es para texto
                curl_setopt_array($curl, array(
                  CURLOPT_URL => $url,
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => "token=".$token."&to=+57".$fila_num['telefono_acudiente_1']."&body=".$textowhat."&priority=1&referenceId=",
                  CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded"
                  ),
                ));
        	}
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            
      		// ###################### INICIO ENVIO DE CORREO ###################
            $mail = new PHPMailer(true);
            
            try {
                //echo $email;
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                //$mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.hostinger.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = false;
                //$mail->SMTPAuth   = true;                                   //Cuando se envía con isSMTP
                //$mail->Username   = 'numericopensamientoclei2@gmail.com';                     // SMTP username
                //$mail->Username   = 'unicabfinanciera@gmail.com';
                //$mail->Password   = 'Financiera2020#';
                $mail->Username   = 'coordinacion.academica@unicab.org';
                $mail->Password   = 'Cor.aca2022';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 465;
            
                //Recipients
                $mail->setFrom('coordinacion.academica@unicab.org');
                $mail->addAddress($fila_num['email_acudiente_1']);     // Add a recipient
                //$mail->addReplyTo('numericopensamientoclei2@gmail.com', 'FYI');
                $mail->addBCC('numericopensamientoclei2@gmail.com');
                //$mail->addBCC('psico01@unicab.org');
            
                // Attachments
                //$mail->addAttachment($folder_correo.$nom_pdf, $nom_pdf);         // Add attachments
                if($envio == 1) {
                    $mail->Body    = '<p>Señor(a): </p>
                    <p>'.strtoupper($fila_num['acudiente_1']).'</p>
                    <p>Cordial Saludo.</p>
                    <br><img src="'.$rutaimage.'" width="500px"></p>
                    <br><p>'.$textoimg.'</p>
                    <br><p>Este correo es netamente para las difusiones por whatsapp.</p>
                    <br><p>Para comunicaciones con coordinación académica utiliza el correo: psico01@unicab.org.</p>
                    <br><p>Atentamente</p>
                    <p>--</p>
                    <p>COORDINACIÓN ACADÉMICA</p>
                    <p>Unicab Corporación Educativa</p>
                    <p>Cel. 318 400 4412</p>
                    <p>unicab.org</p>';
                }
                else if($envio == 2) {
                    $mail->Body    = '<p>Señor(a): </p>
                    <p>'.strtoupper($fila_num['acudiente_1']).'</p>
                    <p>Cordial Saludo.</p>
                    <br><p>'.$textowhat.'</p>
                    <br><p>Este correo es netamente para las difusiones por whatsapp.</p>
                    <br><p>Para comunicaciones con coordinación académica utiliza el correo: psico01@unicab.org.</p>
                    <br><p>Atentamente</p>
                    <p>--</p>
                    <p>COORDINACIÓN ACADÉMICA</p>
                    <p>Unicab Corporación Educativa</p>
                    <p>Cel. 318 400 4412</p>
                    <p>unicab.org</p>';
                }
                
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'Mensaje de Coordinación Académica Colegio UNICAB Virtual';
                /*$mail->Body    = '<p>Señor(a): </p>
                    <p>'.strtoupper($fila_num['acudiente_1']).'</p>
                    <p>Cordial Saludo.</p>
                    <br><p>'.$textowhat.'</p>
                    <br><p>Atentamente</p>
                    <p>--</p>
                    <p>COORDINACIÓN ACADÉMICA</p>
                    <p>Unicab Corporación Educativa</p>
                    <p>Cel. 318 400 4412</p>
                    <p>unicab.org</p>';*/
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            
                //$mail->send();
                //echo 'Message has been sent';
                $msg_correo = "CorreoOK";
            } catch (Exception $e) {
                //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $msg_correo = "CorreoError ".$e;
            }
            
            // ###################### FIN ENVIO DE CORREO ###################
            
            //$valores = [$response,$fila_num['nombres']." ".$fila_num['apellidos'],$fila_num['telefono_acudiente_1'],$fila_num['email_acudiente_1'],$msg_correo];
            $valores = [$response,$fila_num['nombres']." ".$fila_num['apellidos'],$fila_num['telefono_acudiente_1']];
    	    $datos_temp = array_combine($keys,$valores);
      		$datos[$i] = $datos_temp;
      		$i++;
        }
  		
	}
	
	$resultados->datos = $datos;
	
    curl_close($curl);

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/chosen.css">
<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/ImageSelect.css">
<!--<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/bootstrap.min.css" >-->

<!-- Bootstrap Core CSS  -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- js-->
<!--<script src="../js/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/jquery.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/chosen.jquery.js"></script>
<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/ImageSelect.jquery.js"></script>
<!--<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/bootstrap.js"></script>-->
<script src="../js/bootstrap.js"> </script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
   	
<style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
    .maxl {
        color: blue;
    }
    #alert {
        position: fixed;
        bottom: 0;
        left: 180px;
        z-index: 5000;
        height: 80px;
    }
    #txtvacio {
        border: 0;
    }
    .error {
        border: 3px solid red !important;
    }
    
    .readonly {
        background: lightgray;
    }
        
    input[type=checkbox] {
    	visibility: hidden;
    }
    
    .checkbox-GHF {
    	display: inline-block;
    	position: relative;
        width: 70px;
    	height: 30px;
    	background: #F3F781;
    	border-radius: 15px;
    	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.6), 0px 1px 0px rgba(255,255,255,0.3);   
    }
    
    .checkbox-GHF label {
    
        /* aspecto */
        display: block;
        width: 34px;
    	height: 20px;
    	border-radius: 17px;
    	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.35);
    	background: #fcfff4;
    	background: linear-gradient(to top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
        cursor: pointer;
        
        /* Posicionamiento */
        position: absolute;
        top: 5px;
    	left: 5px;
        z-index: 1;
        
    	/* Comportamiento */
        transition: all .4s ease;
        
        /* ocultar el posible texto que tenga */
        overflow: hidden;
        text-indent: 35px;  
        transition: text-indent 0s;
    }
    
    /* estado activado */
    .checkbox-GHF input[type=checkbox]:checked + label {
    	left: auto;
        right: 5px;
    }
    
    .checkbox-GHF:after {
    	content: 'NO';
    	font: 12px/30px Arial, sans-serif;
    	color: red;
    	position: absolute;
    	right: 10px;
        z-index: 0;
    	font-weight: bold;
    	
    }
    
    .checkbox-GHF:before {
    	content: 'SI';
    	font: 12px/30px Arial, sans-serif;
    	color: green;
    	position: absolute;
    	left: 10px;
    	z-index: 0;
    	font-weight: bold;
    }
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else {
		        require 'menu.php';
		    }
		?>
	
		<?php require 'header.php';  ?>
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Envío masivo de whatsapp pre-solicitudes:</h4>
						</div>
						<div class="form-body" style="height: 500px; overflow: scroll;">
							<?php
							    echo "url: ".$url."<br>";
							    echo "envio: ".$envio."<br>";
							    echo "tipo imagen: ".$tipoimg."<br>";
							    echo "ruta imagen: ".$rutaimage."<br>";
							    //echo "texto whatsapp: ".$textowhat."<br>";
							    //echo "texto imagen: ".$textoimg."<br>";
							    //echo "msg correo: ".$msg_correo."<br>";
							    //echo "id grado: ".$idgra."<br>";
							    
							    if ($err) {
                                  echo "cURL Error #:" . $err."<br>";
                                } else {
                                  echo $response."<br>";
                                }
                                
                                echo json_encode($resultados, JSON_UNESCAPED_UNICODE);
							?>
						</div>
                        
					</div>
           		</div>
      		</div>
		</section>        	
		<!--footer-->
		<?php require 'footer.php'; ?>
	    <!--//footer-->
	</div>
</body>
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="../js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
			showLeftPush = document.getElementById( 'showLeftPush' ),
			body = document.body;
			
		showLeftPush.onclick = function() {
			classie.toggle( this, 'active' );
			classie.toggle( body, 'cbp-spmenu-push-toright' );
			classie.toggle( menuLeft, 'cbp-spmenu-open' );
			disableOther( 'showLeftPush' );
		};
		

		function disableOther( button ) {
			if( button !== 'showLeftPush' ) {
				classie.toggle( showLeftPush, 'disabled' );
			}
		}
	</script>
	<!-- //Classie --><!-- //for toggle left push menu script -->
		
	<!--scrolling js-->
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>