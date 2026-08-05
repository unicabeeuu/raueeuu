<!-- header-starts -->
<?php 
    # session_start(); Session is already started in index.php, no need to start it again here
    include "../../registro/docenteunicab/updreg/conteo_est_getdat.php";
    
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
<div class="sticky-header header-section ">
	<div class="header-left">
		<!--toggle button start-->
		<button id="showLeftPush"><i class="fa fa-bars"></i></button>
		<!--toggle button end-->
		<div style="margin-left: 100px;">
	        <label style="color: blue;"><i class="fa fa-users"></i><?php echo $total_usuarios_m; ?> M</label>
		    <label style="color: green;"><i class="fa fa-users"></i><?php echo $total_usuarios_r; ?> R</label>
		    <label style="color: #F20F1C;">Pre (</label>
		    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_s; ?> Prev.</label>
		    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_s1; ?> New</label>
		    <label style="color: #F20F1C;"> )</label>
		    <label style="color: orange;"> Sol (</label>
		    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn; ?> Prev.</label>
		    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn1; ?> New</label>
		    <label style="color: orange;"> )</label>
		    <label style="color: #F20FEB;"><i class="fa fa-users"></i><?php echo $mat_efec; ?> Enrolled</label>
			<label style="color: black;"><i class="fa fa-users"></i><?php echo $total_usuarios_proceso_abierto; ?> Open Proc.</label>
		    <label style="color: green;"><button data-toggle="modal" data-target="#modal_detalle"><i class="fa fa-info-circle"></i></button></label>
	    </div>
		<div class="clearfix"> </div>
	</div>
	<div class="header-right">		
		<div class="profile_details">		
			<ul>
				<li class="dropdown profile_details_drop">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<div class="profile_img">	
							<span class="prfil-img"><img src="../images/user.png" alt=""> </span> 
							<div class="user-name">
								<p><?php //echo $perfil; ?></p>
								<span><?php echo $_SESSION['nombre']; ?></span>
							</div>
							<i class="fa fa-angle-down lnr"></i>
							<i class="fa fa-angle-up lnr"></i>
							<div class="clearfix"></div>	
						</div>	
					</a>
					<ul class="dropdown-menu drp-mnu">
						<li> <a href="../../index.php" target="blanck"><i class="fa fa-send"></i> View site</a> </li>
						<li> <a href="include/logout.php"><i class="fa fa-sign-out"></i> Log out</a> </li>
					</ul>
				</li>
			</ul>
		</div>
		<div class="clearfix"> </div>				
	</div>
	<div class="clearfix"> </div>	
</div>
<!-- //header-ends -->

<!-- Modal de detalle -->
<div class="modal fade" id="modal_detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">STATISTICS DETAIL</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div style="margin-left: 100px;">
            <div class="row">
	            <label style="color: blue;"><i class="fa fa-users"></i><?php echo $total_usuarios_m; ?> M</label>
	            <label style="color: black;">Number of students in Moodle.</label>
	        </div>
	        <div class="row">
		        <label style="color: green;"><i class="fa fa-users"></i><?php echo $total_usuarios_r; ?> R</label>
		        <label style="color: black;">Number of active students in the Registry.</label>
		    </div>
		    <div class="row">
			    <label style="color: #F20F1C;">Pre (</label>
			    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_s; ?> Prev.</label>
			    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_s1; ?> New</label>
			    <label style="color: #F20F1C;"> )</label>
			    <label style="color: black;">Number of returning and new students with pre_solicitud status.</label>
		    </div>
		    <div class="row">
		        <label style="color: orange;">Sol (</label>
			    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn; ?> Prev.</label>
			    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn1; ?> New</label>
			    <label style="color: orange;"> )</label>
			    <label style="color: black;">Number of returning and new students with solicitud status.</label>
		    </div>
		    <div class="row">
		        <label style="color: #F20FEB;"><i class="fa fa-users"></i><?php echo $mat_efec; ?> Enrolled</label>
		        <label style="color: black;">Active students in the Registry plus students with solicitud status.</label>
		    </div>
			<div class="row">
				<label style="color: black;"><i class="fa fa-users"></i><?php echo $total_usuarios_proceso_abierto; ?> Open Proc.</label>
				<label style="color: black;">Students who started the process through the virtual assistant and have not taken the admission test.</label>
			</div>
	    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" style="display: none;" onclick="guardar()">Guardar</button>-->
        
      </div>
    </div>
    </div>
  </div>
</div>