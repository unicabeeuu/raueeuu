<?php
	
	require("1cc3s4db.php");
	
	$ref_payco=$_REQUEST['ref_payco'];
	$tipo=$_REQUEST['tipo'];
	$estado=$_REQUEST['estado'];
	$respuesta=$_REQUEST['respuesta'];
	
	if($tipo == "TC") {
		$sql="UPDATE tbl_transac_tc SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "EF") {
		$sql="UPDATE tbl_transac_ef SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "BAL") {
		$sql="UPDATE tbl_transac_bal SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "PUNR") {
		$sql="UPDATE tbl_transac_punr SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "REDS") {
		$sql="UPDATE tbl_transac_reds SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "GANA") {
		$sql="UPDATE tbl_transac_gana SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}
	else if($tipo == "PSE") {
		$sql="UPDATE tbl_transac_pse SET estado = '$estado', respuesta = '$respuesta' WHERE ref_payco = '$ref_payco'";
	}	
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	//$resultado = 1;
	
	//$resultado->close();
	//$mysqli->close();
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<title></title>
	</head>
	<body>
		<center>
			<?php
				if($resultado > 0){
			?>
			<h1>Transacci¨®n Actualizada</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Actualizando Transacci¨®n</h1>
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