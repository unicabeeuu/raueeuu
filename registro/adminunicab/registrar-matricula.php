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
    
	//$peticion="SELECT * from estudiantes where estado='inactivo'";
	/*$peticion="SELECT e.*, m.* 
	FROM estudiantes e LEFT JOIN matricula m ON e.id = m.id_estudiante WHERE m.estado='solicitud'";*/
	$peticion="SELECT a.*, g.grado 
    	FROM (SELECT e.id, e.apellidos, e.nombres, e.n_documento, e.genero, e.email_institucional, e.telefono_acudiente_1, e.periodo_ing, m.* 
    	FROM estudiantes e LEFT JOIN matricula m ON e.id = m.id_estudiante WHERE m.estado IN ('pre_solicitud', 'solicitud', 'nuevo_pre_solicitud', 'antiguo_pre_solicitud', 'nuevo_solicitud', 'antiguo_solicitud')) a, grados g 
    	WHERE a.id_grado = g.id";
	$resultado = mysqli_query($conexion, $peticion);
?>
<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php //require 'menu.php';  ?>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else if($perfil == "AR1") {
		        require 'menu_registro_aux.php';
		    }
		    else {
		        require 'menu.php';
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
           		<div class="charts">		
               		 <div class="mid-content-top charts-grids">	
                    	<div class="middle-content">                    	
					    	<table id="listEstudiantes" class="display" style="width:100%">
					        <thead>
                            <br><br>
					            <tr>
					                <!-- <th>Grado</th> -->
					                <th>Apellidos</th>
					                <th>Nombres</th>
					                <th>Identificación</th>
					                <th>Celular</th>
					                <th>Correo</th>
					                <th>Estado</th>
					                <th>Grado</th>
									<th>PerIng</th>
									<th>FSolicitud</th>
					                <th>Acción</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        	while ($fila = mysqli_fetch_array($resultado)){
					        	    if ($fila['estado'] == 'solicitud' || $fila['estado'] == 'nuevo_solicitud' || $fila['estado'] == 'antiguo_solicitud') {
					        	        echo"<tr>
					        		    <td>".$fila['apellidos']."</td>
					        		    <td>".$fila['nombres']."</td>
					        		    <td>".$fila['n_documento']."</td>
					        		    <td>".$fila['telefono_acudiente_1']."</td>
					        		    <td>".$fila['email_institucional']."</td>
					        		    <td>".$fila['estado']."</td>
					        		    <td>".$fila['grado']."</td>
										<td>".$fila['periodo_ing']."</td>
										<td>".$fila['fecha_ingreso']."</td>
					        		    <td><a class='btn btn-primary' href='validar-matricula_f.php?id=".$fila['id']."' title='Matricular Estudiante'><i class='fa fa-check-square-o'></i> Matricular</a></td>
					        		    </tr>";    
					        	    }
					        	    else {
					        	        echo"<tr>
					        		    <td>".$fila['apellidos']."</td>
					        		    <td>".$fila['nombres']."</td>
					        		    <td>".$fila['n_documento']."</td>
					        		    <td>".$fila['telefono_acudiente_1']."</td>
					        		    <td>".$fila['email_institucional']."</td>
					        		    <td>".$fila['estado']."</td>
					        		    <td>".$fila['grado']."</td>
										<td>".$fila['periodo_ing']."</td>
										<td>".$fila['fecha_ingreso']."</td>
					        		    <td></td>
					        		    </tr>";
					        	    }
					        		
					        	}
					        	?>
					        </tbody>
					    </table>
					    <label><?php //echo $peticion; ?></label>
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
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>