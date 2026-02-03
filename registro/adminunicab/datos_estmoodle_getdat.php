<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db_m.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$nombres = str_replace("_"," ",$_REQUEST['nom_r']);
	$apellidos = str_replace("_"," ",$_REQUEST['ape_r']);
	$nombres = substr($nombres,0,strlen($nombres)-1);
	$apellidos = substr($apellidos,0,strlen($apellidos)-1);
	//echo strlen($nombres);
	
	$cadena = "";
	
	//$query1 = "SELECT * FROM mood_user WHERE firstname like '%$nombres%' AND lastname like '%$apellidos%'";
	$query1 = "SELECT DISTINCT u.id, cc.name, u.lastname, u.firstname, u.city, u.email, u.username  
        FROM mood_role_assignments ra, mood_user u, mood_context ct, mood_role r, mood_course c, mood_course_categories cc 
        WHERE u.id = ra.userid AND ra.contextid = ct.id AND ra.roleid = r.id AND ct.instanceid = c.id AND c.category = cc.id  
        AND ct.contextlevel = 50 AND ra.roleid = 5 AND u.deleted = 0 
        AND cc.name NOT IN ('Psicología y Coordinación','Capacitación','Inducciones') 
        AND u.firstname like '%$nombres%' AND u.lastname like '%$apellidos%'";
	//echo $query1;
	
	$cadena = $cadena."<table id='tbldatos_m' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>USUARIO</td>
	                            <td>NOMBRES</td>
	                            <td>APELLIDOS</td>
	                            <td>GRADO</td>
	                            <td>CORREO</td>
	                        </tr></thead><tbody>";
	//echo $cadena;                      
	
	$resultado=$mysqli->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['username']."</td>
                <td>".$row['firstname']."</td>
                <td>".$row['lastname']."</td>
                <td>".$row['name']."</td>
                <td>".$row['email']."</td></tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>