 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../../docenteunicab/calificaciones.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php
include "conexion.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
// @mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
$total=$_POST['total'];
$total_periodo=$_POST['id_periodo'];
$id_materia=$_POST['id_materia'];
$id_grado=$_POST['id_grado'];

for ($i=1; $i <=$total ; $i++) { 
	for ($j=1; $j <=$total_periodo ; $j++) { 
		$id_estudiante=$_POST['id_estudiante'.$i];		
		$nota=$_POST['nota'.$i."_".$j];
		$buscar="SELECT * FROM notas WHERE id_periodo='".$j."' and id_materia='".$id_materia."' and id_grado='".$id_grado."' and id_estudiante='".$id_estudiante."'";
		$respuesta=mysqli_query($conexion,$buscar);	
		$tot=mysqli_num_rows($respuesta);
		if($tot>0){
			while ($fila=mysqli_fetch_array($respuesta)) {
				$id=$fila['id'];
			}
			$actualizar="UPDATE `notas` SET `nota`=".$nota." WHERE id=".$id.";";
			$exe=mysqli_query($conexion,$actualizar);					
		}else{
			$insertar="INSERT INTO notas(`nota`, `id_periodo`, `id_materia`, `id_grado`, `id_estudiante`) VALUES ('".$nota."','".$j."','".$id_materia."','".$id_grado."','".$id_estudiante."');";
			$exe2=mysqli_query($conexion,$insertar);
		}
	}
}
echo"<script>alert('La información esta siendo almacenada')</script>";
?>