<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idact = $_REQUEST["idact"];
	
	$control = 0;
	
	//Se eliminan los registros de actividades
	$query0 = "SELECT * FROM tbl_config_act_ok WHERE computar_en = $idact";
	//echo $query0;
	
	$resultado0=$mysqli1->query($query0);
	//$upd = $mysqli1->affected_rows;
	while($row0 = $resultado0->fetch_assoc()) {
	    $query2 = "UPDATE tbl_config_act SET porcentaje = 0, computar_en = 0, asignada = 'NA' WHERE id_act = ".$row0['id_act'];
	    //echo $query2;
	    $resultado2=$mysqli1->query($query2);
	    $control++;
	}
	//Se actuliza el calculo
	if($control > 0) {
	    $query1 = "UPDATE tbl_config_act SET calculation1 = '=', asignada = 'NA' WHERE id_act = $idact";
	    $resultado1=$mysqli1->query($query1);
	}
	
    $query_del = "DELETE FROM tbl_config_act_ok WHERE computar_en = $idact OR id_act = $idact";
    $resultad_del=$mysqli1->query($query_del);
    $del = $mysqli1->affected_rows;
    
    if($del > 0) {
        echo "ForDesOk";
    }
	else {
	    echo "ForDesError";
	}
	
?>