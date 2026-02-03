 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-blog.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$titulo=$_POST['TituloB'];
		$descripcion=$_POST['DescripcionB'];

		// img
		if ($_FILES['ImagenB']['name'] == null) {
			$destino=$_POST['ImagenActual'];
		}else{
			$imagen=$_FILES['ImagenB']['name'];
			$ruta=$_FILES['ImagenB']['tmp_name'];
			$tipo_archivo =$_FILES['ImagenB']['type'];
			// $destino="../../../assets/img/img-blog/".$imagen;
			$destino="assets/img/imgblog/".$imagen;
			copy($ruta, $destino);
		}
		// img

		if ($_POST['CategoriaB'] == "") {
			$categoria=$_POST['CategoriaActual'];
		}else{
			$categoria=$_POST['CategoriaB'];
		}

		$idBlog=$_POST['IdBlog'];


		try {
			$sql_actualizar="UPDATE `blog` SET `TituloB`='".$titulo."',`DescripcionB`='".$descripcion."',`ImagenB`='".$destino."',`CategoriaB`='".$categoria."' WHERE Idblog=".$idBlog."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('El Post fue actualizado correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo m谩s tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>