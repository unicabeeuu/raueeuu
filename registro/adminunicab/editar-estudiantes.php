<?php
	session_start();
	require "php/conexion.php";
	if (isset($_SESSION['unisuper'])) {
	    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
    	$res=mysqli_query($conexion,$sql);
    
    	while ($fila0 = mysqli_fetch_array($res)){
    	  	$id_emp = $fila0['id'];
    		$apellidos_emp  = $fila0['apellidos'];
    		$nombres_emp = $fila0['nombres'];
    		$email_institucional_emp = $fila0['email'];
    		$director=$fila0['d_pensamiento'];
    		$n_documento_emp = $fila0['n_documento'];
    		$password_emp = $fila0['pc'];
    		$perfil = $fila0['perfil'];
    	}
	    
		$sql_estudiante="SELECT e.*, td.id idtd, td.tipo_documento tipo_documento1, m.estado estado_m 
		FROM `estudiantes` e, tbl_tipos_documento td, matricula m 
		WHERE e.tipo_documento = td.id AND e.id = m.id_estudiante AND e.id = ".$_GET['id']."";
		$exe_estudiante=mysqli_query($conexion,$sql_estudiante);

		while ($fila = mysqli_fetch_array($exe_estudiante)) {
			$id = $fila['id'];
			$apellidos = $fila['apellidos'];
			$nombres = $fila['nombres'];
			$genero = $fila['genero'];
			$idtd=$fila['idtd'];
			$tipo_documento=$fila['tipo_documento1'];
			$n_documento = $fila['n_documento'];
			$fecha_nacimiento = $fila['fecha_nacimiento'];
			$expedicion=$fila['expedicion'];
			$ciudad = $fila['ciudad'];
			$direccion = $fila['direccion'];
			$direccion_estudiante = $fila['direccion_estudiante'];
			$email_institucional = $fila['email_institucional'];
			$actividad_extra = $fila['actividad_extra'];
			$email_acudiente_1 = $fila['email_acudiente_1'];
			$email_acudiente_2 = $fila['email_acudiente_2'];
			$acudiente_1 = $fila['acudiente_1'];
			$documento_acu = $fila['documento_responsable'];
			$acudiente_2 = $fila['acudiente_2'];
			$telefono_acudiente_1 = $fila['telefono_acudiente_1'];
			$telefono_acudiente_2 = $fila['telefono_acudiente_2'];
			$parentesco_acudiente_1 = $fila['parentesco_acudiente_1'];
			$parentesco_acudiente_2 = $fila['parentesco_acudiente_2'];
			$rh = $fila['estado'];
			$estado = $fila['estado_m'];
			$password = $fila['password'];
			$mensaje=$fila['mensaje'];
		}
		
		//Se cargan los tipos de documento
    	$sql_td = "SELECT * FROM tbl_tipos_documento";
    	$res_td=mysqli_query($conexion,$sql_td);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
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
#chartdiv {
  width: 100%;
  height: 295px;
}
</style>

