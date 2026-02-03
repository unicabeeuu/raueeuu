<?php
	require("php/1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$fila = 0;
	
	$nom = strtoupper($_POST['buscar']);
	//echo $nom;
	
	$query1 = "SELECT DISTINCT e.id, a.grado, m.n_matricula, a.usuario, CONCAT(e.nombres,' ',e.apellidos) nombre, e.n_documento, e.fecha_nacimiento, e.email_institucional, 
		e.acudiente_1, e.email_acudiente_1, e.telefono_acudiente_1, e.acudiente_2, e.email_acudiente_2, e.telefono_acudiente_2, e.direccion, e.ciudad, 
		e.actividad_extra 
		FROM estudiantes e, matricula m, 
		(SELECT em.*, ee.id_registro 
		FROM tbl_estudiantes_mood em LEFT JOIN equivalence_idest ee
		ON em.id = ee.id_moodle ) a 
		WHERE e.id = m.id_estudiante AND e.id = a.id_registro 
		AND (e.nombres like '%".$nom."%' OR e.apellidos like '%".$nom."%') 
		ORDER BY a.grado, nombre";
	$resultado=$mysqli1->query($query1);
	$sel = $mysqli1->affected_rows;
?>

<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="../docenteunicab/updreg/css/reg.css" >
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/gridviewscroll.js"></script>
		<style>
		    #tblest {
                table-layout: fixed;
                border-collapse: collapse;
            }
		    #tblest .tdlargo {
                width: 350px;
            }
            #tblest .tdcorto {
                width: 50px;
            }
            #tblest .tdnormal {
                width: 130px;
            }
            #tblest .tdmedia {
                width: 100px;
            }
            #tblest .tdmediol {
                width: 200px;
            }
            #tblest .tdmediol1 {
                width: 250px;
            }
            #tblest .tdelargo {
                width: 400px;
            }
            
            .GridViewScrollHeader TH, .GridViewScrollHeader TD {
                padding: 5px;
                font-weight: normal;
                background-color: #CCCCCC;
                color: #000000;
            }
            
            .GridViewScrollItem TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridViewScrollItemFreeze TD {
                padding: 5px;
                background-color: #CCCCCC;
                color: #444444;
            }
            
            .GridViewScrollFooterFreeze TD {
                padding: 5px;
                color: #444444;
            }
            
            .GridviewScrollItemHover TD
            {
                background-color: #CCCCCC;
                color: blue;
                cursor: pointer;
            }
            .GridviewScrollItemSelected TD
            {
                background: #A9F5BC;
                color: blue;
            }
		</style>
		<script>
		    var gridViewScroll = null;
        
            $(function() {
                var options = new GridViewScrollOptions();
                options.elementID = "tblestzz";
                options.width = 1200;
                options.height = 300;
                options.freezeColumn = true;
                options.freezeFooter = false;
                options.freezeColumnCssClass = "GridViewScrollItemFreeze";
                options.freezeFooterCssClass = "GridViewScrollFooterFreeze";
                options.freezeColumnCount = 1;
    
                gridViewScroll = new GridViewScroll(options);
                gridViewScroll.enhance();
                
                $("#tblest tbody tr").click(function(){ 
                    $(this).addClass('GridviewScrollItemSelected').siblings().removeClass('GridviewScrollItemSelected');  
                    var value=$(this).find('td:first').html();
                });
                
                $("#tblest tbody tr").hover(function(){ 
                    $(this).addClass('GridviewScrollItemHover').siblings().removeClass('GridviewScrollItemHover');  
                    var value=$(this).find('td:first').html();
                });
            });
        </script>
	</head>
	<body>
		<center>
			<div id="enc">
				<img src="../docenteunicab/updreg/img/enc2.png" alt="enc2" />
			</div>
			<div id="divres">
				<table>
					<tbody>
						<tr>
							<td height="30">
							</td>
						</tr>
						<tr>
							<td>
								<fieldset>
									<legend>
									    <?php
										echo '<label>Total Registros &#9658; '.$sel.'</label>';
										?>
									</legend>
									<div>
									    <table border="1px" class="table" id="tblest">
											<thead>
											<tr class="GridViewScrollHeader">
												<td class="tdlargo"><b>NOMBRE</b></td>
												<td class="tdcorto"><b>ID</b></td>
												<td class="tdnormal"><b>GRADO</b></td>
												<td class="tdmediol"><b>MATRICULA</b></td>
												<td class="tdmedia"><b>USUARIO</b></td>
												<td class="tdmediol"><b>DOCUMENTO No.</b></td>
												<td class="tdmediol"><b>FECHA NACIMIENTO</b></td>
												<td class="tdlargo"><b>EMAIL INST</b></td>
												<td class="tdlargo"><b>ACUDIENTE 1</b></td>
												<td class="tdlargo"><b>EMAIL ACUDIENTE 1</b></td>
												<td class="tdmediol1"><b>TELEFONO ACUDIENTE 1</b></td>
												<td class="tdlargo"><b>ACUDIENTE 2</b></td>
												<td class="tdlargo"><b>EMAIL ACUDIENTE 2</b></td>
												<td class="tdmediol1"><b>TELEFONO ACUDIENTE 2</b></td>
												<td class="tdelargo"><b>DIRECCION</b></td>
												<td class="tdmediol1"><b>CIUDAD</b></td>
												<td class="tdmediol"><b>ACTIVIDAD EXTRA</b></td>
											</tr>
											</thead>
											<tbody>
											<?php
											    while($row = $resultado->fetch_assoc()){
											?>
											<tr class="GridviewScrollItem">
												<td class="tdlargo"><?php echo $row['nombre'];?></td>
												<td class="tdcorto"><?php echo $row['id'];?></td>
												<td class="tdnormal"><?php echo $row['grado'];?></td>
												<td class="tdmediol"><?php echo $row['n_matricula'];?></td>
												<td class="tdmedia"><?php echo $row['usuario'];?></td>
												<td class="tdmediol"><?php echo $row['n_documento'];?></td>
												<td class="tdmediol"><?php echo $row['fecha_nacimiento'];?></td>
												<td class="tdlargo"><?php echo $row['email_institucional'];?></td>
												<td class="tdlargo"><?php echo $row['acudiente_1'];?></td>
												<td class="tdlargo"><?php echo $row['email_acudiente_1'];?></td>
												<td class="tdmediol1"><?php echo $row['telefono_acudiente_1'];?></td>
												<td class="tdlargo"><?php echo $row['acudiente_2'];?></td>
												<td class="tdlargo"><?php echo $row['email_acudiente_2'];?></td>
												<td class="tdmediol1"><?php echo $row['telefono_acudiente_2'];?></td>
												<td class="tdelargo"><?php echo $row['direccion'];?></td>
												<td class="tdmediol1"><?php echo $row['ciudad'];?></td>
												<td class="tdmediol"><?php echo $row['actividad_extra'];?></td>
											</tr>
											<?php 
											        $fila++;
											    }
												$resultado->close();
												$mysqli1->close();
											?>
											</tbody>
										</table>
									</div>
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
		</center>
	</body>
	
</html>