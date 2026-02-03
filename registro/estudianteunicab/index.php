<?php
session_start();
include "../adminunicab/php/conexion.php";
if (isset($_SESSION['uniestudiante'])) {
	$sql="SELECT * FROM estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$fecha_nacimiento=$fila['fecha_nacimiento'];
		$email_institucional = $fila['email_institucional'];
		$mensaje=$fila['mensaje'];
		$password = $fila['password'];
	}
	// fecha de bd
	// $fecha=$fecha_nacimiento;
	// $nacimiento=explode("-", $fecha);
	// // echox "Año: ".$nacimiento[0];
	// // echo "Mes: ".$nacimiento[1];
	// // echo "Dia: ".$nacimiento[2];
	// // fecha actual
	
	// $dia=date("d");
	// $mes=date("m");
	// $fanio=date("Y");
	// $edad=$fanio-$nacimiento[0];
	// echo "edad: ".$edad."<br>";
	// echo "mes sistema ".$mes."<br>";
	// echo "mes BD ".$nacimiento[1]."<br>";
	// echo "dia sistema ".$dia;
	// echo "dia BD ".$nacimiento[2]."<br>";
	// // saber el dia de cumpleaños
	// if ($mes===$nacimiento[1]) {
	// 	if ($dia===$nacimiento[2]) {
	//
 	/*?> 
 		<h1>feliz cumpleaños</h1>
	<?php */
	// 	}else{
	// 		echo "no estas de cumpleaños";
	// 	}
	// }else{
	// 	echo "estoy aca";
	// }

?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
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
<script type="text/javascript">
	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
        }
	}	
</script>
<!-- abrir modal -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#mensaje").modal("show");
	});
</script>
<!--fin abrir modal -->
</head> 
<body class="cbp-spmenu-push" onload="back_form();">

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
		<!-- video -->
        <section>
           	<div id="page-wrapper">
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	<div class="middle-content">                    	
						<?php
						    echo '<div class="alert alert-info" role="alert" id="alert"><strong>Bienvenido: </strong>'.$apellidos.' '.$nombres.'</div>';
							/*if ($mensaje=="") {
								echo '<div class="alert alert-info" role="alert" id="alert"><strong>Bienvenido: </strong>'.$apellidos.' '.$nombres.'</div>';
							}else{
								echo '
								<div class="alert alert-info" role="alert" id="alert">'.$mensaje.'</div>
								<div class="modal fade" id="mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  		<div class="modal-dialog" role="document">  		
						    		<div class="modal-content">
						      			<div class="modal-header">
						        			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        			<h4 class="modal-title" id="myModalLabel"><strong>UNICAB COMUNICA:</strong></h4>
						      			</div>
						      			<div class="modal-body">
						        			'.$mensaje.'
						        			<hr>
						        			<center><img src="../images/admin.png" width="250px" title="icono administrador"/></center>
						      			</div>
						      		<div class="modal-footer">
						        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
						      		</div>
						    		</div>
						  			</div>
								</div>';
							}*/
						?>
               			</div>
          		 	</div>
            	</div>
           	</div>
		</section>
		<!--fin video -->
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

	<!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
</body>
<?php 
}else if (isset($_SESSION['unisuper'])) {
	echo "<script>location.href='../adminunicab/index.php'</script>";
}else if(isset($_SESSION['uniprofe'])) {
	echo "<script>location.href='../docenteunicab/index.php'</script>";
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='login.php'</script>";
}
?>
</html>