<script type="text/javascript">
	$(function() {
		$("#tDocumento").change(function() {
			if($("#tDocumento").val() == "NA") {
				$("#submit").hide();
			}
			else {
				$("#submit").show();
			}
			validar_campos();
		});
		
		$("#genero").change(function() {
			if($("#genero").val() == "NA") {
				$("#submit").hide();
			}
			else {
				$("#submit").show();
			}
			validar_campos();
		});
		
		$("#parentesco_acudiente_1").change(function() {
			if($("#parentesco_acudiente_1").val() == "NA") {
				$("#submit").hide();
			}
			else {
				$("#submit").show();
			}
			validar_campos();
		});
		
		buscar();
	});
	
	function validar_campos() {
		if($("#tDocumento").val() == "NA") {
			$("#submit").hide();
		}
		else {
			$("#submit").show();
		}
		if($("#genero").val() == "NA") {
			$("#submit").hide();
		}
		else {
			$("#submit").show();
		}
		if($("#parentesco_acudiente_1").val() == "NA") {
			$("#submit").hide();
		}
		else {
			$("#submit").show();
		}
	}

	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
        }
	}
	
	function buscar() {
			var doc = $("#n_documento").val();
			
			$.ajax({
        		type:"POST",
        		url:"buscar_estudiante_getdat.php",
        		data:"doc=" + doc,
        		success:function(r) {
        		    var res = JSON.parse(r);
        			//alert(res.idgenero);
					$("#apellidos").val(res.apellidos);
					$("#nombres").val(res.nombres);
					$("#tDocumento").val(res.tipo_documento).change();
					$("#genero").val(res.genero).change();
					$("#fecha_nacimiento").val(res.fecha_nacimiento);
					$("#expedicion").val(res.expedicion);
					$("#ciudad").val(res.ciudad);
					$("#direccion_est").val(res.direccion_estudiante);
					$("#telefono_estudiante").val(res.telefono_estudiante);
					$("#email_institucional").val(res.email_institucional);
					$("#actividad_extra").val(res.actividad_extra);
					$("#mensaje").val(res.mensaje);
					$("#password").val(res.password);
					$("#rh").val(res.estadoe);
					$("#grado").val(res.id_grado).change();
					
					$("#email_acudiente_1").val(res.email_acudiente_1);
					$("#acudiente_1").val(res.acudiente_1);
					$("#documento_acu").val(res.documento_responsable);
					$("#telefono_acudiente_1").val(res.telefono_acudiente_1);
					$("#direccion").val(res.direccion);
					$("#parentesco_acudiente_1").val(res.parentesco_acudiente_1);
					
					$("#email_acudiente_2").val(res.email_acudiente_2);
					$("#acudiente_2").val(res.acudiente_2);
					$("#telefono_acudiente_2").val(res.telefono_acudiente_2);
					$("#parentesco_acudiente_2").val(res.parentesco_acudiente_2);
					
					$("#submit").show();
        		}
        	});		
			
		}
	
</script>

