<?php
    session_start();
	//Genera botÃ³n de ver registros a procesar
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/buscar_notas_mood.php?idest_ra1=1242&idgra_ra1=11
	//https://unicab.org/registro/docenteunicab/updreg/buscar_notas_mood.php?idest_ra1=1566&idgra_ra1=11
	//echo "hola";
	
	if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
    	//$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
    	//echo $sql;
    	
    	$res_sql=$mysqli1->query($sql);
	    while($fila = $res_sql->fetch_assoc()){
    	  	$id = $fila['id'];
    		$apellidos  = $fila['apellidos'];
    		$nombres = $fila['nombres'];
    		$email_institucional = $fila['email'];
    		//$director=$fila['d_pensamiento'];
    		$n_documento = $fila['n_documento'];
    		$password = $fila['pc'];
    		$perfil = $fila['perfil'];
    	}
    }
    //echo $perfil;
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$idest = $_REQUEST["idest_ra1"];
	$idgra = $_REQUEST["idgra_ra1"];
	//$idest = 502;
	//echo $idest;
	//echo $idgra;
	
	$notas = new stdClass();
	$lbls = array();
	$p1 = array();
	$p2 = array();
	$p3 = array();
	$p4 = array();
	$tabla = new stdClass();
	$lineas = array();
	$upd_ins = array();
	$i = 0;
	
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
	if(date($fecha2) >= date('2025/02/01') && date($fecha2) < date('2025/04/04')) {
	    $in = "('TP1','TP1I','TP1F','TP19','TP110','TP111')";
	}
	else if(date($fecha2) >= date('2025/04/05') && date($fecha2) < date('2025/06/06')) {
	    $in = "('TP1','TP1I','TP1F','TP19','TP110','TP111','TP2','TP2I','TP2F','TP29','TP210','TP211')";
	}
	else if(date($fecha2) >= date('2025/06/07') && date($fecha2) < date('2025/08/22')) {
	    $in = "('TP1','TP1I','TP1F','TP19','TP110','TP111','TP2','TP2I','TP2F','TP29','TP210','TP211','TP3','TP3I','TP3F','TP39','TP310','TP311')";
	}
	else if(date($fecha2) >= date('2025/08/23')) {
	    $in = "('TP1','TP1I','TP1F','TP19','TP110','TP111','TP2','TP2I','TP2F','TP29','TP210','TP211','TP3','TP3I','TP3F','TP39','TP310','TP311','TP4','TP4I','TP4F','TP49','TP410','TP411')";
	}
	//echo $in;
	
	//***************************************************************************************************
	if (isset($_SESSION['uniprofe'])) {
		$queryr0 = "Delete From notas_mood_temp_est Where email_inst = '".$_SESSION['uniprofe']."'";
	}
	else if (isset($_SESSION['unisuper'])) {
		$queryr0 = "Delete From notas_mood_temp_est Where email_inst = '".$_SESSION['unisuper']."'";
	}
	else if (isset($_SESSION['admin_unicab'])) {
		$queryr0 = "Delete From notas_mood_temp_est Where email_inst = '".$_SESSION['admin_unicab']."'";
	}
	//echo $queryr0;
	$resultado_r0=$mysqli1->query($queryr0);
	
	//Se busca el id estudiante de moodle
	$queryr1 = "SELECT id_moodle FROM equivalence_idest WHERE id_registro = '$idest'";
	$resultado_r1=$mysqli1->query($queryr1);
	while($row1 = $resultado_r1->fetch_assoc()){
		$idest_m = $row1['id_moodle'];
	}
	//echo $idest_m;
	
	//Se busca el id grado de moodle
	$queryr2 = "SELECT id_category FROM equivalence_idgra WHERE id_grado_ra = '$idgra'";
	//echo $queryr2;
	$resultado_r2=$mysqli1->query($queryr2);
	while($row2 = $resultado_r2->fetch_assoc()){
		$idgra_m = $row2['id_category'];
	}
	//echo $idgra_m;
	
	//Se agrega el idgra_m de 32 en el caso de noveno, décimo y once... que es el id del curso énfasis en educación física en moodle
	if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	    $idgra_m1 = 32;
	}
	
	/*$queryr01 = "SELECT DISTINCT u.id id_est, u.lastname, u.firstname, c.shortname, 
	    case CONCAT(cc.id,gi.idnumber) when '19TP1I' then 61999 when '19TP2I' then 61999 when '19TP3I' then 61999 when '19TP4I' then 61999 
            	when '20TP1I' then 66999 when '20TP2I' then 66999 when '20TP3I' then 66999 when '20TP4I' then 66999 
            	when '22TP1I' then 70999 when '22TP2I' then 70999 when '22TP3I' then 70999 when '22TP4I' then 70999 
            	when '23TP1I' then 77999 when '23TP2I' then 77999 when '23TP3I' then 77999 when '23TP4I' then 77999 
            	when '22TP1F' then 73997 when '22TP2F' then 73997 when '23TP1F' then 76997 when '23TP2F' then 76997 
            	when '16TP1F' then 47997 when '16TP2F' then 47997 when '16TP3F' then 47997 when '16TP4F' then 47997 
            	when '17TP1F' then 52997 when '17TP2F' then 52997 when '17TP3F' then 52997 when '17TP4F' then 52997 
            	when '32TP19' then 42998 when '32TP29' then 42998 when '32TP39' then 42998 when '32TP49' then 42998 
                when '32TP110' then 47998 when '32TP210' then 47998 when '32TP310' then 47998 when '32TP410' then 47998 
                when '32TP111' then 52998 when '32TP211' then 52998 when '32TP311' then 52998 when '32TP411' then 52998 
            	else c.id end as id_mat_mood, 
	    cc.name, cc.id id_grado, 
        gi.idnumber, cast(ifnull(gg.finalgrade/10, 0) as decimal(10,1)) as calificacion 
        FROM mood_user u, mood_role_assignments ra, mood_context ct, mood_role r, mood_course c, mood_course_categories cc, 
        mood_grade_items gi, mood_grade_grades gg  
        WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id 
        AND gi.courseid = c.id AND gi.id = gg.itemid AND gg.userid = u.id 
        AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.id = '$idest_m' AND gi.itemtype = 'category' AND cc.id IN ('$idgra_m', '$idgra_m1') AND gi.idnumber IN $in 
        ORDER BY cc.name, c.shortname, gi.idnumber, u.lastname, u.firstname";*/
        
    //La siguiente consulta incluye énfasis en educación física para los grados 9, 10 y 11
    //Se cambio física de numérico a bioético --> 51999 a 47997 (10) y 55999 a 52997 (11) --> 71999 a 73997 (CV) y 75999 a 76997 (CVI)
    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
        $queryr01 = "SELECT DISTINCT u.id id_est, u.lastname, u.firstname, c.shortname, 
	    case CONCAT(cc.id,gi.idnumber) when '22TP1F' then 73997 when '22TP2F' then 73997 when '23TP1F' then 76997 when '23TP2F' then 76997 
            	when '16TP1F' then 47997 when '16TP2F' then 47997 when '16TP3F' then 47997 when '16TP4F' then 47997 
            	when '17TP1F' then 52997 when '17TP2F' then 52997 when '17TP3F' then 52997 when '17TP4F' then 52997 
            	when '32TP19' then 42998 when '32TP29' then 42998 when '32TP39' then 42998 when '32TP49' then 42998 
                when '32TP110' then 47998 when '32TP210' then 47998 when '32TP310' then 47998 when '32TP410' then 47998 
                when '32TP111' then 52998 when '32TP211' then 52998 when '32TP311' then 52998 when '32TP411' then 52998 
            	else c.id end as id_mat_mood, 
	    cc.name, cc.id id_grado, 
        gi.idnumber, cast(ifnull(gg.finalgrade/10, 0) as decimal(10,1)) as calificacion 
        FROM mood_user u, mood_role_assignments ra, mood_context ct, mood_role r, mood_course c, mood_course_categories cc, 
        mood_grade_items gi, mood_grade_grades gg  
        WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id 
        AND gi.courseid = c.id AND gi.id = gg.itemid AND gg.userid = u.id 
        AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.id = '$idest_m' AND gi.itemtype = 'category' AND cc.id IN ('$idgra_m', '$idgra_m1') AND gi.idnumber IN $in 
        ORDER BY cc.name, c.shortname, gi.idnumber, u.lastname, u.firstname";
    }
    else {
       $queryr01 = "SELECT DISTINCT u.id id_est, u.lastname, u.firstname, c.shortname, 
	    case CONCAT(cc.id,gi.idnumber) when '22TP1F' then 73997 when '22TP2F' then 73997 when '23TP1F' then 76997 when '23TP2F' then 76997 
            	when '16TP1F' then 47997 when '16TP2F' then 47997 when '16TP3F' then 47997 when '16TP4F' then 47997 
            	when '17TP1F' then 52997 when '17TP2F' then 52997 when '17TP3F' then 52997 when '17TP4F' then 52997 
            	else c.id end as id_mat_mood, 
	    cc.name, cc.id id_grado, 
        gi.idnumber, cast(ifnull(gg.finalgrade/10, 0) as decimal(10,1)) as calificacion 
        FROM mood_user u, mood_role_assignments ra, mood_context ct, mood_role r, mood_course c, mood_course_categories cc, 
        mood_grade_items gi, mood_grade_grades gg  
        WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id 
        AND gi.courseid = c.id AND gi.id = gg.itemid AND gg.userid = u.id 
        AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.id = '$idest_m' AND gi.itemtype = 'category' AND cc.id = '$idgra_m' AND gi.idnumber IN $in 
        ORDER BY cc.name, c.shortname, gi.idnumber, u.lastname, u.firstname"; 
    }
    $queryr01 = utf8_decode($queryr01);
	//echo $queryr01;
	$resultado_r01=$mysqli->query($queryr01);
	$seleccionados_m = $mysqli->affected_rows;
	//echo $seleccionados_m;
	while($row01 = $resultado_r01->fetch_assoc()){
	    if (isset($_SESSION['uniprofe'])) {
	        //echo "control";
			$queryr02="INSERT INTO notas_mood_temp_est (id_est, lastname, firstname, shortname, id_mat_mood, name, id_grado, idnumber, calificacion, email_inst) 
			VALUES (".$row01['id_est'].",'".$row01['lastname']."','".$row01['firstname']."','".$row01['shortname']."',".$row01['id_mat_mood']
			.",'".$row01['name']."',".$row01['id_grado'].",'".$row01['idnumber']."',".$row01['calificacion'].",'".$_SESSION['uniprofe']."')";
		}
		else if (isset($_SESSION['unisuper'])) {
			$queryr02="INSERT INTO notas_mood_temp_est (id_est, lastname, firstname, shortname, id_mat_mood, name, id_grado, idnumber, calificacion, email_inst) 
			VALUES (".$row01['id_est'].",'".$row01['lastname']."','".$row01['firstname']."','".$row01['shortname']."',".$row01['id_mat_mood']
			.",'".$row01['name']."',".$row01['id_grado'].",'".$row01['idnumber']."',".$row01['calificacion'].",'".$_SESSION['unisuper']."')";
		}
		else if (isset($_SESSION['admin_unicab'])) {
			$queryr02="INSERT INTO notas_mood_temp_est (id_est, lastname, firstname, shortname, id_mat_mood, name, id_grado, idnumber, calificacion, email_inst) 
			VALUES (".$row01['id_est'].",'".$row01['lastname']."','".$row01['firstname']."','".$row01['shortname']."',".$row01['id_mat_mood']
			.",'".$row01['name']."',".$row01['id_grado'].",'".$row01['idnumber']."',".$row01['calificacion'].",'".$_SESSION['admin_unicab']."')";
		}
		$resultado_r02=$mysqli1->query($queryr02);
	}
	//echo "<br>".$queryr02;
	
	//************** ESTE EL PARAMETRO QUE HAY QUE CAMBIAR EN LA BASE DE DATOS PARA CONFIGURAR LA ACTUALIZACION DE CALIFICACIONES AL HACER DOBLE CLIC
	//Se valida el parámetro
	$param = 0;
	$query_param = "SELECT v1 FROM tbl_parametros WHERE parametro = 'act_notas_bd'";
	$resultado_param=$mysqli1->query($query_param);
	while($rowparam = $resultado_param->fetch_assoc()){
	    $param = $rowparam['v1'];
	}
	//echo "<br>param antes = ".$param;
	//if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
	//if($perfil == "SU" || $perfil == "AR") {
	if($perfil == "SUXXX") {
	    $param = 1;
	}
	//echo "<br>param después = ".$param;
	
	/*$query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
	        case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion ";*/
	
	//Se genera la consulta para actualizar las calificaciones
	if (isset($_SESSION['uniprofe'])) {
	    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	        $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
	        case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion ";
	    }
	    else {
	        $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion ";
	    }
	    
	}
	else if (isset($_SESSION['unisuper'])) {
	    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	        $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
	        case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['unisuper']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion ";
	    }
	    else {
	       $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['unisuper']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion "; 
	    }
	    
	}
	else if (isset($_SESSION['admin_unicab'])) {
	    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	        $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
	        case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['admin_unicab']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion ";
	    }
	    else {
	        $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['admin_unicab']."' 
            ORDER BY ne.shortname, ep.periodo ) a 
            ON a.id_materia_ra = n.id_materia AND a.periodo = n.id_periodo AND a.id_grado_ra = n.id_grado AND a.id_registro = n.id_estudiante 
            SET n.nota = a.calificacion 
            WHERE n.nota <> a.calificacion ";
	    }
	    
	}
	$query_tupd = utf8_encode($query_tupd);
	//echo $query_tupd;
	//$mysqli1->set_charset("utf8");
	if($param == 1) {
	    $resultado_tupd=$mysqli1->query($query_tupd);
    	if($resultado_tupd > 0) {
    		//console.log("actualizados = ".$mysqli1->affected_rows);
    		$upd_ins[] = "u".$mysqli1->affected_rows;
    	}
	}
	
	/*$query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
            case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";*/
	
	//Se genera la consulta para insertar nuevas calificaciones 
	if (isset($_SESSION['uniprofe'])) {
	    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	        $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
            case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";
	    }
	    else {
	        $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";
	    }
	    
	}
	else if (isset($_SESSION['unisuper'])) {
	    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	        $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
            case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['unisuper']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";
	    }
	    else {
	        $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['unisuper']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";
	    }
	    
	}
	else if (isset($_SESSION['admin_unicab'])) {
	    if($idgra_m == 15 || $idgra_m == 16 || $idgra_m == 17) {
	        $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, 
            case eg.id_grado_ra when 0 then ne.id_grado_ra_enfasis else eg.id_grado_ra end as id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	when 'Noveno 9¡ãTP19' then 42998 when 'Noveno 9¡ãTP29' then 42998 when 'Noveno 9¡ãTP39' then 42998 when 'Noveno 9¡ãTP49' then 42998 
            	when 'D¨¦cimo 10¡ãTP110' then 47998 when 'D¨¦cimo 10¡ãTP210' then 47998 when 'D¨¦cimo 10¡ãTP310' then 47998 when 'D¨¦cimo 10¡ãTP410' then 47998 
            	when 'Once 11¡ãTP111' then 52998 when 'Once 11¡ãTP211' then 52998 when 'Once 11¡ãTP311' then 52998 when 'Once 11¡ãTP411' then 52998 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion, 
            	case nte.idnumber when 'TP19' then 10 when 'TP29' then 10 when 'TP39' then 10 when 'TP49' then 10 
            	when 'TP110' then 11 when 'TP210' then 11 when 'TP310' then 11 when 'TP410' then 11 
            	when 'TP111' then 12 when 'TP211' then 12 when 'TP311' then 12 when 'TP411' then 12 else 0 end id_grado_ra_enfasis 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['admin_unicab']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";
	    }
	    else {
	        $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo VTP1F' then 73997 when 'Ciclo VTP2F' then 73997 when 'Ciclo VITP1F' then 76997 when 'Ciclo VITP2F' then 76997 
            	when 'D¨¦cimo 10¡ãTP1F' then 47997 when 'D¨¦cimo 10¡ãTP2F' then 47997 when 'D¨¦cimo 10¡ãTP3F' then 47997 when 'D¨¦cimo 10¡ãTP4F' then 47997 
            	when 'Once 11¡ãTP1F' then 52997 when 'Once 11¡ãTP2F' then 52997 when 'Once 11¡ãTP3F' then 52997 when 'Once 11¡ãTP4F' then 52997 
            	else nte.id_mat_mood end as id_mat_mood, nte.id_grado, nte.idnumber, nte.email_inst, nte.calificacion 
            FROM notas_mood_temp_est nte) ne, 
            equivalence_idmat em, equivalence_per ep, equivalence_idgra eg, equivalence_idest ee 
            WHERE ne.id_mat_mood = em.id_course AND ne.idnumber = ep.idnumber AND ne.id_grado = eg.id_category AND ne.id_est = ee.id_moodle 
            AND ne.email_inst = '".$_SESSION['admin_unicab']."' 
            ORDER BY ne.shortname, ep.periodo ) m 
            LEFT JOIN notas n 
            ON CONCAT(m.periodo,m.id_materia_ra,m.id_grado_ra,m.id_registro) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) 
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL ";
	    }
	    
	}
	$query_tins = utf8_encode($query_tins);
	//echo $query_tins;
	if($param == 1) {
	    $resultado_tins=$mysqli1->query($query_tins);
    	if($resultado_tins > 0) {
    		//console.log("insertados = ".$mysqli1->affected_rows);
    		$upd_ins[] = "i".$mysqli1->affected_rows;
    	}
    	$notas->upd_ins = $upd_ins;
	}
	
	/*Esto es para mostrar las notas en tabla*/
	if (isset($_SESSION['uniprofe'])) {
	    $queryt = "SELECT DISTINCT ne.*, 
	        m.pensamiento, ep.periodo 
	        FROM notas_mood_temp_est ne, equivalence_idmat em, materias m, equivalence_per ep 
            WHERE ne.id_mat_mood = em.id_course AND em.id_materia_ra = m.id AND ne.idnumber = ep.idnumber 
            AND ne.email_inst = '".$_SESSION['uniprofe']."' 
            ORDER BY ne.shortname, ep.periodo";
	}
	else if (isset($_SESSION['unisuper'])) {
	    $queryt = "SELECT DISTINCT ne.*, m.pensamiento, ep.periodo
            FROM notas_mood_temp_est ne, equivalence_idmat em, materias m, equivalence_per ep 
            WHERE ne.id_mat_mood = em.id_course AND em.id_materia_ra = m.id AND ne.idnumber = ep.idnumber 
            AND ne.email_inst = '".$_SESSION['unisuper']."' 
            ORDER BY ne.shortname, ep.periodo";
	}
	else if (isset($_SESSION['admin_unicab'])) {
	    $queryt = "SELECT DISTINCT ne.*, m.pensamiento, ep.periodo
            FROM notas_mood_temp_est ne, equivalence_idmat em, materias m, equivalence_per ep 
            WHERE ne.id_mat_mood = em.id_course AND em.id_materia_ra = m.id AND ne.idnumber = ep.idnumber 
            AND ne.email_inst = '".$_SESSION['admin_unicab']."' 
            ORDER BY ne.shortname, ep.periodo";
	}
	$queryt = utf8_encode($queryt);
	//echo $queryt;
	
	if($param == 1) {
    	$resultadot=$mysqli1->query($queryt);
    	while($rowt = $resultadot->fetch_assoc()){
    	    $lineas[$i] = $rowt;
    	    $i++;
    	}
	}
	
	//echo json_encode($lineas, JSON_UNESCAPED_UNICODE);
	$tabla->lineas = $lineas;
	//echo json_encode($tabla, JSON_UNESCAPED_UNICODE);
	$notas->tabla = $tabla;
	//echo "<br>";
	echo json_encode($notas, JSON_UNESCAPED_UNICODE);
	
/*}else{
	echo "<script>alert('Debes iniciar sesi¨®n');</script>";
	echo "<script>location.href='../login.php'</script>";
}*/

?>

