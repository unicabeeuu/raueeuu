<?php 
session_start();
include "../adminunicab/php/conexion.php";
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
	    
	$contador=0;
	/*$nota_uno=0;
	$nota_dos=0;
	$nota_tres=0;
	$nota_cuatro=0;*/
	$id_estudiante=$_GET['id_estudiante'];
	$buscar_grado="SELECT DISTINCT matricula.id_grado, grados.grado 
	    FROM matricula INNER JOIN grados ON matricula.id_grado=grados.id 
	    INNER JOIN estudiantes on matricula.id_estudiante=estudiantes.id 
	    where estudiantes.id=".$id_estudiante." and matricula.estado='activo'";
	$exe_buscar=mysqli_query($conexion,$buscar_grado);
	while ($buscar=mysqli_fetch_array($exe_buscar)) {
		$id_grado=$buscar['id_grado'];
		$nombre_grado=strtoupper($buscar['grado']);
	}
	
	/*$sqlNotas="SELECT DISTINCT grados.grado, materias.materia, materias.pensamiento, profesores.apellidos, profesores.nombres, estudiantes.id, matricula.estado 
	    FROM materias INNER JOIN ((grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) 
	    ON grados.id = matricula.id_grado) INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) 
	    ON grados.id = carga_profesor.id_grado) ON materias.Id = carga_profesor.id_materia 
	    WHERE estudiantes.id='".$id_estudiante."' and matricula.estado='activo' ORDER BY materias.pensamiento asc";
	$consultaNotas=mysqli_query($conexion,$sqlNotas);*/

	$sql_buscarEstudiante="SELECT * FROM `estudiantes` WHERE `id`=".$id_estudiante."";
	$exe_buscarEstuidante=mysqli_query($conexion,$sql_buscarEstudiante);

	while ($rowEstudiante = mysqli_fetch_array($exe_buscarEstuidante)) {
		$nombeCompleto=$rowEstudiante['nombres']." ".$rowEstudiante['apellidos'];
	}
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	if($dia < 10) {
		//$dia = "0".$dia;
	}
	if($mes < 10) {
		//$mes = "0".$mes;
	}
	$fecha2 =$a."/".$mes."/". $dia;
	//echo $fecha2;
	
	//Se valida la fecha actual con respecto a los cierres de periodo
	if(date($fecha2) >= date('2020/02/03') && date($fecha2) < date('2020/04/11')) {
	    $per = 1;
	}
	else if(date($fecha2) >= date('2020/04/11') && date($fecha2) < date('2020/06/28')) {
	    $per = 2;
	}
	else if(date($fecha2) >= date('2020/06/28') && date($fecha2) < date('2020/09/12')) {
	    $per = 3;
	}
	else if(date($fecha2) >= date('2020/09/12')) {
	    $per = 4;
	}
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

