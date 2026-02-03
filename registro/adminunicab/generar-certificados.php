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
	}
    
        
$id_estudiante=$_GET['id'];
$buscar_grado="SELECT estudiantes.id, estudiantes.apellidos, estudiantes.nombres, grados.id as id_grado, grados.grado 
FROM grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id = matricula.id_grado 
WHERE estudiantes.id=".$id_estudiante."";
$exe_buscar=mysqli_query($conexion,$buscar_grado);
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
		    if($id == 18 || $id == 3) {
		        require 'menu_registro.php';
		    }
		    else if($id == 43) {
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
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Certificado Estudiantil</h4>
						</div>
						<div class="form-body">
							<form class="form-horizontal" action="certificado-final.php" method="POST">
								<div class="form-group">
									<label for="tipo_certificado" class="col-sm-2 control-label">Certificado:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="tipo_certificado" name="tipo_certificado" class="form-control1" required>
											<option value="Estudio">Estudio</option>
											<!--<option value="Notas">Notas</option>-->
									  </select>
									</div>
								</div>
								<?php
								while ($row=mysqli_fetch_array($exe_buscar)) {
									if ($row['id_grado']>=13) {
										?>
										<div id="select_periodo" style="display: none">
											<div class="form-group">
												<label for="periodo" class="col-sm-2 control-label">Periodo:<span class="req">*</span></label>
												<div class="col-sm-8">
													<select id="periodo" name="periodo" class="form-control1" required>
														<option value="1">1</option>
														<option value="2">2</option>
												  </select>
												</div>
											</div>
										</div>
										<?php
									}else{
										?>
										<div id="select_periodo" style="display: none">
										<div class="form-group">
											<label for="periodo" class="col-sm-2 control-label">Periodo:<span class="req">*</span></label>
											<div class="col-sm-8">
												<select id="periodo" name="periodo" class="form-control1" required>
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
													<option value="4">4</option>
											  </select>
											</div>
										</div>
									</div>
									<?php
									}
								}
								?>
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
									<label for="firmas" class="col-sm-2 control-label">Firmas:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="firmas" name="firmas" class="form-control1" required>
											<option value="SI">SI</option>
											<option value="NO">NO</option>
									  </select>
									</div>
								</div>

								<input type="hidden" value="<?php echo $id_estudiante?>" id="id_estudiante" name="id_estudiante">
								<button type="submit" class="btn btn-primary">Generar</button>
							</form> 
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
	<script type="text/javascript">
		$('#tipo_certificado').change(function(){
    var valorCambiado =$(this).val();
    if((valorCambiado == 'Estudio')){
       $('#select_periodo').hide();
       
     }
     if (valorCambiado=='Notas') {
     	$('#select_periodo').show();
     }
});
	</script>
		
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
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>