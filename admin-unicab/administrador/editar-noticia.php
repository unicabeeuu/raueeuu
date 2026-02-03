<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {

		$sql_buscarN="SELECT * FROM `noticia` WHERE `IdNoticia`=".$_GET['id']."";
		$exe_buscarN=mysqli_query($conexion,$sql_buscarN);

		while ($rowNoticia=mysqli_fetch_array($exe_buscarN)) {
			$idNoticia=$rowNoticia['IdNoticia'];
			$titulo=$rowNoticia['TituloN'];
			$descripcion=$rowNoticia['DescripcionN'];
			$imagen=$rowNoticia['ImagenN'];
			$categoria=$rowNoticia['CategoriaN'];
			$fuente=$rowNoticia['FuenteN'];
		}

		$direccionImagen=substr($imagen, 3);
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
							<h4>Editar noticia: <?php echo $titulo; ?></h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/actualizarNoticia.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

								<div class="form-group"> 
									<label for="TituloN">Título</label> 
									<input type="text" class="form-control" id="TituloN" name="TituloN" placeholder="Ingrese nombre de la noticia" value="<?php echo $titulo; ?>" onblur="javascript:Validar();">
								</div>

								<div class="form-group"> 
									<label for="DescripcionN">Descripción</label> 
									<textarea id="DescripcionN" name="DescripcionN" rows="20" class="form-control1" placeholder="Descripción o información de la noticia" onblur="javascript:Validar();"><?php echo $descripcion; ?></textarea>
								</div>

								<div class="form-group"> 
									<div class="media">
										<label>Imagen</label> 
									  <div class="media-left">
									      <img class="media-object" src="<?php echo $direccionImagen; ?>" alt="imagen descripción evento" width="50%">
									  </div>
									</div>							
								</div>

								<div class="form-group" > 
									<label for="mostralR">Cambiar Imagen:</label> 
									<a href="#" id="mostrarImagen"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarImagen"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>
								
								<div id="imagen_nueva" style="display: none;">
									<div class="form-group"> 
										<label for="ImagenN">Imagen</label> 
										<input type="file" class="form-control" id="ImagenN" name="ImagenN">
										<p id="texto"> </p><br/>   	
											<img id="img" src=""  class="img-fluid" width="80%" />
									</div>
								</div>


								<div class="form-group"> 
									<label for="categoriaActual">Categoría</label> 
									<input type="text" class="form-control" id="categoriaActual" name="categoriaActual" value="<?php echo $categoria; ?>" readonly="">
								</div> 

								<div class="form-group" > 
									<label>Cambiar Categoría:</label> 
									<a href="#" id="mostrarCategoria"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="#" id="ocultarCategoria"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
								</div>


								<div id="categoria_nueva" style="display: none;">
									<div class="form-group"> 
										<label for="CategoriaN">Categoría</label> 
										<select id="CategoriaN" name="CategoriaN" class="form-control1">
											<option value="">--- SELECCIONE ---</option>
											<option value="Educación">Educación</option>
											<option value="Deporte">Deporte</option>
										</select>
									</div>
								</div>	

								<div class="form-group"> 
									<label for="FuenteN">Fuente</label> 
									<input type="text" class="form-control" id="FuenteN" name="FuenteN" placeholder="Ingrese nombre o link de la fuente" value="<?php echo $fuente; ?>">
								</div> 

								<div class="form-group"> 
									<label for="Autor">Públicado</label> 
									<input type="text" class="form-control" id="Autor"  readonly="" value="<?php echo $Apellidos.' '.$Nombres; ?>">
								</div>

								<input type="hidden" class="form-control" name="ImagenActual" value="<?php echo $imagen;?>" readonly="">

								<input type="hidden" class="form-control" name="CategoriaActual" value="<?php echo $categoria;?>" readonly="">

								<input type="hidden" class="form-control" name="IdNoticia" value="<?php echo $idNoticia;?>" readonly="">

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

   <script type="text/javascript">
   		function Validar(){
			var titlo=document.getElementById('TituloN').value;
			var descripcion=document.getElementById('DescripcionN').value;
			var categoria=document.getElementById('CategoriaN').value;
			
			if (titlo=="") {
 				$('#alert').html('<center><strong>Advertencia</strong> El título de la noticia es Obligatorio</center>').slideDown(500);
 				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}

			if (descripcion=="") {
				$('#alert').html('<center><strong>Advertencia</strong> La descripción o información de la noticia es Obligatorio</center>').slideDown(500);
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

     		// Cuando cambie #fichero
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
        $("#TituloN").MaxLength(
        {
            MaxLength: 400,
            DisplayCharacterCount: false	
        });

        $("#DescripcionN").MaxLength(
        {
            MaxLength: 10000,
            DisplayCharacterCount: false	
        });

        $("#FuenteN").MaxLength(
        {
            MaxLength: 200,
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

				$(document).ready(function(){
					$("#mostrarCategoria").on( "click", function() {
						$('#categoria_nueva').show();
					 });
					$("#ocultarCategoria").on( "click", function() {
						$('#categoria_nueva').hide();
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