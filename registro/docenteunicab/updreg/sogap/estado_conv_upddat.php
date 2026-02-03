<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$estado=str_replace("_"," ",$_REQUEST['estado']);
	
	$sql="UPDATE tbl_cp SET estado = '$estado' WHERE id = '$idconv'";	
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
					<h1>Estado Modificado</h1>
			<?php
				}
				else{
			?>
					<h1 style="color:red">Error Modificando Estado</h1>
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