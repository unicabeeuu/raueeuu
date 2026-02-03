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
    
    $query = "SELECT * FROM equivalence_idgra WHERE id_grado_ra NOT IN (150, 160, 170, 180, 130, 140, 0)";
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
?>

<html>
	<head><meta charset="big5">
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
    		    //require 'menu.php';
    		    require 'menu_tutores.php';
    		?>
    		<!-- header-starts -->
    		<?php require 'header.php';  ?>
    		<!-- modal -->
    		<section>
    			<?php require 'modal.php';  ?>
    		</section>
    		
    		<!-- main content start-->
            <section>
               	<div id="page-wrapper">
               		<div class="charts">		
               		 	<div class="mid-content-top charts-grids">	
                        	 
                        			<!---------------------------------------------->
                                    <div id="cont">
                            			<div id="div2">
                            				<fieldset>
                            				<legend><h3>BUSCAR EN BASE DE DATOS</h3></legend>
                            				    <form class="form-horizontal" action="estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                            					<form class="form-horizontal" action="estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                            					<form class="form-horizontal" action="estudianteg_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                            					<form class="form-horizontal" action="bd_exportar_getdat.php"  method="POST" target="_blank">
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