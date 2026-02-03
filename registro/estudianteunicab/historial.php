<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
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
					<div class="tables">
						<div class="panel-body widget-shadow">
							<table class="table table-bordered">
								<tbody>
								    <tr>
								      <th scope="row">Número Documento</th>
								      <td><?php echo $n_documento; ?></td>
								    </tr>
								    <tr>
								    <tr>
								      <th scope="row">Correo Institucional</th>
								      <td><?php echo $email_institucional; ?></td>
								    </tr>
								      <th scope="row">Nombre Estudiante</th>
								      <td><?php echo $nombres." ".$apellidos; ?></td>
								    </tr>
						  		</tbody>
							</table>
							<?php 
							$auto=0;
							$sql_grado="SELECT DISTINCT grados.id, grados.grado, matricula.idMatricula 
							    FROM grados INNER JOIN matricula ON grados.id = matricula.id_grado 
							    WHERE matricula.id_estudiante=".$id." and matricula.estado='activo'";
							$exe_grado=mysqli_query($conexion,$sql_grado);
							if (mysqli_num_rows($exe_grado)) {
								while ($row=mysqli_fetch_array($exe_grado)) {
								$sql_historial="SELECT DISTINCT  promedio, estudiantes.id, estudiantes.nombres, materias.materia, materias.pensamiento, 
								    grados.id as id_grado, grados.grado, matricula.idMatricula, matricula.estado, matricula.EstadoGrado 
								    FROM ((((historial_notas INNER JOIN estudiantes ON historial_notas.id_estudiante=estudiantes.id) 
								    INNER JOIN materias ON historial_notas.id_materia=materias.Id) 
								    INNER JOIN matricula ON matricula.idMatricula=historial_notas.id_matricula) 
								    INNER JOIN grados ON historial_notas.id_grado=grados.id) 
								    WHERE estudiantes.id=".$id." and matricula.estado='inactivo' and grados.id=".$row['id']." 
								    and matricula.idMatricula=".$row['idMatricula']." ORDER BY materias.pensamiento";
								$exe_historial=mysqli_query($conexion,$sql_historial);
								
								echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
								 	<thead > 
								 		<tr bordercolor="#e0e0e0">
											<TH COLSPAN=4><center><strong>Grado '.$row['grado'].'</strong></center></TH>
								 		</tr>
								 		<tr>
								 			<th>Nombre Asignatura</th>
								 			<th>Pensamiento</th>
											<th>Promedio</th>  
										</tr> 
								 	</thead> 
									<tbody>';
								while ($row2=mysqli_fetch_array($exe_historial)) {
									$materia=$row2['materia'];
									$pensamiento=$row2['pensamiento'];
									$grado=$row2['grado'];
									$promedio=$row2['promedio'];
									echo'<tr>
							         		<td scope="row">'.$row2['materia'].'</td>
							         		<td>'.$row2['pensamiento'].'</td>
							         		<td>'.$row2['promedio'].'</td>
						         		</tr>';
								}
								echo '</tbody> 
								</table>';
							}
							}else{
								echo '<div class="alert alert-success" role="alert">El estudiante <strong>NO</strong> cuenta con un historial de notas';
							}
							?>
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