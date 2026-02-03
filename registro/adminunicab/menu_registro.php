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
                  <li><a href="adm_tbl_param.php?tabla=tbl_cargos"><i class="fa fa-angle-right"></i> Cargos</a></li>
                  <li><a href="adm_tbl_param.php?tabla=tbl_dependencias"><i class="fa fa-angle-right"></i> Dependencias</a></li>
                  <li><a href="adm_tbl_param.php?tabla=tbl_empleados"><i class="fa fa-angle-right"></i> Empleados</a></li>
                  <!--<li><a href="adm_tbl_param.php?tabla=estudiantes&estado=activo"><i class="fa fa-angle-right"></i> Estudiantes activos</a></li>
                  <li><a href="adm_tbl_param.php?tabla=estudiantes&estado=inactivo"><i class="fa fa-angle-right"></i> Estudiantes inactivos</a></li>-->
                  <li><a href="registro-estudiantes.php"><i class="fa fa-angle-right"></i> Registrar Estudiante</a></li>
                  <li><a href="lista-estudiantes.php"><i class="fa fa-angle-right"></i> Editar Estudiante</a></li>
                  <li><a href="adm_tbl_param.php?tabla=tbl_profesiones"><i class="fa fa-angle-right"></i> Profesiones</a></li>
                  <li><a href="adm_tbl_param.php?tabla=tbl_tipos_documento"><i class="fa fa-angle-right"></i> Tipos Documento</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Procesos</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../docenteunicab/updreg/pen_gra_upddat.php" target="_blank"><i class="fa fa-line-chart"></i> Actualizar Calificaciones</a></li>
                  <li><a href="carga_academica.php"><i class="fa fa-battery-three-quarters "></i> Carga Docente</a></li>
                  <li><a href="cierre-academico.php"><i class="fa fa-power-off"></i> Cierre Académico</a></li>
                  <li><a href="registrar-matricula.php"><i class="fa fa-folder-open"></i> Registrar Matrícula</a></li>
                  <li><a href="lista-matricula.php"><i class="fa fa-edit"></i> Editar Matrícula</a></li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-angle-right"></i>
                    <span>Generar carnets</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="carnets_emp_getdat.php"><i class="fa fa-file-text"></i> Empleados</a></li>
                      <?php  
                            //if($id_administrador == 18) {
                      ?>
                      <li><a href="carnets_est_getdat.php"><i class="fa fa-file-text-o"></i> Estudiantes</a></li>
                      <?php  
                            //}
                      ?>
                    </ul>
                  </li>
                  
                  <?php  
                      if($id_administrador == 18 || $id_administrador == 3 || $id_administrador == 2) {
                  ?>
						<li><a href="pazsalvo_est_getdat.php"><i class="fa fa-check-circle"></i> Paz y salvos</a></li>
						<li><a href="domain_put_upddat.php"><i class="fa fa-share-square "></i> Método Doman</a></li>
						<li><a href="domain_put_upddat_i.php"><i class="fa fa-share-square "></i> Método Doman I</a></li>
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
                  
                  <li><a href="lista-estudiantes_presol.php"><i class="fa fa-upload"></i> Pre_solicitud a Solicitud</a></li>
                  
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
                    <li><a href="certificados-grado.php"><i class="fa fa-angle-right"></i> Grado</a></li>
                    <?php
                        if($id_administrador == 18 || $id_administrador == 3) {
                    ?>
                        <li><a href="certificados-grado_aanterior.php"><i class="fa fa-angle-right"></i> Grado año anterior</a></li>
                    <?php
                        }
                    ?>
                    <li><a href="certificados_final_getdat.php"><i class="fa fa-angle-right"></i> Consultar</a></li>
                    <!--<li><a href="consultar-certificado.php"><i class="fa fa-angle-right"></i> Consultar</a></li>-->
                    <li><a href="certificados_adm_getdat.php"><i class="fa fa-file-pdf-o"></i> Generar</a></li>
                  </ul>
                  </li>
                  <li><a href="cupos_getdat.php"><i class="fa fa-check-circle"></i> Cupos apartados</a></li>
                  <li><a href="estudiante.php"><i class="fa fa-user"></i> Estudiante</a></li>
                  <li><a href="diferencia_est_getdat.php?q=rnom"><i class="fa fa-user-secret"></i> Estudiantes en R y no en M</a></li>
                  <li><a href="diferencia_est_getdat.php?q=mnor"><i class="fa fa-user-times"></i> Estudiantes en M y no en R</a></li>
                  <li><a href="desemp_estud_per_getdat.php"><i class="fa fa-bar-chart"></i> Desempeño estudiantes</a></li>
                  <li><a href="ranking_getdat.php"><i class="fa fa-sort-amount-desc"></i> Ranking</a></li>
                  <li><a href="estudiante_grupo_getdat.php"><i class="fa fa-user-plus"></i> Estudiantes grupo</a></li>
                  <li><a href="lista-est_ant_sinmat.php"><i class="fa fa-user-plus"></i> Estudiantes Ant. SinMat.</a></li>				  
                  <?php
                    if($v_param1 == 1) {
                  ?>                        
						<li class='treeview'>
							<a href='#'><i class='fa fa-file-text'></i>Resultados Eval<i class='fa fa-angle-left pull-right'></i></a>
							<ul class='treeview-menu'>
								<li><a href="lista-estudiantes_evalpres.php"><i class="fa fa-file-text "></i> Admisión</a></li>
								<li><a href="lista-estudiantes_evalpres_sm.php"><i class="fa fa-file-text "></i> Admisión Sin Matrícula</a></li>
								<li><a href="lista-estudiantes_evalval.php"><i class="fa fa-file-text "></i> Validación</a></li>
							</ul>
						</li>
                  <?php
                    }
                  ?>
				  <li class='treeview'>
					  <a href='#'><i class='fa fa-file-text'></i>Resultados Encuestas<i class='fa fa-angle-left pull-right'></i></a>
					  <ul class='treeview-menu'>
						  <li><a href="resultado_encuesta.php"><i class="fa fa-file-text "></i> Encuesta Bimestre 1</a></li>
					  </ul>
				  </li>
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
                    <!--<li><a href="adm1.php"><i class="fa fa-users"></i> Base de datos</a></li>-->
					<li><a href="backup.php"><i class="fa fa-database"></i> Copia de seguridad</a></li>
					<li><a href="lista_comprobantes_avadmisiones.php"><i class="fa fa-check-circle"></i> Validar documentos matrícula</a></li>
					<li><a href="stickers_correspondencia.php"><i class="fa fa-file-text"></i> Stickers correspondencia</a></li>
                </ul>
              </li>
              
              <li class='treeview'>
                  <a href='#'><i class='fa fa-phone-square'></i>Envíos Whatsapp<i class='fa fa-angle-left pull-right'></i></a>
                  <ul class='treeview-menu'>
                      <li><a href="envio_whatsapp_putdat.php"><i class="fa fa-user"></i> Est. Ant. Sin Mat.</a></li>
                      <li><a href="envio_whatsapp_ent_sinmat_putdat.php"><i class="fa fa-user"></i> Entrevistas Sin Mat.</a></li>
                      <li><a href="envio_whatsapp_presol_putdat.php"><i class="fa fa-user"></i> Pre-Solicitudes Sin Mat.</a></li>
                      <li><a href="envio_whatsapp_matriculas_putdat.php"><i class="fa fa-user"></i> Matrículas efectivas</a></li>
					  <li><a href="envio_whatsapp_contactos_drive.php"><i class="fa fa-user"></i> Contactos Drive.</a></li>
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