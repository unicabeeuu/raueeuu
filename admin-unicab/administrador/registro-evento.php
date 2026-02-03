<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {

		$sqlAdministrador="SELECT * FROM `administrador` WHERE `Email`='".$_SESSION['admin_unicab']."'";
		$exeAdministrador=mysqli_query($conexion,$sqlAdministrador);

		while ($rowAdmin=mysqli_fetch_array($exeAdministrador)) {
			$IdAdministrador=$rowAdmin['IdAdministrador'];
			$Apellidos=$rowAdmin['Apellido'];
			$Nombres=$rowAdmin['Nombre'];
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
							<h4>Crear nuevo evento:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/crearEvento.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

								<div class="form-group"> 
									<label for="NombreE">Nombre</label> 
									<input type="text" class="form-control" id="NombreE" name="NombreE" placeholder="Ingrese nombre del evento" autofocus="" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="DescripcionE">Descripción</label> 
									<textarea id="DescripcionE" name="DescripcionE" rows="20" class="form-control1" placeholder="Descripción o información del evento" onblur="javascript:Validar();"></textarea>
								</div>

								<div class="form-group"> 
									<label for="FechaE">Fecha</label> 
									<input type="date" class="form-control" id="FechaE" name="FechaE">
								</div> 

								<div class="form-group"> 
									<label for="HoraE">Hora</label> 
									<input type="text" class="form-control" id="HoraE" name="HoraE" placeholder="Ingrese hora del evento"> 
								</div>

								<div class="form-group"> 
									<label for="LugarE">Lugar</label> 
									<input type="text" class="form-control" id="LugarE" name="LugarE" placeholder="Ingrese lugar del evento">
								</div> 

								<div class="form-group"> 
									<label for="ImagenE">Imagen</label> 
									<input type="file" class="form-control" id="ImagenE" name="ImagenE">
									<p id="texto"> </p><br/>   	
									<img id="img" src=""  class="img-fluid" width="80%" />
								</div>

								<div class="form-group"> 
									<label for="LinkE">Link</label> 
									<input type="text" class="form-control" id="LinkE" name="LinkE" placeholder="Ingrese Link/Url del evento">
								</div>

								<div class="form-group"> 
									<label for="Autor">Públicado</label> 
									<input type="text" class="form-control" id="Autor"  readonly="" value="<?php echo $Apellidos.' '.$Nombres; ?>">
								</div>

								<input type="hidden" class="form-control" name="IdAdministrador" value="<?php echo $IdAdministrador;?>" readonly="">

								<button type="submit" class="btn btn-default">Guardar</button> 
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

   <!-- validar formulario -->
   <script type="text/javascript">
   		function Validar(){
			var nombre=document.getElementById('NombreE').value;
			var descripcion=document.getElementById('DescripcionE').value;
			
			if (nombre=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El nombre del evento es Obligatorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (descripcion=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La descripción o información del evento es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}
		}
	</script>
	<!-- validar formulario -->

	<!-- validar tipo de documento -->
   	<script type="text/javascript">

   		$(document).ready(function(){
   			var extensionesValidas = ".png, .gif, .jpeg, .jpg";
     		var pesoPermitido = 1024;

     		// Cuando cambie #fichero
     		$("#ImagenE").change(function () {
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

	<!-- validar caracteres formulario -->
	<script type="text/javascript">
		$(function () {
			$("#NombreE").MaxLength({
	            MaxLength: 400,
	            DisplayCharacterCount: false	
        	});

	        $("#DescripcionE").MaxLength({
	            MaxLength: 10000,
	            DisplayCharacterCount: false	
	        });

	        $("#HoraE").MaxLength({
	            MaxLength: 15,
	            DisplayCharacterCount: false	
	        });

	        $("#LugarE").MaxLength({
	            MaxLength: 200,
	            DisplayCharacterCount: false	
	        });

	        $("#LinkE").MaxLength({
	            MaxLength: 200,
	            DisplayCharacterCount: false	
	        });
    	});
	</script>
<!-- validar caracteres formulario -->
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>