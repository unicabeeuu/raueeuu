<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
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
    
	$id_estudiante=$_GET['id'];
	//buscar ultima matricula
	$sql_matricula="SELECT estudiantes.id, estudiantes.apellidos, estudiantes.nombres, grados.id as 'id_grado', grados.grado, matricula.EstadoGrado 
	FROM estudiantes INNER JOIN matricula ON estudiantes.id=matricula.id_estudiante 
	INNER JOIN grados ON matricula.id_grado=grados.id WHERE `id_estudiante`=".$id_estudiante." ORDER BY idMatricula DESC LIMIT 1 ";
	$exe_matricula=mysqli_query($conexion,$sql_matricula);
	$total_matricula=mysqli_num_rows($exe_matricula);
	//buscar ultima matricula

	$sql="SELECT * FROM grados";
	$resultado = mysqli_query($conexion, $sql);

?>
<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Unicab Registro Matricula</title>
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
<script type="text/javascript">
	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
        }
	}	
</script>
<body class="cbp-spmenu-push" onload="back_form();">
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
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		<!-- main content start-->
        <section>
           	<div id="page-wrapper">
				<div class="main-page">
					<div class="forms">
						<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Validar Matricula:</h4>
							</div>
							<div class="form-body">
								<form class="form-horizontal" action="php/registroMatricula.php" method="POST">
									
									<div class="form-group">
										<label for="n_matricula" class="col-sm-2 control-label">Número Matricula:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="n_matricula" name="n_matricula" placeholder="001-2018-1G" required maxlength="25" autofocus>
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_ingreso" class="col-sm-2 control-label">Fecha Ingreso:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="date" class="form-control1" id="fecha_ingreso" name="fecha_ingreso" required maxlength="25">
										</div>
									</div>

									<input type="hidden" value="<?php echo $id_estudiante ?>" id="id" name="id">

	                                <div class="form-group">
										<label for="id_grado" class="col-sm-2 control-label">Grado a cursar:<span class="req">*</span></label>
										<div class="col-sm-8">
											<select id="id_grado" name="id_grado" class="form-control1" required>
											<?php 
												if ($total_matricula>=1) {
													while ($filaE=mysqli_fetch_array($exe_matricula)) {
														$actualizar_grado=$filaE['id_grado'];
														//grados
														if ($filaE['id_grado']>=1 && $filaE['id_grado']<=12) {
															if ($filaE['EstadoGrado']=="reprobado") {
																echo '<option value="'.$filaE['id_grado'].'">'.$filaE['grado'].'</option>';
															}else{
																$actualizar_grado++;
																$buscar_grado="SELECT * FROM `grados` WHERE `id`=".$actualizar_grado."";
																$exe_buscar=mysqli_query($conexion,$buscar_grado);
																while ($rowGrado = mysqli_fetch_array($exe_buscar)) {
																	echo '<option value="'.$rowGrado['id'].'">'.$rowGrado['grado'].'</option>';	
																}
															}
														}
														//ciclos
														if($filaE['id_grado']>=13 && $filaE['id_grado']<=18) {
															if ($filaE['EstadoGrado']=="reprobado") {
																echo '<option value="'.$filaE['id_grado'].'">'.$filaE['grado'].'</option>';
															}else{
																$actualizar_grado++;
																$buscar_grado="SELECT * FROM `grados` WHERE `id`=".$actualizar_grado."";
																echo $buscar_grado;
																$exe_buscar1=mysqli_query($conexion,$buscar_grado);
																while ($rowGrado = mysqli_fetch_array($exe_buscar1)) {
																	echo '<option value="'.$rowGrado['id'].'">'.$rowGrado['grado'].'</option>';	
																}
															}
														}
														//ciclos
													}
												}else{
													while ($fila=mysqli_fetch_array($resultado)){
													echo '<option value="'.$fila['id'].'">'.$fila['grado'].'</option>';
													}
												}
											?>
							              </select>
										</div>
									</div>
									<button type="submit" class="btn btn-primary">Guardar</button>
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