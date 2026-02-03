<?php
session_start();
require "../php/conexion.php";
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
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	$fecha2 =$a."/".$mes."/". $dia;
	if($mes >= 10) {
	    $a++;
	}
    
	$peticion="SELECT a.* FROM 
	(SELECT cp.*, e.nombres, e.apellidos FROM tbl_asistente_virtual_comprobantes_pago cp, estudiantes e 
	WHERE cp.documento = e.n_documento AND cp.tipo = 'deuda' 
	UNION ALL 
	SELECT cp.*, e.nombres, e.apellidos FROM tbl_asistente_virtual_comprobantes_pago cp, estudiantes e 
	WHERE cp.documento = e.n_documento AND cp.tipo = 'matrícula' AND cp.a = $a) a ORDER BY a.id DESC";
	$resultado = mysqli_query($conexion, $peticion);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

 <!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
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
<link href="../../registro/css/jquery.dataTables.min.css" rel="stylesheet"> 
<!-- // css tabla -->
<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->

<script>
	function toggleValidacion(registroId, element) {
		const nuevoValor = element.checked ? 1 : 0;
		// Desactivar el checkbox mientras se actualiza
		element.disabled = true;
		
		fetch('https://unicab.org/avadmisiones/av_validar_comprobantes.php', {
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
				const celdaValidado = fila.querySelector('td:nth-child(8)'); // 8ta columna (validado)
				if (celdaValidado) {
					celdaValidado.textContent = nuevoValor;
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
	
	function Rechazar(id, documento, tipo, valor, element) {
		const fila = element.closest('tr');
		const celdaValidado = fila.querySelector('td:nth-child(8)'); // 8ta columna (validado)
		console.log(celdaValidado.textContent);
		if (celdaValidado.textContent == "1") {
			alert("Está acción no está permitida para comprobantes validados.");
		}
		else {
			let razon = prompt("Ingrese la razón por la cual se rechaza el comprobante");
			razon = razon.replace(/ /g, '_');
			//alert("El registro " + id + " del documento " + documento + ", tipo " + tipo + " y valor de " + valor + " fue rechazado por la siguiente razón: " + razon);
			
			fetch('https://unicab.org/avadmisiones/av_rechazar_comprobantes.php', {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: `id=${id}&documento=${documento}&tipo=${tipo}&valor=${valor}&razon=${razon}`
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
					alert("Correo de rechazo de comprobante enviado con éxito");
					location.reload();
				} else {
					alert("Correo de rechazo de comprobante no se puedo enviar");
				}
			})
			.catch(err => {
				console.log('Error:', err);
				alert('No se pudo conectar con el servidor.');
			})
			.finally(() => {
				///element.disabled = false;
			});
		}		
	}
	
</script>
<style>
#chartdiv {
  width: 100%;
  height: 295px;
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

/*##################################*/
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
		
		<section>
           	<div id="page-wrapper">
				<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>Listado de comprobantes de deuda y matrícula:</h4>
						</div>
						<div class="form-body">
							<table id="listEstudiantes" class="display" style="width:100%">
						        <thead>                    
						            <tr>
						                <th>Apellidos</th>
						                <th>Nombres</th>
						                <th>Documento</th>
						                <th>Tipo</th>
										<th>Año</th>
						                <th>Comprobante</th>
										<th>Val</th>
										<th>Validado</th>
										<th>Estado</th>
										<th>Validar</th>
										<th>Rechazar</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php 
							        	while ($fila = mysqli_fetch_array($resultado)){
											$isChecked = ($fila['validado'] == 1) ? 'checked' : '';
											$registroId = $fila['id'];
							        		echo"<tr>
							        		<td>".$fila['apellidos']."</td>
							        		<td>".$fila['nombres']."</td>
							        		<td>".$fila['documento']."</td>
							        		<td>".$fila['tipo']."</td>
											<td>".$fila['a']."</td>
							        		<td><a href='".$fila['ruta']."' target='_blank'>Descargar</a></td>
											<td>".$fila['valor']."</td>
							        		<td>".$fila['validado']."</td>";
											
											if ($fila['validado'] == 1) {
												echo "<td><center><label>Validado</label></center></td>";
											}
											else if ($fila['rechazado'] == 1) {
												echo "<td><center><label>Rechazado</label></center></td>";
											}
											else if ($fila['rechazado'] == 0) {
												echo "<td><center><label>Rechazado</label></center></td>";
											} 

											if ($fila['rechazado'] == 1) {
												echo "<td><center>
												<!--<a href='lista-estudiantes_evalval1.php?documento=".$fila['documento_est']."&idgra=".$fila['id_grado_val']."' class='btn btn-primary'><i class='fa fa-file-text'></i> Ver resultado</a></center></td></tr>-->
												<div class='switch-wrapper' style='display: none !important;'><label class='custom-switch-v3'><input type='checkbox' ".$isChecked." onclick='toggleValidacion(".$registroId.", this)'><span class='custom-slider-v3'></span></label></div></center></td>";
												
												echo "<td><center>
												<!--<div class='switch-wrapper'><label class='custom-switch-v4'><input type='checkbox' ".$isChecked1." onclick=''><span class='custom-slider-v4'></span></label></div>-->
												<button class='btn btn-warning' onclick='Rechazar(".$registroId.", ".$fila['documento'].", \"".$fila['tipo']."\", ".$fila['valor'].", this);' disabled>Rechazar</button></center></td></tr>";
											}
											else if ($fila['rechazado'] == 0) {
												echo "<td><center>
												<!--<a href='lista-estudiantes_evalval1.php?documento=".$fila['documento_est']."&idgra=".$fila['id_grado_val']."' class='btn btn-primary'><i class='fa fa-file-text'></i> Ver resultado</a></center></td></tr>-->
												<div class='switch-wrapper'><label class='custom-switch-v3'><input type='checkbox' ".$isChecked." onclick='toggleValidacion(".$registroId.", this)'><span class='custom-slider-v3'></span></label></div></center></td>";
												
												echo "<td><center>
												<!--<div class='switch-wrapper'><label class='custom-switch-v4'><input type='checkbox' ".$isChecked1." onclick=''><span class='custom-slider-v4'></span></label></div>-->
												<button class='btn btn-warning' onclick='Rechazar(".$registroId.", ".$fila['documento'].", \"".$fila['tipo']."\", ".$fila['valor'].", this);'>Rechazar</button></center></td></tr>";
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
		<!--footer-->
		<?php require "include/footer.php"; ?>
	    <!--//footer-->
	</div>
</body>
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
	
	<!-- side nav js -->
	<script src='../../registro/js/SidebarNav.min.js' type='text/javascript'></script>
	<script>
      $('.sidebar-menu').SidebarNav()
    </script>
	<!-- //side nav js -->
    
    <!-- js tabla -->
	<script src="../js/jquery.dataTables.min.js"></script>
	<script type="text/javascript">
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
		} );
	</script>
	<!-- //js tabla -->

	<!-- Bootstrap Core JavaScript -->
   	<script src="../../registro/js/bootstrap.js"> </script>
	<!-- //Bootstrap Core JavaScript -->
    
	<!--  <script>-->
<?php 
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>