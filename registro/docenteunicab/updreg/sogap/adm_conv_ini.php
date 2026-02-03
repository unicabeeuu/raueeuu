<?php
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='adm.php'");
	
	$msg=str_replace("_"," ",$_REQUEST['msg']);
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
		<title></title>
		
		<link type="text/css" href="css/reg.css" rel="stylesheet" />
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		<style>
			#cont {
				display: flex;
				justify-content: space-around;
			}
			input[type=text], input[type=password] {
				border: none;
				border-bottom: 2px solid green;
				background-color: honeydew;
			}
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
		</style>
	</head>
	<body>
		<center>
			<div id="enc">
				<img src="img/fondo_land_.png" alt="fondo_land" />
			</div>
		</center>		
		<center><h2>ADMINISTRACION DE PAGOSGHF PARA CONVENIO</h2></center>
		<div id="cont">
			<div id="div1">
				<fieldset>
				<legend><h3>INICIO DE SESION</h3></legend>
					<form method="POST" enctype="multipart/form-data" action="convadm_getdat.php" onsubmit="return validar(this);">
						<table>
							<tr>
								<td colspan="2" style="text-align:center"><img src="img/logo_ac_.png"/>
								</td>
							</tr>
							<tr>
								<td><h3>Convenio</h3></td>
								<td><!--<input type="text" name="txtnomneg" required />-->
								<?php
									//Cargar convenios
									echo "<select name='selconv' required>";
									echo "<option value='0'>Seleccione Convenio</option>";
									$query1="SELECT id, convenio FROM tbl_cp WHERE id > 0";
									$resultado1=$mysqli1->query($query1);
									while($row = $resultado1->fetch_assoc()){
										echo "<option value='".$row['id']."'>".$row['convenio']."</option>";
									}
									echo "</select>";
									$resultado1->close();
								?>
								</td>
							</tr>
							<tr>
								<td><h3>Password<label>...</label></h3></td>
								<td><input type="password" name="pc" required /></td>
							</tr>
							<tr>
								<td></td>
								<td><input type="submit" class="btn btn-primary btn-lg" value="Login" /></td>
							</tr>
							<tr></tr>
							<tr>
								<td colspan="2" style="text-align:center; color:red">
									<?php
										if($msg == "error1") {
											echo "El password no es correcto";
										}
									?>
								</td>
							</tr>
						</table>
					</form>
					
				</fieldset>
			</div>
			
		</div>
	</body>
</html>