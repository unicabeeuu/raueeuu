<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
if (isset($_SESSION['uniprofe'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
?>

<html>
	<head><meta charset="gb18030">
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../images/favicon.png" />
        <!-- // Favicon -->
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        
        <!-- Bootstrap Core CSS -->
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        
        <!-- Custom CSS -->
        <link href="../../css/style.css" rel='stylesheet' type='text/css' />
        
        <!-- font-awesome icons CSS -->
        <link href="../../css/font-awesome.css" rel="stylesheet"> 
        <!-- //font-awesome icons CSS-->
        
        <!-- side nav css file -->
        <link href='../../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
        <!-- //side nav css file -->
        
        <!-- js-->
        <!--<script src="../../js/jquery-1.11.1.min.js"></script>-->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="../../js/modernizr.custom.js"></script>
        
        <script type="text/javascript" src="js/reg.js"></script>
        
        <!--webfonts-->
        <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--//webfonts--> 
        
        <!--css tabla -->
        <link href="../../css/jquery.dataTables.min.css" rel="stylesheet"> 
        <!-- // css tabla -->
        
		<link rel="stylesheet" href="css/reg.css" />
		
		<!-- Metis Menu -->
        <script src="../../js/metisMenu.min.js"></script>
        <script src="../../js/custom.js"></script>
        <link href="../../css/custom.css" rel="stylesheet">
        <!--//Metis Menu -->
        <style>
            .mprincipal {
            	list-style-image: url("img/m26.png");
            	font-weight: bold !important;
	            font-size: 20px !important;
            }
        </style>
	</head>
	<body id="bodyadm" class="cbp-spmenu-push">
	    <div class="main-content">
    		<?php 
    		    if($id == 18 || $id == 40) {
		        require 'menu_adm.php';
    		    }
    		    else {
    		        require 'menu.php';
    		    }  
    		?>
    		<!-- header-starts -->
    		<?php require 'header.php';  ?>
    		<!-- modal -->
    		<section>
    			<?php require '../modal.php';  ?>
    		</section>
    		
    		<!-- main content start-->
            <section>
               	<div id="page-wrapper">
               		<div class="charts">		
               		 	<div class="mid-content-top charts-grids">	
                        	 
                        			<!---------------------------------------------->
                                    <center>
                            			<div id="enc">
                            				<img src="img/enc1.png" alt="enc1" width="800" height="132"/>
                            			</div>
                            		</center>		
                            		<div id="cont">
                            			<div id="div1">
                            				<fieldset>
                            				<legend><h3>OPCIONES DE ACTUALIZACION</h3></legend>
                            					<ul class="mprincipal">
                            						<!--<li><h3>Calificaciones Moodle</h3></li>
                            							<ul>
                            								<li><a href="calificaciones_getdat.php" target="_blank">Cargar</a></li>
                            							</ul>
                            						<li><h3>Calificaciones para cargar a Registro</h3></li>
                            							<ul>
                            								<li><a href="calificaciones1_getdat.php" target="_blank">Cargar</a></li>
                            							</ul>
                            						<li><h3>Calificaciones Registro</h3></li>
                            							<ul>
                            								<li><a href="cal_reg_getdat.php" target="_blank">Cargar</a></li>
                            							</ul>
                            						<li><h3>Calificaciones Registro Remoto</h3></li>
                            							<ul>
                            								<li><a href="cal_reg_rem_getdat.php" target="_blank">Cargar</a></li>
                            							</ul>-->
                            						<li><h3>PRUEBA DE CONEXION CON MOODLE</h3></li>
                            							<ul class="msecund">
                            								<li><a href="prueba_coneccion.php" target="_blank">Cargar</a></li>
                            							</ul>
                            						<li><h3>PENSAMIENTO Y GRADOS A CARGAR</h3></li>
                            							<ul class="msecund">
                            							    <?php
                            							        if($id == 18 || $id == 40) {
                            							    ?>
                            								<li><a href="pen_gra_upddat.php" target="_blank">En bloque</a></li>
                            								<li><a href="pen_gra_upddat_s.php" target="_blank">Individual</a></li>
                            								<!--<li><a href="pen_gra_upddat_custom.php" target="_blank">Consulta personalizada</a></li>-->
                            								<?php
                            							        }
                            							        else if($id == 24) {
                            								?>
                            								<li><a href="pen_gra_upddat_tutor.php">Individual</a></li>
                            								<?php
                            							        }
                            								?>
                            							</ul>
                            					</ul>				
                            				</fieldset>
                            			</div>
                            			<div id="div2">
                            				<fieldset>
                            				<legend><h3>PROCESOS</h3></legend>
                            				    <?php
                            				        if($id == 18 || $id == 40) {
                            				    ?>
                            					<ul class="mprincipal">
                            						<li><h3>CAMBIAR PARAMETROS</h3></li>
                            							<ul class="msecund">
                            								<li><a href="param_upddat.php" >Cargar</a></li>
                            							</ul>
                            					</ul>
                            					<?php
                            				        }
                            				        if($id == 18) {
                            					?>
                            					<ul class="mprincipal">
                            						<li><h3>ACCESO REMOTO A phpMyAdmin MOODLE</h3></li>
                            							<ul class="msecund">
                            								<li><a href="https://unicab.org/phpMyAdmin/phpMyAdmin/index.php" target="_blank"><img src="img/phpmyadmin.png" alt="phpmyadmin" width="150" height="101"/></a></li>
                            							</ul>
                            					</ul>
                            					<?php
                							        }
                							    ?>
                            				</fieldset>
                            
                            			</div>
                            			
                            		</div>
    								<!---------------------------------------------->
                  		 	
               			</div>
           			</div>	
           		</div>
    		</section>
    	<!--footer-->
    	<?php //require '../footer.php'; ?>
        <!--//footer-->
    	</div>
	    
	    <!-- Classie --><!-- for toggle left push menu script -->
    	<script src="../../js/classie.js"></script>
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
    	
    	<!--scrolling js-->
    	<script src="../../js/jquery.nicescroll.js"></script>
    	<script src="../../js/scripts.js"></script>
    	<!--//scrolling js-->
    	
    	<!-- side nav js -->
    	<script src='../../js/SidebarNav.min.js' type='text/javascript'></script>
    	<script>
          $('.sidebar-menu').SidebarNav()
        </script>
    	<!-- //side nav js -->
    	
    	<!-- Bootstrap Core JavaScript -->
       <script src="../../js/bootstrap.js"> </script>
    	<!-- //Bootstrap Core JavaScript -->
    	
    	<!-- js tabla -->
    	<script src="../../js/jquery.dataTables.min.js"></script>
    	<script type="text/javascript">
    		$(document).ready(function() {
        	$('#listEstudiantes').DataTable();	
    		} );
    	</script>
    	<!-- //js tabla -->
    	
    	<!-- validar combo periodo -->
    	<script type="text/javascript">
    		function validacion() {
    			var grado=document.getElementById('id_grado').value;
    			if (grado==0) {
    				$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar un grado valido</center>').slideDown(500);
    				return false;
    			}else{
    				$('#alert').html('').slideUp(300);
    			}
    		}
    	</script>
    	<!-- // validar combo periodo -->
		
	</body>
	<?php 
	}else{
		echo "<script>alert('Debes iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	?>
</html>