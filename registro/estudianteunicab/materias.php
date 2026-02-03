<?php 
	session_start();
	Include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniestudiante'])) {
		$sql="SELECT * FROM estudiantes WHERE email_institucional='".$_SESSION['uniestudiante']."'";
		$res=mysqli_query($conexion,$sql);

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
    INNER JOIN estudiantes on matricula.id_estudiante=estudiantes.id where estudiantes.id=".$id." and matricula.estado='activo'";
	$exe_buscar=mysqli_query($conexion,$buscar_grado);
	while ($buscar=mysqli_fetch_array($exe_buscar)) {
		$id_grado=$buscar['id_grado'];
		$nombre_grado=strtoupper($buscar['grado']);
	}
	/*$sqlNotas="SELECT DISTINCT grados.grado, materias.materia, materias.pensamiento, profesores.apellidos, profesores.nombres, estudiantes.id, matricula.estado 
	FROM materias INNER JOIN ((grados INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) 
	ON grados.id = matricula.id_grado) INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) 
	ON grados.id = carga_profesor.id_grado) ON materias.Id = carga_profesor.id_materia 
	WHERE estudiantes.id='".$id."' and matricula.estado='activo' 
	ORDER BY materias.pensamiento asc";
	$consultaNotas=mysqli_query($conexion,$sqlNotas);*/
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
            
        function ver_cal_mood() {
            alert("hola");
            var value=$("#txtidest").val();
        	var value1=$("#txtidgra").val();
        	//alert(id_est + id_gra);
            
            /*$.ajax({
        		type:"POST",
        		url:"../docenteunicab/updreg/buscar_notas_mood.php",
        		data:"idest_ra1=" + value + "&idgra_ra1=" + value1,
        		success:function(r) {
        		    //Esto es para mostrar la tabla con las notas moodle
        			var res = JSON.parse(r);
        			console.log(res);
        			var lineas = res.tabla.lineas;
        			//console.log(lineas);
        			//$("#tablam").html(lineas.length);
        			for(var i = 0; i < lineas.length; i++) {
        			    var idestm = lineas[i].id_est;
        			    var lastn = lineas[i].lastname;
        			    var firstn = lineas[i].firstname;
        			    var shortn = lineas[i].shortname;
        			    var pen = lineas[i].pensamiento;
        			    var idnumber = lineas[i].idnumber;
        			    var per = lineas[i].periodo;
        			    var cal = lineas[i].calificacion;
        		    }
        		}
        	});*/
        }
    </script>
    
    <style>
        #chartdiv {
          width: 100%;
          height: 295px;
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
							<div class="panel panel-default">
							<br>
							<?php
								$varialble_nota=0;
								//Las siguientes líneas se agregaron para corregir lógica de programación
								$materia = "";
								$materia1 = "";
								$registros = 1;
								$nota_uno = 0;
								$nota_dos = 0;
								$nota_tres = 0;
								$nota_cuatro = 0;
								//Fin líneas de corrección.
								
								if (!isset($id_grado)) {
									echo '<div class="alert alert-danger" role="alert">
  										<strong>¡Alerta!</strong> El estudiante no se encuentra matriculado.
									</div>';
								}else{
									$sql_no="SELECT DISTINCT estudiantes.id as id_estudiante, materias.materia, materias.pensamiento, grados.id as id_grado, grados.grado, notas.nota, periodos.id as id_periodo 
									FROM ((((notas INNER JOIN estudiantes on notas.id_estudiante=estudiantes.id) INNER JOIN materias on notas.id_materia=materias.Id) 
									INNER JOIN grados on notas.id_grado=grados.id) INNER JOIN periodos on notas.id_periodo=periodos.id) 
									WHERE estudiantes.id=".$id." and grados.id=".$id_grado." 
									ORDER BY materias.materia ASC, periodos.id ASC";
									//echo $sql_no;
    								$exe_no=mysqli_query($conexion,$sql_no);
    								$tot_notas=mysqli_num_rows($exe_no);
    								
    								echo '<table class="table table-hover" border="1" bordercolor="#e0e0e0">
											<thead > 
												<tr>
												<TH COLSPAN=2><center><strong>ASIGNATURAS INSCRITAS GRADO '.$nombre_grado.'</strong></center></TH>
												<TH COLSPAN=4><center><strong>NOTAS DEFINITIVAS POR PERIODOS</strong></center></TH>
												</tr>';
    								if ($id_grado>=17	) {
    									echo '<tr>
    										<th><center>Materia</center></th>
    										<th><center>Pesamiento</center></th>
    										<th><center>Nº 1</center></th>
    										<th><center>Nº 2</center></th>
    										</tr> 
    										</thead> 
    										<tbody>
    									';
    								}else{
    									echo '<tr>
    										<th><center>Materia</center></th>
    										<th><center>Pesamiento</center></th>
    										<th><center>Nº 1</center></th>
    										<th><center>Nº 2</center></th>
    										<th><center>Nº 3</center></th>
    										<th><center>Nº 4</center></th>
    										</tr> 
    										</thead> 
    										<tbody>
    									';
    								}
    								while ($row=mysqli_fetch_array($exe_no)) {
    								    //Las siguientes líneas se agregaron para corregir lógica de programación
    								    $materia1 = $row['materia'];
    								    if($materia <> $materia1) {
    								        
    								        if($registros > 1) {
            								    //echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td>";
            								    echo "<tr><td>".$m_ant."</td><td>".$p_ant."</td>";
            								    if ($row['id_grado']>=17) {
            								        echo "<td>".$nota_uno."</td><td>".$nota_dos."</td></tr>";
            								    }
            								    else {
            								        echo "<td>".$nota_uno."</td><td>".$nota_dos."</td><td>".$nota_tres."</td><td>".$nota_cuatro."</td></tr>";
            								    }
            								}
            								$registros = 1;
            								$nota_uno = 0;
            								$nota_dos = 0;
            								$nota_tres = 0;
            								$nota_cuatro = 0;
            								
    								    }
    								    $p_ant = $row['pensamiento'];
    								    $m_ant = $row['materia'];
    								    //Fin líneas de corrección.
    								    
    									if ($row['id_grado']>=17) {
    										if ($row['id_periodo']==1) {
    											$nota_uno=$row['nota'];
    											//echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$nota_uno."</td>";
    											//echo "<td>".$nota_uno."</td>";
    										}
    										if ($row['id_periodo']==2) {
    											$nota_dos=$row['nota'];
    											//echo "<td>".$nota_dos."</td></tr>";
    										}
    									}else{
    										if ($row['id_periodo']==1) {
    											$nota_uno=$row['nota'];
    											//echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td><td>".$nota_uno."</td>";
    											//echo "<td>".$nota_uno."</td>";
    										}
    										if ($row['id_periodo']==2) {
    											$nota_dos=$row['nota'];
    											//echo "<td>".$nota_dos."</td>";
    										}
    										if ($row['id_periodo']==3) {
    											$nota_tres=$row['nota'];
    											//echo "<td>".$nota_tres."</td>";
    										}
    										if ($row['id_periodo']==4) {
    											$nota_cuatro=$row['nota'];
    											//echo "<td>".$nota_cuatro."</td></tr>";
    										}
    									}
    									//Las siguientes líneas se agregaron para corregir lógica de programación
    									$registros++;
    									if ($registros > 1) {
    									    $materia = $materia1;
    									}
    									//Fin líneas de corrección.
    								}
    								
    								//Las siguientes líneas se agregaron para corregir lógica de programación
    								if($registros > 1) {
    								    //echo "<tr><td>".$row['materia']."</td><td>".$row['pensamiento']."</td>";
    								    echo "<tr><td>".$m_ant."</td><td>".$p_ant."</td>";
    								    if ($row['id_grado']>=17) {
    								        echo "<td>".$nota_uno."</td><td>".$nota_dos."</td></tr>";
    								    }
    								    else {
    								        echo "<td>".$nota_uno."</td><td>".$nota_dos."</td><td>".$nota_tres."</td><td>".$nota_cuatro."</td></tr>";
    								    }
    								}
    								//Fin líneas de corrección.
    								
    								echo "</tbody> 
    									</table>";
									
								}
							?>
						</div><br/>
						<button id="btnupd" onclick="ver_cal_mood();" class="btn btn-primary" style="display: none;">Actualizar Calificaciones</button>
						<label id="lblupd"><span style="color: red;">NOTA: </span>Estas calificaciones no se actualizan automáticamente. Las calificaciones se actualizan en cada cierre de periodo. 
						O puedes dirigirte al tutor encargado del pensamiento para solicitarle que actualice tus calificaciones en registro.</label>
						<input type="hidden" id="txtidest" value="<?php echo $id; ?>"/><input type="hidden" id="txtidgra" value="<?php echo $id_grado; ?>"/>
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