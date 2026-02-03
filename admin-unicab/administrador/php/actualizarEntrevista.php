 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-entrevistas.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$id_entrevista=$_POST['id_entrevista'];
		$psicologo=$_POST['psicologo'];
		$observaciones=$_POST['observaciones'];

		try {
			$sql_actualizar="UPDATE `entrevistas` SET `psicologo`='".$psicologo."',`observaciones`='".$observaciones."' WHERE id=".$id_entrevista."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);	
				echo "<script>alert('entrevista editada correctamente');</script>";	
		} catch (Exception $e) {
				echo "<script>alert('Este proceso no se pudo realizar, intentelo más tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>