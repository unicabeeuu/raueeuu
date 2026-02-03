<?php
	//Genera el select de los grados
	session_start();
	require("1cc3s4db.php");
	include "../../adminunicab/php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	$idpen = $_REQUEST["idpen"];
	//echo $idgra;
	//echo $idpen;
	
	if ($idpen == 47997) {
		$idpen = 47;
	}
	else if ($idpen == 52997) {
		$idpen = 52;
	}
	else if ($idpen == 73997) {
		$idpen = 73;
	}
	else if ($idpen == 76997) {
		$idpen = 76;
	}
	
	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
	
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
	
	//Se valida la fecha actual con respecto a los cierres de periodo --- ESTO NO APLICA
	if(date($fecha2) >= date('2022/02/01') && date($fecha2) < date('2022/04/08')) {
	    $notin = "('TP2','TP2I','TP2F','TP3','TP3I','TP3F','TP4','TP4I','TP4F')";
	    $per = "P1";
	}
	else if(date($fecha2) >= date('2022/04/09') && date($fecha2) < date('2022/07/01')) {
	    $notin = "('TP1','TP1I','TP1F','TP3','TP3I','TP3F','TP4','TP4I','TP4F')";
	    $per = "P2";
	}
	else if(date($fecha2) >= date('2022/07/02') && date($fecha2) < date('2022/09/09')) {
	    $notin = "('TP1','TP1I','TP1F','TP2','TP2I','TP2F','TP4','TP4I','TP4F')";
	    $per = "P3";
	}
	else if(date($fecha2) >= date('2022/09/10')) {
	    $notin = "('TP2','TP2I','TP2F','TP3','TP3I','TP3F','TP1','TP1I','TP1F')";
	    $per = "P4";
	}
	//echo $per;
	
	$cadena = "";
	
	//$query1 = "SELECT * FROM tbl_config_act WHERE id_grado = $idgra AND id_pensamiento = $idpen";
	if($id == 18) {
	    $query1 = "SELECT *, 
    	case idnumber when 'TP1' then 'NO' when 'TP1I' then 'NO' when 'TP1F' then 'NO' 
    	when 'TP2' then 'NO' when 'TP2I' then 'NO' when 'TP2F' then 'NO' 
    	when 'TP3' then 'NO' when 'TP3I' then 'NO' when 'TP3F' then 'NO' 
    	when 'TP4' then 'NO' when 'TP4I' then 'NO' when 'TP4F' then 'NO' else 'SI' end as editar 
    	FROM tbl_config_act WHERE id_grado = $idgra AND id_pensamiento = $idpen";
	}
	else {
	    $query1 = "SELECT *, 
    	case idnumber when 'TP1' then 'NO' when 'TP1I' then 'NO' when 'TP1F' then 'NO' 
    	when 'TP2' then 'NO' when 'TP2I' then 'NO' when 'TP2F' then 'NO' 
    	when 'TP3' then 'NO' when 'TP3I' then 'NO' when 'TP3F' then 'NO' 
    	when 'TP4' then 'NO' when 'TP4I' then 'NO' when 'TP4F' then 'NO' else 'SI' end as editar 
    	FROM tbl_config_act WHERE id_grado = $idgra AND id_pensamiento = $idpen AND idnumber NOT IN ".$notin." AND IFNULL(asignada, 'NA') != 'OK'";
	}
	$query1 = "SELECT *, 
    	case idnumber when 'TP1' then 'NO' when 'TP1I' then 'NO' when 'TP1F' then 'NO' 
    	when 'TP2' then 'NO' when 'TP2I' then 'NO' when 'TP2F' then 'NO' 
    	when 'TP3' then 'NO' when 'TP3I' then 'NO' when 'TP3F' then 'NO' 
    	when 'TP4' then 'NO' when 'TP4I' then 'NO' when 'TP4F' then 'NO' else 'SI' end as editar 
    	FROM tbl_config_act WHERE id_grado = $idgra AND id_pensamiento = $idpen";
	//echo $query1;
	
	$cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr class='GridViewScrollHeader'>
	                            <td>Id_act</td>
	                            <td>Actividad</td>
	                            <td>Id_gra</td>
	                            <td>Id_pen</td>
	                            <td>Idnumber</td>
	                            <td>Porcentaje</td>
	                            <td>Computar_en</td>
	                            <td>Calculation</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    if($row['editar'] == "SI") {
	        $cadena = $cadena."<tr>
                <td>".$row['id_act']."</td>
                <td>".str_replace("'","_",$row['itemname'])."</td>
                <td>".$row['id_grado']."</td>
                <td>".$row['id_pensamiento']."</td>
                <td>".$row['idnumber']."</td>
                <td>".$row['porcentaje']."</td>
                <td>".$row['computar_en']."</td>
                <td>".substr($row['calculation1'],0,20)."...</td>
                <td><button class='btn btn-warning glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modal_porcentajes' title='Editar'
                onclick='enviardat(".$row['id_act'].",\"".str_replace("'","_",$row['itemname'])."\",".$row['id_grado'].",".$row['id_pensamiento'].",\"".$row['idnumber']."\")'></button></td></tr>";
	    }
	    else {
	        $cadena = $cadena."<tr>
                <td>".$row['id_act']."</td>
                <td>".str_replace("'","_",$row['itemname'])."</td>
                <td>".$row['id_grado']."</td>
                <td>".$row['id_pensamiento']."</td>
                <td>".$row['idnumber']."</td>
                <td>".$row['porcentaje']."</td>
                <td>".$row['computar_en']."</td>
                <td>".substr($row['calculation1'],0,20)."...</td>
                <td><button class='btn btn-info glyphicon glyphicon-eye-open' title='Ver fórmula' onclick='verformula(".$row['id_act'].")'></button></td></tr>";
	    }
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>