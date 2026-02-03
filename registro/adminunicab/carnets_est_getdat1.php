<?php
	require("../docenteunicab/updreg/1cc3s4db.php");
	//header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: no-store");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/adminunicab/carnets_est_getdat1.php?idgra=3&anio=2021
	
	$idgra = $_REQUEST["idgra"];
	$anio = $_REQUEST["anio"];
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
	
	$query1 = "SELECT c.*, CONCAT(e.nombres,' ',e.apellidos) nombre, g.grado 
	FROM tbl_carnets c, estudiantes e, grados g 
	WHERE c.id_emp_est = e.id AND c.id_grado = g.id AND c.tipo = 'EST'  
	AND c.id_grado = $idgra AND c.a = '$anio' 
	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";
	//echo $query1;
	
	$cadena = $cadena."<table id='tblcert' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>ID_EST</td>
	                            <td>GRADO</td>
	                            <td>NOMBRE</td>
	                            <td>CARNET</td>
	                            <td>MSG CORREO</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['id_emp_est']."</td>
                <td>".$row['grado']."</td>
                <td>".$row['nombre']."</td>
                <td><a href='".$row['ruta']."?t=".$codigo."' target='_blank'>DESCARGAR</a></td>
                <td>".$row['msg_correo']."</td>
                </tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>