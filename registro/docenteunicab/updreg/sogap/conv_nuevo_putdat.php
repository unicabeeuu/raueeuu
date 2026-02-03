<?php
	
	require("1cc3s4db.php");
	include "mcript.php"; 
	
	$nomconv=strtoupper(str_replace("_"," ",$_REQUEST['nomconv']));
	$nomcont=strtoupper(str_replace("_"," ",$_REQUEST['nomcont']));
	$increm=strtoupper(str_replace("_"," ",$_REQUEST['increm']));
	$celcont=$_REQUEST['celcont'];
	$emailcont=$_REQUEST['emailcont'];
	$modelo=$_REQUEST['modelo'];
	$pc=$_REQUEST['pc'];
	$pc = $gen_enc($pc);
	$pc = str_replace("+","_",$pc);
	
	$sql="INSERT INTO tbl_cp (convenio, estado, incremento, nombre_contacto, celular, email, modelo, pc) 
	VALUES ('$nomconv','ACTIVO', '$increm', '$nomcont', '$celcont', '$emailcont', '$modelo', '$pc')";
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
			<h1>Nuevo Convenio Creado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Creando Convenio</h1>
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