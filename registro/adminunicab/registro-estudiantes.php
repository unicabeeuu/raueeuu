<?php
	session_start();
	require "php/conexion.php";
	if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
	    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
    	$res=mysqli_query($conexion,$sql);
    
    	while ($fila = mysqli_fetch_array($res)){
                          
    	  	$id = $fila['id'];
    		$apellidos  = $fila['apellidos'];
    		$nombres = $fila['nombres'];
    		$email_institucional = $fila['email'];
    		# $director=$fila['d_pensamiento'];
    		$n_documento = $fila['n_documento'];
    		$password = $fila['pc'];
    		$perfil = $fila['perfil'];
    	}
    	
    	//Se cargan los tipos de documento
    	$sql_td = "SELECT * FROM tbl_tipos_documento";
    	$res_td=mysqli_query($conexion,$sql_td);
    	
    	//Se cargan los generos
    	$sql_g = "SELECT * FROM tbl_generos";
    	$res_g=mysqli_query($conexion,$sql_g);
    	
    	//Se cargan los grados
    	$sql_gra = "SELECT * FROM tbl_grados WHERE id = 0 OR (id BETWEEN 9 AND 12) ORDER BY id";
    	$res_gra=mysqli_query($conexion,$sql_gra);
	    
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Academic Registry</title>
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

    <script>
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
		
		function buscar() {
			let doc = $("#n_documento").val();
			
			$.ajax({
        		type:"POST",
        		url:"buscar_estudiante_getdat.php",
        		data:"doc=" + doc,
        		success:function(r) {
        		    let res = JSON.parse(r);
        			//alert(res.idgenero);
					$("#apellidos").val(res.apellidos);
					$("#nombres").val(res.nombres);
					$("#tDocumento").val(res.tipo_documento).change();
					$("#genero").val(res.genero).change();
					$("#fecha_nacimiento").val(res.fecha_nacimiento);
					$("#expedicion").val(res.expedicion);
					$("#ciudad").val(res.ciudad);
					$("#direccion_estudiante").val(res.direccion_estudiante);
					$("#telefono_estudiante").val(res.telefono_estudiante);
					$("#email_institucional").val(res.email_institucional);
					$("#actividad_extra").val(res.actividad_extra);
					$("#pass").val(res.password);
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
        		}
        	});
		}
    </script>

