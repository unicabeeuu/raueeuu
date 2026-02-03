<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);
    //echo $sql;
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
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $aant = $fanio - 1;
    
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
	where matricula.estado='activo' ORDER BY grados.grado";
	$gradoActual="Completo";
	}
 	if (isset($_POST["id_grado"])) {
	$peticion="SELECT estudiantes.id, estudiantes.apellidos,estudiantes.nombres,estudiantes.genero,estudiantes.n_documento,estudiantes.email_institucional, grados.grado 
	FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id= matricula.id_grado 
	where grados.id=".$_POST['id_grado']."  and matricula.estado='activo' ORDER BY grados.grado";
 	}
	// var_dump($peticion);
	echo $peticion;
	
	$res=mysqli_query($conexion,$peticion);
	
	while ($fila=mysqli_fetch_array($res)) {
		$gradoActual=$fila["grado"];
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
                    			<form  method="post">
                    				<div class="form-group">
										<label for="n_documento" class="col-sm-2 control-label">Número Documento:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="n_documento" name="n_documento" placeholder="Número Documento" required maxlength="15" autofocus="">
											</div>
									</div>
								  	<button type="submit" class="btn btn-default"><span style="color:#FFF" class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                    			</form>
								<hr>
								</div>
              		 		</div>
							<?php
							if (!isset($_POST['n_documento'])) {
								echo ' <div class="alert alert-danger" role="alert">
  									<strong>¡Advertencia!</strong> Debe ingresar un número de documento para realizar la búsqueda.
								</div>';
							}else{
								$numero_documento=$_POST['n_documento'];
								$buscar="SELECT id, apellidos, nombres FROM estudiantes where n_documento='".$numero_documento."'";
								$exe_buscar=mysqli_query($conexion,$buscar);
								$total_buscar=mysqli_num_rows($exe_buscar);
								if ($total_buscar>0) {
										while ($fila=mysqli_fetch_array($exe_buscar)) {
											$id=$fila['id'];
											$apellidos=$fila['nombres'];
											$nombres=$fila['apellidos'];
										}
									?>
									<!-- buscar certificado -->
									<div class="form-group">
										<form class="form-horizontal" action="certificado-final-grados_aanterior.php" method="POST">
											<div class="form-group">				
												<label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
												<div class="col-sm-8">
													<input type="text" readonly="readonly" class="form-control1" id="apellidos" name="apellidos" value="<?php echo $apellidos;?>">
												</div>
											</div>

											<div class="form-group">
												<label for="nombres" class="col-sm-2 control-label">Nombres</label>
												<div class="col-sm-8">
													<input type="text" readonly="readonly" class="form-control1" id="nombres" name="nombres" value="<?php echo $nombres;?>">
												</div>
											</div>
											<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

											<?php
										$sql_historial="SELECT estudiantes.id AS id_estudiante, estudiantes.apellidos, estudiantes.nombres, estudiantes.n_documento, 
										matricula.estado, matricula.idMatricula, matricula.EstadoGrado, grados.id AS id_grado, grados.grado, matricula.fecha_ingreso 
										FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) 
										ON grados.id = matricula.id_grado 
										WHERE estudiantes.n_documento='".$numero_documento."' and matricula.estado IN ('activo', 'retirado', 'aprobado', 'reprobado') 
										AND date_format(matricula.fecha_ingreso, '%Y') = $aant 
										ORDER By matricula.idMatricula ASC";
										//echo $sql_historial;
										
										$exe_historial=mysqli_query($conexion,$sql_historial);
										$total_historial=mysqli_num_rows($exe_historial);
										if ($total_historial>0) {
											?>
										<div class="form-group">
											<label for="nombres" class="col-sm-2 control-label">Seleccione grado:</label>
											<div class="col-sm-8">
												<select id="id_matricula" name="id_matricula" class="form-control1" required >
												<option value='0'>Seleccionar Grado</option>
												<?php
													while ($row=mysqli_fetch_array($exe_historial)) {
														$id_grado=$row['id_grado'];
														if ($row['EstadoGrado']=="reprobado") {
															echo '<option value="'.$row['idMatricula'].'" style="color:red;">'.$row['grado'].'</option>';
														}else{
															echo '<option value="'.$row['idMatricula'].'">'.$row['grado'].'</option>';
														}
														
								 					}
							 					?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label for="idioma" class="col-sm-2 control-label">Idioma:<span class="req">*</span></label>
											<div class="col-sm-8">
												<select id="idioma" name="idioma" class="form-control1" required>
									                <option value="espanol">Español</option>
									                <option value="ingles">Ingles</option>
								              </select>
											</div>
										</div>
										
										<div class="form-group">
											<label for="idioma" class="col-sm-2 control-label">Año Anterior:<span class="req">*</span></label>
											<div class="col-sm-8">
											    <input type="text" id="aant" name="aant" value="<?php echo $aant; ?>" readonly>
											</div>
										</div>
								
										<div class="form-group" style="display: none;">
											<label for="firmas" class="col-sm-2 control-label">Firmas:<span class="req">*</span></label>
											<div class="col-sm-8">
												<select id="firmas" name="firmas" class="form-control1" required>
									                <option value="SI" selected>SI</option>
									                <option value="NO">NO</option>
								              </select>
											</div>
										</div>
										<input type="hidden" id="n_documentof" name="n_documentof" value="<?php echo $numero_documento; ?>"/>
										
										 <div class="form-group" style="visibility: hidden;">
											<label for="id_grado" class="col-sm-2 control-label">Materia<span class="req">*</span></label>
											<div class="col-sm-8">
												<select id="id_grado" name="id_grado" class="form-control1" required>
						              			</select>
											</div>
										</div>
										
										

										<div class="modal-footer">
      										<input type="submit" class="btn btn-primary" value="Generar">
	      								</div>
										</form>
									</div>
										<?php
										}else{
											echo ' <div class="alert alert-danger" role="alert">
	  											<strong>¡Advertencia!</strong> El estudiante no cuenta con historial en algún grado.
											</div>';
										}
									}else{
										echo ' <div class="alert alert-danger" role="alert">
	  										<strong>¡Advertencia!</strong> no se han encontrado resultados.
										</div>';
									}
							}	
							?>
  		 				<!-- // buscar certificado -->
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
    
    <!-- prueba -->
    <script type="text/javascript">
		$(document).ready(function(){
			$("#id_matricula").change(function () {
				
				$("#id_matricula option:selected").each(function () {
					id_matricula = $(this).val(),
					$.post("cargardato.php", { id_matricula: id_matricula}, function(data){
						$("#id_grado").html(data);
					});            
				});
			})
		});
	</script>
    <!-- prueba -->
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>