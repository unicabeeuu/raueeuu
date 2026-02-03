 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-usuarios.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$nombre=$_POST['NombreU'];
		$apellido=$_POST['ApellidoU'];
		$correo=$_POST['CorreoU'];
		$id=$_POST['IdAdministrador'];

		// var_dump($_POST['PerfilNuevo']);

		if ($_POST['PerfilNuevo'] == "") {
			$perfil=$_POST['PerfilActual'];
		}else{
			$perfil=$_POST['PerfilNuevo'];
		}

		if ($_POST['PassU'] !== null) {
			$pass=$_POST['PassU'];
		}else{
			$pass= NULL;
		}

		try {
			if ($pass==NULL) {
				$sql_update="UPDATE `administrador` SET `Nombre`='".$nombre."',`Apellido`='".$apellido."',`Email`='".$correo."',`Perfil`='".$perfil."' WHERE IdAdministrador=".$id."";
			}else{
				$sql_update="UPDATE `administrador` SET `Nombre`='".$nombre."',`Apellido`='".$apellido."',`Email`='".$correo."',`Password`='".$pass."',`Perfil`='".$perfil."' WHERE `IdAdministrador`=".$id."";
			}
			$exe_update=mysqli_query($conexion,$sql_update);
			echo "<script>alert('Usuario actualizado correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo más tarde');</script>";	
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>