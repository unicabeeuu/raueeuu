<?php
session_start();
require "../../adminunicab/php/conexion.php";
if (isset($_SESSION['uniprofe'])) {
    $idest = $_POST["idest_ra01"];
	$idgra = $_POST["idgra_ra01"];
	//echo $idest;
	//echo $idgra;
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- Favicon -->
<link rel="shortcut icon" href="../../images/favicon.png" />
<!-- // Favicon -->
 <!-- js-->
<script src="../../js/jquery-1.11.1.min.js"></script>
<script src="../../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../../js/metisMenu.min.js"></script>
<script src="../../js/custom.js"></script>
<link href="../../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
#chartdiv {
  width: 100%;
  height: 295px;
}
</style>
<?php require '../../adminunicab/php/conexion.php';
$sql="SELECT * FROM grados";
	$gradoActual="No se encontraron estudiantes matriculados";
	$peticion='SELECT estudiantes.apellidos,estudiantes.id,estudiantes.nombres,estudiantes.genero,estudiantes.n_documento,estudiantes.email_institucional, grados.grado 
	    FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id= matricula.id_grado 
	    WHERE grados.id='.$idgra.' AND matricula.estado="activo" AND estudiantes.id = '.$idest;
    //echo $gradoActual;
    //echo "ig_grado: ".$_POST["id_grado"];
	/*if (!isset($_POST["id_grado"])) {
	$peticion='SELECT estudiantes.apellidos,estudiantes.id,estudiantes.nombres,estudiantes.genero,estudiantes.n_documento,estudiantes.email_institucional, grados.grado FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id= matricula.id_grado where grados.id='.$idgra.' and matricula.estado="activo" ORDER BY grados.grado';
	$gradoActual="Completo";
	//echo $peticion;
	//echo $gradoActual;
	}
 	if (isset($_POST["id_grado"])) {
	$peticion="SELECT estudiantes.id, estudiantes.apellidos,estudiantes.nombres,estudiantes.genero,estudiantes.n_documento,estudiantes.email_institucional, grados.grado FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id= matricula.id_grado where grados.id=".$_POST['id_grado']."  and matricula.estado='activo' ORDER BY grados.grado";
	//echo $peticion;
	$res=mysqli_query($conexion,$peticion);
	
	while ($fila=mysqli_fetch_array($res)) {
		$gradoActual=$fila["grado"];
		}
	}*/	

//echo $sql;
$resultado = mysqli_query($conexion, $sql);
$resultado1 = mysqli_query($conexion, $peticion);
//echo $peticion;
?>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
    	
		<section>
           <div id="page-wrapper">
           		<div class="charts">		
               		 <div class="mid-content-top charts-grids">	
                    	<div class="middle-content">
                        <div class="alert alert-info" role="alert">Proceso de reversar cierre</div>
                    		<hr>
					    	<table id="listEstudiantes" class="display" style="width:100%">
					        <thead>
                            <br><br>
					            <tr>
					                <th>Grado</th>
					                <th>Apellidos</th>
					                <th>Nombres</th>
					                <th>Identificación</th>
                                    <th>Acción</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        	while ($fila = mysqli_fetch_array($resultado1)){
									$id_estudiante=$fila['id'];
					        		echo"<tr><td>".$fila['grado']."</td><td>".$fila['apellidos']."</td><td>".$fila['nombres']."</td><td>".$fila['n_documento']."</td><td><a class='btn btn-danger' href='hn_ghf.php?id=".$fila['id']."' title='Cierre académico' >CIERRE ACADÉMICO</a></td></tr>";
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
	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="../../js/classie.js"></script>
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
	<script src="../../js/jquery.nicescroll.js"></script>
	<script src="../../js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='../../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->

	<!-- Bootstrap Core JavaScript -->
   <script src="../../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->

	<!-- js tabla -->
	<script src="../../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
    
    <script>
	$('#myModal').modal('show');
    	$('#myModal').on('shown.bs.modal', function () {
		  $('#myInput').focus()
		})
    </script>
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../../login_registro.php'</script>";
}
?>
</html>