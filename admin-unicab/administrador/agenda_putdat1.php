<?php
    session_start();
	require "../php/conexion.php";
	
	$psicologo = $_REQUEST['psi_text'];
	$psicologo1 = str_replace(" ", "_", $psicologo);
	$id_psicologo = $_REQUEST['id_psi_text'];
	$tipoagenda = $_REQUEST['ta_text'];
	$id_tipoagenda = $_REQUEST['tipoagenda'];
	$fecha_agenda = $_REQUEST['fecha_agenda'];
	$hora_agenda = $_REQUEST['hora_agenda'];
	$descripcion = nl2br($_REQUEST['descripcion']);
	
	$sql_ins = "INSERT INTO tbl_agendamientos (id_empleado, id_tipo_agenda, fecha, hora, descripcion, estado) VALUES 
	    ($id_psicologo, $id_tipoagenda, '$fecha_agenda', '$hora_agenda', '$descripcion', 'en proceso')";
	//echo $sql_ins;
	$exe_ins = mysqli_query($conexion, $sql_ins);
    /*while ($fila = mysqli_fetch_array($exe_ins)) {
		$fechaActual=$fila['fecha'];
    };*/
    
    echo "<script>alert('Evento agendado correctamente');</script>";
	
	//Se direcciona al envío de correo
    echo "<script>location.href='agenda_putdat0.php';</script>";

?>