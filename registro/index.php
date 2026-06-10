<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- // capchat -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- Favicon -->
<link rel="shortcut icon" href="http://unicab.org/wp-content/uploads/2013/11/favicon.png" />
<!-- // Favicon -->
<!-- CSS -->
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/custom.css" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!-- // CSS -->
<style>
    #page-wrapper { padding-top: 2em; }
    .login-action-buttons {
        display: flex;
        gap: 0.75rem;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 0.5em;
    }
    .login-action-buttons .btn {
        min-width: 130px;
    }
    @media (max-width: 480px) {
        .login-action-buttons {
            flex-direction: column;
            align-items: center;
        }
        .login-action-buttons .btn {
            width: 70%;
        }
        .widget-shadow {
            border-radius: 0 0 20px 20px !important;
        }
    }
</style>
<!-- scripy -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- // script -->
</head>
<body>
<div class="main-content">

		<div id="page-wrapper">
			<div class="main-page login-page ">
				<h2 class="title1">Sistema de Control y Registro Académico</h2>
<!--                <img class="img-responsive" src="../assets/img/logo-unicab/logo_thrive_f1.png"-->
<!--                style="height: 36%; width: 95%">-->
			<div class="widget-shadow" style="border-radius: 0 0 50px 50px">
				<div class="login-body" align="center">
                
                	<img class="img-responsive" width="50%" src="../assets/img/logo-unicab/logo_thrive_f1.png"><br>
                    <img class="img-responsive" width="40%" src="images/iconoProfesor.png"><br>
                    <div class="login-action-buttons">
                        <a href="../login_registro.php" class="btn" style="background-color: #222a75; color: white;">Docentes</a>
                        <a href="estudianteunicab/login.php" class="btn" style="background-color: #fc0d8c; color: white;">Estudiantes</a>
                    </div>
				</div>
			</div>

		</div>
	</div>
	<?php include "adminunicab/footer.php" ?> 
</div>
<!--scrolling js-->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!--//scrolling js-->
</body>
</html>