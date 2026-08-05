<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
?>
<!DOCTYPE HTML>
<html lang="es">
<head>
<title>Unicab Academic Registry</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style_thrive.css" rel='stylesheet' type='text/css' />

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

<?php require 'php/conexion.php';

	$peticion="SELECT * from profesores";
	$resultado = mysqli_query($conexion, $peticion);
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
                        <?php
							$id=$_GET['id'];
							$peticion34="SELECT * FROM profesores WHERE id=".$id." Limit 1";
							$resultado34 = mysqli_query($conexion, $peticion34);
							while ($fila = mysqli_fetch_array($resultado34)){
							$nombreCompleto=$fila['nombres']." ".$fila['apellidos']."";
							}
						 ?>
                        
                        
      <div class="well">
            <div class="row">
                <div class="col-md-8" id="redesFinal">
                    <?php echo "<h4><b>Are you sure you want to edit the data of: </h4><h3>". $nombreCompleto ."?</b></h3>" ?>
                </div>
                <div class="col-md-4" align="center">
                    <a href='#' class='btn btn-primary' data-toggle='modal' data-target='#myModal'  title='Edit teacher'>Confirm</a>
                </div>
            </div>
        </div>
                                        	
					    	<table id="listEstudiantes" class="display" style="width:100%">
					        <thead>
                            
					            <tr>
					                <!-- <th>Grado</th> -->
					                <th>Last Names</th>
					                <th>First Names</th>
                                    <th>Email</th>
					                <th>Identification</th>
                                    <th>Password</th>
					                <th>Actions</th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        	while ($fila = mysqli_fetch_array($resultado)){
									
					        		echo"<tr><td>".$fila['apellidos']."</td><td>".$fila['nombres']."</td><td>".$fila['email_institucional']."</td><td>".$fila['n_documento']."</td><td>".$fila['password']."</td>
					        		<td><a href='editar-docentes.php?id=".$fila['id']."' title='Editar Docente ".$fila['id']."'><i class='fa fa-pencil'></i></a></td>

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
						
                        $peticion = "SELECT * FROM profesores WHERE id =".$_GET['id']." LIMIT 1";
						$resultado2 = mysqli_query($conexion, $peticion);
						
						while ($fila = mysqli_fetch_array($resultado2)){
                      
					  	$id = $fila['id'];
						$apellidos = $fila['apellidos'];
						$nombres = $fila['nombres'];
						$n_documento = $fila['n_documento'];
						$email_institucional = $fila['email_institucional'];
						$d_pensamiento=$fila['d_pensamiento'];
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
   				 					<h4 class="modal-title">Edit Teacher:</h4>
			 					</div>
			 					<div class="modal-body">
								<!-- formulario -->
								<div class="form-body">
									<form class="form-horizontal" action='php/update-profesores-admin.php' method="POST">
										<div class='form-group'>
											<label for='apellidos' class='col-sm-2 control-label'>Last Names:<span class="req">*</span></label>
											<div class='col-sm-8'>
												<input type='text' class='form-control1' id='apellidos' name='apellidos' placeholder='Student Last Names' required maxlength='25' value="<?php echo $apellidos;?>">
											</div>
										</div>

										<div class='form-group'>
											<label for='nombres' class='col-sm-2 control-label'>First Names:<span class="req">*</span></label>
											<div class='col-sm-8'>
												<input type='text' class='form-control1' id='nombres' name='nombres'  placeholder='Student First Names' required maxlength='25' value="<?php echo $nombres;?>">
											</div>
										</div>

										<div class='form-group'>
											<label for='n_documento' class='col-sm-2 control-label'>Identification:<span class="req">*</span></label>
											<div class='col-sm-8'>
												<input type='text' class='form-control1' id='n_documento' name='n_documento' placeholder='Document Number' required maxlength='15' value="<?php echo $n_documento;?>">
											</div>
										</div>

										<div class='form-group'>
											<label for='email_institucional' class='col-sm-2 control-label'>Institutional Email:<span class="req">*</span></label>
											<div class='col-sm-8'>
												<input type='email' class='form-control1' id='email_institucional' name='email_institucional' placeholder='Email Institucional' required maxlength='50' value="<?php echo $email_institucional;?>">
											</div>
										</div>
										<div class="form-group">
											<label for="pensamiento" class="col-sm-2 control-label">Thought Area:<span class="req">*</span></label>
											<div class="col-sm-8">
												<select id="pensamiento" name="pensamiento" class="form-control1">
													<option value="<?php echo $d_pensamiento; ?>"><?php echo $d_pensamiento; ?></option>
													<option value="">NINGUNO</option>
						                		 	<option value="HUMANÍSTICO">HUMANÍSTICO</option>
						                			<option value="BIOETICO">BIOETICO</option>
						              			</select>
											</div>
										</div>
										 <div class='form-group'>
											<label for='password' class='col-sm-2 control-label'>Password:<span class="req">*</span></label>
											<div class='col-sm-8'>
												<input type='text' class='form-control1' id='password' name='password' placeholder='Enter new password' required  maxlength='15' value="<?php echo $password;?>">
											</div>
										</div>
										<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
										<div class="modal-footer">
	      									<input type="submit" class="btn btn-primary" value="Save Changes">
	      								</div>
      								</form> 
   							 	</div>
  							</div>
						</div>
					<!-- modal -->
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
</body>
<?php 
}
else{
	echo "<script>alert('You must log in');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>