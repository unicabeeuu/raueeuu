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
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/gridviewscroll.js"></script>
        
        <!--webfonts-->
        <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--//webfonts--> 
        
        <!--css tabla
        <link href="../../css/jquery.dataTables.min.css" rel="stylesheet">--> 
        <!-- // css tabla -->
        
		<link rel="stylesheet" href="css/reg.css" />
		
		<!-- Metis Menu
        <script src="../../js/metisMenu.min.js"></script>
        <script src="../../js/custom.js"></script>-->
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
            var gridViewScroll = null;
            
            $(function() {
                var options = new GridViewScrollOptions();
                options.elementID = "tblformula";
                options.width = 800;
                options.height = 300;
                options.freezeColumn = true;
                options.freezeFooter = false;
                options.freezeColumnCssClass = "GridViewScrollItemFreeze";
                options.freezeFooterCssClass = "GridViewScrollFooterFreeze";
                options.freezeColumnCount = 1;
    
                gridViewScroll = new GridViewScroll(options);
                gridViewScroll.enhance();
                
                //alert("hola");
                $("#selgra1").change(function() {
                    $("#divtabla").empty();
                    //$("#tbodyact").empty();
                    $("#txtidtp").val(0);
                    $("#divresul").html("");
                    $("#divtabla").html("");
                    
                    var gra = $("#selgra1").val();
                    //alert(gra);
            		$("#lblgra").html("Grado = " + gra);
            		
            		$("#submit").hide("");
            		$("#btnverf").hide("");
            		//cargarpen_act_mood(gra);
            	});
            	
            	$("#selpen1").change(function() {
            	    $("#divtabla").empty();
            	    //$("#tbodyact").empty();
            	    $("#txtidtp").val(0);
            	    $("#divresul").html("");
            	    $("#divtabla").html("");
            	    
            	    var pen = $("#selpen1").val();
            	    //alert(pen);
            		if(pen == "NA") {
            			$("#submit").hide("");
            			$("#btnverf").hide("");
            		}
            		else {
            		    var gra = $("#selgra1").val();
                		if(gra == "NA") {
                			$("#submit").hide("");
                			$("#btnverf").hide("");
                		}
                		else {
                		    $("#submit").show("");
                		    $("#btnverf").show("");
                		}
            		}
            		
            		$("#lblpen").html("Pensamiento = " + pen);
            	});
            });
            
            function actualizar_cal_mood() {
                alert("idgra=" + $("#selgra1").val() + "&idpen=" + $("#selpen1").val());
                $.ajax({
            		type:"POST",
            		url:"calif_mood_upddat1.php",
            		data:"idgra=" + $("#selgra1").val() + "&idpen=" + $("#selpen1").val(),
            		success:function(r) {
            			$("#divresul").html(r);
            		}
            	});
            	
            	//ver_tabla();
            }
            
            function ver_tabla() {
                $.ajax({
            		type:"POST",
            		url:"ver_form_mood_getdat.php",
            		data:"idgra=" + $("#selgra1").val() + "&idpen=" + $("#selpen1").val(),
            		success:function(r) {
            		    //alert(r);
            		    //$("#tbodyform").remove();
            		    //$("#tblformula").append('<tbody id="tbodyform"></tbody>');
            		    //$("#tblformula > tbody").html("");
            		    //$("#tbodyform").html(r);

            		    //Se borra el div tabla1
            			$("#divtabla1").remove();
            			//Se genera un nuevo div tabla1
            			$("#divtabla").append('<div id="divtabla1"></div>');
            			
            			$("#divtabla1").html(r);
            		}
            	});
            }
        </script>
	</head>
	<body id="bodyadm" class="cbp-spmenu-push">
	    <div class="main-content">
    		<?php 
    		    if($id == 18 || $id == 40) {
		        require 'menu_adm.php';
    		    }
    		    else {
    		        require 'menu.php';
    		    }  
    		?>
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
                            				<legend><h3>ACTUALIZAR CALCULO DE CALIFICACIONES MOODLE</h3></legend>
                            				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                            					<ul class="mprincipal">
                            						<li><h3>CALIFICACIONES POR<span style="color: white;">.....</span>
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
																<button id="submit" class="btn btn-primary" style="display: none;" onclick="actualizar_cal_mood()">Actualizar</button>
																<button id="btnverf" class="btn btn-primary" style="display: none;" onclick="ver_tabla()">Ver registros</button>
															</li>
                            							</ul>
                            					</ul>
                            					<!--</form>-->
                            				</fieldset>
                            
                            			</div>
                            		</div></br>
									<div id="divresul">
									    
									</div>
									<div id="divtabla" style="width: 600px;">
    								    <div id="divtabla1"></div>
    								    <!--<table id="tblformula">
    								        <thead>
    								            <tr class='GridViewScrollHeader'>
                    	                            <td>Grado</td>
                    	                            <td>Id_gra</td>
                    	                            <td>Pensamiento</td>
                    	                            <td>Id_pen</td>
                    	                            <td>Idnumber</td>
                    	                            <td>Id_act</td>
                    	                            <td>Calculation</td>
                    	                            <td>...</td>
                    	                        </tr>
    								        </thead>
    								        <tbody id="tbodyform">
    								            <tr class='GridviewScrollItem'>
                    	                            <td>primero</td>
                    	                            <td>1</td>
                    	                            <td>num</td>
                    	                            <td>1</td>
                    	                            <td>a1p1</td>
                    	                            <td>1</td>
                    	                            <td>=</td>
                    	                            <td>...</td>
                    	                        </tr>
                    	                        <tr class='GridviewScrollItem'>
                    	                            <td>segundo</td>
                    	                            <td>2</td>
                    	                            <td>num</td>
                    	                            <td>1</td>
                    	                            <td>a2p1</td>
                    	                            <td>2</td>
                    	                            <td>=</td>
                    	                            <td>...</td>
                    	                        </tr>
    								        </tbody>
    								    </table>-->
    								</div>
									<?php
                        				$mysqli1->close();
                        			?>
    								<!---------------------------------------------->
    								
                  		 	
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