<?php  
	//set_time_limit(0);
	require("1cc3s4db.php");	
	
	//Se limpian las tablas
	$sql_drop = "DROP TABLE equivalence_idest_temp";
	$resultado_sql_drop = $mysqli1->query($sql_drop);
	echo "tabla borrada\n";
	
	$sql_del = "DELETE FROM equivalence_idest_temp1";
	$resultado_sql_del = $mysqli1->query($sql_del);
	echo "registros borrados\n";
	
	//Se crea la tabla temporal de estudiantes que están en la tabla tbl_estudiantes_mood y que no están en la tabla de equivalence_idest
	$sql = "CREATE TABLE equivalence_idest_temp SELECT * FROM `tbl_estudiantes_mood` WHERE id NOT IN (SELECT id_moodle FROM equivalence_idest) 
	 AND grado != 'Diplomados'";
	$resultado_sql = $mysqli1->query($sql);
	echo $sql."\n";
	echo "tabla creada\n";
	$control = 0;
	
	//Se hace el insert en la tabla de equivalence_idest
	$query0 = "SELECT * FROM equivalence_idest_temp";
	$resultado0 = $mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()) {
	    $id_moodle = $row0['id'];
	    $nom_moodle = strtoupper($row0['apellidos'])." ".strtoupper($row0['nombres']);
	    $grado = $row0['grado'];
	    //Se consultan los id en registro
	    $sql1 = "SELECT * FROM estudiantes WHERE apellidos like '%".$row0['apellidos']."%' OR nombres like '%".$row0['apellidos']."%' 
	        OR (apellidos like '%".$row0['nombres']."%' OR nombres like '%".$row0['nombres']."%')";
	    $resultado_sql1 = $mysqli1->query($sql1);
	    while($row1 = $resultado_sql1->fetch_assoc()) {
	        $id_registro = $row1['id'];
	        $nom_registro = $row1['apellidos']." ".$row1['nombres'];
	        $nom_registro1 = $row1['nombres']." ".$row1['apellidos'];
	        if($nom_moodle == $nom_registro || $nom_moodle == $nom_registro1) {
	            $control = 1;
	            break;
	        }
	    }		
		
		if($control == 1) {
		    $query_ins = "INSERT INTO equivalence_idest_temp1 (id_moodle, nom_moodle, grado, id_registro, nom_registro, actualizar) 
		        VALUES ($id_moodle, '$nom_moodle', '$grado', $id_registro, '$nom_registro', 1)";
		}
		else {
		    $query_ins = "INSERT INTO equivalence_idest_temp1 (id_moodle, nom_moodle, grado, id_registro, nom_registro, actualizar) 
		        VALUES ($id_moodle, '$nom_moodle', '$grado', $id_registro, '$nom_registro', 0)";
		}
		$resultado_ins = $mysqli1->query($query_ins);
		$control = 0;
	}
	echo "tabla cargada\n";
	
?>