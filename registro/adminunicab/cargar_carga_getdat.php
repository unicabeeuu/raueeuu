<?php
	//Genera el select de los grados
	require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$cadena = "";
	
	$query1 = "SELECT g.grado, g.id id_gra, m.pensamiento, m.id id_pen, CONCAT(e.nombres, ' ', e.apellidos) tutor, e.id 
        FROM grados g, materias m, tbl_empleados e, carga_profesor cp 
        WHERE cp.id_grado = g.id AND cp.id_materia = m.id AND cp.id_empleado = e.id 
        ORDER BY g.id, m.id";
	//echo $cadena; 
	
	$cadena = $cadena."<table id='tbldatos' class='table table-fixed' border='1px'>
	                        <thead>
	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
	                            <td>GRADO</td>
	                            <td>ID_GRA</td>
	                            <td>PENSAMIENTO</td>
	                            <td>ID_PEN</td>
	                            <td>TUTOR</td>
	                            <td>ID</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    if($row['id_gra']%2 == 0) {
	        $fondo = 'lightgreen';
	    }
	    else {
	        $fondo = 'lightblue';
	    }
	    $cadena = $cadena."<tr bgcolor='".$fondo."'>
            <td>".$row['grado']."</td>
            <td>".$row['id_gra']."</td>
            <td>".$row['pensamiento']."</td>
            <td>".$row['id_pen']."</td>
            <td>".$row['tutor']."</td>
            <td>".$row['id']."</td>
            <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_carga' title='Modificar'
            onclick='enviardat_carga(\"".$row['grado']."\",".$row['id_gra'].",\"".$row['pensamiento'].
            "\",".$row['id_pen'].",\"".$row['tutor']."\",".$row['id'].")'> Modificar</button></td></tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>