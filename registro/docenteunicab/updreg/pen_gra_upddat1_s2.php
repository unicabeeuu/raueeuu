<?php
	//Programa el cargue para un pensamiento y un grado
	require("1cc3s4db.php");
	
	$pen = $_REQUEST["pen"];
	$gra = $_REQUEST["gra"];
	
	$query="UPDATE querys_ra SET procesar = 1 WHERE pensamiento = '$pen' AND grados = '$gra'";
	$resultado=$mysqli1->query($query);
	
?>

<html>
	<head>
		<title></title>		
	</head>
	<body>
		<?php
			if($resultado == 1){
				//require("mail_pass.php?idneg=".$idneg."&npass=".$pass);
				header("Location: pen_gra_upddat_s.php?msg=Programado_OK&pen=".$pen."&gra=".$gra);
			}
		?>
		
	</body>
</html>