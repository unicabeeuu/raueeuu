 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta charset="gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../crear-banner.php">
		
		
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
		
		//imagen
		$imagen=$_FILES['imagen']['name'];
		$ruta=$_FILES['imagen']['tmp_name'];
		$tipo_archivo =$_FILES['imagen']['type'];
		$destino="../../../unicab.solutions/images/".$imagen;
		$url = "images/".$_FILES['imagen']['name'];
		copy($ruta, $destino);
		// imagen

		$boton1=$_POST['boton1'];
		$texto1=$_POST['texto1'];
		$boton2=$_POST['boton2'];
		$texto2=$_POST['texto2'];

		try {	
			$sql_banner="INSERT INTO unicab_solutions.tbl_banner (titulo, subtitulo, titulo2, subtitulo2, descripcion, imagen, boton1, texto1, boton2, texto2, estado) 
			VALUES ('".$titulo1."','".$titulo2."','".$subtitulo1."','".$subtitulo2."','".$descripcion."','".$url."','".$boton1."','".$texto1."','".$boton2."','".$texto2."','1')";
			$exe_banner=mysqli_query($conexion,$sql_banner);	
				echo "<script>alert('Banner creado correctamente');</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>