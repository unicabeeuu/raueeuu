<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idest = $_REQUEST['idest'];
	$obs = nl2br($_REQUEST['obs']);
	$nom = $_REQUEST['buscar'];
	$nom = str_replace("_"," ",$nom);
	$ndoc = $_REQUEST['ndoc'];
	$tutor = $_REQUEST['tutor'];
	$accion = $_REQUEST['accion'];
	$idobs = $_REQUEST['idobs'];
	
	$ct = 0;
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
	if($dia < 10) {
		//$dia = "0".$dia;
	}
	if($mes < 10) {
		//$mes = "0".$mes;
	}
	$fecha2 =$fanio."/".$mes."/". $dia;
	
	//Se valida la acción
	if ($accion == "crear") {
		$query1 = "INSERT INTO tbl_estudiantes_observ_tut (n_documento,observacion, tutor, fecha) 
	    VALUES ('$ndoc', '$obs', '$tutor', '$fecha2')";
	}
	else if ($accion == "editar") {
		$query1 = "UPDATE tbl_estudiantes_observ_tut SET observacion = '$obs' WHERE n_documento = '$ndoc' AND id = $idobs";
	}
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	
	echo "<script languaje='javascript' type='text/javascript'>alert('Observación guardada con éxito');</script>";
	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
	
	/*$cadena = "";
	
	$query_tabla = "SELECT a.*, o.observacion, ifnull(o.id, -1) id_obs FROM 
	    (SELECT e.id id_est, e.nombres, e.apellidos, e.n_documento FROM estudiantes e 
	    WHERE e.nombres like '%$nom%' OR e.apellidos like '%$nom%' OR e.n_documento like '%$nom%') a 
	    LEFT JOIN tbl_estudiantes_param o 
	    ON a.id_est = o.id_estudiante";
	
	$resultado_t=$mysqli1->query($query_tabla);
	while($rowt = $resultado_t->fetch_assoc()){
	    $cadena = $cadena."<tr class='GridviewScrollItem'>
    						    <td class='tdcorto'>&#9658;</td>
    							<td class='tdmediol1'>".$rowt['nombres']."</td>
    							<td class='tdmediol1'>".$rowt['apellidos']."</td>
    							<td class='tdmedia1'>".$rowt['n_documento']."</td>
    							<td class='tdelargo'>".$rowt['observacion']."</td>
    							<td class='tdmedia'><button class='btn btn-warning glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modal_observaciones' title='Editar'
                                    onclick='enviardat(".$rowt['id_est'].",\"".$rowt['nombres']."\",\"".$rowt['apellidos']."\",\"".$rowt['observacion']."\");'>Editar</button></td>
    							<td class='tdmedia'>".$rowt['id_est']."</td>
    							<td>...</td>
    						</tr>";
	}
	
	echo $cadena;*/
?>