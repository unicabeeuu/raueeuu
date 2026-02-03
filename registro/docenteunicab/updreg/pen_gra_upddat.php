<?php
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$rxp = 24;
	if(!$_GET['p']) {
		header("Location: pen_gra_upddat.php?p=1");
	}
	
	//$query1 = "SELECT * FROM querys_ra WHERE campos2 != ''";
	$query1 = "SELECT * FROM querys_ra WHERE id > 25 ORDER BY grados, pensamiento";
	$resultado=$mysqli1->query($query1);
	$sel_upd = $mysqli1->affected_rows;
	if($sel_upd > 0) {
		$pag = ceil($sel_upd/$rxp);
		$ini = ($_GET['p']-1)*$rxp;
		$ini1 = $ini + 1;
		$fin = ($_GET['p']-1)*$rxp + $rxp;
		if($fin > $sel_upd) {
			$fin = $sel_upd;
		}
	}
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/reg.css" >
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<style>
		    .btn1, .btn2 {
            	color: blue;
            	background: white;
            	border: 2px solid #0099CC;
            	-webkit-border-radius: 28;
            	-moz-border-radius: 28;
            	border-radius: 28px;
            	font-size: 14px;
            }
            .btn1:hover {
            	background-color: #008CBA;
            	color: white;
            }
            .btn2:hover {
            	background-color: #228B22;
            	color: white;
            	border: 2px solid green;
            }
		</style>
	</head>
	<body>
		<center>
			<div id="enc">
				<img src="img/enc1.png" alt="enc1" />
			</div>
			<div id="divres">
				<table>
					<tbody>
						<tr>
							<td height="30">
							</td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend>PENSAMIENTOS Y GRADOS A CARGAR</legend>
									<div>
									    <?php
										echo '<label>Total Registros &#9658; '.$sel_upd.' ---------------> Registros '.$ini1.' al '.$fin.'</label>';
										?>
										<table border="1px" class="tr">
											<thead>
											<tr>
												<td><b>Pensamiento</b></td>
												<td><b>Grados</b></td>
												<td><b>Actualizado</b></td>
												<td><b>Seleccionados</b></td>
												<td><b>Insertados temp</b></td>
												<td><b>Actualizados</b></td>
												<td><b>Nuevos</b></td>
												<td><b>Procesar</b></td>
												<td><b>No RA (*)</b></td>
												<!--<td><b></b></td>-->
												<td><b></b></td>
											</tr>
											</thead>
											<tbody>
											<?php
											    if($sel_upd > 0) {													
													//$ini = ($_GET['p']-1)*$rxp;
													//$query1_1 = "SELECT * FROM querys_ra WHERE id > 25 ORDER BY grados, pensamiento LIMIT ".$ini.",".$rxp;
													$query1_1 = "SELECT a.*, 
													CASE a.grados WHEN '1' THEN 1 WHEN '2' THEN 2 WHEN '3' THEN 3 WHEN '4' THEN 4 WHEN '5' THEN 5 WHEN '6' THEN 6 WHEN '7' THEN 7 
													WHEN '8' THEN 8 WHEN '9' THEN 9 WHEN '10' THEN 10 WHEN '11' THEN 11 WHEN 'Ciclo I' THEN 12 WHEN 'Ciclo II' THEN 13 
													WHEN 'Ciclo III' THEN 14 WHEN 'Ciclo IV' THEN 15 WHEN 'Ciclo V' THEN 16 WHEN 'Ciclo VI' THEN 17 END id_grado
                                                    FROM querys_ra a WHERE a.id > 25  
                                                    ORDER BY 21, a.pensamiento LIMIT ".$ini.",".$rxp;
													$resultado=$mysqli1->query($query1_1);
												}
												else {
													$resultado=$mysqli1->query($query1);
												}
												
												while($row = $resultado->fetch_assoc()){
											?>
											<tr>
												<td><?php echo $row['pensamiento'];?></td>
												<td><?php echo $row['grados'];?></td>
												<td><?php echo $row['actualizado'];?></td>
												<td><?php echo $row['seleccionados'];?></td>
												<td><?php echo $row['insertados_tem'];?></td>
												<td><?php echo $row['actualizados'];?></td>
												<td><?php echo $row['nuevos'];?></td>
												<td><?php echo $row['procesar'];?></td>
												<td><?php echo $row['est_nue_no_reg'];?></td>
												<!--<td><?php echo '<a href="pen_gra_upddat1.php?idq='.$row['id'].'"><button type="button" class="btn1">Programar</button></a>';?></td>-->
												<td><?php echo '<a href="pen_gra_upddat2.php?idq='.$row['id'].'" target="_blank"><button type="button" class="btn2">Ver registros a procesar</button></a>';?></td>
											</tr>
											<?php }
												$resultado->close();
												$mysqli1->close();
											?>
											</tbody>
										</table>
									</div>
									<label class="msg">* No RA: Registros no insertados por pertenecer a estudiantes que no están en registro</label>
								</fieldset>
								<nav aria-label="...">
								  <ul class="pagination">
									<li class="page-item <?php echo $_GET['p']<=1 ? 'disabled' : '' ?>">
										<a class="page-link" href="pen_gra_upddat.php?p=<?php echo $_GET['p']-1 ?>">&#9668; Anterior</a>
									</li>
									<?php for($i=0; $i<$pag;$i++): ?>
									<li class="page-item <?php echo $_GET['p']==$i+1 ? 'active' : '' ?>">
										<a class="page-link" href="pen_gra_upddat.php?p=<?php echo $i+1 ?>"><?php echo $i+1 ?></a>
									</li>
									<?php endfor ?>
									<!--<li class="page-item active" aria-current="page">
									  <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
									</li>-->
									<li class="page-item <?php echo $_GET['p']>=$pag ? 'disabled' : '' ?>">
										<a class="page-link" href="pen_gra_upddat.php?p=<?php echo $_GET['p']+1 ?>">Siguiente &#9658;</a>
									</li>
								  </ul>
								</nav>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
		</center>
	</body>
	
</html>