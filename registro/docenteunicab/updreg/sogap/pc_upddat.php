<?php
	
	require("1cc3s4db.php");
	include "mcript.php";
	
	$idconv=$_REQUEST['idconv'];
	$pc=$_REQUEST['pc'];
	
	$pca=$_REQUEST['pa'];
	$pca = $gen_enc($pca);
	$pca = str_replace("+","_",$pca);
	
	$pcn0=$_REQUEST['pn'];
	$pcn=$_REQUEST['pn'];
	$pcn = $gen_enc($pcn);
	$pcn = str_replace("+","_",$pcn);
	
	//contar si existe pc actual
	$ct = 0;
	$sql0 = "SELECT count(1) ct FROM tbl_cp WHERE id = '$idconv' AND pc = '$pca'";
	$resultado0=$mysqli1->query($sql0);
	while($row0 = $resultado0->fetch_assoc()){
	    $ct=$row0['ct'];
	}
	
	if($ct > 0) {
	    $sql="UPDATE tbl_cp SET pc = '$pcn' WHERE id = '$idconv' AND pc = '$pca'";
    	//echo $sql;
    	$resultado=$mysqli1->query($sql);
	}
	else {
	    header("Location: convadm_getdat.php?selconv=".$idconv."&pc=".$pc."&msg=Error_actualizando_password&msgt=error");
	}
	
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
			<h1>Password actualizado</h1>
			<?php
			    header("Location: convadm_getdat.php?selconv=".$idconv."&pc=".$pcn0."&msg=Password_actualizado&msgt=ok");
				}
				else{
			?>
			<h1 style="color:red">Error actualizando password</h1>
			<p><?php echo"$mysqli1->error" ?></p>
			<?php
			    header("Location: convadm_getdat.php?selconv=".$idconv."&pc=".$pc."&msg=Error_actualizando_password&msgt=error");
				}
				//$resultado->close();
				$mysqli1->close();
			?>
			<!-- <a href="nnegocios_getdat.php">Regresar</a> -->
		</center>
	</body>
</html>