<?php 
	session_start();
	require "../php/conexion.php";
	require("1cc3s4db.php");
if (isset($_SESSION['admin_unicab'])) {

	/*$sqlAdministrador="SELECT * FROM `administrador` WHERE `Email`='".$_SESSION['admin_unicab']."'";
	$exeAdministrador=mysqli_query($conexion,$sqlAdministrador);

	while ($rowAdmin=mysqli_fetch_array($exeAdministrador)) {
		$IdAdministrador=$rowAdmin['IdAdministrador'];
		$Apellidos=$rowAdmin['Apellido'];
		$Nombres=$rowAdmin['Nombre'];
	}*/
	
	$query = "SELECT * FROM equivalence_idgra WHERE id_grado_ra NOT IN (150, 160, 170, 180, 130, 140, 0)";
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
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

    <style>
        #cont {
        	display: flex;
        	justify-content: space-around;
        }
        fieldset {
        	border: 2px double green;
        	-moz-border-radius: 8px;
        	-webkit-border-radius: 8px;	
        	border-radius: 8px;
        }
        legend {
        	 text-align: center;
        	 font-weight: bold;
        	 font-size: 18pt;
        	 color: #B4045F;
        	 text-shadow: 0px 0px 10px #BA55D3;
        }
        .mprincipal {
        	list-style-image: url("../images/m26.png");
        	font-weight: bold !important;
            font-size: 20px !important;
        }
        .msecund {
        	list-style-image: url(../images/bd30.png); 
        	background: lightgreen;
        	padding: 20px;
        	font-weight: bold;
        	font-size: 18px;
        }
        .msecund li {
        	background: #cce5ff;
        	margin-left: 20px;
        	margin-top: 5px;
        }
    </style>
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
					<!---------------------------------------------->
                    <div id="cont">
            			<div id="div2">
            				<fieldset>
            				<legend><h3>BUSCAR EN BASE DE DATOS</h3></legend>
            				    <form class="form-horizontal" action="../../registro/docenteunicab/updreg/estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
            					<ul class="mprincipal">
            						<li><h3>BUSCAR POR NOMBRE O APELLIDO <span style="color: blue;">ACTIVO</span></h3></li>
            							<ul class="msecund">
            								<li>
												<input type="text" id="buscar" name="buscar" placeholder="Ingrese nombre" required/>
												<label style="color: white;">...</label>
												<!--<a href="estudiante_getdat.php" >Buscar</a>-->
												<input type="submit" class="btn btn-primary" value="Buscar" >
												<input type="hidden" id="estado" name="estado" value="activo" required/>
											</li>
            							</ul>
            					</ul>
            					</form>
            					<form class="form-horizontal" action="../../registro/docenteunicab/updreg/estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
            					<ul class="mprincipal">
            						<li><h3>BUSCAR POR NOMBRE O APELLIDO <span style="color: red;">INACTIVO</span></h3></li>
            							<ul class="msecund">
            								<li>
												<input type="text" id="buscar" name="buscar" placeholder="Ingrese nombre" required/>
												<label style="color: white;">...</label>
												<!--<a href="estudiante_getdat.php" >Buscar</a>-->
												<input type="submit" class="btn btn-primary" value="Buscar" >
												<input type="hidden" id="estado" name="estado" value="inactivo" required/>
											</li>
            							</ul>
            					</ul>
            					</form>
            					<form class="form-horizontal" action="../../registro/docenteunicab/updreg/estudianteg_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
            					<ul class="mprincipal">
            						<li><h3>BUSCAR POR GRADO ACTIVO<span style="color: white;">.....</span>
            						<input type="checkbox" class="chk" id="chkper" name="chkper"/> <span style="color: red;">Perdiendo</span>
            						<select id="selper" name="selper">
            						    <option value="0">Sel. periodo</option>
            						    <option value="1">1</option>
            						    <option value="2">2</option>
            						    <option value="3">3</option>
            						    <option value="4">4</option>
            						</select>
            						</h3></li>
            							<ul class="msecund">
            								<li>
												<select id="selgra1" name="selgra1" required>
												    <option value="NA">Seleccione grado</option>
												    <?php 
												        while($row = $resultado1->fetch_assoc()){
												            echo "<option value='".$row['id_category']."'>".$row['name']."</option>";
												        }
												    ?>
												</select>
												<label style="color: white;">...</label>
												<select id="selgrupo" name="selgrupo" required>
												    <option value="NA" selected>Grupo</option>
												    <option value="A">A</option>
												    <option value="B">B</option>
												    <option value="C">C</option>
												    <option value="D">D</option>
												</select>
												<label style="color: white;">...</label>
												<!--<a href="estudianteg_getdat.php" >Buscar</a>-->
												<input type="submit" class="btn btn-primary" value="Buscar" >
												<input type="hidden" id="estadog" name="estadog" value="activo" required/>
											</li>
            							</ul>
            					</ul>
            					</form>
            					<form class="form-horizontal" action="../../registro/docenteunicab/updreg/bd_exportar_getdat.php"  method="POST" target="_blank">
                					<ul class="mprincipal">
                						<li><h3>EXPORTAR BASE DE DATOS</h3></li>
                							<ul class="msecund">
                								<li>
													<input type="submit" class="btn btn-primary" value="Exportar" >
												</li>
                							</ul>
                					</ul>
                				</form>
            				</fieldset>
            
            			</div>
            		</div>
					<div id="resul_bus"></div>
					<?php
        				$mysqli1->close();
        			?>
					<!---------------------------------------------->
                    
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