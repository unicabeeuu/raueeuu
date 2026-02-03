 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../registro-calendario.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$fecha=$_POST['fecha'];
		
		// img
		if ($_FILES['ImagenB']['name'] == null) {
			$destino=$_POST['imagenV'];
		}else{
			$imagen=$_FILES['ImagenB']['name'];
			$ruta=$_FILES['ImagenB']['tmp_name'];
			$tipo_archivo =$_FILES['ImagenB']['type'];
			$destino="../../../calendario/".$imagen;
			copy($ruta, $destino);
		}
		// img

		try {
			$sql_actualizar="UPDATE `calendario` SET `archivo`='".$destino."' WHERE `id`='1'";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('Calendario actualizado correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo m谩s tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>