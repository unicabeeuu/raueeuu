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
              <li class="header">MENU DE NAVEGACION </li>
              <?php  
                    if($id_administrador == 18) {
              ?>
              <li class="treeview">
                <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Cambiar sistema</span>
                <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../../../registro/adminunicab/index.php"><i class="fa fa-angle-right"></i> AR</a></li>
                  <li><a href="../../../registro/docenteunicab/index.php"><i class="fa fa-angle-right"></i> TU</a></li>
                  <li><a href="../../../tickets/login.php"><i class="fa fa-angle-right"></i> Tickets</a></li>
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
					if ($perfil == "SU") {
              ?>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-database"></i>
                    <span>Tablas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Usuarios</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="crear-usuario.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="listado-usuarios.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-picture-o"></i>
                        <span>Banner</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="crear-banner.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="lista-baner.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                          <li><a href="crear-banner_us.php"><i class="fa fa-angle-right"></i> Crear us</a></li>
                          <li><a href="lista-baner_us.php"><i class="fa fa-angle-right"></i> Listado us</a></li>
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
                        <span>Eventos</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-evento.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="listado-eventos.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-newspaper-o"></i>
                        <span>Noticias</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="registro-noticia.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="listado-noticias.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                        </ul>
                      </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-folder-open"></i>
                        <span>Blog</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="crear-blog.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                          <li><a href="listado-blog.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                        </ul>
                      </li>
					  <li class="treeview">
						<a href='listado_estudiantes_nuevos.php'>
						<i class='fa fa-user'></i> <span>Listado estudiantes nuevos</span>
						</a>
					  </li>
                      
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href='agenda_putdat0.php'>
                    <i class='fa fa-calendar'></i> <span>Agendar otros eventos</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href='entrevistas_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Ver Agenda</span>
                    </a>
                  </li>
				  <li class="treeview">
                    <a href='entrevistas_carti_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Ver Agenda CARTI</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Entrevistas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Data inicial</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Gestionar</a></li>
                      <!--<li><a href="entrevistas_getdat.php"><i class="fa fa-calendar-check-o"></i> Ver agenda</a></li>-->
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
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
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class='treeview'>
        				<a href='seg_psi_val0.php'>
        				<i class='fa fa-check-square'></i> <span>Crear valoración</span>
        				</a>
        			  </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-file-archive-o"></i>
                        <span>Seguimiento</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="seg_psi0.php"><i class="fa fa-calendar"></i> Crear</a></li>
                          <li><a href="seg_psi_gestion0.php"><i class="fa fa-folder-open"></i> Gestionar</a></li>
                        </ul>
                      </li>
                      <li class='treeview'>
        				<a href='seg_psi_cierre0.php'>
        				<i class='fa fa-times'></i> <span>Generar cierre</span>
        				</a>
        			  </li>
                      <li class='treeview'>
        				<a href='listado-seguimientos.php'>
        				<i class='fa fa-angle-right'></i> <span>Listado</span>
        				</a>
        			  </li>
                    </ul>
                  </li>
				  
				  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Estudiantes</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class="treeview">
						<a href='desem_estud_per_getdat.php'>
						<i class='fa fa-bar-chart'></i> <span>Desempeño estudiantes</span>
						</a>
					  </li>
                      <li class="treeview">
						<a href='observaciones_est_putdat.php'>
						<i class='fa fa-pencil-square-o'></i> <span>Observaciones estudiantes</span>
						</a>
					  </li>
					  <li class="treeview">
						<a href="observador.php">
						<i class="fa fa-folder-open"></i> <span>Observador Estudiante</span>
						</a>
					  </li>
					  <li class='treeview'>
						<a href='lista_est_evalpres.php'>
						<i class='fa fa-file-text'></i> <span>Resultados Eval Admisión</span>
						</a>
					  </li>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-database"></i>
                    <span>Base de datos</span>
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
                    <span>Programar</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="programar_val_putdat.php"><i class="fa fa-calendar"></i> Programar validaciones</a></li>
                      <li><a href="programar_eval_admision.php"><i class="fa fa-calendar"></i> Programar admisión SM</a></li>
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
    				<i class='fa fa-usd'></i> <span>Becas y descuentos</span>
    				</a>
    			  </li>	
				  <li class='treeview'>
					<a href='documento_solicitud.php'>
					<i class='fa fa-sign-in'></i> <span>Solicitud Matrículas</span>
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
                    <span>Usuarios</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-usuario.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-usuarios.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-picture-o"></i>
                    <span>Banner</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-banner.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="lista-baner.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li><a href="crear-banner_us.php"><i class="fa fa-angle-right"></i> Crear us</a></li>
                      <li><a href="lista-baner_us.php"><i class="fa fa-angle-right"></i> Listado us</a></li>
                    </ul>
                  </li>

                  <li class="treeview">
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
                  </li>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Noticias</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-noticia.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-noticias.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder-open"></i>
                    <span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-blog.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-blog.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Entrevistas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Data inicial</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <?php
                        if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18) {
                      ?>
                        <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Gestionar</a></li>
                      <?php
                        }
                      ?>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="seguimiento_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <li><a href="listado-seguimientos.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  <?php
                }
                else if ($perfil == "AR_AW") {
                  ?>
                  <li class="treeview">
                    <a href='agenda_putdat0.php'>
                    <i class='fa fa-calendar'></i> <span>Agendar otros eventos</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href='entrevistas_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Ver Agenda</span>
                    </a>
                  </li>
				  <li class="treeview">
                    <a href='entrevistas_carti_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Ver Agenda CARTI</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Entrevistas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Data inicial</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <?php
                        if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18) {
                      ?>
                        <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Gestionar</a></li>
                      <?php
                        }
                      ?>
					  <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class='treeview'>
        				<a href='seg_psi_val0.php'>
        				<i class='fa fa-check-square'></i> <span>Crear valoración</span>
        				</a>
        			  </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-file-archive-o"></i>
                        <span>Seguimiento</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="seg_psi0.php"><i class="fa fa-calendar"></i> Crear</a></li>
                          <li><a href="seg_psi_gestion0.php"><i class="fa fa-folder-open"></i> Gestionar</a></li>
                        </ul>
                      </li>
                      <li class='treeview'>
        				<a href='seg_psi_cierre0.php'>
        				<i class='fa fa-times'></i> <span>Generar cierre</span>
        				</a>
        			  </li>
                      <li class='treeview'>
        				<a href='listado-seguimientos.php'>
        				<i class='fa fa-angle-right'></i> <span>Listado</span>
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
                    <span>Base de datos</span>
                    </a>
                  </li>
                  <li class="treeview">
                    <a href='desem_estud_per_getdat.php'>
                    <i class='fa fa-bar-chart '></i> <span>Desempeño estudiantes</span>
                    </a>
                  </li>
                  <li class="treeview">
					<a href='observaciones_est_putdat.php'>
                    <i class='fa fa-pencil-square-o'></i> <span>Observaciones estudiantes</span>
                    </a>
                  </li>
				  <li class="treeview">
					<a href="observador.php">
					<i class="fa fa-folder-open"></i> <span>Observador Estudiante</span>
					</a>
				  </li>
                  <?php
                }
                else if ($perfil == "PS") {
                  ?>
                  <li class="treeview">
                    <a href='agenda_putdat0.php'>
                    <i class='fa fa-calendar'></i> <span>Agendar otros eventos</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href='entrevistas_getdat.php'>
                    <i class='fa fa-calendar-check-o'></i> <span>Ver Agenda</span>
                    </a>
                  </li>
                  
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Entrevistas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <!--<li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      
                      <li>**************</a></li>-->
                      <li><a href="informacion_preent.php"><i class="fa fa-database"></i> Data inicial</a></li>
                      <li><a href="entrevista_putdat0.php"><i class="fa fa-calendar"></i> Agendar</a></li>
                      <?php
                        if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18 || $id_administrador == 42 || $id_administrador == 53) {
                      ?>
                        <li><a href="gestionar_entrevista.php"><i class="fa fa-check-square"></i> Gestionar</a></li>
                        <!--<li><a href="entrevistas_getdat.php"><i class="fa fa-calendar-check-o"></i> Ver agenda</a></li>-->
                      <?php
                        }
                      ?>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  <?php
                    if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18 || $id_administrador == 42 || $id_administrador == 53) {
                  ?>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Seguimientos</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li class='treeview'>
        				<a href='seg_psi_val0.php'>
        				<i class='fa fa-check-square'></i> <span>Crear valoración</span>
        				</a>
        			  </li>
                      <li class="treeview">
                        <a href="#">
                        <i class="fa fa-file-archive-o"></i>
                        <span>Seguimiento</span>
                        <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="seg_psi0.php"><i class="fa fa-calendar"></i> Crear</a></li>
                          <li><a href="seg_psi_gestion0.php"><i class="fa fa-folder-open"></i> Gestionar</a></li>
                        </ul>
                      </li>
                      <li class='treeview'>
        				<a href='seg_psi_cierre0.php'>
        				<i class='fa fa-times'></i> <span>Generar cierre</span>
        				</a>
        			  </li>
                      <li class='treeview'>
        				<a href='listado-seguimientos.php'>
        				<i class='fa fa-angle-right'></i> <span>Listado</span>
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
                    <span>Base de datos</span>
                    </a>
                  </li>
                  <li class="treeview">
                    <a href='desem_estud_per_getdat.php'>
                    <i class='fa fa-bar-chart'></i> <span>Desempeño estudiantes</span>
                    </a>
                  </li>
                  <?php
                    if($id_administrador == 2 || $id_administrador == 4 || $id_administrador == 5 || $id_administrador == 18 || $id_administrador == 42 || $id_administrador == 53) {
                  ?>
                      <li class="treeview">
                        <a href='observaciones_est_putdat.php'>
                        <i class='fa fa-pencil-square-o'></i> <span>Observaciones estudiantes</span>
                        </a>
                      </li>
					  <li class="treeview">
						<a href="observador.php">
						<i class="fa fa-folder-open"></i> <span>Observador Estudiante</span>
						</a>
					  </li>
					  <li class='treeview'>
						<a href='lista_est_evalpres.php'>
						<i class='fa fa-file-text'></i> <span>Resultados Eval Admisión</span>
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
                    <span>Programar</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="programar_val_putdat.php"><i class="fa fa-calendar"></i> Programar validaciones</a></li>
                      <li><a href="programar_eval_admision.php"><i class="fa fa-calendar"></i> Programar admisión SM</a></li>
                    </ul>
                  </li>
				  <li class="treeview">
					<a href='listado_estudiantes_nuevos.php'>
					<i class='fa fa-user'></i> <span>Listado estudiantes nuevos</span>
					</a>
				  </li>
				  <li class='treeview'>
					<a href='documento_solicitud.php'>
					<i class='fa fa-sign-in'></i> <span>Solicitud Matrículas</span>
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
                    <span>Base de datos</span>
                    </a>
                  </li>
                  <!--<li class='treeview'>
					  <a href='ordenes_getdat.php'>
					  <i class='fa fa-usd'></i> <span>Ordenes de pago</span>
					  </a>
				  </li>-->
				  <li><a href="becas_descuentos.php"><i class="fa fa-usd"></i> Becas y descuentos</a></li>
				  <li><a href="lista_comprobantes_avadmisiones.php"><i class="fa fa-usd"></i> Validar comprobantes</a></li>
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
                    <span>Noticias</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="registro-noticia.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-noticias.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-folder-open"></i>
                    <span>Blog</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-blog.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-blog.php"><i class="fa fa-angle-right"></i> Listado</a></li>
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