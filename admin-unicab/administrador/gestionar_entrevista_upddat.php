 <?php 
 	session_start();
 	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {
	    //https://unica.org/admin-unicab/administrador/gestionar_entrevista_upddat.php?documento=1111&psicologo=2&observaciones=prueba&idprem=-1&chkeval=1
 ?>

<?php

		$documento = $_REQUEST['documento'];
		$psicologo = $_REQUEST['psicologo'];
		$observaciones = nl2br(strtoupper($_REQUEST['observaciones']));
		$idprem = $_REQUEST['idprem'];
		$chkeval = $_REQUEST['chkeval'];
		if($chkeval == true) {
		    $chkeval1 = 1;
		}
		else {
		  $chkeval1 = 0;  
		}
		$chkadmitido = $_REQUEST['chkadmitido'];
		if($chkadmitido == true) {
		    $chkadmitido1 = 1;
		}
		else {
		  $chkadmitido1 = 0;  
		}
		$checked_contador = count($_REQUEST['chkgrados']);
		//echo $checked_contador;
		
		// fecha publicado
		date_default_timezone_set('America/Bogota');

		$dia=date("d");
		$mes=date("m");
		$mesLetra=date("M");
		$fanio=date("Y");
		
		$fechaHoy=$fanio."-".$mes."-".$dia;
		// fecha publicado

		
		try {	
			$sql_upd = "UPDATE tbl_pre_matricula SET entrevista = 'SI', observaciones_ent = '$observaciones', admitido = $chkadmitido1, id_empleado = $psicologo, eval = $chkeval1 
			WHERE id = $idprem AND documento_est = '$documento'";
			//echo $sql_upd;
			$exe_upd = mysqli_query($conexion,$sql_upd);
			
			//Se insertan los grados a validar
			if(!empty($_REQUEST['chkgrados'])){
    		    //echo $_REQUEST['chkgrados'];
    		    foreach($_REQUEST['chkgrados'] as $selected){
                    //echo $selected."</br>"; // Imprime resultados
                    $sql_ins = "INSERT INTO tbl_validaciones (id_grado, documento_est, fecha_programacion) VALUES 
			        ($selected, '$documento', 'NA')";
			        $exe_ins = mysqli_query($conexion,$sql_ins);
                }
    		}
		
			echo "<script>alert('Datos actualizados correctamente');</script>";
			//echo "<script>location.href='gestionar_entrevista.php';</script>";
			
			//Se direcciona al envío de correo con el contrato --- método antiguo ---
			//echo "<script>window.open('https://unicab.solutions/contrato_correo_us.php?documento=".$documento."', '_blank');</script>";
			//echo "<script>location.href='https://unicab.solutions/contrato_correo_us.php?documento=".$documento."';</script>";
			
			//Se direcciona al envío del contrato
			//################ OJO ################# Para el año 2025 en ésta página se debe crear el contrato para enviarlo
			//################ POR AHORA SE DIRECCIONA A GETIONAR ENTREVISTA
			//echo "<script>location.href='enviar_contrato.php?documento=".$documento."';</script>";
			echo "<script>location.href='gestionar_entrevista.php';</script>";
				
		} catch (Exception $e) {
			echo "<script>alert('Esta acción no se pudo ejecutar');</script>";
			echo "<script>location.href='../index.php';</script>";
		}
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
	
?>