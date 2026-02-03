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
	$keys = ['Grado','id_gra','idnumber','BIO','SOC','NUM','ESP','ING','TEC'];
	$i = 0;
	
	$bio = 0;
	$soc = 0;
	$num = 0;
	$esp = 0;
	$ing = 0;
	$tec = 0;
	
	$bio1 = 0;
	$soc1 = 0;
	$num1 = 0;
	$esp1 = 0;
	$ing1 = 0;
	$tec1 = 0;
	
	$bio2 = 0;
	$soc2 = 0;
	$num2 = 0;
	$esp2 = 0;
	$ing2 = 0;
	$tec2 = 0;
	
	$control = 0;
	$control1 = 0;
	$control2 = 0;
	
	$cadena = "<table class='table' border='1px'><thead><tr><td>Grado</td><td>Id_gra</td><td>Idnumber</td>
	    <td>BIO</td><td>SOC</td><td>NUM</td><td>ESP</td><td>ING</td><td>TEC</td></tr></thead><tbody>";
	
	$query1 = "SELECT id_grado_ra, grado_ra FROM equivalence_idgra ORDER BY id_grado_ra";
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()){
		$query2 = "SELECT g.name, g.id_grado_ra, m.shortname, m.id_materia_ra, c.id_act, c.calculation1, c.idnumber 
            FROM tbl_config_act_ok c, equivalence_idgra g, equivalence_idmat m 
            WHERE c.id_grado = g.id_category AND c.id_pensamiento = m.id_course AND c.calculation1 != '=' 
            AND c.idnumber IN $in AND g.id_grado_ra = ".$row['id_grado_ra']."
            ORDER BY c.idnumber, g.id_grado_ra, m.id_materia_ra";
        //echo $query2;
        
        $resultado2=$mysqli1->query($query2);
	    while($row2 = $resultado2->fetch_assoc()){
	        $grado = $row2['name'];
	        $idgra = $row2['id_grado_ra'];
	        
	        if($row2['idnumber'] == $idnumber1) {
	            $idnumber_a = $row2['idnumber'];
	            if($row2['id_materia_ra'] == 1 || $row2['id_materia_ra'] == 10) {
    	            $bio1 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 4 || $row2['id_materia_ra'] == 12) {
    	            $soc1 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 5) {
    	            $num1 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 6 || $row2['id_materia_ra'] == 15) {
    	            $esp1 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 7) {
    	            $ing1 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 9) {
    	            $tec1 = $row2['id_act'];
    	        }
    	        $control1 = 1;
	        }
	        else if($row2['idnumber'] == $idnumber2) {
	            $idnumber_b = $row2['idnumber'];
	            if($row2['id_materia_ra'] == 1 || $row2['id_materia_ra'] == 10) {
    	            $bio2 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 4 || $row2['id_materia_ra'] == 12) {
    	            $soc2 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 5) {
    	            $num2 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 6 || $row2['id_materia_ra'] == 15) {
    	            $esp2 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 7) {
    	            $ing2 = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 9) {
    	            $tec2 = $row2['id_act'];
    	        }
    	        $control2 = 1;
	        }
	        else {
	            $idnumber_c = $row2['idnumber'];
	            if($row2['id_materia_ra'] == 1 || $row2['id_materia_ra'] == 10) {
    	            $bio = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 4 || $row2['id_materia_ra'] == 12) {
    	            $soc = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 5) {
    	            $num = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 6 || $row2['id_materia_ra'] == 15) {
    	            $esp = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 7) {
    	            $ing = $row2['id_act'];
    	        }
    	        if($row2['id_materia_ra'] == 9) {
    	            $tec = $row2['id_act'];
    	        }
	        }
	        
	    }
	    $valores = [$grado,$idgra,$idnumber_b,$bio,$soc,$num,$esp,$ing,$tec];
  		$config = array_combine($keys,$valores);
  		$configurados[$i] = $config;
  		$i++;
  		//$cadena = $cadena."<tr><td>".$grado."</td><td>".$idgra."</td><td>".$idnumber_b."</td><td>".$bio."</td><td>".$soc."</td><td>".$num."</td><td>".$esp."</td><td>".$ing."</td><td>".$tec."</td></tr>";
  		$cadena = $cadena."<tr><td>".$grado."</td><td>".$idgra."</td><td>".$idnumber_c."</td>";
  		if($bio == 0) {
  		    $cadena = $cadena."<td class='falta'>".$bio."</td>";
  		}
  		else {
  		    $cadena = $cadena."<td>".$bio."</td>";
  		}
  		if($soc == 0) {
  		    $cadena = $cadena."<td class='falta'>".$soc."</td>";
  		}
  		else {
  		    $cadena = $cadena."<td>".$soc."</td>";
  		}
  		if($num == 0) {
  		    $cadena = $cadena."<td class='falta'>".$num."</td>";
  		}
  		else {
  		    $cadena = $cadena."<td>".$num."</td>";
  		}
  		if($esp == 0) {
  		    $cadena = $cadena."<td class='falta'>".$esp."</td>";
  		}
  		else {
  		    $cadena = $cadena."<td>".$esp."</td>";
  		}
  		if($ing == 0) {
  		    if($idgra == 15 || $idgra == 16 || $idgra == 17 || $idgra == 18) {
  		        $cadena = $cadena."<td>".$ing."</td>";
  		    }
  		    else {
  		        $cadena = $cadena."<td class='falta'>".$ing."</td>";
  		    }
  		}
  		else {
  		    $cadena = $cadena."<td>".$ing."</td>";
  		}
  		if($tec == 0) {
  		    if($idgra == 13 || $idgra == 14) {
  		        $cadena = $cadena."<td>".$tec."</td>";
  		    }
  		    else {
  		        $cadena = $cadena."<td class='falta'>".$tec."</td>";
  		    }
  		}
  		else {
  		    $cadena = $cadena."<td>".$tec."</td>";
  		}
  		
  		if($control1 == 1) {
  		    $valores = [$grado,$idgra,$idnumber_a,$bio1,$soc1,$num1,$esp1,$ing1,$tec1];
      		$config = array_combine($keys,$valores);
      		$configurados[$i] = $config;
      		$i++;
      		//$cadena = $cadena."<tr><td>".$grado."</td><td>".$idgra."</td><td>".$idnumber_a."</td><td>".$bio1."</td><td>".$soc1."</td><td>".$num1."</td><td>".$esp1."</td><td>".$ing1."</td><td>".$tec1."</td></tr>";
      		$cadena = $cadena."<tr><td>".$grado."</td><td>".$idgra."</td><td>".$idnumber_a."</td>";
      		if($bio1 == 0) {
      		    $cadena = $cadena."<td>".$bio1."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$bio1."</td>";
      		}
      		if($soc1 == 0) {
      		    $cadena = $cadena."<td>".$soc1."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$soc1."</td>";
      		}
      		if($num1 == 0 && $idnumber_a == "TP2F") {
      		    $cadena = $cadena."<td class='falta'>".$num1."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$num1."</td>";
      		}
      		if($esp1 == 0) {
      		    $cadena = $cadena."<td>".$esp1."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$esp1."</td>";
      		}
      		if($ing1 == 0) {
      		    if($idgra == 11 || $idgra == 12 || $idgra == 15 || $idgra == 16 || $idgra == 17 || $idgra == 18) {
      		        $cadena = $cadena."<td>".$ing1."</td>";
      		    }
      		    else {
      		        $cadena = $cadena."<td class='falta'>".$ing1."</td>";
      		    }
      		}
      		else {
      		    $cadena = $cadena."<td>".$ing1."</td>";
      		}
      		if($tec1 == 0) {
      		    $cadena = $cadena."<td>".$tec1."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$tec1."</td>";
      		}
  		}
  		if($control2 == 1) {
  		    $valores = [$grado,$idgra,$idnumber_a,$bio2,$soc2,$num1,$esp2,$ing2,$tec2];
      		$config = array_combine($keys,$valores);
      		$configurados[$i] = $config;
      		$i++;
      		//$cadena = $cadena."<tr><td>".$grado."</td><td>".$idgra."</td><td>".$idnumber_a."</td><td>".$bio1."</td><td>".$soc1."</td><td>".$num1."</td><td>".$esp1."</td><td>".$ing1."</td><td>".$tec1."</td></tr>";
      		$cadena = $cadena."<tr><td>".$grado."</td><td>".$idgra."</td><td>".$idnumber_b."</td>";
      		if($bio2 == 0) {
      		    $cadena = $cadena."<td>".$bio2."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$bio2."</td>";
      		}
      		if($soc2 == 0) {
      		    $cadena = $cadena."<td>".$soc2."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$soc2."</td>";
      		}
      		if($num2 == 0 && $idnumber_a == "TP2F") {
      		    $cadena = $cadena."<td class='falta'>".$num2."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$num2."</td>";
      		}
      		if($esp2 == 0) {
      		    $cadena = $cadena."<td>".$esp2."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$esp2."</td>";
      		}
      		if($ing2 == 0) {
      		    if($idgra == 11 || $idgra == 12 || $idgra == 15 || $idgra == 16 || $idgra == 17 || $idgra == 18) {
      		        $cadena = $cadena."<td>".$ing2."</td>";
      		    }
      		    else {
      		        $cadena = $cadena."<td class='falta'>".$ing2."</td>";
      		    }
      		}
      		else {
      		    $cadena = $cadena."<td>".$ing2."</td>";
      		}
      		if($tec2 == 0) {
      		    $cadena = $cadena."<td>".$tec2."</td>";
      		}
      		else {
      		    $cadena = $cadena."<td>".$tec2."</td>";
      		}
  		}
  		
  		$bio = 0;
    	$soc = 0;
    	$num = 0;
    	$esp = 0;
    	$ing = 0;
    	$tec = 0;
    	$bio1 = 0;
    	$soc1 = 0;
    	$num1 = 0;
    	$esp1 = 0;
    	$ing1 = 0;
    	$tec1 = 0;
    	$bio2 = 0;
    	$soc2 = 0;
    	$num2 = 0;
    	$esp2 = 0;
    	$ing2 = 0;
    	$tec2 = 0;
    	$control = 0;
    	$control1 = 0;
	    $control2 = 0;
	}
	
	$datos->configurados = $configurados;
	
	//echo json_encode($datos, JSON_UNESCAPED_UNICODE);
	
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
	
?>