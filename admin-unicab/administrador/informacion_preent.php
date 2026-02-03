<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		//$sqlAdministrador="SELECT * FROM `administrador` WHERE `Email`='".$_SESSION['admin_unicab']."'";
		$sql_emp = "SELECT * FROM tbl_empleados WHERE email = '".$_SESSION['admin_unicab']."' OR email = '".$_SESSION['uniprofe']."' LIMIT 1";
		$exe_emp = mysqli_query($conexion,$sql_emp);
        
		while ($row_emp = mysqli_fetch_array($exe_emp)) {
			$id_emp = $row_emp['id'];
			$apellidos_ep = $row_emp['apellidos'];
			$nombres_emp = $row_emp['nombres'];
		}
?>
<?php
    $peticion2="SET lc_time_names = 'es_CO'";
    $resultado2 = mysqli_query($conexion, $peticion2);
    
    $peticion = "SELECT DATE_FORMAT(NOW(),'%W %d de %M de %Y') fecha";
    $resultado = mysqli_query($conexion, $peticion);
    while ($fila = mysqli_fetch_array($resultado))
	{
		$fechaActual=$fila['fecha'];
    }
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	
	$query = "SELECT * FROM equivalence_idgra";
    $res_query = mysqli_query($conexion, $query);
    
    $querym = "SELECT * FROM tbl_medios_llegada";
    $res_querym = mysqli_query($conexion, $querym);

?>