<script type="text/javascript">
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
		<?php //require 'menu.php';  ?>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		        require 'menu_registro.php';
		    }
		    else {
		        require 'menu.php';
		    }
		?>
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
								<?php
									$varialble_nota=0;
									if (!isset($id_grado)) {
										echo '<div class="alert alert-danger" role="alert">
  											<strong>¡Alerta!</strong> El estudiante no se encuentra matriculado.
										</div>';
									}
									else{
									    $tabla = "notas";
										/*$sql_no="SELECT DISTINCT estudiantes.id as id_estudiante, materias.materia, materias.pensamiento, grados.id as id_grado, 
										grados.grado, notas.nota, periodos.id as id_periodo 
										from ((((notas INNER JOIN estudiantes on notas.id_estudiante=estudiantes.id) 
										INNER JOIN materias on notas.id_materia=materias.Id) INNER JOIN grados on notas.id_grado=grados.id) 
										INNER JOIN periodos on notas.id_periodo=periodos.id) 
										where estudiantes.id=".$id_estudiante." and grados.id=".$id_grado." ORDER BY materias.materia ASC, periodos.id ASC";*/
										
										/*if($per == 1) {
                						    $sql_no="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
            									p1.nota P1
            									FROM 
            									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
            									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
            									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
            									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1 
            									ORDER BY 2";
                						}
                						else if($per == 2) {
                						    $sql_no="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
            									p1.nota P1, p2.nota P2 
            									FROM 
            									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
            									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
            									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
            									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1, 
            									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
            									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
            									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
            									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 2) p2 
            									WHERE p1.id_estudiante = p2.id_estudiante  
            									AND p1.id = p2.id  
            									AND p1.id_grado = p2.id_grado  
            									ORDER BY 2";
                						}
                						else if($per == 3) {
                						    $sql_no="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
            									p1.nota P1, p2.nota P2, p3.nota P3 
            									FROM 
            									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
            									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
            									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
            									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1, 
            									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
            									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
            									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
            									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 2) p2, 
            									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
            									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
            									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
            									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 3) p3 
            									WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante  
            									AND p1.id = p2.id AND p1.id = p3.id  
            									AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado  
            									ORDER BY 2";
                						}
                						else if($per == 4) {
                						    $sql_no="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
        									p1.nota P1, p2.nota P2, p3.nota P3, p4.nota P4 
        									FROM 
        									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
        									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
        									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
        									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1, 
        									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
        									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
        									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
        									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 2) p2, 
        									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
        									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
        									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
        									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 3) p3, 
        									(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota 
        									FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
        									WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
        									AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 4) p4 
        									WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante AND p1.id_estudiante = p4.id_estudiante 
        									AND p1.id = p2.id AND p1.id = p3.id AND p1.id = p4.id 
        									AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado AND p1.id_grado = p4.id_grado 
        									ORDER BY 2";
                						}*/
                						
                						$sql_no="SELECT a.id_estudiante, a.materia, a.pensamiento, a.id_materia, a.id_grado, a.grado, 
                                            sum(case a.id_periodo when 1 then a.nota else 0 end) P1, sum(case a.id_periodo when 2 then a.nota else 0 end) P2, 
                                            sum(case a.id_periodo when 3 then a.nota else 0 end) P3, sum(case a.id_periodo when 4 then a.nota else 0 end) P4 
                                            FROM 
                                            (SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id id_materia, g.id id_grado, g.grado, n.nota, p.id id_periodo 
                                            FROM notas n, estudiantes e, materias m, grados g, periodos p 
                                            WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id AND e.id = 1155 AND g.id = 3 AND p.id = 1
                                            UNION ALL
                                            SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id id_materia, g.id id_grado, g.grado, n.nota, p.id id_periodo 
                                            FROM notas n, estudiantes e, materias m, grados g, periodos p 
                                            WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id AND e.id = 1155 AND g.id = 3 AND p.id = 2
                                            UNION ALL
                                            SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id id_materia, g.id id_grado, g.grado, n.nota, p.id id_periodo 
                                            FROM notas n, estudiantes e, materias m, grados g, periodos p 
                                            WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id AND e.id = 1155 AND g.id = 3 AND p.id = 3
                                            UNION ALL
                                            SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id id_materia, g.id id_grado, g.grado, n.nota, p.id id_periodo 
                                            FROM notas n, estudiantes e, materias m, grados g, periodos p 
                                            WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id AND e.id = 1155 AND g.id = 3 AND p.id = 4) a
                                            GROUP BY a.id_estudiante, a.materia, a.pensamiento, a.id_materia, a.id_grado, a.grado 
                                            ORDER BY 3";
                						//echo $sql_no;
										$exe_no=mysqli_query($conexion,$sql_no);
										$tot_notas=mysqli_num_rows($exe_no);

										echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
    											<thead > 
    												<tr>
    													<TH COLSPAN=6><center><strong>NOMBRE ESTUDIANTE: '.$nombeCompleto.'</strong></center></TH>
    												</tr>
    												<tr>
    												<TH COLSPAN=2><center><strong>ASIGNATURAS INSCRITAS GRADO '.$nombre_grado.'</strong></center></TH>
    												<TH COLSPAN=4><center><strong>NOTAS DEFINITIVAS POR PERIODOS</strong></center></TH>
    												</tr>';
    									if ($id_grado>=17) {
    										echo '<tr>
    											<th><center>Materia</center></th>
    											<th><center>Pesamiento</center></th>
    											<th><center>P 1</center></th>
    											<th><center>P 2</center></th>
    											</tr> 
    											</thead> 
    											<tbody>';
    									}else{
    										echo '<tr>
    											<th><center>Materia</center></th>
    											<th><center>Pesamiento</center></th>
    											<th><center>P 1</center></th>
    											<th><center>P 2</center></th>
    											<th><center>P 3</center></th>
    											<th><center>P 4</center></th>
    											</tr> 
    											</thead> 
    											<tbody>';
    									}
    									while ($row=mysqli_fetch_array($exe_no)) {
    										if ($row['id_grado']>=17) {
    											echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td></tr>";
    											//esta validación es para las asignaturas de bioético y humanístico
    											if($row['id_materia'] == 10) {
    												echo "<tr><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td></tr>";
    												echo "<tr><td>EDUCACIÓN FÍSICA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td></tr>";
    											}
    											else if($row['id_materia'] == 15) {
    												echo "<tr><td>ARTISTICA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td></tr>";
    												echo "<tr><td>FILOSOFÍA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td></tr>";
    											}
    										}else{
    											echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td><td>".$row['P3']."</td><td>".$row['P4']."</td></tr>";
    											//esta validación es para las asignaturas de bioético y humanístico
    											if($row['id_materia'] == 10 || $row['id_materia'] == 1) {
    												echo "<tr><td>EDUCACIÓN ÉTICA Y EN VALORES</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td><td>".$row['P3']."</td><td>".$row['P4']."</td></tr>";
    												echo "<tr><td>EDUCACIÓN FÍSICA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td><td>".$row['P3']."</td><td>".$row['P4']."</td></tr>";
    											}
    											else if($row['id_materia'] == 15) {
    												echo "<tr><td>ARTISTICA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td><td>".$row['P3']."</td><td>".$row['P4']."</td></tr>";
    												echo "<tr><td>FILOSOFÍA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td><td>".$row['P3']."</td><td>".$row['P4']."</td></tr>";
    											}
    											else if($row['id_materia'] == 6) {
    												echo "<tr><td>ARTISTICA</td><td>".$row['pensamiento']."</td><td>".$row['P1']."</td><td>".$row['P2']."</td><td>".$row['P3']."</td><td>".$row['P4']."</td></tr>";
    											}
    										}	
    									}
										echo "</tbody> 
											</table>";
									}
								
							?>
							</tbody>
							</table>
							
							<br>
							    <a href="estudiante.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
						    <br><br>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--footer-->
		<?php //require 'footer.php'; ?>
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
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>