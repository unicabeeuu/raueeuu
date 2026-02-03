<?php 
    include 'conexion.php';
    require("1cc3s4db.php");
    
    $id_estudiante=$_REQUEST['id'];
    
    $control = 0;
    $promedio_final = 0;
    $perdidas = 0;
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
    
    // buscar numero matricula
    $sql_matricula="SELECT * FROM `matricula` WHERE `id_estudiante`=".$id_estudiante." and estado='activo'";
    
    $exe_matricula=mysqli_query($conexion,$sql_matricula);
    while ($rowM = mysqli_fetch_array($exe_matricula)) {
    	$numero_matricula=$rowM['n_matricula'];
    }
    
    //Se valida si el estudiante es de cierre de años anteriores
    $tabla = "";
    $sql_cierre_ant = "SELECT v1, t1 FROM tbl_parametros WHERE parametro = 'id_est_cierre_anterior'";
    $exe_cierre_ant=mysqli_query($conexion,$sql_cierre_ant);
    while ($rowC = mysqli_fetch_array($exe_cierre_ant)) {
    	$id1=$rowC['v1'];
    	$tabla=$rowC['t1'];
    }
    
    //Se valida si hay notas para el estudiante
    //$sel_conteo = "SELECT COUNT(1) ct FROM notas WHERE id_estudiante = $id_estudiante";
    if($id_estudiante == $id1) {
        $sql_conteo = "SELECT COUNT(1) ct, m.id_grado 
        FROM ".$tabla." n, matricula m 
        WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = $id_estudiante AND m.estado = 'activo'
        GROUP BY m.id_grado";
    }
    else {
        $sql_conteo = "SELECT COUNT(1) ct, m.id_grado 
        FROM notas n, matricula m 
        WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = $id_estudiante AND m.estado = 'activo'
        GROUP BY m.id_grado";
    }
    
    $res_conteo = mysqli_query($conexion,$sql_conteo);
    while ($row_c = mysqli_fetch_array($res_conteo)) {
        $ct = $row_c['ct'];
        $id_gra = $row_c['id_grado'];
    }
    //echo $ct;
    //echo $id_gra;
    
    if ($ct == 0) {
        $control = 1;
		echo"<script>alert('El estudiante NO cuenta con notas para este grado')</script>";
		echo "<script>location.href='../cierre-academico.php'</script>";
	}
	
	if($id_gra == 11 || $id_gra == 12 || $id_gra == 17 || $id_gra == 18) {
	   if ($ct < 7) {
	        $control = 1;
    	    echo"<script>alert('Al estudiante le faltan notas')</script>";
    		echo "<script>location.href='../cierre-academico.php'</script>";
    	} 
	}
	else {
	    if ($ct < 6) {
	        $control = 1;
    		echo"<script>alert('Al estudiante le faltan notas')</script>";
    		echo "<script>location.href='../cierre-academico.php'</script>";
    	}
	}
	
	if($control == 0) {
	    $datos = new stdClass();
    	$calif_finales = array();
    	$keys = ['id_mat','per1','per2','per3','per4','nfinal'];
    	$keys1 = ['id_mat','per1','per2','nfinal'];
    	$i = 0;
    	
    	//Se hace la consulta de las notas
    	if($id_gra == 17 || $id_gra == 18) {
    	    if($id_estudiante == $id1) {
    	        /*$query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, 
                round((case when n.id_periodo = 1 then nota end),1) as per1, 
                round((case when n.id_periodo = 2 then nota end),1) as per2 
                FROM ".$tabla." n, estudiantes e 
                WHERE n.id_estudiante = e.id AND n.id_estudiante = $id_estudiante";*/
                $query0 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, p1.id_grado, p1.id_materia, p1.per1, p2.per2 FROM 
                (SELECT round(nota,1) per1, id_estudiante, id_grado, id_materia FROM ".$tabla." WHERE id_estudiante = $id_estudiante AND id_periodo = 1) p1, 
                (SELECT round(nota,1) per2, id_estudiante, id_grado, id_materia FROM ".$tabla." WHERE id_estudiante = $id_estudiante AND id_periodo = 2) p2, 
                estudiantes e 
                WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_grado = p2.id_grado AND p1.id_materia = p2.id_materia AND p1.id_estudiante = e.id";
    	    }
    	    else {
    	        /*$query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, 
                round((case when n.id_periodo = 1 then nota end),1) as per1, 
                round((case when n.id_periodo = 2 then nota end),1) as per2 
                FROM notas n, estudiantes e 
                WHERE n.id_estudiante = e.id AND n.id_estudiante = $id_estudiante";*/
                $query0 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, p1.id_grado, p1.id_materia, p1.per1, p2.per2 FROM 
                (SELECT round(nota,1) per1, id_estudiante, id_grado, id_materia FROM notas WHERE id_estudiante = $id_estudiante AND id_periodo = 1) p1, 
                (SELECT round(nota,1) per2, id_estudiante, id_grado, id_materia FROM notas WHERE id_estudiante = $id_estudiante AND id_periodo = 2) p2, 
                estudiantes e 
                WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_grado = p2.id_grado AND p1.id_materia = p2.id_materia AND p1.id_estudiante = e.id";
    	    }
    	    
    	}
    	else {
    	    if($id_estudiante == $id1) {
    	        /*$query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, 
                round((case when n.id_periodo = 1 then nota end),1) as per1, 
                round((case when n.id_periodo = 2 then nota end),1) as per2, 
                round((case when n.id_periodo = 3 then nota end),1) as per3, 
                round((case when n.id_periodo = 4 then nota end),1) as per4 
                FROM ".$tabla." n, estudiantes e 
                WHERE n.id_estudiante = e.id AND n.id_estudiante = $id_estudiante";*/
                $query0 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, p1.id_grado, p1.id_materia, p1.per1, p2.per2, p3.per3, p4.per4 FROM 
                (SELECT round(nota,1) per1, id_estudiante, id_grado, id_materia FROM ".$tabla." WHERE id_estudiante = $id_estudiante AND id_periodo = 1) p1, 
                (SELECT round(nota,1) per2, id_estudiante, id_grado, id_materia FROM ".$tabla." WHERE id_estudiante = $id_estudiante AND id_periodo = 2) p2, 
                (SELECT round(nota,1) per3, id_estudiante, id_grado, id_materia FROM ".$tabla." WHERE id_estudiante = $id_estudiante AND id_periodo = 3) p3, 
                (SELECT round(nota,1) per4, id_estudiante, id_grado, id_materia FROM ".$tabla." WHERE id_estudiante = $id_estudiante AND id_periodo = 4) p4, 
                estudiantes e 
                WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_grado = p2.id_grado AND p1.id_materia = p2.id_materia 
                AND p1.id_estudiante = p3.id_estudiante AND p1.id_grado = p3.id_grado AND p1.id_materia = p3.id_materia 
                AND p1.id_estudiante = p4.id_estudiante AND p1.id_grado = p4.id_grado AND p1.id_materia = p4.id_materia 
                AND p1.id_estudiante = e.id";
    	    }
    	    else {
    	        /*$query0 = "SELECT n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) nombre, n.id_grado, n.id_materia, 
                round((case when n.id_periodo = 1 then nota end),1) as per1, 
                round((case when n.id_periodo = 2 then nota end),1) as per2, 
                round((case when n.id_periodo = 3 then nota end),1) as per3, 
                round((case when n.id_periodo = 4 then nota end),1) as per4 
                FROM notas n, estudiantes e 
                WHERE n.id_estudiante = e.id AND n.id_estudiante = $id_estudiante";*/
                $query0 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, p1.id_grado, p1.id_materia, p1.per1, p2.per2, p3.per3, p4.per4 FROM 
                (SELECT round(nota,1) per1, id_estudiante, id_grado, id_materia FROM notas WHERE id_estudiante = $id_estudiante AND id_periodo = 1) p1, 
                (SELECT round(nota,1) per2, id_estudiante, id_grado, id_materia FROM notas WHERE id_estudiante = $id_estudiante AND id_periodo = 2) p2, 
                (SELECT round(nota,1) per3, id_estudiante, id_grado, id_materia FROM notas WHERE id_estudiante = $id_estudiante AND id_periodo = 3) p3, 
                (SELECT round(nota,1) per4, id_estudiante, id_grado, id_materia FROM notas WHERE id_estudiante = $id_estudiante AND id_periodo = 4) p4, 
                estudiantes e 
                WHERE p1.id_estudiante = p2.id_estudiante AND p1.id_grado = p2.id_grado AND p1.id_materia = p2.id_materia 
                AND p1.id_estudiante = p3.id_estudiante AND p1.id_grado = p3.id_grado AND p1.id_materia = p3.id_materia 
                AND p1.id_estudiante = p4.id_estudiante AND p1.id_grado = p4.id_grado AND p1.id_materia = p4.id_materia 
                AND p1.id_estudiante = e.id";
    	    }
    	    
    	}
    	//echo $query0;
        
        $resultado0 = $mysqli1->query($query0);
        while($row0 = $resultado0->fetch_assoc()) {
    	    $datos->id_est = $row0['id'];
    	    $datos->nombre = $row0['nombre'];
    	    $datos->id_grado = $row0['id_grado'];
    	    
    	    if($id_gra == 17 || $id_gra == 18) {
    	        $nota_final = round(($row0['per1'] + $row0['per2'])/2, 1);
    	        //echo "<br/>".$nota_final;
    	        if($nota_final < 3.5) {
    	            $perdidas++;
    	        }
    	        $nota_final = strval(round($nota_final,1));
    	        $valores = [$row0['id_materia'],$row0['per1'],$row0['per2'],$nota_final];
    	        $calif = array_combine($keys1,$valores);
    	    }
    	    else {
    	        $nota_final = round(($row0['per1'] + $row0['per2'] + $row0['per3'] + $row0['per4'])/4, 1);
    	        //echo "<br/>".$nota_final;
    	        if($nota_final < 3.5) {
    	            $perdidas++;
    	        }
    	        $nota_final = strval(round($nota_final,1));
    	        $valores = [$row0['id_materia'],$row0['per1'],$row0['per2'],$row0['per3'],$row0['per4'],$nota_final];
    	        $calif = array_combine($keys,$valores);
    	    }
    	    $promedio_final += $nota_final;
    	    //echo $nota_final."|";
      		
      		$calif_finales[$i] = $calif;
      		$i++;
    	}
    	$promedio_final1 = strval(round($promedio_final, 1));
    	$datos->acumulado = $promedio_final1;
    	if($id_gra == 11 || $id_gra == 12 || $id_gra == 17 || $id_gra == 18) {
    	    $promedio_final = round($promedio_final/7, 1);
    	}
    	else {
    	    $promedio_final = round($promedio_final/6, 1);
    	}
    	$datos->promedio_final = strval($promedio_final);
    	$datos->perdidas = $perdidas;
    	$datos->calificaciones = $calif_finales;
    	echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    	
    	//Se valida si ya existe el registro
        $sql_val = "SELECT COUNT(1) ct FROM tbl_notas_historia WHERE id_est = $id_estudiante AND n_matricula = '".$numero_matricula."'";
        //echo $sql_val;
        $res_sql_val = $mysqli1->query($sql_val);
        while($row_v = $res_sql_val->fetch_assoc()) {
            $ct1= $row_v['ct'];
        }
        if($ct1 == 0) {
            $sql_put = "INSERT INTO tbl_notas_historia (id_est,a,n_matricula,json) VALUES (".$id_estudiante.",".$a.",'".$numero_matricula."','".json_encode($datos, JSON_UNESCAPED_UNICODE)."')";
            $res_sql_put = $mysqli1->query($sql_put);
        }
        else {
            $sql_upd = "UPDATE tbl_notas_historia SET json = '".json_encode($datos, JSON_UNESCAPED_UNICODE)."' WHERE id_est = $id_estudiante AND n_matricula = '".$numero_matricula."'";
            $res_sql_upd = $mysqli1->query($sql_upd);
        }
	}
	
	//Se vuelve a validar si ya existe el registro para continuar con el proceso de cierre
    $sql_val1 = "SELECT COUNT(1) ct FROM tbl_notas_historia WHERE id_est = $id_estudiante AND n_matricula = '".$numero_matricula."'";
    //echo $sql_val1;
    $res_sql_val1 = $mysqli1->query($sql_val1);
    while($row_v1 = $res_sql_val1->fetch_assoc()) {
        $ct2= $row_v1['ct'];
    }
    if($ct2 == 0) {
        echo"<script>alert('Este proceso no se pudo realizar')</script>";
		echo "<script>location.href='../cierre-academico.php'</script>";
    }
    else {
        if($perdidas == 0) {
            $actualizar_matricula="UPDATE `matricula` SET `estado`='aprobado' WHERE id_estudiante=".$id_estudiante." AND `n_matricula`='".$numero_matricula."'";
		    $exe_matricula=mysqli_query($conexion,$actualizar_matricula);
        }
        else {
            $actualizar_matricula="UPDATE `matricula` SET `estado`='reprobado' WHERE id_estudiante=".$id_estudiante." AND `n_matricula`='".$numero_matricula."'";
		    $exe_matricula=mysqli_query($conexion,$actualizar_matricula);
        }
        /*$actualizar_estudiante="UPDATE `estudiantes` SET `estado`='inactivo' WHERE id=".$id_estudiante."";
		$exe_estudiante=mysqli_query($conexion,$actualizar_estudiante);*/	

		//eliminar notas estudiante
		$elimnar_notas="DELETE FROM `notas` WHERE `id_estudiante`=".$id_estudiante."";
		$exe_notas=mysqli_query($conexion,$elimnar_notas);
		
		echo"<script>alert('El cierre académico del estudiante fue exitoso')</script>";
		echo "<script>location.href='../cierre-academico.php'</script>";
    }
	

