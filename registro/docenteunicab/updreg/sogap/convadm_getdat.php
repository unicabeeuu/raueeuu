<?php
	
	require("1cc3s4db.php");
	include "mcript.php";
	
	//$nomneg=strtoupper($_POST['txtnomneg']);
	$idconv=strtoupper($_REQUEST['selconv']);
	$pass0=$_REQUEST['pc'];
	//echo $pass0;
	
	$pass=$_REQUEST['pc'];
	$pass = $gen_enc($pass);
	$pass = str_replace("+","_",$pass);
	//echo $pass;
	
	$msg=str_replace("_"," ",$_REQUEST['msg']);
	$msgt=$_REQUEST['msgt'];
	
	$query0="SELECT * FROM tbl_cp WHERE id = '$idconv' AND estado = 'ACTIVO'";
	//echo $query0;
	$resultado0=$mysqli1->query($query0);
	while($row0 = $resultado0->fetch_assoc()){
	    $nomconv1=$row0['convenio'];
		$pass1=$row0['pc'];
	}
	//echo $pass1;
	
?>

<html lang="es">
	<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
		<title></title>
		
		<link rel="stylesheet" href="chosen/chosen.css">
	    <link rel="stylesheet" href="chosen/ImageSelect.css">
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/reg.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<script type="text/javascript" src="../js/gridviewscroll.js"></script>
		<script type="text/javascript" src="../js/Chart.bundle.min.js"></script>
		
		<script type="text/javascript" src="js/chosen.jquery.js"></script>
		<script type="text/javascript" src="js/ImageSelect.jquery.js"></script>
		
		<style>
		    body {
				width: 100%;
				height: 100%;
				width: 100%;
				height: 100%;
				background-image: url("img/fondo_h_1.png");
				//background-position: 50% 50%;
				background-repeat: no-repeat;
				//background-attachment: fixed;
				
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-ms-background-size: cover;
				 background-size: cover;
			}
			fieldset {
            	border: 2px double green;
            	-moz-border-radius: 8px;
            	-webkit-border-radius: 8px;	
            	border-radius: 8px;
            	background-color:white;
				opacity: 0.7;
            }
            legend {
            	 text-align: center;
            	 font-weight: bold;
            	 font-size: 18pt;
            	 color: #B4045F;
            	 text-shadow: 0px 0px 10px #BA55D3;
            }
			.mprincipal1 {
            	list-style-image: url("img/m26.png");
            	font-weight: bold;
	            font-size: 18px;
            }
            .msecund {
            	list-style-image: url(../img/bd30.png); 
            	background: lightgreen;
            	padding: 20px;
            	font-weight: bold;
            	font-size: 16px;
            	color: blue;
            }
            .msecund li {
            	background: #cce5ff;
            	margin-left: 20px;
            	margin-top: 5px;
            }
			.txtid {
				width: 80px;
				border: none;
				border-bottom: 2px solid green;
				background-color: honeydew;
			}
			.txtid1 {
				width: 200px;
				border: none;
				border-bottom: 2px solid green;
				background-color: honeydew;
			}
			select {
			    font-size: 16px !important;
			}
			#tbltot {
				background-color: #f3e4fc;
			}
			.tdt {
				border-bottom: 1px solid lightgray;
			}
			.tdt:first-child {
				border-right: 2px solid blue;
			}
			#div1 {
				//width: 70%;
				display: inline-block;
			}
			#div2 {
				//width: 30%;
				display: inline-block;
			}
			#contenedor, #divenc {
				display: flex;
				justify-content: space-around;
			}
			#ulest {
				list-style:none;
			}
			#ulest li {
				display: inline;
				text-align: center;
				margin-right: 10px;
			}
			#li1 {
				color: green;
				font-weight:bold;
			}
			#li2 {
				color: orange;
				font-weight:bold;
			}
			#li3 {
				color: red;
				font-weight:bold;
			}
			#li4 {
				color: purple;
				font-weight:bold;
			}
		</style>
		<script type="text/javascript">
		    $(function() {
		        var msgt = "<?php echo $msgt; ?>";
                //alert(msgt);
                if(msgt == "error") {
                    $("#lblmsg").css("color","red");
                }
                else if(msgt == "ok") {
                    $("#lblmsg").css("color","green");
                }
                
                /*$("#selest1").change(function() {
            		var est = $("#selest1").val();
            		var est1 = $("#seltrana").val();
            		if(est == "NA" || est1 == "NA") {
            			$("#btnest1").hide();
            		}
            		else {
            		    $("#btnest1").show();
            		}
            	});
            	
            	$("#selest2").change(function() {
            		var est = $("#selest2").val();
            		var est1 = $("#seltranp").val();
            		if(est == "NA" || est1 == "NA") {
            			$("#btnest2").hide();
            		}
            		else {
            		    $("#btnest2").show();
            		}
            	});*/
            	
            	$("#seltrana").change(function() {
            		var est = $("#selest1").val();
            		var est1 = $("#seltrana").val();
            		//if(est == "NA" || est1 == "NA") {
            		if(est1 == "NA") {
            			$("#btnest1").hide();
            		}
            		else {
            		    $("#btnest1").show();
            		}
            	});
            	
            	$("#seltranp").change(function() {
            		var est = $("#selest2").val();
            		var est1 = $("#seltranp").val();
            		if(est1 == "NA") {
            			$("#btnest2").hide();
            		}
            		else {
            		    $("#btnest2").show();
            		}
            	});
            });
            
			/*function validar(frm) {
				if(frm.razon.value.length > 100) { 
					alert('Ingrese hasta 100 caracteres en la razón de cancelación') ; 
					return false ;  
				}
			}*/
		</script>
	</head>
	<body>
		<center>
			<?php
				if($pass != $pass1){
				    //echo $pass;
				    //echo $pass1;
					//require("mail_pass.php?idneg=".$idneg."&npass=".$pass);
					header("Location: adm_conv_ini.php?msg=error1");
					echo "<script>location.href='adm_conv_ini.php?msg=error1'</script>";
				}
			?>
			<div id="divenc">
				<div>
					<img src="img/logo_ac_.png" width="150px" height="150px"/>
				</div>
				<div>
					<h2>Convenio: <label style="background-color: #f3e4fc; color: blue;"><?php echo $nomconv1; ?></label></h2><br/>
					<fieldset style="width: 400px;">
            		    <legend><h4>MENSAJES</h4></legend>
            		    <center>
            		        <label id="lblmsg"><?php echo $msg; ?></label>
            		    </center>
            		</fieldset>
				</div>
				<div>
					<table id="tbltot">
        				<tr></tr>
        				<tr></tr>
        				<tr><td colspan="2"  style="text-align:center; color: blue;"><b>Cantidad de Transacciones por Estado</b></td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btntc1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query1="SELECT count(1) cantidad, estado FROM tbl_transac_tc WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query1;
        								$resultado1=$mysqli1->query($query1);
        								echo "<ul id='ulest'>";
        								while($row = $resultado1->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row['estado'].": ".$row['cantidad']."</li>";
        									}
        									else if(strtoupper($row['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row['estado'].": ".$row['cantidad']."</li>";
        									}
        									else if(strtoupper($row['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row['estado'].": ".$row['cantidad']."</li>";
        									}
        									else if(strtoupper($row['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row['estado'].": ".$row['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado1->close();
        							?>
        					</td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btnpse1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query2="SELECT count(1) cantidad, estado FROM tbl_transac_pse WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query2;
        								$resultado2=$mysqli1->query($query2);
        								echo "<ul id='ulest'>";
        								while($row2 = $resultado2->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row2['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row2['estado'].": ".$row2['cantidad']."</li>";
        									}
        									else if(strtoupper($row2['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row2['estado'].": ".$row2['cantidad']."</li>";
        									}
        									else if(strtoupper($row2['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row2['estado'].": ".$row2['cantidad']."</li>";
        									}
        									else if(strtoupper($row2['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row2['estado'].": ".$row2['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado2->close();
        							?>
        					</td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btnef1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query3="SELECT count(1) cantidad, estado FROM tbl_transac_ef WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query3;
        								$resultado3=$mysqli1->query($query3);
        								echo "<ul id='ulest'>";
        								while($row3 = $resultado3->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row3['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row3['estado'].": ".$row3['cantidad']."</li>";
        									}
        									else if(strtoupper($row3['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row3['estado'].": ".$row3['cantidad']."</li>";
        									}
        									else if(strtoupper($row3['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row3['estado'].": ".$row3['cantidad']."</li>";
        									}
        									else if(strtoupper($row3['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row3['estado'].": ".$row3['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado3->close();
        							?>
        					</td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btnbal1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query4="SELECT count(1) cantidad, estado FROM tbl_transac_bal WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query4;
        								$resultado4=$mysqli1->query($query4);
        								echo "<ul id='ulest'>";
        								while($row4 = $resultado4->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row4['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado3->close();
        							?>
        					</td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btnpred1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query4="SELECT count(1) cantidad, estado FROM tbl_transac_punr WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query4;
        								$resultado4=$mysqli1->query($query4);
        								echo "<ul id='ulest'>";
        								while($row4 = $resultado4->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row4['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado3->close();
        							?>
        					</td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btnsred1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query4="SELECT count(1) cantidad, estado FROM tbl_transac_reds WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query4;
        								$resultado4=$mysqli1->query($query4);
        								echo "<ul id='ulest'>";
        								while($row4 = $resultado4->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row4['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado3->close();
        							?>
        					</td>
        				</tr>
        				<tr style="text-align:center; border: 2px solid green;"><td><img src="img/btngana1.png" width="80px" height="27px"/></td><td style="text-align:center; ">
        						<?php
        								$query4="SELECT count(1) cantidad, estado FROM tbl_transac_gana WHERE convenio = '$nomconv1' GROUP BY estado";
        								//echo $query4;
        								$resultado4=$mysqli1->query($query4);
        								echo "<ul id='ulest'>";
        								while($row4 = $resultado4->fetch_assoc()){
        								    //echo strtoupper($row['estado']);
        									if(strtoupper($row4['estado']) == "ACEPTADA") {
        										echo "<li id='li1'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "PENDIENTE") {
        										echo "<li id='li2'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "RECHAZADA") {
        										echo "<li id='li3'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}
        									else if(strtoupper($row4['estado']) == "EXPIRADA") {
        										echo "<li id='li4'>".$row4['estado'].": ".$row4['cantidad']."</li>";
        									}									
        								}
        								echo "</ul>";
        								$resultado3->close();
        							?>
        					</td>
        				</tr>
        			</table>
				</div>
			</div><br/>
			<!--<h2>Datos Convenio: <label style="background-color:lightcyan"><?php echo $conv; ?></label></h2><br/>-->
			
		</center>
		<!--**************************************************************************************************************************************************-->
		<div id="contenedor">
			<div id="div1">
				<fieldset>
				<legend><h4>CONSULTAS</h4></legend>
					<ul class="mprincipal1">
						<li><h4>Transacciones anuales o periodos</h4></li>
							<ul class="msecund">
								<li>
									<form name="f_cargaritem" method="post" action="tranest_getdat.php?p=1" target="_blank">
										<label>Anual ...</label><input type="text" id="ano" name="ano" class="txtid" placeholder="YYYY" pattern="^(2){1}(0){1}[1-9]{1}[0-9]{1}$" required />
										<select id="selest1" name="selest1">
										    <option value="NA" selected>SEL. ESTADO</option>
										    <option value="ACEPTADA">ACEPTADA</option>
										    <option value="EXPIRADA">EXPIRADA</option>
										    <option value="PENDIENTE">PENDIENTE</option>
										    <option value="RECHAZADA">RECHAZADA</option>
										</select>
										<select id="seltrana" name="seltrana" class="my-select">
                                			<option selected="selected" data-img-src="img/btnseltran1.png" value="NA">TT</option>
                                			<option data-img-src="img/btntc1.png"  value="TC">TC</option>
                                			<option data-img-src="img/btnpse1.png"  value="PSE">PSE</option>
                                			<option data-img-src="img/btnef1.png"  value="EF">EF</option>
                                			<option data-img-src="img/btnbal1.png"  value="BAL">BA</option>
                                			<option data-img-src="img/btnpred1.png"  value="PR">PR</option>
                                			<option data-img-src="img/btnsred1.png"  value="RS">RS</option>
                                			<option data-img-src="img/btngana1.png"  value="GA">GA</option>
                                		</select>
										<input type="submit" class="btn btn-primary btn-lg" value="Cargar" id="btnest1" style="display: none;"/>
										<input type="hidden" id="txtnomconva" name="txtnomconva" value="<?php echo str_replace(" ","_",$nomconv1); ?>" />
										<input type="hidden" id="txtidconva" name="txtidconva" value="<?php echo $idconv; ?>" />
										<input type="hidden" id="txtpca" name="txtpca" value="<?php echo $pass0; ?>" />
									</form>
								</li>
								<li>
									<form name="f_cargaritem" method="post" action="tranest_getdat1.php?p=1" target="_blank">
										<label>Periodo ...</label><input type="text" id="anomes" name="anomes" class="txtid" placeholder="YYYYMM" pattern="^(2){1}(0){1}[1-9]{1}[0-9]{1}[0-1]{1}[1-9]{1}$" required />
										<select id="selest2" name="selest2">
										    <option value="NA" selected>SEL. ESTADO</option>
										    <option value="ACEPTADA">ACEPTADA</option>
										    <option value="EXPIRADA">EXPIRADA</option>
										    <option value="PENDIENTE">PENDIENTE</option>
										    <option value="RECHAZADA">RECHAZADA</option>
										</select>
										<select id="seltranp" name="seltranp" class="my-select">
                                			<option selected="selected" data-img-src="img/btnseltran1.png" value="NA">TT</option>
                                			<option data-img-src="img/btntc1.png"  value="TC">TC</option>
                                			<option data-img-src="img/btnpse1.png"  value="PSE">PSE</option>
                                			<option data-img-src="img/btnef1.png"  value="EF">EF</option>
                                			<option data-img-src="img/btnbal1.png"  value="BAL">BA</option>
                                			<option data-img-src="img/btnpred1.png"  value="PR">PR</option>
                                			<option data-img-src="img/btnsred1.png"  value="RS">RS</option>
                                			<option data-img-src="img/btngana1.png"  value="GA">GA</option>
                                		</select>
										<input type="submit" class="btn btn-primary btn-lg" value="Cargar" id="btnest2" style="display: none;"/>
										<input type="hidden" id="txtnomconvp" name="txtnomconvp" value="<?php echo $nomconv1; ?>" />
										<input type="hidden" id="txtidconvp" name="txtidconvp" value="<?php echo $idconv; ?>" />
										<input type="hidden" id="txtpcp" name="txtpcp" value="<?php echo $pass0; ?>" />
									</form>
								</li>
							</ul>
					</ul>
					<ul class="mprincipal1">
						<li><h4>Buscar transacciones en forma personalizada</h4></li>
							<ul class="msecund">
								<li>
									<form name="f_cargaritem" method="post" action="tranper_getdat.php?p=1" target="_blank">
									    <label>Periodo ...</label><input type="text" id="anomesb" name="anomesb" class="txtid1" placeholder="YYYY o YYYYMM" pattern="^(2){1}(0){1}[1-9]{1}[0-9]{1}[0-1]?[1-9]?$" />
										<input type="text" id="buscar" name="buscar" class="txtid1" placeholder="* Ingrese texto a buscar" pattern="^[A-Za-z0-9_-\s]{1,}$" required />
										<input type="submit" class="btn btn-primary btn-lg" value="Buscar" id="btnbuscar" />
										<input type="hidden" id="txtnomconvb" name="txtnomconvb" value="<?php echo str_replace(" ","_",$nomconv1); ?>" />
										<input type="hidden" id="txtidconvb" name="txtidconvb" value="<?php echo $idconv; ?>" />
										<input type="hidden" id="txtpcb" name="txtpcb" value="<?php echo $pass0; ?>" />
									</form>
								</li>
							</ul>
					</ul>
				
				</fieldset>
			</div>
			<div id="div2">
				<fieldset>
				<legend><h4>PROCESOS</h4></legend>
					<ul class="mprincipal1">
						<li><h4>Modificaciones</h4></li>
							<ul class="msecund">
								<li><label>Actualizar estado ...</label><a class="btn btn-primary btn-lg" href="actualizar_esttran_upddat1.php?nomconv=<?php echo str_replace(' ','_',$nomconv1); ?>&pc=<?php echo $pass0; ?>&idconv=<?php echo $idconv; ?>" >Actualizar</a>
								</li>
								<li><label>Cambiar password ...</label><button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                            		  Cambiar
                            		</button>
                            	</li>
							</ul>
					</ul>
					<ul class="mprincipal1">
						<li><h4>Cargar pagos</h4></li>
							<ul class="msecund">
								<li><label>Pago individual ...</label><a class="btn btn-primary btn-lg" href="pago_nuevo_form.php?nomconv=<?php echo str_replace(' ','_',$nomconv1); ?>&idconv=<?php echo $idconv; ?>" target="_blank">Cargar</a>
                            	</li>
							</ul>
							<ul class="msecund">
								<li><label>Pagos anuales ...</label><a class="btn btn-primary btn-lg" href="" target="_blank">Cargar</a>
                            	</li>
							</ul>
					</ul>
					
				</fieldset>
                <a href="adm_conv_ini.php">Salir</a>
			</div>
		</div>
		<!--**************************************************************************************************************************************************-->
		
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
				<h4 class="modal-title" id="myModalLabel">Cambiar password</h4>
			  </div>
			  <form method="post" action="pc_upddat.php" >
    			  <div class="modal-body">
        				  <label>Password actual: </label>
        				  <input type="password" id="pa" name="pa" required/><br />
        				  <label>Password nuevo: </label>
        				  <input type="password" id="pn" name="pn" required/>
        				  <input type="hidden" id="idconv" name="idconv" value="<?php echo $idconv; ?>"/>
        				  <input type="hidden" id="pc" name="pc" value="<?php echo $pass0; ?>"/>
    			  </div>
    			  <div class="modal-footer">
        			  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        			  <!--<button type="button" class="btn btn-primary">Actualizar</button>-->
        			  <input type="submit" value="Actualizar" class="btn btn-primary" />
    			  </div>
			  </form>
			</div>
		  </div>
		</div>
		
		<script>
		 $(".my-select").chosen({width:"170px"});
		</script>
		
	</body>
</html>