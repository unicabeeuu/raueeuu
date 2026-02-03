<?php
	session_start();
	require "../adminunicab/php/conexion.php";

	$n_documento = $_REQUEST['buscar'];

if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		//$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		$perfil = $fila['perfil'];
	}
    
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
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<style>
	.ck-editor__editable[role="textbox"] {
		/* editing area */
		min-height: 200px;
	}
</style>

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

<script type="text/javascript">
            
</script>
   	
<style>
    .azul1 {
		background: lightblue;
		height: 100px;
	}
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php 
		    if($id == 18) {
	        require 'menu_adm.php';
		    }
		    else {
		        //require 'menu.php';
		        require 'menu_tutores.php';
		    }  
		?>
	
		<?php require 'header.php';  ?>
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
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
		<?php require 'footer.php'; ?>
	    <!--//footer-->
	</div>
</body>
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
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>