<?php
session_start();
require "php/conexion.php";
if (isset($_SESSION['unisuper'])) {
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
	
	$tipo_certificado=$_POST['tipo_certificado'];
	$periodo=$_POST['periodo'];
	$idioma=$_POST['idioma'];
	$id_estudiante=$_POST['id_estudiante'];
	$firmas=$_POST['firmas'];
	
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Sistema de Registro Académico - Unicab Virtual</title>
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
<link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--Fecha Actual-->
 <?php
date_default_timezone_set('America/Bogota');
$dia=date("d");
$mes=date("m");
$mesLetra=date("M");
$fanio=date("Y");
$espaniol="";

switch ($mes) {
	case '1':
		$espaniol="Enero"; 
		break;
	case '2':
		$espaniol="Febrero";
		break;
	case '3':
		$espaniol="Marzo";
		break;
	case '4':
		$espaniol="Abril";
		break;
	case '5':
		$espaniol="Mayo";
		break;
	case '6':
		$espaniol="Junio";
		break;
	case '7':
		$espaniol="Julio";
		break;
	case '8':
		$espaniol="Agosto";
		break;
	case '9':
		$espaniol="Septiembre";
		break;
	case '10':
		$espaniol="Octubre";
		break;
	case '11':
		$espaniol="Noviembre";
		break;
	case '12':
		$espaniol="Diciembre";
		break;
}

 /*$peticion2="SET lc_time_names = 'en_US'";
 $resultado2 = mysqli_query($conexion, $peticion2);*/
                        
  $peticion = "SELECT DATE_FORMAT(NOW(),'%Y-%m-%d') fecha";
  $resultado = mysqli_query($conexion, $peticion);
  while ($fila = mysqli_fetch_array($resultado))
   {
	$fechaHoy=$fila['fecha'];
   }
?>
</head> 
<style>
@media print {
  @page { margin: 0; }
  body { margin: -17; margin-top: -60px; }
}
</style>

<body class="cbp-spmenu-push">

	<div class="main-content">
	<?php 
	    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
	    //if($id == 18 ) {
	        require 'menu_registro.php';
	    }
	    else if($perfil == "AR1") {
	        require 'menu_registro_aux.php';
	    }
	    else {
	        require 'menu.php';
	    }
	?>
	
<section>
<div id="page-wrapper">
<div>				
      <div class="mid-content-top charts-grids">	
        <div class="middle-content">

