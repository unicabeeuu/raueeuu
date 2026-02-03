<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idact = $_REQUEST["idact"];
	$idgra = $_REQUEST["idgra"];
	$idpen = $_REQUEST["idpen"];
	//echo $idgra;
	//echo $idpen;
	
	$cadena = "=sum(";
	$cadena1 = "=sum(";
	$control = 0;
	$act = 1;
	$formula = new stdClass();
	$datos = new stdClass();
	
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
	    $per = 1;
	}
	else if(date($fecha2) >= date('2022/04/09') && date($fecha2) < date('2022/07/01')) {
	    $per = 2;
	}
	else if(date($fecha2) >= date('2022/07/02') && date($fecha2) < date('2022/09/09')) {
	    $per = 3;
	}
	else if(date($fecha2) >= date('2022/09/10')) {
	    $per = 4;
	}
	//echo $per;
	//$per = 2;
	
	$idnumber1 = "";
	$computar_en = 0;
	$letra_final = "";
	//$idnumber1 = "G".$idgra."M".$idpen."A".$act."P".$per."";
    //echo $idnumber1;
    
    //Se valida el idnumber del total (computar en) para verificar si es física o inglés
    $query0 = "SELECT idnumber FROM tbl_config_act WHERE id_act = $idact";
    $resultado0=$mysqli1->query($query0);
    while($row0 = $resultado0->fetch_assoc()) {
	    $idnumber = $row0['idnumber'];
	}
	if($idnumber == 'TP1F') {
	    $letra_final = "F";
	}
	else if($idnumber == 'TP1I') {
	    $letra_final = "I";
	}
	
	//Se valida la sumatoria de los porcentajes
	$query = "SELECT round(sum(porcentaje),2) total FROM tbl_config_act WHERE computar_en = $idact";
	//echo $query;
	$resultado=$mysqli1->query($query);
	while($row = $resultado->fetch_assoc()) {
	    $total = $row['total'];
	}
	//echo $total;
	
	if($total < 1 || $total > 1) {
	    //echo "Error. La sumatoria de porcentajes no da 100%";
	    $datos->resultado = "Error";
	    $datos->msg = "La sumatoria de porcentajes no da 100%";
	    $control = 1;
	}
	else {
	    //Se eliminan los registros de actividades
	    $query_del = "DELETE FROM tbl_config_act_ok WHERE computar_en = $idact OR id_act = $idact";
	    $resultad_del=$mysqli1->query($query_del);
	    
	    //Se cargan los registro de actividades con sus porcentajes
	    $query1 = "SELECT * FROM tbl_config_act WHERE computar_en = $idact";
	    $resultado1=$mysqli1->query($query1);
	    while($row1 = $resultado1->fetch_assoc()) {
    	    $cadena = $cadena."##gi".$row1['id_act']."##*".$row1['porcentaje'].",";
    	    $cadena1 = $cadena1.$row1['id_act']."*".$row1['porcentaje'].",";
    	    $computar_en = $row1['computar_en'];
    	    
    	    //Se hace el insert en la tabla tbl_config_act_ok
    	    $idnumber1 = "G".$idgra."M".$idpen."A".$act."P".$per.$letra_final;
    	    //echo $idnumber1;
    	    $query_ins = "INSERT INTO tbl_config_act_ok (itemname, id_act, id_pensamiento, idnumber, id_grado, porcentaje, computar_en, calculation1, idnumber1) 
        	    VALUES ('".str_replace("'","''",$row1['itemname'])."',".$row1['id_act'].",".$row1['id_pensamiento'].",'".$row1['idnumber']."',"
        	    .$row1['id_grado'].",".$row1['porcentaje'].",".$row1['computar_en'].",'=','".$idnumber1."')";
    	    //echo $query_ins;
    	    $resultado_ins=$mysqli1->query($query_ins);
    	    $act++;
    	}
    	$cadena = substr($cadena,0,strlen($cadena)-1);
    	$cadena = $cadena.")";
    	$cadena1 = substr($cadena1,0,strlen($cadena1)-1);
    	$cadena1 = $cadena1.")";
    	//echo $cadena;
    	$datos->resultado = "OK";
	    $datos->msg = "OK";
	    $datos->form = $cadena;
	    $datos->form1 = $cadena1;
    	
    	//Se carga el registro con la f車rmula
    	$query2 = "SELECT * FROM tbl_config_act WHERE id_act = $computar_en";
	    $resultado2=$mysqli1->query($query2);
	    while($row2 = $resultado2->fetch_assoc()) {
	        $query_ins1 = "INSERT INTO tbl_config_act_ok (itemname, id_act, id_pensamiento, idnumber, id_grado, porcentaje, computar_en, calculation1, idnumber1) 
	            VALUES ('".$row2['itemname']."',".$row2['id_act'].",".$row2['id_pensamiento'].",'".$row2['idnumber']."',"
    	        .$row2['id_grado'].",".$row2['porcentaje'].",".$row2['computar_en'].",'".$cadena."','')";
    	    //echo $query_ins1;
    	    $resultado_ins1=$mysqli1->query($query_ins1);
	    }
    	
    	$control = 0;
	}
	
	//Se actuliza el calculo
	if($control == 0) {
	    $query2 = "UPDATE tbl_config_act SET calculation1 = '$cadena' WHERE id_act = $idact";
	    $resultado2=$mysqli1->query($query2);
	}
	else {
	    $query2 = "UPDATE tbl_config_act SET calculation1 = '=' WHERE id_act = $idact";
	    $resultado2=$mysqli1->query($query2);
	}
	
	$formula->datos = $datos;
	echo json_encode($formula, JSON_UNESCAPED_UNICODE);
	
?>