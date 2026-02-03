<?php
    session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper']) || isset($_SESSION['admin_unicab'])) {
	$fila = 0;
	
	$nom = strtoupper($_POST['buscar']);
	//echo $nom;
	
	$query1 = "SELECT a.*, o.observacion, ifnull(o.id, -1) id_obs 
	    FROM 
	    (SELECT e.id id_est, e.nombres, e.apellidos, e.n_documento FROM estudiantes e 
	    WHERE e.nombres like '%$nom%' OR e.apellidos like '%$nom%' OR e.n_documento like '%$nom%') a 
	    LEFT JOIN tbl_estudiantes_param o 
	    ON a.id_est = o.id_estudiante";
	
	$resultado=$mysqli1->query($query1);
	$sel = $mysqli1->affected_rows;
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<!--<link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />-->
		<link href="../../css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="css/reg.css" >
		
		<!--<link href="../../css/font-awesome.css" rel="stylesheet">
		<link href="../../css/bootstrap.css" rel='stylesheet' type='text/css' />-->
		
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/reg.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/gridviewscroll.js"></script>
		<script type="text/javascript" src="js/Chart.bundle.min.js"></script>
		<style>
		    #tblest {
                table-layout: fixed;
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
            #tblest .tdmedia1 {
                width: 120px;
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
            
            .GridviewScrollItemHoverxx TD
            {
                background-color: #CCCCCC;
                color: blue;
                cursor: pointer;
            }
            .GridviewScrollItemSelectedxx TD
            {
                background: #A9F5BC;
                color: blue;
            }
            input[type=search] {
    			border: none;
    			border-bottom: 2px solid green;
    			background-color: #A9F5BC;
    		}
            #search {
                margin-left: 100px;
            }
		</style>
		<script>
		    var gridViewScroll = null;
        
            $(function() {
                var options = new GridViewScrollOptions();
                options.elementID = "tblest";
                options.width = 1100;
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
                    var id=$(this).find('td:nth-child(5)').text();
                    var nombres=$(this).find('td:nth-child(2)').text();
                    var apellidos=$(this).find('td:nth-child(3)').text();
                    var obs=$(this).find('td:nth-child(4)').text();
                    //alert(id);
                    
                    /*$("#txtidest").val(id);
                    $("#txtidest1").val(id);
                    $("#txtnom").val(nombres);
                    $("#txtape").val(apellidos);
                    $("#txtobs").val(obs);
                    $("#modal_observaciones").modal();*/
                });
                
                $("#tblest tbody tr").hover(function(){ 
                    $(this).addClass('GridviewScrollItemHover').siblings().removeClass('GridviewScrollItemHover');  
                    var value=$(this).find('td:first').html();
                });
                
                $("#search").keyup(function(){
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#tblest tbody tr"), function() {
                         if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                         else
                            $(this).show();
                    });
                });
                
            });
            
            function updobs() {
                $("#search").val("");
                
                $.ajax({
            		type:"POST",
            		url:"observaciones_putdat1.php",
            		data:"idest=" + $("#txtidest1").val() + "&obs=" + $("#txtobs").val() + "&buscar=" + $("#txtparam").val(),
            		success:function(r) {
            		    //location.reload();
            		    $("#tblest tbody").empty();
            		    $("#tblest tbody").append(r);
            		    //$("#tblest tbody").replaceWith(r);
            		}
            	});
            }
            
            function enviardat(id_est, nombres, apellidos, obs) {
                $("#txtidest1").val(id_est);
                $("#txtnom").val(nombres);
                $("#txtape").val(apellidos);
                $("#txtobs").val(obs);
            }
            
            function pulsar(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    console.log('prevented');
                    return false;
                }
            }
            //*******************************************************************************
        </script>
	</head>
	<body>
		<center>
			<div id="enc" style="display: none;">
				<img src="img/enc2.png" alt="enc2" />
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
									<legend>Observaciones de Estudiantes
									</legend>
									<?php
										echo '<label>Total Registros &#9658; '.$sel.'</label>';
										/*echo "uniprofe".$_SESSION['uniprofe'];
										echo "unisuper".$_SESSION['unisuper'];
										echo "admin".$_SESSION['admin_unicab'];*/
									?>
									<input type="search" placeholder="Ingrese texto a buscar" id="search" name="search">
									<div>
										<table border="1px" class="table" id="tblest">
											<thead>
											<tr class="GridViewScrollHeader">
											    <td class="tdcorto">&#9658;</td>
												<td class="tdmediol1"><b>NOMBRE</b></td>
												<td class="tdmediol1"><b>APELLIDOS</b></td>
												<td class="tdmedia1"><b>DOCUMENTO</b></td>
												<td class="tdelargo"><b>OBSERVACION</b></td>
												<td class="tdmedia"><b>ACCIONES</b></td>
												<td class="tdmedia"><b>ID EST</b></td>
												<td><b>...</b></td>
											</tr>
											</thead>
											<tbody>
											<?php
											    while($row = $resultado->fetch_assoc()){
											?>
											<tr class="GridviewScrollItem">
											    <td class="tdcorto">&#9658;</td>
												<td class="tdmediol1"><?php echo $row['nombres'];?></td>
												<td class="tdmediol1"><?php echo $row['apellidos'];?></td>
												<td class="tdmedia1"><?php echo $row['n_documento'];?></td>
												<td class="tdelargo"><?php echo $row['observacion'];?></td>
												<td class="tdmedia"><button class="btn btn-warning fa fa-pencil-square-o" data-toggle="modal" data-target="#modal_observaciones" title="Editar"
                                                    onclick="enviardat(<?php echo $row['id_est'];?>,'<?php echo $row['nombres'];?>','<?php echo $row['apellidos'];?>','<?php echo $row['observacion'];?>');"> Editar</button></td>
												<td class="tdmedia"><?php echo $row['id_est'];?></td>
												<td>...</td>
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
			<input type="hidden" id="txtidest"/><input type="hidden" id="txtparam" value="<?php echo str_replace(" ","_",$nom); ?>"/>
			<div id="divresul"></div><br />
		</center>
		
		<!-- Modal para agregar las observaciones -->
        <div class="modal fade" id="modal_observaciones" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">AGREGAR OBSERVACION</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <label>Id_est</label>
                <input type="text" id="txtidest1" class="form-control" readonly/>
                <label>Nombres</label>
                <input type="text" id="txtnom" class="form-control" readonly/>
                <label>Apellidos</label>
                <input type="text" id="txtape" class="form-control" readonly/>
                <label>Observaciones</label>
                <textarea id="txtobs" class="form-control" cols='21' rows='5' onkeydown="pulsar(event)"></textarea>
                <label id="lblval"></label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" id="btnupdpor" data-dismiss="modal" onclick="updobs()">Guardar</button>
              </div>
            </div>
          </div>
        </div>
	</body>
	
</html>
<?php
    /*}else{
    	echo "<script>alert('Debes iniciar sesiﾃｳn');</script>";
    	echo "<script>location.href='../login.php'</script>";
    }*/
?>