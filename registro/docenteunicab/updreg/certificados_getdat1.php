<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	//header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: no-store");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$idgra = $_REQUEST["idgra"];
	$anio = $_REQUEST["anio"];
	//echo $idgra;
	
	$cadena = "";
	
	//Este código se utiliza como parametro de la url del pdf para que el navegador no busque el mismo link ya almacenado en cache 
	//ejemplo https://unicab.org/registro/docenteunicab/updreg/certificados/2020/Noveno/cn_Noveno_ANA_SOFIA_CHAVEZ_PUERTA_2020.pdf?t=".$codigo
	$codigo = "";
	$sa1 = ["q","a","1","z","x","2","s","w","3","p","l","4","m","k","5","o","e","6",
            "d","c","7","i","j","8","n","r","9","f","v","0","u","h","b","t","g"];
	
	for($i = 1; $i <=10; $i++) {
		$ale=mt_rand(1,sizeof($sa1));
		$codigo = $codigo.$sa1[$ale-1];
	}
	
	/*$query1 = "SELECT c.*, CONCAT(e.nombres,' ',e.apellidos) nombre 
	FROM certificado c, estudiantes e, matricula m 
	WHERE c.id_estudiante = e.id AND c.numero1 is not null AND e.id = m.id_estudiante 
	AND c.id_grado = $idgra AND m.estado = 'activo' AND m.id_grado = $idgra";*/
	
	/*$query1 = "SELECT c.*, CONCAT(e.nombres,' ',e.apellidos) nombre 
	FROM certificado c, estudiantes e, matricula m 
	WHERE c.id_estudiante = e.id AND c.numero1 is not null AND e.id = m.id_estudiante 
	AND c.id_grado = $idgra AND m.id_grado = $idgra AND Date_format(c.fecha_expedicion,'%Y') = '$anio' 
	AND substring(c.numero, 1, 2) = 'CN' 
	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";*/
	
	$query1 = "SELECT c.*, CONCAT(e.nombres,' ',e.apellidos) nombre 
	FROM certificado c, estudiantes e 
	WHERE c.id_estudiante = e.id AND c.numero1 is not null  
	AND c.id_grado = $idgra AND Date_format(c.fecha_expedicion,'%Y') = '$anio' 
	AND substring(c.numero, 1, 2) = 'CN' 
	ORDER BY CONCAT(e.nombres,' ',e.apellidos)";
	//echo $query1;
	
	$cadena = $cadena."<table id='tblcert' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>NUMERO</td>
	                            <td>ID_EST</td>
	                            <td>ID_GRA</td>
	                            <td>CERTIFICADO DE NOTAS</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['numero']."</td>
                <td>".$row['id_estudiante']."</td>
                <td>".$row['id_grado']."</td>
                <td><a href='".$row['ruta']."?t=".$codigo."' target='_blank'>".$row['nombre']."</a></td>
                </tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>