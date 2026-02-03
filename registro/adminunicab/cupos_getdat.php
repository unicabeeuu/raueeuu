<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/estudiante_grupo_getdat.php
	
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
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
    
    $query = "SELECT COUNT(1) ct, c.id_grado_solicitado, g.grado 
    FROM tbl_cupos c, grados g 
    WHERE c.id_grado_solicitado = g.id AND c.n_documento != '9397454' 
    GROUP BY id_grado_solicitado, g.grado";
    //echo $query;
    $resultado1 = $mysqli1->query($query);
    
    $query_total = "SELECT COUNT(1) ct FROM tbl_cupos WHERE n_documento != '9397454'";
    $resultado2 = $mysqli1->query($query_total);
    while ($fila_total = mysqli_fetch_array($resultado2)){
        $tot_cupos = $fila_total['ct'];
    }
    
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
        h3 {
            color: blue;
            font-weight: bold;
        }
    </style>
    <script>
        
        $(function() {
            //alert("hola");
            //consultar_estudiantes();
        });
        
        function enviardat(id_grado_solicitado) {
            $("#div_listado").empty();
            //alert("funci¨®n");
            
            $.ajax({
        		type:"POST",
        		url:"cupos_getdat1.php",
        		data:"id_grado_solicitado=" + id_grado_solicitado,
        		success:function(r) {
        		    $("#div_listado").html(r);
        		}
        	});
        	
        	$('#modal_list').modal('toggle');
            $('#modal_list').modal('show');
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
                        			    <h3>CUPOS APARTADOS 2023 POR GRADO </h3>
                        			    <div id="divtabla">
            								<table>
            								    <thead>
            								        <tr>
            								            <td width="100px">Cantidad</td>
            								            <td width="100px">Grado</td>
            								            <td></td>
            								        </tr>
            								    </thead>
            								    <tbody>
            								        <?php
            								            while ($fila = mysqli_fetch_array($resultado1)){
            								                echo '<tr>
            								                        <td>'.$fila['ct'].'</td>
            								                        <td>'.$fila['grado'].'</td>
            								                        <td><button class="btn btn-secundary glyphicon glyphicon-list-alt" title="Ver listado"
                                                                    onclick="enviardat('.$fila['id_grado_solicitado'].')"> Ver listado</button></td>
            								                    </tr>';
            								                $tot_mat += $fila['ct'];
            								            }
            								        ?>
            								    </tbody>
            								</table>
            								<label>Total cupos apartados: <?php echo $tot_cupos; ?></label>
            							</div>
                        			</div>
                        		</div></br>
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
	
	<!-- Modal de cupos por grado -->
    <div class="modal fade bd-example-modal-lg" id="modal_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document" style="min-width: 90%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">DETALLE DE LOS CUPOS</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="div_listado">
            </div>
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