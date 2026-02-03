<?php
session_start();
require "php/conexion.php";
require("../docenteunicab/updreg/1cc3s4db.php");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");

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
    
	$peticion = "SELECT er.*, ep.pregunta, ep.tipo, g.grado, CONCAT(e.nombres, ' ', e.apellidos) nombre,
	CASE er.resultado WHEN 'A' THEN ep.a WHEN 'B' THEN ep.b WHEN 'C' THEN ep.c WHEN 'D' THEN ep.d WHEN 'E' THEN ep.e ELSE er.resultado END resultado1
	FROM tbl_encuestas_resultados er, tbl_encuestas_preguntas ep, grados g, estudiantes e  
	WHERE er.id_pregunta = ep.id AND er.id_encuesta = ep.id_encuesta AND er.id_grado = g.id AND er.n_documento = e.n_documento
	AND er.id_encuesta = 1 
	ORDER BY er.id_grado, er.n_documento, er.id_pregunta";
	//$resultado = mysqli_query($conexion, $peticion);
	$resultado = $mysqli1->query($peticion);
	
	$query = "SELECT * FROM grados WHERE id > 1 AND id < 19";
	//$grados = mysqli_query($conexion, $query);
	$grados = $mysqli1->query($query);
	
	$sql_preg = "SELECT * FROM tbl_encuestas_preguntas WHERE id_encuesta = 1";
	//$grados = mysqli_query($conexion, $query);
	$preguntas = $mysqli1->query($sql_preg);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Unicab Registro Académico</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />

<!-- Custom CSS -->
<link href="../css/style.css" rel='stylesheet' type='text/css' />

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
<script type="text/javascript" src="../docenteunicab/updreg/js/Chart.bundle.min.js"></script>

<!--webfonts-->
<link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
<!--//webfonts--> 

<!-- Metis Menu -->
<script src="../js/metisMenu.min.js"></script>
<script src="../js/custom.js"></script>
<link href="../css/custom.css" rel="stylesheet">
<!--//Metis Menu -->
<style>
    #chartdiv {
      width: 100%;
      height: 295px;
    }
    .activo {
        color: green;
    }
    .inactivo {
        color: orange;
    }
    .retirado {
        color: red;
    }
</style>

<script>
	//(1)
	function buscar_estadistica() {
		var idGrado = $("#selgra1").val();
		var idPreg = $("#selpreg1").val();
		
		if (idPreg == "NA") {
			alert("Debe seleccionar una pregunta");
			return;
		}
		//alert(id_est + id_gra);
		$.ajax({
			type:"POST",
			url:"resultado_encuesta_estadistica.php",
			data:"idgra=" + idGrado + "&idpreg=" + idPreg,
			success:function(r) {
				mostrar_estadistica(r, idPreg);
			}
		});
	}
	
	//*******************************************************************************
	//(2)
	function mostrar_estadistica(data, idPreg) {
		var res = JSON.parse(data);
		if(res.lbls.length == 4) {
			/*if(vper == "1") {
				var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])))/1).toFixed(1);
			}
			else if(vper == "2") {
				var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])))/2).toFixed(1);
			}
			else if(vper == "3") {
				var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])))/3).toFixed(1);
			}
			else {
				var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])) + isnanc(parseFloat(res.p4[3])))/4).toFixed(1);
			}*/
			var datos = {
				labels : [res.lbls[0], res.lbls[1], res.lbls[2], res.lbls[3], "."],
				datasets : [
					{label : "Pregunta " + idPreg, backgroundColor : "rgba(249,255,51,0.9)", data : [res.cantidades[0], res.cantidades[1], res.cantidades[2], res.cantidades[3], 0], order: 1},
					/*{label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],res.p2[3],0], order: 1},
					{label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],res.p3[3],0], order: 1},
					{label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],res.p4[3],0], order: 1},
					{label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2,cf3], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
					{label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}*/
				]
			};
		}
		else if(res.lbls.length == 5) {
			/*if(vper == "1") {
				var cf0 = ((isnanc(parseFloat(res.p1[0])))/1).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])))/1).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])))/1).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])))/1).toFixed(1);
				var cf4 = ((isnanc(parseFloat(res.p1[4])))/1).toFixed(1);
			}
			else if(vper == "2") {
				var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])))/2).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])))/2).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])))/2).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])))/2).toFixed(1);
				var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])))/2).toFixed(1);
			}
			else if(vper == "3") {
				var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])))/3).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])))/3).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])))/3).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])))/3).toFixed(1);
				var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])))/3).toFixed(1);
			}
			else {
				var cf0 = ((isnanc(parseFloat(res.p1[0])) + isnanc(parseFloat(res.p2[0])) + isnanc(parseFloat(res.p3[0])) + isnanc(parseFloat(res.p4[0])))/4).toFixed(1);
				var cf1 = ((isnanc(parseFloat(res.p1[1])) + isnanc(parseFloat(res.p2[1])) + isnanc(parseFloat(res.p3[1])) + isnanc(parseFloat(res.p4[1])))/4).toFixed(1);
				var cf2 = ((isnanc(parseFloat(res.p1[2])) + isnanc(parseFloat(res.p2[2])) + isnanc(parseFloat(res.p3[2])) + isnanc(parseFloat(res.p4[2])))/4).toFixed(1);
				var cf3 = ((isnanc(parseFloat(res.p1[3])) + isnanc(parseFloat(res.p2[3])) + isnanc(parseFloat(res.p3[3])) + isnanc(parseFloat(res.p4[3])))/4).toFixed(1);
				var cf4 = ((isnanc(parseFloat(res.p1[4])) + isnanc(parseFloat(res.p2[4])) + isnanc(parseFloat(res.p3[4])) + isnanc(parseFloat(res.p4[4])))/4).toFixed(1);
			}*/
			var datos = {
				labels : [res.lbls[0], res.lbls[1], res.lbls[2], res.lbls[3], res.lbls[4], "."],
				datasets : [
					{label : "Pregunta " + idPreg, backgroundColor : "rgba(249,255,51,0.9)", data : [res.cantidades[0], res.cantidades[1], res.cantidades[2], res.cantidades[3], res.cantidades[4], 0], order: 1},
					/*{label : "P2", backgroundColor : "rgba(151,187,205,0.9)", data : [res.p2[0],res.p2[1],res.p2[2],res.p2[3],res.p2[4],0], order: 1},
					{label : "P3", backgroundColor : "rgba(239,152,60,0.9)", data : [res.p3[0],res.p3[1],res.p3[2],res.p3[3],res.p3[4],0], order: 1},
					{label : "P4", backgroundColor : "rgba(150,85,244,0.9)", data : [res.p4[0],res.p4[1],res.p4[2],res.p4[3],res.p4[4],0], order: 1},
					{label : "Cal. Final", backgroundColor : "#000000", data : [cf0,cf1,cf2,cf3,cf4], type: 'line', fill : false, pointRadius: 5, showLine: false, borderColor : "#000000", order: 0},
					{label : "Cal. Min.", backgroundColor : "rgba(255,0,0,0.9)", data : [3,3,3,3,3,3], type: 'line', fill : false, borderColor : "#FF0000", order: 3}*/
				]
			};
		}
		
		//Se borra la etiqueta canvas
		$("#grafico").remove();
		//Se genera un nuevo canvas
		$("#divcanvas").append('<canvas id="grafico" width="800" height="200"></canvas>');
		
		var canvas = document.getElementById("grafico").getContext("2d");
		window.bar = new Chart(canvas, {
			type : "bar",
			data : datos,
			options : {
				elements : {
					rectangle : {
						borderWidth : 1, 
						borderColor : "gray", 
						borderSkipped : "bottom",
						width : 5
					}
				},
				responsive : true,
				showTooltips: false,
				title : {
					display : true,
					text : res.pregunta,
					fontSize : 14
				}
			}
		});
	}
	//******************************************************************************
