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
	/*$sql_matricula="SELECT estudiantes.id, estudiantes.apellidos, estudiantes.nombres, grados.id as 'id_grado', grados.grado, matricula.EstadoGrado 
	FROM estudiantes INNER JOIN matricula ON estudiantes.id=matricula.id_estudiante 
	INNER JOIN grados ON matricula.id_grado=grados.id WHERE `id_estudiante`=".$id_estudiante." ORDER BY idMatricula DESC LIMIT 1 ";*/
	$sql_matricula="SELECT estudiantes.id, estudiantes.apellidos, estudiantes.nombres, estudiantes.n_documento, estudiantes.email_institucional, 
	grados.id id_grado, grados.grado, matricula.EstadoGrado, matricula.n_matricula, matricula.fecha_ingreso  
	FROM estudiantes INNER JOIN matricula ON estudiantes.id=matricula.id_estudiante 
	INNER JOIN grados ON matricula.id_grado=grados.id WHERE `id_estudiante`=".$id_estudiante." ORDER BY idMatricula DESC LIMIT 1 ";
	$exe_matricula=mysqli_query($conexion,$sql_matricula);
	$total_matricula=mysqli_num_rows($exe_matricula);
	
	//Esto es nuevo
	while ($filaE=mysqli_fetch_array($exe_matricula)) {
	    $nombreE = $filaE['apellidos']." ".$filaE['nombres'];
	    $n_matriculaE = $filaE['n_matricula'];
	    $fechaingE = $filaE['fecha_ingreso'];
	    $gradoE = $filaE['grado'];
	    $idgradoE = $filaE['id_grado'];
	    $idestE = $filaE['id'];
	    $identifE = $filaE['n_documento'];
	    $emailE = $filaE['email_institucional'];
	}

	$sql="SELECT * FROM grados";
	$resultado = mysqli_query($conexion, $sql);
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	
	//Se consulta la cantidad de estudiantes por grupo
	$sql_grupoA = "SELECT COUNT(1) ct FROM matricula WHERE id_grado = $idgradoE AND grupo = 'A' 
    AND date_format(fecha_ingreso, '%Y') = $a";
    
    $exe_grupoA = mysqli_query($conexion,$sql_grupoA);
	while ($rowA = mysqli_fetch_array($exe_grupoA)){
	    $ctA = $rowA['ct'];
	}
	
	$sql_grupoB = "SELECT COUNT(1) ct FROM matricula WHERE id_grado = $idgradoE AND grupo = 'B' 
    AND date_format(fecha_ingreso, '%Y') = $a";
    
    $exe_grupoB = mysqli_query($conexion,$sql_grupoB);
	while ($rowB = mysqli_fetch_array($exe_grupoB)){
	    $ctB = $rowB['ct'];
	}
	
	$sql_grupoC = "SELECT COUNT(1) ct FROM matricula WHERE id_grado = $idgradoE AND grupo = 'C' 
    AND date_format(fecha_ingreso, '%Y') = $a";
    
    $exe_grupoC = mysqli_query($conexion,$sql_grupoC);
	while ($rowC = mysqli_fetch_array($exe_grupoC)){
	    $ctC = $rowC['ct'];
	}
	
	$sql_grupoD = "SELECT COUNT(1) ct FROM matricula WHERE id_grado = $idgradoE AND grupo = 'D' 
    AND date_format(fecha_ingreso, '%Y') = $a";
    
    $exe_grupoD = mysqli_query($conexion,$sql_grupoD);
	while ($rowD = mysqli_fetch_array($exe_grupoD)){
	    $ctD = $rowD['ct'];
	}

?>
<!DOCTYPE HTML>
<html lang="es">
<head><meta charset="gb18030">
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
    .editar {
        background: #E0F8E6;
    }
    .verde {
        color: green;
        font-weight: bold;
    }
    .azul {
        color: blue;
        font-weight: bold;
    }
    .naranja {
        color: orange;
        font-weight: bold;
    }
    .morado {
        color: purple;
        font-weight: bold;
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
		    else if($perfil == "AR1") {
		        require 'menu_registro_aux.php';
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
								<h4>Validar Matricula para: <?php echo $nombreE; ?></h4>
								<p><span class="verde">Grupo A: <?php echo $ctA; ?></span><span class="azul"> || Grupo B: <?php echo $ctB; ?></span><span class="naranja"> || Grupo C: <?php echo $ctC; ?></span><span class="morado"> || Grupo D: <?php echo $ctD; ?></span></p>
								<!--<p><?php echo $sql_grupoA; ?></p>-->
							</div>
							<div class="form-body">
								<!--<form class="form-horizontal" action="php/registroMatricula.php" method="POST">-->
								<form class="form-horizontal" action="php/registroMatricula_f.php" method="POST">
									
									<div class="form-group">
										<label for="n_matricula" class="col-sm-2 control-label">No. Matricula:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="n_matricula" name="n_matricula" placeholder="001-2018-1G" required maxlength="25" value="<?php echo $n_matriculaE; ?>" readonly>
										</div>
									</div>

									<div class="form-group">
										<label for="fecha_ingreso" class="col-sm-2 control-label">Fecha Ingreso:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="date" class="form-control1 editar" id="fecha_ingreso" name="fecha_ingreso" required maxlength="25" value="<?php echo $fechaingE; ?>" autofocus>
										</div>
									</div>
									
									<div class="form-group">
										<label for="identif" class="col-sm-2 control-label">Documento:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="identif" name="identif" required maxlength="25" value="<?php echo $identifE; ?>" readonly>
										</div>
									</div>
									
									<div class="form-group">
										<label for="idest" class="col-sm-2 control-label">Id Estudiante:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="idest" name="idest" required maxlength="25" value="<?php echo $idestE; ?>" readonly>
										</div>
									</div>
									
									<div class="form-group">
										<label for="grado" class="col-sm-2 control-label">Grado:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1" id="grado" name="grado" required maxlength="25" value="<?php echo $gradoE; ?>" readonly>
											<input type="hidden" class="form-control1" id="id_grado" name="id_grado" required value="<?php echo $idgradoE; ?>">
										</div>
									</div>
									
									<div class="form-group">
										<label for="email" class="col-sm-2 control-label">Email institucional:<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1 editar" id="email" name="email" required maxlength="50" value="<?php echo $emailE; ?>" >
										</div>
									</div>
									
									<div class="form-group">
										<label for="email" class="col-sm-2 control-label">Grupo (A, B, C, D):<span class="req">*</span></label>
										<div class="col-sm-8">
											<input type="text" class="form-control1 editar" id="grupo" name="grupo" required maxlength="50">
										</div>
									</div>

									<input type="hidden" value="<?php echo $id_estudiante ?>" id="id" name="id">

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