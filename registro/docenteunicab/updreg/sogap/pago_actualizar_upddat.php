<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$fecha=$_REQUEST['fecha'];
	$valor=$_REQUEST['valor'];
	$codref=$_REQUEST['codref'];
	$concepto=strtoupper(str_replace("_"," ",$_REQUEST['concepto']));
	
	$sql="UPDATE tbl_pagos SET fecha = '$fecha', valor = $valor, concepto = '$concepto' 
	WHERE codigo = '$codref'";
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
			<h1>Pago actualizado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Actualizando Pago</h1>
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