/*$sql_ejecutar="SELECT DISTINCT estudiantes.id AS id_estudiante, estudiantes.apellidos, estudiantes.nombres, grados.id AS id_grado, grados.grado, materias.Id AS id_materia,
    materias.materia 
    FROM (grados INNER JOIN (materias INNER JOIN carga_profesor ON materias.Id = carga_profesor.id_materia) ON grados.id = carga_profesor.id_grado) 
    INNER JOIN (estudiantes INNER JOIN notas ON estudiantes.id = notas.id_estudiante) ON grados.id = notas.id_grado where estudiantes.id=".$id_estudiante."";
// echo "h ".$sql_ejecutar."<br>";
$ejecutar=mysqli_query($conexion,$sql_ejecutar);

$materiasAprobadas=0;
$materiasReprobadas=0;

$auto=0;
$promedio=0;
$suma=0;
$cont=0;
$contVacio=0;
$contNota=0;
$curso=0;
$array_notas=array();
$array_materia=array();
$contt=0;
while ($row=mysqli_fetch_array($ejecutar)) {
	$gradooo=$row['id_grado'];
	$auto++;
	$sql_notas="sql".$auto;
	$sql_notas="SELECT DISTINCT ROUND(sum(nota),2) AS suma, COUNT(nota) as num_notas, grados.id as id_grado, grados.grado, materias.Id as id_materia, 
	    materias.materia, materias.pensamiento, estudiantes.id as id_estudiante, estudiantes.apellidos, estudiantes.nombres, notas.id as id_notas, notas.nota as nota 
	    FROM materias INNER JOIN (grados INNER JOIN (estudiantes INNER JOIN notas ON estudiantes.id = notas.id_estudiante) ON grados.id = notas.id_grado) 
	    ON materias.Id = notas.id_materia where estudiantes.id=".$id_estudiante." and materias.Id=".$row['id_materia']."";

	$exe_notas="exe".$auto;
	$exe_notas=mysqli_query($conexion,$sql_notas);
	while ($fila=mysqli_fetch_array($exe_notas)) {
		$id_estudiante=$fila['id_estudiante'];
		$id_grado=$fila['id_grado'];
		$count=$fila['num_notas'];
		$array_notas[$contt]=array($fila['suma'],$fila['id_materia']);
		
		if (($fila['nota'])==NULL) {
			$contVacio++;
		}else{
			$contNota++;
		}
		$contt++;
	}

}
	if ($contVacio===0 && $contNota===0) {
		echo"<script>alert('El estudiante NO cuenta con notas para este grado')</script>";
		echo "<script>location.href='../cierre-academico.php'</script>";
	}if ($contVacio>0) {
		echo"<script>alert('El estudiante le faltan ".$contVacio." notas')</script>";
		echo "<script>location.href='../cierre-academico.php'</script>";
	}
	if ($contNota>=1) {
		if ($gradooo>=1 && $gradooo<=10) {
			$curso=9;
		}
		if ($gradooo>=11 && $gradooo<=12) {
			$curso=11;
		}
		if ($gradooo>=13 && $gradooo<=16) {
			$curso=6;
		}
		if ($gradooo>=17 && $gradooo<=18) {
			$curso=7;
		}
		if ($contNota===$curso) {
			foreach ($array_notas as $value) {
				$promedio=$value[0]/$count;
				if ($promedio>=3.0) {
					$materiasAprobadas++;
				}else{
					$materiasReprobadas++;
				}

				$sql_historial="INSERT INTO `historial_notas`(`promedio`, `id_estudiante`, `id_grado`, `id_materia`) VALUES (".ROUND($promedio,1).",".$id_estudiante.",".$id_grado.",".$value[1].")";
				$exe_historial=mysqli_query($conexion,$sql_historial);

				echo"<script>alert('El cierre académico del estudiante fue exitoso')</script>";
				echo "<script>location.href='../cierre-academico.php'</script>";
			}
				if ($materiasReprobadas>=1) {
					$EstadoGrado="reprobado";
				}else{
					$EstadoGrado="aprobado";
				}
				
				$actualizar_matricula="UPDATE `matricula` SET `estado`='inactivo', `EstadoGrado`='".$EstadoGrado."' WHERE id_estudiante=".$id_estudiante." AND `n_matricula`='".$numero_matricula."'";
				$exe_matricula=mysqli_query($conexion,$actualizar_matricula);
			
				$actualizar_estudiante="UPDATE `estudiantes` SET `estado`='inactivo' WHERE id=".$id_estudiante."";
				$exe_estudiante=mysqli_query($conexion,$actualizar_estudiante);	

				//eliminar notas estudiante
				$elimnar_notas="DELETE FROM `notas` WHERE `id_estudiante`=".$id_estudiante."";
				$exe_notas=mysqli_query($conexion,$elimnar_notas);
		}else{
			echo"<script>alert('Este proceso no se pudo realizar')</script>";
			echo "<script>location.href='../index.php'</script>";
		}
	}*/
?>