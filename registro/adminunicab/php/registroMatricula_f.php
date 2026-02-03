 <html>
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../index.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

    include "conexion.php";
    $n_matricula=$_POST['n_matricula'];
    $fecha_ingreso=$_POST['fecha_ingreso'];
    $estado="activo";
    $id_estudiante=$_POST['id'];
    $id_grado=$_POST['id_grado'];
    $email=$_POST['email'];
    $grupo=$_POST['grupo'];
    $documento = $_REQUEST['dentif'];
    
    /*$sql='INSERT INTO `matricula`(`n_matricula`, `fecha_ingreso`, `estado`, `id_estudiante`, `id_grado`) 
    VALUES ("'.$n_matricula.'","'.$fecha_ingreso.'","'.$estado.'",'.$id_estudiante.','.$id_grado.')';*/
    $sql="UPDATE matricula SET fecha_ingreso = '$fecha_ingreso', estado = '$estado', grupo = '$grupo' 
    WHERE id_estudiante = $id_estudiante AND n_matricula = '$n_matricula' AND id_grado = $id_grado";
    $rec = mysqli_query($conexion, $sql);
    
    $sql1="UPDATE estudiantes SET email_institucional ='$email' where id = ".$id_estudiante;
    $rec1=mysqli_query($conexion,$sql1);
    
    $sql2 = "INSERT INTO tbl_temp (c1, v1) VALUES ('$documento', $id_grado)";
    $rec2 = mysqli_query($conexion,$sql2);
    
    // MENSAJE DE ENVIO
    //echo"<script>alert('La matricula está siendo almacendao')</script>";
    echo"<script>alert('La matricula se generó con éxito.')</script>";
?>