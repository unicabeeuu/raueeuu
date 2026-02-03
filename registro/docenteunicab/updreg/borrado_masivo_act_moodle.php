<?php  
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	
	//Se borra la tabla
	$sql_drop = "DROP TABLE tbl_id_act";
	$res_drop=$mysqli1->query($sql_drop);
	echo "Tabla tbl_id_act borrada.<br/>";
	
	//Se crea la tabla
	$sql_create = "CREATE TABLE tbl_id_act SELECT id_act FROM 
        (SELECT * FROM `tbl_config_act` WHERE idnumber IN ('TP2','TP3') UNION ALL 
        SELECT * FROM tbl_config_act WHERE idnumber = 'TP1' AND id_grado IN (19,20,22,23,28,30)) a";
	$res_create=$mysqli1->query($sql_create);
	
	$sql_count = "SELECT COUNT(1) ct FROM tbl_id_act";
	$res_count=$mysqli1->query($sql_count);
	while($rowc = $res_count->fetch_assoc()){
	    $ct = $rowc['ct'];
	}
	echo "<span style='color: blue;'>Tabla tbl_id_act creada con ".$ct." registros.</span><br/>";
	
	//Se borrar los id_act de quienes no hicieron cambios
	$sql_delidact = "DELETE FROM tbl_id_act WHERE id_act IN (SELECT id_act FROM tbl_id_act_no)";
	$res_delidact=$mysqli1->query($sql_delidact);
    
    $sql_count1 = "SELECT COUNT(1) ct FROM tbl_id_act";
	$res_count1=$mysqli1->query($sql_count1);
	while($rowc1 = $res_count1->fetch_assoc()){
	    $ct1 = $rowc1['ct'];
	}
	$tot = $ct - $ct1;
    echo "<span style='color: blue;'>Se borraron ".$tot." de tabla tbl_id_act.</span><br/>";
	
	//Se hace la consultas
	$sql_idact = "SELECT * FROM tbl_id_act";
	
	$res_idact=$mysqli1->query($sql_idact);
	while($row0 = $res_idact->fetch_assoc()){
	    //Se limpian las tablas
    	$sql_del1 = "DELETE FROM tbl_config_act_ok WHERE id_act = ".$row0['id_act']." or computar_en = ".$row0['id_act'];
    	$resultado_sql_del1=$mysqli1->query($sql_del1);
    	//$sel1 = $mysqli->affected_rows;
    	//echo $sql_del1;
    	
    	$sql_del2 = "DELETE FROM tbl_config_act WHERE id_act = ".$row0['id_act']." or computar_en = ".$row0['id_act'];
    	$resultado_sql_del2=$mysqli1->query($sql_del2);
    	//$sel2 = $mysqli->affected_rows;
    	//echo $sql_del2."<br/>";
	}
	
	echo "Borrado de <span style='color: purple;'>".$sel1." registros en la tabla tbl_config_act_ok</span> y <span style='color: red'>".$sel2." registros en la tabla tbl_config_act.</span>";
	
?>