<?php 
  $sqlAdministrador="SELECT * FROM `administrador` WHERE `Email`='".$_SESSION['admin_unicab']."'";
    $exeAdministrador=mysqli_query($conexion,$sqlAdministrador);

    while ($rowAdmin=mysqli_fetch_array($exeAdministrador)) {
      $id_administrador=$rowAdmin['IdAdministrador'];
      $nombre=$rowAdmin['Nombre'];
      $apellido=$rowAdmin['Apellido'];
      $email=$rowAdmin['Email'];
      $perfil=$rowAdmin['Perfil'];
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
            <h1><a class="navbar-brand" href="index.php"><img src="../../assets/img/footer-logo.png" width="50%"></a></h1>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="sidebar-menu">
              <li class="header">MENU DE NAVEGACION </li>
              <li class="treeview">
                <a href="index.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
                </a>
              </li>
              <?php 
                if ($perfil=="Administrador") {
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
                      <li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  <?php 
                }else if ($perfil=="Psicólogo") {
                  ?>
                  <li class="treeview">
                    <a href="#">
                    <i class="fa fa-commenting"></i>
                    <span>Entrevistas</span>
                    <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="crear-entrevista.php"><i class="fa fa-angle-right"></i> Crear</a></li>
                      <li><a href="listado-entrevistas.php"><i class="fa fa-angle-right"></i> Listado</a></li>
                    </ul>
                  </li>
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-users"></i>
                    <span>Base de datos</span>
                    </a>
                  </li>
                  <?php
                }else if ($perfil=="Financiero") {
                  ?>
                  <li class="treeview">
                    <a href="adm2_1.php">
                    <i class="fa fa-users"></i>
                    <span>Base de datos</span>
                    </a>
                  </li>
                  <?php
                }else if ($perfil=="Publicista") {
                  ?>
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
                  <?php
                }

              ?>
            </ul>
          </div>
          <!-- /.navbar-collapse -->
      </nav>
    </aside>
  </div>