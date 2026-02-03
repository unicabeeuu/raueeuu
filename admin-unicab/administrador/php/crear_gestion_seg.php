 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta charset="gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../seg_psi_gestion0.php">
		
		
	</head>
</html>
<?php
    //var desc = lineas[i].descripcion.replace("<br />",""); --> esto en javascript

		$documento = $_REQUEST['buscar'];
		//$psi = $_REQUEST['sel_psi'];
		$psi = $_REQUEST['id_psi_text'];
		$id_seg = $_REQUEST['id_seg'];
		$id_val = $_REQUEST['id_val'];
		$desarrollo = nl2br($_REQUEST['desarrollo']);
		$avances = nl2br($_REQUEST['avances']);
		$acc_est = nl2br($_REQUEST['acc_est']);
		$acc_acu = nl2br($_REQUEST['acc_acu']);
		$compromisos = nl2br($_REQUEST['compromisos']);
		$proc_post = nl2br($_REQUEST['proc_post']);
		$obj_prox_seg = nl2br($_REQUEST['obj_prox_seg']);
		$fecha_prox_seg = $_REQUEST['fecha_prox_seg'];
		$hora_prox_seg = $_REQUEST['hora_prox_seg'];

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
			$sql_upd_psi = "UPDATE tbl_seg_psi SET desarrollo = '$desarrollo', avances = '$avances', acciones_est = '$acc_est', acciones_acu = '$acc_acu', 
			compromisos = '$compromisos', proc_post = '$proc_post', fecha_real = '$fecha2', hora_real = '$hora', estado = 'realizado' 
			WHERE id = $id_seg AND id_valoracion = $id_val";
			//echo $sql_upd_psi;
			$exe_upd_psi = mysqli_query($conexion, $sql_upd_psi);
			
			//Se ingresa el nuevo seguimiento en la fecha y hora programada
			if($obj_prox_seg != "NA") {
    			$sql_seg_psi = "INSERT INTO tbl_seg_psi (id_valoracion, id_psicologo, objetivo, desarrollo, fecha, hora, estado, fecha_real, hora_real, 
    			avances, acciones_est, acciones_acu, compromisos, proc_post) 
    			VALUES ($id_val, $psi, '$obj_prox_seg', 'NA', '$fecha_prox_seg', '$hora_prox_seg', 'abierto', '0000-00-00', '00', 'NA', 'NA', 'NA', 'NA', 'NA')";
    			//echo $sql_seg_psi;
    			$exe_sql_seg_psi = mysqli_query($conexion, $sql_seg_psi);
			}
			
			echo "<script>alert('Gestión creada correctamente');</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../seg_psi_gestion0.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>