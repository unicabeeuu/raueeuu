 <?php 
 	session_start();
	require "../adminunicab/php/conexion.php";
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
			$perfil = $fila['perfil'];
		}
		
		// imagen 
		$imagen=$_FILES['ImagenA']['name'];
		$ruta=$_FILES['ImagenA']['tmp_name'];
		$tipo_archivo =$_FILES['ImagenA']['type'];
		$destino="../../assets/img/imgblog/".$imagen;
		copy($ruta, $destino);
		// imagen
		
		$destino1="../../../assets/img/imgblog/".$imagen;
		$ruta_final = '<img src="'.$destino1.'" width="600" class="img-fluid"/>';
		//echo $ruta_final;
		
?>

<!DOCTYPE HTML>
<html>
	<head>
	<title>Unicab Registro Académico</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	 <!-- Favicon -->
	<link rel="shortcut icon" href="../images/favicon.png" />
	<!-- // Favicon -->
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
	</head>

	<body class="cbp-spmenu-push">	
		<div class="main-content">
			<?php 
				if($id == 18) {
				require 'menu_adm.php';
				}
				else {
					//require 'menu.php';
					require 'menu_tutores.php';
				}  
			?>
		
			<?php require 'header.php';  ?>
			
			<!-- modal -->
			<section>
				<?php require 'modal.php';  ?>
			</section>
			<!-- modal -->
			
			<section>
				<div id="page-wrapper">
					<div class="forms">
						<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Subir imagen para blog:</h4>
							</div>
							<div class="form-body">
								<p>Copie el contenido siguiente en el lugar que corresponda dentro de la información complementaria del Blog.</p><br>
								<span>&lt;img src="../../../assets/img/imgblog/<?php echo $imagen; ?>" width="600" class="img-fluid"/&gt;</span><br><br>
								<a href="imagen_putdat.php">Cargar otra imagen</a>
							</div>
							
							<br>
							<div class="form-body">
								<p>Etiqueta logo conectados.</p><br>
								<img src="../../../assets/img/imgblog/pie_conectados.jpg" width="600" /><br>
								<span>&lt;img src="../../../assets/img/imgblog/pie_conectados.jpg" width="600" class="img-fluid"/&gt;</span>
							</div>
							
						</div>
					</div>
				</div>
			</section>        	
			<!--footer-->
			<?php require 'footer.php'; ?>
			<!--//footer-->
		</div>
	</body>
	
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
	
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>