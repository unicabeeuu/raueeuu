<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		$sql_emp = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW','PS') AND id NOT IN (1,30,31,49)";
		$exe_emp = mysqli_query($conexion,$sql_emp);
        
		/*while ($row_emp = mysqli_fetch_array($exe_emp)) {
			$id_emp = $row_emp['id'];
			$apellidos_ep = $row_emp['apellidos'];
			$nombres_emp = $row_emp['nombres'];
		}*/
?>
<?php
$peticion2="SET lc_time_names = 'es_CO'";
$resultado2 = mysqli_query($conexion, $peticion2);

$peticion = "SELECT DATE_FORMAT(NOW(),'%W %d de %M de %Y') fecha";
$resultado = mysqli_query($conexion, $peticion);
while ($fila = mysqli_fetch_array($resultado))
	{
		$fechaActual=$fila['fecha'];
    }  ;

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

    <link href='fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='fullcalendar/lib/main.js'></script>
    <script src='fullcalendar/lib/locales-all.js'></script>
    <script>
        $(function() {
            $("#psicologo").change(function() {
                var psi_txt = $("#psicologo option:selected").text();
                $("#txt_psicologo").val(psi_txt);
                
                var psi = $("#psicologo").val();
                //alert(psi);
                if(psi == "0") {
                    $("#btnsubmit").hide();
                }
                else {
                    $("#btnsubmit").show();
                }
                
        	});
        });
    
    </script>

    <style>
        .azul1 {
            background: lightblue;
            padding-top: 10px;
        }
        .fc-toolbar-title {
            font-size: 20px !Important;
            font-weight: bold;
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
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Crear nuevo seguimiento:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="seg_psi.php" method="POST" id="form" name="form" enctype="multipart/form-data">
                               
                                <div class="form-group col-lg-12 text-left"> 
                                <label for="psicologo">Psicólogo:</label> 
									<select id="psicologo" name="psicologo" width="300px" class="form-control1">
										<option value="0" selected> Seleccion psicólogo</option>
										<?php
										    while ($row_emp = mysqli_fetch_array($exe_emp)) {
										        echo '<option value="'.$row_emp['id'].'">'.$row_emp['nombres'].' '.$row_emp['apellidos'].'</option>';
										    }
										?>
										<!--<option value="Camila Cubillos">Camila Cubillos</option>
                                        <option value="Diana Chaparro">Diana Chaparro</option>
										<option value="Julián Mesa">Julián Mesa</option>
                                        <option value="Otro">Otro</option>-->
									</select>
								</div>
								
								<div class="form-group col-lg-12 text-right"> 
                                    <button type="submit" id="btnsubmit" name="btnsubmit" class="btn btn-default" style="display: none;">Continuar</button>
								</div>

								<input type="hidden" id="txt_psicologo" name="txt_psicologo"/>
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