<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniestudiante'])) {
		$sql="SELECT * FROM estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
		$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$email_institucional = $fila['email_institucional'];
		$password = $fila['password'];
	}
	
	$query = "SELECT CONCAT(c.nombres, ' ', c.apellidos) estudiante, c.n_documento, c.acudiente, c.telefono_acudiente, c.email_acudiente, c.año, c.id_grado_sistema, g1.grado grado_sistema, 
        c.id_grado_solicitado, g2.grado grado_solicitado, c.respuesta_pregunta, c.fecha_solicitud, m.estado, m.fecha_ingreso, m.idMatricula, m.id_grado, g3.grado gradoactual  
        FROM tbl_cupos c, estudiantes e, matricula m, grados g1, grados g2, grados g3, 
        (SELECT max(idMatricula) idMatricula, id_estudiante FROM `matricula` GROUP BY id_estudiante) m1 
        WHERE c.n_documento = e.n_documento AND e.id = m.id_estudiante 
        AND m.idMatricula = m1.idMatricula AND c.id_grado_sistema = g1.id AND c.id_grado_solicitado = g2.id AND m.id_grado = g3.id 
        AND c.n_documento = '$n_documento' 
        ORDER BY m.idMatricula";
    //echo $query;
    
    $cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr>
							    <TH COLSPAN=10><center><strong>CUPO APARTADO</strong></center></TH>
							</tr>
	                        <tr>
	                            <th>Estudiante</th>
	                            <th>Documento</th>
	                            <th>Acudiente</th>
	                            <th>Tel. Acud</th>
	                            <th>Email Acud</th>
	                            <th>Respuesta</th>
	                            <th>Grado Sistema</th>
	                            <th>Grado Solicitado</th>
	                            <th>Grado Actual/Ultimo</th>
	                            <th>Año Cupo</td>
	                        </tr></thead><tbody>";
	                        
    //$resultado1 = $mysqli1->query($query);
    $resultado1 = mysqli_query($conexion,$query);
    /*while($row = $resultado1->fetch_assoc()) {
        $cadena = $cadena."<tr>
                <td>".$row['estudiante']."</td>
                <td>".$row['n_documento']."</td>
                <td>".$row['acudiente']."</td>
                <td>".$row['telefono_acudiente']."</td>
                <td>".$row['email_acudiente']."</td>
                <td>".$row['respuesta_pregunta']."</td>
                <td>".$row['grado_sistema']."</td>
                <td>".$row['grado_solicitado']."</td>
                <td>".$row['gradoactual']."</td></tr>";
        $i++;
    }*/
    while ($filar = mysqli_fetch_array($resultado1)){
        $cadena = $cadena."<tr>
                <td>".$filar['estudiante']."</td>
                <td>".$filar['n_documento']."</td>
                <td>".$filar['acudiente']."</td>
                <td>".$filar['telefono_acudiente']."</td>
                <td>".$filar['email_acudiente']."</td>
                <td>".$filar['respuesta_pregunta']."</td>
                <td>".$filar['grado_sistema']."</td>
                <td>".$filar['grado_solicitado']."</td>
                <td>".$filar['gradoactual']."</td>
                <td>".$filar['año']."</td></tr>";
    }
    $cadena = $cadena."</tbody></table>";
	
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Unicab Registro Académico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <script type="text/javascript" src="../docenteunicab/updreg/js/jquery.min.js"></script>
    <script src="../js/modernizr.custom.js"></script>
    
    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <!--//webfonts--> 
    
    <!--css tabla -->
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
    <!-- // css tabla -->
    
    <!-- Metis Menu -->
    <script src="../js/metisMenu.min.js"></script>
    <!--<script src="../js/custom.js"></script>-->
    <link href="../css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
    
    <script>
        $(function() {
            //alert("Cargó jquery");
        });
    </script>
    
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
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
							<br>
							<?php
							    echo $cadena;
							?>
						<input type="hidden" id="txtidest" value="<?php echo $id; ?>"/><input type="hidden" id="txtidgra" value="<?php echo $id_grado; ?>"/>
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
}else if (isset($_SESSION['unisuper'])) {
	echo "<script>location.href='../adminunicab/index.php'</script>";
}else if(isset($_SESSION['uniprofe'])) {
	echo "<script>location.href='../docenteunicab/index.php'</script>";
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='login.php'</script>";
}
?>
</html>