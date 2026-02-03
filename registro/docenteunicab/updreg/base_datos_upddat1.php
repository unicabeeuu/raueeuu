<?php  
	require("1cc3s4db.php");
	
	$control = 0;
	
	//Se hace el insert en la tabla de equivalence_idest
	$query0 = "SELECT * FROM equivalence_idest_temp1";
	$resultado0=$mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()) {
	    if($row0['actualizar'] == 1) {
	        $query_ins = "INSERT INTO equivalence_idest (id_moodle, id_registro) VALUES (".$row0['id_moodle'].",".$row0['id_registro'].")";
		    $resultado_ins=$mysqli1->query($query_ins);
		    $control++;
	    }
	}
	echo "Tabla de equivalencia actualizada con ".$control." registros.";
	
?>