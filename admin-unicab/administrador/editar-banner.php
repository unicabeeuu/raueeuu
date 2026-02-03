<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {

		$sql_banner="SELECT * FROM `banner` WHERE id=".$_GET['id']."";
		$exe_banner=mysqli_query($conexion,$sql_banner);
		while ($rowBanner = mysqli_fetch_array($exe_banner)) {
			$idB=$rowBanner['id'];
			$tituloB=$rowBanner['titulo'];
			$subtituloB=$rowBanner['subtitulo'];
			$titulo2B=$rowBanner['titulo2'];
			$subtitulo2B=$rowBanner['subtitulo2'];
			$descripcionB=$rowBanner['descripcion'];
			$imagenB=$rowBanner['imagen'];
			$boton1B=$rowBanner['boton1'];
			$texto1B=$rowBanner['texto1'];
			$boton2B=$rowBanner['boton2'];
			$texto2B=$rowBanner['texto2'];
		}
		$urlImg=substr($imagenB, 3);
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
							<h4>Editar banner</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/actualizarBanner.php" method="POST" id="form" name="form" enctype="multipart/form-data">
								<!--  -->
								<div class="form-group col-lg-12 text-left"> 
									<h3>Título</h3> 
									<hr>
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="titulo1">Text Amarillo</label> 
									<input type="text" class="form-control" id="titulo1" name="titulo1" value="<?php echo $tituloB; ?>"/>
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="titulo2">Text Blanco</label> 
									<input type="text" class="form-control" id="titulo2" name="titulo2" value="<?php echo $subtituloB; ?>"/>
								</div>

								<!-- subtitulo -->

								<div class="form-group col-lg-12 text-left"> 
									<br><h3>Subtítulo</h3> 
									<hr>
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="subtitulo1">Texto  Blanco</label> 
									<input type="text" class="form-control" id="subtitulo1" name="subtitulo1" value="<?php echo $titulo2B; ?>">
								</div>


								<div class="form-group col-lg-6 text-left"> 
									<label for="subtitulo2">Texto Amarillo</label> 
									<input type="text" class="form-control" id="subtitulo2" name="subtitulo2" value="<?php echo $subtitulo2B; ?>"/>
								</div>

								<div class="form-group col-lg-12 text-left"> 
									<br><h3>Descripción</h3> 
									<hr>
								</div>

								<div class="form-group col-lg-12 text-left"> 
									<label for="descripcion">Texto blanco</label> 
									<textArea type="text" style="resize: none;" class="form-control" id="descripcion" rows="2" name="descripcion" ><?php echo $descripcionB; ?></textArea>
								</div>

								<div class="form-group col-lg-12 text-left"> 
									<br><h3>Imagen banner</h3> 
									<hr>
								</div>

								<div class="form-group col-lg-12 text-left"> 
									<div class="media">
										<label>Imagen actual</label> 
									  <div class="media-left">
									      <img class="media-object" src="<?php echo $urlImg; ?>" alt="imagen descripción evento" width="40%">
									  </div>
									</div>							
								</div>

								<div class="form-group col-lg-12 text-left"> 
									<label for="mostralR">Cambiar Imagen:</label> 
									<a href="#" id="mostrarImagen"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarImagen"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>

								<div id="imagen_nueva" style="display: none;">
									<div class="form-group col-lg-12 text-left"> 
										<label for="ImagenN">Tamaño recomendado 1920*1280</label> 
										<input type="file" class="form-control" id="ImagenN" name="ImagenN">
										<p id="texto"> </p><br/>   	
											<img id="img" src=""  class="img-fluid" width="40%" />
									</div>
								</div>

								<!-- boton1 -->
								<div class="form-group col-lg-12 text-left"> 
									<h3>Botón 1</h3> 
									<hr>
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="boton1">Url</label> 
									<input type="text" class="form-control" id="boton1" name="boton1" value="<?php echo $boton1B; ?>" />
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="texto1">Texto</label> 
									<input type="text" class="form-control" id="texto1" name="texto1" value="<?php echo $texto1B; ?>" />
								</div>

								<!-- boton2 -->
								<div class="form-group col-lg-12 text-left"> 
									<h3>Botón 2</h3> 
									<hr>
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="boton2">Url</label> 
									<input type="text" class="form-control" id="boton2" name="boton2" value="<?php echo $boton2B; ?>" />
								</div>

								<div class="form-group col-lg-6 text-left"> 
									<label for="texto2">Texto</label> 
									<input type="text" class="form-control" id="texto2" name="texto2" value="<?php echo $texto2B; ?>" />
								</div>
								
								<!--  -->

								<input type="hidden" class="form-control" name="idBanner" value="<?php echo $idB; ?>" readonly>
								<input type="hidden" class="form-control" name="imagenV" value="<?php echo $imagenB; ?>" readonly>
								<hr>
								<div class="form-group col-lg-12 text-left"> 
									<div class="alert alert-info" role="alert">
  										<p><strong>Título: </strong> se puede dividir en dos colores: amarrillo y blanco, si se desea un texto con los dos colores se distribuye el contenido entre estos dos campos, si se quiere que el texto sea de un solo color, selecciona el campo con el color que desea el <strong>Título.</strong></p>

  										<p><strong>Subtítulo: </strong> se puede dividir en dos colores: blanco y amarrillo, si se desea un texto con los dos colores se distribuye el contenido entre estos dos campos, si se quiere que el texto sea de un solo color, selecciona el campo con el color que desea el <strong>Subtítulo.</strong></p>

  										<p><strong>Descripción: </strong> este texto es de color blanco y puede ser opcional, si se deja en blanco en la página no se visualizara este apartado del banner</p>

  										<p><strong>Imagen Banner: </strong> Esta imagen es obligatoria, las medidas deben ser de 1920px*1280px.</p>

  										<p><strong>Botones: </strong> para agregar los botones se debe de llenar los campos url (link o redirección del botón) y texto (texto que se visualizara en el botón), si los campos estan vacios no se visualizara ningun botón en el banner.</p>
  										
									</div>
								</div>
								

                             	<div class="form-group col-lg-12 text-right"> 
                                    <button type="submit" class="btn btn-default">Actualizar</button>
								</div>
							</form> 
						</div>
					</div>
					<div class="alert alert-danger" role="alert" id="alert" style="margin-top: 30px; display: none;">
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

   	<!-- validar tipo de documento -->
   	<script type="text/javascript">

   		$(document).ready(function(){
   			var extensionesValidas = ".png, .jpeg, .jpg";
     		var pesoPermitido = 1024;

     		$("#ImagenN").change(function () {
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
	        $("#titulo1").MaxLength(
	        {
	            MaxLength: 30,
	            DisplayCharacterCount: false	
	        });
	    });

	    $(function () {
	        $("#subtitulo1").MaxLength(
	        {
	            MaxLength: 30,
	            DisplayCharacterCount: false	
	        });
	    });

	    $(function () {
	        $("#titulo2").MaxLength(
	        {
	            MaxLength: 30,
	            DisplayCharacterCount: false	
	        });
	    });

	    $(function () {
	        $("#subtitulo2").MaxLength(
	        {
	            MaxLength: 30,
	            DisplayCharacterCount: false	
	        });
	    });

	    $(function () {
	        $("#descripcion").MaxLength(
	        {
	            MaxLength: 200,
	            DisplayCharacterCount: false	
	        });
	    });

	    // boton
	    $(function () {
	        $("#url1").MaxLength(
	        {
	            MaxLength: 500,
	            DisplayCharacterCount: false	
	        });
	    });

	    $(function () {
	        $("#texto1").MaxLength(
	        {
	            MaxLength: 30,
	            DisplayCharacterCount: false	
	        });
	    });
	   	
	   	$(function () {
	        $("#url2").MaxLength(
	        {
	            MaxLength: 500,
	            DisplayCharacterCount: false	
	        });
	    });

	    $(function () {
	        $("#texto2").MaxLength(
	        {
	            MaxLength: 30,
	            DisplayCharacterCount: false	
	        });
	    });
</script>
<!-- mostrar o ocultar -->
<script type="text/javascript">
        $(document).ready(function(){
        	
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