<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	//Se valida si ya hay transacciones realizadas del paquete Gateway
	$sql0 = "SELECT COUNT(1) ct FROM tbl_gateway WHERE id_convenio = $idconv AND ct_inicial <> ct_actual";
	//echo $sql0;
	
	$resultado0=$mysqli1->query($sql0);
	while($row0 = $resultado0->fetch_assoc()){
		$ct = $row0['ct'];
	}
	//echo $ct;
	
	if($ct > 0) {
	    $sql="DELETE FROM tbl_gateway WHERE id_convenio = -9";
	}
	else {
	    $sql="DELETE FROM tbl_gateway WHERE id_convenio = '$idconv'";
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
			<h1>Gateway Borrada</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Borrando Gateway</h1>
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