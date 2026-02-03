 <html>
 <head>
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php
session_start();
include "conexion.php";
include "mcript.php";
//SOLUCIONA EL PROBLEMA DE ACENTOS Y Ñ EN LA BASE DE DATOS
//@mysql_query("SET NAMES 'utf8'"); 
//INSERTAMOS EL COMENTARIO
if (isset($_POST)) {
	$usuario=$_POST["user"];
	$password=$_POST["pass"];
	$password = $gen_enc($password);
	$captcha =$_POST["g-recaptcha-response"];
	$secret ="6Lc6bVYUAAAAAKacD2jtl3-U71hljlBJEou4JdWe";
		if (!$captcha) {
			echo "<script>alert('por favor verificar el captcha');</script>";
			echo "<script>location.href='../login.php';</script>";
		}else if(!$usuario && !$password){
			echo "llene los campos";
		}else{
			$response= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
			$arr = json_decode($response, TRUE);
			if($arr['success']){
			    //$sql="SELECT * FROM administradores where email_institucional='".$usuario."' and password='".md5($password)."'";
			    $sql="SELECT * FROM tbl_empleados where email='".$usuario."' and pc= '$password' AND perfil IN ('AR','SU','AR_AW')";
				$petecion=mysqli_query($conexion,$sql);
				$total=mysqli_num_rows($petecion);
				if ($total>0) {
					$_SESSION['unisuper']= $usuario;	
					echo "<script>location.href='../index.php';</script>";
				}else{
					echo "<script>alert('Usuario no encontrado');</script>";
					echo "<script>location.href='../../../login_registro.php';</script>";
				}
			}else {
				echo "<script>alert('error al comprobar el captcha');</script>";
				echo "<script>location.href='../../../login_registro.php';</script>";
			}
		}
}  
?>
