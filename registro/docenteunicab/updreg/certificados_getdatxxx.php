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
    
    if($id == 18 || $id == 3) {
        $query = "SELECT * FROM equivalence_idgra";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id";
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
                //Se valida el id del empleador para mostrar la opción de generar certificados
                var idemp = $("#idemp").val();
                if(idemp == 18) {
                    
                }
                else {
                    $("#div1").hide();
                }
                
                //alert("hola");
                $("#selgra1").change(function() {
                    $("#divtabla").empty();
                    $("#search").hide();
                    
                    var gra = $("#selgra1").val();
            		$("#lblgra").html("Grado = " + gra);
                    
            		if(gra == "NA") {
            			$("#submit").hide("");
            		}
            		else {
            		    $("#submit").show("");
            		}
            	});
            	
            	$("#selgra2").change(function() {
                    $("#divtabla").empty();
                    $("#search").hide();
                    
                    var gra = $("#selgra2").val();
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
            
            function consultar_cert() {
                var idgra = $("#selgra2").val();
                //alert (idgra);
                $.ajax({
            		type:"POST",
            		url:"certificados_getdat1.php",
            		data:"idgra=" + $("#selgra2").val(),
            		success:function(r) {
            		    $("#search").show();
            		    $("#divtabla").html(r);
            			//$("#tbodyact").html(r);
            		}
            	});
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
                            			<div id="div1">
                            				<fieldset>
                            				<legend><h3>GENERAR CERTIFICADOS DE NOTAS</h3></legend>
                            				    <form class="form-horizontal" action="reporte_notas_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
																<button id="submit" class="btn btn-primary" style="display: none;" >Generar</button>
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            
                            			</div>
                            			<div id="div2">
                            				<fieldset>
                            				<legend><h3>CONSULTAR CERTIFICADOS DE NOTAS</h3></legend>
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
    								    <input type="hidden" id="idemp" name="idemp" value="<?php echo $id; ?>"/>
    								</div>
    								
                  		 	
               			</div>
           			</div>	
           		</div>
    		</section>
    	<!--footer-->
    	<?php //require '../footer.php'; ?>
        <!--//footer-->
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