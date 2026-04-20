<?php
    session_start();
	require("1cc3s4db.php");
	include "mcript.php";
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	//https://unicab.org/registro/docenteunicab/updreg/consultar_querys_ra.php
	
	
//if (isset($_SESSION['uniprofe']) || isset($_SESSION['unisuper']) || isset($_SESSION['admin_unicab'])) {
	$fila = 0;
	
	$query1 = "SELECT * FROM querys_ra WHERE id > 25 ORDER BY grados, pensamiento";
	
	//echo $query1;
	$resultado=$mysqli1->query($query1);
	$sel = $mysqli1->affected_rows;
	
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title></title>
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link href="../../css/font-awesome.css" rel="stylesheet">
		<link rel="stylesheet" href="css/reg.css" >
		
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
            #tblest .tdmediol {
                width: 200px;
            }
            #tblest .tdmediol1 {
                width: 250px;
            }
            #tblest .tdelargo {
                width: 450px;
            }
            #div_enfasis {
                overflow: hidden;
                width: 100%;
            }
            #div_vacio {
                width: 60%;
            }
            #divcanvas_enf {
                width: 40%;
            }
            #divcanvas_enf, #div_vacio {
                float: left;
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
                options.elementID = "tblest";
                options.width = 1200;
                options.height = 600;
                options.freezeColumn = true;
                options.freezeFooter = false;
                options.freezeColumnCssClass = "GridViewScrollItemFreeze";
                options.freezeFooterCssClass = "GridViewScrollFooterFreeze";
                options.freezeColumnCount = 1;
    
                gridViewScroll = new GridViewScroll(options);
                gridViewScroll.enhance();
                
                /*$("#tblest tbody tr").click(function(){ 
                    $(this).addClass('GridviewScrollItemSelected').siblings().removeClass('GridviewScrollItemSelected');  
                    var value=$(this).find('td:nth-child(5)').text();
                    var value1=$(this).find('td:nth-child(6)').text();
                    $("#txtidest").val(value);
                    $("#txtidgra").val(value1);
                    
                    //ver_cal(value,value1);
                    ver_observaciones(value);
                    ver_cal_mood(value,value1);
                });*/
                
                $("#tblest tbody tr").hover(function(){ 
                    $(this).addClass('GridviewScrollItemHover').siblings().removeClass('GridviewScrollItemHover');  
                    var value=$(this).find('td:first').html();
                });
            });
            
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
									<legend>Querys
									</legend>
									<?php
										echo '<label>Total Registros &#9658; '.$sel.'</label>';
									?>
									<table border="1px" class="table" id="tblest">
										<thead>
										<tr class="GridViewScrollHeader">
											<td class="tdcorto"><b>PEN</b></td>
											<td class="tdcorto"><b>GRA</b></td>
											<td class="tdelargo"><b>CONSULTA</b></td>
										</tr>
										</thead>
										<tbody>
										<?php
										    while($row = $resultado->fetch_assoc()){
										        $query1 = $dev_enc($row['campos1']).$dev_enc($row['campos2']).$dev_enc($row['campos3']).$dev_enc($row['tablas'])
                								.$row['condicion1'].$row['condicion2'].$row['condicion3']
                								.$row['condicion4'].$dev_enc($row['condicion5']).$dev_enc($row['orden']);
										?>
										<tr class="GridviewScrollItem">
											<td class="tdcorto"><?php echo $row['pensamiento'];?></td>
											<td class="tdcorto"><?php echo $row['grados'];?></td>
											<td class="tdelargo"><?php echo $query1;?></td>
										</tr>
										<?php 
										        $fila++;
										    }
											$resultado->close();
											$mysqli1->close();
										?>
										</tbody>
									</table>
								</fieldset>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<br/>
			<input type="hidden" id="txtidest"/><input type="hidden" id="txtidgra"/>
			<div id="divcanvas" style="display: block;">
			    <canvas id="grafico" width="800" height="200"></canvas>
			</div>
			<!-- Este es el canvas para las notas en moodle -->
			<div id="divcanvasm" style="display: none;">
			    <canvas id="graficom" width="800" height="200"></canvas>
			</div>
			<!------------------------------------------------>
			<div id="divresul"></div><br />
			
			<div id="div_enfasis">
			    <div id="divcanvas_enf" style="display: block;">
    			    <canvas id="grafico_enf" width="800" height="200"></canvas>
    			</div>
			    
    			<div id="div_vacio"><label style="color: white;">...</label></div>
			</div>
			
			<div id="tablam" style="display: none;">
			    
			</div>
		</center>
	</body>
	
</html>
<?php
    /*}else{
    	echo "<script>alert('Debes iniciar sesiﾃｳn');</script>";
    	echo "<script>location.href='../login.php'</script>";
    }*/
?>