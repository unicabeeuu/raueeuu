<?php
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
	$query1 = "SELECT ".$dev_enc($campos_cal_r)."FROM ".$dev_enc($tablas_cal_r);
	//echo $query1;
	
	$resultado=$mysqli1->query($query1);
?>

<html>
	<head>
		<title></title>
	</head>
	<body>
		<center>
		<div id="enc">
			<img src="img/enc1.png" alt="enc1" />
		</div>
		<h1>Listado de calificaciones en Registro</h1></center>
		<!--<a href="categorias_form.php">Nueva Categoría</a><br/><br/>-->
		<table border="1px">
			<thead>
			<tr>
				<td><b>Id</b></td>
				<td><b>Nota</b></td>
				<td><b>Id Periodo</b></td>
				<td><b>Id Materia</b></td>
				<td><b>Id Grado</b></td>
				<td><b>Id Estudiante</b></td>
				<!--<td><b>Nombres</b></td>
				<td><b>Apellidos</b></td>-->
			</tr>
			</thead>
			<tbody>
			<?php
				while($row = $resultado->fetch_assoc()){
			?>
			<tr>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['nota'];?></td>
				<td><?php echo $row['id_periodo'];?></td>
				<td><?php echo $row['id_materia'];?></td>
				<td><?php echo $row['id_grado'];?></td>
				<td><?php echo $row['id_estudiante'];?></td>
			</tr>
			<?php }
				$resultado->close();
				$mysqli1->close();
			?>
			</tbody>
		</table>
		
	</body>
</html>