</head> 
<body class="cbp-spmenu-push">
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
       	<div id="page-wrapper">
			<div class="forms">
				<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
					<div class="form-title">
						<h4>Student Registration:</h4>
					</div>
					<div class="form-body">
						<form class="form-horizontal" action="php/registrarEstudiante.php" method="POST">
							<div class="form-group">
								<label for="n_documento" class="col-sm-2 control-label">Identification:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="n_documento" name="n_documento" placeholder="Document Number" required maxlength="15">
								</div>
								<div class="col-sm-2">
									<button class="btn btn-primary" onclick="buscar();">
										<span class="fa fa-search"></span> Search
									</button>
								</div>
							</div>
							<div class="form-group">
								<label for="apellidos" class="col-sm-2 control-label">Last Names:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="apellidos" name="apellidos" placeholder="Student Last Names" required maxlength="25" autofocus="">
								</div>
							</div>

							<div class="form-group">
								<label for="nombres" class="col-sm-2 control-label">First Names:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="nombres" name="nombres"  placeholder="Student First Names" required maxlength="25">
								</div>
							</div>
							<div class="form-group">
								<label for="tDocumento" class="col-sm-2 control-label">Document Type:<span class="req">*</span></label>
								<div class="col-sm-8">
									<select id="tDocumento" name="tDocumento" class="form-control1" required>
						                <option value="NA" selected>SELECT DOCUMENT TYPE</option>
						                <?php  
						                    while ($fila1 = mysqli_fetch_array($res_td)){
						                ?>
						                    <option value="<?php echo $fila1['id'] ?>"><?php echo $fila1['tipo_documento'] ?></option>
						                <?php  
						                    }
						                ?>
						                <!--<option value="Tarjeta de Identidad">Tarjeta de Identidad</option>
					                 	<option value="Cédula">Cédula</option>
						                <option value="Pasaporte">Pasaporte</option>-->
					              </select>
								</div>
							</div>
							<div class="form-group">
								<label for="genero" class="col-sm-2 control-label">Gender:<span class="req">*</span></label>
								<div class="col-sm-8">
									<select id="genero" name="genero" class="form-control1" required>
						                <option value="NA" selected>SELECT GENDER</option>
						                <?php  
						                    while ($fila2 = mysqli_fetch_array($res_g)){
						                ?>
						                    <option value="<?php echo $fila2['genero'] ?>"><?php echo $fila2['genero'] ?></option>
						                <?php  
						                    }
						                ?>
						                <!--<option value="Masculino">Masculino</option>
						                <option value="Femenino">Femenino</option>-->
					              </select>
								</div>
							</div>
							<div class="form-group">
								<label for="fecha_nacimiento" class="col-sm-2 control-label">Date of Birth:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="date" class="form-control1" id="fecha_nacimiento" name="fecha_nacimiento" required >
								</div>
							</div>
							<div class="form-group">
								<label for="expedicion" class="col-sm-2 control-label">Expedition:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="expedicion" name="expedicion" placeholder="Document Expedition Place" required maxlength="25">
								</div>
							</div>
							<div class="form-group">
								<label for="ciudad" class="col-sm-2 control-label">City:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="ciudad" name="ciudad" placeholder="City of Origin" required maxlength="25">
								</div>
							</div>

							<div class="form-group">
								<label for="direccion_estudiante" class="col-sm-2 control-label">Home Address:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="direccion_estudiante" name="direccion_estudiante" placeholder="Home Address" required maxlength="100">
								</div>
							</div>

							<div class="form-group">
								<label for="telefono_estudiante" class="col-sm-2 control-label">Phone:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="telefono_estudiante" name="telefono_estudiante" placeholder="Phone" maxlength="15">
								</div>
							</div>

							<div class="form-group">
								<label for="email_institucional" class="col-sm-2 control-label">Institutional Email:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="email" class="form-control1" id="email_institucional" name="email_institucional" placeholder="Institutional Email" required maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="actividad_extra" class="col-sm-2 control-label">Extra Activity:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="actividad_extra" name="actividad_extra" placeholder="Sport Practiced"  maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="pass" class="col-sm-2 control-label">Password:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="password" class="form-control1" id="pass" name="pass" maxlength="15" placeholder="Student Password" required="">
								</div>
							</div>

							<div class='form-group'>
								<label for='rh' class='col-sm-2 control-label'>RH:</label>
								<div class='col-sm-8'>
									<input type='text' class='form-control1' id='rh' name='rh' placeholder='Enter RH'  maxlength='15' value="<?php echo $rh;?>">
								</div>
							</div>

							<div class="form-group">
								<label for="grado" class="col-sm-2 control-label">Grade:<span class="req">*</span></label>
								<div class="col-sm-8">
									<select id="grado" name="grado" class="form-control1" required>
						                <option value="1" selected>SELECT GRADE</option>
						                <?php  
						                    while ($fila3 = mysqli_fetch_array($res_gra)){
						                ?>
						                    <option value="<?php echo $fila3['id'] ?>"><?php echo $fila3['grado'] ?></option>
						                <?php  
						                    }
						                ?>
					              </select>
								</div>
							</div>

							<div class="form-title">
								<h4>Primary Guardian Information</h4>
							</div><br>

							<div class="form-group">
								<label for="email_acudiente_1" class="col-sm-2 control-label">Email:</label>
								<div class="col-sm-8">
									<input type="email" class="form-control1" id="email_acudiente_1" name="email_acudiente_1" placeholder="Email" maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="acudiente_1" class="col-sm-2 control-label">Name:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="acudiente_1" name="acudiente_1" placeholder="Name"  maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="documento_acu" class="col-sm-2 control-label">Document:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="documento_acu" name="documento_acu" placeholder="Document"  maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="telefono_acudiente_1" class="col-sm-2 control-label">Phone:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="telefono_acudiente_1" name="telefono_acudiente_1" placeholder="Phone" maxlength="15">
								</div>
							</div>

							<div class="form-group">
								<label for="direccion" class="col-sm-2 control-label">Home Address:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="direccion" name="direccion" placeholder="Home Address" required maxlength="100">
								</div>
							</div>

							<div class="form-group">
									<label for="tDocumento" class="col-sm-2 control-label">Relationship:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="parentesco_acudiente_1" name="parentesco_acudiente_1" class="form-control1">
											<option value="NA">SELECT RELATIONSHIP</option>
											<option value="MADRE">MOTHER</option>
							                <option value="PADRE">FATHER</option>
						                 	<option value="ABUELA">GRANDMOTHER</option>
							                <option value="ABUELO">GRANDFATHER</option>
							                <option value="HERMANA">SISTER</option>
							                <option value="HERMANO">BROTHER</option>
											<option value="TIA">AUNT</option>
							                <option value="TIO">UNCLE</option>
							                <option value="PRIMA">FEMALE COUSIN</option>
							                <option value="PRIMO">MALE COUSIN</option>
							                <option value="OTRO">OTHER</option>
				              			</select>
									</div>
								</div>

							<div class="form-title">
								<h4>Secondary Guardian Information (<strong>optional</strong>)</h4>
							</div><br>

							<div class="form-group">
								<label for="email_acudiente_2" class="col-sm-2 control-label">Email:</label>
								<div class="col-sm-8">
									<input type="email" class="form-control1" id="email_acudiente_2" name="email_acudiente_2" placeholder="Email" maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="acudiente_2" class="col-sm-2 control-label">Name:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="acudiente_2" name="acudiente_2" placeholder="Name"  maxlength="50">
								</div>
							</div>

							<div class="form-group">
								<label for="telefono_acudiente_2" class="col-sm-2 control-label">Phone:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="telefono_acudiente_2" name="telefono_acudiente_2" placeholder="Phone" maxlength="15">
								</div>
							</div>

							<div class="form-group">
									<label for="tDocumento" class="col-sm-2 control-label">Relationship:</label>
									<div class="col-sm-8">
										<select id="parentesco_acudiente_2" name="parentesco_acudiente_2" class="form-control1">
											<option value="NA">SELECT RELATIONSHIP</option>
											<option value="MADRE">MOTHER</option>
							                <option value="PADRE">FATHER</option>
						                 	<option value="ABUELA">GRANDMOTHER</option>
							                <option value="ABUELO">GRANDFATHER</option>
							                <option value="HERMANA">SISTER</option>
							                <option value="HERMANO">BROTHER</option>
											<option value="TIA">AUNT</option>
							                <option value="TIO">UNCLE</option>
							                <option value="PRIMA">FEMALE COUSIN</option>
							                <option value="PRIMO">MALE COUSIN</option>
							                <option value="OTRO">OTHER</option>
				              			</select>
									</div>
								</div>
							<hr>
							<button type="submit" class="btn btn-primary" id="submit" style="display: none;">
						      	<span class="fa fa-save"></span> Save Information
						    </button>
						</form> 
					</div>
				</div>
       		</div>
  		</div>
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
	</div>
	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="../js/classie.js"></script>
		<script>
			let menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
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
	echo "<script>alert('You must log in');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>