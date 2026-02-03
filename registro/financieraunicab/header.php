		<?php  
		    include "../docenteunicab/updreg/conteo_est_getdat.php";
		?>
		<!-- header-starts -->
		<div class="sticky-header header-section ">
			<div class="header-left">
				<!--toggle button start-->
				<button id="showLeftPush"><i class="fa fa-bars"></i></button>
				<!--toggle button end-->
				<div style="margin-left: 100px;">
			        <label style="color: blue;"><i class="fa fa-users"></i><?php echo $total_usuarios_m; ?> M</label>
				    <label style="color: green;"><i class="fa fa-users"></i><?php echo $total_usuarios_r; ?> R</label>
			    </div>
				<div class="clearfix"> </div>
			</div>
			<div class="header-right">
				
				<div class="profile_details">		
					<ul>
						<li class="dropdown profile_details_drop">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<div class="profile_img">	
									<span class="prfil-img"><img src="../images/profesor.png" alt=""> </span> 
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
								<li> <a href="#" data-toggle="modal" data-target="#myModal" title="Editar Datos Personales Usuario"><i class="fa fa-user"></i> Datos Personales</a> </li> 
								<li> <a href="../docenteunicab/updreg/logout-profesor.php" title="Salir del Sistema"><i class="fa fa-sign-out"></i> Cerrar Sesión</a> </li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="clearfix"> </div>				
			</div>
			<div class="clearfix"> </div>	
		</div>
		<!-- //header-ends -->