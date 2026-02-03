<?php 
session_start();
include "../adminunicab/php/conexion.php";
	if (isset($_SESSION['uniprofe'])) {
		$sql="SELECT * FROM profesores WHERE email_institucional='".$_SESSION['uniprofe']."'";
		$res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
                      
	  	$id = $fila['id'];
		$apellidos = $fila['apellidos'];
		$nombres = $fila['nombres'];
		$email_institucional = $fila['email_institucional'];
		$director=$fila['d_pensamiento'];
		$n_documento = $fila['n_documento'];
		$password = $fila['password'];
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
#chartdiv {
  width: 100%;
  height: 295px;
}
</style>

<script type="text/javascript">
	function back_form(){
		window.location.hash="no-back-button";
		window.location.hash="Again-No-back-button"
		window.onhashchange=function(){
            window.location.hash="form-bloq";
        }
	}	
</script>

</head> 
<body class="cbp-spmenu-push" onload="back_form();">
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
					<form class="form-horizontal" action="../adminunicab/php/RegistroCalificaciones.php" method="POST">
					<div class="panel-body widget-shadow">
						<div class="panel-group" id="accordion">
							<?php
							$grado=$_POST['id_grado'];
							$materia=$_POST['id_materia'];

							$sqlgrado="SELECT * FROM grados WHERE id='".$grado."'";
							$consultagrado=mysqli_query($conexion,$sqlgrado);
								while ($fila = mysqli_fetch_array($consultagrado)){
										$idg = $fila['id'];
										$gradob = $fila['grado'];
								}

							$sqlmateria="SELECT * FROM materias WHERE Id='".$materia."'";
							$consultamateria=mysqli_query($conexion,$sqlmateria);
								while ($fila = mysqli_fetch_array($consultamateria)){
								  	$idb = $fila['Id'];
									$materiab = $fila['materia'];
									$pensa=$fila['pensamiento'];
								}

							if ($idg>=2 && $idg<=16) {
								$totalPeriodos=4;
							}else{
								$totalPeriodos=2;
							}

							$auto=0;
							$buscar_estudiantes="SELECT DISTINCT estudiantes.id AS id_estudiante, estudiantes.apellidos, estudiantes.nombres, grados.id AS id_grado, grados.grado, materias.Id AS id_materia, materias.materia, matricula.idMatricula, matricula.estado FROM (grados INNER JOIN (materias INNER JOIN carga_profesor ON materias.Id = carga_profesor.id_materia) ON grados.id = carga_profesor.id_grado) INNER JOIN (estudiantes INNER JOIN matricula ON estudiantes.id = matricula.id_estudiante) ON grados.id = matricula.id_grado where grados.id=".$grado." and materias.Id=".$materia."  and matricula.estado='activo' ORDER BY apellidos ASC";
							$exe_estudiante=mysqli_query($conexion,$buscar_estudiantes);
								if ($idg>=13) {
									
								}else{
									if ($idb==7) {
									}
									else if ($pensa=="HUMANÍSTICO" && $idg<=12) {
										echo '<div class="alert alert-info" role="alert">
					 					El director del pensamiento <strong>'.$pensa.'</strong> es el encargado de subir las notas.
										</div>';
									}else if ($pensa=="BIOETICO" && $idg<=12) {
										echo '<div class="alert alert-info" role="alert">
					 					El director del pensamiento <strong>'.$pensa.'</strong> es el encargado de subir las notas.
										</div>';
									}
								}
							?>
							<div class="panel panel-default">
								<table class="table table-hover" border="1" bordercolor="#e0e0e0">
									<thead > 
										<tr bordercolor="#e0e0e0">
											<TH COLSPAN=1><center><strong>MATERIA: <?php echo $materiab.' - GRADO: '.strtoupper($gradob);  ?></strong></center>
											</TH>
											<TH COLSPAN=<?php echo $totalPeriodos; ?>><center><strong>NOTAS DEFINITIVAS POR PERIODO</strong></center>
											</TH>
										</tr>
										<tr>
											<th>
												<center>APELLIDOS Y NOMBRES</center>
											</th>
											<?php 
												for ($i=1; $i <=$totalPeriodos ; $i++) { 
													echo "<th><center>N°".$i."</center></th>";	
												}
											?>
										</tr> 
									</thead> 
									<tbody>
										<?php 
											while ($fila=mysqli_fetch_array($exe_estudiante)) {
												$auto++;
												echo "<input type='hidden' name='id_estudiante".$auto."' id='id_estudiante".$auto."' value='".$fila['id_estudiante']."'>";
												echo "<tr>
													<td scope='row'>".$fila["apellidos"]." ".$fila["nombres"]."</td>";
												//estudiantes normales
												if ($idg>=1 && $idg<=12) {
													$contador=0;
													for ($i=1; $i <=$totalPeriodos ; $i++) { 
														$contador++;
														$sql="sql_".$contador;
														$sql="SELECT DISTINCT estudiantes.id AS id_estudiante, estudiantes.apellidos, estudiantes.nombres, grados.id AS id_grados, grados.grado, materias.Id AS id_materias, materias.materia, notas.id AS id_notas, notas.nota, periodos.id, matricula.idMatricula, matricula.estado FROM materias INNER JOIN ((estudiantes INNER JOIN (grados INNER JOIN matricula ON grados.id = matricula.id_grado) ON estudiantes.id = matricula.id_estudiante) INNER JOIN (periodos INNER JOIN notas ON periodos.id = notas.id_periodo) ON estudiantes.id = notas.id_estudiante) ON materias.Id = notas.id_materia where estudiantes.id=".$fila['id_estudiante']." and grados.id=".$fila['id_grado']." and materias.Id=".$fila['id_materia']." and periodos.id=".$i." and matricula.estado='activo' ";
														$exe="exe_".$contador;
														$exe=mysqli_query($conexion,$sql);
														$cont="cont_".$contador;
														$cont=mysqli_num_rows($exe);
														$a=$auto."_".$i;
														if ($cont>0) {
															$row="row".$contador;
															while ($row=mysqli_fetch_array($exe)) {
																echo "<td>";
																echo "<select id='nota".$a."' name='nota".$a."''>
											        				<option value=".$row['nota'].">".$row['nota']."</option
											        				<option value='0.0'>0.0</option>
											        				<option value='0.1'>0.1</option>
													                <option value='0.2'>0.2</option>
													                <option value='0.3'>0.3</option>
													                <option value='0.4'>0.4</option>
													                <option value='0.5'>0.5</option>
													                <option value='0.6'>0.6</option>
													                <option value='0.7'>0.7</option>
													                <option value='0.8'>0.8</option>
													                <option value='0.9'>0.9</option>
													                <option value='1.0'>1.0</option>
													                <option value='1.1'>1.1</option>
													                <option value='1.2'>1.2</option>
													                <option value='1.3'>1.3</option>
													                <option value='1.4'>1.4</option>
													                <option value='1.5'>1.5</option>
													                <option value='1.6'>1.6</option>
													                <option value='1.7'>1.7</option>
													                <option value='1.8'>1.8</option>
													                <option value='1.9'>1.9</option>
													                <option value='2.0'>2.0</option>
													                <option value='2.1'>2.1</option>
													                <option value='2.2'>2.2</option>
													                <option value='2.3'>2.3</option>
													                <option value='2.4'>2.4</option>
													                <option value='2.5'>2.5</option>
													                <option value='2.6'>2.6</option>
													                <option value='2.7'>2.7</option>
													                <option value='2.8'>2.8</option>
													                <option value='2.9'>2.9</option>
													                <option value='3.0'>3.0</option>
													                <option value='3.1'>3.1</option>
													                <option value='3.2'>3.2</option>
													                <option value='3.3'>3.3</option>
													                <option value='3.4'>3.4</option>
													                <option value='3.5'>3.5</option>
													                <option value='3.6'>3.6</option>
													                <option value='3.7'>3.7</option>
													                <option value='3.8'>3.8</option>
													                <option value='3.9'>3.9</option>
													                <option value='4.0'>4.0</option>
													                <option value='4.1'>4.1</option>
													                <option value='4.2'>4.2</option>
													                <option value='4.3'>4.3</option>
													                <option value='4.4'>4.4</option>
													                <option value='4.5'>4.5</option>
													                <option value='4.6'>4.6</option>
													                <option value='4.7'>4.7</option>
													                <option value='4.8'>4.8</option>
													                <option value='4.9'>4.9</option>
													                <option value='5.0'>5.0</option>
						              							</select></td>";
															}
														}else{
															// sin notas
															echo "<td><select id='nota".$a."' name='nota".$a."''>
										        				<option value='0.0'>0.0</option>
												                <option value='0.1'>0.1</option>
												                <option value='0.2'>0.2</option>
												                <option value='0.3'>0.3</option>
												                <option value='0.4'>0.4</option>
												                <option value='0.5'>0.5</option>
												                <option value='0.6'>0.6</option>
												                <option value='0.7'>0.7</option>
												                <option value='0.8'>0.8</option>
												                <option value='0.9'>0.9</option>
												                <option value='1.0'>1.0</option>
												                <option value='1.1'>1.1</option>
												                <option value='1.2'>1.2</option>
												                <option value='1.3'>1.3</option>
												                <option value='1.4'>1.4</option>
												                <option value='1.5'>1.5</option>
												                <option value='1.6'>1.6</option>
												                <option value='1.7'>1.7</option>
												                <option value='1.8'>1.8</option>
												                <option value='1.9'>1.9</option>
												                <option value='2.0'>2.0</option>
												                <option value='2.1'>2.1</option>
												                <option value='2.2'>2.2</option>
												                <option value='2.3'>2.3</option>
												                <option value='2.4'>2.4</option>
												                <option value='2.5'>2.5</option>
												                <option value='2.6'>2.6</option>
												                <option value='2.7'>2.7</option>
												                <option value='2.8'>2.8</option>
												                <option value='2.9'>2.9</option>
												                <option value='3.0'>3.0</option>
												                <option value='3.1'>3.1</option>
												                <option value='3.2'>3.2</option>
												                <option value='3.3'>3.3</option>
												                <option value='3.4'>3.4</option>
												                <option value='3.5'>3.5</option>
												                <option value='3.6'>3.6</option>
												                <option value='3.7'>3.7</option>
												                <option value='3.8'>3.8</option>
												                <option value='3.9'>3.9</option>
												                <option value='4.0'>4.0</option>
												                <option value='4.1'>4.1</option>
												                <option value='4.2'>4.2</option>
												                <option value='4.3'>4.3</option>
												                <option value='4.4'>4.4</option>
												                <option value='4.5'>4.5</option>
												                <option value='4.6'>4.6</option>
												                <option value='4.7'>4.7</option>
												                <option value='4.8'>4.8</option>
												                <option value='4.9'>4.9</option>
												                <option value='5.0'>5.0</option>
							              					</select></td>";
															// fin sin notas
														}
													}
												//fin estudiantes normales
												}else{
													//estudiantes ciclos
													//estudiantes con notas
													$contador=0;
													for ($i=1; $i <=$totalPeriodos ; $i++) { 
														$a=$auto."_".$i;
														$contador++;
														$sql="sql_".$contador;
														$sql="SELECT DISTINCT estudiantes.id AS id_estudiante, estudiantes.apellidos, estudiantes.nombres, grados.id AS id_grados, grados.grado, materias.Id AS id_materias, materias.materia, notas.id AS id_notas, notas.nota, periodos.id, matricula.idMatricula, matricula.estado FROM materias INNER JOIN ((estudiantes INNER JOIN (grados INNER JOIN matricula ON grados.id = matricula.id_grado) ON estudiantes.id = matricula.id_estudiante) INNER JOIN (periodos INNER JOIN notas ON periodos.id = notas.id_periodo) ON estudiantes.id = notas.id_estudiante) ON materias.Id = notas.id_materia where estudiantes.id=".$fila['id_estudiante']." and grados.id=".$fila['id_grado']." and materias.Id=".$fila['id_materia']." and periodos.id=".$i." and matricula.estado='activo' ORDER BY apellidos ASC";
														$exe="exe_".$contador;
														$exe=mysqli_query($conexion,$sql);
														$cont="cont_".$contador;
														$cont=mysqli_num_rows($exe);
														if ($cont>0) {
															$row="row".$contador;
															echo "<td>";
															while ($row=mysqli_fetch_array($exe)) {
																echo "<select id='nota".$a."' name='nota".$a."''>
											        				<option value=".$row['nota'].">".$row['nota']."</option
											        				<option value='0.0'>0.0</option>
											        				<option value='0.1'>0.1</option>
													                <option value='0.2'>0.2</option>
													                <option value='0.3'>0.3</option>
													                <option value='0.4'>0.4</option>
													                <option value='0.5'>0.5</option>
													                <option value='0.6'>0.6</option>
													                <option value='0.7'>0.7</option>
													                <option value='0.8'>0.8</option>
													                <option value='0.9'>0.9</option>
													                <option value='1.0'>1.0</option>
													                <option value='1.1'>1.1</option>
													                <option value='1.2'>1.2</option>
													                <option value='1.3'>1.3</option>
													                <option value='1.4'>1.4</option>
													                <option value='1.5'>1.5</option>
													                <option value='1.6'>1.6</option>
													                <option value='1.7'>1.7</option>
													                <option value='1.8'>1.8</option>
													                <option value='1.9'>1.9</option>
													                <option value='2.0'>2.0</option>
													                <option value='2.1'>2.1</option>
													                <option value='2.2'>2.2</option>
													                <option value='2.3'>2.3</option>
													                <option value='2.4'>2.4</option>
													                <option value='2.5'>2.5</option>
													                <option value='2.6'>2.6</option>
													                <option value='2.7'>2.7</option>
													                <option value='2.8'>2.8</option>
													                <option value='2.9'>2.9</option>
													                <option value='3.0'>3.0</option>
													                <option value='3.1'>3.1</option>
													                <option value='3.2'>3.2</option>
													                <option value='3.3'>3.3</option>
													                <option value='3.4'>3.4</option>
													                <option value='3.5'>3.5</option>
													                <option value='3.6'>3.6</option>
													                <option value='3.7'>3.7</option>
													                <option value='3.8'>3.8</option>
													                <option value='3.9'>3.9</option>
													                <option value='4.0'>4.0</option>
													                <option value='4.1'>4.1</option>
													                <option value='4.2'>4.2</option>
													                <option value='4.3'>4.3</option>
													                <option value='4.4'>4.4</option>
													                <option value='4.5'>4.5</option>
													                <option value='4.6'>4.6</option>
													                <option value='4.7'>4.7</option>
													                <option value='4.8'>4.8</option>
													                <option value='4.9'>4.9</option>
													                <option value='5.0'>5.0</option>
						              							</select>";
															}
														}else{
															// sin notas
															echo "<td><select id='nota".$a."' name='nota".$a."''>
										        				<option value='0.0'>0.0</option>
												                <option value='0.1'>0.1</option>
												                <option value='0.2'>0.2</option>
												                <option value='0.3'>0.3</option>
												                <option value='0.4'>0.4</option>
												                <option value='0.5'>0.5</option>
												                <option value='0.6'>0.6</option>
												                <option value='0.7'>0.7</option>
												                <option value='0.8'>0.8</option>
												                <option value='0.9'>0.9</option>
												                <option value='1.0'>1.0</option>
												                <option value='1.1'>1.1</option>
												                <option value='1.2'>1.2</option>
												                <option value='1.3'>1.3</option>
												                <option value='1.4'>1.4</option>
												                <option value='1.5'>1.5</option>
												                <option value='1.6'>1.6</option>
												                <option value='1.7'>1.7</option>
												                <option value='1.8'>1.8</option>
												                <option value='1.9'>1.9</option>
												                <option value='2.0'>2.0</option>
												                <option value='2.1'>2.1</option>
												                <option value='2.2'>2.2</option>
												                <option value='2.3'>2.3</option>
												                <option value='2.4'>2.4</option>
												                <option value='2.5'>2.5</option>
												                <option value='2.6'>2.6</option>
												                <option value='2.7'>2.7</option>
												                <option value='2.8'>2.8</option>
												                <option value='2.9'>2.9</option>
												                <option value='3.0'>3.0</option>
												                <option value='3.1'>3.1</option>
												                <option value='3.2'>3.2</option>
												                <option value='3.3'>3.3</option>
												                <option value='3.4'>3.4</option>
												                <option value='3.5'>3.5</option>
												                <option value='3.6'>3.6</option>
												                <option value='3.7'>3.7</option>
												                <option value='3.8'>3.8</option>
												                <option value='3.9'>3.9</option>
												                <option value='4.0'>4.0</option>
												                <option value='4.1'>4.1</option>
												                <option value='4.2'>4.2</option>
												                <option value='4.3'>4.3</option>
												                <option value='4.4'>4.4</option>
												                <option value='4.5'>4.5</option>
												                <option value='4.6'>4.6</option>
												                <option value='4.7'>4.7</option>
												                <option value='4.8'>4.8</option>
												                <option value='4.9'>4.9</option>
												                <option value='5.0'>5.0</option>
							              					</select></td>";
															// fin sin notas
														}
													}
													//fin estudiantes ciclos
												}
											}
										?>
									</tbody>
								</table>
								<input type="hidden" name="id_periodo" id="id_periodo" value="<?php echo $totalPeriodos ?>">
								<input type="hidden" name="id_grado" id="id_grado" value="<?php echo $grado ?>">
								<input type="hidden" name="id_materia" id="id_materia" value="<?php echo $materia ?>">
								<input type="hidden" name="total" id="total" value="<?php echo $auto ?>">
								</form>
						</div>

					</div>
					<?php 
						if ($idb==7) {
							echo '
								<button type="submit" class="btn btn-primary">
							      <span class="fa fa-save"></span> Guardar Notas
							    </button>

							    <a href="calificaciones.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							';
							// echo '<button type="submit" class="btn btn-primary">Guardar Notas</button>';
						}
						else if ($pensa=="HUMANÍSTICO" && $idg<=12) {
							echo '
							    <a href="calificaciones.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							';
						}else if ($pensa=="BIOETICO" && $idg<=12) {
							echo '
							    <a href="calificaciones.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							';
						}else{
							echo '
								<button type="submit" class="btn btn-primary">
							      <span class="fa fa-save"></span> Guardar Notas
							    </button>

							    <a href="calificaciones.php" class="btn btn-primary"><span class="fa fa-rotate-left"></span> Atrás</a>
							';
							// echo '<button type="submit" class="btn btn-primary">Guardar Notas</button>';
						}
					?>
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
}else{
	echo "<script>alert('Debes iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>
</html>