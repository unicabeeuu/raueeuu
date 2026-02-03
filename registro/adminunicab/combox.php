<?php
	include "php/conexion.php";
	//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
	// @mysql_query("SET NAMES 'utf8'"); 
	//INSERTAMOS EL COMENTARIO
	$id = $_POST['id'];
	$sql="SELECT grados.id, grados.grado, materias.Id AS idMateria, materias.materia, materias.pensamiento FROM grados INNER JOIN (materias INNER JOIN grado_materia ON materias.Id=grado_materia.id_materia) ON grados.id = grado_materia.id_grado where grados.id='".$id."'";

	$rec = mysqli_query($conexion, $sql);

	while ($fila=mysqli_fetch_array($rec)){
		$html.='<option value="'.$fila['idMateria'].'">'.$fila['materia'].'</option>';
	}
	
	echo $html;
?>