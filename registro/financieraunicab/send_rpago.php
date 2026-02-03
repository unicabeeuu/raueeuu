<?php
    require("../docenteunicab/updreg/1cc3s4db.php");
    //1014859175

    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$fecha2 =$a."/".$mes."/". $dia;
	
	$msg_correo1 = "";
	$msgregistro = "";

    class Email {
	
    	//nombre
    	var $nombre;
    	//email del emisor
    	var $mail;
    	//email del receptor
    	var $mailr;
    	var $asunto;
    	//mensaje
    	var $msn;
    	//documento
    	//var $doc;
    	//archivo adjunto
    	var $adjunto;
    	//var $adjunto2;
    	//var $adjunto3;
    	//var $adjunto4;
    	//var $adjunto5;
    	//var $adjunto6;
    	//var $adjunto7;
    	//var $adjunto8;
    	//var $adjunto9;
    	//var $adjunto10;
    	
    	//enviar el mensaje
    	private $sender;
    	
    	//url para redireccionar
    	private $url;
    
    	//función constructora
    	public function __construct(){
    		//cada uno de ellos es el parámetro que enviamos desde el formulario
    		$this->nombre = $n;
    		$this->mail = $m;
    		$this->mailr = $mr;
    		$this->asunto = $a;
    		$this->msn = $ms;
    		$this->adjunto = $ad;
    		//$this->adjunto = $ad2;
    		//$this->adjunto = $ad3;
    		//$this->adjunto = $ad4;
    		//$this->adjunto = $ad5;
    		//$this->adjunto = $ad6;
    		//$this->adjunto = $ad7;
    		//$this->adjunto = $ad8;
    		//$this->adjunto = $ad9;
    		//$this->adjunto = $ad10;
    	}
    
    	//método enviar con los parámetros del formulario
    	public function enviar($m,$mr,$a,$ms,$ad){
    	    echo "<br/>entro a la función enviar correo";
    		//si existe post
    		if(isset($_REQUEST)){
    		    //si existe adjunto
			    if($ad) {
			        $fichero_ok = "ghf_".basename($ad);
			        move_uploaded_file($_FILES['adjunto']['tmp_name'], $fichero_ok);
			    }
			
                echo "<br/>entro al envío";
                echo "<br/>origen: ".$m;
                echo "<br/>destino: ".$mr;
                echo "<br/>asuno: ".$a;
                echo "<br/>mensaje: ".$ms;
                echo "<br>archivo: ".$fichero_ok;
    			//archivo necesario para enviar los archivos adjuntos
    			require_once 'AttachMailer.php';
    
    			//enviamos el mensaje (emisor,receptor,asunto,mensaje)
    			$this->sender = new AttachMailer($m, $mr, $a, $ms);
    			$this->sender->attachFile($fichero_ok);
    			
    			//eliminamos el fichero de la carpeta con unlink()
    			//si queremos que se guarde en nuestra carpeta, lo comentamos o borramos
    			unlink($fichero_ok);
    			
    			//enviamos el email con el archivo adjunto
    			$this->sender->send();
    			
    			return "CorreoOK";
    		}
    		else{
    		    return "CorreoError";
    		}
    	}
    	
    	//método para devolver el resultado
    	public function resultado() {
    	    return $this->msg_correo;
    	}
    }

    // estudiante
    /*$documento = $_REQUEST['register_documento'];
    echo "documento: ".$documento;
    
    $tipprod = $_REQUEST['register_producto'];
    $text_prod = $_REQUEST['text_producto'];
    //$opinter = $_REQUEST['opinter'];
    $desc_emp =$_REQUEST['register_emprendimiento'];
    //$oppart = $_REQUEST['oppart'];
    //echo "<br/>".$oppart;
    
    $apellidos = strtoupper($_REQUEST['register_apellidos']);
    $nombres = strtoupper($_REQUEST['register_nombres']);
    $fecha_inscripción = strtoupper($_REQUEST['register_year']);
    $celular = strtoupper($_REQUEST['register_telefono']);
    $correo = $_REQUEST['register_email'];
    
    //Se consulta el producto o servicio
	$sql_est = "SELECT e.id, e.n_documento, e.nombres, e.apellidos, e.ciudad, e.email_institucional, e.telefono_estudiante, 
	m.id_grado, g.grado 
	FROM admin_unicab.estudiantes e, 
	(SELECT * FROM admin_unicab.matricula WHERE idMatricula = 
    (SELECT MAX(idMatricula) maxid FROM admin_unicab.matricula WHERE id_estudiante = 621 AND estado = 'activo')) m, admin_unicab.grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND e.n_documento = ".$documento;
	$res_est=$mysqli1->query($sql_est);
	while($row_est = $res_est->fetch_assoc()){
	    $ciudad = $row_est['ciudad'];
	    $grado = $row_est['grado'];
	}

    //Se hace el insert en la tabla tbl_participantes
    $sql_insertp = "INSERT INTO tbl_participantes (id_tipo_participante, id_evento, nombres, apellidos, razon_social, email, fecha_inscripcion, 
        celular, descripcion_participacion, ciudad, duracion, identificacion_est, grado_est, dia_participacion) VALUES 
        (5, 1, '$nombres', '$apellidos', 'NA', '$correo', '$fecha2', '$celular', '$desc_emp', 'NA', 8, '$documento', '0', 2)";
    $res_insertp=$mysqli1->query($sql_insertp);
    echo $sql_insertp;
    
    //Se consulta el id del participante
    $id = 0;
    $sql_id = "SELECT id FROM tbl_participantes WHERE identificacion_est = ".$documento;
    echo "<br/>".$sql_id;
    $res_id=$mysqli1->query($sql_id);
	while($row_id = $res_id->fetch_assoc()){
	    $id = $row_id['id'];
	}
	
	if($id > 0) {
	    $msgregistro = "RegistroOK";
	}
	else {
	    $msgregistro = "RegistroError";
	}
    
    //Se hace el insert en la tabla tbl_detalles_eventos
    $sql_insertde = "INSERT INTO tbl_detalles_eventos (id_evento, id_participante, id_tipo_talento, id_producto_servicio, fecha, descripcion_actividad, hora_inicio, duracion) 
    VALUES (1, $id, 1, $tipprod, '$fecha2', '$desc_emp', '00:00', '8')";
    $res_insertde=$mysqli1->query($sql_insertde);
    echo "<br/>".$sql_insertde;
    
    $msg_correo1 = "CorreoError";*/
    $msgregistro = "RegistroOK";
    if($msgregistro == "RegistroOK") {
        //llamamos a la clase
        $obj = new Email();
    
        //$emailReceptor = "numericopensamientoclei2@gmail.com";
        //$emailReceptor = "matriculas.unicab@gmail.com,matriculas.academica@unicab.org,numericopensamientoclei2@gmail.com,eventosunicab@gmail.com";
        $emailReceptor = "numericopensamientoclei2@gmail.com";
        //$nombreCompleto = $_REQUEST['register_nombres']." ".$_REQUEST['register_apellidos'];
        //$asuntoMensaje = "Inscripción de ".$nombreCompleto." al PRIMER CONGRESO INTERNACIONAL DE EDUCACION ESCOLAR VIRTUAL Y ALTERNATIVAS EDUCATIVAS ";
        $asuntoMensaje = "Prueba de envío de PDF";
        //$asuntoMensaje = "UNICAB TALEN SHOW ";
        $cuerpoMensaje = "<h2>--- DATOS ----</h2>
        <br> Mensaje: Esto es una prueba de envío de PDF guardado localmente en serviror<br>";
        //ejecutamos el método enviar con los parámetros que recibimos del formulario
        
        $adjunto_c= $_FILES['adjunto']['name'];
        echo "adjunto: ".$adjunto_c;
        //$correoorigen1="impactodigitalcol@gmail.com";
        $correoorigen1="numericopensamientoclei2@gmail.com";
        
        //Se envía el correo
        $msg_correo1 = $obj->enviar($correoorigen1, $emailReceptor, $asuntoMensaje, $cuerpoMensaje, $adjunto_c);
    }
    
    echo "<br/>".$msg_correo1;
    
    $resultado = $msgregistro."_".$msg_correo1."_".$id;
	echo "<br/>".$resultado;
    
    //header('Location: ../form1.php?s='.$resultado);
?>