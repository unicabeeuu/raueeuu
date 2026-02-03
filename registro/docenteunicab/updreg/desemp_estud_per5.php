<?php
    session_start();
	//Genera botón de ver registros a procesar
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
	$per = $_REQUEST['per'];
	$idgra = $_REQUEST['idgra'];
	$grupo = $_REQUEST['selgrupo'];
	//echo $per;
	//echo $idgra;
	
	if($per == 1) {
	    $in = "('TP1','TP1I','TP1F')";
	    $idnumber1 = "TP1I";
	    $idnumber2 = "TP1F";
	}
	else if($per == 2) {
	    $in = "('TP2','TP2I','TP2F')";
	    $idnumber1 = "TP2I";
	    $idnumber2 = "TP2F";
	}
	else if($per == 3) {
	    $in = "('TP3','TP3I','TP3F')";
	    $idnumber1 = "TP3I";
	    $idnumber2 = "TP3F";
	}
	else if($per == 4) {
	    $in = "('TP4','TP4I','TP4F')";
	    $idnumber1 = "TP4I";
	    $idnumber2 = "TP4F";
	}
	
	$datos = new stdClass();
	$configurados = array();
	if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
	    $keys = ['Nombre','BIO','SOC','NUM','FIS','ESP','ING','TEC'];
	}
	else {
	    $keys = ['Nombre','BIO','SOC','NUM','ESP','ING','TEC'];
	}
	$i = 0;
	
	$bio = 0;
	$soc = 0;
	$num = 0;
	$esp = 0;
	$ing = 0;
	$tec = 0;
	$fis = 0;
	
	$control = 0;
	$total = 0;
	
	if($grupo == "NA") {
	    $query1 = "SELECT DISTINCT CONCAT(e.nombres, ' ', e.apellidos) nombre, e.id 
    	FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.estado = 'activo' AND m.id_grado = $idgra 
    	ORDER BY 1";
	}
	else {
	    $query1 = "SELECT DISTINCT CONCAT(e.nombres, ' ', e.apellidos) nombre, e.id 
    	FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.estado = 'activo' AND m.id_grado = $idgra AND m.grupo = '$grupo' 
    	ORDER BY 1";
	}
	
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	//$sel = $mysqli1->affected_rows;
	
	if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
	    $cadena = "<table class='table' border='1px'><thead><tr><td>Nombre</td><td>BIO</td><td>SOC</td><td>NUM</td><td>FIS</td><td>ESP</td><td>ING</td><td>TEC</td></tr></thead><tbody>";
	}
	else {
	    $cadena = "<table class='table' border='1px'><thead><tr><td>Nombre</td><td>BIO</td><td>SOC</td><td>NUM</td><td>ESP</td><td>ING</td><td>TEC</td></tr></thead><tbody>";
	}
	
	while($row = $resultado->fetch_assoc()){
	    $nombre = $row['nombre'];
	    $id = $row['id'];
	    
		if($per == 1) {
	        $query2 = "SELECT * 
                FROM notas 
                WHERE id_estudiante = ".$row['id']." AND id_periodo = ".$per;
	    }
	    else if($per == 2) {
	        $query2 = "SELECT cast(SUM(nota)/2 as decimal(10,1)) as nota, id_materia, id_grado 
                FROM notas 
                WHERE id_estudiante = ".$row['id']." AND id_periodo IN (1,2) 
                GROUP BY id_materia, id_grado";
	    }
	    else if($per == 3) {
	        $query2 = "SELECT cast(SUM(nota)/3 as decimal(10,1)) as nota, id_materia, id_grado 
                FROM notas 
                WHERE id_estudiante = ".$row['id']." AND id_periodo IN (1,2,3) 
                GROUP BY id_materia, id_grado";
	    }
	    else if($per == 4) {
	        $query2 = "SELECT cast(SUM(nota)/4 as decimal(10,1)) as nota, id_materia, id_grado 
                FROM notas 
                WHERE id_estudiante = ".$row['id']." AND id_periodo IN (1,2,3,4) 
                GROUP BY id_materia, id_grado";
	    }
        //echo $query2;
        
        $resultado2=$mysqli1->query($query2);
	    while($row2 = $resultado2->fetch_assoc()){
	        if($row2['id_materia'] == 1 || $row2['id_materia'] == 10 || $row2['id_materia'] == 11) {
	            $bio = $row2['nota'];
	        }
	        if($row2['id_materia'] == 4 || $row2['id_materia'] == 12) {
	            $soc = $row2['nota'];
	        }
	        if($row2['id_materia'] == 5) {
	            $num = $row2['nota'];
	        }
	        if($row2['id_materia'] == 6 || $row2['id_materia'] == 15) {
	            $esp = $row2['nota'];
	        }
	        if($row2['id_materia'] == 7) {
	            $ing = $row2['nota'];
	        }
	        if($row2['id_materia'] == 9) {
	            $tec = $row2['nota'];
	        }
	        /*if($row2['id_materia'] == 11) {
	            $fis= $row2['nota'];
	        }*/
	    }
	    /*echo "bio".$bio;
        echo "soc".$soc;
        echo "num".$num;
        echo "esp".$esp;
        echo "ing".$ing;
        echo "tec".$tec;*/
        
        if($bio < 3.5) {
            $control++;
        }
        if($soc < 3.5) {
            $control++;
        }
        if($num < 3.5) {
            $control++;
        }
        if($esp < 3.5) {
            $control++;
        }
        if($ing < 3.5) {
            $control++;
        }
        if($tec < 3.5) {
            $control++;
        }
        if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
            if($fis < 3.5) {
                $control++;
            }
        }
	        
	    if($control == 5) {
	        if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
	            $valores = [$nombre,$bio,$soc,$num,$fis,$esp,$ing,$tec];
	        }
	        else {
	            $valores = [$nombre,$bio,$soc,$num,$esp,$ing,$tec];
	        }
      		$config = array_combine($keys,$valores);
      		$configurados[$i] = $config;
      		$i++;
      		
      		//$cadena = $cadena."<tr><td>".$nombre."</td><td>".$bio."</td><td>".$soc."</td><td>".$num."</td><td>".$esp."</td><td>".$ing."</td><td>".$tec."</td></tr>";
      		$cadena = $cadena."<tr><td>".$nombre;
      		if($bio < 3.5) {
      		    $cadena = $cadena."</td><td class='perdio'>".$bio;
      		}
      		else {
      		    $cadena = $cadena."</td><td>".$bio;
      		}
      		if($soc < 3.5) {
      		    $cadena = $cadena."</td><td class='perdio'>".$soc;
      		}
      		else {
      		    $cadena = $cadena."</td><td>".$soc;
      		}
      		if($num < 3.5) {
      		    $cadena = $cadena."</td><td class='perdio'>".$num;
      		}
      		else {
      		    $cadena = $cadena."</td><td>".$num;
      		}
      		if($idgra == 110 || $idgra == 120 || $idgra == 170 || $idgra == 180) {
      		   if($fis < 3.5) {
          		    $cadena = $cadena."</td><td class='perdio'>".$fis;
          		}
          		else {
          		    $cadena = $cadena."</td><td>".$fis;
          		} 
      		}
      		if($esp < 3.5) {
      		    $cadena = $cadena."</td><td class='perdio'>".$esp;
      		}
      		else {
      		    $cadena = $cadena."</td><td>".$esp;
      		}
      		if($ing < 3.5) {
      		    $cadena = $cadena."</td><td class='perdio'>".$ing;
      		}
      		else {
      		    $cadena = $cadena."</td><td>".$ing;
      		}
      		if($tec < 3.5) {
      		    //$cadena = $cadena."</td><td class='perdio'>".$tec."</td></tr>";
      		    $cadena = $cadena."</td><td class='perdio'>".$tec."</td>";
      		}
      		else {
      		    //$cadena = $cadena."</td><td>".$tec."</td></tr>";
      		    $cadena = $cadena."</td><td>".$tec."</td>";
      		}
      		$cadena = $cadena."<td><button class='btn btn-warning glyphicon glyphicon-list-alt' data-toggle='modal' data-target='#modal_dat_acud' title='Datos'
                onclick='enviardat(".$row['id'].",".$bio.",".$soc.",".$num.",".$fis.",".$esp.",".$ing.",".$tec.",\"".str_replace("'","_",$nombre)."\",".$idgra.")'></button></td></tr>";
                
      		$total++;
	    }
  		
  		$bio = 0;
    	$soc = 0;
    	$num = 0;
    	$esp = 0;
    	$ing = 0;
    	$tec = 0;
    	$fis = 0;
    	$control = 0;
	}
	$cadena = $cadena."</tbody></table><h3 style='color: #B43104'>Total estudiantes: <span id='stot5'>".$total."</span></h3>";
	echo $cadena;
	
	$datos->configurados = $configurados;
	
	//echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
?>