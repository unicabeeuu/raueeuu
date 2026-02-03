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
    		$n_documento_emp = $fila['n_documento'];
    		$password = $fila['pc'];
    		$perfil = $fila['perfil'];
    	}
        //echo $id;
        
        $id_estudiante = $_REQUEST['id'];
        $idioma = $_REQUEST['idioma'];
        $id_gradoActual = $_REQUEST['id_grado'];
        $id_matriculaActual = $_REQUEST['id_matricula'];
        $firmas = $_REQUEST['firmas'];
        $n_documeto = $_REQUEST['n_documentof'];
        //echo $id_gradoActual;
    
        // buscar estudiante
		$id_grado = 0;
        /*$peticion= "SELECT e.nombres, e.apellidos, e.genero, e.tipo_documento, e.n_documento, e.expedicion, e.ciudad, g.grado, 
            m.estado, g.id, m.idMatricula, m.fecha_ingreso, m.n_matricula 
            FROM estudiantes e INNER JOIN matricula m ON e.id = m.id_estudiante 
            INNER JOIN grados g ON m.id_grado=g.id 
            WHERE m.id_estudiante=".$id_estudiante." and m.idMatricula=".$id_matriculaActual."";*/
        $peticion= "SELECT e.nombres, e.apellidos, e.genero, td.tipo_documento, e.n_documento, e.expedicion, e.ciudad, g.grado, g.id, 
            m.estado, g.id, m.idMatricula, m.fecha_ingreso, m.n_matricula 
            FROM estudiantes e INNER JOIN 
            (SELECT * FROM matricula WHERE idMatricula = 
            (SELECT MAX(idMatricula) maxid FROM matricula WHERE id_estudiante = ".$id_estudiante." AND estado IN ('aprobado', 'reprobado', 'activo'))) m ON e.id = m.id_estudiante 
            INNER JOIN grados g ON m.id_grado=g.id INNER JOIN tbl_tipos_documento td ON e.tipo_documento = td.id 
            WHERE m.id_estudiante=".$id_estudiante." and m.idMatricula=".$id_matriculaActual."";
        //echo $peticion;
        
        $resultado = mysqli_query($conexion, $peticion);
        
        while ($fila1 = mysqli_fetch_array($resultado)){
            //echo "Entra al ciclo";
        	$nombreCompleto=$fila1['nombres']." ".$fila1['apellidos'];
        	$genero=$fila1['genero'];
        	$tipo_documento=$fila1['tipo_documento'];
        	$n_documento=$fila1['n_documento'];
        	$expedicion=$fila1['expedicion'];
        	$ciudad=$fila1['ciudad'];
        	$grado=$fila1['grado'];
        	$estado=$fila1['estado'];
        	$id_grado=$fila1['id'];
        	$id_matricula=$fila1['idMatricula'];
        	$n_matricula=$fila1['n_matricula'];
        	$anio=substr($fila1['fecha_ingreso'],  0,4);
        }
        //echo $n_matricula;
        //echo $estado;
        //echo $id_grado;
        //echo $genero;
        
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
        //echo $variable;
        //echo "<br/>".$variableDos;
        //echo "<br/>".$variableTres;
        //echo "<br/>".$variableCuatro;
        
        if ($estado == "reprobado") {
    		$mensaje_promovido="Reprobó grado ".$grado;
    		$mensaje_promovidoIngles="Failes grade ".$grado;
    	}
    	else{
    	    if($id_grado == 2) {
    	        $mensaje_promovido="Promovido(a) a grado 2°";
        		$mensaje_promovidoIngles="Promoted to grade 2°";
    	    }
    	    else if($id_grado == 3) {
    	        $mensaje_promovido="Promovido(a) a grado 3°";
        		$mensaje_promovidoIngles="Promoted to grade 3°";
    	    }
    	    else if($id_grado == 4) {
    	        $mensaje_promovido="Promovido(a) a grado 4°";
        		$mensaje_promovidoIngles="Promoted to grade 4°";
    	    }
    	    else if($id_grado == 5) {
    	        $mensaje_promovido="Promovido(a) a grado 5°";
        		$mensaje_promovidoIngles="Promoted to grade 5°";
    	    }
    	    else if($id_grado == 6) {
    	        $mensaje_promovido="Promovido(a) a grado 6°";
        		$mensaje_promovidoIngles="Promoted to grade 6°";
    	    }
    	    else if($id_grado == 7) {
    	        $mensaje_promovido="Promovido(a) a grado 7°";
        		$mensaje_promovidoIngles="Promoted to grade 7°";
    	    }
    	    else if($id_grado == 8) {
    	        $mensaje_promovido="Promovido(a) a grado 8°";
        		$mensaje_promovidoIngles="Promoted to grade 8°";
    	    }
    	    else if($id_grado == 9) {
    	        $mensaje_promovido="Promovido(a) a grado 9°";
        		$mensaje_promovidoIngles="Promoted to grade 9°";
    	    }
    	    else if($id_grado == 10) {
    	        $mensaje_promovido="Promovido(a) a grado 10°";
        		$mensaje_promovidoIngles="Promoted to grade 10°";
    	    }
    	    else if($id_grado == 11) {
    	        $mensaje_promovido="Promovido(a) a grado 11°";
        		$mensaje_promovidoIngles="Promoted to grade 11°";
    	    }
    	    else if($id_grado == 12) {
    	        $mensaje_promovido="Estudiante finalizó académicamente";
    			$mensaje_promovidoIngles="Student finished academically";
    	    }
    	    else if($id_grado == 13) {
    	        $mensaje_promovido="Promovido(a) a Ciclo II";
    			$mensaje_promovidoIngles="Promoted to Cycle II";
    	    }
    	    else if($id_grado == 14) {
    	        $mensaje_promovido="Promovido(a) a Ciclo III";
    			$mensaje_promovidoIngles="Promoted to Cycle III";
    	    }
    	    else if($id_grado == 15) {
    	        $mensaje_promovido="Promovido(a) a Ciclo IV";
    			$mensaje_promovidoIngles="Promoted to Cycle IV";
    	    }
    	    else if($id_grado == 16) {
    	        $mensaje_promovido="Promovido(a) a Ciclo V";
    			$mensaje_promovidoIngles="Promoted to Cycle V";
    	    }
    	    else if($id_grado == 17) {
    	        $mensaje_promovido="Promovido(a) a Ciclo VI";
    			$mensaje_promovidoIngles="Promoted to Cycle VI";
    	    }
    	    else if($id_grado == 18) {
    	        $mensaje_promovido="Estudiante Finalizo académicamente por Ciclos";
    			$mensaje_promovidoIngles="Student I finish academically by Cycles";
    	    }
    	}
    	//echo $mensaje_promovido;
    	
    	date_default_timezone_set('America/Bogota');
        $dia=date("d");
        $mes=date("m");
        $mesLetra=date("M");
        $fanio=date("Y");
        $espaniol="";
        $fechaHoy1=$fanio."-".$mes."-".$dia;
    	
        //certificado
        //Se busca si ya existe un certificado para el año y el estudiante
        //$numero1 = $fanio * 10000;
        //$parame = "%CFF".$fanio."%";
        //$parami = "%CFIF".$fanio."%";
		$parame = "%CFF%";
        $parami = "%CFIF%";
        $ct = 0;
        if($idioma == "espanol") {
            /*$sql_validacion = "SELECT COUNT(1) ct, numero, numero1 FROM certificado WHERE id_estudiante = $id_estudiante AND numero like '$parame' AND numero1 > $numero1 
            GROUP BY numero, numero1";*/
			$sql_validacion = "SELECT COUNT(1) ct, numero, numero1 FROM certificado WHERE id_estudiante = $id_estudiante AND numero like '$parame' AND id_grado = $id_gradoActual 
            GROUP BY numero, numero1";
        }
        else if($idioma == "ingles") {
            /*$sql_validacion = "SELECT COUNT(1) ct, numero, numero1 FROM certificado WHERE id_estudiante = $id_estudiante AND numero like '$parami' AND numero1 > $numero1 
            GROUP BY numero, numero1";*/
			$sql_validacion = "SELECT COUNT(1) ct, numero, numero1 FROM certificado WHERE id_estudiante = $id_estudiante AND numero like '$parami' AND id_grado = $id_gradoActual 
            GROUP BY numero, numero1";
        }
        //echo $sql_validacion;
        $res_validacion = mysqli_query($conexion, $sql_validacion);
        
        while ($filav = mysqli_fetch_array($res_validacion)){
            $ct = $filav['ct'];
            $certicado_total=$filav['numero1'];
        }
        //echo $certicado_total;
        
        if($ct == 0) {
            $sql_certificado="SELECT MAX(id) id FROM `certificado`";
            $exe_certificado=mysqli_query($conexion,$sql_certificado);
            //$certicado_total=mysqli_num_rows($exe_certificado);
            while ($filamax = mysqli_fetch_array($exe_certificado)){
                $certicado_total = $filamax['id'] + 1;
            }
        }
        //certificado
        
        // echo "Hola ".$fechaHoy;
        switch ($mes) {
        	case '1':
        		$espaniol="Enero";
        		$mesi = "January";
        		break;
        	case '2':
        		$espaniol="Febrero";
        		$mesi = "February";
        		break;
        	case '3':
        		$espaniol="Marzo";
        		$mesi = "March";
        		break;
        	case '4':
        		$espaniol="Abril";
        		$mesi = "April";
        		break;
        	case '5':
        		$espaniol="Mayo";
        		break;
        	case '6':
        		$espaniol="Junio";
        		$mesi = "June";
        		break;
        	case '7':
        		$espaniol="Julio";
        		$mesi = "July";
        		break;
        	case '8':
        		$espaniol="Agosto";
        		$mesi = "August";
        		break;
        	case '9':
        		$espaniol="Septiembre";
        		$mesi = "September";
        		break;
        	case '10':
        		$espaniol="Octubre";
        		$mesi = "October";
        		break;
        	case '11':
        		$espaniol="Noviembre";
        		$mesi = "November";
        		break;
        	case '12':
        		$espaniol="Diciembre";
        		$mesi = "December";
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
	<?php //require 'menu.php';  ?>
	<?php 
	    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		//if($id == 18 ) {
	        require 'menu_registro.php';
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
<?php
	$tabla = "notas";
	
	//Se valida si hay notas en la tabla de notas
	$sql_ct_notas = "SELECT COUNT(1) ct FROM notas WHERE id_estudiante = $id_estudiante AND id_grado = ".$id_gradoActual;
	//echo $sql_ct_notas;
	$res_ct_notas = mysqli_query($conexion, $sql_ct_notas);
    while ($ct_notas = mysqli_fetch_array($res_ct_notas)){
        $ct_tabla_notas = $ct_notas['ct'];
    }
    
	//echo $ct_tabla_notas;
	if($ct_tabla_notas > 0) {
	    if($id_gradoActual == 17 || $id_gradoActual == 18) {
        	$sql_nota="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.materiaingles, p1.pensamiento, p1.pensamientoingles, p1.id id_materia, p1.id_grado, p1.grado, 
                p1.nota P1, p2.nota P2, cast((p1.nota + p2.nota)/2 as decimal(10,1)) as promedio 
                FROM 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_gradoActual AND p.id = 1) p1, 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_gradoActual AND p.id = 2) p2 
                WHERE p1.id_estudiante = p2.id_estudiante  
                AND p1.id = p2.id  
                AND p1.id_grado = p2.id_grado  
                ORDER BY 2";
    	}
    	else {
    	    $sql_nota="SELECT DISTINCT p1.id_estudiante, p1.materia, p1.materiaingles, p1.pensamiento, p1.pensamientoingles, p1.id id_materia, p1.id_grado, p1.grado, 
                p1.nota P1, p2.nota P2, p3.nota P3, p4.nota P4, cast((p1.nota + p2.nota + p3.nota + p4.nota)/4 as decimal(10,1)) as promedio 
                FROM 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_gradoActual AND p.id = 1) p1, 
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_gradoActual AND p.id = 2) p2,
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_gradoActual AND p.id = 3) p3,
                (SELECT DISTINCT e.id id_estudiante, m.materia, m.materiaingles, m.pensamiento, m.pensamientoingles, m.id, g.id id_grado, g.grado, n.nota 
                FROM $tabla n, estudiantes e, materias m, grados g, periodos p 
                WHERE n.id_estudiante = e.id AND n.id_materia = m.Id AND n.id_grado = g.id AND n.id_periodo = p.id 
                AND e.id = $id_estudiante AND g.id = $id_gradoActual AND p.id = 4) p4 
                WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_estudiante = p3.id_estudiante AND p1.id_estudiante = p4.id_estudiante 
                AND p1.id = p2.id  AND p1.id = p3.id  AND p1.id = p4.id 
                AND p1.id_grado = p2.id_grado AND p1.id_grado = p3.id_grado AND p1.id_grado = p4.id_grado 
                ORDER BY 2";
    	}
    	//echo $sql_nota;
	
    	$exe_notas1=mysqli_query($conexion,$sql_nota);
    	$exe_notas2=mysqli_query($conexion,$sql_nota);
    
    	$total_materias=mysqli_num_rows($exe_notas1);
    	$pasada=0;
    	$perdida=0;
        //echo $total_materias;
    
    	while ($fila_promedio=mysqli_fetch_array($exe_notas1)) {
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
    	//echo $perdida;
	}
	else {
	    //Se capturan las notas en la tabla tbl_notas_historia
	    $sql_nota = "SELECT * FROM tbl_notas_historia WHERE id_est = ".$id_estudiante." AND n_matricula = '$n_matricula'";
	    //echo $sql_nota;
	    $exe_notas1=mysqli_query($conexion,$sql_nota);
    	
    	//$total_materias=mysqli_num_rows($exe_notas1);
    	$pasada=0;
    	$perdida=0;
        //echo $total_materias;
    
    	while ($fila_promedio=mysqli_fetch_array($exe_notas1)) {
    	    $json = $fila_promedio['json'];
    	}
    	//echo $json;
    	$obj = json_decode($json);
        $perdida = $obj->{'perdidas'};
        $calif = $obj->{'calificaciones'};
        $json_id_grado = $obj->{'id_grado'};
	}
	//$tabla = "historial_notas";

	if ($perdida>=1) {
		$mensaje="cursó y reprobó";
		$mensajeIngles="studied and failed";
		$mensaje_promovido="Reprobó grado ".$grado;
    	$mensaje_promovidoIngles="Failes grade ".$grado;
	}else{
		$mensaje="cursó y aprobó";
		$mensajeIngles="studied and approved";
	}
	
	if ($genero=="Femenino") {
		$genero_estudiante="la";
		$promovio="Promovida";
	}else{
		$genero_estudiante="el";
		$promovio="Promovido";
	}
	//echo $grado;
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
		<!--CERTIFICADO  ********************************** AQUI VOY ***** comparar con reporte_notas_getdat1.php -->
		    <div class="panel panel-default">
  				<div class="panel-body" align="center">
				 	<!--<img class="img-responsive" width="140px" src="../images/logo20.png"><br>-->
					<img class="img-responsive" width="140px" src="../images/logo3_2025.jpg"><br>
					<h6 align="center" style="font-size: 1rem; text-align: center;">	
	      				<strong>UNICAB VIRTUAL</strong>, CODIGO DANE 315759002653, CODIGO ICFES 154567, Licencia de funcionamiento de la Secretaría de Educación y Cultura de Sogamoso según resolución 061 del 15 de diciembre de 2007, y Resolución Nº 0155 21 de Julio de 2010 y Resolución No. 326 del 22 de septiembre de 2015, para todos los niveles de Educación Básica Primaria, Básica Secundaria y Media Académica,
					</h6><br><br>
					<h4 style="font-weight: bold; font-size: 1rem;">LA RECTORA Y SECRETARIA ACADÉMICA DEL COLEGIO UNICAB VIRTUAL</h4><br><br>
                     <div id="contenedorMarcaDeAgua" align="left">
                            <!--<img id="marcaDeAgua"  src="../images/macadeagua.jpg" width="1050px">-->
							<img id="marcaDeAgua"  src="../images/marcaagua28_2025.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
					<h3 style="font-weight: bold; font-size: 1rem;">CERTIFICAN:</h3><br>
					<h5 class="justifyText" style="font-size: 1rem;">
						Que <?php echo $variable; ?> estudiante, <b><?php echo $nombreCompleto?></b>, <?php echo $variableDos; ?> con <?php echo $tipo_documento; ?> No. <?php echo $n_documento?> expedida en <?php echo $expedicion; ?>, <?php echo $mensaje; ?> el grado <strong><?php echo mb_strtoupper($grado); ?></strong> de <strong><?php echo 	mb_strtoupper($nivelEducativo); ?></strong>, durante el año lectivo <?php echo $anio; ?> cumpliendo con los siguientes logros establecidos y valoraciones que a continuación se especifican el boletín parcial de calificaciones:
					</h5><br>
					<table border="1" bordercolor="#000000" style="border-collapse:separate; border-spacing:2px; font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">
				  	<thead style="background: gray; color: white;">
					    <tr>
				    		<th style="text-align: center;">Pensamiento</th>
					      	<th style="text-align: center;">AREA-Asignatura</th>
					      	<th style="text-align: center;">VALORACIÓN</th>
					      	<th style="text-align: center;">NIVEL DE DESEMPEÑO</th>
					    </tr>
				  	</thead>
				 	<tbody style="font-weight: bold;">
				 		<?php
				 		    if($ct_tabla_notas > 0) {
        				 		while ($row=mysqli_fetch_array($exe_notas2)) {
        				 		    echo " <tr>
        			 				<td style='text-align:center;'>".$row['pensamiento']."&nbsp;&nbsp;</td>
        	      					<td style='text-align:center;'>".$row['materia']."</td>
        	      					<td style='text-align:center;'>".$row['promedio']."</td>";
        	      					//echo $row['promedio'];
        	      					if ($row['promedio']<3.0) {
        	      					    $nivel = "BAJO";
        	      					}
        	      					else if ($row['promedio']>=3.0 && $row['promedio']<=3.9) {
        	      					    $nivel = "BASICO";
        	      					}
        	      					else if ($row['promedio']>=4.0 && $row['promedio']<=4.5) {
        	      					    $nivel = "ALTO";
        	      					}
        	      					else if ($row['promedio']>4.5) {
        	      					    $nivel = "SUPERIOR";
        	      					}
        					      	/*if ($row['promedio']<=3.0) {
        						      	//echo "<td style='text-align:center;'>BAJO</td>";
        					      	}
        					      	if ($row['promedio']>=3.1 && $row['promedio']<=4.4) {
        						      	//echo "<td style='text-align:center;'>ALTO</center></td>";
        					      	}
        					      	if ($row['promedio']>=4.5) {
        						      	//echo "<td style='text-align:center;'>SUPERIOR</center></td>";
        					      	}*/
        					      	echo "<td style='text-align:center;'>".$nivel."</center></td>";
        	      					echo "</tr>";
        	      					if ($row['id_grado']>=17) {
        	      					    //esta validación es para las asignaturas de bioético y humanístico
        	      					    if($row['id_materia'] == 10) {
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>EDUCACIÓN ÉTICA Y EN VALORES</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>EDUCACIÓN FÍSICA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
            							else if($row['id_materia'] == 15) {
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>FILOSOFÍA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
        	      					}
        	      					else {
        	      					    //esta validación es para las asignaturas de bioético y humanístico
            							if($row['id_materia'] == 10 || $row['id_materia'] == 1) {
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>EDUCACIÓN ÉTICA Y EN VALORES</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>EDUCACIÓN FÍSICA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
            							else if($row['id_materia'] == 15) {
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>FILOSOFÍA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
            							else if($row['id_materia'] == 6) {
            								echo "<tr><td style='text-align:center;'>".$row['pensamiento']."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$row['promedio']."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
        	      					}
        						}
				 		    }
				 		    else {
				 		        foreach($calif as $promedios) {
                                    $json_id_mat = $promedios->{'id_mat'};
                                    $json_nfinal = $promedios->{'nfinal'};
                                    //Se busca el pensamiento y la materia
                                    $sql_materia = "SELECT * FROM materias WHERE id = ".$json_id_mat;
                                    $exe_materia=mysqli_query($conexion,$sql_materia);
                                	while ($fila_materia = mysqli_fetch_array($exe_materia)) {
                                	    $pensamiento = $fila_materia['pensamiento'];
                                	    $materia = $fila_materia['materia'];
                                	}
                                    
                                    echo " <tr>
        			 				<td style='text-align:center;'>".$pensamiento."&nbsp;&nbsp;</td>
        	      					<td style='text-align:center;'>".$materia."</td>
        	      					<td style='text-align:center;'>".$json_nfinal."</td>";
        	      					if ($json_nfinal < 3.0) {
        	      					    $nivel = "BAJO";
        	      					}
        	      					else if ($json_nfinal >= 3.0 && $json_nfinal <= 3.9) {
        	      					    $nivel = "BASICO";
        	      					}
        	      					else if ($json_nfinal >= 4.0 && $json_nfinal <= 4.5) {
        	      					    $nivel = "ALTO";
        	      					}
        	      					else if ($json_nfinal > 4.5) {
        	      					    $nivel = "SUPERIOR";
        	      					}
        					      	echo "<td style='text-align:center;'>".$nivel."</center></td>";
        	      					echo "</tr>";
        	      					if ($json_id_grado >= 17) {
        	      					    //esta validación es para las asignaturas de bioético y humanístico
        	      					    if($json_id_mat == 10) {
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN ÉTICA Y EN VALORES</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN FÍSICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
            							else if($json_id_mat == 15) {
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>FILOSOFÍA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
        	      					}
        	      					else {
        	      					    //esta validación es para las asignaturas de bioético y humanístico
            							if($json_id_mat == 10 || $json_id_mat == 1) {
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN ÉTICA Y EN VALORES</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>EDUCACIÓN FÍSICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
            							else if($json_id_mat == 15) {
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$json_nfinal."</td><td>".$nivel."</td></tr>";
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>FILOSOFÍA</td><td style='text-align:center;'>".$json_nfinal."</td><td>".$nivel."</td></tr>";
            							}
            							else if($json_id_mat == 6) {
            								echo "<tr><td style='text-align:center;'>".$pensamiento."</td><td style='text-align:center;'>ARTISTICA</td><td style='text-align:center;'>".$json_nfinal."</td><td style='text-align:center;'>".$nivel."</td></tr>";
            							}
        	      					}
                                }
                                //echo $calif[0]->{'nfinal'};
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
							echo "<img class='img-responsive' width='70%' src='../images/firma_certificados_liliana.jpg'>";
							//echo "<img class='img-responsive' width='800' height='190' src='../images/firmas1.jpg'>";
						}else{
							echo "<img class='img-responsive' width='70%' src='../images/firma_certificados_liliana_sf.jpg'>";
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
				<form action="php/Registro-certificado.php" method="POST" target="_blank">
					<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy1; ?>">
					<input type="hidden" id="tipoc" name="tipoc" value="Certificado final de año">
					<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
					<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
					<input type="hidden" name="matricula_actual" value="<?php echo $n_matricula;?>">
					<input type="hidden" name="idioma" value="<?php echo $idioma;?>">
					<input type="hidden" name="firmas" value="<?php echo $firmas;?>">
					<input type="hidden" name="n_certif" value="<?php echo $certicado_total;?>">
					<?php  
					    if($ct == 0) {
					        //echo '<h6>Certificado N°: CFF'.$certicado_total.'</h6>';
					    }
					    else {
					        //echo '<h6>Certificado N°: '.$certicado_total.'</h6>';
					    }
					?>
					<h6>Certificado N°: CFF<?php echo $certicado_total; ?></h6>
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
					<!--<img class="img-responsive" width="140px" src="../images/logo20.png"><br>-->
					<img class="img-responsive" width="140px" src="../images/logo3_2025.jpg"><br>
					

					<h6 align="center" style="font-size: 1rem; text-align: center;">
	      			<strong>UNICAB VIRTUAL</strong>, DANE CODE 315759002653, ICFES CODE 154567, operating license from education and culture secretary of Sogamoso according to administrative resolution N° 061 on December 15<sup>th</sup> in 2007 and  administrative resolution N° 326 on September 22<sup>nd</sup> in 2015,  for all education levels preschool, elementary, secondary and high school</h6><br><br>

	      			<h4 style="font-weight: bold; font-size: 1rem;">THE RECTOR  AND ACADEMIC SECRETARY OF THE UNICAB VIRTUAL SCHOOL</h4><br><br>
					<div id="contenedorMarcaDeAgua" align="left">
                            <img id="marcaDeAgua"  src="../images/marcaagua28_2025.jpg" width="1050px">
                        </div>
                        <div id="contenedorGeneral">
	      			<h3 style="font-weight: bold; font-size: 1rem;">CERTIFY:</h3><br>
					<h5 class="justifyText" style="font-size: 1rem;">
					That the student <b><?php echo $nombreCompleto?></b>, with I.D. N° <?php echo $n_documento?> from <?php echo $ciudad?>, <?php echo $mensajeIngles; ?> the <?php  echo $grado." ".$nivelEducativo; ?>, during the  school year <?php echo $anio; ?>  fulfilling the following established achievements and evaluations that the partial report card is specified below:</h5>
					<br>
					<!--<table border="1" bordercolor="#e0e0e0" style="font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">-->
					<table border="1" bordercolor="#000000" style="border-collapse:separate; border-spacing:2px; font-family: 'PT Sans Narrow', sans-serif; font-size: 1rem; width:100%">
				  	<thead style="background: gray; color: white;">
					    <tr>
				    		<th style="text-align: center;">THOUGHT</th>
					      	<th style="text-align: center;">SUBJECT</th>
					      	<th style="text-align: center;">ASSESSMENT</th>
					      	<th style="text-align: center;">PERFORMANCE LEVEL</th>
					    </tr>
				  	</thead>
				 	<tbody style="font-weight: bold;">
				 		<?php
				 		while ($rowBuscar=mysqli_fetch_array($exe_notas2)) {
			 				echo " <tr>
			 				<td style='text-align:center;'>".$rowBuscar['pensamientoingles']."</td>
	      					<td style='text-align:center;'>".$rowBuscar['materiaingles']."</td>
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
						<h5 class="justifyText">Certificate issued in Sogamoso on <?php echo $dia; ?> days of the month of <?php echo $mesi; ?> <?php echo $fanio; ?>
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
				<form action="php/Registro-certificado.php" method="POST" target="_blank">
					<input type="hidden" id="fecha_expedicion" name="fecha_expedicion" value="<?php echo $fechaHoy; ?>">
					<input type="hidden" id="tipoc" name="tipoc" value="Certificado final de año">
					<input type="hidden" name="id_estudiante" value="<?php echo $id_estudiante;?>">
					<input type="hidden" name="id_grado" value="<?php echo $id_grado;?>">
					<input type="hidden" name="n_certif" value="<?php echo $certicado_total;?>">
					<input type="hidden" name="idioma" value="<?php echo $idioma;?>">
					<input type="hidden" name="firmas" value="<?php echo $firmas;?>">
					<input type="hidden" name="matricula_actual" value="<?php echo $n_matricula;?>">
					<?php  
					    if($ct == 0) {
					        //echo '<h6>Certificado N°: CFIF'.$certicado_total.'</h6>';
					    }
					    else {
					        //echo '<h6>Certificado N°: '.$certicado_total.'</h6>';
					    }
					?>
					<h6>Certificate N°: CFIF<?php echo $certicado_total; ?></h6>
					<button type="submit" id="hide" class="btn btn-danger">Certificate</button>
				</form>
 			</div>
		<?php
	}
	//fin certificado ingles
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

<title><?php echo "CERTIFICATE-OF-REGISTRATION-".$nombreCompleto." UNICAB"; ?></title>
</html>