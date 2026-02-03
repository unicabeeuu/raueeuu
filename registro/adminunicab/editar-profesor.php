<?php
session_start();
require "php/conexion.php";
require("../docenteunicab/updreg/1cc3s4db.php");
require("php/mcript.php");

$sql_depen = "SELECT * FROM tbl_dependencias";
$resul_depen=$mysqli1->query($sql_depen);

$sql_cargo = "SELECT * FROM tbl_cargos";
$resul_cargo=$mysqli1->query($sql_cargo);

if (isset($_SESSION['unisuper'])) {
    
	//$peticion="SELECT * from profesores WHERE id=".$_GET['id']."";
	$peticion="SELECT * from tbl_empleados WHERE id=".$_REQUEST['id']."";
	$resultado = mysqli_query($conexion, $peticion);

	while ($fila = mysqli_fetch_array($resultado)){              
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$email_inst = $fila['email'];
		$pc=$dev_enc($fila['pc']);					
		$perfil=$fila['perfil'];
		$depen=$fila['dependencia'];
		$skype=$fila['skype'];
		$celular=$fila['celular'];
		$cargo=$fila['cargo'];
		$profesion=$fila['profesion'];
		$desc=str_replace("<br />","",nl2br($fila['descripcion']));
		$nombrec=$fila['nombre_corto'];
    }
    echo $email;
    
    //Se busca el id de la dependencia
    $sql_iddepen = "SELECT id FROM tbl_dependencias WHERE dependencia = '$depen'";
    $res_iddepen = mysqli_query($conexion, $sql_iddepen);

	while ($fila1 = mysqli_fetch_array($res_iddepen)){
	    $iddepen=$fila1['id'];
	}
	
	//Se busca el id del cargo
    $sql_idcargo = "SELECT id FROM tbl_cargos WHERE cargo = '$cargo'";
    $res_idcargo = mysqli_query($conexion, $sql_idcargo);

	while ($fila2 = mysqli_fetch_array($res_idcargo)){
	    $idcargo=$fila2['id'];
	}
?>
<!DOCTYPE HTML>
<html lang="es">
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

<script type="text/javascript">
    $(function () {
        $("#dependencia option[value="+ <?php echo $iddepen; ?> +"]").attr("selected",true);
        $("#cargo option[value="+ <?php echo $idcargo; ?> +"]").attr("selected",true);
        
        $("#dependencia").change(function() {
            var depen = $("#dependencia option:selected").text();
            $("#txtdepen").val(depen);
    	});
    	
    	$("#cargo").change(function() {
            var cargo = $("#cargo option:selected").text();
            $("#txtcargo").val(cargo);
    	});
    });
    
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
		<?php require 'menu.php';  ?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		<!-- main content start-->
       	<div id="page-wrapper">
			<div class="forms">
				<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
					<div class="form-title">
						<h4>Información Empleado: <?php echo $nombres." ".$apellidos; ?></h4>
					</div>

					<div class="form-body">
						<form class="form-horizontal" action='php/update-profesores-admin.php' method="POST">
							<div class='form-group'>
								<label for='apellidos' class='col-sm-2 control-label'>Apellidos:<span class="req">*</span></label>
								<div class='col-sm-8'>
									<input type='text' class='form-control1' id='apellidos' name='apellidos' placeholder='Apellidos Estudiante' required value="<?php echo $apellidos;?>">
								</div>
							</div>

							<div class='form-group'>
								<label for='nombres' class='col-sm-2 control-label'>Nombres:<span class="req">*</span></label>
								<div class='col-sm-8'>
									<input type='text' class='form-control1' id='nombres' name='nombres'  placeholder='Nombres Estudiante' required value="<?php echo $nombres;?>">
								</div>
							</div>

							<div class='form-group'>
								<label for='email_institucional' class='col-sm-2 control-label'>Correo Institucional:<span class="req">*</span></label>
								<div class='col-sm-8'>
									<input type='email' class='form-control1' id='email' name='email' placeholder='Correo' required value="<?php echo $email_inst;?>">
								</div>
							</div>

							<div class='form-group'>
								<label for='n_documento' class='col-sm-2 control-label'>Identificación:<span class="req">*</span></label>
								<div class='col-sm-8'>
									<input type='text' class='form-control1' id='n_documento' name='n_documento' placeholder='Número Documento' required value="<?php echo $n_documento;?>">
								</div>
							</div>

							<div class="form-group">
								<label for="pensamiento" class="col-sm-2 control-label">Dependencia:<span class="req">*</span></label>
								<div class="col-sm-8">
									<select id="dependencia" name="dependencia" class="form-control1">
						                <option value="NA" selected>SELECCIONE DEPENDENCIA</option>
						                <?php 
									        while($rowd = $resul_depen->fetch_assoc()){
									            echo "<option value='".$rowd['id']."'>".$rowd['dependencia']."</option>";
									        }
									    ?>
					              </select>
					              <input type="hidden" id="txtdepen" name="txtdepen" value="<?php echo $depen; ?>"/>
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Skype:</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="skype" name="skype" required placeholder="Skype" value="<?php echo $skype;?>">
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Celular:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="celular" name="celular" required placeholder="Celular" value="<?php echo $celular;?>">
								</div>
							</div>
							<div class="form-group">
								<label for="pensamiento" class="col-sm-2 control-label">Cargo:<span class="req">*</span></label>
								<div class="col-sm-8">
									<select id="cargo" name="cargo" class="form-control1">
						                <option value="NA" selected>SELECCIONE CARGO</option>
						                <?php 
									        while($rowc = $resul_cargo->fetch_assoc()){
									            echo "<option value='".$rowc['id']."'>".$rowc['cargo']."</option>";
									        }
									    ?>
					              </select>
					              <input type="hidden" id="txtcargo" name="txtcargo" value="<?php echo $cargo; ?>"/>
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Profesión:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="profesion" name="profesion" required placeholder="Profesión" value="<?php echo $profesion;?>">
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Descripción:</label>
								<div class="col-sm-8">
									<textarea class="form-control1xxx" id="descripcion" name="descripcion" required placeholder="Descripción" rows="6" cols="82"><?php echo $desc;?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Nombre corto:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="nombrec" name="nombrec" required placeholder="Primer nombre y primer apellido" value="<?php echo $nombrec;?>">
								</div>
							</div>
							<div class="form-group">
								<label for="focusedinput" class="col-sm-2 control-label">Password:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="pass" name="pass" required placeholder="Password" value="<?php echo $pc;?>">
								</div>
							</div>

							<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
							<hr>

						    <button type="submit" class="btn btn-primary">
						      <span class="fa fa-save"></span> Guardar Cambios
						    </button>
						    
						    <a href="lista-profesores.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
						</form> 
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
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>