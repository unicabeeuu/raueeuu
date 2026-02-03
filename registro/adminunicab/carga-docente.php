<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
    
?>
<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
#chartdiv {
  width: 100%;
  height: 295px;
}
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php require 'menu.php';  ?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<!-- main content start-->
        <section>
           <div id="page-wrapper">
           		<div class="charts">		
               		 <div class="mid-content-top charts-grids">	
                    	<div class="middle-content">                    	
                    		<div class="panel-group" id="accordion">
					    <!-- <div class="embed-responsive embed-responsive-16by9"> -->
					    	<?php 
					    	$sql_grado="SELECT * FROM grados";
							$consulta=mysqli_query($conexion,$sql_grado);	
					    	while ($fila = mysqli_fetch_array($consulta)){
					    		echo '  
								  <div class="panel panel-default">
								    <div class="panel-heading">
								      <h4 class="panel-title">
								        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$fila['id'].'">
								          Carga Grado '.$fila['grado'].'
								        </a>
								      </h4>
								    </div>
								    <div id="collapse'.$fila['id'].'" class="panel-collapse collapse in">
								      <div class="panel-body">';
								      			$query="consulta".$fila['id'];
					      						$query="SELECT carga_profesor.id as id_carga, profesores.id as id_profesores, profesores.apellidos, profesores.nombres, grados.id as id_grado, grados.grado, materias.Id as id_materia, materias.materia, materias.pensamiento FROM materias INNER JOIN (grados INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) ON grados.id = carga_profesor.id_grado) ON materias.Id = carga_profesor.id_materia WHERE grados.id=".$fila['id']."";
					      						$exe="exec".$fila['id'];
					      						$exe=mysqli_query($conexion,$query);	
					      						echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
												<thead > 
												<tr>
												<TH COLSPAN=4><center>CARGA ASIGNADA</center></TH>
												</tr>
												<tr>
													<th><center>MATERIA</center></th>
													<th><center>PENSAMIENTO</center></th>
													<th><center>PROFESOR</center></th>  
													<th><center>ACCIÓN</center></th>  
												</tr>  
												</thead> 
												<tbody>'; 
												while ($row = mysqli_fetch_array($exe)){
													echo"<tr>
					        						<td scope='row'>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$row['apellidos'].' '.$row['nombres']."</td>
					        						<td>
					        							<center><a href='php/update-carga.php?id=".$row['id_carga']."' class='btn btn-danger' title='Eliminar Carga'><i class='fa fa-trash'></i> Eliminar</a></center>
					        						</td>";						        		
					        					}
												echo '</tr> 
													</tbody> 
												</table>
								        
								    </div>
								    </div>
								  ';		
							}
					    	?>

                        <!-- </div> -->
                        </div>
                   		</div>
              		 </div>
            	</div>
           </div>
		</section>
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
	</div>
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
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>