<?php
	//Da la posibilidad de ver y programar la actualización por pensamiento y grado
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$msg = $_REQUEST["msg"];
	$pen = $_REQUEST["pen"];
	$gra = $_REQUEST["gra"];
	if($msg == "Programado_OK") {
		$msg = "Proceso promadado de cargue exitoso para ".$pen." ".$gra;
	}
	else {
		$msg = "";
	}
	
	//$query1 = "SELECT pensamiento, grados FROM querys_ra WHERE campos2 != '' AND id > 25";
	$query1 = "SELECT DISTINCT pensamiento FROM querys_ra WHERE id > 25";
	$resultado=$mysqli1->query($query1);
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<title></title>
		<link rel="stylesheet" href="css/reg.css" >
		<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>-->
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script>
		    $(function() {
		        
		    });
		</script>
	</head>
	<body id="bodyadm">
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
									<legend>SELECCIONE PENSAMIENTO Y GRADO A CARGAR</legend>
									<div>
										<table>
											<tbody>
												<tr>
													<td>
														<select id="selpen" name="selpen">
															<option value="NA">Seleccione pensamiento</option>
															<?php
																while($row = $resultado->fetch_assoc()){
															?>
															<option value="<?php echo $row['pensamiento'];?>"><?php echo $row['pensamiento'];?></option>
															<?php }
																$resultado->close();
																$mysqli1->close();
															?>
														</select>
													</td>
													<td>
														<div id="divselgrado">
															<select id="selgra" name="selgra">
														    </select>
														</div>
													</td>
													<td>
														<div id="divmostrar">
														</div>
													</td>
													<td>
														<div id="divupd"></div>
													</td>
												</tr>
											</tbody>
										</table>
										<label id="res"><?php  echo $msg; ?></label>										
									</div>
								</fieldset>							
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
		</center>
	</body>
	
</html>