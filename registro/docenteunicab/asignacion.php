<?php 
session_start();
include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniprofe'])) {
		//$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
		$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
		$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
        $id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
	}
	/*$sqlNotas="SELECT DISTINCT grados.grado, materias.materia, materias.pensamiento, profesores.nombres, profesores.apellidos 
	    FROM materias INNER JOIN (grados INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) 
	    ON grados.id = carga_profesor.id_grado) ON materias.Id = carga_profesor.id_materia where profesores.id='".$id."' ORDER BY grados.id ASC";*/
	if($id == 18 || $id == 40) {
	    $sqlNotas="SELECT DISTINCT g.grado, m.materia, m.pensamiento, p.nombres, p.apellidos 
	    FROM materias m, grados g, tbl_empleados p, carga_profesor cp 
	    WHERE p.id = cp.id_empleado AND g.id = cp.id_grado AND m.id = cp.id_materia ORDER BY g.id";
	}
	else {
	    $sqlNotas="SELECT DISTINCT g.grado, m.materia, m.pensamiento, p.nombres, p.apellidos 
	    FROM materias m, grados g, tbl_empleados p, carga_profesor cp 
	    WHERE p.id = cp.id_empleado AND g.id = cp.id_grado AND m.id = cp.id_materia AND cp.id_empleado = ".$id." ORDER BY g.id";
	}
	//echo $sqlNotas;
	$consulta=mysqli_query($conexion,$sqlNotas);
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
		<?php 
		    if($id == 18) {
	        require 'menu_adm.php';
		    }
		    else {
		        //require 'menu.php';
		        require 'menu_tutores.php';
		    }  
		?>
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
							<table class="table table-hover" border="1" bordercolor="#e0e0e0">
							<thead> 
								<tr>
									<TH COLSPAN=4><center>CARGA ASIGNADA</center></TH>
								</tr>
								<?php
								    if($id == 18 || $id == 40) {
								?>
								<tr>
								    <th><center>TUTOR</center></th> 
									<th><center>GRADO</center></th>
									<th><center>MATERIA</center></th>
									<th><center>PENSAMIENTO</center></th>  
								</tr>
								<?php
								    }
								    else {
								?>
								<tr>
									<th><center>GRADO</center></th>
									<th><center>MATERIA</center></th>
									<th><center>PENSAMIENTO</center></th>  
								</tr>
								<?php
								    }
								?>
							</thead> 
							<tbody> 
								<?php 
								$respuesta=mysqli_num_rows($consulta);
								if ($respuesta>=1) {
									while ($fila = mysqli_fetch_array($consulta)){
									    $nombre_completo = $fila['nombres']." ".$fila['apellidos'];
									    if($id == 18) {
									        echo"<tr>
    					        		    <td scope='row'>".$nombre_completo."</td><td>".$fila['grado']."</td><td>".$fila['materia']."</td><td>".$fila['pensamiento']."</td>";
									    }
									    else {
									        echo"<tr>
    					        		    <td scope='row'>".$fila['grado']."</td><td>".$fila['materia']."</td><td>".$fila['pensamiento']."</td>";
									    }
					        		}
								}else{
									echo '<div class="alert alert-danger" role="alert">El profesor <strong>'.$apellidos.' '.$nombres.'</strong> no tiene asignaturas asiganadas</div>';

								}
					        	?>
								</tr> 
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
	echo "<script>location.href='../../login_registro.php';</script>";
}
?>
</html>