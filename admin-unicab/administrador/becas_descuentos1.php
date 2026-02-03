<?php 
	session_start();
	require "../php/conexion.php";
	require("../../registro/docenteunicab/updreg/1cc3s4db.php");
	//https://unicab.org/admin-unicab/administrador/becas_descuentos1.php?n_documentof=9397454&sel_descuento=3&per_lec=2021
	//https://unicab.org/admin-unicab/administrador/becas_descuentos1.php?n_documentof=9397454&sel_descuento=4&per_lec=2022
	
if (isset($_SESSION['admin_unicab'])) {

	$identif = $_REQUEST['n_documentof'];
	$tipo_beca = $_REQUEST['sel_descuento'];
	$anio = $_REQUEST['per_lec'];
	
	$control_tbl_becas = 0;
	$control_upd_datos_est = 0;
	
	//beca = 0 -> sin beca; = 1 media beca; = 2 beca completa
	if($tipo_beca == 1) {
	    $beca = 2;
	    $descuento = 0;
	    $ct_pagos = 0;
	}
	else if($tipo_beca == 2) {
	    $beca = 1;
	    $descuento = 0;
	    $ct_pagos = 0;
	}
	else if($tipo_beca == 3) {
	    $beca = 0;
	    //$descuento = 5;
	    $descuento = 3;
	    $ct_pagos = 0;
	}
	/*else if($tipo_beca == 4) {
	    $beca = 0;
	    $descuento = 10;
	    $ct_pagos = 0;
	}*/
	
	//Se valida si ya existe un registro de descuento para el estudiante y periodo lectivo
	$sql_val = "SELECT COUNT(1) ct FROM tbl_becas WHERE identificacion = '$identif' AND periodo_lectivo = $anio";
	//echo $sql_val;
	
	$res_val=$mysqli1->query($sql_val);
	while($row_val = $res_val->fetch_assoc()){
	    $ct = $row_val['ct'];
	}
	
	if($ct == 0) {
	    $sql_ins = "INSERT INTO tbl_becas (identificacion, periodo_lectivo, beca, descuento, ct_pagos) VALUES 
    	    ('$identif', $anio, $beca, $descuento, $ct_pagos)";
    	//echo "<br>".$sql_ins;
    	$exe_ins = mysqli_query($conexion, $sql_ins);
    	
    	$control_tbl_becas = 1;
	}
	
	
	//*******************************************************************************************************************************
	//Se actualizan los costos, becas y descuentos en la tabla de estudiantes
	date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    //$faniop=date("Y");
    $espaniol="";
    //echo $fanio;
    if($mes >= 11) {
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
	if(date($fecha2) >= date('2021/11/01') && date($fecha2) < date('2022/04/11')) {
	    $per = "1";
	}
	else if(date($fecha2) >= date('2022/04/11') && date($fecha2) < date('2022/06/28')) {
	    $per = "2";
	}
	else if(date($fecha2) >= date('2022/06/28') && date($fecha2) < date('2022/09/12')) {
	    $per = "3";
	}
	else if(date($fecha2) >= date('2022/09/12')) {
	    $per = "4";
	}
	
	//pension_a -> es la nueva pensión de promoción anticipada
	//$pagos_anuales_de = 10;
        
	$sql_beca = "SELECT b.*, e.nombres, e.apellidos, m.id_grado id_grado_m, c.* 
    FROM tbl_becas b, estudiantes e, matricula m, tbl_costos_unicab c 
    WHERE b.identificacion = e.n_documento AND e.id = m.id_estudiante AND m.id_grado = c.id_grado 
    AND b.periodo_lectivo = $fanio AND c.a = $fanio AND date_format(m.fecha_ingreso, '%Y') = $fanio 
    AND e.n_documento = '$identif' AND m.estado = 'activo'";
    //echo "<br>".$sql_beca;
    
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
        //echo "<br>".$sql_updins_est;
        
        $res_updinst_est = $mysqli1->query($sql_updins_est);
        
        $control_upd_datos_est = 0;
    }
	
	//*******************************************************************************************************************************
    echo "<br>".$control_tbl_becas." ".$control_upd_datos_est;
    
    if($control_tbl_becas == 1 && $control_upd_datos_est == 1) {
        //echo "<script>alert('Descuento generado correctamente y datos actualizados en la tabla de estudiantes');</script>";
        $texto = "Descuento generado correctamente y datos actualizados en la tabla de estudiantes.";
    }
    else if($control_tbl_becas == 1 && $control_upd_datos_est == 0) {
        //echo "<script>alert('Descuento generado correctamente pero los datos no se actualizaron en la tabla de estudiantes porque todavía no está activo en ' + $fanio);</script>";
        $texto = "Descuento generado correctamente pero los datos no se actualizaron en la tabla de estudiantes porque todavía no está activo en " . $fanio;
    }
    else if($control_tbl_becas == 0 && $control_upd_datos_est == 0) {
        //echo "<script>alert('Descuento NO GENERADO correctamente');</script>";
        $texto = "Descuento NO GENERADO correctamente.";
    }
    
    //Se consulta los datos finales del estudiante
    $sql_est = "SELECT e.*, g.grado 
    FROM estudiantes e, matricula m, grados g 
    WHERE e.id = m.id_estudiante AND m.id_grado = g.id AND e.n_documento = '$documento' AND m.estado = 'activo'";
    $res_est = $mysqli1->query($sql_est);
	//echo "<br>".$sql_est;
	
	//Se direcciona 
    //echo "<script>location.href='becas_descuentos.php';</script>";
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Administrador - Web Unicab</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        
        <link rel="shortcut icon" type="image/x-icon" href="../../images/fave-icon.png"/>
        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.css" rel='stylesheet' type='text/css' />
        
        <!-- Custom CSS -->
        <link href="../css/style.css" rel='stylesheet' type='text/css' />
        
        <!-- font-awesome icons CSS -->
        <link href="../css/font-awesome.css" rel="stylesheet"> 
        <!-- //font-awesome icons CSS -->
        
         <!-- side nav css file -->
         <link href='../css/SidebarNav.min.css' media='all' rel='stylesheet' type='text/css'/>
         <!-- side nav css file -->
         
         <!-- js-->
        <script src="../js/jquery-1.11.1.min.js"></script>
        <script src="../js/modernizr.custom.js"></script>
        
        <!--webfonts-->
        <link href="//fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
        <!--//webfonts--> 
        
        <!-- Metis Menu -->
        <script src="../js/metisMenu.min.js"></script>
        <script src="../js/custom.js"></script>
        <link href="../css/custom.css" rel="stylesheet">
        <!--//Metis Menu -->
        
        <style>
            #cont {
            	display: flex;
            	justify-content: space-around;
            }
            fieldset {
            	border: 2px double green;
            	-moz-border-radius: 8px;
            	-webkit-border-radius: 8px;	
            	border-radius: 8px;
            }
            legend {
            	 text-align: center;
            	 font-weight: bold;
            	 font-size: 18pt;
            	 color: #B4045F;
            	 text-shadow: 0px 0px 10px #BA55D3;
            }
            .mprincipal {
            	list-style-image: url("../images/m26.png");
            	font-weight: bold !important;
                font-size: 20px !important;
            }
            .msecund {
            	list-style-image: url(../images/bd30.png); 
            	background: lightgreen;
            	padding: 20px;
            	font-weight: bold;
            	font-size: 18px;
            }
            .msecund li {
            	background: #cce5ff;
            	margin-left: 20px;
            	margin-top: 5px;
            }
        </style>
    </head> 
    <body class="cbp-spmenu-push">
    	<div class="main-content">
    		<!-- menu -->
    		<?php 
    			require "include/header.php";
    		?>
    		<!-- menu -->
    		
    		<!-- header -->
    		<?php 
    			require "include/menu.php";
    		?>
    		<!-- header -->
    		<!-- main content start-->
    		
    		<section>
               <div id="page-wrapper">
               		<h3>Resultado:</h3>
                		<p><?php echo $texto; ?></p><br>
            		
                        <table border="1">
                        <tbody>
                        <?php  
                            while($row_est = $res_est->fetch_assoc()){
                        ?>
                            <tr>
                                <td style="width: 200px;">IDENTIFICACION</td><td style="width: 400px;"><?php echo $row_est['n_documento']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">NOMBRES</td><td style="width: 400px;"><?php echo $row_est['nombres']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">NOMBRES</td><td style="width: 400px;"><?php echo $row_est['apellidos']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">GRADO</td><td style="width: 400px;"><?php echo $row_est['grado']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">PER. ING</td><td style="width: 400px; text-align: right;"><?php echo $row_est['periodo_ing']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">DESCUENTO</td><td style="width: 400px; text-align: right;"><?php echo $row_est['descuento']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">BECA</td><td style="width: 400px; text-align: right;"><?php echo $row_est['beca']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">CT PAGOS</td><td style="width: 400px; text-align: right;"><?php echo $row_est['acuerdo_ct_pagos']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">TOTAL ANUAL</td><td style="width: 400px; text-align: right;"><?php echo $row_est['tot_anual_de']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">TOTAL ANUAL SD</td><td style="width: 400px; text-align: right;"><?php echo $row_est['tot_anual_sd']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">TOTAL ANUAL SB</td><td style="width: 400px; text-align: right;"><?php echo $row_est['tot_anual_sb']; ?></td>
                            </tr>
                            <tr>
                                <td style="width: 200px;">PENSION FINAL</td><td style="width: 400px; text-align: right;"><?php echo $row_est['pension_final']; ?></td>
                            </tr>
                        <?php  
                            }
                        ?>
                        </tbody>
                    </table>
                    
                    <br><a href="becas_descuentos.php" ><button type="button" class="btn btn-primary">Volver</button></a>
           	   </div>
    		</section>
    		
    		<!--footer-->
    		<?php 
    			require "include/footer.php";
    		?>
            <!--//footer-->
    	</div>
    	
    	<!-- side nav js -->
    	<script src='../js/SidebarNav.min.js' type='text/javascript'></script>
    	<script>
          $('.sidebar-menu').SidebarNav()
        </script>
    	<!-- //side nav js -->
    	
    	<!-- Classie --><!-- for toggle left push menu script -->
		<script src="../js/classie.js"></script>
		<script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			
			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
    	<!-- //Classie --><!-- //for toggle left push menu script -->
    	
    	<!--scrolling js-->
    	<script src="../js/jquery.nicescroll.js"></script>
    	<script src="../js/scripts.js"></script>
    	<!--//scrolling js-->
    
    	<!-- Bootstrap Core JavaScript -->
       <script src="../js/bootstrap.js"> </script>
       <script type="text/javascript" src="../js/MaxLength.min.js"></script>
    
       	<script type="text/javascript">
            $(function () {
                $("#TituloB").MaxLength(
                {
                    MaxLength: 400,
                    DisplayCharacterCount: false	
                });
        
                $("#DescripcionB").MaxLength(
                {
                    MaxLength: 10000,
                    DisplayCharacterCount: false	
                });
            });
        </script>
        
    </body>
</html>
<?php 
}else{
	echo "<script>alert('Debe iniciar sesión');</script>";
	echo "<script>location.href='../../login_registro.php'</script>";
}
?>