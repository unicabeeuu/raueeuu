<?php
session_start();
require "../adminunicab/php/conexion.php";
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
	
	//Se consulta el título
	$sql = "SELECT b.* , e.nombres, e.apellidos, e.id 
	FROM blog b, tbl_empleados e 
	WHERE b.idAdministrador = e.id AND (b.estado_rev_texto = 0 OR b.estado_rev_mult = 0) 
	AND date_format(b.FechaPublicacionB, '%Y') = 2022";
    $exe_sql = mysqli_query($conexion,$sql);
    
	
?>
<!DOCTYPE HTML>
<html>
<head>
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

<script type="text/javascript">
    
</script>
   	
<style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
    .maxl {
        color: blue;
    }
    #alert {
        position: fixed;
        bottom: 0;
        left: 180px;
        z-index: 5000;
        height: 80px;
    }
    #txtvacio {
        border: 0;
    }
    .error {
        border: 3px solid red !important;
    }
        
    input[type=checkbox] {
    	visibility: hidden;
    }
    
    .checkbox-GHF {
    	display: inline-block;
    	position: relative;
        width: 70px;
    	height: 30px;
    	background: #F3F781;
    	border-radius: 15px;
    	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.6), 0px 1px 0px rgba(255,255,255,0.3);   
    }
    
    .checkbox-GHF label {
    
        /* aspecto */
        display: block;
        width: 34px;
    	height: 20px;
    	border-radius: 17px;
    	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.35);
    	background: #fcfff4;
    	background: linear-gradient(to top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
        cursor: pointer;
        
        /* Posicionamiento */
        position: absolute;
        top: 5px;
    	left: 5px;
        z-index: 1;
        
    	/* Comportamiento */
        transition: all .4s ease;
        
        /* ocultar el posible texto que tenga */
        overflow: hidden;
        text-indent: 35px;  
        transition: text-indent 0s;
    }
    
    /* estado activado */
    .checkbox-GHF input[type=checkbox]:checked + label {
    	left: auto;
        right: 5px;
    }
    
    .checkbox-GHF:after {
    	content: 'NO';
    	font: 12px/30px Arial, sans-serif;
    	color: red;
    	position: absolute;
    	right: 10px;
        z-index: 0;
    	font-weight: bold;
    	
    }
    
    .checkbox-GHF:before {
    	content: 'SI';
    	font: 12px/30px Arial, sans-serif;
    	color: green;
    	position: absolute;
    	left: 10px;
    	z-index: 0;
    	font-weight: bold;
    }
</style>
</head> 
<body class="cbp-spmenu-push">
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
	
		<?php require 'header.php';  ?>
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Listado de blogs pendientes por publicar:</h4>
						</div>
						<div class="form-body">  
					    	<table id="listaBlogs" class="display" style="width:100%">
						        <thead>
						            <tr>
						                <th>Título</th>
						                <th>Descripción</th>
						                <th>Creado por</th>
						                <th>Comentarios diseño</th>
	                                    <th>Revisar</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php 
						        	while ($filab = mysqli_fetch_array($exe_sql)){
										if($id == 9 || $id == 14) {
										    echo"<tr><td>".$filab['TituloB']."</td>
    						        		<td>".$filab['DescripcionA']."</td>
    						        		<td>".$filab['nombres']." ".$filab['apellidos']."</td>
    						        		<td>".$filab['comentarios_dis']."</td>
    						        		<td><a href='../../articulo_getdat.php?idb=".$filab['IdBlog']."&ide=".$id."' class='btn btn-primary' title='Redacción y ortografía' target='_blank'><i class='fa fa-pencil'></i> Redacción y ortografía</a></td>
    						        		</tr>";
										}
						        		else if($id == 10 || $id == 12 || $id == 52) {
										    echo"<tr><td>".$filab['TituloB']."</td>
    						        		<td>".$filab['DescripcionA']."</td>
    						        		<td>".$filab['nombres']." ".$filab['apellidos']."</td>
    						        		<td>".$filab['comentarios_dis']."</td>
    						        		<td><a href='../../articulo_getdat.php?idb=".$filab['IdBlog']."&ide=".$id."' class='btn btn-success' title='Diseño' target='_blank'><i class='fa fa-check-square'></i> Diseño</a></td>
    						        		</tr>";
										}
										else if($id == 18) {
										    echo"<tr><td>".$filab['TituloB']."</td>
    						        		<td>".$filab['DescripcionA']."</td>
    						        		<td>".$filab['nombres']." ".$filab['apellidos']."</td>
    						        		<td>".$filab['comentarios_dis']."</td>
    						        		<td><a href='../../articulo_getdat.php?idb=".$filab['IdBlog']."&ide=".$id."' class='btn btn-primary' title='Redacción y ortografía' target='_blank'><i class='fa fa-check-square'></i> Redacción y ortografía</a>
    						        		    <br><a href='../../articulo_getdat.php?idb=".$filab['IdBlog']."&ide=".$id."' class='btn btn-success' title='Diseñor' target='_blank'><i class='fa fa-check-square'></i> Diseño</a>
    						        		</td>
    						        		</tr>";
										}
										else {
										    echo"<tr><td>".$filab['TituloB']."</td>
    						        		<td>".$filab['DescripcionA']."</td>
    						        		<td>".$filab['nombres']." ".$filab['apellidos']."</td>
    						        		<td>".$filab['comentarios_dis']."</td>
    						        		<td><a href='../../articulo_getdat.php?idb=".$filab['IdBlog']."&ide=".$id."' class='btn btn-primary' title='Ver post' target='_blank'><i class='fa fa-sticky-note'></i> Ver post</a></td>
    						        		</tr>";
										}
						        	}
						        	?>
						        </tbody>
					    	</table>
                   		</div>
                        
					</div>
           		</div>
      		</div>
		</section>        	
		<!--footer-->
		<?php require 'footer.php'; ?>
	    <!--//footer-->
	</div>
</body>
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
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listaBlogs').DataTable();	
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>