<?php
	
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	set_time_limit(300);
	
	date_default_timezone_set('America/Bogota');
	$fecha = time();
	$dia = date("d",$fecha);
	$mes = date("m",$fecha);
	$an = date("Y",$fecha);
	
	$sel_tran = 0;
	$rxp = 30;
	
	$p=$_REQUEST['p'];
	//echo $p;
	
	$nomconv=str_replace("_"," ",$_REQUEST['txtnomconvb']);
	$idconv=$_REQUEST['txtidconvb'];
	$pc=$_REQUEST['txtpcb'];
	//echo $nomconv;
	//echo $idconv;
	//echo $pc;
	
	$a=$_REQUEST['anomesb'];
	$texto=$_REQUEST['buscar'];
	
	if(strlen($a) == 4 || strlen($a) == 6) {
	    //No hace nada
	}
	else if(strlen($a) == 5) {
	    $a = substr($a, 0, 4);
	}
	
	if(!$a) {
		//Se pone el año actual
		$a = $an;
	}
	//echo $a;
	
	//Se genera la ruta de la imagen
	if($tipo == "TC") {
	    $rutaimg = "img/btntc1.png";
	}
	else if($tipo == "PSE") {
	    $rutaimg = "img/btnpse1.png";
	}
	else if($tipo == "EF") {
	    $rutaimg = "img/btnef1.png";
	}
	else if($tipo == "BAL") {
	    $rutaimg = "img/btnbal1.png";
	}
	else if($tipo == "PR") {
	    $rutaimg = "img/btnpred1.png";
	}
	else if($tipo == "RS") {
	    $rutaimg = "img/btnsred1.png";
	}
	else if($tipo == "GA") {
	    $rutaimg = "img/btngana1.png";
	}
	
	if(!$p) {
		//header("Location: tranest_getdat.php?p=1&pi=1&idq=".$idq);
		header("Location: tranest_getdat.php?p=1");
	}
	
	//Se consultan las transacciones
	if(strlen($a) == 4) {
	    $sql = "SELECT * FROM 
	        (SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, t.b1nc4, 'NA' pin, 'TC' tipo 
	        FROM (SELECT * FROM tbl_transac_tc WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.b1nc4 LIKE '%$texto%' OR t.estado LIKE '%$texto%')  
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, t.b1nc4, 'NA' pin, 'PSE' tipo 
	        FROM (SELECT * FROM tbl_transac_pse WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.b1nc4 LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'EF' tipo 
	        FROM (SELECT * FROM tbl_transac_ef WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'BAL' tipo 
	        FROM (SELECT * FROM tbl_transac_bal WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'PR' tipo 
	        FROM (SELECT * FROM tbl_transac_punr WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'RS' tipo 
	        FROM (SELECT * FROM tbl_transac_reds WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'GA' tipo 
	        FROM (SELECT * FROM tbl_transac_gana WHERE substring(fecha_upd,1,4) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') ) a";
	}
	else if(strlen($a) == 6) {
	    $sql = "SELECT * FROM 
	        (SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, t.b1nc4, 'NA' pin, 'TC' tipo 
	        FROM (SELECT * FROM tbl_transac_tc WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.b1nc4 LIKE '%$texto%' OR t.estado LIKE '%$texto%')  
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, t.b1nc4, 'NA' pin, 'PSE' tipo 
	        FROM (SELECT * FROM tbl_transac_pse WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.b1nc4 LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'EF' tipo 
	        FROM (SELECT * FROM tbl_transac_ef WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'BAL' tipo 
	        FROM (SELECT * FROM tbl_transac_bal WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'PR' tipo 
	        FROM (SELECT * FROM tbl_transac_punr WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'RS' tipo 
	        FROM (SELECT * FROM tbl_transac_reds WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'GA' tipo 
	        FROM (SELECT * FROM tbl_transac_gana WHERE substring(fecha_upd,1,6) = '$a') t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%' OR t.estado LIKE '%$texto%') ) a";
	}
	/*$sql = "SELECT * FROM 
	        (SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, t.b1nc4, 'NA' pin, 'TC' tipo 
	        FROM tbl_transac_tc t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.b1nc4 LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, t.b1nc4, 'NA' pin, 'PSE' tipo 
	        FROM tbl_transac_pse t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.b1nc4 LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'EF' tipo 
	        FROM tbl_transac_ef t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%') 
	        UNION ALL 
	        SELECT t.estado, t.cod_ref_pago, t.f1c, t.v1l, p.concepto, t.fecha_upd, t.ref_payco, t.recibo, t.documento, t.c4dd4c, 'NA' b1nc4, t.pin, 'BAL' tipo 
	        FROM tbl_transac_bal t, tbl_pagos p WHERE t.cod_ref_pago = p.codigo AND convenio = '$nomconv' 
	        AND (t.cod_ref_pago LIKE '%$texto%' OR t.f1c LIKE '%$texto%' OR p.concepto LIKE '%$texto%' OR t.fecha_upd LIKE '%$texto%' OR t.ref_payco LIKE '%$texto%' 
	        OR t.recibo LIKE '%$texto%' OR t.documento LIKE '%$texto%' OR t.c4dd4c LIKE '%$texto%' OR t.pin LIKE '%$texto%') ) a";*/
	    
	//echo $sql;
	$resultado=$mysqli1->query($sql);
	$sel_tran = $mysqli1->affected_rows;
	//echo $sel_tran;
	
	if($sel_tran > 0) {
		$pag = ceil($sel_tran/$rxp);
		$ini = ($_GET['p']-1)*$rxp;
		$ini1 = $ini + 1;
		$fin = ($_GET['p']-1)*$rxp + $rxp;
		if($fin > $sel_tran) {
			$fin = $sel_tran;
		}
	}
	//echo "pag".$pag;
	//echo "ini".$ini;
	//echo "ini1".$ini1;
	//echo "fin".$fin;
	//echo 'Total Registros &#9658; '.$sel_tran.' ---------------> Registros '.$ini1.' al '.$fin;
	
	//$resultado->close();
	//$mysqli->close();
	//https://www.youtube.com/watch?v=YR2-3a8cu8c
?>

<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=euc-jp">
		<title></title>
		
		<link rel="stylesheet" href="../css/bootstrap.min.css" >
		<link rel="stylesheet" href="chosen/jquery.dataTables.min.css">
		<script type="text/javascript" src="../js/jquery.min.js"></script>
		<script type="text/javascript" src="../js/reg.js"></script>
		<script type="text/javascript" src="../js/bootstrap.js"></script>
		<script type="text/javascript" src="../js/gridviewscroll.js"></script>
		
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
            .txtid {
				width: 80px;
				border: none;
				border-bottom: 2px solid green;
				background-color: honeydew;
			}
			#contenedor, #divenc {
				display: flex;
				justify-content: space-around;
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
                options.elementID = "listatran";
                options.width = 1000;
                options.height = 400;
                options.freezeColumn = true;
                options.freezeFooter = false;
                options.freezeColumnCssClass = "GridViewScrollItemFreeze";
                options.freezeFooterCssClass = "GridViewScrollFooterFreeze";
                options.freezeColumnCount = 1;
    
                gridViewScroll = new GridViewScroll(options);
                gridViewScroll.enhance();
                
                $("#listatran tbody tr").click(function(){ 
                    $(this).addClass('GridviewScrollItemSelected').siblings().removeClass('GridviewScrollItemSelected');  
                    //var value=$(this).find('td:nth-child(2)').text();
                    //var value1=$(this).find('td:nth-child(18)').text();
                    //$("#txtidest").val(value);
                    //$("#txtidgra").val(value1);
                    //ver_cal_mood(value,value1);
                });
                
                $("#listatran tbody tr").hover(function(){ 
                    $(this).addClass('GridviewScrollItemHover').siblings().removeClass('GridviewScrollItemHover');  
                    //var value=$(this).find('td:first').html();
                });
		    });
		</script>
	</head>
	<body>
	    <div id="divenc">
    	    <div>
    			<img src="img/logo_ac_.png" width="100px" height="100px"/>
    		</div>
    		<div>
    			<h2>Convenio: <label style="background-color: #f3e4fc; color: blue;"><?php echo $nomconv; ?></label></h2>
    		</div>
		</div>
		<center>
			<div id="divres">
				<table>
					<tbody>
						<tr>
							<td >
								<fieldset>
								    <legend>TRANSACCIONES CON TEXTO A BUSCAR <?php echo $texto; ?></legend>
									<?php
								        echo '<label>Total Registros &#9658; '.$sel_tran.' ---------------> Registros '.$ini1.' al '.$fin.'</label>';
									?>
									<table id="listatran" border="1px" class="display">
										<thead>
										    <tr class="GridViewScrollHeader">
											    <td><b>Estado</b></td>
										        <td width="100"><b>Tipo</b></td>
												<td><b>RefPago</b></td>
												<td width="200"><b>Factura</b></td>
												<td width="80"><b>Valor</b></td>
												<td width="200"><b>Concepto</b></td>
												<td><b>Fecha</b></td>
												<td><b>RefPayco</b></td>
												<td><b>Recibo</b></td>
												<td width="200"><b>Banco</b></td>
												<td><b>PIN</b></td>
												<td>...</td>
											</tr>
										</thead>
										<tbody>
											<?php
											    while($row = $resultado->fetch_assoc()){
											?>
        											<tr class="GridviewScrollItem">
        											    <td><?php echo $row['estado'];?></td>
        											    <?php  
        												    if($row['tipo'] == "TC") {
        												?>
        												<td><?php echo '<img src="img/btntc1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												    else if($row['tipo'] == "PSE") {
        												?>
        												<td><?php echo '<img src="img/btnpse1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												    else if($row['tipo'] == "EF") {
        												?>
        												<td><?php echo '<img src="img/btnef1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												    else if($row['tipo'] == "BAL") {
        												?>
        												<td><?php echo '<img src="img/btnbal1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												    else if($row['tipo'] == "PR") {
        												?>
        												<td><?php echo '<img src="img/btnpred1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												    else if($row['tipo'] == "RS") {
        												?>
        												<td><?php echo '<img src="img/btnsred1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												    else if($row['tipo'] == "GA") {
        												?>
        												<td><?php echo '<img src="img/btngana1.png" width="80px" height="27px"/>'; ?></td>
        												<?php  
        												    }
        												?>
        												<td><?php echo $row['cod_ref_pago'];?></td>
        												<td><?php echo $row['f1c'];?></td>
        												<td><?php echo $row['v1l'];?></td>
        												<td><?php echo str_replace(" ","_",$row['concepto']);?></td>
        												<td><?php echo $row['fecha_upd'];?></td>
        												<td><?php echo $row['ref_payco'];?></td>
        												<td><?php echo $row['recibo'];?></td>
        												<td><?php echo str_replace(" ","_",$row['b1nc4']);?></td>
        												<td><?php echo $row['pin'];?></td>
        												<!--<td><?php echo $row['tipo'];?></td>-->
        												<td>...</td>
        											</tr>
											<?php 
    										    }
											?>
										</tbody>
									</table>
								</fieldset>
								<nav aria-label="...">
								  <ul class="pagination">
									<li class="page-item <?php echo $p<=1 ? 'disabled' : '' ?>">
										<!--<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p']-1 ?>&pi=<?php echo $_GET['pi'] ?>&idq=<?php echo $idq ?>">&#9668; Anterior</a>-->
										<a class="page-link" href="tranest_getdat.php?p=<?php echo $p-1 ?>">&#9668; Anterior</a>
									</li>
									<?php for($i=0; $i<$pag;$i++): ?>
									<li class="page-item <?php echo $p==$i+1 ? 'active' : '' ?>">
										<!--<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $i+1 ?>&pi=<?php echo $_GET['pi'] ?>&idq=<?php echo $idq ?>"><?php echo $i+1 ?></a>-->
										<a class="page-link" href="tranest_getdat.php?p=<?php echo $i+1 ?>"><?php echo $i+1 ?></a>
									</li>
									<?php endfor ?>
									<li class="page-item <?php echo $p>=$pag ? 'disabled' : '' ?>">
										<!--<a class="page-link" href="pen_gra_upddat3.php?p=<?php echo $_GET['p']+1 ?>&pi=<?php echo $_GET['pi'] ?>&idq=<?php echo $idq ?>">Siguiente &#9658;</a>-->
										<a class="page-link" href="tranest_getdat.php?p=<?php echo $p+1 ?>">Siguiente &#9658;</a>
									</li>
								  </ul>
								</nav>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
		</center>
		
		<!-- js tabla -->
    	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
    	<script type="text/javascript">
    		$(document).ready(function() {
        	//$('#listatran').DataTable();	
    		} );
    	</script>
    	<!-- //js tabla -->
		
	</body>
</html>