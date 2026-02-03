<?php
    session_start();
	Include "../adminunicab/php/conexion.php";
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
	
    //Se captura el id y grado del estudiante
    $sql = "SELECT e.id, m.id_grado FROM estudiantes e, matricula m 
	WHERE e.id = m.id_estudiante AND e.n_documento = '".$_SESSION['identifest']."' AND m.n_matricula like '%$fanio%'";
    $res=mysqli_query($conexion,$sql);

	while ($fila = mysqli_fetch_array($res)){
	    $idest = $fila['id'];
		$idgrado = $fila['id_grado'];
	}

?>

	<!-- menu -->
  <div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="cbp-spmenu-s1">
		<!--left-fixed -navigation-->
		<aside class="sidebar-left">
      <nav class="navbar navbar-inverse">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".collapse" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <h1><a class="navbar-brand" href="index.php"><img src="../images/logo_horizontal_blanco.png" width="80%" /></a></h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">Menu Navegable</li>
              <li class="treeview">
                <a href="index.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
              </li>
              <!--<li class="treeview">
                <a href="historial.php">
                <i class="fa fa-clipboard" aria-hidden="true"></i><span>Historial de Notas</span>
                </a>
              </li>-->
              <li class="treeview">
                <a href="materias.php">
                <i class="fa fa-table"></i> <span>Materias Inscritas</span>
                </a>
              </li>
              <li class="treeview">
                <a href="encuesta.php">
                <i class="fa fa-file-pdf-o"></i> <span>Certificado de Notas</span>
                </a>
              </li>
              <li class="treeview">
                <a href="estudiantes_evaladm.php?idest=<?php echo $idest; ?>">
                <i class="fa fa-file-text"></i> <span>Evaluación Admisión</span>
                </a>
              </li>
              <li class="treeview">
                <a href="carnets.php?idest=<?php echo $idest; ?>">
                <i class="fa fa-file-pdf-o"></i> <span>Carnet Estudiantil</span>
                </a>
              </li>
              <li class="treeview">
                <a href="polizas.php?idest=<?php echo $idest; ?>">
                <i class="fa fa-file-pdf-o"></i> <span>Póliza</span>
                </a>
              </li>
              <li class="treeview">
                <a href="pazysalvo.php?idest=<?php echo $idest; ?>">
                <i class="fa fa-check-circle"></i> <span>Paz y Salvo</span>
                </a>
              </li>
              <li class="treeview">
                <a href="certificado_final.php">
                <i class="fa fa-file-pdf-o"></i> <span>Certificado Final</span>
                </a>
              </li>
              <li class="treeview">
                <a href="cupo.php">
                <i class="fa fa-share-square-o"></i> <span>Cupo Apartado</span>
                </a>
              </li>
			  <li class="treeview">
                <a href="observador.php">
                <i class="fa fa-folder-open"></i> <span>Observador Estudiante</span>
                </a>
              </li>
			  <?php
				if ($idgrado == 6 || $idgrado == 14 || $idgrado == 10 || $idgrado == 16 || $idgrado == 12 || $idgrado == 18) {
			  ?>
			  <li class="treeview">
                <a href="diploma.php">
                <i class="fa fa-graduation-cap"></i> <span>Diploma de Grado</span>
                </a>
              </li>
			  <?php
				}
			  ?>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
	</div>
  <!--left-fixed -navigation-->
<!-- // menu -->