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
<link href="../css/jquery.dataTables.min.css" rel='stylesheet' type='text/css' />
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
								<h4>Lista de Seguimientos:</h4>	
							</div>
						</div>
					</div>
				<div class="tables">
					<div class="panel-body widget-shadow">
						
						<table id="example" class="display" style="width:100%">
					        <thead>
					            <tr>
					                <th><center>Código</center></th>
                                	<th><center>Documento</center></th>
                                	<th><center>Estudiante</center></th>
					                <th><center>Fecha</center></th>
					                <th><center>Hora</center></th>
					                <th><center>Psicólogo</center></th>
                                    <!--<th><center>Acciones</center></th>-->
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        		//$sql_evento="SELECT * FROM `entrevistas` order by 'id'";
					        		$sql_evento="SELECT s.id, s.documento_est, s.fecha, s.hora, e.nombres, e.apellidos, em.nombres nombres_psi, em.apellidos apellidos_psi 
                                        FROM tbl_seguimientos s, estudiantes e, tbl_empleados em 
                                        WHERE s.documento_est = e.n_documento AND s.id_psicologo = em.id 
                                        UNION ALL 
                                        SELECT s.id, e.n_documento, s.fecha, s.hora, e.nombres, e.apellidos, em.nombres nombres_psi, em.apellidos apellidos_psi 
                                        FROM tbl_seg_psi s, tbl_seg_psi_val v, estudiantes e, tbl_empleados em  
                                        WHERE s.id_valoracion = v.id AND v.n_documento = e.n_documento AND s.id_psicologo = em.id";
					        		$exe_evento=mysqli_query($conexion,$sql_evento);
					        		while ($rowEvento=mysqli_fetch_array($exe_evento)) {
					        			echo "
					        			<tr>
											<td>".$rowEvento['id']."</td>
					        				<td>".$rowEvento['documento_est']."</td>
					        				<td>".$rowEvento['nombres']." ".$rowEvento['apellidos']."</td>
					        				<td>".$rowEvento['fecha']."</td>
					        				<td>".$rowEvento['hora']."</td>
					        				<td>".$rowEvento['nombres_psi']." ".$rowEvento['apellidos_psi']."</td>
					        				

					        			</tr>
					        			";
					        			/*
					        			<td>
					        				<center><a href='editar-entrevista.php?id=".$rowEvento['id']."'><i class='fa fa-pencil' aria-hidden='true'> Editar</i></a></center> 
					        				<center><a href='php/eliminarEntrevista.php?id=".$rowEvento['id']."'><i class='fa fa-trash' aria-hidden='true'> Borrar</i></a></center> 

					        				</td>
					        			*/
					        		}
					        		mysqli_close($conexion);
					        	?>
					        </tbody>
					        <tfoot>
					            <tr>
                                	<th><center>Código</center></th>
                                	<th><center>Documento</center></th>
                                	<th><center>Estudiante</center></th>
					                <th><center>Fecha</center></th>
					                <th><center>Hora</center></th>
					                <th><center>Psicólogo</center></th>
					            </tr>
					        </tfoot>
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

	<script src="../js/jquery-3.3.1.js"> </script>
	<script src="../js/jquery.dataTables.min.js"> </script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable( {
				"order": [[ 0, "desc" ]]
			} );
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