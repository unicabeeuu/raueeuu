<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
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

<!--css tabla 
<link href="../css/jquery.dataTables.min.css" rel='stylesheet' type='text/css' />--> 
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" rel="stylesheet">
<!-- // css tabla -->

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
<!-- js
<script src="../js/jquery-1.11.1.min.js"></script>-->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

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
		<div id="page-wrapper">
			<div class="main-page">
					<div class="forms">
						<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Lista de Estudiantes Nuevos:</h4>	
							</div>
						</div>
					</div>
				<div class="tables">
					<div class="panel-body widget-shadow">
						
						<table id="estudiantes" class="display table-striped nowrap" style="width:100%">
					        <thead>
					            <tr>
					                <th>Doc</th>
									<th>Nombres</th>
									<th>Apellidos</th>
                                	<th>Grado</th>
					                <th>Eval Admisión</th>
                                    <th>Entrevista</th>
									<th>Email Acudiente</th>
                                    <th>Teléfono Acudiente</th>
									<th>Documento</th>
									<th>Situación SE</th>
					                
					            </tr>
					        </thead>
					        <!--<tbody>
					        	<?php 
					        		//$sql_evento="SELECT * FROM `entrevistas` order by 'id'";
					        		/*$sql_nuevos = "SELECT DISTINCT pm.nombres_est, pm.apellidos_est, pm.documento_est, pm.email_a, pm.celular_a, g.grado, 
									en.fecha, en.hora, IFNULL(ea.n_documento, '-') n_documento 
									FROM estudiantes e JOIN tbl_pre_matricula pm ON e.n_documento = pm.documento_est 
									LEFT JOIN estudiantes_eval_admision ea ON e.n_documento = ea.n_documento 
									LEFT JOIN tbl_entrevistas en ON e.n_documento = en.documento_est AND en.fecha > '2023-10-31'
									LEFT JOIN grados g ON pm.id_grado = g.id
									WHERE e.a_matricula = 2024";
					        		$exe_nuevos = mysqli_query($conexion,$sql_nuevos);
					        		while ($row = mysqli_fetch_array($exe_nuevos)) {
										if ($row['n_documento'] == '-') {
											echo "
											<tr>
												<td>".$row['nombres_est']."</td>
												<td>".$row['apellidos_est']."</td>		
												<td>".$row['documento_est']."</td>		
												<td>".$row['grado']."</td>
												<td>".$row['email_a']."</td>
												<td>".$row['celular_a']."</td>
												<td>".$row['n_documento']."</td>
												<td>".$row['fecha']." ".$row['hora']."</td>											
											</tr>
											";
										}
					        			else {
											echo "
											<tr>
												<td>".$row['nombres_est']."</td>
												<td>".$row['apellidos_est']."</td>		
												<td>".$row['documento_est']."</td>		
												<td>".$row['grado']."</td>
												<td>".$row['email_a']."</td>
												<td>".$row['celular_a']."</td>
												<td><a class='btn btn-primary' href='programar_eval_admision.php?documento=".$row['n_documento']."' target='_blank'>Programar</a></td>
												<td>".$row['fecha']." ".$row['hora']."</td>											
											</tr>
											";
										}
					        		}
					        		mysqli_close($conexion);*/
					        	?>
					        </tbody>-->
				    	</table>
					</div>

				</div>
			</div>
		</div>
		<!--footer-->
		<?php 
			require 'include/footer.php';
		?>
        <!--//footer-->
	</div>
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
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
	
	<!-- Bootstrap Core JavaScript -->
	<script src="../js/bootstrap.js"> </script>

	<!--<script src="../js/jquery-3.3.1.js"> </script>
	<script src="../js/jquery.dataTables.min.js"> </script>-->
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			//$('#estudiantes').DataTable();
			/*new DataTable('#estudiantes', {
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
				},
				columnDefs: [
					{
						className: 'dtr-control',
						orderable: false,
						target: 0
					}
				],
				order: [1, 'asc'],
				responsive: {
					details: {
						type: 'column'
					}
				},
				scrollX: true
			});*/
			
			//La siguiente configuración corresponde a Filas secundarias controladas por columnas
			//https://datatables.net/extensions/responsive/examples/child-rows/column-control.html
			var datatable = $('#estudiantes').DataTable({
				"processing": true,
				"ajax": "listado_estudiantes_nuevos1.php",
				language: {
					url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
				},
				columnDefs: [
					{
						className: 'dtr-control',
						orderable: false,
						target: 0
					}
				],
				order: [1, 'asc'],
				responsive: {
					details: {
						type: 'column'
					}
				},
				scrollX: true
			});
		} );
	</script>
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>