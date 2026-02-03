<?php 
session_start();
include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniprofe'])) {
		$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
		$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
		$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email_institucional'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['password'];
	}
?>
<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
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
<style>
#chartdiv {
  width: 100%;
  height: 295px;
}
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php require 'menu.php';  ?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->

		<!-- main content start-->
        <section>
        	<div id="page-wrapper">
			<div class="main-page">
				<div class="tables">
					<div class="panel-body widget-shadow">
						<form class="form-horizontal" action="registrar-direccion.php"  method="POST" onsubmit="return validacion()">
							<div class="alert alert-success" role="alert">
  								<strong>Warning: </strong>Las notas que a continuación ingrese seran:
							</div>							
							<div class="form-group">
								<label  class="col-sm-2 control-label">Grado<span class="req">*</span></label>
								<div class="col-sm-8">
									<select id="id_grado" name="id_grado" class="form-control1" required>
										<option value='0'>Seleccionar Grado</option>
										<?php 
											$sql="SELECT distinct profesores.id, profesores.apellidos, profesores.nombres, grados.id, grados.grado FROM grados INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) ON grados.id = carga_profesor.id_grado where profesores.id=".$id." ORDER BY grados.id ASC";
											$consulta=mysqli_query($conexion,$sql);
											while ($fila=mysqli_fetch_array($consulta)){
												if ($fila['id']<=12) {
													echo '<option value="'.$fila['id'].'">'.$fila['grado'].'</option>';
												}
											}
										?>
			              			</select>
								</div>
							</div>                            
                            <div class="form-group">
								<label for="pensamiento" class="col-sm-2 control-label">Pensamiento:<span class="req">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="pensamiento" name="pensamiento" 
								value="<?php echo $director;?>" readonly="readonly">
								</div>
							</div>
							<div class="modal-footer">
								<input type="submit" class="btn btn-primary" value="Buscar Grado" title="Buscar Grado">
							</div>
							<div class="alert alert-info" role="alert" id="alert" style="display:none; margin-top: 20px;"></div>
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
		<script type="text/javascript">
	$(document).ready(function(){
		$("#id_grado").change(function () {
			
			$("#id_grado option:selected").each(function () {
				id_grado = $(this).val(),
				$.post("combox2.php", { id_grado: id_grado}, function(data){
					$("#id_materia").html(data);
				});            
			});
		})
	});
</script>
<!-- validar combo periodo -->
<script type="text/javascript">
	function validacion() {
		var grado=document.getElementById('id_grado').value;
		if (grado>=0 && grado<=1) {
			$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar un grado valido</center>').slideDown(500);
			return false;
		}else{
			$('#alert').html('').slideUp(300);
		}
	}
</script>
<!-- // validar combo periodo -->
</body>
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>