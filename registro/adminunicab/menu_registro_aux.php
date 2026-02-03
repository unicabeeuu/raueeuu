    <?php 
        include "php/conexion.php";
        
        $sqlparam = "SELECT v1, parametro FROM tbl_parametros Where parametro IN ('bd_adm','eval_pres')";
        $resparam=mysqli_query($conexion,$sqlparam);
        while ($filaP=mysqli_fetch_array($resparam)){
            if($filaP['parametro'] == "bd_adm") {
                $v_param = $filaP['v1'];
            }
            else if($filaP['parametro'] == "eval_pres") {
                $v_param1 = $filaP['v1'];
            }
        }
        
        $sqlAdministrador="SELECT * FROM tbl_empleados WHERE email = '".$_SESSION['admin_unicab']."' OR email = '".$_SESSION['uniprofe']."' OR email = '".$_SESSION['unisuper']."'";
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
            <h1><a class="navbar-brand" href="index.php"><img src="../images/logo_horizontal_blanco.png" width="80%" /></a></h1>
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
                  <li><a href="../../admin-unicab/administrador/index.php"><i class="fa fa-angle-right"></i> AW</a></li>
                  <li><a href="../docenteunicab/index.php"><i class="fa fa-angle-right"></i> TU</a></li>
                  <li><a href="../../tickets/login.php"><i class="fa fa-angle-right"></i> Tickets</a></li>
                </ul>
              </li>
              <?php  
                    }
                    else {
              ?>
              <li class="treeview">
                <a href="index.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
              </li>
              <?php  
                    }
              ?>
              <!-- <li class="treeview"> 
              <li class="treeview">-->
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Tablas de parámetros</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="registro-estudiantes.php"><i class="fa fa-angle-right"></i> Registrar Estudiante</a></li>
                  <li><a href="lista-estudiantes.php"><i class="fa fa-angle-right"></i> Editar Estudiante</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Procesos</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="cierre-academico.php"><i class="fa fa-power-off"></i> Cierre Académico</a></li>
                  <li><a href="registrar-matricula.php"><i class="fa fa-folder-open"></i> Registrar Matrícula</a></li>
                  
                  <?php  
                      if($id_administrador == 18 || $id_administrador == 3 || $id_administrador == 2 || $id_administrador == 43) {
                  ?>
                  <li><a href="pazsalvo_est_getdat.php"><i class="fa fa-check-circle"></i> Paz y salvos</a></li>
                  <?php  
                      }
                  ?>
                </ul>
              </li>
               <li class="treeview">
                <a href="#">
                <i class="fa fa-line-chart "></i>
                <span>Informes</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="treeview">
                  <a href="#">  
                  <i class="fa fa-file-pdf-o"></i>
                  <span>Certificados</span>
                  <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="certificados-periodo.php"><i class="fa fa-angle-right"></i> Matrícula</a></li>
                    <li><a href="certificados-grado_aanterior.php"><i class="fa fa-angle-right"></i> Grado año anterior</a></li>
                    <li><a href="certificados_final_getdat.php"><i class="fa fa-angle-right"></i> Consultar</a></li>
                    <!--<li><a href="consultar-certificado.php"><i class="fa fa-angle-right"></i> Consultar</a></li>-->
                    <li><a href="certificados_adm_getdat.php"><i class="fa fa-file-pdf-o"></i> Generar</a></li>
                  </ul>
                  </li>
                  <li><a href="desemp_estud_per_getdat.php"><i class="fa fa-bar-chart"></i> Desempeño estudiantes</a></li>
                  <li><a href="ranking_getdat.php"><i class="fa fa-sort-amount-desc"></i> Ranking</a></li>
                  <li><a href="estudiante_grupo_getdat.php"><i class="fa fa-user-plus"></i> Estudiantes grupo</a></li>
                  
                </ul>
              </li>
             <li class="treeview">
                <a href="#">
                <i class="fa fa-wrench"></i>
                <span>Herramientas</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <?php
                    if($v_param == 1) {
                        echo "<li class='treeview'>";
                        echo "<a href='adm1.php'>";
                        echo "<i class='fa fa-users'></i> <span>Base de datos</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                ?>
                </ul>
              </li>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
	</div>
  <script type="text/javascript">
    function cierre(){
      var evalua=confirm("Las modificaciones en esta sección son irreversibles\n¿Desea continuar?");
      if (evalua==true) {
        location.href='cierre-academico.php';
      }else{
        location.href='index.php';
      }
    }
  </script>
  <!--left-fixed -navigation-->
<!-- // menu -->