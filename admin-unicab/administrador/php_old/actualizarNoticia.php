 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-noticias.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$titulo=$_POST['TituloN'];
		$descripcion=$_POST['DescripcionN'];

		// img
		if ($_FILES['ImagenN']['name'] == null) {
			$destino=$_POST['ImagenActual'];
		}else{
			$imagen=$_FILES['ImagenN']['name'];
			$ruta=$_FILES['ImagenN']['tmp_name'];
			$tipo_archivo =$_FILES['ImagenN']['type'];
			$destino="../../../assets/img/imgnoticias/".$imagen;
			copy($ruta, $destino);
		}
		// img

		if ($_POST['CategoriaN'] == "") {
			$categoria=$_POST['CategoriaActual'];
		}else{
			$categoria=$_POST['CategoriaN'];
		}

		$fuente=$_POST['FuenteN'];
		$idNoticia=$_POST['IdNoticia'];

		try {
			$sql_actualizar="UPDATE `noticia` SET `TituloN`='".$titulo."', `DescripcionN`='".$descripcion."', `ImagenN`='".$destino."', `CategoriaN`='".$categoria."', `FuenteN`='".$fuente."' WHERE IdNoticia=".$idNoticia."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('La noticia fue actualizada correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo más tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>