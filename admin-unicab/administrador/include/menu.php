<?php 
  //$sqlAdministrador="SELECT * FROM `administrador` WHERE `Email`='".$_SESSION['admin_unicab']."'";
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
            <!--<h1><a class="navbar-brand" href="index.php"><img src="../../assets/img/footer_logo_blanco2025.png" width="50%"></a></h1>-->
			<h1><a class="navbar-brand" href="index.php"><img src="../../registro/images/logo_horizontal_blanco.png" width="100%"></a></h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">NAVIGATION MENU </li>
              <?php  
                    if($id_administrador == 18) {
              ?>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Switch system</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../../registro/adminunicab/index.php"><i class="fa fa-angle-right"></i> AR</a></li>
                  <li><a href="../../registro/docenteunicab/index.php"><i class="fa fa-angle-right"></i> TU</a></li>
                  <li><a href="../../../tickets/login.php"><i class="fa fa-angle-right"></i> Tickets</a></li>
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
					if ($perfil == "SU") {
              ?>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-database"></i>
                    <span>Tables</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Users</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="crear-usuario.php"><i class="fa fa-angle-right"></i> Create</a></li>
                          <li><a href="listado-usuarios.php"><i class="fa fa-angle-right"></i> List</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-picture-o"></i>
                        <span>Banner</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="crear-banner.php"><i class="fa fa-angle-right"></i> Create</a></li>
                          <li><a href="lista-baner.php"><i class="fa fa-angle-right"></i> List</a></li>
                          <li><a href="crear-banner_us.php"><i class="fa fa-angle-right"></i> Create us</a></li>
                          <li><a href="lista-baner_us.php"><i class="fa fa-angle-right"></i> List us</a></li>
                        </ul>
                      </li>
                      <!--<li class="treeview">
                        <a href="#">
                        <i class="fa fa-users"></i>
                        <span>Equipo trabajo</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-mediador.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="listado-mediadores.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-volume-control-phone"></i>
                        <span>Directorio</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-directorio.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="lista-directorio.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-calendar"></i>
                        <span>Calendario</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-calendario.php"><i class="fa fa-angle-right"></i> Cargar</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-weixin"></i>
                        <span>Chat Social</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="chat-social.php"><i class="fa fa-angle-right"></i> Configurar</a></li>
                        </ul>
                      </li>-->
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-bullhorn"></i>
                        <span>Events</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-evento.php"><i class="fa fa-angle-right"></i> Create</a></li>
                          <li><a href="listado-eventos.php"><i class="fa fa-angle-right"></i> List</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-newspaper-o"></i>
                        <span>News</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-noticia.php"><i class="fa fa-angle-right"></i> Create</a></li>
                          <li><a href="listado-noticias.php"><i class="fa fa-angle-right"></i> List</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-folder-open"></i>
                        <span>Blog</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="crear-blog.php"><i class="fa fa-angle-right"></i> Create</a></li>
                          <li><a href="listado-blog.php"><i class="fa fa-angle-right"></i> List</a></li>
                        </ul>
                      </li>
					  <li class="treeview">
						<a href='listado_estudiantes_nuevos.php'>
						<i class='fa fa-user'></i> <span>New students list</span>
						</a>
					  </li>
                      
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href='agenda_putdat0.php'>
                    <i class='fa fa-calendar'></i> <span>Schedule other events</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href='entrevistas_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>View Schedule</span>
                    </a>
                  </li>
				  <li class="treeview">
                    <a href='entrevistas_carti_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>View CARTI Schedule</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Interviews</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Initial data</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Schedule</a></li>
                      <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Manage</a></li>
                      <!--<li><a href="entrevistas_getdat.php"><i class="fa fa-calendar-check-o"></i> Ver agenda</a></li>-->
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  
                  <!--<li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="seguimiento_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <li><a href="listado-seguimientos.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>-->
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Follow-ups</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class='treeview'>
        				<a href='seg_psi_val0.php'>
        				<i class='fa fa-check-square'></i> <span>Create assessment</span>
        				</a>
        			  </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-file-archive-o"></i>
                        <span>Follow-up</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="seg_psi0.php"><i class="fa fa-calendar"></i> Create</a></li>
                          <li><a href="seg_psi_gestion0.php"><i class="fa fa-folder-open"></i> Manage</a></li>
                        </ul>
                      </li>
                      <li class='treeview'>
        				<a href='seg_psi_cierre0.php'>
        				<i class='fa fa-times'></i> <span>Generate closure</span>
        				</a>
        			  </li>
                      <li class='treeview'>
        				<a href='listado-seguimientos.php'>
        				<i class='fa fa-angle-right'></i> <span>List</span>
        				</a>
        			  </li>
                    </ul>
                  </li>
				  
				  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Students</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
						<a href='desem_estud_per_getdat.php'>
						<i class='fa fa-bar-chart'></i> <span>Student performance</span>
						</a>
					  </li>
                      <li class="treeview">
						<a href='observaciones_est_putdat.php'>
						<i class='fa fa-pencil-square-o'></i> <span>Student observations</span>
						</a>
					  </li>
					  <li class="treeview">
						<a href="observador.php">
						<i class="fa fa-folder-open"></i> <span>Student Observer</span>
						</a>
					  </li>
					  <li class='treeview'>
						<a href='lista_est_evalpres.php'>
						<i class='fa fa-file-text'></i> <span>Admission Test Results</span>
						</a>
					  </li>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-database"></i>
                    <span>Database</span>
                    </a>
                  </li>
                  <!--<li class="treeview">
                    <a href='programar_val_putdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Programar validaciones</span>
                    </a>
                  </li>-->
				  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-calendar-check-o"></i>
                    <span>Schedule</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="programar_val_putdat.php"><i class="fa fa-calendar"></i> Schedule validations</a></li>
                      <li><a href="programar_eval_admision.php"><i class="fa fa-calendar"></i> Schedule SM admission</a></li>
                    </ul>
                  </li>
                  <!--<li class='treeview'>
    				<a href='ordenes_getdat.php'>
    				<i class='fa fa-usd'></i> <span>Ordenes de pago</span>
    				</a>
    			  </li>-->
    			  <?php  
                    if($id_administrador == 18) {
                  ?>
    			  <li class='treeview'>
    				<a href='becas_descuentos.php'>
    				<i class='fa fa-usd'></i> <span>Scholarships and discounts</span>
    				</a>
    			  </li>	
				  <li class='treeview'>
					<a href='documento_solicitud.php'>
					<i class='fa fa-sign-in'></i> <span>Enrollment Requests</span>
					</a>
				  </li>
    			  <?php  
                    }
                  ?>
                  <?php
                }
                else if ($perfil == "AW" || $perfil == "TU_AR_AW") {
                  ?>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-user"></i>
                    <span>Users</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-usuario.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-usuarios.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-picture-o"></i>
                    <span>Banner</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-banner.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="lista-baner.php"><i class="fa fa-angle-right"></i> List</a></li>
                      <li><a href="crear-banner_us.php"><i class="fa fa-angle-right"></i> Create us</a></li>
                      <li><a href="lista-baner_us.php"><i class="fa fa-angle-right"></i> List us</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Work team</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-mediador.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-mediadores.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-volume-control-phone"></i>
                    <span>Directory</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-directorio.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="lista-directorio.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span>Calendar</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-calendario.php"><i class="fa fa-angle-right"></i> Upload</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-weixin"></i>
                    <span>Social Chat</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="chat-social.php"><i class="fa fa-angle-right"></i> Configure</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-bullhorn"></i>
                    <span>Events</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-evento.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-eventos.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-noticia.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-noticias.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder-open"></i>
                    <span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-blog.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-blog.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Interviews</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Initial data</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Schedule</a></li>
                      <?php
                        if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18) {
                      ?>
                        <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Manage</a></li>
                      <?php
                        }
                      ?>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Follow-ups</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="seguimiento_putdat0.php"><i class="fa fa-calendar"></i> Schedule</a></li>
                      <li><a href="listado-seguimientos.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  <?php
                }
                else if ($perfil == "AR_AW") {
                  ?>
                  <li class="treeview">
                    <a href='agenda_putdat0.php'>
                    <i class='fa fa-calendar'></i> <span>Schedule other events</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href='entrevistas_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>View Schedule</span>
                    </a>
                  </li>
				  <li class="treeview">
                    <a href='entrevistas_carti_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>View CARTI Schedule</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Interviews</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Initial data</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Schedule</a></li>
                      <?php
                        if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18) {
                      ?>
                        <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Manage</a></li>
                      <?php
                        }
                      ?>
					  <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Follow-ups</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class='treeview'>
        				<a href='seg_psi_val0.php'>
        				<i class='fa fa-check-square'></i> <span>Create assessment</span>
        				</a>
        			  </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-file-archive-o"></i>
                        <span>Follow-up</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="seg_psi0.php"><i class="fa fa-calendar"></i> Create</a></li>
                          <li><a href="seg_psi_gestion0.php"><i class="fa fa-folder-open"></i> Manage</a></li>
                        </ul>
                      </li>
                      <li class='treeview'>
        				<a href='seg_psi_cierre0.php'>
        				<i class='fa fa-times'></i> <span>Generate closure</span>
        				</a>
        			  </li>
                      <li class='treeview'>
        				<a href='listado-seguimientos.php'>
        				<i class='fa fa-angle-right'></i> <span>List</span>
        				</a>
        			  </li>
                    </ul>
                  </li>
                  
                  <!--<li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="seguimiento_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <li><a href="listado-seguimientos.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>-->
                  
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-users"></i>
                    <span>Database</span>
                    </a>
                  </li>
                  <li class="treeview">
                    <a href='desem_estud_per_getdat.php'>
                    <i class='fa fa-bar-chart '></i> <span>Student performance</span>
                    </a>
                  </li>
                  <li class="treeview">
					<a href='observaciones_est_putdat.php'>
                    <i class='fa fa-pencil-square-o'></i> <span>Student observations</span>
                    </a>
                  </li>
				  <li class="treeview">
					<a href="observador.php">
					<i class="fa fa-folder-open"></i> <span>Student Observer</span>
					</a>
				  </li>
                  <?php
                }
                else if ($perfil == "PS") {
                  ?>
                  <li class="treeview">
                    <a href='agenda_putdat0.php'>
                    <i class='fa fa-calendar'></i> <span>Schedule other events</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href='entrevistas_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>View Schedule</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Interviews</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Initial data</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Schedule</a></li>
                      <?php
                        if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18 || $id_administrador == 42 || $id_administrador == 53) {
                      ?>
                        <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Manage</a></li>
                        <!--<li><a href="entrevistas_getdat.php"><i class="fa fa-calendar-check-o"></i> Ver agenda</a></li>-->
                      <?php
                        }
                      ?>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  <?php
                    if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18 || $id_administrador == 42 || $id_administrador == 53) {
                  ?>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Follow-ups</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class='treeview'>
        				<a href='seg_psi_val0.php'>
        				<i class='fa fa-check-square'></i> <span>Create assessment</span>
        				</a>
        			  </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-file-archive-o"></i>
                        <span>Follow-up</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="seg_psi0.php"><i class="fa fa-calendar"></i> Create</a></li>
                          <li><a href="seg_psi_gestion0.php"><i class="fa fa-folder-open"></i> Manage</a></li>
                        </ul>
                      </li>
                      <li class='treeview'>
        				<a href='seg_psi_cierre0.php'>
        				<i class='fa fa-times'></i> <span>Generate closure</span>
        				</a>
        			  </li>
                      <li class='treeview'>
        				<a href='listado-seguimientos.php'>
        				<i class='fa fa-angle-right'></i> <span>List</span>
        				</a>
        			  </li>
                    </ul>
                  </li>
                  
                  <!--<li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="seguimiento_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <li><a href="listado-seguimientos.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>-->
                  <?php
                    }
                  ?>
                  
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-users"></i>
                    <span>Database</span>
                    </a>
                  </li>
                  <li class="treeview">
                    <a href='desem_estud_per_getdat.php'>
                    <i class='fa fa-bar-chart'></i> <span>Student performance</span>
                    </a>
                  </li>
                  <?php
                    if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18 || $id_administrador == 42 || $id_administrador == 53) {
                  ?>
                      <li class="treeview">
                        <a href='observaciones_est_putdat.php'>
                        <i class='fa fa-pencil-square-o'></i> <span>Student observations</span>
                        </a>
                      </li>
					  <li class="treeview">
						<a href="observador.php">
						<i class="fa fa-folder-open"></i> <span>Student Observer</span>
						</a>
					  </li>
					  <li class='treeview'>
						<a href='lista_est_evalpres.php'>
						<i class='fa fa-file-text'></i> <span>Admission Test Results</span>
						</a>
					  </li>

                  <?php
                    }
                  ?>
                  <?php
                    if($id_administrador == 31 || $id_administrador == 18 || $id_administrador == 49) {
                    //if($id_administrador == 18) {
                    //echo '<script>alert('.$id_administrador.')</script>';
                  ?>
                  <!--<li class="treeview">
                    <a href='programar_val_putdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Programar validaciones</span>
                    </a>
                  </li>-->
				  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-calendar-check-o"></i>
                    <span>Schedule</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="programar_val_putdat.php"><i class="fa fa-calendar"></i> Schedule validations</a></li>
                      <li><a href="programar_eval_admision.php"><i class="fa fa-calendar"></i> Schedule SM admission</a></li>
                    </ul>
                  </li>
				  <li class="treeview">
					<a href='listado_estudiantes_nuevos.php'>
					<i class='fa fa-user'></i> <span>New students list</span>
					</a>
				  </li>
				  <li class='treeview'>
					<a href='documento_solicitud.php'>
					<i class='fa fa-sign-in'></i> <span>Enrollment Requests</span>
					</a>
				  </li>
                  <?php
                    }
                  ?>
                  <?php
                }
                else if ($perfil == "FI") {
                  ?>
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-users"></i>
                    <span>Database</span>
                    </a>
                  </li>
                  <!--<li class='treeview'>
					  <a href='ordenes_getdat.php'>
					  <i class='fa fa-usd'></i> <span>Ordenes de pago</span>
					  </a>
				  </li>-->
				  <li><a href="becas_descuentos.php"><i class="fa fa-usd"></i> Scholarships and discounts</a></li>
				  <li><a href="lista_comprobantes_avadmisiones.php"><i class="fa fa-usd"></i> Validate receipts</a></li>
                  <?php
                }
                else if ($perfil == "PU" || $perfil == "ST_PU") {
                  ?>
                  <!--<li class="treeview">
                    <a href="#">
                    <i class="fa fa-picture-o"></i>
                    <span>Banner</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-banner.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="lista-baner.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-calendar"></i>
                    <span>Calendario</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-calendario.php"><i class="fa fa-angle-right"></i> Cargar</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-weixin"></i>
                    <span>Chat Social</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="chat-social.php"><i class="fa fa-angle-right"></i> Configurar</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-bullhorn"></i>
                    <span>Eventos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-evento.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-eventos.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>-->
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    <span>News</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-noticia.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-noticias.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder-open"></i>
                    <span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-blog.php"><i class="fa fa-angle-right"></i> Create</a></li>
                      <li><a href="listado-blog.php"><i class="fa fa-angle-right"></i> List</a></li>
                    </ul>
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