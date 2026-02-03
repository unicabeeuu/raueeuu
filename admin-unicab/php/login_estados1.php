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
    
    try {
		$usuario=$_POST['email'];
		$password=$_POST['pass'];
		//echo $usuario;
		//echo $password;

		$sql="SELECT * FROM tbl_empleados WHERE email = '".$usuario."' and n_documento = '".$password."' AND estado = 'activo'";
		//echo $sql;
		$petecion=mysqli_query($conexion,$sql);
		$total=mysqli_num_rows($petecion);
		if ($total > 0) {
			while ($row = mysqli_fetch_array($petecion)) {
				$_SESSION['email'] = $usuario;
				$_SESSION['perfil'] = $row['perfil'];
				
				$_SESSION['est_fin'] = $usuario;
				$_SESSION['nombre'] = $row['nombres']." ".$row['apellidos'];
				
				
				//echo "<script>location.href='../../login_registro.php';</script>";
				//se direcciona según el perfil
				if($_SESSION['perfil'] == "AR_AW" || $_SESSION['perfil'] == "FI" || $_SESSION['perfil'] == "SU") {
				    echo "<script>alert('Bienvenido(a) ".$row['nombres']." ".$row['apellidos']."');</script>";
				    echo "<script>location.href='../../../est_fin.php';</script>";
				}
				else {
				    echo "<script>alert('Usuario no autorizado');</script>";
				    echo "<script>location.href='../../../login_estados.php';</script>";
				}
			}
		}else{
			echo "<script>alert('Usuario no encontrado');</script>";
			echo "<script>location.href='../../../login_estados.php'</script>";
		}
	} catch (Exception $e) {
			echo "<script>alert('intentelo más tarde');</script>";
			echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>
