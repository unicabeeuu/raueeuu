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
	
	$query1 = "SELECT * FROM tbl_parametros";
	//echo $query1;
	//$resultado=mysqli_query($conexion,$query1);
	//$resultado1=mysqli_query($conexion,$query1);
	$resultado=$mysqli1->query($query1);
	$resultado1=$mysqli1->query($query1);
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
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
        
	</head>
	<body id="bodyadm" class="cbp-spmenu-push">
	    <div class="main-content">
    		<?php 
    		    if($id == 18) {
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
                                    <center>
                            			<div id="enc">
                            				<img src="img/enc1.png" alt="enc1" width="800" height="132"/>
                            			</div>
                            		</center>		
                            		<div id="div1">
										<fieldset>
										<legend><h3>ACTUALIZAR PARAMETROS</h3></legend>
											<table border="1px" class="table table-hover" id="tblparam">
												<thead>
												<tr>
													<td><b>Parámetro</b></td>
													<td><b>Valor 1</b></td>
													<td><b>Valor 2</b></td>
													<td><b>Texto 1</b></td>
													<td><b>Texto 2</b></td>
													<td><b>Fecha 1</b></td>
													<td><b>Fecha 2</b></td>					
												</tr>
												</thead>
												<tbody>
												<?php
												    while($row = $resultado->fetch_assoc()){
													//while($row = mysqli_fetch_array($resultado)){
												?>
												<tr>
													<td><?php echo $row['parametro'];?></td>
													<td><?php echo $row['v1'];?></td>
													<td><?php echo $row['v2'];?></td>
													<td><?php echo $row['t1'];?></td>
													<td><?php echo $row['t2'];?></td>
													<td><?php echo $row['f1'];?></td>
													<td><?php echo $row['f2'];?></td>
												</tr>
												<?php }
													
												?>
												</tbody>
											</table>
										</fieldset></br>
										<form class="form-horizontal" action="param_upddat2.php"  method="POST" onsubmit="return validacion()">
    										<table>
    										    <tbody>
    										        <tr>
    										            <td>
    										                <select id="selpg" name="selpg">
                    											<option value="0">Seleccione parámetro</option>
                    											<?php
                    											    while($row1 = $resultado1->fetch_assoc()){
                    												//while($row1 = mysqli_fetch_array($resultado1)){
                    											?>
                    											<option value="<?php echo $row1['id'];?>"><?php echo $row1['parametro'];?></option>
                    											<?php }
													
												                ?>
                    										</select>
    										            </td>
    										            <td width="20"></td>
        										        <td>
                    										<select id="selparam" name="selparam">
        										            </select>
    										                
        										        </td>
        										        <td width="20"></td>
        										        <td>
        										            <input type="text" id="buscar" name="buscar" placeholder="Ingrese valor" style="display: none;" required/>
        										        </td>
        										        <td width="20"></td>
        										        <td>
        										            <!--<button type="button" id="btnbuscar" class="btn btn-primary" onclick="upd_param()" style="display: none;">Actualizar</button>-->
        										            <input type="submit" id="btnbuscar" class="btn btn-primary" style="display: none;" value="Actualizar" >
        										            <input type="hidden" id="op" name="op"/>
        										        </td>
        										        <td>
        										            
        										        </td>
        										    </tr>
    										    </tbody>
    										</table>
										</form>
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
	}else if (isset($_SESSION['unisuper'])) {
		echo "<script>location.href='../../adminunicab/index.php'</script>";
	}else if (isset($_SESSION['uniestudiante'])) {
		echo "<script>location.href='../../estudianteunicab/index.php'</script>";
	}else{
		echo "<script>alert('Debes iniciar sesión');</script>";
		echo "<script>location.href='../login.php'</script>";
	}
	?>
</html>