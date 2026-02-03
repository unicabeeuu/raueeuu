<?php
	//Genera el select de los grados
	require("1cc3s4db.php");
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sat, 1 Jul 2000 05:00:00 GMT");
	//header("Refresh: 30; URL='pen_gra_upddat.php'");
	set_time_limit(300);
	
	$pago = $_REQUEST['pago'];
	//echo $pago;
	
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    //echo $fanio;
    if($mes == 12) {
	    $fanio++;
	}
    
    $fecha2 = $fanio."/".$mes."/". $dia;
    $fecha_cbpp = date("Ymd");
    if($mes == "02") {
        $diapp = 28;
    }
    else {
        $diapp = 30;
    }
    
    header("Content-type:application/xls; charset=iso-8859-1");
	
    if($pago == "pp") {
        $fecha1_cbpp = $fanio.$mes.$diapp;
        $fecha2_cbpp = date("Ymd",strtotime($fecha1_cbpp."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_primer_pago.xls");
    }
    else if($pago == "02") {
        $fecha1_cb = $fanio.'0310';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes2.xls");
    }
    else if($pago == "03") {
        $fecha1_cb = $fanio.'0410';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes3.xls");
    }
    else if($pago == "04") {
        $fecha1_cb = $fanio.'0510';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes4.xls");
    }
    else if($pago == "05") {
        $fecha1_cb = $fanio.'0610';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes5.xls");
    }
    else if($pago == "06") {
        $fecha1_cb = $fanio.'0710';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes6.xls");
    }
    else if($pago == "07") {
        $fecha1_cb = $fanio.'0810';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes7.xls");
    }
    else if($pago == "08") {
        $fecha1_cb = $fanio.'0910';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes8.xls");
    }
    else if($pago == "09") {
        $fecha1_cb = $fanio.'1010';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes9.xls");
    }
    else if($pago == "10") {
        $fecha1_cb = $fanio.'1110';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes10.xls");
    }
    else if($pago == "dg") {
        $fecha1_cb = $fanio.'1210';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagodg.xls");
    }
    else if($pago == "pm10dg") {
        $fecha1_cb = $fanio.'1110';
        $fecha2_cb = date("Ymd",strtotime($fecha1_cb."+ 30 days"));
        header("Content-Disposition: attachment; filename=bd_bcs_pagomes10dg.xls");
    }
    //echo $fecha1_cb;
    //echo "<br>".$fecha2_cb;
	
	if($pago == "pp") {
	    $query = "SELECT DISTINCT e.*, m.id_grado, cu.matricula, cu.pension, cu.ocp, cu.poliza, cu.dg, cu.pp, eg.grado_ra, 
        CAST(lpad(e.n_documento, 12, 0) AS CHAR) n_documentolargo, CAST(lpad(cu.pp, 8, 0) AS CHAR) pplargo, CAST(lpad(e.pension_final, 8, 0) AS CHAR) pflargo 
        FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
        WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
        AND m.estado IN ('pre_solicitud', 'solicitud') AND cu.a = $fanio AND date_format(m.fecha_ingreso, '%Y') = $fanio 
        ORDER BY e.id";
	}
	else {
	    $query = "SELECT DISTINCT e.*, m.id_grado, cu.matricula, cu.pension, cu.ocp, cu.poliza, cu.dg, cu.pp, eg.grado_ra, 
        CAST(lpad(e.n_documento, 12, 0) AS CHAR) n_documentolargo, CAST(lpad(cu.pp, 8, 0) AS CHAR) pplargo, CAST(lpad(e.pension_final, 8, 0) AS CHAR) pflargo 
        FROM estudiantes e, matricula m, tbl_costos_unicab cu, equivalence_idgra eg 
        WHERE e.id = m.id_estudiante AND m.id_grado = cu.id_grado AND m.id_grado = eg.id_grado_ra 
        AND m.estado = 'activo' AND cu.a = $fanio AND date_format(m.fecha_ingreso, '%Y') = $fanio 
        ORDER BY e.id";
	}
	
	//echo $query;
	$resultado=$mysqli1->query($query);
	//$sel = $mysqli1->affected_rows;

?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
            .xl65
            {
                mso-style-parent: style0;
                mso-number-format: "\@";
            }
        </style>
	</head>
	<body>
		<center>
			<table border="1px" class="table" id="tblest">
    			<thead>
    			<tr>
    				<td class="tdlargo"><b>IDEST_18</b></td>
    				<td class="tdcorto"><b>VALOR1_8</b></td>
    				<td class="tdmedia"><b>FECHA1_6</b></td>
    				<td class="tdnormal"><b>VALOR2_8</b></td>
    				<td class="tdmediol"><b>FECHA2_6</b></td>
    			</tr>
    			</thead>
    			<tbody>
    			<?php
    			    while($row = $resultado->fetch_assoc()){
    			        $idref = str_pad($row['n_documentolargo'], 12, "0", STR_PAD_LEFT);
    			        $valor1 = str_pad($row['pplargo'], 8, "0", STR_PAD_LEFT);
    			        $pfinal = str_pad($row['pflargo'], 8, "0", STR_PAD_LEFT);
    			        $valor2 = $row['pension_final'];
    			        $valor2 = str_pad($valor2, 8, "0", STR_PAD_LEFT);
    			        $valor2_1 = round($row['pension_final'] * 1.05, 0);
    			        $valor2_1 = str_pad($valor2_1, 8, "0", STR_PAD_LEFT);
    			        $dg = $row['dg'];
    			        $dg = str_pad($dg, 8, "0", STR_PAD_LEFT);
    			        $pm10dg = $valor2 + $dg;
    			        $pm10dg = str_pad($pm10dg, 8, "0", STR_PAD_LEFT);
    			        $pm10dg_1 = round($pm10dg * 1.05, 0);
    			        $pm10dg_1 = str_pad($pm10dg_1, 8, "0", STR_PAD_LEFT);
    			        
    			        $html = '';
    			        if($pago == "pp") {
    			            $html .= '<tr><td class="xl65">'.$idref.$fanio."01".'</td>';
    			            $html .= '<td class="xl65">'.$valor1.'</td>';
    			            $html .= '<td>'.$fecha1_cbpp.'</td>';
    			            $html .= '<td class="xl65">'.$valor1.'</td>';
    			            $html .= '<td>'.$fecha2_cbpp.'</td></tr>';
    			            echo $html;
    			        }
    			        else if($pago == "dg") {
    			            $html .= '<tr><td class="xl65">'.$idref.$fanio."11".'</td>';
    			            $html .= '<td class="xl65">'.$dg.'</td>';
    			            $html .= '<td>'.$fecha1_cb.'</td>';
    			            $html .= '<td class="xl65">'.$dg.'</td>';
    			            $html .= '<td>'.$fecha2_cb.'</td></tr>';
    			            echo $html;
    			        }
    			        else if($pago == "pm10dg") {
    			            $html .= '<tr><td class="xl65">'.$idref.$fanio."12".'</td>';
    			            $html .= '<td class="xl65">'.$pm10dg.'</td>';
    			            $html .= '<td>'.$fecha1_cb.'</td>';
    			            $html .= '<td class="xl65">'.$pm10dg_1.'</td>';
    			            $html .= '<td>'.$fecha2_cb.'</td></tr>';
    			            echo $html;
    			        }
    			        else {
    			            $html .= '<tr><td class="xl65">'.$idref.$fanio.$pago.'</td>';
    			            $html .= '<td class="xl65">'.$valor2.'</td>';
    			            $html .= '<td>'.$fecha1_cb.'</td>';
    			            $html .= '<td class="xl65">'.$valor2_1.'</td>';
    			            $html .= '<td>'.$fecha2_cb.'</td></tr>';
    			            echo $html;
    			        }
    			?>
    			<?php 
    			        //$fila++;
    			    }
    				$resultado->close();
    				$mysqli1->close();
    			?>
    			</tbody>
    		</table>
		</center>
	</body>
	
</html>