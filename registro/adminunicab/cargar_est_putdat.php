<?php
	session_start();
	//include "../../adminunicab/php/conexion.php";
	include "php/conexion.php";
	require("php/1cc3s4db.php");
	require("php/1cc3s4db_m.php");
	set_time_limit(600);
	
if (isset($_SESSION['unisuper'])) {

    $insertados = 0;
	$queryr0 = "Delete From tbl_estudiantes_mood_temp";
	$queryr00 = "Delete From tbl_estudiantes_mood";
	//$queryr1 = "SELECT * FROM tbl_estudiantes_mood_temp WHERE id NOT IN (SELECT id FROM tbl_estudiantes_mood)";
	$queryr1 = "SELECT * FROM tbl_estudiantes_mood_temp";
	
    $query = "SELECT DISTINCT u.id, cc.name, u.lastname, u.firstname, u.city, u.email, u.username  
		FROM mood_role_assignments ra, mood_user u, mood_context ct, mood_role r, mood_course c, mood_course_categories cc 
		WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id  
		AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.deleted = 0 AND cc.name NOT IN ('Psicología y Coordinación','Capacitación')
		ORDER BY cc.name, u.id";
	
	$resultado=$mysqli->query($query);
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
                    			    <?php
                    			        //echo $query;
										$resultado_0=$mysqli1->query($queryr0);
										$resultado_00=$mysqli1->query($queryr00);
										
										while($row = $resultado->fetch_assoc()){
											$query1="INSERT INTO tbl_estudiantes_mood_temp (id, grado, apellidos, nombres, ciudad, email_inst, usuario) 
											VALUES (".$row['id'].",'".$row['name']."','".$row['lastname']."','".$row['firstname']."','".$row['city']
											."','".$row['email']."','".$row['username']."')";
											$resultado_1=$mysqli1->query($query1);
											if($resultado_1 > 0) {
												//$insertados++;
											}
										}
										//echo $query1;
										
										$resultador1=$mysqli1->query($queryr1);
										while($row1 = $resultador1->fetch_assoc()){
											$query2="INSERT INTO tbl_estudiantes_mood (id, grado, apellidos, nombres, ciudad, email_inst, usuario) 
											VALUES (".$row1['id'].",'".$row1['grado']."','".$row1['apellidos']."','".$row1['nombres']."','".$row1['ciudad']
											."','".$row1['email_inst']."','".$row1['usuario']."')";
											$resultado_1=$mysqli1->query($query2);
											if($resultado_1 > 0) {
												$insertados++;
											}
											else {
											    $query21="UPDATE tbl_estudiantes_mood SET grado = '".$row1['grado']."' WHERE id = ".$row1['id'];
										        //echo $query21;
										        $resultado_21=$mysqli1->query($query21);
    											if($resultado_21 > 0) {
    												//$insertados++;
    											}
											}
										}
										//echo $query2;
										if($insertados > 0) {
											echo "<label  class='col-sm-8 control-label'>Cargue exitoso de estudiantes de Moodle. Registros: ".$insertados."</label></br></br>";
											echo '<a href="adm1.php" ><button type="button" class="btn btn-primary">Volver</button></a>';
										}
										else {
											echo "<label  class='col-sm-8 control-label' style='color: red;'>No hay estudiantes nuevos de Moodle</label></br></br>";
											echo '<a href="adm1.php" ><button type="button" class="btn btn-primary">Volver</button></a>';
										}
									?>
								
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