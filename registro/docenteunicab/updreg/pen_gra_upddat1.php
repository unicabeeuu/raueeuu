<?php	
	require("1cc3s4db.php");
	
	$id=$_REQUEST['id'];
	
	$query="UPDATE querys_ra SET procesar = 1 WHERE id = '$id'";
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
				header("Location: pen_gra_upddat.php");
			}
		?>
		
	</body>
</html>