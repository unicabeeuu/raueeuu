<?php
	
	require("1cc3s4db.php");
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	/*if($dia < 10) {
		$dia = "0".$dia;
	}
	if($mes < 10) {
		$mes = "0".$mes;
	}*/
	$fecha2 = $a.$mes.$dia;
	
	$b1nc4=str_replace("+","_",$_REQUEST['b1nc4']);
	$b1nc4=str_replace("__"," ",$b1nc4);
	$c4db1nc4=str_replace("+","_",$_REQUEST['c4db1nc4']);
	$t3p4p2r=str_replace("+","_",$_REQUEST['t3p4p2r']);
	$t3p4d4c=str_replace("+","_",$_REQUEST['t3p4d4c']);
	$d4cp1g4=str_replace("+","_",$_REQUEST['d4cp1g4']);
	$f2xpd4cp1g=str_replace("+","_",$_REQUEST['f2xpd4cp1g']);
	$f2xpd4cp1g=str_replace("__"," ",$f2xpd4cp1g);
	
	$tipodoc=str_replace("+","_",$_REQUEST['tipodoc']);
	$doc=str_replace("+","_",$_REQUEST['doc']);
	$fexp=str_replace("+","_",$_REQUEST['fexp']);
	$nom=str_replace("+","_",$_REQUEST['nom']);
	$nom=str_replace("__"," ",$nom);
	$ape=str_replace("+","_",$_REQUEST['ape']);
	$ape=str_replace("__"," ",$ape);
	$email=str_replace("+","_",$_REQUEST['email']);
	$pais=str_replace("+","_",$_REQUEST['pais']);
	$depto=str_replace("+","_",$_REQUEST['depto']);
	$depto=str_replace("__"," ",$depto);
	$ciu=str_replace("+","_",$_REQUEST['ciu']);
	$ciu=str_replace("__"," ",$ciu);
	$tel=str_replace("+","_",$_REQUEST['tel']);
	$cel=str_replace("+","_",$_REQUEST['cel']);
	$dir=str_replace("+","_",$_REQUEST['dir']);
	$dir=str_replace("__"," ",$dir);
	$fac=str_replace("+","_",$_REQUEST['fac']);
	$fac=str_replace("__"," ",$fac);
	$des=str_replace("+","_",$_REQUEST['des']);
	//echo $des;
	$des=str_replace("__"," ",$des);
	//echo $des;
	$val=str_replace("+","_",$_REQUEST['val']);
	$mon=str_replace("+","_",$_REQUEST['mon']);
	
	$estado=str_replace("+","_",$_REQUEST['estado']);
	$estado=str_replace("__"," ",$estado);
	$resp=str_replace("+","_",$_REQUEST['resp']);
	$resp=str_replace("__"," ",$resp);
	$aut=str_replace("+","_",$_REQUEST['aut']);
	$aut=str_replace("__"," ",$aut);
	$payco=str_replace("+","_",$_REQUEST['payco']);
	$recibo=str_replace("+","_",$_REQUEST['recibo']);
	
	$tr1n3d=str_replace("+","_",$_REQUEST['tr1n3d']);
	$t3ck2d3d=str_replace("+","_",$_REQUEST['t3ck2d3d']);
	$urlb1nc4=str_replace("+","_",$_REQUEST['5rlb1nc4']);
	$fb1n=str_replace("+","_",$_REQUEST['fb1n']);
	$fb1n=str_replace("__"," ",$fb1n);
	
	$c4dd4c=$_REQUEST['c4dd4c'];
	$conv=str_replace("+","_",$_REQUEST['conv']);
	$conv=str_replace("__"," ",$conv);
	$ref_pago=str_replace("+","_",$_REQUEST['rp']);
	$ref_pago=str_replace("__"," ",$ref_pago);
	$cod_ref_pago=$_REQUEST['crp'];
	$scp=$_REQUEST['scp'];
	
	$sqlvi="SELECT t1 FROM tbl_parametros WHERE parametro = 'vi'";
	$resultado1=$mysqli1->query($sqlvi);
	while($row = $resultado1->fetch_assoc()){
		$t1vi = $row['t1'];
	}
	
	$sql="INSERT INTO tbl_transac_pse (b1nc4, c4d_b1nc4, t3p4_p2r, t3p4_d4c, d4c_p1g4, f_2xp_d4cp1g, tipo_doc, documento, fexpedicion, nombres, apellidos, email, pais, 
	depto, ciudad, tel, cel, dir, f1c, descripcion, v1l, m4n, 
	estado, respuesta, autorizacion, fecha_upd, ref_payco, recibo, 
	tr1n3d, t3ck2d3d, 5rlb1nc4, f_b1n, c4dv3, c4dd4c, convenio, ref_pago, cod_ref_pago, scp) 
	VALUES ('$b1nc4', '$c4db1nc4', '$t3p4p2r', '$t3p4d4c', '$d4cp1g4', '$f2xpd4cp1g', '$tipodoc','$doc','$fexp', '$nom', '$ape', '$email', '$pais', 
	'$depto', '$ciu', '$tel', '$cel', '$dir', '$fac', '$des', '$val', '$mon', '$estado', '$resp', '$aut', '$fecha2', '$payco', '$recibo', 
	'$tr1n3d', '$t3ck2d3d', '$urlb1nc4', '$fb1n', '$t1vi', '$c4dd4c', '$conv', '$ref_pago', '$cod_ref_pago', '$scp')";
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
			<h1>Nueva Transacci¨®n Guardada</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Guardando Transacci¨®n</h1>
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