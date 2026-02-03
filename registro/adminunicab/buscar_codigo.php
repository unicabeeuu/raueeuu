<?php
	//Genera el select de los grados
	//require("1cc3s4db.php");
	include "php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	$identif = $_POST["identif"];
	$cadena = "";
	
	$query1 = "SELECT * FROM tbl_cod_entrevista WHERE identificacion = '$identif'";
	$cadena = $cadena."<table class='table table-hover' border='1' bordercolor='#e0e0e0'>
							<thead > 
							<tr>
								<th><center>Identificación</center></th>
								<th><center>Periodo lectivo</center></th>
								<th><center>Código</center></th>
								<th><center>Estado</center></th>
							</tr> 
							</thead> 
							<tbody>";
	//$resultado=$mysqli1->query($query1);
	$rescod=mysqli_query($conexion,$query1);
	while($row = $rescod->fetch_assoc()) {
		$cadena = $cadena."<tr>
								<td scope='row'>".$row['identificacion']."</td>
								<td scope='row'>".$row['periodo_lectivo']."</td>
								<td scope='row'>".$row['codigo']."</td>
								<td scope='row'>".$row['estado']."</td>
							</tr>";
	}
	$cadena = $cadena."</tbody>
			</table>";
	echo $cadena;
?>