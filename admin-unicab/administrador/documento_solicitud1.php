 <?php 
 	session_start();
 	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {
	    //https://unica.org/admin-unicab/administrador/gestionar_entrevista_upddat.php?documento=1111&psicologo=2&observaciones=prueba&idprem=-1&chkeval=1
 
		$documento = $_REQUEST['documento'];
		$año = $_REQUEST['año'];
		
		//Se valida si el documento ya existe
		$sql_val = "SELECT COUNT(1) ct FROM tbl_solicitudes_matricula WHERE n_documento = '$documento' AND a = $año";
		$exe_val = mysqli_query($conexion,$sql_val);
		while ($row_val = mysqli_fetch_array($exe_val)) {
			$ct = $row_val['ct'];
		}
		if ($ct > 0) {
			echo "<script>alert('Este documento ya tiene una solicitud de matrícula para este año');</script>";
			echo "<script>location.href='documento_solicitud.php';</script>";
		}
		else {
			$sql_ins = "INSERT INTO tbl_solicitudes_matricula (a, n_documento, estado) VALUES 
			($año, '$documento', 1)";
			$exe_ins = mysqli_query($conexion,$sql_ins);
			
			echo "<script>alert('Documento registrado con éxito');</script>";
			echo "<script>location.href='documento_solicitud.php';</script>";
		}
		
			
	}else{
		echo "<script>alert('Debe iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php';</script>";
	}
	
?>