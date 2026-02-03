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
<?php require 'php/conexion.php';
	$sql="SELECT * FROM grados";
	$gradoActual="No se encontraron estudiantes matriculados";
	// '".$_POST["id_grado"]."'
	if (!isset($_POST["id_grado"])) {
	$peticion="SELECT estudiantes.apellidos,estudiantes.id,estudiantes.nombres,estudiantes.genero,estudiantes.n_documento,estudiantes.email_institucional, grados.grado 
	FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id= matricula.id_grado 
	WHERE matricula.estado='activo' AND matricula.n_matricula like '%2025%' ORDER BY grados.grado";
	$gradoActual="Completo";
	}
 	if (isset($_POST["id_grado"])) {
	$peticion="SELECT estudiantes.id, estudiantes.apellidos,estudiantes.nombres,estudiantes.genero,estudiantes.n_documento,estudiantes.email_institucional, grados.grado 
	FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id= matricula.id_grado 
	WHERE grados.id=".$_POST['id_grado']."  and matricula.estado='activo' AND matricula.n_matricula like '%2025%' ORDER BY grados.grado";
	// var_dump($peticion);
	
	$res=mysqli_query($conexion,$peticion);
	
	while ($fila=mysqli_fetch_array($res)) {
		$gradoActual=$fila["grado"];
		}
	}	

$resultado = mysqli_query($conexion, $sql);
$resultado1 = mysqli_query($conexion, $peticion);
?>
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
		<!-- main content start-->
        <section>
           <div id="page-wrapper">
           		<div class="charts">		
               		 <div class="mid-content-top charts-grids">	
                    	<div class="middle-content">
                        <div class="alert alert-info" role="alert">Listado: <?php echo $gradoActual; ?></div>
                    		<div class="form-group"> 
                    			<form  method="post" action="certificados-periodo.php">
									<label for="smallinput" class="col-sm-2 control-label label-input-sm">Seleccione grado:</label>
									<div class="col-sm-8">
										<select id="id_grado" name="id_grado" class="form-control1" required>
											<?php 
												while ($fila=mysqli_fetch_array($resultado)){
													echo '<option value="'.$fila['id'].'">'.$fila['grado'].'</option>';
													$gradoActual=$fila['grado'];
												}
											?>
						              	</select>
									</div>
								  	<button type="submit" class="btn btn-default"><span style="color:#FFF" class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                                    <a href="certificados-periodo.php" class="btn btn-success">Todo</a>
                    			</form>
							</div>
							<hr>
					    	<table id="listEstudiantes" class="display" style="width:100%">
					    		<thead>
						           <tr>
						               <th align="center">Grado</th>
						               <th align="center">Apellidos</th>
						               <th align="center">Nombres</th>
						               <th align="center">Identificación</th>
	                                   <th align="center">Acción</th>
	              
						           </tr>
       							</thead>
							   <tbody>
								<?php 
								while ($fila = mysqli_fetch_array($resultado1)){

								echo"<tr><td>".$fila['grado']."</td><td>".$fila['apellidos']."</td><td>".$fila['nombres']."</td><td>".$fila['n_documento']."</td>
								<td align='center'>
								<a class='btn btn-primary' href='generar-certificados.php?id=".$fila['id']."' title='Generar certificado'>Certificado</a></td></tr>
								

								";
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
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>