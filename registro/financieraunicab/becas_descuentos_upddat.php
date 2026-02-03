<?php
    include "../adminunicab/php/conexion.php";
    require("../docenteunicab/updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/financieraunicab/becas_descuentos_upddat.php
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    //$faniop=date("Y");
    $espaniol="";
    //echo $fanio;
    if($mes == 12) {
	    $fanio++;
	}
    
    $fecha2 = $fanio."/".$mes."/". $dia;
    $fecha3 = $fanio."-".$mes."-". $dia;
    $fecha_cbpp = date("Ymd");
    if($mes == "02") {
        $diapp = 28;
    }
    else {
        $diapp = 30;
    }
    
    switch ($mes) {
    	case '1':
    		$espaniol="Enero"; 
    		break;
    	case '2':
    		$espaniol="Febrero";
    		break;
    	case '3':
    		$espaniol="Marzo";
    		break;
    	case '4':
    		$espaniol="Abril";
    		break;
    	case '5':
    		$espaniol="Mayo";
    		break;
    	case '6':
    		$espaniol="Junio";
    		break;
    	case '7':
    		$espaniol="Julio";
    		break;
    	case '8':
    		$espaniol="Agosto";
    		break;
    	case '9':
    		$espaniol="Septiembre";
    		break;
    	case '10':
    		$espaniol="Octubre";
    		break;
    	case '11':
    		$espaniol="Noviembre";
    		break;
    	case '12':
    		$espaniol="Diciembre";
    		break;
    }
    
    //Se actualizan las tablas de estudiantes con los pagos y matrículas
    
    //Se valida la fecha actual con respecto a los cierres de periodo para el periodo de ingreso
    $per = "1";
	if(date($fecha2) >= date('2023/02/01') && date($fecha2) < date('2023/04/16')) {
	    $per = "P1";
	}
	else if(date($fecha2) >= date('2023/04/17') && date($fecha2) < date('2023/06/11')) {
	    $per = "P2";
	}
	else if(date($fecha2) >= date('2023/06/12') && date($fecha2) < date('2023/09/03')) {
	    $per = "P3";
	}
	else if(date($fecha2) >= date('2023/09/04')) {
	    $per = "P4";
	}
	//beca = 0 -> sin beca; = 1 media beca; = 2 beca completa
	//pension_a -> es la nueva pensión de promoción anticipada
	$beca = 0;
    $descuento = 0;
    $ct_pagos = 0;
    //$pagos_anuales_de = 10;
        
	$sql_beca = "SELECT b.*, e.nombres, e.apellidos, m.id_grado id_grado_m, c.* 
    FROM tbl_becas b, estudiantes e, matricula m, tbl_costos_unicab c 
    WHERE b.identificacion = e.n_documento AND e.id = m.id_estudiante AND m.id_grado = c.id_grado 
    AND b.periodo_lectivo = $fanio AND c.a = $fanio AND date_format(m.fecha_ingreso, '%Y') = $fanio";
	$res_beca=$mysqli1->query($sql_beca);
    while($row_beca = $res_beca->fetch_assoc()){
        $beca = $row_beca['beca'];
        $descuento = $row_beca['descuento'];
        $ct_pagos = $row_beca['ct_pagos'];
        $documento = $row_beca['identificacion'];
        $pension = $row_beca['pension'];
        $idgra = $row_beca['id_grado'];
        
        if($idgra > 16) {
            if($per == 2) {
                $pagos_anuales_de = 2.5;
            }
            else {
                $pagos_anuales_de = 5;
            }
        }
        else {
            if($per == 2) {
                $pagos_anuales_de = 7.5;
            }
            else if($per == 3) {
                $pagos_anuales_de = 5;
            }
            else {
                $pagos_anuales_de = 10;
            }
        }
        $total_anual_de = round($pension * $pagos_anuales_de, 0);
        
        if($descuento > 0) {
            $descuento1 = round($pension * ($descuento/100), 0);
        }
        else {
            $descuento1 = 0;
        }
        $total_anual_sd = round($total_anual_de - ($descuento1 * $pagos_anuales_de), 0);
        
        if($beca == 1) {
            $beca1 = round($pension * .5, 0);
            $pension1 = $pension - $beca1;
        }
        else if($beca == 2) {
            $beca1 = $pension;
            $pension1 = 0;
        }
        else {
            $beca1 = 0;
            $pension1 = $pension;
        }
        $total_anual_sb = round($total_anual_sd - ($beca1 * $pagos_anuales_de), 0);
        $pension_final = round($total_anual_sb / $pagos_anuales_de, 0);
        
        
        $sql_updins_est = "UPDATE estudiantes SET periodo_ing = $per, descuento = $descuento, beca = $beca, acuerdo_ct_pagos = $ct_pagos, pension_de = $pension, 
            pension_a = 0, pagos_anuales_de = $pagos_anuales_de, pagos_anuales_a = 0, pagos_anuales_f = $pagos_anuales_de, tot_anual_de = $total_anual_de, 
            descuento1 = $descuento1, tot_anual_sd = $total_anual_sd, beca1 = $beca1, tot_anual_sb = $total_anual_sb, pension_final = $pension_final 
            WHERE n_documento = '$documento'";
        echo "<br>".$sql_updins_est;
        $res_updinst_est = $mysqli1->query($sql_updins_est);
        
    }
    
    echo "<br><br>FIN";
    
?>

<html>
    <head><meta charset="gb18030">
        
    </head>
    <body>
        <!--<table border="1">
            <thead>
                <tr>
                    <td>ID_EST</td>
                    <td>ID_GRADO</td>
                    <td>RUTA</td>
                    <td>IDENTIFICACION</td>
                    <td>MSG_CORREO</td>
                </tr>
            </thead>
            <tbody>
            <?php  
                while ($row_tc=mysqli_fetch_array($exe_query_op)) {
            ?>
                <tr>
                    <td><?php echo $row_tc['id_estudiante']; ?></td>
                    <td><?php echo $row_tc['id_grado']; ?></td>
                    <td><?php echo $row_tc['ruta']; ?></td>
                    <td><?php echo $row_tc['identificacion']; ?></td>
                    <td><?php echo $row_tc['msgcorreo']; ?></td>
                </tr>
            <?php  
                }
            ?>
            </tbody>
        </table>-->
    </body>
</html>
