 <?php 
 	session_start();
 	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {
	    //https://unica.org/admin-unicab/administrador/gestionar_entrevista_upddat.php?documento=1111&psicologo=2&observaciones=prueba&idprem=-1&chkeval=1
 ?>

<?php

		$documento = $_REQUEST['documento'];
		
		//Se direcciona al envío de correo con el contrato
		echo "<script>location.href='https://unicab.solutions/contrato_correo_us.php?documento=".$documento."';</script>";
			
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
	
?>