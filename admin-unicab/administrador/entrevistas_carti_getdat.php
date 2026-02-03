<?php 
	session_start();
	require "../php/conexion.php";
	//errores de datos 1058354538
    //Para agendar entrevista 1029145024
	
	//$psicologo = $_REQUEST['psicologo'];
	
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		$sql = "SELECT * FROM tbl_entrevistas_carti ORDER BY fecha, hora";
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
        
        document.addEventListener('DOMContentLoaded', function() {
            var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
            var initialLocaleCode = 'es';
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                //initialView: 'dayGridMonth'
                initialView: 'timeGridWeek',
                nowIndicator: true,
                eventClick: function(info) {
                    var eventObj = info.event;
                    $("#nombre_est").val("");
                    $("#nombre_acu").val("");
					$("#telefono_acu").val("");
                    //alert(eventObj.title);
                    var title = eventObj.title;
                    var divisiones = title.split("-");
                    $("#nombre_est").val(divisiones[0].replace("Entrevista con: ", ""));
					$("#nombre_acu").val(divisiones[1].replace("Acudiente: ", ""));
					$("#telefono_acu").val(divisiones[2]);
                },
                selectable: true,
				longPressDelay: 0,
                selectOverlap: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                locale: initialLocaleCode,
                navLinks: true,
                eventSources: [{
                    events: [
                        <?php
                            while($fila = mysqli_fetch_array($exe)){                                
                        ?>
                        {
                            title: 'Entrevista con: <?php echo $fila['nombres_est']." ".$fila['apellidos_est']." - Acudiente: ".$fila['nombre_acu']." - ".$fila['telefono_acu'] ?>',
                            start: '<?php echo $fila['fecha']."T".$fila['hora'].":00:00" ?>'
                        },
                        <?php
                            }
                        ?>
                    ],
                    color: "#3788D8",
                    textColor: "white"
                }],
                
                businessHours: [ // specify an array instead
                    {
                        daysOfWeek: [ 1, 2, 3, 4, 5 ], 
                        startTime: '08:00', // 8am
                        endTime: '12:00' //12m
                    },
                    {
                        daysOfWeek: [ 1, 2, 3, 4, 5 ], 
                        startTime: '14:00', // 2pm
                        endTime: '18:00' // 6pm
                    },
                    {
                        daysOfWeek: [ 6 ], 
                        startTime: '08:00', // 8am
                        endTime: '12:00' // 12m
                    }
                ],
                dateClick: function(info) {
                    var dia = info.dateStr.substring(0,10);
                    var hora = info.dateStr.substring(11,13);
                    var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
                    
                    var parts = dia.split('-');
                    var mydate = new Date(parts[0], parts[1] - 1, parts[2]); 
                    //alert(mydate.toDateString());
                    ////alert(diasSemana[mydate.getDay()]);
                    
                    if(diasSemana[mydate.getDay()] == "Domingo") {
                        $("#fecha_ent").val("");
                        $("#hora_ent").val("");
                    }
                    else if(diasSemana[mydate.getDay()] == "Sábado") {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11") {
                            $("#fecha_ent").val(dia);
                            $("#hora_ent").val(hora);
                        }
                        else {
                            $("#fecha_ent").val("");
                            $("#hora_ent").val("");
                        }
                    }
                    else {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11" || hora == "14" || hora == "15" || hora == "16" || hora =="17") {
                            $("#fecha_ent").val(dia);
                            $("#hora_ent").val(hora);
                        }
                        else {
                            $("#fecha_ent").val("");
                            $("#hora_ent").val("");
                        }
                    }
                    
                    //mostrar_submit();
                    
                }
            });
            calendar.render();
        });
        
        function buscar_inf() {
            //alert("hola");
            //$(".loader").fadeOut("slow");
            
            //Se limpian los controles
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#nombrea").val("");
            $("#emaila").val("");
            $("#emaila_1").val("");
            
            //Se valida si el documento corresponde al código de pre-matrícula
            var buscar = $("#buscar").val();
            $("#documento_est").val(buscar);
            
            $.ajax({
                type:"POST",
        		url:"informacion_premat_getdat.php",
        		data:"buscar=" + buscar + "&tipo=DOC",
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var r_est = res.estado;
        		    //alert(r_est);
        		    //$("#estado").val(r_est);
        		    
        		    $("#nombree").val(res.nom_est + " " + res.ape_est);
        		    $("#gradoe").val(res.grado);
        		    $("#nombrea").val(res.nom_a);
        		    $("#emaila").val(res.email_a);
        		    $("#emaila_1").val(res.email_a);
        		    $("#cela").val(res.cel_a);
        		}
        	});
        	
        	mostrar_submit();
        }
        
        function mostrar_submit() {
            var control = 0;
            var nombre = $("#nombree").val();
            if(nombre == "") {
                $("#btnsubmit").hide();
                control = 1;
            }
            
            if(control == 0) {
                var grado = $("#gradoe").val();
                if(grado == "") {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                var fecha = $("#fecha_ent").val();
                if(fecha == "") {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                var hora = $("#hora_ent").val();
                if(hora == "") {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            if(control == 0) {
                $("#btnsubmit").show();
            }
        }
    
    </script>

    <style>
        .azul1 {
            background: lightblue;
            padding-top: 10px;
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
							<h4>Agenda Entrevistas CARTI:</h4><?php //echo $sql; ?>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="entrevista_putdat1.php" method="POST" id="form" name="form" enctype="multipart/form-data">
                               
                                <div class="form-group col-lg-9 text-left">
								    <div id='calendar'></div>
								</div>
								<div class="form-group col-lg-3 text-left">
								    <div class="form-group col-lg-12 text-left"> 
    								    <label for="apellidoe">Estudiante:</label>
    									<input type="text" class="form-control" id="nombre_est" name="nombre_est" required readonly>
									</div>
									<div class="form-group col-lg-12 text-left"> 
    								    <label for="apellidoe">Acudiente:</label>
    									<input type="text" class="form-control" id="nombre_acu" name="nombre_acu" required readonly>
									</div>
									<div class="form-group col-lg-12 text-left"> 
    								    <label for="apellidoe">Teléfono Acudiente:</label>
    									<input type="text" class="form-control" id="telefono_acu" name="telefono_acu" required readonly>
									</div>
								</div>
                                
                                <div class="form-group col-lg-12 text-right"> 
                                    <button type="submit" id="btnsubmit" class="btn btn-default" style="display: none;">Guardar</button>
                                    <input type="hidden" id="documento_est" name="documento_est"/>
                                    <input type="hidden" id="idpsi" name="idpsi" value="<?php echo $psicologo; ?>"/>
                                    <input type="hidden" id="nombrea" name="nombrea"/>
                                    <input type="hidden" id="emaila" name="emaila"/>
                                    <input type="hidden" id="cela" name="cela"/>
                                    <input type="hidden" id="cel_psi" name="cel_psi" value="<?php echo $cel_psi; ?>"/>
                                    <input type="hidden" id="meet_psi" name="meet_psi" value="<?php echo $meet_psi; ?>"/>
								</div>

								<div class="alert alert-danger" role="alert" id="alert" style="margin-top: 30px; display: none;">
								</div>
							</form> 
						</div>
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