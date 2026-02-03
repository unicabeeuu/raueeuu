<?php
	
	require("1cc3s4db.php");
	
	$idconv=$_REQUEST['idconv'];
	$fecha=$_REQUEST['fecha'];
	$valor=$_REQUEST['valor'];
	$codref=$_REQUEST['codref'];
	$concepto=strtoupper(str_replace("_"," ",$_REQUEST['concepto']));
	$nomconv=$_REQUEST['nomconv'];
	
	$sql="INSERT INTO tbl_pagos (id_convenio, fecha, valor, concepto, codigo) 
	VALUES ($idconv,'$fecha', $valor, '$concepto', '$codref')";
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	
	//$resultado->close();
	//$mysqli->close();
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		
		<style>
		    body {
				width: 100%;
				height: 100%;
				width: 100%;
				height: 100%;
				background-image: url("img/fondo_h_1.png");
				//background-position: 50% 50%;
				background-repeat: no-repeat;
				//background-attachment: fixed;
				
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-ms-background-size: cover;
				 background-size: cover;
			}
			#contenedor, #divenc {
				display: flex;
				justify-content: space-around;
			}
		</style>
	</head>
	<body>
	    <div id="divenc">
			<div>
				<img src="img/logo_ac_.png" width="150px" height="150px"/>
			</div>
			<div>
				<h2>Creación de pagos: <label style="background-color: #f3e4fc; color: blue;"><?php echo $nomconv; ?></label></h2><br/>
			</div>				
		</div>
		<center>
			<?php
				if($resultado > 0){
			?>
			<h1>Nuevo Pago Creado</h1>
			<?php
				}
				else{
			?>
			<h1 style="color:red">Error Creando Pago</h1>
			<p><?php echo"$mysqli1->error" ?></p>
			<?php
				}
				//$resultado->close();
				$mysqli1->close();
			?>
			<!-- <a href="nnegocios_getdat.php">Regresar</a> -->
			<a class="btn btn-primary btn-lg" href="pago_nuevo_form.php?nomconv=<?php echo str_replace('_',' ',$nomconv); ?>&idconv=<?php echo $idconv; ?>" >Volver</a>
		</center>
	</body>
</html>