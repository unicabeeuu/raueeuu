 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta charset="gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../seg_psi_cierre0.php">
		
		
	</head>
</html>
<?php
    //var desc = lineas[i].descripcion.replace("<br />",""); --> esto en javascript

		$documento = $_REQUEST['buscar'];
		//$psi = $_REQUEST['sel_psi'];
		$psi = $_REQUEST['id_psi_text'];
		//$id_seg = $_REQUEST['id_seg'];
		$id_val = $_REQUEST['id_val'];
		$observaciones = nl2br($_REQUEST['observaciones']);
		$motivo = nl2br($_REQUEST['motivo']);
		$recomendaciones = nl2br($_REQUEST['recomendaciones']);
		$remitido = nl2br($_REQUEST['remitido']);
		$motivo_rem = nl2br($_REQUEST['motivo_rem']);
		$evento = $_REQUEST['sel_evento'];
	
		// fecha publicado
		date_default_timezone_set('America/Bogota');
		$dia=date("d");
		$mes=date("m");
		$mesLetra=date("M");
		$fanio=date("Y");
		$fechaHoy=$fanio."-".$mes."-".$dia;
		// fecha publicado

		// hora actual
		$hora=date("H");
		$minuto=date("i");
		$meridiano=date("A");
		$horaActual=$hora.':'.$minuto.' '.$meridiano;
		$fecha2 = $fanio."-".$mes."-".$dia;
		// hora actual
		
		try {	
			//Se ingresa el cierre
			$sql_seg_psi_cierre = "INSERT INTO tbl_seg_psi_cierre (id_valoracion, id_psicologo, id_agendamiento, observaciones, motivo, recomendaciones, remitido, motivo_remision, fecha) 
			VALUES ($id_val, $psi, $evento, '$observaciones', '$motivo', '$recomendaciones', '$remitido', '$motivo_rem', '$fecha2')";
			//echo $sql_seg_psi;
			$exe_sql_seg_psi_cierre = mysqli_query($conexion, $sql_seg_psi_cierre);
			
			//Se actualiza el evento
			$sql_evento = "UPDATE tbl_agendamientos SET estado = 'confirmado' WHERE id = $evento";
			$exe_evento = mysqli_query($conexion, $sql_evento);
			
			echo "<script>alert('Se ha hecho el cierre con éxito');</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../seg_psi_cierre0.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>