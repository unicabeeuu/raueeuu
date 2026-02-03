<?php
	require("../docenteunicab/updreg/1cc3s4db.php");
	//header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: no-store");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/adminunicab/est_pazsalvo_getdat1.php?idgra=3&anio=2021&idest=0
	
	$idgra = $_REQUEST["idgra"];
	$anio = $_REQUEST["anio"];
	$idest = $_REQUEST["idest"];
	//echo $idgra;
	
	$cadena = "";
	
	//Este código se utiliza como parametro de la url del pdf para que el navegador no busque el mismo link ya almacenado en cache 
	$codigo = "";
	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
            "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
	
	for($i = 1; $i <=10; $i++) {
		$ale=mt_rand(1,sizeof($sa1));
		$codigo = $codigo.$sa1[$ale-1];
	}
	
	//Este sería el query a la tabla de paz y salvos tbl_pazsalvos
	/*$query1 = "SELECT c.*, CONCAT(e.nombres,' ',e.apellidos) nombre, g.grado 
	FROM tbl_carnets c, estudiantes e, grados g 
	WHERE c.id_emp_est = e.id AND c.id_grado = g.id AND c.tipo = 'EST'  
	AND c.id_grado = $idgra AND c.a = '$anio' 
	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";*/
	
	if($idest != 0) {
	    /*$query1 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, g.grado, m.estado 
    	FROM estudiantes e, grados g, matricula m  
    	WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    	AND m.id_grado = $idgra AND e.id = $idest AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND date_format(m.fecha_ingreso, '%Y') = $anio 
    	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";*/
    	$query1 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, g.grado, m.estado 
    	FROM estudiantes e, grados g, matricula m  
    	WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    	AND m.id_grado = $idgra AND e.id = $idest AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND m.n_matricula like '%".$anio."%' 
    	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";
	}
	else {
	    /*$query1 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, g.grado, m.estado 
    	FROM estudiantes e, grados g, matricula m  
    	WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    	AND m.id_grado = $idgra AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND date_format(m.fecha_ingreso, '%Y') = $anio 
    	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";*/
    	$query1 = "SELECT e.id, CONCAT(e.nombres,' ',e.apellidos) nombre, g.grado, m.estado 
    	FROM estudiantes e, grados g, matricula m  
    	WHERE e.id = m.id_estudiante AND m.id_grado = g.id 
    	AND m.id_grado = $idgra AND m.estado IN ('aprobado', 'reprobado', 'retirado') AND m.n_matricula like '%".$anio."%' 
    	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";
	}
	
	//echo $query1;
	
	$cadena = $cadena."<table id='tblcert' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>ID_EST</td>
	                            <td>GRADO</td>
	                            <td>NOMBRE</td>
	                            <td>ESTADO</td>
	                            <td>ACTIVAR PAZ Y SALVO</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['grado']."</td>
                <td>".$row['nombre']."</td>
                <td>".$row['estado']."</td>
                <td style='text-align: center;'><input type='checkbox' id='chk".$row['id']."' class='chk' value='".$row['id']."' onchange='marcaridest(this.value);'></td>
                </tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>