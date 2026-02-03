<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/estudiante_grupo_getdat1.php?id_grado=4&grupo=A
	
	$id_grado = $_REQUEST['id_grado'];
	$grupo = $_REQUEST['grupo'];
	
	$i = 1;

    /*$query = "SELECT e.id, e.nombres, e.apellidos, e.ciudad, g.grado, m.grupo 
    FROM estudiantes e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = 2022 
    AND g.id = $id_grado AND m.grupo = '$grupo' ORDER BY e.apellidos";*/
    $query = "SELECT e.id, e.nombres, e.apellidos, e.ciudad, g.grado, m.grupo 
    FROM estudiantes e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND m.estado = 'activo' AND m.n_matricula like '%2025%' 
    AND g.id = $id_grado AND m.grupo = '$grupo' ORDER BY e.apellidos";
    //echo $query;
    
    $cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>Id</td>
	                            <td>Id_est</td>
	                            <td>Apellidos</td>
	                            <td>Nombres</td>
	                            <td>Ciudad</td>
	                            <td>Grado</td>
	                            <td>Grupo</td>
	                            <td></td>
	                        </tr></thead><tbody>";
	                        
    $resultado1 = $mysqli1->query($query);
    while($row = $resultado1->fetch_assoc()) {
        $cadena = $cadena."<tr>
                <td>".$i."</td>
                <td>".$row['id']."</td>
                <td>".$row['apellidos']."</td>
                <td>".$row['nombres']."</td>
                <td>".$row['ciudad']."</td>
                <td>".$row['grado']."</td>
                <td>".$row['grupo']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-pencil' title='Editar' onclick='enviardat1(".$row['id'].",\"".$row['grupo']."\")'> Editar</button></td></tr>";
        $i++;
    }
    $cadena = $cadena."</tbody></table>";
	echo $cadena;
	
?>