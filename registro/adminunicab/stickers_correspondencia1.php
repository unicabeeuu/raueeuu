<?php
	require("../docenteunicab/updreg/1cc3s4db.php");
	//header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: no-store");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/adminunicab/stickers_correspondencia1.php?idgra=12&anio=2025
	
	$idgra = $_REQUEST["idgra"];
	$anio = $_REQUEST["anio"];
	//$idest = $_REQUEST["idest"];
	//echo $idgra;
	
	$cadena = "";
	
	$query1 = "SELECT * FROM tbl_stickers_virtuales WHERE grado = $idgra AND a = ".$anio;
	
	//echo $query1;
	
	$cadena = $cadena."<table id='tblstickers' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>DOCUMENTO</td>
	                            <td>NOMBRES</td>
	                            <td>APELLIDOS</td>
	                            <td>GENERAR STICKER</td>
	                        </tr></thead><tbody>";
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['documento']."</td>
                <td>".$row['nombres']."</td>
                <td>".$row['apellidos']."</td>
                <td style='text-align: center;'><input type='checkbox' id='chk".$row['id']."' class='chk' value='".$row['id']."' onchange='marcaridest(this);'></td>
                </tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>