<?php
    header("Cache-Control: no-store");
    
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
?>

<html>
    <head>
        <style>
            @font-face {font-family: "Oswald"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/oswald/v35/TK3_WkUHHAIjg75cFRf3bXL8LICs1_FvsUZiZQ.woff2) format("woff2");}
            @font-face {font-family: "Anton"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/anton/v12/1Ptgg87LROyAm3Kz-C8.woff2) format("woff2");}
            @font-face {font-family: "Marck Script"; font-style: normal; font-weight: 400; src: url(https://fonts.gstatic.com/s/marckscript/v11/nwpTtK2oNgBA3Or78gapdwuyyCg_.woff2) format("woff2");}
            @font-face {font-family: "Marck Script"; src: url("updreg/dompdf/dompdf/lib/fonts/MarckScript-Regular.ttf") format("TrueType");}
            #divcontenido {width: 100%; position: absolute; top: 300px;}
            table {border-collapse: collapse; width: 90%;}
            thead, tr, td {text-align: center;}
            thead {font-weight: bold;}
            span {background: #CEF6CE;}
            body {background-image: url("updreg/img/fondo_mencion_honor40_1.jpg"); background-repeat: no-repeat; background-size: cover;}
            .t1 {font-family: "Oswald"; font-weight: bold; font-size: 30pt;}
            .t2 {font-weight: bold; font-size: 16pt;}
            .nom {font-family: "Marck Script"; font-weight: bold; font-size: 30pt;}
            .d1 {font-weight: bold; font-size: 16pt;}
            .rec {font-family: "Anton"; font-weight: bold; font-size: 30pt;}
            .f1 {font-weight: bold; font-size: 16pt;}
        </style>    
    </head>
    <body>
        <center><div id="divcontenido"><div>
        <table><tbody>
        <tr><td class="t1">MENCIÓN DE HONOR</td></tr>
        <tr><td class="t2">Concedida a:</td></tr>
        <tr><td class="nom">Maria Paulina Figueredo Rodriguez</td></tr>
        <tr><td></td></tr>
        <tr><td class="d1"><br>Teniendo en cuenta que durante el grado 1° se distinguió por su:</td></tr>
        <tr><td class="rec">TERCER PUESTO PRUEBAS DE ESTADO</td></tr>
        <tr><td></td></tr>
        <tr><td class="f1"><br>Dado en Sogamoso, Boyacá a los <?php echo $dia; ?> días de <?php echo $espaniol; ?> del <?php echo $fanio; ?>.</td></tr>
        <tr><td></td></tr>
        <tr><td><img src="../images/firma_certficados.JPG" width="600" height="203"/></td></tr>
        </tbody></table>
        </div></div></center>
    </body>
</html>