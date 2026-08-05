<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniestudiante'])) {
		$sql = "SELECT * FROM tbl_estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
		$res = mysqli_query($conexion,$sql);

	$id = "";
	$apellidos = "";
	$nombres = "";
	$n_documento = "";
	$email_institucional = "";
	$password = "";

	while ($fila = mysqli_fetch_array($res)){

	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$email_institucional = $fila['email_institucional'];
		$password = $fila['password'];
	}
	$contador=0;
	$nota_uno=0;
	$nota_dos=0;
	$nota_tres=0;
	$nota_cuatro=0;
	//$id_grado se deja SIN inicializar a propósito: los bloques de abajo usan isset($id_grado)
	//para distinguir "estudiante matriculado" de "no matriculado".
	if ($id != "") {
		$buscar_grado="SELECT DISTINCT tbl_matriculas.id_grado, tbl_grados.grado FROM tbl_matriculas
	    INNER JOIN tbl_grados ON tbl_matriculas.id_grado=tbl_grados.id
	    INNER JOIN tbl_estudiantes on tbl_matriculas.id_estudiante=tbl_estudiantes.id where tbl_estudiantes.id=".$id." and tbl_matriculas.estado='activo'";
		$exe_grado = mysqli_query($conexion, $buscar_grado);

		while ($fila_grado = mysqli_fetch_array($exe_grado)) {
			$id_grado = $fila_grado['id_grado'];
			$grado = $fila_grado['grado'];
		}
	}

	$sql_val_inicial = "SELECT sv.n_documento, CONCAT(est.nombres, ' ', est.apellidos) estudiante,
	CASE sv.id_empleado WHEN 0 THEN (CASE sv.id_solicita WHEN 1 THEN 'ACUDIENTE' ELSE CONCAT(e.nombres, ' ', e.apellidos) END) 
	ELSE CONCAT(e1.nombres, ' ', e1.apellidos) END nombre_solicita, 
	CONCAT(e.nombres, ' ', e.apellidos) solicita, CONCAT(e1.nombres, ' ', e1.apellidos) empleado, 
	sv.id, sv.motivo, sv.personalidad, sv.observaciones, sv.fecha 
	FROM tbl_seg_psi_val sv, tbl_empleados e, tbl_empleados e1, tbl_estudiantes est 
	WHERE sv.id_solicita = e.id AND sv.id_empleado = e1.id AND sv.n_documento = est.n_documento 
	AND sv.n_documento = '$n_documento'";
	//echo $sql_val_inicial;
	$exe_val_inicial = mysqli_query($conexion, $sql_val_inicial);
	$exe_val_inicial1 = mysqli_query($conexion, $sql_val_inicial);

	//Si el estudiante no tiene valoración inicial, esta consulta no devuelve filas
	$solicita = "";
	$id_valoracion = "";

	while ($row_val_inicial = mysqli_fetch_array($exe_val_inicial)) {
		$solicita = $row_val_inicial['nombre_solicita'];
		$id_valoracion = $row_val_inicial['id'];
	}
	//echo $solicita;

	$exe_seguimientos = false;
	if ($id_valoracion != "") {
		$sql_seguimientos = "SELECT objetivo, avances, acciones_est, acciones_acu, compromisos, proc_post, fecha, estado
		FROM tbl_seg_psi WHERE id_valoracion = $id_valoracion ORDER BY fecha";
		$exe_seguimientos = mysqli_query($conexion, $sql_seguimientos);
	}
	
	$sql_observaciones_tutores = "SELECT * 
	FROM tbl_estudiantes_observ_tut WHERE n_documento = '$n_documento'";
	$exe_observaciontes_tutores = mysqli_query($conexion, $sql_observaciones_tutores);
	
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Unicab Academic Registry</title>
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
    <script type="text/javascript" src="../docenteunicab/updreg/js/jquery.min.js"></script>
    <script src="../js/modernizr.custom.js"></script>
    
    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <!--//webfonts--> 
    
    <!--css tabla -->
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
    <!-- // css tabla -->
    
    <!-- Metis Menu -->
    <script src="../js/metisMenu.min.js"></script>
    <!--<script src="../js/custom.js"></script>-->
    <link href="../css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
    
    <script>
        $(function() {
            //alert("Cargó jquery");
        });
            
        function ver_cal_mood() {
            alert("hola");
            let value=$("#txtidest").val();
        	let value1=$("#txtidgra").val();
        	//alert(id_est + id_gra);
            
            /*$.ajax({
        		type:"POST",
        		url:"../docenteunicab/updreg/buscar_notas_mood.php",
        		data:"idest_ra1=" + value + "&idgra_ra1=" + value1,
        		success:function(r) {
        		    //Esto es para mostrar la tabla con las notas moodle
        			let res = JSON.parse(r);
        			console.log(res);
        			let lineas = res.tabla.lineas;
        			//console.log(lineas);
        			//$("#tablam").html(lineas.length);
        			for(let i = 0; i < lineas.length; i++) {
        			    let idestm = lineas[i].id_est;
        			    let lastn = lineas[i].lastname;
        			    let firstn = lineas[i].firstname;
        			    let shortn = lineas[i].shortname;
        			    let pen = lineas[i].pensamiento;
        			    let idnumber = lineas[i].idnumber;
        			    let per = lineas[i].periodo;
        			    let cal = lineas[i].calificacion;
        		    }
        		}
        	});*/
        }
    </script>
    
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
							<div class="panel-group" id="accordion">
								<div class="panel panel-default" style="border: 1px solid green;">
									<br>
									<?php
										//echo $sql_val_inicial;
										
										if (!isset($id_grado)) {
											echo '<div class="alert alert-danger" role="alert">
												<strong>¡Alerta!</strong> El estudiante no se encuentra matriculado.
											</div>';
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<thead > 
														<tr style="background-color: lightgreen">
															<th COLSPAN=2><center><strong>INITIAL ASSESSMENT</strong></center></th>
															<th COLSPAN=2><center><strong>Requested by: '.$solicita.'</strong></center></th>
														</tr>';
											echo '<tr>
													<th><center>Reason</center></th>
													<th><center>Personality</center></th>
													<th><center>Observations</center></th>
													<th><center>Date</center></th>
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
										//echo $sql_val_inicial;
										
										if (!isset($id_grado)) {
											//no hace nada
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<thead > 
														<tr style="background-color: lightblue;">
															<th COLSPAN=7><center><strong>FOLLOW-UPS</strong></center></th>
														</tr>';
											echo '<tr>
													<th><center>Objective</center></th>
													<th><center>Progress</center></th>
													<th><center>Student Actions</center></th>
													<th><center>Guardian Actions</center></th>
													<th><center>Commitments</center></th>
													<th><center>Date</center></th>
													<th><center>Status</center></th>
													</tr> 
													</thead> 
													<tbody>
												';
											while ($exe_seguimientos && $row = mysqli_fetch_array($exe_seguimientos)) {
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
															<th COLSPAN=7><center><strong>TUTOR OBSERVATIONS</strong></center></th>
														</tr>';
											echo '<tr>
													<th><center>Observation</center></th>
													<th><center>Tutor</center></th>
													<th><center>Date</center></th>
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
							
							<input type="hidden" id="txtidest" value="<?php echo $id; ?>"/><input type="hidden" id="txtidgra" value="<?php echo isset($id_grado) ? $id_grado : ""; ?>"/>
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
			let menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
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