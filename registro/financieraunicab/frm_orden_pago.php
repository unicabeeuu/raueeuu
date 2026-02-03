<?php
    header("Cache-Control: no-store");
    include('numlet/vendor/autoload.php');
    use Luecano\NumeroALetras\NumeroALetras;
    
    date_default_timezone_set('America/Bogota');
    $dia=date("d");
    $mes=date("m");
    $mesLetra=date("M");
    $fanio=date("Y");
    $espaniol="";
    
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
    
    $number = 1043000;
	$decimales = 2;
	$currency = "PESOS M/CTE";
	//$cents = "CENTAVOS";
	
	$formatter = new NumeroALetras;
	//echo $formatter->toWords($number, $decimals);
	//echo "<br>".$formatter->toMoney($number, $decimals, $currency, $cents);
	//echo "<br>".$formatter->toInvoice($number, $decimals, $currency);
?>

<html>
    <head>
        <style>
            @font-face {font-family: "Anton"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/anton/v12/1Ptgg87LROyAm3Kz-C8.woff2) format("woff2");}
            /*@font-face {font-family: "Marck Script"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/marckscript/v11/nwpTtK2oNgBA3Or78gapdwuyyCg_.woff2) format("woff2");}
            @font-face {font-family: "Marck Script"; src: url("../docenteunicab/updreg/dompdf/dompdf/lib/fonts/MarckScript-Regular.ttf") format("TrueType");}
            #divcontenido {width: 100%; position: absolute; top: 300px;}*/
            table {border-collapse: collapse; width: 100%;}
            thead, tr, td {text-align: center; border: 1px solid gray;}
            thead {font-weight: bold; background: blue; color: white;}
            span {background: #CEF6CE;}
            body {}
            .nom {font-family: "Marck Script"; font-weight: bold; font-size: 30pt;}
            #divhead {background: gray; color: white;}
            #divbody0 {width: 100%;}
            #divop {background: blue; color: white;}
            tr {height: 25px;}
            #lblconvenciones {color: purple;}
            .tdsinborde {border: 1px solid transparent; text-align: left;}
            .tdsinborde1 {border: 1px solid transparent; color: white;}
            .tdsinborde2 {border: 1px solid transparent;}
            .fondo1 {background: gray; color: white;}
            .ar {text-align: center;}
            .centrado h2 {text-align: center;}
            #divnumletras {border: 2px solid black; height: 25px; font-weight: bold;}
        </style>    
    </head>
    <body>
        <div>
            <div id="divhead">
                <table>
                    <tbody>
                        <tr>
                            <td class="tdsinborde1">
                                <h2>UNIDAD DE CAPACITACION EMPRESARIAL DE BOYACA</h2>
                                <h2>NIT: 826.002.762-1</h2>
                            </td>
                            <td class="tdsinborde1"><img src="img/logoBlancoUnicab.png" width="168" height="140"/></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div>
                <table>
                    <tbody>
                        <tr>
                            <td class="tdsinborde2">
                                <h2>ORDEN DE PAGO No.</h2>
                                <div id="divop"><h2>9397454_9397454_2020_pp</h2></div>
                            </td>
                            <td class="tdsinborde2"><h2>Fecha de expedición: <?php echo $dia."/".$mes."/".$fanio; ?></h2></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="divbody0">
                <p class="centrado"><h2>DATOS DE REFERENCIA</h2></p>
            </div>
            <div>
                <table>
                    <thead>
                        <tr>
                            <td>NOMBRE ALUMNO</td>
                            <td>IDENTIFICACION</td>
                            <td>GRADO</td>
                            <td>CONCEPTO</td>
                            <td>REFERENCIA</td>
                            <td>VALOR</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SANCHEZ CAMELO VALENTINA</td>
                            <td>9397454</td>
                            <td>DECIMO</td>
                            <td>* Primer pago</td>
                            <td>9397454_2020_pp</td>
                            <td>521500</td>
                        </tr>
                        <tr>
                            <td>SANCHEZ CAMELO JOSE MIGUEL</td>
                            <td>9397454</td>
                            <td>NOVENO</td>
                            <td>Otros cobros periódicos</td>
                            <td>9397454_2020_ocp</td>
                            <td>521500</td>
                        </tr>
                        <tr>
                            <td class="tdsinborde" colspan="6"><label id="lblconvenciones">* Primer pago (pp) => Matrícula (m) {209500} + pensión mes 1 (pm1 {188500} + otros cobros periódicos (ocp) {102600} + poliza {20900}.</label></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="tdsinborde"></td>
                            <td class="tdsinborde fondo1 ar"><h3>TOTAL:</h3></td>
                            <td class="tdsinborde fondo1"><h3>$ 1.043.000</h3></td>
                        </tr>
                    </tbody>
                </table>
            </div><br>
            <div id="divnumletras">
                <center><label>SON: <?php echo $formatter->toMoney($number, $decimals, $currency, $cents); ?></label></center>
            </div>
        </div>
        
        
        
    </body>
</html>