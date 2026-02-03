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
        FROM tbl_seg_psi s, tbl_seg_psi_val v, estudiantes e WHERE s.id_valoracion = v.id AND v.n_documento = e.n_documento AND s.id_psicologo = $psicologo";
		$exe_agenda = mysqli_query($conexion, $sql_agenda);
		
		//Se hace la consulta para los eventos agendados
		$sql_eventos = "SELECT * FROM tbl_agendamientos WHERE id_empleado = $psicologo AND estado = 'en proceso' AND id_tipo_agenda = 17";
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
            var contenido=$(".ghf");
            contenido.slideUp(250);
            var contenido1=$(".ghf1");
            contenido1.slideUp(250);
            
            $("#ctr_seguimientos").val("0");
            
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
            
            $(".accordion-titulo13").click(function(e){
                e.preventDefault();
            
                var contenido=$(this).next(".accordion-content13");
        
                if(contenido.css("display")=="none"){ //open        
                  contenido.slideDown(250);         
                  $(this).css({"background": "#f7fa5a", "color": "#000000"});
                  $("span.toggle-icon13", this).html("-");
                  $(".des_con", this).css("color","#000000");
                }
                else{ //close       
                  contenido.slideUp(250);
                  $(this).css({"background": "#fcff33", "color": "#000000"});
                  $("span.toggle-icon13", this).html("+");  
                  $(".des_con", this).css("color","#000000");
                }
        
            });
        	
        });
        
        function buscar_inf() {
            //alert("hola");
            var contenido=$(".ghf");
            contenido.slideUp(250);
            var contenido1=$(".ghf1");
            contenido1.slideUp(250);
            
            //Se limpian los controles
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#lbldocumento").html("");
            $("#divvaloraciones").html("");
            $("#divseguimientos").html("");
            $("#ctr_seguimientos").val("0");
            
            $("#observaciones").val("");
            $("#motivo").val("");
            $("#recomendaciones").val("");
            $("#remitido").val("");
            $("#motivo_remision").val("");
            
            $("#id_val").val("");
            $("#ctr_cierre").val("0");
            
            var buscar = $("#buscar").val();
            var patron = /^[0-9]{1,}$/;
            var esCoincidente = patron.test($("#buscar").val());
            if(esCoincidente) {
                $("#lblmsg").html("");
                $("#ctr_buscar").val(0);
            }
            
            $.ajax({
                type:"POST",
        		url:"informacion_precierre_getdat.php",
        		data:"buscar=" + buscar,
        		success:function(r) {
        		    var res = JSON.parse(r);
        		    var valoraciones= res.valoraciones;
        		    //alert(r_est);
        		    
        		    if(res.estado == "CON_VALORACIONES") {
        		        $("#nombree").val(res.nom_est + " " + res.ape_est);
        		        $("#gradoe").val(res.grado);
        		    
        		        //Se ponen las valoraciones
            		    var tabla = "<table id='tblact' class='table' border='1px'><thead>" +
                            "<tr class='GridViewScrollHeader'>" +
                                "<td>Psicologo Valoró</td>" +
                                "<td>Solicitó</td>" +
                                "<td>Motivo</td>" +
                                "<td>Observaciones</td>" +
                                "<td>...</td>" +
                            "</tr></thead><tbody>";
            		    for(obj of valoraciones) {
            		        var solicito = obj.solicita;
            		        var solicito1 = ""
            		        if(solicito == "EMPLEADO") {
            		            solicito1 = obj.nombres_sol + " " + obj.apellidos_sol;
            		        }
            		        else if(solicito == "ACUDIENTE") {
            		            solicito1 = "ACUDIENTE";
            		        }
            		        else if(solicito == "ESTUDIANTE") {
            		            solicito1 = "ESTUDIANTE";
            		        }
            		        tabla = tabla + "<tr>" +
                                "<td>" + obj.nombres_emp + " " + obj.apellidos_emp + "</td>" +
                                "<td>" + solicito1 + "</td>" +
                                "<td>" + obj.motivo + "</td>" +
                                "<td>" + obj.observaciones + "</td>" +
                                "<td>"  +
                                "<button class='btn btn-warning glyphicon glyphicon-info-sign' data-toggle='modal' data-target='#modal_valoracion' title='Información valoración'" +
                                "onclick='enviardat(\"" + obj.piar + "\",\"" + obj.nivel_biologico + "\",\"" + obj.nivel_intelectual + "\",\"" + obj.nivel_motor + "\",\"" + obj.autonomia + 
                                "\",\"" + obj.nivel_lenguaje + "\",\"" + obj.nivel_social + "\",\"" + obj.personalidad + "\",\"" + obj.nivel_escolar + "\",\"" + obj.contexto_socio_fam + "\")'></button>" +
                                "<label style='color: white;'>.</label>" +
                                "<button class='btn btn-info glyphicon glyphicon-info-sign' title='Información seguimientos'" +
                                "onclick='ver_seguimientos(" + obj.id + ")'></button>" +
                                "<label style='color: white;'>.</label>" +
                                "<button class='btn btn-dark glyphicon glyphicon-off' title='Cerrar'" +
                                "onclick='gestionar_cierre(" + obj.id + ")'></button>" +
                                "</td></tr>";
            		    }
            		    tabla = tabla + "</tbody></table>";
            		    $("#divvaloraciones").html(tabla);
        		    }
        		    else {
        		        //alert("Este documento no tiene valoraciones");
        		        $("#lbldocumento").html("Este documento no tiene valoraciones para cerrar.");
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
            if(id == "observaciones") {
                $("#lblobservaciones").html(long);
                if(long > 500) {
                    $("#ctr_observaciones").val(1);
                }
            }
            else if(id == "motivo") {
                $("#lblmotivo").html(long);
                if(long > 500) {
                    $("#ctr_motivo").val(1);
                }
            }
            else if(id == "recomendaciones") {
                $("#lblrecomendaciones").html(long);
                if(long > 500) {
                    $("#ctr_recomendaciones").val(1);
                }
            }
            else if(id == "remitido") {
                $("#lblremitido").html(long);
                if(long > 500) {
                    $("#ctr_remitido").val(1);
                }
            }
            else if(id == "motivo_rem") {
                $("#lblmotivo_rem").html(long);
                if(long > 500) {
                    $("#ctr_motivo_rem").val(1);
                }
            }
            
            var doc = parseInt($("#ctr_buscar").val());
            
            var a = parseInt($("#ctr_observaciones").val());
            var b = parseInt($("#ctr_motivo").val());
            var c = parseInt($("#ctr_recomendaciones").val());
            var d = parseInt($("#ctr_remitido").val());
            var e = parseInt($("#ctr_motivo_rem").val());
            var f = parseInt($("#ctr_sel_evento").val());
            //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
            
            control = parseInt($("#ctr_observaciones").val()) + parseInt($("#ctr_motivo").val()) + parseInt($("#ctr_recomendaciones").val()) 
                + parseInt($("#ctr_remitido").val()) + parseInt($("#ctr_motivo_rem").val()) + parseInt($("#ctr_buscar").val()) + parseInt($("#ctr_sel_evento").val());
            
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
            
            (a == 1) ? $("#observaciones").addClass("error") : $("#observaciones").removeClass("error");
            (b == 1) ? $("#motivo").addClass("error") : $("#motivo").removeClass("error");
            (c == 1) ? $("#recomendaciones").addClass("error") : $("#recomendaciones").removeClass("error");
            (d == 1) ? $("#remitido").addClass("error") : $("#remitido").removeClass("error");
            (e == 1) ? $("#motivo_rem").addClass("error") : $("#motivo_rem").removeClass("error");
            (f == 1) ? $("#sel_evento").addClass("error") : $("#sel_evento").removeClass("error");
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
            var contenido1=$(".ghf1");
            contenido1.slideUp(250);
            
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
            $("#lbldocumento").html("");
            $("#divvaloraciones").html("");
            $("#divseguimientos").html("");
            $("#ctr_seguimientos").val("0");
            
            $("#observaciones").val("");
            $("#motivo").val("");
            $("#recomendaciones").val("");
            $("#remitido").val("");
            $("#motivo_remision").val("");
            
            $("#id_val").val("");
            $("#ctr_cierre").val("0");
            
            var buscar = $("#buscar").val();
            
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
        
        function enviardat(piar, niv_bio, niv_int, niv_mot, aut, niv_len, niv_soc, pers, niv_esc, c_soc_fam) {
            //alert (idtema);
            $("#piar_text").val(piar);
            $("#nivel_bio").val(niv_bio);
            $("#nivel_int").val(niv_int);
            $("#nivel_mot").val(niv_mot);
            $("#autonomia").val(aut);
            $("#nivel_len").val(niv_len);
            $("#personalidad").val(pers);
            $("#nivel_esc").val(niv_esc);
            $("#con_soc_fam").val(c_soc_fam);
        }
        
        function enviardat1(des, fechareal, horareal, ava, accest, accacu, com, propost) {
            //alert (idtema);
            $("#txtdesarrollo").val(des);
            $("#txtfecha_real").val(fechareal);
            $("#txthora_real").val(horareal);
            $("#txtavances").val(ava);
            $("#txtacc_est").val(accest);
            $("#txtacc_acu").val(accacu);
            $("#txtcompromisos").val(com);
            $("#txtproc_post").val(propost);
        }
        
        function ver_seguimientos(id_val) {
            var buscar = $("#buscar").val();
            var ctr_seg = $("#ctr_seguimientos").val();
            
            if(ctr_seg == "1") {
                var contenido1=$(".ghf1");
                contenido1.slideUp(250);
                $("#ctr_seguimientos").val("0");
            }
            else {
                $.ajax({
                    type:"POST",
            		url:"informacion_precierre1_getdat.php",
            		data:"buscar=" + buscar + "&id_val=" + id_val,
            		success:function(r) {
            		    var res = JSON.parse(r);
            		    var r_est = res.estado;
            		    var seguimientos = res.seguimientos;
            		    //alert(r_est);
            		    
            		    if(res.ct_cierre == 1) {
        		            //alert("Este documento ya tiene su seguimiento cerrado");
        		            //$("#lbldocumento").html("Este documento ya tiene cerrado su proceso de seguimiento.");
        		        }
        		        else {
        		            //Se ponen los seguimientos anreriores
                		    var tabla = "<table id='tblact' class='table' border='1px'><thead>" +
    	                        "<tr class='GridViewScrollHeader'>" +
    	                            "<td>Psicologo</td>" +
    	                            "<td>Objetivo</td>" +
    	                            "<td>Fecha</td>" +
    	                            "<td>Hora</td>" +
    	                            "<td>Estado</td>" +
    	                            "<td>...</td>" +
    	                        "</tr></thead><tbody>";
                		    for(obj of seguimientos) {
                		        tabla = tabla + "<tr>" +
                                    "<td>" + obj.nombres + " " + obj.apellidos + "</td>" +
                                    "<td>" + obj.objetivo + "</td>" +
                                    "<td>" + obj.fecha + "</td>" +
                                    "<td>" + obj.hora + "</td>" +
                                    "<td>" + obj.estado + "</td>" +
                                    "<td><button class='btn btn-warning glyphicon glyphicon-info-sign' data-toggle='modal' data-target='#modal_seguimiento' title='Ver'" +
                                    "onclick='enviardat1(\"" + obj.desarrollo + "\",\"" + obj.fecha_real + "\",\"" + obj.hora_real + "\",\"" + obj.avances + "\",\"" + obj.acciones_est + 
                                    "\",\"" + obj.acciones_acu + "\",\"" + obj.compromisos + "\",\"" + obj.proc_post + "\")'></button></td></tr>";
                		    }
                		    tabla = tabla + "</tbody></table>";
                		    $("#divseguimientos").html(tabla);
                		    $("#ctr_seguimientos").val("1");
                		    
                		    var contenido1=$(".ghf1");
                            contenido1.slideDown(250);
        		        }
            		}
            	});
            }
            
        }
        
        function gestionar_cierre(id_val) {
            $("#id_val").val(id_val);
            var buscar = $("#buscar").val();
            var ctr_cierre = $("#ctr_cierre").val();
            
            if(ctr_cierre == "1") {
                var contenido=$(".ghf");
                contenido.slideUp(250);
                $("#ctr_cierre").val("0");
            }
            else {
                var contenido=$(".ghf");
                contenido.slideDown(250);
                $("#ctr_cierre").val("1");
            }
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
							<h4>Gestionar cierre:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="php/crear_cierre_seg.php" method="POST" id="form" name="form" onsubmit="javascript:return Validar(this);"  enctype="multipart/form-data">

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
                                    <label for="psi_text">Psicólogo a cargo:</label>
                                    <input type="text" class="form-control" id="psi_text" name="psi_text" value="<?php echo $txt_psicologo; ?>" readonly>
                                    <input type="hidden" id="id_psi_text" name="id_psi_text" value="<?php echo $psicologo; ?>"/>
								</div>
								
								<div class="form-group col-lg-12"> 
									<label for="piar_text">Valoraciones:</label>
									<div id="divvaloraciones"></div>
								</div>
								
								
								<div class="ghf1">
								    <!--*************************************************************************************************************-->
    								
    								<div class="accordion-titulo13 form-group col-lg-12" style="background: #fcff33; color: #000000; font-size: 24px; font-weight: 300;">
									    <span class="toggle-icon13" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
									    Ver información de seguimientos anteriores.
									</div>
									<div class="accordion-content13" style="display: none;"><!--********************-->
        								<div class="form-group col-lg-1"> 
        									<label for="piar_text" style="color: white;">......</label>
        								</div>
        								<div class="form-group col-lg-11"> 
        									<!--<label for="piar_text">Tabla</label> -->
        									<div id="divseguimientos"></div>
        								</div>
        								
    								</div>
    								<div class="form-group col-lg-12" style="background: #fcff33; color: #fcff33; font-size: 24px; font-weight: 300;">
									    Fin información de seguimientos anteriores.
									</div>
    								<input type="hidden" id="ctr_seguimientos" name="ctr_seguimientos" value="0"/>
    								<!--*************************************************************************************************************-->
    							</div>
    							
    							<div class="ghf">
    							    <div class="form-group col-lg-12"> 
    									<label for="sel_evento" id="lbl_piar">Evento agendado:</label> 
    									<select id="sel_evento" name="sel_evento" class="form-control1" required>
    										<option value="0" selected>--- SELECCIONE ---</option>
    										<?php
    										    while ($row_eventos = mysqli_fetch_array($exe_eventos)) {
    										        echo '<option value="'.$row_eventos['id'].'">Cierre: Fecha: '.$row_eventos['fecha'].', Hora:  '.$row_eventos['hora'].' -> '.$row_eventos['descripcion'].'</option>';
    										    }
    										?>
    									</select>
    									<input type="hidden" style="width: 20px" id="ctr_sel_evento" value="1"/>
    									<input type="hidden" id="piar_text" name="evento_text"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="observaciones">Observaciones (500 | <label class="maxl" id="lblobservaciones">0</label>)</label> 
    									<textarea id="observaciones" name="observaciones"  rows="4" class="form-control1" placeholder="Observaciones" maxlength="500" onkeyup="mayus(this, 'observaciones', 'Observaciones');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_observaciones" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="motivo">Motivo del cierre (500 | <label class="maxl" id="lblmotivo">0</label>)</label> 
    									<textarea id="motivo" name="motivo"  rows="4" class="form-control1" placeholder="Motivo del cierre" maxlength="500" onkeyup="mayus(this, 'motivo', 'Motivo del cierre');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_motivo" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="recomendaciones">Recomendaciones (500 | <label class="maxl" id="lblrecomendaciones">0</label>)</label> 
    									<textarea id="recomendaciones" name="recomendaciones"  rows="4" class="form-control1" placeholder="Recomendaciones" maxlength="500" onkeyup="mayus(this, 'recomendaciones', 'Recomendaciones');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_recomendaciones" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="remitido">Remitido (500 | <label class="maxl" id="lblremitido">0</label>)</label> 
    									<textarea id="remitido" name="remitido"  rows="4" class="form-control1" placeholder="Remitido" maxlength="500" onkeyup="mayus(this, 'remitido', 'Remitido');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_remitido" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<label for="motivo_rem">Motivo de remisión (500 | <label class="maxl" id="lblmotivo_rem">0</label>)</label> 
    									<textarea id="motivo_rem" name="motivo_rem"  rows="4" class="form-control1" placeholder="Motivo de remisión" maxlength="500" onkeyup="mayus(this, 'motivo_rem', 'Motivo de remisión');" required></textarea>
    									<input type="hidden" class="textarea" style="width: 20px" id="ctr_motivo_rem" value="1"/>
    								</div>
    								
    								<div class="form-group col-lg-12"> 
    									<input type="submit" class="btn btn-success" id="btnguardar" style="display: none;" value="Guardar">
    								</div>
    								
								</div>
								
								<input type="hidden" id="id_val" name="id_val" value="0"/>
								<input type="hidden" id="ctr_cierre" name="ctr_cierre" value="0"/>
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
	
	<!-- Modal de ver información de valoración -->
    <div class="modal fade" id="modal_valoracion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">INFORMACION VALORACION</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="accordion-titulo1 form-group col-lg-12" style="background: #088A4B; color: #ffffff; font-size: 24px; font-weight: 300;">
			    <span class="toggle-icon1" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
			    Ver información de valoración.
			</div>
			<div class="accordion-content1" style="display: none;"><!--********************-->
				<div class="form-group col-lg-1"> 
					<label for="piar_text" style="color: white;">......</label>
				</div>
				<div class="form-group col-lg-11"> 
					<label for="piar_text">¿Cuenta con PIAR?</label> 
					<input type="text" class="form-control" id="piar_text" name="piar_text" readonly/>
				</div>
				
				<!--<div class="form-group col-lg-1"> 
					<label for="piar_text" style="color: white;">......</label>
				</div>
				<div class="accordion-titulo2 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
				    <span class="toggle-icon2" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
				    Motivo valoración inicial.
				</div>
				<div class="accordion-content2" style="display: none;">
				    <div class="form-group col-lg-1"> 
						<label for="piar_text" style="color: white;">......</label>
					</div>
				    <div class="form-group col-lg-11"> 
						<textarea id="motivo_val" name="motivo_val"  rows="3" class="form-control" maxlength="200" readonly></textarea>
					</div>
				</div>-->
				
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
				
				<!--<div class="form-group col-lg-1"> 
					<label for="piar_text" style="color: white;">......</label>
				</div>
				<div class="accordion-titulo12 form-group col-lg-11" style="background: #084B8A; color: #ffffff; font-size: 24px; font-weight: 300;">
				    <span class="toggle-icon12" style="margin-left: 20px; margin-right: 20px; font-size: 38px; font-weight: bold;">+</span>
				    Observaciones por parte de psicología.
				</div>
				<div class="accordion-content12" style="display: none;">
				    <div class="form-group col-lg-1"> 
						<label for="piar_text" style="color: white;">......</label>
					</div>
				    <div class="form-group col-lg-11"> 
						<textarea id="obs_psi" name="obs_psi"  rows="4" class="form-control1" maxlength="500" readonly></textarea>
					</div>
				</div>-->
				
			</div>
          </div>
          <div class="modal-footer">
              <label id="lblmsg"></label><img id="imgnp" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" style="display: none;" onclick="guardar()">Guardar</button>
            
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal de ver información de seguimiento -->
    <div class="modal fade" id="modal_seguimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">INFORMACION SEGUIMIENTO</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <label>Desarrollo </label>
            <textarea id="txtdesarrollo" name="txtdesarrollo" class="form-control" readonly></textarea>
            
            <label>Fecha Real </label>
            <textarea id="txtfecha_real" name="txtfecha_real" class="form-control" readonly></textarea>
            
            <label>Hora Real </label>
            <textarea id="txthora_real" name="txthora_real" class="form-control" readonly></textarea>
            
            <label>Avances </label>
            <textarea id="txtavances" name="txtavances" class="form-control" readonly></textarea>
            
            <label>Acciones Estudiante </label>
            <textarea id="txtacc_est" name="txtacc_est" class="form-control" readonly></textarea>
            
            <label>Acciones Acudiente </label>
            <textarea id="txtacc_acu" name="txtacc_acu" class="form-control" readonly></textarea>
            
            <label>Compromisos </label>
            <textarea id="txtcompromisos" name="txtcompromisos" class="form-control" readonly></textarea>
            
            <label>Procesos Posteriores Interinstitucionales </label>
            <textarea id="txtproc_post" name="txtproc_post" class="form-control" readonly></textarea>
          </div>
          <div class="modal-footer">
              <label id="lblmsg"></label><img id="imgnp" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
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