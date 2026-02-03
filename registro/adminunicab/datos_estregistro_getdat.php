<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$nombres = str_replace("_"," ",$_REQUEST['nom_m']);
	$apellidos = str_replace("_"," ",$_REQUEST['ape_m']);
	$nombres = substr($nombres,0,strlen($nombres)-1);
	$apellidos = substr($apellidos,0,strlen($apellidos)-1);
	//echo strlen($nombres);
	
	$cadena = "";
	
	//$query1 = "SELECT * FROM mood_user WHERE firstname like '%$nombres%' AND lastname like '%$apellidos%'";
	$query1 = "SELECT e.id, e.nombres, e.apellidos, e.estado, m.n_matricula, m.estado estado_matricula, m.idmatricula, m.id_grado, m.estadogrado 
        FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND e.nombres like '%$nombres%' AND e.apellidos like '%$apellidos%'";
	//echo $query1;
	
	$cadena = $cadena."<table id='tbldatos_m' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>ID</td>
	                            <td>NOMBRES</td>
	                            <td>APELLIDOS</td>
	                            <td>ESTADO</td>
	                            <td>N_MATRICULA</td>
	                            <td>ESTADO_MATRIC</td>
	                            <td>ID_MATRIC</td>
	                            <td>GRADO</td>
	                            <td>ESTADO_GRADO</td>
	                        </tr></thead><tbody>";
	//echo $cadena;                      
	
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['nombres']."</td>
                <td>".$row['apellidos']."</td>
                <td>".$row['estado']."</td>
                <td>".$row['n_matricula']."</td>
                <td>".$row['estado_matricula']."</td>
                <td>".$row['idmatricula']."</td>
                <td>".$row['id_grado']."</td>
                <td>".$row['estadogrado']."</td></tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>