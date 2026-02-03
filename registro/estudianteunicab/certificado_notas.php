<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
	header("Cache-Control: no-store");
	//https://unicab.org/registro/estudianteunicab/certificado_notas.php
	
	if (isset($_SESSION['uniestudiante'])) {
		$sql="SELECT * FROM estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
		$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$email_institucional = $fila['email_institucional'];
		$password = $fila['password'];
	}
	
	$buscar_cert="SELECT * FROM certificado WHERE identificacion = '".$_SESSION['identifest']."' AND substring(numero, 1, 2) = 'CN'";
	//echo $buscar_cert;
	$exe_buscar=mysqli_query($conexion,$buscar_cert);
	
	$codigo = "";
	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
            "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
	
	for($i = 1; $i <=10; $i++) {
		$ale=mt_rand(1,sizeof($sa1));
		$codigo = $codigo.$sa1[$ale-1];
	}
	
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
			<div class="main-page">
				<div class="tablesxxx">
					<div class="panel-body widget-shadow">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
							<br>
							<label><?php //echo $buscar_cert; ?></label>
							<table class="table table-hover" border="1" bordercolor="#e0e0e0" width="500">
								<thead > 
    								<tr>
    								    <TH COLSPAN=3><center><strong>CERTIFICADOS DE NOTAS</strong></center></TH>
    								</tr>
    								<tr>
    								    <th width="200"><center>Fecha de expedición</center></th>
        								<th width="100"><center>Número</center></th>
        								<th width="200"><center>Acción</center></th>
    								</tr> 
								</thead> 
								<tbody>
							<?php
								while ($buscar=mysqli_fetch_array($exe_buscar)) {
					        		
							?>
							        <tr>
							            <td><center><?php echo $buscar['fecha_expedicion']; ?></center></td>
							            <td><center><?php echo $buscar['numero']; ?></center></td>
							            <td><center>
							                <a href='<?php echo $buscar['ruta']."?t=".$codigo; ?>' target='_blank' class='btn btn-dark glyphicon glyphicon-download-alt'> Descargar</a>
							                </center>
							            </td>
							        </tr>
							<?php  
	                            }
							?>
							    </tbody>
						    </table>
						</div>
					</div>
				</div>
			</div>
		</div>
		</section>
	<!--footer-->
	<?php //require 'footer.php'; ?>
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
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='login.php'</script>";
}
?>
</html>