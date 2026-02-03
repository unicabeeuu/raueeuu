<?php
	require("1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	$idpen = $_REQUEST["idpen"];
	//echo $idgra;
	//echo $idpen;
	
	$cadena = "";
	
	$query1 = "SELECT DISTINCT cc.name, cc.id id_grado, c.shortname, c.id id_pen, gi.idnumber, gi.calculation, gi.id 
        FROM mood_course c, mood_course_categories cc, mood_grade_items gi, mood_grade_grades gg, mood_equivalence_per me  
        WHERE c.category = cc.id AND gi.courseid = c.id AND gi.id = gg.itemid AND gi.id = me.id_act 
        ORDER BY cc.name, c.shortname";
	
	$cadena = $cadena."<table id='tblformula' class='table' border='1px'>
	                        <thead>
	                        <tr class='GridViewScrollHeader'>
	                            <td>Grado</td>
	                            <td>Id_gra</td>
	                            <td>Pensamiento</td>
	                            <td>Id_pen</td>
	                            <td>Idnumber</td>
	                            <td>Id_act</td>
	                            <td>Calculation</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr class='GridviewScrollItem'>
            <td>".$row['name']."</td>
            <td>".$row['id_grado']."</td>
            <td>".$row['shortname']."</td>
            <td>".$row['id_pen']."</td>
            <td>".$row['idnumber']."</td>
            <td>".$row['id']."</td>
            <td>".$row['calculation']."</td>
            <td>...</td></tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>