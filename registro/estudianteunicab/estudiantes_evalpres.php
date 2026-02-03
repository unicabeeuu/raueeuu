<?php
session_start();
require "../adminunicab/php/conexion.php";
require "../docenteunicab/updreg/1cc3s4db.php";
if (isset($_SESSION['uniestudiante'])) {
    
    $idest = $_REQUEST['idest'];
    
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $fanio1 = $fanio + 1;
    
    //Se consulta nombres, apellidos, documento y grado del estudiante
    $sql_n = "SELECT e.id, e.nombres, e.apellidos, e.n_documento, g.grado 
    FROM estudiantes e, 
    (SELECT MAX(idMatricula), id_grado, id_estudiante FROM matricula 
    WHERE id_estudiante = $idest AND substring(fecha_ingreso,1,4) = '$fanio' AND estado IN ('pre_solicitud', 'solicitud', 'activo') 
    GROUP BY id_grado, id_estudiante) m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND e.id = $idest";
	//echo $sql_n;
	$exe_n = mysqli_query($conexion,$sql_n);
	while ($row_n = mysqli_fetch_array($exe_n)) {
	    $nombre_completo = $row_n['nombres']." ".$row_n['apellidos'];
	    $documento = $row_n['n_documento'];
	    $grado_ra = $row_n['grado'];
	}
	//echo $nombre_completo;
	//echo "grado_ra=".$grado_ra;
    
    //Se consulta el resultado de las preguntas
    $sql = "SELECT m.materia, p.pregunta, r.respuesta, r.resultado, 
    case r.resultado when 'OK' then 'MUY BIEN' else p.retroalimentacion end comentarios
    FROM tbl_respuestas r, tbl_preguntas p, materias m 
    WHERE r.id_pregunta = p.id AND r.id_materia = m.id 
    AND r.a = $fanio AND r.identificacion = '$documento'";
	//echo $sql;
	
	//Se hace la consulta de las recomendaciones para numérico
	$sql_retro_num_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 5";
    $exe_retro_num_ct = mysqli_query($conexion,$sql_retro_num_ct);
    while($row_retro_num_ct = mysqli_fetch_array($exe_retro_num_ct)) {
        $ct_num = $row_retro_num_ct['ct'];
    }
    //echo $ct_num;
    $sql_retro_num = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 5";
	
	//Se hace la consulta de las recomendaciones para bioético
    $sql_retro_bio_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 1";
    $exe_retro_bio_ct = mysqli_query($conexion,$sql_retro_bio_ct);
    while($row_retro_bio_ct = mysqli_fetch_array($exe_retro_bio_ct)) {
        $ct_bio = $row_retro_bio_ct['ct'];
    }
    
	$sql_retro_bio = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 1";
    
    //Se hace la consulta de las recomendaciones para social
    $sql_retro_soc_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 4";
    $exe_retro_soc_ct = mysqli_query($conexion,$sql_retro_soc_ct);
    while($row_retro_soc_ct = mysqli_fetch_array($exe_retro_soc_ct)) {
        $ct_soc = $row_retro_soc_ct['ct'];
    }
    
	$sql_retro_soc = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 4";
    
    //Se hace la consulta de las recomendaciones para español
    $sql_retro_esp_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 6";
    $exe_retro_esp_ct = mysqli_query($conexion,$sql_retro_esp_ct);
    while($row_retro_esp_ct = mysqli_fetch_array($exe_retro_esp_ct)) {
        $ct_esp = $row_retro_esp_ct['ct'];
    }
    
	$sql_retro_esp = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 6";
    
    //Se hace la consulta de las recomendaciones para inglés
    $sql_retro_ing_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 7";
    $exe_retro_ing_ct = mysqli_query($conexion,$sql_retro_ing_ct);
    while($row_retro_ing_ct = mysqli_fetch_array($exe_retro_ing_ct)) {
        $ct_ing = $row_retro_ing_ct['ct'];
    }
    
	$sql_retro_ing = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 7";
    
    //Se hace la consulta de las recomendaciones para tecnológico
    $sql_retro_tec_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 9";
    $exe_retro_tec_ct = mysqli_query($conexion,$sql_retro_tec_ct);
    while($row_retro_tec_ct = mysqli_fetch_array($exe_retro_tec_ct)) {
        $ct_tec = $row_retro_tec_ct['ct'];
    }
    
	$sql_retro_tec = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 9";
    
    //Se hace la consulta de las recomendaciones para física
    $sql_retro_fis_ct = "SELECT COUNT(1) ct 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 11";
    $exe_retro_fis_ct = mysqli_query($conexion,$sql_retro_fis_ct);
    while($row_retro_fis_ct = mysqli_fetch_array($exe_retro_fis_ct)) {
        $ct_fis = $row_retro_fis_ct['ct'];
    }
    //echo $ct_fis;
	$sql_retro_fis = "SELECT DISTINCT p.retroalimentacion 
    FROM tbl_respuestas r, tbl_preguntas p 
    WHERE r.id_pregunta = p.id 
    AND r.resultado = 'NO' AND r.identificacion ='$documento' AND r.a = $fanio AND r.id_materia = 11";
    
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
    
    $sql_ctok = "SELECT COUNT(1) ct_ok, identificacion, id_materia FROM tbl_respuestas WHERE resultado = 'OK' AND identificacion = '$documento' 
    AND a = $fanio GROUP BY identificacion, id_materia";
    //echo $sql_ctok;
    $exe_ctok = $mysqli1->query($sql_ctok);
    while($row_ctok = $exe_ctok->fetch_assoc()) {
        if($row_ctok['id_materia'] == 1) {
            $obj_json_decode['bio']['ctok'] = $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 4) {
            $obj_json_decode['soc']['ctok'] = $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 5) {
            $obj_json_decode['num']['ctok'] = $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 6) {
            $obj_json_decode['esp']['ctok'] = $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 7) {
            $obj_json_decode['ing']['ctok'] = $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 9) {
            $obj_json_decode['tec']['ctok'] = $row_ctok['ct_ok'];
        }
        else if($row_ctok['id_materia'] == 11) {
            $obj_json_decode['fis']['ctok'] = $row_ctok['ct_ok'];
        }
    }
    //echo $ct_ok;
    $sql_ctno = "SELECT COUNT(1) ct_no, identificacion, id_materia FROM tbl_respuestas WHERE resultado = 'NO' AND identificacion = '$documento' 
    AND a = $fanio GROUP BY identificacion, id_materia";
    //echo $sql_ctno;
    $exe_ctno = $mysqli1->query($sql_ctno);
    while($row_ctno = $exe_ctno->fetch_assoc()) {
        if($row_ctno['id_materia'] == 1) {
            $obj_json_decode['bio']['ctno'] = $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 4) {
            $obj_json_decode['soc']['ctno'] = $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 5) {
            $obj_json_decode['num']['ctno'] = $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 6) {
            $obj_json_decode['esp']['ctno'] = $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 7) {
            $obj_json_decode['ing']['ctno'] = $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 9) {
            $obj_json_decode['tec']['ctno'] = $row_ctno['ct_no'];
        }
        else if($row_ctno['id_materia'] == 11) {
            $obj_json_decode['fis']['ctno'] = $row_ctno['ct_no'];
        }
    }
    //echo $ct_no;
    $sql_ctna = "SELECT COUNT(1) ct_na, identificacion, id_materia FROM tbl_respuestas WHERE resultado = 'NA' AND identificacion = '$documento' 
    AND a = $fanio GROUP BY identificacion, id_materia";
    $exe_ctna = $mysqli1->query($sql_ctna);
    while($row_ctna = $exe_ctna->fetch_assoc()) {
        if($row_ctna['id_materia'] == 1) {
            $obj_json_decode['bio']['ctna'] = $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 4) {
            $obj_json_decode['soc']['ctna'] = $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 5) {
            $obj_json_decode['num']['ctna'] = $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 6) {
            $obj_json_decode['esp']['ctna'] = $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 7) {
            $obj_json_decode['ing']['ctna'] = $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 9) {
            $obj_json_decode['tec']['ctna'] = $row_ctna['ct_na'];
        }
        else if($row_ctna['id_materia'] == 11) {
            $obj_json_decode['fis']['ctna'] = $row_ctna['ct_na'];
        }
    }
    //echo $ct_na;
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
    .fa-hand-o-right {
        color: red;
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
	
		<?php require 'header.php';  ?>
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
					
						<h3><span class="badge badge-success">Evaluación de Presaberes de: </span> <?php echo $nombre_completo; ?></h3>
                                                
                        <div class="register-form" id="divform">
                            <!--<form name="formulario" id="formulario" method="post" action="" enctype="multipart/form-data">-->
                                
                                <div>
                                    <p><i class="fa fa-hand-o-right "></i> <strong>Este es el resultado de tu evaluación de presaberes para grado <?php echo $grado_ra; ?>.</strong></p>
                                    <p><i class="fa fa-hand-o-right "></i> <strong>Resumen:</strong> (cantidad de preguntas bien contestadas, mal contestadas y no contestadas por pensamiento)</p>
                                </div>
                                
                                <div class="row">
                                    <table>
                                        <tbody>
                                            <?php
                                                //$conteo = $obj_json_decode['num']['ctok'] + $obj_json_decode['num']['ctno'] + $obj_json_decode['num']['ctna'];
                                                //echo "conteo numérico=".$conteo;
                                                if($obj_json_decode['bio']['ctok'] + $obj_json_decode['bio']['ctno'] + $obj_json_decode['bio']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>BIOETICO</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['bio']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['bio']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['bio']['ctna'].'"/> <img src="../images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                                if($obj_json_decode['soc']['ctok'] + $obj_json_decode['soc']['ctno'] + $obj_json_decode['soc']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>SOCIAL</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['soc']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['soc']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['soc']['ctna'].'"/> <img src="../images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                                if($obj_json_decode['num']['ctok'] + $obj_json_decode['num']['ctno'] + $obj_json_decode['num']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>NUMERICO</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['num']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['num']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['num']['ctna'].'"/> <img src="../images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                                if($obj_json_decode['esp']['ctok'] + $obj_json_decode['esp']['ctno'] + $obj_json_decode['esp']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>ESPAÑOL</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['esp']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['esp']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['esp']['ctna'].'"/> <img src="../images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                                if($obj_json_decode['ing']['ctok'] + $obj_json_decode['ing']['ctno'] + $obj_json_decode['ing']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>INGLES</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['ing']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['ing']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['ing']['ctna'].'"/> <img src="../images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                                if($obj_json_decode['tec']['ctok'] + $obj_json_decode['tec']['ctno'] + $obj_json_decode['tec']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>TECNOLOGICO</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['tec']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['tec']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['tec']['ctna'].'"/> <img src="..//images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                                if($obj_json_decode['fis']['ctok'] + $obj_json_decode['fis']['ctno'] + $obj_json_decode['fis']['ctna'] > 0) {
                                                    $linea = '<tr>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td>FISICA</td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['fis']['ctok'].'"/> <img src="../images/checked_1.jpg" height="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['fis']['ctno'].'"/> <img src="../images/unchecked_1.jpg" width="25px"/></td>';
                                                    $linea .= '<td width="50px"></td>';
                                                    $linea .= '<td class="fondoblanco"><input type="text" class="txtct" value="'.$obj_json_decode['fis']['ctna'].'"/> <img src="../images/na_1.jpg" width="25px"/></td>';
                                                    $linea .= '</tr>';
                                                    echo $linea;
                                                }
                                            ?>
                                            <!--<tr>
                                                <td><h6>Resumen: </h6></td> 
                                                <td width="50px"></td>
                                                <td class="fondoblanco"><input type="text" id="txtok" class="txtct" value="<?php echo $ct_ok; ?>"/> <img src='registro/images/checked_1.jpg' height='25px'/></td>
                                                <td width="50px"></td>
                                                <td class="fondoblanco"><input type="text" id="txtno" class="txtct" value="<?php echo $ct_no; ?>"/> <img src='registro/images/unchecked_1.jpg' width='25px'/></td>
                                                <td width="50px"></td>
                                                <td class="fondoblanco"><input type="text" id="txtna" class="txtct" value="<?php echo $ct_na; ?>"/> <img src='registro/images/na_1.jpg' width='25px'/></td>
                                            </tr>-->
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="form-group">
                                    <p><i class="fa fa-hand-o-right "></i> <strong>Detalle:</strong></p>
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
                        
                        <h3><span class="badge badge-success">Hoja de ruta sugerida para reforzar conceptos </span></h3>
                        <br>
                        <div class="row">
                            <div id="divnum" class="col-6 col-sm-6">
                                <h4>Numérico</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_num = mysqli_query($conexion,$sql_retro_num);
                                        while($row_retro_num = mysqli_fetch_array($exe_retro_num)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_num['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                            <div id="divtec" class="col-6 col-sm-6">
                                <h4>Tecnológico</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_tec = mysqli_query($conexion,$sql_retro_tec);
                                        while($row_retro_tec = mysqli_fetch_array($exe_retro_tec)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_tec['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                        </div>
                        <div class="row">
                            <div id="diving" class="col-6 col-sm-6">
                                <h4>Inglés</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_ing = mysqli_query($conexion,$sql_retro_ing);
                                        while($row_retro_ing = mysqli_fetch_array($exe_retro_ing)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_ing['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                            <div id="divesp" class="col-6 col-sm-6">
                                <h4>Español</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_esp = mysqli_query($conexion,$sql_retro_esp);
                                        while($row_retro_esp = mysqli_fetch_array($exe_retro_esp)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_esp['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                        </div>
                        <div class="row">
                            <div id="divbio" class="col-6 col-sm-6">
                                <h4>Bioético</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_bio = mysqli_query($conexion,$sql_retro_bio);
                                        while($row_retro_bio = mysqli_fetch_array($exe_retro_bio)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_bio['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                            <div id="divfis" class="col-6 col-sm-6">
                                <h4>Física</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_fis = mysqli_query($conexion,$sql_retro_fis);
                                        while($row_retro_fis = mysqli_fetch_array($exe_retro_fis)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_fis['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                        </div>
                        <div class="row">
                            <div id="divsoc" class="col-6 col-sm-6">
                                <h4>Social</h4>
                                <ul class="list-group">
                                    <?php
                                        $exe_retro_soc = mysqli_query($conexion,$sql_retro_soc);
                                        while($row_retro_soc = mysqli_fetch_array($exe_retro_soc)) {
                                            echo '<li class="list-group-item"><i class="fa fa-hand-o-right "></i> '.$row_retro_soc['retroalimentacion'].'</li>';
                                        }
                                    ?>
                                </ul><br>
                            </div>
                        </div>
						
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
	echo "<script>location.href='login.php'</script>";
}
?>
</html>