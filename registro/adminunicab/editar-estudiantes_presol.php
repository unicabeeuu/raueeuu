<?php
	session_start();
	require "php/conexion.php";
	if (isset($_SESSION['unisuper'])) {
	    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
    	$res=mysqli_query($conexion,$sql);
    
    	while ($fila0 = mysqli_fetch_array($res)){
    	  	$id_emp = $fila0['id'];
    		$apellidos_emp  = $fila0['apellidos'];
    		$nombres_emp = $fila0['nombres'];
    		$email_institucional_emp = $fila0['email'];
    		$director=$fila0['d_pensamiento'];
    		$n_documento_emp = $fila0['n_documento'];
    		$password_emp = $fila0['pc'];
    		$perfil = $fila0['perfil'];
    	}
	    
		$sql_estudiante="SELECT e.*, td.id idtd, td.tipo_documento tipo_documento1, m.estado estado_m 
		FROM `estudiantes` e, tbl_tipos_documento td, matricula m 
		WHERE e.tipo_documento = td.id AND e.id = m.id_estudiante AND e.id = ".$_GET['id']." AND m.estado = 'pre_solicitud' AND m.n_matricula like '%2022%'";
		$exe_estudiante=mysqli_query($conexion,$sql_estudiante);

		while ($fila = mysqli_fetch_array($exe_estudiante)) {
			$id = $fila['id'];
			$apellidos = $fila['apellidos'];
			$nombres = $fila['nombres'];
			$genero = $fila['genero'];
			$idtd=$fila['idtd'];
			$tipo_documento=$fila['tipo_documento1'];
			$n_documento = $fila['n_documento'];
			$fecha_nacimiento = $fila['fecha_nacimiento'];
			$expedicion=$fila['expedicion'];
			$ciudad = $fila['ciudad'];
			$direccion = $fila['direccion'];
			$direccion_estudiante = $fila['direccion_estudiante'];
			$email_institucional = $fila['email_institucional'];
			$actividad_extra = $fila['actividad_extra'];
			$email_acudiente_1 = $fila['email_acudiente_1'];
			$email_acudiente_2 = $fila['email_acudiente_2'];
			$acudiente_1 = $fila['acudiente_1'];
			$documento_acu = $fila['documento_responsable'];
			$acudiente_2 = $fila['acudiente_2'];
			$telefono_acudiente_1 = $fila['telefono_acudiente_1'];
			$telefono_acudiente_2 = $fila['telefono_acudiente_2'];
			$rh = $fila['estado'];
			$estado = $fila['estado_m'];
			$password = $fila['password'];
			$mensaje=$fila['mensaje'];
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

<script type="text/javascript">
	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
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
							<h4>Información Estudiante: <?php echo $nombres." ".$apellidos; ?></h4>
						</div>
						<div class="form-body">
							<form class="form-horizontal" action="php/update-estudiante-presol.php" method="POST">
								<div class="form-group">
									<label for="apellidos" class="col-sm-2 control-label">Apellidos:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="apellidos" name="apellidos" placeholder="Apellidos Estudiante" required maxlength="25" value="<?php echo $apellidos;?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="nombres" class="col-sm-2 control-label">Nombres:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="nombres" name="nombres"  placeholder="Nombres Estudiante" required maxlength="25" value="<?php echo $nombres;?>" readonly>
									</div>
								</div>

								<div class="form-group">
									<label for="tDocumento" class="col-sm-2 control-label">Tipo Documento:<span class="req">*</span></label>
									<div class="col-sm-8">
										<select id="tDocumento" name="tDocumento" class="form-control1" disabled>
											<option value="<?php echo $idtd; ?>"><?php echo $tipo_documento; ?></option>
				                		 	<option value="2">REGISTRO CIVIL</option>
							                <option value="1">TARJETA DE IDENTIDAD</option>
						                 	<option value="3">CEDULA</option>
							                <option value="4">PASAPORTE</option>
							                <option value="5">PERMISO ESPECIAL DE PERMANENCIA</option>
				              			</select>
									</div>
								</div>
									
								<div class="form-group">
									<label for="n_documento" class="col-sm-2 control-label">Identificación:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="n_documento" name="n_documento" placeholder="Número Documento" required maxlength="15" value="<?php echo $n_documento;?>" readonly>
									</div>
								</div>

								<div class='form-group'>
									<label for='focusedinput' class='col-sm-2 control-label'>Estado:<span class="req">*</span></label>
									<div class='col-sm-8'>
										<select id='estado' name='estado' class='form-control1' required>
											<option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
									       	<option value='solicitud'>solicitud</option>
			              				</select>
									</div>
								</div>

								<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">

								<hr>

							    <button type="submit" class="btn btn-primary">
							      <span class="fa fa-save"></span> Guardar Cambios
							    </button>

							    <!--<button type="button" class="btn btn-primary">
							      <span class="fa fa-download"></span> Descargar
							    </button>-->

							    <a href="lista-estudiantes.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							</form> 
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