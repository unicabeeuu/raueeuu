<?php
session_start();
require "../adminunicab/php/conexion.php";
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
	
	//Se consulta la lista de usuarios para envío de whatsapp
	$sql_what = "SELECT CONCAT(e.nombres, ' ', e.apellidos) nombre, uw.id_instancia, uw.token 
    FROM tbl_usu_whatsapp uw, tbl_empleados e 
    WHERE uw.id_empleado = e.id AND e.id = $id";
    
    $res_what=mysqli_query($conexion,$sql_what);
    
    //Se consultan la cantidad de estudiantes antiguos sin matricular
    $sql_ant = "SELECT a.id, a.ultimo_grado grado, COUNT(1) ct FROM 
    (SELECT e.nombres, e.apellidos, e.n_documento, g.id, g.grado ultimo_grado, m.estado 
    FROM (SELECT * FROM estudiantes WHERE id < 1855 AND id NOT IN (1040,1155)) e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    AND m.fecha_ingreso > '2020-11-30' AND m.fecha_ingreso < '2021-12-01' AND m.estado IN ('aprobado', 'reprobado') 
    AND e.id NOT IN (
    SELECT e.id 
    FROM estudiantes e, matricula m 
    WHERE e.id = m.id_estudiante 
    AND e.id < 1855 AND m.fecha_ingreso >= '2021-12-01') ) a 
    GROUP BY a.id, a.ultimo_grado
    ORDER BY a.id";
    
    $res_ant=mysqli_query($conexion,$sql_ant);
	
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
<!-- Bootstrap Core CSS -->
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
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>
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
<!--//Metis Menu -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#selusuario").val(0);
        $("#idInstancia").val("");
        $("#token").val("");
        $("#url").val("");
        
        $('input[name="rdgrados"]').attr('checked', false);
        $("#txtidgra").val("");
        
        $("#selenvio").val(0);
        $("#seltipoimg").val(0);
        $("#selimg").val(0);
        
        $("#textoW").hide();
	    $("#ImagenW").hide();
	    $("#textoI").hide();
	    
	    $("#lbltextoW").hide();
	    $("#lblImagenW").hide();
	    $("#lbltextoI").hide();
	    
	    $('#img').attr('src', '');
	    
	    $(".ghf").hide();
	    
	    $("#ImagenW").val("");
	    $("#textoI").val("");
	    $("#textoW").val("");
	    
	    $("#ImagenW").change(function () {
 			$('#texto').text('');
 			$('#img').attr('src', '');

 			if(validarExtension(this)) {
 				if(validarPeso(this)) {
 					verImagen(this);
		    	}
			}  
		});
		
		$("#selusuario").change(function() {
		    var usu = $("#selusuario").val();
		    var datos = usu.split(" | ");
		    
		    $("#textoI").val("");
	        $("#textoW").val("");
	        
	        $("#btnguardar").hide();
	        
	        $('input[name="rdgrados"]').attr('checked', false);
            $("#txtidgra").val("");
		    
		    if(datos[0] == 0) {
		        $("#idInstancia").val("");
    		    $("#token").val("");
    		    
    		    $("#url").val("");
    		    
    		    $(".ghf").hide();
    		    $("#selenvio").val(0);
    		    $("#seltipoimg").val(0);
    		    $("#selimg").val(0);
    		    
    		    $("#textoW").hide();
    		    $("#ImagenW").hide();
    		    $("#textoI").hide();
    		    
    		    $("#lbltextoW").hide();
        	    $("#lblImagenW").hide();
        	    $("#lbltextoI").hide();
        	    
        	    $('#img').attr('src', '');
        	    $("#ImagenW").val("");
		    }
		    else {
		        $("#idInstancia").val(datos[1]);
    		    $("#token").val(datos[2]);
    		    
    		    //var url = "https://api.ultramsg.com/instance2169/messages/image";
    		    var url = "https://api.ultramsg.com/" + datos[1] + "/messages/";
    		    $("#url").val(url);
    		    $("#ctr_url").val(url);
    		    
    		    $("#tipoenvio").show();
		    }
		    
		    
    	    //validar_campos();
    	});
    	
    	$("#selenvio").change(function() {
		    var envio = $("#selenvio").val();
		    var url = $("#ctr_url").val();
		    
		    $('#img').attr('src', '');
		    $("#seltipoimg").val(0);
		    $("#selimg").val(0);
		    $("#selimg").hide();
		    
		    $("#textoI").val("");
	        $("#textoW").val("");
	        
	        $("#btnguardar").hide();
	        
	        $('input[name="rdgrados"]').attr('checked', false);
            $("#txtidgra").val("");
		    
		    if(envio == 0) {
		        $("#textoW").hide();
    		    $("#ImagenW").hide();
    		    $("#textoI").hide();
    		    
    		    $("#lbltextoW").hide();
        	    $("#lblImagenW").hide();
        	    $("#lbltextoI").hide();
        	    
        	    $("#url").val(url);
        	    
        	    $("#imglocal").hide();
        	    $("#ImagenW").val("");
		    }
		    else if(envio == 1) {
		        $(".ghf").show();
		        
		        $("#textoW").hide();
    		    $("#ImagenW").show();
    		    $("#textoI").show();
    		    
    		    $("#lbltextoW").hide();
        	    $("#lblImagenW").show();
        	    $("#lbltextoI").show();
        	    
        	    $("#url").val(url + "image");
        	    $("#seltipoimg").show();
        	    
        	    $("#imglocal").hide();
		    }
		    else if(envio == 2) {
		        $(".ghf").show();
		        
		        $("#textoW").show();
    		    $("#ImagenW").hide();
    		    $("#textoI").hide();
    		    
    		    $("#lbltextoW").show();
        	    $("#lblImagenW").hide();
        	    $("#lbltextoI").hide();
        	    
        	    $("#url").val(url + "chat");
        	    $("#seltipoimg").hide();
        	    
        	    $("#imglocal").show();
        	    $("#ImagenW").val("");
		    }
		    
    	    //validar_campos();
    	});
    	
    	$("#seltipoimg").change(function() {
		    var tipo = $("#seltipoimg").val();
		    
		    $('#img').attr('src', '');
		    $("#ImagenW").val("");
		    
		    $("#textoI").val("");
	        $("#textoW").val("");
	        
	        $("#btnguardar").hide();
	        
	        $('input[name="rdgrados"]').attr('checked', false);
            $("#txtidgra").val("");
		    
		    if(tipo == 0) {
		        $("#selimg").val(0);
        	    $("#selimg").hide();
        	    
        	    $("#imglocal").hide();
		    }
		    else if(tipo == 1) {
		        $("#selimg").val(0);
		        $("#selimg").hide();
		        
		        $("#imglocal").show();
		    }
		    else if(tipo == 2) {
		        $("#selimg").show();
		        $("#imglocal").hide();
		    }
		    
    	    //validar_campos();
    	});
    	
    	$("#selimg").change(function() {
		    var archivo = $("#selimg").val();
		    
		    $('#img').attr('src', '');
		    
		    $("#btnguardar").hide();
		    
		    if(archivo == 0) {
		        $('#img').attr('src', '');
		    }
		    else {
		        verImagenServ(archivo);
		    }
    	});
    	
    });
    
   	// Validacion de extensiones permitidas
    function validarExtension(datos) {
        var extensionesValidas = ".png, .gif, .jpeg, .jpg";
		var ruta = datos.value;
		var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
		var extensionValida = extensionesValidas.indexOf(extension);

		if(extensionValida < 0) {
            //$('#texto').text('La extensión no es válida Su fichero tiene de extensión: .'+ extension);
            var texto = "La extensión no es válida Su fichero tiene de extensión: ." + extension + ": ";
            $("#lblmsg").html(texto).css("color","red");
            $("#ctr_ImagenA").val(1);
            mostrar_submit("ImagenA");
            
            return false;
        }else {
            $("#lblmsg").html("");
            $("#ctr_ImagenA").val(0);
            
            return true;
        }
    }

   	// Validacion de peso del fichero en kbs
    function validarPeso(datos) {
        var pesoPermitido = 1024;
        
        if (datos.files && datos.files[0]) {

		    var pesoFichero = datos.files[0].size/1024;

		    if(pesoFichero > pesoPermitido) {
		        //$('#texto').text('El peso maximo permitido del fichero es: ' + pesoPermitido + ' KBs Su fichero tiene: ' + pesoFichero +' KBs');
		        var texto = "El peso maximo permitido del fichero es: " + pesoPermitido + " KBs Su fichero tiene: " + pesoFichero + " KBs";
                $("#lblmsg").html(texto).css("color","red");
                $("#ctr_ImagenA").val(1);
                mostrar_submit("ImagenA");
                
		        return false;
		    } else {
		        $("#lblmsg").html("");
                $("#ctr_ImagenA").val(0);
            
		        return true;
		    }
		}
    }

  	// Vista preliminar de la imagen local.
  	function verImagen(datos) {
	    if (datos.files && datos.files[0]) {
	        var reader = new FileReader();
         	reader.onload = function (e) {
         		$('#img').attr('src', e.target.result);
          	};

	        reader.readAsDataURL(datos.files[0]);
	        mostrar_submit("ImagenA");
	   	}
	}
	
	// Vista preliminar de la imagen del servidor.
  	function verImagenServ(archivo) {
	    $('#img').attr('src', 'https://unicab.org/assets/img/whatsapp/' + archivo);
	}
	
	function mayus(e, id, desc) {
        //e.value = e.value.toUpperCase();
        
        if(id == "txtpreg") {
            validar_texto(id, desc);
        }
        else {
            validar_texto(id, desc);
        }
    }
    
    function validar_texto(id, desc) {
        var control = 0;
        var id_obj = "#" + id;
        var ctr_obj = "#ctr_" + id;
        var v_input = document.getElementById(id);
        var v_val = /[-_'"\<\>\~\^\*\$\#\%\&\=\+\|\{\}\[\]\\]{1,}/;
        //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
        var val = String($(id_obj).val()).match(v_val);
        
        if(val == null) {
            v_input.setCustomValidity("");
            $("#lblmsg").html("");
            //$("#alert").hide();
            $(ctr_obj).val(0);
        }
        else {
            v_input.setCustomValidity("Ha ingresado caracteres inválidos");
            var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
            texto += "- _ \' \" < > ~ ^ * $ # & = + | { } [ ] \\";
            //alert(texto);
            $("#lblmsg").html(texto).css("color","red");
            //$("#alert").show();
            $(ctr_obj).val(1);
            control = 1;
        }
		
		if(control == 0) {
		    if($(id_obj).val() == "") {
		        var texto = "El campo " + desc + " se debe llenar";
				$("#lblmsg").html(texto).css("color","red");
				//$("#alert").show();
                $(ctr_obj).val(1);
		    }
		}
		
        mostrar_submit(id);
    }
    
    function mostrar_submit(id) {
        var control = 0;
        
        var id_obj = "#" + id;
        var long = $(id_obj).val().length;
        //alert(long);
        
        //Se controla la longitud máxima
        if(id == "DescripcionA") {
            $("#lbldesc").html(long);
            if(long > 1000) {
                $("#ctr_DescripcionA").val(1);
            }
        }
        
        var a = parseInt($("#ctr_DescripcionA").val());
        var b = parseInt($("#ctr_TituloA").val());
        var c = parseInt($("#ctr_ImagenA").val());
        //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
        
        control = parseInt($("#ctr_DescripcionA").val()) + parseInt($("#ctr_TituloA").val()) + parseInt($("#ctr_ImagenA").val());
        
        //alert(control);
        if(control > 0) {
            $("#btnguardar").hide();
        }
        else {
            $("#btnguardar").show();
        }
        
        (a == 1) ? $("#DescripcionA").addClass("error") : $("#DescripcionA").removeClass("error");
        (b == 1) ? $("#TituloA").addClass("error") : $("#TituloA").removeClass("error");
        (c == 1) ? $("#ImagenA").addClass("error") : $("#ImagenA").removeClass("error");
    }
    
    function validar_datos() {
        //alert("hola");
        var usu = $("#selusuario").val();
        var envio = $("#selenvio").val();
        var texto_msg = $("#textoW").val();
        var tipo = $("#seltipoimg").val();
        var imgloc = $("#ImagenW").val();
        var texto_img = $("#textoI").val();
        var imgser = $("#selimg").val();
        var idgra = $("#txtidgra").val();
        
        var control = 0;
        //alert("usuario: " + usu);
        //alert("envio: " + envio);
        //alert("texto mensaje: " + texto_msg);
        //alert("imagen local: " + imgloc);
        //alert("texto imagen: " + texto_img);
        //alert("imagen servidor: " + imgser);
        //alert("grado: " + idgra);
        
        if(usu != 0) {
            
        }
        else {
            alert("Debe seleccionar un usuario");
            control = 1;
        }
        
        if(control == 0) {
            if(envio != 0) {
                if(envio == 1) {
                    
                    if(tipo == 0) {
                        alert("Debe seleccionar un tipo de imagen");
                        control = 1;
                    }
                    else if(tipo == 1) {
                        if(imgloc == "") {
                            alert("Debe seleccionar una imagen local");
                            control = 1;
                        }
                        else {
                            if(texto_img == "") {
                                alert("Debe ingresar el texto de la imagen");
                                control = 1;
                            }
                        }
                    }
                    else if(tipo == 2) {
                        if(imgser == 0) {
                            alert("Debe seleccionar una imagen del servidor");
                            control = 1;
                        }
                        else {
                            if(texto_img == "") {
                                alert("Debe ingresar el texto de la imagen");
                                control = 1;
                            }
                        }
                    }
                }
                else if(envio == 2) {
                    if(texto_msg == "") {
                        alert("Debe ingresar el texto del mensaje");
                        control = 1;
                    }
                }
            }
            else {
                alert("Debe seleccionar un tipo de envío");
                control = 1;
            }
        }
        
        if(control == 0) {
            //alert("Validación correcta");
            if(idgra != 0) {
                $("#btnguardar").show();
            }
            else {
                alert("Debe seleccionar un grado");
            }
        }
        
    }
    
    function marcaridgra(e) {
        //alert(e);
        $("#txtidgra").val(e);
    }
        
</script>
   	
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
		    if($id == 18) {
	        require 'menu_adm.php';
		    }
		    else {
		        //require 'menu.php';
		        require 'menu_tutores.php';
		    }  
		?>
	
		<?php require 'header.php';  ?>
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Envío masivo de whatsapp:</h4>
						</div>
						<div class="form-body">
							<form action="envio_whatsapp_putdat1.php" method="POST" id="form" name="form" enctype="multipart/form-data" target="_blank">

								<div class="form-group"> 
								    <select id="selusuario" name="selusuario" class="form-control" >
								        <option value="0">Seleccione usuario</option>
								        <?php
								            $filas = 1;
								            while ($fila_what = mysqli_fetch_array($res_what)){
								                $datos = $filas." | ".$fila_what['id_instancia']." | ".$fila_what['token'];
								                echo '<option value="'.$datos.'">'.$fila_what['nombre'].'</option>';
								                $filas++;
								            }
								        ?>
								    </select><br>
								    
								    <label for="idInstancia" class="col-lg-1 col-sm-1">Instancia</label> 
									<input type="text" class="col-lg-2 col-sm-2 readonly" id="idInstancia" name="idInstancia" readonly>
									
									<label for="token" class="col-lg-1 col-sm-1">Token</label> 
									<input type="text" class="col-lg-2 col-sm-2 readonly" id="token" name="token" readonly>
									
									<label for="url" class="col-lg-1 col-sm-1">Url</label> 
									<input type="text" class="col-lg-5 col-sm-5 readonly" id="url" name="url" readonly>
									<input type="hidden" id="ctr_url"/>
								</div><br>
								
								<div class="form-group ghf" id="tipoenvio"> 
								    <select id="selenvio" name="selenvio" class="form-control" >
								        <option value="0">Seleccione tipo de envío</option>
								        <option value="1">Imagen</option>
								        <option value="2">Texto</option>
								    </select>
								</div>
								
								<div class="form-group ghf" id="tipoenvio"> 
								    <select id="seltipoimg" name="seltipoimg" class="form-control" >
								        <option value="0">Seleccione tipo de imagen</option>
								        <option value="1">Local</option>
								        <option value="2">Servidor</option>
								    </select>
								</div>
								
								<div class="form-group ghf" id="tipoenvio"> 
								    <select id="selimg" name="selimg" class="form-control" >
								        <option value="0">Seleccione imagen del servidor</option>
								        <?php
								            //Se cargan las imágenes del servidor
								            $archivos = [];
                                    	    $thefolder = "../../assets/img/whatsapp/";
                                            if ($handler = opendir($thefolder)) {
                                                while (false !== ($file = readdir($handler))) {
                                                    if($file == "." || $file == "..") {
                                                        //No hace nada
                                                    }
                                                    else {
                                                        $archivos[] = $file;
                                                    }
                                                }
                                                closedir($handler);
                                            }
                                            
                                            foreach ($archivos as $archivo) {
                                                echo "<option value=".$archivo.">".$archivo."</option>";
                                            }
								        ?>
								    </select>
								</div>
								
								<div class="form-group ghf" id="tipoenvio"> 
								    <label for="textoW" id="lbltextoW">Texto del mensaje</label> 
									<input type="text" class="form-control" id="textoW" name="textoW" placeholder="Ingrese texto del mensaje">
									<input type="hidden" style="width: 20px" id="ctr_textoW" value="1"/>
								</div>

								<hr style="border-color: red;">

								<div class="form-group ghf" id="imglocal"> 
									<label for="ImagenW" id="lblImagenW">Imagen (Peso máximo 1024 Kb)</label> 
									<input type="file" class="form-control" id="ImagenW" name="ImagenW">
									<input type="hidden" style="width: 20px" id="ctr_ImagenW" value="1"/>
								</div>
								
								<div class="form-group ghf"> 
									<p id="texto"> </p><br/>   	
									<img id="img" src=""  class="img-fluid" width="50%" />
								</div>
								
								<div class="form-group ghf"> 
									<label for="textoI" id="lbltextoI">Texto de la imagen</label> 
									<input type="text" class="form-control" id="textoI" name="textoI" placeholder="Ingrese texto de la imagen">
									<input type="hidden" style="width: 20px" id="ctr_textoI" value="1"/>
								</div>

								<input type="hidden" class="form-control" name="IdEmp" value="<?php echo $id;?>" readonly>
								
								<hr style="border-color: red;">
								
								<div class="form-group"> 
									<label for="textoI" id="lbltextoI">Cantidad de estudidantes antiguos sin matricular por grado</label> 
									<table border="1px" style="text-align: center;">
									    <thead>
									        <tr>
									            <td width="50px">Id</td>
									            <td width="150px">Grado</td>
									            <td width="100px">Cantidad</td>
									            <td width="150px">Enviar whatsapp</td>
									        </tr>
									    </thead>
									    <tbody>
									        <?php
									            $cadena = "";
									            while($row_ant = $res_ant->fetch_assoc()) {
                                            	    $cadena = $cadena."<tr>
                                                        <td>".$row_ant['id']."</td>
                                                        <td>".$row_ant['grado']."</td>
                                                        <td>".$row_ant['ct']."</td>
                                                        <td style='text-align: center;'><input type='radio' id='rd".$row_ant['id']."' name='rdgrados' class='chk' value='".$row_ant['id']."' onchange='marcaridgra(this.value);'></td>
                                                        </tr>";
                                            	    echo $cadena;
                                            	    $cadena = "";
                                            	}
									        ?>
									    </tbody>
									</table>
								</div>
								<input type="hidden" id="txtidgra" name="txtidgra"/>
								
								<input type="button" id="btnvalidar" class="btn btn-secondary" value="Validar y Continuar" onclick="validar_datos();"/>

								<button type="submit" id="btnguardar" class="btn btn-primary" style="display: none;">Enviar Mensaje</button> 
							</form>
						</div>
						
						<!--<div class="alert alert-danger" role="alert" id="alert">
                            <p><i class="fa fa-warning"></i><span>: </span><label id="lblmsg"></label>
                            <input type="text" class="alert alert-danger" style="width: 10px" id="txtvacio" value="0"></p>
                        </div>-->
                        
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