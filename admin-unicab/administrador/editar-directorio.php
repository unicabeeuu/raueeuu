<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {

		$sql_directorio="SELECT * FROM `directorio` WHERE id=".$_GET['id']."";
		$exe_directorio=mysqli_query($conexion,$sql_directorio);

		while ($rowDirectorio = mysqli_fetch_array($exe_directorio)) {
			$idD=$rowDirectorio['id'];
			$nombreD=$rowDirectorio['nombre'];
			$dependenciaD=$rowDirectorio['dependencia'];
			$correoD=$rowDirectorio['correo'];
			$skypeD=$rowDirectorio['skype'];
			$telefonoD=$rowDirectorio['telefono'];
			$telefono_whatD=$rowDirectorio['telefono_what'];
			$cargoD=$rowDirectorio['cargo'];
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
							<h4>Editar datos de:  <?php echo $nombreD; ?></h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/actualizarDirectorio.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);">
								
                                <div class="form-group"> 
									<label for="nombreD">Nombre</label> 
									<input type="text" class="form-control" id="nombreD" name="nombreD" placeholder="Ingrese nombre de la persona" value="<?php echo $nombreD; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="dependenciaD">Dependencia</label> 
									<input type="text" class="form-control" id="dependenciaD" name="dependenciaD" placeholder="Ingrese depedencia de trabajo" value="<?php echo $dependenciaD; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="correoD">Correo</label> 
									<input type="text" class="form-control" id="correoD" name="correoD" placeholder="Ingrese correo electrónico" value="<?php echo $correoD; ?>">
								</div>

								<div class="form-group"> 
									<label for="skypeD">Skype</label> 
									<input type="text" class="form-control" id="skypeD" name="skypeD" placeholder="Ingrese Skype" value="<?php echo $skypeD; ?>">
								</div>

								<div class="form-group"> 
									<label for="telefonoD">Teléfono</label> 
									<input type="text" class="form-control" id="telefonoD" name="telefonoD" placeholder="Ingrese Teléfono o Número de contacto" value="<?php echo $telefonoD; ?>">
								</div>

								<div class="form-group"> 
									<label for="whatD">Número WhatsApp</label> 
									<input type="text" class="form-control" id="whatD" name="whatD" placeholder="Ingrese Número de WhatsApp" value="<?php echo $telefono_whatD; ?>">
								</div>

								<div class="form-group"> 
									<label for="cargoD">Cargo</label> 
									<input type="text" class="form-control" id="cargoD" name="cargoD" placeholder="Ingrese cargo de trabjo" value="<?php echo $cargoD; ?>">
								</div>

								<input type="hidden" name="idD" value="<?php echo $idD; ?>">

                             	<button type="submit" class="btn btn-default">Actualizar</button> 
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
			var nombre=document.getElementById('nombreD').value;
			var dependencia=document.getElementById('dependenciaD').value;
			var cargo=document.getElementById('cargoD').value;
			
			if (nombre=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El nombre de la persona es importante para el directorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (dependencia=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La dependencia es importante</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (cargo=="") {
				$('#alert').html('<center><strong>Advertencia</strong> El cargo es importante</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}
		}
   	</script>

	<script type="text/javascript">
	    $(function () {
	        $("#nombreD").MaxLength(
	        {
	            MaxLength: 100,
	            DisplayCharacterCount: false	
	        });

	        $("#dependenciaD").MaxLength(
	        {
	            MaxLength: 50,
	            DisplayCharacterCount: false	
	        });

	        $("#correoD").MaxLength(
	        {
	            MaxLength: 100,
	            DisplayCharacterCount: false	
	        });

	        $("#skypeD").MaxLength(
	        {
	            MaxLength: 100,
	            DisplayCharacterCount: false	
	        });

	        $("#telefonoD").MaxLength(
	        {
	            MaxLength: 15,
	            DisplayCharacterCount: false	
	        });

	        $("#whatD").MaxLength(
	        {
	            MaxLength: 15,
	            DisplayCharacterCount: false	
	        });

	        $("#cargoD").MaxLength(
	        {
	            MaxLength: 100,
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