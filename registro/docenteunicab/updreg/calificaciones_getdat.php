<?php
	require("1cc3s4db_m.php");
	include "mcript.php";	
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
	//$query1 = "SELECT ".$dev_enc($campos_cal)."FROM ".$dev_enc($tablas_cal)."WHERE ".$dev_enc($condicion_ar)."ORDER BY ".$dev_enc($ob_cal);
	$query1 = "SELECT DISTINCT u.id, u.lastname, u.firstname, c.shortname, c.id, em.id_materia_ra id_materia, cc.name, eg.id_grado_ra id_grado, 
gi.idnumber Periodo, 
case gi.idnumber when 'P1' then '1' when 'P2' then '2' when 'P3' then '3' when 'P4' then '4' 
when '1PT' then '1' when '2PT' then '2' when '3PT' then '3' when '4PT' then '4' 
when '1TT' then '1' when '2TT' then '2' when '3TT' then '3' when '4TT' then '4' else gi.itemname end as Periodo_RA, 
cast(ifnull(gg.finalgrade, 0) as signed) as Calificación 
FROM mood_user u, mood_role_assignments ra, mood_context ct, mood_role r, mood_course c, mood_course_categories cc, 
mood_equivalence_idgra eg, mood_equivalence_idmat em, mood_grade_items gi, mood_grade_grades gg  
WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id 
AND cc.id = eg.id_category AND c.id = em.id_course AND gi.courseid = c.id AND gi.id = gg.itemid AND gg.userid = u.id 
AND ct.contextlevel = 50 AND ra.roleid = 5 AND cc.id IN (15, 16, 17) AND c.id IN (95, 97, 99) AND gi.itemtype = 'category' 
ORDER BY cc.name, u.lastname, u.firstname, c.shortname, Periodo";
	//echo $query1;
	
	$resultado=$mysqli->query($query1);
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
		<h1>Listado de calificaciones Moodle</h1></center>
		<!--<a href="categorias_form.php">Nueva Categoría</a><br/><br/>-->
		<table border="1px">
			<thead>
			<tr>
				<td><b>Categoría</b></td>
				<td><b>Id Grado</b></td>
				<td><b>Curso</b></td>
				<td><b>Id Materia</b></td>
				<td><b>Id</b></td>
				<td><b>Nombres</b></td>
				<td><b>Apellidos</b></td>
				<td><b>Periodo</b></td>
				<td><b>Id Periodo</b></td>
				<td><b>Calificación</b></td>
			</tr>
			</thead>
			<tbody>
			<?php
				while($row = $resultado->fetch_assoc()){
			?>
			<tr>
				<td><?php echo $row['name'];?></td>
				<td><?php echo $row['id_grado'];?></td>
				<td><?php echo $row['shortname'];?></td>
				<td><?php echo $row['id_materia'];?></td>
				<td><?php echo $row['id'];?></td>
				<td><?php echo $row['firstname'];?></td>
				<td><?php echo $row['lastname'];?></td>
				<td><?php echo $row['Periodo'];?></td>
				<td><?php echo $row['Periodo_RA'];?></td>
				<td><?php echo $row['Calificación'];?></td>
			</tr>
			<?php }
				$resultado->close();
				$mysqli->close();
			?>
			</tbody>
		</table>
		
	</body>
</html>