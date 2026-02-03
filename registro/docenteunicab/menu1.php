	<?php 
  $numeroMayor=0;
  $numeroMenor=18;
  $sql_menu="SELECT distinct profesores.id, profesores.apellidos, profesores.nombres, grados.id as id_grado, grados.grado FROM grados INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) ON grados.id = carga_profesor.id_grado where profesores.id=".$id." ORDER BY grados.id ASC";
  $consulta_menu=mysqli_query($conexion,$sql_menu);
 while ($filaM=mysqli_fetch_array($consulta_menu)){
  if ($filaM['id_grado']>$numeroMayor) {
    $numeroMayor=$filaM['id_grado']; 
  }
  if ($filaM['id_grado']<$numeroMenor) {
      $numeroMenor=$filaM['id_grado'];
    }
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
            <h1><a class="navbar-brand" href="index.php"><img src="../images/logo.png" width="80%" /></a></h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">Menu Navegable</li>
              <li class="treeview">
                <a href="index.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
              </li>
              <li class="treeview">
                <a href="asignacion.php">
                <i class="fa fa-male"></i> <span>Asignación</span>
                </a>
              </li>
              <?php 
              if ($director=="HUMANÍSTICO" || $director=="BIOETICO") {
                
                if ($numeroMayor>=13 && $numeroMenor<=18) {
                  ?>
                  <li class="treeview">
                  <a href="calificaciones.php">
                    <i class="fa fa-clipboard"></i> <span>Calificaciones</span>
                  </a>
                </li>
                               
                  <?php
                }
                if ($numeroMenor>=1 && $numeroMenor<=12) {
                  ?>
                <li class="treeview">
                    <a href="direccion.php">
                    <i class="fa fa-clipboard"></i> <span>Dirección Pensamiento</span>
                    </a>
                  </li> 
                <?php
                }
              }else{
                ?>
                <li class="treeview">
                  <a href="calificaciones.php">
                    <i class="fa fa-clipboard"></i> <span>Calificaciones</span>
                  </a>
                </li>
                <?php
              }
              ?>
              <li class="treeview">
                <a href="estudiante.php">
                <i class="fa fa-user"></i> <span>Informe Estudiante</span>
                </a>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
	</div>
  <!--left-fixed -navigation-->
<!-- // menu -->