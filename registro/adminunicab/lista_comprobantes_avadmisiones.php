<?php
    session_start();
    include "php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//https://unicab.org/registro/adminunicab/estudiante_grupo_getdat.php
	
if (isset($_SESSION['unisuper'])) {
    $sql="SELECT * FROM tbl_empleados WHERE email='".$_SESSION['unisuper']."'";
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
    //echo $id;
    
    $tot_sol = 0;
    $tot_mat = 0;
    $tot_ciu = 0;
    
    date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
    
    /*$query = "SELECT COUNT(1) ct, g.id, g.grado, m.grupo 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND m.estado = 'activo' AND date_format(m.fecha_ingreso, '%Y') = $a AND m.id_estudiante != '1155' 
    GROUP BY g.id, g.grado, m.grupo ORDER BY g.id";*/
    $query = "SELECT COUNT(1) ct, g.id, g.grado, m.grupo 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND m.estado = 'activo' AND m.n_matricula like '%2025%' AND m.id_estudiante NOT IN (1155) 
    GROUP BY g.id, g.grado, m.grupo ORDER BY g.id";
    //echo $query;
    $resultado1 = $mysqli1->query($query);
    
    //Solicitudes por grado
    /*$query1 = "SELECT COUNT(1) ct, g.grado 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND date_format(m.fecha_ingreso, '%Y') = $a AND m.id_estudiante != 1155 GROUP BY m.id_grado";*/
    $query1 = "SELECT COUNT(1) ct, g.grado 
    FROM matricula m, grados g 
    WHERE m.id_grado = g.id AND m.n_matricula like '%2025%' AND m.id_estudiante NOT IN (1155, 1040) AND m.estado IN ('pre_solicitud', 'solicitud') GROUP BY m.id_grado";
    //echo $query1;
    $resultado2 = $mysqli1->query($query1);
    
    //Matrículas por ciudad
    /*$query2 = "SELECT COUNT(1) ct, e.ciudad 
    FROM matricula m, estudiantes e 
    WHERE m.id_estudiante = e.id AND date_format(m.fecha_ingreso, '%Y') = $a AND m.id_estudiante != 1155 AND m.estado = 'activo' GROUP BY e.ciudad";*/
    $query2 = "SELECT COUNT(1) ct, e.ciudad 
    FROM matricula m, estudiantes e 
    WHERE m.id_estudiante = e.id AND m.n_matricula like '%2025%' AND m.id_estudiante != 1155 AND m.estado = 'activo' GROUP BY e.ciudad";
    //echo $query2;
    $resultado3 = $mysqli1->query($query2);
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$fecha2 =$a."/".$mes."/". $dia;
	if($mes >= 10) {
	    $a++;
	}
	
	$peticion = "SELECT cp.*, e.nombres, e.apellidos FROM tbl_asistente_virtual_comprobantes_pago cp, estudiantes e 
	WHERE cp.documento = e.n_documento AND cp.tipo = 'deuda' 
	UNION ALL 
	SELECT cp.*, e.nombres, e.apellidos FROM tbl_asistente_virtual_comprobantes_pago cp, estudiantes e 
	WHERE cp.documento = e.n_documento AND cp.tipo = 'matrícula' AND cp.a = $a";
	//$resultado = mysqli_query($conexion, $peticion);
	
	/*$peticion1 = "SELECT DISTINCT dm.documento, dm.a, e.apellidos, e.nombres, av.id_grado, g.grado 
	FROM tbl_documentos_matriculas dm, estudiantes e, tbl_asistente_virtual av, grados g 
    WHERE dm.documento = e.n_documento AND dm.documento = av.documento_estudiante AND av.id_grado = g.id 
    AND dm.a >= $a";*/
	$peticion1 = "SELECT DISTINCT dm.documento, dm.a, e.apellidos, e.nombres, av.id_grado, g.grado, c.ct, c.suma, av.control_documentos_invalidos 
	FROM tbl_documentos_matriculas dm, estudiantes e, tbl_asistente_virtual av, grados g, 
	(SELECT COUNT(1) ct, SUM(validado) suma, documento FROM tbl_documentos_matriculas WHERE a >= $a GROUP BY documento) c 
	WHERE dm.documento = e.n_documento AND dm.documento = av.documento_estudiante AND dm.documento = c.documento 
	AND av.id_grado = g.id AND dm.a >= $a";
	$resultado0 = mysqli_query($conexion, $peticion1);
    
?>
<!DOCTYPE HTML>
<html>
<head><meta charset="gb18030">
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" href="../images/favicon.png" />
<!-- // Favicon -->
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

<!-- font-awesome icons CSS -->
<link href="../css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons CSS-->

<!-- side nav css file -->
<link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
<!-- //side nav css file -->
 <!-- js-->
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/modernizr.custom.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!--css tabla -->
<link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
    <style>
        #cont {
        	display: flex;
        	justify-content: space-around;
        }
        fieldset {
        	border: 2px double green;
        	-moz-border-radius: 8px;
        	-webkit-border-radius: 8px;	
        	border-radius: 8px;
        }
        legend {
        	 text-align: center;
        	 font-weight: bold;
        	 font-size: 18pt;
        	 color: #B4045F;
        	 text-shadow: 0px 0px 10px #BA55D3;
        }
        .mprincipal {
        	list-style-image: url(../docenteunicab/updreg/img/m26.png);
        	font-weight: bold !important;
        	font-size: 20px !important;
        }
        .msecund {
        	list-style-image: url(../docenteunicab/updreg/img/bd30.png); 
        	background: lightgreen;
        	padding: 20px;
        	font-weight: bold;
        	font-size: 18px;
        }
        .msecund li {
        	background: #cce5ff;
        	margin-left: 20px;
        	margin-top: 5px;
        }
        thead {
            background-color: gray;
            color: white;
        }
        td.perdio {
            color: red;
            border-right: 1px solid black;
        }
        h3 {
            color: blue;
            font-weight: bold;
        }
		#txtRechazo {
			width: 100%;
		}
		
		/* Asegura que el contenedor de la celda no interfiera */
		.switch-wrapper {
			display: inline-block !important;
			text-align: center !important;
		}

		.custom-switch-v3 {
		  /* Usamos border-box para que los paddings no afecten el tamaño final */
		  box-sizing: border-box !important;
		  position: relative !important;
		  display: inline-block !important;
		  width: 50px !important; 
		  height: 25px !important; 
		  margin: 0 auto !important; /* Centrado */
		}

		/* Ocultar el checkbox nativo */
		.custom-switch-v3 input {
		  opacity: 0 !important;
		  width: 0 !important;
		  height: 0 !important;
		}

		/* El slider (fondo) */
		.custom-slider-v3 {
		  box-sizing: border-box !important;
		  position: absolute !important;
		  cursor: pointer !important;
		  top: 0 !important;
		  left: 0 !important;
		  right: 0 !important;
		  bottom: 0 !important;
		  background-color: red !important; 
		  transition: .4s;
		  border-radius: 25px !important;
		}

		/* El pomo (círculo) */
		.custom-slider-v3:before {
		  box-sizing: border-box !important;
		  position: absolute !important;
		  content: "" !important;
		  height: 17px !important; 
		  width: 17px !important; 
		  left: 4px !important;
		  bottom: 4px !important;
		  background-color: white !important;
		  transition: .4s;
		  border-radius: 50% !important;
		}

		/* Estado ON */
		.custom-switch-v3 input:checked + .custom-slider-v3 {
		  background-color: #28a745 !important; /* Color verde de éxito */
		}

		/* Mover el pomo */
		.custom-switch-v3 input:checked + .custom-slider-v3:before {
		  transform: translateX(25px) !important;
		}
    </style>
    <script>
        
        $(function() {
            //alert("hola");
            //consultar_estudiantes();
        });
		
		function verDocumentos(documento, a, control_documentos_invalidos, nombre) {
			console.log(documento + " " + a);
			$("#div_listado").empty();
			$("#nombre").html(nombre);
			$("#documentoRechazo").val(documento);
			$("#txtRechazo").val("");
			$("#txtControlDocumentosInvalidos").val(control_documentos_invalidos);
            //alert("función");
            
            $.ajax({
        		type:"POST",
        		url:"lista_comprobantes_avadmisiones1.php",
        		data:"documento=" + documento + "&a=" + a,
        		success:function(r) {
        			$("#div_listado").html(r);        			
        		}
        	});
        	
        	$('#modal_list').modal('toggle');
            $('#modal_list').modal('show');
		}
        
        function enviardat(id_grado, grupo) {
            $("#div_listado").empty();
            //alert("funci¨®n");
            
            $.ajax({
        		type:"POST",
        		url:"estudiante_grupo_getdat1.php",
        		data:"id_grado=" + id_grado + "&grupo=" + grupo,
        		success:function(r) {
        			$("#div_listado").html(r);
        			//$("#tbodyact").html(r);
        		}
        	});
        	
        	$('#modal_list').modal('toggle');
            $('#modal_list').modal('show');
        }
        
        function enviardat1(id_est, grupo) {
            //alert("funci¨®n");
            
            $.ajax({
        		type:"POST",
        		url:"estudiante_grupo_getdat2.php",
        		data:"id_est=" + id_est + "&grupo=" + grupo,
        		success:function(r) {
        			var res = JSON.parse(r);
        		    
        		    $("#txtid").val(res.id);
        		    $("#txtnom").val(res.nombres);
        		    $("#txtape").val(res.apellidos);
        		    $("#txtgra").val(res.grado);
        		    $("#txtgru").val(grupo);
        		}
        	});
        	
            $('#modal_list_upd').modal('toggle');
            $('#modal_list_upd').modal('show');
        }
        
        function updgru() {
            var datos = "idest=" + $("#txtid").val() + "&grupo=" + $("#txtgru").val();
        	//alert(datos);
        	
            $.ajax({
        		type:"POST",
        		url:"act_grupo_upddat.php",
        		data:"idest=" + $("#txtid").val() + "&grupo=" + $("#txtgru").val(),
        		success:function(r) {
        		    alert("Registro actualizado correctamente");
        		    $('#modal_list').modal('hide');
        		    
        		    location.reload();
        		}
        	});
        }
		
		function toggleValidacion(registroId, element) {
			const nuevoValor = element.checked ? 1 : 0;
			// Desactivar el checkbox mientras se actualiza
			element.disabled = true;
			
			fetch('https://unicab.org/avadmisiones/av_validar_documentos_finales.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: `id=${registroId}&validado=${nuevoValor}`
			})
			//.then(res => res.json())
			.then(async r => {
				const text = await r.text(); // lee la respuesta como texto crudo
				console.log(text); // aquí verás lo que realmente devolvió el servidor
				try {
					const data = JSON.parse(text); // intenta parsear a JSON
					return data;
				} catch (e) {
					//console.log("⚠️ La respuesta no es JSON válido:");
					throw e; // lanza el error para que caiga en el catch
				}
			})
			.then(data => {
				if (data.status == "success") {
					// Actualiza visualmente la celda de "validado" sin recargar la tabla
					const fila = element.closest('tr');
					const celdaValidado = fila.querySelector('td:nth-child(3)'); // 3ta columna (validado)
					if (celdaValidado) {
						celdaValidado.textContent = nuevoValor;
					}
					if (data.respuesta_correo == "CorreoOK") {
						location.reload();
					}
				} else {
					alert('Error al actualizar: ' + (data.mensaje || 'Respuesta inválida'));
					element.checked = !element.checked; // Revertir si falla
				}
			})
			.catch(err => {
				console.log('Error:', err);
				alert('No se pudo conectar con el servidor.');
				element.checked = !element.checked;
			})
			.finally(() => {
				element.disabled = false;
			});		
			
			/*if (element.checked) {
				alert('¡Alerta! El switch está ACTIVADO (estado lógico 1).');
				
			} else {
				alert('¡Alerta! El switch está DESACTIVADO (estado lógico 0).');
			}*/
		
		}
		
		function Rechazar() {
			let razon = $("#txtRechazo").val();
			razon = razon.replace(/ /g, '_');
			let documento = $("#documentoRechazo").val();
			console.log(documento);
			const checkboxes = document.querySelectorAll('input[type="checkbox"]');
			let checkedCount = 0;
			checkboxes.forEach(checkbox => {
				if (checkbox.checked) {
					checkedCount++;
				}
			});
			console.log("Total checkbox " + checkboxes.length + " total validados " + checkedCount);
			
			if (checkedCount == checkboxes.length) {
				alert("Está acción no está permitida si todos los documentos están validados.");
			}
			else if ($("#txtControlDocumentosInvalidos").val() == "1") {
				alert("Está acción no está permitida porque ya se envío un mensaje de rechazo de documentos al acudiente.");
			}
			else if (razon != "") {
				// Desactivar el botón y mostrar carga btnRechazar
				let submitBtn = $('#btnRechazar');
				submitBtn.prop('disabled', true);
				submitBtn.html(`
					<img src="../images/subiendo.gif" 
						alt="Enviando correo" 
						style="width: 20%; vertical-align: middle; margin-right: 8px;">
					Enviando correo...
				`);
			
				fetch('https://unicab.org/avadmisiones/av_rechazar_documentos_finales.php', {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: `documento=${documento}&razon=${razon}`
				})
				//.then(res => res.json())
				.then(async r => {
					const text = await r.text(); // lee la respuesta como texto crudo
					console.log(text); // aquí verás lo que realmente devolvió el servidor
					try {
						const data = JSON.parse(text); // intenta parsear a JSON
						return data;
					} catch (e) {
						//console.log("⚠️ La respuesta no es JSON válido:");
						throw e; // lanza el error para que caiga en el catch
					}
				})
				.then(data => {
					console.log(data)
					if (data.status == "success") {
						alert("Correo de rechazo de documentos finales enviado con éxito");
					} else {
						alert("Correo de rechazo de documentos finales no se puedo enviar");
					}
					
					submitBtn.prop('disabled', false); 
					submitBtn.html('Rechazar');
				})
				.catch(err => {
					console.log('Error:', err);
					submitBtn.prop('disabled', false); 
					submitBtn.html('Rechazar');
					alert('No se pudo conectar con el servidor.');
				})
				.finally(() => {
					submitBtn.prop('disabled', false); 
					submitBtn.html('Rechazar');
				});
			}
			else {
				alert("Está acción no está permitida sin una razón detallada para el acudiente.");
			}
		}
        
    </script>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php //require 'menu.php';  ?>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {
		    //if($id == 18 ) {
		        require 'menu_registro.php';
		    }
		    else if($perfil == "AR1") {
		        require 'menu_registro_aux.php';
		    }
		    else if($perfil == "ARCH") {
		        require 'menu_archivo.php';
		    }
		    else {
		        require 'menu.php';
		    }
		?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Listado de estudiantes con documentos finales de matrícula enviados para validar:</h4>
						</div>
						<div class="form-body">
							<table id="listaDocumentos" class="display" style="width:100%">
						        <thead>                    
						            <tr>
						                <th>Apellidos</th>
						                <th>Nombres</th>
						                <th>Identificación</th>
						                <th>Año</th>
										<th>Grado</th>
										<th>Estado</th>
						                <th>Acción</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php 
							        	while ($fila = mysqli_fetch_array($resultado0)){
											//$isChecked = ($fila['validado'] == 1) ? 'checked' : '';
											//$registroId = $fila['id'];
											$nombre = $fila['apellidos']." ".$fila['nombres'];
							        		
							        		echo"<tr>
							        		<td>".$fila['apellidos']."</td>
							        		<td>".$fila['nombres']."</td>
							        		<td>".$fila['documento']."</td>
							        		<td>".$fila['a']."</td>
											<td>".$fila['grado']."</td>";
											
											if($fila['ct'] == $fila['suma']) {
												echo "<td>Aprobados</td>
													<td><button class='btn btn-success glyphicon glyphicon-list-alt' title='Ver Documentos'
                                                                    onclick='verDocumentos(".$fila['documento'].",".$fila['a'].",".$fila['control_documentos_invalidos'].",\"".$nombre."\")'> Ver Documentos</button></td>
													</tr>";
											}
											else {
												echo "<td>No_Aprobados</td>
													<td><button class='btn btn-warning glyphicon glyphicon-list-alt' title='Ver Documentos'
                                                                    onclick='verDocumentos(".$fila['documento'].",".$fila['a'].",".$fila['control_documentos_invalidos'].",\"".$nombre."\")'> Ver Documentos</button></td>
													</tr>";
											}
							        	}
						        	?>
						        </tbody>
						    </table>
						</div>
					</div>
           		</div>
      		</div>
		</section>
		
		<!-- main content start-->
        
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
	</div>
	
	<!-- Modal de datos estudiante grado y grupo -->
    <div class="modal fade bd-example-modal-md" id="modal_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">LISTADO DE DOCUMENTOS DE <span id="nombre"></span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="div_listado">
            </div>
			<div id="rechazo">
				<textarea id="txtRechazo" placeholder="Detalle la razón de rechazo..." rows="5"></textarea><br>
				<button id="btnRechazar" class="btn btn-primary" onclick="Rechazar();">Rechazar</button>
			</div>
			
			<input type="hidden" id="documentoRechazo">
			<input type="hidden" id="txtControlDocumentosInvalidos">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <!--<button type="button" class="btn btn-warning" id="btnupdpor" data-dismiss="modal" onclick="updpor()">Guardar</button>-->
          </div>
        </div>
      </div>
    </div>
    
    <!-- Modal de datos estudiante grado y grupo para cambiar de grupo -->
    <div class="modal fade" id="modal_list_upd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">INFORMACION DEL ESTUDIANTE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="modal-body">
                <label>Id_est</label>
                <input type="text" id="txtid" class="form-control" readonly/>
                <label>Nombres</label>
                <input type="text" id="txtnom" class="form-control" readonly/>
                <label>Apellidos</label>
                <input type="text" id="txtape" class="form-control" readonly/>
                <label>Grado</label>
                <input type="text" id="txtgra" class="form-control" readonly/>
                <label>Grupo</label>
                <input type="text" id="txtgru" class="form-control" oninput="val_grupo()"/>
                
                <label id="lblgrupo"></label>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-warning" id="btnupdpor" data-dismiss="modal" onclick="updgru()">Guardar</button>
          </div>
        </div>
      </div>
    </div>
        
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
			
			$(document).ready(function() {
				//$('#listEstudiantes').DataTable();
				$('#listEstudiantes').DataTable({
					responsive: false,
					autoWidth: false,
					scrollX: true, // agrega scroll horizontal si el contenido es muy ancho
					language: {
						url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
					},
					columnDefs: [
						{ targets: "_all", className: "dt-head-center dt-body-center" }
					]
				});
				
				$('#listaDocumentos').DataTable({
					responsive: false,
					autoWidth: false,
					scrollX: true, // agrega scroll horizontal si el contenido es muy ancho
					language: {
						url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
					},
					columnDefs: [
						{ targets: "_all", className: "dt-head-center dt-body-center" }
					]
				});
			});
			
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

	<!-- Bootstrap Core JavaScript -->
   <script src="../js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->

	<!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
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
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>