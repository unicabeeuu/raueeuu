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
    $query = "SELECT * FROM equivalence_idgra";
    
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
				$("#selop").change(function() {
            	    $("#divtabla").empty();
            	    var op = $("#selop").val();
            	    //alert(op);
            	    
            		if(op == "N") {
            			$("#btncontinuar").show();
            		}
            		else if(op == "E") {
            		    $("#btncontinuar").hide();
            		    
            		    //Se consultan las preguntas
            		    consultar_palabras();
            		}
            		else {
            		    $("#btncontinuar").hide();
            		}
            	});
            	
				
                $("#adjunto").change(function () {
     			    var pesoimg = this.files[0].size/1024;
     			    var img = this.files[0].name;
     			    var path = "../../../assets/img/domain/";
     			    var archivo = path + img;
     			    //alert(pesoimg);
     			    //alert(archivo);
     			    if(pesoimg > 300) {
     			        $("#ctr_adjunto").val(1);
     			        var texto = "El peso permitido para la imagen es de 300 Kb ";
                        $("#lblmsg").html(texto).css("color","red");
                        $("#adjunto").val(null);
     			    }
     			    else {
     			        $("#ctr_adjunto").val(0);
     			        $("#lblmsg").html("");
     			    }
     			    
     			    $.ajax({
                		type:"POST",
                		url:"buscar_img_domain.php",
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
     			    var path = "../../../assets/img/domain/";
     			    var archivo = path + img;
     			    //alert(pesoimg);
     			    //alert(archivo);
     			    if(pesoimg > 300) {
     			        $("#ctr_updadjunto").val(1);
     			        var texto = "El peso permitido para la imagen es de 300 Kb ";
                        $("#lblupdmsg").html(texto).css("color","red");
                        $("#updadjunto").val(null);
     			    }
     			    else {
     			        $("#ctr_updadjunto").val(0);
     			        $("#lblupdmsg").html("");
     			    }
     			    
     			    $.ajax({
                		type:"POST",
                		url:"buscar_img_domain.php",
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
    			
                mostrar_editar(id);
            }
            
            function validar_texto(id, desc) {
                var control = 0;
                var id_obj = "#" + id;
                var ctr_obj = "#ctr_" + id;
                var v_input = document.getElementById(id);
                //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
                var v_val = /[_'"\~\$\#\&\|;\{\}\[\]\\]{1,}/;
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
                    texto += " _ \' \" ~ $ # & | ; { } [ ] \\";
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
                var v_val = /[_'"\~\$\#\&\|;\{\}\[\]\\]{1,}/;
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
                    texto += " _ \' \" ~ $ # & | ; { } [ ] \\";
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
    			
                mostrar_editar(id);
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
                    var selpen = $("#selpenp").val();
                    var selpen_txt = $("#selpenp option:selected").text();
                    //var seltp = $("#seltp").val();
                    //var seltp_txt = $("#seltp option:selected").text();
                    
                    $("#txtidgra").val(selgra);
                    $("#txtidpen").val(selpen);
                    //$("#txtidtp1").val(seltp);
                    $("#txtidtp1").val("2");
                    $("#txt_grado1").val(selgra_txt);
                    $("#txt_pensa1").val(selpen_txt);
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
                		url:"cargartem_preguntas.php",
                		data:"idgra=" + $("#selgrap").val() + "&idmat=" + selpen,
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
            
            function consultar_palabras() {//data:"idgra=" + idgra + "&idpen=" + idpen,                    
                $.ajax({
                    type:"POST",
                    url:"domain_put_getdat.php",
                    success:function(r) {
                        //alert(r);
                        $("#divtabla").html(r);
                    }
                });
            }
            
            function guardar() {
                var palabra = $("#txtpalabra").val();
				
				var formData = new FormData();
				var files = $('#adjunto')[0].files[0];
				//alert(files);
				
				formData.append('pal',palabra);
				formData.append('file',files);
				$.ajax({
					type:"POST",
					url:"domain_put_putdat.php",
					data: formData,
					processData: false,
					contentType: false,
					success:function(r) {
						//alert(r);
						$("#adjunto").val(null);
					}
				});				
                
            }
            
            function enviardat(id, palabra, fecha, estado, imagen) {
                //alert (imagen);
                $("#idpalabra").val(id);
                
                $("#txtupdpalabra").val(palabra);
                alert("Datos cargados ");
                
                //Se carga la imagen
                $('#imgpal').attr("src", imagen);
                if(imagen == "NA") {
                    $('#imgpal').hide();
                }
                else {
                    $('#imgpal').show();
                }
                
            }
            
            function modificar() {
                //alert("modificar");
                var idpal = $("#idpalabra").val();
                var palabra = $("#txtupdpalabra").val();
                 
                var formData = new FormData();
				var files = $('#updadjunto')[0].files[0];
				//alert(files);
				
				formData.append('pal',palabra);
				formData.append('idpal',idpal);
				formData.append('file',files);
				$.ajax({
					type:"POST",
					url:"domain_put_pal_upddat.php",
					data: formData,
					processData: false,
					contentType: false,
					success:function(r) {
						//alert(r);
						$("#updadjunto").val(null);
						$("#divtabla").empty();
						consultar_palabras();
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
                            				    <legend><h3>BANCO DE PALABRAS <i class="fa fa-arrow-right "></i> DOMAN KIDS</h3>
                            				        <img id="imgt" src="../../images/preguntas/rc_1.png" width="87"/>
                            				    </legend>
                            				    <table id="tblcontroles">
                            				        <tbody>
                            				            <tr>
                            				                <td>
                            				                    <select id="selop">
                                    					            <option value="NA" selected>Seleccione opción</option>
                                    					            <option value="N">Ingresar nueva palabra</option>
                                    					            <option value="E">Ver palabras</option>
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
                            		<!--<p><label>Id pregunta creada... </label><label id="idpreg"></label></p>-->
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
    	
    	<!-- Modal de nueva palabra -->
        <div class="modal fade" id="modal_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NUEVA PALABRA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>* Palabra </label>
                <input type="text" id="txtpalabra" name="txtpalabra" class="form-control" />
                
                <label>Imagen <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtretro" value="1"/> (300 Kb)</label>
                <input type="file" id="adjunto" name="adjunto" accept=".jpg,.jpeg,.png" class="btn btn-lg btn-info">
              </div>
              <div class="modal-footer">
                  <label id="lblmsg"></label><img id="imgnp" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" onclick="guardar()">Guardar</button>
                
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal edición palabra -->
        <div class="modal fade" id="modal_editar_preg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDITAR PALABRA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>* Palabra </label>
                <input type="text" id="txtupdpalabra" name="txtupdpalabra" class="form-control" required/>
                
                <div class="row">
                    <div class="col-lg-8">
                        <label>Imagen <input type="text" class="controlcampo" style="width: 20px" id="ctr_updadjunto" value="1"/> (300 Kb)</label>
                        <input type="file" id="updadjunto" name="updadjunto" accept=".jpg,.jpeg,.png" class="btn btn-lg btn-info">
                    </div>
                    <div class="col-lg-4">
                        <!--<img id="imgpal" src="../../../assets/img/domain/mano.png" width="200"/>-->
                        <img id="imgpal" src="" width="200"/>
                    </div>
                </div>
                
              </div>
              <div class="modal-footer">
                <label id="lblupdmsg"></label><img id="imgep" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
                <input type="hidden" id="idpalabra" style="width: 20px;" readonly/>
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