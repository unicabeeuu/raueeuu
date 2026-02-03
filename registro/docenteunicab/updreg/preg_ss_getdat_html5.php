<?php
	//Genera el select de los grados
	session_start();
	require("1cc3s4db.php");
	include "../../adminunicab/php/conexion.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/preg_ss_getdat_html5.php?idgra=19
	
	$idgra = $_REQUEST["idgra"];
	//$idpen = $_REQUEST["idpen"];
	//echo $idgra;
	//echo $idpen;
	
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
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$hora = date("H",$fecha);
	$minutos = date("i",$fecha);
	if($dia < 10) {
		//$dia = "0".$dia;
	}
	if($mes < 10) {
		//$mes = "0".$mes;
	}
	$fecha2 =$a."/".$mes."/". $dia;
	//echo $fecha2;
	
	$cadena = "";
	
	$query1 = "SELECT p.*, tp.tema FROM tbl_preguntas p, tbl_temas_preguntas tp 
	WHERE p.id_tema = tp.id AND p.id_grado = $idgra AND p.id_tipo_pregunta = 3";
	//echo $query1;
	
	$cadena = $cadena."<table id='tblact' class='table' border='1px'>
	                        <thead>
	                        <tr class='GridViewScrollHeader'>
	                            <td>Id</td>
	                            <td>Id_gra</td>
	                            <td>Tema</td>
	                            <td>Pregunta</td>
	                            <td>...</td>
	                        </tr></thead><tbody>";
	                        
	$resultado=$mysqli1->query($query1);
	while($row = $resultado->fetch_assoc()) {
	    $cadena = $cadena."<tr>
                <td>".$row['id']."</td>
                <td>".$row['id_grado']."</td>
                <td>".$row['tema']."</td>
                <td>".$row['pregunta']."</td>
                <td><button class='btn btn-warning glyphicon glyphicon-pencil' data-toggle='modal' data-target='#modal_editar_preg' title='Editar'
                onclick='enviardat(".$row['id'].",".$row['id_tema'].",\"".$row['pregunta']."\",\"".$row['r1ok']."\",\"".$row['retroalimentacion']."\",\"".$row['imagen']."\",\"".$row['r1no']."\",\"".$row['r2no']."\",\"".$row['r3no']."\")'></button></td></tr>";
	    
	}
	$cadena = $cadena."</tbody></table>";
	echo $cadena;
?>