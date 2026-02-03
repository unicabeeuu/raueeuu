<?php
	//Genera el select de los grados
	session_start();
	require("1cc3s4db.php");
	include "../../adminunicab/php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	$r = $_REQUEST["r"];
	//echo $idgra;
	
	$sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
	
	$cadena = "";
	$ranking = 1;
	
	if($r == 10) {
	    if($idgra == 11 || $idgra == 12) {
	        $query1 = "SELECT cast(SUM(a.nota)/7 as decimal(10,2)) nota, a.id_estudiante, a.nombre 
                FROM 
                (SELECT cast(SUM(n.nota)/4 as decimal(10,2)) nota, COUNT(1) ct, n.id_materia, n.id_grado, n.id_estudiante, 
                CONCAT(e.nombres,' ',e.apellidos) nombre 
                FROM notas n, matricula m, estudiantes e  
                WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = e.id 
                AND m.estado = 'activo' AND n.id_grado = $idgra 
                GROUP BY n.id_materia, n.id_grado, n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) 
                ORDER BY n.id_estudiante) a 
                GROUP BY a.id_estudiante, a.nombre 
                ORDER BY cast(SUM(a.nota)/7 as decimal(10,2)) desc LIMIT 10";
	    }
	    else if($idgra == 17 || $idgra == 18) {
	        $query1 = "SELECT cast(SUM(a.nota)/7 as decimal(10,2)) nota, a.id_estudiante, a.nombre 
                FROM 
                (SELECT cast(SUM(n.nota)/2 as decimal(10,2)) nota, COUNT(1) ct, n.id_materia, n.id_grado, n.id_estudiante, 
                CONCAT(e.nombres,' ',e.apellidos) nombre 
                FROM notas n, matricula m, estudiantes e  
                WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = e.id 
                AND m.estado = 'activo' AND n.id_grado = $idgra 
                GROUP BY n.id_materia, n.id_grado, n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) 
                ORDER BY n.id_estudiante) a 
                GROUP BY a.id_estudiante, a.nombre 
                ORDER BY cast(SUM(a.nota)/7 as decimal(10,2)) desc LIMIT 10";
	    }
	    else {
    	    $query1 = "SELECT cast(SUM(a.nota)/6 as decimal(10,2)) nota, a.id_estudiante, a.nombre 
                FROM 
                (SELECT cast(SUM(n.nota)/4 as decimal(10,2)) nota, COUNT(1) ct, n.id_materia, n.id_grado, n.id_estudiante, 
                CONCAT(e.nombres,' ',e.apellidos) nombre 
                FROM notas n, matricula m, estudiantes e  
                WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = e.id 
                AND m.estado = 'activo' AND n.id_grado = $idgra 
                GROUP BY n.id_materia, n.id_grado, n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) 
                ORDER BY n.id_estudiante) a 
                GROUP BY a.id_estudiante, a.nombre 
                ORDER BY cast(SUM(a.nota)/6 as decimal(10,2)) desc LIMIT 10";
	    }
	}
	else if($r == 999) {
	    if($idgra == 11 || $idgra == 12) {
	        $query1 = "SELECT cast(SUM(a.nota)/7 as decimal(10,2)) nota, a.id_estudiante, a.nombre 
                FROM 
                (SELECT cast(SUM(n.nota)/4 as decimal(10,2)) nota, COUNT(1) ct, n.id_materia, n.id_grado, n.id_estudiante, 
                CONCAT(e.nombres,' ',e.apellidos) nombre 
                FROM notas n, matricula m, estudiantes e  
                WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = e.id 
                AND m.estado = 'activo' AND n.id_grado = $idgra 
                GROUP BY n.id_materia, n.id_grado, n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) 
                ORDER BY n.id_estudiante) a 
                GROUP BY a.id_estudiante, a.nombre 
                ORDER BY cast(SUM(a.nota)/7 as decimal(10,2)) desc";
	    }
	    else if($idgra == 17 || $idgra == 18) {
	        $query1 = "SELECT cast(SUM(a.nota)/7 as decimal(10,2)) nota, a.id_estudiante, a.nombre 
                FROM 
                (SELECT cast(SUM(n.nota)/2 as decimal(10,2)) nota, COUNT(1) ct, n.id_materia, n.id_grado, n.id_estudiante, 
                CONCAT(e.nombres,' ',e.apellidos) nombre 
                FROM notas n, matricula m, estudiantes e  
                WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = e.id 
                AND m.estado = 'activo' AND n.id_grado = $idgra 
                GROUP BY n.id_materia, n.id_grado, n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) 
                ORDER BY n.id_estudiante) a 
                GROUP BY a.id_estudiante, a.nombre 
                ORDER BY cast(SUM(a.nota)/7 as decimal(10,2)) desc";
	    }
	    else {
    	    $query1 = "SELECT cast(SUM(a.nota)/6 as decimal(10,2)) nota, a.id_estudiante, a.nombre 
                FROM 
                (SELECT cast(SUM(n.nota)/4 as decimal(10,2)) nota, COUNT(1) ct, n.id_materia, n.id_grado, n.id_estudiante, 
                CONCAT(e.nombres,' ',e.apellidos) nombre 
                FROM notas n, matricula m, estudiantes e  
                WHERE n.id_estudiante = m.id_estudiante AND n.id_estudiante = e.id 
                AND m.estado = 'activo' AND n.id_grado = $idgra 
                GROUP BY n.id_materia, n.id_grado, n.id_estudiante, CONCAT(e.nombres,' ',e.apellidos) 
                ORDER BY n.id_estudiante) a 
                GROUP BY a.id_estudiante, a.nombre 
                ORDER BY cast(SUM(a.nota)/6 as decimal(10,2)) desc";
	    }
	}
	//echo $query1;
	
	$cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr class='GridViewScrollHeader'>
	                            <td>Ranking</td>
	                            <td>Promedio Total</td>
	                            <td>Id Estudiante</td>
	                            <td>Nombre</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
            <td>".$ranking."</td>
            <td>".$row['nota']."</td>
            <td>".$row['id_estudiante']."</td>
            <td>".$row['nombre']."</td></tr>";
            
        $ranking++;
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>