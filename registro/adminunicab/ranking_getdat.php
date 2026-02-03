<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
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
    //echo $id;
    if($id == 18 || $id == 3 || $id == 2 || $id == 4 || $id == 43) {
        $query = "SELECT * FROM equivalence_idgra";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id";
    }
    //echo $query;
    $resultado1 = $mysqli1->query($query);
    
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

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

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
    <style>
        #cont {
        	display: flex;
        	justify-content: space-around;
        }
        fieldset {
        	border: 2px double green;
        	-moz-border-radius: 8px;
        	-webkit-border-radius: 8px;	
        	border-radius: 8px;
        }
        legend {
        	 text-align: center;
        	 font-weight: bold;
        	 font-size: 18pt;
        	 color: #B4045F;
        	 text-shadow: 0px 0px 10px #BA55D3;
        }
        .mprincipal {
        	list-style-image: url(../docenteunicab/updreg/img/m26.png);
        	font-weight: bold !important;
        	font-size: 20px !important;
        }
        .msecund {
        	list-style-image: url(../docenteunicab/updreg/img/bd30.png); 
        	background: lightgreen;
        	padding: 20px;
        	font-weight: bold;
        	font-size: 18px;
        }
        .msecund li {
        	background: #cce5ff;
        	margin-left: 20px;
        	margin-top: 5px;
        }
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
            		url:"../docenteunicab/updreg/ranking_getdat1.php",
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
            		url:"../docenteunicab/updreg/ranking_getdat1.php",
            		data:"idgra=" + $("#selgra1").val() + "&r=999",
            		success:function(r) {
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
           		<div class="charts">		
           		 	<div class="mid-content-top charts-grids">	
                    	<div class="middle-content">
                    		<div class="form-group"> 
                    		
                    			<!---------------------------------------------->
                                <div id="cont">
                        			
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
								<div id="divtabla">
    								    
    							</div>
								<!---------------------------------------------->
								
              		 		</div>
            			</div>
           			</div>
       			</div>	
       		</div>
		</section>
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
	</div>
	
	<!-- Modal de datos acudiente estudiante -->
        <div class="modal fade" id="modal_dat_acud" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">DATOS</h5>
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

	<!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
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
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>