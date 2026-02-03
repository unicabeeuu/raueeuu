<?php 
    require("1cc3s4db.php");
    
    //https://unicab.org/registro/docenteunicab/updreg/solicitud_matricula.php?sentencia=INSERT|INTO|matricula|(n_matricula,fecha_ingreso,estado,id_estudiante,id_grado,EstadoGrado)|VALUES|('1321-2020-10G','2020-06-19','solicitud',1321,10,'NA')
    
    //$sql = nl2br(str_replace("'","''",$_REQUEST['sql']));
    $sentencia = str_replace("|"," ",$_REQUEST['sentencia']);
    //echo $sentencia;
    //$sql = mysqli_real_escape_string($sql);
    //echo "<br/>Nuevo sql ".$sql;
    
    $sql_insert = 'INSERT INTO solicitudes_matricula (sentencia) VALUES ("'.$sentencia.'")';
    echo "<br/>".$sql_insert;
    
    $resultado=$mysqli1->query($sql_insert);
    
    echo "<br/>Registro insertado";

?>