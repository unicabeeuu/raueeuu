 <html> 
 <head>
 <META HTTP-EQUIV="Refresh" CONTENT="0; URL=../lista-matricula.php">
 <meta http-equiv="content-type" content="text/html" />
 <meta charset="UTF-8">
 </head>

 </html>
<?php

    include "conexion.php";
    
    $n_matricula = $_REQUEST['n_matricula'];
    $id_matricula = $_REQUEST['id_matricula'];
    $fecha_ingreso = $_REQUEST['fecha_ingreso'];
    $estado = $_REQUEST['est_actual'];
    $nuevo_estado = $_REQUEST['sel_estado'];
    $id_estudiante = $_REQUEST['id_estudiante'];
    $id_grado = $_REQUEST['id_grado'];
    $email_est = $_REQUEST['email_est'];
    //echo $estado;
    //echo "<br/>".$nuevo_estado;
    
    //$id_gradoActual=$_REQUEST['grado_actual'];
    
    /*$sql_buscar="SELECT * FROM `notas` WHERE `id_estudiante`=".$id_estudiante." and `id_grado`=".$id_gradoActual."";
    // echo $sql_buscar;
    $exe_buscar=mysqli_query($conexion,$sql_buscar);
    $total_row=mysqli_num_rows($exe_buscar);
    
    if ($total_row>0) {
    	$sql_eliminar="DELETE FROM `notas` WHERE `id_estudiante`=".$id_estudiante."";
    	$exe_eliminar=mysqli_query($conexion,$sql_eliminar);
    
    	$sql="UPDATE `matricula` SET `n_matricula`='".$n_matricula."',`fecha_ingreso`='".$fecha_ingreso."',`estado`='".$estado."',`id_grado`=".$id_grado." WHERE id_estudiante=".$id_estudiante;
    	$exe=mysqli_query($conexion,$sql);	
    }else{
    	$sql="UPDATE `matricula` SET `n_matricula`='".$n_matricula."',`fecha_ingreso`='".$fecha_ingreso."',`estado`='".$estado."',`id_grado`=".$id_grado." WHERE id_estudiante=".$id_estudiante;
    	$exe=mysqli_query($conexion,$sql);	
    }*/
    if($estado == $nuevo_estado) {
        $sql="UPDATE `matricula` SET `fecha_ingreso` = '".$fecha_ingreso
            ."' WHERE id_estudiante = ".$id_estudiante." AND n_matricula = '".$n_matricula."' AND idMatricula = ".$id_matricula;
        $exe=mysqli_query($conexion,$sql);
    }
    else {
        if($nuevo_estado != "NA") {
            $sql="UPDATE `matricula` SET `fecha_ingreso` = '".$fecha_ingreso."', `estado` = '".$nuevo_estado
                ."' WHERE id_estudiante = ".$id_estudiante." AND n_matricula = '".$n_matricula."' AND idMatricula = ".$id_matricula;
            $exe=mysqli_query($conexion,$sql);
        }
    }
    //echo "<br/>".$sql;
    $sql1="UPDATE `estudiantes` SET `email_institucional` = '".$email_est."' WHERE id = ".$id_estudiante;
    $exe1=mysqli_query($conexion,$sql1);
    	
    // 	//MENSAJE DE ENVIO
    echo"<script>alert('Los datos se han actualizado')</script>";
?>