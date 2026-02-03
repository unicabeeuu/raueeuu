 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-eventos.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$nombre=$_POST['NombreE'];
		$descripcion=$_POST['DescripcionE'];

		if ($_POST['FechaE']==0) {
			$fecha=$_POST['FechaActual'];
		}else{
			$fecha=$_POST['FechaE'];
		}

		$hora=$_POST['HoraE'];
		$lugar=$_POST['LugarE'];

		// img
		if ($_FILES['ImagenE']['name'] == null) {
			$destino=$_POST['ImagenActual'];
		}else{
			$imagen=$_FILES['ImagenE']['name'];
			$ruta=$_FILES['ImagenE']['tmp_name'];
			$tipo_archivo =$_FILES['ImagenE']['type'];
			$destino="../../../assets/img/eventos/".$imagen;
			copy($ruta, $destino);
		}
		// img

		$link=$_POST['LinkE'];
	 	$idEvento=$_POST['IdEvento'];

		try {
			$sql_actualizar="UPDATE `evento` SET `NombreE`='".$nombre."', `DescripcionE`='".$descripcion."', `FechaE`='".$fecha."', `HoraE`='".$hora."', `LugarE`='".$lugar."', `ImagenE`='".$destino."', `LinkE`='".$link."' WHERE IdEvento=".$idEvento."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('Los datos del evento fueron actualizados correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo m谩s tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>