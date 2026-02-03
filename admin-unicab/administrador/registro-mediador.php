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
							<h4>Insertar nuevo registro:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/crearMediador.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

								<div class="form-group"> 
									<label for="nombre">Nombre</label> 
									<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre del mediador" autofocus="" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="cargo">Cargo</label> 
									<input type="text" class="form-control" id="cargo" name="cargo" placeholder="Ingrese cargo que tiene el mediador" autofocus="" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="profesion">Profesión</label> 
									<input type="text" class="form-control" id="profesion" name="profesion" placeholder="Ingrese profesión del mediador" autofocus="" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
                                	<label for="dependencia">Dependencia:</label> 
									<select id="area" name="dependencia" id="dependencia" class="form-control1" onblur="javascript:Validar();">
										<option value="0">--- SELECCIONE ---</option>
										<option value="Administrativo">Administrativo</option>
										<option value="Mediador">Mediador</option>
										<option value="Creativo">Creativo</option>
										<option value="Investigación">Investigación</option>
										<option value="Psicología">Psicología</option>
									</select>
								</div>

								<div class="form-group"> 
									<label for="descripcion">Descripción</label> 
									<textarea id="descripcion" name="descripcion" rows="10" class="form-control1" placeholder="Descripción o perfil del mediador" onblur="javascript:Validar();"></textarea>
								</div>

								<div class="form-group"> 
									<label for="foto">Imagen</label> 
									<input type="file" class="form-control" id="foto" name="foto">
									<p id="texto"> </p><br/>   	
									<img id="img" src=""  class="img-fluid" width="40%" />
								</div>

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
			var nombre=document.getElementById('nombre').value;
			var cargo=document.getElementById('cargo').value;
			var profesion=document.getElementById('profesion').value;
			var dependencia=document.getElementById('dependencia').value;
			var descripcion=document.getElementById('descripcion').value;
			
			if (nombre=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El nombre del mediador es Obligatorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (cargo=="") {
				$('#alert').html('<center><strong>Advertencia</strong> El cargo del mediador es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (profesion=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La profesión del mediador es Obligatorio</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (dependencia==0) {
				$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar una opción valida</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (descripcion=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La descripción el mediador es Obligatorio</center>').slideDown(500);
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
   			var extensionesValidas = ".png, .jpeg, .jpg";
     		var pesoPermitido = 1024;

     		// Cuando cambie #fichero
     		$("#foto").change(function () {
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
			$("#nombre").MaxLength({
	            MaxLength: 100,
	            DisplayCharacterCount: false	
        	});

	        $("#cargo").MaxLength({
	            MaxLength: 50,
	            DisplayCharacterCount: false	
	        });

	        $("#profesion").MaxLength({
	            MaxLength: 100,
	            DisplayCharacterCount: false	
	        });

	        $("#descripcion").MaxLength({
	            MaxLength: 2000,
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