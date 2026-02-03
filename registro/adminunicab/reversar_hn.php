<?php 
include "php/conexion.php";
$id_estudiante=$_GET['id'];

// buscar numero matricula
$sql_matricula="SELECT * FROM `matricula` WHERE `id_estudiante`=".$id_estudiante." and estado='activo'";

$exe_matricula=mysqli_query($conexion,$sql_matricula);
while ($rowM = mysqli_fetch_array($exe_matricula)) {
	$numero_matricula=$rowM['n_matricula'];
	$id_matricula=$rowM['idMatricula'];
}
//echo $numero_matricula;
// buscar numero matricula
$sql_ejecutar="SELECT DISTINCT estudiantes.id AS id_estudiante, estudiantes.apellidos, estudiantes.nombres, grados.id AS id_grado, grados.grado, materias.Id AS id_materia, materias.materia FROM (grados INNER JOIN (materias INNER JOIN carga_profesor ON materias.Id = carga_profesor.id_materia) ON grados.id = carga_profesor.id_grado) INNER JOIN (estudiantes INNER JOIN notas ON estudiantes.id = notas.id_estudiante) ON grados.id = notas.id_grado where estudiantes.id=".$id_estudiante;
// echo "h ".$sql_ejecutar."<br>";
$ejecutar=mysqli_query($conexion,$sql_ejecutar);

$materiasAprobadas=0;
$materiasReprobadas=0;

$auto=0;
$promedio=0;
$suma=0;
$cont=0;
$contVacio=0;
$contNota=0;
$curso=0;
$array_notas=array();
$array_materia=array();
$contt=0;
while ($row=mysqli_fetch_array($ejecutar)) {
	$gradooo=$row['id_grado'];
	$auto++;
	$sql_notas="sql".$auto;
	$sql_notas="SELECT DISTINCT ROUND(sum(nota),2) AS suma, COUNT(nota) as num_notas, grados.id as id_grado, grados.grado, materias.Id as id_materia, materias.materia, materias.pensamiento, estudiantes.id as id_estudiante, estudiantes.apellidos, estudiantes.nombres, notas.id as id_notas, notas.nota as nota FROM materias INNER JOIN (grados INNER JOIN (estudiantes INNER JOIN notas ON estudiantes.id = notas.id_estudiante) ON grados.id = notas.id_grado) ON materias.Id = notas.id_materia where estudiantes.id=".$id_estudiante." and materias.Id=".$row['id_materia'];

	$exe_notas="exe".$auto;
	$exe_notas=mysqli_query($conexion,$sql_notas);
	while ($fila=mysqli_fetch_array($exe_notas)) {
		$id_estudiante=$fila['id_estudiante'];
		$id_grado=$fila['id_grado'];
		$count=$fila['num_notas'];
		$array_notas[$contt]=array($fila['suma'],$fila['id_materia']);
		
		if (($fila['nota'])==NULL) {
			$contVacio++;
		}else{
			$contNota++;
		}
		$contt++;
	}

}
	if ($contVacio===0 && $contNota===0) {
		echo"<script>alert('El estudiante NO cuenta con notas para este grado')</script>";
		//echo "<script>location.href='../cierre-academico.php'</script>";
	}if ($contVacio>0) {
		echo"<script>alert('El estudiante le faltan ".$contVacio." notas')</script>";
		//echo "<script>location.href='../cierre-academico.php'</script>";
	}
	//echo $gradooo;
	if ($contNota>=1) {
		if ($gradooo>=1 && $gradooo<=10) {
			$curso=9;
		}
		if ($gradooo>=11 && $gradooo<=12) {
			$curso=11;
		}
		if ($gradooo>=13 && $gradooo<=16) {
			$curso=6;
		}
		if ($gradooo>=17 && $gradooo<=18) {
			$curso=7;
		}
		//echo "contNota: ".$contNota;
		//echo "curso: ".$curso;
		if ($contNota===$curso) {
			foreach ($array_notas as $value) {
				$promedio=$value[0]/$count;
				if ($promedio>=3.0) {
					$materiasAprobadas++;
				}else{
					$materiasReprobadas++;
				}

				$sql_historial="INSERT INTO `historial_notas`(`promedio`, `id_estudiante`, `id_grado`, `id_materia`, `id_matricula`) VALUES (".ROUND($promedio,1).",".$id_estudiante.",".$id_grado.",".$value[1].",".$id_matricula.")";
				//echo $sql_historial;
				$exe_historial=mysqli_query($conexion,$sql_historial);

				//echo"<script>alert('El cierre académico del estudiante fue exitoso')</script>";
				//echo "<script>location.href='../cierre-academico.php'</script>";
			}
				if ($materiasReprobadas>=1) {
					$EstadoGrado="reprobado";
				}else{
					$EstadoGrado="aprobado";
				}
				
				$actualizar_matricula="UPDATE `matricula` SET `estado`='inactivo', `EstadoGrado`='".$EstadoGrado."' WHERE id_estudiante=".$id_estudiante." AND `n_matricula`='".$numero_matricula."'";
				$exe_matricula=mysqli_query($conexion,$actualizar_matricula);
			
				$actualizar_estudiante="UPDATE `estudiantes` SET `estado`='inactivo' WHERE id=".$id_estudiante."";
				$exe_estudiante=mysqli_query($conexion,$actualizar_estudiante);	

				//eliminar notas estudiante
				$elimnar_notas="DELETE FROM `notas` WHERE `id_estudiante`=".$id_estudiante."";
				$exe_notas=mysqli_query($conexion,$elimnar_notas);
				echo"<script>alert('El cierre académico del estudiante fue exitoso')</script>";
				echo "<script>location.href='adm1.php'</script>";
		}else{
			echo"<script>alert('Este proceso no se pudo realizar')</script>";
			//echo "<script>location.href='../index.php'</script>";
		}
	}
?>