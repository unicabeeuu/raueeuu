<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$cti=$_REQUEST['cti'];
	$cta=$_REQUEST['cta'];
	$fechi=$_REQUEST['fechi'];
	$fechf=$_REQUEST['fechf'];
	$vfijog=$_REQUEST['vfijog'];
	$estg=strtoupper($_REQUEST['estg']);
	
	//Se valida si ya hay transacciones realizadas del paquete Gateway
	$sql0 = "SELECT COUNT(1) ct FROM tbl_gateway WHERE id_convenio = $idconv AND ct_inicial <> ct_actual";
	//echo $sql0;
	
	$resultado0=$mysqli1->query($sql0);
	while($row0 = $resultado0->fetch_assoc()){
		$ct = $row0['ct'];
	}
	//echo $ct;
	
	if($ct > 0) {
		$sql="UPDATE tbl_gateway SET estado = '$estg' WHERE id_convenio = '$idconv'";
	}
	else {
		$sql="UPDATE tbl_gateway SET ct_inicial = $cti, ct_actual = $cta, fecha_ini = '$fechi', fecha_fin = '$fechf', 
		val_fijo_gateway = $vfijog, estado = '$estg' 
		WHERE id_convenio = '$idconv'";
	}
	
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	
	//$resultado->close();
	//$mysqli->close();
?>

<html>
	<head>
		<title></title>
	</head>
	<body>
		<center>
			<?php
				if($resultado > 0){
			?>
			<h1>Keys actualizadas</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Actualizando Keys</h1>
			<p><?php echo"$mysqli1->error" ?></p>
			<?php
				}
				//$resultado->close();
				$mysqli1->close();
			?>
			<!-- <a href="nnegocios_getdat.php">Regresar</a> -->
		</center>
	</body>
</html>