<style>
.justifyText{
text-align : justify;
}
</style>
<?php
	/*$peticion= "SELECT * 
				FROM estudiantes 
				INNER JOIN matricula ON estudiantes.id=matricula.id_estudiante
				INNER JOIN grados ON matricula.id_grado=grados.id
				WHERE estudiantes.id=".$id_estudiante."";*/
	$peticion= "SELECT e.*, td.tipo_documento tipdoc, g.grado, m.estado, m.id_grado 
				FROM estudiantes e
				INNER JOIN matricula m ON e.id = m.id_estudiante
				INNER JOIN grados g ON m.id_grado = g.id 
				INNER JOIN tbl_tipos_documento td ON e.tipo_documento = td.id 
				WHERE e.id=".$id_estudiante;
	$resultado = mysqli_query($conexion, $peticion);
	while ($fila = mysqli_fetch_array($resultado)){
		$nombreCompleto=$fila['nombres']." ".$fila['apellidos'];
		$genero=$fila['genero'];
		$tipo_documento=$fila['tipdoc'];
		$n_documento=$fila['n_documento'];
		$expedicion=$fila['expedicion'];
		$ciudad=$fila['ciudad'];
		$grado=$fila['grado'];
		$estado=$fila['estado'];
		$id_grado=$fila['id_grado'];
	}
	if ($genero=="Masculino" || $genero == "MASCULINO") {
		$variable="el";
		$variableDos="identificado";
		$variableTres="matriculado";
		$variableCuatro="activo";
	}else{
		$variable="la";
		$variableDos="identificada";
		$variableTres="matriculada";
		$variableCuatro="activa";
	}
	// matricula
	$sql_matricula="SELECT * FROM `matricula` WHERE `id_estudiante`=".$id_estudiante."";
	$exe_matricula=mysqli_query($conexion,$sql_matricula);
	while ($rowM=mysqli_fetch_array($exe_matricula)) {
		$anio=$rowM['fecha_ingreso'];
	}
	// matricula

	// numero certificado
	$sql_certificado="SELECT * FROM `certificado`";
	$exe_certificado=mysqli_query($conexion,$sql_certificado);
	$certicado_total=mysqli_num_rows($exe_certificado);
	// numero certificado
	
	$tabla = "notas";

	/*$sql_notas="SELECT estudiantes.id AS id_estudiantes, estudiantes.apellidos, estudiantes.nombres, estudiantes.n_documento, estudiantes.ciudad, 
	grados.id as id_grado, grados.grado, materias.materia, materias.materiaIngles, materias.pensamiento, materias.pensamientoingles, periodos.id, notas.nota 
	FROM materias INNER JOIN (grados INNER JOIN (estudiantes INNER JOIN (periodos INNER JOIN notas ON periodos.id = notas.id_periodo) ON estudiantes.id = notas.id_estudiante) 
	ON grados.id = notas.id_grado) ON materias.Id = notas.id_materia 
	WHERE estudiantes.id=".$id_estudiante." and periodos.id=".$periodo." ORDER BY materias.pensamiento ASC";*/
	
	/*$sql_no="SELECT DISTINCT estudiantes.id as id_estudiante, materias.materia, materias.pensamiento, grados.id as id_grado, 
										grados.grado, notas.nota, periodos.id as id_periodo 
										from ((((notas INNER JOIN estudiantes on notas.id_estudiante=estudiantes.id) 
										INNER JOIN materias on notas.id_materia=materias.Id) INNER JOIN grados on notas.id_grado=grados.id) 
										INNER JOIN periodos on notas.id_periodo=periodos.id) 
										where estudiantes.id=".$id_estudiante." and grados.id=".$id_grado." ORDER BY materias.materia ASC, periodos.id ASC";*/
	if($periodo == 1) {
	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
			p1.nota
			FROM 
			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
			FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
			AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1 
			ORDER BY 2";
	}
	else if($periodo == 2) {
	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
			(p1.nota + p2.nota)/2 nota 
			FROM 
			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
			FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
			AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1, 
			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
			FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
			AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 2) p2 
			WHERE p1.id_estudiante = p2.id_estudiante  
			AND p1.id = p2.id  
			AND p1.id_grado = p2.id_grado  
			ORDER BY 2";
	}
	else if($periodo == 3) {
	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
			(p1.nota + p2.nota + p3.nota)/3 nota 
			FROM 
			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
			FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
			AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1, 
			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
			FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
			AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 2) p2, 
			(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
			FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
			WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
			AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 3) p3 
			WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante  
			AND p1.id = p2.id AND p1.id = p3.id  
			AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado  
			ORDER BY 2";
	}
	else if($periodo == 4) {
	    $sql_notas="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.pensamiento, p1.id id_materia, p1.id_grado, p1.grado, 
		(p1.nota + p2.nota + p3.nota + p4.nota)/4 nota 
		FROM 
		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
		FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
		AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 1) p1, 
		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
		FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
		AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 2) p2, 
		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
		FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
		AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 3) p3, 
		(SELECT DISTINCT e.id id_estudiante, m.materia, m.pensamiento, m.id, g.id id_grado, g.grado, n.nota, m.materiaIngles, m.pensamientoingles 
		FROM ".$tabla." n, estudiantes e, materias m, grados g, periodos p 
		WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
		AND e.id = ".$id_estudiante." AND g.id = ".$id_grado." AND p.id = 4) p4 
		WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante AND p1.id_estudiante = p4.id_estudiante 
		AND p1.id = p2.id AND p1.id = p3.id AND p1.id = p4.id 
		AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado AND p1.id_grado = p4.id_grado 
		ORDER BY 2";
	}
	//echo '<script>alert ('.$periodo.');</script>';
	$exe_notas=mysqli_query($conexion,$sql_notas);
	
	//certificado español
	if ($idioma=="espanol") {
		if (strpos($grado, "Transición") !== false){
			$nivelEducativo="Educación Preescolar";
		}
		if (strpos($grado, "Primero") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Segundo") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Tercero") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Cuarto") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Quinto") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Sexto") !== false)
		{
			$nivelEducativo="Educación Básica Secundaria";
		}
		if (strpos($grado, "Séptimo") !== false)
		{
			$nivelEducativo="Educación Básica Secundaria";
		}
		if (strpos($grado, "Octavo") !== false)
		{
			$nivelEducativo="Educación Básica Secundaria";
		}
		if (strpos($grado, "Noveno") !== false)
		{
			$nivelEducativo="Educación Básica Secundaria";
		}
		if (strpos($grado, "Décimo") !== false)
		{
			$nivelEducativo="Educación Media Académica";
		}
		if (strpos($grado, "Undécimo") !== false)
		{
			$nivelEducativo="Educación Media Académica";
		}
		if (strpos($grado, "Ciclo I") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Ciclo II") !== false)
		{
			$nivelEducativo="Educación Básica Primaria";
		}
		if (strpos($grado, "Ciclo III") !== false)
		{
			$nivelEducativo="Educación Básica Secundaria";
		}
		if (strpos($grado, "Ciclo IV") !== false)
		{
			$nivelEducativo="Educación Básica Secundaria";
		}
		if (strpos($grado, "Ciclo V") !== false)
		{
			$nivelEducativo="Educación Media Académica";
		}
		if (strpos($grado, "Ciclo VI") !== false)
		{
			$nivelEducativo="Educación Media Académica";
		}

		if ($tipo_certificado=="Estudio" && $idioma=="espanol") {
		?>
	    <!--CERTIFICADO-->
	    	<div class="panel panel-default">
				<div class="panel-body" align="center" >
				 	<!--<img class="img-responsive" width="140px" src="../images/logo20.png"><br>-->
					<img class="img-responsive" width="140px" src="../../assets/img/footer_logo2025.png"><br>
						<h6 align="center" style="font-size: 1rem; text-align: center; margin-left: 50px; margin-right: 50px;">	
	      					<strong>UNICAB VIRTUAL</strong>, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la Secretaría de Educación y Cultura de Sogamoso según resolución 061 del 15 de diciembre de 2007, y Resolución Nº 0155 21 de Julio de 2010 y Resolución No. 326 del 22 de septiembre de 2015, para todos los niveles de Educación Básica Primaria, Básica Secundaria y Media Académica.
						</h6>
						<h6><strong>NIT 826002762-1</strong></h6><br><br>
						<h4 style="font-weight: bold; font-size: 1.091rem;">
							LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL
						</h4><br><br>
                        <div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
							<h3 style="font-weight: bold; font-size: 1.273rem;">
								CERTIFICAN:
							</h3><br><br>
							<h5 class="justifyText" style="font-size: 1.091rem;">
								Que, <?php echo $variable; ?> estudiante, <b><?php echo $nombreCompleto?></b>, <?php echo $variableDos; ?> con <?php echo $tipo_documento; ?> No. <?php echo $n_documento?> de  <?php echo $expedicion; ?>,  se encuentra actualmente <?php echo $variableTres; ?> y es estudiante <?php echo $variableCuatro; ?> en nuestra Institución de Educación Virtual, en el grado <strong><?php echo mb_strtoupper($grado)?></strong> de <strong><?php echo mb_strtoupper($nivelEducativo)?></strong> en calendario A, para el año lectivo <?php echo $fanio; ?>.<br><br>
								Que el estudiante puede desarrollar su educación, utilizando las herramientas y la interconexión a través de nuestra plataforma tecnológica Moodle desde cualquier lugar del mundo, con una intensidad horaria de (6) horas diarias, siendo su lugar actual de residencia la ciudad de <?php echo $ciudad; ?>.
								<br><br>
								Se expide a solicitud del interesado a los  (<?php echo $dia; ?>) días del mes de <?php echo $espaniol; ?> de (<?php echo $fanio; ?>).	
							</h5>
                     	</div><!--Cierre contenedorGeneral-->
						<br>
						<div class="row" id="contieneFirmas">
							<?php 
								if ($firmas=="SI") {
									//echo "<img class='img-responsive' width='100%' src='../images/firma_certficados.png'>";
									echo "<img class='img-responsive' width='100%' src='../images/firma_certificados_liliana_1.jpg'>";
								}else{
									echo "<img class='img-responsive' width='100%' src='../images/firma_certificados_liliana_sf_1.jpg'>";
								}
							?>
						   
						</div><hr>
						<p align="center">
						Calle 13ª N° 16-60 Sogamoso – Boyacá | Phone: 608 7752309 | Cel: 300 815 6531 - 315 696 5291<br>
						www.unicab.org
						</p>
	 				</div>
			</div>
				<!--CERTIFICADO-->
				<div align="center">
					<form action="php/Registro-certificado.php" method="POST">
						<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy; ?>">
						<input type="hidden" id="tipoc" name="tipoc" value="Certificado de Estudio">
						<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
						<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
						<h6>Certificado N°: CS<?php echo $certicado_total; ?></h6>
						<button type="submit" id="hide" class="btn btn-danger" >Certificado</button>
					</form>
				  <!--   <script>
	      				$(function(){
	        				$('#hide').click(function(){
	          				$('#hide').hide();
	          				window.print();
	        			});
	      				})
	    			</script> -->
		 		</div>
	 		<!-- CERTIFICADO -->
			<?php
		}
		if ($tipo_certificado=="Notas" && $idioma=="espanol") {
			?>
			<!--CERTIFICADO-->
		<div class="textocertificado">
		    <div class="panel panel-default">
  				<div class="panel-body" align="center">
				 	<img class="img-responsive" width="140px" src="../images/logo20.png"><br>
						<h6 align="center" style="font-size: 1rem; text-align: center; margin-left: 50px; margin-right: 50px;">	
	      				<strong>UNICAB VIRTUAL</strong>, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la Secretaría de Educación y Cultura de Sogamoso según resolución 061 del 15 de diciembre de 2007, y Resolución Nº 0155 21 de Julio de 2010 y Resolución No. 326 del 22 de septiembre de 2015, para todos los niveles de Educación Básica Primaria, Básica Secundaria y Media Académica,
						</h6><br>
						<h4 style="font-weight: bold;">LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL</h4><br>
                        <div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
						<h3 style="font-weight: bold;">CERTIFICAN:</h3><br>
					<h5 class="justifyText">
					Que, <?php echo $variable; ?> estudiante, <b><?php echo $nombreCompleto?></b>. <?php echo $variableDos; ?> con <?php echo $tipo_documento; ?> No. <?php echo $n_documento?> de  <?php echo $expedicion; ?>, en la actualidad es <b>estudiante <?php echo $estado?></b> del grado <strong><?php echo mb_strtoupper($grado)?></strong> de <strong><?php echo mb_strtoupper($nivelEducativo)?></strong>, cumpliendo con los requisitos establecidos.</h5><br>
					<h5 align="left" style="font-weight: bold;"><strong>Periodo:</strong> <?php echo $periodo; ?></h5><br>
					<table border="1" bordercolor="#e0e0e0" style="font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">
				  	<thead>
					    <tr>
				    		<th scope="col" style="text-align: center;">Pensamiento</th>
					      	<th scope="col" style="text-align: center;">Área-Asignatura</th>
					      	<th scope="col" style="text-align: center;">Valoración</th>
					      	<th scope="col" style="text-align: center;">Nivel de desempeño</th>
					    </tr>
				  	</thead>
				 	<tbody>
				 		<?php
				 		while ($row=mysqli_fetch_array($exe_notas)) {
			 				echo " <tr>
			 				<td style='text-align: center;'>".$row['pensamiento']."</td>
	      					<td style='text-align: center;'>".$row['materia']."</td>
	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
					      	if ($row['nota']<=3.0) {
						      	echo "<td style='text-align: center;'>BAJO</td>";
					      	}
					      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
						      	echo "<td style='text-align: center;'>ALTO</td>";
					      	}
					      	if ($row['nota']>=4.5) {
						      	echo "<td style='text-align: center;'>SUPERIOR</td>";
					      	}
	      					echo "</tr>";
	      					//esta validación es para las asignaturas de bioético y humanístico
	      					if($row['id_materia'] == 10 || $row['id_materia'] == 1) {
								echo " <tr>
    			 				<td style='text-align: center;'>".$row['pensamiento']."</td>
    	      					<td style='text-align: center;'>EDUCACIÓN ÉTICA Y EN VALORES</td>
    	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
    					      	if ($row['nota']<=3.0) {
    						      	echo "<td style='text-align: center;'>BAJO</td>";
    					      	}
    					      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    						      	echo "<td style='text-align: center;'>ALTO</td>";
    					      	}
    					      	if ($row['nota']>=4.5) {
    						      	echo "<td style='text-align: center;'>SUPERIOR</td>";
    					      	}
    	      					echo "</tr>";
    	      					echo " <tr>
    			 				<td style='text-align: center;'>".$row['pensamiento']."</td>
    	      					<td style='text-align: center;'>EDUCACIÓN FÍSICA</td>
    	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
    					      	if ($row['nota']<=3.0) {
    						      	echo "<td style='text-align: center;'>BAJO</td>";
    					      	}
    					      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    						      	echo "<td style='text-align: center;'>ALTO</td>";
    					      	}
    					      	if ($row['nota']>=4.5) {
    						      	echo "<td style='text-align: center;'>SUPERIOR</td>";
    					      	}
    	      					echo "</tr>";
							}
							else if($row['id_materia'] == 15) {
								echo " <tr>
    			 				<td style='text-align: center;'>".$row['pensamiento']."</td>
    	      					<td style='text-align: center;'>ARTISTICA</td>
    	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
    					      	if ($row['nota']<=3.0) {
    						      	echo "<td style='text-align: center;'>BAJO</td>";
    					      	}
    					      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    						      	echo "<td style='text-align: center;'>ALTO</td>";
    					      	}
    					      	if ($row['nota']>=4.5) {
    						      	echo "<td style='text-align: center;'>SUPERIOR</td>";
    					      	}
    	      					echo "</tr>";
    	      					echo " <tr>
    			 				<td style='text-align: center;'>".$row['pensamiento']."</td>
    	      					<td style='text-align: center;'>FILOSOFÍA</td>
    	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
    					      	if ($row['nota']<=3.0) {
    						      	echo "<td style='text-align: center;'>BAJO</td>";
    					      	}
    					      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    						      	echo "<td style='text-align: center;'>ALTO</td>";
    					      	}
    					      	if ($row['nota']>=4.5) {
    						      	echo "<td style='text-align: center;'>SUPERIOR</td>";
    					      	}
    	      					echo "</tr>";
							}
							else if($row['id_materia'] == 6) {
								echo " <tr>
    			 				<td style='text-align: center;'>".$row['pensamiento']."</td>
    	      					<td style='text-align: center;'>ARTISTICA</td>
    	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
    					      	if ($row['nota']<=3.0) {
    						      	echo "<td style='text-align: center;'>BAJO</td>";
    					      	}
    					      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    						      	echo "<td style='text-align: center;'>ALTO</td>";
    					      	}
    					      	if ($row['nota']>=4.5) {
    						      	echo "<td style='text-align: center;'>SUPERIOR</td>";
    					      	}
    	      					echo "</tr>";
							}
						}
				 		echo "</tbody>
						</table>";
						?>
						<br>
						<h5 class="justifyText" style="font-size: 1.091rem">
						Se expide a solicitud del interesado a los  (<?php echo $dia; ?>) días del mes de <?php echo $espaniol; ?> de (<?php echo $fanio; ?>).
						</h5>
                    </div><!--Cierre contenedorGeneral-->
					<div class="row" id="contieneFirmas">
						<?php 
							if ($firmas=="SI") {
								//echo "<img class='img-responsive' width='100%' src='../images/firma_certficados.png'>";
								echo "<img class='img-responsive' width='100%' src='../images/firmas_unicab1.jpg'>";
							}else{
								echo "<img class='img-responsive' width='100%' src='../images/certficados_sinfirmas.png'>";
							}
						?>
					</div><hr>
					<p align="center" style="padding: 0px;"> 
					Calle 13ª N° 16-60 Sogamoso – Boyacá | Phone: 608 7752309 | Cel: 300 815 6531 - 315 696 5291<br>
					www.unicab.org
					</p>
 				</div>
			</div>
		</div>
		<!-- CERTIFICADO -->
		<div align="center">
			<form action="php/Registro-certificado.php" method="POST">
				<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy; ?>">
				<input type="hidden" id="tipoc" name="tipoc" value="Certificado de Notas">
				<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
				<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
				<h6>Certificado N°: CS<?php echo $certicado_total; ?></h6>
				<button type="submit" id="hide" class="btn btn-danger" >Certificado</button>
			</form>
 		</div>
 		<!-- CERTIFICADO -->
			<?php
		}
	}

	//certificado ingles
	if ($idioma=="ingles") {
		switch ($estado) {
		    case "activo":
		        $estado="Active";
		        break;
		    case "inactivo":
		         $estado="Inactive";
		        break;
		    case "retirado":
		        $estado="Retired";
		        break;
			 default:
			 	$estado="Undefined";
		}

		switch ($grado) {
		    case "Transición":
		        $grado="Transition";
				$nivelEducativo="Preschool Education";
		        break;
		    case "Primero":
		         $grado="1<sup>st</sup> grade";
				 $nivelEducativo="Elementary Education";
		        break;
		    case "Segundo":
		       $grado="2<sup>nd</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Tercero":
		        $grado="3<sup>rd</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Cuarto":
		        $grado="4<sup>th</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Quinto":
		        $grado="5<sup>th</sup> grade";
				$nivelEducativo="Elementary Education";
		        break;
			case "Sexto":
		        $grado="6<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Séptimo":
		        $grado="7<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Octavo":
		        $grado="8<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Noveno":
		        $grado="9<sup>th</sup> grade";
				$nivelEducativo="Secondary Education";
		        break;
			case "Décimo":
		        $grado="10<sup>th</sup> grade";
				$nivelEducativo="high School";
		        break;
			case "UnDécimo":
		        $grado="11<sup>th</sup> grade";
				$nivelEducativo="high School";
		        break;
			case "Ciclo I":
		        $grado="Cycle I";
				$nivelEducativo="Elementary Education";
		        break;
			case "Ciclo II":
		        $grado="Cycle II";
				$nivelEducativo="Elementary Education";
		        break;
			case "Ciclo III":
		        $grado="Cycle III";
				$nivelEducativo="Secondary Education";
		        break;
			case "Ciclo IV":
		        $grado="Cycle IV";
				$nivelEducativo="Secondary Education";
		        break;
			case "Ciclo V":
		        $grado="Cycle V";
				$nivelEducativo="high School";
		        break;
			case "Ciclo VI":
		        $grado="Cycle VI";
				$nivelEducativo="high School";
		        break;
			default:
			 	$grado="Undefined";
				$nivelEducativo="Undefined";
		}
		if ($tipo_certificado=="Estudio" && $idioma=="ingles") {
			?>
		    <div class="marca">
		    	<div class="panel panel-default">
  					<div class="panel-body" align="center">
					 	<img class="img-responsive" width="140px" src="../images/logo20.png"><br>
						<h6 align="center" style="font-size: 1rem; text-align: center; margin-left: 50px; margin-right: 50px;">	
	      					<strong>UNICAB VIRTUAL</strong>, DANE CODE 315759002653, ICFES CODE 154567, operating license from education and culture secretary of Sogamoso according to administrative resolution N° 061 on December 15<sup>th</sup> in 2007 and  administrative resolution N° 326 on September 22<sup>nd</sup> in 2015,  for all education levels preschool, elementary, secondary and high school
	      				</h6><br><br>
						<h4 style="font-weight: bold; font-size: 1.091rem;">
							THE RECTOR  AND ACADEMIC SECRETARY OF THE UNICAB VIRTUAL SCHOOL
						</h4><br><br>
                   		<div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
							<h3 style="font-weight: bold; font-size: 1.273rem;">
								CERTIFY:
							</h3><br><br>
							<h5 class="justifyText" style="font-size: 1.091rem;">
								That, the student, <b><?php echo $nombreCompleto?></b>. with <?php echo $tipo_documento; ?> No. <?php echo $n_documento?> from  <?php echo $expedicion; ?>,  currently is an <?php echo $estado; ?> student  in our virtual education institution  in  <strong><?php echo $grado; ?>th</strong> grade of <strong><?php echo mb_strtoupper($nivelEducativo); ?></strong> in calendar A, for the school year <?php echo $fanio; ?>.<br><br>
								That the student is able to develop the education, using the tools  and the interconnection through our technological platform Moodle everywhere around the world,  with an hourly intensity of (6) daily hours, being her  place of residence <?php echo $expedicion; ?>.
								<br><br>
								It is issued at the request of the applicant on the (<?php echo $dia; ?>) days of the month of <?php echo $mesLetra;?> of (<?php echo $fanio; ?>).
							</h5>
                    	</div><!--Cierre contenedor general-->
                    	<br>
						<div class="row" id="contieneFirmas">
							<?php 
								if ($firmas=="SI") {
									//echo "<img class='img-responsive' width='100%' src='../images/firma_certficados.png'>";
									echo "<img class='img-responsive' width='100%' src='../images/firmas_unicab1.jpg'>";
								}else{
									echo "<img class='img-responsive' width='100%' src='../images/certficados_sinfirmas.png'>";
								}
							?>
						</div><hr>
						<p align="center">
							Calle 13ª N° 16-60 Sogamoso – Boyacá | Phone: 608 7752309 | Cel: 300 815 6531 - 315 696 5291<br>
							www.unicab.org
						</p>
	 				</div>
				</div>
			</div>
			<!--CERTIFICADO-->
			<div align="center">
				<form action="php/Registro-certificado.php" method="POST">
					<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy; ?>">
					<input type="hidden" id="tipoc" name="tipoc" value="Certificado de Estudio - Inglés">
					<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
					<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
					<h6>Certificado N°: CS<?php echo $certicado_total; ?></h6>
					<button type="submit" id="hide" class="btn btn-danger" >Certificado</button>
				</form>
	 		</div>
	 		<!-- CERTIFICADO -->
			<?php 
		}if ($tipo_certificado=="Notas" && $idioma=="ingles") {
			?>
			<!--CERTIFICADO-->
			<div class="textocertificado">
				<div class="panel panel-default">
					<div class="panel-body" align="center">
						<img class="img-responsive" width="140px" src="../images/logo20.png"><br>
						<h6 align="center" style="font-size: 1rem; text-align: center; margin-left: 50px; margin-right: 50px;">	
	      					<strong>UNICAB VIRTUAL</strong>, DANE CODE 315759002653, ICFES CODE 154567, operating license from<br> education and culture secretary of Sogamoso according to administrative resolution N° 061 on <br>December 15  2007, 0155 July 21 2010 and administrative resolution No. 326 on September 22 2015, <br>for all education levels preschool, elementary, secondary and high school,
						</h6><br>
						<h4 style="font-weight: bold;">
							THE RECTOR  AND ACADEMIC SECRETARY OF THE UNICAB VIRTUAL SCHOOL
						</h4><br>
                        <div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
							<h3 style="font-weight: bold;">CERTIFY:</h3><br>
							<h5 class="justifyText">
								That the student <b><?php echo $nombreCompleto?></b>, with I.D. N° <?php echo $n_documento?> from <?php echo $ciudad?>, currently is an <b><?php echo $estado?> student </b> in <?php echo $grado?> of <?php echo $nivelEducativo?>, fulfilling with the requirements and achievements established.
							</h5><br>
							<h4 align="left"><strong>Term:</strong> 
								<?php echo $periodo; ?>
							</h4><br>
							<table border="1" bordercolor="#e0e0e0" style="font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">
						  	<thead>
							    <tr>
							    	<th scope="col" style="text-align: center;">THOUGHT</th>
							      	<th scope="col" style="text-align: center;">SUBJECT</th>
							      	<th scope="col" style="text-align: center;">ASSESSMENT</th>
							      	<th scope="col" style="text-align: center;">PERFORMANCE LEVEL</th>
							    </tr>
						  	</thead>
						 	<tbody>
					 		<?php
						 		while ($row=mysqli_fetch_array($exe_notas)) {
					 				echo " <tr>
					 				<td><center>".$row['pensamientoingles']."</center></td>
			      					<td><center>".$row['materiaIngles']."</center></td>
			     		 			<td><center>".$row['nota']."</center></td>";
							      	if ($row['nota']<=3.0) {
								      	echo "<td><center>LOW</center></td>";
							      	}
							      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
								      	echo "<td><center>HIGH</center></td>";
							      	}
							      	if ($row['nota']>=4.5) {
								      	echo "<td><center>SUPERIOR</center></td>";
							      	}
			      					echo "</tr>";
			      					//esta validación es para las asignaturas de bioético y humanístico
        	      					if($row['id_materia'] == 10 || $row['id_materia'] == 1) {
        								echo " <tr>
            			 				<td style='text-align: center;'>".$row['pensamientoingles']."</td>
            	      					<td style='text-align: center;'>ETHICS AND VALUES</td>
            	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
            					      	if ($row['nota']<=3.0) {
    								      	echo "<td><center>LOW</center></td>";
    							      	}
    							      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    								      	echo "<td><center>HIGH</center></td>";
    							      	}
    							      	if ($row['nota']>=4.5) {
    								      	echo "<td><center>SUPERIOR</center></td>";
    							      	}
            	      					echo "</tr>";
            	      					echo " <tr>
            			 				<td style='text-align: center;'>".$row['pensamientoingles']."</td>
            	      					<td style='text-align: center;'>PHYSICAL EDUCATION</td>
            	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
            					      	if ($row['nota']<=3.0) {
    								      	echo "<td><center>LOW</center></td>";
    							      	}
    							      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    								      	echo "<td><center>HIGH</center></td>";
    							      	}
    							      	if ($row['nota']>=4.5) {
    								      	echo "<td><center>SUPERIOR</center></td>";
    							      	}
            	      					echo "</tr>";
        							}
        							else if($row['id_materia'] == 15) {
        								echo " <tr>
            			 				<td style='text-align: center;'>".$row['pensamientoingles']."</td>
            	      					<td style='text-align: center;'>ARTS</td>
            	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
            					      	if ($row['nota']<=3.0) {
    								      	echo "<td><center>LOW</center></td>";
    							      	}
    							      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    								      	echo "<td><center>HIGH</center></td>";
    							      	}
    							      	if ($row['nota']>=4.5) {
    								      	echo "<td><center>SUPERIOR</center></td>";
    							      	}
            	      					echo "</tr>";
            	      					echo " <tr>
            			 				<td style='text-align: center;'>".$row['pensamientoingles']."</td>
            	      					<td style='text-align: center;'>PHILOSOPHY</td>
            	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
            					      	if ($row['nota']<=3.0) {
    								      	echo "<td><center>LOW</center></td>";
    							      	}
    							      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    								      	echo "<td><center>HIGH</center></td>";
    							      	}
    							      	if ($row['nota']>=4.5) {
    								      	echo "<td><center>SUPERIOR</center></td>";
    							      	}
            	      					echo "</tr>";
        							}
        							else if($row['id_materia'] == 6) {
        								echo " <tr>
            			 				<td style='text-align: center;'>".$row['pensamientoingles']."</td>
            	      					<td style='text-align: center;'>ARTS</td>
            	     		 			<td style='text-align: center;'>".$row['nota']."</td>";
            					      	if ($row['nota']<=3.0) {
    								      	echo "<td><center>LOW</center></td>";
    							      	}
    							      	if ($row['nota']>=3.1 && $row['nota']<=4.4) {
    								      	echo "<td><center>HIGH</center></td>";
    							      	}
    							      	if ($row['nota']>=4.5) {
    								      	echo "<td><center>SUPERIOR</center></td>";
    							      	}
            	      					echo "</tr>";
        							}
								}
						 		echo "</tbody>
								</table>";
							?>
							<h5 class="justifyText" style="font-size: 1.091rem">
								It is issued at the request of the applicant on the (<?php echo $dia; ?>) days of the month of <?php echo $mesLetra;?> of two thousand nineteen (<?php echo $fanio; ?>).
							</h5>
                        </div><!--cierra contenedor general-->
						<div class="row" id="contieneFirmas">
							<?php 
								if ($firmas=="SI") {
									//echo "<img class='img-responsive' width='100%' src='../images/firma_certficados.png'>";
									echo "<img class='img-responsive' width='100%' src='../images/firmas_unicab1.jpg'>";
								}else{
									echo "<img class='img-responsive' width='100%' src='../images/certficados_sinfirmas.png'>";
								}
							?>
						</div><hr>
						<p align="center">
						Calle 13ª N° 16-60 Sogamoso – Boyacá | Phone: 608 7752309 | Cel: 300 815 6531 - 315 696 5291<br>
						www.unicab.org
						</p>
		 			</div>
				</div>
			</div>
			<!--CERTIFICADO-->
			<div align="center">
				<form action="php/Registro-certificado.php" method="POST">
					<input type="text" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy; ?>">
					<input type="text" id="tipoc" name="tipoc" value="Certificado de Estudio">
					<input type="text" name="id_estudiante" value="<?php echo $id_estudiante;?>">
					<input type="text" name="id_grado" value="<?php echo $id_grado;?>">
					<h6>Certificado N°: CS<?php echo $certicado_total; ?></h6>
					<button type="submit" id="hide" class="btn btn-danger" >Certificado</button>
				</form>
	 		</div>
	 		<!-- CERTIFICADO -->
			<?php 
		}
	}
	?>

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
   <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
	<script>
		$(function(){
			$('#hide').click(function(){
				$('#hide').hide();
				window.print();
			});
		})
	</script>
  

</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
<!--<script>
javascript:window.print();
</script>-->
<title><?php echo "CERTIFICATE-OF-REGISTRATION-".$nombreCompleto." UNICAB"; ?></title>
</html>