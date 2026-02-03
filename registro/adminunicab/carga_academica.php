<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");

    //$tabla = $_REQUEST['tabla'];
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
	
	//Se cargan los tutores
	$sql_t = "SELECT e.*, CONCAT(e.nombres,' ',e.apellidos) nombre FROM tbl_empleados e WHERE e.perfil IN ('TU', 'SU') ORDER BY CONCAT(e.nombres,' ',e.apellidos)";
	$sel_t = mysqli_query($conexion,$sql_t);
	$sel_t1 = mysqli_query($conexion,$sql_t);
	
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
        height:400px;
        width:800px;
    }
    
    #divtabla table {
        width:800px
    }
    .form-controlxx {
        background-color: lightgray;
        width: 50px;
    }
</style>
    <script>
        $(function() {
            cargar_datos();
            
            $("#seloper").change(function() {
                //$("#search").val("");
                $("td:nth-child(7)").hide();
                
                var oper = $("#seloper").val();
                
        		if(oper == "NA") {
        			$("td:nth-child(7)").hide();
        		}
        		else if(oper == "MODIFICAR") {
        			$("td:nth-child(7)").show();
        		}
        		else {
        		    $("td:nth-child(7)").hide();
        		    
        		    $("#modal_carga_add").modal("show");
        		}
        		
        	});
        	
        	$("#seltutorupd").change(function() {
        	    if($("#seltutorupd").val() == "0") {
        	        $("#seltutorupdv").val("1");
        	    }
        	    else {
        	        $("#seltutorupdv").val("0");
        	    }
        	    validar_campos_upd();
        	});
        	
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
        
        function enviardat_carga(gra, id_gra, pen, id_pen, tutor, id) {
            //alert (idact);
            $("#txtgraupd").val(gra);
            $("#txtidgraupd").val(id_gra);
            $("#txtpenupd").val(pen);
            $("#txtidpenupd").val(id_pen);
            
            $("#seltutorupd").val(id);
            $("#seltutorupdv").val("0");
            
            $(".alert-danger").hide();
        }
        
        function updcarga() {
            var tutor = $("#seltutorupd").val();
            //alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"carga_acad_upddat.php",
        		data:"tutor=" + $("#seltutorupd").val() + "&idgra=" + $("#txtidgraupd").val() + "&idpen=" + $("#txtidpenupd").val(),
        		success:function(r) {
        		    if(r > 0) {
            		    $("#divtabla").empty();
            		    cargar_datos();
        		    }
        		}
        	});
        }
        
        function putcarga() {
            var datos = "id=" + $("#txtidput").val() + "&cargo=" + $("#txtcargoput").val();
            var cargo = $("#txtcargoput").val();
            cargo = cargo.replace(" ","_");
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"cargo_putdat.php",
        		data:"cargo=" + cargo,
        		success:function(r) {
        		    if(r > 0) {
            		    //$("#divtabla").empty();
            		    //cargar_datos();
            		    tabla = $("#txttabla").val();
        	            validar_put(cargo,'cargo',tabla);
        		    }
        		}
        	});
        }
        
        function validar_put(valor, campo, tabla) {
            //alert("hola");
            $.ajax({
        		type:"POST",
        		url:"validar_putdat.php",
        		data:"valor=" + valor + "&campo=" + campo + "&tabla=" + tabla,
        		success:function(r) {
        		    //alert(r);
        		    if(r > 0) {
        		        location.reload();
        		    }
        		}
        	});
        }
        
        function validar_campos_upd() {
            var suma = parseInt($("#seltutorupdv").val());
            //alert (suma);
            if(suma > 0) {
                $("#btnupdcarga").hide();
            }
            else {
                $("#btnupdcarga").show();
            }
        }
        
        function validar_campos_put() {
            var suma = parseInt($("#seltutorputv").val());
            //alert (suma);
            if(suma > 0) {
                $("#btnputcarga").hide();
            }
            else {
                $("#btnputcarga").show();
            }
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
                    				<legend class="alert alert-info" role="alert"><h3>CARGA ACADEMICA POR TUTOR</h3></legend>
                    				    <!--<form class="form-horizontal" action="act_moodle_getdat1.php"  method="POST" target="_blank" onsubmit="return validacion()">-->
                    					<select id="seloper" name="seloper" class="my-select" style="color: white;">
                    					    <option selected="selected" data-img-src="../docenteunicab/updreg/img/sel.png" value="NA">SO</option>
                                			<!--<option data-img-src="../docenteunicab/updreg/img/add.png" value="AGREGAR">ADD</option>-->
                                			<option data-img-src="../docenteunicab/updreg/img/upd1.png" value="MODIFICAR">UPD</option>
                                		</select>
                                		<!--<img src="../docenteunicab/updreg/img/agregar0.png"></img>-->
                    					<!--</form>-->
                    				</fieldset><br/>
                    				<input type='search' placeholder='Ingrese texto a buscar' id='search' name='search' style="display: none;"><br/><br/>
                    			    <div id="divtabla">
                    			       
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
	<!-- Modal de edición de carga  -->
    <div class="modal fade" id="modal_carga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">MODIFICAR CARGA ACADEMICA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID GRADO</label>
            <input type="text" id="txtidgraupd" class="form-control" readonly/>
            <label>GRADO</label>
            <input type="text" id="txtgraupd" class="form-control" readonly/>
            <label>ID PENSAMIENTO</label>
            <input type="text" id="txtidpenupd" class="form-control" readonly/>
            <label>PENSAMIENTO</label>
            <input type="text" id="txtpenupd" class="form-control" readonly/>
            <label>TUTOR</label><input type="hidden" id="seltutorupdv" value="1"/>
            <select id="seltutorupd" class="form-control">
                <option value="0">Seleccione tutor</option>
                <?php  
                    while ($filad = mysqli_fetch_array($sel_t)){
                ?>
                        <option value="<?php echo $filad['id']; ?>"><?php echo $filad['nombres']." ".$filad['apellidos']; ?></option>
                <?php  
                    }
                ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdcarga" data-dismiss="modal" onclick="updcarga()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal de insertar carga  -->
    <div class="modal fade" id="modal_carga_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">NUEVO REGISTRO <?php echo strtoupper($tabla); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>ID</label>
            <input type="text" id="txtidput" class="form-control" readonly/>
            <label>CARGO</label>
            <input type="text" id="txtcargoput" class="form-control" />
            <!--<input type="text" id="txtcomputar" class="form-control" oninput="validacomputar()"/>
            <label id="lblval"></label>-->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnputcarga" data-dismiss="modal" onclick="putcarga()">Guardar</button>
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