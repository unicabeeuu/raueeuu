 <html>
 <head>
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>
 </html>
<?php
session_start();
include "conexion.php";
include "mcript.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
//@mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
	try {
		/*$usuario=addslashes($_POST['email']);
		$password=addslashes(quotemeta($_POST['pass']));*/
		$usuario=$_POST['email'];
		$password=$_POST['pass'];
		$password = $gen_enc($password);

		//$sql="SELECT * FROM `administrador` WHERE `Email`='".$usuario."' and `Password`='".$password."'";
		$sql="SELECT * FROM `tbl_empleados` WHERE `email`='".$usuario."' and `pc`='".$password."' AND perfil NOT IN ('AR','NA','TU')";
		
		$petecion=mysqli_query($conexion,$sql);
		$total=mysqli_num_rows($petecion);
		if ($total>0) {
			while ($rowAdmin = mysqli_fetch_array($petecion)) {
				$perfil=$rowAdmin['perfil'];
				$_SESSION['admin_unicab']= $usuario;
				$_SESSION['nombre'] = $rowAdmin['nombres']." ".$rowAdmin['apellidos'];
				//echo "<script>alert('Bienvenido ".$perfil."');</script>";
				echo "<script>alert('Bienvenido ".$_SESSION['nombre']."');</script>";
				echo "<script>location.href='../administrador/index.php';</script>";
			}
		}else{
			echo "<script>alert('Usuario no encontrado');</script>";
			echo "<script>location.href='../../../login_registro.php'</script>";
		}
	} catch (Exception $e) {
			echo "<script>alert('intentelo más tarde');</script>";
			echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>
