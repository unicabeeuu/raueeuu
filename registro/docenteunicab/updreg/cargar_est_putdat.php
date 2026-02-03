<?php
	session_start();
	include "../../adminunicab/php/conexion.php";
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	set_time_limit(600);
	
if (isset($_SESSION['uniprofe'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];		
    }
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	//echo $a;
	//echo $mes;
	if($mes == 12) {
	    $a++;
	}
	//echo $a;
    
    $insertados = 0;
	$queryr0 = "Delete From tbl_estudiantes_mood_temp";
	$queryr00 = "Delete From tbl_estudiantes_mood";
	//$queryr1 = "SELECT * FROM tbl_estudiantes_mood_temp WHERE id NOT IN (SELECT id FROM tbl_estudiantes_mood)";
	$queryr1 = "SELECT * FROM tbl_estudiantes_mood_temp";
	//echo $queryr1;
	
    $query = "SELECT DISTINCT u.id, cc.name, u.lastname, u.firstname, u.city, u.email, u.username, 
        from_unixtime(ra.timemodified, '%Y-%m-%d') f_modif, from_unixtime(ra.timemodified, '%Y') a_modif 
        FROM mood_role_assignments ra, mood_user u, mood_context ct, mood_role r, mood_course c, mood_course_categories cc 
        WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id  
        AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.deleted = 0 
        AND cc.name NOT IN ('Psicología y Coordinación', 'Capacitación','Inducciones', 'Investigación - UNICAB', 'Escuelas de Énfasis', 'Electivas', 'Diplomados', 'Pre - Saberes UNICAB', 'Miscelanea') 
		ORDER BY u.id, cc.name";
	//echo $query;
	
	$resultado=$mysqli->query($query);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Favicon -->
<link rel="shortcut icon" href="../../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->

<!-- js-->
<script src="../../js/jquery-1.11.1.min.js"></script>
<script src="../../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../../js/metisMenu.min.js"></script>
<script src="../../js/custom.js"></script>
<link href="../../css/custom.css" rel="stylesheet">
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
		<?php 
		    if($id == 18) {
	        require 'menu_adm.php';
		    }
		    else {
		        require 'menu.php';
		    }  
		?>
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- modal -->
		<section>
			<?php require '../modal.php';  ?>
		</section>
		
		<!-- main content start-->
        <section>
           	<div id="page-wrapper">
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	
                    		 
                    			<div class="form-body">
                    			    <?php
                    			        //echo $query."<br>";
										$resultado_0=$mysqli1->query($queryr0);
										$resultado_00=$mysqli1->query($queryr00);
										
										//echo $mes;
										if($mes == '01' || $mes == '02') {
                                    	    //$a--;
                                    	}
										//echo $a;
										$a1 = $a--;
										while($row = $resultado->fetch_assoc()){
										    $a_modif = $row['a_modif'];
										    //echo "<br>a_modif = ".$a_modif." a = ".$a." a1 = ".$a1;
										    if($a_modif == $a || $a_modif == $a1) {
    											$query1="INSERT INTO tbl_estudiantes_mood_temp (id, grado, apellidos, nombres, ciudad, email_inst, usuario, a_modif) 
    											VALUES (".$row['id'].",'".$row['name']."','".$row['lastname']."','".$row['firstname']."','".$row['city']
    											."','".$row['email']."','".$row['username']."',".$row['a_modif'].")";
    											$resultado_1=$mysqli1->query($query1);
    											if($resultado_1 > 0) {
    												//$insertados++;
    											}
										    }
										}
										//echo $query1;
										
										$resultador1=$mysqli1->query($queryr1);
										while($row1 = $resultador1->fetch_assoc()){
											$query2="INSERT INTO tbl_estudiantes_mood (id, grado, apellidos, nombres, ciudad, email_inst, usuario, a_modif) 
											VALUES (".$row1['id'].",'".$row1['grado']."','".$row1['apellidos']."','".$row1['nombres']."','".$row1['ciudad']
											."','".$row1['email_inst']."','".$row1['usuario']."',".$row1['a_modif'].")";
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
										    //echo $query;
											echo "<label  class='col-sm-8 control-label'>Cargue exitoso de estudiantes de Moodle. Registros: ".$insertados."</label></br></br>";
											echo '<a href="adm1.php" ><button type="button" class="btn btn-primary">Volver</button></a>';
										}
										else {
											echo "<label  class='col-sm-8 control-label' style='color: red;'>No hay estudiantes nuevos de Moodle</label></br></br>";
											echo '<a href="adm1.php" ><button type="button" class="btn btn-primary">Volver</button></a>';
											//echo '<p>'.$query.'</p>';
											//echo '<p>'.$query1.'</p>';
										}
									?>
								
								</div>
              		 		
            			
           			</div>
       			</div>	
       		</div>
			<div>
			<?php //echo $a1."<br>".$query; ?>
			</div>
		</section>
	<!--footer-->
	<?php require '../footer.php'; ?>
    <!--//footer-->
	</div>
	
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="../../js/classie.js"></script>
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
	
	<!--scrolling js-->
	<script src="../../js/jquery.nicescroll.js"></script>
	<script src="../../js/scripts.js"></script>
	<!--//scrolling js-->
	
	<!-- side nav js -->
	<script src='../../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
	<!-- Bootstrap Core JavaScript -->
   <script src="../../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
	
	<!-- js tabla -->
	<script src="../../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
	
	<!-- validar combo periodo -->
	<script type="text/javascript">
		function validacion() {
			var grado=document.getElementById('id_grado').value;
			if (grado==0) {
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
	echo "<script>location.href='../../../login_registro.php'</script>";
}
?>
</html>