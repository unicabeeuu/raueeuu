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
    
    $query = "SELECT * FROM equivalence_idgra WHERE id_grado_ra NOT IN (150, 160, 170, 180, 130, 140, 0)";
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
?>

<html>
	<head><meta charset="shift_jis">
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
        </style>
        <script>
            $(function() {
                //alert("hola");
                /*$("input[name=idest_ra0]").change(function() {
                    alert("hola");
                   $("input[name=idest_ra01]").val(this.val()); 
                });
                $("input[name=idest_ra01]").change(function() {
                    //alert("hola");
                   $("input[name=idest_ra0]").val(this.val()); 
                });*/
            });
            
            function change_idest() {
                var v_idest = document.getElementById("idest_ra0").value;
                //alert(v_idest);
                document.getElementById("idest_ra01").value = v_idest;
            }
            function change_idest1() {
                var v_idest1 = document.getElementById("idest_ra01").value;
                document.getElementById("idest_ra0").value = v_idest1;
            }
            function change_idgra() {
                var v_idgra = document.getElementById("idgra_ra0").value;
                //alert(v_idest);
                document.getElementById("idgra_ra01").value = v_idgra;
            }
            function change_idgra1() {
                var v_idgra1 = document.getElementById("idgra_ra01").value;
                document.getElementById("idgra_ra0").value = v_idgra1;
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
    			<?php require 'modal.php';  ?>
    		</section>
    		
    		<!-- main content start-->
            <section>
               	<div id="page-wrapper">
               		<div class="charts">		
               		 	<div class="mid-content-top charts-grids">	
                        	 
                        			<!---------------------------------------------->
                                    <div id="cont">
                            			<div id="div1">
                            				<fieldset>
                            				<legend><h3>BASE DE DATOS DE ESTUDIANTES</h3></legend>
                            				    <form class="form-horizontal" action="cargar_est_putdat.php"  method="POST" onsubmit="return validacion()">
                            				    <!--Se debe Cargar y luego Actualizar... después revisar manualmente en la tabla equivalence_idest_temp1 -->
                            				    <!--y por último UPD EQUI IDEST -->
                            				    <ul class="mprincipal">
                            						<li><h3>CARGAR INFORMACION MOODLE TOTAL</h3></li>
                            							<ul class="msecund">
                            								<li><input type="submit" class="btn btn-primary" value="Cargar" ></li>
                            								<li><a href="cargar_est_putdat_aanterior.php" class="btn btn-primary" target="_blank">Cargar Año Anterior</a></li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="base_datos_upddat.php"  method="POST" target="_blank">
                            					<ul class="mprincipal">
                            						<li><h3>ACTUALIZAR BASE DE DATOS</h3></li>
                            							<ul class="msecund">
                            								<li>
																<input type="submit" class="btn btn-primary" value="Actualizar" >
																<a href="base_datos_upddat1.php" class="btn btn-primary" target="_blank">UPD EQUI IDEST</a>
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset><br/>
                            				<fieldset>
                            				<legend><h3>REVERSAR PROCESO DE CIERRE</h3></legend>
                            				    <form class="form-horizontal" action="buscar_notas_mood_est1.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>CARGAR NOTAS MOODLE</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="text" id="idest_ra0" name="idest_ra0" placeholder="idest" style="width: 50px;" oninput="change_idest()"/>
                            								    <input type="text" id="idgra_ra0" name="idgra_ra0" placeholder="idgra" style="width: 50px;" oninput="change_idgra()"/>
																<label style="color: white;">...</label>
																<input type="submit" class="btn btn-primary" value="Cargar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="ca_ghf.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>NUEVO CIERRE ACADEMICO</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="text" id="idest_ra01" name="idest_ra01" placeholder="idest" style="width: 50px;" oninput="change_idest1()"/>
                            								    <input type="text" id="idgra_ra01" name="idgra_ra01" placeholder="idgra" style="width: 50px;" oninput="change_idgra1()"/>
																<label style="color: white;">...</label>
                            								    <input type="submit" class="btn btn-primary" value="Cargar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            				<fieldset>
                            				<legend><h3>INFORMES</h3></legend>
                            				    <form class="form-horizontal" action="informe-estudiante1.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>ESTUDIANTE</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="text" id="idest_ra02" name="idest_ra02" placeholder="idest" style="width: 50px;"/>
                            								    <input type="text" id="idgra_ra02" name="idgra_ra02" placeholder="idgra" style="width: 50px;"/>
																<label style="color: white;">...</label>
																<input type="submit" class="btn btn-primary" value="Cargar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            				<fieldset>
                            				<legend><h3>CONFIGURAR ACTIVIDADES</h3></legend>
                            				    <form class="form-horizontal" action="act_moodle_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>CARGAR ACTIVIDADES MOODLE</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="text" id="periodo" name="periodo" placeholder="periodo" style="width: 100px;"/>
                            								    <input type="submit" class="btn btn-primary" value="Cargar" >
															</li>
                            							</ul>
                            					</form>
                            					<form class="form-horizontal" action="tot_act_curso_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>CARGAR TOT ACT POR PENSAM</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <label>tbl_tot_act_curso</label>
                            								    <input type="submit" class="btn btn-primary" value="Cargar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            				<fieldset>
                            				<legend><h3>BASE DE DATOS BCS</h3></legend>
                            				    <form class="form-horizontal" action="bd_bcs_getdat.php"  method="POST" target="_blank">
                            					<ul class="mprincipal">
                            						<li><h3>EXPORTAR BD BCS</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <select id="pago" name="pago">
                            								        <option value="pp" selected>pp</option>
                            								        <option value="02">pm2</option>
                            								        <option value="03">pm3</option>
                            								        <option value="04">pm4</option>
                            								        <option value="05">pm5</option>
                            								        <option value="06">pm6</option>
                            								        <option value="07">pm7</option>
                            								        <option value="08">pm8</option>
                            								        <option value="09">pm9</option>
                            								        <option value="10">pm10</option>
                            								        <option value="dg">dg</option>
                            								        <option value="pm10dg">pm10dg</option>
                            								    </select>
                            								    <input type="submit" class="btn btn-primary" value="Exportar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            				<!--<a href="reporte_notas_getdat.php" target="_blank">Reporte notas</a>
                            				<a href="reporte_notas_getdat1.php" target="_blank">Reporte notas</a>-->
                            			</div>
                            			<!--***********************************************************************************************-->
                            			<div id="div2">
                            				<fieldset>
                            				<legend><h3>BUSCAR EN BASE DE DATOS</h3></legend>
                            				    <form class="form-horizontal" action="estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>BUSCAR POR NOMBRE O APELLIDO <span style="color: blue;">ACTIVO</span></h3></li>
                            							<ul class="msecund">
                            								<li>
																<input type="text" id="buscar" name="buscar" placeholder="Ingrese nombre" required/>
																<label style="color: white;">...</label>
																<!--<a href="estudiante_getdat.php" >Buscar</a>-->
																<input type="submit" class="btn btn-primary" value="Buscar" >
																<input type="hidden" id="estado" name="estado" value="activo" required/>
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>BUSCAR POR NOMBRE O APELLIDO <span style="color: red;">INACTIVO</span></h3></li>
                            							<ul class="msecund">
                            								<li>
																<input type="text" id="buscar" name="buscar" placeholder="Ingrese nombre" required/>
																<label style="color: white;">...</label>
																<!--<a href="estudiante_getdat.php" >Buscar</a>-->
																<input type="submit" class="btn btn-primary" value="Buscar" >
																<input type="hidden" id="estado" name="estado" value="inactivo" required/>
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="estudianteg_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>BUSCAR POR GRADO ACTIVO<span style="color: white;">.....</span>
                            						<input type="checkbox" class="chk" id="chkper" name="chkper"/> <span style="color: red;">Perdiendo</span>
                            						<select id="selper" name="selper">
                            						    <option value="0">Sel. periodo</option>
                            						    <option value="1">1</option>
                            						    <option value="2">2</option>
                            						    <option value="3">3</option>
                            						    <option value="4">4</option>
                            						</select>
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
																<select id="selgrupo" name="selgrupo" required>
																    <option value="NA" selected>Grupo</option>
																    <option value="A">A</option>
																    <option value="B">B</option>
																    <option value="C">C</option>
																    <option value="D">D</option>
																</select>
																<label style="color: white;">...</label>
																<!--<a href="estudianteg_getdat.php" >Buscar</a>-->
																<input type="submit" class="btn btn-primary" value="Buscar" >
																<input type="hidden" id="estadog" name="estadog" value="activo" required/>
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="observaciones_putdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>OBSERVACIONES ESTUDIANTE</h3></li>
                            							<ul class="msecund">
                            								<li>
																<input type="text" id="buscar" name="buscar" placeholder="Ingrese nombre" required/>
																<label style="color: white;">...</label>
																<!--<a href="estudiante_getdat.php" >Buscar</a>-->
																<input type="submit" class="btn btn-primary" value="Asignar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="bd_exportar_getdat.php"  method="POST" target="_blank">
                                					<ul class="mprincipal">
                                						<li><h3>EXPORTAR BASE DE DATOS</h3></li>
                                							<ul class="msecund">
                                								<li>
    																<input type="submit" class="btn btn-primary" value="Exportar" >
    															</li>
                                							</ul>
                                					</ul>
                                				</form>
                                				<form class="form-horizontal" action="bd_exportar_ret_getdat.php"  method="POST" target="_blank">
                                					<ul class="mprincipal">
                                						<li><h3>EXPORTAR RETIRADOS</h3></li>
                                							<ul class="msecund">
                                								<li>
    																<input type="submit" class="btn btn-primary" value="Exportar" >
    															</li>
                                							</ul>
                                					</ul>
                                				</form>
                            					
                            					<form class="form-horizontal" action="desemp_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>PRUEBA DESEMPEÑO</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="text" id="idest_ra" name="idest_ra"/>
																<label style="color: white;">...</label>
																<!--<a href="estudianteg_getdat.php" >Buscar</a>-->
																<input type="submit" class="btn btn-primary" value="Buscar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            					<form class="form-horizontal" action="buscar_notas_mood.php"  method="POST" target="_blank" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>NOTAS MOODLE</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="text" id="idest_ra1" name="idest_ra1" placeholder="idest" style="width: 50px;"/>
                            								    <input type="text" id="idgra_ra1" name="idgra_ra1" placeholder="idgra" style="width: 50px;"/>
																<label style="color: white;">...</label>
																<!--<a href="estudianteg_getdat.php" >Buscar</a>-->
																<input type="submit" class="btn btn-primary" value="Buscar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            				<fieldset>
                            				<legend><h3>CALIFICACIONES MOODLE</h3></legend>
                            				    <form class="form-horizontal" action="calif_mood_upddat.php"  method="POST" onsubmit="return validacion()">
                            					<ul class="mprincipal">
                            						<li><h3>ACTUALIZAR CONFIGURACION</h3></li>
                            							<ul class="msecund">
                            								<li>
                            								    <input type="submit" class="btn btn-primary" value="Cargar" >
															</li>
                            							</ul>
                            					</ul>
                            					</form>
                            				</fieldset>
                            
                            			</div>
                            		</div>
									<div id="resul_bus"></div>
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