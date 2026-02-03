<!DOCTYPE HTML>
<html>
<head>
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- capchat -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<!-- // capchat -->
<link rel="shortcut icon" type="image/x-icon" href="../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="css/style.css" rel='stylesheet' type='text/css' />
<!-- font-awesome icons CSS-->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->
 <!-- side nav css file -->
 <link href='css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 <!-- js-->
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.custom.js"></script>
<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts-->
<!-- Metis Menu -->
<script src="js/metisMenu.min.js"></script>
<script src="js/custom.js"></script>
<link href="css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body>
<div class="main-content">
	<div id="page-wrapper" style="padding: 2em 2em 2.5em;">
		<div class="main-page login-page ">
			<h2 class="title1">
				<img src="../assets/img/footer_logo_blanco2025.png" width="30%">
			</h2>
			<div class="widget-shadow">
				<div class="login-body">
					<form action="php/login.php" method="POST" onsubmit="javascript:return Validar(this);" >
						<input type="email" class="user" id="email" name="email" placeholder="Usuario" autofocus="" onblur="javascript:Validar();">
						<input type="password" class="lock" id="pass" name="pass"  placeholder="Password" onblur="javascript:Validar();">

						<!-- <div align='center'>
							<div class="g-recaptcha" data-sitekey="6LdSPVAUAAAAABvNpNPP72W9gxoOlafWF9c17utJ"></div>
						</div> -->
						
						<input type="submit" value="Iniciar Sesión">

						<div class="alert alert-danger" role="alert" id="alert" style="margin-top: 30px; display: none;">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!--footer-->
	<div class="footer">
	   <p>&copy; 2019 Colegio Virtual <strong>Unicab</strong>.</p>	
	</div>
    <!--//footer-->
</div>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<script type="text/javascript">
		 function Validar(){
		 	var usuario=document.getElementById('email').value;
		 	var password=document.getElementById('pass').value;

		 	emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

		 	if (emailRegex.test(usuario)) {
		 		$('#alert').html('').slideUp(300);	
     		}else {
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

	     	if (password=="") {
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