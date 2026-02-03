<?php 
session_start();
include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniprofe'])) {
		$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
		$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
		$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email_institucional'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['password'];
	}
	$contador=0;
	$nota_uno=0;
	$nota_dos=0;
	$nota_tres=0;
	$nota_cuatro=0;
	$id_estudiante=$_GET['id_estudiante'];
	
	$buscar_grado="SELECT DISTINCT matricula.id_grado, grados.grado FROM matricula INNER JOIN grados ON matricula.id_grado=grados.id INNER JOIN estudiantes on matricula.id_estudiante=estudiantes.id where estudiantes.id=".$id_estudiante." and matricula.estado='activo'";
	$exe_buscar=mysqli_query($conexion,$buscar_grado);
	while ($buscar=mysqli_fetch_array($exe_buscar)) {
		$id_grado=$buscar['id_grado'];
		$nombre_grado=strtoupper($buscar['grado']);
	}
	$sqlNotas="SELECT DISTINCT grados.grado, materias.materia, materias.pensamiento, profesores.apellidos, profesores.nombres, estudiantes.id, matricula.estado FROM materias INNER JOIN ((grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id = matricula.id_grado) INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) ON grados.id = carga_profesor.id_grado) ON materias.Id = carga_profesor.id_materia WHERE estudiantes.id='".$id_estudiante."' and matricula.estado='activo' ORDER BY materias.pensamiento asc";
	$consultaNotas=mysqli_query($conexion,$sqlNotas);

	$sql_buscarEstudiante="SELECT * FROM `estudiantes` WHERE `id`=".$id_estudiante."";
	$exe_buscarEstuidante=mysqli_query($conexion,$sql_buscarEstudiante);

	while ($rowEstudiante = mysqli_fetch_array($exe_buscarEstuidante)) {
		$nombeCompleto=$rowEstudiante['nombres']." ".$rowEstudiante['apellidos'];
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

<script type="text/javascript">
	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
        }
	}	
</script>

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
        <section>
        	<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
							<?php
								$varialble_nota=0;
								if (!isset($id_grado)) {
									echo '<div class="alert alert-danger" role="alert">
  										<strong>¡Alerta!</strong> El estudiante no se encuentra matriculado.
									</div>';
								}else{
									$sql_no="SELECT DISTINCT estudiantes.id as id_estudiante, materias.materia, materias.pensamiento, grados.id as id_grado, grados.grado, notas.nota, periodos.id as id_periodo from ((((notas INNER JOIN estudiantes on notas.id_estudiante=estudiantes.id) INNER JOIN materias on notas.id_materia=materias.Id) INNER JOIN grados on notas.id_grado=grados.id) INNER JOIN periodos on notas.id_periodo=periodos.id) where estudiantes.id=".$id_estudiante." and grados.id=".$id_grado." ORDER BY materias.materia ASC, periodos.id ASC";
								$exe_no=mysqli_query($conexion,$sql_no);
								$tot_notas=mysqli_num_rows($exe_no);
									if ($tot_notas===0) {
										?>
										<table class="table table-hover" border="1" bordercolor="#e0e0e0">
											<thead > 
											<tr>
												<TH COLSPAN=6><center><strong>NOMBRE ESTUDIANTE:<?php echo $nombeCompleto;?></strong></center>
												</TH>
											</tr>
											<tr>
											<TH COLSPAN=4><center><strong>ASIGNATURAS INSCRITAS GRADO <?php $nombre_grado ?></strong></center></TH>
											</tr>
											<tr>
											<th><center>Materia</center></th>
											<th><center>Pesamiento</center></th>
											<th><center>Docente</center></th>
											</tr> 
											</thead> 
											<tbody>
										<?php
									while ($fila = mysqli_fetch_array($consultaNotas)){
					        		echo"<tr>
					        		<td scope='row'>".$fila['materia']."</td><td>".$fila['pensamiento']."</td><td>".$fila['nombres']." ".$fila['apellidos']."</td>";
					        		}
								echo "</tr> 
							</tbody> 
						</table>";
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
											<thead > 
												<tr>
													<TH COLSPAN=6><center><strong>NOMBRE ESTUDIANTE: '.$nombeCompleto.'</strong></center></TH>
												</tr>
												<tr>
												<TH COLSPAN=2><center><strong>ASIGNATURAS INSCRITAS GRADO '.$nombre_grado.'</strong></center></TH>
												<TH COLSPAN=4><center><strong>NOTAS DEFINITIVAS POR PERIODOS</strong></center></TH>
												</tr>';
										if ($id_grado>=13	) {
											echo '<tr>
												<th><center>Materia</center></th>
												<th><center>Pesamiento</center></th>
												<th><center>Nº 1</center></th>
												<th><center>Nº 2</center></th>
												</tr> 
												</thead> 
												<tbody>
											';
										}else{
											echo '<tr>
												<th><center>Materia</center></th>
												<th><center>Pesamiento</center></th>
												<th><center>Nº 1</center></th>
												<th><center>Nº 2</center></th>
												<th><center>Nº 3</center></th>
												<th><center>Nº 4</center></th>
												</tr> 
												</thead> 
												<tbody>
											';
										}
										while ($row=mysqli_fetch_array($exe_no)) {
											if ($row['id_grado']>=13) {
												if ($row['id_periodo']==1) {
													$nota_uno=$row['nota'];
													echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$nota_uno."</td>";
												}
												if ($row['id_periodo']==2) {
													$nota_dos=$row['nota'];
													echo "<td>".$nota_dos."</td>";
												}
											}else{
												if ($row['id_periodo']==1) {
													$nota_uno=$row['nota'];
													echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$nota_uno."</td>";
												}
												if ($row['id_periodo']==2) {
													$nota_dos=$row['nota'];
													echo "<td>".$nota_dos."</td>";
												}
												if ($row['id_periodo']==3) {
													$nota_tres=$row['nota'];
													echo "<td>".$nota_tres."</td>";
												}
												if ($row['id_periodo']==4) {
													$nota_cuatro=$row['nota'];
													echo "<td>".$nota_cuatro."</td></tr>";
												}
											}	
										}
										echo "</tbody> 
											</table>";
										}
											
								}
							?>
							</tbody>
							</table>
							<br>
							    <a href="estudiante.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
						    <br><br>
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
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>