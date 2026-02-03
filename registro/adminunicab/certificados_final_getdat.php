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
    
    if($id == 18 || $id == 3 || $id == 43 || $id == 2) {
        $query = "SELECT * FROM equivalence_idgra WHERE id_grado_ra >= 2 AND id_grado_ra <= 18";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id";
    }
    
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
    
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />
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
        /*$("#selgra1").change(function() {
            $("#divtabla").empty();
            $("#search").hide();
            $("#idest").val("0");
            $("#submit1").hide("");
            
            var gra = $("#selgra1").val();
    		$("#lblgra").html("Grado = " + gra);
            
    		if(gra == "NA") {
    			$("#submit").hide("");
    			$("#idest").hide("");
    			$("#periodo").hide("");
    		}
    		else {
    		    $("#submit").show("");
    		    $("#idest").show("");
    		    $("#periodo").show("");
    		}
    	});*/
    	
    	$("#selgra2").change(function() {
            $("#divtabla").empty();
            $("#search").hide();
            $("#idest").val("0");
            $("#submit").hide("");
            $("#idest").hide("");
            $("#periodo").hide("");
            
            var gra = $("#selgra2").val();
    		$("#lblgra1").html("Grado = " + gra);
            
    		if(gra == "NA") {
    			$("#submit1").hide("");
    		}
    		else {
    		    $("#submit1").show("");
    		}
    	});
    	
    	$("#sela").change(function() {
            $("#divtabla").empty();
            $("#search").hide();
    	});
    	
    	$("#search").keyup(function(){
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#tblcert tbody tr"), function() {
            //alert ($(this).text());
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
    	
    });
    
    function consultar_cert() {
        var idgra = $("#selgra2").val();
        var anio = $("#sela").val();
        var control = 0;
        
        if (anio == "NA") {
            alert("Seleccione un periodo lectivo");
            $("#divtabla").empty();
            $("#search").hide();
            control = 1;
        }
        //alert (anio);
        
        if(control == 0) {        
            $.ajax({
        		type:"POST",
        		url:"../docenteunicab/updreg/certificados_finales_getdat1.php",
        		data:"idgra=" + $("#selgra2").val() + "&a=" + anio,
        		success:function(r) {
        		    $("#search").show();
        		    $("#divtabla").html(r);
        			//$("#tbodyact").html(r);
        		}
        	});
        }
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
		    else if($perfil == "AR1") {
		        require 'menu_registro_aux.php';
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
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						
						<!---------------------------------------------->
                        <div id="cont">
                			
                			<!--***********************************************************************************************-->
                			<!--<div id="div1">
                				<fieldset>
                				<legend><h3>GENERAR CERTIFICADOS DE NOTAS</h3></legend>
                				    <form class="form-horizontal" action="../docenteunicab/updreg/reporte_notas_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">
                					<ul class="mprincipal">
                						<li><h3>GENRAR CERTIFICADOS POR<span style="color: white;">.....</span>
                						</h3></li>
                							<ul class="msecund">
                								<li>
													<select id="selgra1" name="selgra1" required>
													    <option value="NA" selected>Seleccione grado</option>
													    <?php 
													        while($row = $resultado->fetch_assoc()){
													            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
													        }
													    ?>
													</select>
													<label style="color: white;">...</label>
													<input type="text" id="idest" name="idest" placeholder="idest" style="width: 50px; display: none;" value="0"/>
													<label style="color: white;">...</label>
													<input type="text" id="periodo" name="periodo" placeholder="per" style="width: 50px; display: none;" required/>
																<label style="color: white;">...</label>
													<button id="submit" class="btn btn-primary" style="display: none;" >Generar</button>
												</li>
                							</ul>
                					</ul>
                					</form>
                				</fieldset>
                
                			</div>-->
                			<div id="div2">
                				<fieldset>
                				<legend><h3>CONSULTAR CERTIFICADOS FINALES DE NOTAS</h3></legend>
                				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                					<ul class="mprincipal">
                						<li><h3>LISTADO DE CERTIFICADOS POR<span style="color: white;">.....</span>
                						</h3></li>
                							<ul class="msecund">
                								<li>
													<select id="selgra2" name="selgra2" required>
													    <option value="NA" selected>Seleccione grado</option>
													    <?php 
													        while($row = $resultado1->fetch_assoc()){
													            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
													        }
													    ?>
													</select>
													<label style="color: white;">...</label>
													<select id="sela" name="sela" required>
													    <option value="NA" selected>Seleccione periodo lectivo</option>
													    <option value="2020">2020</option>
													    <option value="2021">2021</option>
													    <option value="2022">2022</option>
													    <option value="2023">2023</option>
													    <option value="2024">2024</option>
													    <option value="2025">2025</option>
														<option value="2026">2026</option>
														<option value="2027">2027</option>
													</select>
													<label style="color: white;">...</label>
													<button id="submit1" class="btn btn-primary" style="display: none;" onclick="consultar_cert()">Buscar</button>
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
						<input type='search' placeholder='Ingrese texto a buscar' id='search' name='search' style="display: none;"><br/><br/>
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
	<script type="text/javascript">
		$('#tipo_certificado').change(function(){
    var valorCambiado =$(this).val();
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
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>