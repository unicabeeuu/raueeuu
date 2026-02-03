<?php  
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	//https://unicab.org/registro/docenteunicab/updreg/act_moodle_getdat.php
	
	//Se limpian las tablas
	$sql_del = "DELETE FROM tbl_config_act";
	$resultado_sql_del=$mysqli1->query($sql_del);
	
	$sql_del = "DELETE FROM tbl_temp";
	$resultado_sql_del=$mysqli1->query($sql_del);
	
	$periodo = $_REQUEST['periodo'];
	
	//Se hace el insert en la tabla tbl_temp
	/*$query0 = "SELECT DISTINCT gi.id 
        FROM mood_grade_items gi, mood_course c, mood_course_categories cc 
        WHERE gi.courseid=c.id AND c.category = cc.id 
        AND gi.grademax > 1 AND c.shortname NOT IN ('CapDocente','Infografías','Ingrafías','PrácticaDoc','Ajedrz','Inducción','Inducción-Unicab') 
        AND gi.idnumber like '%".$periodo."%' 
        ORDER BY cc.id, c.id, gi.idnumber";*/
    $query0 = "SELECT DISTINCT gi.id 
        FROM mood_grade_items gi, mood_course c, mood_course_categories cc 
        WHERE gi.courseid=c.id AND c.category = cc.id 
        AND gi.grademax > 1 AND c.shortname NOT IN ('CapDocente','Infografías','Ingrafías','PrácticaDoc','Ajedrz','Inducción','Inducción-Unicab') 
        ORDER BY cc.id, c.id, gi.idnumber";
    //echo $query0;
    
    /*$resultado0=$mysqli->query($query0);
	$sel = $mysqli->affected_rows;
	//echo $sel;
	
	while($row0 = $resultado0->fetch_assoc()) {
	    $query_ins = "INSERT INTO tbl_temp (c1, c2, v1) 
	        VALUES ('0', '0', ".$row0['id'].")";
		//echo $query_ins; 
		
		$resultado_ins=$mysqli1->query($query_ins);
	}*/
    
	//Se hace el insert en la tabla tbl_config_act
	/*$query01 = "SELECT DISTINCT gi.itemname, gi.id, c.shortname, c.id id_pensamiento, cast(gi.grademax as signed) grademax, cast(gi.gradepass as signed) gradepass, 
	    gi.calculation, gi.idnumber, cc.name, cc.id id_grado 
        FROM mood_grade_items gi, mood_course c, mood_course_categories cc 
        WHERE gi.courseid=c.id AND c.category = cc.id 
        AND gi.grademax > 1 AND c.shortname NOT IN ('CapDocente','Infografías','Ingrafías','PrácticaDoc','Ajedrz','Inducción','Inducción-Unicab') 
        AND gi.idnumber like '%".$periodo."%' 
        ORDER BY cc.id, c.id, gi.idnumber";*/
    $query01 = "SELECT DISTINCT gi.itemname, gi.id, c.shortname, c.id id_pensamiento, cast(gi.grademax as signed) grademax, cast(gi.gradepass as signed) gradepass, 
	    gi.calculation, gi.idnumber, cc.name, cc.id id_grado 
        FROM mood_grade_items gi, mood_course c, mood_course_categories cc 
        WHERE gi.courseid=c.id AND c.category = cc.id 
        AND gi.grademax > 1 AND c.shortname NOT IN ('CapDocente','Infografías','Ingrafías','PrácticaDoc','Ajedrz','Inducción','Inducción-Unicab') 
        ORDER BY cc.id, c.id, gi.idnumber";
    echo $query01;
    
	$resultado01=$mysqli->query($query01);
	$sel = $mysqli->affected_rows;
	//echo $sel;
	
	while($row01 = $resultado01->fetch_assoc()) {
	    $query_ins = "INSERT INTO tbl_config_act (itemname, id_act, shortname, id_pensamiento, grademax, gradepass, calculation, idnumber, 
	        name, id_grado, porcentaje, computar_en, calculation1) 
	        VALUES ('".str_replace("'","''",$row01['itemname'])."', ".$row01['id'].", '".$row01['shortname']."', ".$row01['id_pensamiento'].", ".$row01['grademax'].", ".$row01['gradepass'].", '".
	        $row01['calculation']."', '".$row01['idnumber']."', '".$row01['name']."', ".$row01['id_grado'].",0,0,'=')";
		//echo $query_ins; 
		
		$resultado_ins=$mysqli1->query($query_ins);
	}
	
	//Se borran las actividades que ya están configuradas *****************************
	//$query_del = "DELETE FROM tbl_config_act WHERE id_act IN (SELECT id_act FROM tbl_config_act_ok)";
	$query_upd = "UPDATE tbl_config_act tc JOIN tbl_config_act_ok tc1 
        ON tc.id_act = tc1.id_act SET tc.porcentaje = tc1.porcentaje, tc.computar_en = tc1.computar_en, tc.calculation1 = tc1.calculation1, tc.asignada = 'OK'";
	$resultado_upd=$mysqli1->query($query_upd);
	$upd = $mysqli1->affected_rows;
	
	echo "<br>tabla tbl_config_act cargada con ".$sel." registros y actualiza con ".$upd." registros";
	
?>