<?php
    session_start();
	require "../php/conexion.php";
	
	$psicologo = $_REQUEST['psicologo'];
	$psicologo1 = str_replace(" ", "_", $psicologo);
	$id_psicologo = $_REQUEST['idpsi'];
	$cel_psicologo = $_REQUEST['cel_psi'];
	$meet_psicologo = $_REQUEST['meet_psi'];
	$fecha = $_REQUEST['fecha_ent'];
	$hora = $_REQUEST['hora_ent'];
	$documento_est = $_REQUEST['documento_est'];
	$nombre_est = $_REQUEST['nombree'];
	$nombre_est1 = str_replace(" ", "_", $_REQUEST['nombree']);
	$nombre_a = str_replace(" ", "_", $_REQUEST['nombrea']);
	$email_a = $_REQUEST['emaila'];
	$cel_a = $_REQUEST['cela'];
	//echo $psicologo;
	//echo "<br>".$psicologo1;
	//echo "<br>".$nombre_a;
	//echo "<br>".$cel_a;
	
	$sql_ins = "INSERT INTO tbl_entrevistas (id_psicologo, fecha, hora, documento_est, nombre_est, generar_contrato) VALUES 
	    ($id_psicologo, '$fecha', '$hora', '$documento_est', '$nombre_est', 'NO')";
	//echo $sql_ins;
	$exe_ins = mysqli_query($conexion, $sql_ins);
    /*while ($fila = mysqli_fetch_array($exe_ins)) {
		$fechaActual=$fila['fecha'];
    };*/
    
    echo "<script>alert('Entrevista agendada correctamente');</script>";
	
	//Se direcciona al envío de correo
    //echo "<script>location.href='entrevista_putdat0.php';</script>";
    /*echo "<script>location.href='entrevista_correo.php?noma=".$nombre_a."&psi=".$psicologo1."&celp=".$cel_psicologo."&emaila=".$email_a."&f=".$fecha."&h=".$hora."&meet=".$meet_psicologo."&cela=".$cel_a."&doc_est=".$documento_est."';</script>";*/
    echo "<script>location.href='https://unicab.solutions/entrevista_correo_us.php?noma=".$nombre_a."&psi=".$psicologo1."&celp=".$cel_psicologo."&emaila=".$email_a."&f=".$fecha."&h=".$hora."&meet=".$meet_psicologo."&cela=".$cel_a."&doc_est=".$documento_est."';</script>";

?>