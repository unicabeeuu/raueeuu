<?php
	//Muestra los registros a ser actualizado e insertados para una consulta personalizada
	require("1cc3s4db.php");
	require("1cc3s4db_m.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	set_time_limit(600);
	
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
	
	$fecha2 = $a.$mes.$dia."_".$hora.$minutos;
	
	//Limpiar tablas temporales
	$queryr0 = "Delete From notas_mood_temp";
	$queryr1 = "Delete From notas_temp";
	$queryr2 = "Delete From notas_temp_upd";
	$queryr3 = "Delete From notas_temp_ins";
	$queryr4 = "Delete From notas_temp_no_ra";
	//Consulta general
	$query0 = $_REQUEST["txtquery"];
	//echo $query0;
?>

<html>
	<head>
		<title></title>
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
					}
					$resultado_r2=$mysqli1->query($queryr1);
					if($resultado_r2 > 0) {
						echo '<script type="text/javascript">','add_resumen("Tabla notas_temp limpiada con éxito");','</script>';
						$control = 1;
					}
					if($control == 1) {
						$resultado_r0=$mysqli->query($query0);
						while($row = $resultado_r0->fetch_assoc()){
							$query2="INSERT INTO notas_mood_temp (id_est, lastname, firstname, shortname, id, name, id_grado, periodo, periodo_ra, calificacion) 
							VALUES (".$row['id_est'].",'".$row['lastname']."','".$row['firstname']."','".$row['shortname']."',".$row['id_mat_mood']
							.",'".$row['name']."',".$row['id_grado'].",'".$row['Periodo']."',".$row['Periodo_RA'].",".$row['calificacion'].")";
							$resultado_r3=$mysqli1->query($query2);
							if($resultado_r3 > 0) {
								$insertados++;
							}
						}
						//echo $query2;
						//echo '<script type="text/javascript">','add_resumen("Registros insertados para '.$pensamiento.' grados '.$grados.': '.$insertados.'");','</script>';
						echo '<script type="text/javascript">','add_resumen("Tabla notas_mood_temp cargada: '.$insertados.'");','</script>';
						$control = 21;
						$insertados = 0;
					}
					if($control == 21) {
						$query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra, ee.id_registro 
							FROM notas_mood_temp a, equivalence_idgra eg, equivalence_idmat em, equivalence_idest ee 
							WHERE a.id_grado = eg.id_category AND a.id = em.id_course AND a.id_est = ee.id_moodle";
						//echo $query1;
						
						$resultado_r4=$mysqli1->query($query1);
						$seleccionados = $mysqli1->affected_rows;
						//echo $seleccionados;
						while($row2 = $resultado_r4->fetch_assoc()){								
							$query2="INSERT INTO notas_temp (nota, id_periodo, id_materia, id_grado, id_estudiante) 
							VALUES (".$row2['calificacion'].",".$row2['periodo_ra'].",".$row2['id_materia_ra'].",".$row2['id_grado_ra'].",".$row2['id_registro'].")";
							$resultado_r5=$mysqli1->query($query2);
							if($resultado_r5 > 0) {
								$insertados++;
							}
						}
						echo '<script type="text/javascript">','add_resumen("Tabla notas_temp cargada: '.$insertados.'");','</script>';
						$control = 22;
					}
					if($control == 22) {
						$query_tupd = "SELECT n.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, nt.id_periodo, "
						."nt.id_materia, nt.id_grado, n.nota nota_actual, nt.nota nota_nueva "
						."FROM notas n, estudiantes e, grados g, materias m, notas_temp nt "
						."WHERE nt.id_estudiante = e.id AND nt.id_periodo = n.id_periodo AND nt.id_materia = n.id_materia AND nt.id_grado = n.id_grado "
						."AND nt.id_estudiante = n.id_estudiante AND nt.id_grado = g.id AND nt.id_materia = m.id "
						."AND n.nota < nt.nota "
						."ORDER BY g.grado, m.materia, e.apellidos, e.nombres, nt.id_periodo";
						//echo $query_tupd;
						
						echo '<script type="text/javascript">','add_resumen("***************************");','</script>';
						$resultado_tupd=$mysqli1->query($query_tupd);
						$sel_tupd = $mysqli1->affected_rows;
						//echo $sel_tupd;
						while($row_tupd = $resultado_tupd->fetch_assoc()){								
							$query_tupd1="INSERT INTO notas_temp_upd (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
							id_grado, nota_actual, nota_nueva) 
							VALUES (".$row_tupd['id_estudiante'].",'".$row_tupd['apellidos']."','".$row_tupd['nombres']."','".$row_tupd['grado']."','"
							.$row_tupd['materia']."',".$row_tupd['id_periodo'].",".$row_tupd['id_materia'].",".$row_tupd['id_grado']
							.",".$row_tupd['nota_actual'].",".$row_tupd['nota_nueva'].")";
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
						$query_tins = "SELECT a.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, a.id_periodo, a.id_materia, a.id_grado, a.nota_actual, a.nota nota_nueva "
						."FROM ("
						."SELECT nt.*, cast(ifnull(n.nota, 0) as decimal(10,1)) nota_actual "
						."FROM notas_temp nt "
						."LEFT JOIN notas n "
						."ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) "
						."WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL) a, estudiantes e, grados g, materias m "
						."WHERE a.id_estudiante = e.id AND a.id_grado = g.id AND a.id_materia = m.id "
						."ORDER BY g.grado, m.materia, e.apellidos, e.nombres, a.id_periodo";
						
						$resultado_tins=$mysqli1->query($query_tins);
						$sel_tins = $mysqli1->affected_rows;
						//echo $sel_tins;
						while($row_tins = $resultado_tins->fetch_assoc()){								
							$query_tins1="INSERT INTO notas_temp_ins (id_estudiante, apellidos, nombres, grado, materia, id_periodo, id_materia, 
							id_grado, nota_actual, nota_nueva) 
							VALUES (".$row_tins['id_estudiante'].",'".$row_tins['apellidos']."','".$row_tins['nombres']."','".$row_tins['grado']."','"
							.$row_tins['materia']."',".$row_tins['id_periodo'].",".$row_tins['id_materia'].",".$row_tins['id_grado']
							.",".$row_tins['nota_actual'].",".$row_tins['nota_nueva'].")";
							$resultado_tins1=$mysqli1->query($query_tins1);
							if($resultado_tins1 > 0) {
								$ins_tins++;
							}
						}
						//echo $query_tins1;
						echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_ins ->sel: '.$sel_tins.' ->ins: '.$ins_tins.'");','</script>';
						echo '<script type="text/javascript">','add_resumen("***************************");','</script>';
						$control = 4;
					}
					if($control == 4) {
						$query_en = "SELECT mt.* FROM notas_mood_temp mt WHERE id_est NOT IN (SELECT id_moodle FROM equivalence_idest)";
						$resultado_en=$mysqli1->query($query_en);
						$en = $mysqli1->affected_rows;
						
						$query_en1 = "INSERT INTO notas_temp_no_ra 
						SELECT mt.id_est, mt.lastname, mt.firstname, g.name, m.shortname, mt.periodo_ra, m.id_materia_ra, g.id_grado_ra, 
							0 nota_actual, mt.calificacion 
							FROM notas_mood_temp mt, equivalence_idgra g, equivalence_idmat m 
							WHERE mt.id_grado = g.id_category AND mt.id = m.id_course AND mt.id_est NOT IN (SELECT id_moodle FROM equivalence_idest)";
						
						echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp_no_ra para '.$pensamiento.' grados '.$grados.'");','</script>';
						$resultado_en1=$mysqli1->query($query_en1);
						
						echo '<script type="text/javascript">','add_resumen("Tabla notas_temp_no_ra ->ins: '.$en.'");','</script>';
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
			?>
			<?php
				$mysqli1->close();
				$mysqli->close();
				echo '<script type="text/javascript">','mr();','</script>';
				header("Location: pen_gra_upddat3.php");
			?>
			<br/>
		</center>
	</body>
	
</html>