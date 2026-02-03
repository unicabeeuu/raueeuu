<?php
	
	require("1cc3s4db.php");
	
	$nomconv=strtoupper(str_replace("_"," ",$_REQUEST['nomconv']));
	
	$sql="DELETE FROM tbl_cp WHERE convenio = '$nomconv'";
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
			<h1>Convenio Borrado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Borrando Convenio</h1>
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