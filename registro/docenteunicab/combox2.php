<?php
	session_start();	
	include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniprofe'])) {
		//$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
		$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
		$res=mysqli_query($conexion,$sql);
		while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$email_institucional = $fila['email'];
		$password = $fila['pc'];
	}
		//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
	// @mysql_query("SET NAMES 'utf8'"); 
	//INSERTAMOS EL COMENTARIO
	$id_grado = $_POST['id_grado'];
	/*$sql="SELECT profesores.id, profesores.apellidos, profesores.nombres, grados.id, grados.grado, materias.Id AS id_grado, materias.materia 
	    FROM materias INNER JOIN (grados INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) 
	    ON grados.id = carga_profesor.id_grado) ON materias.Id = carga_profesor.id_materia where grados.id='".$id_grado."' and profesores.id='".$id."'";*/
	$sql="SELECT e.id, e.apellidos, e.nombres, g.id, g.grado, m.id id_materia, m.materia 
	    FROM materias m, grados g, tbl_empleados e, carga_profesor cp 
	    WHERE e.id = cp.id_empleado AND g.id = cp.id_grado AND m.id = cp.id_materia AND g.id='".$id_grado."' and e.id='".$id."'";

	$rec = mysqli_query($conexion, $sql);
	$html= "<option value='1'>Seleccionar Materia</option>";

	while ($fila=mysqli_fetch_array($rec)){
	 	$html.='<option value="'.$fila['id_grado'].'">'.$fila['materia'].'</option>';
	 }
	
	 echo $html;
	}else{
		echo"<script>alert('El usuario no ha iniciado sesion')</script>";
		echo "<script>location.href='../../login_registro.php'</script>";
	}
?>