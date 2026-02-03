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
	
	$tipodoc=str_replace("+","_",$_REQUEST['tipodoc']);
	$doc=str_replace("+","_",$_REQUEST['doc']);
	$fexp=str_replace("+","_",$_REQUEST['fexp']);
	$fexp=str_replace("__"," ",$fexp);
	$nom=str_replace("+","_",$_REQUEST['nom']);
	$nom=str_replace("__"," ",$nom);
	$ape=str_replace("+","_",$_REQUEST['ape']);
	$ape=str_replace("__"," ",$ape);
	$email=str_replace("+","_",$_REQUEST['email']);
	$pais=str_replace("+","_",$_REQUEST['pais']);
	$pais=str_replace("__"," ",$pais);
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
	$des=str_replace("__"," ",$des);
	$val=str_replace("+","_",$_REQUEST['val']);
	$mon=str_replace("+","_",$_REQUEST['mon']);
	$fpin=str_replace("+","_",$_REQUEST['fpin']);
	$fpin=str_replace("__"," ",$fpin);
	$estado=str_replace("+","_",$_REQUEST['estado']);
	$estado=str_replace("__"," ",$estado);
	$resp=str_replace("+","_",$_REQUEST['resp']);
	$resp=str_replace("__"," ",$resp);
	$aut=str_replace("+","_",$_REQUEST['aut']);
	$payco=str_replace("+","_",$_REQUEST['payco']);
	$recibo=str_replace("+","_",$_REQUEST['recibo']);
	$pin=str_replace("+","_",$_REQUEST['pin']);
	$codpro=str_replace("+","_",$_REQUEST['codpro']);
	$c4dd4c=$_REQUEST['c4dd4c'];
	$conv=$_REQUEST['conv'];
	$conv=str_replace("__"," ",$conv);
	$ref_pago=$_REQUEST['rp'];
	$cod_ref_pago=$_REQUEST['crp'];
	$scp=$_REQUEST['scp'];
	
	$sqlvi="SELECT t1 FROM tbl_parametros WHERE parametro = 'vi'";
	$resultado1=$mysqli1->query($sqlvi);
	while($row = $resultado1->fetch_assoc()){
		$t1vi = $row['t1'];
	}
	
	$sql="INSERT INTO tbl_transac_reds (tipo_doc, documento, fexpedicion, nombres, apellidos, email, pais, 
	depto, ciudad, tel, cel, dir, f1c, descripcion, v1l, m4n, fpin, 
	estado, respuesta, autorizacion, fecha_upd, ref_payco, recibo, pin, cod_proyecto, c4dv3, c4dd4c, convenio, ref_pago, cod_ref_pago, scp) 
	VALUES ('$tipodoc','$doc','$fexp', '$nom', '$ape', '$email', '$pais', '$depto', '$ciu', '$tel', '$cel', 
	'$dir', '$fac', '$des', '$val', '$mon', '$fpin', '$estado', '$resp', '$aut', '$fecha2', '$payco', '$recibo', '$pin', '$codpro', '$t1vi', '$c4dd4c', 
	'$conv', '$ref_pago', '$cod_ref_pago', '$scp')";
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