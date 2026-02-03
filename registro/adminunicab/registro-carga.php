<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
    
	$peticion="SELECT * from profesores";
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
					      	<div class="well">
					            <div class="row">
					            	<?php 
					            		if (isset($_GET['id'])) {
					            			$id_profesor=$_GET['id'];
											$peticion34="SELECT * FROM profesores WHERE id=".$id_profesor." Limit 1";
											$resultado34 = mysqli_query($conexion, $peticion34);
											while ($fila = mysqli_fetch_array($resultado34)){
												$nombreCompleto=$fila['nombres']." ".$fila['apellidos']."";
											}

											echo "
												<div class='col-md-8' id='redesFinal'>
								                    <h4><b>Asignar carga academica al profesor: </h4>
								                    <h3>". $nombreCompleto ."?</b></h3>
								                </div>
								                <div class='col-md-4' align='center'>
								                    <a href='#' class='btn btn-primary' data-toggle='modal' data-target='#myModal'  title='Editar Estudiante'>Confirmar</a>
								                </div>
								                ";
										}else{
											echo "
												<string>Seleccioné un profesor para asignar carga académica</string>
							                ";
											}
					            	?>
					            </div>
					        </div>

					    	<table id="listEstudiantes" class="display" style="width:100%">
						        <thead>
						            <tr>
						                <th>Apellidos</th>
						                <th>Nombres</th>
	                                    <th>Correo</th>
						                <th>acción</th>
						            </tr>
						        </thead>
					        	<tbody>
					        	<?php 
						        	while ($fila = mysqli_fetch_array($resultado)){
										
						        		echo"<tr><td>".$fila['apellidos']."</td><td>".$fila['nombres']."</td><td>".$fila['email_institucional']."</td>
						        		<td><a href='registro-carga.php?id=".$fila['id']."' class='btn btn-primary' title='Asignación Carga'><i class='fa fa-pencil'></i> Editar</a></td>

						        		</tr>";
						        	}
					        	?>
					        	</tbody>
					    	</table>
               			</div>
          		 	</div>
        		</div>
           </div>
		</section>

	 	<?php
	 		if (isset($_GET['id'])) {
	 			$peticion = "SELECT * FROM profesores WHERE id=".$_GET['id']." LIMIT 1";
	 		}else{
	 			$peticion = "SELECT * FROM profesores";
	 		}
			$resultado2 = mysqli_query($conexion, $peticion);
			
			while ($fila = mysqli_fetch_array($resultado2)){
	      
		  	$id = $fila['id'];
			$apellidos = $fila['apellidos'];
			$nombres = $fila['nombres'];
			$n_documento = $fila['n_documento'];
			$email_institucional = $fila['email_institucional'];
			$password = $fila['password'];
	        }       
    	?>
	   	<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
						<!-- modal -->
	       			<div id="myModal" data-backdrop="static" class="modal fade" role="dialog">
	   				 	<div class="modal-dialog">
				 			<div class="modal-content">
	   				 				<div class="modal-header">
	   				 					<button type="button" class="close" data-dismiss="modal">&times;</button>
	   				 					<h4 class="modal-title">Asignar Carga a Docente:</h4>
				 					</div>
			 					<div class="modal-body">
									<!-- formulario -->
									<div class="form-body">
										<form class="form-horizontal" action='php/RegistroCarga.php' method="POST">
											<div class='form-group'>
												<label for='apellidos' class='col-sm-2 control-label'>Apellidos</label>
												<div class='col-sm-8'>
													<input type='text' class='form-control1' id='apellidos' name='apellidos' readonly="readonly" placeholder='Apellidos Estudiante' required maxlength='25' value="<?php echo $apellidos;?>">
												</div>
											</div>

											<div class='form-group'>
												<label for='nombres' class='col-sm-2 control-label'>Nombres</label>
												<div class='col-sm-8'>
													<input type='text' class='form-control1' id='nombres' name='nombres' readonly='readonly' placeholder='Nombres Estudiante' required maxlength='25' value="<?php echo $nombres;?>">
												</div>
											</div>

			                                <div class="form-group">
												<label for="id_grado" class="col-sm-2 control-label">Grado<span class="req">*</span></label>
												<div class="col-sm-8">
													<select id="id_grado" name="id_grado" class="form-control1" required>
												<?php 
													$sql="SELECT * FROM grados";
													$sqlgrado = mysqli_query($conexion, $sql);
													while ($fila=mysqli_fetch_array($sqlgrado)){
														echo '<option value="'.$fila['id'].'">'.$fila['grado'].'</option>';
													}

												?>
							              			</select>
												</div>
											</div>

			                                <div class="form-group">
												<label for="id_materia" class="col-sm-2 control-label">Materia<span class="req">*</span></label>
												<div class="col-sm-8">
													<select id="id_materia" name="id_materia" class="form-control1" required>
							              			</select>
												</div>
											</div>

											<input type="hidden" name="id_profesor" id="id_profesor" value="<?php echo $id; ?>">

											<div class="modal-footer">
		      									<input type="submit" class="btn btn-primary" value="Guardar Cambios">
		      								</div>
	      								</form> 
	   							 	</div>
	  							</div>
							</div>
						<!-- modal -->
						</div>
	       			</div>
	  			</div>
	  		</div>
	  	</div>
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
    
<!--     <script>-->
	<!-- combo materia -->
	<script type="text/javascript">
	$(document).ready(function(){
		$("#id_grado").change(function () {

			$("#id_grado option:selected").each(function () {
				id = $(this).val();
				$.post("combox.php", { id: id }, function(data){
					$("#id_materia").html(data);
				});            
			});
		})
	});
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