<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/calif_mood_upddat1.php?idgra=14&idpen=37
	
	$idgra = $_REQUEST["idgra"];
	$idpen = $_REQUEST["idpen"];
	//echo $idgra;
	//echo $idpen;
	
	$control = 0;
	$control1 = 0;
	$cadena = "";
	
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
	if(date($fecha2) >= date('2023/02/01') && date($fecha2) < date('2023/04/16')) {
	    $per = "P1";
	    $idnumber = "('TP1', 'TP1I', 'TP1F', 'TP19', 'TP110', 'TP111')";
	}
	else if(date($fecha2) >= date('2023/04/17') && date($fecha2) < date('2023/06/11')) {
	    $per = "P2";
	    $idnumber = "('TP2', 'TP2I', 'TP2F', 'TP29', 'TP210', 'TP211')";
	}
	else if(date($fecha2) >= date('2023/06/12') && date($fecha2) < date('2023/09/03')) {
	    $per = "P3";
	    $idnumber = "('TP3', 'TP3I', 'TP3F', 'TP39', 'TP310', 'TP311')";
	}
	else if(date($fecha2) >= date('2023/09/04')) {
	    $per = "P4";
	    $idnumber = "('TP4', 'TP4I', 'TP4F', 'TP49', 'TP410', 'TP411')";
	}
	
	//Las siguientes l¨ªneas son para actualizar manualmente para un periodo diferente al actual
	$temp = 3;
	if($temp == 1) {
	    $per = "P1";
	    $idnumber = "('TP1', 'TP1I', 'TP1F', 'TP19', 'TP110', 'TP111')";
	}
	else if($temp == 2) {
	    $per = "P2";
	    $idnumber = "('TP2', 'TP2I', 'TP2F', 'TP29', 'TP210', 'TP211')";
	}
	else if($temp == 3) {
	   $per = "P3";
	   $idnumber = "('TP3', 'TP3I', 'TP3F', 'TP39', 'TP310', 'TP311')"; 
	}
	else if($temp == 4) {
	   $per = "P4";
	    $idnumber = "('TP4', 'TP4I', 'TP4F', 'TP49', 'TP410', 'TP411')";
	}
	
	    
	//Se borran los datos en la tabla mood_equivalence_per
	$query0 = "DELETE FROM mood_equivalence_per";
	$res_del=$mysqli->query($query0);
	
	//Se hace el insert de los nuevos id de las actividades
	//$query1 = "SELECT * FROM tbl_config_act_ok WHERE calculation1 = '=' AND id_grado = $idgra AND id_pensamiento = $idpen";
	$query1 = "SELECT * 
        FROM tbl_config_act_ok WHERE calculation1 = '=' AND id_grado = $idgra AND id_pensamiento = $idpen
        AND SUBSTRING(idnumber1, LENGTH(idnumber1)-1,LENGTH(idnumber1)) = '$per'";
    //echo $query1;
	/*$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    //Se hace el insert en la tabla mood_equivalence_per
	    $query_ins = "INSERT INTO mood_equivalence_per (idnumber1, id_act, porcentaje, computar_en, calculation1) 
	        VALUES ('".$row['idnumber1']."',".$row['id_act'].",".$row['porcentaje'].",".$row['computar_en'].",'".$row['calculation1']."')";
	    $res_ins=$mysqli->query($query_ins);
	    $ins = $mysqli->affected_rows;
	    $control = $control + $ins;
	}*/
	//echo $query_ins;
	
	//Se hace el insert de las fÃ³rmulas
	$query1 = "SELECT * FROM tbl_config_act_ok WHERE calculation1 != '=' AND id_grado = $idgra AND id_pensamiento = $idpen AND idnumber IN $idnumber";
	echo $query1;
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    //Se hace el insert en la tabla mood_equivalence_per
	    $query_ins = "INSERT INTO mood_equivalence_per (id_act, porcentaje, computar_en, calculation1) 
	        VALUES (".$row['id_act'].",".$row['porcentaje'].",".$row['computar_en'].",'".$row['calculation1']."')";
	    $res_ins=$mysqli->query($query_ins);
	    $ins1 = $mysqli->affected_rows;
	    $control1 = $control1 + $ins1;
		echo "<br>".$query_ins;
	}
	
	$cadena = '<p>'.$control.' Registros de actividades con idnumber insertadas y '.$control1.' registro de computo de calificaciones insertado.</p>';	
	
	//Actualizar los idnumber de las actividades y las fÃ³rmulas de calculaciÃ³n en los periodos
    /*$query_upd = "UPDATE mood_grade_items gi 
        JOIN mood_equivalence_per ep ON gi.id = ep.id_act
        SET gi.idnumber = ep.idnumber1 
        WHERE ep.calculation1 = '='";
    $res_upd=$mysqli->query($query_upd);
	$upd = $mysqli->affected_rows;
	$cadena = $cadena.'<p>'.$upd.' Registros de actividades con idnumber actualizados.</p>';*/
    
    $query_upd = "UPDATE mood_grade_items gi 
        JOIN mood_equivalence_per ep ON gi.id = ep.id_act
        SET gi.calculation = ep.calculation1 
        WHERE ep.calculation1 != '='";
    echo "<br/>".$query_upd;
    
    $res_upd=$mysqli->query($query_upd);
	$upd = $mysqli->affected_rows;
	$cadena = $cadena.'<p>'.$upd.' Registro de computo de calificaciones actualizado.</p>'; 
        
    echo utf8_encode($cadena);
?>