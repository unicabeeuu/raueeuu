<?php
    session_start();
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	set_time_limit(600);
	
	$idq=$_REQUEST['idq'];
	
	$seleccionados = 0;
	$seleccionados_m = 0;
	$insertados = 0;
	$insertados_n = 0;
	$actualizados = 0;
	$en = 0;
	$sel_tupd = 0;
	$ins_tupd = 0;
	$sel_tins = 0;
	$ins_tins = 0;
	$error = 0;
	$control = 0;
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	if($dia < 10) {
		$dia = "0".$dia;
	}
	if($mes < 10) {
		$mes = "0".$mes;
	}
	$fecha2 = $a.$mes.$dia."_".$hora.$minutos;
	
	//$fecha2 = $a.$mes.$dia."_".$hora.$minutos;
	//$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	//echo $sql;
	$res=$mysqli1->query($sql);

	while($fila = $res->fetch_assoc()){
	  	$id = $fila['id'];
    }
	
	//Limpiar tablas temporales
	if($id == 18) {
	    $tbl_nmt = "notas_mood_temp";
	    $tbl_nt = "notas_temp";
	    $tbl_ntu = "notas_temp_upd";
	    $tbl_nti = "notas_temp_ins";
	    $tbl_nt_nr = "notas_temp_no_ra";
	    
	    $queryr0 = "Delete From ".$tbl_nmt;
    	$queryr1 = "Delete From ".$tbl_nt;
    	$queryr2 = "Delete From ".$tbl_ntu;
    	$queryr3 = "Delete From ".$tbl_nti;
    	$queryr4 = "Delete From ".$tbl_nt_nr;
	}
	else {
	    $tbl_nmt = "tbl_notas_mood_temp";
	    $tbl_nt = "tbl_notas_temp";
	    $tbl_ntu = "tbl_notas_temp_upd";
	    $tbl_nti = "tbl_notas_temp_ins";
	    $tbl_nt_nr = "tbl_notas_temp_no_ra";
	    
	    $queryr0 = "Delete From ".$tbl_nmt." Where id_tutor = '$id'";
    	$queryr1 = "Delete From ".$tbl_nt." Where id_tutor = '$id'";
    	$queryr2 = "Delete From ".$tbl_ntu." Where id_tutor = '$id'";
    	$queryr3 = "Delete From ".$tbl_nti." Where id_tutor = '$id'";
    	$queryr4 = "Delete From ".$tbl_nt_nr." Where id_tutor = '$id'";
	}
	$query_upd_control = "UPDATE tbl_control_upd SET resultado = 'NA'";
	
	//Consulta general
	$query0 = "SELECT * FROM querys_ra WHERE id = '$idq'";
	//echo $query0;
	//Consultar calificaciones moodle
	//$query1 = "SELECT ".$dev_enc($campos_cal)."FROM ".$dev_enc($tablas_cal)."WHERE ".$dev_enc($condicion_ar)."ORDER BY ".$dev_enc($ob_cal);	
	//Sentencia para actualizar registros
	if($id == 18) {
	    //$query3 = "UPDATE ".$dev_enc($notas_upd)."JOIN ".$dev_enc($condicion_on_upd)."SET ".$dev_enc($set_upd)."WHERE ".$dev_enc($condicion_upd);
	    $query3 = "UPDATE notas n JOIN notas_temp nt 
	    ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante SET n.nota = nt.nota 
	    WHERE n.nota <> nt.nota ";
	}
	else {
	    //$query3 = "UPDATE ".$dev_enc($notas_upd)."JOIN ".$dev_enc($condicion_on_upd_tut)."SET ".$dev_enc($set_upd)."WHERE ".$dev_enc($condicion_upd_tut).$id;
	    $query3 = "UPDATE notas n JOIN tbl_notas_temp nt 
	    ON n.id_periodo = nt.id_periodo AND n.id_materia = nt.id_materia AND n.id_grado = nt.id_grado AND n.id_estudiante = nt.id_estudiante 
        SET n.nota = nt.nota WHERE n.nota <> nt.nota AND nt.id_tutor = ".$id;
	}
	//echo $query3;
	/*$query3 = "UPDATE ".$dev_enc($notas_upd)."JOIN ".$dev_enc($condicion_on_upd)."SET ".$dev_enc($set_upd)."WHERE ".$dev_enc($condicion_upd);*/
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/reg.css" >
		<script type="text/javascript" src="js/reg.js"></script>
	</head>
	<body>
		<center>
			<div id="enc">
				<img src="img/enc1.png" alt="enc1" />
			</div>
			<div id="divgif">
				<img id="gif" src="img/cargar_cal.gif" alt="cargar_cal" />
			</div>
			<div id="divres" style="display: none;">
				<table>
					<tbody>
						<tr>
							<td height="30">
							</td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend>RESUMEN DEL PROCESO</legend>
									<ul id="resumen">
									</ul>
								</fieldset>							
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<?php
				if($control == 0) {
					//echo '<script type="text/javascript">','add_resumen("Cargando tabla temporal");','</script>';
					$resultado_r0=$mysqli1->query($query0);
					while($row = $resultado_r0->fetch_assoc()){
						$pensamiento = $row['pensamiento'];
						$grados = $row['grados'];
						echo '<script type="text/javascript">','add_resumen("Limpiando tablas temporales");','</script>';
						$resultado_r01=$mysqli1->query($queryr2);
						if($resultado_r01 > 0) {
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_upd limpiada con éxito");','</script>';
						}
						$resultado_r02=$mysqli1->query($queryr3);
						if($resultado_r02 > 0) {
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_ins limpiada con éxito");','</script>';
						}
						$resultado_r03=$mysqli1->query($queryr4);
						if($resultado_r03 > 0) {
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_no_ra limpiada con éxito");','</script>';
						}
						$resultado_r1=$mysqli1->query($queryr0);
						if($resultado_r1 > 0) {
							echo '<script type="text/javascript">','add_resumen("Tabla notas_mood_temp limpiada con éxito");','</script>';
							$control = 11;
						}
						$resultado_r2=$mysqli1->query($queryr1);
						if($resultado_r2 > 0) {
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp limpiada con éxito");','</script>';
							//$control = 1;
						}
						$resultado_upd_control=$mysqli1->query($query_upd_control);
						if($resultado_upd_control > 0) {
							echo '<script type="text/javascript">','add_resumen("Tabla control_upd limpiada con éxito");','</script>';
							$control = 1;
						}
						
						if($control == 1) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Borrado de tablas'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
    						//Se hace la consulta en querys_ra
							/*$query1 = $dev_enc($row['campos1']).$dev_enc($row['campos2']).$dev_enc($row['campos3']).$dev_enc($row['tablas'])
								.$dev_enc($row['condicion1']).$row['condicion2'].$dev_enc($row['condicion3'])
								.$row['condicion4'].$dev_enc($row['condicion5']).$dev_enc($row['orden']);*/
							$query1 = $dev_enc($row['campos1']).$dev_enc($row['campos2']).$dev_enc($row['campos3']).$dev_enc($row['tablas'])
								.$row['condicion1'].$row['condicion2'].$row['condicion3']
								.$row['condicion4'].$dev_enc($row['condicion5']).$dev_enc($row['orden']);
							//echo $query1;
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_mood_temp para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_m1=$mysqli->query($query1);
							$seleccionados_m = $mysqli->affected_rows;
							//echo $seleccionados;
							while($row1 = $resultado_m1->fetch_assoc()){
							    if($id == 18) {
							        $query2="INSERT INTO ".$tbl_nmt." (id_est, lastname, firstname, shortname, id, name, id_grado, periodo, periodo_ra, calificacion) 
    								VALUES (".$row1['id_est'].",'".$row1['lastname']."','".$row1['firstname']."','".$row1['shortname']."',".$row1['id_mat_mood']
    								.",'".$row1['name']."',".$row1['id_grado'].",'".$row1['Periodo']."',".$row1['Periodo_RA'].",".$row1['calificacion'].")";
							    }
							    else {
							        $query2="INSERT INTO ".$tbl_nmt." (id_est, lastname, firstname, shortname, id, name, id_grado, periodo, periodo_ra, calificacion, id_tutor) 
    								VALUES (".$row1['id_est'].",'".$row1['lastname']."','".$row1['firstname']."','".$row1['shortname']."',".$row1['id_mat_mood']
    								.",'".$row1['name']."',".$row1['id_grado'].",'".$row1['Periodo']."',".$row1['Periodo_RA'].",".$row1['calificacion'].",".$id.")";
							    }
								/*$query2="INSERT INTO notas_mood_temp (id_est, lastname, firstname, shortname, id, name, id_grado, periodo, periodo_ra, calificacion) 
								VALUES (".$row1['id_est'].",'".$row1['lastname']."','".$row1['firstname']."','".$row1['shortname']."',".$row1['id_mat_mood']
								.",'".$row1['name']."',".$row1['id_grado'].",'".$row1['Periodo']."',".$row1['Periodo_RA'].",".$row1['calificacion'].")";*/
								$resultado_r3=$mysqli1->query($query2);
								if($resultado_r3 > 0) {
									$insertados++;
								}
							}
							//echo $query2;
							echo '<script type="text/javascript">','add_resumen("Registros insertados para '.$pensamiento.' grados '.$grados.': '.$seleccionados_m.'");','</script>';
							echo '<script type="text/javascript">','add_resumen("Tabla notas_mood_temp cargada");','</script>';
							$control = 21;
							$insertados = 0;
						}
						if($control == 21) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Tabla notas_mood_temp cargada'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
						    if($id == 18) {
						        $query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra, ee.id_registro 
								FROM ".$tbl_nmt." a, equivalence_idgra eg, equivalence_idmat em, equivalence_idest ee 
								WHERE a.id_grado = eg.id_category AND a.id = em.id_course AND a.id_est = ee.id_moodle";
						    }
						    else {
						        $query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra, ee.id_registro 
								FROM ".$tbl_nmt." a, equivalence_idgra eg, equivalence_idmat em, equivalence_idest ee 
								WHERE a.id_grado = eg.id_category AND a.id = em.id_course AND a.id_est = ee.id_moodle AND a.id_tutor = ".$id;
						    }
							/*$query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra, ee.id_registro 
								FROM ".$tbl_nmt." a, equivalence_idgra eg, equivalence_idmat em, equivalence_idest ee 
								WHERE a.id_grado = eg.id_category AND a.id = em.id_course AND a.id_est = ee.id_moodle";*/
							//echo $query1;
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_r4=$mysqli1->query($query1);
							$seleccionados = $mysqli1->affected_rows;
							//echo $seleccionados;
							while($row2 = $resultado_r4->fetch_assoc()){
							    if($id == 18) {
							        $query2="INSERT INTO ".$tbl_nt." (nota, id_periodo, id_materia, id_grado, id_estudiante) 
								    VALUES (".$row2['calificacion'].",".$row2['periodo_ra'].",".$row2['id_materia_ra'].",".$row2['id_grado_ra'].",".$row2['id_registro'].")";
							    }
							    else {
							        $query2="INSERT INTO ".$tbl_nt." (nota, id_periodo, id_materia, id_grado, id_estudiante, id_tutor) 
								    VALUES (".$row2['calificacion'].",".$row2['periodo_ra'].",".$row2['id_materia_ra'].",".$row2['id_grado_ra'].",".$row2['id_registro'].",".$id.")";
							    }
								/*$query2="INSERT INTO notas_temp (nota, id_periodo, id_materia, id_grado, id_estudiante) 
								VALUES (".$row2['calificacion'].",".$row2['periodo_ra'].",".$row2['id_materia_ra'].",".$row2['id_grado_ra'].",".$row2['id_registro'].")";*/
								$resultado_r5=$mysqli1->query($query2);
								if($resultado_r5 > 0) {
									$insertados++;
								}
							}
							echo '<script type="text/javascript">','add_resumen("Registros insertados para '.$pensamiento.' grados '.$grados.': '.$insertados.'");','</script>';
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp cargada");','</script>';
							$control = 22;
						}
						if($control == 22) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Tabla notas_temp cargada'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
						    if($id == 18) {
						        $query_tupd = "SELECT n.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, nt.id_periodo, "
    							."nt.id_materia, nt.id_grado, n.nota nota_actual, nt.nota nota_nueva "
    							."FROM notas n, estudiantes e, grados g, materias m, ".$tbl_nt." nt "
    							."WHERE nt.id_estudiante = e.id AND nt.id_periodo = n.id_periodo AND nt.id_materia = n.id_materia AND nt.id_grado = n.id_grado "
    							."AND nt.id_estudiante = n.id_estudiante AND nt.id_grado = g.id AND nt.id_materia = m.id "
    							."AND n.nota <> nt.nota "
    							."ORDER BY g.grado, m.materia, e.apellidos, e.nombres, nt.id_periodo";
						    }
						    else {
						        $query_tupd = "SELECT n.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, nt.id_periodo, "
    							."nt.id_materia, nt.id_grado, n.nota nota_actual, nt.nota nota_nueva "
    							."FROM notas n, estudiantes e, grados g, materias m, ".$tbl_nt." nt "
    							."WHERE nt.id_estudiante = e.id AND nt.id_periodo = n.id_periodo AND nt.id_materia = n.id_materia AND nt.id_grado = n.id_grado "
    							."AND nt.id_estudiante = n.id_estudiante AND nt.id_grado = g.id AND nt.id_materia = m.id "
    							."AND n.nota <> nt.nota AND nt.id_tutor = ".$id." "
    							."ORDER BY g.grado, m.materia, e.apellidos, e.nombres, nt.id_periodo";
						    }
							/*$query_tupd = "SELECT n.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, nt.id_periodo, 
							nt.id_materia, nt.id_grado, n.nota nota_actual, nt.nota nota_nueva 
							FROM notas n, estudiantes e, grados g, materias m, ".$tbl_nt." nt 
							WHERE nt.id_estudiante = e.id AND nt.id_periodo = n.id_periodo AND nt.id_materia = n.id_materia AND nt.id_grado = n.id_grado 
							AND nt.id_estudiante = n.id_estudiante AND nt.id_grado = g.id AND nt.id_materia = m.id 
							AND n.nota < nt.nota 
							ORDER BY g.grado, m.materia, e.apellidos, e.nombres, nt.id_periodo";*/
							//echo $query_tupd;
							
							echo '<script type="text/javascript">','add_resumen("***************************");','</script>';
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp_upd para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_tupd=$mysqli1->query($query_tupd);
							$sel_tupd = $mysqli1->affected_rows;
							//echo $sel_tupd;
							while($row_tupd = $resultado_tupd->fetch_assoc()){
							    if($id == 18) {
							        $query_tupd1="INSERT INTO ".$tbl_ntu." (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
    								id_grado, nota_actual, nota_nueva) 
    								VALUES (".$row_tupd['id_estudiante'].",'".$row_tupd['apellidos']."','".$row_tupd['nombres']."','".$row_tupd['grado']."','"
    								.$row_tupd['materia']."',".$row_tupd['id_periodo'].",".$row_tupd['id_materia'].",".$row_tupd['id_grado']
    								.",".$row_tupd['nota_actual'].",".$row_tupd['nota_nueva'].")";
							    }
							    else {
							        $query_tupd1="INSERT INTO ".$tbl_ntu." (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
    								id_grado, nota_actual, nota_nueva, id_tutor) 
    								VALUES (".$row_tupd['id_estudiante'].",'".$row_tupd['apellidos']."','".$row_tupd['nombres']."','".$row_tupd['grado']."','"
    								.$row_tupd['materia']."',".$row_tupd['id_periodo'].",".$row_tupd['id_materia'].",".$row_tupd['id_grado']
    								.",".$row_tupd['nota_actual'].",".$row_tupd['nota_nueva'].",".$id.")";
							    }
								/*$query_tupd1="INSERT INTO notas_temp_upd (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
								id_grado, nota_actual, nota_nueva) 
								VALUES (".$row_tupd['id_estudiante'].",'".$row_tupd['apellidos']."','".$row_tupd['nombres']."','".$row_tupd['grado']."','"
								.$row_tupd['materia']."',".$row_tupd['id_periodo'].",".$row_tupd['id_materia'].",".$row_tupd['id_grado']
								.",".$row_tupd['nota_actual'].",".$row_tupd['nota_nueva'].")";*/
								$resultado_tupd1=$mysqli1->query($query_tupd1);
								if($resultado_tupd1 > 0) {
									$ins_tupd++;
								}
							}
							//echo $query_tupd1;
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_upd ->sel: '.$sel_tupd.' ->ins: '.$ins_tupd.'");','</script>';
							$control = 23;
						}
						if($control == 23) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Tabla notas_temp_upd cargada'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
						    if($id == 18) {
						        $query_tins = "SELECT a.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, a.id_periodo, a.id_materia, a.id_grado, a.nota_actual, a.nota nota_nueva "
    							."FROM ("
    							."SELECT nt.*, cast(ifnull(n.nota, 0) as decimal(10,1)) nota_actual "
    							."FROM ".$tbl_nt." nt "
    							."LEFT JOIN notas n "
    							."ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) "
    							."WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL) a, estudiantes e, grados g, materias m "
    							."WHERE a.id_estudiante = e.id AND a.id_grado = g.id AND a.id_materia = m.id "
    							."ORDER BY g.grado, m.materia, e.apellidos, e.nombres, a.id_periodo";
						    }
						    else {
						        $query_tins = "SELECT a.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, a.id_periodo, a.id_materia, a.id_grado, a.nota_actual, a.nota nota_nueva "
    							."FROM ("
    							."SELECT nt.*, cast(ifnull(n.nota, 0) as decimal(10,1)) nota_actual "
    							."FROM ".$tbl_nt." nt "
    							."LEFT JOIN notas n "
    							."ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) "
    							."WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL) a, estudiantes e, grados g, materias m "
    							."WHERE a.id_estudiante = e.id AND a.id_grado = g.id AND a.id_materia = m.id AND a.id_tutor = ".$id." "
    							."ORDER BY g.grado, m.materia, e.apellidos, e.nombres, a.id_periodo";
						    }
							/*$query_tins = "SELECT a.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, a.id_periodo, a.id_materia, a.id_grado, a.nota_actual, a.nota nota_nueva 
							FROM (
							SELECT nt.*, cast(ifnull(n.nota, 0) as decimal(10,1)) nota_actual 
							FROM ".$tbl_nt." nt
							LEFT JOIN notas n
							ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
							WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL) a, estudiantes e, grados g, materias m
							WHERE a.id_estudiante = e.id AND a.id_grado = g.id AND a.id_materia = m.id 
							ORDER BY g.grado, m.materia, e.apellidos, e.nombres, a.id_periodo";*/
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp_ins para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_tins=$mysqli1->query($query_tins);
							$sel_tins = $mysqli1->affected_rows;
							//echo $sel_tins;
							while($row_tins = $resultado_tins->fetch_assoc()){
							    //*****UPD TABLA CONTROL ****
        						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Cargando tabla notas_temp_ins'";
        						$resultado_uc=$mysqli1->query($query_uc);
        						//*****UPD TABLA CONTROL ****
        						
							    if($id == 18) {
							        $query_tins1="INSERT INTO ".$tbl_nti." (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
    								id_grado, nota_actual, nota_nueva) 
    								VALUES (".$row_tins['id_estudiante'].",'".$row_tins['apellidos']."','".$row_tins['nombres']."','".$row_tins['grado']."','"
    								.$row_tins['materia']."',".$row_tins['id_periodo'].",".$row_tins['id_materia'].",".$row_tins['id_grado']
    								.",".$row_tins['nota_actual'].",".$row_tins['nota_nueva'].")";
							    }
							    else {
							        $query_tins1="INSERT INTO ".$tbl_nti." (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
    								id_grado, nota_actual, nota_nueva, id_tutor) 
    								VALUES (".$row_tins['id_estudiante'].",'".$row_tins['apellidos']."','".$row_tins['nombres']."','".$row_tins['grado']."','"
    								.$row_tins['materia']."',".$row_tins['id_periodo'].",".$row_tins['id_materia'].",".$row_tins['id_grado']
    								.",".$row_tins['nota_actual'].",".$row_tins['nota_nueva'].",".$id.")";
							    }
								/*$query_tins1="INSERT INTO notas_temp_ins (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
								id_grado, nota_actual, nota_nueva) 
								VALUES (".$row_tins['id_estudiante'].",'".$row_tins['apellidos']."','".$row_tins['nombres']."','".$row_tins['grado']."','"
								.$row_tins['materia']."',".$row_tins['id_periodo'].",".$row_tins['id_materia'].",".$row_tins['id_grado']
								.",".$row_tins['nota_actual'].",".$row_tins['nota_nueva'].")";*/
								$resultado_tins1=$mysqli1->query($query_tins1);
								if($resultado_tins1 > 0) {
									$ins_tins++;
								}
							}
							//echo $query_tins1;
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_ins ->sel: '.$sel_tins.' ->ins: '.$ins_tins.'");','</script>';
							echo '<script type="text/javascript">','add_resumen("***************************");','</script>';
							$control = 2;
						}
						
						if($control == 2) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Tabla notas_temp_ins cargada'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
							echo '<script type="text/javascript">','add_resumen("Actualizando calificaciones para '.$pensamiento.' grados '.$grados.'");','</script>';
							//echo $query3;
							$resultado_r6=$mysqli1->query($query3);
							if($resultado_r6 > 0) {
								//$actualizados++;
								$actualizados = $mysqli1->affected_rows;
								//echo $query;
							}
							echo '<script type="text/javascript">','add_resumen("Registros actualizados para '.$pensamiento.' grados '.$grados.': '.$actualizados.'");','</script>';
							echo '<script type="text/javascript">','add_resumen("Calificaciones actualizadas con éxito");','</script>';
							$control = 3;
						}
						if($control == 3) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Registros actualizados'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
							echo '<script type="text/javascript">','add_resumen("Insertando calificaciones nuevas para '.$pensamiento.' grados '.$grados.'");','</script>';
							if($id == 18) {
							    $query4 = "INSERT INTO ".$dev_enc($insert_into_n)."SELECT ".$dev_enc($select_n);
							}
							else {
							    $query4 = "INSERT INTO ".$dev_enc($insert_into_n)."SELECT ".$dev_enc($select_n_tut).$id;
							}
							//echo $query4;
							/*$query4 = "INSERT INTO ".$dev_enc($insert_into_n)."SELECT ".$dev_enc($select_n);*/
							$resultado_r7=$mysqli1->query($query4);
							if($resultado_r7 > 0) {
								$insertados_n = $mysqli1->affected_rows;
								//echo $query;
							}
							echo '<script type="text/javascript">','add_resumen("Registros ingresados para '.$pensamiento.' grados '.$grados.': '.$insertados_n.'");','</script>';
							echo '<script type="text/javascript">','add_resumen("Calificaciones nuevas ingresadas con éxito");','</script>';
							$control = 4;
						}
						if($control == 4) {
						    //*****UPD TABLA CONTROL ****
    						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Registros insertados'";
    						$resultado_uc=$mysqli1->query($query_uc);
    						//*****UPD TABLA CONTROL ****
    						
						    if($id == 18) {
						        $query_en = "SELECT mt.* FROM ".$tbl_nmt." mt WHERE mt.id_est NOT IN (SELECT id_moodle FROM equivalence_idest)";
						    }
						    else {
						        $query_en = "SELECT mt.* FROM ".$tbl_nmt." mt WHERE mt.id_est NOT IN (SELECT id_moodle FROM equivalence_idest) AND mt.id_tutor = ".$id;
						    }
							/*$query_en = "SELECT mt.* FROM ".$tbl_nmt." mt WHERE id_est NOT IN (SELECT id_moodle FROM equivalence_idest)";*/
							$resultado_en=$mysqli1->query($query_en);
							$en = $mysqli1->affected_rows;
							
							if($id == 18) {
							    $query_en1 = "INSERT INTO ".$tbl_nt_nr." 
    							SELECT mt.id_est, mt.lastname, mt.firstname, g.name, m.shortname, mt.periodo_ra, m.id_materia_ra, g.id_grado_ra, 
    							0 nota_actual, mt.calificacion 
    							FROM ".$tbl_nmt." mt, equivalence_idgra g, equivalence_idmat m 
    							WHERE mt.id_grado = g.id_category AND mt.id = m.id_course AND mt.id_est NOT IN (SELECT id_moodle FROM equivalence_idest)";
							}
							else {
							    $query_en1 = "INSERT INTO ".$tbl_nt_nr." 
    							SELECT mt.id_est, mt.lastname, mt.firstname, g.name, m.shortname, mt.periodo_ra, m.id_materia_ra, g.id_grado_ra, 
    							0 nota_actual, mt.calificacion, mt.id_tutor 
    							FROM ".$tbl_nmt." mt, equivalence_idgra g, equivalence_idmat m 
    							WHERE mt.id_grado = g.id_category AND mt.id = m.id_course AND mt.id_est NOT IN (SELECT id_moodle FROM equivalence_idest) 
    							AND mt.id_tutor = ".$id;
							}
							/*$query_en1 = "INSERT INTO ".$tbl_nt_nr." 
							SELECT mt.id_est, mt.lastname, mt.firstname, g.name, m.shortname, mt.periodo_ra, m.id_materia_ra, g.id_grado_ra, 
							0 nota_actual, mt.calificacion 
							FROM ".$tbl_nmt." mt, equivalence_idgra g, equivalence_idmat m 
							WHERE mt.id_grado = g.id_category AND mt.id = m.id_course AND mt.id_est NOT IN (SELECT id_moodle FROM equivalence_idest)";*/
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp_no_ra para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_en1=$mysqli1->query($query_en1);
							
							if($resultado_en1 > 0) {
    							//*****UPD TABLA CONTROL ****
        						$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'Tabla notas_temp_no_ra cargada'";
        						$resultado_uc=$mysqli1->query($query_uc);
        						//*****UPD TABLA CONTROL ****
    						}
							
							echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_no_ra ->ins: '.$en.'");','</script>';
							
							$query5 = "UPDATE querys_ra SET actualizado = '"
							.$fecha2."', seleccionados = ".$seleccionados_m.", insertados_tem = ".$insertados.", actualizados = ".$actualizados.", nuevos = ".$insertados_n
							.", est_nue_no_reg = ".$en.", procesar = 0 WHERE pensamiento = '".$pensamiento."' AND grados = '".$grados."'";
							//echo $query5;
							$resultado_r8=$mysqli1->query($query5);
						}
						$seleccionados = 0;
						$seleccionados_m = 0;
						$insertados = 0;
						$actualizados = 0;
						$insertados_n = 0;
						$en = 0;
						$sel_tupd = 0;
						$ins_tupd = 0;
						$sel_tins = 0;
						$ins_tins = 0;
					}
				}			
			?>
			<?php
			    //*****UPD TABLA CONTROL ****
				$query_uc = "UPDATE tbl_control_upd SET resultado = 'OK' WHERE archivo = 'cal_reg_putdat1' AND paso = 'FIN'";
				$resultado_uc=$mysqli1->query($query_uc);
				//*****UPD TABLA CONTROL ****
				
				$mysqli1->close();
				$mysqli->close();
				echo '<script type="text/javascript">','mr_putdat();','</script>';
			?>
			<br/>
		</center>
	</body>
	
</html>