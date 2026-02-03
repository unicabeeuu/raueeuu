<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Administrador - Unicab Solutions</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />
<link href="../css/jquery.dataTables.min.css" rel='stylesheet' type='text/css' />
<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
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

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!-- menu -->
		<?php 
			require "include/header.php";
		?>
		<!-- menu -->
		
		<!-- header -->
		<?php 
			require "include/menu.php";
		?>
		<!-- header -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
					<div class="forms">
						<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
							<div class="form-title">
								<h4>Banner:</h4>	
							</div>
						</div>
					</div>
				<div class="tables">
					<div class="panel-body widget-shadow">
						<table id="example" class="display" style="width:100%">
					        <thead>
					            <tr>
					                <th><center>Texto 1</center></th>
					                <th><center>Texto 2</center></th>
					                <th><center>Descripci贸n</center></th>
					                <th><center>Acciones</center></th>
					            </tr>
					        </thead>
					        <tbody>
					        	<?php 
					        		$sql_banner="SELECT * FROM unicab_solutions.tbl_banner";
									$exe_banner=mysqli_query($conexion,$sql_banner);

					        		while ($rowBanner=mysqli_fetch_array($exe_banner)) {
					        			echo "
					        			<tr>
					        				<td>".$rowBanner['titulo'].' '.$rowBanner['subtitulo']."</td>
					        				<td>".$rowBanner['titulo2'].' '.$rowBanner['subtitulo2']."</td>
					        				<td>".$rowBanner['descripcion']."</td>		
					        				<td><center>
					        				<a href='editar-banner_us.php?id=".$rowBanner['id']."'><i class='fa fa-pencil' aria-hidden='true'> Editar</i></a> | 
					        				<a href='php/eliminarBanner_us.php?id=".$rowBanner['id']."'><i class='fa fa-trash' aria-hidden='true'> Borrar</i></a></center> 
					        				</td>
					        			</tr>
					        			";
					        		}
					        		mysqli_close($conexion);
					        	?>
					        </tbody>
					        <tfoot>
					            <tr>
					                <th><center>Texto 1</center></th>
					                <th><center>Texto 2</center></th>
					                <th><center>Descripci贸n</center></th>
					                <th><center>Acciones</center></th>
					            </tr>
					        </tfoot>
				    	</table>
				    
					</div>

				</div>
			</div>
		</div>
		<!--footer-->
		<?php 
			require 'include/footer.php';
		?>
        <!--//footer-->
	</div>
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
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
	
	<!-- Bootstrap Core JavaScript -->
	<script src="../js/bootstrap.js"> </script>

	<script src="../js/jquery-3.3.1.js"> </script>
	<script src="../js/jquery.dataTables.min.js"> </script>
	<script type="text/javascript">
		$(document).ready(function() {
	    	$('#example').DataTable();
		} );
	</script>

	<script type="text/javascript">
   		function Validar(){
			var categoria=document.getElementById('categoria').value;
			
			if (categoria==0) {
				$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar una categoria valida</center>').slideDown(500);
				return false;
			}else{
		   		$('#alert').html('').slideUp(300);			
			}
		}

   </script>
</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>