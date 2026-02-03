<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila0 = mysqli_fetch_array($res)){
	  	$id = $fila0['id'];
		$apellidos  = $fila0['apellidos'];
		$nombres = $fila0['nombres'];
		$email_institucional = $fila0['email'];
		$director=$fila0['d_pensamiento'];
		$n_documento = $fila0['n_documento'];
		$password = $fila0['pc'];
		$perfil = $fila0['perfil'];
	}
    
	/*$peticion = "SELECT *,estudiantes.nombres 
	FROM matricula INNER JOIN estudiantes ON estudiantes.id=matricula.id_estudiante INNER JOIN grados ON grados.id=matricula.id_grado WHERE idMatricula =".$_GET['id']." LIMIT 1";*/
	$peticion = "SELECT m.*, e.nombres, e.apellidos, g.grado, g.id, e.email_institucional   
	FROM matricula m INNER JOIN estudiantes e ON e.id = m.id_estudiante INNER JOIN grados g ON g.id = m.id_grado WHERE m.idMatricula = ".$_GET['id']." LIMIT 1";
	$resultado2 = mysqli_query($conexion, $peticion);
						
	while ($fila = mysqli_fetch_array($resultado2)){
  		
  		$nombreE=$fila['apellidos']." ".$fila['nombres'];
	  	$id_matricula = $fila['idMatricula'];
		$n_matricula = $fila['n_matricula'];
		$fecha_ingreso = $fila['fecha_ingreso'];
		$estado = $fila['estado'];
		$id_estudiante = $fila['id_estudiante'];
		$id_grado = $fila['id_grado'];
		$grado = $fila['grado'];
		$email_est = $fila['email_institucional'];
    }
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
    .editar {
        background: #E0F8E6;
    }
</style>

<script type="text/javascript">
	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
        }
	}	
	
	function validar_email(id, desc) {
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var input_email = document.getElementById(id);
            var patron = /^[_-\w.]+@[a-z]+\.[a-z]{2,5}$/;
            var esCoincidente = patron.test($(id_obj).val());
            if(esCoincidente) {
                input_email.setCustomValidity("");
                $("#msgemail").html("");
                //$(ctr_obj).val(0);
                $("#btnsubmit").show();
            }
            else {
                input_email.setCustomValidity("No es un patrón de correo válido");
                var texto = "No es un patrón de correo válido para " + desc;
                //alert(texto);
                $("#msgemail").html(texto).css("color","red");
                //$(ctr_obj).val(1);
                control = 1;
                $("#btnsubmit").hide();
            }
        }
</script>

</head> 
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
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Matrícula Número #: <?php echo $n_matricula; ?></h4>
						</div>
						<div class="form-body">
							<form class="form-horizontal" action="php/update-matricula.php" method="POST">
								<div class="form-group">
									<label for="apellidos" class="col-sm-2 control-label">Estudiante:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="apellidos" value="<?php echo $nombreE; ?>" readonly="">
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="n_matricula" class="col-sm-2 control-label">Número Matricula:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="n_matricula" name="n_matricula" placeholder="001-2018-1G" required maxlength="25" readonly value="<?php echo $n_matricula ?>">
									</div>
								</div>

								<div class="form-group">
									<label for="fecha_ingreso" class="col-sm-2 control-label">Fecha Ingreso:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="date" class="form-control1 editar" id="fecha_ingreso" name="fecha_ingreso" required maxlength="25" autofocus value="<?php echo $fecha_ingreso ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label for="grado" class="col-sm-2 control-label">Grado:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="grado" name="grado" required maxlength="25" readonly value="<?php echo $grado ?>">
									</div>
								</div>
								
								<div class="form-group">
									<label for="email_est" class="col-sm-2 control-label">Email institucional:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1 editar" id="email_est" name="email_est" required maxlength="50" value="<?php echo $email_est ?>" onkeyup="validar_email('email_est', 'Email institucional');">
										<label id="msgemail"></label>
									</div>
								</div>
								
								<div class="form-group">
									<label for="est_actual" class="col-sm-2 control-label">Estado actual:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="est_actual" name="est_actual" required maxlength="25" readonly value="<?php echo $estado ?>">
									</div>
								</div>

								<input type="hidden" value="<?php echo $id_estudiante; ?>" id="id_estudiante" name="id_estudiante">
								<input type="hidden" value="<?php echo $id_grado; ?>" id="grado_actual" name="grado_actual">
								<input type="hidden" value="<?php echo $id_matricula; ?>" id="id_matricula" name="id_matricula">

								<!--<div class="form-group">
									<label for="id_grado" class="col-sm-2 control-label">Grado a cursar:<span class="req">*</span></label>
										<div class="col-sm-8">
											<select id="id_grado" name="id_grado" class="form-control1" required="">
												<option value="<?php echo $id_grado; ?>"><?php echo $grado; ?></option>
											<?php 
												$sqlgrado="SELECT id, grado FROM grados";
												$repeticiongrado=mysqli_query($conexion,$sqlgrado);
												while ($fila=mysqli_fetch_array($repeticiongrado)){
													//echo "<option value=".$fila['id'].">".$fila['grado']."</option>";
												}
											?>
				              				</select>
										</div>
								</div>-->
								<div class="form-group">
									<label for="sel_estado" class="col-sm-2 control-label">Nuevo estado:<span class="req">*</span></label>
										<div class="col-sm-8">
											<select id="sel_estado" name="sel_estado" class="form-control1 editar" required="">
											    <option value='NA' selected>Seleccione estado</option>
										        <option value='activo'>activo</option>
										        <option value='inactivo'>inactivo</option>
										        <option value='retirado'>retirado</option>
				              				</select>
										</div>
								</div>
								<hr>

							    <button type="submit" class="btn btn-primary" id="btnsubmit">
							      <span class="fa fa-save"></span> Guardar Cambios
							    </button>
							    
							    <a href="lista-matricula.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							</form> 
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
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>