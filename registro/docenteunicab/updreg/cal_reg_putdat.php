<?php
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
	
	//Limpiar tablas temporales
	$queryr0 = "Delete From notas_mood_temp";
	$queryr1 = "Delete From notas_temp";
	$queryr2 = "Delete From notas_temp_upd";
	$queryr3 = "Delete From notas_temp_ins";
	$queryr4 = "Delete From notas_temp_No_ra";
	//Consulta general
	$query0 = "SELECT * FROM querys_ra WHERE procesar = 1";
	//Consultar calificaciones moodle
	//$query1 = "SELECT ".$dev_enc($campos_cal)."FROM ".$dev_enc($tablas_cal)."WHERE ".$dev_enc($condicion_ar)."ORDER BY ".$dev_enc($ob_cal);	
	//Sentencia para actualizar registros
	$query3 = "UPDATE ".$dev_enc($notas_upd)."JOIN ".$dev_enc($condicion_on_upd)."SET ".$dev_enc($set_upd)."WHERE ".$dev_enc($condicion_upd);
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/reg.css" >
		<script type="text/javascript" src="js/reg.js"></script>
		<style>
			/*#resumen {
				list-style-image: url("img/bd30.png"); 
				background: lightgreen;
				padding: 20px;
				font-weight: bold;
				font-size: 20px;
			}
			#resumen li {
				background: #cce5ff;
				margin-left: 20px;
				margin-top: 5px;
			}
			fieldset {
				border: 2px double green;
				-moz-border-radius: 8px;
				-webkit-border-radius: 8px;	
				border-radius: 8px;
			}
			legend {
				 text-align:center;
				 font-weight:bold;
				 font-size:18pt;
				 color:#B4045F;
				 text-shadow: 0px 0px 10px #BA55D3;
			 }*/
		</style>
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
							$control = 1;
						}
						if($control == 1) {
							$query1 = $dev_enc($row['campos1']).$dev_enc($row['campos2']).$dev_enc($row['campos3']).$dev_enc($row['tablas'])
								.$dev_enc($row['condicion1']).$row['condicion2'].$dev_enc($row['condicion3'])
								.$row['condicion4'].$dev_enc($row['condicion5']).$dev_enc($row['orden']);
							//echo $query1;
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_mood_temp para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_m1=$mysqli->query($query1);
							$seleccionados_m = $mysqli->affected_rows;
							//echo $seleccionados;
							while($row1 = $resultado_m1->fetch_assoc()){								
								$query2="INSERT INTO notas_mood_temp (id_est, lastname, firstname, shortname, id, name, id_grado, periodo, periodo_ra, calificacion) 
								VALUES (".$row1['id_est'].",'".$row1['lastname']."','".$row1['firstname']."','".$row1['shortname']."',".$row1['id_mat_mood']
								.",'".$row1['name']."',".$row1['id_grado'].",'".$row1['Periodo']."',".$row1['Periodo_RA'].",".$row1['calificacion'].")";
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
							$query1 = "SELECT a.*, eg.id_grado_ra, em.id_materia_ra FROM notas_mood_temp a, equivalence_idgra eg, equivalence_idmat em 
								WHERE a.id_grado = eg.id_category AND a.id = em.id_course";
							//echo $query1;
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp para '.$pensamiento.' grados '.$grados.'");','</script>';
							$resultado_r4=$mysqli1->query($query1);
							$seleccionados = $mysqli1->affected_rows;
							//echo $seleccionados;
							while($row2 = $resultado_r4->fetch_assoc()){								
								$query2="INSERT INTO notas_temp (nota, id_periodo, id_materia, id_grado, id_estudiante) 
								VALUES (".$row2['calificacion'].",".$row2['periodo_ra'].",".$row2['id_materia_ra'].",".$row2['id_grado_ra'].",".$row2['id_est'].")";
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
							$query_tupd = "SELECT n.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, nt.id_periodo, 
							nt.id_materia, nt.id_grado, n.nota nota_actual, nt.nota nota_nueva 
							FROM notas n, estudiantes e, grados g, materias m, notas_temp nt 
							WHERE nt.id_estudiante = e.id AND nt.id_periodo = n.id_periodo AND nt.id_materia = n.id_materia AND nt.id_grado = n.id_grado 
							AND nt.id_estudiante = n.id_estudiante AND nt.id_grado = g.id AND nt.id_materia = m.id 
							AND n.nota <> nt.nota 
							ORDER BY g.grado, m.materia, e.apellidos, e.nombres, nt.id_periodo";
							//echo $query_tupd;
							
							echo '<script type="text/javascript">','add_resumen("***************************");','</script>';
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp_upd para '.$pensamiento.' grados '.$grados.'");','</script>';
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
							$query_tins = "SELECT a.id_estudiante, e.apellidos, e.nombres, g.grado, m.materia, a.id_periodo, a.id_materia, a.id_grado, a.nota_actual, a.nota nota_nueva 
							FROM (
							SELECT nt.*, cast(ifnull(n.nota, 0) as decimal(10,1)) nota_actual 
							FROM notas_temp nt
							LEFT JOIN notas n
							ON CONCAT(nt.id_periodo,nt.id_materia,nt.id_grado,nt.id_estudiante) = CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante)
							WHERE CONCAT(n.id_periodo,n.id_materia,n.id_grado,n.id_estudiante) IS NULL) a, estudiantes e, grados g, materias m
							WHERE a.id_estudiante = e.id AND a.id_grado = g.id AND a.id_materia = m.id 
							ORDER BY g.grado, m.materia, e.apellidos, e.nombres, a.id_periodo";
							
							echo '<script type="text/javascript">','add_resumen("Cargando tabla notas_temp_ins para '.$pensamiento.' grados '.$grados.'");','</script>';
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
							$control = 2;
						}
						
						if($control == 2) {
							echo '<script type="text/javascript">','add_resumen("Actualizando calificaciones para '.$pensamiento.' grados '.$grados.'");','</script>';
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
							echo '<script type="text/javascript">','add_resumen("Insertando calificaciones nuevas para '.$pensamiento.' grados '.$grados.'");','</script>';
							$query4 = "INSERT INTO ".$dev_enc($insert_into_n)."SELECT ".$dev_enc($select_n);
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
				$mysqli1->close();
				$mysqli->close();
				echo '<script type="text/javascript">','mr_putdar();','</script>';
			?>
			<br/>
		</center>
	</body>
	
</html>