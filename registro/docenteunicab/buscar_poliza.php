<?php
    include "../adminunicab/php/conexion.php";
    require("updreg/1cc3s4db.php");
    header("Cache-Control: no-store");
    //https://unicab.org/registro/docenteunicab/buscar_poliza.php
    
    //Ruta del directorio donde están los archivos
    $path  = '../estudianteunicab/polizas/2021/UnDecimo'; 
    
    // Arreglo con todos los nombres de los archivos
    $files = array_diff(scandir($path), array('.', '..')); 
    //Luego recorres el arreglo y le haces un simple explode a cada elemento
    
    // Obtienes tu variable mediante GET
    $code = $_GET['codigo'];
    
    foreach($files as $file){
        // Divides en dos el nombre de tu archivo utilizando el . 
        //echo "<br>".$file;
        
        $data = explode(".", $file);
        // Nombre del archivo
        $fileName = $data[0];
        // Extensión del archivo 
        $fileExtension = $data[1];
        //echo "<br>".$fileName;
        //echo "<br>".$fileExtension;
        
        $data1 = explode(" ", $fileName);
        $longitud = count($data1);
        //echo " ***** ".$longitud;
        $nombre_completo = "";
        for($i=0; $i<$longitud; $i++) {
            if($data1[$i] == "GRADO") {
                break;
            }
            else {
                //echo $data1[$i];
                $nombre_completo .= $data1[$i]." ";
            }
        }
        
        $nombre_completo = substr($nombre_completo,0,strlen($nombre_completo)-1);
        //echo " ***** ".$nombre_completo;
        echo "<br>".$nombre_completo;
        
        if($code == $fileName){
            echo $fileName;
            // Realizamos un break para que el ciclo se interrumpa
            break;
        }
    }
?>