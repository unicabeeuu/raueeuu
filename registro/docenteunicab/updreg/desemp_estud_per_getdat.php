<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
if (isset($_SESSION['uniprofe'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
    //echo $id;
    if($id == 18 || $id == 3 || $id == 2 || $id == 4) {
        $query = "SELECT * FROM equivalence_idgra WHERE id_grado_ra > 0 AND id_grado_ra <= 18";
    }
    else {
        //$query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id";
        $query = "SELECT DISTINCT a.* FROM 
            (SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id 
			AND eg.id_grado_ra > 0 AND eg.id_grado_ra <= 18 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_apoyos_direccion ad WHERE eg.id_grado_ra = ad.id_grado AND ad.id_empleado = $id 
			AND eg.id_grado_ra > 0 AND eg.id_grado_ra <= 18 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id 
			AND eg.id_grado_ra > 0 AND eg.id_grado_ra <= 18 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_dir_b db WHERE eg.id_grado_ra = db.id_grado AND db.id_empleado = $id 
			AND eg.id_grado_ra > 0 AND eg.id_grado_ra <= 18 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_dir_c dc WHERE eg.id_grado_ra = dc.id_grado AND dc.id_empleado = $id 
			AND eg.id_grado_ra > 0 AND eg.id_grado_ra <= 18 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_dir_d dd WHERE eg.id_grado_ra = dd.id_grado AND dd.id_empleado = $id 
			AND eg.id_grado_ra > 0 AND eg.id_grado_ra <= 18 ) a";
    }
    //echo $query;
    $resultado = $mysqli1->query($query);
?>

<html lang="es">
	<head><meta charset="gb18030">
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../images/favicon.png" />
        <!-- // Favicon -->
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        
        <!-- Bootstrap Core CSS -->
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        
        <!-- Custom CSS -->
        <link href="../../css/style.css" rel='stylesheet' type='text/css' />
        
        <!-- font-awesome icons CSS -->
        <link href="../../css/font-awesome.css" rel="stylesheet"> 
        <!-- //font-awesome icons CSS-->
        
        <!-- side nav css file -->
        <link href='../../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
        <!-- //side nav css file -->
        
        <!-- js-->
        <!--<script src="../../js/jquery-1.11.1.min.js"></script>-->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="../../js/modernizr.custom.js"></script>
        
        <script type="text/javascript" src="js/reg.js"></script>
        
        <!--webfonts-->
        <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--//webfonts--> 
        
        <!--css tabla -->
        <link href="../../css/jquery.dataTables.min.css" rel="stylesheet"> 
        <!-- // css tabla -->
        
		<link rel="stylesheet" href="css/reg.css" />
		
		<!-- Metis Menu -->
        <script src="../../js/metisMenu.min.js"></script>
        <script src="../../js/custom.js"></script>
        <link href="../../css/custom.css" rel="stylesheet">
        <!--//Metis Menu -->
        
        <style>
            thead {
                background-color: gray;
                color: white;
            }
            td.perdio {
                color: red;
                border-right: 1px solid black;
            }
        </style>
        <script>
            
            $(function() {
                //alert("hola");
                $("#selgra1").change(function() {
                    $("#resul_bus").hide("");
                    
                    var gra = $("#selgra1").val();
                    //alert (gra);
            		
            		if(gra == "NA") {
            			$("#submit").hide("");
            		}
            		else {
            		    var per = $("#selper1").val();
                		if(per == "0") {
                			$("#submit").hide("");
                		}
                		else {
                		    $("#submit").show("");
                		}
            		}
            	});
            	$("#selper1").change(function() {
            	    $("#resul_bus").hide("");
            	    
                    var per = $("#selper1").val();
            		
            		if(per == "0") {
            			$("#submit").hide("");
            		}
            		else {
            		    var gra = $("#selgra1").val();
                		if(gra == "NA") {
                			$("#submit").hide("");
                		}
                		else {
                		    $("#submit").show("");
                		}
            		}
            	});
            	
            	$(".accordion-titulo1").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content1");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#01DF74", "color": "#000000"});
                      $("span.toggle-icon1", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close #00EAFF       
                      contenido.slideUp(250);
                      $(this).css({"background": "#088A4B", "color": "ffffff"});
                      $("span.toggle-icon1", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo2").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content2");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#2E9AFE", "color": "#000000"});
                      $("span.toggle-icon2", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#084B8A", "color": "#ffffff"});
                      $("span.toggle-icon2", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo3").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content3");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#01DFD7", "color": "#000000"});
                      $("span.toggle-icon3", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#088A85", "color": "#ffffff"});
                      $("span.toggle-icon3", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo4").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content4");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#F4FA58", "color": "#000000"});
                      $("span.toggle-icon4", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#D7DF01", "color": "#ffffff"});
                      $("span.toggle-icon4", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo5").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content5");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#FE9A2E", "color": "#000000"});
                      $("span.toggle-icon5", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#DF7401", "color": "#ffffff"});
                      $("span.toggle-icon5", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo6").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content6");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#FF4000", "color": "#000000"});
                      $("span.toggle-icon6", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#B43104", "color": "#ffffff"});
                      $("span.toggle-icon6", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo7").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content7");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#FE2E2E", "color": "#000000"});
                      $("span.toggle-icon7", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#B40404", "color": "#ffffff"});
                      $("span.toggle-icon7", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                $(".accordion-titulo8").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content8");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#FF0040", "color": "#000000"});
                      $("span.toggle-icon8", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#8A0829", "color": "#ffffff"});
                      $("span.toggle-icon8", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                
            	//consultar_desemp();
            });
            
            function consultar_desemp() {
                //alert("hola");
                var data = "per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val();
                //alert(data);
                
                $("#divtabla").empty();
            		
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot").html();
            			if(stot == "0") {
            			    $(".accordion-titulo1").hide();
            			}
            			else {
            			    $(".accordion-titulo1").show();
            			}
            		}
            	});
            	$("#resul_bus").show("");
            	consultar_desemp1();
            }
            
            function consultar_desemp1() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per1.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla1").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot1").html();
            			if(stot == "0") {
            			    $(".accordion-titulo2").hide();
            			}
            			else {
            			    $(".accordion-titulo2").show();
            			}
            		}
            	});
            	consultar_desemp2();
            }
            
            function consultar_desemp2() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per2.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla2").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot2").html();
            			if(stot == "0") {
            			    $(".accordion-titulo3").hide();
            			}
            			else {
            			    $(".accordion-titulo3").show();
            			}
            		}
            	});
            	consultar_desemp3();
            }
            
            function consultar_desemp3() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per3.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla3").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot3").html();
            			if(stot == "0") {
            			    $(".accordion-titulo4").hide();
            			}
            			else {
            			    $(".accordion-titulo4").show();
            			}
            		}
            	});
            	consultar_desemp4();
            }
            
            function consultar_desemp4() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per4.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla4").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot4").html();
            			if(stot == "0") {
            			    $(".accordion-titulo5").hide();
            			}
            			else {
            			    $(".accordion-titulo5").show();
            			}
            		}
            	});
            	consultar_desemp5();
            }
            
            function consultar_desemp5() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per5.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla5").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot5").html();
            			if(stot == "0") {
            			    $(".accordion-titulo6").hide();
            			}
            			else {
            			    $(".accordion-titulo6").show();
            			}
            		}
            	});
            	consultar_desemp6();
            }
            
            function consultar_desemp6() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per6.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla6").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot6").html();
            			if(stot == "0") {
            			    $(".accordion-titulo7").hide();
            			}
            			else {
            			    $(".accordion-titulo7").show();
            			}
            		}
            	});
            	consultar_desemp7();
            }
            
            function consultar_desemp7() {
                //alert("hola");
                $.ajax({
            		type:"POST",
            		url:"desemp_estud_per7.php",
            		data:"per=" + $("#selper1").val() + "&idgra=" + $("#selgra1").val() + "&selgrupo=" + $("#selgrupo").val(),
            		success:function(r) {
            		    //alert(r);
            			$("#divtabla7").html(r);
            			//$("#tbodyact").html(r);
            			var stot = $("#stot7").html();
            			if(stot == "0") {
            			    $(".accordion-titulo8").hide();
            			}
            			else {
            			    $(".accordion-titulo8").show();
            			}
            		}
            	});
            }
            
            function enviardat(idest, bio, soc, num, fis, esp, ing, tec, nombre, idgra) {
                //alert (idact);
                $("#txtidest").val(idest);
                $("#txtnom").val(nombre);
                $("#txtbio").val(bio);
                $("#txtsoc").val(soc);
                $("#txtnum").val(num);
                if(idgra == 11 || idgra == 12 || idgra == 17 || idgra == 18) {
                    $("#txtfis").val(fis);
                }
                else {
                    $("#txtfis").val("--");
                }
                $("#txtesp").val(esp);
                $("#txting").val(ing);
                $("#txttec").val(tec);
                
                $.ajax({
            		type:"POST",
            		url:"consultar_acudiente.php",
            		data:"idest=" + idest,
            		success:function(r) {
            		    var arrayDatos = r.split("|");
            		    
            		    $("#txtacu1").val(arrayDatos[0]);
            		    $("#txtcel1").val(arrayDatos[1]);
            		    $("#txtacu2").val(arrayDatos[2]);
            		    $("#txtcel2").val(arrayDatos[3]);
            		}
            	});
            }
            
        </script>
	</head>
	<body id="bodyadm" class="cbp-spmenu-push">
	    <div class="main-content">
    		<?php 
    		    if($id == 18) {
		        require 'menu_adm.php';
    		    }
    		    else {
    		        //require 'menu.php';
    		        require 'menu_tutores.php';
    		    }  
    		?>
    		<!-- header-starts -->
    		<?php require 'header.php';  ?>
    		<!-- modal -->
    		<section>
    			<?php require 'modal.php';  ?>
    		</section>
    		
    		<!-- main content start-->
            <section>
               	<div id="page-wrapper">
               		<div class="charts">		
               		 	<div class="mid-content-top charts-grids">	
                        	 
                        			<!---------------------------------------------->
                                    <div id="cont">
                            			
                            			<!--***********************************************************************************************-->
                            			<div id="div2">
                            			    <fieldset>
                            				<legend><h3>RESULTADOS DE ESTUDIANTES</h3></legend>
                            				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                            					<ul class="mprincipal">
                            						<li><h3>LISTADO POR<span style="color: white;">.....</span>
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
																<select id="selper1" name="selper1" required>
																    <option value="0" selected>Seleccione periodo</option>
																    <option value="1">1</option>
																    <option value="2">2</option>
																    <option value="3">3</option>
																    <option value="4">4</option>
																</select>
																<label style="color: white;">...</label>
																<select id="selgrupo" name="selgrupo" required>
																    <option value="NA" selected>Grupo</option>
																    <option value="A">A</option>
																    <option value="B">B</option>
																    <option value="C">C</option>
																    <option value="D">D</option>
																</select>
																<label style="color: white;">...</label>
																<!--<a href="estudianteg_getdat.php" >Buscar</a>
																<input type="submit" id="submitxxx" class="btn btn-primary" value="Buscarxx" style="display: none;">-->
																<button id="submit" class="btn btn-primary" style="display: none;" onclick="consultar_desemp()">Cargar</button>
															</li>
                            							</ul>
                            					</ul>
                            					<!--</form>-->
                            				</fieldset>
                            			</div>
                            		</div></br>
									<div id="resul_bus" style="display: none;">
									    <div class="accordion-titulo1" style="background: #088A4B; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon1" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van pasando todos los pensamientos.
    									</div>
    									<div class="accordion-content1" style="display: none;"><!--********************-->
            								<div id="divtabla">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo2" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon2" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 1 pensamiento.
    									</div>
    									<div class="accordion-content2" style="display: none;"><!--********************-->
            								<div id="divtabla1">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo3" style="background: #088A85; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon3" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 2 pensamientos.
    									</div>
    									<div class="accordion-content3" style="display: none;"><!--********************-->
            								<div id="divtabla2">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo4" style="background: #D7DF01; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon4" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 3 pensamientos.
    									</div>
    									<div class="accordion-content4" style="display: none;"><!--********************-->
            								<div id="divtabla3">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo5" style="background: #DF7401; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon5" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 4 pensamientos.
    									</div>
    									<div class="accordion-content5" style="display: none;"><!--********************-->
            								<div id="divtabla4">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo6" style="background: #B43104; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon6" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 5 pensamientos.
    									</div>
    									<div class="accordion-content6" style="display: none;"><!--********************-->
            								<div id="divtabla5">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo7" style="background: #B40404; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon7" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 6 pensamientos.
    									</div>
    									<div class="accordion-content7" style="display: none;"><!--********************-->
            								<div id="divtabla6">
            								    
            								</div>
        								</div>
        								<div class="accordion-titulo8" style="background: #8A0829; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon8" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Listado de estudiantes que van perdiendo 7 pensamientos.
    									</div>
    									<div class="accordion-content8" style="display: none;"><!--********************-->
            								<div id="divtabla7">
            								    
            								</div>
        								</div>
									</div>
									<!---------------------------------------------->
									
                  		 	
               			</div>
           			</div>	
           		</div>
    		</section>
    	<!--footer-->
    	<?php //require '../footer.php'; ?>
        <!--//footer-->
    	</div>
    	
    	<!-- Modal de datos acudiente estudiante -->
        <div class="modal fade" id="modal_dat_acud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <!--<h5 class="modal-title" id="exampleModalLabel">DATOS</h5>-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>Id_est</label>
                <input type="text" id="txtidest" class="form-control" readonly/>
                <label>Nombres</label>
                <input type="text" id="txtnom" class="form-control" readonly/>
                <label>Calificaciones</label>
                <div>
                    <label>BIO</label>
                    <input type="text" id="txtbio" style="width: 30px;" readonly/>
                    <label>SOC</label>
                    <input type="text" id="txtsoc" style="width: 30px;" readonly/>
                    <label>NUM</label>
                    <input type="text" id="txtnum" style="width: 30px;" readonly/>
                    <label>FIS</label>
                    <input type="text" id="txtfis" style="width: 30px;" readonly/>
                    <!--<label id="lblval"></label>-->
                    <label>ESP</label>
                    <input type="text" id="txtesp" style="width: 30px;" readonly/>
                    <label>ING</label>
                    <input type="text" id="txting" style="width: 30px;" readonly/>
                    <label>TEC</label>
                    <input type="text" id="txttec" style="width: 30px;" readonly/>
                </div>
                <label>Acudiente 1</label>
                <input type="text" id="txtacu1" class="form-control" readonly/>
                <label>Cel. Acudiente 1</label>
                <input type="text" id="txtcel1" class="form-control" readonly/>
                <label>Acudiente 2</label>
                <input type="text" id="txtacu2" class="form-control" readonly/>
                <label>Cel. Acudiente 2</label>
                <input type="text" id="txtcel2" class="form-control" readonly/>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-warning" id="btnupdpor" data-dismiss="modal" onclick="updpor()">Guardar</button>-->
              </div>
            </div>
          </div>
        </div>
    	
    	<!-- Classie --><!-- for toggle left push menu script -->
    	<script src="../../js/classie.js"></script>
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
    	
    	<!--scrolling js-->
    	<script src="../../js/jquery.nicescroll.js"></script>
    	<script src="../../js/scripts.js"></script>
    	<!--//scrolling js-->
    	
    	<!-- side nav js -->
    	<script src='../../js/SidebarNav.min.js' type='text/javascript'></script>
    	<script>
          $('.sidebar-menu').SidebarNav()
        </script>
    	<!-- //side nav js -->
    	
    	<!-- Bootstrap Core JavaScript -->
       <script src="../../js/bootstrap.js"> </script>
    	<!-- //Bootstrap Core JavaScript -->
    	
    	<!-- js tabla -->
    	<script src="../../js/jquery.dataTables.min.js"></script>
    	<script type="text/javascript">
    		$(document).ready(function() {
        	$('#listEstudiantes').DataTable();	
    		} );
    	</script>
    	<!-- //js tabla -->
		
	</body>
	<?php 
	}else{
		echo "<script>alert('Debes iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	?>
</html>