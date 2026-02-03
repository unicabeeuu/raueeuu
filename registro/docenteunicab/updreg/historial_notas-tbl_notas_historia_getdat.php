<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$id = 0;
	$id_gra = 0;
	$id_matric = '';
	
	//En PHP existe una clase predefinida en el lenguaje que se llama stdClass. ¿Y que hace tan especial a esta clase? 
	//Pues que no tiene ni propiedades, ni m¨¦todos, ni padre; es una clase vacía. 
	//¿Y para que queremos esta clase si no tiene nada? Podemos usar esta clase cuando necesitamos un objeto gen¨¦rico al que luego el podremos añadir propiedades.
	
	//$objeto = new stdClass();
    //$objeto->nombre = "Manuel";
    //$objeto->apellidos = "Carrascosa de la Blanca";
    //$objeto->web = "http://mjcarrascosa.com";
    
    //Con este c¨®digo hemos creado un objeto al que luego le hemos añadido tres atributos. 
    //Esto nos puede servir cuando queremos tener un objeto que solo tenga datos y, por la raz¨®n que sea, no queremos crear una clase espec¨ªfica.
	
	$datos = new stdClass();
	$calif_finales = array();
	$keys = ['id_mat','per1'];
	$i = 0;
	
	//Se hace la consulta
    /*$query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, n.id_matricula, 
        round(n.promedio,1) as per1 
        FROM historial_notas n, estudiantes e 
        WHERE n.id_estudiante = e.id AND n.id_materia NOT IN (2,3,8,13) AND n.id_estudiante = 513 
        ORDER BY n.id_estudiante, n.id_grado";*/
    $query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, n.id_matricula, 
        round(n.promedio,1) as per1 
        FROM historial_notas n, estudiantes e 
        WHERE n.id_estudiante = e.id AND n.id_materia NOT IN (2,3,8,13) 
        ORDER BY n.id_estudiante, n.id_grado";
    $resultado0 = $mysqli1->query($query0);
    while($row0 = $resultado0->fetch_assoc()) {
        $id_est = $row0['id_estudiante'];
        $id_gra1 = $row0['id_grado'];
        $id_matricula = $row0['id_matricula'];
        
        if($id == $id_est && $id_gra == $id_gra1) {
            //echo "primera condiciÃ³n";
            //Se sigue armando el objeto json  
            $valores = [$row0['id_materia'],$row0['per1']];
      		$calif = array_combine($keys,$valores);
      		$calif_finales[$i] = $calif;
      		$i++;
        }
        else if($id == $id_est && $id_gra != $id_gra1) {
            //echo "segunda condiciÃ³n";
            //Se hace el insert
            if($id != 0) {
                $datos->calificaciones = $calif_finales;
	            echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	            
                //Se valida si ya existe el registro
	            $sql_val = "SELECT COUNT(1) ct FROM tbl_notas_historia WHERE id_est = $id AND n_matricula = '".$id_matric."'";
	            //echo $sql_val;
	            $res_sql_val = $mysqli1->query($sql_val);
                while($row_v = $res_sql_val->fetch_assoc()) {
                    $ct= $row_v['ct'];
                }
                if($ct == 0) {
                    $sql_put = "INSERT INTO tbl_notas_historia (id_est,a,n_matricula,json) VALUES (".$id.",2019,'".$id_matric."','".json_encode($datos, JSON_UNESCAPED_UNICODE)."')";
                    $res_sql_put = $mysqli1->query($sql_put);
                }
                else {
                    $sql_upd = "UPDATE tbl_notas_historia SET json = '".json_encode($datos, JSON_UNESCAPED_UNICODE)."' WHERE id_est = $id AND n_matricula = '".$id_matric."'";
                    $res_sql_upd = $mysqli1->query($sql_upd);
                }
            }
            //Se inicializan las variables
            $id = $id_est;
            $id_gra = $id_gra1;
            $id_matric = $id_matricula;
            
            $datos = new stdClass();
        	$calif_finales = array();
        	$i = 0;
            
            //Se empieza un nuevo registro
            $datos->id_est = $row0['id_estudiante'];
    	    $datos->nombre = $row0['nombre'];
    	    $datos->id_grado = $row0['id_grado'];
    	    $datos->n_mat = $row0['id_matricula'];
    	    
    	    $valores = [$row0['id_materia'],$row0['per1']];
      		$calif = array_combine($keys,$valores);
      		$calif_finales[$i] = $calif;
      		$i++;
        }
        else {
            //echo "tercera condiciÃ³n";
            //Se hace el insert
            if($id != 0) {
                $datos->calificaciones = $calif_finales;
	            echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	            
	            //Se valida si ya existe el registro
	            $sql_val = "SELECT COUNT(1) ct FROM tbl_notas_historia WHERE id_est = $id AND n_matricula = '".$id_matric."'";
	            //echo $sql_val;
	            $res_sql_val = $mysqli1->query($sql_val);
                while($row_v = $res_sql_val->fetch_assoc()) {
                    $ct= $row_v['ct'];
                }
                if($ct == 0) {
                    $sql_put = "INSERT INTO tbl_notas_historia (id_est,a,n_matricula,json) VALUES (".$id.",2019,'".$id_matric."','".json_encode($datos, JSON_UNESCAPED_UNICODE)."')";
                    $res_sql_put = $mysqli1->query($sql_put);
                }
                else {
                    $sql_upd = "UPDATE tbl_notas_historia SET json = '".json_encode($datos, JSON_UNESCAPED_UNICODE)."' WHERE id_est = $id AND n_matricula = '".$id_matric."'";
                    $res_sql_upd = $mysqli1->query($sql_upd);
                }
            }
            //Se inicializan las variables
            $id = $id_est;
            $id_gra = $id_gra1;
            $id_matric = $id_matricula;
            
            $datos = new stdClass();
        	$calif_finales = array();
        	$i = 0;
            
            //Se empieza un nuevo registro
            $datos->id_est = $row0['id_estudiante'];
    	    $datos->nombre = $row0['nombre'];
    	    $datos->id_grado = $row0['id_grado'];
    	    $datos->n_mat = $row0['id_matricula'];
    	    
    	    $valores = [$row0['id_materia'],$row0['per1']];
      		$calif = array_combine($keys,$valores);
      		$calif_finales[$i] = $calif;
      		$i++;
        }
	    
	}
	$datos->calificaciones = $calif_finales;
	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
	//Se valida si ya existe el registro
    $sql_val = "SELECT COUNT(1) ct FROM tbl_notas_historia WHERE id_est = $id AND n_matricula = '".$id_matricula."'";
    //echo $sql_val;
    $res_sql_val = $mysqli1->query($sql_val);
    while($row_v = $res_sql_val->fetch_assoc()) {
        $ct= $row_v['ct'];
    }
    if($ct == 0) {
        $sql_put = "INSERT INTO tbl_notas_historia (id_est,a,n_matricula,json) VALUES (".$id.",2019,'".$id_matricula."','".json_encode($datos, JSON_UNESCAPED_UNICODE)."')";
        $res_sql_put = $mysqli1->query($sql_put);
    }
    else {
        $sql_upd = "UPDATE tbl_notas_historia SET json = '".json_encode($datos, JSON_UNESCAPED_UNICODE)."' WHERE id_est = $id AND n_matricula = '".$id_matricula."'";
        $res_sql_upd = $mysqli1->query($sql_upd);
    }
	
?>