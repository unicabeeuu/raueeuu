<?php
	//Da la posibilidad de ver y programar la actualización por pensamiento y grado
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/reg.css" >
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script>
		    $(function() {
		        //alert("hola");
		    });
		</script>
	</head>
	<body id="bodyadm">
		<center>
			<div id="enc">
				<img src="img/enc1.png" alt="enc1" />
			</div>
			<div id="divres">
				<fieldset>
					<legend>INGRESE LA CONSULTA PERSONALIZADA A CARGAR</legend>
					<form action="pen_gra_upddat2_custom.php" target="_blank">
						<textarea id="txtquery" name="txtquery" minlength="50" maxlength="2000" placeholder="Ingrese la consulta" required></textarea></br></br>
						<input type='submit' class='btn1' value="Ver registros a procesar" />
					</form>
				</fieldset>
			</div>
			<br/>
		</center>
	</body>
	
</html>