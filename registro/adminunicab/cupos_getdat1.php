<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/cupos_getdat1.php?id_grado_solicitado=3
	
	$id_grado = isset($_REQUEST['id_grado_solicitado']) ? intval($_REQUEST['id_grado_solicitado']) : 0;

	$i = 1;

    $query = "SELECT CONCAT(c.nombres, ' ', c.apellidos) estudiante, c.n_documento, c.acudiente, c.telefono_acudiente, c.email_acudiente, c.id_grado_sistema, g1.grado grado_sistema,
        c.id_grado_solicitado, g2.grado grado_solicitado, c.respuesta_pregunta, c.fecha_solicitud, m.estado, m.fecha_ingreso, m.id idMatricula, m.id_grado, g3.grado gradoactual
        FROM tbl_cupos c, tbl_estudiantes e, tbl_matriculas m, tbl_grados g1, tbl_grados g2, tbl_grados g3,
        (SELECT max(id) idMatricula, id_estudiante FROM `tbl_matriculas` GROUP BY id_estudiante) m1
        WHERE c.n_documento = e.n_documento AND e.id = m.id_estudiante
        AND m.id = m1.idMatricula AND c.id_grado_sistema = g1.id AND c.id_grado_solicitado = g2.id AND m.id_grado = g3.id
        AND c.n_documento != '9397454' AND c.id_grado_solicitado = $id_grado
        ORDER BY m.id";
    //echo $query;

    $cadena = "";
    $cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>Student</td>
	                            <td>Document</td>
	                            <td>Guardian</td>
	                            <td>Guardian Phone</td>
	                            <td>Guardian Email</td>
	                            <td>Answer</td>
	                            <td>System Grade</td>
	                            <td>Requested Grade</td>
	                            <td>Current/Last Grade</td>
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