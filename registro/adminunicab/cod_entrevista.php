<?php
	session_start();
	//include "../../adminunicab/php/conexion.php";
	include "php/conexion.php";
	//require("1cc3s4db.php");
	
if (isset($_SESSION['unisuper'])) {

    $codigo = "";
	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
            "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
	
	for($i = 1; $i <=10; $i++) {
		$ale=mt_rand(1,sizeof($sa1));
		$codigo = $codigo.$sa1[$ale-1];
	}
	//echo $codigo;
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$a = date("Y",$fecha);
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

<script type="text/javascript" src="js/reg.js"></script>

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
#identif, #buscar {
    border: none;
    border-bottom: 2px solid green;
}
</style>
<script>
    $(function() {
        //alert("hola");
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
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	 
                    			<div class="form-body">
                    			    <?php //echo $id; ?>
                    			    <?php //echo $_SESSION['uniprofe']; ?>
									<form class="form-horizontal" action="cod_entrevista1.php"  method="POST" onsubmit="return validacion()">
										<div class="form-group">
											<label  class="col-sm-2 control-label">Identificación<span class="req">*</span></label>
											<div class="col-sm-8">
												<input type="text" id="identif" name="identif" placeholder="Ingrese identificación" />
											</div>
										</div>
										<div class="form-group">
											<label  class="col-sm-2 control-label">Año<span class="req">*</span></label>
											<div class="col-sm-8">
												<input type="text" id="periodo" name="periodo" value="<?php echo $a; ?>" />
											</div>
										</div>
										<div class="form-group">
											<label  class="col-sm-2 control-label">Codigo<span class="req">*</span></label>
											<div class="col-sm-8">
												<input type="text" id="codigo" name="codigo" value="<?php echo $codigo; ?>" style="background: lightgreen;" readonly/>
											</div>
										</div>
										<div class="modal-footer">
											<input type="submit" class="btn btn-primary" value="Generar codigo">
										</div>
									</form>								
								</div>
								<div class="form-body">
									<!--Este código muestra la opción de mostrar buscar códgigo ... hasta antes del form -->
                                    <span class="temp" style="background: #355A84; color: #fff; font-size: 18px;">*** Buscar código ***</span>
									<a href="#" id="mostrarmod" class="temp" style="text-decoration: none; display: inline-block; border-radius: 50%;"> 
                                	<span style="color: #355A84; transform: translate(-50%, -50%); font-size: 40px; font-weight: 600;">+</span> </a>
									<form class="form-horizontal" method="POST" id="modal" style="display: none; transition: all .5s;">
										<!--Este código muestra la opción de ocultar buscar códgigo ... hasta antes del div -->
        							    <a href="#" id="cerrarmod" 
                                			style="display: block; text-decoration: none; position: relative;"> 
                                			<span style="color: #355A84; position: absolute; left: 100%; transform: translate(-50%, -50%); font-size: 24px; font-weight: 600;">X</span> 
                                		</a>
										<div class="form-group">
											<label  class="col-sm-2 control-label">Buscar<span class="req"></span></label>
											<div class="col-sm-8">
												<input type="text" id="buscar" name="buscar" placeholder="Ingrese identificación" />
											</div>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-primary" onclick="buscar_codigo();">Buscar</button>
										</div>
										<div id="divresul"></div>
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

	<!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
	
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>