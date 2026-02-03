<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab'])) {
	    
	    $psicologo = $_REQUEST['psicologo'];
	    $txt_psicologo = $_REQUEST['txt_psicologo'];
	    //echo $psicologo." ".$txt_psicologo;

		$sqlAdministrador="SELECT * FROM `administrador` WHERE `Email`='".$_SESSION['admin_unicab']."'";
		$exeAdministrador=mysqli_query($conexion,$sqlAdministrador);

		while ($rowAdmin=mysqli_fetch_array($exeAdministrador)) {
			$IdAdministrador=$rowAdmin['IdAdministrador'];
			$Apellidos=$rowAdmin['Apellido'];
			$Nombres=$rowAdmin['Nombre'];
		}
		
		$sql_sol_acomp = "SELECT * FROM tbl_solicitud_seguimientos";
		$exe_sol_acomp = mysqli_query($conexion, $sql_sol_acomp);
		
		//$sql_emp = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW','PS') AND id NOT IN (1,30,31)";
		//$exe_emp = mysqli_query($conexion,$sql_emp);
		
		$sql_agenda = "SELECT e.nombre_est, e.documento_est, e.fecha, e.hora, pm.nombre_a, pm.celular_a, pm.email_a, 'entrevista' fuente 
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
		$exe_agenda = mysqli_query($conexion, $sql_agenda);
		
		//Se hace la consulta para los eventos agendados
		$sql_eventos = "SELECT * FROM tbl_agendamientos WHERE id_empleado = $psicologo AND estado = 'en proceso' AND id_tipo_agenda = 16";
		$exe_eventos = mysqli_query($conexion, $sql_eventos);
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
                    $("#fecha_pseg").val("");
                    $("#hora_pseg").val("");
                    $("#ctr_fecha_pseg").val(1);
                    $("#ctr_hora_pseg").val(1);
                    alert(eventObj.title);
                    mostrar_submit("fecha_pseg");
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
                            while($fila = mysqli_fetch_array($exe_agenda)){
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
                        $("#fecha_pseg").val("");
                        $("#hora_pseg").val("");
                        $("#ctr_fecha_pseg").val(1);
                        $("#ctr_hora_pseg").val(1);
                    }
                    else if(diasSemana[mydate.getDay()] == "Sábado") {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11") {
                            $("#fecha_pseg").val(dia);
                            $("#hora_pseg").val(hora);
                            $("#ctr_fecha_pseg").val(0);
                            $("#ctr_hora_pseg").val(0);
                        }
                        else {
                            $("#fecha_pseg").val("");
                            $("#hora_pseg").val("");
                            $("#ctr_fecha_pseg").val(1);
                            $("#ctr_hora_pseg").val(1);
                        }
                    }
                    else {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11" || hora == "14" || hora == "15" || hora == "16" || hora =="17") {
                            $("#fecha_pseg").val(dia);
                            $("#hora_pseg").val(hora);
                            $("#ctr_fecha_pseg").val(0);
                            $("#ctr_hora_pseg").val(0);
                        }
                        else {
                            $("#fecha_pseg").val("");
                            $("#hora_pseg").val("");
                            $("#ctr_fecha_pseg").val(1);
                            $("#ctr_hora_pseg").val(1);
                        }
                    }
                    
                    mostrar_submit("fecha_pseg");
                    
                }
            });
            calendar.render();
            
            var contenido=$(".ghf");
            contenido.slideUp(250);
            
            $("#sel_evento").change(function() {
        		var evento = $("#sel_evento").val();
        		var evento_txt = $("#sel_evento option:selected").text();
        		$("#evento_text").val(evento_txt);
        		
        		var control = 0;
        		//alert(td);
        		if(evento == 0) {
        			$("#btnguardar").hide();
        			$("#ctr_sel_evento").val(1);
        			var texto = "Debe seleccionar evento agendado";
                    $("#lblmsg").html(texto).css("color","red");
        		}
        		else {
        		    //$("#btnEnviar").show();
        		    $("#ctr_sel_evento").val(0);
        		    $("#lblmsg").html("");
        		}
        		mostrar_submit("sel_evento");
        	});
            
            $("#sel_piar").change(function() {
        		var piar = $("#sel_piar").val();
        		var piar_txt = $("#sel_piar option:selected").text();
        		$("#piar_text").val(piar_txt);
        		
        		var control = 0;
        		//alert(td);
        		if(piar == 0) {
        			$("#btnguardar").hide();
        			$("#ctr_sel_piar").val(1);
        			var texto = "Debe seleccionar ¿Cuenta con PIAR?";
                    $("#lblmsg").html(texto).css("color","red");
        		}
        		else {
        		    //$("#btnEnviar").show();
        		    $("#ctr_sel_piar").val(0);
        		    $("#lblmsg").html("");
        		}
        		mostrar_submit("sel_piar");
        	});
        	
        	$("#sel_acomp").change(function() {
        	    $("#id_emp").val(0);
        	    
        		var acomp = $("#sel_acomp").val();
        		var acomp_txt = $("#sel_acomp option:selected").text();
        		$("#acomp_text").val(acomp_txt);
        		
        		var control = 0;
        		//alert(td);
        		if(acomp == 0) {
        			$("#btnguardar").hide();
        			$("#ctr_sel_acomp").val(1);
        			var texto = "Debe seleccionar ¿Quíen solicita el acompañamiento?";
                    $("#lblmsg").html(texto).css("color","red");
        		}
        		else {
        		    //$("#btnEnviar").show();
        		    $("#ctr_sel_acomp").val(0);
        		    $("#lblmsg").html("");
        		    
        		    //Se carga el listado de tutores (6) o psicólogos (4) -> informacion_premat_getdat.php
        		    if(acomp == 4 || acomp == 6) {
        		        $.ajax({
                            type:"POST",
                    		url:"informacion_tut_psi.php",
                    		data:"acomp=" + acomp,
                    		success:function(r) {
                    		    $("#sel_emp").html(r);
                    		}
                    	});
                    	
                    	$('#modal_new').modal('toggle');
                        $('#modal_new').modal('show');
        		    }
        		    else if(acomp == 2) {
        		        $("#id_emp").val(2);
        		    }
        		    else if(acomp == 5) {
        		        $("#id_emp").val(1);
        		    }
        		    else {
        		        $("#id_emp").val(0);
        		    }
        		}
        		mostrar_submit("sel_acomp");
        	});
        	
        	$("#sel_emp").change(function() {
        		var id_emp = $("#sel_emp").val();
        		$("#id_emp").val(id_emp);
        	});
        	
        });
        
        /*$(function() {
            var contenido=$(".ghf");
            contenido.slideUp(250);
            
            $("#sel_piar").change(function() {
        		var piar = $("#sel_piar").val();
        		var piar_txt = $("#sel_piar option:selected").text();
        		$("#piar_text").val(piar_txt);
        		
        		var control = 0;
        		//alert(td);
        		if(piar == 0) {
        			$("#btnguardar").hide();
        			$("#ctr_sel_piar").val(1);
        			var texto = "Debe seleccionar ¿Cuenta con PIAR?";
                    $("#lblmsg").html(texto).css("color","red");
        		}
        		else {
        		    //$("#btnEnviar").show();
        		    $("#ctr_sel_piar").val(0);
        		    $("#lblmsg").html("");
        		}
        		mostrar_submit("sel_piar");
        	});
        	
        	$("#sel_acomp").change(function() {
        	    $("#id_emp").val(0);
        	    
        		var acomp = $("#sel_acomp").val();
        		var acomp_txt = $("#sel_acomp option:selected").text();
        		$("#acomp_text").val(acomp_txt);
        		
        		var control = 0;
        		//alert(td);
        		if(acomp == 0) {
        			$("#btnguardar").hide();
        			$("#ctr_sel_acomp").val(1);
        			var texto = "Debe seleccionar ¿Quíen solicita el acompañamiento?";
                    $("#lblmsg").html(texto).css("color","red");
        		}
        		else {
        		    //$("#btnEnviar").show();
        		    $("#ctr_sel_acomp").val(0);
        		    $("#lblmsg").html("");
        		    
        		    //Se carga el listado de tutores (6) o psicólogos (4) -> informacion_premat_getdat.php
        		    if(acomp == 4 || acomp == 6) {
        		        $.ajax({
                            type:"POST",
                    		url:"informacion_tut_psi.php",
                    		data:"acomp=" + acomp,
                    		success:function(r) {
                    		    $("#sel_emp").html(r);
                    		}
                    	});
                    	
                    	$('#modal_new').modal('toggle');
                        $('#modal_new').modal('show');
        		    }
        		    else if(acomp == 2) {
        		        $("#id_emp").val(2);
        		    }
        		    else if(acomp == 5) {
        		        $("#id_emp").val(1);
        		    }
        		    else {
        		        $("#id_emp").val(0);
        		    }
        		}
        		mostrar_submit("sel_acomp");
        	});
        	
        	$("#sel_emp").change(function() {
        		var id_emp = $("#sel_emp").val();
        		$("#id_emp").val(id_emp);
        	});
        	
        });*/
    
        function buscar_inf() {
            //alert("hola");
            var contenido=$(".ghf");
            contenido.slideUp(250);
            
            //Se limpian los controles
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#observaciones_g").val("");
            $("#psi_ent").val("");
            $("#lbldocumento").html("");
            
            var buscar = $("#buscar").val();
            var patron = /^[0-9]{1,}$/;
            var esCoincidente = patron.test($("#buscar").val());
            if(esCoincidente) {
                $("#lblmsg").html("");
                $("#ctr_buscar").val(0);
            }
            
            $.ajax({
                type:"POST",
        		url:"informacion_premat_getdat.php",
        		data:"buscar=" + buscar + "&tipo=DOC",
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var r_est = res.estado;
        		    var grados = res.grados_val;
        		    //alert(r_est);
        		    //var psic = $("#psicologo").val();
        		    //alert(Object.keys(res.grados_val).length);
        		    //alert(Object.keys(res.grados_val));
        		    
        		    if(res.ct == 1) {
        		        if(res.ct_val == 1) {
        		            $("#lbldocumento").html("Este documento ya tiene valoración y el proceso no está cerrado.");
        		        }
        		        else {
        		            if(res.ct_val_ant > 0) {
        		                $("#lbldocumento").html("Este documento tiene valoraciones anteriores con proceso ya cerrado. Puede crear una nueva valoración");
        		            }
        		            //alert("Datos cargados ");
                		    $("#nombree").val(res.nom_est + " " + res.ape_est);
                		    $("#gradoe").val(res.grado);
                		    $("#observaciones_g").val(res.obs_ent);
                		    $("#psi_ent").val(res.nom_emp);
                		    /*$("#psicologo").show();
                		    $("#documento").val(buscar);
                		    $("#idprem").val(res.id);
                		    $("#codigoe").val(res.id);
                		    $("#observaciones").val(res.obs_ent);*/
                		    
                		    var contenido=$(".ghf");
                            contenido.slideDown(250);
        		        }
        		    }
        		    else {
        		        if(res.ct_est == 1) {
        		            if(res.ct_val == 1) {
            		            $("#lbldocumento").html("Este documento no tiene información de entrevista pero ya tiene valoración.");
            		        }
            		        else {
            		            if(res.ct_val_ant > 0) {
            		                $("#lbldocumento").html("Este documento tiene valoraciones anteriores con proceso ya cerrado. Puede crear una nueva valoración.");
            		            }
            		            //alert("Este documento no tiene información de entrevista");
            		            $("#lbldocumento").html("Este documento no tiene información de entrevista.");
                		        $("#nombree").val(res.nom_est + " " + res.ape_est);
                		        $("#gradoe").val(res.grado);
                		        
                		        var contenido=$(".ghf");
                                contenido.slideDown(250);
            		        }
            		    }
            		    else {
            		        //alert("Este documento no tiene información de entrevista ni es estudiante registrado");
            		        $("#lbldocumento").html("Este documento no tiene información de entrevista  ni es estudiante registrado.");
            		    }
        		    }
        		}
        	});
        	
        	mostrar_submit("buscar");
        }
        
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
            if(id == "motivo_val") {
                $("#lblmotivo_val").html(long);
                if(long > 200) {
                    $("#ctr_motivo_val").val(1);
                }
            }
            else if(id == "nivel_bio") {
                $("#lblnivel_bio").html(long);
                if(long > 500) {
                    $("#ctr_nivel_bio").val(1);
                }
            }
            else if(id == "nivel_int") {
                $("#lblnivel_int").html(long);
                if(long > 500) {
                    $("#ctr_nivel_int").val(1);
                }
            }
            else if(id == "nivel_mot") {
                $("#lblnivel_mot").html(long);
                if(long > 500) {
                    $("#ctr_nivel_mot").val(1);
                }
            }
            else if(id == "autonomia") {
                $("#lblautonomia").html(long);
                if(long > 500) {
                    $("#ctr_autonomia").val(1);
                }
            }
            else if(id == "nivel_len") {
                $("#lblnivel_len").html(long);
                if(long > 500) {
                    $("#ctr_nivel_len").val(1);
                }
            }
            else if(id == "nivel_soc") {
                $("#lblnivel_soc").html(long);
                if(long > 500) {
                    $("#ctr_nivel_soc").val(1);
                }
            }
            else if(id == "personalidad") {
                $("#lblpersonalidad").html(long);
                if(long > 500) {
                    $("#ctr_personalidad").val(1);
                }
            }
            else if(id == "nivel_esc") {
                $("#lblnivel_esc").html(long);
                if(long > 500) {
                    $("#ctr_nivel_esc").val(1);
                }
            }
            else if(id == "con_soc_fam") {
                $("#lblcon_soc_fam").html(long);
                if(long > 500) {
                    $("#ctr_con_soc_fam").val(1);
                }
            }
            else if(id == "obs_psi") {
                $("#lblobs_psi").html(long);
                if(long > 500) {
                    $("#ctr_obs_psi").val(1);
                }
            }
            
            var doc = parseInt($("#ctr_buscar").val());
            
            var a = parseInt($("#ctr_motivo_val").val());
            var b = parseInt($("#ctr_nivel_bio").val());
            var c = parseInt($("#ctr_nivel_int").val());
            var d = parseInt($("#ctr_nivel_mot").val());
            var e = parseInt($("#ctr_autonomia").val());
            var f = parseInt($("#ctr_nivel_len").val());
            var g = parseInt($("#ctr_nivel_soc").val());
            var h = parseInt($("#ctr_personalidad").val());
            var i = parseInt($("#ctr_nivel_esc").val());
            var j = parseInt($("#ctr_con_soc_fam").val());
            var k = parseInt($("#ctr_obs_psi").val());
            var l = parseInt($("#ctr_fecha_pseg").val());
            //var m = parseInt($("#ctr_sel_psi").val());
            var n = parseInt($("#ctr_sel_piar").val());
            var o = parseInt($("#ctr_sel_acomp").val());
            var p = parseInt($("#ctr_hora_pseg").val());
            var q = parseInt($("#ctr_sel_evento").val());
            //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
            
            control = parseInt($("#ctr_motivo_val").val()) + parseInt($("#ctr_nivel_bio").val()) + parseInt($("#ctr_nivel_int").val()) + parseInt($("#ctr_nivel_mot").val()) 
                + parseInt($("#ctr_autonomia").val()) + parseInt($("#ctr_nivel_len").val()) + parseInt($("#ctr_nivel_soc").val()) + parseInt($("#ctr_personalidad").val()) 
                + parseInt($("#ctr_nivel_esc").val()) + parseInt($("#ctr_con_soc_fam").val()) + parseInt($("#ctr_obs_psi").val()) + parseInt($("#ctr_fecha_pseg").val()) 
                + parseInt($("#ctr_buscar").val()) + parseInt($("#ctr_sel_piar").val()) + parseInt($("#ctr_sel_acomp").val()) + parseInt($("#ctr_hora_pseg").val()) 
                + parseInt($("#ctr_sel_evento").val());
            
            //alert(control);
            if(control > 0) {
                $("#btnguardar").hide();
            }
            else {
                $("#btnguardar").show();
            }
            
            //(doc == 1) ? $("#buscar").addClass("error") : $("#buscar").removeClass("error");
            //(doc == 2) ? $("#buscar").addClass("val_temporal") : $("#buscar").removeClass("val_temporal");
            
            if(doc == 0) {
                $("#buscar").removeClass("error");
                $("#buscar").removeClass("val_temporal");
            }
            else if(doc == 1) {
                $("#buscar").removeClass("val_temporal");
                $("#buscar").addClass("error");
            }
            else if(doc == 2) {
                $("#buscar").removeClass("error");
                $("#buscar").addClass("val_temporal");
            }
            
            (a == 1) ? $("#motivo_val").addClass("error") : $("#motivo_val").removeClass("error");
            (b == 1) ? $("#nivel_bio").addClass("error") : $("#nivel_bio").removeClass("error");
            (c == 1) ? $("#nivel_int").addClass("error") : $("#nivel_int").removeClass("error");
            (d == 1) ? $("#nivel_mot").addClass("error") : $("#nivel_mot").removeClass("error");
            (e == 1) ? $("#autonomia").addClass("error") : $("#autonomia").removeClass("error");
            (f == 1) ? $("#nivel_len").addClass("error") : $("#nivel_len").removeClass("error");
            (g == 1) ? $("#nivel_soc").addClass("error") : $("#nivel_soc").removeClass("error");
            (h == 1) ? $("#personalidad").addClass("error") : $("#personalidad").removeClass("error");
            (i == 1) ? $("#nivel_esc").addClass("error") : $("#nivel_esc").removeClass("error");
            (j == 1) ? $("#con_soc_fam").addClass("error") : $("#con_soc_fam").removeClass("error");
            (k == 1) ? $("#obs_psi").addClass("error") : $("#obs_psi").removeClass("error");
            (l == 1) ? $("#fecha_pseg").addClass("error") : $("#fecha_pseg").removeClass("error");
            //(m == 1) ? $("#sel_psi").addClass("error") : $("#sel_psi").removeClass("error");
            //(m == 1) ? $("#lbl_psi").addClass("error") : $("#lbl_psi").removeClass("error");
            (n == 1) ? $("#sel_piar").addClass("error") : $("#sel_piar").removeClass("error");
            (o == 1) ? $("#sel_acomp").addClass("error") : $("#sel_acomp").removeClass("error");
            (p == 1) ? $("#hora_pseg").addClass("error") : $("#hora_pseg").removeClass("error");
            (q == 1) ? $("#sel_evento").addClass("error") : $("#sel_evento").removeClass("error");
        }
        
        function validar_fecha(id, desc) {
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var input_fecha = document.getElementById(id);
            var patron = /^[0-9]{4}-[0-1]{1}[0-9]{1}-[0-3]{1}[0-9]{1}$/;
            var esCoincidente = patron.test($(id_obj).val());
            if(esCoincidente) {
                input_fecha.setCustomValidity("");
                $("#lblmsg").html("");
                $(ctr_obj).val(0);
                
                var fecha = $(id_obj).val();
                var porciones = fecha.split("-");
                var a = parseInt(porciones[0]);
                var m = parseInt(porciones[1]);
                var d = parseInt(porciones[2]);
                
                if(a < 1850 || a > 2050) {
                    input_fecha.setCustomValidity("No es una fecha de nacimiento válida");
                    var texto = "No es un patrón válido para " + desc;
                    $("#lblmsg").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                }
                if(m < 1 || m > 12) {
                    input_fecha.setCustomValidity("No es una fecha de nacimiento válida");
                    var texto = "No es un patrón válido para " + desc;
                    $("#lblmsg").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                }
                else {
                    if(m == 2) {
                       if(d < 1 || d > 29) {
                            input_fecha.setCustomValidity("No es una fecha de nacimiento válida");
                            var texto = "No es un patrón válido para " + desc;
                            $("#lblmsg").html(texto).css("color","red");
                            $(ctr_obj).val(1);
                        } 
                    }
                    else if(m == 4 || m == 6 || m == 9 || m == 11) {
                       if(d < 1 || d > 30) {
                            input_fecha.setCustomValidity("No es una fecha de nacimiento válida");
                            var texto = "No es un patrón válido para " + desc;
                            $("#lblmsg").html(texto).css("color","red");
                            $(ctr_obj).val(1);
                        } 
                    }
                    else {
                       if(d < 1 || d > 31) {
                            input_fecha.setCustomValidity("No es una fecha de nacimiento válida");
                            var texto = "No es un patrón válido para " + desc;
                            $("#lblmsg").html(texto).css("color","red");
                            $(ctr_obj).val(1);
                        } 
                    }
                }
                
            }
            else {
                input_fecha.setCustomValidity("No es una fecha de nacimiento válida");
                var texto = "No es un patrón válido para " + desc;
                //alert(texto);
                $("#lblmsg").html(texto).css("color","red");
                $(ctr_obj).val(1);
                //control = 1;
            }
            
            mostrar_submit(id);
        }
        
        function validar_numero(id, desc) {
            var contenido=$(".ghf");
            contenido.slideUp(250);
            
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            $(ctr_obj).val(1);
            
            //Se limpian los textarea y la fecha del primer seguimiento
            $("textarea").val("");
            $(".textarea").val(1);
            $(".maxl").html("0");
            $("#fecha_pseg").val("");
            $("#ctr_fecha_pseg").val(1);
            
            $("#lbldocumento").html("");
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#observaciones_g").val("");
            $("#psi_ent").val("");
            
            //Se resetean los select
            //document.getElementById("sel_psi").value = 0;
            document.getElementById("sel_piar").value = 0;
            document.getElementById("sel_acomp").value = 0;
            //$("#ctr_sel_psi").val(1);
            $("#ctr_sel_piar").val(1);
            $("#ctr_sel_acomp").val(1);
            
            $("#id_emp").val(0);
            
            var v_input = document.getElementById(id);
            var patron = /^[0-9]{1,}$/;
            //var val = String($(id_obj).val()).match(v_val);
            var esCoincidente = patron.test($(id_obj).val());
            //alert(esCoincidente);
            if(esCoincidente) {
                v_input.setCustomValidity("");
                $("#lblmsg").html("");
                $(ctr_obj).val(2);
            }
            else {
                v_input.setCustomValidity("Ha ingresado caracteres inválidos");
                var texto = "Ingrese sólamente números para " + desc;
                //alert(texto);
                $("#lblmsg").html(texto).css("color","red");
                $(ctr_obj).val(1);
                control = 1;
            }
            
            mostrar_submit(id);
        }
        
        function cargar_agenda() {
            $('#modal_fecha_pseg').modal('toggle');
            $('#modal_fecha_pseg').modal('show');
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
        .documento {
            border: none;
            background: lightblue;
            border-bottom: 1px solid blue;
        }
        .error {
            border: 3px solid red !important;
        }
        .val_temporal {
            border: 3px solid blue !important;
        }
        .maxl {
            color: blue;
        }
        #lbldocumento {
            color: red;
            font-size: 16px;
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
							<h4>Crear nueva valoración:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/crear_valoracion.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

								<div class="form-group col-lg-3"> 
									<label for="buscar">Documento estudiante</label> 
									<input type="text" class="form-control documento" id="buscar" name="buscar" placeholder="Ingrese documento estudiante" autofocus="" onkeyup="validar_numero('buscar', 'Documento estudiante');" required>
									<input type="hidden" style="width: 20px" id="ctr_buscar" value="1"/>
								</div>
								<div class="form-group col-lg-2">
								    <br> 
            					    <!--<button class="btn btn-success" id="btnbuscar" onclick="buscar_inf();">Buscar</button>-->
            					    <input type="button" class="btn btn-success" id="btnbuscar" onclick="buscar_inf();" value="Buscar">
            					</div>
								<div class="form-group col-lg-5"> 
                                    <label for="nombree">Nombre estudiante:</label>
									<input type="text" class="form-control" id="nombree" name="nombree" width="300px" readonly>
								</div>
								<div class="form-group col-lg-2"> 
                                    <label for="gradoe">Grado:</label>
									<input type="text" class="form-control" id="gradoe" name="gradoe" width="300px" readonly>
								</div>
								<div class="form-group col-lg-12"> 
                                    <span class="badge badge-pill badge-warning"><label id="lbldocumento"></label></span>
								</div>
								<!--*********************************************************************************************************-->
								
								<div class="form-group col-lg-12"> 
                                    <label for="observaciones_g">Observaciones entrevista:</label>
                                    <textArea type="text" class="form-control largo1" id="observaciones_g" name="observaciones_g" maxlength="400" readonly></textArea>
								</div>
								<div class="form-group col-lg-12"> 
                                    <label for="psi_ent">Psicólogo entrevista:</label>
                                    <input type="text" class="form-control" id="psi_ent" name="psi_ent" width="300px" readonly>
								</div>
								
								<div class="form-group col-lg-12"> 
                                    <label for="psi_text">Psicólogo a cargo:</label>
                                    <input type="text" class="form-control" id="psi_text" name="psi_text" value="<?php echo $txt_psicologo; ?>" readonly>
                                    <!--<input type="hidden" style="width: 20px" id="ctr_sel_psi" value="0"/>-->
    								<input type="hidden" id="id_psi_text" name="id_psi_text" value="<?php echo $psicologo; ?>"/>
								</div>
								
								<div class="ghf">
								    <div class="form-group col-lg-12"> 
    									<label for="sel_evento" id="lbl_piar">Evento agendado:</label> 
    									<select id="sel_evento" name="sel_evento" class="form-control1" required>
    										<option value="0" selected>--- SELECCIONE ---</option>
    										<?php
    										    while ($row_eventos = mysqli_fetch_array($exe_eventos)) {
    										        echo '<option value="'.$row_eventos['id'].'">Valoración: Fecha: '.$row_eventos['fecha'].', Hora:  '.$row_eventos['hora'].' -> '.$row_eventos['descripcion'].'</option>';
    										    }
    										?>
    									</select>
    									<input type="hidden" style="width: 20px" id="ctr_sel_evento" value="1"/>
    									<input type="hidden" id="piar_text" name="evento_text"/>
    								</div>
    								
    								<div class="form-group col-lg-6"> 
    									<label for="sel_piar" id="lbl_piar">¿Cuenta con PIAR?</label> 
    									<select id="sel_piar" name="sel_piar" class="form-control1" required>
    										<option value="0" selected>--- SELECCIONE ---</option>
    										<option value="SI">SI</option>
    										<option value="NO">NO</option>
    									</select>
    									<input type="hidden" style="width: 20px" id="ctr_sel_piar" value="1"/>
    									<input type="hidden" id="piar_text" name="piar_text"/>
    								</div>
    								
    								<div class="form-group col-lg-6"> 
    									<label for="sel_acomp" id="lbl_sel_acomp">¿Quién solicita el acompañamiento?</label> 
    									<select id="sel_acomp" name="sel_acomp" class="form-control1" required>
    										<option value="0" selected>--- SELECCIONE ---</option>
    										<?php
    										    while ($row_sol_acom = mysqli_fetch_array($exe_sol_acomp)) {
    										        echo '<option value="'.$row_sol_acom['id'].'">'.$row_sol_acom['solicitud_por'].'</option>';
    										    }
    										?>
    									</select>
    									<input type="hidden" style="width: 20px" id="ctr_sel_acomp" value="1"/>
    									<input type="hidden" id="acomp_text" name="acomp_text"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="motivo_val">Motivo valoración inicial (200 | <label class="maxl" id="lblmotivo_val">0</label>)</label> 
    									<textarea id="motivo_val" name="motivo_val"  rows="3" class="form-control1" placeholder="Motivo de la valoración inicial" maxlength="200" onkeyup="mayus(this, 'motivo_val', 'Motivo valoración');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_motivo_val" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="nivel_bio">Nivel biológico (500 | <label class="maxl" id="lblnivel_bio">0</label>)</label> 
    									<textarea id="nivel_bio" name="nivel_bio"  rows="4" class="form-control1" placeholder="Nivel biológico" maxlength="500" onkeyup="mayus(this, 'nivel_bio', 'Nivel biológico');" required></textarea>
    									<input type="hidden" style="width: 20px" id="ctr_nivel_bio" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="nivel_int">Nivel intelectual (500 | <label class="maxl" id="lblnivel_int">0</label>)</label> 
    									<textarea id="nivel_int" name="nivel_int"  rows="4" class="form-control1" placeholder="Nivel intelectual" maxlength="500" onkeyup="mayus(this, 'nivel_int', 'Nivel intelectual');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_nivel_int" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="nivel_int">Nivel motor (500 | <label class="maxl" id="lblnivel_mot">0</label>)</label> 
    									<textarea id="nivel_mot" name="nivel_mot"  rows="4" class="form-control1" placeholder="Nivel motor" maxlength="500" onkeyup="mayus(this, 'nivel_mot', 'Nivel motor');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_nivel_mot" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="autonomia">Autonomía (500 | <label class="maxl" id="lblautonomia">0</label>)</label> 
    									<textarea id="autonomia" name="autonomia"  rows="4" class="form-control1" placeholder="Autonomía" maxlength="500" onkeyup="mayus(this, 'autonomia', 'Autonomía');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_autonomia" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="nivel_len">Nivel de lenguaje (500 | <label class="maxl" id="lblnivel_len">0</label>)</label> 
    									<textarea id="nivel_len" name="nivel_len"  rows="4" class="form-control1" placeholder="Nivel de lenguaje" maxlength="500" onkeyup="mayus(this, 'nivel_len', 'Nivel de lenguje');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_nivel_len" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="nivel_soc">Nivel social (500 | <label class="maxl" id="lblnivel_soc">0</label>)</label> 
    									<textarea id="nivel_soc" name="nivel_soc"  rows="4" class="form-control1" placeholder="Nivel social" maxlength="500" onkeyup="mayus(this, 'nivel_soc', 'Nivel social');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_nivel_soc" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="personalidad">Personalidad (500 | <label class="maxl" id="lblpersonalidad">0</label>)</label> 
    									<textarea id="personalidad" name="personalidad"  rows="4" class="form-control1" placeholder="Personalidad" maxlength="500" onkeyup="mayus(this, 'personalidad', 'Personalidad');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_personalidad" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="nivel_esc">Nivel escolar (500 | <label class="maxl" id="lblnivel_esc">0</label>)</label> 
    									<textarea id="nivel_esc" name="nivel_esc"  rows="4" class="form-control1" placeholder="Nivel escolar" maxlength="500" onkeyup="mayus(this, 'nivel_esc', 'Nivel escolar');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_nivel_esc" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="con_soc_fam">Contexto socio-familiar (500 | <label class="maxl" id="lblcon_soc_fam">0</label>)</label> 
    									<textarea id="con_soc_fam" name="con_soc_fam"  rows="4" class="form-control1" placeholder="Contexto socio-familiar" maxlength="500" onkeyup="mayus(this, 'con_soc_fam', 'Contexto socio-familiar');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_con_soc_fam" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="obs_psi">Obsrvaciones por parte de psicología (500 | <label class="maxl" id="lblobs_psi">0</label>)</label> 
    									<textarea id="obs_psi" name="obs_psi"  rows="4" class="form-control1" placeholder="Observaciones por parte de psicología" maxlength="500" onkeyup="mayus(this, 'obs_psi', 'Observaciones psicología');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_obs_psi" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-9">
    								    <div id='calendar'></div>
    								</div>
    								<div class="form-group col-lg-3">
    								    <div class="form-group col-lg-12"> 
        								    <label for="fecha_pseg">Fecha primer seguimiento (yyyy-mm-dd)</label> 
        									<!--<input type="text" id="fecha_pseg" name="fecha_pseg" placeholder="yyyy-mm-dd" onkeyup="validar_fecha('fecha_pseg', 'Fecha primer seguimiento');" required/>-->
        									<input type="text" id="fecha_pseg" name="fecha_pseg" placeholder="yyyy-mm-dd" readonly required/>
        									<input type="hidden" style="width: 20px" id="ctr_fecha_pseg" value="1"/>
    									</div>
    									<div class="form-group col-lg-12"> 
        								    <label for="fecha_pseg">Hora (hh)</label> 
        									<input type="text" id="hora_pseg" name="hora_pseg" placeholder="hh" readonly required/>
        									<input type="hidden" style="width: 20px" id="ctr_hora_pseg" value="1"/>
    									</div>
    								</div>
								</div>
								
								
								<div class="form-group col-lg-12"> 
									<button type="submit" class="btn btn-success" id="btnguardar" style="display: none;">Guardar</button>
								</div>
								<input type="hidden" id="id_emp" name="id_emp" value="0"/>
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
	</div>
	
	<!-- Modal de quién solicitó la valoración -->
    <div class="modal fade" id="modal_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">SELECCIONE EL TUTOR O PSICOLOGO QUE SOLICITO LA VALORACION</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>* Tutor o Psicólogo <input type="hidden" class="controlcampo" style="width: 20px" id="ctr_sel_emp" value="1"/></label>
            <!--<input type="text" id="txtidpen" class="form-control" readonly/>-->
            <select id="sel_emp" name="sel_emp" class="form-control">
                <!--<option value="-1" selected>SELECCIONE TEMA</option>
                <option value="0">OTRO</option>-->
            </select>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" style="display: none;" onclick="guardar()">Guardar</button>
            
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal fecha primer seguimiento -->
    <div class="modal fade" id="modal_fecha_pseg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">SELECCIONE LA FECHA DEL PRIMER SEGUIMIENTO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div id="calendarzz" class="modal-body" style="height: 500px;">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" style="display: none;" onclick="guardar()">Guardar</button>
            
          </div>
        </div>
      </div>
    </div>
	
		<!--footer-->
		<?php 
			require "include/footer.php";
		?>
        <!--//footer-->
	
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