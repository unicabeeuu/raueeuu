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
    //$consulta_menu=mysqli_query($conexion,$sql_menu);
    $consulta_menu=$mysqli1->query($sql_menu);
    //while ($filaM=mysqli_fetch_array($consulta_menu)){
    while($filaM =$consulta_menu->fetch_assoc()){
        if ($filaM['id_grado']>$numeroMayor) {
            $numeroMayor=$filaM['id_grado']; 
        }
        if ($filaM['id_grado']<$numeroMenor) {
            $numeroMenor=$filaM['id_grado'];
        }
    }
    
    $sqlparam = "SELECT v1, parametro FROM tbl_parametros Where parametro IN ('act_notas_carga','bd_tut','conf_cal_mood','ver_certificados')";
    //$resparam=mysqli_query($conexion,$sqlparam);
    $resparam=$mysqli1->query($sqlparam);
    //while ($filaP=mysqli_fetch_array($resparam)){
    while($filaP =$resparam->fetch_assoc()){
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
            <h1><a class="navbar-brand" href="../docenteunicab/index.php"><img src="../images/logo.png" width="80%" /></a></h1>
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
                <a href="../docenteunicab/asignacion.php">
                <i class="fa fa-male"></i> <span>Asignación</span>
                </a>
              </li>
              <?php 
              if ($director=="HUMANÍSTICO" || $director=="BIOETICO") {
                
                //if ($numeroMayor>=13 && $numeroMenor<=18) {
                  ?>
                  <!--<li class="treeview">
                  <a href="../calificaciones.php">
                    <i class="fa fa-clipboard"></i> <span>Calificaciones</span>
                  </a>
                </li>-->
                               
                  <?php
                //}
                //if ($numeroMenor>=1 && $numeroMenor<=12) {
                  ?>
                <!--<li class="treeview">
                    <a href="../direccion.php">
                    <i class="fa fa-clipboard"></i> <span>Dirección Pensamiento</span>
                    </a>
                  </li>--> 
                <?php
                //}
              }else{
                ?>
                <!--<li class="treeview">
                  <a href="../calificaciones.php">
                    <i class="fa fa-clipboard"></i> <span>Calificaciones</span>
                  </a>
                </li>-->
                <?php
              }
              ?>
              <li class="treeview">
                <a href="../docenteunicab/estudiante.php">
                <i class="fa fa-user"></i> <span>Informe Estudiante</span>
                </a>
              </li>
			  <!--Aquí iria el nuevo menú para actualizar registro-->
			  <?php
			    //echo "id_emp=".$id;
			    if($id == 18 || $id == 24) {
				//if($id == 10) {
					echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/updreg/adm.php'>";
					  echo "<i class='fa fa-cloud-upload'></i> <span>Actualizar registro</span>";
					  echo "</a>";
				    echo "</li>";
				}
				else {
				    if($v_param == 1) {
				        echo "<li class='treeview'>";
					      echo "<a href='../docenteunicab/updreg/pen_gra_upddat_tutor.php'>";
    					  echo "<i class='fa fa-cloud-upload'></i> <span>Actualizar registro</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				    if($v_param1 == 1) {
				        echo "<li class='treeview'>";
    					  echo "<a href='../docenteunicab/updreg/adm2.php'>";
    					  echo "<i class='fa fa-users'></i> <span>Base de datos</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				    if($v_param2 == 1) {
				        echo "<li class='treeview'>";
    					  echo "<a href='../docenteunicab/updreg/act_moodle_upddat.php'>";
    					  echo "<i class='fa fa-cogs'></i> <span>Configurar calificaciones</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				    if($v_param3 == 1) {
				        echo "<li class='treeview'>";
    					  echo "<a href='../docenteunicab/updreg/certificados_getdat.php'>";
    					  echo "<i class='fa fa-file-pdf-o'></i> <span>Certificados</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				}
				if($id == 18) {
					echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/updreg/cod_entrevista.php'>";
					  echo "<i class='fa fa-key'></i> <span>Código entrevista</span>";
					  echo "</a>";
				    echo "</li>";
				    echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/updreg/adm1.php'>";
					  echo "<i class='fa fa-users'></i> <span>Base de datos</span>";
					  echo "</a>";
				    echo "</li>";
				    echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/updreg/act_moodle_upddat.php'>";
					  echo "<i class='fa fa-cogs'></i> <span>Configurar calificaciones</span>";
					  echo "</a>";
				    echo "</li>";
				    echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/updreg/certificados_getdat.php'>";
					  echo "<i class='fa fa-file-pdf-o'></i> <span>Certificados</span>";
					  echo "</a>";
				    echo "</li>";
				    /*echo "<li class='treeview'>";
					  echo "<a href='desemp_estud_per_getdat.php'>";
					  echo "<i class='fa fa-bar-chart '></i> <span>Desempeño estudiantes</span>";
					  echo "</a>";
				    echo "</li>";*/
				    echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/menciones.php'>";
					  echo "<i class='fa fa-graduation-cap'></i> <span>Reconocimientos</span>";
					  echo "</a>";
				    echo "</li>";
				    echo "<li class='treeview'>";
					  echo "<a href='ordenes_getdat.php'>";
					  echo "<i class='fa fa-usd'></i> <span>Ordenes de pago</span>";
					  echo "</a>";
				    echo "</li>";
				    echo "<li class='treeview'>";
					  echo "<a href='../docenteunicab/updreg/preguntas_put_upddat.php'>";
					  echo "<i class='fa fa-university'></i> <span>Banco de preguntas</span>";
					  echo "</a>";
				    echo "</li>";
				}
				if($id == 24) {
				    if($v_param1 == 1) {
				        echo "<li class='treeview'>";
    					  echo "<a href='../docenteunicab/updreg/adm2.php'>";
    					  echo "<i class='fa fa-users'></i> <span>Base de datos</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				    if($v_param2 == 1) {
				        echo "<li class='treeview'>";
    					  echo "<a href='../docenteunicab/updreg/act_moodle_upddat.php'>";
    					  echo "<i class='fa fa-cogs'></i> <span>Configurar calificaciones</span>";
    					  echo "</a>";
    				    echo "</li>";
				    }
				}
			  ?>
			  <li class="treeview">
                <a href='../docenteunicab/updreg/desemp_estud_per_getdat.php'>
                <i class='fa fa-bar-chart '></i> <span>Desempeño estudiantes</span>
                </a>
              </li>
              <!--<li class="treeview">
                <a href='../menciones.php'>
                <i class='fa fa-graduation-cap'></i> <span>Reconocimientos</span>
                </a>
              </li>-->
            </ul>
            <label><?php //echo $numeroMayor; ?></label>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
	</div>
  <!--left-fixed -navigation-->
<!-- // menu -->