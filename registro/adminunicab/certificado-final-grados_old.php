<?php
session_start();
require "php/conexion.php";

if (isset($_SESSION['unisuper'])) {

$id_estudiante=$_POST['id'];
$idioma=$_POST['idioma'];
$id_gradoActual=$_POST['id_grado'];
$id_matriculaActual=$_POST['id_matricula'];
$firmas=$_POST['firmas'];

// buscar estudiante
$peticion= "SELECT * FROM estudiantes INNER JOIN matricula ON estudiantes.id=matricula.id_estudiante 
INNER JOIN grados ON matricula.id_grado=grados.id 
WHERE `id_estudiante`=".$id_estudiante." and  matricula.idMatricula=".$id_matriculaActual."";

$resultado = mysqli_query($conexion, $peticion);

while ($fila = mysqli_fetch_array($resultado)){
	$nombreCompleto=$fila['nombres']." ".$fila['apellidos'];
	$genero=$fila['genero'];
	$tipo_documento=$fila['tipo_documento'];
	$n_documento=$fila['n_documento'];
	$expedicion=$fila['expedicion'];
	$ciudad=$fila['ciudad'];
	$grado=$fila['grado'];
	$estado=$fila['estado'];
	$id_grado=$fila['id_grado'];
	$id_matricula=$fila['idMatricula'];
}

if ($genero=="Masculino") {
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
// buscar estudiante

//buscar grado estudiante
$buscarGrado="SELECT * FROM `matricula` WHERE `id_estudiante`=".$id_estudiante." and `id_grado`=".$id_gradoActual." and idMatricula=".$id_matriculaActual."";

$exe_buscarGrado=mysqli_query($conexion,$buscarGrado);
while ($rowBuscar = mysqli_fetch_array($exe_buscarGrado)) {
	$anio=substr($rowBuscar['fecha_ingreso'],  0,4);

	if ($rowBuscar['EstadoGrado']=="reprobado") {
		$mensaje_promovido="Reprobó grado ".$grado;
	}else{
		if ($rowBuscar['id_grado']>=1 && $rowBuscar['id_grado']<=12) {
			if ($rowBuscar['id_grado']==2) {
			$mensaje_promovido="Promovido(a) a grado 2°";
			$mensaje_promovidoIngles="Promoted to grade 2°";
			}else if ($rowBuscar['id_grado']==3) {
				$mensaje_promovido="Promovido(a) a grado 3°";
				$mensaje_promovidoIngles="Promoted to grade 3°";
			}else if ($rowBuscar['id_grado']==4) {
				$mensaje_promovido="Promovido(a) a grado 4°";
				$mensaje_promovidoIngles="Promoted to grade 4°";
			}else if ($rowBuscar['id_grado']==5) {
				$mensaje_promovido="Promovido(a) a grado 5°";
				$mensaje_promovidoIngles="Promoted to grade 5°";
			}else if ($rowBuscar['id_grado']==6) {
				$mensaje_promovido="Promovido(a) a grado 6°";
				$mensaje_promovidoIngles="Promoted to grade 6°";
			}else if ($rowBuscar['id_grado']==7) {
				$mensaje_promovido="Promovido(a) a grado 7°";
				$mensaje_promovidoIngles="Promoted to grade 7°";
			}else if ($rowBuscar['id_grado']==8) {
				$mensaje_promovido="Promovido(a) a grado 8°";
				$mensaje_promovidoIngles="Promoted to grade 8°";
			}else if ($rowBuscar['id_grado']==9) {
				$mensaje_promovido="Promovido(a) a grado 9°";
				$mensaje_promovidoIngles="Promoted to grade 9°";
			}else if ($rowBuscar['id_grado']==10) {
				$mensaje_promovido="Promovido(a) a grado 10°";
				$mensaje_promovidoIngles="Promoted to grade 10°";
			}else if ($rowBuscar['id_grado']==11) {
				$mensaje_promovido="Promovido(a) a grado 11°";
				$mensaje_promovidoIngles="Promoted to grade 11°";
			}else if ($rowBuscar['id_grado']==12) {
				$mensaje_promovido="Estudiante finalizó académicamente";
				$mensaje_promovidoIngles="Cómo se pronuncia student finished academically";
			}
		}
		//ciclos de I a VI
		if ($rowBuscar['id_grado']>=13 && $rowBuscar['id_grado']<=18) {
			if ($rowBuscar['id_grado']==13) {
				$mensaje_promovido="Promovido(a) a Ciclo II";
				$mensaje_promovidoIngles="Promoted to Cycle II";
			}else if ($rowBuscar['id_grado']==14) {
				$mensaje_promovido="Promovido(a) a Ciclo III";
				$mensaje_promovidoIngles="Promoted to Cycle III";	
			}else if ($rowBuscar['id_grado']==15) {
				$mensaje_promovido="Promovido(a) a Ciclo IV";
				$mensaje_promovidoIngles="Promoted to Cycle IV";
			}else if ($rowBuscar['id_grado']==16) {
				$mensaje_promovido="Promovido(a) a Ciclo V";
				$mensaje_promovidoIngles="Promoted to Cycle V";
			}else if ($rowBuscar['id_grado']==17) {
				$mensaje_promovido="Promovido(a) a Ciclo VI";
				$mensaje_promovidoIngles="Promoted to Cycle VI";
			}else if ($rowBuscar['id_grado']==18) {
				$mensaje_promovido="Estudiante Finalizo académicamente por Ciclos";
				$mensaje_promovidoIngles="Student I finish academically by Cycles";
			}
		}
	}
}
//buscar grado estudiante

//certificado
$sql_certificado="SELECT * FROM `certificado`";
$exe_certificado=mysqli_query($conexion,$sql_certificado);
$certicado_total=mysqli_num_rows($exe_certificado);
//certificado

date_default_timezone_set('America/Bogota');
$dia=date("d");
$mes=date("m");
$mesLetra=date("M");
$fanio=date("Y");
$espaniol="";
$fechaHoy1=$fanio."-".$mes."-".$dia;
// echo "Hola ".$fechaHoy;
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
// fechas
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
</head> 
<style>
@media print {
  @page { margin: -0px; }
  body { margin: -17px; margin-top: -60px;}
}
.justifyText{
	text-align : justify;
}
</style>
<body class="cbp-spmenu-push">
	<div class="main-content">
	<?php require 'menu.php';  ?>
<section>
<div id="page-wrapper">
<div>				
      <div class="mid-content-top charts-grids">	
        <div class="middle-content">
<?php
	// numero materias grados de 1 a 9 
	if ($id_grado>=1 && $id_grado<=10) {
		$numerio_materias=9;
	}else if ($id_grado>=11 && $id_grado<=12) {
		$numerio_materias=11;
	}
	else if ($id_grado>=13 && $id_grado<=16) {
		$numerio_materias=6;
	}
	else if ($id_grado>=17 && $id_grado<=18) {
		$numerio_materias=7;
	}

	$sql_notas="SELECT DISTINCT  promedio, estudiantes.id, estudiantes.nombres, estudiantes.genero, materias.materia, materias.materiaIngles, 
	materias.pensamiento, materias.pensamientoingles, grados.grado, matricula.estado 
	from ((((historial_notas INNER JOIN estudiantes ON historial_notas.id_estudiante=estudiantes.id) INNER JOIN materias ON historial_notas.id_materia=materias.Id) 
	INNER JOIN matricula ON matricula.id_estudiante=estudiantes.id) INNER JOIN grados ON historial_notas.id_grado=grados.id) 
	where estudiantes.id=".$id_estudiante." and matricula.estado='inactivo' and grados.id=".$id_grado." ORDER BY materias.pensamiento";
	$exe_notas=mysqli_query($conexion,$sql_notas);
	$num_notas=mysqli_num_rows($exe_notas);


	if ($num_notas==$numerio_materias) {
		//se extraen las notas
		$sql_notas="SELECT DISTINCT  promedio, estudiantes.id, estudiantes.nombres, estudiantes.genero, materias.materia, materias.materiaIngles, 
		materias.pensamiento, materias.pensamientoingles, grados.grado, matricula.estado 
		from ((((historial_notas INNER JOIN estudiantes ON historial_notas.id_estudiante=estudiantes.id) INNER JOIN materias ON historial_notas.id_materia=materias.Id) 
		INNER JOIN matricula ON matricula.id_estudiante=estudiantes.id) INNER JOIN grados ON historial_notas.id_grado=grados.id) 
		where estudiantes.id=".$id_estudiante." and matricula.estado='inactivo' and grados.id=".$id_grado." ORDER BY materias.pensamiento ASC";
	}else{
		//se extraen notas duplicadas
		$sql_notas="SELECT DISTINCT  promedio, estudiantes.id, estudiantes.nombres, estudiantes.genero, materias.materia, materias.materiaIngles, 
		materias.pensamiento, materias.pensamientoingles, grados.id as id_grados, grados.grado, matricula.estado 
		from ((((historial_notas INNER JOIN estudiantes ON historial_notas.id_estudiante=estudiantes.id) INNER JOIN materias ON historial_notas.id_materia=materias.Id) 
		INNER JOIN matricula ON matricula.idMatricula=historial_notas.id_matricula) INNER JOIN grados ON historial_notas.id_grado=grados.id) 
		where estudiantes.id=".$id_estudiante." and matricula.estado='inactivo' and grados.id=".$id_gradoActual." and matricula.idMatricula='".$id_matriculaActual."' 
		ORDER BY materias.pensamiento ASC";
	}
	$sql_nota=$sql_notas;
	
	$exe_notas1=mysqli_query($conexion,$sql_nota);

	// buscar pensamiento
	$sql_pensamiento="SELECT grado_materia.id_grado, grados.grado, materias.materia, materias.pensamiento
	FROM materias INNER JOIN (grados INNER JOIN grado_materia ON grados.id = grado_materia.id_grado) ON materias.Id = grado_materia.id_materia 
	WHERE grados.id=".$id_grado."";
	$exe_pensamiento=mysqli_query($conexion,$sql_pensamiento);
	while ($rowP=mysqli_fetch_array($exe_pensamiento)) {
		if ($rowP['pensamiento']=="BIOETICO") {
			$bio="BIOETICO";
		}
		if ($rowP['pensamiento']=="HUMANÍSTICO") {
			$huma="HUMANÍSTICO";
		}
	}
	// buscar pensamiento
	$total_materias=mysqli_num_rows($exe_notas);
	$pasada=0;
	$perdida=0;

	while ($fila_promedio=mysqli_fetch_array($exe_notas)) {
		$promedio=$fila_promedio['promedio'];
		$grado_encurso=$fila_promedio['grado'];
		$genero=$fila_promedio['genero'];
		if ($promedio>=3.0) {
			$pasada++;
		}
		else{
			$perdida++;
		}
	}

	if ($perdida>=1) {
		$mensaje="cursó y reprobó";
		$mensajeIngles="studied and failed";
	}else{
		$mensaje="cursó y aprobó";
		$mensajeIngles="studied  and approved";
	}
	
	if ($genero=="Femenino") {
		$genero_estudiante="la";
		$promovio="Promovida";
	}else{
		$genero_estudiante="el";
		$promovio="Promovido";
	}
	
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
		?>  	
		<!--CERTIFICADO-->
		    <div class="panel panel-default">
  				<div class="panel-body" align="center">
				 	<img class="img-responsive" width="140px" src="../images/logo20.png"><br>
					<h6 align="center" style="font-size: 1rem; text-align: center;">	
	      				<strong>UNICAB VIRTUAL</strong>, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la Secretaría de Educación y Cultura de Sogamoso según resolución 061 del 15 de diciembre de 2007, y Resolución Nº 0155 21 de Julio de 2010 y Resolución No. 326 del 22 de septiembre de 2015, para todos los niveles de Educación Básica Primaria, Básica Secundaria y Media Académica,
					</h6><br><br>
					<h4 style="font-weight: bold; font-size: 1rem;">LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL</h4><br><br>
                     <div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
					<h3 style="font-weight: bold; font-size: 1rem;">CERTIFICAN:</h3><br>
					<h5 class="justifyText" style="font-size: 1rem;">
						Que <?php echo $variable; ?> estudiante, <b><?php echo $nombreCompleto?></b>, <?php echo $variableDos; ?> con <?php echo $tipo_documento; ?> No. <?php echo $n_documento?> expedida en <?php echo $expedicion; ?>, <?php echo $mensaje; ?> el grado <strong><?php echo mb_strtoupper($grado); ?></strong> de <strong><?php echo 	mb_strtoupper($nivelEducativo); ?></strong>, durante el año lectivo <?php echo $anio; ?> cumpliendo con los siguientes logros establecidos y valoraciones que a continuación se especifican el boletín parcial de calificaciones:
					</h5><br>
					<table border="1" bordercolor="#e0e0e0" style="font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">
				  	<thead>
					    <tr>
				    		<th style="text-align: center;">Pensamiento</th>
					      	<th style="text-align: center;">AREA-Asignatura</th>
					      	<th style="text-align: center;">VALORACIÓN</th>
					      	<th style="text-align: center;">NIVEL DE DESEMPEÑO</th>
					    </tr>
				  	</thead>
				 	<tbody>
				 		<?php
				 		while ($row=mysqli_fetch_array($exe_notas1)) {
			 				echo " <tr>
			 				<td style='text-align:center;'>".$row['pensamiento']."&nbsp;&nbsp;</td>
	      					<td style='text-align:center;'>".$row['materia']."</td>
	      					<td style='text-align:center;'>".$row['promedio']."</td>";
					      	if ($row['promedio']<=3.0) {
						      	echo "<td style='text-align:center;'>BAJO</td>";
					      	}
					      	if ($row['promedio']>=3.1 && $row['promedio']<=4.4) {
						      	echo "<td style='text-align:center;'>ALTO</center></td>";
					      	}
					      	if ($row['promedio']>=4.5) {
						      	echo "<td style='text-align:center;'>SUPERIOR</center></td>";
					      	}
	      					echo "</tr>";
						}
				 		echo "</tbody>
						</table>";
						?>
						<br>
						<div style="text-align: left;">
						<p style="border: black 2px solid; text-align: left;  border-width: thin; width:30%; font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem;"><strong><?php echo $mensaje_promovido;?></strong></p>
						</div>
						<br>
					<h5 class="justifyText">Expedido en Sogamoso a los <?php echo $dia; ?> días del mes de <?php echo $espaniol; ?> de <?php echo $fanio; ?>
					</h5>
                    </div><!--cierra contenedor general-->
                    <?php 
						if ($firmas=="SI") {
							echo "<img class='img-responsive' width='90%' src='../images/firma_certficados.png'>";
						}else{
							echo "<img class='img-responsive' width='90%' src='../images/certficados_sinfirmas.png'>";
						}
					?>
					<hr>
					<p id="pie-pagina" align="center">
					Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 3156965291 - 3158895275<br>
					www.unicab.org
					</p>
 				</div>
			</div>
			<!--CERTIFICADO-->
			<div align="center">
				<form action="php/Registro-certificado.php" method="POST">
					<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy1; ?>">
					<input type="hidden" id="tipoc" name="tipoc" value="Certificado final de año">
					<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
					<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
					<h6>Certificado N°: CS<?php echo $certicado_total; ?></h6>
					<button type="submit" id="hide" class="btn btn-danger">Certificado</button>
				</form>
 			</div>
 		</div>
	 		<?php
	}
 	// fin certificado español
	
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
		?>
		<!--CERTIFICADO-->
			<div class="panel panel-default">
				<div class="panel-body" align="center">
					<img class="img-responsive" width="140px" src="../images/logo20.png"><br>
					

					<h6 align="center" style="font-size: 1rem; text-align: center;">
	      			<strong>UNICAB VIRTUAL</strong>, DANE CODE 315759002653, ICFES CODE 154567, operating license from education and culture secretary of Sogamoso according to administrative resolution N° 061 on December 15<sup>th</sup> in 2007 and  administrative resolution N° 326 on September 22<sup>nd</sup> in 2015,  for all education levels preschool, elementary, secondary and high school</h6><br><br>

	      			<h4 style="font-weight: bold; font-size: 1rem;">THE RECTOR  AND ACADEMIC SECRETARY OF THE UNICAB VIRTUAL SCHOOL</h4><br><br>
					<div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
	      			<h3 style="font-weight: bold; font-size: 1rem;">CERTIFY:</h3><br>
					<h5 class="justifyText" style="font-size: 1rem;">
					That the student <b><?php echo $nombreCompleto?></b>, with I.D. N° <?php echo $n_documento?> from <?php echo $ciudad?>, <?php echo $mensajeIngles; ?> the <?php  echo $grado." ".$nivelEducativo; ?>, during the  school year <?php echo $anio; ?>  fulfilling the following established achievements and evaluations that the partial report card is specified below:</h5>
					<br>
					<table border="1" bordercolor="#e0e0e0" style="font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">
				  	<thead>
				  	<thead>
					    <tr>
				    		<th style="text-align: center;">THOUGHT</th>
					      	<th style="text-align: center;">SUBJECT</th>
					      	<th style="text-align: center;">ASSESSMENT</th>
					      	<th style="text-align: center;">PERFORMANCE LEVEL</th>
					    </tr>
				  	</thead>
				 	<tbody>
				 		<?php
				 		while ($rowBuscar=mysqli_fetch_array($exe_notas1)) {
			 				echo " <tr>
			 				<td style='text-align:center;'>".$rowBuscar['pensamientoingles']."</td>
	      					<td style='text-align:center;'>".$rowBuscar['materiaIngles']."</td>
	     		 			<td style='text-align:center;'>".$rowBuscar['promedio']."</td>";
					      	if ($rowBuscar['promedio']<=3.0) {
						      	echo "<td style='text-align:center;'>LOW</td>";
					      	}
					      	if ($rowBuscar['promedio']>=3.1 && $rowBuscar['promedio']<=4.4) {
						      	echo "<td style='text-align:center;'>HIGH</td>";
					      	}
					      	if ($rowBuscar['promedio']>=4.5) {
						      	echo "<td style='text-align:center;'>SUPERIOR</td>";
					      	}
	      					echo "</tr>";
						}
				 		echo "</tbody>
						</table>";

						?>
						<br>
						<div style="text-align: left;">
						<p style="border: black 2px solid; text-align: left;  border-width: thin; width:30%; font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem;"><strong><?php echo $mensaje_promovidoIngles;?></strong></p>
						</div>
						<br>
						<!--  -->
						<h5 class="justifyText">Certificate issued in Sogamoso on <?php echo $dia; ?> días del mes de <?php echo $espaniol; ?> de <?php echo $fanio; ?>
						</h5>
                        </div><!--cierre contenedor general-->
                        <?php 
							if ($firmas=="SI") {
								echo "<img class='img-responsive' width='90%' src='../images/firma_certficados.png'>";
							}else{
								echo "<img class='img-responsive' width='90%' src='../images/certficados_sinfirmas.png'>";
							}
						?>
						<p id="pie-pagina" align="center">
						Calle 13ª N° 16-60 Sogamoso – Boyacá Tel. 0987 701685 Cel. 3156965291 - 3158895275<br>
						www.unicab.org
						</p>
					</p>
	 			</div>
			</div>
			<!--CERTIFICADO-->
			<div align="center">
				<form action="php/Registro-certificado.php" method="POST">
					<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy; ?>">
					<input type="hidden" id="tipoc" name="tipoc" value="Certificado final de año">
					<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
					<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
					<h6>Certificado N°: CS<?php echo $certicado_total; ?></h6>
					<button type="submit" id="hide" class="btn btn-danger">Certificate</button>
				</form>
 			</div>
		<?php
	}
	//fin certificado español
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