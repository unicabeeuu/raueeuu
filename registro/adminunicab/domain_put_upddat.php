<?php
session_start();
require "php/conexion.php";
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
	
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Academic Registry</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style_thrive.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->
<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->
<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
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

<script>
            
	$(function() {
		//alert("hola");
		$("#selop").change(function() {
			$("#divtabla").empty();
			let op = $("#selop").val();
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
			let pesoimg = this.files[0].size/1024;
			let img = this.files[0].name;
			let path = "../../../assets/img/domain/";
			let archivo = path + img;
			//alert(pesoimg);
			//alert(archivo);
			if(pesoimg > 300) {
				$("#ctr_adjunto").val(1);
				let texto = "El peso permitido para la imagen es de 300 Kb ";
				$("#lblmsg").html(texto).css("color","red");
				$("#adjunto").val(null);
			}
			else {
				$("#ctr_adjunto").val(0);
				$("#lblmsg").html("");
			}
			
			$.ajax({
				type:"POST",
				url:"../docenteunicab/updreg/buscar_img_domain.php",
				data:"img=" + img,
				success:function(r) {
					let ct_img = r;
					//alert(ct_img);
					if(ct_img == 1) {
						$("#ctr_adjunto").val(1);
						let texto = "Ya existe una imagen con el nombre " + img;
						$("#lblmsg").html(texto).css("color","red");
						$("#adjunto").val(null);
					}
				}
			});
		});
		
		$("#updadjunto").change(function () {
			let pesoimg = this.files[0].size/1024;
			let img = this.files[0].name;
			let path = "../../../assets/img/domain/";
			let archivo = path + img;
			//alert(pesoimg);
			//alert(archivo);
			if(pesoimg > 300) {
				$("#ctr_updadjunto").val(1);
				let texto = "El peso permitido para la imagen es de 300 Kb ";
				$("#lblupdmsg").html(texto).css("color","red");
				$("#updadjunto").val(null);
			}
			else {
				$("#ctr_updadjunto").val(0);
				$("#lblupdmsg").html("");
			}
			
			$.ajax({
				type:"POST",
				url:"../docenteunicab/updreg/buscar_img_domain.php",
				data:"img=" + img,
				success:function(r) {
					let ct_img = r;
					//alert(ct_img);
					if(ct_img == 1) {
						$("#ctr_updadjunto").val(1);
						let texto = "Ya existe una imagen con el nombre " + img;
						$("#lblupdmsg").html(texto).css("color","red");
						$("#updadjunto").val(null);
					}
				}
			});
		});
	});
	
	function cargaropciones() {
		$("#selop").html("");
		$("#selop").append('<option value="NA" selected>Select option</option>');
		$("#selop").append('<option value="N">Ingresar nueva pregunta</option>');
		$("#selop").append('<option value="E">Edit question</option>');
	}
	
	function validar_texto1(id, desc) {
		let control = 0;
		let id_obj = "#" + id;
		let ctr_obj = "#ctr_" + id;
		//let input_desc = document.getElementById("desc");
		let v_input = document.getElementById(id);
		let v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|.,;:\(\)\{\}\[\]\\]{1,}/;
		let val = String($(id_obj).val()).match(v_val);
		$("#imgnp").hide();
		
		if(val == null) {
			v_input.setCustomValidity("");
			$("#lblmsg").html("");
			$(ctr_obj).val(0);
		}
		else {
			v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
			let texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
			//texto += "- _ \' \" < > ~ ^ * $ ! ¡ # % & ¿ ? /= + . , ; : ( ) { } [ ] \\";
			$("#imgnp").show();
			
			//alert(texto);
			$("#lblmsg").html(texto).css("color","red");
			$(ctr_obj).val(1);
			control = 1;
		}
		
		if(control == 0) {
			if($(id_obj).val() == "") {
				let texto = "El campo " + desc + " se debe llenar";
				$("#lblmsg").html(texto).css("color","red");
				$(ctr_obj).val(1);
			}
		}
		
		mostrar_submit(id);
	}
	
	function validar_texto1upd(id, desc) {
		let control = 0;
		let id_obj = "#" + id;
		let ctr_obj = "#ctr_" + id;
		//let input_desc = document.getElementById("desc");
		let v_input = document.getElementById(id);
		let v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|.,;:\(\)\{\}\[\]\\]{1,}/;
		let val = String($(id_obj).val()).match(v_val);
		$("#imgep").hide();
		
		if(val == null) {
			v_input.setCustomValidity("");
			$("#lblupdmsg").html("");
			$(ctr_obj).val(0);
		}
		else {
			v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
			let texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
			//texto += "- _ \' \" < > ~ ^ * $ ! ¡ # % & ¿ ? /= + . , ; : ( ) { } [ ] \\";
			$("#imgep").show();
			
			//alert(texto);
			$("#lblupdmsg").html(texto).css("color","red");
			$(ctr_obj).val(1);
			control = 1;
		}
		
		if(control == 0) {
			if($(id_obj).val() == "") {
				let texto = "El campo " + desc + " se debe llenar";
				$("#lblupdmsg").html(texto).css("color","red");
				$(ctr_obj).val(1);
			}
		}
		
		mostrar_editar(id);
	}
	
	function validar_texto(id, desc) {
		let control = 0;
		let id_obj = "#" + id;
		let ctr_obj = "#ctr_" + id;
		let v_input = document.getElementById(id);
		//let v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
		let v_val = /[_'"\~\$\#\&\|;\{\}\[\]\\]{1,}/;
		let val = String($(id_obj).val()).match(v_val);
		$("#imgnp").hide();
		
		if(val == null) {
			v_input.setCustomValidity("");
			$("#lblmsg").html("");
			$(ctr_obj).val(0);
		}
		else {
			v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
			let texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
			texto += " _ \' \" ~ $ # & | ; { } [ ] \\";
			//alert(texto);
			$("#lblmsg").html(texto).css("color","red");
			$(ctr_obj).val(1);
			control = 1;
		}
		
		if(control == 0) {
			if($(id_obj).val() == "") {
				let texto = "El campo " + desc + " se debe llenar";
				$("#lblmsg").html(texto).css("color","red");
				$(ctr_obj).val(1);
			}
		}
		
		mostrar_submit(id);
	}
	
	function validar_textoupd(id, desc) {
		let control = 0;
		let id_obj = "#" + id;
		let ctr_obj = "#ctr_" + id;
		let v_input = document.getElementById(id);
		//let v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
		let v_val = /[_'"\~\$\#\&\|;\{\}\[\]\\]{1,}/;
		let val = String($(id_obj).val()).match(v_val);
		$("#imgep").hide();
		
		if(val == null) {
			v_input.setCustomValidity("");
			$("#lblupdmsg").html("");
			$(ctr_obj).val(0);
		}
		else {
			v_input.setCustomValidity("Ha ingresado caracteres inv¨¢lidos");
			let texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
			texto += " _ \' \" ~ $ # & | ; { } [ ] \\";
			//alert(texto);
			$("#lblupdmsg").html(texto).css("color","red");
			$(ctr_obj).val(1);
			control = 1;
		}
		
		if(control == 0) {
			if($(id_obj).val() == "") {
				let texto = "El campo " + desc + " se debe llenar";
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
		$("#txtpalabra").val("");
		
		$("#lblmsg").html("");
		let seltp = $("#selop").val();
		//alert(seltp);
		
		if (seltp == "NA") {
			$('#modal_new').modal('hide');
		}
		else if (seltp == "N") {
			$('#modal_new').modal('toggle');
			$('#modal_new').modal('show');
		}
		else if (seltp == "E") {
			
		}
	}
	
	function consultar_palabras() {//data:"idgra=" + idgra + "&idpen=" + idpen,                    
		$.ajax({
			type:"POST",
			url:"../docenteunicab/updreg/domain_put_getdat.php",
			success:function(r) {
				//alert(r);
				$("#divtabla").html(r);
			}
		});
	}
	
	function guardar() {
		let palabra = $("#txtpalabra").val();
		
		let formData = new FormData();
		let files = $('#adjunto')[0].files[0];
		//alert(files);
		
		formData.append('pal',palabra);
		formData.append('file',files);
		$.ajax({
			type:"POST",
			url:"../docenteunicab/updreg/domain_put_putdat.php",
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
		let idpal = $("#idpalabra").val();
		let palabra = $("#txtupdpalabra").val();
		 
		let formData = new FormData();
		let files = $('#updadjunto')[0].files[0];
		//alert(files);
		
		formData.append('pal',palabra);
		formData.append('idpal',idpal);
		formData.append('file',files);
		$.ajax({
			type:"POST",
			url:"../docenteunicab/updreg/domain_put_pal_upddat.php",
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
   	
<style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
    .maxl {
        color: blue;
    }
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
    .error {
        border: 3px solid red !important;
    }
        
    input[type=checkbox] {
    	visibility: hidden;
    }
    
    .checkbox-GHF {
    	display: inline-block;
    	position: relative;
        width: 70px;
    	height: 30px;
    	background: #F3F781;
    	border-radius: 15px;
    	box-shadow: inset 0px 1px 1px rgba(0,0,0,0.6), 0px 1px 0px rgba(255,255,255,0.3);   
    }
    
    .checkbox-GHF label {
    
        /* aspecto */
        display: block;
        width: 34px;
    	height: 20px;
    	border-radius: 17px;
    	box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.35);
    	background: #fcfff4;
    	background: linear-gradient(to top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
        cursor: pointer;
        
        /* Posicionamiento */
        position: absolute;
        top: 5px;
    	left: 5px;
        z-index: 1;
        
    	/* Comportamiento */
        transition: all .4s ease;
        
        /* ocultar el posible texto que tenga */
        overflow: hidden;
        text-indent: 35px;  
        transition: text-indent 0s;
    }
    
    /* estado activado */
    .checkbox-GHF input[type=checkbox]:checked + label {
    	left: auto;
        right: 5px;
    }
    
    .checkbox-GHF:after {
    	content: 'NO';
    	font: 12px/30px Arial, sans-serif;
    	color: red;
    	position: absolute;
    	right: 10px;
        z-index: 0;
    	font-weight: bold;
    	
    }
    
    .checkbox-GHF:before {
    	content: 'SI';
    	font: 12px/30px Arial, sans-serif;
    	color: green;
    	position: absolute;
    	left: 10px;
    	z-index: 0;
    	font-weight: bold;
    }
	
	/* #################################### */
	.mprincipal {
		list-style-image: url("img/m26.png");
		font-weight: bold !important;
		font-size: 20px !important;
	}
	#divprincipal, #divformulas, #divtipopreg {
		display: flex;
		justify-content: space-around;
		flex-wrap: wrap;
		gap: 0.5rem;
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
		max-width: 500px;
		width: 100%;
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
		max-width: 400px;
		width: 100%;
		height: 200px;
		overflow: auto;
	}
	.blanco {
		background: white;
	}
	.rojo {
		color: red;
	}
</style>
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
	
		<?php require 'header.php';  ?>
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<section>
			<div id="page-wrapper">
				<div class="charts">		
					<div class="mid-content-top charts-grids">	
						 
								<!---------------------------------------------->
								<div id="cont">
									
									<!--***********************************************************************************************-->
									<div id="div2">
										<div class="form-title">
											<h4>WORD BANK <i class="fa fa-arrow-right "></i> DOMAN KIDS</h4>
										</div><br>
										<table id="tblcontroles">
											<tbody>
												<tr>
													<td>
														<select id="selop" class="form-control">
															<option value="NA" selected>Select option</option>
															<option value="N">Enter new word</option>
															<option value="E">View words</option>
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
						
									</div>
									<div id="div1" style="display: none;">
										<div id="tblctpreg">
										</div>
									</div>
								</div></br>
								<!--<p><label>Id pregunta creada... </label><label id="idpreg"></label></p>-->
								<div id="resul_bus">
									
								</div>
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
		<?php require 'footer.php'; ?>
	    <!--//footer-->
		
		<!-- Modal de nueva palabra -->
        <div class="modal fade" id="modal_new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">NEW WORD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>* Word </label>
                <input type="text" id="txtpalabra" name="txtpalabra" class="form-control" />
                
                <label>Image <input type="text" class="controlcampo" style="width: 20px" id="ctr_txtretro" value="1"/> (300 Kb)</label>
                <input type="file" id="adjunto" name="adjunto" accept=".jpg,.jpeg,.png" class="btn btn-lg btn-info">
              </div>
              <div class="modal-footer">
                  <label id="lblmsg"></label><img id="imgnp" src="../../images/caract_no_perm.png" style="display: none;" width="361" height="40">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" onclick="guardar()">Save</button>
                
              </div>
            </div>
          </div>
        </div>
        
        <!-- Modal edición palabra -->
        <div class="modal fade" id="modal_editar_preg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDIT WORD</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>* Word </label>
                <input type="text" id="txtupdpalabra" name="txtupdpalabra" class="form-control" required/>
                
                <div class="row">
                    <div class="col-lg-8">
                        <label>Image <input type="text" class="controlcampo" style="width: 20px" id="ctr_updadjunto" value="1"/> (300 Kb)</label>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="btneditar" data-dismiss="modal" onclick="modificar()">Modify</button>
                
              </div>
            </div>
          </div>
        </div>
	    
		
	</div>
</body>
	<!-- Classie --><!-- for toggle left push menu script -->
	<script src="../js/classie.js"></script>
	<script>
		let menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
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
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
    	$('#listEstudiantes').DataTable();	
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('You must log in');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>