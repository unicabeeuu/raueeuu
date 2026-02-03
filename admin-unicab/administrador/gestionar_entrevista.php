<?php 
	session_start();
	require "../php/conexion.php";
	if (isset($_SESSION['admin_unicab']) || isset($_SESSION['uniprofe'])) {

		$sql_emp = "SELECT * FROM tbl_empleados WHERE perfil IN ('AR_AW','PS') AND id NOT IN (1,30,31)";
		$exe_emp = mysqli_query($conexion,$sql_emp);

		/*while ($rowAdmin=mysqli_fetch_array($exeAdministrador)) {
			$IdAdministrador=$rowAdmin['IdAdministrador'];
			$Apellidos=$rowAdmin['Apellido'];
			$Nombres=$rowAdmin['Nombre'];
		}*/
?>
<?php
$peticion2="SET lc_time_names = 'es_CO'";
$resultado2 = mysqli_query($conexion, $peticion2);

$peticion = "SELECT DATE_FORMAT(NOW(),'%W %d de %M de %Y') fecha";
$resultado = mysqli_query($conexion, $peticion);
while ($fila = mysqli_fetch_array($resultado))
	{
		$fechaActual=$fila['fecha'];
    }  ;

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

    <style>
        .azul1 {
            background: lightblue;
            padding-top: 10px;
        }
        .largo1 {
            height: 200px !Important;
        }
		#lblUltimoAño, #lblUltimoGrado, #lblUltimoEstado, .azul {
			font-weight: bold;
			color: blue;
		}
    </style>
    
    <script>
        $(function() {
            $("#psicologo").change(function() {
                /*$("#btnsubmit").hide();
                
                var psic = $("#psicologo").val();
                //alert(gra);
                
                if (psic == "0") {
                    $("#btnsubmit").hide();
                }
                else {
                    $("#btnsubmit").show();
                }*/
                
                mostrar_submit();
        	});
        	
        	$("#chkeval").on("change", function() {
                if( $(this).is(":checked") ){
                    //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                    $("#divgrados").show();
                } else {
                    //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
                    $("#divgrados").hide();
                    $("input:checkbox[name=chkgrados]").attr("checked",false);
                }
                
                mostrar_submit();
            });
            
            $(".chkgrados").on("change", function() {
                mostrar_submit();
            });
            
        });
        
        function buscar_inf() {
            //alert("hola");
            //$(".loader").fadeOut("slow");
            
            //Se limpian los controles
            $("#nombree").val("");
            $("#gradoe").val("");
            $("#observaciones").val("");
            $("#documento").val("0");
            $("#btnsubmit").hide();
			$("#motivo").val("");
			$("#bodyeval").html("");
            
            var buscar = $("#buscar").val();
            
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
        		    
        		    if(res.ct_est == 1) {
            		    //alert("Datos cargados ");
            		    $("#nombree").val(res.nombres + " " + res.apellidos);
            		    $("#gradoe").val(res.grado);
            		    $("#observaciones_g").val(res.obs);
            		    $("#psicologo").show();
            		    $("#documento").val(buscar);
            		    $("#idprem").val(res.id);
            		    $("#codigoe").val(res.id);
            		    $("#observaciones").val(res.obs_ent);
						$("#motivo").val(res.motivo);
						$("#lblUltimoAño").html(res.ultimo_año);
						$("#lblUltimoGrado").html(res.ultimo_grado);
						$("#lblUltimoEstado").html(res.ultimo_estado);
            		    
            		    $("#chkg1").prop("checked",false);
    		            $("#chkg2").prop("checked",false);
    		            $("#chkg3").prop("checked",false);
    		            $("#chkg4").prop("checked",false);
    		            $("#chkg5").prop("checked",false);
    		            $("#chkg6").prop("checked",false);
    		            $("#chkg7").prop("checked",false);
    		            $("#chkg8").prop("checked",false);
    		            $("#chkg9").prop("checked",false);
    		            $("#chkg10").prop("checked",false);
    		            $("#chkg11").prop("checked",false);
						
						$("#chkadmitido").prop("checked",false);
						if(res.admitido == 1) {
							$("#chkadmitido").prop("checked",true);
						}
            		    
            		    if(res.eval == 1) {
            		        $("#chkeval").prop("checked",true);
            		        $("#divgrados").show();
            		        var a = 0;
            		        
            		        var ct_eval = Object.keys(res.grados_val_total).length;
            		        for(i = 0; i < ct_eval; i++) {
            		            var id_grav = res.grados_val_total[i].id_grav;
            		            //alert(id_grav);
            		            
            		            (id_grav == 2) ? $("#chkg1").prop("checked",true) : a = 0 ;
            		            (id_grav == 3) ? $("#chkg2").prop("checked",true) : a = 0 ;
            		            (id_grav == 4) ? $("#chkg3").prop("checked",true) : a = 0 ;
            		            (id_grav == 5) ? $("#chkg4").prop("checked",true) : a = 0 ;
            		            (id_grav == 6) ? $("#chkg5").prop("checked",true) : a = 0 ;
            		            (id_grav == 7) ? $("#chkg6").prop("checked",true) : a = 0 ;
            		            (id_grav == 8) ? $("#chkg7").prop("checked",true) : a = 0 ;
            		            (id_grav == 9) ? $("#chkg8").prop("checked",true) : a = 0 ;
            		            (id_grav == 10) ? $("#chkg9").prop("checked",true) : a = 0 ;
            		            (id_grav == 11) ? $("#chkg10").prop("checked",true) : a = 0 ;
            		            (id_grav == 12) ? $("#chkg11").prop("checked",true) : a = 0 ;
            		        }
            		    }
            		    else {
            		        $("#chkeval").prop("checked",false);
            		        $("#divgrados").hide();
            		    }
            		    
            		    /*if (psic == "0") {
                            $("#btnsubmit").hide();
                        }
                        else {
                            $("#btnsubmit").show();
                        }*/
						
						//Se muestra el estado de la evaluación
						//console.log(res.eval_val.length);
						var cadena = "";
						if (res.eval_val.length > 0) {
							for (var i = 0; i < res.eval_val.length; i++) {
								cadena = cadena + '<tr>';
									cadena = cadena + '<td>' + res.eval_val[i].estado + '</td>';
									cadena = cadena + '<td>' + res.eval_val[i].ct + '</td>';
								cadena = cadena + '</tr>';
							}
							$("#bodyeval").html(cadena);
						}
						else {
							$("#bodyeval").html("");
						}
        		    }
        		    else {
        		        alert("Este documento no se encuentra registrado");
        		        $("#nombree").val("");
            		    $("#gradoe").val("");
            		    $("#observaciones_g").val("");
            		    //$("#btnsubmit").hide();
            		    $("#psicologo").hide();
            		    $("#documento").val("");
            		    $("#idprem").val("");
            		    $("#codigoe").val("");
            		    $("#observaciones").val("");
						$("#motivo").val("");
            		    
            		    $("#chkeval").prop("checked",false);
        		    }
        		    
        		    if(res.entrevista == "SI") {
        		        alert("Este documento ya se actualizó con los comentarios de entrevista");
        		        $("#btnsubmit").hide();
        		        $("#psicologo").hide();
        		        $("#ctr_observ").val(1);
        		    }
        		}
        	});
        	
        	mostrar_submit();
        }
        
        function validar_texto(id, desc) {
            var control = 0;
            var id_obj = "#" + id;
            var ctr_obj = "#ctr_" + id;
            var v_input = document.getElementById(id);
            //var v_val = /[-_'"\<\>\~\^\*\$\!\¡\#\%\&\¿\?\/\=\+\|,;:\(\)\{\}\[\]\\]{1,}/;
            var v_val = /[_'"\~\$\#\&\|;\(\)\{\}\[\]\\]{1,}/;
            var val = String($(id_obj).val()).match(v_val);
            
            if(val == null) {
                v_input.setCustomValidity("");
                $("#lblmsg").html("");
                //$("#btnsubmit").show();
                $("#ctr_observ").val(0);
            }
            else {
                v_input.setCustomValidity("Ha ingresado caracteres inválidos");
                var texto = "Ha ingresado caracteres no permitidos para " + desc + ": ";
                texto += " _ \' \" ~ $ # & | ; ( ) { } [ ] \\";
                //alert(texto);
                $("#lblmsg").html(texto).css("color","red");
                //$("#btnsubmit").hide();
                $("#ctr_observ").val(1);
            }
            
            mostrar_submit();
        }
        
        function mostrar_submit() {
            $("#btnsubmit").hide();
            var control = 0;
            var psic = $("#psicologo").val();
            if(psic == "0") {
                $("#btnsubmit").hide();
                control = 1;
            }
            
            if(control == 0) {
                var observ = $("#ctr_observ").val();
                if(observ == 1) {
                    $("#btnsubmit").hide();
                    control = 1;
                }
            }
            
            //Se valida si tiene grados por validar
            var contador = 0;
            if(control == 0) {
                if( $("#chkeval").prop("checked") ) {
                    //alert('Seleccionado');
                    $(".chkgrados:checked").each(function() {
                        contador++;
                    });
                    
                    if(contador == 0) {
                        control = 1;
                        var texto = "Ha indicado que el estudiante requiere evaluación de validación, pero no ha seleccionado ningún grado.";
                        $("#lblmsg").html(texto).css("color","red");
                    }
                    else {
                        $("#lblmsg").html("");
                    }
                }
            }
            
            
            if(control == 0) {
                $("#btnsubmit").show();
            }
        }
        
    </script>

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
							<h4>Gestionar entrevista:</h4>	
						</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow azul1" data-example-id="basic-forms"> 
						<div class="form-group col-lg-6 text-left">
    					    <label id="lblbuscar">Buscar por identificación del estudiante:</label>
    					</div>
    					<div class="form-group col-lg-6 text-left azul1">
    					    <input type="text" class="" id="buscar" name="buscar" width="300px">
    						<button class="btn btn-success" onclick="buscar_inf();">Buscar</button>
    					</div>
					</div>
				</div>
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-body">
							<form action="gestionar_entrevista_upddat.php" method="POST" id="form" name="form" enctype="multipart/form-data">

								
                                <div class="form-group col-lg-6 text-left"> 
                                    <label for="nombree">Nombre estudiante:</label>
									<input type="text" class="form-control" id="nombree" name="nombree" width="300px" readonly>
								</div>
								<div class="form-group col-lg-3 text-left"> 
                                    <label for="gradoe">Grado:</label>
									<input type="text" class="form-control" id="gradoe" name="gradoe" width="300px" readonly>
								</div>
								<div class="form-group col-lg-3 text-left"> 
                                    <label for="codigoe">Código entrevista:</label>
									<input type="text" class="form-control" id="codigoe" name="codigoe" width="300px" readonly>
								</div>
								
								<div class="form-group col-lg-12 text-left"> 
                                    <label for="observaciones_g">Observaciones generales:</label>
                                    <textArea type="text" class="form-control largo1" id="observaciones_g" name="observaciones_g" maxlength="2000" readonly></textArea>
								</div>
                               
                                <div class="form-group col-lg-12 text-left"> 
                                    <label for="psicologo">Psicólogo:</label> 
									<select id="psicologo" name="psicologo" width="300px" class="form-control1" style="display: none;">
										<option value="0" selected> Seleccion psicólogo</option>
										<?php
										    while ($row_emp = mysqli_fetch_array($exe_emp)) {
										        echo '<option value="'.$row_emp['id'].'">'.$row_emp['nombres'].' '.$row_emp['apellidos'].'</option>';
										    }
										?>
									</select>
								</div>
                                
                                <div class="form-group col-lg-12 text-left"> 
									<div class="row">
										<div class="form-group col-lg-4">
											<p><span>Ultimo año: </span><label id="lblUltimoAño"></label></p>
										</div>
										<div class="form-group col-lg-4">
											<p><span>Ultimo grado: </span><label id="lblUltimoGrado"></label></p>
										</div>
										<div class="form-group col-lg-4">
											<p><span>Ultimo estado: </span><label id="lblUltimoEstado"></label></p>
										</div>
									</div>
									
									<div class="row">
										<div class="form-group col-lg-4">
											<p><span>Estado Evaluación Desempeño: </span></p>
											<table id="tblEvaluacion" class="table">
												<thead>
													<tr>
														<td class="azul">Estado</td>
														<td class="azul">Cantidad Preguntas</td>
													</tr>
												</thead>
												<tbody id="bodyeval">
												</tbody>
											</table>
										</div>
									</div>
								</div>
								
								<div class="form-group col-lg-12 text-left"> 
                                    <label for="motivo">Motivo de ingreso (Situación socio-económica)</label>
									<textArea type="text" class="form-control largo1" id="motivo" name="motivo" width="550px" maxlength="2000" readonly></textArea>									
								</div>
								
								<div class="form-group col-lg-12 text-left"> 
                                    <label for="observaciones">Observaciones: (Máximo 2000 caracteres)</label>
									<textArea type="text" class="form-control largo1" id="observaciones" name="observaciones" placeholder="Ingrese observaciones"  width="550px" onkeyup="validar_texto('observaciones', 'Observaciones');" maxlength="2000" required></textArea>
									<input type="hidden" id="ctr_observ" name="ctr_observ" value="1"/>
								</div>
                                
                                <div class="form-group col-lg-3 text-left"> 
                                    <label for="chkeval">Requiere evaluación de validación:</label>
									<input type="checkbox" class="form-control" id="chkeval" name="chkeval" width="300px" value="eval_val">
								</div>
								<div class="form-group col-lg-9 text-left" id="divgrados" style="display: none;">
								    <table class="table">
								        <thead>
								            <tr>
								                <td>1<sup>er</sup>g</td>
								                <td>2<sup>do</sup>g</td>
								                <td>3<sup>er</sup>g</td>
								                <td>4<sup>to</sup>g</td>
								                <td>5<sup>to</sup>g</td>
								                <td>6<sup>to</sup>g</td>
								                <td>7<sup>mo</sup>g</td>
								                <td>8<sup>vo</sup>g</td>
								                <td>9<sup>no</sup>g</td>
								                <td>10<sup>mo</sup>g</td>
								                <td>11<sup>avo</sup>g</td>
								            </tr>
								        </thead>
								        <tbody>
								            <tr>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg1" name="chkgrados[]" value="2"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg2" name="chkgrados[]" value="3"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg3" name="chkgrados[]" value="4"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg4" name="chkgrados[]" value="5"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg5" name="chkgrados[]" value="6"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg6" name="chkgrados[]" value="7"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg7" name="chkgrados[]" value="8"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg8" name="chkgrados[]" value="9"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg9" name="chkgrados[]" value="10"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg10" name="chkgrados[]" value="11"></td>
								                <td><input type="checkbox" class="form-control chkgrados" id="chkg11" name="chkgrados[]" value="12"></td>
								            </tr>
								        </tbody>
								    </table> 
                                    
								</div>
                                <label id="lblmsg"></label>
								
								<div class="form-group col-lg-3 text-left"> 
                                    <label for="chkeval">Admitido:</label>
									<input type="checkbox" class="form-control" id="chkadmitido" name="chkadmitido" width="300px" value="admitido">
								</div>
                                
                                <div class="form-group col-lg-12 text-right"> 
                                    <!--<button type="submit" class="btn btn-default">Guardar</button>-->
                                    <input type="submit" id="btnsubmit" class="btn btn-warning" value="Guardar" style="display: none;"/>
                                    <input type="hidden" id="documento" name="documento"/>
                                    <input type="hidden" id="idprem" name="idprem"/>
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
	
	<!-- side nav js -->
	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
	
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