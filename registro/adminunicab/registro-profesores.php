<?php
session_start();
require "php/conexion.php";
require("../docenteunicab/updreg/1cc3s4db.php");

$sql_depen = "SELECT * FROM tbl_dependencias";
$resul_depen=$mysqli1->query($sql_depen);

$sql_cargo = "SELECT * FROM tbl_cargos";
$resul_cargo=$mysqli1->query($sql_cargo);

if (isset($_SESSION['unisuper'])) {
    
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Matricula</title>
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
    <script>
        $(function () {
            $("#dependencia").change(function() {
                var depen = $("#dependencia option:selected").text();
                $("#txtdepen").val(depen);
        	});
        	
        	$("#cargo").change(function() {
                var cargo = $("#cargo option:selected").text();
                $("#txtcargo").val(cargo);
        	});
        });
    </script>

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
			<div class="main-page">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Registro Empleado:</h4>
						</div>
						<div class="form-body">
							<form class="form-horizontal" action="php/registroProfesores.php" method="POST">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Apellidos:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="apellidos" name="apellidos" placeholder="Apellidos" required autofocus="">
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Nombres:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="nombres" name="nombres" required placeholder="Nombres">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Correo Institucional:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="email" class="form-control1" id="email" name="email" required placeholder="Correo">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Identificación:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="n_documento" name="n_documento" required placeholder="No. documento">
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
						              <input type="hidden" id="txtdepen" name="txtdepen"/>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Skype:</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="skype" name="skype" required placeholder="Skype">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Celular:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="celular" name="celular" required placeholder="Celular">
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
						              <input type="hidden" id="txtcargo" name="txtcargo"/>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Profesión:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="profesion" name="profesion" required placeholder="Profesión">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Descripción:</label>
									<div class="col-sm-8">
										<textarea class="form-control1xxx" id="descripcion" name="descripcion" required placeholder="Descripción" rows="6" cols="82"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Nombre corto:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="nombrec" name="nombrec" required placeholder="Primer nombre y primer apellido">
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Password:<span class="req">*</span></label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" id="pass" name="pass" required placeholder="Password">
									</div>
								</div>
								<hr>
								<button type="submit" class="btn btn-primary">
						      		<span class="fa fa-save"></span> Guardar Información
						    	</button>
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