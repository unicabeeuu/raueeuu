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
                    $("#fecha_prox_seg").val("");
                    $("#hora_prox_seg").val("");
                    $("#ctr_fecha_prox_seg").val(1);
                    $("#ctr_hora_prox_seg").val(1);
                    alert(eventObj.title);
                    mostrar_submit("fecha_prox_seg");
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
                        $("#fecha_prox_seg").val("");
                        $("#hora_prox_seg").val("");
                        $("#ctr_fecha_prox_seg").val(1);
                        $("#ctr_hora_prox_seg").val(1);
                    }
                    else if(diasSemana[mydate.getDay()] == "Sábado") {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11") {
                            $("#fecha_prox_seg").val(dia);
                            $("#hora_prox_seg").val(hora);
                            $("#ctr_fecha_prox_seg").val(0);
                            $("#ctr_hora_prox_seg").val(0);
                        }
                        else {
                            $("#fecha_prox_seg").val("");
                            $("#hora_prox_seg").val("");
                            $("#ctr_fecha_prox_seg").val(1);
                            $("#ctr_hora_prox_seg").val(1);
                        }
                    }
                    else {
                        if(hora == "08" || hora == "09" || hora == "10" || hora == "11" || hora == "14" || hora == "15" || hora == "16" || hora =="17") {
                            $("#fecha_prox_seg").val(dia);
                            $("#hora_prox_seg").val(hora);
                            $("#ctr_fecha_prox_seg").val(0);
                            $("#ctr_hora_prox_seg").val(0);
                        }
                        else {
                            $("#fecha_prox_seg").val("");
                            $("#hora_prox_seg").val("");
                            $("#ctr_fecha_prox_seg").val(1);
                            $("#ctr_hora_prox_seg").val(1);
                        }
                    }
                    
                    mostrar_submit("fecha_prox_seg");
                    
                }
            });
            calendar.render();
            
            var contenido=$(".ghf");
            contenido.slideUp(250);
            
            $("#sel_emp").change(function() {
        		var id_emp = $("#sel_emp").val();
        		$("#id_emp").val(id_emp);
        	});
        	
        	$(".accordion-titulo1").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content1");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#01DF74", "color": "#000000"});
                  $("span.toggle-icon1", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close #00EAFF       
                  contenido.slideUp(250);
                  $(this).css({"background": "#088A4B", "color": "ffffff"});
                  $("span.toggle-icon1", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo2").click(function(e){
                    e.preventDefault();
                
                    var contenido=$(this).next(".accordion-content2");
            
                    if(contenido.css("display")=="none"){ //open        
                      contenido.slideDown(250);         
                      $(this).css({"background": "#2E9AFE", "color": "#000000"});
                      $("span.toggle-icon2", this).html("-");
                      $(".des_con", this).css("color","#000000");
                    }
                    else{ //close       
                      contenido.slideUp(250);
                      $(this).css({"background": "#084B8A", "color": "#ffffff"});
                      $("span.toggle-icon2", this).html("+");  
                      $(".des_con", this).css("color","#ffffff");
                    }
            
                });
                
            $(".accordion-titulo3").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content3");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon3", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon3", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo4").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content4");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon4", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon4", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo5").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content5");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon5", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon5", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo6").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content6");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon6", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon6", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo7").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content7");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon7", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon7", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo8").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content8");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon8", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon8", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo9").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content9");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon9", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon9", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo10").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content10");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon10", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon10", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo11").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content11");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon11", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon11", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
            
            $(".accordion-titulo12").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content12");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#2E9AFE", "color": "#000000"});
                  $("span.toggle-icon12", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#084B8A", "color": "#ffffff"});
                  $("span.toggle-icon12", this).html("+");  
                  $(".des_con", this).css("color","#ffffff");
                }
        
            });
        	
        });
        
        function buscar_inf() {
            //alert("hola");
            var contenido=$(".ghf");
            contenido.slideUp(250);
            
            //Se limpian los controles
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#psi_val").val("");
            $("#piar_text").val("");
            $("#acomp_text").val("");
            $("#lbldocumento").html("");
            
            $("#obj_seg").val("");
            $("#desarrollo").val("");
            $("#avances").val("");
            $("#acc_est").val("");
            $("#acc_acu").val("");
            $("#compromisos").val("");
            $("#proc_post").val("");
            $("#obj_prox_seg").val("");
            $("#fecha_prox_seg").val("");
            $("#hora_prox_seg").val("");
            
            $("#id_emp").val(0);
            $("#id_val").val("");
            
            var buscar = $("#buscar").val();
            var patron = /^[0-9]{1,}$/;
            var esCoincidente = patron.test($("#buscar").val());
            if(esCoincidente) {
                $("#lblmsg").html("");
                $("#ctr_buscar").val(0);
            }
            
            $.ajax({
                type:"POST",
        		url:"informacion_preval_getdat.php",
        		data:"buscar=" + buscar,
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var r_est = res.estado;
        		    //alert(r_est);
        		    
        		    if(res.ct_val >= 0) {//Se cambia a 0 para que no valide si tiene valoración
        		        if(res.est_seg == "abierto") {
                            $("#lbldocumento").html("El último seguimiento de este documento aún esta abierto. No se puede crear otro seguimiento hasta que no se gestione o realice el que está abierto.");
        		        }
        		        else {
        		            if(res.ct_cierre == 1) {
            		            //alert("Este documento ya tiene su seguimiento cerrado");
            		            $("#lbldocumento").html("Este documento ya tiene cerrado su proceso de seguimiento.");
            		        }
            		        else {
            		            //alert("Datos cargados ");
                    		    $("#nombree").val(res.nom_est + " " + res.ape_est);
                    		    $("#gradoe").val(res.grado);
                    		    //$("#observaciones_g").val(res.obs_ent);
                    		    $("#psi_val").val(res.nom_emp);
                    		    $("#piar_text").val(res.piar);
                    		    $("#acomp_text").val(res.nom_sol);
                    		    $("#obj_seg_act").val(res.obj_sig);
                    		    
                    		    $("#motivo_val").val(res.motivo);
                    		    $("#nivel_bio").val(res.niv_bio);
                    		    $("#nivel_int").val(res.niv_int);
                    		    $("#nivel_mot").val(res.niv_mot);
                    		    $("#autonomia").val(res.autonomia);
                    		    $("#nivel_len").val(res.niv_len);
                    		    $("#nivel_soc").val(res.niv_soc);
                    		    $("#personalidad").val(res.personalidad);
                    		    $("#nivel_esc").val(res.niv_esc);
                    		    $("#con_soc_fam").val(res.con_soc_fam);
                    		    $("#obs_psi").val(res.obs);
                    		    
                    		    $("#id_val").val(res.id);
                    		    
                    		    var contenido=$(".ghf");
                                contenido.slideDown(250);
            		        }
        		        }
        		    }
        		    else {
        		        //alert("Este documento no tiene valoración");
        		        $("#lbldocumento").html("Este documento no tiene valoración.");
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
            if(id == "obj_prox_seg") {
                $("#lblobj_prox_seg").html(long);
                if(long > 500) {
                    $("#ctr_obj_prox_seg").val(1);
                }
            }
            
            var doc = parseInt($("#ctr_buscar").val());
            
            var a = parseInt($("#ctr_obj_prox_seg").val());
            var b = parseInt($("#ctr_fecha_prox_seg").val());
            var c = parseInt($("#ctr_hora_prox_seg").val());
            //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
            
            control = parseInt($("#ctr_obj_prox_seg").val()) 
                + parseInt($("#ctr_fecha_prox_seg").val()) + parseInt($("#ctr_hora_prox_seg").val()) + parseInt($("#ctr_buscar").val());
            
            //alert(control);
            if(control > 0) {
                $("#btnguardar").hide();
            }
            else {
                $("#btnguardar").show();
            }
            
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
            
            (a == 1) ? $("#obj_prox_seg").addClass("error") : $("#obj_prox_seg").removeClass("error");
            (b == 1) ? $("#fecha_prox_seg").addClass("error") : $("#fecha_prox_seg").removeClass("error");
            (c == 1) ? $("#hora_prox_seg").addClass("error") : $("#hora_prox_seg").removeClass("error");
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
            $("#lbldocumento").html("");
            
            //Se limpian los controles
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#psi_val").val("");
            $("#piar_text").val("");
            $("#acomp_text").val("");
            
            $("#obj_prox_seg").val("");
            $("#fehca_prox_seg").val("");
            $("#hora_prox_seg").val("");
            
            $("#id_emp").val(0);
            $("#id_val").val("");
            
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
							<h4>Crear nuevo seguimiento:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/crear_seguimiento.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

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
                                    <label for="psi_val">Psicólogo que valoro:</label>
                                    <input type="text" class="form-control" id="psi_val" name="psi_val" readonly>
								</div>
								
								<div class="form-group col-lg-12"> 
                                    <label for="psi_text">Psicólogo a cargo:</label>
                                    <input type="text" class="form-control" id="psi_text" name="psi_text" value="<?php echo $txt_psicologo; ?>" readonly>
                                    <input type="hidden" id="id_psi_text" name="id_psi_text" value="<?php echo $psicologo; ?>"/>
								</div>

								<div class="ghf">
								    <div class="accordion-titulo1 form-group col-lg-12" style="background: #088A4B; color: #ffffff; font-size: 24px; font-weight: 300;">
									    <span class="toggle-icon1" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
									    Ver información de valoración.
									</div>
									<div class="accordion-content1" style="display: none;"><!--********************-->
        								<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="form-group col-lg-5"> 
        									<label for="piar_text">¿Cuenta con PIAR?</label> 
        									<input type="text" class="form-control" id="piar_text" name="piar_text" readonly/>
        								</div>
        								<div class="form-group col-lg-6"> 
        									<label for="acomp_text" >¿Quién solicitó el acompañamiento?</label> 
        									<input type="text" class="form-control" id="acomp_text" name="acomp_text" readonly/>
        								</div>
        								
        								<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo2 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon2" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Motivo valoración inicial.
    									</div>
    									<div class="accordion-content2" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="motivo_val" name="motivo_val"  rows="3" class="form-control" maxlength="200" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo3 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon3" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Nivel biológico.
    									</div>
    									<div class="accordion-content3" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="nivel_bio" name="nivel_bio"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo4 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon4" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Nivel intelectual.
    									</div>
    									<div class="accordion-content4" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="nivel_int" name="nivel_int"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo5 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon5" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Nivel motor.
    									</div>
    									<div class="accordion-content5" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="nivel_mot" name="nivel_mot"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo6 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon6" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Autonomía.
    									</div>
    									<div class="accordion-content6" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="autonomia" name="autonomia"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo7 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon7" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Nivel de lenguaje.
    									</div>
    									<div class="accordion-content7" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="nivel_len" name="nivel_len"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo8 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon8" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Nivel social.
    									</div>
    									<div class="accordion-content8" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="nivel_soc" name="nivel_soc"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo9 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon9" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Personalidad.
    									</div>
    									<div class="accordion-content9" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="personalidad" name="personalidad"  rows="4" class="form-control" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo10 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon10" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Nivel escolar.
    									</div>
    									<div class="accordion-content10" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="nivel_esc" name="nivel_esc"  rows="4" class="form-control"maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo11 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon11" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Contexto socio-familiar.
    									</div>
    									<div class="accordion-content11" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="con_soc_fam" name="con_soc_fam"  rows="4" class="form-control1" maxlength="500" readonly></textarea>
            								</div>
    									</div>
    									
    									<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="accordion-titulo12 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
    									    <span class="toggle-icon12" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
    									    Observaciones por parte de psicología.
    									</div>
    									<div class="accordion-content12" style="display: none;"><!--********************-->
    									    <div class="form-group col-lg-1"> 
            									<label for="piar_text" style="color: white;">......</label>
            								</div>
    									    <div class="form-group col-lg-11"> 
            									<textarea id="obs_psi" name="obs_psi"  rows="4" class="form-control1" maxlength="500" readonly></textarea>
            								</div>
    									</div>
        								
    								</div>
    								<div class="form-group col-lg-12" style="background: #088A4B; color: #088A4B; font-size: 24px; font-weight: 300;">
									    Fin información de valoración.
									</div>
    								
    								<!--*************************************************************************************************************-->
    								<div class="form-group col-lg-12"> 
    									<label for="obj_prox_seg">Objetivo próximo seguimiento (500 | <label class="maxl" id="lblobj_prox_seg">0</label>)</label> 
    									<textarea id="obj_prox_seg" name="obj_prox_seg"  rows="4" class="form-control1" placeholder="Objetivo próximo seguimiento" maxlength="500" onkeyup="mayus(this, 'obj_prox_seg', 'Objetivo próximo seguimiento');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_obj_prox_seg" value="1"/>
    								</div>
        								
    								<div class="form-group col-lg-9">
    								    <div id='calendar'></div>
    								</div>
    								<div class="form-group col-lg-3">
    								    <div class="form-group col-lg-12"> 
        								    <label for="fecha_prox_seg">Fecha próximo seguimiento (yyyy-mm-dd)</label> 
        									<!--<input type="text" id="fecha_pseg" name="fecha_pseg" placeholder="yyyy-mm-dd" onkeyup="validar_fecha('fecha_pseg', 'Fecha primer seguimiento');" required/>-->
        									<input type="text" id="fecha_prox_seg" name="fecha_prox_seg" placeholder="yyyy-mm-dd" readonly required/>
        									<input type="hidden" style="width: 20px" id="ctr_fecha_prox_seg" value="1"/>
    									</div>
    									<div class="form-group col-lg-12"> 
        								    <label for="hora_prox_seg">Hora (hh)</label> 
        									<input type="text" id="hora_prox_seg" name="hora_prox_seg" placeholder="hh" readonly required/>
        									<input type="hidden" style="width: 20px" id="ctr_hora_prox_seg" value="1"/>
    									</div>
    								</div>
								</div>
								
								
								<div class="form-group col-lg-12"> 
									<button type="submit" class="btn btn-success" id="btnguardar" style="display: none;">Guardar</button>
								</div>
								<input type="hidden" id="id_emp" name="id_emp" value="0"/>
								<input type="hidden" id="id_val" name="id_val"/>
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