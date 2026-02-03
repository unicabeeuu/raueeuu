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

		//Se valida si el usuario existe
		$sql0 = "SELECT COUNT(1) ct FROM tbl_empleados WHERE email = '".$usuario."' and pc = '".$gen_enc($password)."' AND estado = 'activo'";
		//echo $sql0;
		$petecion0 = mysqli_query($conexion,$sql0);
		while ($row0 = mysqli_fetch_array($petecion0)) {
			$ct = $row0['ct'];
		}
		//echo "ct: ".$ct;
		
		$sql="SELECT * FROM tbl_empleados WHERE email = '".$usuario."' and pc = '".$gen_enc($password)."' AND estado = 'activo'";
		//echo $sql;
		$petecion=mysqli_query($conexion,$sql);
		$total=mysqli_num_rows($petecion);
		//echo "total: ".$total;
		if ($total > 0) {
		//if ($ct > 0) {
			while ($row = mysqli_fetch_array($petecion)) {
				$_SESSION['email'] = $usuario;
				$_SESSION['perfil'] = $row['perfil'];
				
				$_SESSION['uniprofe'] = $usuario;
				$_SESSION['unisuper'] = $usuario;
				$_SESSION['admin_unicab'] = $usuario;
				$_SESSION['nombre'] = $row['nombres']." ".$row['apellidos'];
				
				echo "<script>alert('Bienvenido(a) ".$row['nombres']." ".$row['apellidos']."');</script>";
				//echo "<script>location.href='../../login_registro.php';</script>";
				//se direcciona según el perfil
				if($_SESSION['perfil'] == "PS") {
				    echo "<script>location.href='../../admin-unicab/administrador/index.php';</script>";
				}
				else if($_SESSION['perfil'] == "FI") {
				    echo "<script>location.href='../../admin-unicab/administrador/index.php';</script>";
				}
				else if($_SESSION['perfil'] == "NA") {
				    echo "<script>location.href='../../login_registro.php';</script>";
				}
				else if($_SESSION['perfil'] == "TU") {
				    echo "<script>location.href='../../registro/docenteunicab/index.php';</script>";
				}
				else if($_SESSION['perfil'] == "AR") {
				    echo "<script>location.href='../../registro/adminunicab/index.php';</script>";
				}
				else if($_SESSION['perfil'] == "AR1") {
				    echo "<script>location.href='../../registro/adminunicab/index.php';</script>";
				}
				else if($_SESSION['perfil'] == "SU") {
				    //echo "<script>location.href='../../registro/docenteunicab/index.php';</script>";
				    echo "<script>location.href='sistema_seldat.php?u=$usuario';</script>";
				}
				else if($_SESSION['perfil'] == "ST_PU") {
				    //echo "<script>location.href='../../admin-unicab/administrador/index.php';</script>";
				    echo "<script>location.href='sistema_seldat.php';</script>";
				}
				else if($_SESSION['perfil'] == "AR_AW") {
				    echo "<script>location.href='sistema_seldat.php';</script>";
				}
				else if($_SESSION['perfil'] == "TU_AR_AW") {
				    echo "<script>location.href='sistema_seldat.php';</script>";
				}
				else if($_SESSION['perfil'] == "TU_AW") {
				    echo "<script>location.href='sistema_seldat.php';</script>";
				}
				else if($_SESSION['perfil'] == "ARCH") {
				    echo "<script>location.href='../../registro/adminunicab/index.php';</script>";
				}
				else if($_SESSION['perfil'] == "PR") {
				    echo "<script>location.href='../../registro/docenteunicab/index.php';</script>";
				}
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