</head> 
<body class="cbp-spmenu-push" onload="back_form();">
	<div class="main-content">
		<?php //require 'menu.php';  ?>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else if($perfil == "AR1") {
		        require 'menu_registro_aux.php';
		    }
		    else {
		        require 'menu.php';
		    }
		?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		<!-- main content start-->
        <section>
           <div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Información Estudiante: <?php echo $nombres." ".$apellidos; ?></h4>
						</div>
						<div class="form-body">
							<form class="form-horizontal" action="php/update-estudiante-admin.php" method="POST">
								<div class="form-group">
									<label for="n_documento" class="col-sm-2 control-label">Identificación:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="n_documento" name="n_documento" placeholder="Número Documento" required maxlength="15" value="<?php echo $n_documento;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="apellidos" class="col-sm-2 control-label">Apellidos:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="apellidos" name="apellidos" placeholder="Apellidos Estudiante" required maxlength="25" value="<?php //echo $apellidos;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="nombres" class="col-sm-2 control-label">Nombres:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="nombres" name="nombres"  placeholder="Nombres Estudiante" required maxlength="25" value="<?php //echo $nombres;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="tDocumento" class="col-sm-2 control-label">Tipo Documento:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="tDocumento" name="tDocumento" class="form-control1">
											<!--<option value="<?php //echo $idtd; ?>"><?php //echo $tipo_documento; ?></option>-->
				                		 	<option value="2">REGISTRO CIVIL</option>
							                <option value="1">TARJETA DE IDENTIDAD</option>
						                 	<option value="3">CEDULA</option>
							                <option value="4">PASAPORTE</option>
							                <option value="5">PERMISO DE PERMANENCIA TEMPORAL</option>
							                <option value="6">PERMISO POR PROTECCIÓN TEMPORAL</option>
				              			</select>
									</div>
								</div>
									
								<div class="form-group">
									<label for="genero" class="col-sm-2 control-label">Genero:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="genero" name="genero" class="form-control1">
											<!--<option value="<?php //echo $genero; ?>"><?php //echo $genero; ?></option>-->
					                		<option value="MASCULINO">MASCULINO</option>
				               			 	<option value="FEMENINO">FEMENINO</option>
				              			</select>
									</div>
								</div>

								<div class="form-group">
									<label for="fecha_nacimiento" class="col-sm-2 control-label">Fecha Nacimiento:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" id="fecha_nacimiento" name="fecha_nacimiento" required value="<?PHP  //echo date('Y-m-d',strtotime($fecha_nacimiento)); ?>" >
									</div>
								</div>

								<div class="form-group">
									<label for="expedicion" class="col-sm-2 control-label">Expedición:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="expedicion" name="expedicion" placeholder="Lugar Expedición Documento" required maxlength="25" value="<?php //echo $expedicion; ?>">
									</div>
								</div>

								<div class="form-group">
									<label for="ciudad" class="col-sm-2 control-label">Ciudad:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="ciudad" name="ciudad" placeholder="Ciudad Origen" required maxlength="25" value="<?php //echo $ciudad;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="direccion" class="col-sm-2 control-label">Dirección:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="direccion_est" name="direccion_est" placeholder="Dirección Residencia" required maxlength="100" value="<?php //echo $direccion_estudiante;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="email_institucional" class="col-sm-2 control-label">Correo Institucional:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="email" class="form-control1" id="email_institucional" name="email_institucional" placeholder="Email Institucional" required maxlength="50" value="<?php //echo $email_institucional;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="actividad_extra" class="col-sm-2 control-label">Acvidiad Extra:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="actividad_extra" name="actividad_extra" placeholder="Deporte que Realiza"  maxlength="50" value="<?php //echo $actividad_extra;?>">
									</div>
								</div>

								<div class='form-group'>
									<label for='focusedinput' class='col-sm-2 control-label'>Estado:<span class="req">*</span></label>
									<div class='col-sm-8'>
										<select id='estado' name='estado' class='form-control1' required>
											<option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
									       	<option value='activo'>activo</option>
				                			<option value='inactivo'>inactivo</option>
                                    		<option value='retirado'>retirado</option>
			              				</select>
									</div>
								</div>

								<div class="form-group">
									<label for="actividad_extra" class="col-sm-2 control-label">Mensaje Personalizado:
									</label>
									<div class="col-sm-8">
										<textarea class="form-control1" maxlength="512" placeholder="en este campo podra crear un mensaje personalizado para cada uno de los estudiantes" name="mensaje" id="mensaje" title="máximo 512 caracteres"><?php //echo $mensaje; ?></textarea>
									</div>
								</div>

                                <div class='form-group'>
									<label for='password' class='col-sm-2 control-label'>Contraseña:</label>
									<div class='col-sm-8'>
										<input type='text' class='form-control1' id='password' name='password' placeholder='Ingrese la contraseña nueva'  maxlength='15' value="<?php //echo $password;?>">
									</div>
								</div>
								
								<div class='form-group'>
									<label for='rh' class='col-sm-2 control-label'>RH:</label>
									<div class='col-sm-8'>
										<input type='text' class='form-control1' id='rh' name='rh' placeholder='Ingrese RH'  maxlength='15' value="<?php //echo $rh;?>">
									</div>
								</div>

								<div class="form-title">
									<h4>Información acuediente principal</h4>
								</div><br>

								<div class="form-group">
									<label for="email_acudiente_1" class="col-sm-2 control-label">Correo:</label>
									<div class="col-sm-8">
										<input type="email" class="form-control1" id="email_acudiente_1" name="email_acudiente_1" placeholder="Email" maxlength="50" value="<?php //echo $email_acudiente_1;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="acudiente_1" class="col-sm-2 control-label">Nombre:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="acudiente_1" name="acudiente_1" placeholder="Nombre"  maxlength="50" value="<?php //echo $acudiente_1;?>">
									</div>
								</div>
								
								<div class="form-group">
    								<label for="documento_acu" class="col-sm-2 control-label">Documento:<span class="req">*</span></label>
    								<div class="col-sm-8">
    									<input type="text" class="form-control1" id="documento_acu" name="documento_acu" placeholder="Documento"  maxlength="50" value="<?php //echo $documento_acu;?>">
    								</div>
    							</div>

								<div class="form-group">
									<label for="telefono_acudiente_1" class="col-sm-2 control-label">Teléfono:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="telefono_acudiente_1" name="telefono_acudiente_1" placeholder="Teléfono" maxlength="15" value="<?php //echo $telefono_acudiente_1;?>">
									</div>
								</div>
								
								<div class="form-group">
    								<label for="direccion" class="col-sm-2 control-label">Dirección de residencia:<span class="req">*</span></label>
    								<div class="col-sm-8">
    									<input type="text" class="form-control1" id="direccion" name="direccion" placeholder="Dirección Residencia" required maxlength="100" value="<?php //echo $direccion;?>">
    								</div>
    							</div>
    							
    							<div class="form-group">
									<label for="tDocumento" class="col-sm-2 control-label">Parentesco:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="parentesco_acudiente_1" name="parentesco_acudiente_1" class="form-control1">
											<!--<option value="<?php //echo $parentesco_acudiente_1; ?>"><?php //echo $parentesco_acudiente_1; ?></option>-->
				                		 	<option value="NA">SELECCIONE PARENTESCO</option>
											<option value="MADRE">MADRE</option>
							                <option value="PADRE">PADRE</option>
						                 	<option value="ABUELA">ABUELA</option>
							                <option value="ABUELO">ABUELO</option>
							                <option value="HERMANA">HERMANA</option>
							                <option value="HERMANO">HERMANO</option>
											<option value="TIA">TIA</option>
							                <option value="TIO">TIO</option>
							                <option value="PRIMA">PRIMA</option>
							                <option value="PRIMO">PRIMO</option>
							                <option value="OTRO">OTRO</option>
				              			</select>
									</div>
								</div>

								<div class="form-title">
									<h4>Información acuediente secundario (<strong>opcional</strong>)</h4>
								</div><br>

								<div class="form-group">
									<label for="email_acudiente_2" class="col-sm-2 control-label">Correo:</label>
									<div class="col-sm-8">
										<input type="email" class="form-control1" id="email_acudiente_2" name="email_acudiente_2" placeholder="Email" maxlength="50" value="<?php //echo $email_acudiente_2;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="acudiente_2" class="col-sm-2 control-label">Nombre:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="acudiente_2" name="acudiente_2" placeholder="Nombre"  maxlength="50" value="<?php //echo $acudiente_2;?>">
									</div>
								</div>

								<div class="form-group">
									<label for="telefono_acudiente_2" class="col-sm-2 control-label">Teléfono:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="telefono_acudiente_2" name="telefono_acudiente_2" placeholder="Teléfono" maxlength="15" value="<?php //echo $telefono_acudiente_2;?>">
									</div>
								</div>
								
								<div class="form-group">
									<label for="tDocumento" class="col-sm-2 control-label">Parentesco:</label>
									<div class="col-sm-8">
										<select id="parentesco_acudiente_2" name="parentesco_acudiente_2" class="form-control1">
											<?php
												if($parentesco_acudiente_2 == "NA") {
											?>
													<!--<option value="<?php //echo $parentesco_acudiente_2; ?>">SELECCIONE PARENTESCO</option>-->
											<?php
												}
												else {
											?>
													<!--<option value="<?php //echo $parentesco_acudiente_2; ?>"><?php //echo $parentesco_acudiente_2; ?></option>-->
											<?php
												}
											?>
				                		 	<option value="NA">SELECCIONE PARENTESCO</option>
											<option value="MADRE">MADRE</option>
							                <option value="PADRE">PADRE</option>
						                 	<option value="ABUELA">ABUELA</option>
							                <option value="ABUELO">ABUELO</option>
							                <option value="HERMANA">HERMANA</option>
							                <option value="HERMANO">HERMANO</option>
											<option value="TIA">TIA</option>
							                <option value="TIO">TIO</option>
							                <option value="PRIMA">PRIMA</option>
							                <option value="PRIMO">PRIMO</option>
							                <option value="OTRO">OTRO</option>
				              			</select>
									</div>
								</div>
								
								<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

								<hr>

							    <button type="submit" class="btn btn-primary" id="submit" >
							      <span class="fa fa-save"></span> Guardar Cambios
							    </button>

							    <!--<button type="button" class="btn btn-primary">
							      <span class="fa fa-download"></span> Descargar
							    </button>-->

							    <a href="lista-estudiantes.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							</form> 
						</div>
					</div>
           		</div>
      		</div>
		</section>
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
	</div>
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

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>