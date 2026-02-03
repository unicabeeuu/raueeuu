 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../crear-usuario.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$nombre=$_POST['NombreU'];
		$apellido=$_POST['ApellidoU'];
		$correo=$_POST['CorreoU'];
		$pass=$_POST['PassU'];
		$perfil=$_POST['PerfilU'];

		try {	
			$sql_buscar="SELECT * FROM `administrador` WHERE `Email`='".$correo."'";
			$exe_buscar=mysqli_query($conexion,$sql_buscar);
			if (mysqli_num_rows($exe_buscar)>1) {
				echo "<script>alert('Ya se encuentra un usuario con ese mismo Correo');</script>";
			}else{
				$sql_insert="INSERT INTO `administrador`(`Nombre`, `Apellido`, `Email`, `Password`, `Perfil`) VALUES ('".$nombre."','".$apellido."','".$correo."','".$pass."','".$perfil."')";
				$exe_buscar_insert=mysqli_query($conexion,$sql_insert);
				echo "<script>alert('El usuario fue creado correctamente');</script>";
			}
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>