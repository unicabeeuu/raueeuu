<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$com=$_REQUEST['com'];
	$fijo=$_REQUEST['fijo'];
	$iva=$_REQUEST['iva'];
	$reteica=$_REQUEST['reteica'];
	$retencion=$_REQUEST['retencion'];
	
	$sql="UPDATE tbl_incrementos SET comision_epayco = ".$com.", val_fijo_epayco = ".$fijo.", iva_comision_epayco = ".$iva.", reteica_tc = ".$reteica.", 
	retencion_tc = ".$retencion." WHERE id = '$idconv'";	
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
					<h1>Valores Modificados</h1>
			<?php
				}
				else{
			?>
					<h1 style="color:red">Error Modificando Valores</h1>
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