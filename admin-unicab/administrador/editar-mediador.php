<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {

		$id=$_GET['id'];
		$sql_mediador="SELECT * FROM `mediadores` WHERE id=".$id."";
		$exe_mediador=mysqli_query($conexion,$sql_mediador);
		while ($rowMediador = mysqli_fetch_array($exe_mediador)) {
			$idM=$rowMediador['id'];
			$nombreM=$rowMediador['nombre'];
			$cargoM=$rowMediador['cargo'];
			$profesionM=$rowMediador['profesion'];
			$areaM=$rowMediador['area'];
			$equipoM=$rowMediador['equipo'];
			$descripcionM=$rowMediador['descripcion'];
			$fotoM=$rowMediador['foto'];
		}
		$url_imagen=substr($fotoM, 3);

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
							<h4>Crear mediador nuevo:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/actualizarMediador.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

								<div class="form-group"> 
									<label for="nombre">Nombre</label> 
									<input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombreM; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="cargo">Cargo</label> 
									<input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo $cargoM; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="profesion">Profesión</label> 
									<input type="text" class="form-control" id="profesion" name="profesion" value="<?php echo $profesionM; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="areav">Area</label> 
									<input type="text" class="form-control" id="areav" value="<?php echo $areaM; ?>" onblur="javascript:Validar();" disabled>
								</div>

								<div class="form-group" > 
									<label>Cambiar Área:</label> 
									<a href="#" id="mostrarArea"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarArea"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>

								<div id="area_nueva" style="display: none;">
									<div class="form-group"> 
	                                	<label for="area">Área:</label> 
										<select id="area" name="area" width="300px" class="form-control1" onblur="javascript:Validar();">
											<option value="0">--- SELECCIONE ---</option>
											<option value="Administrativo">Administrativo</option>
											<option value="Mediador">Mediador</option>
										</select>
									</div>
								</div>

								<div class="form-group"> 
									<label for="equipov">Equipo</label> 
									<input type="text" class="form-control" id="equipov"value="<?php echo $equipoM; ?>" onblur="javascript:Validar();" disabled>
								</div>

								<div class="form-group" > 
									<label>Cambiar Equipo:</label> 
									<a href="#" id="mostrarEquipo"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarEquipo"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>


								<div id="equipo_nuevo" style="display: none;">
									<div class="form-group"> 
	                                	<label for="equipo">Equipo:</label> 
										<select id="equipo" name="equipo" width="300px" class="form-control1" onblur="javascript:Validar();">
											<option value="0">--- SELECCIONE ---</option>
											<option value="Creativo">Creativo</option>
											<option value="Investigación">Investigación</option>
											<option value="Psicología">Psicología</option>
											<option value="">sin grupo</option>
										</select>
									</div>
								</div>

								<div class="form-group"> 
									<label for="descripcion">Descripción</label> 
									<textarea id="descripcion" name="descripcion" rows="10" class="form-control1" onblur="javascript:Validar();"><?php echo $descripcionM; ?></textarea>
								</div>

								<div class="form-group"> 
									<div class="media">
										<label>Imagen</label> 
									  <div class="media-left">
									      <img class="media-object" src="<?php echo $url_imagen; ?>" alt="imagen descripción evento" width="50%">
									  </div>
									</div>							
								</div>

								<div class="form-group" > 
									<label>Cambiar Imagen:</label> 
									<a href="#" id="mostrarImagen"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarImagen"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>

								<div id="imagen_nueva" style="display: none;">
									<div class="form-group"> 
										<label for="foto">Imagen</label> 
										<input type="file" class="form-control" id="foto" name="foto">
										<p id="texto"> </p><br/>   	
										<img id="img" src=""  class="img-fluid" width="40%" />
									</div>
								</div>

								<input type="hidden" name="idMediador" value="<?php echo $idM; ?>">
								<input type="hidden" name="areaV" value="<?php echo $areaM; ?>">
								<input type="hidden" name="equipoV" value="<?php echo $equipoM; ?>">
								<input type="hidden" name="imagenV" value="<?php echo $fotoM; ?>">

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
	<!-- mostrar o ocultar -->
	<script type="text/javascript">
	        $(document).ready(function(){
	        	
	        	$(document).ready(function(){
					$("#mostrarArea").on( "click", function() {
						$('#area_nueva').show();
					 });
					$("#ocultarArea").on( "click", function() {
						$('#area_nueva').hide();
					});
				});

				$(document).ready(function(){
					$("#mostrarEquipo").on( "click", function() {
						$('#equipo_nuevo').show();
					 });
					$("#ocultarEquipo").on( "click", function() {
						$('#equipo_nuevo').hide();
					});
				});

				$(document).ready(function(){
					$("#mostrarImagen").on( "click", function() {
						$('#imagen_nueva').show();
					 });
					$("#ocultarImagen").on( "click", function() {
						$('#imagen_nueva').hide();
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