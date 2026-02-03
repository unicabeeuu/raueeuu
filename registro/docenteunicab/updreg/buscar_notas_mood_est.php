<?php
    session_start();
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
    //echo $_SESSION['uniprofe'];
	//$idest = $_POST["idest_ra1"];
	//$idgra = $_POST["idgra_ra1"];
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
	if(date($fecha2) >= date('2022/02/01') && date($fecha2) < date('2022/04/08')) {
	    $in = "('TP1','TP1I','TP1F')";
	}
	else if(date($fecha2) >= date('2022/04/09') && date($fecha2) < date('2022/07/01')) {
	    $in = "('TP1','TP1I','TP1F','TP2','TP2I','TP2F')";
	}
	else if(date($fecha2) >= date('2022/07/02') && date($fecha2) < date('2022/09/09')) {
	    $in = "('TP1','TP1I','TP1F','TP2','TP2I','TP2F','TP3','TP3I','TP3F')";
	}
	else if(date($fecha2) >= date('2022/09/10')) {
	    $in = "('TP1','TP1I','TP1F','TP2','TP2I','TP2F','TP3','TP3I','TP3F','TP4','TP4I','TP4F')";
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
	
	$queryr01 = "SELECT DISTINCT u.id id_est, u.lastname, u.firstname, c.shortname, 
	    c.id id_mat_mood, 
	    cc.name, cc.id id_grado, 
        gi.idnumber, cast(ifnull(gg.finalgrade/10, 0) as decimal(10,1)) as calificacion 
        FROM mood_user u, mood_role_assignments ra, mood_context ct, mood_role r, mood_course c, mood_course_categories cc, 
        mood_grade_items gi, mood_grade_grades gg  
        WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id 
        AND gi.courseid = c.id AND gi.id = gg.itemid AND gg.userid = u.id 
        AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.id = '$idest_m' AND gi.itemtype = 'category' AND cc.id = '$idgra_m' AND gi.idnumber IN $in 
        ORDER BY cc.name, c.shortname, gi.idnumber, u.lastname, u.firstname";
	//echo $queryr01;
	$resultado_r01=$mysqli->query($queryr01);
	$seleccionados_m = $mysqli->affected_rows;
	//echo $seleccionados_m;
	while($row01 = $resultado_r01->fetch_assoc()){
		if (isset($_SESSION['uniprofe'])) {
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
	//echo $queryr02;
	
	//Se genera la consulta para actualizar las calificaciones
	if (isset($_SESSION['uniprofe'])) {
	    $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo Vp1f' then 71999 when 'Ciclo Vp2f' then 71999 when 'Ciclo VIp1f' then 75999 when 'Ciclo VIp2f' then 75999 
            	when 'Décimo 10°Física 10' then '51999' when 'Décimo 10°F1' then '51999' when 'Décimo 10°F3' then '51999' when 'Décimo 10°F4' then '51999' 
            	when 'Once 11°FIS1' then '55999' when 'Once 11°FIS2' then '55999' when 'Once 11°FIS3' then '55999' when 'Once 11°FIS4' then '55999' 
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
	else if (isset($_SESSION['unisuper'])) {
	    $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo Vp1f' then 71999 when 'Ciclo Vp2f' then 71999 when 'Ciclo VIp1f' then 75999 when 'Ciclo VIp2f' then 75999 
            	when 'Décimo 10°Física 10' then '51999' when 'Décimo 10°F1' then '51999' when 'Décimo 10°F3' then '51999' when 'Décimo 10°F4' then '51999' 
            	when 'Once 11°FIS1' then '55999' when 'Once 11°FIS2' then '55999' when 'Once 11°FIS3' then '55999' when 'Once 11°FIS4' then '55999' 
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
	else if (isset($_SESSION['admin_unicab'])) {
	    $query_tupd = "UPDATE notas n JOIN 
	        (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo Vp1f' then 71999 when 'Ciclo Vp2f' then 71999 when 'Ciclo VIp1f' then 75999 when 'Ciclo VIp2f' then 75999 
            	when 'Décimo 10°Física 10' then '51999' when 'Décimo 10°F1' then '51999' when 'Décimo 10°F3' then '51999' when 'Décimo 10°F4' then '51999' 
            	when 'Once 11°FIS1' then '55999' when 'Once 11°FIS2' then '55999' when 'Once 11°FIS3' then '55999' when 'Once 11°FIS4' then '55999' 
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
	$query_tupd = utf8_encode($query_tupd);
	//echo $query_tupd;
	//$mysqli1->set_charset("utf8");
	$resultado_tupd=$mysqli1->query($query_tupd);
	if($resultado_tupd > 0) {
		//console.log("actualizados = ".$mysqli1->affected_rows);
		$upd_ins[] = "u".$mysqli1->affected_rows;
	}
	
	//Se genera la consulta para insertar nuevas calificaciones 
	if (isset($_SESSION['uniprofe'])) {
	    $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo Vp1f' then 71999 when 'Ciclo Vp2f' then 71999 when 'Ciclo VIp1f' then 75999 when 'Ciclo VIp2f' then 75999 
            	when 'Décimo 10°Física 10' then '51999' when 'Décimo 10°F1' then '51999' when 'Décimo 10°F3' then '51999' when 'Décimo 10°F4' then '51999' 
            	when 'Once 11°FIS1' then '55999' when 'Once 11°FIS2' then '55999' when 'Once 11°FIS3' then '55999' when 'Once 11°FIS4' then '55999' 
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
	else if (isset($_SESSION['unisuper'])) {
	    $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo Vp1f' then 71999 when 'Ciclo Vp2f' then 71999 when 'Ciclo VIp1f' then 75999 when 'Ciclo VIp2f' then 75999 
            	when 'Décimo 10°Física 10' then '51999' when 'Décimo 10°F1' then '51999' when 'Décimo 10°F3' then '51999' when 'Décimo 10°F4' then '51999' 
            	when 'Once 11°FIS1' then '55999' when 'Once 11°FIS2' then '55999' when 'Once 11°FIS3' then '55999' when 'Once 11°FIS4' then '55999' 
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
	else if (isset($_SESSION['admin_unicab'])) {
	    $query_tins = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
	        SELECT m.calificacion, m.periodo, m.id_materia_ra, m.id_grado_ra, m.id_registro FROM 
            (SELECT DISTINCT ne.*, ep.periodo, em.id_materia_ra, eg.id_grado_ra, ee.id_registro 
            FROM 
            (SELECT nte.id_est, nte.lastname, nte.firstname, nte.shortname, 
            	case CONCAT(nte.name,nte.idnumber) when 'Ciclo IIITP1I' then 61999 when 'Ciclo IIITP2I' then 61999 when 'Ciclo IIITP3I' then 61999 when 'Ciclo IIITP4I' then 61999 
            	when 'Ciclo IVTP1I' then 66999 when 'Ciclo IVTP2I' then 66999 when 'Ciclo IVTP3I' then 66999 when 'Ciclo IVTP4I' then 66999 
            	when 'Ciclo VTP1I' then 70999 when 'Ciclo VTP2I' then 70999 when 'Ciclo VTP3I' then 70999 when 'Ciclo VTP4I' then 70999 
            	when 'Ciclo VITP1I' then 77999 when 'Ciclo VITP2I' then 77999 when 'Ciclo VITP3I' then 77999 when 'Ciclo VITP4I' then 77999 
            	when 'Ciclo Vp1f' then 71999 when 'Ciclo Vp2f' then 71999 when 'Ciclo VIp1f' then 75999 when 'Ciclo VIp2f' then 75999 
            	when 'Décimo 10°Física 10' then '51999' when 'Décimo 10°F1' then '51999' when 'Décimo 10°F3' then '51999' when 'Décimo 10°F4' then '51999' 
            	when 'Once 11°FIS1' then '55999' when 'Once 11°FIS2' then '55999' when 'Once 11°FIS3' then '55999' when 'Once 11°FIS4' then '55999' 
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
	$query_tins = utf8_encode($query_tins);
	$resultado_tins=$mysqli1->query($query_tins);
	if($resultado_tins > 0) {
		//console.log("insertados = ".$mysqli1->affected_rows);
		$upd_ins[] = "i".$mysqli1->affected_rows;
	}
	$notas->upd_ins = $upd_ins;
	
	/***************************PROCESO DE REPLICACION BIOETICO**************************/
	/*if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
	    $query_trepbio = "CREATE TABLE tbl_notas_bio_rep SELECT * FROM notas WHERE id_estudiante = $idest AND id_materia = 10";
	    $resultado_trepbio=$mysqli1->query($query_trepbio);
	}
	else {
	    $query_trepbio = "CREATE TABLE tbl_notas_bio_rep SELECT * FROM notas WHERE id_estudiante = $idest AND id_materia = 1";
	    $resultado_trepbio=$mysqli1->query($query_trepbio);
	}
	
	$query_trepbio = "UPDATE tbl_notas_bio_rep SET id_materia = 2";
    $resultado_trepbio1=$mysqli1->query($query_trepbio);
    $query_trepbio = "UPDATE notas n 
        JOIN tbl_notas_bio_rep nt ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante 
        SET n.nota = nt.nota";
    $resultado_trepbio2=$mysqli1->query($query_trepbio);
    $query_trepbio = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
        SELECT a.nota, a.id_periodo, a.id_materia, a.id_grado, a.id_estudiante FROM (
        SELECT nt.*
        FROM tbl_notas_bio_rep nt 
        LEFT JOIN notas n
        ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
        WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL AND nt.id_grado = $idgra) a";
    $resultado_trepbio3=$mysqli1->query($query_trepbio);
    
    $query_trepbio = "UPDATE tbl_notas_bio_rep SET id_materia = 3";
    $resultado_trepbio4=$mysqli1->query($query_trepbio);
    $query_trepbio = "UPDATE notas n 
        JOIN tbl_notas_bio_rep nt ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante 
        SET n.nota = nt.nota";
    $resultado_trepbio5=$mysqli1->query($query_trepbio);
    $query_trepbio = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
        SELECT a.nota, a.id_periodo, a.id_materia, a.id_grado, a.id_estudiante FROM (
        SELECT nt.*
        FROM tbl_notas_bio_rep nt 
        LEFT JOIN notas n
        ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
        WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL AND nt.id_grado = $idgra) a";
    $resultado_trepbio6=$mysqli1->query($query_trepbio);
    
    $query_trepbio = "DROP TABLE tbl_notas_bio_rep";
    $resultado_trepbio7=$mysqli1->query($query_trepbio);*/
	/***************************FIN PROCESO DE REPLICACION BIOETICO**************************/
	
	/***************************PROCESO DE REPLICACION HUMANISTICO**************************/
	/*if($idgra == 11 || $idgra == 12 || $idgra == 17 || $idgra == 18) {
	    $query_trephum = "CREATE TABLE tbl_notas_hum_rep SELECT * FROM notas WHERE id_estudiante = $idest AND id_materia = 15";
	    $resultado_trephum=$mysqli1->query($query_trephum);
	    
	    $query_trephum = "UPDATE tbl_notas_hum_rep SET id_materia = 8";
        $resultado_trephum1=$mysqli1->query($query_trephum);
        $query_trephum = "UPDATE notas n 
            JOIN tbl_notas_hum_rep nt ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante 
            SET n.nota = nt.nota";
        $resultado_trephum2=$mysqli1->query($query_trephum);
        $query_trephum = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
            SELECT a.nota, a.id_periodo, a.id_materia, a.id_grado, a.id_estudiante FROM (
            SELECT nt.*
            FROM tbl_notas_hum_rep nt 
            LEFT JOIN notas n
            ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL AND nt.id_grado = $idgra) a";
        $resultado_trephum3=$mysqli1->query($query_trephum);
        
        $query_trephum = "UPDATE tbl_notas_hum_rep SET id_materia = 13";
        $resultado_trephum4=$mysqli1->query($query_trephum);
        $query_trephum = "UPDATE notas n 
            JOIN tbl_notas_hum_rep nt ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante 
            SET n.nota = nt.nota";
        $resultado_trephum5=$mysqli1->query($query_trephum);
        $query_trephum = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
            SELECT a.nota, a.id_periodo, a.id_materia, a.id_grado, a.id_estudiante FROM (
            SELECT nt.*
            FROM tbl_notas_hum_rep nt 
            LEFT JOIN notas n
            ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL AND nt.id_grado = $idgra) a";
        $resultado_trephum6=$mysqli1->query($query_trephum);
	}
	else {
	    $query_trephum = "CREATE TABLE tbl_notas_hum_rep SELECT * FROM notas WHERE id_estudiante = $idest AND id_materia = 6";
	    $resultado_trephum=$mysqli1->query($query_trephum);
	    
	    $query_trephum = "UPDATE tbl_notas_hum_rep SET id_materia = 8";
        $resultado_trephum1=$mysqli1->query($query_trephum);
        $query_trephum = "UPDATE notas n 
            JOIN tbl_notas_hum_rep nt ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante 
            SET n.nota = nt.nota";
        $resultado_trephum2=$mysqli1->query($query_trephum);
        $query_trephum = "INSERT INTO notas (nota, id_periodo, id_materia, id_grado, id_estudiante) 
            SELECT a.nota, a.id_periodo, a.id_materia, a.id_grado, a.id_estudiante FROM (
            SELECT nt.*
            FROM tbl_notas_hum_rep nt 
            LEFT JOIN notas n
            ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
            WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL AND nt.id_grado = $idgra) a";
        $resultado_trephum3=$mysqli1->query($query_trephum);
	}
    
    
    $query_trephum = "DROP TABLE tbl_notas_hum_rep";
    $resultado_trephum7=$mysqli1->query($query_trephum);*/
	/***************************FIN PROCESO DE REPLICACION HUMANISTICO**************************/
	
	/***************************PROCESO DE RESTAURACION DE MATRICULA**************************/
	$query_updmatricula = "UPDATE matricula SET estado = 'activo', id_grado = $idgra, EstadoGrado = '' WHERE idMatricula = $idest AND id_estudiante = $idest";
    $resultado_updmatricula=$mysqli1->query($query_updmatricula);
    $query_delhistnot = "DELETE FROM historial_notas WHERE id_estudiante = $idest";
    $resultado_delhistnot=$mysqli1->query($query_delhistnot);
    $query_updest="UPDATE estudiantes SET estado='activo' WHERE id=".$idest."";
	$resultado_updest=$mysqli1->query($query_updest);
	/***************************FIN PROCESO DE RESTAURACION DE MATRICULA**************************/
	
	/*Esto es para mostrar las notas en tabla*/
	if (isset($_SESSION['uniprofe'])) {
	    $queryt = "SELECT DISTINCT ne.*, m.pensamiento, ep.periodo 
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
	$resultadot=$mysqli1->query($queryt);
	while($rowt = $resultadot->fetch_assoc()){
	    $lineas[$i] = $rowt;
	    $i++;
	}
	//echo json_encode($lineas, JSON_UNESCAPED_UNICODE);
	$tabla->lineas = $lineas;
	//echo json_encode($tabla, JSON_UNESCAPED_UNICODE);
	$notas->tabla = $tabla;
	echo json_encode($notas, JSON_UNESCAPED_UNICODE);
	
/*}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../../login_registro.php'</script>";
}*/

?>

