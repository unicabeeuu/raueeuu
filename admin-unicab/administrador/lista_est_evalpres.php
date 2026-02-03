<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		$sql_emp = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW','PS') AND id NOT IN (1,30,31)";
		$exe_emp = mysqli_query($conexion,$sql_emp);
        
		/*while ($row_emp = mysqli_fetch_array($exe_emp)) {
			$id_emp = $row_emp['id'];
			$apellidos_ep = $row_emp['apellidos'];
			$nombres_emp = $row_emp['nombres'];
		}*/
		
		//$peticion="SELECT * from estudiantes WHERE estado != 'Retirado'"; // este id estaba 3148
		$peticion_evalpres = "SELECT DISTINCT e.id, e.nombres, e.apellidos, e.n_documento, e.email_institucional, e.telefono_estudiante, r.id_grado, g.grado, r.estado, 
		CASE WHEN e.id <= 3482 THEN 'Antiguo' ELSE 'Nuevo' END tipo_estudiante, d.DSA, d.DA, d.DM, d.DB 
		FROM estudiantes e, tbl_respuestas r, grados g, tbl_desemp_pres d 
		WHERE e.n_documento = r.identificacion AND r.id_grado = g.id AND e.n_documento = d.identificacion AND r.id_grado = d.id_grado 
		AND r.a >= 2025 AND r.identificacion NOT IN (SELECT DISTINCT identificacion FROM `tbl_respuestas` WHERE estado = 'ABIERTA') 
		ORDER BY g.id, e.nombres";
		$resultado_evalpres = mysqli_query($conexion, $peticion_evalpres);
?>
<?php
$peticion2="SET lc_time_names = 'es_CO'";
$resultado2 = mysqli_query($conexion, $peticion2);

$peticion = "SELECT DATE_FORMAT(NOW(),'%W %d de %M de %Y') fecha";
$resultado = mysqli_query($conexion, $peticion);
while ($fila = mysqli_fetch_array($resultado))
	{
		$fechaActual=$fila['fecha'];
    }  ;

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

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

    <link href='fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='fullcalendar/lib/main.js'></script>
    <script src='fullcalendar/lib/locales-all.js'></script>
    <script>
        $(function() {
            $("#psicologo").change(function() {
                //$("#btnsubmit").hide();
                //alert("hola");
                
                var psi = $("#psicologo").val();
                //alert(psi);
                if(psi == "0") {
                    $("#btnsubmit").hide();
                }
                else {
                    $("#btnsubmit").show();
                }
                
        	});
        });
    
    </script>

    <style>
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
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Resultados Evaluación de Admisión:</h4>
						</div>
						<div class="form-body">
							<table id="listEstudiantes" class="display" style="width:100%">
						        <thead>                    
						            <tr>
						                <th>Apellidos</th>
						                <th>Nombres</th>
						                <th>Identificación</th>
						                <th>Correo</th>
						                <th>Grado</th>
										<th>Tipo Est</th>
						                <!--<th>Estado</th>
										<th>DSA</th>
										<th>DA</th>-->
										<th>DM</th>
										<th>DB</th>
						                <th>Acción</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php 
							        	while ($fila = mysqli_fetch_array($resultado_evalpres)){
							        		echo"<tr>
							        		<td>".$fila['apellidos']."</td>
							        		<td>".$fila['nombres']."</td>
							        		<td>".$fila['n_documento']."</td>
							        		<td>".$fila['email_institucional']."</td>
							        		<td>".$fila['grado']."</td>
											<td>".$fila['tipo_estudiante']."</td>
							        		<!--<td>".$fila['estado']."</td>
											<td>".$fila['DSA']."</td>
											<td>".$fila['DA']."</td>-->
											<td style='color: orange;'>".$fila['DM']."</td>
											<td style='color: red;'>".$fila['DB']."</td>";

							        		echo "<td><center>
							        		<a href='lista_est_evalpres1.php?idest=".$fila['id']."' class='btn btn-primary'><i class='fa fa-file-text'></i> Ver resultado</a></center></td></tr>";
							        	}
						        	?>
						        </tbody>
						    </table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
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
   <script type="text/javascript" src="../js/MaxLength.min.js"></script>

   <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>