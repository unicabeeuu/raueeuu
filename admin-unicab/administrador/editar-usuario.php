<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {

		$sql_buscarA="SELECT * FROM `administrador` WHERE `IdAdministrador`=".$_GET['id']."";
		$exe_buscarA=mysqli_query($conexion,$sql_buscarA);

		while ($rowAdminstrador=mysqli_fetch_array($exe_buscarA)) {
			$idAdministrador=$rowAdminstrador['IdAdministrador'];
			$nombreA=$rowAdminstrador['Nombre'];
			$apellidoA=$rowAdminstrador['Apellido'];
			$correoA=$rowAdminstrador['Email'];
			$perfilA=$rowAdminstrador['Perfil'];
		}
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
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

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
							<h4>Editar usuario: <?php echo $nombre." ".$apellido; ?></h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/actualizarUsuario.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">
								<div class="form-group"> 
									<label for="NombreU">Nombre</label> 
									<input type="text" class="form-control" id="NombreU" name="NombreU" placeholder="Ingrese nombre" value="<?php echo $nombreA; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="ApellidoU">Apellido</label> 
									<input type="text" class="form-control" id="ApellidoU" name="ApellidoU" placeholder="Ingrese apellido" value="<?php echo $apellidoA; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="PerfilActual">Perfil</label> 
									<input type="text" class="form-control" value="<?php echo $perfilA; ?>" disabled="">
								</div>

								<div class="form-group" > 
									<label>Cambiar Perfil:</label> 
									<a href="#" id="mostrarPerfil"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarPerfil"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>

								<div id="perfil_nueva" style="display: none;">
									<div class="form-group"> 
	                                	<label for="PerfilNuevo">Perfil:</label> 
										<select id="PerfilNuevo" name="PerfilNuevo" width="300px" class="form-control1" onblur="javascript:Validar();">
											<option value="">--- SELECCIONE ---</option>
											<option value="Psicólogo">Psicólogo</option>
	                                        <option value="Publicista">Publicista</option>
										</select>
									</div>
								</div>	

								<div class="form-group"> 
									<label for="CorreoU">Correo Electrónico</label> 
									<input type="text" class="form-control" id="CorreoU" name="CorreoU" placeholder="Ingrese correo electrónico" value="<?php echo $correoA; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group" > 
									<label>Cambiar Contraseña:</label> 
									<a href="#" id="mostrarPass"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarPass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>
                                	
                            	<div id="pass_nueva" style="display: none;">
									<div class="form-group"> 
										<label for="PassU">Contraseña</label> 
										<input type="password" class="form-control" id="PassU" name="PassU" placeholder="Ingrese password" onblur="javascript:Validar();">
									</div>
								</div>

								<input type="hidden" name="IdAdministrador" value="<?php echo $idAdministrador; 
								?>">
								<input type="hidden" name="PerfilActual" value="<?php echo $perfilA; ?>">

                             	<button type="submit" class="btn btn-default">Guardar Cambios</button> 
								<br>
								<div class="alert alert-danger" role="alert" id="alert" style="margin-top: 30px; display: none;">
								</div>
							</form> 
						</div>
					</div>
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
			var nombre=document.getElementById('NombreU').value;
			var apellido=document.getElementById('ApellidoU').value;
			var correo=document.getElementById('CorreoU').value;

			emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
			
			if (nombre=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El nombre del usuario es Obligatorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (apellido=="") {
				$('#alert').html('<center><strong>Advertencia</strong> El apellido del usuario es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (emailRegex.test(correo)) {
		 		$('#alert').html('').slideUp(300);	
     		}else {
       			$('#alert').html('<center><strong>Advertencia</strong> El correo no tiene el formato correcto</center>').slideDown(500);
		 		$('#usuario').focus();
   			return false;
     		}

     		if (correo=="") {
				$('#alert').html('<center><strong>Advertencia</strong> El Correo Electrónico es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}
		}
   </script>

	<script type="text/javascript">
	    $(function () {
	        $("#NombreU").MaxLength(
	        {
	            MaxLength: 50,
	            DisplayCharacterCount: false	
	        });

	        $("#ApellidoU").MaxLength(
	        {
	            MaxLength: 50,
	            DisplayCharacterCount: false	
	        });

	        $("#CorreoU").MaxLength(
	        {
	            MaxLength: 100,
	            DisplayCharacterCount: false	
	        });

	        $("#PassU").MaxLength(
	        {
	            MaxLength: 60,
	            DisplayCharacterCount: false	
	        });
	    });
	</script>

	<!-- mostrar o ocultar -->
	<script type="text/javascript">
	        $(document).ready(function(){
	        	
	        	$(document).ready(function(){
					$("#mostrarPerfil").on( "click", function() {
						$('#perfil_nueva').show();
					 });
					$("#ocultarPerfil").on( "click", function() {
						$('#perfil_nueva').hide();
					});
				});

				$(document).ready(function(){
					$("#mostrarPass").on( "click", function() {
						$('#pass_nueva').show();
					 });
					$("#ocultarPass").on( "click", function() {
						$('#pass_nueva').hide();
					});
				});
			});
	</script>
<!-- mostrar o ocultar -->
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>