 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../listado-mediadores.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y 脩 EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
		$nombre=$_POST['nombre'];
		$cargo=$_POST['cargo'];
		$profesion=$_POST['profesion'];


		if ($_POST['area'] == "0") {
			$area=$_POST['areaV'];
		}else{
			$area=$_POST['area'];
		}

		if ($_POST['equipo'] == "0") {
			$equipo=$_POST['equipoV'];
		}else{
			$equipo=$_POST['equipo'];
		}

		$descripcion=$_POST['descripcion'];

		// img
		if ($_FILES['foto']['name'] == null) {
			$destino=$_POST['imagenV'];
		}else{
			$imagen=$_FILES['foto']['name'];
			$ruta=$_FILES['foto']['tmp_name'];
			$tipo_archivo =$_FILES['foto']['type'];
			$destino="../../../assets/img/equipo/".$imagen;
			copy($ruta, $destino);
		}
		// img

		$id=$_POST['idMediador'];

		try {
			$sql_actualizar="UPDATE mediadores SET nombre='".$nombre."',`cargo`='".$cargo."',`profesion`='".$profesion."',`area`='".$area."',`equipo`='".$equipo."',`descripcion`='".$descripcion."',`foto`='".$destino."' WHERE id=".$id."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('La noticia fue actualizada correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo m谩s tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
?>