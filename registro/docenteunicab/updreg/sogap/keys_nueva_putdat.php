<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$pick=$_REQUEST['pick'];
	$ptek=$_REQUEST['ptek'];
	$vi=$_REQUEST['vi'];
	$modelo=$_REQUEST['modelo'];
	
	$sql="INSERT INTO tbl_keys (id_convenio, pic_key, pte_key, vi, modelo) 
	VALUES ($idconv,'$pick', '$ptek', '$vi', '$modelo')";
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
			<h1>Nuevas Keys Creadas</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Creando Keys</h1>
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