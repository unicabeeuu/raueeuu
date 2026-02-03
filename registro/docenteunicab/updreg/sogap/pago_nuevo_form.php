<?php
	require("1cc3s4db.php");
	
	$nomconv=strtoupper(str_replace("_"," ",$_REQUEST['nomconv']));
	$idconv=$_REQUEST['idconv'];
	//echo $nomconv;
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$a = date("Y",$fecha);
	/*if($dia < 10) {
		$dia = "0".$dia;
	}
	if($mes < 10) {
		$mes = "0".$mes;
	}*/
	$fecha2 = $a."-".$mes."-".$dia;
	
	/*$query="SELECT MAX(id_negocio) maxdeid FROM tbl_negocios";
	$resultado=$mysqli1->query($query);
	while($row = $resultado->fetch_assoc()){
		$id_neg=$row['maxdeid'] + 1;
	}
	$resultado->close();*/

?>

<!DOCTYPE html>
<html>
	<head>
	    <link rel="stylesheet" href="../css/bootstrap.min.css" >
	    
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
			.t1{
				border: none;
				border-bottom: 2px solid green;
				background-color: honeydew;
			}
			td{
				border-bottom: 1px solid lightgray;
			}
			#div1 {
				width: 600px;
			}
			#div2 {
				width: 400px;
			}
			#contenedor, #divenc {
				display: flex;
				justify-content: space-around;
			}
			td:first-child {
				border-right: 2px solid blue;
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
		<script type="text/javascript">
			function validar(frm) {
				if(frm.selciu.value == "0") { 
					alert('Seleccione una ciudad') ; 
					return false ; 
				}
				if(frm.selcat.value == "0") { 
					alert('Seleccione una categoría') ; 
					return false ; 
				}
				if(frm.selmes.value == "0") { 
					alert('Seleccione un mes') ; 
					return false ; 
				}
				if(frm.seldia.value == "0") { 
					alert('Seleccione un día') ; 
					return false ; 
				}
				if(frm.hf.value == "0") { 
					alert('Seleccione una hora final de servicio') ; 
					return false ; 
				}
				if(parseInt(frm.hi.value) >= parseInt(frm.hf.value)) {
					alert('La hora inicial de servicio no puede ser mayor o igual a la hora final') ; 
					return false ; 
				}
			}
			
		</script>
	</head>
	<body>
		<div id="divenc">
			<div>
				<img src="img/logo_ac_.png" width="150px" height="150px"/>
			</div>
			<div>
				<h2>Pago nuevo: <label style="background-color: #f3e4fc; color: blue;"><?php echo $nomconv; ?></label></h2><br/>
			</div>				
		</div>
		<center>
		<form name="nuevo_pago" method="POST" enctype="multipart/form-data" action="pago_nuevo_putdat.php" onsubmit="return validar(this);">
			<div id="contenedor">
				<div id="div1">
					<fieldset><legend><h3>Datos Principales</h3></legend>
					<table>
						<tr>
							<td><b>* Valor</b>
							</td>
							<td><input type="text" name="valor" class="t1" pattern="^[0-9]{1,}$" placeholder="* Valor" required/>
							</td>
						</tr>
						<tr>
							<td><b>* Concepto</b>
							</td>
							<td><input type="text" name="concepto" class="t1" pattern="^[\w\s]{1,50}$" placeholder="* Concepto" required/>
							</td>
						</tr>
						<tr>
							<td><b>* Código/Referencia</b>
							</td>
							<td><input type="text" name="codref" class="t1" pattern="^[\w\s-]{1,30}$" placeholder="* Código/Referencia" required/>
							</td>
						</tr>
						
					</table><br/><br/>
					</fieldset>
				</div>
			</div><br/><br/>
			<input type="submit" name="enviar" value="Guardar" class="btn btn-primary btn-lg"/>
			<input type="hidden" name="idconv" value="<?php echo $idconv; ?>"/>
			<input type="hidden" name="fecha" value="<?php echo $fecha2; ?>"/>
			<input type="hidden" name="nomconv" value="<?php echo str_replace(' ','_',$nomconv); ?>"/>
		</form>
		</center>
		
		
	</body>

</html>