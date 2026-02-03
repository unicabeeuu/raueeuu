 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])){
 ?>
<html>
	<head><meta charset="gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-baner_us.php">
		
		
	</head>
</html>
<?php
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO

		$titulo1=$_POST['titulo1'];
		$titulo2=$_POST['titulo2'];
		$subtitulo1=$_POST['subtitulo1'];
		$subtitulo2=$_POST['subtitulo2'];
		$descripcion=$_POST['descripcion'];	
		$estado=$_POST['estado'];

		// img
		if ($_FILES['ImagenN']['name'] == null) {
			$url=$_POST['imagenV'];
		}else{
			$imagen=$_FILES['ImagenN']['name'];
			$ruta=$_FILES['ImagenN']['tmp_name'];
			$tipo_archivo =$_FILES['ImagenN']['type'];
			//$destino="../../../assets/img/slider/".$imagen;
			$destino="../../../unicab.solutions/images/".$imagen;
		    $url = "images/".$_FILES['imagenN']['name'];
			copy($ruta, $destino);
		}

		$boton1=$_POST['boton1'];
		$texto1=$_POST['texto1'];
		$boton2=$_POST['boton2'];
		$texto2=$_POST['texto2'];


		$idBanner=$_POST['idBanner'];

		try {
			$sql_actualizar="UPDATE unicab_solutions.tbl_banner 
			    SET titulo='".$titulo1."', subtitulo='".$titulo2."', titulo2='".$subtitulo1."', subtitulo2='".$subtitulo2."', descripcion='".$descripcion."', 
			    imagen='".$url."', boton1='".$boton1."', texto1='".$texto1."', boton2='".$boton2."', texto2='".$texto2."', estado='".$estado."'  
			    WHERE `id`=".$idBanner."";
			$exe_actualizar=mysqli_query($conexion,$sql_actualizar);
			echo "<script>alert('El banner fue actualizado correctamente');</script>";	
		} catch (Exception $e) {
			echo "<script>alert('Este proceso no se pudo realizar, intentelo más tarde');</script>";	
		}

	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>