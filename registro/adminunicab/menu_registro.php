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
            <div><a class="navbar-brand" href="index.php"><img src="../../assets/img/logo-unicab/logo_thrive_f2.png" width="70%" /></a></div>
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
              <!-- <li class="treeview"> 
              <li class="treeview">-->
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cubes"></i>
                <span>Parameter Tables</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <!-- <li><a href="adm_tbl_param.php?tabla=tbl_cargos"><i class="fa fa-angle-right"></i> Positions</a></li>
                  <li><a href="adm_tbl_param.php?tabla=tbl_dependencias"><i class="fa fa-angle-right"></i> Departments</a></li> -->
                  <li><a href="adm_tbl_param.php?tabla=tbl_empleados"><i class="fa fa-angle-right"></i> Employees</a></li>
                  <!--<li><a href="adm_tbl_param.php?tabla=estudiantes&estado=activo"><i class="fa fa-angle-right"></i> Active Students</a></li>
                  <li><a href="adm_tbl_param.php?tabla=estudiantes&estado=inactivo"><i class="fa fa-angle-right"></i> Inactive Students</a></li>-->
                  <!-- <li><a href="registro-estudiantes.php"><i class="fa fa-angle-right"></i> Register Student</a></li> -->
                  <li><a href="lista-estudiantes.php"><i class="fa fa-angle-right"></i> Edit Student</a></li>
                  <!-- <li><a href="adm_tbl_param.php?tabla=tbl_profesiones"><i class="fa fa-angle-right"></i> Professions</a></li>
                  <li><a href="adm_tbl_param.php?tabla=tbl_tipos_documento"><i class="fa fa-angle-right"></i> Document Types</a></li> -->
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Processes</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../docenteunicab/updreg/pen_gra_upddat.php" target="_blank"><i class="fa fa-line-chart"></i> Update Grades</a></li>
                  <li><a href="carga_academica.php"><i class="fa fa-battery-three-quarters "></i> Teacher Load</a></li>
                  <li><a href="cierre-academico.php"><i class="fa fa-power-off"></i> Academic Closing</a></li>
                  <!-- <li><a href="registrar-matricula.php"><i class="fa fa-folder-open"></i> Register Enrolment</a></li> -->
                  <li><a href="lista-matricula.php"><i class="fa fa-edit"></i> Edit Enrolment</a></li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-angle-right"></i>
                    <span>Generate ID Cards</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="carnets_emp_getdat.php"><i class="fa fa-file-text"></i> Employees</a></li>
                      <?php  
                            //if($id_administrador == 18) {
                      ?>
                      <li><a href="carnets_est_getdat.php"><i class="fa fa-file-text-o"></i> Students</a></li>
                      <?php  
                            //}
                      ?>
                    </ul>
                  </li>
                  
                  <?php  
                      if($id_administrador == 18 || $id_administrador == 3 || $id_administrador == 2) {
                  ?>
						<li><a href="pazsalvo_est_getdat.php"><i class="fa fa-check-circle"></i> Clearances</a></li>
						<!-- <li><a href="domain_put_upddat.php"><i class="fa fa-share-square "></i> Doman Method</a></li>
						<li><a href="domain_put_upddat_i.php"><i class="fa fa-share-square "></i> Doman Method I</a></li>
                  <?php  
                      }
                  ?>
                  
                  <li class='treeview'>
                      <a href='#'><i class='fa fa-bookmark'></i>Blog<i class='fa fa-angle-left pull-right'></i></a>
                      <ul class='treeview-menu'>
                          <li><a href="post_putdat.php"><i class="fa fa-bookmark-o"></i> Crear</a></li>
                          <li><a href="post_getdat.php"><i class="fa fa-check"></i> Ver</a></li>
                      </ul>
                  </li>
                  
                  <li><a href="lista-estudiantes_presol.php"><i class="fa fa-upload"></i> Pre_solicitud a Solicitud</a></li> -->
                  
                </ul>
              </li>
               <li class="treeview">
                <a href="#">
                <i class="fa fa-line-chart "></i>
                <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li class="treeview">
                  <a href="#">  
                  <i class="fa fa-file-pdf-o"></i>
                  <span>Certificates</span>
                  <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="certificados-periodo.php"><i class="fa fa-angle-right"></i> Enrolment</a></li>
                    <li><a href="certificados-grado.php"><i class="fa fa-angle-right"></i> Degree</a></li>
                    <?php
                        if($id_administrador == 18 || $id_administrador == 3) {
                    ?>
                        <li><a href="certificados-grado_aanterior.php"><i class="fa fa-angle-right"></i> Previous Year Degree</a></li>
                    <?php
                        }
                    ?>
                    <li><a href="certificados_final_getdat.php"><i class="fa fa-angle-right"></i> Consult</a></li>
                    <!--<li><a href="consultar-certificado.php"><i class="fa fa-angle-right"></i> Consult</a></li>-->
                    <li><a href="certificados_adm_getdat.php"><i class="fa fa-file-pdf-o"></i> Generate</a></li>
                  </ul>
                  </li>
                  <!-- <li><a href="cupos_getdat.php"><i class="fa fa-check-circle"></i> Reserved spots</a></li> -->
                  <!-- <li><a href="estudiante.php"><i class="fa fa-user"></i> Student</a></li> -->
                  <!-- <li><a href="diferencia_est_getdat.php?q=rnom"><i class="fa fa-user-secret"></i> Students in R and not in M</a></li>
                  <li><a href="diferencia_est_getdat.php?q=mnor"><i class="fa fa-user-times"></i> Students in M and not in R</a></li> -->
                  <li><a href="desemp_estud_per_getdat.php"><i class="fa fa-bar-chart"></i> Student Performance</a></li>
                  <li><a href="ranking_getdat.php"><i class="fa fa-sort-amount-desc"></i> Ranking</a></li>
                  <li><a href="estudiante_grupo_getdat.php"><i class="fa fa-user-plus"></i> Group Students</a></li>
                  <!-- <li><a href="lista-est_ant_sinmat.php"><i class="fa fa-user-plus"></i> Old Students Without Enrol.</a></li>	-->			  
                  <?php
                    if($v_param1 == 1) {
                  ?>                        
						<li class='treeview'>
							<a href='#'><i class='fa fa-file-text'></i>Eval Results<i class='fa fa-angle-left pull-right'></i></a>
							<ul class='treeview-menu'>
								<li><a href="lista-estudiantes_evalpres.php"><i class="fa fa-file-text "></i> Admission</a></li>
								<li><a href="lista-estudiantes_evalpres_sm.php"><i class="fa fa-file-text "></i> Admission Without Enrol.</a></li>
								<!-- <li><a href="lista-estudiantes_evalval.php"><i class="fa fa-file-text "></i> Validation</a></li> -->
							</ul>
						</li>
                  <?php
                    }
                  ?>
				 <!-- <li class='treeview'>
					  <a href='#'><i class='fa fa-file-text'></i>Survey Results<i class='fa fa-angle-left pull-right'></i></a>
					  <ul class='treeview-menu'>
						  <li><a href="resultado_encuesta.php"><i class="fa fa-file-text "></i> Bimester 1 Survey</a></li>
					  </ul>
				  </li> -->
                </ul>
              </li>
             <li class="treeview">
                <a href="#">
                <i class="fa fa-wrench"></i>
                <span>Tools</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                <?php
                    if($v_param == 1) {
                        echo "<li class='treeview'>";
                        echo "<a href='adm1.php'>";
                        echo "<i class='fa fa-users'></i> <span>Database</span>";
                        echo "</a>";
                        echo "</li>";
                    }
                ?>
                    <!--<li><a href="adm1.php"><i class="fa fa-users"></i> Database</a></li>-->
					<!-- <li><a href="backup.php"><i class="fa fa-database"></i> Backup</a></li> -->
					<li><a href="lista_comprobantes_avadmisiones.php"><i class="fa fa-check-circle"></i> Validate enrolment documents</a></li>
					<li><a href="stickers_correspondencia.php"><i class="fa fa-file-text"></i> Correspondence stickers</a></li>
                </ul>
              </li>
              
              <!-- <li class='treeview'>
                  <a href='#'><i class='fa fa-phone-square'></i>Whatsapp Sends<i class='fa fa-angle-left pull-right'></i></a>
                  <ul class='treeview-menu'>
                      <li><a href="envio_whatsapp_putdat.php"><i class="fa fa-user"></i> Old Est. Without Enrol.</a></li>
                      <li><a href="envio_whatsapp_ent_sinmat_putdat.php"><i class="fa fa-user"></i> Interviews Without Enrol.</a></li>
                      <li><a href="envio_whatsapp_presol_putdat.php"><i class="fa fa-user"></i> Pre-Requests Without Enrol.</a></li>
                      <li><a href="envio_whatsapp_matriculas_putdat.php"><i class="fa fa-user"></i> Effective Enrolments</a></li>
					  <li><a href="envio_whatsapp_contactos_drive.php"><i class="fa fa-user"></i> Drive Contacts.</a></li>
                  </ul>
              </li> -->
                  
              <!--  -->
              <!--<li class="treeview">
                <a href="#">
                <i class="fa fa-file-pdf-o"></i>
                <span>Certificates</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="certificados-periodo.php"><i class="fa fa-angle-right"></i> Period</a></li>
                  <li><a href="certificados-grado.php"><i class="fa fa-angle-right"></i> Degree</a></li>
                  <li><a href="consultar-certificado.php"><i class="fa fa-angle-right"></i> Consult</a></li>
                </ul>
              </li>
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
              </li>-->
              <!--<li class="treeview">
                <a href="cod_entrevista.php">
                <i class="fa fa-key"></i> <span>Interview Code</span>
                </a>
              </li>-->
              <?php
                  /*if($v_param == 1) {
                      echo "<li class='treeview'>";
    					  echo "<a href='adm1.php'>";
    					  echo "<i class='fa fa-users'></i> <span>Database</span>";
    					  echo "</a>";
    				    echo "</li>";
                  }*/
    		  ?>  
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