<!DOCTYPE HTML>
<html>
<head>
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<!--<link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">-->

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<!--<script src="../../assets/vendor/jquery/jquery-3.3.1.min.js"></script>-->
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

    <style>
        .largo1 {
            height: 200px !Important;
        }
        .azul {
            background: lightblue;
            padding: 10px;
        }
        .azul1 {
            background: lightblue;
            padding-top: 10px;
        }
        .amarillo {
            background: lightgreen;
            padding-top: 10px;
        }
        #estado, #codigo, .gris {
            background: lightgray;
            color: black;
        }
        #documentoe {
            background: #FCFC71;
        }
        #lblbuscar {
            font-weight: bold;
            font-size: 20px;
        }
        .error {
            border: 3px solid red !important;
        }
    </style>
    
    <script>
        $(function() {
            $("#selgrado").change(function() {
                /*$("#btnsubmit").hide();
                
                var gra = $("#selgrado").val();
                //alert(gra);
                
                if (gra == "NA") {
                    $("#btnsubmit").hide();
                }
                else {
                    $("#btnsubmit").show();
                }*/
                
                mostrar_submit();
        	});
        	
        	$("#selmedio").change(function() {
                mostrar_submit();
        	});
        	
        	$("#selinteresado").change(function() {
                mostrar_submit();
        	});
        	
        });
        
        function buscar_inf() {
            //alert("hola");
            //$(".loader").fadeOut("slow");
            
            //Se limpian los controles
            $("#estado").val("");
            $("#nombrea").val("");
            $("#cela").val("");
            $("#emaila").val("");
            $("#ciudad").val("");
            $("#nombree").val("");
            $("#apellidoe").val("");
            $("#documentoe").val("");
            $("#actextra").val("");
            $("#observaciones").val("");
            $("#id_est").val("0");
            $("#buscar1").val("");
            
            //Se valida si el documento corresponde al código de pre-matrícula
            var buscar = $("#buscar").val();
            
            $.ajax({
                type:"POST",
        		url:"informacion_premat_getdat.php",
        		data:"buscar=" + buscar + "&tipo=DOC",
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var r_est = res.estado;
        		    //alert(res.entrevista);
        		    $("#estado").val(r_est);
        		    
        		    $("#nombrea").val(res.nom_a);
        		    $("#cela").val(res.cel_a);
        		    $("#emaila").val(res.email_a);
        		    $("#ciudad").val(res.ciu_a);
        		    $("#nombree").val(res.nombres);
        		    $("#apellidoe").val(res.apellidos);
        		    $("#documentoe").val(res.documento);
        		    $("#actextra").val(res.extra);
        		    $("#observaciones").val(res.obs);
        		    $("#id_est").val(res.id);
        		    $("#codigo").val(res.id);
        		    $("#tieneEntrevista").val(res.entrevista);
        		    $("#reprogramado").val(res.reprogramado);
        		    
        		    if(res.ct == 1 || res.ct_est == 1) {
            		    //alert("Datos cargados ");
            		    document.getElementById("selgrado").value = res.idgrado;
            		    document.getElementById("selmedio").value = res.idmedio;
            		    document.getElementById("selinteresado").value = res.interesado;
            		    $("#btnsubmit").show();
        		    }
        		    else {
        		        document.getElementById("selgrado").value = "NA";
        		        $("#tieneEntrevista").val("NO");
        		        $("#btnsubmit").hide();
        		    }
        		}
        	});
        }
        
        function buscar_inf1() {
            //alert("hola");
            //$(".loader").fadeOut("slow");
            
            //Se limpian los controles
            $("#estado").val("");
            $("#nombrea").val("");
            $("#cela").val("");
            $("#emaila").val("");
            $("#ciudad").val("");
            $("#nombree").val("");
            $("#apellidoe").val("");
            $("#documentoe").val("");
            $("#actextra").val("");
            $("#observaciones").val("");
            $("#id_est").val("0");
            $("#buscar").val("");
            
            //Se valida si el documento corresponde al código de pre-matrícula
            var buscar = $("#buscar1").val();
            
            $.ajax({
                type:"POST",
        		url:"informacion_premat_getdat.php",
        		data:"buscar=" + buscar + "&tipo=CEL",
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var r_est = res.estado;
        		    //alert(r_est);
        		    $("#estado").val(r_est);
        		    
        		    $("#nombrea").val(res.nom_a);
        		    $("#cela").val(res.cel_a);
        		    $("#emaila").val(res.email_a);
        		    $("#ciudad").val(res.ciu_a);
        		    $("#nombree").val(res.nom_est);
        		    $("#apellidoe").val(res.ape_est);
        		    $("#documentoe").val(res.doc_est);
        		    $("#actextra").val(res.act_ext);
        		    $("#observaciones").val(res.obs);
        		    $("#id_est").val(res.id);
        		    $("#codigo").val(res.id);
        		    
        		    if(res.ct == 1) {
            		    //alert("Datos cargados ");
            		    document.getElementById("selgrado").value = res.id_grado;
            		    $("#btnsubmit").show();
        		    }
        		    else {
        		        document.getElementById("selgrado").value = "NA";
        		        $("#btnsubmit").hide();
        		    }
        		}
        	});
        }
        
        function validar_texto(id, desc) {
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var v_input = document.getElementById(id);
            //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
            var v_val = /[_'"\~\$\#\&\|;\(\)\{\}\[\]\\]{1,}/;
            var val = String($(id_obj).val()).match(v_val);
            
            if(val == null) {
                v_input.setCustomValidity("");
                $("#lblmsg").html("");
                //$("#btnsubmit").show();
                $("#ctr_observ").val(0);
            }
            else {
                v_input.setCustomValidity("Ha ingresado caracteres inválidos");
                var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                texto += " _ \' \" ~ $ # & | ; ( ) { } [ ] \\";
                //alert(texto);
                $("#lblmsg").html(texto).css("color","red");
                //$("#btnsubmit").hide();
                $("#ctr_observ").val(1);
            }
            
            mostrar_submit();
        }
        
        function mostrar_submit() {
            var a = parseInt($("#ctr_emaila").val());
            (a == 1) ? $("#emaila").addClass("error") : $("#emaila").removeClass("error");
            
            var control = 0;
            var gra = $("#selgrado").val();
            if(gra == "NA") {
                $("#btnsubmit").hide();
                control = 1;
            }
            
            if(control == 0) {
                var observ = $("#ctr_observ").val();
                if(observ == 1) {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                var emaila = $("#ctr_emaila").val();
                if(emaila == 1) {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                var medio = $("#selmedio").val();
                if(medio == "NA") {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                var interesado = $("#selinteresado").val();
                if(interesado == "NA") {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                $("#btnsubmit").show();
            }
        }
        
        function validar_email(id, desc) {
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var input_email = document.getElementById(id);
            var patron = /^[_-\w.]+@[a-z]+\.[a-z.]{2,6}$/;
            var esCoincidente = patron.test($(id_obj).val());
            if(esCoincidente) {
                input_email.setCustomValidity("");
                //$("#lblmsg_email").html("");
                $(ctr_obj).val(0);
            }
            else {
                input_email.setCustomValidity("No es un patrón de correo válido");
                var texto = "No es un patrón de correo válido para " + desc;
                //alert(texto);
                //$("#lblmsg_email").html(texto).css("color","red");
                $(ctr_obj).val(1);
                control = 1;
            }
			
            mostrar_submit();
        }
        
    </script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!-- menu -->
		<?php 
			require "include/header.php";
		?>
		<!-- menu -->
		
		<!-- header -->
		<?php 
			require "include/menu.php";
		?>
		<!-- header -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Información base de datos pre matrícula</h4><?php //echo $sql_emp; ?>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow azul1" data-example-id="basic-forms"> 
						<div class="form-group col-lg-6 text-left">
    					    <label id="lblbuscar">Buscar por identificación del estudiante:</label>
    					</div>
    					<div class="form-group col-lg-6 text-left azul1">
    					    <input type="text" class="" id="buscar" name="buscar" width="300px">
    						<button class="btn btn-success" onclick="buscar_inf();">Buscar</button>
    					</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow amarillo" data-example-id="basic-forms"> 
						<div class="form-group col-lg-6 text-left">
    					    <label id="lblbuscar">Buscar por celular del acudiente:</label>
    					</div>
    					<div class="form-group col-lg-6 text-left amarillo">
    					    <input type="text" class="" id="buscar1" name="buscar1" width="300px">
    						<button class="btn btn-primary" onclick="buscar_inf1();">Buscar</button>
    					</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/crearInformacion.php" method="POST" id="form" name="form" enctype="multipart/form-data">
							<!--<form action="php/crearInformacion.php" method="POST" id="form" name="form" target="_blank" enctype="multipart/form-data">-->
                                <div class="form-group col-lg-6 text-left azul"> 
                                    <label for="estado">  Estado: </label>
									<input type="text" id="estado" name="estado" width="100px" readonly required>
								</div>
								<div class="form-group col-lg-6 text-left azul"> 
                                    <label for="estado">  Id (código entrevista): </label>
									<input type="text" id="codigo" name="codigo" width="100px" readonly required>
								</div>
								
                                <div class="form-group col-lg-6 text-left"> 
                                <label for="nombrea">Nombre acudiente:</label>
									<input type="text" class="form-control" id="nombrea" name="nombrea" placeholder="Ingrese nombre acudiente" width="300px" readonly required>
								</div>
								<div class="form-group col-lg-6 text-left"> 
                                <label for="cela">Celular acudiente:</label>
									<input type="text" class="form-control" id="cela" name="cela" placeholder="Ingrese celular acudiente sin espacios" width="300px" readonly required>
								</div>
								
								<div class="form-group col-lg-6 text-left"> 
                                <label for="emaila">Email acudiente:</label>
									<input type="text" class="form-control" id="emaila" name="emaila" placeholder="Ingrese email acudiente" width="300px" onkeyup="validar_email('emaila', 'Email acudiente');" readonly required>
									<input type="hidden" id="ctr_emaila" name="ctr_emaila" value="1"/>
								</div>
								<div class="form-group col-lg-6 text-left"> 
                                <label for="ciudad">Ciudad:</label>
									<input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Ingrese ciudad" width="300px" readonly required>
								</div>
								
								<hr>
								<div class="form-group col-lg-6 text-left"> 
                                <label for="nombree">Nombres estudiante:</label>
									<input type="text" class="form-control" id="nombree" name="nombree" placeholder="Ingrese nombres estudiante" width="300px" readonly required>
								</div>
								<div class="form-group col-lg-6 text-left"> 
                                <label for="apellidoe">Apellidos estudiante:</label>
									<input type="text" class="form-control" id="apellidoe" name="apellidoe" placeholder="Ingrese apellidos estudiante" width="300px" readonly required>
								</div>
								
								<div class="form-group col-lg-6 text-left"> 
                                <label for="documentoe">Documento estudiante:</label>
									<input type="text" class="form-control" id="documentoe" name="documentoe" placeholder="Ingrese documento estudiante" width="300px" readonly required>
								</div>
								<div class="form-group col-lg-6 text-left"> 
                                <label for="actextra">Actividad extra:</label>
									<input type="text" class="form-control" id="actextra" name="actextra" placeholder="Ingrese actividad extra del estudiante" idth="300px" readonly required>
								</div>
								
								<div class="form-group col-lg-6 text-left"> 
                                <label for="selgrado">Grado:</label> 
									<select id="selgrado" name="selgrado" width="300px" class="form-control1">
										<option value="NA" selected>Seleccione grado</option>
										<?php 
									        while ($row = mysqli_fetch_array($res_query)){
									            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
									        }
									    ?>
									</select>
								</div>
								
								<div class="form-group col-lg-6 text-left"> 
                                <label for="selgrado">Medio de Llegada:</label> 
									<select id="selmedio" name="selmedio" width="300px" class="form-control1" required>
										<option value="NA" selected>Seleccione medio</option>
										<?php 
									        while ($rowm = mysqli_fetch_array($res_querym)){
									            echo "<option value='".$rowm['id']."'>".$rowm['medio']."</option>";
									        }
									    ?>
									</select>
								</div>
								
								<div class="form-group col-lg-6 text-left"> 
                                <label for="selgrado">Interesado:</label> 
									<select id="selinteresado" name="selinteresado" width="300px" class="form-control1" required>
										<option value="NA" selected>Seleccione</option>
										<option value="NO">NO</option>
										<option value="SI">SI</option>
									</select>
								</div>
								
								<div class="form-group col-lg-3 text-left"> 
                                    <label for="tieneEntrevista">Entrevista:</label> 
									<input type="text" id="tieneEntrevista" name="tieneEntrevista" class="gris" style="width: 50px" readonly/>
								</div>
								<div class="form-group col-lg-3 text-left"> 
									<label for="reprogramado">Reprogramado:</label>
									<input type="text" id="reprogramado" name="reprogramado" class="gris" style="width: 50px" readonly/>
								</div>
                                
                                <div class="form-group col-lg-12 text-left"> 
                                <label for="observaciones">Observaciones generales: (Máximo 300 caracteres) </label>
                                    <textArea type="text" class="form-control largo1" id="observaciones" name="observaciones" placeholder="Ingrese las observaciones generales" onkeyup="validar_texto('observaciones', 'Observaciones');" maxlength="300" required></textArea>
                                    <label id="lblmsg"></label>
									<input type="hidden" id="ctr_observ" name="ctr_observ" value="1"/>
								</div>
                                
                                 <div class="form-group col-lg-12 text-right"> 
                                    <input type="submit" id="btnsubmit" class="btn btn-warning" value="Guardar" style="display: none;"/>
<!--  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
                                    <!--<button type="submit" class="btn btn-default">Guardar</button>-->
                                    <input type="hidden" id="id_emp" name="id_emp" value="<?php echo $id_emp;?>"/>
                                    <input type="hidden" id="id_est" name="id_est"/>
								</div>

								<div class="alert alert-danger" role="alert" id="alert" style="margin-top: 30px; display: none;">
								</div>
							</form> 
						</div>
					</div>
                    <!--<div class="alert alert-info" role="alert"><b>La información se guardará con fecha:</b> <?php echo $fechaActual;?></div>-->
				</div>
			</div>
		</div>
		<!--footer-->
		<?php 
			require "include/footer.php";
		?>
        <!--//footer-->
	</div>
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
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

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
   <script type="text/javascript" src="../js/MaxLength.min.js"></script>

   <script type="text/javascript">
   		function Validar(){
			var nombre=document.getElementById('TituloB').value;
			var descripcion=document.getElementById('DescripcionB').value;
			var categoria=document.getElementById('CategoriaB').value;
			
			if (nombre=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El título del Blog es Obligatorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (descripcion=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La descripción o información del Blog es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (categoria==0) {
				$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar una categoria valida</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}
		}
   	</script>

   	<!-- validar tipo de documento -->
   	<script type="text/javascript">

   		$(document).ready(function(){
   			var extensionesValidas = ".png, .gif, .jpeg, .jpg";
     		var pesoPermitido = 1024;

     		$("#ImagenB").change(function () {
     			$('#texto').text('');
     			$('#img').attr('src', '');

     			if(validarExtension(this)) {
     				if(validarPeso(this)) {
     					verImagen(this);
			    	}
				}  
    		});

		    // Validacion de extensiones permitidas
		    function validarExtension(datos) {

				var ruta = datos.value;
				var extension = ruta.substring(ruta.lastIndexOf('.') + 1).toLowerCase();
				var extensionValida = extensionesValidas.indexOf(extension);

				if(extensionValida < 0) {
		            $('#texto').text('La extensión no es válida Su fichero tiene de extensión: .'+ extension);
		            return false;
		        }else {
		            return true;
		        }
		    }

		   	// Validacion de peso del fichero en kbs
		    function validarPeso(datos) {

		        if (datos.files && datos.files[0]) {

				    var pesoFichero = datos.files[0].size/1024;

				    if(pesoFichero > pesoPermitido) {
				        $('#texto').text('El peso maximo permitido del fichero es: ' + pesoPermitido + ' KBs Su fichero tiene: '+ pesoFichero +' KBs');
				        return false;
				    } else {
				        return true;
				    }
				}
		    }

		  	// Vista preliminar de la imagen.
		  	function verImagen(datos) {
			    if (datos.files && datos.files[0]) {
			        var reader = new FileReader();
		         	reader.onload = function (e) {
		         		$('#img').attr('src', e.target.result);
		          	};

			        reader.readAsDataURL(datos.files[0]);

			   	}
			}
		});
   	</script>
   	<!-- validar tipo de documento -->
	
	<script type="text/javascript">
    $(function () {
        $("#TituloB").MaxLength(
        {
            MaxLength: 400,
            DisplayCharacterCount: false	
        });

        $("#DescripcionB").MaxLength(
        {
            MaxLength: 10000,
            DisplayCharacterCount: false	
        });
    });
</script>
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>