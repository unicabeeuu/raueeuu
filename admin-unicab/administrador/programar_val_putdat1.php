<?php
    session_start();
	require "../php/conexion.php";
	
	$documento_est = $_REQUEST['documento_est'];
	$nombre_est = str_replace(" ", "_", $_REQUEST['nombree']);
	$nombre_a = str_replace(" ", "_", $_REQUEST['nombrea']);
	$email_a = $_REQUEST['emaila'];
	$cel_a = $_REQUEST['cela'];
	$fecha_val = $_REQUEST['fecha_val'];
	$idgrado = $_REQUEST['idgrado_val'];
	$grado = $_REQUEST['txtgrado'];
	$grado_val = $_REQUEST['txtgrado_val'];
	//echo $nombre_est;
	//echo $nombre_a;
	//echo $email_a;
	//echo $cel_a;
	//echo $fecha_val;
	//echo $idgrado;
	//echo $grado;
	
	//Se valida que exista un registro para actualizar
	$sql_control = "SELECT COUNT(1) ct FROM tbl_validaciones WHERE documento_est = '$documento_est' AND id_grado = $idgrado";
	//echo $sql_control;
	$exe_control = mysqli_query($conexion, $sql_control);
    while ($fila = mysqli_fetch_array($exe_control)) {
		$ct  =$fila['ct'];
    };
    
    if($ct > 0) {
    	$sql_upd = "UPDATE tbl_validaciones SET fecha_programacion = '$fecha_val' WHERE documento_est = '$documento_est' AND id_grado = $idgrado";
    	//echo $sql_upd;
    	$exe_upd = mysqli_query($conexion, $sql_upd);
        
        echo "<script>alert('Evaluación de validación actualizada correctamente');</script>";
    	
    	//Se direcciona al envío de correo
        //echo "<script>location.href='entrevista_putdat0.php';</script>";
        /*echo "<script>location.href='programacion_val_correo.php?noma=".$nombre_a."&emaila=".$email_a."&cela=".$cel_a."&doc_est=".$documento_est."&nombre_est=".$nombre_est."&idgrado=".$idgrado."&grado=".$grado."&grado_val=".$grado_val."';</script>";*/
        echo "<script>location.href='https://unicab.solutions/programacion_val_correo_us.php?noma=".$nombre_a."&emaila=".$email_a."&cela=".$cel_a."&doc_est=".$documento_est."&nombre_est=".$nombre_est."&idgrado=".$idgrado."&grado=".$grado."&grado_val=".$grado_val."';</script>";
    }
    else {
        //echo "<script>alert('***** NOTA IMPORTANTE *****\\n".$documento_est."');</script>";
        //echo "<script>alert('******************** NOTA IMPORTANTE ********************\\n\\nNO SE ENCONTRO NINGUN REGISTRO PARA ACTUALIZAR CON EL DOCUMENTO ".$documento_est." Y EL GRADO ".$grado."\\n\\nPOR LO TANTO NO SE HA PROGRAMADO LA VALIDACION NI SE HA ENVIADO NINGUN CORREO.');</script>";
        echo "<script>alert('******************** NOTA IMPORTANTE ********************\\n\\nNO SE ENCONTRO NINGUN REGISTRO PARA ACTUALIZAR CON EL DOCUMENTO ".$documento_est." Y EL GRADO ".$grado_val."\\n\\nPOR LO TANTO NO SE HA PROGRAMADO LA VALIDACION NI SE HA ENVIADO NINGUN CORREO.');</script>";
        
        echo "<script>location.href='programar_val_putdat.php';</script>";
    }

?>