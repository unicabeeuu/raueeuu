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
	
	$query = "SELECT * FROM equivalence_idgra";
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
    <script>
        $(function() {
            //alert("hola");
            $("#sel_descuento").change(function() {
        		var des = $("#sel_descuento").val();
        		if(des == 0) {
        		    $("#btnsubmit").hide();
        		}
        		else {
        		    var anio = $("#anio").val();
        		    if(anio == 2021 || anio == 2022) {
        		        $("#btnsubmit").show();
        		    }
        		    else {
        		        $("#btnsubmit").hide();
        		    }
        		}
        	});
        	
        	$("#anio").change(function() {
        		var anio = $("#anio").val();
        		if(anio == 2021 || anio == 2022) {
        		    var des = $("#sel_descuento").val();
            		if(des == 0) {
            		    $("#btnsubmit").hide();
            		}
            		else {
            		    $("#btnsubmit").show();
            		}
        		}
        		else {
        		    $("#btnsubmit").hide();
        		}
        	});
        });
        
    </script>
    
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
		<section>
           <div id="page-wrapper">
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	<div class="middle-content">
                    		<div class="form-group"> 
                    			<div class="form-body">
                    			<form class="form-horizontal"  method="post">
                    				<div class="form-group">
										<label for="n_documento" class="col-sm-2 control-label">Número Documento <span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="n_documento" name="n_documento" placeholder="Número Documento" required maxlength="15" autofocus="">
										</div>
									</div>
									
									<div class="form-group">
										<label for="anio" class="col-sm-2 control-label">Año <span class="req">*</span></label>
    									<div class="col-sm-8">
    										<!--<input type="text" class="form-control1" id="anio" name="anio" placeholder="Ingrese el año al que aplica el descuento">-->
    						                <select id="anio" name="anio" class="form-control1" required >
        										<option value='2021' selected>2021</option>
        										<option value='2022'>2022</option>
    										</select>
    									</div>
									</div>
									
									<div class="form-group">
									    <label class="col-sm-6 control-label" style="color: white;">-- <span class="req">*</span></label>
								  	    <button type="submit" class="btn btn-default">BUSCAR <span style="color:#FFF" class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
								  	</div>
                    			</form>
								<hr>
								</div>
              		 		</div>
							<?php
    							if (!isset($_POST['n_documento'])) {
    								echo ' <div class="alert alert-danger" role="alert">
      									<strong>¡Advertencia!</strong> Debe ingresar un número de documento para realizar la búsqueda.
    								</div>';
    							}else{
    								$anio=$_POST['anio'];
    								$numero_documento=$_POST['n_documento'];
    								$buscar="SELECT id, apellidos, nombres FROM estudiantes where n_documento='".$numero_documento."'";
    								$exe_buscar=mysqli_query($conexion,$buscar);
    								$total_buscar=mysqli_num_rows($exe_buscar);
    								if ($total_buscar>0) {
										while ($fila=mysqli_fetch_array($exe_buscar)) {
											$id=$fila['id'];
											$apellidos=$fila['nombres'];
											$nombres=$fila['apellidos'];
										}
							?>
							<!-- buscar certificado -->
							<div class="form-group">
								<form class="form-horizontal" action="becas_descuentos1.php" method="POST">
									<div class="form-group">				
										<label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
										<div class="col-sm-8">
											<input type="text" readonly="readonly" class="form-control1" id="apellidos" name="apellidos" value="<?php echo $apellidos;?>">
										</div>
									</div>

									<div class="form-group">
										<label for="nombres" class="col-sm-2 control-label">Nombres</label>
										<div class="col-sm-8">
											<input type="text" readonly="readonly" class="form-control1" id="nombres" name="nombres" value="<?php echo $nombres;?>">
										</div>
									</div>
									<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
									
									<?php
									    //Se valida si ya tiene algún descuento
									    $sql_valdes = "SELECT * FROM tbl_becas WHERE identificacion = '$numero_documento' AND periodo_lectivo = $anio";
									    $exe_valdes=mysqli_query($conexion,$sql_valdes);
									    $res_valdes=mysqli_num_rows($exe_valdes);
										if ($res_valdes > 0) {
										    $texto = "Este documento ya tiene para el periodo lectivo ".$anio." el siguiente descuento: ";
										    while ($row_val=mysqli_fetch_array($exe_valdes)) {
												$beca = $row_val['beca'];
												$descuento = $row_val['descuento'];
												$ct_pagos = $row_val['ct_pagos'];
						 					}
						 					if ($beca == 1) {
						 					    $texto .= "MEDIA BECA.";
						 					}
						 					else if ($beca == 2) {
						 					    $texto .= "BECA COMPLETA.";
						 					}
						 					else if ($descuento == 3) {
						 					    $texto .= "3% de DESCUENTO.";
						 					}
						 					/*else if ($descuento == 10) {
						 					    $texto .= "10% de DESCUENTO.";
						 					}*/
									?>
									        <div class="form-group">
        										<label for="nombres" class="col-sm-2 control-label">Resultado</label>
        										<div class="col-sm-8">
        											<input type="text" readonly="readonly" class="form-control1" id="nombres" name="nombres" value="<?php echo $texto;?>">
        										</div>
        									</div>
									<?php
    								    }
    								    else {
    								        $sql_descuentos="SELECT * FROM tbl_tipos_descuentos WHERE id < 4";
    										//echo $sql_historial;
    										
    										$exe_descuentos=mysqli_query($conexion,$sql_descuentos);
    										$res=mysqli_num_rows($exe_descuentos);
        								}
									?>

									<?php
										/*$sql_descuentos="SELECT * FROM tbl_tipos_descuentos";
										//echo $sql_historial;
										
										$exe_descuentos=mysqli_query($conexion,$sql_descuentos);
										$res=mysqli_num_rows($exe_descuentos);*/
										if ($res>0) {
									?>
								<div class="form-group">
									<label for="nombres" class="col-sm-2 control-label">Seleccione descuento *</label>
									<div class="col-sm-8">
										<select id="sel_descuento" name="sel_descuento" class="form-control1" required >
										<option value='0'>Seleccionar Descuento</option>
										<?php
											while ($row=mysqli_fetch_array($exe_descuentos)) {
												echo '<option value="'.$row['id'].'">'.$row['tipo_descuento'].'</option>';
						 					}
					 					?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="per_lec" class="col-sm-2 control-label">Periodo Lectivo <span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" readonly="readonly" class="form-control1" id="per_lec" name="per_lec" value="<?php echo $anio;?>">
									</div>
									
								</div>
						
								<input type="hidden" id="n_documentof" name="n_documentof" value="<?php echo $numero_documento; ?>"/>
								
								<div class="modal-footer">
  									<input type="submit" class="btn btn-primary" id="btnsubmit" style="display: none;" value="Generar">
  								</div>
								</form>
							</div>
							<?php
        								}else{
        									echo ' <div class="alert alert-danger" role="alert">
          										<strong>¡Advertencia!</strong> No se encontraron tipos de descuento.
        									</div>';
        								}
        							}else{
        								echo ' <div class="alert alert-danger" role="alert">
          									<strong>¡Advertencia!</strong> no se han encontrado resultados.
        								</div>';
        							}
        						}	
							?>
  		 				<!-- // buscar certificado -->
            		</div>
           		</div>
       		</div>
       	   </div>
		</section>
		
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