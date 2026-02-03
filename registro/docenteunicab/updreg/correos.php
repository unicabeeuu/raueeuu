<?php 
    require("1cc3s4db.php");
    
    $id_grado = $_REQUEST['idgra'];
    //tipo_correo: 1 = est; 12 = est y acudiente1; 13 = est y acudiente2; 123 = est, acudiente1 y acudiente1; 2 = acudiente1; 3 = acudiente2; 23 = acudiente1 y acudiente2
    //4 = empleados
    //tipo_cel: 5 = est; 6 = acudiente1; 56 = est y acudiente1
    //7 = acudiente1, email acudiente1 y celular acudiente1
    $tipo_correo = $_REQUEST['tipoc']; 
    $grupo = $_REQUEST['grupo'];
    if(!$grupo) {
        $grupo = "NA";
    }
    
    $cadena = "";
    $msg = "";
    
    //https://unicab.org/registro/docenteunicab/updreg/correos.php?idgra=8&tipoc=1&grupo=C
    if($tipo_correo == 1) {
        $msg = "Listado correos estudiantes";
        $sql="SELECT email_institucional correos FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    else if($tipo_correo == 2) {
        $msg = "Listado correos acudientes 1";
        $sql="SELECT email_acudiente_1 correos FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    else if($tipo_correo == 3) {
        $msg = "Listado correos acudientes 2";
        $sql="SELECT email_acudiente_2 correos FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    else if($tipo_correo == 12) {
        $msg = "Listado correos estudiantes y acudientes 1";
        if($grupo != "NA") {
            $sql="SELECT email_institucional correos FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo' 
            UNION ALL 
            SELECT email_acudiente_1 FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo'";
        }
        else {
            $sql="SELECT email_institucional correos FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') 
            UNION ALL 
            SELECT email_acudiente_1 FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        }
    }
    else if($tipo_correo == 13) {
        $msg = "Listado correos estudiantes y acudientes 2";
        if($grupo != "NA") {
            $sql="SELECT email_institucional correos FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo' 
            UNION ALL 
            SELECT email_acudiente_2 FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo'";
        }
        else {
            $sql="SELECT email_institucional correos FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') 
            UNION ALL 
            SELECT email_acudiente_2 FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        }
    }
    else if($tipo_correo == 23) {
        $msg = "Listado correos acudientes 1 y acudientes 2";
        if($grupo != "NA") {
            $sql="SELECT email_acudiente_1 correos FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo' 
            UNION ALL 
            SELECT email_acudiente_2 FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo'";
        }
        else {
            $sql="SELECT email_acudiente_1 correos FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') 
            UNION ALL 
            SELECT email_acudiente_2 FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        }
    }
    else if($tipo_correo == 123) {
        $msg = "Listado correos estudiantes, acudientes 1 y acudientes 2";
        if($grupo != "NA") {
            $sql="SELECT email_institucional correos FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo' 
            UNION ALL 
            SELECT email_acudiente_1 FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo' 
            UNION ALL 
            SELECT email_acudiente_2 FROM estudiantes e, matricula m 
            WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') AND m.grupo = '$grupo'";
        }
        else {
            $sql="SELECT email_institucional correos FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') 
            UNION ALL 
            SELECT email_acudiente_1 FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado') 
            UNION ALL 
            SELECT email_acudiente_2 FROM estudiantes e, matricula m WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        }
    }
    else if($tipo_correo == 4) {
        $msg = "Listado correos empleados";
        $sql="SELECT email correos FROM tbl_empleados";
    }
    else if($tipo_correo == 5) {
        $msg = "Listado teléfonos estudiantes";
        $sql="SELECT nombres, apellidos, telefono_estudiante FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    else if($tipo_correo == 6) {
        $msg = "Listado teléfonos acudientes";
        $sql="SELECT acudiente_1, telefono_acudiente_1 FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    else if($tipo_correo == 56) {
        $msg = "Listado teléfonos estudiantes y acudientes";
        $sql="SELECT nombres, apellidos, telefono_estudiante, acudiente_1, telefono_acudiente_1 FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    else if($tipo_correo == 7) {
        $msg = "Listado correso y teléfonos acudientes";
        $sql="SELECT acudiente_1, email_acudiente_1, telefono_acudiente_1 FROM estudiantes e, matricula m 
        WHERE e.id = m.id_estudiante AND m.id_grado = $id_grado AND m.estado IN ('activo', 'aprobado')";
        if($grupo != "NA") {
            $sql = $sql." AND m.grupo = '$grupo'";
        }
    }
    
    echo $sql;
    
    $resultado=$mysqli1->query($sql);
    $sel = $mysqli1->affected_rows;
    //echo $sel;
    while($row = $resultado->fetch_assoc()){
        //echo $row['correos'];
        if($tipo_correo < 5) {
            $cadena = $cadena.$row['correos']."; ";
        }
        else if($tipo_correo == 5) {
            $cadena = $cadena.$row['nombres']." ".$row['apellidos']."; ".$row['telefono_estudiante']."<br>";
        }
        else if($tipo_correo == 6) {
            $cadena = $cadena.$row['acudiente_1']."; ".$row['telefono_acudiente_1']."<br>";
        }
        else if($tipo_correo == 56) {
            $cadena = $cadena.$row['nombres']." ".$row['apellidos']."; ".$row['telefono_estudiante']." Acud: ".$row['acudiente_1']."; ".$row['telefono_acudiente_1']."<br>";
        }
        else if($tipo_correo == 7) {
            $cadena = $cadena.$row['acudiente_1']."; ".$row['email_acudiente_1']."; ".$row['telefono_acudiente_1']."<br>";
        }
        //echo $cadena;
    }
    $cadena = substr($cadena, 0, strlen($cadena)-2);
    
    echo "<br>".$msg;
    echo "<br/>".$cadena;

?>