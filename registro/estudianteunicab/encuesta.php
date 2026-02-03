<?php 
	session_start();
	include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniestudiante'])) {
		$sql = "SELECT * FROM estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
		$res = mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$n_documento = $fila['n_documento'];
		$email_institucional = $fila['email_institucional'];
		$password = $fila['password'];
	}
	$contador=0;
	$nota_uno=0;
	$nota_dos=0;
	$nota_tres=0;
	$nota_cuatro=0;
	
	$buscar_grado="SELECT DISTINCT matricula.id_grado, grados.grado FROM matricula
    INNER JOIN grados ON matricula.id_grado=grados.id 
    INNER JOIN estudiantes on matricula.id_estudiante=estudiantes.id where estudiantes.id=".$id." and matricula.estado IN ('activo', 'aprobado')";
	$exe_buscar = mysqli_query($conexion,$buscar_grado);
	while ($buscar = mysqli_fetch_array($exe_buscar)) {
		$id_grado = $buscar['id_grado'];
		$nombre_grado = strtoupper($buscar['grado']);
	}
	
	$sql_encuesta = "SELECT * FROM tbl_encuestas_preguntas where id_encuesta = 1 AND respuesta_texto = 'NO'";
	//echo $sql_val_inicial;
	$exe_encuesta = mysqli_query($conexion, $sql_encuesta);
	
	$sql_encuesta1 = "SELECT * FROM tbl_encuestas_preguntas where id_encuesta = 1 AND respuesta_texto = 'SI'";
	//echo $sql_val_inicial;
	$exe_encuesta1 = mysqli_query($conexion, $sql_encuesta1);
	
	//Se valida si ya se realizó la encuesta
	$sql_val_enc = "SELECT COUNT(1) ct FROM tbl_encuestas_resultados WHERE n_documento = '$n_documento' AND año = 2025 AND id_encuesta = 1";
	$exe_val_enc = mysqli_query($conexion,$sql_val_enc);
	while ($row_val_enc = mysqli_fetch_array($exe_val_enc)) {
		$ct = $row_val_enc['ct'];
	}
	if ($ct > 0) {
		echo "<script>location.href='certificado_notas.php'</script>";
	}
	
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Unicab Registro Académico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <script type="text/javascript" src="../docenteunicab/updreg/js/jquery.min.js"></script>
    <script src="../js/modernizr.custom.js"></script>
    
    <!--webfonts-->
    <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
    <!--//webfonts--> 
    
    <!--css tabla -->
    <link href="../css/jquery.dataTables.min.css" rel="stylesheet"> 
    <!-- // css tabla -->
    
    <!-- Metis Menu -->
    <script src="../js/metisMenu.min.js"></script>
    <!--<script src="../js/custom.js"></script>-->
    <link href="../css/custom.css" rel="stylesheet">
    <!--//Metis Menu -->
    
    <script>
        $(function() {
            //alert("Cargó jquery");
        });
		
		function guardar_encuesta() {
			var idGrado = $("#txtidgra").val();
			var documento = $("#txtdocumento").val();
			
			//SELECCIÓN MÚLTIPLE
			var encuesta1p1 = $('input:radio[name=encuesta1pregunta1]:checked').val();
			var tipo = $("#tipoencuesta1pregunta1").val();
			var pregunta = $("#preguntaencuesta1pregunta1").val();
			    
			if(encuesta1p1 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta1").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta1');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta1").removeClass('bordeRojo');
			}
			
			var encuesta1p2 = $('input:radio[name=encuesta1pregunta2]:checked').val();
			var tipo = $("#tipoencuesta1pregunta2").val();
			var pregunta = $("#preguntaencuesta1pregunta2").val();
                
			if(encuesta1p2 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta2").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta2');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta2").removeClass('bordeRojo');
			}
			
			var encuesta1p3 = $('input:radio[name=encuesta1pregunta3]:checked').val();
			var tipo = $("#tipoencuesta1pregunta3").val();
			var pregunta = $("#preguntaencuesta1pregunta3").val();
                
			if(encuesta1p3 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta3").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta3');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta3").removeClass('bordeRojo');
			}
			
			var encuesta1p4 = $('input:radio[name=encuesta1pregunta4]:checked').val();
			var tipo = $("#tipoencuesta1pregunta4").val();
			var pregunta = $("#preguntaencuesta1pregunta4").val();
                
			if(encuesta1p4 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta4").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta4');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta4").removeClass('bordeRojo');
			}
			
			var encuesta1p5 = $('input:radio[name=encuesta1pregunta5]:checked').val();
			var tipo = $("#tipoencuesta1pregunta5").val();
			var pregunta = $("#preguntaencuesta1pregunta5").val();
                
			if(encuesta1p5 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta5").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta5');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta5").removeClass('bordeRojo');
			}
			
			var encuesta1p6 = $('input:radio[name=encuesta1pregunta6]:checked').val();
			var tipo = $("#tipoencuesta1pregunta6").val();
			var pregunta = $("#preguntaencuesta1pregunta6").val();
                
			if(encuesta1p6 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta6").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta6');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta6").removeClass('bordeRojo');
			}
			
			var encuesta1p7 = $('input:radio[name=encuesta1pregunta7]:checked').val();
			var tipo = $("#tipoencuesta1pregunta7").val();
			var pregunta = $("#preguntaencuesta1pregunta7").val();
                
			if(encuesta1p7 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta7").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta7');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta7").removeClass('bordeRojo');
			}
			
			var encuesta1p8 = $('input:radio[name=encuesta1pregunta8]:checked').val();
			var tipo = $("#tipoencuesta1pregunta8").val();
			var pregunta = $("#preguntaencuesta1pregunta8").val();
                
			if(encuesta1p8 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta8").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta8');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta8").removeClass('bordeRojo');
			}
			
			var encuesta1p9 = $('input:radio[name=encuesta1pregunta9]:checked').val();
			var tipo = $("#tipoencuesta1pregunta9").val();
			var pregunta = $("#preguntaencuesta1pregunta9").val();
                
			if(encuesta1p9 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta9").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta9');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta9").removeClass('bordeRojo');
			}
			
			var encuesta1p10 = $('input:radio[name=encuesta1pregunta10]:checked').val();
			var tipo = $("#tipoencuesta1pregunta10").val();
			var pregunta = $("#preguntaencuesta1pregunta10").val();
                
			if(encuesta1p10 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta10").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta10');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta10").removeClass('bordeRojo');
			}
			
			var encuesta1p11 = $('input:radio[name=encuesta1pregunta11]:checked').val();
			var tipo = $("#tipoencuesta1pregunta11").val();
			var pregunta = $("#preguntaencuesta1pregunta11").val();
                
			if(encuesta1p11 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta11").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta11');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta11").removeClass('bordeRojo');
			}
			
			var encuesta1p12 = $('input:radio[name=encuesta1pregunta12]:checked').val();
			var tipo = $("#tipoencuesta1pregunta12").val();
			var pregunta = $("#preguntaencuesta1pregunta12").val();
                
			if(encuesta1p12 == undefined) {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta12").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta12');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta12").removeClass('bordeRojo');
			}
			
			//PREGUNTAS ABIERTAS
			var encuesta1p13 = $('.encuesta1pregunta13').val();
			var tipo = $("#tipoencuesta1pregunta13").val();
			var pregunta = $("#preguntaencuesta1pregunta13").val();
                
			if(encuesta1p13 == undefined || encuesta1p13 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta13").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta13');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta13").removeClass('bordeRojo');
			}
			
			var encuesta1p14 = $('.encuesta1pregunta14').val();
			var tipo = $("#tipoencuesta1pregunta14").val();
			var pregunta = $("#preguntaencuesta1pregunta14").val();
                
			if(encuesta1p14 == undefined || encuesta1p14 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta14").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta14');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta14").removeClass('bordeRojo');
			}
			
			var encuesta1p15 = $('.encuesta1pregunta15').val();
			var tipo = $("#tipoencuesta1pregunta15").val();
			var pregunta = $("#preguntaencuesta1pregunta15").val();
                
			if(encuesta1p15 == undefined || encuesta1p15 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta15").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta15');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta15").removeClass('bordeRojo');
			}
			
			var encuesta1p16 = $('.encuesta1pregunta16').val();
			var tipo = $("#tipoencuesta1pregunta16").val();
			var pregunta = $("#preguntaencuesta1pregunta16").val();
                
			if(encuesta1p16 == undefined || encuesta1p16 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta16").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta16');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta16").removeClass('bordeRojo');
			}
			
			var encuesta1p17 = $('.encuesta1pregunta17').val();
			var tipo = $("#tipoencuesta1pregunta17").val();
			var pregunta = $("#preguntaencuesta1pregunta17").val();
                
			if(encuesta1p17 == undefined || encuesta1p17 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta17").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta17');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta17").removeClass('bordeRojo');
			}
			
			var encuesta1p18 = $('.encuesta1pregunta18').val();
			var tipo = $("#tipoencuesta1pregunta18").val();
			var pregunta = $("#preguntaencuesta1pregunta18").val();
                
			if(encuesta1p18 == undefined || encuesta1p18 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta18").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta18');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta18").removeClass('bordeRojo');
			}
			
			var encuesta1p19 = $('.encuesta1pregunta19').val();
			var tipo = $("#tipoencuesta1pregunta19").val();
			var pregunta = $("#preguntaencuesta1pregunta19").val();
                
			if(encuesta1p19 == undefined || encuesta1p19 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta19").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta19');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta19").removeClass('bordeRojo');
			}
			
			var encuesta1p20 = $('.encuesta1pregunta20').val();
			var tipo = $("#tipoencuesta1pregunta20").val();
			var pregunta = $("#preguntaencuesta1pregunta20").val();
                
			if(encuesta1p20 == undefined || encuesta1p20 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta20").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta20');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta20").removeClass('bordeRojo');
			}
			
			var encuesta1p21 = $('.encuesta1pregunta21').val();
			var tipo = $("#tipoencuesta1pregunta21").val();
			var pregunta = $("#preguntaencuesta1pregunta21").val();
                
			if(encuesta1p21 == undefined || encuesta1p21 == "") {
				alert("Se debe seleccionar una opción para la pregunta de " + tipo + ": "  + pregunta);
				$("#encuesta1pregunta21").addClass('bordeRojo');
				$("#link").attr('href','#encuesta1pregunta21');
				$("#link").get(0).click();
				return;
			}
			else {
				$("#encuesta1pregunta21").removeClass('bordeRojo');
			}
			
			var datos = "idGrado=" + idGrado + "&documento=" + documento + "&idEncuesta=" + 1 + 
			"&encuesta1p1=" + encuesta1p1 + "&encuesta1p2=" + encuesta1p2 + "&encuesta1p3=" + encuesta1p3 + 
			"&encuesta1p4=" + encuesta1p4 + "&encuesta1p5=" + encuesta1p5 + "&encuesta1p6=" + encuesta1p6 + 
			"&encuesta1p7=" + encuesta1p7 + "&encuesta1p8=" + encuesta1p8 + "&encuesta1p9=" + encuesta1p9 + 
			"&encuesta1p10=" + encuesta1p10 + "&encuesta1p11=" + encuesta1p11 + "&encuesta1p12=" + encuesta1p12 + 
			"&encuesta1p13=" + encuesta1p13.replaceAll(" ", "_") + "&encuesta1p14=" + encuesta1p14.replaceAll(" ", "_") + "&encuesta1p15=" + encuesta1p15.replaceAll(" ", "_") + 
			"&encuesta1p16=" + encuesta1p16.replaceAll(" ", "_") + "&encuesta1p17=" + encuesta1p17.replaceAll(" ", "_") + "&encuesta1p18=" + encuesta1p18.replaceAll(" ", "_") + 
			"&encuesta1p19=" + encuesta1p19.replaceAll(" ", "_") + "&encuesta1p20=" + encuesta1p20.replaceAll(" ", "_") + "&encuesta1p21=" + encuesta1p21.replaceAll(" ", "_");
			console.log(datos);
			
			$.ajax({
        		type:"POST",
        		url:"encuesta_putdat.php",
        		data:datos,
        		success:function(r) {
					//alert(r);
        		    var res = JSON.parse(r);
					console.log(res.insert);
					if (res.insert == "OK") {
						window.location.href = "certificado_notas.php";
					}
        		}
        	});
		}
    </script>
    
    <style>
        #chartdiv {
          width: 100%;
          height: 295px;
        }
		.bordeRojo {
			background-color: #FF7F7F;
		}
    </style>
