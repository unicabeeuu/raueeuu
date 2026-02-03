<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");

    $q = $_REQUEST['q'];
    //$estado = $_REQUEST['estado'];
    
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
	
	//Se hace la consulta
	if($q == "rnom") {
	    $text = "ESTUDIANTES EN REGISTRO Y NO EN MOODLE";
	    
	    $sql1 = "SELECT a.* 
        FROM 
        (SELECT e.nombres nombres_r, e.apellidos apellidos_r, e.id id_r, e.id_moodle, em.nombres nombres_m, em.apellidos apellidos_m, em.id id_m 
        FROM 
        (SELECT e.*, ee.id_registro, ee.id_moodle 
        FROM estudiantes e, equivalence_idest ee, matricula m WHERE e.id = ee.id_registro AND e.id = m.id_estudiante AND m.estado = 'activo' 
        AND m.n_matricula like '%2022%') e LEFT JOIN tbl_estudiantes_mood em 
        ON e.id_moodle = em.id) a 
        WHERE a.id_m is null";
	}
	else if($q == "mnor") {
	    $text = "ESTUDIANTES EN MOODLE Y NO EN REGISTRO";
	    
	    $sql1 = "SELECT em.* 
            FROM tbl_estudiantes_mood em 
            WHERE id NOT IN (SELECT ee.id_moodle FROM equivalence_idest ee, estudiantes e, matricula m  
            WHERE ee.id_registro = e.id AND e.id = m.id_estudiante AND m.estado = 'activo' AND m.n_matricula like '%2022%') ";
	}
	$resultado=$mysqli1->query($sql1);
	
?>
<!DOCTYPE HTML>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=big5">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/chosen.css">
<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/ImageSelect.css">
<!--<link rel="stylesheet" href="../docenteunicab/updreg/sogap/chosen/bootstrap.min.css" >-->

<!-- Bootstrap Core CSS  -->
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
<!--<script src="../js/jquery-1.11.1.min.js"></script>-->
<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/jquery.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/chosen.jquery.js"></script>
<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/ImageSelect.jquery.js"></script>
<!--<script type="text/javascript" src="../docenteunicab/updreg/sogap/js/bootstrap.js"></script>-->
<script src="../js/bootstrap.js"> </script>

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
    
    #divtabla {
        overflow:scroll;
        height:300px;
        width:800px;
    }
    #divtabla table {
        width:800px
    }
    
    #tblmoodle {
        overflow:scroll;
        height:300px;
        width:500px;
    }
    #tblmoodle table {
        width:500px
    }
    
    #tblregistro {
        overflow:scroll;
        height:300px;
        width:500px;
    }
    #tblregistro table {
        width:500px
    }
    .form-controlxx {
        background-color: lightgray;
        width: 50px;
    }
