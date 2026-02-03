<?php
session_start();
require "../adminunicab/php/conexion.php";
require "updreg/1cc3s4db.php";
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
    //echo $id;
    
    $documento = $_REQUEST['documento'];
    $idgra = $_REQUEST['idgra'];
    
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $fanio1 = $fanio + 1;
    
    //Se consulta nombres y apellidos del documento
    $sql_n = "SELECT * FROM tbl_pre_matricula WHERE documento_est = '$documento'";
	//echo $sql_n;
	$exe_n = mysqli_query($conexion,$sql_n);
	while ($row_n = mysqli_fetch_array($exe_n)) {
	    $nombre_completo = $row_n['nombres_est']." ".$row_n['apellidos_est'];
	}
	//echo $nombre_completo;
	
	//Se consulta el nombre del grado
	$sql_grado = "SELECT * FROM equivalence_idgra WHERE id_grado_ra = $idgra";
	//echo $sql_grado;
	$exe_grado = mysqli_query($conexion,$sql_grado);
	while ($row_grado = mysqli_fetch_array($exe_grado)) {
	    $grado_ra = $row_grado['grado_ra'];
	}
	//echo "grado_ra=".$grado_ra;
    
    //Se consulta el resultado de las preguntas
    $sql = "SELECT m.materia, p.pregunta, r.respuesta, r.resultado, 
    case r.resultado when 'OK' then 'MUY BIEN' else p.retroalimentacion end comentarios
    FROM tbl_respuestas_val r, tbl_preguntas p, materias m 
    WHERE r.id_pregunta = p.id AND r.id_materia = m.id 
    AND r.a = $fanio AND r.identificacion = '$documento' AND r.id_grado = $idgra";
	//echo $sql;
	
	//Se hace la consulta de las recomendaciones para numérico
	
    //Se hacen los conteos generales
    $conteos = array(ctok=>0, ctno=>0, ctna=>0);
    $resumen = new stdClass();
    $resumen->bio = $conteos;
    $resumen->soc = $conteos;
    $resumen->num = $conteos;
    $resumen->esp = $conteos;
    $resumen->ing = $conteos;
    $resumen->tec = $conteos;
    $resumen->fis = $conteos;
    $obj_json = json_encode($resumen, JSON_UNESCAPED_UNICODE);
    $obj_json_decode = json_decode($obj_json, true);
    //echo $obj_json;
    
    //Totales por pensamiento
    $totbio = 0;
    $totsoc = 0;
    $totnum = 0;
    $totesp = 0;
    $toting = 0;
    $tottec = 0;
    $totfis = 0;
    $total_todos = 0;
    $total_todos_ok = 0;
    
    //Nivel por pensamiento
    $nivbio = "";
    $nivsoc = "";
    $nivnum = "";
    $nivesp = "";
    $niving = "";
    $nivtec = "";
    $nivfis = "";
    $nivglo = "";
    
    $colbio = "";
    $colsoc = "";
    $colnum = "";
    $colesp = "";
    $coling = "";
    $coltec = "";
    $colfis = "";
    $colglo = "";
    
    $sql_ctok = "SELECT COUNT(1) ct_ok, identificacion, id_materia FROM tbl_respuestas_val WHERE resultado = 'OK' AND identificacion = '$documento' 
    AND a = $fanio AND id_grado = $idgra GROUP BY identificacion, id_materia";
    //echo $sql_ctok;
    $exe_ctok = $mysqli1->query($sql_ctok);
    while($row_ctok = $exe_ctok->fetch_assoc()) {
        if($row_ctok['id_materia'] == 1) {
            $obj_json_decode['bio']['ctok'] = $row_ctok['ct_ok'];
            $totbio += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 10) {
            $obj_json_decode['bio']['ctok'] = $row_ctok['ct_ok'];
            $totbio += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 4) {
            $obj_json_decode['soc']['ctok'] = $row_ctok['ct_ok'];
            $totsoc += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 12) {
            $obj_json_decode['soc']['ctok'] = $row_ctok['ct_ok'];
            $totsoc += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 5) {
            $obj_json_decode['num']['ctok'] = $row_ctok['ct_ok'];
            $totnum += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 6) {
            $obj_json_decode['esp']['ctok'] = $row_ctok['ct_ok'];
            $totesp += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 15) {
            $obj_json_decode['esp']['ctok'] = $row_ctok['ct_ok'];
            $totesp += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 7) {
            $obj_json_decode['ing']['ctok'] = $row_ctok['ct_ok'];
            $toting += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 9) {
            $obj_json_decode['tec']['ctok'] = $row_ctok['ct_ok'];
            $tottec += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 11) {
            $obj_json_decode['fis']['ctok'] = $row_ctok['ct_ok'];
            $totfis += $row_ctok['ct_ok'];
            $total_todos_ok += $row_ctok['ct_ok'];
        }
        
        $tot_ok += $row_ctok['ct_ok'];
        $tot_gen += $row_ctok['ct_ok'];
    }
    //echo $ct_ok;
    
    $sql_ctno = "SELECT COUNT(1) ct_no, identificacion, id_materia FROM tbl_respuestas_val WHERE resultado = 'NO' AND identificacion = '$documento' 
    AND a = $fanio AND id_grado = $idgra GROUP BY identificacion, id_materia";
    //echo $sql_ctno;
    $exe_ctno = $mysqli1->query($sql_ctno);
    while($row_ctno = $exe_ctno->fetch_assoc()) {
        if($row_ctno['id_materia'] == 1) {
            $obj_json_decode['bio']['ctno'] = $row_ctno['ct_no'];
            $totbio += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 10) {
            $obj_json_decode['bio']['ctno'] = $row_ctno['ct_no'];
            $totbio += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 4) {
            $obj_json_decode['soc']['ctno'] = $row_ctno['ct_no'];
            $totsoc += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 12) {
            $obj_json_decode['soc']['ctno'] = $row_ctno['ct_no'];
            $totsoc += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 5) {
            $obj_json_decode['num']['ctno'] = $row_ctno['ct_no'];
            $totnum += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 6) {
            $obj_json_decode['esp']['ctno'] = $row_ctno['ct_no'];
            $totesp += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 15) {
            $obj_json_decode['esp']['ctno'] = $row_ctno['ct_no'];
            $totesp += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 7) {
            $obj_json_decode['ing']['ctno'] = $row_ctno['ct_no'];
            $toting += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 9) {
            $obj_json_decode['tec']['ctno'] = $row_ctno['ct_no'];
            $tottec += $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 11) {
            $obj_json_decode['fis']['ctno'] = $row_ctno['ct_no'];
            $totfis += $row_ctno['ct_no'];
        }
        
        $tot_gen += $row_ctno['ct_no'];
    }
    //echo $ct_no;
    
    $sql_ctna = "SELECT COUNT(1) ct_na, identificacion, id_materia FROM tbl_respuestas_val WHERE resultado = 'NA' AND identificacion = '$documento' 
    AND a = $fanio AND id_grado = $idgra GROUP BY identificacion, id_materia";
    $exe_ctna = $mysqli1->query($sql_ctna);
    while($row_ctna = $exe_ctna->fetch_assoc()) {
        if($row_ctna['id_materia'] == 1) {
            $obj_json_decode['bio']['ctna'] = $row_ctna['ct_na'];
            $totbio += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 10) {
            $obj_json_decode['bio']['ctna'] = $row_ctna['ct_na'];
            $totbio += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 4) {
            $obj_json_decode['soc']['ctna'] = $row_ctna['ct_na'];
            $totsoc += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 12) {
            $obj_json_decode['soc']['ctna'] = $row_ctna['ct_na'];
            $totsoc += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 5) {
            $obj_json_decode['num']['ctna'] = $row_ctna['ct_na'];
            $totnum += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 6) {
            $obj_json_decode['esp']['ctna'] = $row_ctna['ct_na'];
            $totesp += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 15) {
            $obj_json_decode['esp']['ctna'] = $row_ctna['ct_na'];
            $totesp += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 7) {
            $obj_json_decode['ing']['ctna'] = $row_ctna['ct_na'];
            $toting += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 9) {
            $obj_json_decode['tec']['ctna'] = $row_ctna['ct_na'];
            $tottec += $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 11) {
            $obj_json_decode['fis']['ctna'] = $row_ctna['ct_na'];
            $totfis += $row_ctna['ct_na'];
        }
        
        $tot_gen += $row_ctna['ct_na'];
    }
    //echo $tot_gen;
    
    $obj_json_decode['bio']['ctpen'] = $totbio;
    $obj_json_decode['soc']['ctpen'] = $totsoc;
    $obj_json_decode['num']['ctpen'] = $totnum;
    $obj_json_decode['esp']['ctpen'] = $totesp;
    $obj_json_decode['ing']['ctpen'] = $toting;
    $obj_json_decode['tec']['ctpen'] = $tottec;
    $obj_json_decode['fis']['ctpen'] = $totfis;
    
    $total_todos = $totbio + $totsoc + $totnum + $totesp + $toting + $tottec + $totfis;
    
    if($obj_json_decode['bio']['ctok'] / $totbio > 0.75) {
        $nivbio = "SUPER ALTO";
        $colbio = "#138726";
    }
    else if($obj_json_decode['bio']['ctok'] / $totbio > 0.5) {
        $nivbio = "ALTO";
        $colbio = "#4b9db9";
    }
    else if($obj_json_decode['bio']['ctok'] / $totbio > 0.25) {
        $nivbio = "MEDIO";
        $colbio = "#FFC300";
    }
    else {
        if($totbio > 0) {
            $nivbio = "BAJO";
            $colbio = "#e8222e";
        }
        else {
            $nivbio = "NO APLICA";
            $colbio = "#000";
        }
    }
    
    if($obj_json_decode['soc']['ctok'] / $totsoc > 0.75) {
        $nivsoc = "SUPER ALTO";
        $colsoc = "#138726";
    }
    else if($obj_json_decode['soc']['ctok'] / $totsoc > 0.5) {
        $nivsoc = "ALTO";
        $colsoc = "#4b9db9";
    }
    else if($obj_json_decode['soc']['ctok'] / $totsoc > 0.25) {
        $nivsoc = "MEDIO";
        $colsoc = "#FFC300";
    }
    else {
        if($totsoc > 0) {
            $nivsoc = "BAJO";
            $colsoc = "#e8222e";
        }
        else {
            $nivsoc = "NO APLICA";
            $colsoc = "#000";
        }
    }
    
    if($obj_json_decode['num']['ctok'] / $totnum > 0.75) {
        $nivnum = "SUPER ALTO";
        $colnum = "#138726";
    }
    else if($obj_json_decode['num']['ctok'] / $totnum > 0.5) {
        $nivnum = "ALTO";
        $colnum = "#4b9db9";
    }
    else if($obj_json_decode['num']['ctok'] / $totnum > 0.25) {
        $nivnum = "MEDIO";
        $colnum = "#FFC300";
    }
    else {
        if($totnum > 0) {
            $nivnum = "BAJO";
            $colnum = "#e8222e";
        }
        else {
            $nivnum = "NO APLICA";
            $colnum = "#000";
        }
    }
    
    if($obj_json_decode['esp']['ctok'] / $totesp > 0.75) {
        $nivesp = "SUPER ALTO";
        $colesp = "#138726";
    }
    else if($obj_json_decode['esp']['ctok'] / $totesp > 0.5) {
        $nivesp = "ALTO";
        $colesp = "#4b9db9";
    }
    else if($obj_json_decode['esp']['ctok'] / $totesp > 0.25) {
        $nivesp = "MEDIO";
        $colesp = "#FFC300";
    }
    else {
        if($totesp > 0) {
            $nivesp = "BAJO";
            $colesp = "#e8222e";
        }
        else {
            $nivesp = "NO APLICA";
            $colesp = "#000";
        }
    }
    
    if($obj_json_decode['ing']['ctok'] / $toting > 0.75) {
        $niving = "SUPER ALTO";
        $coling = "#138726";
    }
    else if($obj_json_decode['ing']['ctok'] / $toting > 0.5) {
        $niving = "ALTO";
        $coling = "#4b9db9";
    }
    else if($obj_json_decode['ing']['ctok'] / $toting > 0.25) {
        $niving = "MEDIO";
        $coling = "#FFC300";
    }
    else {
        if($toting > 0) {
            $niving = "BAJO";
            $coling = "#e8222e";
        }
        else {
            $niving = "NO APLICA";
            $coling = "#000";
        }
    }
    
    if($obj_json_decode['tec']['ctok'] / $tottec > 0.75) {
        $nivtec = "SUPER ALTO";
        $coltec = "#138726";
    }
    else if($obj_json_decode['tec']['ctok'] / $tottec > 0.5) {
        $nivtec = "ALTO";
        $coltec = "#4b9db9";
    }
    else if($obj_json_decode['tec']['ctok'] / $tottec > 0.25) {
        $nivtec = "MEDIO";
        $coltec = "#FFC300";
    }
    else {
        if($tottec > 0) {
            $nivtec = "BAJO";
            $coltec = "#e8222e";
        }
        else {
            $nivtec = "NO APLICA";
            $coltec = "#000";
        }
    }
    
    if($obj_json_decode['fis']['ctok'] / $totfis > 0.75) {
        $nivfis = "SUPER ALTO";
        $colfis = "#138726";
    }
    else if($obj_json_decode['fis']['ctok'] / $totfis > 0.5) {
        $nivfis = "ALTO";
        $colfis = "#4b9db9";
    }
    else if($obj_json_decode['fis']['ctok'] / $totfis > 0.25) {
        $nivfis = "MEDIO";
        $colfis = "#FFC300";
    }
    else {
        if($totfis > 0) {
            $nivfis = "BAJO";
            $colfis = "#e8222e";
        }
        else {
            $nivfis = "NO APLICA";
            $colfis = "#000";
        }
    }
    
    if($total_todos_ok / $total_todos > 0.75) {
        $nivglo = "SUPER ALTO";
        $colglo = "#138726";
    }
    else if($total_todos_ok / $total_todos > 0.5) {
        $nivglo = "ALTO";
        $colglo = "#4b9db9";
    }
    else if($total_todos_ok / $total_todos > 0.25) {
        $nivglo = "MEDIO";
        $colglo = "#FFC300";
    }
    else {
        $nivglo = "BAJO";
        $colglo = "#e8222e";
    }
    
    $porc = round(($tot_ok / $tot_gen),2) * 100;
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
<style>
    .fa-chevron-right {
        color: blue;
    }
    .conteo {
        width: 40px;
        border: none;
        color: white;
        font-weight: bold;
        background-color: #247fb7;
        font-size: 16px;
    }
    #divimagen, #divtextopregunta {
        height: 350px;
    }
    #divnum {
        background: #CEF6F5;
    }
    #divtec {
        background: #F5A9A9;
    }
    #diving {
        background: #F3F781;
    }
    #divesp {
        background: #F7BE81;
    }
    #divbio {
        background: #F6CECE;
    }
    #divfis {
        background: #A9F5A9;
    }
    #divsoc {
        background: #D8D8D8;
    }
    .imgpreg {
        margin-top: 10px;
    }
    .p2 {
        display: none;
    }
    .oculto {
        display: none;
    }
    .nooculto {
        display: inline;
    }
    #tblres {
        table-layout: fixed;
    }
    #tblres .tdcorto {
        width: 80px;
        text-align: center;
    }
    #tblres .tdmedio {
        width: 200px;
    }
    .GridViewScrollHeader TH, .GridViewScrollHeader TD {
        padding: 5px;
        font-weight: bold;
        background-color: #CCCCCC;
        color: #000000;
    }
    .GridViewScrollItem TD {
        padding: 5px;
        color: #444444;
    }
    .GridViewScrollItemFreeze TD {
        padding: 5px;
        background-color: #CCCCCC;
        color: #444444;
    }
    .GridviewScrollItemHover TD
    {
        background-color: #CCCCCC;
        color: blue;
    }
    .txtct {
        width: 20px;
        border: 0;
        color: black;
        font-weight: bold;
    }
    .fondoblanco {
        background: white;
    }
    .list-group-item {
        background: white;
        border-bottom: 1px solid black;
    }
    .badge {
        font-size: 18px;
        background: green;
    }
    .badge-success {
        background: green;
    }
    .badge-secondary {
        background: gray;
    }
    .badge-danger {
        background: red;
    }
    .badge-warning {
        background: orange;
    }
    #al {
        color: white;
    }
    #divenc1 {
        display: flex;
        justify-content: center;
    }
    #divenc2 {
        display: flex;
        justify-content: space-around;
    }
    #divenc2_1 {
        border: 3px solid #093A5F;
        width: 50%;
        padding-left: 20px;
    }
    #divenc2_2 {
        background: #54CF8C;
        width: 20%;
        text-align: center;
    }
    
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Poppins-medium:wght@500&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&display=swap');
    /*@import url('https://fonts.googleapis.com/css2?family=PT+Sans+Narrow:wght@700&display=swap');*/
    
    #divglobal {
        display: flex;
        justify-content: center;
        text-align: center;
        background: #F1F1F2;
    }
    #tblglobal, thead {
        border: 2px solid black;
    }
