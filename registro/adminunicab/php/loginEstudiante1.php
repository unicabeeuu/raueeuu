 <html>
 <head>
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php
    session_start();
    include "conexion.php";
    
    $usuario = $_REQUEST["u"];
	$password = $_REQUEST["d"];
	$pagina = $_REQUEST["p"];
	
	//$sql="SELECT * FROM estudiantes where email_institucional='".$usuario."' and password='".$password."'";
	$sql="SELECT * FROM estudiantes where email_institucional='".$usuario."' and n_documento='".$password."'";
	//echo $sql;
	$petecion=mysqli_query($conexion,$sql);
	if (mysqli_num_rows($petecion)>0) {
		$_SESSION['uniestudiante']= $usuario;
		while ($row=mysqli_fetch_array($petecion)) {
		    $_SESSION['identifest']= $row['n_documento'];
		}
		if ($pagina == "cupo") {
		    echo "<script>location.href='../../estudianteunicab/cupo.php';</script>";
		}
		else {
		    echo "<script>location.href='../../estudianteunicab/index.php';</script>";
		}
		
	}else{
		echo "<script>alert('Usuario no encontrado');</script>";
		echo "<script>location.href='../../estudianteunicab/login.php';</script>";
	} 
?>