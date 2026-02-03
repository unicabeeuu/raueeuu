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
	
	$doc=strtoupper(str_replace("_"," ",$_REQUEST['doc']));
	$fexp=strtoupper(str_replace("_"," ",$_REQUEST['fexp']));
	$nom=strtoupper(str_replace("_"," ",$_REQUEST['nom']));
	$ape=strtoupper(str_replace("_"," ",$_REQUEST['ape']));
	$email=str_replace("_"," ",$_REQUEST['email']);
	$tel=strtoupper(str_replace("_"," ",$_REQUEST['tel']));
	$cel=strtoupper(str_replace("_"," ",$_REQUEST['cel']));
	$dir=strtoupper(str_replace("_"," ",$_REQUEST['dir']));
	$pass=str_replace("_"," ",$_REQUEST['pass']);
	
	$sql="INSERT INTO tbl_up (nombres, apellidos, cedula, expedida, email, tel, cel, 
	dir, pass) 
	VALUES ('$nom','$ape','$doc', '$fexp', '$email', '$tel', '$cel', '$dir', '$pass')";
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
			<h1>Nuevo Usuario Guardado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Guardando Usuario</h1>
			<p><?php echo"$mysqli->error" ?></p>
			<?php
				}
				//$resultado->close();
				$mysqli1->close();
			?>
			<!-- <a href="nnegocios_getdat.php">Regresar</a> -->
		</center>
	</body>
</html>