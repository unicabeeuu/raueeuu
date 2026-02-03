<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	//header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: no-store");
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
        //$query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id";
        $query = "SELECT DISTINCT a.* FROM 
        (SELECT DISTINCT eg.* 
        FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id 
        UNION ALL 
        SELECT DISTINCT eg.* 
        FROM equivalence_idgra eg, tbl_dir_b dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id 
        UNION ALL 
        SELECT DISTINCT eg.* 
        FROM equivalence_idgra eg, tbl_dir_c dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id 
        UNION ALL 
        SELECT DISTINCT eg.* 
        FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id) a ";
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
                //Se valida el id del empleador para mostrar la opci¨®n de generar certificados
                var idemp = $("#idemp").val();
                if(idemp == 18 || idemp == 40) {
                    
                }
                else {
                    $("#div1").hide();
                }
                
                //alert("hola");
                $("#selgra1").change(function() {
                    //alert("hola");
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
            		    //alert("mostrar");
            		    $("#submit").show("");
            		    $("#idest").show("");
            		    $("#periodo").show("");
            		}
            		//var selna = "NA";
            		//$("#selgra2 option[value='" + selna + "']").attr("selected",true);
            	});
            	
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
                var anio = $("#idanio").val();
                
                //alert (anio);
                $.ajax({
            		type:"POST",
            		url:"certificados_getdat1.php",
            		data:"idgra=" + $("#selgra2").val() + "&anio=" + anio,
            		success:function(r) {
            		    $("#search").show();
            		    $("#divtabla").html(r);
            			//$("#tbodyact").html(r);
            		}
            	});
            }
            
            function validar_per() {
                var per = $("#peridodo").val();
                alert(per);
                if(per > 1 && per < 5) {
                    $("#submit").show("");
                }
                else {
                    $("#submit").hide("");
                }
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
    		        //require 'menu.php';
    		        require 'menu_tutores.php';
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
																<input type="text" id="idanio" name="idanio" placeholder="a09o" style="width: 50px;" value="2020"/>
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
		echo "<script>alert('Debes iniciar sesiÃ³n');</script>";
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	?>
</html>