</script>

</head> 
<body class="cbp-spmenu-push">
	<div class="main-content">
		<label><?php //echo $perfil; ?></label>
		<?php 
		    if($perfil == "SU" || $perfil == "AR" || $perfil == "AR_AW") {				
		        require 'menu_registro.php';
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
		
		<!-- main content start-->
        <section>
           	<div id="page-wrapper">
           		<div class="forms">
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
							<h4>RESULTADO ENCUESTA BIMESTRE 4 2024:</h4>
						</div>
						<div class="form-body">  
							<?php //echo $peticion; ?>
					    	<table id="listEstudiantes" class="display" style="width:100%">
						        <thead>
						            <tr>
						                <th>Grado</th>
	                                    <th>Documento</th>						                
						                <th>Nombre</th>
										<th>Tipo Pregunta</th>
						                <th>Pregunta</th>
						                <th>Resultado</th>
										<th>Año</th>
						            </tr>
						        </thead>
						        <tbody>
						        	<?php 
										//while ($fila = mysqli_fetch_array($resultado)){
										while ($fila = $resultado->fetch_assoc()){
											echo"<tr><td>".$fila['grado']."</td>
												<td>".$fila['n_documento']."</td>
												<td>".$fila['nombre']."</td>
												<td>".$fila['tipo']."</td>
												<td>".$fila['pregunta']."</td>
												<td>".$fila['resultado1']."</td>
												<td>".$fila['año']."</td>
												</tr>";
										}
						        	?>
						        </tbody>
					    	</table>
                   		</div>
						
						<div class="form-title">
							<h4>VER ESTADISTICAS POR PREGUNTA Y GRADO</h4>
						</div><br>
						<div class="row">  
							<div class="col-sm-6">
								<select id="selgra1" name="selgra1" class="form-control">
									<option value="NA">Seleccione grado</option>
									<?php 
										while($row_grados = $grados->fetch_assoc()){
											echo "<option value='".$row_grados['id']."'>".$row_grados['grado']."</option>";
										}
									?>
								</select>
							</div>
							<div class="col-sm-6">
								<select id="selpreg1" name="selpreg1" class="form-control">
									<option value="NA">Seleccione pregunta</option>
									<?php 
										while($row_preg = $preguntas->fetch_assoc()){
											echo "<option value='".$row_preg['id']."'>".$row_preg['id']." - ".$row_preg['pregunta']."</option>";
										}
									?>
								</select>
							</div>
                   		</div>
						
						<div class="row">  
							<div class="col-sm-6">
								<button class="btn btn-primary" onclick="buscar_estadistica();">Ver Estadística</button>
							</div>
                   		</div>
						
						<div class="row">  
							<div class="col-sm-12">
								<div id="divcanvas" style="display: block;">
									<canvas id="grafico" width="800" height="200"></canvas>
								</div>
							</div>
                   		</div>
						
						<div class="row">
							<div class="col-sm-12">
								<form class="form-horizontal" action="bd_exportar_encuesta.php"  method="POST" target="_blank">
									<input type="submit" class="btn btn-primary" value="Exportar Estadísticas" >
								</form>
							</div>
						</div>
              		 </div>
            	</div>
           </div>
		</section>
	</div>
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
</body>
<?php 
}
else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>