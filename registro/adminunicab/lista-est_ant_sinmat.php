<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		$perfil = $fila['perfil'];
	}
    
	/*$peticion="SELECT e.nombres, e.apellidos, e.n_documento, g.id, g.grado ultimo_grado, m.estado 
    FROM (SELECT * FROM estudiantes WHERE id < 1155) e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    AND date_format(m.fecha_ingreso, '%Y') = 2020 
    AND e.id NOT IN (
    SELECT e.id 
    FROM estudiantes e, matricula m 
    WHERE e.id = m.id_estudiante 
    AND e.id < 1155 AND date_format(m.fecha_ingreso, '%Y') = 2021) 
    ORDER BY g.id";*/
    $peticion="SELECT e.nombres, e.apellidos, e.n_documento, g.id, g.grado ultimo_grado, m.estado 
    FROM (SELECT * FROM estudiantes WHERE id < 1855 AND id NOT IN (1040,1155)) e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    AND m.fecha_ingreso > '2020-11-30' AND m.fecha_ingreso < '2021-12-01' AND m.estado IN ('aprobado', 'reprobado') 
    AND e.id NOT IN (
    SELECT e.id 
    FROM estudiantes e, matricula m 
    WHERE e.id = m.id_estudiante 
    AND e.id < 1855 AND m.fecha_ingreso >= '2021-12-01') 
    ORDER BY g.id";
	$resultado = mysqli_query($conexion, $peticion);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
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
<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->
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
		<?php //require 'menu.php';  ?>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else {
		        require 'menu.php';
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
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Lista de estudiantes antiguos sin matricular:</h4>
						</div>
						<div class="form-body">
							<table id="listEstudiantes" class="display" style="width:100%">
						        <thead>                    
						            <tr>
						                <th>Apellidos</th>
						                <th>Nombres</th>
						                <th>Identificación</th>
						                <th>Id_grado</th>
						                <th>Ultimo grado</th>
						                <th>Estado</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php 
							        	while ($fila = mysqli_fetch_array($resultado)){
							        		echo"<tr>
							        		<td>".$fila['apellidos']."</td>
							        		<td>".$fila['nombres']."</td>
							        		<td>".$fila['n_documento']."</td>
							        		<td>".$fila['id']."</td>
							        		<td>".$fila['ultimo_grado']."</td>
							        		<td>".$fila['estado']."</td></tr>";
							        	}
						        	?>
						        </tbody>
						    </table>
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