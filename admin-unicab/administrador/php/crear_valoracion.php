 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta charset="gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../seg_psi_val0.php">
		
		
	</head>
</html>
<?php
    //var desc = lineas[i].descripcion.replace("<br />",""); --> esto en javascript

		$documento = $_REQUEST['buscar'];
		//$psi = $_REQUEST['sel_psi'];
		$psi = $_REQUEST['id_psi_text'];
		$piar = $_REQUEST['sel_piar'];
		$acomp = $_REQUEST['sel_acomp'];
		$id_emp = $_REQUEST['id_emp'];
		$motivo_val = nl2br($_REQUEST['motivo_val']);
		$nivel_bio = nl2br($_REQUEST['nivel_bio']);
		$nivel_int = nl2br($_REQUEST['nivel_int']);
		$nivel_mot = nl2br($_REQUEST['nivel_mot']);
		$autonomia = nl2br($_REQUEST['autonomia']);
		$nivel_len = nl2br($_REQUEST['nivel_len']);
		$nivel_soc = nl2br($_REQUEST['nivel_soc']);
		$personalidad = nl2br($_REQUEST['personalidad']);
		$nivel_esc = nl2br($_REQUEST['nivel_esc']);
		$con_soc_fam = nl2br($_REQUEST['con_soc_fam']);
		$obs_psi = nl2br($_REQUEST['obs_psi']);
		$fecha_pseg = $_REQUEST['fecha_pseg'];
		$hora_pseg = $_REQUEST['hora_pseg'];
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
		$hora=date("g");
		$minuto=date("i");
		$meridiano=date("A");
		$horaActual=$hora.':'.$minuto.' '.$meridiano;
		// hora actual

		try {	
			$sql_val = "INSERT INTO tbl_seg_psi_val (n_documento, id_psicologo, id_solicita, id_empleado, id_agendamiento, piar, motivo, nivel_biologico, nivel_intelectual, 
			nivel_motor, autonomia, nivel_lenguaje, nivel_social, personalidad, nivel_escolar, contexto_socio_fam, observaciones, fecha, fecha_primer_seg, hora) 
			VALUES ('".$documento."', ".$psi.", ".$acomp.", ".$id_emp.", ".$evento.", '".$piar."', '".$motivo_val."', '".$nivel_bio."', '".$nivel_int.
			"', '".$nivel_mot."', '".$autonomia."', '".$nivel_len."', '".$nivel_soc."', '".$personalidad."', '".$nivel_esc."', '".$con_soc_fam."', '".$obs_psi.
			"', '".$fechaHoy."', '".$fecha_pseg."', '".$hora_pseg."')";
			$exe_val = mysqli_query($conexion,$sql_val);
			
			//Se captura el id de la valoracion
			$sql_id_val = "SELECT id FROM tbl_seg_psi_val WHERE n_documento = '$documento' AND id_psicologo = $psi AND id_solicita = $acomp AND id_empleado = $id_emp 
			AND fecha = '$fechaHoy' AND fecha_primer_seg = '$fecha_pseg' AND hora = '$hora_pseg'";
			$exe_sql_id_val = mysqli_query($conexion, $sql_id_val);
			while($row_sql_id_val = mysqli_fetch_array($exe_sql_id_val)) {
			    $id_val = $row_sql_id_val['id'];
			}
			
			//Se ingresa el nuevo seguimiento en la fecha y hora programada
			$sql_seg_psi = "INSERT INTO tbl_seg_psi (id_valoracion, id_psicologo, objetivo, desarrollo, fecha, hora, estado, fecha_real, hora_real, 
			avances, acciones_est, acciones_acu, compromisos, proc_post) 
			VALUES ($id_val, $psi, 'NA', 'NA', '$fecha_pseg', '$hora_pseg', 'abierto', '0000-00-00', '00', 'NA', 'NA', 'NA', 'NA', 'NA')";
			$exe_sql_seg_psi = mysqli_query($conexion, $sql_seg_psi);
			
			//Se actualiza el evento
			$sql_evento = "UPDATE tbl_agendamientos SET estado = 'confirmado' WHERE id = $evento";
			$exe_evento = mysqli_query($conexion, $sql_evento);
			
			echo "<script>alert('Valoración creada correctamente');</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../seg_psi_val0.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>