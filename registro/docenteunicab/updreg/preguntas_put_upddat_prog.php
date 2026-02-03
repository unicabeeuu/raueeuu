<?php
    session_start();
    include "../../adminunicab/php/conexion.php";
    require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	
if (isset($_SESSION['uniprofe'])) {
    //$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['uniprofe']."'";
	$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos  = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['pc'];
		
    }
    
    /*if($id == 18) {
        $query = "SELECT * FROM equivalence_idgra";
    }
    else {
        $query = "SELECT DISTINCT eg.* FROM equivalence_idgra eg, carga_profesor cp WHERE eg.id_grado_ra = cp.id_grado AND cp.id_empleado = $id";
    }*/
    $query = "SELECT * FROM grados WHERE id > 18";
    
    $resultado=$mysqli1->query($query);
    $resultado1=$mysqli1->query($query);
    
    $query2 = "SELECT * FROM tbl_tipo_preguntas WHERE id > 1";
    $resultado2=$mysqli1->query($query2);
    
    $query1 = "SELECT * FROM materias WHERE id IN (1,4,5,6,7,9,11)";
    $resultado3=$mysqli1->query($query1);
?>

<html lang="es">
	<head><meta charset="gb18030">
	    <!---->
	    
		<title></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Favicon -->
        <link rel="shortcut icon" href="../../images/favicon.png" />
        <!-- // Favicon 
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>-->
        
        <!-- Bootstrap Core CSS -->
        <link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />
        
        <!-- Custom CSS -->
        <link href="../../css/style.css" rel='stylesheet' type='text/css' />
        
        <!-- font-awesome icons CSS -->
        <link href="../../css/font-awesome.css" rel="stylesheet"> 
        <!-- //font-awesome icons CSS-->
        
        <!-- side nav css file -->
        <link href='../../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
        <!-- //side nav css file -->
        
        <!-- js-->
        <!--<script src="../../js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <!--<script src="../../js/modernizr.custom.js"></script>-->
        
        <script type="text/javascript" src="js/reg.js"></script>
        
        <!--webfonts-->
        <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--//webfonts--> 
        
        <!--css tabla -->
        <link href="../../css/jquery.dataTables.min.css" rel="stylesheet"> 
        <!-- // css tabla -->
        
		<link rel="stylesheet" href="css/reg.css" />
		
		<!-- Metis Menu 
        <script src="../../js/metisMenu.min.js"></script>
        <script src="../../js/custom.js"></script>-->
        <link href="../../css/custom.css" rel="stylesheet">
        <!--//Metis Menu -->
        <style>
            .mprincipal {
            	list-style-image: url("img/m26.png");
            	font-weight: bold !important;
	            font-size: 20px !important;
            }
            #divprincipal, #divformulas, #divtipopreg {
                display: flex;
                justify-content: space-around;
            }
            #divopciones {
                margin-left: 40px;
            }
            #txtper {
                width: 50px;
            }
            #tblcontroles {
                margin-left: 40px;
            }
            #fl1 {
                width: 500px;
            }
            .grisclaro {
                background: lightgray;
                border: none;
                padding-left: 10px;
            }
            .grisosc {
                background: gray;
                color: white;
                font-weight: bold;
                border: none;
                padding-left: 10px;
            }
            .error {
                border: 3px solid red !important;
            }
            .controlcampo {
                border: none;
                color: white;
            }
            .controlcampo1 {
                border: none;
                color: lightblue;
                background: lightblue;
            }
            #div1 {
                width: 400px;
                height: 200px;
                overflow-x: scroll;
                overflow-y: scroll;
            }
            .blanco {
                background: white;
            }
            .rojo {
                color: red;
            }
        </style>
        <script>
            
            $(function() {
                //alert("hola");
                $("#selgrap").change(function() {
                    $("#divtabla").empty();
                    $("#tblctpreg").empty();
                    $("#div1").hide();
                    $("#idpreg").html("");
                    
                    $("#txtidtp").val(0);
                    //$("#seltp").hide();
                    $("#btncontinuar").hide();
                    //$("#txtctrpen").val("NA");
                    //$("#selpenp").html("");
                    
                    var gra = $("#selgrap").val();
                    //alert(gra);
                    //cargarpen(gra);
                    
                    if (gra == "NA") {
                        //$("#seltp").hide();
            		    $("#btncontinuar").hide();
                    }
                    else {
                        //var pen = $("#txtctrpen").val();
                        //alert (pen);
                		var op = $("#selop").val();
						//alert ("gra = " + gra + ", pen = " + pen + ", op = " + op);
						if(op == "N") {
							//$("#seltp").show();
							$("#btncontinuar").show();
						}
						else {
							//$("#seltp").hide();
							$("#btncontinuar").hide();
						}
                        
                    }
            		$("#lblgra").html("Grado = " + gra);
            		
            		//cargaropciones();
            	});
            	
            	$("#selop").change(function() {
            	    $("#divtabla").empty();
            	    var idgra = $("#selgrap").val();
            	    //var idpen = $("#selpenp").val();
            	    var op = $("#selop").val();
            	    //alert(op);
            	    
            		if(op == "N") {
            			//$("#seltp").show();
            			$("#btncontinuar").show();
            		}
            		else if(op == "E") {
            		    $("#seltp").hide();
            		    $("#btncontinuar").hide();
            		    
            		    //Se consultan las preguntas
            		    consultar_preguntas(idgra);            		    
            		}
            		else {
            		    $("#seltp").hide();
            		    $("#btncontinuar").hide();
            		}
            	});
            	
            	$("#seltema").change(function() {
            	    $("#ctr_txtotro").val(1);
            	    $("#txtotro").val("");
            	    
            	    $("#txtretro").val("");
            	    $("#txtretro").prop("readonly",false);
                    $("#ctr_txtretro").val(1);
            	    
            	    var tema = $("#seltema").val();
            	    var tematxt = $("select[name='seltema'] option:selected").text();
            	    
            		if(tema == 1) {
            			$("#btnguardar").hide();
            			$("#ctr_seltema").val(1);
            			var texto = "Debe seleccionar un tema";
                        $("#lblmsg").html(texto).css("color","red");
                        
                        $("#divotro").hide();
            		}
            		else if(tema == 2) {
            			$("#divotro").show();
            			$("#ctr_seltema").val(0);
            			$("#lblmsg").html("");
            		}
            		else {
            		    //$("#btnEnviar").show();
            		    $("#ctr_seltema").val(0);
            		    $("#lblmsg").html("");
            		    
            		    $("#divotro").hide();
            		    
            		    //Se busca la retroalimentación para ese tema
                		$.ajax({
                    		type:"POST",
                    		url:"buscar_retro_html5.php",
                    		data:"idtema=" + tema,
                    		success:function(r) {
                    		    var texto = ""
                    		    if(r == "") {
                    		        texto = "REFORZAR " + tematxt;
                    		    }
                    		    else {
                    		        texto = r;
                    		    }
								//alert(texto);
                    			$("#txtretro").val(texto);
                    			$("#txtretro").prop("readonly",true);
                    			$("#ctr_txtretro").val(0);
                    		}
                    	});
            		}
            		
            		mostrar_submit('seltema');
            	});
            	
            	$("#selupdtema").change(function() {
            	    $("#ctr_txtupdotro").val(1);
            	    $("#txtupdotro").val("");
            	    
            	    $("#txtupdretro").val("");
            	    $("#txtupdretro").prop("readonly",false);
                    $("#ctr_txtupdretro").val(1);
            	    
            	    var tema = $("#selupdtema").val();
            	    var tematxt = $("select[name='selupdtema'] option:selected").text();
            	    
            		if(tema == 1) {
            			$("#btneditar").hide();
            			$("#ctr_selupdtema").val(1);
            			var texto = "Debe seleccionar un tema";
                        $("#lblupdmsg").html(texto).css("color","red");
                        
                        $("#divupdotro").hide();
            		}
            		else if(tema == 2) {
            			$("#divupdotro").show();
            			$("#ctr_selupdtema").val(0);
            			$("#lblupdmsg").html("");
            		}
            		else {
            		    //$("#btnEnviar").show();
            		    $("#ctr_selupdtema").val(0);
            		    $("#lblupdmsg").html("");
            		    
            		    $("#divupdotro").hide();
            		    
            		    //Se busca la retroalimentaci¨®n para ese tema
                		$.ajax({
                    		type:"POST",
                    		url:"buscar_retro_html5.php",
                    		data:"idtema=" + tema,
                    		success:function(r) {
                    		    var texto = ""
                    		    if(r == "") {
                    		        texto = "REFORZAR " + tematxt;
                    		    }
                    		    else {
                    		        texto = r;
                    		    }
								//alert(texto);
                    			$("#txtupdretro").val(texto);
                    			$("#txtupdretro").prop("readonly",true);
                    			$("#ctr_txtupdretro").val(0);
                    		}
                    	});
            		}
            		//mostrar_editar('selupdtema');
            	});
            	
            	$("#adjunto").change(function () {
     			    var pesoimg = this.files[0].size/1024;
     			    var img = this.files[0].name;
     			    var path = "../../images/preguntas/";
     			    var archivo = path + img;
     			    //alert(pesoimg);
     			    //alert(archivo);
     			    if(pesoimg > 200) {
     			        $("#ctr_adjunto").val(1);
     			        var texto = "El peso permitido para la imagen es de 200 Kb ";
                        $("#lblmsg").html(texto).css("color","red");
                        $("#adjunto").val(null);
     			    }
     			    else {
     			        $("#ctr_adjunto").val(0);
     			        $("#lblmsg").html("");
     			    }
     			    
     			    /*$.ajax({
                        url:archivo,
                        type:'HEAD',
                        error: function()
                        {
                            //alert("Archivo no existe");
                        },
                        success: function()
                        {
                            //alert("Archivo existe");
                            $("#ctr_adjunto").val(1);
         			        var texto = "Ya existe una imagen con el nombre " + img;
                            $("#lblmsg").html(texto).css("color","red");
                            $("#adjunto").val(null);
                        }
                    });*/
                    $.ajax({
                		type:"POST",
                		url:"buscar_img.php",
                		data:"img=" + img,
                		success:function(r) {
                		    var ct_img = r;
                			//alert(ct_img);
                			if(ct_img == 1) {
                			    $("#ctr_adjunto").val(1);
             			        var texto = "Ya existe una imagen con el nombre " + img;
                                $("#lblmsg").html(texto).css("color","red");
                                $("#adjunto").val(null);
                			}
                		}
                	});
        		});
            	
            	$("#updadjunto").change(function () {
     			    var pesoimg = this.files[0].size/1024;
     			    var img = this.files[0].name;
     			    var path = "../../images/preguntas/";
     			    var archivo = path + img;
     			    //alert(pesoimg);
     			    //alert(archivo);
     			    if(pesoimg > 200) {
     			        $("#ctr_updadjunto").val(1);
     			        var texto = "El peso permitido para la imagen es de 200 Kb ";
                        $("#lblupdmsg").html(texto).css("color","red");
                        $("#updadjunto").val(null);
     			    }
     			    else {
     			        $("#ctr_updadjunto").val(0);
     			        $("#lblupdmsg").html("");
     			    }
     			    
     			    $.ajax({
                		type:"POST",
                		url:"buscar_img.php",
                		data:"img=" + img,
                		success:function(r) {
                		    var ct_img = r;
                			//alert(ct_img);
                			if(ct_img == 1) {
                			    $("#ctr_updadjunto").val(1);
             			        var texto = "Ya existe una imagen con el nombre " + img;
                                $("#lblupdmsg").html(texto).css("color","red");
                                $("#updadjunto").val(null);
                			}
                		}
                	});
        		});
            });
            
            function cargarpen(gra) {
                //alert(gra);
            	$.ajax({
            		type:"POST",
            		url:"cargarpen_preguntas.php",
            		data:"idgra=" + gra,
            		success:function(r) {
            			$("#selpenp").html(r);
            		}
            	});
            }
            
            function cargaropciones() {
                $("#selop").html("");
                $("#selop").append('<option value="NA" selected>Seleccione opción</option>');
                $("#selop").append('<option value="N">Ingresar nueva pregunta</option>');
                $("#selop").append('<option value="E">Editar pregunta</option>');
            }
            
            function validar_texto1(id, desc) {
                var control = 0;
                var id_obj = "#" + id;
                var ctr_obj = "#ctr_" + id;
                //var input_desc = document.getElementById("desc");
                var v_input = document.getElementById(id);
                var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|.,;:\(\)\{\}\[\]\\]{1,}/;
                var val = String($(id_obj).val()).match(v_val);
                $("#imgnp").hide();
                
                if(val == null) {
                    v_input.setCustomValidity("");
                    $("#lblmsg").html("");
                    $(ctr_obj).val(0);
                }
                else {
                    v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
                    var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                    //texto += "- _ \' \" < > ~ ^ * $ ! ¡ # % & ¿ ? /= + . , ; : ( ) { } [ ] \\";
                    $("#imgnp").show();
                    
                    //alert(texto);
                    $("#lblmsg").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                    control = 1;
                }
                
                if(control == 0) {
    			    if($(id_obj).val() == "") {
    			        var texto = "El campo " + desc + " se debe llenar";
        				$("#lblmsg").html(texto).css("color","red");
                        $(ctr_obj).val(1);
    			    }
    			}
    			
                mostrar_submit(id);
            }
            
            function validar_texto1upd(id, desc) {
                var control = 0;
                var id_obj = "#" + id;
                var ctr_obj = "#ctr_" + id;
                //var input_desc = document.getElementById("desc");
                var v_input = document.getElementById(id);
                var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|.,;:\(\)\{\}\[\]\\]{1,}/;
                var val = String($(id_obj).val()).match(v_val);
                $("#imgep").hide();
                
                if(val == null) {
                    v_input.setCustomValidity("");
                    $("#lblupdmsg").html("");
                    $(ctr_obj).val(0);
                }
                else {
                    v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
                    var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                    //texto += "- _ \' \" < > ~ ^ * $ ! ¡ # % & ¿ ? /= + . , ; : ( ) { } [ ] \\";
                    $("#imgep").show();
                    
                    //alert(texto);
                    $("#lblupdmsg").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                    control = 1;
                }
                
                if(control == 0) {
    			    if($(id_obj).val() == "") {
    			        var texto = "El campo " + desc + " se debe llenar";
        				$("#lblupdmsg").html(texto).css("color","red");
                        $(ctr_obj).val(1);
    			    }
    			}
    			
                //mostrar_editar(id);
            }
            
            function validar_texto(id, desc) {
                var control = 0;
                var id_obj = "#" + id;
                var ctr_obj = "#ctr_" + id;
                var v_input = document.getElementById(id);
                //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
                var v_val = /[_'"\~\$\#\&\|\{\}\[\]\\]{1,}/;
                var val = String($(id_obj).val()).match(v_val);
                $("#imgnp").hide();
                
                if(val == null) {
                    v_input.setCustomValidity("");
                    $("#lblmsg").html("");
                    $(ctr_obj).val(0);
                }
                else {
                    v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
                    var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                    texto += " _ \' \" ~ $ # & | { } [ ] \\";
                    //alert(texto);
                    $("#lblmsg").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                    control = 1;
                }
    			
    			if(control == 0) {
    			    if($(id_obj).val() == "") {
    			        var texto = "El campo " + desc + " se debe llenar";
        				$("#lblmsg").html(texto).css("color","red");
                        $(ctr_obj).val(1);
    			    }
    			}
    			
                mostrar_submit(id);
            }
            
            function validar_textoupd(id, desc) {
                var control = 0;
                var id_obj = "#" + id;
                var ctr_obj = "#ctr_" + id;
                var v_input = document.getElementById(id);
                //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
                var v_val = /[_'"\~\$\#\&\|\{\}\[\]\\]{1,}/;
                var val = String($(id_obj).val()).match(v_val);
                $("#imgep").hide();
                
                if(val == null) {
                    v_input.setCustomValidity("");
                    $("#lblupdmsg").html("");
                    $(ctr_obj).val(0);
                }
                else {
                    v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
                    var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                    texto += " _ \' \" ~ $ # & | { } [ ] \\";
                    //alert(texto);
                    $("#lblupdmsg").html(texto).css("color","red");
                    $(ctr_obj).val(1);
                    control = 1;
                }
    			
    			if(control == 0) {
    			    if($(id_obj).val() == "") {
    			        var texto = "El campo " + desc + " se debe llenar";
        				$("#lblupdmsg").html(texto).css("color","red");
                        $(ctr_obj).val(1);
    			    }
    			}
    			
                //mostrar_editar(id);
            }
            
            function mayus(e, id, desc) {
                e.value = e.value.toUpperCase();
                
                if(id == "txtpreg") {
                    validar_texto(id, desc);
                }
                else if(id == "txtupdpreg") {
                    validar_textoupd(id, desc);
                }
                else if(id == "txtotro") {
                    validar_texto1(id, desc);
                }
                else if(id == "txtupdotro") {
                    validar_texto1upd(id, desc);
                }
                else if(id == "txtupdresp") {
                    validar_textoupd(id, desc);
                }
                else if(id == "txtupdretro") {
                    validar_textoupd(id, desc);
                }
                else {
                    validar_texto(id, desc);
                }
            }
            
            function continuar() {
                //alert("hola");
                //Se ponen los control de los controles en 1
                $("#ctr_txtpreg").val(1);
                $("#ctr_txtresp").val(1);
                $("#ctr_txtretro").val(1);
                $("#ctr_txtotro").val(1);
                $("#ctr_seltema").val(1);
                $("#divotro").hide();
                
                $("#lblmsg").html("");
                var seltp = $("#selop").val();
                //alert(seltp);
                
                if (seltp == "NA") {
                    $('#modal_new').modal('hide');
                }
                else if (seltp == "N") {
                    var selgra = $("#selgrap").val();
                    var selgra_txt = $("#selgrap option:selected").text();
                    //var selpen = $("#selpenp").val();
                    //var selpen_txt = $("#selpenp option:selected").text();
                    //var seltp = $("#seltp").val();
                    //var seltp_txt = $("#seltp option:selected").text();
                    
                    $("#txtidgra").val(selgra);
                    //$("#txtidpen").val(selpen);
                    //$("#txtidtp1").val(seltp);
                    $("#txtidtp1").val("2");
                    $("#txt_grado1").val(selgra_txt);
                    //$("#txt_pensa1").val(selpen_txt);
                    //$("#txt_tp1").val(seltp_txt);
                    $("#txt_tp1").val("RESPUESTA CORTA");
                    
                    //Se limpian lo cuadros de texto
                    $("#txtpreg").val("");
                    $("#txtresp").val("");
                    $("#txtretro").val("");
                    $("#txtotro").val("");
                    
                    //Se cargan los temas de las preguntas
                    $.ajax({
                		type:"POST",
                		url:"cargartem_preguntas_html5.php",
                		data:"idgra=" + $("#selgrap").val(),
                		success:function(r) {
                			$("#seltema").html(r);
                		}
                	});
                
                    $('#modal_new').modal('toggle');
                    $('#modal_new').modal('show');
                }
                else if (seltp == "E") {
                    
                }
            }
            
            function mostrar_submit(id) {
                var control = 0;
                var tema = $("#seltema").val();
                
                var id_obj = "#" + id;
                var long = $(id_obj).val().length;
                //alert(long);
                
                //Se controla la longitud m¨¢xima
                if(id == "txtotro") {
                    $("#lblotro").html(long);
                    if(long > 100) {
                        $("#ctr_txtotro").val(1);
                    }
                }
                else if(id == "txtpreg") {
                    $("#lblpreg").html(long);
                    if(long > 1000) {
                        $("#ctr_txtpreg").val(1);
                    }
                }
                else if(id == "txtresp") {
                    $("#lblresp").html(long);
                    if(long > 600) {
                        $("#ctr_txtresp").val(1);
                    }
                }
                else if(id == "txtretro") {
                    $("#lblretro").html(long);
                    if(long > 200) {
                        $("#ctr_txtretro").val(1);
                    }
                }
                
                if(tema == 2) {
                    var a = parseInt($("#ctr_txtpreg").val());
                    var b = parseInt($("#ctr_txtresp").val());
                    var c = parseInt($("#ctr_txtretro").val());
                    var d = parseInt($("#ctr_txtotro").val());
                    //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
                    
                    control = parseInt($("#ctr_txtpreg").val()) + parseInt($("#ctr_txtresp").val()) + parseInt($("#ctr_txtretro").val()) + 
                    + parseInt($("#ctr_txtotro").val());
                    
                    //alert(control);
                    if(control > 0) {
                        $("#btnguardar").hide();
                    }
                    else {
                        $("#btnguardar").show();
                    }
                    
                    (a == 1) ? $("#txtpreg").addClass("error") : $("#txtpreg").removeClass("error");
                    (b == 1) ? $("#txtresp").addClass("error") : $("#txtresp").removeClass("error");
                    (c == 1) ? $("#txtretro").addClass("error") : $("#txtretro").removeClass("error");
                    (d == 1) ? $("#txtotro").addClass("error") : $("#txtotro").removeClass("error");
                }
                else {
                    var a = parseInt($("#ctr_txtpreg").val());
                    var b = parseInt($("#ctr_txtresp").val());
                    var c = parseInt($("#ctr_txtretro").val());
                    var d = parseInt($("#ctr_seltema").val());
                    //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
                    
                    control = parseInt($("#ctr_txtpreg").val()) + parseInt($("#ctr_txtresp").val()) + parseInt($("#ctr_txtretro").val()) + 
                    + parseInt($("#ctr_seltema").val());
                    
                    //alert(control);
                    if(control > 0) {
                        $("#btnguardar").hide();
                    }
                    else {
                        $("#btnguardar").show();
                    }
                    
                    (a == 1) ? $("#txtpreg").addClass("error") : $("#txtpreg").removeClass("error");
                    (b == 1) ? $("#txtresp").addClass("error") : $("#txtresp").removeClass("error");
                    (c == 1) ? $("#txtretro").addClass("error") : $("#txtretro").removeClass("error");
                    (d == 1) ? $("#seltema").addClass("error") : $("#seltema").removeClass("error");
                }
                
            }
            
            function mostrar_editar(id) {
                var control = 0;
                var tema = $("#selupdtema").val();
                
                var id_obj = "#" + id;
                /*var long = $(id_obj).val().length;
                //alert(long);
                
                //Se controla la longitud m¨¢xima
                if(id == "txtupdotro") {
                    $("#lblupdotro").html(long);
                    if(long > 100) {
                        $("#ctr_txtupdotro").val(1);
                    }
                }
                else if(id == "txtupdpreg") {
                    $("#lblupdpreg").html(long);
                    if(long > 1000) {
                        $("#ctr_txtupdpreg").val(1);
                    }
                }
                else if(id == "txtupdresp") {
                    $("#lblupdresp").html(long);
                    if(long > 600) {
                        $("#ctr_txtupdresp").val(1);
                    }
                }
                else if(id == "txtupdretro") {
                    $("#lblupdretro").html(long);
                    if(long > 200) {
                        $("#ctr_txtupdretro").val(1);
                    }
                }*/
                
                if(tema == 2) {// OTRO
                    var a = parseInt($("#ctr_txtupcpreg").val());
                    var b = parseInt($("#ctr_txtupdresp").val());
                    var c = parseInt($("#ctr_txtupdretro").val());
                    var d = parseInt($("#ctr_txtupdotro").val());
                    //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
                    
                    control = parseInt($("#ctr_txtupdpreg").val()) + parseInt($("#ctr_txtupdresp").val()) + parseInt($("#ctr_txtupdretro").val()) + 
                    + parseInt($("#ctr_txtupdotro").val());
                    
                    //alert(control);
                    if(control > 0) {
                        $("#btneditar").hide();
                    }
                    else {
                        $("#btneditar").show();
                    }
                    
                    (a == 1) ? $("#txtupdpreg").addClass("error") : $("#txtupdpreg").removeClass("error");
                    (b == 1) ? $("#txtupdresp").addClass("error") : $("#txtupdresp").removeClass("error");
                    (c == 1) ? $("#txtupdretro").addClass("error") : $("#txtupdretro").removeClass("error");
                    (d == 1) ? $("#txtupdotro").addClass("error") : $("#txtupdotro").removeClass("error");
                }
                else {
                    var a = parseInt($("#ctr_txtupdpreg").val());
                    var b = parseInt($("#ctr_txtupdresp").val());
                    var c = parseInt($("#ctr_txtupdretro").val());
                    var d = parseInt($("#ctr_selupdtema").val());
                    //alert("a=" + a + " b=" + b + " c=" + c + " d=" + d);
                    
                    control = parseInt($("#ctr_txtupdpreg").val()) + parseInt($("#ctr_txtupdresp").val()) + parseInt($("#ctr_txtupdretro").val()) + 
                    + parseInt($("#ctr_selupdtema").val());
                    
                    //alert(control);
                    if(control > 0) {
                        $("#btneditar").hide();
                    }
                    else {
                        $("#btneditar").show();
                    }
                    
                    (a == 1) ? $("#txtupdpreg").addClass("error") : $("#txtupdpreg").removeClass("error");
                    (b == 1) ? $("#txtupdresp").addClass("error") : $("#txtupdresp").removeClass("error");
                    (c == 1) ? $("#txtupdretro").addClass("error") : $("#txtupdretro").removeClass("error");
                    (d == 1) ? $("#selupdtema").addClass("error") : $("#selupdtema").removeClass("error");
                }
                
            }
            
            function consultar_preguntas(idgra) {
                $.ajax({
                    type:"POST",
                    url:"preg_rc_getdat_html5.php",
                    data:"idgra=" + idgra,
                    success:function(r) {
                        //alert(r);
                        $("#divtabla").html(r);
                    }
                });
            }
            
            function guardar() {
                var idgra = $("#txtidgra").val();
                //var idpen = $("#txtidpen").val();
                var idtp = $("#txtidtp1").val();
                var pregunta = $("#txtpreg").val();
                pregunta = pregunta.replace(" ", "_");
                pregunta = pregunta.replace("+", "|");
                var r1ok = $("#txtresp").val();
                r1ok = r1ok.replace(" ", "_");
                var idtema = $("#seltema").val();
                var retro = $("#txtretro").val();
                retro = retro.replace(" ", "_");
                
                var tema = $("#seltema").val();
                var ntema = $("#txtotro").val();
                ntema =ntema.replace(" ", "_");
                //alert("ntema= " + ntema + " idgra= " + idgra + " idpen= " + idpen);
                 
                if(tema == 2) {
                    //Se guarda el otro tema
                    $.ajax({
                        type:"POST",
                        url:"temapreg_putdat.php",
                        data:"ntema=" + ntema + "&idgra=" + idgra + "&idpen=" + 0,
                        success:function(r) {
                            //alert(r);
                            $("#idn_tema").val(r);
                            guardar_preg(idgra, 0, idtp, pregunta, r1ok, r, retro);
                        }
                    });
                }
                else if(tema == 1) {
                    var texto = "Debe seleccionar un tema";
                    $("#lblmsg").html(texto).css("color","red");
                }
                else {
                    guardar_preg(idgra, 0, idtp, pregunta, r1ok, idtema, retro);
                }
            }
            
            function guardar_preg(idgra, idpen, idtp, pregunta, r1ok, idtema, retro) {
                $("#idpreg").html("");
                
                if(idtp == 2) {
                    //Se guarda la pregunta de respuesta corta
                    /*$.ajax({
                        type:"POST",
                        url:"pregunta_putdat.php",
                        data:"idgra=" + idgra + "&idpen=" + idpen + "&idtp=" + idtp + "&preg=" + pregunta + "&r1ok=" + r1ok + "&idtema=" + idtema + "&retro=" + retro,
                        success:function(r) {
                            //alert(r);
                        }
                    });*/
                    var formData = new FormData();
                    var files = $('#adjunto')[0].files[0];
                    //alert(files);
                    
                    formData.append('idgra',idgra);
                    formData.append('idpen',idpen);
                    formData.append('idtp',idtp);
                    formData.append('idtema',idtema);
                    formData.append('preg',pregunta);
                    formData.append('r1ok',r1ok);
                    formData.append('retro',retro);
                    formData.append('file',files);
                    $.ajax({
                        type:"POST",
                        url:"pregunta_putdat_html5.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success:function(r) {
                            //alert(r);
                            $("#adjunto").val(null);
                            $("#idpreg").html(r);
                        }
                    });
                }
                
                cantidad_preguntas1(idgra, 0);
                
                setTimeout(function() {
                    cantidad_preguntas2(idgra, 0);
                },2000);
            }
            
            function enviardat(id, idtema, pregunta, r1ok, retro, imagen) {
                //alert (idtema);
                $("#idpregunta").val(id);
				var control = 0;
                
                var selgra = $("#selgrap").val();
                var selgra_txt = $("#selgrap option:selected").text();
                //var selpen = $("#selpenp").val();
                //var selpen_txt = $("#selpenp option:selected").text();
                //var seltp = $("#seltp").val();
                //var seltp_txt = $("#seltp option:selected").text();
                
                $("#txtupdidgra").val(selgra);
                //$("#txtupdidpen").val(selpen);
                //$("#txtidtp1").val(seltp);
                $("#txtupdidtp1").val("2");
                $("#txtupd_grado1").val(selgra_txt);
                //$("#txtupd_pensa1").val(selpen_txt);
                //$("#txt_tp1").val(seltp_txt);
                $("#txtupd_tp1").val("RESPUESTA CORTA");
                
                $("#txtupdpreg").val(pregunta);
                var long = $("#txtupdpreg").val().length;
                //alert(long);
                $("#lblupdpreg").html(long);
                
                $("#txtupdresp").val(r1ok);
                long = $("#txtupdresp").val().length;
                $("#lblupdresp").html(long);
                
                $("#txtupdretro").val(retro);
                long = $("#txtupdretro").val().length;
                $("#lblupdretro").html(long);
                
                //Se cargan los temas de las preguntas
                $.ajax({
            		type:"POST",
            		url:"cargartem_preguntas_html5.php",
            		data:"idgra=" + $("#selgrap").val(),
            		success:function(r) {
						//alert(r);
            			$("#selupdtema").html(r);
						$("#selupdtema").val(idtema);
						$("#selupdtema").change();
            		}
            	});
            	
            	//$("#selupdtema > option[value=" + idtema + "]").attr("selected",true);
                //$("#selupdtema").val(idtema);
                //$("#selupdtema").change();
                //$("#selupdtema").selectmenu('refresh', true);
                //$("#selupdtema").puidropdown('selectValue', idtema);
                //alert("Datos cargados " + document.getElementById("selupdtema").value);
                alert("Datos cargados ");
                //document.getElementById("selupdtema").value = idtema;
                
                //Se ponen los ceros en los controles
                $("#ctr_txtupdpreg").val(0);
                $("#ctr_txtupdresp").val(0);
                $("#ctr_txtupdretro").val(0);
                $("#ctr_selupdtema").val(0);
                
                //Se carga la imagen
                //$('#imgpreg').removeAttr('src');
                //var image = new Image();
                //var src = imagen;
                //image.src = src;
                //$('#imgpreg').append(image);
                $('#imgpreg').attr("src", imagen);
                if(imagen == "NA") {
                    $('#imgpreg').hide();
                }
                else {
                    $('#imgpreg').show();
                }
                
                $("#txtupdretro").prop("readonly",true);
                
                //mostrar_editar("txtupdpreg");
                
            }
            
            function modificar() {
                //alert("modificar");
                var idpregunta = $("#idpregunta").val();
                var idgra = $("#txtupdidgra").val();
                //var idpen = $("#txtupdidpen").val();
                var idtp = $("#txtupdidtp1").val();
                var pregunta = $("#txtupdpreg").val();
                pregunta = pregunta.replace(" ", "_");
                pregunta = pregunta.replace("+", "|");
                var r1ok = $("#txtupdresp").val();
                r1ok = r1ok.replace(" ", "_");
                var idtema = $("#selupdtema").val();
                var retro = $("#txtupdretro").val();
                retro = retro.replace(" ", "_");
                
                var tema = $("#selupdtema").val();
                var ntema = $("#txtupdotro").val();
                ntema =ntema.replace(" ", "_");
                //alert("ntema= " + ntema + " idgra= " + idgra + " idpen= " + idpen);
                 
                if(tema == 2) {
                    //Se guarda el otro tema
                    $.ajax({
                        type:"POST",
                        url:"temapreg_putdat.php",
                        data:"ntema=" + ntema + "&idgra=" + idgra + "&idpen=" + 0,
                        success:function(r) {
                            //alert(r);
                            $("#idn_tema").val(r);
                            modificar_preg(idgra, 0, idtp, pregunta, r1ok, r, retro, idpregunta);
                        }
                    });
                }
                else if(tema == 1) {
                    var texto = "Debe seleccionar un tema";
                    $("#lblupdmsg").html(texto).css("color","red");
                }
                else {
                    modificar_preg(idgra, 0, idtp, pregunta, r1ok, idtema, retro, idpregunta);
                }
            }
            
            function modificar_preg(idgra, idpen, idtp, pregunta, r1ok, idtema, retro, idpreg) {
                //alert(idtp);
                if(idtp == 2) {
                    //Se modifica la pregunta de respuesta corta
                    var formData = new FormData();
                    var files = $('#updadjunto')[0].files[0];
                    //alert(files);
                    
                    formData.append('idgra',idgra);
                    formData.append('idpen',idpen);
                    formData.append('idtp',idtp);
                    formData.append('idtema',idtema);
                    formData.append('preg',pregunta);
                    formData.append('r1ok',r1ok);
                    formData.append('retro',retro);
                    formData.append('idpreg',idpreg);
                    formData.append('file',files);
                    $.ajax({
                        type:"POST",
                        url:"pregunta_upddat_html5.php",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success:function(r) {
                            //alert(r);
                            $("#updadjunto").val(null);
                            $("#divtabla").empty();
                            consultar_preguntas(idgra, idpen);
                        }
                    });
                }
            }
            
            function cantidad_preguntas(idgra, idpen) {
                $("#tblctpreg").empty();
                
                //alert("entro a ct");
                $.ajax({
                    type:"POST",
                    url:"ct_preg_getdat.php",
                    data:"idgra=" + idgra + "&idpen=" + idpen,
                    success:function(r) {
                        //alert(r);
                        $("#tblctpreg").append(r);
            			$("#div1").show();
                    }
                });
            }
            
            function cantidad_preguntas1(idgra, idpen) {
                $("#tblctpreg").empty();
                
                //alert("entro a ct");
                $.ajax({
                    type:"POST",
                    url:"ct_preg_getdat.php",
                    data:"idgra=" + idgra + "&idpen=" + idpen,
                    success:function(r) {
                        //alert(r);
                    }
                });
            }
            
            function cantidad_preguntas2(idgra, idpen) {
                $("#tblctpreg").empty();
                
                //alert("entro a ct");
                $.ajax({
                    type:"POST",
                    url:"ct_preg_getdat.php",
                    data:"idgra=" + idgra + "&idpen=" + idpen,
                    success:function(r) {
                        //alert(r);
                        $("#tblctpreg").append(r);
            			$("#div1").show();
                    }
                });
            }
            
        </script>
	</head>
	<body id="bodyadm" class="cbp-spmenu-push">
	    <div class="main-content">
    		<?php 
    		    if($id == 18 || $id == 40) {
		        require 'menu_adm.php';
    		    }
    		    else {
    		        //require 'menu.php';
    		        require 'menu_tutores.php';
    		    }  
    		?>
    		<!-- header-starts -->
    		<?php require 'header.php';  ?>
    		<!-- modal -->
    		<section>
    			<?php require 'modal.php';  ?>
    		</section>
    		
    		<!-- main content start-->
            <section>
               	<div id="page-wrapper">
               		<div class="charts">		
               		 	<div class="mid-content-top charts-grids">	
                        	 
                        			<!---------------------------------------------->
                                    <div id="cont">
                            			
                            			<!--***********************************************************************************************-->
                            			<div id="div2">
                            				<fieldset id="fl1">
                            				    <legend><h3>BANCO DE PREGUNTAS EVALUACIÓN CARGOS <i class="fa fa-arrow-right "></i> PREGUNTA DE RESPUESTA CORTA</h3>
                            				        <img id="imgt" src="../../images/preguntas/rc_1.png" width="87"/>
                            				    </legend>
                            				    <table id="tblcontroles">
                            				        <tbody>
                            				            <tr>
                            				                <td>
                            				                    <select id="selgrap" name="selgrap" required>
        														    <option value="NA" selected>Seleccione</option>
        														    <?php 
        														        while($row = $resultado1->fetch_assoc()){
        														            echo "<option value='".$row['id']."'>".$row['grado']."</option>";
        														        }
        														    ?>
        														</select>
                            				                </td>
                            				                <td width="30"></td>
                            				                <td>
                            				                </td>
                            				            </tr>
                            				            <tr>
                            				                <td colspan="3">
                            				                    <hr>
                            				                </td>
                            				                
                            				            </tr>
                            				            <tr>
                            				                <td>
                            				                    <select id="selop">
                                    					            <option value="NA" selected>Seleccione opción</option>
                                    					            <option value="N">Ingresar nueva pregunta</option>
                                    					            <option value="E">Editar pregunta</option>
                                    					        </select>
                            				                </td>
                            				                <td width="30"></td>
                            				                <td>
                            				                    <!--<button id="btncontinuar" class="btn btn-primary" style="display: none;" data-toggle="modal" data-target="#modal_new" onclick="continuar1()">Continuar</button>-->
                            				                    <button id="btncontinuar" class="btn btn-primary" style="display: none;" onclick="continuar()">Continuar</button>
                            				                </td>
                            				            </tr>
                            				            <tr>
                            				                <td colspan="3">
                            				                    <hr>
                            				                </td>
                            				                
                            				            </tr>
                            				            <!--<tr>
                            				                <td>
                            				                    <select id="seltp" name="seltp" style="display: none;" required>
        														    <option value="1" selected>Seleccione tipo pregunta</option>
        														    <?php 
        														        while($row2 = $resultado2->fetch_assoc()){
        														            echo "<option value='".$row2['id']."'>".$row2['tipo_pregunta']."</option>";
        														        }
        														    ?>
        														</select>
                            				                </td>
                            				                <td width="30"></td>
                            				                <td>
                            				                    
                            				                </td>
                            				            </tr>-->
                            				        </tbody>
                            				    </table>
                            					<br>
                            				</fieldset>
                            
                            			</div>
                            			<div id="div1" style="display: none;">
                            			    <div id="tblctpreg">
                            			    </div>
                            			</div>
                            		</div></br>
                            		<p><label>Id pregunta creada... </label><label id="idpreg"></label></p>
									<div id="resul_bus">
									    
									</div>
									<?php
                        				$mysqli1->close();
                        			?>
    								<!---------------------------------------------->
    								<div id="divtabla">
    								    
    								</div>
    								<input type="hidden" id="txtidtp"/>
    								<div id="divcontrol" style="display: none;">
    								    <label id="lblgra"></label><label id="lblpen"></label>
    								</div>
    								<input type="hidden" id="idn_tema" name="idn_tema"/>
                  		 	
               			</div>
           			</div>	
           		</div>
    		</section>
    	<!--footer-->
    	<?php //require '../footer.php'; ?>
        <!--//footer-->
    	</div>
    	
    	<!-- Modal de nueva pregunta respusta corta -->
        <div class="modal fade" id="modal_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NUEVA PREGUNTA DE RESPUESTA CORTA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-lg-1">
                        <h5><label>Idgra</label></h5>
                    </div>
                    <div class="col-lg-3">
                        <h5><label>Grado</label></h5>
                    </div>
                    <div class="col-lg-1">
                        <h5><label>Idpen</label></h5>
                    </div>
                    <div class="col-lg-3">
                        <h5><label>Pensamiento</label></h5>
                    </div>
                    <div class="col-lg-1">
                        <h5><label>Idtipp</label></h5>
                    </div>
                    <div class="col-lg-3">
                        <h5><label>Tipo pregunta</label></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1">
                        <input type="text" id="txtidgra" class="grisclaro" readonly/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="txt_grado1" class="grisosc" readonly/>
                    </div>
                    <div class="col-lg-1">
                        <input type="text" id="txtidpen" class="grisclaro" readonly/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="txt_pensa1" class="grisosc" readonly/>
                    </div>
                    <div class="col-lg-1">
                        <input type="text" id="txtidtp1" class="grisclaro" readonly/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="txt_tp1" class="grisosc" readonly/>
                    </div>
                </div>
                <label>* Tema <input type="text" class="controlcampo" style="width: 20px" id="ctr_seltema" value="1"/></label>
                <!--<input type="text" id="txtidpen" class="form-control" readonly/>-->
                <select id="seltema" name="seltema" class="form-control">
                    <!--<option value="-1" selected>SELECCIONE TEMA</option>
                    <option value="0">OTRO</option>-->
                </select>
                
                <div id="divotro" class="row" style="display: none;">
                    <div class="col-lg-4" style="background: lightblue;">
                        <label>* Indique cual otro tema <input type="text" class="controlcampo1" style="width: 20px" id="ctr_txtotro" value="1"/> (100 | </label>
                        <label id="lblotro">0</label><label>)</label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" id="txtotro" name="txtotro" class="form-control" onkeyup="mayus(this, 'txtotro', 'Otro tema');" maxlength="100" required/>
                    </div>
                </div>
                
                <label>* Ingrese pregunta <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtpreg" value="1"/> (1000 | </label>
                <label id="lblpreg">0</label><label>)</label>
                <!--<input type="text" id="txtpreg" class="form-control" oninput="validapor()"/>-->
                <textarea id="txtpreg" name="txtpreg" class="form-control" onkeyup="mayus(this, 'txtpreg', 'Pregunta');" maxlength="1000" required></textarea>
                
                <label>* Ingrese respuesta <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtresp" value="1"/> (600 | </label>
                <label id="lblresp">0</label><label>)</label>
                <input type="text" id="txtresp" name="txtresp" class="form-control" onkeyup="mayus(this, 'txtresp', 'Respuesta');" maxlength="600" required/>
                
                <label>* Ingrese comentarios por error <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtretro" value="1"/> (200 |</label>
                <label id="lblretro">0</label><label>)</label>
                <textarea id="txtretro" name="txtretro" class="form-control" onkeyup="mayus(this, 'txtretro', 'Comentarios error');" required></textarea>
                
                <label>Imagen <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtretro" value="1"/> (200 Kb)</label>
                <input type="file" id="adjunto" name="adjunto" accept=".jpg,.jpeg" class="btn btn-lg btn-info">
              </div>
              <div class="modal-footer">
                  <label id="lblmsg"></label><img id="imgnp" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" style="display: none;" onclick="guardar()">Guardar</button>
                
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal edición pregunta respusta corta -->
        <div class="modal fade" id="modal_editar_preg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDITAR PREGUNTA DE RESPUESTA CORTA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                    <div class="col-lg-1">
                        <h5><label>Idgra</label></h5>
                    </div>
                    <div class="col-lg-3">
                        <h5><label>Grado</label></h5>
                    </div>
                    <div class="col-lg-1">
                        <h5><label>Idpen</label></h5>
                    </div>
                    <div class="col-lg-3">
                        <h5><label>Pensamiento</label></h5>
                    </div>
                    <div class="col-lg-1">
                        <h5><label>Idtipp</label></h5>
                    </div>
                    <div class="col-lg-3">
                        <h5><label>Tipo pregunta</label></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-1">
                        <input type="text" id="txtupdidgra" class="grisclaro" readonly/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="txtupd_grado1" class="grisosc" readonly/>
                    </div>
                    <div class="col-lg-1">
                        <input type="text" id="txtupdidpen" class="grisclaro" readonly/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="txtupd_pensa1" class="grisosc" readonly/>
                    </div>
                    <div class="col-lg-1">
                        <input type="text" id="txtupdidtp1" class="grisclaro" readonly/>
                    </div>
                    <div class="col-lg-3">
                        <input type="text" id="txtupd_tp1" class="grisosc" readonly/>
                    </div>
                </div>
                <label>* Tema <input type="text" class="controlcampo" style="width: 20px" id="ctr_selupdtema" value="1"/></label>
                <!--<input type="text" id="txtidpen" class="form-control" readonly/>-->
                <select id="selupdtema" name="selupdtema" class="form-control">
                    <!--<option value="-1" selected>SELECCIONE TEMA</option>
                    <option value="0">OTRO</option>-->
                </select>
                
                <div id="divupdotro" class="row" style="display: none;">
                    <div class="col-lg-4" style="background: lightblue;">
                        <label>* Indique cual otro tema <input type="text" class="controlcampo1" style="width: 20px" id="ctr_txtupdotro" value="1"/> (100 | </label>
                        <label id="lblupdotro">0</label><label>)</label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" id="txtupdotro" name="txtupdotro" class="form-control" onkeyup="mayus(this, 'txtupdotro', 'Otro tema');" maxlength="100" required/>
                    </div>
                </div>
                
                <label>* Pregunta <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtupdpreg" value="1"  maxlength="1000"/> (1000 | </label>
                <label id="lblupdpreg">0</label><label>)</label>
                <!--<input type="text" id="txtpreg" class="form-control" oninput="validapor()"/>-->
                <textarea id="txtupdpreg" name="txtupdpreg" class="form-control" onkeyup="mayus(this, 'txtupdpreg', 'Pregunta');" maxlength="1000" required></textarea>
                
                <label>* Respuesta <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtupdresp" value="1"/> (600 | </label>
                <label id="lblupdresp">0</label><label>)</label>
                <input type="text" id="txtupdresp" name="txtupdresp" class="form-control" onkeyup="mayus(this, 'txtupdresp', 'Respuesta');" maxlength="600" required/>
                
                <label>* Comentarios por error <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtupdretro" value="1"/> (200 |</label>
                <label id="lblupdretro">0</label><label>)</label>
                <textarea id="txtupdretro" name="txtupdretro" class="form-control" onkeyup="mayus(this, 'txtupdretro', 'Comentarios error');" required></textarea>
                
                <div class="row">
                    <div class="col-lg-8">
                        <label>Imagen <input type="text" class="controlcampo" style="width: 20px" id="ctr_updadjunto" value="1"/> (200 Kb)</label>
                        <input type="file" id="updadjunto" name="updadjunto" accept=".jpg,.jpeg" class="btn btn-lg btn-info">
                    </div>
                    <div class="col-lg-4">
                        <!--<img id="imgpreg" src="../../images/preguntas/desktop_recta.jpg" width="200"/>-->
                        <img id="imgpreg" src="" width="200"/>
                    </div>
                </div>
                
              </div>
              <div class="modal-footer">
                <label id="lblupdmsg"></label><img id="imgep" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
                <input type="hidden" id="idpregunta" style="width: 20px;" readonly/>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btneditar" data-dismiss="modal" onclick="modificar()">Modificar</button>
                
              </div>
            </div>
          </div>
        </div>
	    
	    <!-- Classie --><!-- for toggle left push menu script -->
    	<script src="../../js/classie.js"></script>
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
    	
    	<!--scrolling js-->
    	<script src="../../js/jquery.nicescroll.js"></script>
    	<script src="../../js/scripts.js"></script>
    	<!--//scrolling js-->
    	
    	<!-- side nav js -->
    	<script src='../../js/SidebarNav.min.js' type='text/javascript'></script>
    	<script>
          $('.sidebar-menu').SidebarNav()
        </script>
    	<!-- //side nav js -->
    	
    	<!-- Bootstrap Core JavaScript -->
       <script src="../../js/bootstrap.js"> </script>
    	<!-- //Bootstrap Core JavaScript -->
    	
    	<!-- js tabla -->
    	<script src="../../js/jquery.dataTables.min.js"></script>
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
		echo "<script>location.href='../../../login_registro.php'</script>";
	}
	?>
</html>