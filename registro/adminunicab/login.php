<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- capchat -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- // capchat -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->

<!-- CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="../css/style.css" rel='stylesheet' type='text/css' />
<link href="../css/custom.css" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!-- // CSS -->

<!-- scripy -->
<script src="../js/jquery-1.11.1.min.js"></script>
<!-- // script -->
</head>
<body>
<div class="main-content">

		<div id="page-wrapper">
			<div class="main-page login-page ">
				<h2 class="title1">Login</h2>
			<div class="widget-shadow">
				<div class="login-body">
					<form action="php/loginSuper.php" method="post" onsubmit="javascript:return Validar();">
						<!-- <form action="php/loginSuper.php" method="post" name="f"> -->
						<input type="email" class="user" name="user" id="user" placeholder="Usuario" autofocus onblur="javascript:Validar();">
						<input type="password" class="lock" name="pass" id="pass" placeholder="Contraseña" onblur="javascript:Validar();">

						<div align='center'>
							<div class="g-recaptcha" data-sitekey="6Lc6bVYUAAAAALNJxEipjWAkhov1hRFgXOvpFAnB"></div>
						</div>

						<input type="submit" value="Ingresar">
						<div class="alert alert-info" role="alert" id="alert" style="display:none; margin-top: 20px;"></div>
					</form>
				</div>
			</div>

		</div>
	</div>
	<?php include "footer.php" ?> 
</div>
	
<!--scrolling js-->
<script src="../js/jquery.nicescroll.js"></script>
<script src="../js/scripts.js"></script>
<!--//scrolling js-->
<script type="text/javascript">
	function Validar(){
	    var usuario=document.getElementById('user').value;
    	var contrasena=document.getElementById('pass').value;

	    emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

    	if (emailRegex.test(usuario)) {
  			$('#alert').html('').slideUp(300);	
    	} else {
      		$('#alert').html('<center><strong>Advertencia</strong> El correo no tiene el formato correcto</center>').slideDown(500);
			$('#usuario').focus();
  			return false;
    	}

	    if (usuario=="") {
	    	$('#alert').html('<center><strong>Advertencia</strong> Campo Obligatorio</center>').slideDown(500);
	      	$('#usuario').focus();
	      	return false;
	    }else{
	     	$('#alert').html('').slideUp(300);
	    }

	    if (contrasena=="") {
	    	$('#alert').html('<center><strong>Advertencia</strong> Campo Obligatorio</center>').slideDown(500);
	    	$('#contrasena').focus();
	      	return false;
	    }else{
	      	$('#alert').html('').slideUp(300);
	    }
  }
</script>
</body>
</html>