<?php 
	session_start();
	require "../php/conexion.php";
	//errores de datos 1058354538
    //Para agendar entrevista 1029145024
	
	$psicologo = $_REQUEST['psicologo'];
	$txt_psicologo = $_REQUEST['txt_psicologo'];
	
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		$sql_emp = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW','PS') AND id NOT IN (1,30,31)";
		//$sql_emp = "SELECT * FROM tbl_empleados WHERE id = $psicologo";
		//$exe_emp = mysqli_query($conexion,$sql_emp);
		
		$sql_tipoagenda = "SELECT * FROM tbl_tipos_agenda WHERE id NOT IN (18, 19) ORDER BY tipo_agenda";
		$exe_tipoagenda = mysqli_query($conexion,$sql_tipoagenda);
		
		/*$sql = "SELECT e.*, pm.nombre_a, pm.celular_a, pm.email_a 
		FROM tbl_entrevistas e LEFT JOIN tbl_pre_matricula pm ON e.documento_est = pm.documento_est WHERE e.id_psicologo = $psicologo";*/
		$sql = "SELECT e.nombre_est, e.documento_est, e.fecha, e.hora, pm.nombre_a, pm.celular_a, pm.email_a, 'entrevista' fuente 
        FROM tbl_entrevistas e LEFT JOIN tbl_pre_matricula pm ON e.documento_est = pm.documento_est WHERE e.id_psicologo = $psicologo 
        UNION ALL 
        SELECT CONCAT(e.nombres, ' ', e.apellidos) nombre_est, s.documento_est, s.fecha, s.hora, e.acudiente_1, e.telefono_acudiente_1, e.email_acudiente_1, 'seguimiento' fuente
        FROM tbl_seguimientos s, estudiantes e WHERE s.documento_est = e.n_documento AND s.id_psicologo = $psicologo 
        UNION ALL 
        SELECT CONCAT(e.nombres, ' ', e.apellidos) nombre_est, e.n_documento, s.fecha, s.hora, e.acudiente_1, e.telefono_acudiente_1, e.email_acudiente_1, 'seguimiento' fuente
        FROM tbl_seg_psi s, tbl_seg_psi_val v, estudiantes e WHERE s.id_valoracion = v.id AND v.n_documento = e.n_documento AND s.id_psicologo = $psicologo 
        UNION ALL 
        SELECT a.descripcion nombre_est, '--' documento, a.fecha, a.hora, '--' nombre_a, '--' cel_a, '--' email_a, ta.tipo_agenda fuente 
        FROM tbl_agendamientos a, tbl_tipos_agenda ta WHERE a.id_tipo_agenda = ta.id AND a.id_empleado = $psicologo";
		$exe = mysqli_query($conexion, $sql);
		//echo $sql;
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
                    $("#fecha_agenda").val("");
                    $("#hora_agenda").val("");
                    $("#ctr_fecha_agenda").val(1);
                    $("#ctr_hora_agenda").val(1);
                    alert(eventObj.title);
                    mostrar_submit("fecha_agenda");
                },
                selectable: true,
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
                                if($fila['fuente'] == 'entrevista') {
                        ?>
                        {
                            title: 'Entrevista con: <?php echo $fila['nombre_est']."-".$fila['documento_est']." - Acudiente: ".$fila['nombre_a']."-".$fila['celular_a'] ?>',
                            start: '<?php echo $fila['fecha']."T".$fila['hora'].":00:00" ?>'
                        },
                        <?php
                                }
                                else if($fila['fuente'] == 'seguimiento') {
                        ?>
                        {
                            title: 'Seguimiento con: <?php echo $fila['nombre_est']."-".$fila['documento_est']." - Acudiente: ".$fila['nombre_a']."-".$fila['celular_a'] ?>',
                            start: '<?php echo $fila['fecha']."T".$fila['hora'].":00:00" ?>',
                            color: "lightgreen",
                            textColor: "black"
                        },
                        <?php
                                }
                                else {
                        ?>
                        {
                            title: 'Evento: <?php echo $fila['fuente'].", Descripción: ".$fila['nombre_est'] ?>',
                            start: '<?php echo $fila['fecha']."T".$fila['hora'].":00:00" ?>',
                            color: "yellow",
                            textColor: "black"
                        },
                        <?php
                                }
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
                        $("#fecha_agenda").val("");
                        $("#hora_agenda").val("");
                        $("#ctr_fecha_agenda").val(1);
                        $("#ctr_hora_agenda").val(1);
                    }
                    else if(diasSemana[mydate.getDay()] == "Sábado") {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11") {
                            $("#fecha_agenda").val(dia);
                            $("#hora_agenda").val(hora);
                            $("#ctr_fecha_agenda").val(0);
                            $("#ctr_hora_agenda").val(0);
                        }
                        else {
                            $("#fecha_agenda").val("");
                            $("#hora_agenda").val("");
                            $("#ctr_fecha_agenda").val(1);
                            $("#ctr_hora_agenda").val(1);
                        }
                    }
                    else {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11" || hora == "14" || hora == "15" || hora == "16" || hora =="17") {
                            $("#fecha_agenda").val(dia);
                            $("#hora_agenda").val(hora);
                            $("#ctr_fecha_agenda").val(0);
                            $("#ctr_hora_agenda").val(0);
                        }
                        else {
                            $("#fecha_agenda").val("");
                            $("#hora_agenda").val("");
                            $("#ctr_fecha_agenda").val(1);
                            $("#ctr_hora_agenda").val(1);
                        }
                    }
                    
                    mostrar_submit("fecha_agenda");
                    
                }
            });
            calendar.render();
            
            $("#tipoagenda").change(function() {
        		var ta = $("#tipoagenda").val();
        		var ta_txt = $("#tipoagenda option:selected").text();
        		$("#ta_text").val(ta_txt);
        		
        		var control = 0;
        		//alert(td);
        		if(ta == 0) {
        			$("#btnguardar").hide();
        			$("#ctr_tipoagenda").val(1);
        			var texto = "Debe seleccionar un tipo de agenda";
                    $("#lblmsg").html(texto).css("color","red");
        		}
        		else {
        		    //$("#btnEnviar").show();
        		    $("#ctr_tipoagenda").val(0);
        		    $("#lblmsg").html("");
        		}
        		mostrar_submit("tipoagenda");
        	});
        });
        
        function mayus(e, id, desc) {
            e.value = e.value.toUpperCase();
            
            if(id == "txtpreg") {
                validar_texto(id, desc);
            }
            else {
                validar_texto(id, desc);
            }
        }
        
        function validar_texto(id, desc) {
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var v_input = document.getElementById(id);
            var v_val = /[-_'"\<\>\~\^\*\$\#\%\&\=\+\|\{\}\[\]\\]{1,}/;
            //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
            var val = String($(id_obj).val()).match(v_val);
            
            if(val == null) {
                v_input.setCustomValidity("");
                $("#lblmsg").html("");
                //$("#alert").hide();
                $(ctr_obj).val(0);
            }
            else {
                v_input.setCustomValidity("Ha ingresado caracteres inválidos");
                var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                texto += "- _ \' \" < > ~ ^ * $ # & = + | { } [ ] \\";
                //alert(texto);
                $("#lblmsg").html(texto).css("color","red");
                //$("#alert").show();
                $(ctr_obj).val(1);
                control = 1;
            }
			
			if(control == 0) {
			    if($(id_obj).val() == "") {
			        var texto = "El campo " + desc + " se debe llenar";
    				$("#lblmsg").html(texto).css("color","red");
    				//$("#alert").show();
                    $(ctr_obj).val(1);
			    }
			}
			
            mostrar_submit(id);
        }
        
        function mostrar_submit(id) {
            var control = 0;
            
            var id_obj = "#" + id;
            var long = $(id_obj).val().length;
            //alert(long);
            
            //Se controla la longitud máxima
            if(id == "descripcion") {
                $("#lbldescripcion").html(long);
                if(long > 200) {
                    $("#ctr_descripcion").val(1);
                }
            }
            
            //var a = parseInt($("#ctr_psicologo").val());
            var b = parseInt($("#ctr_tipoagenda").val());
            var c = parseInt($("#ctr_descripcion").val());
            var d = parseInt($("#ctr_fecha_agenda").val());
            var e = parseInt($("#ctr_hora_agenda").val());
            
            control = parseInt($("#ctr_tipoagenda").val()) + parseInt($("#ctr_descripcion").val()) 
            + parseInt($("#ctr_fecha_agenda").val()) + parseInt($("#ctr_hora_agenda").val());
            
            //alert(control);
            if(control > 0) {
                $("#btnguardar").hide();
            }
            else {
                $("#btnguardar").show();
            }
            
            //(a == 1) ? $("#psicologo").addClass("error") : $("#psicologo").removeClass("error");
            (b == 1) ? $("#tipoagenda").addClass("error") : $("#tipoagenda").removeClass("error");
            (c == 1) ? $("#descripcion").addClass("error") : $("#descripcion").removeClass("error");
            (d == 1) ? $("#fecha_agenda").addClass("error") : $("#fecha_agenda").removeClass("error");
            (e == 1) ? $("hora_agenda").addClass("error") : $("#hora_agenda").removeClass("error");
            
        }
    
    </script>

    <style>
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
							<h4>Programar nuevo evento en la agenda:</h4><?php //echo $sql_emp; ?>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="agenda_putdat1.php" method="POST" id="form" name="form" enctype="multipart/form-data">
                                
                                <div class="form-group col-lg-6"> 
                                    <label for="psi_text">Psicólogo:</label>
                                    <input type="text" class="form-control" id="psi_text" name="psi_text" value="<?php echo $txt_psicologo; ?>" readonly>
                                    <!--<input type="hidden" style="width: 20px" id="ctr_sel_psi" value="0"/>-->
    								<input type="hidden" id="id_psi_text" name="id_psi_text" value="<?php echo $psicologo; ?>"/>
								</div>
								
								<div class="form-group col-lg-6 text-left"> 
                                <label for="tipoagenda">Tipo agenda:</label> 
									<select id="tipoagenda" name="tipoagenda" width="300px" class="form-control1">
										<?php
										    while ($row_tipoagenda = mysqli_fetch_array($exe_tipoagenda)) {
										        echo '<option value="'.$row_tipoagenda['id'].'">'.$row_tipoagenda['tipo_agenda'].'</option>';
										    }
										?>
									</select>
									<input type="hidden" style="width: 20px" id="ctr_tipoagenda" value="1"/>
									<input type="hidden" id="ta_text" name="ta_text"/>
								</div>
								
                                <div class="form-group col-lg-12"> 
									<label for="descripcion">Descripción (200 | <label class="maxl" id="lbldescripcion">0</label>) -> Si no aplica ingresar NA.</label> 
									<textarea id="descripcion" name="descripcion"  rows="4" class="form-control1" placeholder="Descripción del evento" maxlength="200" onkeyup="mayus(this, 'descripcion', 'Descripción del evento');" required></textarea>
									<input type="hidden" class="textarea" style="width: 20px" id="ctr_descripcion" value="1"/>
								</div>
								
								<div class="form-group col-lg-9 text-left">
								    <div id='calendar'></div>
								</div>
								<div class="form-group col-lg-3 text-left">
								    <div class="form-group col-lg-12 text-left"> 
    								    <label for="fecha_agenda">Fecha (yyyy-mm-dd):</label>
    									<input type="text" class="form-control" id="fecha_agenda" name="fecha_agenda" required readonly>
    									<input type="hidden" style="width: 20px" id="ctr_fecha_agenda" value="1"/>
									</div>
									<div class="form-group col-lg-12 text-left"> 
    								    <label for="hora_agenda">Hora:</label>
    									<input type="text" class="form-control" id="hora_agenda" name="hora_agenda" required readonly>
    									<input type="hidden" style="width: 20px" id="ctr_hora_agenda" value="1"/>
									</div>
								</div>
                                
                                <div class="form-group col-lg-12 text-right"> 
                                    <button type="submit" id="btnguardar" class="btn btn-default" style="display: none;">Guardar</button>
								</div>
								
							</form> 
						</div>
						
						<div class="alert alert-danger" role="alert" id="alert">
                            <p><i class="fa fa-warning"></i><span>: </span><label id="lblmsg"></label>
                            <input type="text" class="alert alert-danger" style="width: 10px" id="txtvacio" value="0"></p>
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