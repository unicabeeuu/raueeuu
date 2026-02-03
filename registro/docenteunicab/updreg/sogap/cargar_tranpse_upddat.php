<?php
	
	require("1cc3s4db.php");
	
	$fac=str_replace("+","_",$_REQUEST['f1c']);
	$fac=str_replace("__"," ",$fac);
	$tr1n3d=str_replace("+","_",$_REQUEST['tr1n3d']);
	$t3ck2d3d=str_replace("+","_",$_REQUEST['t3ck2d3d']);
	$recibo=str_replace("+","_",$_REQUEST['recibo']);
	$resp=str_replace("+","_",$_REQUEST['resp']);
	$resp=str_replace("__"," ",$resp);
	$estado=str_replace("+","_",$_REQUEST['estado']);
	$estado=str_replace("__"," ",$estado);
	$aut=str_replace("+","_",$_REQUEST['aut']);
	$fb1n=str_replace("+","_",$_REQUEST['fb1n']);
	$fb1n=str_replace("__"," ",$fb1n);
	$c4dd4c=$_REQUEST['c4dd4c'];
	$d4cp1g4=str_replace("+","_",$_REQUEST['d4cp1g4']);
	$conv=$_REQUEST['conv'];
	$conv=str_replace("__"," ",$conv);
	
	//Se actualiza la cantidad de trasaccione efectivas en gateway si aplica
	//Se busca el id del convenio
	$sqlidconv = "SELECT id FROM tbl_cp WHERE convenio = '$conv'";
	$resultadoidconv=$mysqli1->query($sqlidconv);
	while($rowidconv = $resultadoidconv->fetch_assoc()){
		$idconv = $rowidconv['id'];
	}
	if(strtoupper($estado) == "ACEPTADA") {
	    $sqlgaw = "UPDATE tbl_gateway SET ct_actual = ct_actual - 1 WHERE id_convenio = $idconv AND estado = 'ACTIVO'";
	    $resultadogaw=$mysqli1->query($sqlgaw);
	}
	
	/*$sql="INSERT INTO tbl_transac_pse (b1nc4, c4d_b1nc4, t3p4_p2r, t3p4_d4c, d4c_p1g4, f_2xp_d4cp1g, tipo_doc, documento, fexpedicion, nombres, apellidos, email, pais, 
	depto, ciudad, tel, cel, dir, f1c, descripcion, v1l, m4n, 
	estado, respuesta, autorizacion, fecha_upd, ref_payco, recibo, 
	tr1n3d, t3ck2d3d, 5rlb1nc4, f_b1n, c4dv3, c4dd4c, convenio, ref_pago, cod_ref_pago) 
	VALUES ('$b1nc4', '$c4db1nc4', '$t3p4p2r', '$t3p4d4c', '$d4cp1g4', '$f2xpd4cp1g', '$tipodoc','$doc','$fexp', '$nom', '$ape', '$email', '$pais', 
	'$depto', '$ciu', '$tel', '$cel', '$dir', '$fac', '$des', '$val', '$mon', '$estado', '$resp', '$aut', '$fecha2', '$payco', '$recibo', 
	'$tr1n3d', '$t3ck2d3d', '$urlb1nc4', '$fb1n', '$t1vi', '$c4dd4c', '$conv', '$ref_pago', '$cod_ref_pago')";*/
	
	$sql="UPDATE tbl_transac_pse SET recibo = '$recibo', respuesta = '$resp', estado = '$estado', autorizacion = '$aut', f_b1n = '$fb1n' 
	WHERE f1c = '$fac' AND tr1n3d = '$tr1n3d' AND t3ck2d3d = '$t3ck2d3d' AND c4dd4c = '$c4dd4c' AND d4c_p1g4 = '$d4cp1g4'";
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	//$resultado = 1;
	
	//$resultado->close();
	//$mysqli->close();
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
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