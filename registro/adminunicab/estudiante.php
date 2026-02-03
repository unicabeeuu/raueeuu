<?php
session_start();
include "php/conexion.php";
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
                    		<div class="form-group"> 
                    			<div class="form-body">
                    			<form class="form-horizontal" action="estudiante.php"  method="POST" onsubmit="return validacion()">
									<div class="form-group">
										<label  class="col-sm-2 control-label">Grado<span class="req">*</span></label>
										<div class="col-sm-8">
											<select id="id_grado" name="grado" class="form-control1" required>
												<option value='0'>Seleccionar Grado</option>
												<?php 
													$sql="SELECT * FROM grados";
													$consulta=mysqli_query($conexion,$sql);
													while ($fila=mysqli_fetch_array($consulta)){
														echo '<option value="'.$fila['id'].'">'.$fila['grado'].'</option>';
													}
												?>
			              					</select>
										</div>
									</div>
                            
									<div class="modal-footer">
										<input type="submit" class="btn btn-primary" value="Buscar Estudiante" title="Buscar Estudiante">
									</div>
									<div class="alert alert-danger" role="alert" id="alert" style="display:none; margin-top: 20px;"></div>
								</form>
								<?php 
								if (!isset($_POST['grado'])) {

								}else{
									$grado=$_POST['grado'];
									$sql_estudiante="SELECT DISTINCT estudiantes.id, estudiantes.apellidos, estudiantes.nombres, grados.grado, matricula.estado FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id = matricula.id_grado WHERE grados.id=".$grado." and matricula.estado='activo' ORDER BY apellidos ASC";
									$exe_estudiante=mysqli_query($conexion,$sql_estudiante);
									$buscar=mysqli_num_rows($exe_estudiante);
									if ($buscar>0) {
										while ($fila=mysqli_fetch_array($exe_estudiante)) {
										$nombre_grado=strtoupper($fila['grado']);
										$apellidos_estudiante=$fila['apellidos'];
										$nombre_estudiante=$fila['nombres'];
									}
									echo '								
									<table class="table table-hover" border="1" bordercolor="#e0e0e0">
										<thead > 
										<tr>
											<TH COLSPAN=4><center><strong>LISTADO ESTUDIANTES GRADO: '.$nombre_grado.'</strong></center></TH>
										</tr>
										<tr>
											<th><center>Apellidos</center></th>
											<th><center>Nombres</center></th>
											<th><center>Acción</center></th>
										</tr> 
										</thead> 
										<tbody>';
											$exe_listado=mysqli_query($conexion,$sql_estudiante);
											while ($row=mysqli_fetch_array($exe_listado)) {
												echo'<tr>
					         						<td scope="row">'.$row['apellidos'].'</td>
					         						<td scope="row">'.$row['nombres'].'</td>
					         						<td scope="row">
					         						<center><a href="informe-estudiante.php?id_estudiante='.$row['id'].'" class="btn btn-primary"  "title="Informe Estudiante"><i class="fa fa-eye"></i> Informe</a></center></td>

				         						</tr>';											
											}
										echo '</tbody>
								</table>';	
									}else{
										echo '<div class="alert alert-danger" role="alert">
  										<strong>¡Alerta!</strong> No se encontro resultados para este grado
										</div>';
									}
								}
								?>
								</div>
								
              		 		</div>
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
   		<!-- validar combo periodo -->
		<script type="text/javascript">
			function validacion() {
				var grado=document.getElementById('id_grado').value;
				if (grado==0) {
					$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar un grado valido</center>').slideDown(500);
					return false;
				}else{
					$('#alert').html('').slideUp(300);
				}
			}
		</script>
		<!-- // validar combo periodo -->
</body>
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>