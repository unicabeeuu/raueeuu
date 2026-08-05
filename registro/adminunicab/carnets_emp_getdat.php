<?php
session_start();
require "php/conexion.php";
require("php/1cc3s4db.php");
if (isset($_SESSION['unisuper'])) {
    
        
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['unisuper']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		$perfil = $fila['perfil'];
    }
    
    /*if($id == 18 || $id == 3) {
        $query = "SELECT * FROM equivalence_idgra";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id";
    }
    
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);*/
    
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Unicab Academic Record</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style_thrive.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="../docenteunicab/updreg/css/reg.css" />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
    input[type=search] {
		border: none;
		border-bottom: 2px solid green;
		background-color: #A9F5BC;
	}
	thead {
	    background-color: lightgray;
	    font-weight: bold;
	    text-align: center;
	}
	tbody tr {
	    text-align: center;
	}
</style>
<script>
    $(function() {
        //alert("hola");
        $("#search").keyup(function(){
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#tblcarnet tbody tr"), function() {
            //alert ($(this).text());
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

    });

    function consultar_carnet() {
        let anio = $("#idanio").val();

        //alert (anio);
        $.ajax({
    		type:"POST",
    		url:"carnets_emp_getdat1.php",
    		data:"anio=" + anio,
    		success:function(r) {
    		    //alert(r);
    		    $("#search").show();
    		    $("#divtabla").html(r);
    			//$("#tbodyact").html(r);
    		}
    	});
    }
</script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php //require 'menu.php';  ?>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else {
		        require 'menu.php';
		    }
		?>
		<!--left-fixed -navigation-->

		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->

		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->

		<!-- main content start-->
        <section>
           <div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms" style="padding: 2rem;"> 

						<!---------------------------------------------->
                        <div id="cont">

                			<!--***********************************************************************************************-->
                			<div id="div1">
                				<fieldset>
                				<legend><h3 style="color: #FC0D8C;">GENERATE EMPLOYEE CARD</h3></legend>
                				    <form class="form-horizontal" action="../docenteunicab/carnet_mpdf.php"  method="POST" target="_blank" onsubmit="return validacion()">
                					<ul class="mprincipal">
                						<li><h3>GENERATE CARD BY<span style="color: white;">.....</span>
                						</h3></li>
                							<ul class="msecund" style="background-color: #222a75;">
                								<li style="background-color: #222a75;">
													<input type="text" id="idest" name="idest" placeholder="idemp" style="width: 50px;" value="0"/>
													<label style="color: white;">...</label>
													<!--<input type="text" id="periodo" name="periodo" placeholder="per" style="width: 50px; display: none;" required/>
													<label style="color: white;">...</label>-->
													<button id="submit" class="btn" style="background-color: #ff9805; color: white;">Generate</button>
												</li>
                							</ul>
                							<input type="hidden" id="tipo_carnet" name="tipo_carnet" value="EMP"/>
                							<input type="hidden" id="selgra1" name="selgra1" value="0"/>
                					</ul>
                					</form>
                				</fieldset>

                			</div>
                			<div id="div2">
                				<fieldset>
                				<legend><h3 style="color: #FC0D8C;">CONSULT EMPLOYEE CARD</h3></legend>
                				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                					<ul class="mprincipal">
                						<li><h3>CARD LIST BY<span style="color: white;">.....</span>
                						</h3></li>
                							<ul class="msecund" style="background-color: #222a75;">
                								<li style="background-color: #222a75;">
													<input type="text" id="idanio" name="idanio" placeholder="year" style="width: 50px;" value="2021"/>
													<label style="color: white;">...</label>
													<button id="submit1" class="btn" style="background-color: #ff9805; color: white;" onclick="consultar_carnet()">Search</button>
												</li>
                							</ul>
                					</ul>
                					<!--</form>-->
                				</fieldset>

                			</div>
                		</div></br>
						<div id="resul_bus">

						</div>
						<?php
            				$mysqli1->close();
            			?>
						<!---------------------------------------------->
						<input type='search' placeholder='Enter search text' id='search' name='search' style="display: none;"><br/><br/>
						<div id="divtabla">

						</div>
						<div id="divcontrol" style="display: none;">
						    <label id="lblgra"></label><label id="lblgra1"></label>
						</div>

					</div>
           		</div>
      		</div>
        	</div>
		</section>
	<!--footer-->
	<?php //require 'footer.php'; ?>
    <!--//footer-->
	</div>
	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="../js/classie.js"></script>
		<script>
			let menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
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
	<script type="text/javascript">
		$('#tipo_certificado').change(function(){
    let valorCambiado =$(this).val();
    if((valorCambiado == 'Estudio')){
       $('#select_periodo').hide();

     }
     if (valorCambiado=='Notas') {
     	$('#select_periodo').show();
     }
});
	</script>

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
</body>
<?php 
}
else{
	echo "<script>alert('You must log in');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>