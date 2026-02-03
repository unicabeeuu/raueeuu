<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
	header("Cache-Control: no-store");
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    //La siguiente línea se debe cambiar cuando ya sea el año siguiente
    //$fanioPazSalvo = $fanio -1;
    $fanioPazSalvo = $fanio;
	
	if (isset($_SESSION['uniestudiante'])) {
		//$sql="SELECT * FROM estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
		$sql_estudiante="SELECT e.*, m.id_grado 
		FROM estudiantes e, 
		(SELECT max(id_grado) id_grado, id_estudiante FROM matricula WHERE estado IN ('aprobado', 'reprobado', 'retirado') 
		AND id_estudiante = (SELECT id FROM estudiantes WHERE email_institucional = '".$_SESSION['uniestudiante']."') 
		AND n_matricula like '%2025%' 
		GROUP BY id_estudiante) m 
		WHERE e.id = m.id_estudiante AND e.email_institucional='".$_SESSION['uniestudiante']."'";
		$res = mysqli_query($conexion,$sql_estudiante);
		//echo $sql_estudiante;

    	while ($fila = mysqli_fetch_array($res)){
                          
    	  	$id = $fila['id'];
    		$apellidos = $fila['apellidos'];
    		$nombres = $fila['nombres'];
    		$n_documento = $fila['n_documento'];
    		$email_institucional = $fila['email_institucional'];
    		$password = $fila['password'];
    		$idgra = $fila['id_grado'];
    	}
    	
    	/*$buscar_carnet = "SELECT * FROM tbl_pazysalvos WHERE id_estudiante = '".$id."' AND a = '$fanio' AND id_grado = $idgra AND firma = 'SI'";*/
    	$buscar_carnet = "SELECT * FROM tbl_pazysalvos WHERE id_estudiante = '".$id."' AND a = '$fanioPazSalvo' AND id_grado = $idgra AND firma = 'SI'";
    	//echo $buscar_carnet;
    	$exe_buscar = mysqli_query($conexion,$buscar_carnet);
    	
    	$codigo = "";
    	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
                "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
    	
    	for($i = 1; $i <=10; $i++) {
    		$ale=mt_rand(1,sizeof($sa1));
    		$codigo = $codigo.$sa1[$ale-1];
    	}
    	
    	$ruta = "";
    	
    	//Se valida el estado del estudiante
    	$ct = 0;
    	/*$qry_estado = "SELECT Count(1) ct FROM matricula WHERE date_format(fecha_ingreso, '%Y') = $fanio AND estado IN ('aprobado', 'reprobado', 'retirado') AND id_estudiante = $id";*/
    	$qry_estado = "SELECT Count(1) ct FROM matricula WHERE fecha_ingreso BETWEEN '2024-11-01' AND '2025-12-01' AND estado IN ('aprobado', 'reprobado', 'retirado') 
		AND id_estudiante = $id";
		//echo $qry_estado;
    	
    	$res_estado = mysqli_query($conexion,$qry_estado);

    	while ($fila_estado = mysqli_fetch_array($res_estado)){
    	  	$ct = $fila_estado['ct'];
    	}
		
		//Se valida si el estudiante está habilitado financieramente para descargar el paz y SALVO
		$ct_control = 0;
		$qry_control = "SELECT Count(1) ct FROM tbl_estudiantes_bloqueados WHERE n_documento = $n_documento";
    	
    	$res_control = mysqli_query($conexion,$qry_control);

    	while ($fila_control = mysqli_fetch_array($res_control)){
    	  	$ct_control = $fila_control['ct'];
    	}
		
	
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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
							<p><?php //echo $buscar_carnet; ?></p>
							<table class="table table-hover" border="1" bordercolor="#e0e0e0" width="500">
								<thead > 
    								<tr>
    								    <TH COLSPAN=3><center><strong>PAZ Y SALVO</strong></center></TH>
    								</tr>
    								<tr>
    								    <th width="200"><center>Acción</center></th>
    								</tr> 
								</thead> 
								<tbody>
							<?php
								while ($buscar=mysqli_fetch_array($exe_buscar)) {
								    $ruta = $buscar['ruta'];
								}
								//echo $ruta." ".$ct." ".$ct_control;
								//echo $qry_estado;
								//echo $buscar_carnet;
								if ($ruta != "" && $ct > 0 && $ct_control == 0) {
					        		
							?>
							        <tr>
							            <td><center>
							                <a href='<?php echo $ruta."?t=".$codigo; ?>' target='_blank' class='btn btn-dark glyphicon glyphicon-download-alt'> Descargar</a>
							                </center>
							            </td>
							        </tr>
							        <tr>
							            <td><center>
							                <p><?php //echo $buscar_carnet; //echo $ruta; ?></p>
							                </center>
							            </td>
							        </tr>
							<?php  
	                            }
	                            else {
							?>
							        <tr>
							            <td><center>
							                <p>Este documento sólo se puede descargar cuando se encuentre académica y financieramente a paz y salvo.</p>
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