</style>
    <script>
        $(function() {
            //cargar_datos();
            
            $("#search").keyup(function(){
                _this = this;
                // Show only matching TR, hide rest of them
                $.each($("#tbldatos tbody tr"), function() {
                    //alert ($(this).text());
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                        $(this).hide();
                    else
                        $(this).show();
                });
            });
        });
        
        function cargar_datos() {
            //alert ("hola");
            $("#search").val("");
            
            $.ajax({
        		type:"POST",
        		url:"cargar_carga_getdat.php",
        		success:function(r) {
        		    //alert (r);
        		    $("#search").show();
        		    $("#divtabla").html(r);
        			//$("#tbodyact").html(r);
        			var oper = $("#seloper").val();
        			if(oper == "MODIFICAR") {
        			    $("td:nth-child(7)").show();
        			}
        			else {
        			    $("td:nth-child(7)").hide();
        			}

        		}
        	});
        }
        
        function ver_datos_moodle(nombres, apellidos) {
            $("#tblmoodle").empty();
            $("#txtnom_r").val(nombres.replace("_"," "));
            $("#txtape_r").val(apellidos.replace("_"," "));
        	
            $.ajax({
        		type:"POST",
        		url:"datos_estmoodle_getdat.php",
        		data:"nom_r=" + nombres + "&ape_r=" + apellidos,
        		success:function(r) {
        		    $("#tblmoodle").html(r);
        		}
        	});
        }
        
        function ver_datos_registro(nombres, apellidos, id) {
            $("#tblregistro").empty();
            $("#txtnom_m").val(nombres.replace("_"," "));
            $("#txtape_m").val(apellidos.replace("_"," "));
            $("#txtid_m").val(id);
        	
            $.ajax({
        		type:"POST",
        		url:"datos_estregistro_getdat.php",
        		data:"nom_m=" + nombres + "&ape_m=" + apellidos,
        		success:function(r) {
        		    $("#tblregistro").html(r);
        		}
        	});
        }
    </script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
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
                    			<div class="form-body">
                    			    <fieldset>
                    				<legend class="alert alert-info" role="alert"><h3><?php echo $text; ?></h3></legend>
                    				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                    					<!--<select id="seloper" name="seloper" class="my-select" style="color: white;">
                    					    <option selected="selected" data-img-src="../docenteunicab/updreg/img/sel.png" value="NA">SO</option>
                                			<option data-img-src="../docenteunicab/updreg/img/add.png" value="AGREGAR">ADD</option>
                                			<option data-img-src="../docenteunicab/updreg/img/upd1.png" value="MODIFICAR">UPD</option>
                                		</select>-->
                                		<!--<img src="../docenteunicab/updreg/img/agregar0.png"></img>-->
                    					<!--</form>-->
                    				</fieldset><br/>
                    				<input type='search' placeholder='Ingrese texto a buscar' id='search' name='search'><br/><br/>
                    			    <div id="divtabla">
                    			        <table id='tbldatos' class='table table-fixed' border='1px'>
                	                        <thead style="text-align: center;">
                	                            <?php  
                	                                if($q == "rnom") {
                	                            ?>
                        	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
                        	                            <td>NOMBRES_R</td>
                        	                            <td>APELLIDOS_R</td>
                        	                            <td>ID_R</td>
                        	                            <td>NOMBRES_M</td>
                        	                            <td>APELLIDOS_M</td>
                        	                            <td>ID_M</td>
                        	                            <td>...</td>
                        	                        </tr>
                        	                   <?php  
                        	                        }
                        	                        else if($q == "mnor") {
                        	                   ?>
                        	                        <tr style='background-color: gray; color: white; text-weight: bold;'>
                        	                            <td>NOMBRES_M</td>
                        	                            <td>APELLIDOS_M</td>
                        	                            <td>ID_M</td>
                        	                            <td>GRADO</td>
                        	                            <td>USUARIO</td>
                        	                            <td>EMAIL</td>
                        	                            <td>...</td>
                        	                        </tr>
                        	                   <?php  
                        	                        }
                        	                   ?>
                    	                   </thead>
                    	                   <tbody>
                    	                       <?php  
                    	                            while($row = $resultado->fetch_assoc()) {
                    	                                if($q == "rnom") {
                    	                       ?> 
                                                            <tr>
                                                                <td><?php echo $row['nombres_r']; ?></td>
                                                                <td><?php echo $row['apellidos_r']; ?></td>
                                                                <td><?php echo $row['id_r']; ?></td>
                                                                <td><?php echo $row['nombres_m']; ?></td>
                                                                <td><?php echo $row['apellidos_m']; ?></td>
                                                                <td><?php echo $row['id_m']; ?></td>
                                                                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_moodle' 
                                                                    onclick='ver_datos_moodle("<?php echo str_replace(" ","_",$row['nombres_r']); ?>","<?php echo str_replace(" ","_",$row['apellidos_r']); ?>")'> Ver Datos Moodle</button>
                                                                </td>
                                                            </tr> 
                                                <?php  
                    	                                }
                        	                            else if($q == "mnor") {
                                                ?>
                                                            <tr>
                                                                <td><?php echo $row['nombres']; ?></td>
                                                                <td><?php echo $row['apellidos']; ?></td>
                                                                <td><?php echo $row['id']; ?></td>
                                                                <td><?php echo $row['grado']; ?></td>
                                                                <td><?php echo $row['usuario']; ?></td>
                                                                <td><?php echo $row['email_inst']; ?></td>
                                                                <td><button class='btn btn-warning glyphicon glyphicon-edit' data-toggle='modal' data-target='#modal_registro' 
                                                                    onclick='ver_datos_registro("<?php echo str_replace(" ","_",$row['nombres']); ?>","<?php echo str_replace(" ","_",$row['apellidos']); ?>",<?php echo $row['id']; ?>)'> Ver Datos Registro</button>
                                                                </td>
                                                            </tr>
                                                <?php  
                    	                                }
                        	                        }
                                                ?>
                                            </tbody>
                                        </table>
        							</div>
								</div>
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
	
	<!-- ******************************************************************************************************************************** -->
	<!-- Modal datos moodle  -->
    <div class="modal fade" id="modal_moodle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">DATOS EN MOODLE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>NOMBRES_R</label>
            <input type="text" id="txtnom_r" class="form-control" readonly/>
            <label>APELLIDOS_R</label>
            <input type="text" id="txtape_r" class="form-control" readonly/>
            <label>DATOS MOODLE</label>
            <div id="tblmoodle">
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-warning" id="btnupdcarga" data-dismiss="modal" onclick="updcarga()">Guardar</button>-->
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar carga  -->
    <div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">DATOS EN REGISTRO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>NOMBRRES_M</label>
            <input type="text" id="txtnom_m" class="form-control" readonly/>
            <label>APELLIDOS_M</label>
            <input type="text" id="txtape_m" class="form-control" readonly/>
            <label>ID_M</label>
            <input type="text" id="txtid_m" class="form-control" readonly/>
            <label>DATOS REGISTRO</label>
            <div id="tblregistro">
                
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-warning" id="btnputcarga" data-dismiss="modal" onclick="putcarga()">Guardar</button>-->
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

	<!-- Bootstrap Core JavaScript 
   <script src="../js/bootstrap.js"> </script>-->
	<!-- //Bootstrap Core JavaScript -->

	<!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->
	
	<!-- Este c車digo es para el select con im芍genes -->
   	<script>
	    $(".my-select").chosen({width:"180px"});
	</script>
</body>
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>