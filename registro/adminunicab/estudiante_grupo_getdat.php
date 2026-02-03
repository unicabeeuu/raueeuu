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
    
    $tot_sol = 0;
    $tot_mat = 0;
    $tot_ciu = 0;
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
    
    /*$query = "SELECT COUNT(1) ct, g.id, g.grado, m.grupo 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = $a AND m.id_estudiante != '1155' 
    GROUP BY g.id, g.grado, m.grupo ORDER BY g.id";*/
    $query = "SELECT COUNT(1) ct, g.id, g.grado, m.grupo 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND m.estado = 'activo' AND m.n_matricula like '%2025%' AND m.id_estudiante NOT IN (1155) 
    GROUP BY g.id, g.grado, m.grupo ORDER BY g.id";
    //echo $query;
    $resultado1 = $mysqli1->query($query);
    
    //Solicitudes por grado
    /*$query1 = "SELECT COUNT(1) ct, g.grado 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND date_format(m.fecha_ingreso, '%Y') = $a AND m.id_estudiante != 1155 GROUP BY m.id_grado";*/
    $query1 = "SELECT COUNT(1) ct, g.grado 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND m.n_matricula like '%2025%' AND m.id_estudiante NOT IN (1155, 1040) AND m.estado IN ('pre_solicitud', 'solicitud') GROUP BY m.id_grado";
    //echo $query1;
    $resultado2 = $mysqli1->query($query1);
    
    //Matrículas por ciudad
    /*$query2 = "SELECT COUNT(1) ct, e.ciudad 
    FROM matricula m, estudiantes e 
    WHERE m.id_estudiante = e.id AND date_format(m.fecha_ingreso, '%Y') = $a AND m.id_estudiante != 1155 AND m.estado = 'activo' GROUP BY e.ciudad";*/
    $query2 = "SELECT COUNT(1) ct, e.ciudad 
    FROM matricula m, estudiantes e 
    WHERE m.id_estudiante = e.id AND m.n_matricula like '%2025%' AND m.id_estudiante != 1155 AND m.estado = 'activo' GROUP BY e.ciudad";
    //echo $query2;
    $resultado3 = $mysqli1->query($query2);
    
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
        
        function enviardat(id_grado, grupo) {
            $("#div_listado").empty();
            //alert("funci¨®n");
            
            $.ajax({
        		type:"POST",
        		url:"estudiante_grupo_getdat1.php",
        		data:"id_grado=" + id_grado + "&grupo=" + grupo,
        		success:function(r) {
        			$("#div_listado").html(r);
        			//$("#tbodyact").html(r);
        		}
        	});
        	
        	$('#modal_list').modal('toggle');
            $('#modal_list').modal('show');
        }
        
        function enviardat1(id_est, grupo) {
            //alert("funci¨®n");
            
            $.ajax({
        		type:"POST",
        		url:"estudiante_grupo_getdat2.php",
        		data:"id_est=" + id_est + "&grupo=" + grupo,
        		success:function(r) {
        			var res = JSON.parse(r);
        		    
        		    $("#txtid").val(res.id);
        		    $("#txtnom").val(res.nombres);
        		    $("#txtape").val(res.apellidos);
        		    $("#txtgra").val(res.grado);
        		    $("#txtgru").val(grupo);
        		}
        	});
        	
            $('#modal_list_upd').modal('toggle');
            $('#modal_list_upd').modal('show');
        }
        
        function updgru() {
            var datos = "idest=" + $("#txtid").val() + "&grupo=" + $("#txtgru").val();
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"act_grupo_upddat.php",
        		data:"idest=" + $("#txtid").val() + "&grupo=" + $("#txtgru").val(),
        		success:function(r) {
        		    alert("Registro actualizado correctamente");
        		    $('#modal_list').modal('hide');
        		    
        		    location.reload();
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
                        			<div id="div1">
                        			    <h3>SOLICITUDES POR GRADO </h3>
                        			    <div id="divtabla1">
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
            								            while ($fila1 = mysqli_fetch_array($resultado2)){
            								                echo '<tr>
            								                        <td>'.$fila1['ct'].'</td>
            								                        <td>'.$fila1['grado'].'</td>
            								                    </tr>';
            								                $tot_sol += $fila1['ct'];
            								            }
            								        ?>
            								    </tbody>
            								</table>
            								<label>Total solicitudes: <?php echo $tot_sol; ?></label>
            							</div>
            							<hr>
            							<h3>MATRICULAS POR CIUDAD </h3>
                        			    <div id="divtablaCiudad">
            								<table>
            								    <thead>
            								        <tr>
            								            <td width="100px">Cantidad</td>
            								            <td width="100px">Ciudad</td>
            								            <td></td>
            								        </tr>
            								    </thead>
            								    <tbody>
            								        <?php
            								            while ($fila2 = mysqli_fetch_array($resultado3)){
            								                echo '<tr>
            								                        <td>'.$fila2['ct'].'</td>
            								                        <td>'.$fila2['ciudad'].'</td>
            								                    </tr>';
            								                $tot_ciu += $fila2['ct'];
            								            }
            								        ?>
            								    </tbody>
            								</table>
            								<label>Total matrículas: <?php echo $tot_ciu; ?></label>
            							</div>
                        			</div>
                        			<div id="div2">
                        			    <h3>MATRICULAS POR GRADO Y GRUPO </h3>
                        			    <div id="divtabla">
            								<table>
            								    <thead>
            								        <tr>
            								            <td width="100px">Cantidad</td>
            								            <td width="100px">Grado</td>
            								            <td width="100px">Grupo</td>
            								            <td></td>
            								            <td></td>
            								        </tr>
            								    </thead>
            								    <tbody>
            								        <?php
            								            while ($fila = mysqli_fetch_array($resultado1)){
            								                echo '<tr>
            								                        <td>'.$fila['ct'].'</td>
            								                        <td>'.$fila['grado'].'</td>
            								                        <td>'.$fila['grupo'].'</td>
            								                        <td><button class="btn btn-secundary glyphicon glyphicon-list-alt" title="Ver listado"
                                                                    onclick="enviardat('.$fila['id'].',\''.$fila['grupo'].'\')"> Ver listado</button></td>
            								                    </tr>';
            								                $tot_mat += $fila['ct'];
            								            }
            								        ?>
            								    </tbody>
            								</table>
            								<label>Total matrículas: <?php echo $tot_mat; ?></label>
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
	
	<!-- Modal de datos estudiante grado y grupo -->
    <div class="modal fade bd-example-modal-lg" id="modal_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">LISTADO DE ESTUDIANTES</h5>
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
    
    <!-- Modal de datos estudiante grado y grupo para cambiar de grupo -->
    <div class="modal fade" id="modal_list_upd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">INFORMACION DEL ESTUDIANTE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="modal-body">
                <label>Id_est</label>
                <input type="text" id="txtid" class="form-control" readonly/>
                <label>Nombres</label>
                <input type="text" id="txtnom" class="form-control" readonly/>
                <label>Apellidos</label>
                <input type="text" id="txtape" class="form-control" readonly/>
                <label>Grado</label>
                <input type="text" id="txtgra" class="form-control" readonly/>
                <label>Grupo</label>
                <input type="text" id="txtgru" class="form-control" oninput="val_grupo()"/>
                
                <label id="lblgrupo"></label>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdpor" data-dismiss="modal" onclick="updgru()">Guardar</button>
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