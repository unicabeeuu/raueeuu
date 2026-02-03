<?php
	session_start();
	//include "../../adminunicab/php/conexion.php";
	include "php/conexion.php";
	//require("1cc3s4db.php");
	
if (isset($_SESSION['unisuper'])) {
	
    $identif = $_REQUEST['identif'];
	$periodo = $_REQUEST['periodo'];
	$codigo = $_REQUEST['codigo'];
	$query = "INSERT INTO tbl_cod_entrevista VALUES ($identif,$periodo,'$codigo','NO ACTIVO')";
	$rescod=mysqli_query($conexion,$query);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
<!--<script src="../js/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="js/jquery.min.js"></script>
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
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		
		<!--<section>
			<?php //require '../modal.php';  ?>
		</section>-->
		
		<!-- main content start-->
        <section>
           	<div id="page-wrapper">
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	 
                    			<div class="form-body">
                    			    <?php
										//echo $query;
										if($rescod > 0) {
											echo "<label  class='col-sm-2 control-label'>Cargue exitoso del código de entrevista</label></br></br>";
											echo "<label  class='col-sm-2 control-label'>Identificación: ".$identif."</label></br>";
											echo "<label  class='col-sm-2 control-label'>Año: ".$periodo."</label></br>";
											echo "<label  class='col-sm-2 control-label'>Código: ".$codigo."</label></br>";
											echo '<a href="cod_entrevista.php" ><button type="button" class="btn btn-primary">Generear nuevo código para entrevista</button></a>';
										}
										else {
											echo "<label  class='col-sm-8 control-label' style='color: red;'>Este número de identificación en este año ya tiene código asignado.</label></br></br>";
											echo '<a href="cod_entrevista.php" ><button type="button" class="btn btn-primary">Generear nuevo código para entrevista</button></a>';
										}
									?>
								
								</div>								
              		 	
           			</div>
       			</div>	
       		</div>
		</section>
	<!--footer-->
	<?php require '../footer.php'; ?>
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
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>