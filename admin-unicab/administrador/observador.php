<?php 
	session_start();
	require "../php/conexion.php";
	//errores de datos 1058354538
    //Para agendar entrevista 1029145024
	
	$psicologo = $_REQUEST['psicologo'];
	
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		//$sql_emp = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW','PS') AND id NOT IN (1,30,31)";
		$sql_emp = "SELECT * FROM tbl_empleados WHERE id = $psicologo";
		
		$exe_emp = mysqli_query($conexion,$sql_emp);
		while ($row_emp = mysqli_fetch_array($exe_emp)) {
		    $nombre_psi = $row_emp['nombres']." ".$row_emp['apellidos'];
		    $cel_psi = $row_emp['celular'];
		    $meet_psi = $row_emp['skype'];
		}
		
		$sql = "SELECT e.*, pm.nombre_a, pm.celular_a, pm.email_a 
		FROM tbl_entrevistas e LEFT JOIN tbl_pre_matricula pm ON e.documento_est = pm.documento_est WHERE e.id_psicologo = $psicologo";
		$exe = mysqli_query($conexion, $sql);
?>

<!DOCTYPE HTML>
<html>
<head>
<title>Administrador - Web Unicab</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS -->

 <!-- side nav css file -->
 <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
 <!-- side nav css file -->
 
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

    <link href='fullcalendar/lib/main.css' rel='stylesheet' />
    <script src='fullcalendar/lib/main.js'></script>
    <script src='fullcalendar/lib/locales-all.js'></script>
    <script>
        
        function buscar_inf() {
            //Se busca la información del estudiante
            var buscar = $("#buscar").val();
            $("#documento_est").val(buscar);
            
            $.ajax({
                type:"POST",
        		url:"informacion_premat_getdat.php",
        		data:"buscar=" + buscar + "&tipo=DOC",
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var r_est = res.estado;
        		    var fecha = res.fecha_val;
        		    var grado_val = res.grados_val;
        		    //alert(res.nom_a + res.email_a + res.cel_a);
        		    //$("#estado").val(r_est);
        		    
        		    $("#nombree").val(res.nom_est + " " + res.ape_est);
        		    $("#gradoe").val(res.grado);
        		    try {
        		        $("#gradoe_val").val(grado_val[0].grav);
        		    } catch(e) {}
        		    $("#nombrea").val(res.nom_a);
        		    $("#emaila").val(res.email_a);
        		    $("#emaila_1").val(res.email_a);
        		    $("#cela").val(res.cel_a);
        		    $("#idgrado").val(res.id_grado);
        		    try {
        		        $("#idgrado_val").val(grado_val[0].id_grav);
        		    } catch(e) {}
        		    $("#txtgrado").val(res.grado);
        		    try {
        		        $("#txtgrado_val").val(grado_val[0].grav);
        		    } catch(e) {}
        		    $("#registrado").val(res.registrado_para_val);
        		    //alert(res.nom_a + res.email_a + res.cel_a);
        		    
        		    if(fecha == "NA") {
        		        $("#fecha_val").val("");
        		        $("#ctr_fecha_val").val(1);
        		    }
        		    else {
        		       $("#fecha_val").val(fecha);
        		       $("#ctr_fecha_val").val(0);
        		    }
        		    
        		    if(res.registrado_para_val == "SI") {
        		        $("#ctr_registrado").val(0);
        		    }
        		    else {
        		        $("#ctr_registrado").val(1);
        		    }
        		}
        	});
        	
        	mostrar_submit();
        }
        
        function mostrar_submit() {
            var control = 0;
            var documento = $("#buscar").val();
            if(documento == "") {
                $("#btnsubmit").hide();
                control = 1;
            }
            
            if(control == 0) {
                var fecha = $("#fecha_val").val();
                if(fecha == "") {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            var a = $("#ctr_fecha_val").val();
            //alert(a);
            if(a == 1) {
                control = 1;
            }
            (a == 1) ? $("#fecha_val").addClass("error") : $("#fecha_val").removeClass("error");
            
            var registrado = $("#ctr_registrado").val();
            if(registrado == 1) {
                control = 1;
            }
            
            if(control == 0) {
                $("#btnsubmit").show();
            }
            else {
                $("#btnsubmit").hide();
            }
            
        }
        
        function validar_fecha(id, desc) {
            //alert("control");
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var input_email = document.getElementById(id);
            var patron = /^[0-9]{4}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/;
            var esCoincidente = patron.test($(id_obj).val());
            //alert(esCoincidente);
            if(esCoincidente) {
                input_email.setCustomValidity("");
                //$("#pdesc").html("");
                $(ctr_obj).val(0);
                
                var fecha = $(id_obj).val();
                //alert(fecha);
                var porciones = fecha.split("-");
                var a = parseInt(porciones[0]);
                var m = parseInt(porciones[1]);
                var d = parseInt(porciones[2]);
                
                if(a < 1850 || a > 2050) {
                    input_email.setCustomValidity("No es una fecha de nacimiento válida");
                    var texto = "No es un patrón válido para " + desc;
                    //$("#pdesc").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                }
                if(m < 1 || m > 12) {
                    input_email.setCustomValidity("No es una fecha de nacimiento válida");
                    var texto = "No es un patrón válido para " + desc;
                    //$("#pdesc").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                }
                else {
                    if(m == 2) {
                       if(d < 1 || d > 29) {
                            input_email.setCustomValidity("No es una fecha de nacimiento válida");
                            var texto = "No es un patrón válido para " + desc;
                            //$("#pdesc").html(texto).css("color","red");
                            $(ctr_obj).val(1);
                        } 
                    }
                    else if(m == 4 || m == 6 || m == 9 || m == 11) {
                       if(d < 1 || d > 30) {
                            input_email.setCustomValidity("No es una fecha de nacimiento válida");
                            var texto = "No es un patrón válido para " + desc;
                            //$("#pdesc").html(texto).css("color","red");
                            $(ctr_obj).val(1);
                        } 
                    }
                    else {
                       if(d < 1 || d > 31) {
                            input_email.setCustomValidity("No es una fecha de nacimiento válida");
                            var texto = "No es un patrón válido para " + desc;
                            //$("#pdesc").html(texto).css("color","red");
                            $(ctr_obj).val(1);
                        } 
                    }
                }
                
            }
            else {
                input_email.setCustomValidity("No es una fecha de nacimiento válida");
                var texto = "No es un patrón válido para " + desc;
                //alert(texto);
                //$("#pdesc").html(texto).css("color","red");
                $(ctr_obj).val(1);
                control = 1;
            }
            mostrar_submit();
        }
    
    </script>

    <style>
        .error {
            border: 3px solid red !important;
        }
        .azul1 {
            background: lightblue;
			height: 100px;
        }
        .fc-toolbar-title {
            font-size: 20px !Important;
            font-weight: bold;
        }
    </style>

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<!-- menu -->
		<?php 
			require "include/header.php";
		?>
		<!-- menu -->
		
		<!-- header -->
		<?php 
			require "include/menu.php";
		?>
		<!-- header -->
		<!-- main content start-->
		<div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Observador estudiante:</h4><?php //echo $sql_emp; ?>	
						</div>
					</div>
				</div>
				<div class="forms azul1">
					<!--<div class="form-grids row widget-shadow azul1" data-example-id="basic-forms"> 
						<div class="form-group col-lg-6 text-left">
    					    <label id="lblbuscar">Buscar por identificación del estudiante:</label>
    					</div>
    					<div class="form-group col-lg-6 text-left azul1">
    					    <input type="text" class="" id="buscar" name="buscar" width="300px">
    						<button class="btn btn-success" onclick="buscar_inf();">Buscar</button>
    						<input type="hidden" style="width: 20px" id="ctr_buscar" value="1"/>
    					</div>
					</div>-->
					
					<div class="form-body">
						<form action="observador_getdat.php" method="POST" id="form" name="form" enctype="multipart/form-data" >
						   
							<div class="form-group col-lg-6 text-left">
								<label id="lblbuscar">Buscar por identificación del estudiante:</label>
							</div>
							<div class="form-group col-lg-6 text-left">
								<input type="text" class="" id="buscar" name="buscar" width="300px" required>
								<button type="submit" id="btnsubmit" name="btnsubmit" class="btn btn-success" >Buscar</button>
							</div>
						</form> 
					</div>
				</div>
			</div>
		</div>
		<!--footer-->
		<?php 
			require "include/footer.php";
		?>
        <!--//footer-->
	</div>
	
	<div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title text-center">Datos de la Entrevista</h4>
				</div>
				<div class="modal-body">
					<dl class="dl-horizontal">
						<dt>Titulo de Evento</dt>
						<dd id="title"></dd>
						<dt>Inicio de Evento</dt>
						<dd id="start"></dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
	<!--scrolling js-->
	<script src="../js/jquery.nicescroll.js"></script>
	<script src="../js/scripts.js"></script>
	<!--//scrolling js-->

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
   <script type="text/javascript" src="../js/MaxLength.min.js"></script>

</body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>