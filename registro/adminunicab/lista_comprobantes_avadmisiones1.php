<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/lista_comprobantes_avadmisiones1.php?documento=93974543&a=2026
	
	$documento = $_REQUEST['documento'];
	$a = $_REQUEST['a'];
	
	$i = 1;

    $query = "SELECT * FROM tbl_documentos_matriculas WHERE documento = '$documento' AND a = $a";
    //echo $query;
    
    $cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr>
	                            <td>Id</td>
	                            <td>Tipo</td>
	                            <td>Validado</td>
	                            <td></td>
	                        </tr></thead><tbody>";
	                        
    $resultado1 = $mysqli1->query($query);
    while($row = $resultado1->fetch_assoc()) {
		$isChecked = ($row['validado'] == 1) ? 'checked' : '';
		$registroId = $row['id'];
        $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td><a href='".$row['ruta']."' target='_blank'>".$row['tipo']."</a></td>
                <td>".$row['validado']."</td>
                <td><center>
					<div class='switch-wrapper'><label class='custom-switch-v3'><input type='checkbox' ".$isChecked." onclick='toggleValidacion(".$registroId.", this)'><span class='custom-slider-v3'></span></label></div></center>
				</td>
				</tr>";
        $i++;
    }
    $cadena = $cadena."</tbody></table>";
	echo $cadena;
	
?>