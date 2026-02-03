<?php
    session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	set_time_limit(300);
	
	$sel_tupd = 0;
	$sel_tins = 0;
	$sel_tno_ra = 0;
	$rxp = 30;
	$rxp_i = 30;
	$idq=$_REQUEST['idq'];
	
	if(!$_GET['p'] && !$_GET['p1']) {
		header("Location: pen_gra_upddat3.php?p=1&pi=1&idq=".$idq);
	}
	
	//$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=$mysqli1->query($sql);

	while($fila = $res->fetch_assoc()){
	  	$id = $fila['id'];
    }
	
	//Asignar tablas temporales
	if($id == 18) {
	    $tbl_nmt = "notas_mood_temp";
	    $tbl_nt = "notas_temp";
	    $tbl_ntu = "notas_temp_upd";
	    $tbl_nti = "notas_temp_ins";
	    $tbl_nt_nr = "notas_temp_no_ra";
	    
	    //Consultar tablas temporales
	    $queryr2 = "Select * From ".$tbl_ntu." ORDER BY grado, materia, id_periodo, apellidos, nombres";
	    $queryr3 = "Select * From ".$tbl_nti." ORDER BY grado, materia, id_periodo, apellidos, nombres";
	    $queryr4 = "Select * From ".$tbl_nt_nr." ORDER BY grado, materia, id_periodo, apellidos, nombres";
	}
	else {
	    $tbl_nmt = "tbl_notas_mood_temp";
	    $tbl_nt = "tbl_notas_temp";
	    $tbl_ntu = "tbl_notas_temp_upd";
	    $tbl_nti = "tbl_notas_temp_ins";
	    $tbl_nt_nr = "tbl_notas_temp_no_ra";
	    
	    //Consultar tablas temporales
	    $queryr2 = "Select * From ".$tbl_ntu." WHERE id_tutor = ".$id." ORDER BY grado, materia, id_periodo, apellidos, nombres";
	    $queryr3 = "Select * From ".$tbl_nti." WHERE id_tutor = ".$id." ORDER BY grado, materia, id_periodo, apellidos, nombres";
	    $queryr4 = "Select * From ".$tbl_nt_nr." WHERE id_tutor = ".$id." ORDER BY grado, materia, id_periodo, apellidos, nombres";
	}
	//echo $queryr2;
	//echo $queryr3;
	
	try {
		$resultado2=$mysqli1->query($queryr2);
		$sel_tupd = $mysqli1->affected_rows;
	}
	catch (Exception $e) {}
	//echo $sel_tupd;
	if($sel_tupd > 0) {
		$pag = ceil($sel_tupd/$rxp);
		$ini = ($_GET['p']-1)*$rxp;
		$ini1 = $ini + 1;
		$fin = ($_GET['p']-1)*$rxp + $rxp;
		if($fin > $sel_tupd) {
			$fin = $sel_tupd;
		}
	}
	
	try {
		$resultado3=$mysqli1->query($queryr3);
		$sel_tins = $mysqli1->affected_rows;
	}
	catch (Exception $e) {}
	if($sel_tins > 0) {
		$pag_i = ceil($sel_tins/$rxp_i);
		$ini_i = ($_GET['pi']-1)*$rxp_i;
		$ini1_i = $ini_i + 1;
		$fin_i = ($_GET['pi']-1)*$rxp_i + $rxp_i;
		if($fin_i > $sel_tins) {
			$fin_i = $sel_tins;
		}
	}
	
	try {
		$resultado4=$mysqli1->query($queryr4);
		$sel_tno_ra = $mysqli1->affected_rows;
	}
	catch (Exception $e) {}
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
	    <!---->
	    
		<title></title>
		<!---->
		<!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">-->
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/reg.css" >
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
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
							<td rowspan="2">
								<fieldset>
									<legend>REGISTROS A ACTUALIZAR</legend>
									<?php
									echo '<label>Total Registros &#9658; '.$sel_tupd.' ---------------> Registros '.$ini1.' al '.$fin.'</label>';
									?>
									<table border="1px" class="tr">
										<thead>
											<tr>
												<td><b>Id estudiante</b></td>
												<td><b>Apellidos</b></td>
												<td><b>Nombres</b></td>
												<td><b>Grado</b></td>
												<td><b>Materia</b></td>
												<td><b>Periodo</b></td>
												<td><b>Id materia</b></td>
												<td><b>Id grado</b></td>
												<td><b>Nota actual</b></td>
												<td><b>Nota nueva</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											    if($sel_tupd > 0) {													
													//$ini = ($_GET['p']-1)*$rxp;
													if($id == 18) {
													    $queryr2_1 = "Select * From ".$tbl_ntu." ORDER BY grado, materia, id_periodo, apellidos, nombres LIMIT "
													    .$ini.",".$rxp;
													}
													else {
													    $queryr2_1 = "Select * From ".$tbl_ntu." WHERE id_tutor = ".$id." ORDER BY grado, materia, id_periodo, apellidos, nombres LIMIT "
													    .$ini.",".$rxp;
													}
													/*$queryr2_1 = "Select * From ".$tbl_ntu." ORDER BY grado, materia, id_periodo, apellidos, nombres LIMIT "
													.$ini.",".$rxp;*/
													//echo $pag;
													//echo $_GET['p'];
													$resultado2_1=$mysqli1->query($queryr2_1);
												}
												else {
													$resultado2_1=$mysqli1->query($queryr2);
												}
												//echo $queryr2_1;
												while($row2 = $resultado2_1->fetch_assoc()){
											?>
											<tr>
												<td><?php echo $row2['id_estudiante'];?></td>
												<td><?php echo $row2['apellidos'];?></td>
												<td><?php echo $row2['nombres'];?></td>
												<td><?php echo $row2['grado'];?></td>
												<td><?php echo $row2['materia'];?></td>
												<td><?php echo $row2['id_periodo'];?></td>
												<td><?php echo $row2['id_materia'];?></td>
												<td><?php echo $row2['id_grado'];?></td>
												<td><?php echo $row2['nota_actual'];?></td>
												<td><?php echo $row2['nota_nueva'];?></td>
											</tr>
											<?php }
											?>
										</tbody>
									</table>
								</fieldset>
								<nav aria-label="...">
								  <ul class="pagination">
									<li class="page-item <?php echo $_GET['p']<=1 ? 'disabled' : '' ?>">
										<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p']-1 ?>&pi=<?php echo $_GET['pi'] ?>&idq=<?php echo $idq ?>">&#9668; Anterior</a>
									</li>
									<?php for($i=0; $i<$pag;$i++): ?>
									<li class="page-item <?php echo $_GET['p']==$i+1 ? 'active' : '' ?>">
										<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $i+1 ?>&pi=<?php echo $_GET['pi'] ?>&idq=<?php echo $idq ?>"><?php echo $i+1 ?></a>
									</li>
									<?php endfor ?>
									<!--<li class="page-item active" aria-current="page">
									  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
									</li>-->
									<li class="page-item <?php echo $_GET['p']>=$pag ? 'disabled' : '' ?>">
										<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p']+1 ?>&pi=<?php echo $_GET['pi'] ?>&idq=<?php echo $idq ?>">Siguiente &#9658;</a>
									</li>
								  </ul>
								</nav>
							</td>
							<td valign="top">
								<fieldset>
									<legend>REGISTROS NUEVOS</legend>
									<?php
									echo '<label>Total Registros &#9658; '.$sel_tins.' ---------------> Registros '.$ini1_i.' al '.$fin_i.'</label>';
									?>
									<table border="1px" class="tr">
										<thead>
											<tr>
												<td><b>Id estudiante</b></td>
												<td><b>Apellidos</b></td>
												<td><b>Nombres</b></td>
												<td><b>Grado</b></td>
												<td><b>Materia</b></td>
												<td><b>Periodo</b></td>
												<td><b>Id materia</b></td>
												<td><b>Id grado</b></td>
												<td><b>Nota actual</b></td>
												<td><b>Nota nueva</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
											    if($sel_tins > 0) {
											        if($id == 18) {
											            $queryr3_1 = "Select * From ".$tbl_nti." ORDER BY grado, materia, id_periodo, apellidos, nombres LIMIT "
													    .$ini_i.",".$rxp_i;
											        }
											        else {
											            $queryr3_1 = "Select * From ".$tbl_nti." WHERE id_tutor = ".$id." ORDER BY grado, materia, id_periodo, apellidos, nombres LIMIT "
													    .$ini_i.",".$rxp_i;
											        }
													/*$queryr3_1 = "Select * From ".$tbl_nti." ORDER BY grado, materia, id_periodo, apellidos, nombres LIMIT "
													.$ini_i.",".$rxp_i;*/
													//echo $pag;
													//echo $_GET['p'];
													$resultado3_1=$mysqli1->query($queryr3_1);
												}
												else {
													$resultado3_1=$mysqli1->query($queryr3);
												}
												
												while($row3 = $resultado3_1->fetch_assoc()){
											?>
											<tr>
												<td><?php echo $row3['id_estudiante'];?></td>
												<td><?php echo $row3['apellidos'];?></td>
												<td><?php echo $row3['nombres'];?></td>
												<td><?php echo $row3['grado'];?></td>
												<td><?php echo $row3['materia'];?></td>
												<td><?php echo $row3['id_periodo'];?></td>
												<td><?php echo $row3['id_materia'];?></td>
												<td><?php echo $row3['id_grado'];?></td>
												<td><?php echo $row3['nota_actual'];?></td>
												<td><?php echo $row3['nota_nueva'];?></td>
											</tr>
											<?php }
											?>
										</tbody>
									</table>
								</fieldset>
								<nav aria-label="...">
								  <ul class="pagination">
									<li class="page-item <?php echo $_GET['pi']<=1 ? 'disabled' : '' ?>">
										<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p'] ?>&pi=<?php echo $_GET['pi']-1 ?>&idq=<?php echo $idq ?>">&#9668; Anterior</a>
									</li>
									<?php for($j=0; $j<$pag_i;$j++): ?>
									<li class="page-item <?php echo $_GET['pi']==$j+1 ? 'active' : '' ?>">
										<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p'] ?>&pi=<?php echo $j+1 ?>&idq=<?php echo $idq ?>"><?php echo $j+1 ?></a>
									</li>
									<?php endfor ?>
									<!--<li class="page-item active" aria-current="page">
									  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
									</li>-->
									<li class="page-item <?php echo $_GET['pi']>=$pag_i ? 'disabled' : '' ?>">
										<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p'] ?>&pi=<?php echo $_GET['pi']+1 ?>&idq=<?php echo $idq ?>">Siguiente &#9658;</a>
									</li>
								  </ul>
								</nav>
							</td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend>REGISTROS NO INGRESADOS DE EST SIN RA</legend>
									<?php
									echo '<label>Total Registros &#9658; '.$sel_tno_ra.'</label>';
									?>
									<table border="1px" class="tr">
										<thead>
											<tr>
												<td><b>Id estudiante</b></td>
												<td><b>Apellidos</b></td>
												<td><b>Nombres</b></td>
												<td><b>Grado</b></td>
												<td><b>Materia</b></td>
												<td><b>Periodo</b></td>
												<td><b>Id materia</b></td>
												<td><b>Id grado</b></td>
												<td><b>Nota actual</b></td>
												<td><b>Nota nueva</b></td>
											</tr>
										</thead>
										<tbody>
											<?php
												while($row4 = $resultado4->fetch_assoc()){
											?>
											<tr>
												<td><?php echo $row4['id_estudiante'];?></td>
												<td><?php echo $row4['apellidos'];?></td>
												<td><?php echo $row4['nombres'];?></td>
												<td><?php echo $row4['grado'];?></td>
												<td><?php echo $row4['materia'];?></td>
												<td><?php echo $row4['id_periodo'];?></td>
												<td><?php echo $row4['id_materia'];?></td>
												<td><?php echo $row4['id_grado'];?></td>
												<td><?php echo $row4['nota_actual'];?></td>
												<td><?php echo $row4['nota_nueva'];?></td>
											</tr>
											<?php }
											?>
										</tbody>
									</table>
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div id="btncargue" style="display: none;">
				<!--<a href="cal_reg_putdat1.php?id=<?php echo $id; ?>" target="_blank"><button type="button" class="btn">Actualizar información</button></a>-->
				<!-- Button trigger modal -->
				<?php
				    if($id > 0) {
				?>
        		<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
        		  Actualizar calificaciones
        		</button>
        		<?php 
				    }
        		?>
			</div>
			
			<?php
				//$mysqli1->close();
				echo '<script type="text/javascript">','mr();','</script>';
			?>
			<br/>
		</center>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="myModalLabel">Actualizar calificaciones en registro</h4>
			  </div>
			  <div class="modal-body">
				<label>Esta seguro de actualizar las calificaciones en Registro?
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<!--<button type="button" class="btn btn-primary">Actualizar</button>-->
				<a href="cal_reg_putdat1.php?idq=<?php echo $idq; ?>" ><button type="button" class="btn btn-primary" >Actualizar</button></a>
			  </div>
			</div>
		  </div>
		</div>
	</body>
	
</html>