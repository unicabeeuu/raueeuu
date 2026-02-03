<?php
	
	require("1cc3s4db.php");
	
	$codref=$_REQUEST['codref'];
	
	$sql="DELETE FROM tbl_pagos WHERE codigo = '$codref'";
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
			<h1>Pago Borrado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Borrando Pago</h1>
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