 <html>
 <head>
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php
session_start();
include "conexion.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
//@mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
if (isset($_POST)) {
	$usuario=addslashes($_POST["user"]);
	$password=addslashes($_POST["pass"]);
	$captcha=$_POST["g-recaptcha-response"];
	$secret="6Lc6bVYUAAAAAKacD2jtl3-U71hljlBJEou4JdWe";
		if (!$captcha) {
			echo "<script>alert('por favor verificar el captcha');</script>";
			echo "<script>location.href='../../estudianteunicab/login.php';</script>";
		}else if(!$usuario && !$password){
			echo "llene los campos";
		}else{
			$response= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
			$arr = json_decode($response, TRUE);
			if($arr['success']){
				//$sql="SELECT * FROM estudiantes where email_institucional='".$usuario."' and password='".$password."'";
				$sql="SELECT * FROM estudiantes where email_institucional='".$usuario."' and n_documento='".$password."'";
				//echo $sql;
				$petecion=mysqli_query($conexion,$sql);
				if (mysqli_num_rows($petecion)>0) {
					$_SESSION['uniestudiante']= $usuario;
					while ($row=mysqli_fetch_array($petecion)) {
					    $_SESSION['identifest']= $row['n_documento'];
					}
					echo "<script>location.href='../../estudianteunicab/index.php';</script>";
				}else{
					echo "<script>alert('Usuario no encontrado');</script>";
					echo "<script>location.href='../../estudianteunicab/login.php';</script>";
				}

			}else {
				echo "<script>alert('error al comprobar el captcha');</script>";
				echo "<script>location.href='../../estudianteunicab/login.php';</script>";
			}
		}
}  
?>