<?php
	
	$mensaje = str_replace("_"," ",$_REQUEST['msg']);
	$control = $_REQUEST['control'];
?>

<!DOCTYPE html>
<html lang="es">
 <head>
  <meta charset="utf-8"/>
  <title>AndroidGHF</title>
  <link rel="stylesheet" href="default.css"/>
 </head>
 <body>
    <div id="agrupar">
	    <div id="enc" >
			<header id="cab">
				<table width="100%;">
					<tr>
						<td width="33%"></td>
						<td ><img src="img/logo512_n.png" width="25%" height="auto"/>
							<!--<p style="font-weight: bold">Desarrollo de aplicaciones android, PHP y Mysql</p>-->
						</td>
						<!--<td width="33%"><img src="logo4_25_1.png" width="25%" height="auto" /></td>-->
					</tr>
				</table>
			</header>
			
	    </div>
	    <div id="concontactos">			
			<section id="seccontactos">
				<div id="divcontactos">
					<h3>POLITICA DE PRIVACIDAD DE PAY SERVICES.</h3>
					<!--<h3>También puede escribirnos a ghernandof@yahoo.com.</h3>-->
					<fieldset><legend>Política.</legend> 
						 <form id="ff" method="POST" enctype="multipart/form-data" action="datos_contacto.php">
							<p>
								PAY SERVICES comprenden la importancia de la privacidad de los usuarios y se compromete cabalmente a protegerla.</br></br>
								Hemos creado esta Política para facilitar la comprensión de los siguientes conceptos:</br></br>
								1. Cómo usa PAY SERVICES los datos personales de los usuarios.</br> 
								2. Cómo comunicarse con PAY SERVICES.</br></br> 
								Debe tenerse en cuenta que esta Política es aplicable solo a la aplicación PAY SERVICES.</br></br>
								Esta Política describe el modo en que PAY SERVICES procesa los datos personales y privados, y el compromiso de PAY SERVICES en relación con la protección de la privacidad de los usuarios.</br></br>
								<em><b>1. Cómo utiliza PAY SERVICES los datos personales de los usuarios.</b></em></br></br> 
								Los datos personales que PAY SERVICES captura a través de la aplicación están compuestos por información que permite identificar a un usuario de manera individual. Para efectos de esta aplicación, se consultan los nombres, apellidos, número de identificación, email, celular y dirección del usuario para identificar a quien pertenece el pago a realizar. En cuanto a los datos que pide la aplicación para procesar el pago están: la ciudad, departamento, convenio de pago, referencia de pago, valor y concepto de pago. PAY SERVICES obtiene y usa los datos personales de los usuarios solo para los fines indicados en esta Política.</br></br>
								<em><b>1.1 Cómo usa PAY SERVICES los datos personales de los usuarios.</b></em></br></br> 
								El único fin, con el cual PAY SERVICES utiliza los datos antes mencionados es para validar el registro de los usuarios inscritos en nuestra plataforma. Estos datos se envían a través de web services encriptados a la plataforma de la pasarela de pago Epayco, quien es la entidad encarga de procesar el pago y reportar el resultado de las transacciones a cada usuario y empresa que se encuentre en el convenio respectivo. 
								PAY SERVICES nunca divulga o transfiere los datos de los usuarios a nadie. Son para uso única y exclusivamente para la funcionalidad de la app.</br></br>
								<em><b>2 Cómo comunicarse con PAY SERVICES.</b></em></br></br>
								Si tiene preguntas, comentarios o sugerencias, comuníquese con nosotros por correo electrónico a   ghernandof1@gmail.com.</br></br>
								Última actualización: Junio de 2020.
							</p>
							<?php
								if($control == 1) {
							?>
								<center><label style="color: red; font-weight: bold; background: khaki"><?php echo $mensaje; ?></label></center>
							<?php
								}
								else if($control == 0) {
							?>
								<center><label style="color: green; font-weight: bold; background: khaki"><?php echo $mensaje; ?></label></center>
							<?php
								}
							?>
						</form>
					</fieldset>
				</div>		
				<div style="background: rgba(255, 255, 255, 0.7); font-weight: bold; text-align: center"><p>////////// *** \\\\\\\\\\</p></div>
			</section>
		</div>
		<br>
		<div id="pie">
		<div>
			<footer id="foo">
			
			</footer>
		</div>
	   
		</div>
    </div>
 </body>
</html>