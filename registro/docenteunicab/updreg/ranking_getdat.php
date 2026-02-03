<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
	//https://unicab.org/registro/docenteunicab/updreg/ranking_getdat1.php?idgra=10&r=10
	
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
        /*$query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id";*/
        
        $query = "SELECT DISTINCT a.* FROM 
            (SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_apoyos_direccion ad WHERE eg.id_grado_ra = ad.id_grado AND ad.id_empleado = $id 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_direccion_grado dg WHERE eg.id_grado_ra = dg.id_grado AND dg.id_empleado = $id 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_dir_b db WHERE eg.id_grado_ra = db.id_grado AND db.id_empleado = $id 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_dir_c dc WHERE eg.id_grado_ra = dc.id_grado AND dc.id_empleado = $id 
            UNION ALL 
            SELECT DISTINCT eg.* FROM equivalence_idgra eg, tbl_dir_d dd WHERE eg.id_grado_ra = dd.id_grado AND dd.id_empleado = $id) a";
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
            #txtper {
                width: 50px;
            }
            thead {
                background-color: gray;
                color: white;
            }
            td.falta {
                color: red;
                border-right: 1px solid black;
            }
        </style>
        <script>
            
            $(function() {
                //alert("hola");
                $("#selgra1").change(function() {
                    $("#divtabla").empty();
                    //$("#tbodyact").empty();
                    
                    var gra = $("#selgra1").val();
            		$("#lblgra").html("Grado = " + gra);
                    
            		if(gra == "NA") {
            			$("#submit").hide("");
            			$("#submit1").hide("");
            		}
            		else {
            		    $("#submit").show("");
            		    $("#submit1").show("");
            		}
            		//$("#submit").hide("");
            	});
            });
            
            function consultar_ranking() {
                $("#divtabla").empty();
                
                var gra = $("#selgra1").val();
                //alert(gra);
                $.ajax({
            		type:"POST",
            		url:"ranking_getdat1.php",
            		data:"idgra=" + $("#selgra1").val() + "&r=10",
            		success:function(r) {
            			$("#divtabla").html(r);
            			//$("#tbodyact").html(r);
            		}
            	});
            }
            
            function consultar_ranking1() {
                $("#divtabla").empty();
                
                var gra = $("#selgra1").val();
                //alert(gra);
                $.ajax({
            		type:"POST",
            		url:"ranking_getdat1.php",
            		data:"idgra=" + $("#selgra1").val() + "&r=999",
            		success:function(r) {
            			$("#divtabla").html(r);
            			//$("#tbodyact").html(r);
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
                                    <div id="cont"><?php //echo $query; ?>
                            			
                            			<!--***********************************************************************************************-->
                            			<div id="div2">
                            				<fieldset>
                            				<legend><h3>RANKING ESTUDIANTES </h3></legend>
                            				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                            					<ul class="mprincipal">
                            						<li><h3>LISTADO POR<span style="color: white;">.....</span>
                            						</h3></li>
                            							<ul class="msecund">
                            								<li>
																<select id="selgra1" name="selgra1" required>
																    <option value="NA">Seleccione grado</option>
																    <?php 
																        while($row = $resultado1->fetch_assoc()){
																            echo "<option value='".$row['id_grado_ra']."'>".$row['name']."</option>";
																        }
																    ?>
																</select>
																<label style="color: white;">...</label>
																<!--<a href="estudianteg_getdat.php" >Buscar</a>
																<input type="submit" id="submitxxx" class="btn btn-primary" value="Buscarxx" style="display: none;">-->
																<button id="submit" class="btn btn-primary" style="display: none;" onclick="consultar_ranking()">TOP 10</button>
																<label style="color: white;">...</label>
																<button id="submit1" class="btn btn-primary" style="display: none;" onclick="consultar_ranking1()">TOTAL</button>
    																
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