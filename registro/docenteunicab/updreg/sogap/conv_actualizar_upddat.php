<?php
	
	require("1cc3s4db.php");
	include "mcript.php";
	
	$nomconv=strtoupper(str_replace("_"," ",$_REQUEST['nomconv']));
	$nomcont=strtoupper(str_replace("_"," ",$_REQUEST['nomcont']));
	$increm=strtoupper(str_replace("_"," ",$_REQUEST['increm']));
	$celcont=$_REQUEST['celcont'];
	$emailcont=$_REQUEST['emailcont'];
	$idconv=$_REQUEST['idconv'];
	$modelo=$_REQUEST['modelo'];
	$pc=$_REQUEST['pc'];
	$pc = $gen_enc($pc);
	$pc = str_replace("+","_",$pc);
	
	$sql="UPDATE tbl_cp SET convenio = '$nomconv', incremento = '$increm', nombre_contacto = '$nomcont', celular = '$celcont', modelo = '$modelo', 
	email = '$emailcont', pc = '$pc' WHERE id = '$idconv'";
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
			<h1>Convenio actualizado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Actualizando Convenio</h1>
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