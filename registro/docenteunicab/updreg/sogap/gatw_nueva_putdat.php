<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$cti=$_REQUEST['cti'];
	$cta=$_REQUEST['cta'];
	$fechi=$_REQUEST['fechi'];
	$fechf=$_REQUEST['fechf'];
	$vfijog=$_REQUEST['vfijog'];
	$estg=strtoupper($_REQUEST['estg']);
	
	$sql="INSERT INTO tbl_gateway (id_convenio, ct_inicial, ct_actual, fecha_ini, fecha_fin, val_fijo_gateway, estado) 
	VALUES ($idconv, $cti, $cta, '$fechi', '$fechf', $vfijog, '$estg')";
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
			<h1>Nueva Gateway Creada</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Creando Gateway</h1>
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