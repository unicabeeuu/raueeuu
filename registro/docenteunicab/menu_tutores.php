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
    
    $sqlparam = "SELECT v1, parametro FROM tbl_parametros Where parametro IN ('act_notas_carga','bd_tut','conf_cal_mood','ver_certificados','eval_pres')";
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
        else if($filaP['parametro'] == "eval_pres") {
            $v_param4 = $filaP['v1'];
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
    
    //Se valida si el empleado tiene acceso a crear y editar preguntas
    $sql_val_preg = "SELECT COUNT(1) ct FROM tbl_usu_preguntas WHERE id_empleado = $id";
    $exe_val_preg = mysqli_query($conexion,$sql_val_preg);

    while ($row_val_preg = mysqli_fetch_array($exe_val_preg)) {
        $ct = $row_val_preg['ct'];
    }
    
    //Se valida si el empleado tiene acceso a enviar whatsapp masivos
    $sql_val_what = "SELECT COUNT(1) ct FROM tbl_usu_whatsapp WHERE id_empleado = $id";
    $exe_val_what = mysqli_query($conexion,$sql_val_what);

    while ($row_val_what = mysqli_fetch_array($exe_val_what)) {
        $ctw = $row_val_what['ct'];
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
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Informes</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="asignacion.php"><i class="fa fa-male"></i> <span>Asignación</span></a></li>
                  <?php
                      if($v_param3 == 999) {
    				    echo "<li class='treeview'>";
        				echo "<a href='updreg/certificados_getdat.php'>";
        				echo "<i class='fa fa-file-pdf-o'></i> <span>Certificados</span>";
        				echo "</a>";
        			    echo "</li>";
    				  }
    				  if($perfil != "PR") {
				  ?>
				  <li><a href='updreg/desemp_estud_per_getdat.php'><i class='fa fa-bar-chart '></i> <span>Desempeño estudiantes</span></a></li>
				  <?php
    				  }
				        if($v_param4 == 1) {
    				        echo "<li class='treeview'>";
        					  echo "<a href='lista-estudiantes_evalpres.php'>";
        					  echo "<i class='fa fa-file-text'></i> <span>Resultados Eval Admisión</span>";
        					  echo "</a>";
        				    echo "</li>";
    				    }
    				    if($perfil != "PR") {
				  ?>
                  <li><a href="updreg/ranking_getdat.php"><i class="fa fa-sort-amount-desc"></i> <span>Ranking</span></a></li>
                  <?php
    				    }
                  ?>
                </ul>
              </li>
              
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Procesos Tutores</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <?php
                    if($v_param4 == 1 && $ct == 1) {
				        echo "<li class='treeview'>";
    					  echo "<a href='#'><i class='fa fa-university'></i>Banco de preguntas<i class='fa fa-angle-left pull-right'></i></a>";
    					  echo "<ul class='treeview-menu'>";
    					    echo "<li><a href='updreg/preguntas_put_upddat.php'><i class='fa fa-minus'></i> Respuesta corta</a></li>";
    					    echo "<li><a href='updreg/preguntas_putss_upddat.php'><i class='fa fa-check-circle-o'></i> Sel. sencilla</a></li>";
    					    echo "<li><a href='updreg/preguntas_putsm2_upddat.php'><i class='fa fa-check-square-o'></i> Sel. múltiple 2</a></li>";
    					    echo "<li><a href='updreg/preguntas_putsm3_upddat.php'><i class='fa fa-check-square'></i> Sel. múltiple 3</a></li>";
    					  echo "</ul>";
    				    echo "</li>";
				    }
                    if($v_param1 == 1 && $perfil != "PR") {
				        echo "<li class='treeview'>";
    					  echo "<a href='updreg/adm2.php'>";
    					  echo "<i class='fa fa-users'></i> <span>Base de datos</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				    if($v_param2 == 1 && $perfil != "PR") {
				        echo "<li class='treeview'>";
    					  echo "<a href='updreg/act_moodle_upddat.php'>";
    					  echo "<i class='fa fa-cogs'></i> <span>Configurar calificaciones</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				    if($perfil != "PR") {
                  ?>
                  <li class='treeview'>
                      <a href='#'><i class='fa fa-bookmark'></i>Blog<i class='fa fa-angle-left pull-right'></i></a>
                      <ul class='treeview-menu'>
                          <li><a href="post_putdat.php"><i class="fa fa-bookmark-o"></i> Crear</a></li>
                          <li><a href="post_getdat.php"><i class="fa fa-check"></i> Ver</a></li>
						  <li><a href="imagen_putdat.php"><i class="fa fa-picture-o"></i> Subir imagen</a></li>
                      </ul>
                  </li>
                  <?php
				    }
				    
				    if($ctw == 1) {
                  ?>
					<li><a href="envio_whatsapp_putdat"><i class="fa fa-phone-square"></i> Envíos Whatsapp</a></li>
					<?php
						}
					?>
				  <li><a href="observaciones_est_putdat.php"><i class="fa fa-pencil-square-o"></i> Observaciones estudiantes</a></li>
				  <li><a href="observador.php"><i class="fa fa-folder-open"></i> Observador estudiante</a></li>
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