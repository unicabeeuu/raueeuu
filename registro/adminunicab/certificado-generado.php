<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sistema de Registro Académico - Unicab Virtual</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<?php require 'php/conexion.php';

	$peticion= "SELECT * 
				FROM estudiantes 
				INNER JOIN matricula ON estudiantes.id=matricula.id_estudiante
				INNER JOIN grados ON matricula.id_grado=grados.id
				WHERE estudiantes.id=".$_GET['id'];
	$resultado = mysqli_query($conexion, $peticion);
	while ($fila = mysqli_fetch_array($resultado)){
		$nombreCompleto=$fila['nombres']." ".$fila['apellidos'];
		$n_documento=$fila['n_documento'];
		$ciudad=$fila['ciudad'];
		$grado=$fila['grado'];
		$estado=$fila['estado'];
	}
	if (strpos($grado, "Transición") !== false)
	{
		$nivelEducativo="Educación Preescolar";
	}
	if (strpos($grado, "Primero") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Segundo") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Tercero") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Cuarto") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Quinto") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Sexto") !== false)
	{
		$nivelEducativo="Educación Básica Secundaria";
	}
	if (strpos($grado, "Séptimo") !== false)
	{
		$nivelEducativo="Educación Básica Secundaria";
	}
	if (strpos($grado, "Octavo") !== false)
	{
		$nivelEducativo="Educación Básica Secundaria";
	}
	if (strpos($grado, "Noveno") !== false)
	{
		$nivelEducativo="Educación Básica Secundaria";
	}
	if (strpos($grado, "Décimo") !== false)
	{
		$nivelEducativo="Educación Media Académica";
	}
	if (strpos($grado, "Undécimo") !== false)
	{
		$nivelEducativo="Educación Media Académica";
	}
	if (strpos($grado, "Ciclo I") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Ciclo II") !== false)
	{
		$nivelEducativo="Educación Básica Primaria";
	}
	if (strpos($grado, "Ciclo III") !== false)
	{
		$nivelEducativo="Educación Básica Secundaria";
	}
	if (strpos($grado, "Ciclo IV") !== false)
	{
		$nivelEducativo="Educación Básica Secundaria";
	}
	if (strpos($grado, "Ciclo V") !== false)
	{
		$nivelEducativo="Educación Media Académica";
	}
	if (strpos($grado, "Ciclo VI") !== false)
	{
		$nivelEducativo="Educación Media Académica";
	}
?>

<!--Fecha Actual-->
 <?php
 $peticion2="SET lc_time_names = 'es_CO'";
 $resultado2 = mysqli_query($conexion, $peticion2);
                        
  $peticion = "SELECT DATE_FORMAT(NOW(),'%W %d de %M de %Y') fecha";
  $resultado = mysqli_query($conexion, $peticion);
  while ($fila = mysqli_fetch_array($resultado))
   {
	$fechaHoy=$fila['fecha'];
   }
?>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
	<?php require 'menu.php';  ?>
	
<section>
<div id="page-wrapper">
<div>				
      <div class="mid-content-top charts-grids">	
        <div class="middle-content">

<style>
.justifyText{
text-align : justify;
}


</style>

    <!--CERTIFICADO-->
    <div class="panel panel-default">
  <div class="panel-body" align="center">
  <img class="img-responsive" width="140px" src="../images/logo20.png"><br>
<h6 align="center">
      UNICAB VIRTUAL, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la
Secretaría de Educación y Cultura de Sogamoso según resolución 061 del 15 de Diciembre de 2007, y Resolución Nº
0155 21 de Julio de 2010 y Resolución No. 326 del 22 de Septiembre de 2015, para todos los niveles de Educación
Preescolar, Básica Primaria, Básica Secundaria y Media Académica
</h6><br><br>
<h4>LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL</h4><br><br>
<h3><b>CERTIFICAN:</b></h3><br>
<h5 class="justifyText">
Que el estudiante <b><?php echo $nombreCompleto?></b>, identificado con documento N° <?php echo $n_documento?> expedido
en <?php echo $ciudad?>, en la actualidad es <b>estudiante <?php echo $estado?></b> del grado <?php echo $grado?> de <?php echo $nivelEducativo?>, cumpliendo con los requisitos establecidos.
</h5><br><br>
<h5 class="justifyText">El presente certificado se expide hoy <?php echo $fechaHoy?></h5>

<div class="row" id="contieneFirmas">
   <img class="img-responsive" width="100%" src="../images/firma_certficados.JPG">
</div><hr>
<p align="center">
Carrera 14 N° 13ª-15 Sogamoso – Boyacá Tel. 0987 701685 Cel. 3156965291 - 3158895275<br>
www.unicab.org
</p>
 </div>
</div>

<!--CERTIFICADO-->
<div align="center">
 <a class="btn btn-danger" href="javascript:window.print()">Certificado</a>
 </div>
   </div>
   </div>
   </div>
   </div>

 
        </section>
	<!--footer-->

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
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>