</style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php 
		    if($id == 18 || $id == 40) {
	        require 'menu_adm.php';
		    }
		    else {
		        //require 'menu.php';
		        require 'menu_tutores.php';
		    }  
		?>
	
		<?php require 'header.php';  ?>
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
					
						<div id="divenc1">
					        <div>
					            <img src="../images/encabezado_informes1.jpg" width="100%"/>
					        </div>
					    </div><br>
					    
					    <div id="divenc2">
						    <div id="divenc2_1">
						        <p>Evaluación de Admisión</p>
						        <p>Nombres y Apellidos: <strong><?php echo $nombre_completo; ?></strong></p>
						        <p>Documento: <strong><?php echo $documento; ?></strong></p>
						        <p>Grado: <strong><?php echo $grado_ra; ?></strong></p>
						    </div>
						    <div id="divenc2_2">
						        <p style="font-family: 'Poppins'; font-size: 24px; font-style: italic; color: #093A5F">GLOBAL</p>
						        <p style="font-family: 'Poppins-medium'; font-size: 18px; color: #093A5F; padding: 0 5px;">De <?php echo $total_todos; ?> puntos posibles, su puntaje global es de <?php echo $total_todos_ok; ?>.</p>
						    </div>
						</div><br>
                                                
                        <div class="register-form" id="divform">
                            <!--<form name="formulario" id="formulario" method="post" action="" enctype="multipart/form-data">-->
                                <div style="width: 100%; background: #093A5F; color: #F1F1F2; text-align: center; font-size: 20px; font-weight: bold; font-family: 'PT Sans Narrow';">Informe Global</div>
                                <div style="width: 100%; background: #F1F1F2; text-align: center; font-size: 20px; font-family: 'Poppins-medium';">
                                    <br><p>A continuación se relacionan los puntajes obtenidos en cada uno de los pensamientos evaluados en la evaluación de admisión:</p><br>
                                </div>
                                
                                <div class="row" id="divglobal">
                                    <table id="tblglobal" style="text-align: center;">
                                        <thead style="font-family: 'PT Sans Narrow';">
                                            <tr style="background: #45A872; color: #F1F1F2; font-size: 20px; font-weight: bold; border: 2px;"><td colspan="9">Pensamientos</td></tr>
                                            <tr>
                                                <td colspan="2" width="200px" style="background: #FA4D59; color: #F1F1F2; font-size: 20px; font-weight: bold; border: 2px solid black;">Global</td>
                                                <!--<td width="100px">Global</td>-->
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Bio</td>
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Esp</td>
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Ing</td>
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Num</td>
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Soc</td>
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Tec</td>
                                                <td width="100px" style="background: #093A5F; color: #F1F1F2; font-weight: bold; border: 2px solid black;">Fis</td>
                                            </tr>
                                        </thead>
                                        <tbody style="font-family: 'PT Sans Narrow';">
                                        <?php
                                            $linea = '<tr>';
                                            $linea .= '<td style="color: #064C86; border: 2px solid black;">Puntaje</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$total_todos_ok.' / '.$total_todos.'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['bio']['ctok'].' / '.$obj_json_decode['bio']['ctpen'].'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['esp']['ctok'].' / '.$obj_json_decode['esp']['ctpen'].'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['ing']['ctok'].' / '.$obj_json_decode['ing']['ctpen'].'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['num']['ctok'].' / '.$obj_json_decode['num']['ctpen'].'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['soc']['ctok'].' / '.$obj_json_decode['soc']['ctpen'].'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['tec']['ctok'].' / '.$obj_json_decode['tec']['ctpen'].'</td>';
                                            $linea .= '<td style="border: 2px solid black; color: #093A5F; font-weight: bold;">'.$obj_json_decode['fis']['ctok'].' / '.$obj_json_decode['fis']['ctpen'].'</td>';
                                            $linea .= '</tr>';
                                            echo $linea;
                                            
                                            $linea = '<tr>';
                                            $linea .= '<td style="color: #064C86; border: 2px solid black;">Desempeño</td>';
                                            $linea .= '<td style="color: '.$colglo.'; border: 2px solid black; font-weight: bold;">'.$nivglo.'</td>';
                                            $linea .= '<td style="color: '.$colbio.'; border: 2px solid black; font-weight: bold;">'.$nivbio.'</td>';
                                            $linea .= '<td style="color: '.$colesp.'; border: 2px solid black; font-weight: bold;">'.$nivesp.'</td>';
                                            $linea .= '<td style="color: '.$coling.'; border: 2px solid black; font-weight: bold;">'.$niving.'</td>';
                                            $linea .= '<td style="color: '.$colnum.'; border: 2px solid black; font-weight: bold;">'.$nivnum.'</td>';
                                            $linea .= '<td style="color: '.$colsoc.'; border: 2px solid black; font-weight: bold;">'.$nivsoc.'</td>';
                                            $linea .= '<td style="color: '.$coltec.'; border: 2px solid black; font-weight: bold;">'.$nivtec.'</td>';
                                            $linea .= '<td style="color: '.$colfis.'; border: 2px solid black; font-weight: bold;">'.$nivfis.'</td>';
                                            $linea .= '</tr><tr><td colspan="9" style="border: 2px solid #F1F1F2; color: #F1F1F2">Fila vacía</td></tr>';
                                            echo $linea;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div>
                                    <p><i class="fa fa-chevron-right"></i> <strong>Se envío una copia de ésta evaluación al correo del acudiente.</strong></p>
                                    <p><i class="fa fa-chevron-right"></i> <strong>Convenciones:</strong> Contestadas bien <img src="../images/checked_1.jpg" height="25px"/>,  Contestadas incorrectas <img src="../images/unchecked_1.jpg" width="25px"/>, No contestadas <img src="../images/na_1.jpg" width="25px"/></p>
                                </div><br>
                                
                                <div style="width: 100%; background: #093A5F; color: #F1F1F2; text-align: center; font-size: 20px; font-weight: bold; font-family: 'PT Sans Narrow';">Informe por Materias</div>
                                <div class="form-group">
                                    <table id="tblres" border="1px" class="table" style="width:100%">
                                        <thead>                    
        						            <tr class="GridViewScrollHeader">
        						                <td class="tdmedio">Materia</td>
        						                <td>Pregunta</td>
        						                <td class="tdcorto">Resultado</td>
        						            </tr>
        						        </thead>
        						        <tbody>
        						        	<?php 
        						        	    $peticion = mysqli_query($conexion,$sql);
        							        	while ($fila = mysqli_fetch_array($peticion)){
        							        	    if($fila['resultado'] == "NO") {
        							        		    echo"<tr class='GridviewScrollItem'>
            							        		<td>".$fila['materia']."</td>
            							        		<td>".$fila['pregunta']."</td>
            							        		<td class='tdcorto'><img src='../images/unchecked_1.jpg' width='25px'/></td></tr>";
        							        		}
        							        		else if($fila['resultado'] == "OK") {
        							        		    echo"<tr class='GridviewScrollItem'>
            							        		<td>".$fila['materia']."</td>
            							        		<td>".$fila['pregunta']."</td>
            							        		<td class='tdcorto'><img src='../images/checked_1.jpg' height='25px'/></td></tr>";
        							        		}
        							        		else if($fila['resultado'] == "NA") {
        							        		    echo"<tr class='GridviewScrollItem'>
            							        		<td>".$fila['materia']."</td>
            							        		<td>".$fila['pregunta']."</td>
            							        		<td class='tdcorto'><img src='../images/na_1.jpg' width='25px'/></td></tr>";
        							        		}
        							        	}
        						        	?>
        						        </tbody>
                                    </table>
                                </div>
                            <!--</form>-->
                            
                        </div><br>
                        <input type="hidden" id="txtctnum" value="<?php echo $ct_num; ?>"/>
                    	<input type="hidden" id="txtctbio" value="<?php echo $ct_bio; ?>"/>
                    	<input type="hidden" id="txtctsoc" value="<?php echo $ct_soc; ?>"/>
                    	<input type="hidden" id="txtctesp" value="<?php echo $ct_esp; ?>"/>
                    	<input type="hidden" id="txtcting" value="<?php echo $ct_ing; ?>"/>
                    	<input type="hidden" id="txtcttec" value="<?php echo $ct_tec; ?>"/>
                    	<input type="hidden" id="txtctfis" value="<?php echo $ct_fis; ?>"/>
                        
                        <?php
                            if($porc >= 70) {
                        ?>
                                <p><h3><span class="badge badge-success">El resultado de la evaluación de validación es: <?php echo $porc;?>%. Validación aprobada</span></h3></p><br>
                                <p><h3><span class="badge badge-secondary">Puede empezar proceso de matrícula <a href="https://unicab.org/pre_admisiones.php" id="al">AQUI</a></span></h3></p>
                        <?php
                            }
                            else {
                        ?>
                                <p><h3><span class="badge badge-danger">El resultado de la evaluación de validación es: <?php echo $porc;?>%. Validación no aprobada</span></h3></p><br>
                                <p><h5><span class="badge badge-warning">Por favor ponte en contacto con el Coordinador Académico al número 318 400 4412</span></h5></p>
                        <?php
                            }
                        ?>
						
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
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>