 <html>
 <head>
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>
 </html>
<?php
    session_start();
    include "conexion.php";
    
    try {
		$usuario = $_POST['email'];
		$password = $_POST['pass'];
		$idioma = $_POST['idioma'];
		$idioma = "E";
		//echo $usuario;
		//echo $password;

		$sql="SELECT * FROM estudiantes e, matricula m 
		WHERE e.id = m.id_estudiante AND e.email_institucional = '".$usuario."' and e.n_documento = '".$password."' 
		AND m.estado IN ('activo', 'pre_solicitud_cero') 
		UNION ALL 
		SELECT *, '', '', '', '', '', '', '', '' FROM estudiantes 
		WHERE email_institucional = '".$usuario."' and n_documento = '".$password."' AND actividad_extra = 'Domain Grupo Sotaquira'";
		//echo $sql;
		$petecion=mysqli_query($conexion,$sql);
		$total=mysqli_num_rows($petecion);
		if ($total > 0) {
			while ($row = mysqli_fetch_array($petecion)) {
				$_SESSION['usu_domain'] = $usuario;
				//$_SESSION['nombre'] = $row['nombres']." ".$row['apellidos'];			
				
				//echo "<script>alert('Bienvenido(a) ".$row['nombres']." ".$row['apellidos']."');</script>";
				if ($idioma == "E") {
					echo "<script>location.href='../../../domain_upddat_pre.php';</script>";
				}
				else if ($idioma == "I") {
					echo "<script>location.href='../../../domain_upddat_pre_i.php';</script>";
				}
			}
		}else{
			echo "<script>alert('Usuario no encontrado');</script>";
			echo "<script>location.href='../../../login_domain.php'</script>";
		}
	} catch (Exception $e) {
			echo "<script>alert('intentelo más tarde');</script>";
			echo "<script>location.href='../../../login_domain.php'</script>";
	}
?>
