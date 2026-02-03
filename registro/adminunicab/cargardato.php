<?php
	session_start();	
	include "php/conexion.php";
	//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
	// @mysql_query("SET NAMES 'utf8'"); 
	//INSERTAMOS EL COMENTARIO
	// busca matricula
	$id = $_POST['id_matricula'];
	$sql="SELECT * FROM `matricula` WHERE `idMatricula`=".$id."";
	$rec = mysqli_query($conexion, $sql);
	while ($fila=mysqli_fetch_array($rec)){
		$id_grado=$fila['id_grado'];
	}

	// busca grado
	$sql_grado="SELECT * FROM `grados` WHERE `id`=".$id_grado."";
	$exe_grado=mysqli_query($conexion,$sql_grado);
	while ($row=mysqli_fetch_array($exe_grado)){
		$html.='<option value="'.$row['id'].'">'.$row['id'].'</option>';
	}	
	echo $html;

	// $html.='<option value="'.$fila['idMateria'].'">'.$fila['materia'].'</option>';
	

	// $sql="SELECT grados.id, grados.grado, materias.Id AS idMateria, materias.materia, materias.pensamiento FROM grados INNER JOIN (materias INNER JOIN grado_materia ON materias.Id=grado_materia.id_materia) ON grados.id = grado_materia.id_grado where grados.id='".$id."'";
?>