<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
		
    // numero usuario
    //$sql_usuario="SELECT COUNT(*) as 'total_usuarios' FROM `administrador`";
    $sql_usuario="SELECT COUNT(*) as 'total_usuarios' 
        FROM `tbl_empleados` 
        WHERE perfil like '%AW%' OR perfil like '%SU%' OR perfil like '%PU%' OR perfil like '%PS%' OR perfil like '%FI%'";
    $exe_usuario=mysqli_query($conexion,$sql_usuario);
    while ($rowU = mysqli_fetch_array($exe_usuario)) {
        $total_usuarios=$rowU['total_usuarios'];
    }
    // numero usuario

    // numero eventos
    $sql_evento="SELECT COUNT(*) as 'total_eventos' FROM `evento`";
    $exe_evento=mysqli_query($conexion,$sql_evento);
    while ($rowE = mysqli_fetch_array($exe_evento)) {
        $total_eventos=$rowE['total_eventos'];
    }
    // numero eventos

    // numero noticia
    $sql_noticia="SELECT COUNT(*) as 'total_noticias' FROM `noticia`";
    $exe_noticia=mysqli_query($conexion,$sql_noticia);
    while ($rowN = mysqli_fetch_array($exe_noticia)) {
        $total_noticias=$rowN['total_noticias'];
    }
    // numero noticia

    //numero blog
    $sql_blog="SELECT COUNT(*) as 'total_blogs' FROM `blog`";
    $exe_blog=mysqli_query($conexion,$sql_blog);
    while ($rowB = mysqli_fetch_array($exe_blog)) {
        $total_blogs=$rowB['total_blogs'];
    }
    //numero blog

    //numero entrevistas
    $sql_entrevista="SELECT COUNT(*) as 'total_entrevistas' FROM `entrevistas`";
    $exe_entrevista=mysqli_query($conexion,$sql_entrevista);
    while ($rowEntrevista = mysqli_fetch_array($exe_entrevista)) {
        $total_entrevistas=$rowEntrevista['total_entrevistas'];
    }
    //numero entrevistas
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="big5">
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- chart -->
<script src="../js/Chart.js"></script>
<!-- //chart -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
#chartdiv {
  width: 100%;
  height: 295px;
}
</style>
<!--pie-chart --><!-- index page sales reviews visitors pie chart -->
<script src="../js/pie-chart.js" type="text/javascript"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#demo-pie-1').pieChart({
                barColor: '#2dde98',
                trackColor: '#eee',
                lineCap: 'round',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-2').pieChart({
                barColor: '#8e43e7',
                trackColor: '#eee',
                lineCap: 'butt',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });

            $('#demo-pie-3').pieChart({
                barColor: '#ffc168',
                trackColor: '#eee',
                lineCap: 'square',
                lineWidth: 8,
                onStep: function (from, to, percent) {
                    $(this.element).find('.pie-value').text(Math.round(percent) + '%');
                }
            });
        });
    </script>
    <!-- //pie-chart --><!-- index page sales reviews visitors pie chart -->

    <!-- requried-jsfiles-for owl -->
	<link href="../css/owl.carousel.css" rel="stylesheet">
	<script src="../js/owl.carousel.js"></script>
		<script>
			$(document).ready(function() {
				$("#owl-demo").owlCarousel({
					items : 3,
					lazyLoad : true,
					autoPlay : true,
					pagination : true,
					nav:true,
				});
			});
		</script>
   <!-- //requried-jsfiles-for owl -->
</head> 
<body class="cbp-spmenu-push">
<div class="main-content">
	<!-- menu -->
        <?php 
            require "include/header.php";
        ?>
        <!-- menu -->
        
        <!-- header -->
        <?php 
            require "include/menu.php";
        ?>
        <!-- header -->

	<!-- main content start-->
	<div id="page-wrapper">
		<div class="main-page">
		<div class="col_3">
        	<!--<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-users user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><?php echo $total_usuarios; ?> usuarios </h5>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-bullhorn user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><?php echo $total_eventos; ?> Eventos </h5>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-newspaper-o user2 icon-rounded"></i>
                    <div class="stats">
                      <h5><?php echo $total_noticias; ?> Noticias </h5>
                    </div>
                </div>
        	</div>
        	<div class="col-md-3 widget widget1">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-folder-open-o user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><?php echo $total_blogs; ?> Blog </h5>
                    </div>
                </div>
        	 </div>
        	<div class="col-md-3 widget">
        		<div class="r3_counter_box">
                    <i class="pull-left fa fa-commenting user2 icon-rounded"></i>
                    <div class="stats">
                        <h5><?php echo $total_entrevistas; ?> Entrevistas</h5>
                    </div>
                </div>
        	 </div>
        	<div class="clearfix"> </div><br><br>-->
            
            <iframe width="100%" height="300px" src="https://www.youtube.com/embed/v1axCQs3AYU" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <label><?php //echo $id_administrador; ?></label>
    	</div>
		</div>
	</div>
<!--footer-->
<?php 
	require 'include/footer.php';
?>
<!--//footer-->
</div>
<!-- NO ELIMINAR -->
<!-- Classie --><!-- for toggle left push menu script -->
<script src="../js/classie.js"></script>
<script>
	var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
		showLeftPush = document.getElementById( 'showLeftPush' ),
		body = document.body;
		
	showLeftPush.onclick = function() {
		classie.toggle( this, 'active' );
		classie.toggle( body, 'cbp-spmenu-push-toright' );
		classie.toggle( menuLeft, 'cbp-spmenu-open' );
		disableOther( 'showLeftPush' );
	};
	

	function disableOther( button ) {
		if( button !== 'showLeftPush' ) {
			classie.toggle( showLeftPush, 'disabled' );
		}
	}
</script>
<!-- //Classie --><!-- //for toggle left push menu script -->
<!-- NO ELIMINAR -->

<!--scrolling js-->
<script src="../js/jquery.nicescroll.js"></script>
<script src="../js/scripts.js"></script>
<!--//scrolling js-->

<!-- side nav js -->
<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
<script>
$('.sidebar-menu').SidebarNav()
</script>
<!-- //side nav js -->
<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.js"> </script>
<!-- //Bootstrap Core JavaScript -->
<!-- //Bootstrap Core JavaScript -->
<!-- ELIMINAR -->
<!-- <script src="../js/SimpleChart.js"></script> -->
</body>
</html>
<?php 
}else{
    echo "<script>alert('Debe iniciar sesión');</script>";
    echo "<script>location.href='../../login_registro.php'</script>";
}
?>