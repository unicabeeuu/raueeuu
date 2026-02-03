<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/cupos_getdat1.php?id_grado_solicitado=3
	
	$id_grado = $_REQUEST['id_grado_solicitado'];
	
	$i = 1;

    $query = "SELECT CONCAT(c.nombres, ' ', c.apellidos) estudiante, c.n_documento, c.acudiente, c.telefono_acudiente, c.email_acudiente, c.id_grado_sistema, g1.grado grado_sistema, 
        c.id_grado_solicitado, g2.grado grado_solicitado, c.respuesta_pregunta, c.fecha_solicitud, m.estado, m.fecha_ingreso, m.idMatricula, m.id_grado, g3.grado gradoactual  
        FROM tbl_cupos c, estudiantes e, matricula m, grados g1, grados g2, grados g3, 
        (SELECT max(idMatricula) idMatricula, id_estudiante FROM `matricula` GROUP BY id_estudiante) m1 
        WHERE c.n_documento = e.n_documento AND e.id = m.id_estudiante 
        AND m.idMatricula = m1.idMatricula AND c.id_grado_sistema = g1.id AND c.id_grado_solicitado = g2.id AND m.id_grado = g3.id 
        AND c.n_documento != '9397454' AND c.id_grado_solicitado = $id_grado 
        ORDER BY m.idMatricula";
    //echo $query;
    
    $cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>Estudiante</td>
	                            <td>Documento</td>
	                            <td>Acudiente</td>
	                            <td>Tel. Acud</td>
	                            <td>Email Acud</td>
	                            <td>Respuesta</td>
	                            <td>Grado Sistema</td>
	                            <td>Grado Solicitado</td>
	                            <td>Grado Actual/Ultimo</td>
	                        </tr></thead><tbody>";
	                        
    $resultado1 = $mysqli1->query($query);
    while($row = $resultado1->fetch_assoc()) {
        $cadena = $cadena."<tr>
                <td>".$row['estudiante']."</td>
                <td>".$row['n_documento']."</td>
                <td>".$row['acudiente']."</td>
                <td>".$row['telefono_acudiente']."</td>
                <td>".$row['email_acudiente']."</td>
                <td>".$row['respuesta_pregunta']."</td>
                <td>".$row['grado_sistema']."</td>
                <td>".$row['grado_solicitado']."</td>
                <td>".$row['gradoactual']."</td></tr>";
        $i++;
    }
    $cadena = $cadena."</tbody></table>";
	echo $cadena;
	
?>