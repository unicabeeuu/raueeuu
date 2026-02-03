 <?php 
 	session_start();
 	require "../../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
 ?>
<html>
	<head><meta charset="gb18030">
		<META HTTP-EQUIV="Refresh" CONTENT="0; URL=../seg_psi0.php">
		
		
	</head>
</html>
<?php
    //var desc = lineas[i].descripcion.replace("<br />",""); --> esto en javascript

		$documento = $_REQUEST['buscar'];
		//$psi = $_REQUEST['sel_psi'];
		$id_val = $_REQUEST['id_val'];
		$psi = $_REQUEST['id_psi_text'];
		$obj_prox_seg = $_REQUEST['obj_prox_seg'];
		/*$desarrollo = $_REQUEST['desarrollo'];
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
		$obs_psi = nl2br($_REQUEST['obs_psi']);*/
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
		$hora=date("g");
		$minuto=date("i");
		$meridiano=date("A");
		$horaActual=$hora.':'.$minuto.' '.$meridiano;
		// hora actual

		try {	
			//Se ingresa el nuevo seguimiento en la fecha y hora programada
			$sql_seg_psi = "INSERT INTO tbl_seg_psi (id_valoracion, id_psicologo, objetivo, desarrollo, fecha, hora, estado, fecha_real, hora_real, 
			avances, acciones_est, acciones_acu, compromisos, proc_post) 
			VALUES ($id_val, $psi, '$obj_prox_seg', 'NA', '$fecha_prox_seg', '$hora_prox_seg', 'abierto', '0000-00-00', '00', 'NA', 'NA', 'NA', 'NA', 'NA')";
			$exe_sql_seg_psi = mysqli_query($conexion, $sql_seg_psi);
			
			echo "<script>alert('Seguimiento creado correctamente');</script>";
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../seg_psi0.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
?>