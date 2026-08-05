    <?php 
        include "php/conexion.php";
        
        $sqlparam = "SELECT v1 FROM tbl_parametros Where parametro = 'bd_adm'";
        $resparam=mysqli_query($conexion,$sqlparam);
        while ($filaP=mysqli_fetch_array($resparam)){
            $v_param = $filaP['v1'];
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
            <h1><a class="navbar-brand" href="index.php"><img src="../../assets/img/logo-unicab/logo_thrive_f2.png" width="80%" /></a></h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">Navigation Menu</li>
              <?php  
                    if($id_administrador == 18) {
              ?>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-database"></i>
                <span>Change System</span>
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
                <i class="fa fa-home"></i> <span>Home</span>
                </a>
              </li>
              <?php  
                    }
              ?>
              <!-- <li class="treeview"> -->
              <li class="treeview">
                <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Registration</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="registro-estudiantes.php"><i class="fa fa-angle-right"></i> Register Student</a></li>
                  <li><a href="lista-estudiantes.php"><i class="fa fa-angle-right"></i> Edit Student</a></li>
                   <li><a href="registro-profesores.php"><i class="fa fa-angle-right"></i> Register Employee</a></li>
                   <li><a href="lista-profesores.php"><i class="fa fa-angle-right"></i> Edit Employee</a></li>
                </ul>
              </li>
               <li class="treeview">
                <a href="#">
                <i class="fa fa-edit"></i>
                <span>Enrolments</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="registrar-matricula.php"><i class="fa fa-angle-right"></i> Register Enrolment</a></li>
                  <li><a href="lista-matricula.php"><i class="fa fa-angle-right"></i> Edit Enrolment</a></li>
                </ul>
              </li>
             <li class="treeview">
                <a href="#">
                <i class="fa fa-edit"></i>
                <span>Teacher Load</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="registro-carga.php"><i class="fa fa-angle-right"></i> Assignment</a></li>
                  <li><a href="carga-docente.php"><i class="fa fa-angle-right"></i> View Assignment</a></li>
                </ul>
              </li>
              <!--  -->
              <li class="treeview">
                <a href="#">
                <i class="fa fa-file-pdf-o"></i>
                <span>Certificates</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="certificados-periodo.php"><i class="fa fa-angle-right"></i> Period</a></li>
                  <li><a href="certificados-grado.php"><i class="fa fa-angle-right"></i> Degree</a></li>
                  <li><a href="certificados_final_getdat.php"><i class="fa fa-angle-right"></i> Consult</a></li>
                  <!--<li><a href="consultar-certificado.php"><i class="fa fa-angle-right"></i> Consult</a></li>-->
                  <li><a href="certificados_adm_getdat.php"><i class="fa fa-file-pdf-o"></i> Generate</a></li>
                </ul>
              </li>
              <!--  -->
              <li class="treeview">
                <a href="estudiante.php">
                <i class="fa fa-user"></i> <span>Student Report</span>
                </a>
              </li>
              <li class="treeview">
                <a onclick="cierre()" href="#">
                <i class="fa fa-power-off"></i> <span>Academic Closing</span>
                </a>
              </li>
              <li class="treeview">
                <a href="backup.php">
                <i class="fa fa-database"></i> <span>Backup Copy</span>
                </a>
              </li>
              <!--<li class="treeview">
                <a href="cod_entrevista.php">
                <i class="fa fa-key"></i> <span>Interview Code</span>
                </a>
              </li>-->
              <?php
                  if($v_param == 1) {
                      echo "<li class='treeview'>";
    					  echo "<a href='adm1.php'>";
    					  echo "<i class='fa fa-users'></i> <span>Database</span>";
    					  echo "</a>";
    				    echo "</li>";
                  }
    		  ?> 
    		  <li class="treeview">
                <a href='desemp_estud_per_getdat.php'>
                <i class='fa fa-bar-chart '></i> <span>Student Performance</span>
                </a>
              </li>
             <!--  <li class="treeview">
                <a href="#">
                <i class="fa fa-table"></i> <span>Reports</span>
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
      let evalua=confirm("Modifications in this section are irreversible\nDo you want to continue?");
      if (evalua==true) {
        location.href='cierre-academico.php';
      }else{
        location.href='index.php';
      }
    }
  </script>
  <!--left-fixed -navigation-->
<!-- // menu -->