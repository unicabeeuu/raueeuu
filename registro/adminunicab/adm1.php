<?php
	session_start();
	//include "../../adminunicab/php/conexion.php";
	include "php/conexion.php";
	require("php/1cc3s4db.php");
	//require("php/1cc3s4db_m.php");
	set_time_limit(600);
	
if (isset($_SESSION['unisuper']) || isset($_SESSION['uniprofe'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."' OR email='".$_SESSION['unisuper']."'";
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
	
    $query = "SELECT * FROM equivalence_idgra WHERE id_grado_ra NOT IN (150, 160, 170, 180, 130, 140, 0)";
    //$resultado=$mysqli1->query($query);
    //$resultado1=$mysqli1->query($query);
    $resultado=mysqli_query($conexion,$query);
    $resultado1=mysqli_query($conexion,$query);
?>
<!DOCTYPE HTML>
<html lang="es">
<head><meta charset="gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

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
 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<script type="text/javascript" src="js/reg.js"></script>

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
#chartdiv {
  width: 100%;
  height: 295px;
}
#identif, #buscar {
    border: none;
    border-bottom: 2px solid green;
}
.mprincipal {
	list-style-image: url("img/m26.png");
	font-weight: bold !important;
    font-size: 20px !important;
}
#cont {
	display: flex;
	justify-content: space-around;
}
.fld1 {
	background-color:white;
	opacity: 0.7;
}
label {
	color: blue;
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
</style>
<script>
    $(function() {
        //alert("hola");
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
		<?php
		    if($perfil == "ARCH") {
		        require 'header_archivo.php'; 
		    }
		    else {
		        require 'header.php'; 
		    }
		     
		?>
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
                    	 
                    			<!---------------------------------------------->
                                <div id="cont">
                        			<!--<div id="div1">
                        				<fieldset>
                        				<legend><h3>BASE DE DATOS DE ESTUDIANTES</h3></legend>
                        				    <form class="form-horizontal" action="cargar_est_putdat.php"  method="POST" onsubmit="return validacion()">
                        				    <ul class="mprincipal">
                        						<li><h3>CARGAR INFORMACION MOODLE TOTAL</h3></li>
                        							<ul class="msecund">
                        								<li><input type="submit" class="btn btn-primary" value="Cargar" ></li>
                        							</ul>
                        					</ul>
                        					</form>
                        				</fieldset><br />
                        				<fieldset>
                        				<legend><h3>REVERSAR PROCESO DE CIERRE</h3></legend>
                        				    <form class="form-horizontal" action="../docenteunicab/updreg/buscar_notas_mood_est1.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                        					</form>
                            					<form class="form-horizontal" action="reversar_ca.php"  method="POST" onsubmit="return validacion()">
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
                        			</div>-->
                        			<div id="div2">
                        				<fieldset>
                        				<legend><h3>BUSCAR EN BASE DE DATOS</h3></legend>
                        				    <form class="form-horizontal" action="../docenteunicab/updreg/estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                        					<form class="form-horizontal" action="../docenteunicab/updreg/estudiante_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                        					<form class="form-horizontal" action="../docenteunicab/updreg/estudianteg_getdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                        					<?php
                        					    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
                        					?>
                            					<form class="form-horizontal" action="../docenteunicab/updreg/observaciones_putdat.php"  method="POST" target="_blank" onsubmit="return validacion()">
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
                            				<?php
                                                }
                        					?>
                            				<form class="form-horizontal" action="../docenteunicab/updreg/bd_exportar_getdat.php"  method="POST" target="_blank">
                            					<ul class="mprincipal">
                            						<li><h3>EXPORTAR BASE DE DATOS</h3></li>
                            							<ul class="msecund">
                            								<li>
																<input type="submit" class="btn btn-primary" value="Exportar" >
															</li>
                            							</ul>
                            					</ul>
                            				</form>
                            				<form class="form-horizontal" action="../docenteunicab/updreg/bd_exportar_ret_getdat.php"  method="POST" target="_blank">
                            					<ul class="mprincipal">
                            						<li><h3>EXPORTAR RETIRADOS</h3></li>
                            							<ul class="msecund">
                            								<li>
																<input type="submit" class="btn btn-primary" value="Exportar" >
															</li>
                            							</ul>
                            					</ul>
                            				</form>
                            				<?php
                        					    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
                        					?>
                                				<form class="form-horizontal" action="../docenteunicab/updreg/bd_exportar_act_extra.php"  method="POST" target="_blank">
                                					<ul class="mprincipal">
                                						<li><h3>LISTADO DE ACTIVIDADES EXTRA</h3></li>
                                							<ul class="msecund">
                                								<li>
    																<input type="submit" class="btn btn-primary" value="Exportar" >
    															</li>
                                							</ul>
                                					</ul>
                                				</form>
												<form class="form-horizontal" action="../docenteunicab/updreg/bd_exportar_eval_admision.php"  method="POST" target="_blank">
                                					<ul class="mprincipal">
                                						<li><h3>LISTADO DE EVALUACIONES DE ADMISIÓN</h3></li>
                                							<ul class="msecund">
                                								<li>
    																<input type="submit" class="btn btn-primary" value="Exportar" >
    															</li>
                                							</ul>
                                					</ul>
                                				</form>
                            				<?php
                                                }
                        					?>
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
	
</body>
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>