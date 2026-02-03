<!-- modal -->
<div id="myModal" data-backdrop="static" class="modal fade" role="dialog">
  	<div class="modal-dialog">
    	<!-- Modal content-->
	    <div class="modal-content">
	      	<div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
	     	    <h4 class="modal-title">Actualizar datos personales</h4>
	    	</div>
			<div class="modal-body">
			<!-- formulario -->
				<div class="form-body">
					<form class="form-horizontal" action="php/update-administrativos.php" method="POST">
							<div class="form-group">
								<label for="email_institucional" class="col-sm-2 control-label">Correo Institucional</label>
								<div class="col-sm-8">
									<input type="email" class="form-control1" id="email_institucional" name="email_institucional" readonly="readonly" value="<?php echo $email_institucional;?>">
								</div>
							</div>

							<div class="form-group">				
								<label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="apellidos" name="apellidos" readonly="readonly" value="<?php echo $apellidos;?>">
								</div>
							</div>

							<div class="form-group">
								<label for="nombres" class="col-sm-2 control-label">Nombres</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="nombres" name="nombres" readonly="readonly" value="<?php echo $nombres;?>">
								</div>
							</div>

							<div class="form-group">
								<label for="n_documento" class="col-sm-2 control-label">Identificación</label>
								<div class="col-sm-8">
									<input type="text" class="form-control1" id="n_documento" name="n_documento" readonly="readonly" value="<?php echo $n_documento;?>">
								</div>
							</div>

							<div class="form-group">
								<label for="password" class="col-sm-2 control-label">Contraseña</label>
								<div class="col-sm-8">
									<input type="password" class="form-control1" id="password" name="password" required maxlength="15"
									placeholder="Contraseña Docente" value="<?php echo $password;?>">
								</div>
							</div>

							<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

							<div class="modal-footer">
		      					<input type="submit" class="btn btn-primary" value="Guardar Cambios">
		      				</div>
					</form> 
				</div>
	        	<!-- fin formulario -->
			</div>
	  	</div>
	</div>
</div>
<!-- modal