<?php  
    if($_SESSION['perfil'] == "SU") {
        /* establecer el limitador de caché a 'private' */
        session_cache_limiter('private');
        $cache_limiter = session_cache_limiter();
        
        /* establecer la caducidad de la caché a 30 minutos */
        session_cache_expire(480);
        $cache_expire = session_cache_expire();
    }
    session_start();
    $usuario = $_REQUEST['u'];
?>
<!DOCTYPE HTML>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- capchat 
<script src='https://www.google.com/recaptcha/api.js'></script>-->
<!-- // capchat -->

<link rel="shortcut icon" type="image/x-icon" href="../../favicon2025.ico"/>

<!-- Bootstrap Core CSS -->
<link href="../../admin-unicab/css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="../../admin-unicab/css/style.css" rel='stylesheet' type='text/css' />
<!-- font-awesome icons CSS-->
<link href="../../admin-unicab/css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->
 <!-- side nav css file -->
 <link href='../../admin-unicab/css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 <!-- js-->
<script src="../../admin-unicab/js/jquery-1.11.1.min.js"></script>
<script src="../../admin-unicab/js/modernizr.custom.js"></script>
<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts-->
<!-- Metis Menu -->
<script src="../../admin-unicab/js/metisMenu.min.js"></script>
<script src="../../admin-unicab/js/custom.js"></script>
<link href="../../admin-unicab/css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
    <style>
        #divsistemas {
            display: flex;
            justify-content: space-around;*
            /*justify-content: space-between;*/
        }
        .login-body {
            /*width: 700px;
            margin-right: 100px !Important;*/
        }
    </style>
    <script type="text/javascript">
		 function mostrar_opciones() {
		    //alert($("#txtperfil").val());
            if($("#txtperfil").val() == "SU") {
                $("#div_admreg").show();
                $("#div_admweb").show();
                $("#div_tutadm_cargue").show();
                $("#div_tickets").show();
                $("#div_tut").hide();
                $("#div_admweb1").hide();
            }
			else if($("#txtperfil").val() == "SU_2") {
                $("#div_admreg").show();
                $("#div_admweb").show();
                $("#div_tutadm_cargue").show();
                $("#div_tickets").hide();
                $("#div_tut").hide();
                $("#div_admweb1").hide();
            }
            else if($("#txtperfil").val() == "AR_AW") {
                $("#div_admreg").show();
                $("#div_admweb").show();
                $("#div_tutadm_cargue").hide();
                $("#div_tickets").hide();
                $("#div_tut").hide();
                $("#div_admweb1").hide();
            }
            else if($("#txtperfil").val() == "TU_AR_AW") {
                $("#div_admreg").show();
                $("#div_admweb").show();
                $("#div_tutadm_cargue").hide();
                $("#div_tickets").hide();
                $("#div_tut").show();
                $("#div_admweb1").hide();
            }
            else if($("#txtperfil").val() == "TU_AW") {
                $("#div_admreg").hide();
                $("#div_admweb").show();
                $("#div_tutadm_cargue").hide();
                $("#div_tickets").hide();
                $("#div_tut").show();
                $("#div_admweb1").hide();
            }
            else if($("#txtperfil").val() == "ST_PU") {
                $("#div_admreg").hide();
                $("#div_admweb").hide();
                $("#div_tutadm_cargue").hide();
                $("#div_tickets").hide();
                $("#div_tut").show();
                $("#div_admweb1").show();
            }
            else {
                $("#div_admreg").hide();
                $("#div_admweb").hide();
                $("#div_tutadm_cargue").hide();
                $("#div_tickets").hide();
                $("#div_tut").hide();
                $("#div_admweb1").hide();
            }
        }
	</script>
</head> 
<body>
<div class="main-content">
	<div id="page-wrapper" style="padding: 2em 2em 2.5em;">
		<div class="main-page login-page ">
			<h2 class="title1">
				<img src="../../assets/img/footer_logo_blanco2025.png" width="30%">
			</h2>
			<div class="widget-shadow">
				<div class="login-body">
				    <center>
				    <h3>Hola</h3>
				    <h3><?php echo $_SESSION['nombre']; ?></h3>
				    <h3>tu perfil te permite acceder a:</h3><br/>
    				    <div id="divsistemas">
    				        <div id="div_admreg" style="display: inline;">
    				            <a href="../../registro/adminunicab/index.php"><img src="../images/adm_reg.png" width="99" height="80"></a>
    				        </div>
    				        <div id="div_admweb" style="display: inline;">
    				            <a href="../../admin-unicab/administrador/index.php"><img src="../images/adm_web.png" width="88" height="80"></a>
    				            <?php
    				                if($_SESSION['perfil'] == "AR_AW") {
    				                    echo '<label>Psicología</label>';
    				                }
    				            ?>
    				        </div>
    				        <div id="div_tutadm_cargue" style="display: inline;">
    				            <a href="../../registro/docenteunicab/index.php"><img src="../images/tut_adm_cargue.png" width="115" height="80"></a>
    				        </div>
    				        <div id="div_tut" style="display: inline;">
    				            <a href="../../registro/docenteunicab/index.php"><img src="../images/tutor.png" width="88" height="80"></a>
    				        </div>
    				        <div id="div_tickets" style="display: inline;">
    				            <a href="../../tickets/login.php"><img src="../images/tickets.png" width="88" height="80"></a>
    				        </div>
    				        <div id="div_admweb1" style="display: inline;">
    				            <!--<a href="https://unicab.solutions/admin/index.php"><img src="../images/adm_web1.png" width="88" height="80"></a>-->
    				            <?php
    				                echo "<a href='https://unicab.solutions/admin/index.php?u=".$usuario."'><img src='../images/adm_web1.png' width='88' height='80'></a>";
    				            ?>
    				        </div>
    				    </div>
    				    <input type="hidden" id="txtperfil" value="<?php echo $_SESSION['perfil']; ?>"/>
    				    <?php  
        			        //echo "<script>mostrar_opciones();</script>";
        			        echo '<script type="text/javascript">','mostrar_opciones();','</script>';
        			    ?>
				    
				    </center>
				</div>
			</div>
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
	
</body>
</html>