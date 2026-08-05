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
		# $director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		$perfil = $fila['perfil'];
    }
    
    if($id == 18 || $id == 3  || $id == 43 || $id == 8 || $id == 2) {
        $query = "SELECT * FROM tbl_equivalence_idgra WHERE id_grado_ra = 0 OR (id_grado_ra BETWEEN 9 AND 12) ORDER BY id_grado_ra";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM tbl_equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id AND (eg.id_grado_ra = 0 OR eg.id_grado_ra BETWEEN 9 AND 12) ORDER BY eg.id_grado_ra";
    }
    
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
    
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Unicab Academic Registry</title>
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
        $("#selgra1").change(function() {
            $("#divtabla").empty();
            $("#search").hide();
            $("#idest").val("0");
            $("#submit1").hide("");
            
            $("#resul_est").html("");
            
            let gra = $("#selgra1").val();
    		$("#lblgra").html("Grado = " + gra);
    		$("#selgra1_").val(gra);
            
    		if(gra == "NA") {
    			//$("#submit").hide("");
    			$("#btnbuscar").hide("");
    			$("#idest").hide("");
    			$("#periodo").hide("");
    		}
    		else {
    		    //$("#submit").show("");
    		    $("#btnbuscar").show("");
    		    $("#idest").show("");
    		    $("#periodo").show("");
    		}
    	});
    	
    	$("#selgra2").change(function() {
            $("#divtabla").empty();
            $("#resul_est").empty();
            $("#txtidest").val("");
            $("#search").hide();
            $("#idest").val("0");
            $("#submit").hide("");
            $("#idest").hide("");
            $("#periodo").hide("");
            
            let gra = $("#selgra2").val();
    		$("#lblgra1").html("Grado = " + gra);
            
    		if(gra == "NA") {
    			$("#submit1").hide("");
    		}
    		else {
    		    $("#submit1").show("");
    		}
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
    
    function consultar_pazsalvo() {
        let idgra = $("#selgra2").val();
        let anio = $("#idanio").val();
        
        //alert (anio);
        $.ajax({
    		type:"POST",
    		url:"pazsalvo_est_getdat1.php",
    		data:"idgra=" + $("#selgra2").val() + "&anio=" + anio,
    		success:function(r) {
    		    $("#search").show();
    		    $("#divtabla").html(r);
    			//$("#tbodyact").html(r);
    		}
    	});
    }
    
    function consultar_estudiantes() {
        let idgra = $("#selgra1").val();
        let anio = $("#a_").val();
        let idest = $("#idest").val();
        
        $("#txtidest").val("");
        
        //alert (anio);
        $.ajax({
    		type:"POST",
    		url:"est_pazsalvo_getdat1.php",
    		data:"idgra=" + $("#selgra1").val() + "&anio=" + anio + "&idest=" + idest,
    		success:function(r) {
    		    //$("#search").show();
    		    $("#resul_est").html(r);
    			//$("#tbodyact").html(r);
    		}
    	});
    }
    
    function marcaridest(e) {
        //alert("prueba");
        //alert(e);
        
        /*$('.chk').each(function () {                  
         if ($(this).prop('checked'))
         {
          alert('seleccionado --> ' + this.value)
        
          }
        });*/
        
        let valoresCheck = [];

        $("input[type=checkbox]:checked").each(function(){
            valoresCheck.push(this.value);
        });
        
        //alert(valoresCheck);
        $("#txtidest").val(valoresCheck);
        
        if($("#txtidest").val() != "") {
            $("#submit").show("");
        }
        else {
            $("#submit").hide("");
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
			else if($perfil == "ARCH") {
		        require 'menu_archivo.php';
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
							<?php
								if($id != 8) { 
							?>
                			<div id="div1" style="width: 50%">
                				<fieldset>
                				<legend><h3 style="color: #FC0D8C;">GENERATE STUDENT CLEARANCE</h3></legend>
                				    <ul class="mprincipal">
                						<li><h3>GENERATE CLEARANCE BY<span style="color: white;">.....</span>
                						</h3></li>
                							<ul class="msecund" style="background-color: #222a75;">
                								<li style="background-color: #222a75;">
													<select id="selgra1" name="selgra1" required>
													    <option value="NA" selected>Select grade</option>
													    <?php 
													        while($row = $resultado->fetch_assoc()){
													            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
													        }
													    ?>
													</select>
													<label style="color: white;">...</label>
													<input type="text" id="idest" name="idest" placeholder="idest" style="width: 50px; display: none;" value="0" onchange="idest_.value = this.value"/>
													<label style="color: white;">...</label>
													<input type="text" id="periodo" name="periodo" placeholder="year" style="width: 50px;" value="2025" onchange="a_.value = this.value"/>
													<label style="color: white;">...</label>
													<button id="btnbuscar" class="btn" style="display: none; background-color: #ff9805; color: white;" onclick="consultar_estudiantes()">Search</button>
												</li>
                							</ul>
                							
                					</ul>
                					<div id="resul_est">
            						    
            						</div>
            						
            						<form class="form-horizontal" action="../docenteunicab/updreg/pazysalvo_getdat1.php"  method="POST" target="_blank">
            						    <input type="hidden" id="selgra1_" name="selgra1_">
            						    <input type="hidden" id="idest_" name="idest_">
            						    <input type="hidden" id="a_" name="a_" value="2025">
            						    <div>
                						    <label>Student IDs to generate clearance:</label>
                						    <textarea id="txtidest" name="txtidest" readonly style="width: 100%; background: #222a75" height="50px"></textarea>
                						</div>
            						    <input type="submit" id="submit" class="btn" style="background-color: #ff9805; display: none;" value="Generate">
                					</form>
                				</fieldset>
                
                			</div>
							<?php
								} 
							?>
							
                			<div id="div2" style="width: 40%">
                				<fieldset>
                				<legend><h3 style="color: #FC0D8C;">CONSULT STUDENT CLEARANCE</h3></legend>
                				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                					<ul class="mprincipal">
                						<li><h3>CLEARANCE LIST BY<span style="color: white;">.....</span>
                						</h3></li>
                							<ul class="msecund" style="background-color: #222a75;">
                								<li style="background-color: #222a75;">
													<select id="selgra2" name="selgra2" required>
													    <option value="NA" selected>Select grade</option>
													    <?php 
													        while($row = $resultado1->fetch_assoc()){
													            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
													        }
													    ?>
													</select>
													<label style="color: white;">...</label>
													<input type="text" id="idanio" name="idanio" placeholder="year" style="width: 50px;" value="2025"/>
													<label style="color: white;">...</label>
													<button id="submit1" class="btn" style="display: none; background-color: #ff9805; color: white;" onclick="consultar_pazsalvo()">Search</button>
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
	echo "<script>alert('Debes iniciar sesiÃ³n');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>