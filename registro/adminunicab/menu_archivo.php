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
                    if($id_administrador == 18 || $id_administrador == 40) {
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
						echo '<li><a href="pazsalvo_est_getdat.php"><i class="fa fa-check-circle"></i> Paz y salvos</a></li>';
                    }
                ?>
                </ul>
              </li>
              <!--  -->
              <!--<li class="treeview">
                <a href="#">
                <i class="fa fa-file-pdf-o"></i>
                <span>Certificados</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="certificados-periodo.php"><i class="fa fa-angle-right"></i> Periodo</a></li>
                  <li><a href="certificados-grado.php"><i class="fa fa-angle-right"></i> Grado</a></li>
                  <li><a href="consultar-certificado.php"><i class="fa fa-angle-right"></i> Consultar</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="estudiante.php">
                <i class="fa fa-user"></i> <span>Informe Estudiante</span>
                </a>
              </li>
              <li class="treeview">
                <a onclick="cierre()" href="#">
                <i class="fa fa-power-off"></i> <span>Cierre Académico</span>
                </a>
              </li>
              <li class="treeview">
                <a href="backup.php">
                <i class="fa fa-database"></i> <span>Copia de Seguridad</span>
                </a>
              </li>-->
              <!--<li class="treeview">
                <a href="cod_entrevista.php">
                <i class="fa fa-key"></i> <span>Código entrevista</span>
                </a>
              </li>-->
              <?php
                  /*if($v_param == 1) {
                      echo "<li class='treeview'>";
    					  echo "<a href='adm1.php'>";
    					  echo "<i class='fa fa-users'></i> <span>Base de datos</span>";
    					  echo "</a>";
    				    echo "</li>";
                  }*/
    		  ?>  
             <!--  <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Informes</span>
                </a>
              </li> -->
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