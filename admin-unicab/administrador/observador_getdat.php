<?php 
	session_start();
	require "../php/conexion.php";
	
	$n_documento = $_REQUEST['buscar'];
	
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		$sql_val_inicial = "SELECT sv.n_documento, CONCAT(est.nombres, ' ', est.apellidos) estudiante, 
		CASE sv.id_empleado WHEN 0 THEN (CASE sv.id_solicita WHEN 1 THEN 'ACUDIENTE' ELSE CONCAT(e.nombres, ' ', e.apellidos) END) 
		ELSE CONCAT(e1.nombres, ' ', e1.apellidos) END nombre_solicita, 
		CONCAT(e.nombres, ' ', e.apellidos) solicita, CONCAT(e1.nombres, ' ', e1.apellidos) empleado, 
		sv.id, sv.motivo, sv.personalidad, sv.observaciones, sv.fecha 
		FROM tbl_seg_psi_val sv, tbl_empleados e, tbl_empleados e1, estudiantes est 
		WHERE sv.id_solicita = e.id AND sv.id_empleado = e1.id AND sv.n_documento = est.n_documento 
		AND sv.n_documento = '$n_documento'";
		//echo $sql_val_inicial;
		$exe_val_inicial = mysqli_query($conexion, $sql_val_inicial);
		$exe_val_inicial1 = mysqli_query($conexion, $sql_val_inicial);
		while ($row_val_inicial = mysqli_fetch_array($exe_val_inicial)) {
			$solicita = $row_val_inicial['nombre_solicita'];
			$id_valoracion = $row_val_inicial['id'];
		}
		//echo $solicita;
		
		$sql_seguimientos = "SELECT objetivo, avances, acciones_est, acciones_acu, compromisos, proc_post, fecha, estado 
		FROM tbl_seg_psi WHERE id_valoracion = $id_valoracion ORDER BY fecha";
		$exe_seguimientos = mysqli_query($conexion, $sql_seguimientos);
		
		$sql_observaciones_tutores = "SELECT * 
		FROM tbl_estudiantes_observ_tut WHERE n_documento = '$n_documento'";
		$exe_observaciontes_tutores = mysqli_query($conexion, $sql_observaciones_tutores);
		
		//Se busca el nombre
		$sql_nombre = "SELECT CONCAT(nombres, ' ', apellidos) nombre FROM estudiantes WHERE n_documento = '$n_documento'";
		$exe_nombre = mysqli_query($conexion, $sql_nombre);
		while ($row_nombre = mysqli_fetch_array($exe_nombre)) {
			$nombre_estudiante = $row_nombre['nombre'];
		}
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

    <link href='fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='fullcalendar/lib/main.js'></script>
    <script src='fullcalendar/lib/locales-all.js'></script>
	
    <style>
        .error {
            border: 3px solid red !important;
        }
        .azul1 {
            background: lightblue;
            padding-top: 10px;
        }
        .fc-toolbar-title {
            font-size: 20px !Important;
            font-weight: bold;
        }
    </style>

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!-- menu -->
		<?php 
			require "include/header.php";
		?>
		<!-- menu -->
		
		<!-- header -->
		<?php 
			require "include/menu.php";
		?>
		<!-- header -->
		
		<!-- main content start-->
		<section>
        	<div id="page-wrapper">
				<div class="main-page">
					<div class="forms">
						<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Observador estudiante: <?php echo $nombre_estudiante; ?></h4>	
							</div>
						</div>
					</div>
				
					<div class="tables">
						<div class="panel-body widget-shadow">
							<div class="panel-group" id="accordion">
								<div class="panel panel-default" style="border: 1px solid green;">
									<br>
									<?php
										//echo $sql_val_inicial;
										
										if (!isset($n_documento)) {
											echo '<div class="alert alert-danger" role="alert">
												<strong>¡Alerta!</strong> El estudiante no se encuentra matriculado.
											</div>';
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<thead > 
														<tr style="background-color: lightgreen">
															<th COLSPAN=2><center><strong>VALORACIÓN INICIAL</strong></center></th>
															<th COLSPAN=2><center><strong>Solicitada por: '.$solicita.'</strong></center></th>
														</tr>';
											echo '<tr>
													<th><center>Motivo</center></th>
													<th><center>Personalidad</center></th>
													<th><center>Observaciones</center></th>
													<th><center>Fecha</center></th>
													</tr> 
													</thead> 
													<tbody>
												';
											while ($row = mysqli_fetch_array($exe_val_inicial1)) {
												echo '<tr>
													<td><center>'.$row['motivo'].'</center></tdh>
													<td><center>'.$row['personalidad'].'</center></td>
													<td><center>'.$row['observaciones'].'</center></td>
													<td><center>'.$row['fecha'].'</center></td>
													</tr>';
											}
											
											echo "</tbody> 
												</table>";
											
										}
									?>
								</div>
								<br/>
								
								<div class="panel panel-default" style="border: 1px solid blue;">
									<?php
										if (!isset($n_documento)) {
											//no hace nada
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<thead > 
														<tr style="background-color: lightblue;">
															<th COLSPAN=7><center><strong>SEGUIMIENTOS</strong></center></th>
														</tr>';
											echo '<tr>
													<th><center>Objetivo</center></th>
													<th><center>Avances</center></th>
													<th><center>Acciones Est</center></th>
													<th><center>Acciones Acu</center></th>
													<th><center>Compromisos</center></th>
													<th><center>Fecha</center></th>
													<th><center>Estado</center></th>
													</tr> 
													</thead> 
													<tbody>
												';
											while ($row = mysqli_fetch_array($exe_seguimientos)) {
												echo '<tr>
													<td><center>'.$row['objetivo'].'</center></td>
													<td><center>'.$row['avances'].'</center></td>
													<td><center>'.$row['acciones_est'].'</center></td>
													<td><center>'.$row['acciones_acu'].'</center></td>
													<td><center>'.$row['compromisos'].'</center></td>
													<td><center>'.$row['fecha'].'</center></td>
													<td><center>'.$row['estado'].'</center></td>
													</tr>';
											}
											
											echo "</tbody> 
												</table>";
											
										}
									?>
								</div>
								<br/>
								
								<div class="panel panel-default" style="border: 1px solid orange;">
									<?php
										if (!isset($n_documento)) {
											//no hace nada
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<thead > 
														<tr style="background-color: lightyellow;">
															<th COLSPAN=7><center><strong>OBSERVACIONES TUTORES Y PSICÓLOGOS</strong></center></th>
														</tr>';
											echo '<tr>
													<th><center>Observación</center></th>
													<th><center>Tutor - Psicólogo</center></th>
													<th><center>Fecha</center></th>
													</tr> 
													</thead> 
													<tbody>
												';
											while ($row = mysqli_fetch_array($exe_observaciontes_tutores)) {
												echo '<tr>
													<td><center>'.$row['observacion'].'</center></td>
													<td><center>'.$row['tutor'].'</center></td>
													<td><center>'.$row['fecha'].'</center></td>
													</tr>';
											}
											
											echo "</tbody> 
												</table>";
											
										}
									?>
								</div>
								<br/>
							
							</div>
							
							<input type="hidden" id="txtidest" value="<?php echo $id; ?>"/><input type="hidden" id="txtidgra" value="<?php echo $id_grado; ?>"/>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<!--footer-->
		<?php 
			require "include/footer.php";
		?>
        <!--//footer-->
	</div>
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
	<!--scrolling js-->
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../js/scripts.js"></script>
	<!--//scrolling js-->

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
   <script type="text/javascript" src="../js/MaxLength.min.js"></script>

</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>