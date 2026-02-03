<?php
    include "../adminunicab/php/conexion.php";
    require("updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    
    $query_tc = "SELECT *  FROM certificado WHERE numero1 = 20204894 AND tipo_certificado = 'Certificado de notas'";
    //$exe_query_tc=mysqli_query($conexion,$query_tc);
    
    //Se crea la carpeta
    /*$path = 'dhonor/2021/'.str_replace(" ","_","GHF").'/';
    echo $path;
    if (!file_exists($path)) {
        mkdir($path, 0755, true);
        echo "control";
    }*/
?>
<html>
    <head>
        <style>
            @font-face {
                font-family: "Oswald"; 
                font-style: normal; 
                font-weight: 400; 
                src: url(https://fonts.gstatic.com/s/oswald/v35/TK3_WkUHHAIjg75cFRf3bXL8LICs1_FvsUZiZQ.woff2) format('woff2');}
            #divcontenido {width: 80%; position: absolute; top: 250px; left: 50px;}
            table {border-collapse: collapse; width: 900px;}
            thead, tr, td {text-align: center;}
            thead {font-weight: bold;}
            #divmarca {background-image: url("updreg/img/marca_agua1.png"); background-repeat: no-repeat; background-size: 100%;}
            span {background: #CEF6CE;}
            body {background-image: url("updreg/img/fondo_mencion_honor40_1.jpg"); background-repeat: no-repeat; background-size: cover;}
            .t1 {font-family: "Oswald"; font-weight: bold; font-size: 30px;}
            .t2 {font-weight: bold; font-size: 16px;}
            .nom {font-family: "DejaVuSans-BoldOblique"; font-weight: bold; font-size: 30px;}
            .d1 {font-weight: bold;}
            .rec {font-family: "Oswald"; font-weight: bold; font-size: 30px;}
            .f1 {font-weight: bold; font-size: 14px;}
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
        <tr><td class="f1"><br>Dado en Sogamoso, Boyacá a los '.$dia.' días de '.$espaniol.' del '.$fanio.'.</td></tr>
        <tr><td></td></tr>
        <tr><td><img src="../images/firma_certficados.JPG" width="600" height="203"/></td></tr>
        </tbody></table>
        </div></div></center>
    </body>
</html>