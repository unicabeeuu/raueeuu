<?php
	session_start();
	include "../../adminunicab/php/conexion.php";
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat_tutor.php'");
	set_time_limit(300);
	
if (isset($_SESSION['uniprofe'])) {
    $sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
	$res=$mysqli1->query($sql);

	while($fila = $res->fetch_assoc()){
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email_institucional'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['password'];		
    }
    //echo $id;
    
	$query1 = "SELECT q.* 
		FROM carga_profesor cp, querys_ra q, profesores p, equivalence_idgra eg, equivalence_idmat em 
		WHERE cp.id_grado = eg.id_grado_ra AND eg.id_category = q.condicion2 AND cp.id_materia = em.id_materia_ra AND em.id_course = q.condicion4 
		AND cp.id_profesor = p.id 
		AND q.id > 25 AND p.email_institucional = '".$_SESSION['uniprofe']."' 
		ORDER BY p.apellidos, p.nombres, q.condicion2, q.condicion4";
	$resultado=$mysqli1->query($query1);
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
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
	</head>
	<body class="cbp-spmenu-push">
		<div class="main-content">
    		<?php require 'menu.php';  ?>
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
                            		<div id="divres">
										<table>
											<tbody>
												<tr>
													<td height="30">
													</td>
												</tr>
												<tr>
													<td>
														<fieldset>
															<legend>PENSAMIENTOS Y GRADOS A CARGAR</legend>
															<div>
															    <table border="1px" class="tr">
																	<thead>
																	<tr>
																		<td><b>Pensamiento</b></td>
																		<td><b>Grados</b></td>
																		<td><b>Actualizado</b></td>
																		<td><b>Seleccionados</b></td>
																		<td><b>Insertados temp</b></td>
																		<td><b>Actualizados</b></td>
																		<td><b>Nuevos</b></td>
																		<!--<td><b>Procesar</b></td>-->
																		<td><b>No RA (*)</b></td>
																		<!--<td><b></b></td>-->
																		<td><b></b></td>
																	</tr>
																	</thead>
																	<tbody>
																	<?php
																		while($row = $resultado->fetch_assoc()){
																	?>
																	<tr>
																		<td><?php echo $row['pensamiento'];?></td>
																		<td><?php echo $row['grados'];?></td>
																		<td><?php echo $row['actualizado'];?></td>
																		<td><?php echo $row['seleccionados'];?></td>
																		<td><?php echo $row['insertados_tem'];?></td>
																		<td><?php echo $row['actualizados'];?></td>
																		<td><?php echo $row['nuevos'];?></td>
																		<!--<td><?php echo $row['procesar'];?></td>-->
																		<td><?php echo $row['est_nue_no_reg'];?></td>
																		<!--<td><?php echo '<a href="pen_gra_upddat1.php?idq='.$row['id'].'"><button type="button" class="btn">Programar</button></a>';?></td>-->
																		<td><?php echo '<a href="pen_gra_upddat2.php?idq='.$row['id'].'" target="_blank"><button type="button" class="btn1">Ver registros a procesar</button></a>';?></td>
																	</tr>
																	<?php }
																		$resultado->close();
																		$mysqli1->close();
																	?>
																	</tbody>
																</table>
															</div>
															<label class="msg">* No RA: Registros no insertados por pertenecer a estudiantes que no est√°n en registro</label>
														</fieldset>							
													</td>
												</tr>
											</tbody>
										</table>
									</div>
    								<!---------------------------------------------->
                  		 	
               			</div>
           			</div>	
           		</div>
    		</section>
    	<!--footer-->
    	<?php require '../footer.php'; ?>
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
	echo "<script>alert('Debes iniciar sesi®Æn');</script>";
	echo "<script>location.href='../../../login_registro.php'</script>";
}
?>
	
</html>