</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<?php require 'menu.php';  ?>
		<!--left-fixed -navigation-->
		
		<!-- header-starts -->
		<?php require 'header.php';  ?>
		<!-- //header-ends -->
		
		<!-- modal -->
		<section>
			<?php require 'modal.php';  ?>
		</section>
		<!-- modal -->
		
		<!-- main content start-->
        <section>
        	<div id="page-wrapper">
				<div class="main-page">					
					<div class="tables">
						<div class="panel-body widget-shadow">
							<div class="panel-group" id="accordion">
								<?php //echo $sql_encuesta; ?>
								<center><h2>Para descargar el boletin de calificaciones es necesario responder la siguiente encuesta:</h2></center><br>
								<div class="panel panel-default" style="border: 1px solid blue;">
									<div style="background-color: lightblue;">
										<p style="font-size: 1.5em"><strong>Preguntas de selección múltiple, para que podamos contrastar y nos facilite más la construcción del instrumento final.</strong></p>
									</div>
									<?php
										//echo "id_grado ".$id_grado;
										
										if (!isset($id_grado)) {
											//no hace nada
										}else{
											$encuestaPreguntas = "";
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<tbody>
												';
											while ($row = mysqli_fetch_array($exe_encuesta)) {
												$nombreRadio = 'encuesta'.$row['id_encuesta'].'pregunta'.$row['id'];
												$encuestaPreguntas .= $nombreRadio."|";
												echo '<tr id="'.$nombreRadio.'">
													<td><strong>'.$row['tipo'].'</strong><input type="hidden" id="tipo'.$nombreRadio.'" value="'.$row['tipo'].'"></td>
													<td>'.$row['pregunta'].'<input type="hidden" id="pregunta'.$nombreRadio.'" value="'.$row['pregunta'].'">
														<input type="hidden" id="'.$row['id'].'" value="'.$row['id'].'">
													</td>';
												if ($row['e'] == "NO") {
													echo '<td>
															<ul style="list-style: none;">
																<li><label><input type="radio" name="'.$nombreRadio.'" id="a" value="A"> A. '.$row['a'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="b" value="B"> B. '.$row['b'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="c" value="C"> C. '.$row['c'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="d" value="D"> D. '.$row['d'].'</label></li>
															</ul>
														</td></tr>';
												}
												else {
													echo '<td>
															<ul style="list-style: none;">
																<li><label><input type="radio" name="'.$nombreRadio.'" id="a" value="A"> A. '.$row['a'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="b" value="B"> B. '.$row['b'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="c" value="C"> C. '.$row['c'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="d" value="D"> D. '.$row['d'].'</label></li>
																<li><label><input type="radio" name="'.$nombreRadio.'" id="e" value="E"> E. '.$row['e'].'</label></li>
															</ul>
														</td></tr>';
												}
											}											
											echo "</tbody> 
												</table>";
											
										}
									?>
								</div>
								<br/>
								
								<div class="panel panel-default" style="border: 1px solid green;">
									<div style="background-color: lightgreen;">
										<p style="font-size: 1.5em"><strong>Algunas preguntas abiertas que permiten a los padres expresar sus opiniones y percepciones detalladamente.</strong></p>
									</div>
									<?php
										if (!isset($n_documento)) {
											//no hace nada
										}else{
											echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
													<tbody>
												';
											while ($row = mysqli_fetch_array($exe_encuesta1)) {
												$nombreInputRT = 'encuesta'.$row['id_encuesta'].'pregunta'.$row['id'];
												$encuestaPreguntasRT .= $nombreInputRT."|";
												//Los input hidden con id tipo... y pregunta... se utilizan para tener el texto del tipo y pregunta para utilizarlos en los alert
												echo '<tr id="'.$nombreInputRT.'">
														<td><strong>'.$row['tipo'].'</strong><input type="hidden" id="tipo'.$nombreInputRT.'" value="'.$row['tipo'].'">
														</td>
														<td>'.$row['pregunta'].'<input type="hidden" id="pregunta'.$nombreInputRT.'" value="'.$row['pregunta'].'">
															<br><br><textarea name="'.$nombreInputRT.'" rows="3" cols="100" class="form-control '.$nombreInputRT.'" maxlength="2000"></textarea>
															<input type="hidden" id="'.$row['id'].'" value="'.$row['id'].'">
														</td>
													</tr>';
											}											
											echo "</tbody> 
												</table>";
											
										}
									?>
								</div>
								<br/>
							
							</div>
							
							<input type="hidden" id="txtidest" value="<?php echo $id; ?>"/>
							<input type="hidden" id="txtidgra" value="<?php echo $id_grado; ?>"/>
							<input type="hidden" id="txtdocumento" value="<?php echo $n_documento; ?>"/>
							<input type="hidden" id="txtEncuestasPreguntasSM" value="<?php echo $encuestaPreguntas; ?>"/>
							<input type="hidden" id="txtEncuestasPreguntasRT" value="<?php echo $encuestaPreguntasRT; ?>"/>
							<a href="" id="link"></a>
							<button class="btn btn-primary" onclick="guardar_encuesta();">Guardar Encuesta</button>
						</div>
					</div>
				</div>
			</div>
		</section>
	<!--footer-->
	<?php require 'footer.php'; ?>
    <!--//footer-->
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
</body>
<?php 
}else if (isset($_SESSION['unisuper'])) {
	echo "<script>location.href='../adminunicab/index.php'</script>";
}else if(isset($_SESSION['uniprofe'])) {
	echo "<script>location.href='../docenteunicab/index.php'</script>";
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='login.php'</script>";
}
?>
</html>