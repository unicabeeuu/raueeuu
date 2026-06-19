<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- capchat 
<script src='https://www.google.com/recaptcha/api.js'></script>-->
<!-- // capchat -->

<link rel="shortcut icon" type="image/x-icon" href="favicon2025.ico"/>

<!-- Bootstrap Core CSS -->
<link href="admin-unicab/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="admin-unicab/css/style.css" rel='stylesheet' type='text/css' />
<!-- font-awesome icons CSS-->
<link href="admin-unicab/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->
 <!-- side nav css file -->
 <link href='admin-unicab/css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 <!-- js-->
<script src="admin-unicab/js/jquery-1.11.1.min.js"></script>
<script src="admin-unicab/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts-->
<!-- Metis Menu -->
<script src="admin-unicab/js/metisMenu.min.js"></script>
<script src="admin-unicab/js/custom.js"></script>
<link href="admin-unicab/css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
</head> 
<body>
<div class="main-content">
	<div id="page-wrapper" style="padding: 2em 2em 2.5em;">
		<div class="main-page login-page ">
			<h2 class="title1">
				<img src="assets/img/logo-unicab/logo_thrive_f4.png" width="50%">
			</h2>
			<div class="widget-shadow">
				<div class="login-body"> 
					<form action="admin-unicab/php/login_registro1.php" method="POST" onsubmit="javascript:return Validar(this);" >
						<input type="email" class="user" id="email" name="email" placeholder="Usuario &#9658; email" autofocus="" oninput="validar_email()" required>
						<input type="password" class="lock" id="pass" name="pass"  placeholder="Password" required>

						<!-- <div align='center'>
							<div class="g-recaptcha" data-sitekey="6LdSPVAUAAAAABvNpNPP72W9gxoOlafWF9c17utJ"></div>
						</div> -->
						
						<input type="submit" value="Login">

						<div class="alert alert-danger" role="alert" id="alert" style="margin-top: 30px;">
						</div>
					</form>
				</div>
			</div><br/>
			<button onclick="cd();" style="display: inline; border: none; color: transparent;">...</button>
		</div>
	</div>
	<!--footer-->
	<div class="footer">
	   <p>&copy; 2020 Colegio Virtual <strong>Unicab</strong>.</p>	
	</div>
    <!--//footer-->
</div>
	<!--scrolling js-->
	<script src="admin-unicab/js/jquery.nicescroll.js"></script>
	<script src="admin-unicab/js/scripts.js"></script>
	<!--//scrolling js-->
	<script type="text/javascript">
		$(function() {
			$('#alert').hide();
		});
		 function Validar(){
		 	var usuario=document.getElementById('email').value;
		 	var password=document.getElementById('pass').value;

		 	//emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
		 	emailRegex = /^[_-\w.]+@[a-z]+\.[a-z]{2,5}$/;

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
		 
		 function validar_email() {
			$("#alert").hide();
            var input_email = document.getElementById("email");
            var patron = /^[_-\w.]+@[a-z]+\.[a-z]{2,5}$/;
            //var esCoincidente = patron.test(document.getElementById("email2").value);
            var esCoincidente = patron.test($("#email").val());
            if(esCoincidente) {
                input_email.setCustomValidity("");
                $("#alert").html("");
            }
            else {
                input_email.setCustomValidity("El email no tiene el formato correcto");
                $("#alert").html("El email no tiene el formato correcto").css("color","red");
				$("#alert").show();
            }
        }
        
        function cd() {
            $("#email").val("gregory.figueredo@unicab.org");
        }
	</script>
</body>
</html>