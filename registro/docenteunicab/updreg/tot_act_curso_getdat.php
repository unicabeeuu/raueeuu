<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$control = 0;
	
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
	else if(date($fecha2) >= date('2022/09/12')) {
	    $in = "('TP1','TP1I','TP1F','TP2','TP2I','TP2F','TP3','TP3I','TP3F','TP4','TP4I','TP4F')";
	}
	//echo $in;
	
	//se buscan las actividades con los id TP1, etc...
	//$query_tp = "SELECT id_act FROM tbl_config_act_ok WHERE idnumber IN $in";
	//$query_tp = "SELECT id_act FROM tbl_config_act_ok WHERE computar_en IN (SELECT id_act FROM tbl_config_act_ok WHERE idnumber IN $in)";
	//echo $query_tp;
	
	$query0 = "DELETE FROM tbl_tot_act_curso";
	$resultado0=$mysqli1->query($query0);
	
	//Esta consulta era la anterior... se consultaban las tablas de moodle
	/*$query1 = "SELECT COUNT(1) ct, a.shortname, a.id_pen FROM 
        (SELECT DISTINCT gi.itemname, gi.id id_act, c.shortname, c.id id_pen, gi.grademax, gi.gradepass, gi.calculation 
        FROM mood_grade_items gi, mood_course c 
        WHERE gi.courseid=c.id  
        AND gi.grademax > 1 AND gi.itemtype = 'mod' 
        AND gi.itemname != '') a 
        GROUP BY a.shortname, a.id_pen";*/
        
    //Esta es la nueva consulta que depende de la configuración de calificaciones en registro
    $query1 = "SELECT COUNT(1) ct, eg.name, ao.id_grado, em.shortname, ao.id_pensamiento   
        FROM tbl_config_act_ok ao, equivalence_idmat em, equivalence_idgra eg 
        WHERE ao.id_pensamiento = em.id_course AND ao.id_grado = eg.id_category  
        AND ao.id_act IN (SELECT id_act FROM tbl_config_act_ok 
        WHERE computar_en IN (SELECT id_act FROM tbl_config_act_ok WHERE idnumber IN $in))
        GROUP BY id_grado, id_pensamiento";
	//echo $query1;
	
	$resultado1=$mysqli1->query($query1);
	while($row = $resultado1->fetch_assoc()) {
	    $query_ins = "INSERT INTO tbl_tot_act_curso (ct, shortname) VALUES (".$row['ct'].",'".$row['shortname']."')";
	    $resultado_ins=$mysqli1->query($query_ins);
	    $control++;
	    //echo $query_ins;
	}
	echo "Tabla tbl_tot_act_curso cargada con ".$control." registros.";
?>