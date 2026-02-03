<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
	$tabla = $_REQUEST['tabla'];
	
if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    $sql="SELECT * FROM tbl_empleados WHERE email = '".$_SESSION['uniprofe']."' OR email = '".$_SESSION['unisuper']."'";
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
    
    if($id == 18) {
        $query = "SELECT * FROM equivalence_idgra";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id";
    }
    
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
    
    /*$query2 = "SELECT * FROM equivalence_idmat";
    $resultado2=$mysqli1->query($query2);*/
?>

<html lang="es">
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
            .mprincipal {
            	list-style-image: url("img/m26.png");
            	font-weight: bold !important;
	            font-size: 20px !important;
            }
            .GridViewScrollHeader TH, .GridViewScrollHeader TD {
                padding: 5px;
                font-weight: normal;
                background-color: #CCCCCC;
                color: #000000;
            }
            
            .GridViewScrollItem TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridViewScrollItemFreeze TD {
                padding: 5px;
                background-color: #CCCCCC;
                color: #444444;
            }
            
            .GridViewScrollFooterFreeze TD {
                padding: 5px;
                color: #444444;
            }
            #divformulas {
                display: flex;
                justify-content: space-around;
            }
        </style>
        <script>
            
            $(function() {
                //alert("hola");
                $("#selgra1").change(function() {
                    $("#divtabla").empty();
                    //$("#tbodyact").empty();
                    $("#txtidtp").val(0);
                    $("#lblformulaok").html("");
                    $("#lblformulaok1").html("");
                    $("#lblformulaerror").html("");
                    $("#btnformula").hide();
                    $("#btndesformula").hide();
                    
                    var gra = $("#selgra1").val();
            		$("#lblgra").html("Grado = " + gra);
                    
            		/*if(gra == "NA") {
            			$("#submit").hide("");
            		}
            		else {
            		    var pen = $("#selpen1").val();
                		if(pen == "NA") {
                			$("#submit").hide("");
                		}
                		else {
                		    $("#submit").show("");
                		}
            		}*/
            		$("#submit").hide("");
            		cargarpen_act_mood(gra);
            	});
            	
            	$("#selpen1").change(function() {
            	    $("#divtabla").empty();
            	    //$("#tbodyact").empty();
            	    $("#txtidtp").val(0);
            	    $("#lblformulaok").html("");
            	    $("#lblformulaok1").html("");
                    $("#lblformulaerror").html("");
                    $("#btnformula").hide();
                    $("#btndesformula").hide();
            		
            		var pen = $("#selpen1").val();
            		if(pen == "NA") {
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
            		
            		$("#lblpen").html("Pensamiento = " + pen);
            	});
            });
            
            function cargarpen_act_mood(gra) {
            	$.ajax({
            		type:"POST",
            		url:"cargarpen_act_mood.php",
            		data:"idgra=" + $("#selgra1").val(),
            		success:function(r) {
            			$("#selpen1").html(r);
            		}
            	});
            }
            
            function consultar_act() {
                $.ajax({
            		type:"POST",
            		url:"act_moodle_getdat1.php",
            		data:"idgra=" + $("#selgra1").val() + "&idpen=" + $("#selpen1").val(),
            		success:function(r) {
            			$("#divtabla").html(r);
            			//$("#tbodyact").html(r);
            		}
            	});
            }
            
            function updpor() {
                var datos = "idgra=" + $("#txtidgra").val() + "&idpen=" + $("#txtidpen").val() + "&por=" + $("#txtporc").val() 
            		+ "&comp=" + $("#txtcomputar").val() + "&idact=" + $("#txtidact").val();
            	//alert(datos);
            	$("#txtidtp").val($("#txtcomputar").val());
            	
                $.ajax({
            		type:"POST",
            		url:"act_moodle_upddat1.php",
            		data:"idgra=" + $("#txtidgra").val() + "&idpen=" + $("#txtidpen").val() + "&por=" + $("#txtporc").val() 
            		+ "&comp=" + $("#txtcomputar").val() + "&idact=" + $("#txtidact").val(),
            		success:function(r) {
            		    $("#divtabla").empty();
            			consultar_act();
            		}
            	});
            	
            	$("#btnformula").show();
            	$("#lblformulaok").html("");
            	$("#lblformulaerror").html("");
            }
            
            function enviardat(idact, actividad, idgra, idpen, idnumber) {
                //alert (idact);
                $("#txtidact").val(idact);
                $("#txtact").val(actividad);
                $("#txtidgra").val(idgra);
                $("#txtidpen").val(idpen);
                $("#txtporc").val("");
                
                $("#lblformulaok").html("");
		        $("#lblformulaerror").html("");
		        $("#lblformulaok1").html("");
		        $("#btndesformula").hide();
                
                $("#lblval").html("");
                //alert ($("#txtidtp").val());
                if($("#txtidtp").val() == 0) {
                    $("#txtcomputar").val("");
                    $("#txtcomputar").prop("readonly", false);
                }
                else {
                    $("#txtcomputar").prop("readonly", true);
                }
                //alert (idnumber);
                /*if(idnumber == "") {
                    $("#lblval").html("El idnumber de esta actividad no se encuentra registrado en moodle").css("color","red");
                    $("#btnupdpor").hide();
                }
                else {
                    $("#lblval").html("");
                    $("#btnupdpor").show();
                }*/
            }
            
            function validapor() {
                var input_por = document.getElementById("txtporc");
                var patron = /^[0-9]{1,3}$/;
                //var esCoincidente = patron.test(document.getElementById("email2").value);
                var esCoincidente = patron.test($("#txtporc").val());
                if(esCoincidente) {
                    input_por.setCustomValidity("");
                    $("#lblval").html("");
                    $("#btnupdpor").show();
                }
                else {
                    input_por.setCustomValidity("Ingrese s車lo n迆meros para el porcentaje y m芍ximo tres d赤gitos");
                    $("#lblval").html("Ingrese SOLO NUMEROS para el porcentaje  y MAXIMO 3 DIGITOS.").css("color","red");
                    $("#btnupdpor").hide();
                }
                
                if($("#txtporc").val() > 100 || $("#txtporc").val() < 0) {
                    $("#lblval").html("El valor ingresado de porcentaje no puede ser mayor a 0 y menor que 100.").css("color","red");
                    $("#btnupdpor").hide();
                }
            }
            
            function genformula() {
                $.ajax({
            		type:"POST",
            		url:"act_formula_upddat.php",
            		data:"idact=" + $("#txtidtp").val() + "&idgra=" + $("#txtidgra").val() + "&idpen=" + $("#txtidpen").val(),
            		success:function(r) {
            		    var res = JSON.parse(r);
            			console.log(res);
            			var datos = res.datos;
        			
            		    if(datos.resultado == "Error") {
            		        $("#lblformulaok").html("");
            		        $("#lblformulaerror").html(datos.msg);
            		        $("#btndesformula").hide();
            		        $("#lblformulaok1").html("");
            		    }
            		    else {
            		        $("#lblformulaok").html(datos.form);
            		        $("#lblformulaerror").html("");
            		        $("#btndesformula").show();
            		        $("#lblformulaok1").html(datos.form1);
            		    }
            		    
            			consultar_act();
            		}
            	});
            }
            
            function verformula(idact) {
                $("#txtidtp").val(idact);
                
                $.ajax({
            		type:"POST",
            		url:"act_formula_getdat.php",
            		data:"idact=" + idact,
            		success:function(r) {
            		    var res = JSON.parse(r);
            			console.log(res);
            			var datos = res.datos;
            			
            			if(datos.resultado == "Ok") {
            			    $("#lblformulaok").html(datos.form);
            		        $("#lblformulaok1").html(datos.form1);
            		        $("#btndesformula").show();
            			}
            			else {
            			    $("#lblformulaok").html("");
            		        $("#lblformulaok1").html("");
            		        $("#btndesformula").hide();
            			}
            		    
            		}
            	});
            }
            
            function deshacerformula() {
                
                $.ajax({
            		type:"POST",
            		url:"act_formula_deldat.php",
            		data:"idact=" + $("#txtidtp").val(),
            		success:function(r) {
            		    //alert (r);
            		    if(r == "ForDesOk") {
            		        $("#lblformulaok").html("");
            		        $("#lblformulaerror").html("");
            		        $("#btnformula").hide();
            		        $("#btndesformula").hide();
            		        $("#lblformulaok1").html("");
            		    }
            		    
            			consultar_act();
            		}
            	});
            	
            	$("#txtidtp").val(0);
                
            }
        </script>
	</head>
	<body id="bodyadm" class="cbp-spmenu-push">
	    <div class="main-content">
    		<?php require 'menu.php';  ?>
    		<!-- header-starts -->
    		<?php require 'header.php';  ?>
    		<!-- modal -->
    		<section>
    			<?php require '../modal.php';  ?>
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
                            				<legend><h3>ADMINISTRACION DE <?php echo $tabla; ?></h3></legend>
                            				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                            					<ul class="mprincipal">
                            						<li><h3>LISTADO DE ACTIVIDADES POR<span style="color: white;">.....</span>
                            						</h3></li>
                            							<ul class="msecund">
                            								<li>
																<select id="selgra1" name="selgra1" required>
																    <option value="NA">Seleccione grado</option>
																    <?php 
																        while($row = $resultado1->fetch_assoc()){
																            echo "<option value='".$row['id_category']."'>".$row['name']."</option>";
																        }
																    ?>
																</select>
																<label style="color: white;">...</label>
																<select id="selpen1" name="selpen1" required>
																    
																</select>
																<label style="color: white;">...</label>
																<!--<a href="estudianteg_getdat.php" >Buscar</a>
																<input type="submit" id="submitxxx" class="btn btn-primary" value="Buscarxx" style="display: none;">-->
																<button id="submit" class="btn btn-primary" style="display: none;" onclick="consultar_act()">Buscar</button>
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
    								<div id="divtabla">
    								    
    								</div>
    								<input type="hidden" id="txtidtp"/>
    								<div id="divformulas">
    								    <div>
    								        <button id="btnformula" class="btn btn-primary" onclick="genformula()" style="display: none;">GENERAR FORMULA FINAL</button>
    								    </div>
    								    <div>
    								        <p><lbl id="lblformulaok1" class="btn-success"></lbl>
    								        <lbl id="lblformulaerror" class="btn-danger"></lbl></p>
    								        <p style="display: none;"><lbl id="lblformulaok" class="btn-warning"></p>
    								    </div>
    								    <div>
    								        <button id="btndesformula" class="btn btn-danger" onclick="deshacerformula()" style="display: none;">DESHACER FORMULA</button>
    								    </div>
    								</div>
    								<div id="divcontrol" style="display: none;">
    								    <label id="lblgra"></label><label id="lblpen"></label>
    								</div>
    								
                  		 	
               			</div>
           			</div>	
           		</div>
    		</section>
    	<!--footer-->
    	<?php //require '../footer.php'; ?>
        <!--//footer-->
    	</div>
    	
    	<!-- Modal de edici車n de c芍lculo -->
        <div class="modal fade" id="modal_porcentajes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PORCENTAJES Y CALCULO DE CALIFICACIONES</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>Id_act</label>
                <input type="text" id="txtidact" class="form-control" readonly/>
                <label>Actividad</label>
                <input type="text" id="txtact" class="form-control" readonly/>
                <label>Id_gra</label>
                <input type="text" id="txtidgra" class="form-control" readonly/>
                <label>Id_pen</label>
                <input type="text" id="txtidpen" class="form-control" readonly/>
                <label>Porcentaje</label>
                <input type="text" id="txtporc" class="form-control" oninput="validapor()"/>
                <label>Computar en</label>
                <input type="text" id="txtcomputar" class="form-control" oninput="validacomputar()"/>
                <label id="lblval"></label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnupdpor" data-dismiss="modal" onclick="updpor()">Guardar</button>
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
    	
    	<!-- validar combo periodo -->
    	<script type="text/javascript">
    		function validacion() {
    			var grado=document.getElementById('id_grado').value;
    			if (grado==0) {
    				$('#alert').html('<center><strong>Advertencia</strong> Debe seleccionar un grado valido</center>').slideDown(500);
    				return false;
    			}else{
    				$('#alert').html('').slideUp(300);
    			}
    		}
    	</script>
    	<!-- // validar combo periodo -->
		
	</body>
	<?php 
	}else{
		echo "<script>alert('Debes iniciar sesión');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	?>
</html>