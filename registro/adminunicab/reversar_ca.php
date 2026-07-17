<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
    $idest = isset($_POST["idest_ra01"]) ? trim($_POST["idest_ra01"]) : "";
    $idgra = isset($_POST["idgra_ra01"]) ? trim($_POST["idgra_ra01"]) : "";

    if ($idest === "" || $idgra === "") {
        echo "<script>alert('Debe indicar el estudiante y el grado antes de continuar.');</script>";
        echo "<script>location.href='adm1.php'</script>";
        exit;
    }

    $idest = intval($idest);
    $idgra = intval($idgra);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Academic Registry</title>
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
<?php require 'php/conexion.php';
$sql="SELECT * FROM tbl_grados";
	$tbl_gradosActual="No se encontraron tbl_estudiantes tbl_matriculasdos";
	$peticion="SELECT tbl_estudiantes.apellidos, tbl_estudiantes.id, tbl_estudiantes.nombres, tbl_estudiantes.genero, tbl_estudiantes.n_documento, tbl_estudiantes.email_institucional, tbl_grados.grado AS tbl_grados
	    FROM tbl_grados INNER JOIN (tbl_estudiantes INNER JOIN tbl_matriculas ON tbl_estudiantes.id = tbl_matriculas.id_estudiante) ON tbl_grados.id = tbl_matriculas.id_grado
	    WHERE tbl_grados.id = {$idgra} AND tbl_matriculas.estado = 'activo' AND tbl_estudiantes.id = {$idest}";
    //echo $tbl_gradosActual;
    //echo "ig_tbl_grados: ".$_POST["id_tbl_grados"];
	/*if (!isset($_POST["id_tbl_grados"])) {
	$peticion='SELECT tbl_estudiantes.apellidos,tbl_estudiantes.id,tbl_estudiantes.nombres,tbl_estudiantes.genero,tbl_estudiantes.n_documento,tbl_estudiantes.email_institucional, tbl_gradoss.tbl_grados FROM tbl_gradoss INNER JOIN (tbl_estudiantes INNER JOIN tbl_matriculas ON tbl_estudiantes.id = tbl_matriculas.id_estudiante) ON tbl_gradoss.id= tbl_matriculas.id_tbl_grados where tbl_gradoss.id='.$idgra.' and tbl_matriculas.estado="activo" ORDER BY tbl_gradoss.tbl_grados';
	$tbl_gradosActual="Completo";
	//echo $peticion;
	//echo $tbl_gradosActual;
	}
 	if (isset($_POST["id_tbl_grados"])) {
	$peticion="SELECT tbl_estudiantes.id, tbl_estudiantes.apellidos,tbl_estudiantes.nombres,tbl_estudiantes.genero,tbl_estudiantes.n_documento,tbl_estudiantes.email_institucional, tbl_gradoss.tbl_grados FROM tbl_gradoss INNER JOIN (tbl_estudiantes INNER JOIN tbl_matriculas ON tbl_estudiantes.id = tbl_matriculas.id_estudiante) ON tbl_gradoss.id= tbl_matriculas.id_tbl_grados where tbl_gradoss.id=".$_POST['id_tbl_grados']."  and tbl_matriculas.estado='activo' ORDER BY tbl_gradoss.tbl_grados";
	//echo $peticion;
	$res=mysqli_query($conexion,$peticion);
	
	while ($fila=mysqli_fetch_array($res)) {
		$tbl_gradosActual=$fila["tbl_grados"];
		}
	}*/	

//echo $sql;
$resultado = mysqli_query($conexion, $sql);
$resultado1 = mysqli_query($conexion, $peticion);
?>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
	    <?php require 'menu.php';  ?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		<!-- main content start-->
		<section>
           <div id="page-wrapper">
           		<div class="charts">		
               		 <div class="mid-content-top charts-grids">	
                    	<div class="middle-content">
                        <div class="alert alert-info" role="alert">Closing reversal process</div>
                    		<hr>
					    	<table id="listEstudiantes" class="display" style="width:100%">
					        <thead>
                            <br><br>
					            <tr>
					                <th>Grade</th>
					                <th>Apellidos</th>
					                <th>Nombres</th>
					                <th>Identification</th>
                                    <th>Action</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        	while ($fila = mysqli_fetch_array($resultado1)){
									$id_estudiante=$fila['id'];
					        		echo"<tr><td>".$fila['tbl_grados']."</td><td>".$fila['apellidos']."</td><td>".$fila['nombres']."</td><td>".$fila['n_documento']."</td><td><a class='btn btn-danger' href='reversar_hn.php?id=".$fila['id']."' title='Cierre académico' >ACADEMIC CLOSING</a></td></tr>";
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
	echo "<script>alert('You must log in');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>