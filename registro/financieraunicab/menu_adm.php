	<?php 
  $numeroMayor=0;
  $numeroMenor=18;
  /*$sql_menu="SELECT distinct profesores.id, profesores.apellidos, profesores.nombres, grados.id as id_grado, grados.grado 
  FROM grados INNER JOIN (profesores INNER JOIN carga_profesor ON profesores.id = carga_profesor.id_profesor) 
  ON grados.id = carga_profesor.id_grado where profesores.id=".$id." ORDER BY grados.id ASC";*/
  $sql_menu="SELECT distinct e.id, e.apellidos, e.nombres, g.id as id_grado, g.grado 
      FROM grados g, tbl_empleados e, carga_profesor cp 
      WHERE cp.id_empleado = e.id AND g.id = cp.id_grado AND cp.id_empleado = ".$id." 
      ORDER BY g.id";
      
    $consulta_menu=mysqli_query($conexion,$sql_menu);
    while ($filaM=mysqli_fetch_array($consulta_menu)){
        if ($filaM['id_grado']>$numeroMayor) {
            $numeroMayor=$filaM['id_grado']; 
        }
        if ($filaM['id_grado']<$numeroMenor) {
            $numeroMenor=$filaM['id_grado'];
        }
    }
    
    $sqlparam = "SELECT v1, parametro FROM tbl_parametros Where parametro IN ('act_notas_carga','bd_tut','conf_cal_mood','ver_certificados')";
    $resparam=mysqli_query($conexion,$sqlparam);
    while ($filaP=mysqli_fetch_array($resparam)){
        if($filaP['parametro'] == "act_notas_carga") {
            $v_param = $filaP['v1'];
        }
        else if($filaP['parametro'] == "bd_tut") {
            $v_param1 = $filaP['v1'];
        }
        else if($filaP['parametro'] == "conf_cal_mood") {
            $v_param2 = $filaP['v1'];
        }
        else if($filaP['parametro'] == "ver_certificados") {
            $v_param3 = $filaP['v1'];
        }
    }
    
    $sqlAdministrador="SELECT * FROM `tbl_empleados` WHERE `email`='".$_SESSION['admin_unicab']."'";
    $exeAdministrador=mysqli_query($conexion,$sqlAdministrador);

    while ($rowAdmin=mysqli_fetch_array($exeAdministrador)) {
      $id_administrador=$rowAdmin['id'];
      $nombre=$rowAdmin['nombres'];
      $apellido=$rowAdmin['apellidos'];
      $email=$rowAdmin['email'];
      $perfil=$rowAdmin['perfil'];
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
              <?php  
                    if($id_administrador == 18) {
              ?>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-database"></i>
                <span>Cambiar sistema</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../adminunicab/index.php"><i class="fa fa-angle-right"></i> AR</a></li>
                  <li><a href="../../admin-unicab/administrador/index.php"><i class="fa fa-angle-right"></i> AW</a></li>
                  <li><a href="../../tickets/login.php"><i class="fa fa-angle-right"></i> Tickets</a></li>
                </ul>
              </li>
              <?php  
                    }
                    else {
              ?>
              <li class="treeview">
                <a href="../docenteunicab/index.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
              </li>
              <?php  
                    }
              ?>
              
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Informes</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../docenteunicab/updreg/desemp_estud_per_getdat.php"><i class="fa fa-bar-chart"></i> Desempeño estudiantes</a></li>
                  <li><a href="../docenteunicab/updreg/ranking_getdat.php"><i class="fa fa-sort-amount-desc"></i> Ranking</a></li>
                  <li class='treeview'>
                      <a href='#'><i class='fa fa-file-pdf-o'></i>Certificados<i class='fa fa-angle-left pull-right'></i></a>
                      <ul class='treeview-menu'>
                          <li><a href='../docenteunicab/updreg/certificados_getdat.php'><i class='fa fa-angle-right'></i> Por periodo</a></li>
                          <li><a href='../docenteunicab/updreg/certificados_finales_getdat.php'><i class='fa fa-angle-right'></i> Finales</a></li>
                      </ul>
                  </li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Procesos Admon</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../docenteunicab/asignacion.php"><i class="fa fa-battery-three-quarters "></i> Asignación</a></li>
                  <li><a href="ordenes_getdat.php"><i class="fa fa-usd"></i> Ordenes pago</a></li>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Procesos Tutores</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../docenteunicab/updreg/adm.php"><i class="fa fa-cloud-upload"></i> Actualizar registro</a></li>
                  <li><a href="../docenteunicab/updreg/cod_entrevista.php"><i class="fa fa-power-off"></i> Código entrevista</a></li>
                  <li><a href="../docenteunicab/updreg/adm1.php"><i class="fa fa-users"></i> Base de datos</a></li>
                  <li><a href="../docenteunicab/updreg/act_moodle_upddat.php"><i class="fa fa-cogs"></i> Configurar calificaciones</a></li>
                  <li><a href="../docenteunicab/menciones.php"><i class="fa fa-graduation-cap"></i> Reconocimientos</a></li>
                  <li><a href="../docenteunicab/updreg/preguntas_put_upddat.php"><i class="fa fa-university"></i> Banco de preguntas</a></li>
                </ul>
              </li>
              
            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
	</div>
  <!--left-fixed -navigation-->
<!-- // menu -->