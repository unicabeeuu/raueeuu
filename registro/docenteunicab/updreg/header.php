		<?php  
		    include "conteo_est_getdat.php";
		?>
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div class="header-stats">
			        <label style="color: blue;"><i class="fa fa-users"></i><?php echo $total_usuarios_m; ?> M</label>
				    <label style="color: green;"><i class="fa fa-users"></i><?php echo $total_usuarios_r; ?> R</label>
				    <label style="color: #F20F1C;">Pre (</label>
				    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_s; ?> Ant.</label>
				    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_s1; ?> Nuev.</label>
				    <label style="color: #F20F1C;"> )</label>
				    <label style="color: orange;"> Sol (</label>
				    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn; ?> Ant.</label>
				    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn1; ?> Nue.</label>
				    <label style="color: orange;"> )</label>
				    <label style="color: #F20FEB;"><i class="fa fa-users"></i><?php echo $mat_efec; ?> Mat. Efec</label>
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
									<span class="prfil-img"><img src="../../images/profesor.png" alt=""> </span> 
									<div class="user-name">
										<p>Bienvenido</p>
										<span><?php echo $_SESSION['uniprofe']; ?></span>
									</div>
									<i class="fa fa-angle-down lnr"></i>
									<i class="fa fa-angle-up lnr"></i>
									<div class="clearfix"></div>	
								</div>	
							</a>
							<ul class="dropdown-menu drp-mnu">
								<li> <a href="#" data-toggle="modal" data-target="#myModal" title="Edit User Personal Data"><i class="fa fa-user"></i> Datos Personales</a> </li> 
								<li> <a href="logout-profesor.php" title="Log Out"><i class="fa fa-sign-out"></i> Log Out</a> </li>
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
				        <label style="color: black;">Number of active students in Record.</label>
				    </div>
				    <div class="row">
    				    <label style="color: #F20F1C;">Pre (</label>
    				    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_s; ?> Ant.</label>
    				    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_s1; ?> Nuev.</label>
    				    <label style="color: #F20F1C;"> )</label>
    				    <label style="color: black;">Number of old and new students in pre-request status.</label>
				    </div>
				    <div class="row">
				        <label style="color: orange;">Sol (</label>
    				    <label style="color: brown;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn; ?> Ant.</label>
    				    <label style="color: purple;"><i class="fa fa-users"></i><?php echo $total_usuarios_sn1; ?> Nue.</label>
    				    <label style="color: orange;"> )</label>
    				    <label style="color: black;">Number of old and new students in request status.</label>
				    </div>
				    <div class="row">
				        <label style="color: #F20FEB;"><i class="fa fa-users"></i><?php echo $mat_efec; ?> Mat. Efec</label>
				        <label style="color: black;">Active students in Record plus students in request status.</label>
				    </div>
			    </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-warning" id="btnguardar" data-dismiss="modal" style="display: none;" onclick="guardar()">Save</button>-->
                
              </div>
            </div>
            </div>
          </div>
        </div>